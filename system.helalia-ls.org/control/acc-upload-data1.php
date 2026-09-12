<?php   
     
for($row=2; $row<=$highestRow; $row++){  
         
              $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
              $ed_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
              $ed_fees = $worksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue(); 
              $activity = $worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
              $bus = $worksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();   
              $uniform1 = $worksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue();  
              $books1 = $worksheet->getCellByColumnAndRow(6, $row)->getCalculatedValue(); 
              $books2 = $worksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue(); 
              $uniform2 = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue(); 
              $pc = $worksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
              $technokids = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
              $hosting = $worksheet->getCellByColumnAndRow(11, $row)->getCalculatedValue();
              $total = $worksheet->getCellByColumnAndRow(12, $row)->getCalculatedValue();
              $registration = $worksheet->getCellByColumnAndRow(13, $row)->getCalculatedValue(); 
             
              $wrong = 0; 

              if($ed_id>0){ 
                
                mysqli_select_db($database, $database_database);  
                $query_get_users_info = "SELECT * FROM `kids` WHERE `ed_id` = '{$ed_id}' "; 
                $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
                $row_get_users_info = mysqli_fetch_assoc($get_users_info);
                $totalRows_get_users_info = mysqli_num_rows($get_users_info); 

                if($totalRows_get_users_info<1){ $wrong = 1; }   

              } 

  if( $name !=NULL ){

              $insertSQL = sprintf("INSERT INTO `kids_accounting` ( `wrong`, `study_year`, `name`, `ed_id`, `ed_fees`, `activity`, `bus`, `uniform1`,  `books1`, `books2`, `uniform2`, `pc`, `technokids`, `hosting`, `total`, `registration` ) 
                                    VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s )", 
                                                GetSQLValueString($database,$wrong, "int"), 
                                                GetSQLValueString($database,$_POST['target'], "int"), 
                                                GetSQLValueString($database,$name, "text"),  
                                                GetSQLValueString($database,$ed_id, "int"),  
                                                GetSQLValueString($database,$ed_fees, "double"),  
                                                GetSQLValueString($database,$activity, "double"),    
                                                GetSQLValueString($database,$bus, "double"),    
                                                GetSQLValueString($database,$uniform1, "double"),
                                                GetSQLValueString($database,$books1, "double"),    
                                                GetSQLValueString($database,$books2, "double"),    
                                                GetSQLValueString($database,$uniform2, "double"), 
                                                GetSQLValueString($database,$pc, "double"), 
                                                GetSQLValueString($database,$technokids, "double"),  
                                                GetSQLValueString($database,$hosting, "double"), 
                                                GetSQLValueString($database,$total, "double"),  
                                                GetSQLValueString($database,$registration, "double"));

                mysqli_select_db($database, $database_database);    
                mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
                 
     } 
 }
?>