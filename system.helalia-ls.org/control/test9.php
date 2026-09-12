<?php require_once('includes/access.php');  
      require_once('../Connections/database.php'); 
      error_reporting(E_ALL);
      require_once('includes/functions.php');  

      mysqli_select_db($database, $database_database); 
      $query_get_data = "SELECT * FROM `kids_update` WHERE `data_update` = 0     ";
      $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
      $row_get_data = mysqli_fetch_assoc($get_data);
      $totalRows_get_data = mysqli_num_rows($get_data);  
  
            do{   
                  $query_get_data2 = "SELECT * FROM `kids` WHERE `ed_id` = '{$row_get_data['ed_id']}' ";
                  $get_data2 = mysqli_query($database,$query_get_data2) or die(mysqli_error($database));
                  $row_get_data2 = mysqli_fetch_assoc($get_data2);
                  $totalRows_get_data2 = mysqli_num_rows($get_data2);  

                  if($totalRows_get_data2>0){ 

                          $insertSQL = sprintf("UPDATE `kids` SET `gov_id` = %s, `name` = %s,  `fn_name` = %s, `check` = 1 WHERE `id` = %s ",  
                                        GetSQLValueString($database,$row_get_data['gov_id'], "text"), 
                                        GetSQLValueString($database,$row_get_data['name'], "text"), 
                                        GetSQLValueString($database,$row_get_data['fn_name'], "text"),  
                                        GetSQLValueString($database,$row_get_data2['id'], "int"));
                  
                          mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 

                       

                          $insertSQL2 = sprintf("UPDATE `kids_update` SET  `data_update` = 1 WHERE `id` = %s ",  
                                        GetSQLValueString($database,$row_get_data['id'], "int")); 
                          mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 
                  }

                       

         }while( $row_get_data = mysqli_fetch_assoc($get_data));
   
 ?>  