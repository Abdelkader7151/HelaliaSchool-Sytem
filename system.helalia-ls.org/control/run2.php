<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 error_reporting(E_ALL);
 require_once('includes/functions.php');    
 
 
  mysqli_select_db($database, $database_database); 
  $query_get_data = "SELECT * FROM `seats` ";
  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);

  $count = 0;

    do{
 
        $insertSQL = sprintf("UPDATE `kids` SET `name`=%s, `fn_name`=%s  WHERE `ed_id`=%s  ", 
                            GetSQLValueString($database,$row_get_data['name_arb'], "text"), 
                                    GetSQLValueString($database,$row_get_data['name_eng'], "text"), 
                                    GetSQLValueString($database,$row_get_data['ed_id'], "int"));
    
        if(mysqli_query($database,$insertSQL) or die(mysqli_error($database))){$count ++;}

    }while($row_get_data = mysqli_fetch_assoc($get_data));

echo  $count;
  ?>