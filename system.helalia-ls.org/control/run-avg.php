<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    


   
 if(isset($_GET['year'])){

mysqli_select_db($database , $database_database,);
$query_get_data = "SELECT * FROM `kids` where `study_year` = '{$_GET['year']}'      ";
$get_data = mysqli_query($database ,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);

   $month = 12; 
   $subject = 236; 
   $year = 2025;
  
 do{   
      $insertSQL = sprintf("INSERT INTO `control_registry_avg` ( `study_year`, `kid_id`, `subject_id`, `month`, `year`, `ed_id`, `name`, `arb_name`, `gender`) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                                GetSQLValueString($database,$_GET['year'], "int"), 
                                GetSQLValueString($database,$row_get_data['id'], "int"), 
                                GetSQLValueString($database,$subject, "int"), 
                                GetSQLValueString($database,$month, "int"), 
                                GetSQLValueString($database,$year, "int"), 
                                GetSQLValueString($database,$row_get_data['ed_id'], "int"), 
                                GetSQLValueString($database,$row_get_data['fn_name'], "text"), 
                                GetSQLValueString($database,$row_get_data['name'], "text"), 
                                GetSQLValueString($database,$row_get_data['gender'], "text"));
  
       // mysqli_query($database,$insertSQL) or die(mysqli_error($database));

  }while($row_get_data = mysqli_fetch_assoc($get_data));

  
 }
 



?> 