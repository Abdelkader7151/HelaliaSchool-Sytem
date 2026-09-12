<?php 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
  
  mysqli_select_db($database, $database_database);  
  $query_get_year_kids = "SELECT * FROM `kids` "; 
  $get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
  $row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
  $totalRows_get_year_kids = mysqli_num_rows($get_year_kids);

  do{ 
	     $insertSQL = sprintf("UPDATE `kids` SET `study_year`=%s, `class`= %s WHERE `id` = %s", 
                      GetSQLValueString($database,($row_get_year_kids['study_year']+1), "int"),  
                              GetSQLValueString($database,NULL, "text"),  
                              GetSQLValueString($database,$row_get_year_kids['id'], "int"));

       mysqli_select_db($database, $database_database);   
      
         // mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
       
  }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));

  echo $totalRows_get_year_kids;
  
 ?>