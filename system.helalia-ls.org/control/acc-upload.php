<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
//error_reporting(E_ALL);
 require_once('includes/functions.php');    

 if($row_get_login['access17sub4']==1){

  $output = '';
  $error = 0;
  $highestRow = 0;


  
if(isset($_POST['import'])){    

     

      $file = $_FILES["excel"]["tmp_name"]; 
      include("PHPExcel/Classes/PHPExcel/IOFactory.php"); 
      $objPHPExcel = PHPExcel_IOFactory::load($file);   
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
      $highestRow = $worksheet->getHighestRow(); 

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
        $cambrage = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue(); 
        $technokids = $worksheet->getCellByColumnAndRow(11, $row)->getCalculatedValue();
        $hosting = $worksheet->getCellByColumnAndRow(12, $row)->getCalculatedValue();
        $total = $worksheet->getCellByColumnAndRow(13, $row)->getCalculatedValue();
        $registration = $worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue();  
        $total_ed = $worksheet->getCellByColumnAndRow(15, $row)->getCalculatedValue(); 
        $rest = $worksheet->getCellByColumnAndRow(16, $row)->getCalculatedValue(); 
       
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
                    mysqli_query($database," DELETE FROM `kids_accounting` WHERE `ed_id` = '{$ed_id}' ");  

                    $insertSQL = sprintf("INSERT INTO `kids_accounting` ( `kid_id`, `wrong`, `study_year`, `name`, `ed_id`, `ed_fees`, `activity`, `bus`, `uniform1`,  `books1`, `books2`, `uniform2`, `pc`, `technokids`, `hosting`, `total`, `registration`, `cambrage`, `total_ed`, `rest` ) 
                                          VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s , %s , %s , %s )", 
                                                      GetSQLValueString($database,$row_get_users_info['id'], "int"), 
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
                                                      GetSQLValueString($database,$registration, "double"),
                                                      GetSQLValueString($database,$cambrage, "double"),
                                                      GetSQLValueString($database,$total_ed, "double"),
                                                      GetSQLValueString($database,$rest, "double"));

                      mysqli_select_db($database, $database_database);    
                      mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
                      
            } 
      }

         //include("acc-upload-data".$_POST['target'].".php");   
      }     
        header("location: acc-view.php?id=".$_POST['target']); 
        exit();
  } 

     
$head_title = "  حسابات";
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
			<?php require_once('includes/mobile-menu-buttons.php');?> 
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
                <h4>   تحميل ملف     تحصيلات     </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="acc-upload.php" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
					   
             
            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" name="target"  id="target"  required >
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

            <div class="col-sm-4" style=" padding-top:10px"> <a href="../uploads/demo1.xlsx" style="color:green; display:none" id="demo" > Demo  <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
            </div> 
                       


            <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  ملف التحميل <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="excel" class="form-control" required type="file" name="excel" accept=".xlsx" >
                <small><a href="uploads/accounting.xlsx" >تحميل الملف </a> xlsx</small>
              </div>
            </div>


						<div class="form-group"> 
						    <div class="col-sm-2 col-sm-offset-3"> 
                  <button type="submit" class="btn btn-primary btn-block" name="import"  ><i class="fa fa-refresh" aria-hidden="true"></i> تحديث</button> 
                </div>  
                    
						   
                
                    <h3 style="color:green;  "><?php if(isset($_GET['id'])){   echo "تم إضافة عدد ".$_GET['id']." قيد"; }?></h3>
                    <h3 style="color:red; "><?php if(isset($_GET['failed'])){   echo "يوجد خطء"; }?></h3>
        
          </div> 
 	
					</form>
				  </div>
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

       // $("#target").change(function(){ 
       //       var demo = $(this).val();
       //        $("#demo").attr('href','./uploads/demo'+demo+'.xlsx').fadeIn();   
       //  });			 	  
		  
	  });
	  </script>
  </body>
 
</html>

    <?php }else{header("location: home.php");exit();}?>