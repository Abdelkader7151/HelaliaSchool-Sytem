<?php   
      require_once('../Connections/database.php'); 
      require_once('includes/functions.php');   
 
// check 1 remove dublicate accounts for parents and leave emp
 
      mysqli_select_db($database, $database_database); 
      $query_get_data = "SELECT * FROM `app_login` ";
      $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
      $row_get_data = mysqli_fetch_assoc($get_data);
      $totalRows_get_data = mysqli_num_rows($get_data);
     

do{   
      mysqli_select_db($database, $database_database); 
      $query_get_app_login = "SELECT * FROM `app_login` where `phone` = '{$row_get_data['phone']}'  ";
      $get_app_login = mysqli_query($database,$query_get_app_login) or die(mysqli_error($database));
      $row_get_app_login = mysqli_fetch_assoc($get_app_login);
      $totalRows_get_app_login = mysqli_num_rows($get_app_login);

      if($totalRows_get_app_login>1){
         //mysqli_query($database,"DELETE FROM `app_login` where `phone` = '{$row_get_data['phone']}' and `account_type` = 1 "); 
         } 
}while( $row_get_data = mysqli_fetch_assoc($get_data));




// check 2 remove dublicate accounts for parents and leave emp
 
mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `kids_list` ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);

if($totalRows_get_data>0){ 
do{   
mysqli_select_db($database, $database_database); 
$query_get_app_login = "SELECT * FROM `app_login` where `id` = '{$row_get_data['parent_id']}'  ";
$get_app_login = mysqli_query($database,$query_get_app_login) or die(mysqli_error($database));
$row_get_app_login = mysqli_fetch_assoc($get_app_login);
$totalRows_get_app_login = mysqli_num_rows($get_app_login);

      if($totalRows_get_app_login<1){
      // mysqli_query($database,"DELETE FROM `kids_list` where `parent_id` = '{$row_get_data['parent_id']}' "); 
      } 

mysqli_select_db($database, $database_database); 
$query_get_kid= "SELECT * FROM `kids_list` where `kid_id`='{$row_get_data['kid_id']}' ";
$get_kid = mysqli_query($database,$query_get_kid) or die(mysqli_error($database));
$row_get_kid = mysqli_fetch_assoc($get_kid);
$totalRows_get_kid = mysqli_num_rows($get_kid);
      if($totalRows_get_kid>1){
       //mysqli_query($database,"DELETE FROM `kids_list` where `kid_id` = '{$row_get_data['kid_id']}' ");
      }


}while( $row_get_data = mysqli_fetch_assoc($get_data));}




    // check  1  if kid linked to  deleted account 
      
    mysqli_select_db($database, $database_database); 
    $query_get_data = "SELECT * FROM `kids` where `linked` = 1 ";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
   
if($totalRows_get_data>0){
      do{    
      mysqli_select_db($database, $database_database); 
      $query_get_data_kids = "SELECT * FROM `kids_list` where `kid_id` = '{$row_get_data['id']}'  ";
      $get_data_kids = mysqli_query($database,$query_get_data_kids) or die(mysqli_error($database));
      $row_get_data_kids = mysqli_fetch_assoc($get_data_kids);
      $totalRows_get_data_kids = mysqli_num_rows($get_data_kids);

      if($totalRows_get_data_kids<1){ 
           // mysqli_query($database,"UPDATE `kids` set  `linked` = 0 WHERE `id` = '{$row_get_data['id']}' ");  
      } 

      }while( $row_get_data = mysqli_fetch_assoc($get_data));
 }

 
 ?>