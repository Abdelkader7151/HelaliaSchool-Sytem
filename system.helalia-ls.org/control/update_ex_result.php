<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');       

 if($row_get_login['access23sub1']==1 && isset($_POST['id']) && isset($_POST['ex_result'])){

   if($_POST['ex_total']>=$_POST['ex_result']){

    $updateSQL1 = sprintf("UPDATE `control` SET `ex_result`=%s, `ex_result_admin_by`=%s, `ex_result_date`=%s  WHERE `id`=%s AND `confirm` =%s",    
                            GetSQLValueString($database,$_POST['ex_result'], "double"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "double"),   
                            GetSQLValueString($database,$_POST['id'], "int"),
                            GetSQLValueString($database,0, "int"));

    mysqli_select_db($database, $database_database);   
    $Result1 = mysqli_query($database,$updateSQL1) or die(mysqli_error($database));
    echo 1;
      }else{
        echo 0;
      } 
 }?> 