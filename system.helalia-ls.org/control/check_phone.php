<?php require_once('includes/access.php');  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');
 if (!function_exists('helalia_phone_is_taken')) {
   require_once('includes/phone-unique.php');
 }

mysqli_select_db($database, $database_database);
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$exclude = array();
if (isset($_POST['emp_id']) && (int) $_POST['emp_id'] > 0) {
  $exclude['exclude_emp_id'] = (int) $_POST['emp_id'];
  $exclude['exclude_app_login_emp_id'] = (int) $_POST['emp_id'];
}
$info = helalia_phone_already_used($database, $phone, $exclude);
// AJAX callers expect a number > 0 when taken
echo $info['used'] ? 1 : 0;
?>
