<?php require_once('includes/access.php');  
      require_once('../Connections/database.php'); 
      error_reporting(E_ALL);
      require_once('includes/functions.php');  

      mysqli_select_db($database, $database_database); 
      $query_get_data = "SELECT `gov_id`, `id` FROM `kids`     ";
      $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
      $row_get_data = mysqli_fetch_assoc($get_data);
      $totalRows_get_data = mysqli_num_rows($get_data); 

  
            do{  
                    $gen='';
                    $gov_id = $row_get_data['gov_id'];
                    $arabic_nums = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
                    $english_nums = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $gov_id = str_replace($arabic_nums, $english_nums, $gov_id);
                    $char13 = substr($gov_id, 12, 1); 
                  if(is_numeric($char13)) {
                       $char13 % 2 == 0 ? $gen ="أنثى" : $gen ="ذكر" ;
                  }  

       $insertSQL = sprintf("UPDATE `kids` SET  `gender`=%s  WHERE `id` = %s ", 
                      // GetSQLValueString($database,$gov_id, "text"), 
                       GetSQLValueString($database,$gen, "text"),  
                       GetSQLValueString($database,$row_get_data['id'], "int"));
 
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));

         }while( $row_get_data = mysqli_fetch_assoc($get_data));
   
 ?>  