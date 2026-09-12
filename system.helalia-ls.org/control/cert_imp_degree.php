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
                    
                       
                    $subject1_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, removes($row))->getValue()); 
                    $subject2_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, removes($row))->getValue()); 
                    $subject3_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, removes($row))->getValue()); 
                    $subject4_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, removes($row))->getValue()); 
                    $subject5_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, removes($row))->getValue()); 
                    $subject6_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, removes($row))->getValue()); 
                    $subject7_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, removes($row))->getValue()); 
                    $subject8_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, removes($row))->getValue()); 
                    $subject9_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, removes($row))->getValue()); 
                    $subject10_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, removes($row))->getValue()); 
                    $subject11_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, removes($row))->getValue()); 
                    $subject12_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, removes($row))->getValue()); 
                    $subject13_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, removes($row))->getValue()); 
                    $subject14_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, removes($row))->getValue()); 
                    $subject15_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, removes($row))->getValue()); 
                    $subject16_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, removes($row))->getValue()); 
                    $subject17_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, removes($row))->getValue()); 
                    $subject18_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, removes($row))->getValue()); 
                    $subject19_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, removes($row))->getValue()); 
                    $subject20_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, removes($row))->getValue()); 
                    $subject21_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, removes($row))->getValue()); 
                    $subject22_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, removes($row))->getValue()); 
                    $subject23_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, removes($row))->getValue()); 
                    $subject24_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, removes($row))->getValue()); 
                    $subject25_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, removes($row))->getValue()); 
                    $subject26_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, removes($row))->getValue()); 
                    $subject27_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, removes($row))->getValue()); 
                    $subject28_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, removes($row))->getValue()); 
                    $subject29_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, removes($row))->getValue()); 
                    $subject30_degree = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, removes($row))->getValue());    
                   

                     $subject1_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 3)->getValue()); 
                     $subject2_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 3)->getValue()); 
                     $subject3_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 3)->getValue()); 
                     $subject4_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 3)->getValue()); 
                     $subject5_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 3)->getValue()); 
                     $subject6_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 3)->getValue()); 
                     $subject7_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 3)->getValue()); 
                     $subject8_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 3)->getValue()); 
                     $subject9_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 3)->getValue()); 
                     $subject10_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 3)->getValue()); 
                     $subject11_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 3)->getValue()); 
                     $subject12_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 3)->getValue()); 
                     $subject13_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 3)->getValue()); 
                     $subject14_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 3)->getValue()); 
                     $subject15_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 3)->getValue()); 
                     $subject16_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, 3)->getValue());
                     $subject17_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, 3)->getValue());
                     $subject18_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, 3)->getValue());
                     $subject19_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, 3)->getValue());
                     $subject20_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, 3)->getValue());
                     $subject21_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, 3)->getValue()); 
                     $subject22_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, 3)->getValue()); 
                     $subject23_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, 3)->getValue()); 
                     $subject24_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, 3)->getValue()); 
                     $subject25_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, 3)->getValue()); 
                     $subject26_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, 3)->getValue()); 
                     $subject27_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, 3)->getValue()); 
                     $subject28_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, 3)->getValue()); 
                     $subject29_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, 3)->getValue()); 
                     $subject30_degree_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, 3)->getValue());

                     

                    
                      $insertSQL1 = sprintf("INSERT INTO `cert_temp` (
                        `gov_id`, `type`,
                        `subject1_degree`, `subject2_degree`, `subject3_degree`, `subject4_degree`, `subject5_degree`, `subject6_degree`, `subject7_degree`, `subject8_degree`, `subject9_degree`, `subject10_degree`, `subject11_degree`, `subject12_degree`, `subject13_degree`, `subject14_degree`, `subject15_degree`,
                        `subject16_degree`, `subject17_degree`, `subject18_degree`, `subject19_degree`, `subject20_degree`, `subject21_degree`, `subject22_degree`, `subject23_degree`, `subject24_degree`, `subject25_degree`, `subject26_degree`, `subject27_degree`, `subject28_degree`, `subject29_degree`, `subject30_degree`,
                        `subject1_degree_total`, `subject2_degree_total`, `subject3_degree_total`, `subject4_degree_total`, `subject5_degree_total`, `subject6_degree_total`, `subject7_degree_total`, `subject8_degree_total`, `subject9_degree_total`, `subject10_degree_total`, `subject11_degree_total`, `subject12_degree_total`, `subject13_degree_total`, `subject14_degree_total`, `subject15_degree_total`,
                        `subject16_degree_total`, `subject17_degree_total`, `subject18_degree_total`, `subject19_degree_total`, `subject20_degree_total`, `subject21_degree_total`, `subject22_degree_total`, `subject23_degree_total`, `subject24_degree_total`, `subject25_degree_total`, `subject26_degree_total`, `subject27_degree_total`, `subject28_degree_total`, `subject29_degree_total`, `subject30_degree_total`,
                        `user_id` ) VALUES ( 
                            %s, %s,  
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s ) ",

                            GetSQLValueString($database,$gov_id, "text"),   
                            GetSQLValueString($database,$_POST['type'], "int"),    

                            GetSQLValueString($database,$subject1_degree, "text"),  
                            GetSQLValueString($database,$subject2_degree, "text"),  
                            GetSQLValueString($database,$subject3_degree, "text"),  
                            GetSQLValueString($database,$subject4_degree, "text"),  
                            GetSQLValueString($database,$subject5_degree, "text"),  
                            GetSQLValueString($database,$subject6_degree, "text"),  
                            GetSQLValueString($database,$subject7_degree, "text"),  
                            GetSQLValueString($database,$subject8_degree, "text"),  
                            GetSQLValueString($database,$subject9_degree, "text"),  
                            GetSQLValueString($database,$subject10_degree, "text"),  
                            GetSQLValueString($database,$subject11_degree, "text"),  
                            GetSQLValueString($database,$subject12_degree, "text"),  
                            GetSQLValueString($database,$subject13_degree, "text"),  
                            GetSQLValueString($database,$subject14_degree, "text"),  
                            GetSQLValueString($database,$subject15_degree, "text"),  
                            GetSQLValueString($database,$subject16_degree, "text"), 
                            GetSQLValueString($database,$subject17_degree, "text"), 
                            GetSQLValueString($database,$subject18_degree, "text"), 
                            GetSQLValueString($database,$subject19_degree, "text"), 
                            GetSQLValueString($database,$subject20_degree, "text"), 
                            GetSQLValueString($database,$subject21_degree, "text"), 
                            GetSQLValueString($database,$subject22_degree, "text"), 
                            GetSQLValueString($database,$subject23_degree, "text"), 
                            GetSQLValueString($database,$subject24_degree, "text"), 
                            GetSQLValueString($database,$subject25_degree, "text"), 
                            GetSQLValueString($database,$subject26_degree, "text"), 
                            GetSQLValueString($database,$subject27_degree, "text"), 
                            GetSQLValueString($database,$subject28_degree, "text"), 
                            GetSQLValueString($database,$subject29_degree, "text"), 
                            GetSQLValueString($database,$subject30_degree, "text"), 

                            GetSQLValueString($database,$subject1_degree_total, "text"),  
                            GetSQLValueString($database,$subject2_degree_total, "text"),  
                            GetSQLValueString($database,$subject3_degree_total, "text"),  
                            GetSQLValueString($database,$subject4_degree_total, "text"),  
                            GetSQLValueString($database,$subject5_degree_total, "text"),  
                            GetSQLValueString($database,$subject6_degree_total, "text"),  
                            GetSQLValueString($database,$subject7_degree_total, "text"),  
                            GetSQLValueString($database,$subject8_degree_total, "text"),  
                            GetSQLValueString($database,$subject9_degree_total, "text"),  
                            GetSQLValueString($database,$subject10_degree_total, "text"),  
                            GetSQLValueString($database,$subject11_degree_total, "text"),  
                            GetSQLValueString($database,$subject12_degree_total, "text"),  
                            GetSQLValueString($database,$subject13_degree_total, "text"),  
                            GetSQLValueString($database,$subject14_degree_total, "text"),  
                            GetSQLValueString($database,$subject15_degree_total, "text"),  
                            GetSQLValueString($database,$subject16_degree_total, "text"), 
                            GetSQLValueString($database,$subject17_degree_total, "text"), 
                            GetSQLValueString($database,$subject18_degree_total, "text"), 
                            GetSQLValueString($database,$subject19_degree_total, "text"), 
                            GetSQLValueString($database,$subject20_degree_total, "text"), 
                            GetSQLValueString($database,$subject21_degree_total, "text"), 
                            GetSQLValueString($database,$subject22_degree_total, "text"), 
                            GetSQLValueString($database,$subject23_degree_total, "text"), 
                            GetSQLValueString($database,$subject24_degree_total, "text"), 
                            GetSQLValueString($database,$subject25_degree_total, "text"), 
                            GetSQLValueString($database,$subject26_degree_total, "text"), 
                            GetSQLValueString($database,$subject27_degree_total, "text"), 
                            GetSQLValueString($database,$subject28_degree_total, "text"), 
                            GetSQLValueString($database,$subject29_degree_total, "text"), 
                            GetSQLValueString($database,$subject30_degree_total, "text"), 

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
                $query_get_check = "SELECT `gov_id` FROM `certificate` WHERE `gov_id` = '{$row_get_data['gov_id']}' AND `study_year`='{$row_get_gov_id['study_year']}' AND `type`='{$row_get_data['type']}' ";
                $get_check = mysqli_query($database,$query_get_check) or die(mysqli_error($database));
                $row_get_check = mysqli_fetch_assoc($get_check);
                $totalRows_get_check = mysqli_num_rows($get_check);
                 
                    //if($totalRows_get_check>0){ mysqli_query($database, " DELETE FROM `certificate` WHERE `gov_id` = '{$row_get_data['gov_id']}' AND `study_year`='{$row_get_gov_id['study_year']}'  AND `type`='{$row_get_data['type']}'   ");  }

                $updateSQL = sprintf("UPDATE `certificate` SET   
                        `subject1_degree`=%s, `subject2_degree`=%s, `subject3_degree`=%s, `subject4_degree`=%s, `subject5_degree`=%s, `subject6_degree`=%s, `subject7_degree`=%s, `subject8_degree`=%s, `subject9_degree`=%s, `subject10_degree`=%s, `subject11_degree`=%s, `subject12_degree`=%s, `subject13_degree`=%s, `subject14_degree`=%s, `subject15_degree`=%s,
                        `subject16_degree`=%s, `subject17_degree`=%s, `subject18_degree`=%s, `subject19_degree`=%s, `subject20_degree`=%s, `subject21_degree`=%s, `subject22_degree`=%s, `subject23_degree`=%s, `subject24_degree`=%s, `subject25_degree`=%s, `subject26_degree`=%s, `subject27_degree`=%s, `subject28_degree`=%s, `subject29_degree`=%s, `subject30_degree`=%s,
                        `subject1_degree_total`=%s, `subject2_degree_total`=%s, `subject3_degree_total`=%s, `subject4_degree_total`=%s, `subject5_degree_total`=%s, `subject6_degree_total`=%s, `subject7_degree_total`=%s, `subject8_degree_total`=%s, `subject9_degree_total`=%s, `subject10_degree_total`=%s, `subject11_degree_total`=%s, `subject12_degree_total`=%s, `subject13_degree_total`=%s, `subject14_degree_total`=%s, `subject15_degree_total`=%s,
                        `subject16_degree_total`=%s, `subject17_degree_total`=%s, `subject18_degree_total`=%s, `subject19_degree_total`=%s, `subject20_degree_total`=%s, `subject21_degree_total`=%s, `subject22_degree_total`=%s, `subject23_degree_total`=%s, `subject24_degree_total`=%s, `subject25_degree_total`=%s, `subject26_degree_total`=%s, `subject27_degree_total`=%s, `subject28_degree_total`=%s, `subject29_degree_total`=%s, `subject30_degree_total`=%s
                        WHERE `gov_id` = %s AND `study_year`= %s  AND `type` =%s ",    

                        GetSQLValueString($database,$row_get_data['subject1_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject2_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject3_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject4_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject5_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject6_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject7_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject8_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject9_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject10_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject11_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject12_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject13_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject14_degree'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject15_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject16_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject17_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject18_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject19_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject20_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject21_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject22_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject23_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject24_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject25_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject26_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject27_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject28_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject29_degree'], "text"),
                        GetSQLValueString($database,$row_get_data['subject30_degree'], "text"), 

                        GetSQLValueString($database,$row_get_data['subject1_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject2_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject3_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject4_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject5_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject6_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject7_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject8_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject9_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject10_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject11_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject12_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject13_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject14_degree_total'], "text"),  
                        GetSQLValueString($database,$row_get_data['subject15_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject16_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject17_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject18_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject19_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject20_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject21_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject22_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject23_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject24_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject25_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject26_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject27_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject28_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject29_degree_total'], "text"),
                        GetSQLValueString($database,$row_get_data['subject30_degree_total'], "text"),  

                       
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
                <h4>         تحميل الدرجة الفعلية  </h4>
            </div>
          </div>
			<div class="row">  
				<div class="col-md-4">
				  <div class="demo-form-wrapper"> 
                    <form action="cert_imp_degree.php" method="POST" name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">
                    
  
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  تحميل  <span class="required" style="color:red">*</span></label>
              <div class="col-sm-5">
              <input type="file" required name="excel" accept=".xls,.xlsx"   class="form-control" />  
                <small style="color:browne">الملف Excel فقط <a href="uploads/degree.xlsx">Demo</a></small>
                
              </div>

             

            </div>  
                 
 
            <div class="form-group">
						<label class="col-sm-3 control-label" for="type"> النوع  </label>
						<div class="col-sm-4">
                
                <input type="radio" name="type" value="2" checked   > نصف العام    
                <input type="radio" name="type" value="3"    > اخر العام     
						</div>
            </div> 

 
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