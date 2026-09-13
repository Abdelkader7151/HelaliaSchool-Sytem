<?php 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
  
  mysqli_select_db($database, $database_database);  
  $query_get_year_kids = "SELECT * FROM `kids_bk` "; 
  $get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
  $row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
  $totalRows_get_year_kids = mysqli_num_rows($get_year_kids);

  do{ 
	     $insertSQL = sprintf("UPDATE `kids` SET `class`= %s WHERE `ed_id` = %s",  
                       GetSQLValueString($database,$row_get_year_kids['class'], "int"),  
                               GetSQLValueString($database,$row_get_year_kids['ed_id'], "text"));

       // mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
       
  }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));

  echo $totalRows_get_year_kids;
  
 ?>