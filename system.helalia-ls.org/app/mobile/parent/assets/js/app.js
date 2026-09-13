/* Helalia — minimal UI helpers. No framework, no build step. */
(function () {
  'use strict';

  // Segmented tabs that stay on the page (href="#") switch locally.
  document.addEventListener('click', function (e) {
    var tab = e.target.closest('.tab[href="#"]');
    if (!tab) return;
    e.preventDefault();
    var group = tab.parentElement.querySelectorAll('.tab');
    for (var i = 0; i < group.length; i++) group[i].classList.remove('is-active');
    tab.classList.add('is-active');
  });

  // Attendance chips flip between present / absent.
  document.addEventListener('click', function (e) {
    var row = e.target.closest('.row[data-toggle]');
    if (!row) return;
    var chip = row.querySelector('.chip');
    if (!chip) return;
    var on = row.getAttribute('data-on') || 'Present';
    var off = row.getAttribute('data-off') || 'Absent';
    var isOn = chip.textContent.trim() === on;
    chip.textContent = isOn ? off : on;
    row.classList.toggle('t-green', !isOn);
    row.classList.toggle('t-coral', isOn);
  });

  // Keep the scroll position of the inner page across back/forward.
  // Include query string so alerts tabs / Load more don't share one scroll slot.
  var page = document.querySelector('.page');
  if (page) {
    var key = 'helalia:' + location.pathname + (location.search || '');
    try {
      var saved = sessionStorage.getItem(key);
      if (saved) page.scrollTop = parseInt(saved, 10) || 0;
      page.addEventListener('scroll', function () {
        try { sessionStorage.setItem(key, String(page.scrollTop)); } catch (err) {}
      }, { passive: true });
    } catch (err) {}
  }

  // Reliable back for the WebView: never history.back() — that loops
  // (alerts ↔ alert detail). Always go to the explicit href and replace
  // the current history entry so Back does not bounce between two pages.
  document.addEventListener('click', function (e) {
    var el = e.target.closest('a.back, a[data-helalia-back]');
    if (!el) return;
    var dest = el.getAttribute('data-helalia-back') || el.getAttribute('href') || '';
    if (!dest || dest === '#' || dest.indexOf('javascript:') === 0) return;
    e.preventDefault();
    try {
      location.replace(dest);
    } catch (err) {
      location.href = dest;
    }
  });

  // One-app login: phone decides parent / student / office-teacher home.
  var loginForm = document.getElementById('login-form');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var phoneEl = loginForm.querySelector('[name="phone"], #phone, input[type="tel"]');
      var passEl = loginForm.querySelector('[name="password"], #password, input[type="password"]');
      var err = loginForm.querySelector('.auth__err');
      var phone = phoneEl ? String(phoneEl.value || '').replace(/\s+/g, '') : '';
      var pass = passEl ? String(passEl.value || '') : '';
      if (!phone || !pass) {
        if (err) {
          err.textContent = document.documentElement.lang === 'ar'
            ? 'أدخل رقم الهاتف وكلمة المرور'
            : 'Enter phone and password';
          err.classList.add('is-on');
        }
        return;
      }
      var key = phone.toLowerCase();
      var isAr = document.documentElement.lang === 'ar';
      var lang = isAr ? 'arb' : 'eng';
      var parentPhones = {
        '01000729089': 1, '01001005526': 1, parent: 1
      };
      var kidPhones = { student: 1, kid: 1 };
      var dest;
      if (parentPhones[key]) dest = '../../parent/' + lang + '/parent-view.html';
      else if (kidPhones[key]) dest = '../../kid/' + lang + '/kid-view.html';
      else dest = '../../emp/' + lang + '/emp-view.html';
      location.href = dest;
    });
  }
})();

/* Dual staff: reopen must show Emp/Parent chooser, not last parent screen. */
(function () {
  if ((document.cookie || '').indexOf('helalia_dual_staff=1') === -1) return;
  var path = location.pathname || '';
  // Don't interrupt reading alerts / alert detail / news.
  if (/parent-alerts?\.php/.test(path)) return;
  if (/parent-timeline\.php/.test(path)) return;
  if ((location.search || '').indexOf('dual_picked=1') !== -1) {
    try { sessionStorage.setItem('helalia_dual_pick', '1'); } catch (e) {}
    return;
  }
  var picked = false;
  try { picked = sessionStorage.getItem('helalia_dual_pick') === '1'; } catch (e) { return; }
  if (picked) return;
  var lang = path.indexOf('/arb/') !== -1 ? 'arb' : 'eng';
  location.replace('../../emp/' + lang + '/choose-role.php?fresh=1');
})();