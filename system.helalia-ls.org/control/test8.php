<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');     

            $query_get_kid_id = "SELECT * FROM `kids_list`  ";    
            $get_kid_id = mysqli_query($database,$query_get_kid_id) or die(mysqli_error($database));
            $row_get_kid_id = mysqli_fetch_assoc($get_kid_id);
            $totalRows_get_kid_id = mysqli_num_rows($get_kid_id);
  
                    do{    
                        $query_get_kid  = "SELECT * FROM `app_login` WHERE `id` = {$row_get_kid_id['parent_id']} ";    
                        $get_kid  = mysqli_query($database,$query_get_kid) or die(mysqli_error($database));
                        $row_get_kid = mysqli_fetch_assoc($get_kid);
                        $totalRows_get_kid = mysqli_num_rows($get_kid); 

                        if($totalRows_get_kid<1){
                            $deleteSQL1 = sprintf("DELETE FROM `kids_list` WHERE `id` =%s  ",  
                                                GetSQLValueString($database,$row_get_kid_id['id'], "int"));
                        
                           // mysqli_query($database,$deleteSQL1) or die(mysqli_error($database)); 
                          echo $row_get_kid_id['parent_id']."<br>";
                         }
                     
                     }while($row_get_kid_id = mysqli_fetch_assoc($get_kid_id));
                    
 
 