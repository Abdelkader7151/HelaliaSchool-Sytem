<?php require_once('includes/access.php');  
      require_once('../Connections/database.php'); 
      error_reporting(E_ALL);
      require_once('includes/functions.php');  

 
         
                  $query_get_data = "SELECT * FROM `kids`  WHERE `class` > 0 AND `study_year` IS NOT NULL  AND `study_year` < 15 ";
                  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                  $row_get_data = mysqli_fetch_assoc($get_data);
                  $totalRows_get_data = mysqli_num_rows($get_data);  
 
                       do{   
                            $query_get_data2 = "SELECT * FROM `class` WHERE `id` ='{$row_get_data['class']}' ";
                            $get_data2 = mysqli_query($database,$query_get_data2) or die(mysqli_error($database));
                            $row_get_data2 = mysqli_fetch_assoc($get_data2);
                            $totalRows_get_data2 = mysqli_num_rows($get_data2); 

                         if($totalRows_get_data2>0){
                             $insertSQL = sprintf("UPDATE `kids` SET `study_year` = %s  WHERE `id` = %s ",   
                                        GetSQLValueString($database,$row_get_data2['study_year'], "int"),   
                                        GetSQLValueString($database,$row_get_data['id'], "int"));
                  
                          mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
                         }else{
                            echo $row_get_data['class']."</br>";
                         }

        
                        }while( $row_get_data = mysqli_fetch_assoc($get_data));   
   
 ?>  