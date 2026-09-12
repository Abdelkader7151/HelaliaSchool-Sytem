// HLS — shared shell loader
// Inserts sidebar + topbar into pages and highlights the active link.
// Usage: <body data-page="employees"> ... include this script.

(function () {
  const PAGES = [
    { id: 'dashboard',   icon: 'fa-gauge-high',        label: 'Dashboard',          href: 'dashboard.html',          group: 'Overview' },
    { id: 'workflow',    icon: 'fa-diagram-project',   label: 'Payroll workflow',   href: 'payroll-approval.html',   group: 'Overview' },

    { id: 'employees',   icon: 'fa-users',             label: 'Employees',          href: 'employees.html',          group: 'HR', count: 30 },
    { id: 'attendance',  icon: 'fa-clock',             label: 'Attendance',         href: 'attendance.html',         group: 'HR' },
    { id: 'leaves',      icon: 'fa-calendar-day',      label: 'Leaves',             href: 'leaves.html',             group: 'HR', count: 4 },
    { id: 'org-tree',    icon: 'fa-sitemap',           label: 'Org chart',          href: 'org-tree.html',           group: 'HR' },
    { id: 'hr-excuses',  icon: 'fa-clock-rotate-left', label: 'Excuses',            href: 'excuses.html',            group: 'HR' },
    { id: 'overtime',    icon: 'fa-stopwatch',         label: 'Overtime',           href: 'overtime.html',           group: 'HR' },
    { id: 'deductions',  icon: 'fa-circle-minus',      label: 'Deductions',         href: 'deductions.html',         group: 'HR' },

    { id: 'pay-engine',  icon: 'fa-calculator',        label: 'Payroll engine',     href: 'payroll-officer.html',    group: 'Payroll' },
    { id: 'pay-approve', icon: 'fa-user-check',        label: 'Approve payroll',    href: 'payroll-hr-manager.html', group: 'Payroll' },
    { id: 'pay-history', icon: 'fa-money-bill-wave',   label: 'Payroll history',    href: 'payroll.html',            group: 'Payroll' },

    { id: 'acct-post',   icon: 'fa-right-left',        label: 'Post to accounting', href: 'payroll-posting.html',    group: 'Accounting' },
    { id: 'acct-review', icon: 'fa-building-columns',  label: 'Accounting review',  href: 'payroll-finance.html',    group: 'Accounting' },
    { id: 'acct-pay',    icon: 'fa-money-check-dollar',label: 'Payment & settlement',href: 'payroll-payment.html',   group: 'Accounting' },
    { id: 'acct-ledger', icon: 'fa-book',              label: 'General accounting', href: 'accounting-ledger.html',  group: 'Accounting' },
    { id: 'acct-treasury',icon: 'fa-vault',            label: 'Treasury (safe)',    href: 'accounting-treasury.html',group: 'Accounting' },
    { id: 'acct-bank',   icon: 'fa-landmark',          label: 'Bank',               href: 'accounting-bank.html',    group: 'Accounting' },
    { id: 'student-fees',icon: 'fa-file-invoice-dollar',label: 'Student fees',      href: 'student-fees.html',       group: 'Accounting' },
    { id: 'bus-fees',    icon: 'fa-bus',               label: 'Bus fees',           href: 'bus-fees.html',           group: 'Accounting' },

    { id: 'buses',       icon: 'fa-bus',               label: 'Buses & routes',     href: 'buses.html',              group: 'Transport', count: 3 },

    { id: 'students',    icon: 'fa-children',          label: 'Students',           href: 'students.html',           group: 'Student Affairs', count: 14 },
    { id: 'classes',     icon: 'fa-chalkboard',        label: 'Classes',            href: 'classes.html',            group: 'Student Affairs' },
    { id: 'subjects',    icon: 'fa-book-open',         label: 'Subjects',           href: 'subjects.html',           group: 'Student Affairs' },
    { id: 'second-language',icon: 'fa-language',       label: 'Second language',    href: 'second-language.html',    group: 'Student Affairs' },
    { id: 'student-vacations',icon: 'fa-plane-departure',label: 'Vacations',         href: 'student-vacations.html',  group: 'Student Affairs' },
    { id: 'student-reports',icon: 'fa-chart-pie',      label: 'Reports',            href: 'student-reports.html',    group: 'Student Affairs' },
    { id: 'student-search',icon: 'fa-magnifying-glass',label: 'Search & report',    href: 'student-search.html',     group: 'Student Affairs' },

    { id: 'mobile-accounts',icon: 'fa-mobile-screen',  label: 'Student accounts',   href: 'mobile-accounts.html', group: 'Mobile App' },
    { id: 'mobile-parents', icon: 'fa-people-roof',    label: 'Parent accounts',    href: 'mobile-parents.html',  group: 'Mobile App' },
    { id: 'mobile-employees',icon: 'fa-user-tie',      label: 'Employee accounts',  href: 'mobile-employees.html', group: 'Mobile App' },
    { id: 'mobile-notify',  icon: 'fa-bell',            label: 'Send notification',  href: 'mobile-notify.html',    group: 'Mobile App' },

    { id: 'clinic',      icon: 'fa-stethoscope',       label: 'Clinic visits',      href: 'clinic.html',             group: 'Clinic' },
    { id: 'clinic-students',icon: 'fa-notes-medical',  label: 'Medical records',    href: 'clinic-students.html',    group: 'Clinic' },

    { id: 'inv-supplies', icon: 'fa-boxes-stacked',    label: 'Supplies',           href: 'inventory-supplies.html',    group: 'Inventory' },
    { id: 'inv-equipment',icon: 'fa-display',          label: 'Equipment',          href: 'inventory-equipment.html',   group: 'Inventory' },
    { id: 'inv-maint',    icon: 'fa-screwdriver-wrench',label: 'Maintenance',       href: 'inventory-maintenance.html', group: 'Inventory' },
    { id: 'inv-issues',   icon: 'fa-dolly',             label: 'Stock issues',       href: 'inventory-issues.html',      group: 'Inventory' },
    { id: 'inv-receipts', icon: 'fa-truck-ramp-box',    label: 'Goods receipts',     href: 'inventory-receipts.html',    group: 'Inventory' },

    { id: 'departments', icon: 'fa-sitemap',           label: 'Departments',        href: 'departments.html',        group: 'Admin', count: 3 },
    { id: 'users',       icon: 'fa-user-shield',       label: 'Users',              href: 'users.html',              group: 'Admin' },
    { id: 'permissions', icon: 'fa-shield-halved',     label: 'Permissions',        href: 'permissions.html',        group: 'Admin' },
    { id: 'reports',     icon: 'fa-chart-column',      label: 'Reports',            href: 'reports.html',            group: 'Admin' },
    { id: 'settings',    icon: 'fa-gear',              label: 'Settings',           href: 'settings.html',           group: 'Admin' }
  ];

  function buildSidebar(activeId) {
    const canView = grp => (window.LIBERTY.can ? LIBERTY.can('view', grp) : true);
    const grouped = {};
    PAGES.forEach(p => { if (canView(p.group)) (grouped[p.group] = grouped[p.group] || []).push(p); });

    const groupsHtml = Object.entries(grouped).map(([group, items]) => `
      <div class="sidebar-section">${group}</div>
      ${items.map(p => `
        <a href="${p.href}" class="sidebar-link${p.id === activeId ? ' active' : ''}">
          <i class="fa-solid ${p.icon}"></i>
          <span>${p.label}</span>
          ${p.count ? `<span class="badge-count">${p.count}</span>` : ''}
        </a>
      `).join('')}
    `).join('');

    const u = window.LIBERTY.currentUser ? window.LIBERTY.currentUser() : window.LIBERTY.user;
    const roleLabel = { admin: 'Administrator', hr: 'HR', finance: 'Finance', manager: 'Manager', employee: 'Employee' };
    return `
      <aside class="sidebar">
        <div class="sidebar-brand">
          <img src="uploads/logo.png" alt="HLS" class="logo" style="width:40px;height:40px;border-radius:50%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
          <div class="logo-fallback" style="display:none;width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ec4899);color:#fff;font-weight:700;place-items:center;">H</div>
          <div>
            <div class="brand-name">HLS</div>
            <div class="brand-sub">School System</div>
          </div>
        </div>
        <nav class="sidebar-nav">${groupsHtml}</nav>
        <div class="sidebar-footer">
          <div class="user-avatar">${LIBERTY.initials(u.name)}</div>
          <div class="user-info">
            <div class="user-name">${u.name}</div>
            <div class="user-role">${roleLabel[u.role] || u.role}</div>
          </div>
          <a href="login.html" class="logout" title="Sign out"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
      </aside>
    `;
  }

  function buildTopbar(title, sub) {
    return `
      <div class="topbar">
        <div>
          <h1>${title}</h1>
          ${sub ? `<div class="crumb">${sub}</div>` : ''}
        </div>
        <div class="topbar-actions">
          <button class="topbar-icon-btn" title="Notifications">
            <i class="fa-regular fa-bell"></i>
            <span class="dot-notif"></span>
          </button>
          <button class="topbar-icon-btn" title="Help">
            <i class="fa-regular fa-circle-question"></i>
          </button>
        </div>
      </div>
    `;
  }

  // which section does a page belong to? (from PAGES, else body data-section)
  function sectionForPage(pageId) {
    const p = PAGES.find(x => x.id === pageId);
    if (p) return p.group;
    return document.body.getAttribute('data-section') || 'Overview';
  }

  // hide/disable any element tagged data-perm="edit|delete" the current user lacks
  function enforcePerms(section) {
    if (!window.LIBERTY.can) return;
    ['edit', 'delete'].forEach(act => {
      if (!LIBERTY.can(act, section)) {
        document.querySelectorAll(`[data-perm="${act}"]`).forEach(el => { el.style.display = 'none'; });
      }
    });
    if (!LIBERTY.can('edit', section)) document.body.classList.add('perm-readonly');
  }

  // full-page block if the user can't even view this section
  function accessGuard(section) {
    if (!window.LIBERTY.can || LIBERTY.can('view', section)) return false;
    const u = LIBERTY.currentUser();
    document.querySelector('.content-wrap, body').innerHTML = `
      <div style="min-height:80vh;display:grid;place-items:center;padding:40px;">
        <div style="text-align:center;max-width:420px;">
          <div style="width:72px;height:72px;border-radius:20px;background:var(--err-soft,#fee2e2);color:var(--err,#ef4444);display:grid;place-items:center;font-size:30px;margin:0 auto 18px;"><i class="fa-solid fa-lock"></i></div>
          <h2 style="font-size:21px;font-weight:800;margin:0 0 8px;">Access denied</h2>
          <p style="color:#64748b;font-size:14px;margin:0 0 18px;">Your account (<b>${u.name}</b> · ${u.role}) does not have permission to view the <b>${section}</b> section. Ask an administrator to grant access.</p>
          <a href="dashboard.html" class="btn btn-primary"><i class="fa-solid fa-house me-1"></i> Back to dashboard</a>
        </div>
      </div>`;
    return true;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const pageId = body.getAttribute('data-page') || '';
    const title  = body.getAttribute('data-title') || '';
    const sub    = body.getAttribute('data-sub')   || '';
    const section = sectionForPage(pageId);
    window.LIBERTY.__pageSection = section;

    const sidebarMount = document.getElementById('sidebar-mount');
    const topbarMount  = document.getElementById('topbar-mount');

    if (sidebarMount) sidebarMount.outerHTML = buildSidebar(pageId);
    if (topbarMount)  topbarMount.outerHTML  = buildTopbar(title, sub);

    if (accessGuard(section)) return;
    enforcePerms(section);
  });
})();
