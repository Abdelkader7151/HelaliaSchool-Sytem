<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');       

 if($row_get_login['access23sub5']==1 && isset($_POST['id']) && isset($_POST['ex_result'])){

   if($_POST['ex_total']>=$_POST['ex_result']){

    $updateSQL1 = sprintf("UPDATE `control_year` SET `phase2_result`=%s, `phase2_admin_by`=%s, `phase2_date`=%s  WHERE `id`=%s ",    
                            GetSQLValueString($database,$_POST['ex_result'], "double"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "double"),   
                            GetSQLValueString($database,$_POST['id'], "int"));

    mysqli_select_db($database, $database_database);   
    mysqli_query($database,$updateSQL1) or die(mysqli_error($database));

    echo 1;
      }else{
        echo 0;
      } 
 }?> 