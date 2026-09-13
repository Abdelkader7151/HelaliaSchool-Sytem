<?php  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 
    mysqli_select_db($database, $database_database); 
    $query_get_teachers_subjects = "SELECT * FROM `teachers` ";
    $get_teachers_subjects = mysqli_query($database,$query_get_teachers_subjects) or die(mysqli_error($database));
    $row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects);
    $totalRows_get_teachers_subjects = mysqli_num_rows($get_teachers_subjects);

    if($totalRows_get_teachers_subjects>0){
        do{   
                mysqli_select_db($database, $database_database); 
                $query_get_users_info = "SELECT * FROM `subjects` where `id`='{$row_get_teachers_subjects['subject']}'  ";
                $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
                $row_get_users_info = mysqli_fetch_assoc($get_users_info);
                $totalRows_get_users_info = mysqli_num_rows($get_users_info);
            
                if($totalRows_get_users_info<1){ 
                    $deleteSQL = sprintf("DELETE FROM `teachers` WHERE `id`=%s ",
                            GetSQLValueString($database,$row_get_teachers_subjects['id'], "int"));
            
                    mysqli_query($database,$deleteSQL) or die(mysqli_error($database));   
                }  

        }while($row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects));
    }?>    