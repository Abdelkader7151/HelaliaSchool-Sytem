<?php require_once('Connections/database.php'); 
      include("includes/functions.php");
      include_once("includes/auth-persist.php");
      include_once("includes/device-lock.php");
      include_once("emp/includes/dual-entry.php");

$phone_id = NULL;
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $phone_id = escape($_GET['id']);
    $_SESSION['phone_id'] = $phone_id;
} elseif (!empty($_SESSION['phone_id'])) {
    $phone_id = $_SESSION['phone_id'];
}

/**
 * Keep user logged in on reopen: session first, then Remember cookies.
 * Device lock: shof device-lock.php (HELALIA_DEVICE_LOCK).
 */
function helalia_splash_enter_app($database, $loginUsername, $row, $phone_id)
{
    if (helalia_device_login_check($row, $phone_id) === 'linked') {
        helalia_clear_login_session();
        helalia_clear_auth_cookies();
        $langDir = switch_lang($row['languages']);
        $deviceId = ($phone_id !== null && $phone_id !== '') ? trim((string) $phone_id) : '';
        header('Location: login-' . $langDir . '.php?linked&id=' . rawurlencode($deviceId));
        exit();
    }

    // Refresh long-lived auth cookies on every successful open.
    if (function_exists('helalia_set_auth_cookies') && !empty($row['password'])) {
        helalia_set_auth_cookies($loginUsername, $row['password']);
    }

    $langDir = switch_lang($row['languages']);
    dual_entry_redirect_if_dual_staff($loginUsername, $row['account_type'], $langDir);
    header(
        "Location: " . account_type_folder($row['account_type']) . "/" . $langDir . "/" . account_type_url($row['account_type'])
    );
    exit();
}

$splashClearClientAuth = false;

// Stale sessions/cookies from before school-wide logout (any phone OS).
if (!helalia_auth_epoch_ok() && (!empty($_SESSION['MM_Username']) || !empty($_COOKIE['helu']) || !empty($_COOKIE['help']))) {
    helalia_clear_login_session();
    helalia_clear_auth_cookies();
    $splashClearClientAuth = true;
}

// Already logged in (same app session) — stay in
if (!$splashClearClientAuth && isset($_SESSION['MM_Username'], $_SESSION['MM_Userid'], $_SESSION['account_type']) && helalia_auth_epoch_ok()) {
    $uid = (int) $_SESSION['MM_Userid'];
    $q = mysqli_query(
        $database,
        "SELECT `phone`, `password`, `id`, `account_type`, `languages`, `phone_id` FROM `app_login` WHERE `id`={$uid} LIMIT 1"
    );
    $row = ($q && mysqli_num_rows($q)) ? mysqli_fetch_assoc($q) : null;
    if ($row) {
        $_SESSION['MM_Username'] = $row['phone'];
        $_SESSION['account_type'] = $row['account_type'];
        helalia_splash_enter_app($database, $row['phone'], $row, $phone_id);
    }
    unset($_SESSION['MM_Username'], $_SESSION['MM_Userid'], $_SESSION['account_type']);
}

// Remember cookies — stay logged in after app restart (Android + iPhone)
if (!$splashClearClientAuth && isset($_COOKIE['helu'], $_COOKIE['help']) && helalia_auth_epoch_ok()) {
    $loginUsername = escape(helalia_normalize_login_phone($_COOKIE['helu']));
    $password = escape($_COOKIE['help']);

    $LoginRS__query = sprintf(
        "SELECT `phone`, `password`, `id`, `account_type`, `languages`, `phone_id` FROM `app_login` WHERE `phone`=%s AND `password`=%s",
        GetSQLValueString($database, $loginUsername, "text"),
        GetSQLValueString($database, $password, "text")
    );

    $LoginRS = mysqli_query($database, $LoginRS__query) or die(mysqli_error($database));
    if (mysqli_num_rows($LoginRS)) {
        $row = mysqli_fetch_assoc($LoginRS);
        session_regenerate_id(true);
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_Userid'] = $row['id'];
        $_SESSION['account_type'] = $row['account_type'];
        helalia_splash_enter_app($database, $loginUsername, $row, $phone_id);
    }
    // Bad/stale cookies — force login screen on every OS
    helalia_clear_auth_cookies();
    $splashClearClientAuth = true;
}

$splashIdQs = htmlspecialchars((string) $phone_id, ENT_QUOTES, 'UTF-8');
$authEpochJs = json_encode(helalia_auth_epoch(), JSON_UNESCAPED_UNICODE);

?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<title>Helalia</title>
<link rel="icon" href="parent/assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="parent/assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Cairo:wght@600;700;800&display=swap">
<link rel="stylesheet" href="parent/assets/css/helalia.css">
<script>
/* Clear stale auth after school-wide logout; restore only matching epoch (iPhone + Android). */
(function () {
  var epoch = <?php echo $authEpochJs; ?>;
  var forceClear = <?php echo $splashClearClientAuth ? 'true' : 'false'; ?>;
  try {
    var storedV = localStorage.getItem('helalia_helv');
    if (forceClear || (storedV && storedV !== epoch)) {
      localStorage.removeItem('helalia_helu');
      localStorage.removeItem('helalia_help');
      localStorage.removeItem('helalia_helv');
    }
  } catch (e) {}
  try {
    if (forceClear) return;
    if (document.cookie.indexOf('helu=') !== -1 && document.cookie.indexOf('help=') !== -1 && document.cookie.indexOf('helv=') !== -1) return;
    var u = localStorage.getItem('helalia_helu');
    var p = localStorage.getItem('helalia_help');
    var v = localStorage.getItem('helalia_helv');
    if (!u || !p || !v || v !== epoch) return;
    var maxAge = 60 * 60 * 24 * 365;
    var secure = location.protocol === 'https:' ? ';Secure' : '';
    document.cookie = 'helu=' + encodeURIComponent(u) + ';path=/;max-age=' + maxAge + ';SameSite=Lax' + secure;
    document.cookie = 'help=' + encodeURIComponent(p) + ';path=/;max-age=' + maxAge + ';SameSite=Lax' + secure;
    document.cookie = 'helv=' + encodeURIComponent(v) + ';path=/;max-age=' + maxAge + ';SameSite=Lax' + secure;
    location.replace(location.pathname + location.search);
  } catch (e) {}
})();
</script>
</head>
<body>
<div class="app app--splash">
  <main class="splash">
    <div class="splash__brand">
      <img class="splash__logo" src="parent/assets/img/logo.png" alt="Helalia Language School">
    </div>
    <nav class="splash__langs" aria-label="Language">
      <a class="splash__lang splash__lang--gold" href="login-eng.php?id=<?php echo $splashIdQs; ?>">
        <span class="splash__lang-code">EN</span>
        <span>
          <b>English</b>
          <small>Continue</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">›</span>
      </a>
      <a class="splash__lang" href="login-arb.php?id=<?php echo $splashIdQs; ?>" lang="ar" dir="rtl">
        <span class="splash__lang-code">ع</span>
        <span>
          <b>العربية</b>
          <small>متابعة</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">‹</span>
      </a>
    </nav>
    <p class="splash__copy" style="text-align:center">© <?php echo date('Y'); ?> <span>Helalia</span>
    <br>
    <br>
     <img src='parent\assets\img\ascendra-logo-white.png' width='100px' />
     </p>
  </main>
</div>
</body>
</html>
