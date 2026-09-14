<?php require_once('../Connections/database.php'); ?>
<?php include("includes/functions.php");?>
<?php

//redirect is session is set
if(isset($_SESSION['MM_Username']) && isset($_SESSION['admin'])){header("location: home.php");exit;}
 
$failed=0; 

if (isset($_POST['username'])) {
  // trim: username momken yet7awel be spaces men el form (schooladmin ma kanesh beyedkhol)
  $loginUsername=strtolower(trim($_POST['username']));
  $password=strtolower(trim($_POST['password']));
  $MM_fldUserAuthorization = "id";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "failed";
  $MM_redirecttoReferrer = true;
  mysqli_select_db($database, $database_database); 



  mysqli_select_db($database, $database_database); 
  $query_get_Login = sprintf("SELECT `username`, `password`, `id` FROM `users` WHERE `username`=%s AND `password`=%s",
                                  GetSQLValueString($database, $loginUsername, "text"), 
                                  GetSQLValueString($database, $password, "text"));  
  $get_Login = mysqli_query($database,$query_get_Login) or die(mysqli_error($database));
  $row_get_Login = mysqli_fetch_assoc($get_Login);
  $totalRows_get_Login = mysqli_num_rows($get_Login); 

 
  if ($totalRows_get_Login) {
    
    $loginStrGroup  = $row_get_Login['id']; 
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername; 
	  $_SESSION['admin'] = $loginStrGroup;
    $_SESSION['MM_Userid'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  } else {
	  $failed=1;
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/login-1-rtl.min.css">

    

 </head>
 
  <body style="background-image: url('img/bg.jpg'); background-size: cover">
    <div class="login">
      <div class="login-body">
        <a class="login-brand" href="<?php echo $row_get_settings['admin_link'];?>">
          <img class="img-responsive" src="img/logo.png" alt="<?php echo $row_get_settings['website_title_arb'];?>">
        </a>
        <h3 class="login-heading">تسجيل الدخول</h3>
        <div class="login-form">
          <form method="post" enctype="multipart/form-data" target="_parent" data-toggle="validator">
            <div class="form-group">
              <label for="username" class="control-label f16">اسم الدخول</label>
              <input id="username" class="form-control" type="text" name="username" spellcheck="false" autocomplete="off" data-msg-required="اسم الدخول" required>
            </div>
            <div class="form-group">
              <label for="password" class="control-label f16">كلمة المرور</label>
              <input id="password" class="form-control" type="password" name="password" minlength="4" data-msg-minlength="Password must be 4 characters or more." data-msg-required="كلمة المرور" required>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block f18" style="margin-bottom: 20px" type="submit">الدخول</button>
				
				    <?php if($failed == 1){echo "<p class='alert-danger text-center' id='wrong'>كلمة مرور خطء </p>";}?> 
            </div> 
          </form>
        </div>
      </div>
       <?php include("includes/footer.php");?>
    </div>
    <?php include("includes/footer-script.php");?> 
	  
	  <?php if($failed==1){?>
<script type="text/javascript">
$(document).ready(function(){ 
$("#wrong").fadeIn(200).fadeOut(300).fadeIn(200).fadeOut(300).fadeIn(200).fadeOut(300).fadeIn(200).fadeOut(1500);
});
</script>
<?php }?> 
	  
	  
	  
  </body> 
</html>