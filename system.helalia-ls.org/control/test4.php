<?php   
      require_once('../Connections/database.php'); 
      require_once('includes/functions.php');   
 
// check 1 remove dublicate accounts for parents and leave emp
mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `teachers`  ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);

do{   
      mysqli_select_db($database, $database_database); 
      $query_get_app_login = "SELECT * FROM `emps` WHERE `id` = '{$row_get_data['emp_id']}'    "; 
      $get_app_login = mysqli_query($database,$query_get_app_login) or die(mysqli_error($database));
      $row_get_app_login = mysqli_fetch_assoc($get_app_login);
      $totalRows_get_app_login = mysqli_num_rows($get_app_login);

      if($totalRows_get_app_login<1){ 
            $deleteSQL = sprintf("DELETE FROM `teachers` WHERE `id`=%s ",
                        GetSQLValueString($database,$row_get_data['id'], "int"));
 
            //mysqli_query($database,$deleteSQL) or die(mysqli_error($database)); 
          echo $row_get_data['id']."<br>"; 
         } 
}while($row_get_data = mysqli_fetch_assoc($get_data));


 
 
 ?>  