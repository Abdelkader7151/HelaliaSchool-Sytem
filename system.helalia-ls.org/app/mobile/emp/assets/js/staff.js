(function () {
  var drawer = document.getElementById('staff-drawer');
  var sheet = document.getElementById('lang-sheet');

  if (drawer) {
    var openers = document.querySelectorAll('[data-drawer-open]');
    var closers = drawer.querySelectorAll('[data-drawer-close]');
    function openDrawer() {
      if (sheet) closeLang();
      drawer.classList.add('is-open');
      drawer.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      openers.forEach(function (btn) {
        btn.setAttribute('aria-expanded', 'true');
      });
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      drawer.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      openers.forEach(function (btn) {
        btn.setAttribute('aria-expanded', 'false');
      });
    }

    openers.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        if (drawer.classList.contains('is-open')) closeDrawer();
        else openDrawer();
      });
    });

    closers.forEach(function (el) {
      el.addEventListener('click', closeDrawer);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) closeDrawer();
    });
  }

  if (!sheet) return;

  var langOpeners = document.querySelectorAll('[data-lang-open]');
  var langClosers = sheet.querySelectorAll('[data-lang-close]');

  function openLang() {
    if (drawer) {
      drawer.classList.remove('is-open');
      drawer.setAttribute('aria-hidden', 'true');
    }
    sheet.classList.add('is-open');
    sheet.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    langOpeners.forEach(function (btn) {
      btn.setAttribute('aria-expanded', 'true');
    });
  }

  function closeLang() {
    sheet.classList.remove('is-open');
    sheet.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    langOpeners.forEach(function (btn) {
      btn.setAttribute('aria-expanded', 'false');
    });
  }

  langOpeners.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      if (sheet.classList.contains('is-open')) closeLang();
      else openLang();
    });
  });

  langClosers.forEach(function (el) {
    el.addEventListener('click', closeLang);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sheet.classList.contains('is-open')) closeLang();
  });
})();

(function () {
  var lists = document.querySelectorAll('[data-score-url]');
  if (!lists.length) return;

  var spin = document.getElementById('staff-spin');
  function showSpin(on) {
    if (!spin) return;
    if (on) spin.removeAttribute('hidden');
    else spin.setAttribute('hidden', 'hidden');
  }

  lists.forEach(function (list) {
    var url = list.getAttribute('data-score-url');
    var row = list.getAttribute('data-row') || '';
    var inputs = list.querySelectorAll('.scorecard__input:not([readonly])');
    inputs.forEach(function (input) {
      input.addEventListener('change', function () {
        saveScore(url, input, row);
      });
      input.addEventListener('focusout', function () {
        saveScore(url, input, row);
      });
    });
  });

  var lastSent = {};
  function saveScore(url, input, row) {
    var id = input.getAttribute('data-id');
    var total = input.getAttribute('data-total');
    var value = input.value;
    var key = url + ':' + id;
    if (lastSent[key] === value) return;
    lastSent[key] = value;
    showSpin(true);
    var body = new URLSearchParams();
    if (row) {
      body.set('id', id);
      body.set('reg_result', value);
      body.set('reg_total', total);
      body.set('row', row);
    } else {
      body.set('id', id);
      body.set('ex_result', value);
      body.set('ex_total', total);
    }
    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString(),
      credentials: 'same-origin'
    }).then(function (res) { return res.text(); }).then(function (text) {
      if (String(text).trim() === '0') input.value = '';
    }).catch(function () {
      input.value = '';
    }).then(function () {
      showSpin(false);
    });
  }
})();

(function () {
  var triggers = document.querySelectorAll('[data-photo-trigger]');
  var input = document.querySelector('[data-photo-input]');
  var img = document.querySelector('[data-photo-img]');
  if (triggers.length && input) {
    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        input.click();
      });
    });
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (file && img && window.FileReader) {
        var reader = new FileReader();
        reader.onload = function (e) {
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
      var form = input.closest('form[data-photo-save]');
      if (file && form) {
        form.submit();
      }
    });
  }

  var start = document.querySelector('[data-vac-start]');
  var end = document.querySelector('[data-vac-end]');
  var days = document.querySelector('[data-vac-days]');
  var submit = document.querySelector('[data-vac-submit]');
  function vacDays() {
    if (!start || !end || !days) return;
    if (!start.value || !end.value) {
      days.textContent = '0';
      if (submit) submit.disabled = true;
      return;
    }
    var a = Date.parse(start.value + 'T12:00:00');
    var b = Date.parse(end.value + 'T12:00:00');
    var n = Math.round((b - a) / 86400000);
    if (!(n > 0)) n = 0;
    days.textContent = String(n);
    if (submit) submit.disabled = n <= 0;
  }
  if (start && end) {
    start.addEventListener('change', vacDays);
    end.addEventListener('change', vacDays);
  }

  var excStart = document.querySelector('[data-exc-start]');
  var excEnd = document.querySelector('[data-exc-end]');
  var hours = document.querySelector('[data-exc-hours]');
  function parseClock(v) {
    if (!v) return 0;
    var p = v.split(':');
    return (parseInt(p[0], 10) || 0) * 3600 + (parseInt(p[1], 10) || 0) * 60;
  }
  function pad(n) {
    return (n < 10 ? '0' : '') + n;
  }
  function excHours() {
    if (!hours) return;
    var diff = parseClock(excEnd && excEnd.value) - parseClock(excStart && excStart.value);
    if (!(diff > 0)) {
      hours.textContent = '0';
      return;
    }
    hours.textContent = pad(Math.floor(diff / 3600)) + ':' + pad(Math.floor((diff % 3600) / 60));
  }
  if (excStart) excStart.addEventListener('change', excHours);
  if (excEnd) excEnd.addEventListener('change', excHours);
})();

(function () {
  var msgs = window.__staffActionMsgs || {};
  var working = document.getElementById('staff-working');
  var workingText = document.getElementById('staff-working-text');
  var success = document.getElementById('staff-success');
  var successTitle = document.getElementById('staff-success-title');
  var lastFocus = null;

  function openLayer(el) {
    if (!el) return;
    lastFocus = document.activeElement;
    el.hidden = false;
    el.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeLayer(el) {
    if (!el) return;
    el.hidden = true;
    el.setAttribute('aria-hidden', 'true');
    if ((!success || success.hidden) && (!working || working.hidden)) {
      document.body.style.overflow = '';
    }
    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
  }

  window.staffShowWorking = function (on, text) {
    if (!working) return;
    if (workingText && text) workingText.textContent = text;
    else if (workingText && msgs.working) workingText.textContent = msgs.working;
    if (on) openLayer(working);
    else closeLayer(working);
  };

  window.staffShowSuccess = function (message) {
    if (!success || !successTitle) return;
    successTitle.textContent = message || msgs.uploaded || 'OK';
    openLayer(success);
    var ok = success.querySelector('[data-staff-success-close]');
    if (ok) ok.focus();
  };

  if (success) {
    success.querySelectorAll('[data-staff-success-close]').forEach(function (el) {
      el.addEventListener('click', function () {
        closeLayer(success);
      });
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !success.hidden) closeLayer(success);
    });
  }

  function savedPath() {
    return /profile|password|my-absence|my-excuse|vacation|excuse|questions|evaluation|notify|control|plan/i.test(location.pathname);
  }

  function successFromUrl() {
    var p = new URLSearchParams(location.search);
    if (p.has('deleted')) return msgs.deleted;
    if (p.has('confirmed')) return msgs.confirmed;
    if (p.has('sent')) return msgs.sent;
    if (p.has('saved')) return msgs.saved;
    if (p.has('done')) return savedPath() ? msgs.saved : msgs.uploaded;
    return '';
  }

  function cleanSuccessParams() {
    var p = new URLSearchParams(location.search);
    var keys = ['done', 'deleted', 'saved', 'sent', 'confirmed'];
    var changed = false;
    keys.forEach(function (key) {
      if (p.has(key)) {
        p.delete(key);
        changed = true;
      }
    });
    if (!changed) return;
    var qs = p.toString();
    var next = location.pathname + (qs ? ('?' + qs) : '') + location.hash;
    history.replaceState(null, '', next);
  }

  var bootMsg = successFromUrl();
  if (bootMsg) {
    window.addEventListener('load', function () {
      window.staffShowSuccess(bootMsg);
      cleanSuccessParams();
    });
  }

  function bindWaitForm(form) {
    if (!form || form.getAttribute('data-staff-wait-bound') === '1') return;
    form.setAttribute('data-staff-wait-bound', '1');
    form.addEventListener('submit', function () {
      var btn = form.querySelector('[type="submit"]');
      if (btn) {
        var wait = btn.getAttribute('data-wait');
        if (wait) btn.textContent = wait;
        btn.disabled = true;
      }
      window.staffShowWorking(true);
    });
  }

  document.querySelectorAll('form[enctype="multipart/form-data"], form[data-staff-wait]').forEach(bindWaitForm);
  document.querySelectorAll('form[method="post"]:not([data-staff-wait-skip])').forEach(function (form) {
    if (form.querySelector('[data-wait]')) bindWaitForm(form);
  });

  document.querySelectorAll('[data-q-load-more]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var listId = btn.getAttribute('aria-controls');
      var list = listId ? document.getElementById(listId) : null;
      if (!list || btn.disabled) return;
      var variant = btn.getAttribute('data-q-variant') || 'pending';
      var offset = parseInt(btn.getAttribute('data-q-offset') || '0', 10);
      var step = parseInt(btn.getAttribute('data-step') || '6', 10);
      btn.disabled = true;
      btn.classList.add('is-loading');
      var url = new URL(window.location.href);
      url.searchParams.set('q_chunk', variant);
      url.searchParams.set('offset', String(offset));
      fetch(url.toString(), { credentials: 'same-origin' })
        .then(function (res) {
          if (!res.ok) throw new Error('load failed');
          return res.json();
        })
        .then(function (data) {
          if (data.html) {
            list.insertAdjacentHTML('beforeend', data.html);
          }
          if (data.has_more) {
            btn.setAttribute('data-q-offset', String(offset + step));
            btn.disabled = false;
            btn.classList.remove('is-loading');
          } else {
            btn.hidden = true;
          }
        })
        .catch(function () {
          btn.disabled = false;
          btn.classList.remove('is-loading');
        });
    });
  });
})();

/* Dual-role: after app kill/reopen, always show Emp/Parent chooser again. */
(function () {
  var dual = document.body && document.body.getAttribute('data-helalia-dual');
  if (dual !== '1') return;
  var path = location.pathname || '';
  var isChoose = path.indexOf('choose-role') !== -1;
  if (isChoose) {
    try { sessionStorage.removeItem('helalia_dual_pick'); } catch (e) {}
    return;
  }
  if ((location.search || '').indexOf('dual_picked=1') !== -1) {
    try { sessionStorage.setItem('helalia_dual_pick', '1'); } catch (e) {}
    return;
  }
  var picked = false;
  try { picked = sessionStorage.getItem('helalia_dual_pick') === '1'; } catch (e) { return; }
  if (picked) return;
  var base = path.replace(/\/[^\/]*$/, '/');
  location.replace(base + 'choose-role.php?fresh=1');
})();