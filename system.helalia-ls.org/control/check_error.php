<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

  
 //check deleted subjects and remove  teacher  from it

    mysqli_select_db($database, $database_database); 
    $query_get_teachers_subjects = "SELECT `teachers`.id AS `id`, `subjects`.id AS `subject_id` FROM `teachers` LEFT JOIN `subjects` ON `teachers`.subject = `subjects`.id   ";
    $get_teachers_subjects = mysqli_query($database,$query_get_teachers_subjects) or die(mysqli_error($database));
    $row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects);
    $totalRows_get_teachers_subjects = mysqli_num_rows($get_teachers_subjects);

    if($totalRows_get_teachers_subjects>0){
        do{   
            if($row_get_teachers_subjects['subject_id']==NULL){
                $deleteSQL = sprintf("DELETE FROM `teachers` WHERE `id`=%s ",
                                GetSQLValueString($database,$row_get_teachers_subjects['id'], "int"));

                mysqli_query($database,$deleteSQL) or die(mysqli_error($database));   
            }  
        }while($row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects));
    }?>    