<?php
require_once __DIR__ . '/includes/gps-handoff-lib.php';
$token = isset($_GET['t']) ? (string) $_GET['t'] : '';
$arb = (isset($_GET['lang']) && $_GET['lang'] === 'arb');
$row = gps_pending_read($token);
$ok = (bool) $row;
$title = $arb ? 'موقع هلاليه' : 'Helalia location';
$ask = $arb ? 'طلب الموقع' : 'Ask for location';
$wait = $arb ? 'Safari سيطلب السماح. اضغط Allow ثم ارجع لتطبيق Helalia.' : 'Safari will ask Allow. Tap Allow, then return to the Helalia app.';
$done = $arb ? 'تم. ارجع لتطبيق Helalia.' : 'Done. Return to the Helalia app.';
$fail = $arb ? 'تعذر قراءة الموقع. فعّل الموقع لـ Safari من الإعدادات ثم أعد المحاولة.' : 'Could not read location. Allow Location for Safari in Settings, then try again.';
$missing = $arb ? 'انتهت صلاحية الرابط. ارجع للتطبيق واضغط تفعيل الموقع.' : 'This link expired. Return to the app and tap Enable location.';
?>
<!DOCTYPE html>
<html lang="<?php echo $arb ? 'ar' : 'en'; ?>" dir="<?php echo $arb ? 'rtl' : 'ltr'; ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  body { margin:0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:#112c5a; color:#fff; }
  .wrap { min-height:100vh; display:flex; flex-direction:column; justify-content:center; padding:28px 22px; box-sizing:border-box; }
  h1 { font-size:22px; margin:0 0 12px; }
  p { opacity:.9; line-height:1.45; }
  button { margin-top:22px; border:0; border-radius:14px; background:#eed484; color:#112c5a; font-weight:800; font-size:18px; padding:16px 18px; }
  .msg { margin-top:16px; min-height:1.4em; }
</style>
</head>
<body>
<main class="wrap">
  <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
<?php if (!$ok) { ?>
  <p><?php echo htmlspecialchars($missing, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } else { ?>
  <p><?php echo htmlspecialchars($wait, ENT_QUOTES, 'UTF-8'); ?></p>
  <button type="button" id="go"><?php echo htmlspecialchars($ask, ENT_QUOTES, 'UTF-8'); ?></button>
  <p class="msg" id="msg"></p>
  <script>
    var token = <?php echo json_encode($token); ?>;
    var fail = <?php echo json_encode($fail); ?>;
    var done = <?php echo json_encode($done); ?>;
    var btn = document.getElementById('go');
    var msg = document.getElementById('msg');
    function save(pos) {
      fetch('api/gps-handoff.php?action=save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          token: token,
          lat: pos.coords.latitude,
          lng: pos.coords.longitude,
          accuracy: pos.coords.accuracy
        })
      }).then(function (r) { return r.json(); }).then(function (data) {
        msg.textContent = data && data.ok ? done : fail;
      }).catch(function () { msg.textContent = fail; });
    }
    btn.addEventListener('click', function () {
      msg.textContent = '';
      if (!navigator.geolocation) { msg.textContent = fail; return; }
      navigator.geolocation.getCurrentPosition(save, function () { msg.textContent = fail; }, {
        enableHighAccuracy: true,
        timeout: 60000
      });
    });
  </script>
<?php } ?>
</main>
</body>
</html>
