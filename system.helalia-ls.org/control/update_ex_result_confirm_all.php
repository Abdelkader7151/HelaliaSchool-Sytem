<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');       

 if($row_get_login['access23sub3']==1 && isset($_POST['id']) && isset($_POST['month'])){
 

    $updateSQL1 = sprintf("UPDATE `control` SET `confirm`=%s, `confirm_by`=%s, `confirm_date`=%s  WHERE `kid_id`=%s  AND  `month`=%s ",    
                            GetSQLValueString($database,1, "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "double"),   
                            GetSQLValueString($database,$_POST['id'], "int"),
                            GetSQLValueString($database,$_POST['month'], "int"));

    mysqli_select_db($database, $database_database);   
    mysqli_query($database,$updateSQL1) or die(mysqli_error($database));

 
    
 }?> 