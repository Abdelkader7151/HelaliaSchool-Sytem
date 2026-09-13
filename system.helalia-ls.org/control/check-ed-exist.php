<?php require_once('includes/access.php');  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
  
mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `kids_list` WHERE `kid_id` = '{$_POST['ed']}' ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);

  echo $totalRows_get_data;  
?> 