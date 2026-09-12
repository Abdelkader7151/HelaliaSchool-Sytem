<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');   
 //require_once('erros_check.php');   

 if($row_get_login['access6sub3']==1){

  $output = '';
  $error = 0;
  $highestRow = 0;


  
if(isset($_POST['import'])){    

      mysqli_query($database," DELETE FROM `temp_atten` "); 

      $file = $_FILES["excel"]["tmp_name"]; 
      include("PHPExcel/Classes/PHPExcel/IOFactory.php"); 
      $objPHPExcel = PHPExcel_IOFactory::load($file);   
      $count = 1;
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
      $highestRow = $worksheet->getHighestRow();
      for($row=2; $row<=$highestRow; $row++){  
        
              $date = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
              $on_duty = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
              $off_duty = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
              $sign_in = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
              $sign_out = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
              $late_in = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
              $late_out = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
              $absent = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
              $att_time = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
              $exp_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();  

              list($late_in_hours, $late_in_minutes) = explode(':', $late_in, 2);
              $late_in = $late_in_minutes * 60 + $late_in_hours * 3600;

              list($late_out_hours, $late_out_minutes) = explode(':', $late_out, 2);
              $late_out = $late_out_minutes * 60 + $late_out_hours * 3600;

              list($att_time_hours, $att_time_minutes) = explode(':', $att_time, 2);
              $att_time = $att_time_minutes * 60 + $att_time_hours * 3600;
  
              $insertSQL = sprintf("INSERT INTO `temp_atten` ( `emp_id`, `date`, `on_duty`, `off_duty`, `sign_in`, `sign_out`, `late_in`, `late_out`, `absent`, `att_time`, `exp_id`) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                            GetSQLValueString($database,emp_id($exp_id), "int"), 
                            GetSQLValueString($database,strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $date)))), "int"), 
                            GetSQLValueString($database,strtotime(date("Y-m-d {$on_duty}:00",time())), "int"), 
                            GetSQLValueString($database,strtotime(date("Y-m-d {$off_duty}:00",time())), "int"),  
                            GetSQLValueString($database,strtotime(date("Y-m-d {$sign_in}:00",time())), "int"),
                            GetSQLValueString($database,strtotime(date("Y-m-d {$sign_out}:00",time())), "int"), 
                            GetSQLValueString($database,$late_in, "int"), 
                            GetSQLValueString($database,$late_out, "int"), 
                            GetSQLValueString($database,($absent=='True')?1:0, "int"),
                            GetSQLValueString($database,$att_time, "int"), 
                            GetSQLValueString($database,$exp_id, "int"));

              mysqli_select_db($database, $database_database);   
              if($exp_id!='Emp No.'){
                $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
                $count++;
              }
              }
          }  
      
          if($highestRow==$count){
          mysqli_select_db($database, $database_database); 
          $query_get_data = "SELECT * FROM temp_atten";
          $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
          $row_get_data = mysqli_fetch_assoc($get_data);
          $totalRows_get_data = mysqli_num_rows($get_data);  

          if($totalRows_get_data>0){
              $i=1;
          do{    
            mysqli_select_db($database, $database_database); 
            $query_get_check = "SELECT `exp_id`,`date` FROM `attendance_log` WHERE `exp_id` ='{$row_get_data['exp_id']}' AND `date` ='{$row_get_data['date']}'" ;
            $get_check = mysqli_query($database,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 

              $insertSQL2 = sprintf("INSERT INTO `attendance_log` ( `emp_id`, `date`, `on_duty`, `off_duty`, `sign_in`, `sign_out`, `late_in`, `late_out`, `absent`, `att_time`, `exp_id`) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                            GetSQLValueString($database,$row_get_data['emp_id'], "int"), 
                            GetSQLValueString($database,$row_get_data['date'], "int"), 
                            GetSQLValueString($database,$row_get_data['on_duty'], "int"), 
                            GetSQLValueString($database,$row_get_data['off_duty'], "int"), 
                            GetSQLValueString($database,$row_get_data['sign_in'], "int"), 
                            GetSQLValueString($database,$row_get_data['sign_out'], "int"), 
                            GetSQLValueString($database,$row_get_data['late_in'], "int"), 
                            GetSQLValueString($database,$row_get_data['late_out'], "int"), 
                            GetSQLValueString($database,$row_get_data['absent'], "int"), 
                            GetSQLValueString($database,$row_get_data['att_time'], "int"), 
                            GetSQLValueString($database,$row_get_data['exp_id'], "int"));

              mysqli_select_db($database, $database_database);   
              if($totalRows_get_check<1){
                $Result2 = mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 
                $i++;
              }

         }while($row_get_data = mysqli_fetch_assoc($get_data)); 
          }  
        }
        mysqli_query($database," DELETE FROM `temp_atten` ");
        if($highestRow==$count){
        header("location: import-attendance.php?id=".($i-1));
        }else{
          header("location: import-attendance.php?failed");
        }
        exit();
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
                    <form action="import-attendance.php" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  ملف التحميل <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="excel" class="form-control" required type="file" name="excel" accept=".xlsx" >
                <small>امتداد الملف xlsx</small>
              </div>
            </div>  
             

                       
						<div class="form-group"> 
						    <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block" name="import"  ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                </div>  
                    
						    <div class="col-sm-2"> 
                  <a href="attend-all.php?update" class="btn btn-primary btn-block"    ><i class="fa fa-refresh" aria-hidden="true"></i> تحديث</a> 
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



        $('#form1').on('blur', '#username', function (event) { 
			  // event.preventDefault(); 
           
			  var email = $("#username").val();  
			  $.post("check_email.php",
			{
             email:email
		    },
            function(Date,status){ 

                 if(Date>0){
                    $("#email_check").fadeIn();  
                    $("#submit").attr('disabled', 'disabled');
                 }else{
                    $("#email_check").fadeOut();   
                    $("#submit").removeAttr("disabled");
                  }
                  
			   }); 
	    });


      $('#form1').on('change', '#job', function (event) {  
           
			  var id = $("#job").val();  
			  $.post("job_access.php",
			{
             id:id
		    },
            function(Date,status){  
                $("#appaccess").html(Date);  
			   }); 
	    });
      


      $("#app1").click(function(){
  if($(this).is(":checked")){
      $(".app1").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app1").each(function(){ 
         $(this).prop( "checked", false );
      });
  } 
});

$(".app1").click(function(){
  $("#app1").prop( "checked", true );
  var count = 0;
  $(".app1").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app1").prop( "checked", false ); }
});






 
$("#app2").click(function(){
  if($(this).is(":checked")){
      $(".app2").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app2").each(function(){ 
         $(this).prop( "checked", false );
      });
  } 
});

$(".app2").click(function(){
  $("#app2").prop( "checked", true );
  var count = 0;
  $(".app2").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app2").prop( "checked", false ); }
});

$("#app6").click(function(){
    if($(this).is(":checked")){
      $(".app6").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".app6").each(function(){ 
         $(this).prop( "checked", false );
    });
    } 
});

$(".app6").click(function(){
  $("#app6").prop( "checked", true );
  var count = 0;
  $(".app6").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app6").prop( "checked", false ); }
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

		 
		  
 
	          
		  
		  
		  
	<?php if(isset($_GET['done'])){?>	  
		  Command: toastr["success"](" تم الرفع بنجاح") 
		  
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
		  
	  });
	  </script>
  </body>
 
</html>

    <?php }else{header("location: home.php");exit();}?>