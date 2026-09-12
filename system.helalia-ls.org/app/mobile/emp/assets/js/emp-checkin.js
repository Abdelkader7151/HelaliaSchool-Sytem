(function () {
  var root = document.getElementById('punch-root');
  if (!root) return;

  var i18n = {};
  var i18nEl = document.getElementById('punch-i18n');
  if (i18nEl) {
    try { i18n = JSON.parse(i18nEl.textContent || '{}'); } catch (e) { i18n = {}; }
  }

  var status = {};
  try { status = JSON.parse(root.getAttribute('data-status') || '{}'); } catch (e) { status = {}; }

  var api = root.getAttribute('data-api');
  var handoffApi = root.getAttribute('data-handoff');
  var gpsToken = '';
  var gpsPoll = null;
  var locCard = root.querySelector('[data-loc-card]');
  var locState = root.querySelector('[data-loc-state]');
  var locMeta = root.querySelector('[data-loc-meta]');
  var locHint = root.querySelector('[data-loc-hint]');
  var locEnable = root.querySelector('[data-loc-enable]');
  var locSafari = root.querySelector('[data-loc-safari]');
  var emptyEl = root.querySelector('[data-today-empty]');
  var recordedEl = root.querySelector('[data-today-in]');
  var factsEl = root.querySelector('[data-today-facts]');
  var msgEl = root.querySelector('[data-punch-msg]');
  var closedEl = root.querySelector('[data-checkout-closed]');
  var punchBtn = root.querySelector('[data-punch-btn]');
  var bootMs = Date.now();
  var serverNow = parseInt(status.now, 10) || Math.floor(Date.now() / 1000);

  var geo = {
    on: false,
    denied: false,
    asking: false,
    checking: false,
    precise: false,
    insecure: false,
    unsupported: false,
    lat: null,
    lng: null,
    accuracy: null,
    distance: null,
    inside: false,
    accuracyOk: false
  };
  var busy = false;
  var watchId = null;
  var geoTimer = null;
  var preciseTimer = null;
  var geoSeq = 0;
  var watchStarted = false;
  var deviceReady = !window.cordova;
  var PRECISE_MAX_M = 80;
  var PRECISE_WAIT_MS = 10000;

  if (window.cordova) {
    document.addEventListener('deviceready', function () {
      deviceReady = true;
      if (geo.asking && !geo.on) {
        requestPosition(true, 0);
      }
    }, false);
  }

  function t(key) {
    return i18n[key] || key;
  }

  function isSecure() {
    if (window.cordova) return true;
    if (location.protocol === 'https:') return true;
    return window.isSecureContext === true;
  }

  function isIOS() {
    var ua = navigator.userAgent || '';
    return /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  }

  function isInAppIOS() {
    if (!isIOS()) return false;
    var ua = navigator.userAgent || '';
    return !/Safari\//.test(ua) || !/Version\//.test(ua);
  }

  function showSafari(url) {
    if (!locSafari) return;
    locSafari.hidden = false;
    locSafari.textContent = t('loc_safari');
    if (url) {
      locSafari.href = url;
    }
  }

  function hideSafari() {
    if (locSafari) locSafari.hidden = true;
  }

  function applyNativeCoords(lat, lng, acc) {
    onPosition({
      coords: {
        latitude: lat,
        longitude: lng,
        accuracy: acc == null ? 25 : acc
      }
    });
  }

  function pollGpsToken() {
    if (!handoffApi || !gpsToken) return;
    var url = handoffApi + (handoffApi.indexOf('?') >= 0 ? '&' : '?') + 'action=poll&t=' + encodeURIComponent(gpsToken);
    fetch(url, { credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (data) {
      if (data && data.ready) {
        if (gpsPoll) { clearInterval(gpsPoll); gpsPoll = null; }
        applyNativeCoords(data.lat, data.lng, data.accuracy);
      }
    }).catch(function () {});
  }

  function startSafariHandoff() {
    if (!handoffApi || !status.csrf) {
      locState.textContent = t('loc_ios');
      setHint(t('loc_safari_hint'));
      showEnable();
      showSafari('../gps-ask.php');
      return;
    }
    locState.textContent = t('loc_ios');
    setHint(t('loc_safari_hint'));
    showEnable();
    fetch(handoffApi, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify({ action: 'start', csrf: status.csrf || '' })
    }).then(function (r) { return r.json(); }).then(function (data) {
      if (!data || !data.ok || !data.url) {
        showSafari('../gps-ask.php');
        return;
      }
      gpsToken = data.token || '';
      var abs = data.url;
      try { abs = new URL(data.url, window.location.href).href; } catch (e) {}
      showSafari(abs);
      if (gpsPoll) clearInterval(gpsPoll);
      gpsPoll = setInterval(pollGpsToken, 2000);
      document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') pollGpsToken();
      });
    }).catch(function () {
      showSafari('../gps-ask.php');
    });
  }

  function fence() {
    return (status && status.fence) ? status.fence : { lat: 31.1774369, lng: 29.9892744, radius_m: 55, gps_slack_m: 50, max_accuracy_m: 120 };
  }

  function haversine(lat1, lng1, lat2, lng2) {
    var R = 6371000;
    var p1 = lat1 * Math.PI / 180;
    var p2 = lat2 * Math.PI / 180;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLng = (lng2 - lng1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(p1) * Math.cos(p2) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
    return Math.round(R * 2 * Math.asin(Math.min(1, Math.sqrt(a))) * 100) / 100;
  }

  function fmtDistance(m) {
    if (m == null || isNaN(m)) return '';
    if (m < 1000) return Math.round(m) + ' m';
    return (m / 1000).toFixed(2) + ' km';
  }

  function setHint(text) {
    if (!locHint) return;
    if (!text) {
      locHint.hidden = true;
      locHint.textContent = '';
      return;
    }
    locHint.hidden = false;
    locHint.textContent = text;
  }

  function showEnable() {
    if (!locEnable || geo.unsupported) {
      if (locEnable) locEnable.hidden = true;
      return;
    }
    locEnable.hidden = false;
    locEnable.disabled = false;
    locEnable.textContent = t('loc_enable');
  }

  function hideEnable() {
    if (locEnable) locEnable.hidden = true;
  }

  function nowUnix() {
    return serverNow + Math.floor((Date.now() - bootMs) / 1000);
  }

  function syncClock(next) {
    if (next && next.now) {
      serverNow = parseInt(next.now, 10) || serverNow;
      bootMs = Date.now();
    }
  }

  function checkoutOpen() {
    var until = parseInt(status.checkout_until, 10) || 0;
    if (!until) return false;
    return nowUnix() < until;
  }

  function fmtDay(iso) {
    if (!iso) return '';
    var p = String(iso).split('-');
    if (p.length !== 3) return iso;
    return p[2] + '/' + p[1] + '/' + p[0];
  }

  function clockLabel() {
    var d = new Date(nowUnix() * 1000);
    var h = d.getHours();
    var m = d.getMinutes();
    return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m;
  }

  function applyToday() {
    var today = (status && status.today) ? status.today : {};
    var hasIn = !!today.has_in;
    var hasOut = !!today.has_out;
    if (emptyEl) emptyEl.hidden = hasIn;
    if (recordedEl) recordedEl.hidden = !hasIn || hasOut;
    if (factsEl) factsEl.hidden = !hasOut;
    function set(sel, v) {
      var el = root.querySelector(sel);
      if (el) el.textContent = v || '—';
    }
    var recorded = [fmtDay(status.day), today.sign_in].filter(Boolean).join(' · ');
    set('[data-fact-recorded]', recorded || '—');
    set('[data-fact-in]', today.sign_in);
    set('[data-fact-out]', today.sign_out);
    set('[data-fact-delay]', today.delay);
    set('[data-fact-early]', today.early);
    set('[data-fact-worked]', today.worked);
  }

  function showMsg(text, kind) {
    if (!msgEl) return;
    if (!text) {
      msgEl.hidden = true;
      msgEl.textContent = '';
      msgEl.className = 'punch-msg';
      return;
    }
    msgEl.hidden = false;
    msgEl.textContent = text;
    msgEl.className = 'punch-msg' + (kind ? ' punch-msg--' + kind : '');
  }

  function updateLocUi() {
    var f = fence();
    locCard.classList.remove('is-on', 'is-in', 'is-out', 'is-bad');
    if (geo.unsupported) {
      locCard.classList.add('is-bad');
      locState.textContent = t('loc_unsupported');
      locMeta.textContent = '';
      setHint('');
      hideEnable();
      return;
    }
    if (geo.insecure || !isSecure()) {
      locCard.classList.add('is-bad');
      locState.textContent = t('loc_off');
      locMeta.textContent = '';
      setHint(t('loc_https'));
      showEnable();
      return;
    }
    if ((geo.asking || geo.checking) && !geo.precise) {
      locState.textContent = t('loc_checking');
      locMeta.textContent = (geo.on && geo.accuracy != null) ? ('±' + Math.round(geo.accuracy) + ' m') : '';
      setHint('');
      hideEnable();
      return;
    }
    if (geo.denied && !geo.on) {
      locCard.classList.add('is-bad');
      locState.textContent = t('loc_denied');
      locMeta.textContent = '';
      setHint(t('loc_timeout'));
      showEnable();
      return;
    }
    if (!geo.on) {
      locState.textContent = t('loc_off');
      locMeta.textContent = '';
      setHint('');
      showEnable();
      return;
    }
    hideEnable();
    hideSafari();
    setHint('');
    locCard.classList.add('is-on');
    locMeta.textContent = geo.accuracy != null ? ('±' + Math.round(geo.accuracy) + ' m') : '';
    if (!geo.accuracyOk || !geo.precise) {
      locCard.classList.add('is-bad');
      locState.textContent = t('loc_accuracy');
      if (!geo.checking) showEnable();
    } else if (geo.inside) {
      locCard.classList.add('is-in');
      locState.textContent = t('loc_inside');
    } else {
      locCard.classList.add('is-out');
      locState.textContent = (t('loc_away') || 'You are {d} away from school').replace('{d}', fmtDistance(geo.distance));
    }
  }

  function coordsPrecise(lat, lng, accuracy) {
    var f = fence();
    var dist = haversine(lat, lng, f.lat, f.lng);
    var slackCap = (f.gps_slack_m != null) ? f.gps_slack_m : 50;
    var slack = Math.min(Math.max(0, accuracy || 0), slackCap);
    var inside = dist <= f.radius_m || (dist - slack) <= f.radius_m;
    if (inside) return true;
    return accuracy != null && accuracy >= 0 && accuracy <= PRECISE_MAX_M;
  }

  function markPrecise() {
    geo.precise = true;
    geo.checking = false;
    clearPreciseTimer();
  }

  function startPreciseWait(seq) {
    clearPreciseTimer();
    preciseTimer = setTimeout(function () {
      if (seq !== geoSeq) return;
      geo.checking = false;
      if (!geo.precise && geo.on) {
        geo.precise = coordsPrecise(geo.lat, geo.lng, geo.accuracy);
      }
      updateLocUi();
      updateButtons();
    }, PRECISE_WAIT_MS);
  }

  function updateButtons() {
    var today = (status && status.today) ? status.today : {};
    var locReady = geo.on && geo.precise && geo.accuracyOk && geo.inside && !geo.checking;
    var canIn = !today.has_in && !today.on_vacation;
    var canOut = today.has_in && !today.has_out && checkoutOpen();
    var closed = !!(today.has_in && !today.has_out && !checkoutOpen());
    if (closedEl) closedEl.hidden = !closed;
    if (!punchBtn) return;
    punchBtn.classList.remove('is-lit');
    if (canOut) {
      punchBtn.hidden = false;
      punchBtn.disabled = busy || !locReady;
      punchBtn.textContent = t('checkout_btn');
      punchBtn.classList.add('punch-btn--out');
      punchBtn.classList.remove('btn--gold');
      punchBtn.setAttribute('data-mode', 'out');
      if (locReady && !busy) punchBtn.classList.add('is-lit');
    } else if (canIn) {
      punchBtn.hidden = false;
      punchBtn.disabled = busy || !locReady;
      punchBtn.textContent = t('checkin_btn');
      punchBtn.classList.remove('punch-btn--out');
      punchBtn.classList.add('btn--gold');
      punchBtn.setAttribute('data-mode', 'in');
      if (locReady && !busy) punchBtn.classList.add('is-lit');
    } else {
      punchBtn.hidden = true;
      punchBtn.disabled = true;
      punchBtn.removeAttribute('data-mode');
    }
  }

  function betterFix(pos) {
    if (!pos || !pos.coords) return false;
    var nextAcc = pos.coords.accuracy;
    if (geo.lat == null) return true;
    if (nextAcc == null) return false;
    if (geo.accuracy == null) return true;
    return nextAcc + 2 < geo.accuracy;
  }

  function onPosition(pos) {
    if (!pos || !pos.coords) return;
    var nextPrecise = coordsPrecise(pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy);
    if (geo.precise && geo.lat != null && !betterFix(pos) && !nextPrecise) {
      return;
    }
    if (!geo.precise && geo.lat != null && !betterFix(pos) && !nextPrecise) {
      startWatch();
      return;
    }
    var f = fence();
    geo.asking = false;
    geo.on = true;
    geo.denied = false;
    geo.insecure = false;
    geo.lat = pos.coords.latitude;
    geo.lng = pos.coords.longitude;
    geo.accuracy = pos.coords.accuracy;
    geo.distance = haversine(geo.lat, geo.lng, f.lat, f.lng);
    var slackCap = (f.gps_slack_m != null) ? f.gps_slack_m : 50;
    var slack = Math.min(Math.max(0, geo.accuracy || 0), slackCap);
    geo.inside = geo.distance <= f.radius_m || (geo.distance - slack) <= f.radius_m;
    geo.accuracyOk = geo.inside || (geo.accuracy != null && geo.accuracy >= 0 && geo.accuracy <= f.max_accuracy_m);
    if (nextPrecise) {
      markPrecise();
    } else {
      geo.precise = false;
      geo.checking = true;
      startPreciseWait(geoSeq);
    }
    clearGeoTimer();
    updateLocUi();
    updateButtons();
    startWatch();
  }

  function onError(err, fromWatch, high) {
    if (geo.on && fromWatch) {
      return;
    }
    var code = err && typeof err.code === 'number' ? err.code : 0;
    var denied = !!(err && (code === 1 || err.code === err.PERMISSION_DENIED));
    if (!denied && high && !isIOS()) {
      requestPosition(false, geoSeq);
      return;
    }
    clearGeoTimer();
    clearPreciseTimer();
    geo.asking = false;
    geo.checking = false;
    geo.precise = false;
    geo.on = false;
    if (!isSecure()) {
      geo.insecure = true;
      geo.denied = false;
    } else {
      geo.denied = denied;
    }
    if (!denied) {
      setHint(t('loc_timeout'));
    }
    updateLocUi();
    updateButtons();
  }

  function clearGeoTimer() {
    if (geoTimer) {
      clearTimeout(geoTimer);
      geoTimer = null;
    }
  }

  function clearPreciseTimer() {
    if (preciseTimer) {
      clearTimeout(preciseTimer);
      preciseTimer = null;
    }
  }

  function stopGeo() {
    if (watchId != null && navigator.geolocation && navigator.geolocation.clearWatch) {
      try { navigator.geolocation.clearWatch(watchId); } catch (e) {}
    }
    watchId = null;
    watchStarted = false;
  }

  function geoOptions(high, withTimeout) {
    var opts = {
      enableHighAccuracy: !!high,
      maximumAge: high ? 0 : 20000
    };
    if (withTimeout) {
      opts.timeout = high ? 20000 : 12000;
    }
    return opts;
  }

  function requestPosition(high, seq) {
    if (seq !== geoSeq) return;
    if (!navigator.geolocation || typeof navigator.geolocation.getCurrentPosition !== 'function') {
      geo.unsupported = true;
      geo.asking = false;
      updateLocUi();
      updateButtons();
      return;
    }
    var opts = geoOptions(high, false);
    try {
      navigator.geolocation.getCurrentPosition(
        function (pos) {
          if (seq !== geoSeq) return;
          onPosition(pos);
        },
        function (err) {
          if (seq !== geoSeq) return;
          onError(err, false, high);
        },
        opts
      );
    } catch (e) {
      if (seq !== geoSeq) return;
      onError({ code: 1, message: String(e) }, false, high);
    }
  }

  function startWatch() {
    if (watchStarted || !navigator.geolocation || typeof navigator.geolocation.watchPosition !== 'function') {
      return;
    }
    watchStarted = true;
    try {
      watchId = navigator.geolocation.watchPosition(
        function (pos) {
          onPosition(pos);
        },
        function (err) {
          onError(err, true, true);
        },
        { enableHighAccuracy: true, maximumAge: 3000 }
      );
    } catch (e) {
      watchStarted = false;
    }
  }

  function startGeo(silent) {
    if (!navigator.geolocation) {
      geo.unsupported = true;
      updateLocUi();
      updateButtons();
      return;
    }
    if (!isSecure()) {
      geo.insecure = true;
      geo.on = false;
      updateLocUi();
      updateButtons();
      return;
    }
    stopGeo();
    clearGeoTimer();
    clearPreciseTimer();
    geoSeq += 1;
    var seq = geoSeq;
    geo.asking = !silent;
    geo.checking = true;
    geo.precise = false;
    geo.denied = false;
    geo.insecure = false;
    geo.on = false;
    geo.lat = null;
    geo.lng = null;
    geo.accuracy = null;
    geo.distance = null;
    geo.inside = false;
    geo.accuracyOk = false;

    if (isInAppIOS()) {
      geo.checking = false;
      updateLocUi();
      if (!silent) startSafariHandoff();
      return;
    }

    var opts = isIOS()
      ? { enableHighAccuracy: true, timeout: isInAppIOS() ? 8000 : 60000 }
      : { enableHighAccuracy: true, timeout: 25000, maximumAge: 0 };
    try {
      navigator.geolocation.getCurrentPosition(
        function (pos) {
          if (seq !== geoSeq) return;
          onPosition(pos);
        },
        function (err) {
          if (seq !== geoSeq) return;
          onError(err, false, !isIOS());
        },
        opts
      );
    } catch (e) {
      onError({ code: 1, message: String(e) }, false, false);
    }

    updateLocUi();

    if (isIOS()) {
      if (isInAppIOS()) return;
      geoTimer = setTimeout(function () {
        if (seq !== geoSeq || geo.on) return;
        geo.asking = false;
        locCard.classList.add('is-bad');
        locState.textContent = t('loc_ios');
        locMeta.textContent = '';
        setHint(t('loc_safari_hint'));
        showEnable();
        startSafariHandoff();
        updateButtons();
      }, 8000);
      return;
    }
    geoTimer = setTimeout(function () {
      if (seq !== geoSeq || geo.on) return;
      requestPosition(false, seq);
      geoTimer = setTimeout(function () {
        if (seq !== geoSeq || geo.on) return;
        geo.asking = false;
        geo.checking = false;
        locCard.classList.add('is-bad');
        locState.textContent = t('loc_timeout');
        locMeta.textContent = '';
        setHint(t('loc_timeout'));
        showEnable();
        updateButtons();
      }, 12000);
    }, 8000);
  }

  function punch(action) {
    if (busy) return;
    if (action === 'out' && !checkoutOpen()) {
      updateButtons();
      showMsg(t('checkout_closed'), 'bad');
      return;
    }
    busy = true;
    showMsg(t('punch_wait'), 'wait');
    updateButtons();
    var payload = {
      action: action,
      csrf: status.csrf || '',
      lat: geo.lat,
      lng: geo.lng,
      accuracy: geo.accuracy
    };
    fetch(api, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify(payload)
    }).then(function (res) {
      return res.json().then(function (data) {
        return { res: res, data: data };
      });
    }).then(function (pack) {
      busy = false;
      var data = pack.data || {};
      if (data.csrf) status.csrf = data.csrf;
      if (data.ok && data.today) {
        status = data;
        syncClock(data);
        applyToday();
        showMsg('', '');
      } else {
        var code = data.error || 'err_generic';
        if (code === 'preview_only' || code === 'err_preview') {
          status.today = status.today || {};
          if (action === 'in') {
            status.today.has_in = true;
            status.today.has_out = false;
            status.today.sign_in = status.today.sign_in || clockLabel();
            status.can_check_out = checkoutOpen();
            status.checkout_closed = !checkoutOpen();
          } else if (action === 'out' && checkoutOpen()) {
            status.today.has_out = true;
            status.today.sign_out = status.today.sign_out || clockLabel();
            status.can_check_out = false;
            status.checkout_closed = false;
          }
          applyToday();
        }
        showMsg(t(code) || t('err_generic'), 'bad');
        if (data.today) {
          status.today = data.today;
          if (data.checkout_until) status.checkout_until = data.checkout_until;
          if (typeof data.can_check_out !== 'undefined') status.can_check_out = data.can_check_out;
          if (typeof data.checkout_closed !== 'undefined') status.checkout_closed = data.checkout_closed;
          applyToday();
        }
        syncClock(data);
      }
      updateButtons();
    }).catch(function () {
      busy = false;
      showMsg(t('err_generic'), 'bad');
      updateButtons();
    });
  }

  function bootLocation() {
    if (!navigator.geolocation) {
      geo.unsupported = true;
      updateLocUi();
      updateButtons();
      return;
    }
    if (!isSecure()) {
      geo.insecure = true;
      updateLocUi();
      updateButtons();
      return;
    }
    if (isInAppIOS()) {
      updateLocUi();
      updateButtons();
      return;
    }
    startGeo(true);
    if (navigator.permissions && navigator.permissions.query) {
      navigator.permissions.query({ name: 'geolocation' }).then(function (perm) {
        perm.onchange = function () {
          if (perm.state === 'granted' && !geo.on && !geo.checking) startGeo(true);
          if (perm.state === 'denied') {
            stopGeo();
            clearPreciseTimer();
            geo.on = false;
            geo.denied = true;
            geo.asking = false;
            geo.checking = false;
            geo.precise = false;
            updateLocUi();
            updateButtons();
          }
        };
      }).catch(function () {});
    }
  }

  var lastTap = 0;
  function onEnableTap(e) {
    if (e) {
      if (e.preventDefault) e.preventDefault();
      if (e.stopPropagation) e.stopPropagation();
    }
    var now = Date.now();
    if (now - lastTap < 700) return;
    lastTap = now;
    startGeo(false);
  }
  if (locEnable) {
    locEnable.addEventListener('touchend', onEnableTap, false);
    locEnable.addEventListener('click', onEnableTap, false);
  }
  if (locSafari) {
    locSafari.addEventListener('click', function (e) {
      var href = locSafari.getAttribute('href');
      if (!href || href === '#') {
        if (e.preventDefault) e.preventDefault();
        startSafariHandoff();
        return;
      }
      if (navigator.share) {
        e.preventDefault();
        navigator.share({ title: 'Helalia', url: locSafari.href }).catch(function () {
          window.open(locSafari.href, '_blank');
        });
      }
    });
  }
  if (punchBtn) {
    punchBtn.addEventListener('click', function () {
      punch(punchBtn.getAttribute('data-mode') === 'out' ? 'out' : 'in');
    });
  }

  applyToday();
  updateLocUi();
  updateButtons();
  bootLocation();
  setInterval(updateButtons, 15000);
})();
