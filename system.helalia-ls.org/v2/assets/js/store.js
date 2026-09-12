// Liberty — shared CRUD store for Students & Buses
// Merges the seed arrays in data.js with localStorage overlays (edits, adds, deletes)
// so add/edit/delete persist across pages without a backend.
(function () {
  const SK = 'liberty_students_ovr';   // { id: {…fields, __added?} }
  const SDK = 'liberty_students_del';  // [id, …]
  const BK = 'liberty_buses_ovr';
  const BDK = 'liberty_buses_del';
  const SUK = 'liberty_supplies_ovr',  SUDK = 'liberty_supplies_del';
  const EQK = 'liberty_equipment_ovr', EQDK = 'liberty_equipment_del';
  const MNK = 'liberty_maint_ovr',     MNDK = 'liberty_maint_del';
  const CLK = 'liberty_classes_ovr',   CLDK = 'liberty_classes_del';
  const SBK = 'liberty_subjects_ovr',  SBDK = 'liberty_subjects_del';
  const SLK = 'liberty_seclang_ovr',   SLDK = 'liberty_seclang_del';
  const MSK = 'liberty_student_msgs';  // append-only parent messages/notifications
  const NTK = 'liberty_notifications';  // append-only notifications (parent/student/employee)
  const VCK = 'liberty_vacations_ovr', VCDK = 'liberty_vacations_del';
  const MAK = 'liberty_mobile_accounts_ovr', MADK = 'liberty_mobile_accounts_del';
  const EAK = 'liberty_employee_accounts_ovr', EADK = 'liberty_employee_accounts_del';
  const ISK = 'liberty_stock_issues';  // append-only issue vouchers
  const GRK = 'liberty_goods_receipts'; // append-only goods receipts

  const readObj = k => { try { return JSON.parse(localStorage.getItem(k)) || {}; } catch (_) { return {}; } };
  const readArr = k => { try { return JSON.parse(localStorage.getItem(k)) || []; } catch (_) { return []; } };
  const write = (k, v) => localStorage.setItem(k, JSON.stringify(v));

  function merge(seed, ovrKey, delKey) {
    const ovr = readObj(ovrKey), del = readArr(delKey);
    const base = seed.map(s => ({ ...s, ...(ovr[s.id] || {}) }));
    const seedIds = new Set(seed.map(s => s.id));
    const added = Object.values(ovr).filter(o => o.__added && !seedIds.has(o.id));
    return base.concat(added).filter(s => !del.includes(s.id));
  }

  function save(seed, ovrKey, obj, prefix) {
    const ovr = readObj(ovrKey);
    const isSeed = seed.some(s => s.id === obj.id);
    if (!obj.id) {                       // brand-new
      const n = 9000 + Object.keys(ovr).length + 1;
      obj.id = prefix + '-' + String(n);
      obj.__added = true;
    } else if (!isSeed) {
      obj.__added = true;                // editing a previously-added record
    }
    ovr[obj.id] = { ...(ovr[obj.id] || {}), ...obj };
    write(ovrKey, ovr);
    return obj.id;
  }

  function remove(seed, ovrKey, delKey, id) {
    const ovr = readObj(ovrKey);
    if (ovr[id] && ovr[id].__added && !seed.some(s => s.id === id)) {
      delete ovr[id]; write(ovrKey, ovr); return;
    }
    const del = readArr(delKey);
    if (!del.includes(id)) { del.push(id); write(delKey, del); }
  }

  window.STORE = {
    students: () => merge(LIBERTY.students, SK, SDK),
    saveStudent: stu => save(LIBERTY.students, SK, stu, 'STD'),
    deleteStudent: id => remove(LIBERTY.students, SK, SDK, id),
    studentById: id => STORE.students().find(s => s.id === id) || null,

    buses: () => merge(LIBERTY.buses, BK, BDK),
    saveBus: bus => save(LIBERTY.buses, BK, bus, 'BUS'),
    deleteBus: id => remove(LIBERTY.buses, BK, BDK, id),

    supplies: () => merge(LIBERTY.inventorySupplies, SUK, SUDK),
    saveSupply: o => save(LIBERTY.inventorySupplies, SUK, o, 'SUP'),
    deleteSupply: id => remove(LIBERTY.inventorySupplies, SUK, SUDK, id),

    equipment: () => merge(LIBERTY.equipment, EQK, EQDK),
    saveEquipment: o => save(LIBERTY.equipment, EQK, o, 'EQP'),
    deleteEquipment: id => remove(LIBERTY.equipment, EQK, EQDK, id),

    maintenance: () => merge(LIBERTY.maintenance, MNK, MNDK),
    saveMaintenance: o => save(LIBERTY.maintenance, MNK, o, 'MNT'),
    deleteMaintenance: id => remove(LIBERTY.maintenance, MNK, MNDK, id),

    classes: () => merge(LIBERTY.classes, CLK, CLDK),
    saveClass: o => save(LIBERTY.classes, CLK, o, 'CLS'),
    deleteClass: id => {
      remove(LIBERTY.classes, CLK, CLDK, id);
      // unassign any students that were in this class
      STORE.students().filter(s => s.classId === id).forEach(s => STORE.saveStudent({ ...s, classId: null }));
    },
    classById: id => STORE.classes().find(c => c.id === id) || null,
    studentsInClass: id => STORE.students().filter(s => s.classId === id),
    assignStudentToClass: (studentId, classId) => {
      const s = STORE.studentById(studentId);
      if (s) STORE.saveStudent({ ...s, classId: classId || null });
    },

    subjects: () => merge(LIBERTY.subjects, SBK, SBDK),
    saveSubject: o => save(LIBERTY.subjects, SBK, o, 'SUBJ'),
    deleteSubject: id => remove(LIBERTY.subjects, SBK, SBDK, id),
    subjectById: id => STORE.subjects().find(s => s.id === id) || null,

    secondLanguages: () => merge(LIBERTY.secondLanguages, SLK, SLDK),
    saveSecondLanguage: o => save(LIBERTY.secondLanguages, SLK, o, 'SL'),
    deleteSecondLanguage: id => remove(LIBERTY.secondLanguages, SLK, SLDK, id),
    secondLanguageById: id => STORE.secondLanguages().find(s => s.id === id) || null,

    // Parent messages / notifications — رسائل وإشعارات لأولياء الأمور
    messagesFor: studentId => readArr(MSK).filter(m => m.studentId === studentId).sort((a, b) => b.sentAt.localeCompare(a.sentAt)),
    sendMessage: msg => {
      const list = readArr(MSK);
      msg.id = 'MSG-' + String(5000 + list.length + 1);
      msg.sentAt = msg.sentAt || new Date().toISOString();
      msg.read = false;
      list.push(msg);
      write(MSK, list);
      return msg.id;
    },

    // General notifications — إشعارات عامة (parent / student / employee), shown in the mobile app
    notifications: () => readArr(NTK).sort((a, b) => b.sentAt.localeCompare(a.sentAt)),
    sendNotification: n => {
      const list = readArr(NTK);
      n.id = 'NTF-' + String(6000 + list.length + 1);
      n.sentAt = n.sentAt || new Date().toISOString();
      list.push(n);
      write(NTK, list);
      return n.id;
    },
    deleteNotification: id => write(NTK, readArr(NTK).filter(n => n.id !== id)),

    // Student vacations — إجازات الطلبة (admin approve/reject)
    vacations: () => merge(LIBERTY.studentVacations, VCK, VCDK),
    vacationsFor: studentId => STORE.vacations().filter(v => v.studentId === studentId),
    saveVacation: o => save(LIBERTY.studentVacations, VCK, o, 'SVAC'),
    deleteVacation: id => remove(LIBERTY.studentVacations, VCK, VCDK, id),
    decideVacation: (id, status) => {
      const v = STORE.vacations().find(x => x.id === id);
      if (v) STORE.saveVacation({ ...v, status });
    },

    // Mobile app accounts — حسابات تطبيق الموبايل (student + parent), linked to a student record
    mobileAccounts: () => merge(LIBERTY.mobileAccounts, MAK, MADK),
    saveMobileAccount: o => save(LIBERTY.mobileAccounts, MAK, o, 'MACC'),
    deleteMobileAccount: id => remove(LIBERTY.mobileAccounts, MAK, MADK, id),
    mobileAccountsFor: studentId => STORE.mobileAccounts().filter(a => a.studentId === studentId),

    // Employee mobile app accounts — حسابات تطبيق الموبايل للموظفين
    employeeAccounts: () => merge(LIBERTY.employeeAccounts || [], EAK, EADK),
    saveEmployeeAccount: o => save(LIBERTY.employeeAccounts || [], EAK, o, 'EACC'),
    deleteEmployeeAccount: id => remove(LIBERTY.employeeAccounts || [], EAK, EADK, id),

    // Stock issue vouchers — صرف مخزون (append-only; deducts qty from supplies)
    issues: () => readArr(ISK),
    addIssue: voucher => {
      const list = readArr(ISK);
      voucher.id = 'ISS-' + String(7000 + list.length + 1);
      // deduct each line qty from its supply
      (voucher.lines || []).forEach(ln => {
        const sup = STORE.supplies().find(s => s.id === ln.supplyId);
        if (sup) STORE.saveSupply({ ...sup, qty: Math.max(0, (sup.qty || 0) - (ln.qty || 0)) });
      });
      list.push(voucher);
      write(ISK, list);
      return voucher.id;
    },

    // Goods receipts — سند استلام مخزون (append-only; ADDS qty to supplies, updates supplier/price/date)
    receipts: () => readArr(GRK),
    addReceipt: voucher => {
      const list = readArr(GRK);
      voucher.id = 'GRN-' + String(8000 + list.length + 1);
      (voucher.lines || []).forEach(ln => {
        if (ln.supplyId) {
          const sup = STORE.supplies().find(s => s.id === ln.supplyId);
          if (sup) STORE.saveSupply({ ...sup, qty: (sup.qty || 0) + (ln.qty || 0),
            price: ln.price || sup.price, supplier: voucher.supplier || sup.supplier, purchased: voucher.date || sup.purchased });
        } else {
          // new item created straight from the receipt
          const id = STORE.saveSupply({ id: '', name: ln.name, category: ln.category || 'Other', unit: ln.unit || 'Piece',
            qty: ln.qty || 0, price: ln.price || 0, supplier: voucher.supplier || '', purchased: voucher.date || '', notes: 'Created via ' + voucher.id });
          ln.supplyId = id;
        }
      });
      list.push(voucher);
      write(GRK, list);
      return voucher.id;
    },

    resetAll: () => { [SK, SDK, BK, BDK, SUK, SUDK, EQK, EQDK, MNK, MNDK, ISK, GRK, CLK, CLDK, SBK, SBDK, SLK, SLDK, MSK, NTK, VCK, VCDK, MAK, MADK, EAK, EADK].forEach(k => localStorage.removeItem(k)); }
  };
})();
