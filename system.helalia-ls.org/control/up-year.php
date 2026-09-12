<?php  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 
 
    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids` WHERE `study_year` = 15  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info); 

    do{
      // $study_year = ($row_get_kid_info['study_year']+1);
       mysqli_query($database," UPDATE `kids` SET `upyear` = 0 WHERE `id`='{$row_get_kid_info['id']}' "); 
    }while($row_get_kid_info = mysqli_fetch_assoc($get_kid_info));

    