<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');       

 if($row_get_login['access23sub3']==1 && isset($_POST['id']) && isset($_POST['confirm'])){
 

    $updateSQL1 = sprintf("UPDATE `control` SET `confirm`=%s, `confirm_by`=%s, `confirm_date`=%s  WHERE `id`=%s  ",    
                            GetSQLValueString($database,$_POST['confirm'], "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "double"),   
                            GetSQLValueString($database,$_POST['id'], "int"));

    mysqli_select_db($database, $database_database);   
    mysqli_query($database,$updateSQL1) or die(mysqli_error($database));

if($_POST['confirm']==0){
    $updateSQL2 = sprintf("UPDATE `control` SET `publish`=%s WHERE `id`=%s  ",    
                     GetSQLValueString($database,0, "int"), 
                     GetSQLValueString($database,$_POST['id'], "int"));
                  
    mysqli_query($database,$updateSQL2) or die(mysqli_error($database));
}
    
 }?> 