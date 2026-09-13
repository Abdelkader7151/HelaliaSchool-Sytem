<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    


  $output = '';
  $error = 0;
  $highestRow = 0;


  
if(isset($_POST['import'])){    
 

      $file = $_FILES["excel"]["tmp_name"]; 
      include("PHPExcel/Classes/PHPExcel/IOFactory.php"); 
      $objPHPExcel = PHPExcel_IOFactory::load($file);   
      $count = 1;
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
      $highestRow = $worksheet->getHighestRow();

      for($row=2; $row<=$highestRow; $row++){    

                $exp_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();       
                $attend = str_replace(" ص","",$worksheet->getCellByColumnAndRow(1, $row)->getValue()); 


                $day =  explode(" ",$attend)[0];
                $time =  explode(" ",$attend)[1];

                  // echo  change_date1($day);
                 // echo  $time." ".change_date1($day);
                // echo  strtotime($time." ".change_date1($day));

                 //echo date("Y-m-d H:i:s",1735017357);
                         
              }
          }  
      
        
         
      } 

     
$head_title = "  الموظفين";
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
                <h4>   تحميل ملف الحضور و الانصارف     </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="test7.php" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    


                    <?php 
                   
                   echo  strtotime($time." ".change_date1($day));
                      
                    
                     ?>



		  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  ملف التحميل <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="excel" class="form-control" required type="file" name="excel" accept=".xlsx,.xls" >
                <small>امتداد الملف xlsx</small>
              </div>
            </div>  
             

                       
						<div class="form-group"> 
						    <div class="col-sm-2"> 
                                <button type="submit" class="btn btn-primary btn-block" name="import"  ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                                </div>   
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


	  
  
  </body>
 
</html> 