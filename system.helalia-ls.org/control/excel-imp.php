<?php 
 
        $msg ='';
        $output = '';
        $error = 0;
        $highestRow = 0;
      
      if(isset($_POST['import'])){   
          
           // mysqli_query($database, " DELETE FROM `ben_temp` WHERE `user_id` = '{$row_get_user['id']}' ");

            $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
            include("PHPExcel/Classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
            $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
         
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<$highestRow; $row++)
                { 
                      $start_date1 = strtotime(date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(0, $row)->getValue())));
                      //$start_date1 = mysqli_real_escape_string($database, strtotime($worksheet->getCellByColumnAndRow(0, $row)->getValue()));
                      $name = mysqli_real_escape_string($database, str_replace("/","",$worksheet->getCellByColumnAndRow(1, $row)->getValue()));  
                      $type = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                      $ben_id = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 
                      $program_id = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
                      $cust_id = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                     // $birthdate = mysqli_real_escape_string($database, strtotime($worksheet->getCellByColumnAndRow(6, $row)->getValue()));
                      $birthdate = strtotime(date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(6, $row)->getValue())));
                      $sex = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                      $gov_id = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                      $marital_status = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                      $job = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, $row)->getValue());
                      $phone2 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
                      $phone1 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
                      $area = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, $row)->getValue());
                      $city = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, $row)->getValue());
                      $address = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, $row)->getValue());
 
                      if(cust_exist($cust_id)==1 && program_exist($program_id)==1 && ben_id_dub($ben_id)==0 &&  name_dubl($ben_id,$name,$cust_id,$birthdate)==0){
                        $query = " INSERT INTO `ben_temp`( `id`, `cust_id`,  `name`, `start_date1`, `type`,  `program_id`, `sex`, `gov_id`, `birthdate`, `marital_status`, `job`, `phone1`, `phone2`, `city`, `area`, `address`, `user_id` ) VALUES ( '{$ben_id}', '{$cust_id}',  '{$name}', '{$start_date1}', '{$type}', '{$program_id}',  '{$sex}', '{$gov_id}', '{$birthdate}', '{$marital_status}', '{$job}', '{$phone1}', '{$phone2}', '{$city}', '{$area}', '{$address}', '{$row_get_user['id']}' ) ";  
                        mysqli_query($database, $query);
                        $error=0; 
                      }else{  
                        if(name_dubl($ben_id,$name,$cust_id,$birthdate)>0 ){ $msg.= "<li style='color:red;'> <b>{$name}</b> : الاسم مكرر  </li> ";}
                        if(cust_exist($cust_id)==0 ){ $msg.= "<li style='color:red;'> <b>{$cust_id}</b> : الشركة غير مسجلة  </li> ";}
                        if(program_exist($program_id)==0){ $msg.= "<li style='color:red;'>  <b>{$program_id}</b> :برنامج غير مسجل </li> ";} 
                        if(ben_id_dub($ben_id)==1){  $msg.= "<li style='color:red;'>   <b>{$ben_id}</b> : يوجد خطى بالسريل    </li> "; }
                        mysqli_query($database, " DELETE FROM `ben_temp` WHERE `user_id` = '{$row_get_user['id']}' ");
                        $error++;
                        break; 
                      }  
                      
                } 
                if($error>0){break;} 
            } 

            mysqli_select_db($database, "db"); 
            $query_get_data = "SELECT * FROM `ben_temp` WHERE `user_id` = '{$row_get_user['id']}' ";
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
            if(($highestRow-2)==$totalRows_get_data && $error==0){
              do{  
                 
                $group_id = group_comp_id($row_get_data['cust_id']);
                $group_name = group_comp_name($row_get_data['cust_id']);
                $cust_name = comp_name($row_get_data['cust_id']); 
                $annual = annual($row_get_data['program_id']);
                $program_title = program_title($row_get_data['program_id']); 
                $age_year = date("Y",$row_get_data['birthdate']);
                $age_month = date("m",$row_get_data['birthdate']);    
                $card_color = card_color($row_get_data['program_id']);
                $accommodation =  accommodation($row_get_data['program_id']);
                $cust_contract =  cust_contract($row_get_data['program_id']);
                $contract_start = cust_contract_start($row_get_data['program_id']);
                $contract_end = cust_contract_end($row_get_data['program_id']); 
                if($row_get_data['start_date1']!=NULL){$start_date2 = date("Y/m/d",$row_get_data['start_date1']);}else{$start_date2 = '';}
                $end_date2 = date("Y/m/d",$contract_end);  

                  $insertSQL = sprintf("INSERT INTO `ben` (`id`, `group_id`, `group_name`, `cust_id`, `cust_name`, `name`, `start_date1`, `start_date2`, `end_date1`, `end_date2`, `annual`, `type`, `cust_contract`, `contract_start`, `contract_end`, `program_title`, `program_id`, `card_color`, `accommodation`, `sex`, `gov_id`, `birthdate`, `age_year`, `age_month`, `marital_status`, `job`, `phone1`, `phone2`, `city`, `area`, `address`, `user_id` ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s ) ",
                        GetSQLValueString($database,$database,$row_get_data['id'], "int"),  
                        GetSQLValueString($database,$database,$group_id, "int"),  
                        GetSQLValueString($database,$database,$group_name, "text"),   
                        GetSQLValueString($database,$database,$row_get_data['cust_id'], "int"),  
                        GetSQLValueString($database,$database,$cust_name, "text"), 
                        GetSQLValueString($database,$database,$row_get_data['name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['start_date1'], "int"), 
                        GetSQLValueString($database,$database,$start_date2, "text"), 
                        GetSQLValueString($database,$database,$contract_end, "int"), 
                        GetSQLValueString($database,$database,$end_date2, "text"), 
                        GetSQLValueString($database,$database,$annual, "double"), 
                        GetSQLValueString($database,$database,$row_get_data['type'], "int"), 
                        GetSQLValueString($database,$database,$cust_contract, "int"),  
                        GetSQLValueString($database,$database,$contract_start, "int"), 
                        GetSQLValueString($database,$database,$contract_end, "int"), 
                        GetSQLValueString($database,$database,$program_title, "text"), 
                        GetSQLValueString($database,$database,$row_get_data['program_id'], "int"), 
                        GetSQLValueString($database,$database,$card_color, "text"), 
                        GetSQLValueString($database,$database,$accommodation, "text"), 
                        GetSQLValueString($database,$database,$row_get_data['sex'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['gov_id'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['birthdate'], "int"), 
                        GetSQLValueString($database,$database,$age_year, "int"), 
                        GetSQLValueString($database,$database,$age_month, "int"), 
                        GetSQLValueString($database,$database,$row_get_data['marital_status'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['job'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['phone1'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['phone2'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['city'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['area'], "text"), 
                        GetSQLValueString($database,$database,$row_get_data['address'], "text"), 
                        GetSQLValueString($database,$database,$row_get_user['id'], "int")); 
                      
                  mysqli_select_db($database, "db"); 
                  if(ben_id($row_get_data['id'])==1){ 
                    $deleteSQL = sprintf("DELETE FROM `ben` WHERE `id`=%s ", 
                                  GetSQLValueString($database,$database,$row_get_data['id'], "int")); 
                     mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
                  }   
                  $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
                 

              }while($row_get_data = mysqli_fetch_assoc($get_data)); 


              mysqli_select_db($database, "db"); 
              $query_get_data2 = "SELECT * FROM `ben_temp` WHERE `type` = 1 AND `user_id` = '{$row_get_user['id']}' ";
              $get_data2 = mysqli_query($database,$query_get_data2) or die(mysqli_error($database));
              $row_get_data2 = mysqli_fetch_assoc($get_data2);
              $totalRows_get_data2 = mysqli_num_rows($get_data2);
              
                do{    
                   $updateSQL2 = sprintf("UPDATE `ben` SET `main_ben_id` = %s, `main_ben_name` = %s  WHERE  `type` > %s AND `id` > %s AND `id` < %s ",
                              GetSQLValueString($database,$database,$row_get_data2['id'], "int"),  
                              GetSQLValueString($database,$database,$row_get_data2['name'], "text"),  
                              GetSQLValueString($database,$database,1, "int"),  
                              GetSQLValueString($database,$database,$row_get_data2['id'], "int"),  
                              GetSQLValueString($database,$database,($row_get_data2['id']+10), "int"));

                   mysqli_query($database,$updateSQL2) or die(mysqli_error($database));
                }while($row_get_data2 = mysqli_fetch_assoc($get_data2));  
          }

          mysqli_query($database, " DELETE FROM `ben_temp` WHERE `user_id` = '{$row_get_user['id']}' "); 

       } 

            
 
 ?> 