// Liberty HR — Payroll → Accounting workflow (6 stages, mirrors the integration diagram)
//   1 HR data (source)         شؤون العاملين      — always ready
//   2 Payroll calculation      حساب المرتبات      — HR Officer
//   3 Payroll approval         اعتماد المرتبات     — HR Manager
//   4 Post to accounting       ترحيل تلقائي        — auto journal entry
//   5 Accounting approval      الحسابات           — Finance Manager
//   6 Payment & settlement     الدفع والتسوية      — Treasury (bank/cash + close period)
// State persists in localStorage so the chain feels real across the separate pages.

(function () {
  const PERIOD = 'May 2026';
  const STORAGE = 'liberty_payroll_v2';

  const STEPS = [
    { stage: 1, key: 'hr',   label: 'HR data',        ar: 'شؤون العاملين',  who: 'HR module',       icon: 'fa-users' },
    { stage: 2, key: 'calc', label: 'Payroll calc',   ar: 'حساب المرتبات',  who: 'HR Officer',      icon: 'fa-calculator' },
    { stage: 3, key: 'hr2',  label: 'Payroll approval',ar: 'اعتماد المرتبات', who: 'HR Manager',     icon: 'fa-user-check' },
    { stage: 4, key: 'post', label: 'Post to accounting', ar: 'ترحيل تلقائي', who: 'System (auto)',  icon: 'fa-right-left' },
    { stage: 5, key: 'acct', label: 'Accounting',     ar: 'الحسابات',       who: 'Finance Manager', icon: 'fa-building-columns' },
    { stage: 6, key: 'pay',  label: 'Payment & close',ar: 'الدفع والتسوية',  who: 'Treasury',        icon: 'fa-money-check-dollar' }
  ];

  const ACTORS = {
    1: { name: 'HR module',       role: 'HR data',         color: 'green' },
    2: { name: 'Mona Adel',       role: 'HR Officer',      color: 'amber' },
    3: { name: 'Marwa Yousry',  role: 'HR Manager',      color: 'purple' },
    4: { name: 'Liberty System',  role: 'Auto-posting',    color: 'pink' },
    5: { name: 'Khaled Sobhy',    role: 'Finance Manager', color: 'blue' },
    6: { name: 'Treasury Desk',   role: 'Payments',        color: 'green' }
  };

  // ---- salary math (matches payroll.html) ----
  function calc(e) {
    const allowance = Math.round(e.salary * 0.15);
    const overtime  = Math.round(e.salary * 0.03);
    const deduction = Math.round(e.salary * 0.12);
    const net       = e.salary + allowance + overtime - deduction;
    return { ...e, allowance, overtime, deduction, gross: e.salary + allowance + overtime, net };
  }
  function rows() { return LIBERTY.employees.map(calc); }
  function totals() {
    const t = rows().reduce((a, r) => {
      a.basic += r.salary; a.allowance += r.allowance; a.overtime += r.overtime;
      a.deduction += r.deduction; a.gross += r.gross; a.net += r.net; a.count++;
      return a;
    }, { basic: 0, allowance: 0, overtime: 0, deduction: 0, gross: 0, net: 0, count: 0 });
    t.insurance = Math.round(t.deduction * 0.5);
    t.tax       = Math.round(t.deduction * 0.4);
    t.other     = t.deduction - t.insurance - t.tax;
    return t;
  }

  // ---- accounting journal entry (auto-generated after approval) ----
  function journal() {
    const t = totals();
    return {
      accrual: {
        title: 'Payroll accrual — قيد استحقاق المرتبات',
        debit: [
          { acct: '5101', name: 'Salaries & wages expense', ar: 'مصاريف رواتب أساسية', amt: t.basic },
          { acct: '5102', name: 'Overtime expense',         ar: 'مصاريف ساعات إضافية', amt: t.overtime },
          { acct: '5103', name: 'Allowances expense',       ar: 'مصاريف بدلات',         amt: t.allowance }
        ],
        credit: [
          { acct: '2201', name: 'Payroll tax payable',       ar: 'ضرائب مرتبات دائنة',   amt: t.tax },
          { acct: '2202', name: 'Social insurance payable',  ar: 'تأمينات اجتماعية دائنة', amt: t.insurance },
          { acct: '2203', name: 'Other deductions payable',  ar: 'خصومات أخرى دائنة',    amt: t.other },
          { acct: '2101', name: 'Employees payable (net)',   ar: 'مستحقات موظفين (صافي)', amt: t.net }
        ]
      },
      payment: {
        title: 'Payment — قيد سداد المرتبات',
        debit:  [{ acct: '2101', name: 'Employees payable (net)', ar: 'مستحقات موظفين', amt: t.net }],
        credit: [{ acct: '1101', name: 'Bank — CIB current a/c',  ar: 'نقدية / بنك',     amt: t.net }]
      },
      totalDebit: t.gross, totalCredit: t.gross, net: t.net
    };
  }

  // ---- bank details (deterministic, demo only) ----
  function account(e) { return '0019' + String(1000000000 + e.id * 100237).slice(-10); }
  function iban(e)    { return 'EG' + String(30 + (e.id * 7) % 69).padStart(2, '0') + '00190000' + account(e); }
  const BANK = 'Commercial International Bank (CIB)';

  // ---- persisted state ----
  function load() {
    try {
      const s = JSON.parse(localStorage.getItem(STORAGE));
      if (s && typeof s.done === 'number') return s;
    } catch (_) {}
    return { done: 1, paid: false, closed: false, log: [] };   // HR data is ready by default
  }
  function save(s) { localStorage.setItem(STORAGE, JSON.stringify(s)); }

  function logEntry(stage, action, warn) {
    const a = ACTORS[stage];
    return { stage, action, by: a.name, role: a.role, at: new Date().toISOString(), warn: !!warn };
  }
  function advance(toStage, action) {              // toStage in 2..5
    const s = load();
    s.done = Math.max(s.done, toStage);
    s.log.unshift(logEntry(toStage, action));
    save(s); return s;
  }
  function markPaid(action) {
    const s = load(); s.paid = true;
    s.log.unshift(logEntry(6, action)); save(s); return s;
  }
  function closePeriod(action) {
    const s = load(); s.closed = true;
    s.log.unshift(logEntry(6, action)); save(s); return s;
  }
  function returnRun(fromStage, reason) {          // any rejection bounces back to calculation
    const s = load();
    s.done = 1; s.paid = false; s.closed = false;
    s.log.unshift(logEntry(fromStage, 'Returned for correction — ' + (reason || 'no reason given'), true));
    save(s); return s;
  }
  function reset() { localStorage.removeItem(STORAGE); }

  // ---- bank transfer file ----
  function bankCsv() {
    const lines = [['Employee Name', 'File No', 'Bank', 'Account Number', 'IBAN', 'Net Salary (EGP)']];
    rows().forEach(r => lines.push([r.name, r.file, BANK, account(r), iban(r), r.net]));
    const t = totals();
    lines.push(['TOTAL', t.count + ' employees', '', '', '', t.net]);
    return lines.map(row => row.map(c => {
      const v = String(c);
      return /[",\n]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v;
    }).join(',')).join('\r\n');
  }
  function downloadBank() {
    const blob = new Blob(['\ufeff' + bankCsv()], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'Liberty-Payroll-' + PERIOD.replace(' ', '') + '-BankTransfer.csv';
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 2000);
  }

  // ---- stepper ----
  function stepperProgress(s) { return s.closed ? 6 : s.done; }   // 6 only when period closed
  function renderStepper(mountId, pageStage) {
    const el = document.getElementById(mountId);
    if (!el) return;
    const s = load();
    const prog = stepperProgress(s);
    el.innerHTML = `
      <div class="flow-steps">
        ${STEPS.map(st => {
          let cls = 'upcoming';
          if (st.stage <= prog) cls = 'done';
          else if (st.stage === prog + 1) cls = 'current';
          const here = st.stage === pageStage ? ' here' : '';
          const icon = cls === 'done' ? 'fa-check' : st.icon;
          return `
            <div class="flow-step ${cls}${here}">
              <div class="fs-node"><i class="fa-solid ${icon}"></i></div>
              <div class="fs-text">
                <div class="fs-label">${st.stage}. ${st.label}</div>
                <div class="fs-who">${st.who}</div>
              </div>
            </div>`;
        }).join('')}
      </div>`;
  }

  function fmtTime(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' }) + ' · ' +
           d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
  }

  // shared salary-sheet <tbody>. mode: 'full' | 'bank'
  function salaryRows(mode) {
    return rows().map(r => {
      if (mode === 'bank') {
        return `
          <tr>
            <td><div class="row-avatar"><div class="av ${r.color}">${LIBERTY.initials(r.name)}</div>
              <div><div class="nm">${r.name}</div><div class="meta">${r.file}</div></div></div></td>
            <td class="muted small">CIB</td>
            <td class="mono small">${account(r)}</td>
            <td class="mono small muted">${iban(r)}</td>
            <td class="num mono fw-bold">${LIBERTY.money(r.net)}</td>
          </tr>`;
      }
      return `
        <tr>
          <td><div class="row-avatar"><div class="av ${r.color}">${LIBERTY.initials(r.name)}</div>
            <div><div class="nm">${r.name}</div><div class="meta">${r.role}</div></div></div></td>
          <td>${r.dept}</td>
          <td class="num mono">${LIBERTY.money(r.salary)}</td>
          <td class="num mono text-success">+${LIBERTY.money(r.allowance)}</td>
          <td class="num mono text-success">+${LIBERTY.money(r.overtime)}</td>
          <td class="num mono text-danger">-${LIBERTY.money(r.deduction)}</td>
          <td class="num mono fw-bold">${LIBERTY.money(r.net)}</td>
        </tr>`;
    }).join('');
  }

  window.PAYROLL = {
    PERIOD, STEPS, ACTORS, BANK,
    calc, rows, totals, journal, account, iban,
    load, save, advance, markPaid, closePeriod, returnRun, reset,
    bankCsv, downloadBank, renderStepper, stepperProgress, fmtTime, salaryRows
  };
})();
