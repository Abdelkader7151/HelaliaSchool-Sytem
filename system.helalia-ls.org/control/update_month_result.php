<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub1']==1 && isset($_POST['id']) && isset($_POST['month_result'])){


      
  
    $updateSQL1 = sprintf("UPDATE `control` SET `month_result`=%s, `month_result_admin_by`=%s, `month_result_date`=%s  WHERE `id`=%s AND `confirm` =%s",    
                            GetSQLValueString($database,$_POST['month_result'], "double"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "double"),   
                            GetSQLValueString($database,$_POST['id'], "int"),
                            GetSQLValueString($database,0, "int"));

    mysqli_select_db($database, $database_database);   
    $Result1 = mysqli_query($database,$updateSQL1) or die(mysqli_error($database));

 

 }?>