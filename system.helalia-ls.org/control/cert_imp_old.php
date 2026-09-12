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


function total_subject($subject,$study_year)
{
    global $database;
    $query_get_data = "SELECT `total` FROM `subjects` WHERE `name`='{$subject}' AND `study_year` = '{$study_year}' ";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data); 
    return $row_get_data['total'];
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

            for($row=5; $row<=$highestRow; $row++)
                {  
 
                  $name =  mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(0, removes($row))->getValue());   
                  
                  mysqli_select_db($database, "db"); 
                  $query_get_gov_id = "SELECT `gov_id`, `class` FROM `kids` WHERE `name` = '{$name}' AND `study_year` = '{$_POST['target']}' ";
                  $get_gov_id = mysqli_query($database,$query_get_gov_id) or die(mysqli_error($database));
                  $row_get_gov_id = mysqli_fetch_assoc($get_gov_id);
                  $totalRows_get_gov_id = mysqli_num_rows($get_gov_id); 
                  
                  if($totalRows_get_gov_id==1){
                     
                     $gov_id = $row_get_gov_id['gov_id'];
                    

                     if($gov_id!=NULL && $gov_id>0 && strlen($gov_id)==14){

                     $subject1 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, removes($row))->getValue()); 
                     $subject2 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, removes($row))->getValue()); 
                     $subject3 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, removes($row))->getValue()); 
                     $subject4 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, removes($row))->getValue()); 
                     $subject5 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, removes($row))->getValue()); 
                     $subject6 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, removes($row))->getValue()); 
                     $subject7 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, removes($row))->getValue()); 
                     $subject8 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, removes($row))->getValue()); 
                     $subject9 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, removes($row))->getValue()); 
                     $subject10 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, removes($row))->getValue()); 
                     $subject11 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, removes($row))->getValue()); 
                     $subject12 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, removes($row))->getValue()); 
                     $subject13 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, removes($row))->getValue()); 
                     $subject14 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, removes($row))->getValue()); 
                     $subject15 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, removes($row))->getValue()); 
                     $subject16 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, removes($row))->getValue()); 
                     $subject17 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, removes($row))->getValue()); 
                     $subject18 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, removes($row))->getValue()); 
                     $subject19 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, removes($row))->getValue()); 
                     $subject20 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, removes($row))->getValue()); 
                     $subject21 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, removes($row))->getValue()); 
                     $subject22 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, removes($row))->getValue()); 
                     $subject23 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, removes($row))->getValue()); 
                     $subject24 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, removes($row))->getValue()); 
                     $subject25 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, removes($row))->getValue()); 
                     $subject26 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, removes($row))->getValue()); 
                     $subject27 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, removes($row))->getValue()); 
                     $subject28 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, removes($row))->getValue()); 
                     $subject29 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, removes($row))->getValue()); 
                     $subject30 = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, removes($row))->getValue()); 

                       
                     $subject1_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 3)->getValue()); 
                     $subject2_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 3)->getValue()); 
                     $subject3_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 3)->getValue()); 
                     $subject4_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 3)->getValue()); 
                     $subject5_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 3)->getValue()); 
                     $subject6_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 3)->getValue()); 
                     $subject7_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 3)->getValue()); 
                     $subject8_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 3)->getValue()); 
                     $subject9_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 3)->getValue()); 
                     $subject10_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 3)->getValue()); 
                     $subject11_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 3)->getValue()); 
                     $subject12_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 3)->getValue()); 
                     $subject13_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 3)->getValue()); 
                     $subject14_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 3)->getValue()); 
                     $subject15_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 3)->getValue());                       
                     $subject16_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, 3)->getValue()); 
                     $subject17_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, 3)->getValue()); 
                     $subject18_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, 3)->getValue()); 
                     $subject19_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, 3)->getValue()); 
                     $subject20_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, 3)->getValue()); 
                     $subject21_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, 3)->getValue()); 
                     $subject22_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, 3)->getValue()); 
                     $subject23_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, 3)->getValue()); 
                     $subject24_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, 3)->getValue()); 
                     $subject25_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, 3)->getValue()); 
                     $subject26_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, 3)->getValue()); 
                     $subject27_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, 3)->getValue()); 
                     $subject28_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, 3)->getValue()); 
                     $subject29_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, 3)->getValue()); 
                     $subject30_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, 3)->getValue()); 


                     $subject1_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 4)->getValue()); 
                     $subject2_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 4)->getValue()); 
                     $subject3_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 4)->getValue()); 
                     $subject4_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 4)->getValue()); 
                     $subject5_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 4)->getValue()); 
                     $subject6_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 4)->getValue()); 
                     $subject7_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 4)->getValue()); 
                     $subject8_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 4)->getValue()); 
                     $subject9_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 4)->getValue()); 
                     $subject10_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 4)->getValue()); 
                     $subject11_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 4)->getValue()); 
                     $subject12_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 4)->getValue()); 
                     $subject13_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 4)->getValue()); 
                     $subject14_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 4)->getValue()); 
                     $subject15_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 4)->getValue()); 
                     $subject16_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(16, 4)->getValue());
                     $subject17_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(17, 4)->getValue());
                     $subject18_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(18, 4)->getValue());
                     $subject19_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(19, 4)->getValue());
                     $subject20_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(20, 4)->getValue());
                     $subject21_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(21, 4)->getValue()); 
                     $subject22_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(22, 4)->getValue()); 
                     $subject23_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(23, 4)->getValue()); 
                     $subject24_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(24, 4)->getValue()); 
                     $subject25_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(25, 4)->getValue()); 
                     $subject26_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(26, 4)->getValue()); 
                     $subject27_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(27, 4)->getValue()); 
                     $subject28_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(28, 4)->getValue()); 
                     $subject29_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(29, 4)->getValue()); 
                     $subject30_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(30, 4)->getValue()); 

                     if($_POST['class']!=0 && $_POST['class']!=NULL){$class = $_POST['class'];}else{$class = $row_get_gov_id['class'];}
                      
                       
                      $insertSQL1 = sprintf("INSERT INTO `cert_temp` (
                        `gov_id`, `date`, `year`, `title_eng`, `title_arb`, `title_frn`, `study_year`, `class`, `type`,
                        `subject1`, `subject2`, `subject3`, `subject4`, `subject5`, `subject6`, `subject7`, `subject8`, `subject9`, `subject10`, `subject11`, `subject12`, `subject13`, `subject14`, `subject15`,
                        `subject16`, `subject17`, `subject18`, `subject19`, `subject20`, `subject21`, `subject22`, `subject23`, `subject24`, `subject25`, `subject26`, `subject27`, `subject28`, `subject29`, `subject30`,
                        `subject1_total`, `subject2_total`, `subject3_total`, `subject4_total`, `subject5_total`, `subject6_total`, `subject7_total`, `subject8_total`, `subject9_total`, `subject10_total`, `subject11_total`, `subject12_total`, `subject13_total`, `subject14_total`, `subject15_total`,
                        `subject16_total`, `subject17_total`, `subject18_total`, `subject19_total`, `subject20_total`, `subject21_total`, `subject22_total`, `subject23_total`, `subject24_total`, `subject25_total`, `subject26_total`, `subject27_total`, `subject28_total`, `subject29_total`, `subject30_total`,
                        `subject1_name`, `subject2_name`, `subject3_name`, `subject4_name`, `subject5_name`, `subject6_name`, `subject7_name`, `subject8_name`, `subject9_name`, `subject10_name`, `subject11_name`, `subject12_name`, `subject13_name`, `subject14_name`, `subject15_name`,
                        `subject16_name`, `subject17_name`, `subject18_name`, `subject19_name`, `subject20_name`, `subject21_name`, `subject22_name`, `subject23_name`, `subject24_name`, `subject25_name`, `subject26_name`, `subject27_name`, `subject28_name`, `subject29_name`, `subject30_name`,
                        `subject1_count`, `subject2_count`, `subject3_count`, `subject4_count`, `subject5_count`, `subject6_count`, `subject7_count`, `subject8_count`, `subject9_count`, `subject10_count`, `subject11_count`, `subject12_count`, `subject13_count`, `subject14_count`, `subject15_count`,
                        `subject16_count`, `subject17_count`, `subject18_count`, `subject19_count`, `subject20_count`, `subject21_count`, `subject22_count`, `subject23_count`, `subject24_count`, `subject25_count`, `subject26_count`, `subject27_count`, `subject28_count`, `subject29_count`, `subject30_count`,
                        `user_id` ) VALUES ( 
                            %s, %s, %s, %s, %s, %s, %s, %s ,%s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,

                            %s ) ",
                            GetSQLValueString($database,$database,$gov_id, "text"),  
                            GetSQLValueString($database,$database,time(), "int"), 
                            GetSQLValueString($database,$database,date("Y",time()), "int"), 
                            GetSQLValueString($database,$database,$_POST['title_eng'], "text"),  
                            GetSQLValueString($database,$database,$_POST['title_arb'], "text"),  
                            GetSQLValueString($database,$database,$_POST['title_frn'], "text"),  
                            GetSQLValueString($database,$database,$_POST['target'], "int"),  
                            GetSQLValueString($database,$database,$class, "int"),  
                            GetSQLValueString($database,$database,$_POST['type'], "int"),  
    
                            GetSQLValueString($database,$database,removes($subject1), "text"),  
                            GetSQLValueString($database,$database,removes($subject2), "text"),   
                            GetSQLValueString($database,$database,removes($subject3), "text"),  
                            GetSQLValueString($database,$database,removes($subject4), "text"),   
                            GetSQLValueString($database,$database,removes($subject5), "text"),  
                            GetSQLValueString($database,$database,removes($subject6), "text"),   
                            GetSQLValueString($database,$database,removes($subject7), "text"),    
                            GetSQLValueString($database,$database,removes($subject8), "text"),    
                            GetSQLValueString($database,$database,removes($subject9), "text"),    
                            GetSQLValueString($database,$database,removes($subject10), "text"),   
                            GetSQLValueString($database,$database,removes($subject11), "text"),    
                            GetSQLValueString($database,$database,removes($subject12), "text"),    
                            GetSQLValueString($database,$database,removes($subject13), "text"),    
                            GetSQLValueString($database,$database,removes($subject14), "text"),    
                            GetSQLValueString($database,$database,removes($subject15), "text"), 
                            GetSQLValueString($database,$database,removes($subject16), "text"),
                            GetSQLValueString($database,$database,removes($subject17), "text"),
                            GetSQLValueString($database,$database,removes($subject18), "text"),
                            GetSQLValueString($database,$database,removes($subject19), "text"),
                            GetSQLValueString($database,$database,removes($subject20), "text"),
                            GetSQLValueString($database,$database,removes($subject21), "text"),
                            GetSQLValueString($database,$database,removes($subject22), "text"),
                            GetSQLValueString($database,$database,removes($subject23), "text"),
                            GetSQLValueString($database,$database,removes($subject24), "text"),
                            GetSQLValueString($database,$database,removes($subject25), "text"),
                            GetSQLValueString($database,$database,removes($subject26), "text"),
                            GetSQLValueString($database,$database,removes($subject27), "text"),
                            GetSQLValueString($database,$database,removes($subject28), "text"),
                            GetSQLValueString($database,$database,removes($subject29), "text"),
                            GetSQLValueString($database,$database,removes($subject30), "text"),

                            GetSQLValueString($database,$database,removes($subject1_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject2_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject3_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject4_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject5_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject6_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject7_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject8_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject9_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject10_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject11_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject12_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject13_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject14_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject15_total), "text"),  
                            GetSQLValueString($database,$database,removes($subject16_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject17_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject18_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject19_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject20_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject21_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject22_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject23_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject24_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject25_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject26_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject27_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject28_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject29_total), "text"), 
                            GetSQLValueString($database,$database,removes($subject30_total), "text"), 

                            GetSQLValueString($database,$database,$subject1_name, "text"),  
                            GetSQLValueString($database,$database,$subject2_name, "text"),  
                            GetSQLValueString($database,$database,$subject3_name, "text"),  
                            GetSQLValueString($database,$database,$subject4_name, "text"),  
                            GetSQLValueString($database,$database,$subject5_name, "text"),  
                            GetSQLValueString($database,$database,$subject6_name, "text"),  
                            GetSQLValueString($database,$database,$subject7_name, "text"),  
                            GetSQLValueString($database,$database,$subject8_name, "text"),  
                            GetSQLValueString($database,$database,$subject9_name, "text"),  
                            GetSQLValueString($database,$database,$subject10_name, "text"),  
                            GetSQLValueString($database,$database,$subject11_name, "text"),  
                            GetSQLValueString($database,$database,$subject12_name, "text"),  
                            GetSQLValueString($database,$database,$subject13_name, "text"),  
                            GetSQLValueString($database,$database,$subject14_name, "text"),  
                            GetSQLValueString($database,$database,$subject15_name, "text"), 
                            GetSQLValueString($database,$database,$subject16_name, "text"), 
                            GetSQLValueString($database,$database,$subject17_name, "text"), 
                            GetSQLValueString($database,$database,$subject18_name, "text"), 
                            GetSQLValueString($database,$database,$subject19_name, "text"), 
                            GetSQLValueString($database,$database,$subject20_name, "text"), 
                            GetSQLValueString($database,$database,$subject21_name, "text"), 
                            GetSQLValueString($database,$database,$subject22_name, "text"), 
                            GetSQLValueString($database,$database,$subject23_name, "text"), 
                            GetSQLValueString($database,$database,$subject24_name, "text"), 
                            GetSQLValueString($database,$database,$subject25_name, "text"), 
                            GetSQLValueString($database,$database,$subject26_name, "text"), 
                            GetSQLValueString($database,$database,$subject27_name, "text"), 
                            GetSQLValueString($database,$database,$subject28_name, "text"), 
                            GetSQLValueString($database,$database,$subject29_name, "text"), 
                            GetSQLValueString($database,$database,$subject30_name, "text"), 

                            GetSQLValueString($database,$database,total_subject($subject1_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject2_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject3_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject4_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject5_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject6_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject7_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject8_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject9_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject10_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject11_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject12_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject13_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject14_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject15_name,$_POST['target']), "int"),  
                            GetSQLValueString($database,$database,total_subject($subject16_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject17_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject18_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject19_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject20_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject21_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject22_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject23_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject24_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject25_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject26_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject27_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject28_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject29_name,$_POST['target']), "int"), 
                            GetSQLValueString($database,$database,total_subject($subject30_name,$_POST['target']), "int"), 
    
                            GetSQLValueString($database,$database,$row_get_login['id'], "int")); 
                          
                      mysqli_select_db($database, "db");  
                      $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
                    }else{
                        $error++;
                        mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ");  
                        $msg.= "<li style='color:red;'> $name  $gov_id خطى بالرقم القومي </li> ";
                        break;
                    } 


                  }else{ 
                    if($name!=NULL){ 
                      $error++;
                      mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ");
                      $msg.= "<li style='color:red;'>     الاسم غير صحيح  : <b>{$name}</b> </li> "; 
                      break; 
                    }
                   } 
                } 

 

                mysqli_select_db($database, "db"); 
                $query_get_data = "SELECT `gov_id`, COUNT(gov_id) as `dub` FROM `cert_temp` GROUP BY `gov_id` HAVING COUNT(gov_id) > 1 ";
                $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                $row_get_data = mysqli_fetch_assoc($get_data);
                $totalRows_get_data = mysqli_num_rows($get_data);
                
                 if($row_get_data['dub']>1 && $totalRows_get_data>0){
                    $msg.= "<li style='color:red;'> <b>{$row_get_data['gov_id']}</b> :    الرقم القومي مكرر   </li> ";
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
                 
                 

                $insertSQL2 = sprintf("INSERT INTO `certificate` (
                    `gov_id`, `date`, `year`, `title_eng`, `title_arb`, `title_frn`, `study_year`, `class`, `type`,
                        `subject1`, `subject2`, `subject3`, `subject4`, `subject5`, `subject6`, `subject7`, `subject8`, `subject9`, `subject10`, `subject11`, `subject12`, `subject13`, `subject14`, `subject15`,
                        `subject16`, `subject17`, `subject18`, `subject19`, `subject20`, `subject21`, `subject22`, `subject23`, `subject24`, `subject25`, `subject26`, `subject27`, `subject28`, `subject29`, `subject30`,
                        `subject1_total`, `subject2_total`, `subject3_total`, `subject4_total`, `subject5_total`, `subject6_total`, `subject7_total`, `subject8_total`, `subject9_total`, `subject10_total`, `subject11_total`, `subject12_total`, `subject13_total`, `subject14_total`, `subject15_total`,
                        `subject16_total`, `subject17_total`, `subject18_total`, `subject19_total`, `subject20_total`, `subject21_total`, `subject22_total`, `subject23_total`, `subject24_total`, `subject25_total`, `subject26_total`, `subject27_total`, `subject28_total`, `subject29_total`, `subject30_total`,
                        `subject1_name`, `subject2_name`, `subject3_name`, `subject4_name`, `subject5_name`, `subject6_name`, `subject7_name`, `subject8_name`, `subject9_name`, `subject10_name`, `subject11_name`, `subject12_name`, `subject13_name`, `subject14_name`, `subject15_name`,
                        `subject16_name`, `subject17_name`, `subject18_name`, `subject19_name`, `subject20_name`, `subject21_name`, `subject22_name`, `subject23_name`, `subject24_name`, `subject25_name`, `subject26_name`, `subject27_name`, `subject28_name`, `subject29_name`, `subject30_name`,
                        `subject1_count`, `subject2_count`, `subject3_count`, `subject4_count`, `subject5_count`, `subject6_count`, `subject7_count`, `subject8_count`, `subject9_count`, `subject10_count`, `subject11_count`, `subject12_count`, `subject13_count`, `subject14_count`, `subject15_count`,
                        `subject16_count`, `subject17_count`, `subject18_count`, `subject19_count`, `subject20_count`, `subject21_count`, `subject22_count`, `subject23_count`, `subject24_count`, `subject25_count`, `subject26_count`, `subject27_count`, `subject28_count`, `subject29_count`, `subject30_count`,
                    `user_id` ) VALUES ( 
                        %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s ) ",
                        GetSQLValueString($database,$database,$row_get_data['gov_id'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['date'], "int"), 
                        GetSQLValueString($database,$database,$row_get_data['year'], "int"), 
                        GetSQLValueString($database,$database,$_POST['title_eng'], "text"),  
                        GetSQLValueString($database,$database,$_POST['title_arb'], "text"),  
                        GetSQLValueString($database,$database,$_POST['title_frn'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['study_year'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['class'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['type'], "int"),  

                        GetSQLValueString($database,$database,removes($row_get_data['subject1']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject2']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject3']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject4']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject5']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject6']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject7']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject8']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject9']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject10']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject11']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject12']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject13']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject14']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject15']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject16']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject17']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject18']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject19']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject20']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject21']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject22']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject23']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject24']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject25']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject26']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject27']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject28']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject29']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject30']), "text"),   


                        GetSQLValueString($database,$database,removes($row_get_data['subject1_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject2_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject3_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject4_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject5_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject6_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject7_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject8_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject9_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject10_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject11_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject12_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject13_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject14_total']), "text"),  
                        GetSQLValueString($database,$database,removes($row_get_data['subject15_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject16_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject17_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject18_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject19_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject20_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject21_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject22_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject23_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject24_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject25_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject26_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject27_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject28_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject29_total']), "text"), 
                        GetSQLValueString($database,$database,removes($row_get_data['subject30_total']), "text"), 

                        GetSQLValueString($database,$database,$row_get_data['subject1_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject2_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject3_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject4_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject5_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject6_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject7_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject8_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject9_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject10_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject11_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject12_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject13_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject14_name'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['subject15_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject16_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject17_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject18_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject19_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject20_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject21_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject22_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject23_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject24_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject25_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject26_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject27_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject28_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject29_name'], "text"),
                        GetSQLValueString($database,$database,$row_get_data['subject30_name'], "text"),

                        GetSQLValueString($database,$database,$row_get_data['subject1_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject2_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject3_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject4_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject5_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject6_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject7_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject8_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject9_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject10_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject11_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject12_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject13_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject14_count'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['subject15_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject16_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject17_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject18_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject19_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject20_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject21_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject22_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject23_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject24_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject25_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject26_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject27_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject28_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject29_count'], "int"),
                        GetSQLValueString($database,$database,$row_get_data['subject30_count'], "int"),

                        GetSQLValueString($database,$database,$row_get_login['id'], "int")); 
                      
                  mysqli_select_db($database, "db");  
                  $Result2 = mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
                 

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
                    <form action="cert_imp.php" method="POST" name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">
                    
 
		       <div class="form-group">
              <label class="col-sm-3 control-label" for="title_arb">  العنوان عربي   </label>
              <div class="col-sm-6">
                <input id="title_arb" class="form-control"  type="text" name="title_arb" required >
              </div>
            </div>  
 
            <div class="form-group">
              <label class="col-sm-3 control-label" for="title_eng">  العنوان الانجليزي  </label>
              <div class="col-sm-6">
                <input id="title_eng" class="form-control" type="text" style="text-align: left;" name="title_eng" required >
              </div>
            </div>

            <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="title_frn">  العنوان الفرنسي  </label>
              <div class="col-sm-6"> 
                <input id="title_frn" class="form-control" style="text-align: left;"  type="text" name="title_frn"   >
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  تحميل  <span class="required" style="color:red">*</span></label>
              <div class="col-sm-5">
              <input type="file" required name="excel" accept=".xls,.xlsx"   class="form-control" />  
                <small style="color:browne">الملف Excel فقط</small>
                
              </div>

             

            </div>  
                 
 
            <div class="form-group">
						<label class="col-sm-3 control-label" for="type"> النوع  </label>
						<div class="col-sm-4">
              <input type="radio" name="type" value="1" checked > شهري   <input type="radio" name="type" value="2" disabled   > نصف العام    <input type="radio" name="type" value="1" disabled  > اخر العام     
						</div>
            </div> 

            
            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" name="target"  id="target"  >
                      <option selected   >...</option>  
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

            <i class="fa fa-spinner fa-spin fa-3x fa-fw" id="loading" style="margin-right: 150px; display:none"></i>
					  </div>          
    


            
 
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-success btn-block" name="import" id="submit1" style="background-color: green;" ><i class="fa fa-upload" aria-hidden="true"></i> تحميل</button> 
                         </div> 
                         <div class="col-sm-5">
                            <?php if(isset($_POST['import']) && $error==0 ){?>
                                <p style="font-size: 16px; color:black; "> تم رفع <?php echo ($highestRow-4);?> </p>
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