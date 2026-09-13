<?php
//initialize the session
if (!isset($_SESSION)) { session_start(); }

include_once __DIR__ . '/auth-persist.php';

if (isset($_GET['exit'])){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL; 
  $_SESSION['MM_Userid'] = NULL; 	
  $_SESSION['account_type'] = NULL; 	 
  unset($_SESSION['MM_Username']); 
  unset($_SESSION['MM_Userid']);	 
  unset($_SESSION['account_type']);
  if (function_exists('helalia_logout_and_redirect')) {
    helalia_logout_and_redirect('../../index.php');
  }
  setcookie("helu", "", time() - (86400 * 400), "/");  
  setcookie("help", "", time() - (86400 * 400), "/");
	
    header("location: ../../index.php");
    exit;
} 

?>
