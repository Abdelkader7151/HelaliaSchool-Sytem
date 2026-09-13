<?php require_once('includes/access.php'); 
require_once('includes/logout.php'); 
require_once('../Connections/database.php'); 
require_once('includes/functions.php');    
 

 if($row_get_login['access16']==1){
 
function removes($name)
{
  $step1 = trim($name," ");
  $step2= ltrim($step1, " ");
  $step3 = rtrim($step2, " ");
  $step4 = trim($step3, "\n");
  $step5 = str_replace('\n',"",$step4);
  $step6=str_replace("\r\n","",$step5);
  $step7=str_replace("١","1",$step6);
  $step8=str_replace("٢","2",$step7);
  $step9=str_replace("٣","3",$step8);
  $step10=str_replace("٤","4",$step9);
  $step11=str_replace("٥","5",$step10);
  $step12=str_replace("٦","6",$step11);
  $step13=str_replace("٧","7",$step12);
  $step14=str_replace("٨","8",$step13);
  $step15=str_replace("٩","9",$step14); 
  $step16=str_replace("٠","0",$step15); 
  $step17=str_replace(".",".",$step16); 
  $step18=str_replace("اقل من المتوقع","",$step17); 
  $step19=str_replace("يلبى التوقعات احيانا","",$step18);   
  return $step19;
}

 

    if(isset($_POST['import'])){    

        mysqli_select_db($database, "db");  
        mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' "); 

        $msg =''; 
        $error = 0;
        $highestRow = 0;  
            
            $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
            include("PHPExcel/Classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
            $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
         
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                 $highestRow = $worksheet->getHighestRow();  

            for($row=4; $row<=$highestRow; $row++)
                {  
 
                  $ed_id =  mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(0, removes($row))->getValue());   
                  
                  mysqli_select_db($database, "db"); 
                  $query_get_gov_id = "SELECT `ed_id`, `class`, `study_year` FROM `kids` WHERE `ed_id` = '{$ed_id}'  ";
                  $get_gov_id = mysqli_query($database,$query_get_gov_id) or die(mysqli_error($database));
                  $row_get_gov_id = mysqli_fetch_assoc($get_gov_id);
                  $totalRows_get_gov_id = mysqli_num_rows($get_gov_id); 
                  
                  if($totalRows_get_gov_id==1){
                     
                     $gov_id = $row_get_gov_id['ed_id'];
                    

                    if($gov_id!=NULL && $gov_id>0 ){ 
                    
                       
                    $subject1_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, removes($row))->getValue()); 
                    $subject2_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, removes($row))->getValue()); 
                    $subject3_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, removes($row))->getValue()); 
                    $subject4_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, removes($row))->getValue()); 
                    $subject5_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, removes($row))->getValue()); 
                    $subject6_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, removes($row))->getValue()); 
                    $subject7_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, removes($row))->getValue()); 
                    $subject8_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, removes($row))->getValue()); 
                    $subject9_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, removes($row))->getValue()); 
                    $subject10_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, removes($row))->getValue()); 
                    $subject11_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, removes($row))->getValue()); 
                    $subject12_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, removes($row))->getValue()); 
                    $subject13_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, removes($row))->getValue()); 
                    $subject14_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, removes($row))->getValue()); 
                    $subject15_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, removes($row))->getValue()); 
                    $subject16_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, removes($row))->getValue()); 
                    $subject17_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, removes($row))->getValue()); 
                    $subject18_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, removes($row))->getValue()); 
                    $subject19_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, removes($row))->getValue()); 
                    $subject20_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, removes($row))->getValue()); 
                    $subject21_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, removes($row))->getValue()); 
                    $subject22_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, removes($row))->getValue()); 
                    $subject23_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, removes($row))->getValue()); 
                    $subject24_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, removes($row))->getValue()); 
                    $subject25_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, removes($row))->getValue()); 
                    $subject26_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, removes($row))->getValue()); 
                    $subject27_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, removes($row))->getValue()); 
                    $subject28_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, removes($row))->getValue()); 
                    $subject29_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, removes($row))->getValue()); 
                    $subject30_phases = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, removes($row))->getValue());    
                   

                     $subject1_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 3)->getValue()); 
                     $subject2_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 3)->getValue()); 
                     $subject3_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 3)->getValue()); 
                     $subject4_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 3)->getValue()); 
                     $subject5_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 3)->getValue()); 
                     $subject6_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 3)->getValue()); 
                     $subject7_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 3)->getValue()); 
                     $subject8_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 3)->getValue()); 
                     $subject9_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 3)->getValue()); 
                     $subject10_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 3)->getValue()); 
                     $subject11_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 3)->getValue()); 
                     $subject12_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 3)->getValue()); 
                     $subject13_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 3)->getValue()); 
                     $subject14_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 3)->getValue()); 
                     $subject15_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 3)->getValue()); 
                     $subject16_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, 3)->getValue());
                     $subject17_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, 3)->getValue());
                     $subject18_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, 3)->getValue());
                     $subject19_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, 3)->getValue());
                     $subject20_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, 3)->getValue());
                     $subject21_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, 3)->getValue()); 
                     $subject22_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, 3)->getValue()); 
                     $subject23_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, 3)->getValue()); 
                     $subject24_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, 3)->getValue()); 
                     $subject25_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, 3)->getValue()); 
                     $subject26_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, 3)->getValue()); 
                     $subject27_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, 3)->getValue()); 
                     $subject28_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, 3)->getValue()); 
                     $subject29_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, 3)->getValue()); 
                     $subject30_phases_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, 3)->getValue());

                     

                    
                      $insertSQL1 = sprintf("INSERT INTO `cert_temp` (
                        `gov_id`, `type`,
                        `subject1_phases`, `subject2_phases`, `subject3_phases`, `subject4_phases`, `subject5_phases`, `subject6_phases`, `subject7_phases`, `subject8_phases`, `subject9_phases`, `subject10_phases`, `subject11_phases`, `subject12_phases`, `subject13_phases`, `subject14_phases`, `subject15_phases`,
                        `subject16_phases`, `subject17_phases`, `subject18_phases`, `subject19_phases`, `subject20_phases`, `subject21_phases`, `subject22_phases`, `subject23_phases`, `subject24_phases`, `subject25_phases`, `subject26_phases`, `subject27_phases`, `subject28_phases`, `subject29_phases`, `subject30_phases`,
                        `subject1_phases_total`, `subject2_phases_total`, `subject3_phases_total`, `subject4_phases_total`, `subject5_phases_total`, `subject6_phases_total`, `subject7_phases_total`, `subject8_phases_total`, `subject9_phases_total`, `subject10_phases_total`, `subject11_phases_total`, `subject12_phases_total`, `subject13_phases_total`, `subject14_phases_total`, `subject15_phases_total`,
                        `subject16_phases_total`, `subject17_phases_total`, `subject18_phases_total`, `subject19_phases_total`, `subject20_phases_total`, `subject21_phases_total`, `subject22_phases_total`, `subject23_phases_total`, `subject24_phases_total`, `subject25_phases_total`, `subject26_phases_total`, `subject27_phases_total`, `subject28_phases_total`, `subject29_phases_total`, `subject30_phases_total`,
                        `user_id` ) VALUES ( 
                            %s, %s,  
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s ) ",

                            GetSQLValueString($database,$gov_id, "text"),   
                            GetSQLValueString($database,$_POST['type'], "int"),    

                            GetSQLValueString($database,$subject1_phases, "double"),  
                            GetSQLValueString($database,$subject2_phases, "double"),  
                            GetSQLValueString($database,$subject3_phases, "double"),  
                            GetSQLValueString($database,$subject4_phases, "double"),  
                            GetSQLValueString($database,$subject5_phases, "double"),  
                            GetSQLValueString($database,$subject6_phases, "double"),  
                            GetSQLValueString($database,$subject7_phases, "double"),  
                            GetSQLValueString($database,$subject8_phases, "double"),  
                            GetSQLValueString($database,$subject9_phases, "double"),  
                            GetSQLValueString($database,$subject10_phases, "double"),  
                            GetSQLValueString($database,$subject11_phases, "double"),  
                            GetSQLValueString($database,$subject12_phases, "double"),  
                            GetSQLValueString($database,$subject13_phases, "double"),  
                            GetSQLValueString($database,$subject14_phases, "double"),  
                            GetSQLValueString($database,$subject15_phases, "double"),  
                            GetSQLValueString($database,$subject16_phases, "double"), 
                            GetSQLValueString($database,$subject17_phases, "double"), 
                            GetSQLValueString($database,$subject18_phases, "double"), 
                            GetSQLValueString($database,$subject19_phases, "double"), 
                            GetSQLValueString($database,$subject20_phases, "double"), 
                            GetSQLValueString($database,$subject21_phases, "double"), 
                            GetSQLValueString($database,$subject22_phases, "double"), 
                            GetSQLValueString($database,$subject23_phases, "double"), 
                            GetSQLValueString($database,$subject24_phases, "double"), 
                            GetSQLValueString($database,$subject25_phases, "double"), 
                            GetSQLValueString($database,$subject26_phases, "double"), 
                            GetSQLValueString($database,$subject27_phases, "double"), 
                            GetSQLValueString($database,$subject28_phases, "double"), 
                            GetSQLValueString($database,$subject29_phases, "double"), 
                            GetSQLValueString($database,$subject30_phases, "double"), 

                            GetSQLValueString($database,$subject1_phases_total, "double"),  
                            GetSQLValueString($database,$subject2_phases_total, "double"),  
                            GetSQLValueString($database,$subject3_phases_total, "double"),  
                            GetSQLValueString($database,$subject4_phases_total, "double"),  
                            GetSQLValueString($database,$subject5_phases_total, "double"),  
                            GetSQLValueString($database,$subject6_phases_total, "double"),  
                            GetSQLValueString($database,$subject7_phases_total, "double"),  
                            GetSQLValueString($database,$subject8_phases_total, "double"),  
                            GetSQLValueString($database,$subject9_phases_total, "double"),  
                            GetSQLValueString($database,$subject10_phases_total, "double"),  
                            GetSQLValueString($database,$subject11_phases_total, "double"),  
                            GetSQLValueString($database,$subject12_phases_total, "double"),  
                            GetSQLValueString($database,$subject13_phases_total, "double"),  
                            GetSQLValueString($database,$subject14_phases_total, "double"),  
                            GetSQLValueString($database,$subject15_phases_total, "double"),  
                            GetSQLValueString($database,$subject16_phases_total, "double"), 
                            GetSQLValueString($database,$subject17_phases_total, "double"), 
                            GetSQLValueString($database,$subject18_phases_total, "double"), 
                            GetSQLValueString($database,$subject19_phases_total, "double"), 
                            GetSQLValueString($database,$subject20_phases_total, "double"), 
                            GetSQLValueString($database,$subject21_phases_total, "double"), 
                            GetSQLValueString($database,$subject22_phases_total, "double"), 
                            GetSQLValueString($database,$subject23_phases_total, "double"), 
                            GetSQLValueString($database,$subject24_phases_total, "double"), 
                            GetSQLValueString($database,$subject25_phases_total, "double"), 
                            GetSQLValueString($database,$subject26_phases_total, "double"), 
                            GetSQLValueString($database,$subject27_phases_total, "double"), 
                            GetSQLValueString($database,$subject28_phases_total, "double"), 
                            GetSQLValueString($database,$subject29_phases_total, "double"), 
                            GetSQLValueString($database,$subject30_phases_total, "double"), 

                            GetSQLValueString($database,$row_get_login['id'], "int")); 
                          
                      mysqli_select_db($database, "db");  
                      $Result1 = mysqli_query($database, $insertSQL1) or die(mysqli_error($database));
                    }else{
                        $error++;
                        mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ");  
                        $msg.= "<li style='color:red;'>    $gov_id خطى بالرقم التعليمي </li> ";
                        break;
                    } 


                  }else{ 
                   // if($name!=NULL){ 
                   //   $error++;
                   //   mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ");
                    //  $msg.= "<li style='color:red;'>     الاسم غير صحيح  : <b>{$name}</b> </li> "; 
                    //  break; 
                   // }
                   } 
                } 

 

                mysqli_select_db($database, "db"); 
                $query_get_data = "SELECT `gov_id`, COUNT(gov_id) as `dub` FROM `cert_temp` GROUP BY `gov_id` HAVING COUNT(gov_id) > 1 ";
                $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                $row_get_data = mysqli_fetch_assoc($get_data);
                $totalRows_get_data = mysqli_num_rows($get_data);
                
                 if($row_get_data['dub']>1 && $totalRows_get_data>0){
                    $msg.= "<li style='color:red;'> <b>{$row_get_data['gov_id']}</b> :    الرقم التعليمي مكرر   </li> ";
                    $error++;
                    mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' "); 
                } 


                 
           


            mysqli_select_db($database, "db"); 
            $query_get_data = "SELECT * FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ";
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
           // if(($highestRow-2)==$totalRows_get_data && $error==0){
            if($totalRows_get_data && $error==0){
              do{  


                mysqli_select_db($database, "db"); 
                $query_get_check = "SELECT `gov_id` FROM `certificate` WHERE `gov_id` = '{$row_get_data['gov_id']}' AND  `study_year`='{$row_get_gov_id['study_year']}' AND `type` ='{$row_get_data['type']}'  ";
                $get_check = mysqli_query($database,$query_get_check) or die(mysqli_error($database));
                $row_get_check = mysqli_fetch_assoc($get_check);
                $totalRows_get_check = mysqli_num_rows($get_check);
                 
                    //if($totalRows_get_check>0){ mysqli_query($database, " DELETE FROM `certificate` WHERE `gov_id` = '{$row_get_data['gov_id']}' AND `study_year`='{$row_get_gov_id['study_year']}' AND `type` ='{$row_get_data['type']}'    ");  }

                $updateSQL = sprintf("UPDATE `certificate` SET   
                        `subject1_phases`=%s, `subject2_phases`=%s, `subject3_phases`=%s, `subject4_phases`=%s, `subject5_phases`=%s, `subject6_phases`=%s, `subject7_phases`=%s, `subject8_phases`=%s, `subject9_phases`=%s, `subject10_phases`=%s, `subject11_phases`=%s, `subject12_phases`=%s, `subject13_phases`=%s, `subject14_phases`=%s, `subject15_phases`=%s,
                        `subject16_phases`=%s, `subject17_phases`=%s, `subject18_phases`=%s, `subject19_phases`=%s, `subject20_phases`=%s, `subject21_phases`=%s, `subject22_phases`=%s, `subject23_phases`=%s, `subject24_phases`=%s, `subject25_phases`=%s, `subject26_phases`=%s, `subject27_phases`=%s, `subject28_phases`=%s, `subject29_phases`=%s, `subject30_phases`=%s,
                        `subject1_phases_total`=%s, `subject2_phases_total`=%s, `subject3_phases_total`=%s, `subject4_phases_total`=%s, `subject5_phases_total`=%s, `subject6_phases_total`=%s, `subject7_phases_total`=%s, `subject8_phases_total`=%s, `subject9_phases_total`=%s, `subject10_phases_total`=%s, `subject11_phases_total`=%s, `subject12_phases_total`=%s, `subject13_phases_total`=%s, `subject14_phases_total`=%s, `subject15_phases_total`=%s,
                        `subject16_phases_total`=%s, `subject17_phases_total`=%s, `subject18_phases_total`=%s, `subject19_phases_total`=%s, `subject20_phases_total`=%s, `subject21_phases_total`=%s, `subject22_phases_total`=%s, `subject23_phases_total`=%s, `subject24_phases_total`=%s, `subject25_phases_total`=%s, `subject26_phases_total`=%s, `subject27_phases_total`=%s, `subject28_phases_total`=%s, `subject29_phases_total`=%s, `subject30_phases_total`=%s
                        WHERE `gov_id` = %s AND `study_year`= %s  AND `type` =%s ",   

                        GetSQLValueString($database,$row_get_data['subject1_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject2_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject3_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject4_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject5_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject6_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject7_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject8_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject9_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject10_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject11_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject12_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject13_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject14_phases'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject15_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject16_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject17_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject18_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject19_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject20_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject21_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject22_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject23_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject24_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject25_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject26_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject27_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject28_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject29_phases'], "double"),
                        GetSQLValueString($database,$row_get_data['subject30_phases'], "double"), 

                        GetSQLValueString($database,$row_get_data['subject1_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject2_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject3_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject4_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject5_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject6_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject7_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject8_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject9_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject10_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject11_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject12_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject13_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject14_phases_total'], "double"),  
                        GetSQLValueString($database,$row_get_data['subject15_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject16_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject17_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject18_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject19_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject20_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject21_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject22_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject23_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject24_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject25_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject26_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject27_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject28_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject29_phases_total'], "double"),
                        GetSQLValueString($database,$row_get_data['subject30_phases_total'], "double"),  

                        GetSQLValueString($database,$row_get_data['gov_id'], "text"), 
                        GetSQLValueString($database,$row_get_gov_id['study_year'], "int"),     
                        GetSQLValueString($database,$row_get_data['type'], "int")); 
                      
                  mysqli_select_db($database, "db");  
                  mysqli_query($database,$updateSQL) or die(mysqli_error($database));
                 

              }while($row_get_data = mysqli_fetch_assoc($get_data)); 

 
               mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' "); 
          }

         
        }
        
    }

 


if(isset($_POST['save'])){
  mysqli_select_db($database, "db"); 
  $query_get_data = "SELECT * FROM `cert_subjects`   ";
  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);

  do{ 
    $updateSQL = sprintf("UPDATE `cert_subjects` SET `total`=%s WHERE `id`=%s  ", 
                                GetSQLValueString($database,$_POST['check_'.$row_get_data['id']]?1:0, "int"), 
                                GetSQLValueString($database,$row_get_data['id'], "int"));

    mysqli_query($database,$updateSQL) or die(mysqli_error($database)); 
  }while($row_get_data = mysqli_fetch_assoc($get_data)); 
}



$head_title = "  النتائج";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css"> 
 </head> 
 
  <body class="layout layout-header-fixed"> 
	  
    <div class="layout-header">
      <div class="navbar navbar-default">
        <div class="navbar-header" style=" background-color: black">
          <a class="navbar-brand navbar-brand-center" href="home.php" style=" padding: 5px"> </a>
			<?php include('includes/mobile-menu-buttons.php');?> 
		  </div> 
	    <div class="navbar-toggleable">
          <nav id="navbar" class="navbar-collapse collapse">
            <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true" type="button" >
              <span class="sr-only">Toggle navigation</span>
              <span class="bars">
                <span class="bar-line bar-line-1 out"></span>
                <span class="bar-line bar-line-2 out"></span>
                <span class="bar-line bar-line-3 out"></span>
                <span class="bar-line bar-line-4 in"></span>
                <span class="bar-line bar-line-5 in"></span>
                <span class="bar-line bar-line-6 in"></span>
              </span>
            </button>
            <ul class="nav navbar-nav navbar-right"> 
             <?php require_once('includes/notifications.php');?>    
            </ul>  
			 <?php require_once('includes/title-bar.php');?>  
          </nav>
        </div>
      </div>
    </div> 
	  
    <div class="layout-main">
      <?php include("includes/side-nav.php");?>  
		
      <div class="layout-content">
        <div class="layout-content-body"> 
			<div class="row">
            <div class="col-md-12">
                <h4>         تحميل نتيجة  </h4>
            </div>
          </div>
			<div class="row">  
				<div class="col-md-4">
				  <div class="demo-form-wrapper"> 
                    <form action="cert_imp_term.php" method="POST" name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">
                    
  
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  تحميل  <span class="required" style="color:red">*</span></label>
              <div class="col-sm-5">
              <input type="file" required name="excel" accept=".xls,.xlsx"   class="form-control" />  
                <small style="color:browne">الملف Excel فقط <a href="uploads/turm.xlsx">Demo</a></small>
                
              </div>

             

            </div>  
                 
 
            <div class="form-group">
						<label class="col-sm-3 control-label" for="type"> النوع  </label>
						<div class="col-sm-4">
                
                <input type="radio" name="type" value="2" checked   > نصف العام    
                <input type="radio" name="type" value="3"    > اخر العام     
						</div>
            </div> 

            
          <!--  
            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" name="target"  id="target"  >
                      <option selected   >...</option>  
                      <option value="0" >   بري سكول</option> 
                      <option value="1" > اولى حضانة</option> 
                      <option value="2" > ثانية حضانة</option> 
                      <option value="3" >  الصف الاول الابتدائى</option> 
                      <option value="4" >  الصف الثانى الابتدائى</option> 
                      <option value="5" >  الصف الثالث الابتدائى</option> 
                      <option value="6" >  الصف الرابع الابتدائى</option> 
                      <option value="7" >  الصف الخامس الابتدائى</option> 
                      <option value="8" >  الصف السادس الابتدائى</option> 
                      <option value="9" >  الصف الاول الاعدادى</option> 
                      <option value="10" >  الصف الثاني الاعدادى</option> 
                      <option value="11" >  الصف الثالث الاعدادى</option> 
                      <option value="12" >  الصف الاول الثانوى</option> 
                      <option value="13" >  الصف الثاني الثانوى</option> 
                      <option value="14" >  الصف الثالث الثانوى</option>  
                </select>
						</div>
            </div>


            <div class="form-group" style="display: none" id="class_box">
						<label class="col-sm-3 control-label" for="class" id="class_box"> الفصل  </label>
						<div class="col-sm-4">
                <select class="form-control" name="class" id="class"   >
                      <option selected value="0" >جميع الفصول</option>  
                </select>
						</div>
            </div> 
 -->
            <i class="fa fa-spinner fa-spin fa-3x fa-fw" id="loading" style="margin-right: 150px; display:none"></i>
					  </div>          
    


            
 
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-3"> 
                            <button type="submit" class="btn btn-success btn-block" name="import" id="submit1" style="background-color: green;" ><i class="fa fa-upload" aria-hidden="true"></i> تحميل</button> 
                         </div> 
                         <div class="col-sm-5">
                            <?php if(isset($_POST['import']) && $error==0 ){?>
                                <p style="font-size: 16px; color:black; "> تم رفع <?php echo ($highestRow-3);?> </p>
                            <?php } ?>
                         </div>  
                        </div> 
                      

                      <div class="col-sm-9 col-sm-offset-3 ">
                        <ul style="font-size: 17px; padding-top:20px">
                            <?php echo $msg;?>
                        </ul>
                      </div>

                         

                   
                         
					</form>
				  </div>
                   

          <div class="col-md-8" id="result">
            
 


        <!-- 
          <h3>  ملف التحميل</h3>
            <table style="width: 100%" border="1">
              <tr>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">المرحلة</th>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">النوع</th>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">لملف</th>
              </tr>
              <tr>
                <td style=" text-align:center">حضانة</td>
                <td style=" text-align:center">شهري</td>
                <td style=" text-align:center"><a href="uploads/cert-demo.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
               <tr>
                <td style=" text-align:center">حضانة</td>
                <td style=" text-align:center">نصف العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo2.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
              <tr>
                <td style=" text-align:center">حضانة</td>
                <td style=" text-align:center">اخر العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo3.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr> 
              <tr>
                <td colspan="3"> </td> 
              </tr>
              <tr >
                <td style=" text-align:center">ابتدائي</td>
                <td style=" text-align:center">شهري</td>
                <td style=" text-align:center"><a href="uploads/cert-demo.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
                <tr>
                <td style=" text-align:center">ابتدائي</td>
                <td style=" text-align:center">نصف العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo5.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
              <tr>
                <td style=" text-align:center">ابتدائي</td>
                <td style=" text-align:center">اخر العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo6.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr> 
              <tr>
                <td colspan="3"> </td> 
              </tr>
              <tr>
                <td style=" text-align:center">اعدادي</td>
                <td style=" text-align:center">شهري</td>
                <td style=" text-align:center"><a href="uploads/cert-demo.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
                 <tr>
                <td style=" text-align:center">اعدادي</td>
                <td style=" text-align:center">نصف العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo8.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
              <tr>
                <td style=" text-align:center">اعدادي</td>
                <td style=" text-align:center">اخر العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo9.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr> 
              <tr>
                <td colspan="3"> </td> 
              </tr>
              <tr>
                <td style=" text-align:center">ثانوي</td>
                <td style=" text-align:center">شهري</td>
                <td style=" text-align:center"><a href="uploads/cert-demo.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
                <tr>
                <td style=" text-align:center">ثانوي</td>
                <td style=" text-align:center">نصف العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo11.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr>
              <tr>
                <td style=" text-align:center">ثانوي</td>
                <td style=" text-align:center">اخر العام</td>
                <td style=" text-align:center"><a href="uploads/cert-demo12.xls" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i>   تحميل</a></td>
              </tr> 
              
            </table>-->

            <!--<hr>
            <h3>المواد الدراسية</h3>
              <?php
              //mysqli_select_db($database, "db"); 
              //$query_get_data = "SELECT * FROM `cert_subjects`   ";
             // $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
              //$row_get_data = mysqli_fetch_assoc($get_data);
              //$totalRows_get_data = mysqli_num_rows($get_data);
              ?>
              <form method="post">
            <table width="100%" border="1">
              <tr>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">المادة بالعربى</th>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">المادة بالفرنسي</th>
                <th style="font-weight: bold; text-align:center; color:black; background-color:darkgray">  مجموع</th>
              </tr>
              <?php //do{?>
                <tr>
                  <td style=" text-align:center">  <?php //echo $row_get_data['name_arb'];?></td>
                  <td style=" text-align:center">  <?php // echo $row_get_data['name_eng'];?></td> 
                  <td style=" text-align:center">  <input type="checkbox" <?php //if($row_get_data['total']==1){echo " checked ";}?> name="check_<?php //echo $row_get_data['id'];?>"  value="1" /> </td> 
              </tr>
              <?php //}while($row_get_data = mysqli_fetch_assoc($get_data));?>
            </table>

            <button type="submit" class="btn btn-success btn-block" name="save" id="save" style="background-color: green;" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
            </form>
              -->
          </div>
                </div>
                
		    </div>
           
			 
			
        </div>
    
		 
		 <?php include("includes/footer.php");?> 
        </div>
 
 
    <?php include("includes/footer-script.php");?> 
    <script src="js/application.min.js"></script>  
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
  
 
	  
	  <script>  
	  $(document).ready(function(){

      $("#court-datatables").DataTable({ 
            dom: 'Bfrtip',
            lengthMenu: [
            [ -1  ],
            [ 'All' ]
              ],
              buttons: [
                'excel','copy',   
                ]

            }); 
  
      $('#demo-inputmask2').on('change', '#target', function (event) {    
        var year = $(this).val();
        if(year<15){
          $("#class_box").fadeIn();
           $.post("get_class2.php",
            {
              year:year
            },
            function(Date,status){ 
                $("#class").html(Date);   
                $("#loading").fadeIn();
            
              $.post("cer_file.php",
                {
                  year:year,
                  class:0
                },
                  function(Date,status){ 
                      $("#result").html(Date); 
                      $("#loading").fadeOut();
                  });
                });
        }else{
           $("#class").prop("selectedIndex", 0);
           $("#class_box").fadeOut(); 
          };
       });


       $('#demo-inputmask2').on('change', '#class', function (event) {    
            var year = $("#target").val(); 
            var clas = $(this).val();
            $("#loading").fadeIn();
            
           $.post("cer_file.php",
            {
              year:year,
              class:clas
            },
            function(Date,status){ 
                $("#result").html(Date); 
                $("#loading").fadeOut();
             });
        
       });
  

	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>