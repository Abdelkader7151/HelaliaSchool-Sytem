<?php require_once('Connections/database.php');
include("includes/functions.php");

if(isset($_GET['id']) && $_GET['id']!=NULL){
    $_SESSION['phone_id'] = $_GET['id']; 
}

if (isset($_SESSION['MM_Username']) && isset($_SESSION['MM_Userid']) && isset($_SESSION['account_type'])) {
    header("location: ".account_type_folder($_SESSION['account_type'])."/".switch_lang($row_get_user['languages'])."/".account_type_url($_SESSION['account_type']));
    exit;
}

if (isset($_COOKIE['helu']) && isset($_COOKIE['help'])) {
    $loginUsername = $_COOKIE['helu'];
    $password = $_COOKIE['help'];
    mysqli_select_db($database, $database_database);

    $LoginRS__query = sprintf(
        "SELECT `phone`, `password`, `id`, `account_type`, `languages`, `phone_id` FROM `app_login` WHERE `phone`=%s AND `password`=%s",
        GetSQLValueString($database, $loginUsername, "text"),
        GetSQLValueString($database, $password, "text")
    );

    $LoginRS = mysqli_query($database, $LoginRS__query) or die(mysqli_error($database));
    $loginFoundUser = mysqli_num_rows($LoginRS);
    if ($loginFoundUser) {
        $row = mysqli_fetch_assoc($LoginRS);
        session_regenerate_id(true);
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_Userid'] = $row['id'];
        $_SESSION['account_type'] = $row['account_type'];

        if (isset($_SESSION['phone_id']) && $_SESSION['phone_id'] != NULL) {
            phone_id_update($_SESSION['phone_id'], $row['id']);
        }

        header("Location: ".account_type_folder($row['account_type'])."/".switch_lang($row['languages'])."/".account_type_url($row['account_type']));
        exit();
    }
}

$pid = isset($_SESSION['phone_id']) ? $_SESSION['phone_id'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<title>Helalia</title>
<link rel="icon" href="parent/assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="parent/assets/img/logo-icon.png">
<link rel="stylesheet" href="parent/assets/css/helalia.css">
</head>
<body>
<div class="app app--splash">
  <main class="splash">
    <div class="splash__brand">
      <img class="splash__logo" src="parent/assets/img/logo.png" alt="Helalia Language School">
    </div>
    <nav class="splash__langs" aria-label="Language">
      <a class="splash__lang splash__lang--gold" href="login-eng.php?id=<?php echo htmlspecialchars((string) $pid); ?>">
        <span class="splash__lang-code">EN</span>
        <span>
          <b>English</b>
          <small>Continue</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">›</span>
      </a>
      <a class="splash__lang" href="login-arb.php?id=<?php echo htmlspecialchars((string) $pid); ?>" lang="ar" dir="rtl">
        <span class="splash__lang-code">ع</span>
        <span>
          <b>العربية</b>
          <small>متابعة</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">‹</span>
      </a>
    </nav>
    <p class="splash__copy">© <?php echo date('Y'); ?> <span>Helalia</span></p>
  </main>
</div>
</body>
</html>
