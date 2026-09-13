<?php require_once('Connections/database.php');
      include("includes/functions.php");

 
     
      $wrong = 0;
 
 

if(isset($_POST['submit'])){  
    $code = time();
    $updateSQL = sprintf("UPDATE `app_login` SET `reset`=%s WHERE `phone`=%s  ",  
                      GetSQLValueString($database ,$code, "text"),
                      GetSQLValueString($database ,$_POST['phone'], "text")); 

     mysqli_query($database , $updateSQL) or die(mysqli_error($database)); 


mysqli_select_db($database , $database_database,);
$query_get_reset = "SELECT `name`,`email` FROM `app_login` where `reset` = '{$code}' ";
$get_reset =mysqli_query($database ,$query_get_reset) or die(mysqli_error($database));
$row_get_reset = mysqli_fetch_assoc($get_reset);
$totalRows_get_reset = mysqli_num_rows($get_reset); 

 $to = $row_get_reset['email']; 
$subject = "Helalia Reset Password";

$message = "
<html>
<head>
<title>Reset Password</title>
</head>
<body>
<p>Welcome  ".$row_get_reset['name']." <br>
Your Reset Password code is (<strong>".$code."</strong>)</p> 
</body>
</html>
";
 
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
$headers .= 'From: <admin@helalia-ls.org>' . "\r\n"; 

mail($to,$subject,$message,$headers);
 

   header("location: confirm-eng.php");
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
<div class="app app--auth">
  

<div class="auth">
    <div class="auth__hero">
      <img class="auth__hero-img" src="parent/assets/img/bg-school.jpg" alt="مدرسة هلاليا للغات">
    </div>
    <div class="between">
      <a class="back" href="login-eng.php" aria-label="Back"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg></a>
      <a class="lang lang--onnavy" href="forgot-arb.php" hreflang="ar">العربية</a>
    </div>
    <div class="auth__brand">
      <img class="auth__logo" src="parent/assets/img/logo-icon.png" alt="Helalia Language School">
      <h1 class="auth__name">Helalia Language School</h1>
      <p class="auth__tag"> School management mobile app</p>
    </div>
    
    
   <form class="auth__form" method="post" autocomplete="on" action="forgot-eng.php?id=<?php echo $_SESSION['phone_id'];?>">
      <p class="auth__fine" style="text-align:start;margin-block-end:2px">Enter your phone and we will guide you to reset access.</p>
      <label class="field"><span class="field__label">Phone number</span>
      <input class="input" id="forgot-phone" name="phone"  type="tel" inputmode="numeric" autocomplete="tel" pattern="01[0-9]{9}" maxlength="11" required  placeholder="01xxxxxxxxx"></label>
     
      <button class="btn btn--gold" type="submit" name="submit">Submit request</button> 

      <a class="btn btn--ghost" href="login-eng.php">Sign in</a>
    </form>
    
    <div class="auth__foot">
      <p class="auth__fine">The school office will confirm your identity before resetting access.</p>
    </div>
  </div>
</div>



<script src="../assets/js/app.js" defer></script>
<script>
var fp = document.getElementById('forgot-phone');
fp.addEventListener('input', function () {
  this.value = this.value.replace(/\D/g, '').slice(0, 11);
});
fp.addEventListener('keypress', function (e) {
  if (e.key.length === 1 && /\D/.test(e.key)) e.preventDefault();
});
</script>
</body>
</html>
