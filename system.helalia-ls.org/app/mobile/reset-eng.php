<?php require_once('Connections/database.php');
      include("includes/functions.php");

  

if(isset($_POST['submit'])){  
    $updateSQL = sprintf("UPDATE `app_login` SET `password`=%s, `reset`=%s WHERE `reset`=%s  ",  
                      GetSQLValueString($database ,md5($_POST['password']), "text"),
                      GetSQLValueString($database ,'', "text"),
                      GetSQLValueString($database ,$_GET['code'], "text")); 

   $Result1 = mysqli_query($database , $updateSQL) or die(mysqli_error($database)); 
   header("location: login-eng.php?id=".$_SESSION['phone_id']);
   exit();
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
<title>Helalia : Forgot Password</title>
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
      <a class="back" href="forgot-eng.php" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg></a>
      <a class="lang lang--onnavy" href="confirm-arb.php" hreflang="ar">العربية</a>
    </div>
    <div class="auth__brand">
      <img class="auth__logo" src="parent/assets/img/logo.png" alt="Helalia Language School">
      <h1 class="auth__name">Reset Password</h1> 
    </div>
    
    
    <form class="auth__form" method="post" autocomplete="on" action="reset-eng.php?id=<?php echo $_SESSION['phone_id'];?>&code=<?php echo escape($_GET['code']);?>">
      <label class="field"><span class="field__label">New Password</span>
      <input class="input" type="text" inputmode="numeric" placeholder="••••" required name="password" minlength="4" style="text-align:center"></label>
      <button class="btn btn--gold"  name="submit"  type="submit">Change Password</button>
      <br>
      <a class="btn btn--ghost" href="login-eng.php">Login</a>
    </form>
    
    
   </div></div>
 
 
 
</body>
</html>
