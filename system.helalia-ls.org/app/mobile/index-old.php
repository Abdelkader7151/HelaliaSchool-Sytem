<?php require_once('Connections/database.php');
      include("includes/functions.php");
      include_once("emp/includes/dual-entry.php");

    $phone_id = NULL;
    $_SESSION['phone_id'] = NULL;


if(isset($_GET['id']) && $_GET['id']!=NULL){ 
    $phone_id = escape($_GET['id']);
    $_SESSION['phone_id'] = $phone_id;
} 


//swtich if user loged
if (isset($_SESSION['MM_Username'])) {
    dual_entry_redirect_if_dual_staff(
        isset($row_get_user['phone']) ? $row_get_user['phone'] : $_SESSION['MM_Username'],
        isset($_SESSION['account_type']) ? $_SESSION['account_type'] : (isset($row_get_user['account_type']) ? $row_get_user['account_type'] : 0),
        switch_lang($row_get_user['languages'])
    );
    header("location: ".account_type_folder($row_get_user['account_type'])."/".switch_lang($row_get_user['languages'])."/".account_type_url($row_get_user['account_type']));
    exit;
}


//if remember active
if (isset($_COOKIE['helu']) && isset($_COOKIE['help'])) {
    $loginUsername = escape($_COOKIE['helu']);
    $password = escape($_COOKIE['help']);  

    $LoginRS__query = sprintf(
        "SELECT `phone`, `password`, `id`, `account_type`, `languages`, `phone_id` FROM `app_login` WHERE `phone`=%s AND `password`=%s",
          GetSQLValueString($database, $loginUsername, "text"),
          GetSQLValueString($database,$password, "text")
      );

    $LoginRS = mysqli_query($database, $LoginRS__query) or die(mysqli_error($database));
    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser) { 
        $row = mysqli_fetch_assoc($LoginRS);    
        session_regenerate_id(true); 
        //declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_Userid'] = $row['id'];
        $_SESSION['account_type'] = $row['account_type'];

        
        if($row['phone_id']!=null && $phone_id!=null && $row['phone_id']!=$phone_id){
            unset($_SESSION['MM_Username']); 
            unset($_SESSION['MM_Userid']);	 
            unset($_SESSION['account_type']); 
            setcookie("helu", "", time() - (86400 * 400), "/");  
            setcookie("help", "", time() - (86400 * 400), "/");
            header("Location:  login-".switch_lang($row['languages']).".php?linked");
            exit();
        }else{
           if ($phone_id != null && $row['phone_id']==null) { 
                phone_id_update($phone_id, $row['id']);
             } 
            dual_entry_redirect_if_dual_staff($loginUsername, $row['account_type'], switch_lang($row['languages']));
            header("Location: ".account_type_folder($row['account_type'])."/".switch_lang($row['languages'])."/".account_type_url($row['account_type']));
            exit();
        } 
        
    }
}   

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
</head>
<body>
<div class="app app--splash">
  <main class="splash">
    <div class="splash__brand">
      <img class="splash__logo" src="parent/assets/img/logo.png" alt="Helalia Language School">
    </div>
    <nav class="splash__langs" aria-label="Language">
      <a class="splash__lang splash__lang--gold" href="login-eng.php?id=<?php echo htmlspecialchars((string) $phone_id); ?>">
        <span class="splash__lang-code">EN</span>
        <span>
          <b>English</b>
          <small>Continue</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">›</span>
      </a>
      <a class="splash__lang" href="login-arb.php?id=<?php echo htmlspecialchars((string) $phone_id); ?>" lang="ar" dir="rtl">
        <span class="splash__lang-code">ع</span>
        <span>
          <b>العربية</b>
          <small>متابعة</small>
        </span>
        <span class="splash__lang-go" aria-hidden="true">›</span>
      </a>
    </nav>
    <p class="splash__copy" style="text-align:center">© <?php echo date('Y'); ?> <span>Helalia</span>
    <br>
    <?php if ($phone_id == NULL) { ?>
    <p style="color:red;clear:both; padding-bottom:10px; font-size:10px">Error Restart the Application</p>
    <?php } ?>
    <br>
     <img src="parent/assets/img/ascendra-logo-white.png" width="100px" />
     </p>
  </main>
</div>
</body>
</html>
