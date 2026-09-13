<?php require_once('Connections/database.php');
      include("includes/functions_eng.php");
      include_once("emp/includes/dual-entry.php"); 
      $wrong = 0;

// Keep device id from the app open URL
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $_SESSION['phone_id'] = escape($_GET['id']);
}
 
//redirect is session is set
if (isset($_SESSION['MM_Username']) && isset($_SESSION['MM_Userid']) && isset($_SESSION['account_type'])) {
    dual_entry_redirect_if_dual_staff(
        isset($row_get_user['phone']) ? $row_get_user['phone'] : $_SESSION['MM_Username'],
        $_SESSION['account_type'],
        switch_lang($row_get_user['languages'])
    );
    header("location: ".account_type_folder($_SESSION['account_type'])."/".switch_lang($row_get_user['languages'])."/".account_type_url($_SESSION['account_type']));
    exit;
}
 


if (isset($_POST['phone'])) { 
    $loginUsername = escape($_POST['phone']);
    $password      = escape(md5(strtolower($_POST['password'])));  

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
        //declare two session variables and assign them
        $_SESSION['MM_Username']   = $loginUsername;
        $_SESSION['MM_Userid']     = $row['id'];
        $_SESSION['account_type']  = $row['account_type'];  
        language_update($row['id'],$lang);

        // Always keep the user logged in when they reopen the app (1 year).
        setcookie("helu", $loginUsername, time() + (86400 * 365), "/");
        setcookie("help", $password, time() + (86400 * 365), "/");
        
        // One device per account: bind on first login; block other devices after that.
        $boundId = isset($row['phone_id']) ? trim((string) $row['phone_id']) : '';
        $deviceId = (isset($_SESSION['phone_id']) && $_SESSION['phone_id'] !== null)
            ? trim((string) $_SESSION['phone_id'])
            : '';
        if ($boundId !== '' && $deviceId !== '' && $boundId !== $deviceId) {
            unset($_SESSION['MM_Username']);
            unset($_SESSION['MM_Userid']);
            unset($_SESSION['account_type']);
            setcookie("helu", "", time() - (86400 * 400), "/");
            setcookie("help", "", time() - (86400 * 400), "/");
            header("Location:  login-".$lang_dir.".php?linked");
            exit();
        }
        if ($deviceId !== '' && $boundId === '') {
            phone_id_update($deviceId, $row['id']);
        }
        dual_entry_redirect_if_dual_staff($loginUsername, $row['account_type'], $lang_dir);
        header("Location: ".account_type_folder($row['account_type'])."/".$lang_dir."/".account_type_url($row['account_type']));
        exit();

 
    } else {
       $wrong = 1; 
    }
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title>Helalia : Login</title>
<link rel="icon" href="parent/assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="parent/assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="parent/assets/css/helalia.css">
</head>
<body>
<div class="app app--auth"><div class="auth">
    <div class="auth__hero">
      <img class="auth__hero-img" src="parent/assets/img/bg-school.jpg" alt="Helalia Language School">
    </div>
    <div class="between">
      <a class="back" href="index.php?id=<?php echo $_SESSION['phone_id'];?>" aria-label="Back"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg></a>
      <a class="lang lang--onnavy" href="login-arb.php?id=<?php echo $_SESSION['phone_id'];?>" hreflang="ar">العربية</a>
    </div>
    <div class="auth__brand">
      <img class="auth__logo" src="parent/assets/img/logo.png" alt="Helalia Language School">
      <h1 class="auth__name">Helalia Language School</h1>
      <p class="auth__tag">Login</p>
    </div> 
    <form class="auth__form" method="post" autocomplete="on" action="login-eng.php?id=<?php echo $_SESSION['phone_id'];?>">
      <input type="hidden" name="lang" value="eng"> 
      <label class="field"><span class="field__label">Phone</span><input class="input" id="phone" name="phone" type="tel" placeholder="01xxxxxxxxx" required></label>
      <label class="field"><span class="field__label">Password</span><input class="input" id="password" name="password" type="password" placeholder="••••••••" required></label>
      <div class="checkline">
        <label class="checkline__box"><input type="checkbox" name="remember" value="1" checked> Remember</label>
        <a class="auth__link" href="forgot-eng.php">Forgot Password</a>
      </div>
      <button class="btn btn--gold" type="submit">Login</button> 
       <br><br>
       <a class="btn btn--ghost" href="register-eng.php">Ask for Account</a>
    </form> 
    </div>
  </div> 



<?php if ($wrong == 1 || isset($_GET['linked'])) { ?> 
     <style>
      .hl-modal{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
        justify-content:center;padding:20px;background:rgba(17,44,90,.55);
        -webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px);
        opacity:0;transition:opacity .25s ease}
      .hl-modal.is-open{opacity:1}
      .hl-modal__box{width:100%;max-width:340px;background:#fff;border-radius:18px;
        padding:32px 24px;text-align:center;box-shadow:0 20px 50px rgba(0,0,0,.25);
        transform:scale(.9);transition:transform .25s cubic-bezier(.34,1.56,.64,1)}
      .hl-modal.is-open .hl-modal__box{transform:scale(1)}
      .hl-modal__icon{width:64px;height:64px;margin:0 auto 16px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        background:#fdecec;color:#d93025}
      .hl-modal__icon svg{width:34px;height:34px}
      .hl-modal__text{margin:0;font-size:19px;font-weight:700;color:#112c5a;
        font-family:'Plus Jakarta Sans',system-ui,sans-serif}
      @media (prefers-reduced-motion:reduce){
        .hl-modal,.hl-modal__box{transition:none}
      }
    </style> 
 <?php } ?>



  <?php if ($wrong == 1) { ?>   
    <div class="hl-modal" id="wrong-password" role="alertdialog" aria-live="assertive" aria-label="Login error">
      <div class="hl-modal__box">
        <div class="hl-modal__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </div>
        <p class="hl-modal__text">Wrong phone number or password</p>
      </div>
    </div>

     <script>
      (function () {
        var m = document.getElementById('wrong-password');
        if (!m) return;  

        function close() {
          m.classList.remove('is-open');
          setTimeout(function () { m.style.display = 'none'; }, 250);
        }

        requestAnimationFrame(function () { m.classList.add('is-open'); });

        setTimeout(close, 3000);
        m.addEventListener('click', close);
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') close();
        });
      })();
    </script>

  <?php }   if (isset($_GET['linked'])) { ?>  

    <div class="hl-modal" id="phone-linked" role="alertdialog" aria-live="assertive" aria-label="Device notice">
      <div class="hl-modal__box">
        <div class="hl-modal__icon hl-modal__icon--warn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="6" y="2" width="12" height="20" rx="2.5"/>
            <line x1="10.5" y1="18.5" x2="13.5" y2="18.5"/>
          </svg>
        </div>
        <p class="hl-modal__text">This account is linked to another device</p>
      </div>
    </div>

    <script>
      (function () {
        var m = document.getElementById('phone-linked');
        if (!m) return;   

        function close() {
          m.classList.remove('is-open');
          setTimeout(function () { m.style.display = 'none'; }, 250);
        }

        requestAnimationFrame(function () { m.classList.add('is-open'); });

        setTimeout(close, 3000);
        m.addEventListener('click', close);
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') close();
        });
      })();
    </script>

<?php } ?>



    <script>
        var phone = document.getElementById('phone');
        phone.addEventListener('input', function () {
          this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });
        phone.addEventListener('keypress', function (e) {
          if (e.key.length === 1 && /\D/.test(e.key)) e.preventDefault();
        });    
    </script>
</body>
</html> 