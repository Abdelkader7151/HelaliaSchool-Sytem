// Liberty — Roles & Permissions engine
// Sections map to sidebar groups. Each user has a matrix: section -> { view, edit, delete }.
// Stored in localStorage so the admin's changes persist and apply across all pages.
(function () {
  // The controllable sections (match sidebar groups)
  window.LIBERTY.SECTIONS = [
    { key: 'Overview',        icon: 'fa-gauge-high',         desc: 'Dashboard & payroll workflow' },
    { key: 'HR',              icon: 'fa-users',              desc: 'Employees, attendance, leaves, excuses, overtime, deductions' },
    { key: 'Payroll',         icon: 'fa-calculator',         desc: 'Payroll engine, approvals, history' },
    { key: 'Accounting',      icon: 'fa-building-columns',   desc: 'Posting, review, payment, ledger, treasury, bank' },
    { key: 'Transport',       icon: 'fa-bus',                desc: 'Buses, routes & bus fees' },
    { key: 'Student Affairs', icon: 'fa-children',           desc: 'Students, fees, reports, search' },
    { key: 'Mobile App',      icon: 'fa-mobile-screen',      desc: 'Student & parent mobile app accounts' },
    { key: 'Clinic',          icon: 'fa-stethoscope',        desc: 'School clinic — student visits & medical reports' },
    { key: 'Inventory',       icon: 'fa-boxes-stacked',      desc: 'Supplies, equipment & maintenance requests' },
    { key: 'Admin',           icon: 'fa-user-shield',        desc: 'Departments, users, permissions, settings' }
  ];
  const SECTION_KEYS = LIBERTY.SECTIONS.map(s => s.key);
  const ACTIONS = ['view', 'edit', 'delete'];

  // crud helpers
  const crud = (v, e, d) => ({ view: v, edit: e, delete: d });
  const ALL  = crud(true, true, true);
  const VIEW = crud(true, false, false);
  const VE   = crud(true, true, false);
  const NONE = crud(false, false, false);

  // Default matrix per role — used to seed a user the first time
  const ROLE_DEFAULTS = {
    admin: () => Object.fromEntries(SECTION_KEYS.map(k => [k, { ...ALL }])),
    doctor: () => ({
      'Overview': { ...VIEW }, 'HR': { ...NONE }, 'Payroll': { ...NONE },
      'Accounting': { ...NONE }, 'Transport': { ...NONE }, 'Student Affairs': { ...VIEW }, 'Mobile App': { ...NONE },
      'Clinic': { ...ALL }, 'Admin': { ...NONE }
    }),
    hr: () => ({
      'Overview': { ...VIEW }, 'HR': { ...ALL }, 'Payroll': { ...VE },
      'Accounting': { ...VIEW }, 'Transport': { ...VIEW }, 'Student Affairs': { ...VE }, 'Mobile App': { ...VE }, 'Admin': { ...NONE }
    }),
    finance: () => ({
      'Overview': { ...VIEW }, 'HR': { ...VIEW }, 'Payroll': { ...VIEW },
      'Accounting': { ...ALL }, 'Transport': { ...VE }, 'Student Affairs': { ...VIEW }, 'Mobile App': { ...NONE }, 'Admin': { ...NONE }
    }),
    manager: () => ({
      'Overview': { ...VIEW }, 'HR': { ...VE }, 'Payroll': { ...VIEW },
      'Accounting': { ...NONE }, 'Transport': { ...VIEW }, 'Student Affairs': { ...VIEW }, 'Mobile App': { ...NONE }, 'Admin': { ...NONE }
    }),
    employee: () => ({
      'Overview': { ...VIEW }, 'HR': { ...NONE }, 'Payroll': { ...NONE },
      'Accounting': { ...NONE }, 'Transport': { ...NONE }, 'Student Affairs': { ...NONE }, 'Mobile App': { ...NONE }, 'Admin': { ...NONE }
    })
  };
  LIBERTY.roleDefault = role => (ROLE_DEFAULTS[role] || ROLE_DEFAULTS.employee)();

  // ---- storage ----
  const PKEY = 'liberty_perms';        // { userId: matrix }
  const CKEY = 'liberty_current_user'; // userId
  const readPerms = () => { try { return JSON.parse(localStorage.getItem(PKEY)) || {}; } catch (_) { return {}; } };
  const writePerms = p => localStorage.setItem(PKEY, JSON.stringify(p));

  // normalize a matrix so every section/action exists
  function normalize(matrix, role) {
    const base = LIBERTY.roleDefault(role || 'employee');
    const out = {};
    SECTION_KEYS.forEach(k => {
      const src = (matrix && matrix[k]) || base[k] || NONE;
      out[k] = { view: !!src.view, edit: !!src.edit, delete: !!src.delete };
    });
    return out;
  }

  // current acting user (defaults to the admin in the seed list)
  LIBERTY.currentUserId = () => {
    const id = parseInt(localStorage.getItem(CKEY));
    if (id && LIBERTY.users.some(u => u.id === id && u.active)) return id;
    const admin = LIBERTY.users.find(u => u.role === 'admin' && u.active) || LIBERTY.users[0];
    return admin ? admin.id : 1;
  };
  LIBERTY.currentUser = () => LIBERTY.users.find(u => u.id === LIBERTY.currentUserId()) || LIBERTY.users[0];

  // permission matrix for a user (seed from role default on first read)
  LIBERTY.permsFor = userId => {
    const user = LIBERTY.users.find(u => u.id === userId);
    const all = readPerms();
    return normalize(all[userId], user ? user.role : 'employee');
  };
  LIBERTY.savePermsFor = (userId, matrix) => {
    const all = readPerms();
    all[userId] = matrix;
    writePerms(all);
  };
  LIBERTY.resetPermsFor = userId => {
    const all = readPerms();
    delete all[userId];
    writePerms(all);
  };

  // can the CURRENT user do <action> in <section>?
  LIBERTY.can = (action, section) => {
    const u = LIBERTY.currentUser();
    if (!u) return false;
    const m = LIBERTY.permsFor(u.id);
    const sec = section || LIBERTY.__pageSection || 'Overview';
    if (!m[sec]) return false;
    if (action === 'view') return m[sec].view;
    // edit/delete imply you must also be able to view
    return m[sec].view && m[sec][action];
  };

  // ---- manager scoping: who can a user see in the staff list? ----
  // Effective manager name for an employee (respects org-chart overrides)
  const orgOverrides = () => { try { return JSON.parse(localStorage.getItem('liberty_org_overrides')) || {}; } catch (_) { return {}; } };
  LIBERTY.effManagerOf = e => {
    const o = orgOverrides()[e.id];
    return (o && o.manager != null) ? o.manager : e.manager;
  };
  // All subordinates (direct + indirect) of an employee name
  LIBERTY.subordinatesOf = name => {
    const set = new Set();
    (function walk(n) {
      LIBERTY.employees.forEach(e => {
        if (LIBERTY.effManagerOf(e) === n && !set.has(e.name)) { set.add(e.name); walk(e.name); }
      });
    })(name);
    return set;
  };
  // The employee list the CURRENT user is allowed to see.
  // admin / hr / finance => everyone. manager => self + reporting line. employee => self only.
  LIBERTY.visibleEmployees = () => {
    const u = LIBERTY.currentUser();
    if (!u) return LIBERTY.employees;
    // full-access roles, or any user not linked to a staff record, see everyone
    if (['admin', 'hr', 'finance'].includes(u.role) || !u.linked || u.linked === '—') return LIBERTY.employees;
    const team = LIBERTY.subordinatesOf(u.linked);
    team.add(u.linked); // include self
    return LIBERTY.employees.filter(e => team.has(e.name));
  };
  // Is the current user scoped to a subset (i.e. a manager/employee, not full-access)?
  LIBERTY.isScopedToTeam = () => {
    const u = LIBERTY.currentUser();
    return !!u && !['admin', 'hr', 'finance'].includes(u.role) && u.linked && u.linked !== '—';
  };
})();
