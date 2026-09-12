<?php  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 
    mysqli_select_db($database, $database_database);  
    $query_get_data = "SELECT distinct `subject_id` FROM `control`   ";    
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    
    if($totalRows_get_data>0){ 
        do{      
          
            mysqli_select_db($database, $database_database);  
            $query_get_subject = "SELECT * FROM `subjects`  WHERE `id` = '{$row_get_data['subject_id']}'  "; 
            $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
            $row_get_subject = mysqli_fetch_assoc($get_subject);
            $totalRows_get_subject = mysqli_num_rows($get_subject);

            if($totalRows_get_subject<1){
                $deleteSQL = sprintf("DELETE FROM `control` WHERE `subject_id` = %s ",
                                 GetSQLValueString($database,$row_get_data['subject_id'], "int"));

                mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

                $deleteSQL2 = sprintf("DELETE FROM `control_year` WHERE `subject_id` = %s ",
                                 GetSQLValueString($database,$row_get_data['subject_id'], "int"));
                                 
                mysqli_query($database,$deleteSQL2) or die(mysqli_error($database));
            }

        }while($row_get_data = mysqli_fetch_assoc($get_data)); 
    } 
    
?>    