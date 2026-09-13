// Liberty HR — shared sample data + utilities
// Hardcoded so any page can reference window.LIBERTY.*

window.LIBERTY = {
  user: {
    name: 'Marwa Yousry',
    role: 'HR Manager',
    initials: 'MY',
    avatarColor: 'purple'
  },

  departments: [
    { id: 1, code: 'american', name: 'American Section', head: 'Employee 1', staff: 12 },
    { id: 2, code: 'british',  name: 'British Section',  head: 'Employee 3',  staff: 10 },
    { id: 3, code: 'languages',name: 'Languages Dept.',  head: 'Employee 2',     staff: 8  }
  ],

  employees: [
    { id: 1,  name: 'Employee 1',     fp: '1001', file: 'F-001', role: 'Head of Prep & Primary',  dept: 'American',  manager: '—',                start: '2018-09-01', status: 'Permanent', email: 'm.naseem@liberty.edu',     phone: '01001234567', salary: 18500, color: 'purple' },
    { id: 2,  name: 'Employee 2',         fp: '1002', file: 'F-002', role: 'English Coordinator',     dept: 'Languages', manager: 'Employee 1',   start: '2019-08-15', status: 'Permanent', email: 'p.habib@liberty.edu',      phone: '01002345678', salary: 15200, color: 'pink' },
    { id: 3,  name: 'Employee 3',      fp: '1003', file: 'F-003', role: 'Head of British Section', dept: 'British',   manager: '—',                start: '2017-09-01', status: 'Permanent', email: 'm.samir@liberty.edu',      phone: '01003456789', salary: 19000, color: 'blue' },
    { id: 4,  name: 'Employee 4',        fp: '1004', file: 'F-004', role: 'English Teacher',         dept: 'American',  manager: 'Employee 2',       start: '2020-09-01', status: 'Permanent', email: 'y.hassan@liberty.edu',     phone: '01004567890', salary: 11200, color: 'green' },
    { id: 5,  name: 'Employee 5',     fp: '1005', file: 'F-005', role: 'Math Teacher',            dept: 'American',  manager: 'Employee 1',   start: '2019-09-01', status: 'Permanent', email: 'a.elsayed@liberty.edu',    phone: '01005678901', salary: 11800, color: 'amber' },
    { id: 6,  name: 'Employee 6',        fp: '1006', file: 'F-006', role: 'Arabic Teacher',          dept: 'Languages', manager: 'Employee 2',       start: '2021-09-01', status: 'Probation', email: 'n.karim@liberty.edu',      phone: '01006789012', salary: 9800,  color: 'purple' },
    { id: 7,  name: 'Employee 7',         fp: '1007', file: 'F-007', role: 'Science Teacher',         dept: 'British',   manager: 'Employee 3',    start: '2020-09-01', status: 'Permanent', email: 'o.fathy@liberty.edu',      phone: '01007890123', salary: 11500, color: 'blue' },
    { id: 8,  name: 'Employee 8',        fp: '1008', file: 'F-008', role: 'English Teacher',         dept: 'British',   manager: 'Employee 3',    start: '2022-09-01', status: 'Permanent', email: 'm.adel@liberty.edu',       phone: '01008901234', salary: 10500, color: 'pink' },
    { id: 9,  name: 'Employee 9',      fp: '1009', file: 'F-009', role: 'PE Teacher',              dept: 'American',  manager: 'Employee 1',   start: '2021-09-01', status: 'Permanent', email: 'k.mostafa@liberty.edu',    phone: '01009012345', salary: 9200,  color: 'green' },
    { id: 10, name: 'Employee 10',       fp: '1010', file: 'F-010', role: 'Art Teacher',             dept: 'American',  manager: 'Employee 1',   start: '2020-09-01', status: 'Permanent', email: 'l.hossam@liberty.edu',     phone: '01000123456', salary: 9500,  color: 'amber' },
    { id: 11, name: 'Employee 11',     fp: '1011', file: 'F-011', role: 'IT Teacher',              dept: 'British',   manager: 'Employee 3',    start: '2019-09-01', status: 'Permanent', email: 'h.ibrahim@liberty.edu',    phone: '01010234567', salary: 12000, color: 'blue' },
    { id: 12, name: 'Employee 12',        fp: '1012', file: 'F-012', role: 'French Teacher',          dept: 'Languages', manager: 'Employee 2',       start: '2022-09-01', status: 'Probation', email: 's.tarek@liberty.edu',      phone: '01011234567', salary: 9800,  color: 'pink' },
    { id: 13, name: 'Employee 13',      fp: '1013', file: 'F-013', role: 'Social Studies',          dept: 'American',  manager: 'Employee 1',   start: '2018-09-01', status: 'Permanent', email: 't.mahmoud@liberty.edu',    phone: '01012345678', salary: 11600, color: 'amber' },
    { id: 14, name: 'Employee 14',        fp: '1014', file: 'F-014', role: 'KG Teacher',              dept: 'American',  manager: 'Employee 1',   start: '2021-09-01', status: 'Permanent', email: 'r.ashraf@liberty.edu',     phone: '01013456789', salary: 9000,  color: 'purple' },
    { id: 15, name: 'Employee 15',      fp: '1015', file: 'F-015', role: 'Math Teacher',            dept: 'British',   manager: 'Employee 3',    start: '2020-09-01', status: 'Permanent', email: 'y.galal@liberty.edu',      phone: '01014567890', salary: 11800, color: 'green' },
    { id: 16, name: 'Employee 16',          fp: '1016', file: 'F-016', role: 'Music Teacher',           dept: 'Languages', manager: 'Employee 2',       start: '2022-09-01', status: 'Permanent', email: 'd.wael@liberty.edu',       phone: '01015678901', salary: 9300,  color: 'pink' },
    { id: 17, name: 'Employee 17',       fp: '1017', file: 'F-017', role: 'English Teacher',         dept: 'British',   manager: 'Employee 3',    start: '2019-09-01', status: 'Permanent', email: 's.nabil@liberty.edu',      phone: '01016789012', salary: 11000, color: 'blue' },
    { id: 18, name: 'Employee 18',        fp: '1018', file: 'F-018', role: 'Science Teacher',         dept: 'American',  manager: 'Employee 1',   start: '2021-09-01', status: 'Probation', email: 'n.eldin@liberty.edu',      phone: '01017890123', salary: 10200, color: 'amber' },
    { id: 19, name: 'Employee 19',         fp: '1019', file: 'F-019', role: 'Arabic Coordinator',      dept: 'Languages', manager: 'Employee 2',       start: '2018-09-01', status: 'Permanent', email: 'f.adel@liberty.edu',       phone: '01018901234', salary: 13500, color: 'green' },
    { id: 20, name: 'Employee 20',          fp: '1020', file: 'F-020', role: 'PE Teacher',              dept: 'British',   manager: 'Employee 3',    start: '2022-09-01', status: 'Permanent', email: 'a.hany@liberty.edu',       phone: '01019012345', salary: 9100,  color: 'blue' },
    { id: 21, name: 'Employee 21',         fp: '1021', file: 'F-021', role: 'Counselor',               dept: 'American',  manager: 'Employee 1',   start: '2020-09-01', status: 'Permanent', email: 'h.salah@liberty.edu',      phone: '01020123456', salary: 10800, color: 'purple' },
    { id: 22, name: 'Employee 22',       fp: '1022', file: 'F-022', role: 'IT Support',              dept: 'American',  manager: 'Employee 1',   start: '2019-09-01', status: 'Permanent', email: 'k.magdy@liberty.edu',      phone: '01021234567', salary: 9600,  color: 'amber' },
    { id: 23, name: 'Employee 23',         fp: '1023', file: 'F-023', role: 'KG Teacher',              dept: 'British',   manager: 'Employee 3',    start: '2021-09-01', status: 'Permanent', email: 'l.wagih@liberty.edu',      phone: '01022345678', salary: 9000,  color: 'pink' },
    { id: 24, name: 'Employee 24',        fp: '1024', file: 'F-024', role: 'Drama Teacher',           dept: 'Languages', manager: 'Employee 2',       start: '2020-09-01', status: 'Permanent', email: 'h.refaat@liberty.edu',     phone: '01023456789', salary: 9700,  color: 'blue' },
    { id: 25, name: 'Employee 25',        fp: '1025', file: 'F-025', role: 'Librarian',               dept: 'American',  manager: 'Employee 1',   start: '2022-09-01', status: 'Probation', email: 'a.mostafa@liberty.edu',    phone: '01024567890', salary: 8500,  color: 'green' },
    { id: 26, name: 'Employee 26',        fp: '1026', file: 'F-026', role: 'Lab Assistant',           dept: 'British',   manager: 'Employee 3',    start: '2019-09-01', status: 'Permanent', email: 's.tawfik@liberty.edu',     phone: '01025678901', salary: 8800,  color: 'amber' },
    { id: 27, name: 'Employee 27',       fp: '1027', file: 'F-027', role: 'English Teacher',         dept: 'American',  manager: 'Employee 2',       start: '2021-09-01', status: 'Permanent', email: 'm.nasser@liberty.edu',     phone: '01026789012', salary: 10500, color: 'purple' },
    { id: 28, name: 'Employee 28',       fp: '1028', file: 'F-028', role: 'Math Teacher',            dept: 'American',  manager: 'Employee 1',   start: '2018-09-01', status: 'Permanent', email: 'b.magdy@liberty.edu',      phone: '01027890123', salary: 12500, color: 'pink' },
    { id: 29, name: 'Employee 29',         fp: '1029', file: 'F-029', role: 'Spanish Teacher',         dept: 'Languages', manager: 'Employee 2',       start: '2022-09-01', status: 'Probation', email: 'r.fares@liberty.edu',      phone: '01028901234', salary: 9500,  color: 'blue' },
    { id: 30, name: 'Employee 30',       fp: '1030', file: 'F-030', role: 'Bus Coordinator',         dept: 'American',  manager: 'Employee 1',   start: '2020-09-01', status: 'Permanent', email: 'mostafa.adel@liberty.edu', phone: '01029012345', salary: 8200,  color: 'green' }
  ],

  leaves: [
    { id: 1, employee: 'Employee 4',    type: 'Annual',     from: '2026-05-04', to: '2026-05-08', days: 5, reason: 'Family vacation', status: 'pending'  },
    { id: 2, employee: 'Employee 5', type: 'Sick',       from: '2026-04-26', to: '2026-04-27', days: 2, reason: 'Flu',             status: 'approved' },
    { id: 3, employee: 'Employee 6',    type: 'Casual',     from: '2026-04-29', to: '2026-04-29', days: 1, reason: 'Personal',        status: 'pending'  },
    { id: 4, employee: 'Employee 8',    type: 'Annual',     from: '2026-05-12', to: '2026-05-15', days: 4, reason: 'Travel',          status: 'pending'  },
    { id: 5, employee: 'Employee 9',  type: 'Sick',       from: '2026-04-21', to: '2026-04-22', days: 2, reason: 'Doctor visit',    status: 'approved' },
    { id: 6, employee: 'Employee 10',   type: 'Maternity',  from: '2026-06-01', to: '2026-09-01', days: 92,reason: 'Maternity leave', status: 'approved' },
    { id: 7, employee: 'Employee 11', type: 'Casual',     from: '2026-04-15', to: '2026-04-15', days: 1, reason: 'Personal',        status: 'rejected' },
    { id: 8, employee: 'Employee 12',    type: 'Annual',     from: '2026-05-20', to: '2026-05-22', days: 3, reason: 'Family event',    status: 'pending'  },
    { id: 9, employee: 'Employee 14',    type: 'Sick',       from: '2026-04-10', to: '2026-04-11', days: 2, reason: 'Migraine',        status: 'approved' },
    { id: 10,employee: 'Employee 16',      type: 'Casual',     from: '2026-05-02', to: '2026-05-02', days: 1, reason: 'Personal',        status: 'pending'  }
  ],

  attendance: {
    weekStart: '2026-04-26',
    days: ['Sun 26', 'Mon 27', 'Tue 28', 'Wed 29', 'Thu 30', 'Fri 01', 'Sat 02'],
    // status codes: p=present, l=late, a=absent, lv=leave, o=off-day
    rows: [
      { id: 1, name: 'Employee 1',    cells: ['p:08:02','p:07:55','p:07:58','p:08:10','p:07:50','o','o'] },
      { id: 2, name: 'Employee 2',        cells: ['p:07:50','p:07:55','l:08:18','p:07:45','p:07:48','o','o'] },
      { id: 3, name: 'Employee 3',     cells: ['p:07:48','p:07:52','p:08:00','p:07:55','p:07:50','o','o'] },
      { id: 4, name: 'Employee 4',       cells: ['p:08:05','p:08:00','p:07:58','p:08:12','p:07:55','o','o'] },
      { id: 5, name: 'Employee 5',    cells: ['p:07:55','lv','lv','p:08:00','p:07:58','o','o'] },
      { id: 6, name: 'Employee 6',       cells: ['p:08:00','p:07:55','p:08:02','p:07:58','p:08:00','o','o'] },
      { id: 7, name: 'Employee 7',        cells: ['p:07:50','p:07:48','p:07:52','l:08:20','p:07:55','o','o'] },
      { id: 8, name: 'Employee 8',       cells: ['p:07:58','p:07:55','p:08:00','p:07:50','a','o','o'] },
      { id: 9, name: 'Employee 9',     cells: ['p:07:45','p:07:50','p:07:48','p:07:55','p:07:50','o','o'] },
      { id: 10,name: 'Employee 10',      cells: ['p:08:00','p:07:55','l:08:25','p:08:00','p:07:55','o','o'] },
      { id: 11,name: 'Employee 11',    cells: ['p:07:50','p:07:48','p:07:55','p:07:50','p:07:55','o','o'] },
      { id: 12,name: 'Employee 12',       cells: ['p:08:02','p:08:00','p:07:58','p:08:05','p:08:00','o','o'] }
    ]
  },

  payroll: {
    period: 'April 2026',
    runs: [
      { period: 'April 2026',    employees: 30, gross: 327100, net: 285420, status: 'paid'      },
      { period: 'March 2026',    employees: 30, gross: 326800, net: 285200, status: 'paid'      },
      { period: 'February 2026', employees: 29, gross: 318500, net: 277400, status: 'paid'      },
      { period: 'January 2026',  employees: 29, gross: 318500, net: 277400, status: 'paid'      }
    ]
  },

  users: [
    { id: 1, name: 'Marwa Yousry',  username: 'admin',    email: 'admin@liberty.edu',    role: 'admin',    active: true,  linked: '—' },
    { id: 2, name: 'HR Manager',      username: 'hr',       email: 'hr@liberty.edu',       role: 'hr',       active: true,  linked: '—' },
    { id: 3, name: 'Employee 3',   username: 'm.samir',  email: 'm.samir@liberty.edu',  role: 'manager',  active: true,  linked: 'Employee 3' },
    { id: 4, name: 'Employee 2',      username: 'posy',     email: 'p.habib@liberty.edu',  role: 'manager',  active: true,  linked: 'Employee 2' },
    { id: 5, name: 'Employee 30',    username: 'mostafa',  email: 'm.adel@liberty.edu',   role: 'employee', active: true,  linked: 'Employee 30' },
    { id: 7, name: 'Dr. Employee 21',  username: 'doctor',   email: 'clinic@liberty.edu',   role: 'doctor',   active: true,  linked: '—' },
    { id: 6, name: 'Old account',     username: 'oldacct',  email: 'old@liberty.edu',      role: 'employee', active: false, linked: '—' }
  ]
};

// Helpers
window.LIBERTY.initials = (n) => n.split(' ').map(x => x[0]).slice(0, 2).join('').toUpperCase();
window.LIBERTY.money = (n) => 'EGP ' + Number(n).toLocaleString('en-US');

// ---- HR inputs feeding the payroll engine (May 2026) ----
// Overtime — الساعات الإضافية
window.LIBERTY.overtime = [
  { id: 1, employee: 'Employee 4',    dept: 'American',  date: '2026-05-06', hours: 6,  rate: 85, status: 'approved' },
  { id: 2, employee: 'Employee 5', dept: 'American',  date: '2026-05-08', hours: 4,  rate: 90, status: 'approved' },
  { id: 3, employee: 'Employee 7',     dept: 'British',   date: '2026-05-11', hours: 8,  rate: 80, status: 'approved' },
  { id: 4, employee: 'Employee 8',    dept: 'British',   date: '2026-05-13', hours: 3,  rate: 78, status: 'pending'  },
  { id: 5, employee: 'Employee 11', dept: 'British',   date: '2026-05-14', hours: 5,  rate: 92, status: 'approved' },
  { id: 6, employee: 'Employee 28',   dept: 'American',  date: '2026-05-18', hours: 7,  rate: 95, status: 'approved' },
  { id: 7, employee: 'Employee 19',     dept: 'Languages', date: '2026-05-20', hours: 4,  rate: 88, status: 'pending'  },
  { id: 8, employee: 'Employee 15',  dept: 'British',   date: '2026-05-22', hours: 6,  rate: 84, status: 'approved' }
].map(o => ({ ...o, amount: o.hours * o.rate }));

// Deductions & penalties — الخصومات والجزاءات
window.LIBERTY.penalties = [
  { id: 1, employee: 'Employee 6',    dept: 'Languages', type: 'Absence', reason: 'Unexcused day',        qty: '1 day',   amount: 380, status: 'applied'  },
  { id: 2, employee: 'Employee 10',   dept: 'American',  type: 'Late',    reason: 'Late 3× (>20 min)',    qty: '3 times', amount: 150, status: 'applied'  },
  { id: 3, employee: 'Employee 12',    dept: 'Languages', type: 'Penalty', reason: 'Policy violation',     qty: '1',       amount: 500, status: 'pending'  },
  { id: 4, employee: 'Employee 8',    dept: 'British',   type: 'Absence', reason: 'Unexcused day',        qty: '1 day',   amount: 350, status: 'applied'  },
  { id: 5, employee: 'Employee 9',  dept: 'American',  type: 'Loan',    reason: 'Salary advance',       qty: 'install.',amount: 600, status: 'applied'  },
  { id: 6, employee: 'Employee 18',    dept: 'American',  type: 'Late',    reason: 'Late 2× (>15 min)',    qty: '2 times', amount: 90,  status: 'applied'  },
  { id: 7, employee: 'Employee 29',     dept: 'Languages', type: 'Penalty', reason: 'Missed supervision',   qty: '1',       amount: 250, status: 'pending'  },
  { id: 8, employee: 'Employee 25',    dept: 'American',  type: 'Absence', reason: 'Half-day unexcused',   qty: '0.5 day', amount: 175, status: 'applied'  }
];

// Excuses / permissions — الأذونات (submitted by employees: delay / early leave / errand)
window.LIBERTY.excuses = [
  { id: 1, employee: 'Employee 4',    dept: 'American',  type: 'Late',   date: '2026-05-06', from: '08:00', to: '10:00', reason: 'Doctor appointment', status: 'approved' },
  { id: 2, employee: 'Employee 5', dept: 'American',  type: 'Early',  date: '2026-05-09', from: '13:00', to: '14:30', reason: 'Family matter',      status: 'approved' },
  { id: 3, employee: 'Employee 8',    dept: 'British',   type: 'Errand', date: '2026-05-12', from: '11:00', to: '12:30', reason: 'Bank visit',         status: 'pending'  },
  { id: 4, employee: 'Employee 12',    dept: 'Languages', type: 'Late',   date: '2026-05-14', from: '08:00', to: '09:15', reason: 'Traffic',            status: 'approved' },
  { id: 5, employee: 'Employee 7',     dept: 'British',   type: 'Early',  date: '2026-05-18', from: '14:00', to: '15:00', reason: 'Personal errand',    status: 'pending'  }
];

// =====================================================================
// STUDENT AFFAIRS — شئون الطلبة  (fees linked to accounting + sibling discount)
// =====================================================================

// Annual fee plans per stage — خطط المصاريف السنوية
window.LIBERTY.feePlans = {
  'KG':        { tuition: 32000, bus: 6000, activities: 2500 },
  'Primary':   { tuition: 42000, bus: 6500, activities: 3000 },
  'Prep':      { tuition: 48000, bus: 7000, activities: 3500 },
  'Secondary': { tuition: 55000, bus: 7500, activities: 4000 }
};

// Default sibling-discount ladder — applied to TUITION only. Editable & persisted.
// rank 1 = eldest (no discount); 2nd/3rd/4th/5th/6th child get progressively more off.
window.LIBERTY.siblingDiscountDefault = {
  enabled: true,
  rates: { 1: 0, 2: 10, 3: 15, 4: 20, 5: 25, 6: 30 }   // percent off tuition
};
window.LIBERTY.discountKey = 'liberty_sibling_discount';
window.LIBERTY.discountCfg = function () {
  try {
    const saved = JSON.parse(localStorage.getItem(LIBERTY.discountKey));
    if (saved && saved.rates) return saved;
  } catch (_) {}
  return JSON.parse(JSON.stringify(LIBERTY.siblingDiscountDefault));
};
window.LIBERTY.saveDiscountCfg = function (cfg) {
  localStorage.setItem(LIBERTY.discountKey, JSON.stringify(cfg));
};

// Families — الأسر (surname grouping for sibling discount)
window.LIBERTY.families = [
  { id: 'FAM-01', name: 'El Sherbiny', guardian: 'Khaled El Sherbiny', phone: '0100 111 2233' },
  { id: 'FAM-02', name: 'Mansour',     guardian: 'Tarek Mansour',      phone: '0101 222 3344' },
  { id: 'FAM-03', name: 'Abdel Rahman',guardian: 'Hany Abdel Rahman',  phone: '0102 333 4455' },
  { id: 'FAM-04', name: 'Saleh',       guardian: 'Omar Saleh',         phone: '0103 444 5566' },
  { id: 'FAM-05', name: 'Fahmy',       guardian: 'Sherif Fahmy',       phone: '0106 555 6677' }
];

// Buses — الأتوبيسات (each with a route, driver, supervisor, capacity, annual fee)
window.LIBERTY.buses = [
  { id: 'BUS-01', label: 'Bus 1', plate: 'أ ب ج 1234', capacity: 28, fee: 6500,
    driver: 'Sayed Abdullah', driverPhone: '0100 100 1001', supervisor: 'Mona Adel',
    route: 'Smouha · Sidi Gaber · Cleopatra', stops: ['Smouha', 'Sidi Gaber', 'Cleopatra', 'School'] },
  { id: 'BUS-02', label: 'Bus 2', plate: 'د هـ و 5678', capacity: 24, fee: 7000,
    driver: 'Ramadan Fawzy', driverPhone: '0100 200 2002', supervisor: 'Heba Sami',
    route: 'Miami · Mandara · Montaza', stops: ['Miami', 'Mandara', 'Montaza', 'School'] },
  { id: 'BUS-03', label: 'Bus 3', plate: 'ز ح ط 9012', capacity: 30, fee: 6000,
    driver: 'Galal Nabil', driverPhone: '0100 300 3003', supervisor: 'Sara Adel',
    route: 'Stanley · Gleem · Roushdy', stops: ['Stanley', 'Gleem', 'Roushdy', 'School'] }
];

// Students — الطلبة (full record). arrival: 'Bus' | 'Car'. busId set only when arrival = Bus.
// guardian = الولاية التعليمية (who holds educational custody). paid = tuition paid, busPaid = bus fee paid.
window.LIBERTY.students = [
  // El Sherbiny — Smouha — 6 children (full sibling-discount ladder)
  { id: 'STD-0001', name: 'Student 01',   nameAr: 'الطالب 01',   familyId: 'FAM-01', stage: 'Secondary', grade: 'Grade 10', section: 'American',  dob: '2010-03-12', gender: 'Female', nationality: 'Egyptian', govId: '21003120100123', eduId: 'EDU-0001', secondLanguage: 'SL-01', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Bus', busId: 'BUS-01', paid: 40000, busPaid: 6500 },
  { id: 'STD-0002', name: 'Student 02', nameAr: 'الطالب 02',  familyId: 'FAM-01', stage: 'Prep',      grade: 'Grade 8',  section: 'American',  dob: '2012-07-05', gender: 'Male', nationality: 'Egyptian', govId: '21203070100456', eduId: 'EDU-0002', secondLanguage: 'SL-01', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: 'Asthma — keeps an inhaler', guardian: 'Father',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Bus', busId: 'BUS-01', paid: 30000, busPaid: 6500 },
  { id: 'STD-0003', name: 'Student 03',  nameAr: 'الطالب 03',   familyId: 'FAM-01', stage: 'Primary',   grade: 'Grade 5',  section: 'American',  dob: '2015-01-22', gender: 'Female', nationality: 'Egyptian', govId: '21501220100789', eduId: 'EDU-0003', secondLanguage: 'SL-02', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Bus', busId: 'BUS-01', paid: 25000, busPaid: 3000 },
  { id: 'STD-0004', name: 'Student 04',   nameAr: 'الطالب 04',    familyId: 'FAM-01', stage: 'Primary',   grade: 'Grade 3',  section: 'American',  dob: '2017-09-30', gender: 'Male', nationality: 'Egyptian', govId: '21709300101012', eduId: 'EDU-0004', secondLanguage: 'SL-02', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Car', busId: null, paid: 18000, busPaid: 0 },
  { id: 'STD-0005', name: 'Student 05',   nameAr: 'الطالب 05',    familyId: 'FAM-01', stage: 'KG',        grade: 'KG2',      section: 'American',  dob: '2020-04-18', gender: 'Female', nationality: 'Egyptian', govId: '22004180101345', eduId: 'EDU-0005', secondLanguage: '', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: 'Peanut allergy', guardian: 'Mother',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Car', busId: null, paid: 12000, busPaid: 0 },
  { id: 'STD-0006', name: 'Student 06',  nameAr: 'الطالب 06',   familyId: 'FAM-01', stage: 'KG',        grade: 'KG1',      section: 'American',  dob: '2021-11-02', gender: 'Female', nationality: 'Egyptian', govId: '22111020101678', eduId: 'EDU-0006', secondLanguage: '', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Smouha, Alexandria', medical: '', guardian: 'Mother',
    father: { name: 'Khaled El Sherbiny', phone: '0100 111 2233' }, mother: { name: 'Rania Fouad', phone: '0100 111 9988' },
    arrival: 'Car', busId: null, paid: 8000, busPaid: 0 },
  // Mansour — Miami — 2 children
  { id: 'STD-0007', name: 'Student 07',      nameAr: 'الطالب 07',     familyId: 'FAM-02', stage: 'Prep',      grade: 'Grade 7',  section: 'British',   dob: '2013-02-14', gender: 'Male', nationality: 'Egyptian', govId: '21302140102345', eduId: 'EDU-0007', secondLanguage: 'SL-03', transferredFrom: 'Al Nasr Language School', transferEduAdmin: 'Montaza Educational Directorate', transferReason: 'Family relocation',
    address: 'Miami, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Tarek Mansour', phone: '0101 222 3344' }, mother: { name: 'Dina Salah', phone: '0101 222 7766' },
    arrival: 'Bus', busId: 'BUS-02', paid: 28000, busPaid: 7000 },
  { id: 'STD-0008', name: 'Student 08',       nameAr: 'الطالب 08',      familyId: 'FAM-02', stage: 'Primary',   grade: 'Grade 4',  section: 'British',   dob: '2016-06-09', gender: 'Female', nationality: 'Egyptian', govId: '21606090102678', eduId: 'EDU-0008', secondLanguage: 'SL-03', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Miami, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Tarek Mansour', phone: '0101 222 3344' }, mother: { name: 'Dina Salah', phone: '0101 222 7766' },
    arrival: 'Bus', busId: 'BUS-02', paid: 20000, busPaid: 3500 },
  // Abdel Rahman — Stanley — 3 children
  { id: 'STD-0009', name: 'Student 09', nameAr: 'الطالب 09', familyId: 'FAM-03', stage: 'Secondary', grade: 'Grade 11', section: 'Languages', dob: '2009-08-21', gender: 'Female', nationality: 'Egyptian', govId: '20908210103123', eduId: 'EDU-0009', secondLanguage: 'SL-01', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Stanley, Alexandria', medical: 'Type 1 diabetes', guardian: 'Both parents',
    father: { name: 'Hany Abdel Rahman', phone: '0102 333 4455' }, mother: { name: 'Mona Adel', phone: '0102 333 8899' },
    arrival: 'Bus', busId: 'BUS-03', paid: 35000, busPaid: 6000 },
  { id: 'STD-0010', name: 'Student 10', nameAr: 'الطالب 10', familyId: 'FAM-03', stage: 'Prep',      grade: 'Grade 9',  section: 'Languages', dob: '2011-12-03', gender: 'Male', nationality: 'Egyptian', govId: '21112030103456', eduId: 'EDU-0010', secondLanguage: 'SL-01', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Stanley, Alexandria', medical: '', guardian: 'Both parents',
    father: { name: 'Hany Abdel Rahman', phone: '0102 333 4455' }, mother: { name: 'Mona Adel', phone: '0102 333 8899' },
    arrival: 'Car', busId: null, paid: 22000, busPaid: 0 },
  { id: 'STD-0011', name: 'Student 11',  nameAr: 'الطالب 11',  familyId: 'FAM-03', stage: 'Primary',   grade: 'Grade 6',  section: 'Languages', dob: '2014-05-17', gender: 'Female', nationality: 'Egyptian', govId: '21405170103789', eduId: 'EDU-0011', secondLanguage: '', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Stanley, Alexandria', medical: '', guardian: 'Both parents',
    father: { name: 'Hany Abdel Rahman', phone: '0102 333 4455' }, mother: { name: 'Mona Adel', phone: '0102 333 8899' },
    arrival: 'Bus', busId: 'BUS-03', paid: 18000, busPaid: 3000 },
  // Saleh — Cleopatra — 1 child
  { id: 'STD-0012', name: 'Student 12',     nameAr: 'الطالب 12',       familyId: 'FAM-04', stage: 'Primary',   grade: 'Grade 2',  section: 'American',  dob: '2018-10-25', gender: 'Male', nationality: 'Egyptian', govId: '21810250104012', eduId: 'EDU-0012', secondLanguage: '', transferredFrom: 'Victory College', transferEduAdmin: 'East Alexandria Directorate', transferReason: 'Closer to new home',
    address: 'Cleopatra, Alexandria', medical: '', guardian: 'Father',
    father: { name: 'Omar Saleh', phone: '0103 444 5566' }, mother: { name: 'Yasmin Tag', phone: '0103 444 1122' },
    arrival: 'Bus', busId: 'BUS-01', paid: 24000, busPaid: 6500 },
  // Fahmy — Mandara — 2 children
  { id: 'STD-0013', name: 'Student 13',         nameAr: 'الطالب 13',      familyId: 'FAM-05', stage: 'Prep',      grade: 'Grade 8',  section: 'British',   dob: '2012-03-08', gender: 'Female', nationality: 'Egyptian', govId: '21203080104345', eduId: 'EDU-0013', secondLanguage: 'SL-04', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Mandara, Alexandria', medical: '', guardian: 'Mother',
    father: { name: 'Sherif Fahmy', phone: '0106 555 6677' }, mother: { name: 'Heba Sami', phone: '0106 555 2211' },
    arrival: 'Car', busId: null, paid: 26000, busPaid: 0 },
  { id: 'STD-0014', name: 'Student 14',         nameAr: 'الطالب 14',       familyId: 'FAM-05', stage: 'KG',        grade: 'KG2',      section: 'British',   dob: '2020-01-19', gender: 'Male', nationality: 'Egyptian', govId: '22001190104678', eduId: 'EDU-0014', secondLanguage: 'SL-04', transferredFrom: '', transferEduAdmin: '', transferReason: '',
    address: 'Mandara, Alexandria', medical: '', guardian: 'Mother',
    father: { name: 'Sherif Fahmy', phone: '0106 555 6677' }, mother: { name: 'Heba Sami', phone: '0106 555 2211' },
    arrival: 'Bus', busId: 'BUS-02', paid: 14000, busPaid: 3500 }
];

// Active roster (uses the shared CRUD store when present, else the seed)
window.LIBERTY.roster = () => (window.STORE && STORE.students) ? STORE.students() : LIBERTY.students;
window.LIBERTY.busList = () => (window.STORE && STORE.buses) ? STORE.buses() : LIBERTY.buses;
window.LIBERTY.busById = (id) => LIBERTY.busList().find(b => b.id === id) || null;

// Grades available per stage — used to make the grade selector stage-aware
window.LIBERTY.gradesByStage = {
  KG: ['KG1', 'KG2'],
  Primary: ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
  Prep: ['Grade 7', 'Grade 8', 'Grade 9'],
  Secondary: ['Grade 10', 'Grade 11', 'Grade 12']
};

// Second languages — اللغة الثانية (managed under Student Affairs > Second language)
window.LIBERTY.secondLanguages = [
  { id: 'SL-01', name: 'French',  nameAr: 'الفرنسية' },
  { id: 'SL-02', name: 'German',  nameAr: 'الألمانية' },
  { id: 'SL-03', name: 'Spanish', nameAr: 'الإسبانية' },
  { id: 'SL-04', name: 'Italian', nameAr: 'الإيطالية' }
];

// Age of a student on October 1st of the current academic year
window.LIBERTY.ageAtOct1 = function (dob, octYear) {
  if (!dob) return null;
  octYear = octYear || 2026;
  const oct1 = new Date(octYear, 9, 1);
  const birth = new Date(dob);
  let age = oct1.getFullYear() - birth.getFullYear();
  const m = oct1.getMonth() - birth.getMonth();
  if (m < 0 || (m === 0 && oct1.getDate() < birth.getDate())) age--;
  return age;
};

// Classes — الفصول (each student may be assigned to one class via student.classId)
window.LIBERTY.classes = [
  { id: 'CLS-01', name: 'KG1 - A',       stage: 'KG',        section: 'American',  teacher: 'Employee 14', capacity: 20 },
  { id: 'CLS-02', name: 'KG2 - A',       stage: 'KG',        section: 'American',  teacher: 'Employee 14', capacity: 20 },
  { id: 'CLS-03', name: 'Grade 2 - A',   stage: 'Primary',   section: 'American',  teacher: 'Employee 10', capacity: 25 },
  { id: 'CLS-04', name: 'Grade 3 - A',   stage: 'Primary',   section: 'American',  teacher: 'Employee 13', capacity: 25 },
  { id: 'CLS-05', name: 'Grade 4 - A',   stage: 'Primary',   section: 'British',   teacher: 'Employee 15', capacity: 25 },
  { id: 'CLS-06', name: 'Grade 5 - A',   stage: 'Primary',   section: 'American',  teacher: 'Employee 5',  capacity: 25 },
  { id: 'CLS-07', name: 'Grade 6 - A',   stage: 'Primary',   section: 'Languages', teacher: 'Employee 6',  capacity: 25 },
  { id: 'CLS-08', name: 'Grade 7 - A',   stage: 'Prep',      section: 'British',   teacher: 'Employee 7',  capacity: 28 },
  { id: 'CLS-09', name: 'Grade 8 - A',   stage: 'Prep',      section: 'British',   teacher: 'Employee 17', capacity: 28 },
  { id: 'CLS-10', name: 'Grade 9 - A',   stage: 'Prep',      section: 'Languages', teacher: 'Employee 12', capacity: 28 },
  { id: 'CLS-11', name: 'Grade 10 - A',  stage: 'Secondary', section: 'American',  teacher: 'Employee 13', capacity: 30 },
  { id: 'CLS-12', name: 'Grade 11 - A',  stage: 'Secondary', section: 'Languages', teacher: 'Employee 2',  capacity: 30 }
];
// classId assignment for the seed students (id -> class), keyed by student id
window.LIBERTY.studentClassSeed = {
  'STD-0001': 'CLS-11', 'STD-0002': 'CLS-09', 'STD-0003': 'CLS-06', 'STD-0004': 'CLS-04',
  'STD-0005': 'CLS-02', 'STD-0006': 'CLS-01', 'STD-0007': 'CLS-08', 'STD-0008': 'CLS-05',
  'STD-0009': 'CLS-12', 'STD-0010': 'CLS-10', 'STD-0011': 'CLS-07', 'STD-0012': 'CLS-03',
  'STD-0013': 'CLS-09', 'STD-0014': 'CLS-02'
};
LIBERTY.students.forEach(s => { s.classId = LIBERTY.studentClassSeed[s.id] || null; });

// Vacations / leave history — إجازات الطالب
window.LIBERTY.studentVacations = [
  { id: 'SVAC-01', studentId: 'STD-0001', from: '2026-02-08', to: '2026-02-12', days: 5, reason: 'Family travel', status: 'approved' },
  { id: 'SVAC-02', studentId: 'STD-0002', from: '2025-11-20', to: '2025-11-21', days: 2, reason: 'Medical (flu)', status: 'approved' },
  { id: 'SVAC-03', studentId: 'STD-0009', from: '2026-01-15', to: '2026-01-15', days: 1, reason: 'Doctor appointment', status: 'approved' },
  { id: 'SVAC-04', studentId: 'STD-0004', from: '2026-04-05', to: '2026-04-09', days: 5, reason: 'Family trip abroad', status: 'pending' },
  { id: 'SVAC-05', studentId: 'STD-0012', from: '2026-04-14', to: '2026-04-14', days: 1, reason: 'Family occasion', status: 'pending' },
  { id: 'SVAC-06', studentId: 'STD-0007', from: '2026-03-02', to: '2026-03-03', days: 2, reason: 'Personal', status: 'rejected' }
];

// Certificate / achievement history — شهادات وتكريمات
window.LIBERTY.studentCertificates = [
  { studentId: 'STD-0001', title: 'Honor Roll — Term 1', date: '2025-12-20', issuedBy: 'Employee 1' },
  { studentId: 'STD-0002', title: 'Science Fair — 2nd place', date: '2026-03-10', issuedBy: 'Employee 18' },
  { studentId: 'STD-0009', title: 'Perfect Attendance', date: '2026-01-30', issuedBy: 'Employee 3' }
];

// Detentions / disciplinary record — جزاءات وحجز
window.LIBERTY.studentDetentions = [
  { studentId: 'STD-0004', date: '2026-02-02', reason: 'Late homework submissions (repeated)', duration: '1 day', issuedBy: 'Employee 13' },
  { studentId: 'STD-0007', date: '2026-01-18', reason: 'Disruptive behavior in class', duration: '2 days', issuedBy: 'Employee 7' }
];

// Mobile app accounts — حسابات تطبيق الموبايل (student &/or parent), each linked to a student record
window.LIBERTY.mobileAccounts = [
  { id: 'MACC-0001', studentId: 'STD-0001', type: 'Student', username: 'student01', password: 'hls2027', contactName: 'Student 01', phone: '', email: '', active: true, lastLogin: '2026-06-20' },
  { id: 'MACC-0002', studentId: 'STD-0001', type: 'Parent',  username: 'parent.sherbiny1', password: 'hls2027', contactName: 'Khaled El Sherbiny', phone: '0100 111 2233', email: '', active: true, lastLogin: '2026-06-24' },
  { id: 'MACC-0003', studentId: 'STD-0007', type: 'Parent',  username: 'parent.mansour1', password: 'hls2027', contactName: 'Tarek Mansour', phone: '0101 222 3344', email: '', active: true, lastLogin: '2026-06-15' }
];

// Subjects — المواد الدراسية (each has a stage and one or more responsible teachers)
window.LIBERTY.subjects = [
  { id: 'SUBJ-01', name: 'English Language',  nameAr: 'اللغة الإنجليزية', stage: 'KG',        teachers: ['Employee 14'], coordinator: 'Employee 2',  supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-02', name: 'Arabic Language',   nameAr: 'اللغة العربية',   stage: 'KG',        teachers: ['Employee 6'],  coordinator: 'Employee 6',  supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-03', name: 'English Language',  nameAr: 'اللغة الإنجليزية', stage: 'Primary',   teachers: ['Employee 4', 'Employee 27'], coordinator: 'Employee 2',  supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-04', name: 'Arabic Language',   nameAr: 'اللغة العربية',   stage: 'Primary',   teachers: ['Employee 6'],  coordinator: 'Employee 6',  supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-05', name: 'Mathematics',       nameAr: 'الرياضيات',       stage: 'Primary',   teachers: ['Employee 5', 'Employee 28'], coordinator: 'Employee 13', supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 15, cw2: 15 },
  { id: 'SUBJ-06', name: 'Science',           nameAr: 'العلوم',          stage: 'Primary',   teachers: ['Employee 18'], coordinator: 'Employee 18', supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: false, totalDegree: 50,  cw1: 10, cw2: 10 },
  { id: 'SUBJ-07', name: 'English Language',  nameAr: 'اللغة الإنجليزية', stage: 'Prep',      teachers: ['Employee 17'], coordinator: 'Employee 2',  supervisor: 'Employee 3',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-08', name: 'Mathematics',       nameAr: 'الرياضيات',       stage: 'Prep',      teachers: ['Employee 15'], coordinator: 'Employee 15', supervisor: 'Employee 3',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 15, cw2: 15 },
  { id: 'SUBJ-09', name: 'Science',           nameAr: 'العلوم',          stage: 'Prep',      teachers: ['Employee 7'],  coordinator: 'Employee 7',  supervisor: 'Employee 3',  ministryTotal: true,  hlsTotal: false, totalDegree: 50,  cw1: 10, cw2: 10 },
  { id: 'SUBJ-10', name: 'French Language',   nameAr: 'اللغة الفرنسية',  stage: 'Prep',      teachers: ['Employee 12'], coordinator: 'Employee 12', supervisor: 'Employee 2',  ministryTotal: false, hlsTotal: true,  totalDegree: 50,  cw1: 10, cw2: 10 },
  { id: 'SUBJ-11', name: 'English Language',  nameAr: 'اللغة الإنجليزية', stage: 'Secondary', teachers: ['Employee 2'],  coordinator: 'Employee 2',  supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 20, cw2: 20 },
  { id: 'SUBJ-12', name: 'Mathematics',       nameAr: 'الرياضيات',       stage: 'Secondary', teachers: ['Employee 13'], coordinator: 'Employee 13', supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: true,  totalDegree: 100, cw1: 15, cw2: 15 },
  { id: 'SUBJ-13', name: 'Social Studies',    nameAr: 'الدراسات',        stage: 'Secondary', teachers: ['Employee 13'], coordinator: 'Employee 13', supervisor: 'Employee 1',  ministryTotal: true,  hlsTotal: false, totalDegree: 50,  cw1: 10, cw2: 10 }
];

// Sibling rank within a family: oldest child = 1
window.LIBERTY.siblingRank = function (student) {
  const sibs = LIBERTY.roster()
    .filter(s => s.familyId === student.familyId)
    .sort((a, b) => a.dob < b.dob ? -1 : a.dob > b.dob ? 1 : 0);
  const i = sibs.findIndex(s => s.id === student.id);
  return i < 0 ? 1 : i + 1;
};

// Tuition fee computation (tuition + activities; sibling discount on tuition only). Bus billed separately.
window.LIBERTY.studentFee = function (student, cfg) {
  cfg = cfg || LIBERTY.discountCfg();
  const plan = LIBERTY.feePlans[student.stage] || { tuition: 0, activities: 0 };
  const rank = LIBERTY.siblingRank(student);
  const tuition = plan.tuition;
  const activities = plan.activities;
  const pct = cfg.enabled ? (cfg.rates[rank] || 0) : 0;
  const discount = Math.round(tuition * pct / 100);
  const gross = tuition + activities;
  const net = gross - discount;
  const paid = student.paid || 0;
  return { plan, rank, tuition, activities, pct, discount, gross, net, paid, balance: net - paid };
};

// Bus fee computation for a student (from the registered bus)
window.LIBERTY.busFee = function (student) {
  if (student.arrival !== 'Bus' || !student.busId) return { registered: false, bus: null, fee: 0, paid: 0, balance: 0 };
  const bus = LIBERTY.busById(student.busId);
  const fee = bus ? bus.fee : 0;
  const paid = student.busPaid || 0;
  return { registered: true, bus, fee, paid, balance: fee - paid };
};

// =====================================================================
// CLINIC / MEDICAL — العيادة المدرسية  (doctor records a report per visit)
// =====================================================================
window.LIBERTY.clinicStaff = [
  { id: 'DR-01', name: 'Dr. Employee 21', nameAr: 'د. هبة صلاح', title: 'School Physician' },
  { id: 'NR-01', name: 'Nurse Mona Adel', nameAr: 'الممرضة منى عادل', title: 'School Nurse' }
];

// Seed clinic visits — كل زيارة للعيادة لها تقرير
window.LIBERTY.clinicVisits = [
  { id: 'CLV-1001', studentId: 'STD-0002', date: '2026-06-22', time: '09:40', seenBy: 'Dr. Employee 21',
    complaint: 'Shortness of breath after PE', temp: 37.1, pulse: 96, bp: '110/70',
    diagnosis: 'Mild asthma flare', treatment: 'Salbutamol inhaler 2 puffs, rest 20 min', severity: 'Moderate',
    outcome: 'Returned to class', parentNotified: true, followUp: 'Monitor; carry inhaler', medsGiven: 'Ventolin inhaler' },
  { id: 'CLV-1002', studentId: 'STD-0009', date: '2026-06-22', time: '11:15', seenBy: 'Dr. Employee 21',
    complaint: 'Feeling dizzy, low energy', temp: 36.8, pulse: 88, bp: '105/65',
    diagnosis: 'Low blood sugar (diabetic)', treatment: 'Glucose 15g, monitored 30 min', severity: 'Moderate',
    outcome: 'Returned to class', parentNotified: true, followUp: 'Check sugar before PE', medsGiven: 'Oral glucose' },
  { id: 'CLV-1003', studentId: 'STD-0007', date: '2026-06-23', time: '10:05', seenBy: 'Nurse Mona Adel',
    complaint: 'Fell in playground — knee scrape', temp: 36.9, pulse: 90, bp: '108/68',
    diagnosis: 'Superficial abrasion, left knee', treatment: 'Cleaned & dressed wound', severity: 'Mild',
    outcome: 'Returned to class', parentNotified: false, followUp: 'Keep clean & dry', medsGiven: 'Antiseptic, plaster' },
  { id: 'CLV-1004', studentId: 'STD-0012', date: '2026-06-23', time: '12:30', seenBy: 'Dr. Employee 21',
    complaint: 'Fever and sore throat', temp: 38.6, pulse: 104, bp: '100/62',
    diagnosis: 'Suspected tonsillitis', treatment: 'Paracetamol 250mg, isolated', severity: 'Severe',
    outcome: 'Sent home', parentNotified: true, followUp: 'See pediatrician; clearance before return', medsGiven: 'Paracetamol' },
  { id: 'CLV-1005', studentId: 'STD-0005', date: '2026-06-24', time: '09:20', seenBy: 'Dr. Employee 21',
    complaint: 'Rash after snack (peanut allergy)', temp: 37.0, pulse: 98, bp: '102/64',
    diagnosis: 'Mild allergic reaction', treatment: 'Antihistamine, observed 45 min', severity: 'Moderate',
    outcome: 'Sent home', parentNotified: true, followUp: 'Strict allergen avoidance', medsGiven: 'Antihistamine syrup' }
];

window.LIBERTY.SEVERITY = {
  'Mild':     { pill: 'ok',   color: '#10b981' },
  'Moderate': { pill: 'warn', color: '#f59e0b' },
  'Severe':   { pill: 'err',  color: '#ef4444' }
};

// All visits (seed + ones the doctor logs), newest first
window.LIBERTY.clinicKey = 'liberty_clinic_visits';
window.LIBERTY.clinicAll = function () {
  let extra = [];
  try { extra = JSON.parse(localStorage.getItem(LIBERTY.clinicKey)) || []; } catch (_) {}
  return LIBERTY.clinicVisits.concat(extra)
    .slice()
    .sort((a, b) => (b.date + (b.time || '')).localeCompare(a.date + (a.time || '')));
};
window.LIBERTY.clinicForStudent = function (studentId) {
  return LIBERTY.clinicAll().filter(v => v.studentId === studentId);
};
window.LIBERTY.clinicAdd = function (visit) {
  let extra = [];
  try { extra = JSON.parse(localStorage.getItem(LIBERTY.clinicKey)) || []; } catch (_) {}
  visit.id = 'CLV-' + (2000 + extra.length + 1);
  extra.push(visit);
  localStorage.setItem(LIBERTY.clinicKey, JSON.stringify(extra));
  return visit.id;
};

// =====================================================================
// INVENTORY & ASSETS — المخزون والأصول
// =====================================================================
window.LIBERTY.supplyCategories = ['Stationery', 'Cleaning', 'Cafeteria', 'Medical', 'Lab', 'IT', 'Maintenance', 'Sports'];
window.LIBERTY.supplyUnits = ['Piece', 'Box', 'Pack', 'Ream', 'Bottle', 'Kg', 'Litre', 'Roll', 'Set'];
window.LIBERTY.equipCategories = ['Computer', 'Projector', 'Printer', 'Lab equipment', 'Furniture', 'AV', 'Network', 'Kitchen', 'Sports'];
window.LIBERTY.equipLocations = ['Room', 'Lab', 'Office', 'Library', 'Gym', 'Storage', 'Cafeteria'];
window.LIBERTY.equipStatuses = ['In service', 'Under maintenance', 'In storage', 'Retired'];
window.LIBERTY.priorities = ['Low', 'Medium', 'High', 'Critical'];
window.LIBERTY.maintStatuses = ['Open', 'In progress', 'Resolved', 'Cancelled'];
window.LIBERTY.issueDepartments = ['American Section', 'British Section', 'Languages Dept.', 'Science Lab', 'IT Department', 'Administration', 'Cafeteria', 'Clinic', 'Maintenance', 'Sports'];

// Supplies — المستلزمات (consumables)
window.LIBERTY.inventorySupplies = [
  { id: 'SUP-001', name: 'A4 Paper',            category: 'Stationery', qty: 120, unit: 'Ream',   supplier: 'Alex Office Supplies', purchased: '2026-05-12', price: 95,  notes: 'White 80gsm' },
  { id: 'SUP-002', name: 'Whiteboard Markers',  category: 'Stationery', qty: 60,  unit: 'Box',    supplier: 'Alex Office Supplies', purchased: '2026-05-12', price: 140, notes: 'Assorted colors' },
  { id: 'SUP-003', name: 'Floor Cleaner',       category: 'Cleaning',   qty: 40,  unit: 'Litre',  supplier: 'CleanPro Egypt',       purchased: '2026-06-01', price: 55,  notes: '' },
  { id: 'SUP-004', name: 'Disposable Gloves',   category: 'Medical',    qty: 25,  unit: 'Box',    supplier: 'MediCare Supplies',    purchased: '2026-06-10', price: 110, notes: 'Nitrile, M' },
  { id: 'SUP-005', name: 'Printer Toner 26A',   category: 'IT',         qty: 8,   unit: 'Piece',  supplier: 'TechZone',             purchased: '2026-04-20', price: 1450,notes: 'HP LaserJet' },
  { id: 'SUP-006', name: 'Lab Test Tubes',      category: 'Lab',        qty: 200, unit: 'Piece',  supplier: 'SciLab Co.',           purchased: '2026-03-15', price: 6,   notes: 'Borosilicate' },
  { id: 'SUP-007', name: 'Cafeteria Cups',      category: 'Cafeteria',  qty: 30,  unit: 'Pack',   supplier: 'PackRight',            purchased: '2026-06-18', price: 48,  notes: '100/pack' },
  { id: 'SUP-008', name: 'Hand Soap Refill',    category: 'Cleaning',   qty: 18,  unit: 'Bottle', supplier: 'CleanPro Egypt',       purchased: '2026-06-05', price: 35,  notes: '' }
];

// Equipment — الأصول (durable assets)
window.LIBERTY.equipment = [
  { id: 'EQP-001', name: 'Dell OptiPlex PC',     serial: 'DL-9921-AA', category: 'Computer',     location: 'Lab',     locationName: 'IT Lab 1',     purchased: '2024-09-01', cost: 18500, warranty: '2027-09-01', status: 'In service',        notes: '' },
  { id: 'EQP-002', name: 'Epson Projector',      serial: 'EP-5540-BX', category: 'Projector',    location: 'Room',    locationName: 'Room 204',     purchased: '2023-08-15', cost: 12000, warranty: '2025-08-15', status: 'Under maintenance', notes: 'Lamp flickering' },
  { id: 'EQP-003', name: 'HP LaserJet Printer',  serial: 'HP-1180-CC', category: 'Printer',      location: 'Office',  locationName: 'Admin Office', purchased: '2025-01-20', cost: 6500,  warranty: '2027-01-20', status: 'In service',        notes: '' },
  { id: 'EQP-004', name: 'Microscope (x1000)',   serial: 'MS-7741-DD', category: 'Lab equipment',location: 'Lab',     locationName: 'Science Lab',  purchased: '2022-09-10', cost: 9800,  warranty: '2024-09-10', status: 'In service',        notes: '' },
  { id: 'EQP-005', name: 'Smart Board 75"',      serial: 'SB-3320-EE', category: 'AV',           location: 'Room',    locationName: 'Room 301',     purchased: '2024-02-01', cost: 32000, warranty: '2027-02-01', status: 'In service',        notes: '' },
  { id: 'EQP-006', name: 'Network Switch 48p',   serial: 'NS-8890-FF', category: 'Network',      location: 'Storage', locationName: 'Server Room',  purchased: '2023-05-12', cost: 14500, warranty: '2026-05-12', status: 'In service',        notes: '' },
  { id: 'EQP-007', name: 'Cafeteria Fridge',     serial: 'CF-2210-GG', category: 'Kitchen',      location: 'Cafeteria',locationName: 'Main Cafeteria',purchased: '2021-08-01', cost: 16000, warranty: '2023-08-01', status: 'In storage',        notes: 'Spare unit' }
];

// Maintenance requests — طلبات الصيانة
window.LIBERTY.maintenance = [
  { id: 'MNT-001', assetId: 'EQP-002', issue: 'Projector lamp flickers and dims during class', requestedBy: 'Employee 3', requestDate: '2026-06-20', priority: 'High',   status: 'In progress', resolvedDate: '', notes: 'Replacement lamp ordered' },
  { id: 'MNT-002', assetId: 'EQP-004', issue: 'Microscope focus knob stuck',                    requestedBy: 'Employee 2',    requestDate: '2026-06-18', priority: 'Medium', status: 'Open',        resolvedDate: '', notes: '' },
  { id: 'MNT-003', assetId: 'EQP-001', issue: 'PC very slow on startup, possible disk issue',   requestedBy: 'Employee 11',requestDate: '2026-06-15', priority: 'Low',    status: 'Resolved',    resolvedDate: '2026-06-19', notes: 'Replaced HDD with SSD' },
  { id: 'MNT-004', assetId: 'EQP-006', issue: 'Intermittent network drops in Server Room',      requestedBy: 'Marwa Yousry',requestDate: '2026-06-22', priority: 'Critical',status: 'Open',       resolvedDate: '', notes: 'Affecting whole floor' }
];

window.LIBERTY.PRIORITY = {
  'Low':      { pill: 'muted', color: '#64748b' },
  'Medium':   { pill: 'info',  color: '#3b82f6' },
  'High':     { pill: 'warn',  color: '#f59e0b' },
  'Critical': { pill: 'err',   color: '#ef4444' }
};
window.LIBERTY.EQ_STATUS = {
  'In service':        'ok',
  'Under maintenance': 'warn',
  'In storage':        'info',
  'Retired':           'muted'
};
window.LIBERTY.MNT_STATUS = {
  'Open':        'err',
  'In progress': 'warn',
  'Resolved':    'ok',
  'Cancelled':   'muted'
};
window.LIBERTY.equipById = id => (window.STORE ? STORE.equipment() : LIBERTY.equipment).find(e => e.id === id) || null;
