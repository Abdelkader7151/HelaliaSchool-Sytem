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
  $step17=str_replace(".",",",$step16); 
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

            for($row=3; $row<=$highestRow; $row++)
                {  
 
                  $name =  mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(0, removes($row))->getValue());   
                  
                  mysqli_select_db($database, "db"); 
                  $query_get_gov_id = "SELECT `gov_id` FROM `kids` WHERE `name` = '{$name}' AND `study_year` = '{$_POST['target']}' ";
                  $get_gov_id = mysqli_query($database,$query_get_gov_id) or die(mysqli_error($database));
                  $row_get_gov_id = mysqli_fetch_assoc($get_gov_id);
                  $totalRows_get_gov_id = mysqli_num_rows($get_gov_id); 
                  
                  if($totalRows_get_gov_id==1){
                     //$gov_id = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
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
                       
                     $subject1_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 1)->getValue()); 
                     $subject2_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 1)->getValue()); 
                     $subject3_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 1)->getValue()); 
                     $subject4_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 1)->getValue()); 
                     $subject5_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 1)->getValue()); 
                     $subject6_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 1)->getValue()); 
                     $subject7_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 1)->getValue()); 
                     $subject8_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 1)->getValue()); 
                     $subject9_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 1)->getValue()); 
                     $subject10_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 1)->getValue()); 
                     $subject11_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 1)->getValue()); 
                     $subject12_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 1)->getValue()); 
                     $subject13_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 1)->getValue()); 
                     $subject14_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 1)->getValue()); 
                     $subject15_name = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 1)->getValue());   

                     $subject1_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(1, 2)->getValue()); 
                     $subject2_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(2, 2)->getValue()); 
                     $subject3_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(3, 2)->getValue()); 
                     $subject4_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(4, 2)->getValue()); 
                     $subject5_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(5, 2)->getValue()); 
                     $subject6_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(6, 2)->getValue()); 
                     $subject7_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(7, 2)->getValue()); 
                     $subject8_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(8, 2)->getValue()); 
                     $subject9_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(9, 2)->getValue()); 
                     $subject10_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(10, 2)->getValue()); 
                     $subject11_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(11, 2)->getValue()); 
                     $subject12_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(12, 2)->getValue()); 
                     $subject13_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(13, 2)->getValue()); 
                     $subject14_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(14, 2)->getValue()); 
                     $subject15_total = mysqli_real_escape_string($database, $worksheet->getCellByColumnAndRow(15, 2)->getValue());
 
                       
                      $insertSQL1 = sprintf("INSERT INTO `cert_temp` (
                        `gov_id`, `date`, `year`, `title`, `study_year`, `class`,
                        `subject1`, `subject2`, `subject3`, `subject4`, `subject5`, `subject6`, `subject7`, `subject8`, `subject9`, `subject10`, `subject11`, `subject12`, `subject13`, `subject14`, `subject15`,
                        `subject1_total`, `subject2_total`, `subject3_total`, `subject4_total`, `subject5_total`, `subject6_total`, `subject7_total`, `subject8_total`, `subject9_total`, `subject10_total`, `subject11_total`, `subject12_total`, `subject13_total`, `subject14_total`, `subject15_total`,
                        `subject1_name`, `subject2_name`, `subject3_name`, `subject4_name`, `subject5_name`, `subject6_name`, `subject7_name`, `subject8_name`, `subject9_name`, `subject10_name`, `subject11_name`, `subject12_name`, `subject13_name`, `subject14_name`, `subject15_name`,
                        `user_id` ) VALUES ( 
                            %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                            %s ) ",
                            GetSQLValueString($database,$database,$gov_id, "text"),  
                            GetSQLValueString($database,$database,time(), "int"), 
                            GetSQLValueString($database,$database,date("Y",time()), "int"), 
                            GetSQLValueString($database,$database,$_POST['title'], "text"),  
                            GetSQLValueString($database,$database,$_POST['target'], "int"),  
                            GetSQLValueString($database,$database,$_POST['class'], "int"),  
    
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
    
                            GetSQLValueString($database,$database,$row_get_login['id'], "int")); 
                          
                      mysqli_select_db($database, "db");  
                      $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
                    }else{
                        $error++;
                        mysqli_query($database, " DELETE FROM `cert_temp` WHERE `user_id` = '{$row_get_login['id']}' ");  
                        $msg.= "<li style='color:red;'> خطى بالرقم القومي </li> ";
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
                    `gov_id`, `date`, `year`, `title`, `study_year`, `class`,
                    `subject1`, `subject2`, `subject3`, `subject4`, `subject5`, `subject6`, `subject7`, `subject8`, `subject9`, `subject10`, `subject11`, `subject12`, `subject13`, `subject14`, `subject15`,
                    `subject1_total`, `subject2_total`, `subject3_total`, `subject4_total`, `subject5_total`, `subject6_total`, `subject7_total`, `subject8_total`, `subject9_total`, `subject10_total`, `subject11_total`, `subject12_total`, `subject13_total`, `subject14_total`, `subject15_total`,
                    `subject1_name`, `subject2_name`, `subject3_name`, `subject4_name`, `subject5_name`, `subject6_name`, `subject7_name`, `subject8_name`, `subject9_name`, `subject10_name`, `subject11_name`, `subject12_name`, `subject13_name`, `subject14_name`, `subject15_name`,
                    `user_id` ) VALUES ( 
                        %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                        %s ) ",
                        GetSQLValueString($database,$database,$row_get_data['gov_id'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['date'], "int"), 
                        GetSQLValueString($database,$database,$row_get_data['year'], "int"), 
                        GetSQLValueString($database,$database,$row_get_data['title'], "text"),  
                        GetSQLValueString($database,$database,$row_get_data['study_year'], "int"),  
                        GetSQLValueString($database,$database,$row_get_data['class'], "int"),  

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

                        GetSQLValueString($database,$database,$row_get_login['id'], "int")); 
                      
                  mysqli_select_db($database, "db");  
                  $Result2 = mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
                 

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
                <h4>         تحميل نتيجة  </h4>
            </div>
          </div>
			<div class="row">  
				<div class="col-md-6">
				  <div class="demo-form-wrapper"> 
                    <form action="cert_imp.php" method="POST" name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">
                    
 
		    <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  العنوان  </label>
              <div class="col-sm-6">
                <input id="name" class="form-control"      type="text" name="title" >
              </div>
            </div>  
 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  تحميل  <span class="required" style="color:red">*</span></label>
              <div class="col-sm-5">
              <input type="file" required name="excel"   accept=".xls,.xlsx"   class="form-control" />  
                <small style="color:browne">الملف Excel فقط</small>
                
              </div>

              <div class="col-sm-4" style="padding-top: 5px;" align="center">
                                <a href="uploads/cert-demo.xlsx" ><i class="fa fa-file-excel-o" style="color: green;" aria-hidden="true"></i> Download Demo</a>
                         </div>

            </div>  
                 
 
            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control"   name="target"  id="target"  >
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

					  </div>          
    
 
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-success btn-block" name="import" id="submit1" style="background-color: green;" ><i class="fa fa-upload" aria-hidden="true"></i> تحميل</button> 
                         </div> 
                         <div class="col-sm-5">
                            <?php if(isset($_POST['import']) && $error==0 ){?>
                                <p style="font-size: 16px; color:black; "> تم رفع <?php echo ($highestRow-2);?> </p>
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
                   

                </div>
                
		    </div>
           
			 
			
        </div>
    
		 
		 <?php include("includes/footer.php");?> 
        </div>
 
    
      
 
 
	  
    <?php include("includes/footer-script.php");?> 
    <script src="js/application.min.js"></script>
  
 
	  
	  <script>

      
	  $(document).ready(function(){


  
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
             });
        }else{
           $("#class").prop("selectedIndex", 0);
           $("#class_box").fadeOut(); 
          };
       });



      
      $("#study_year").change(function(){
                if($(this).val()==13 || $(this).val()==14){
                    $("#study_type_box").fadeIn();
                  } else {
                    $("#study_type_box").fadeOut();
                    $("#study_type").prop("selectedIndex", 0);
                  } 
                    var year = $(this).val(); 
                      $.post("get_class.php",
                                    {
                                      year:year
                                    },
                                        function(Date,status){  
                                            $("#study_year_class").html(Date); 
                                    }); 
   

});
 


      $('#demo-inputmask2').on('change', '#study_year', function (event) {   
			  var study_year = $("#study_year").val();  
			  $.post("study_year_class.php",
			  {
          study_year:study_year
		    },
            function(Date,status){ 
                $("#study_year_class").html(Date); 
             }); 
        }); 

        $('#demo-inputmask2').on('blur', '#gov_id', function (event) { 
			  // event.preventDefault(); 
           
			  var gov = $("#gov_id").val();  
			  $.post("check-gov2.php",
			  {
          gov:gov
		    },
            function(Date,status){ 

                 if(Date>0){
                    $("#gov_id_warn2").fadeIn();  
                    $("#submit").attr('disabled', 'disabled');
                 }else{
                    $("#gov_id_warn2").fadeOut();   
                    $("#submit").removeAttr("disabled");
                  }
                  
         }); 


        var gov_id = $("#gov_id").val().length; 
        if(gov_id<14 || gov_id>14){  
          $("#gov_id_warn1").fadeIn(); 
           } else{ 
            $.post("age_october.php",
                {
                  gov:gov
                },
                    function(Date,status){  
                        $("#birthday_october").text(Date); 
                });   
            } 

	        });




      
       











		    function readURL(input) {
			  if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
				  $('#blah').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]); // convert to base64 string
			  }
           }

		 
		  
 $("#access7").click(function(){
    if($(this).is(":checked")){
      $(".access7").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access7").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
});    

$(".access7").click(function(){
   $("#access7").prop( "checked", true ); 
});   


$("#access9").click(function(){
    if($(this).is(":checked")){
      $(".access9").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access9").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
}); 


$(".access9").click(function(){
   $("#access9").prop( "checked", true ); 
});  



$("#access5").click(function(){
    if($(this).is(":checked")){
      $(".access5").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access5").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
});   

$(".access5").click(function(){
   $("#access5").prop( "checked", true ); 
});  
		  
		  
		  
	<?php if(isset($_GET['done'])){?>	  
		  Command: toastr["success"](" تم اضافة بنجاح") 
		  
 toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-left",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
<?php }?>		  
      

$("#submit").click(function(){ 
  var gov_id = $("#gov_id").val().length; 
  if(gov_id<14 || gov_id>14){  
    event.preventDefault(); 
    $("#gov_id_warn1").fadeIn(); 
  } 
});

$("#gov_id").keydown(function(){
  $("#gov_id_warn1").fadeOut(); 
  $("#gov_id_warn2").fadeOut(); 
});
 


	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>