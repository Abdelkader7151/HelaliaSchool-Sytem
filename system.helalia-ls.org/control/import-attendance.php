<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');   
 //require_once('erros_check.php');   

 if($row_get_login['access6sub3']==1){

  $output = '';
  $error = 0;
  $highestRow = 0;

  function late_in($late_in){ 
    if($late_in <= 959){
      return 0;
    }elseif($late_in>=960 && $late_in<=1259){
      return 5;
    }elseif($late_in>=1260 && $late_in<=1559){
      return 10;
    }elseif($late_in>=1560 && $late_in<=1859){
      return 15;
    }elseif($late_in>=1860){
      return 420;
    }
  }  
  
if(isset($_POST['import'])){    

      mysqli_query($database," DELETE FROM `temp_atten` "); 

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

              $emp_id = emp_id($exp_id);

              mysqli_select_db($database, $database_database); 
              $query_get_emps = "SELECT `on_duty` FROM `emps` WHERE `id` = '{$emp_id}' ";
              $get_emps = mysqli_query($database,$query_get_emps) or die(mysqli_error($database));
              $row_get_emps = mysqli_fetch_assoc($get_emps);
              $totalRows_get_emps = mysqli_num_rows($get_emps);    
  
             $late_in = (strtotime($time." ".change_date1($day)) - strtotime($row_get_emps['on_duty']." am ".change_date1($day)));
             if($late_in<0){ $late_in = 0;}
                      
              $insertSQL = sprintf("INSERT INTO `temp_atten` ( `emp_id`, `date`, `late_in`, `on_duty`, `sign_in`, `exp_id`) VALUES ( %s, %s, %s, %s, %s, %s )", 
                            GetSQLValueString($database,emp_id($exp_id), "int"), 
                            GetSQLValueString($database,strtotime(change_date1($day)), "int"), 
                            GetSQLValueString($database,late_in($late_in), "int"), 
                            GetSQLValueString($database,strtotime($row_get_emps['on_duty']." am ".change_date1($day)), "int"), 
                            GetSQLValueString($database,strtotime($time." ".change_date1($day)), "int"), 
                            GetSQLValueString($database,$exp_id, "int"));

              mysqli_select_db($database, $database_database);   
              if($exp_id>0){
                 mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
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
            $query_get_check = "SELECT `exp_id`, `date` FROM `attendance_log` WHERE `exp_id` ='{$row_get_data['exp_id']}' AND `date` ='{$row_get_data['date']}' " ;
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

              
             if($totalRows_get_check<1){
                 mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 
                $i++;
             }

         }while($row_get_data = mysqli_fetch_assoc($get_data)); 
          
          mysqli_select_db($database, $database_database); 
          $query_get_last = "SELECT `date`, `on_duty` FROM `attendance_log` ORDER BY `id` desc limit 1"; ;
          $get_last = mysqli_query($database,$query_get_last) or die(mysqli_error($database));
          $row_get_last = mysqli_fetch_assoc($get_last);
          $totalRows_get_last = mysqli_num_rows($get_last);  
   

          mysqli_select_db($database, $database_database); 
          $query_get_emps = "SELECT * FROM `emps` WHERE `ext_id` > 0 ";
          $get_emps = mysqli_query($database,$query_get_emps) or die(mysqli_error($database));
          $row_get_emps = mysqli_fetch_assoc($get_emps);
          $totalRows_get_emps = mysqli_num_rows($get_emps);  
           
          if($totalRows_get_data>0){   
           
                do{  
                  $query_get_sign = "SELECT `exp_id` FROM `attendance_log` WHERE `exp_id` = '{$row_get_emps['ext_id']}' AND `date` = '{$row_get_last['date']}'  ";  
                  $get_sign = mysqli_query($database,$query_get_sign) or die(mysqli_error($database));
                  $row_get_sign = mysqli_fetch_assoc($get_sign);
                  $totalRows_get_sign = mysqli_num_rows($get_sign); 

                    if($totalRows_get_sign<1){
 
          
                      
                          $insertSQL2 = sprintf("INSERT INTO `attendance_log` ( `emp_id`, `date`, `on_duty`, `off_duty`, `sign_in`, `sign_out`, `late_in`, `late_out`, `absent`, `att_time`, `exp_id`) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                                          GetSQLValueString($database,$row_get_emps['id'], "int"), 
                                          GetSQLValueString($database,$row_get_last['date'], "int"), 
                                          GetSQLValueString($database,strtotime($row_get_emps['on_duty']." am ".change_date1($day)), "int"), 
                                          GetSQLValueString($database,NULL, "int"), 
                                          GetSQLValueString($database,NULL, "int"), 
                                          GetSQLValueString($database,NULL, "int"),  
                                          GetSQLValueString($database,NULL, "int"), 
                                          GetSQLValueString($database,NULL, "int"), 
                                          GetSQLValueString($database,1, "int"), 
                                          GetSQLValueString($database,NULL, "int"), 
                                          GetSQLValueString($database,$row_get_emps['ext_id'], "int")); 
                      
                        mysqli_query($database,$insertSQL2) or die(mysqli_error($database));   
                  }    
             }while($row_get_emps = mysqli_fetch_assoc($get_emps)); 










          }
        } 
          mysqli_query($database," DELETE FROM `temp_atten` ");
        }  



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
                <input id="excel" class="form-control" required type="file" name="excel" accept=".xlsx,.xls" >
                <small>امتداد الملف xlsx <a href="uploads/clock.xls"><i class="fa fa-file-excel-o" aria-hidden="true" style="color:green"></i> تحميل</a></small>
              </div>
            </div>  
             

                       
						<div class="form-group"> 
						    <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block" name="import"  ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                </div>  
                    
						  <!--  <div class="col-sm-2"> 
                  <a href="attend-all.php?update" class="btn btn-primary btn-block"    ><i class="fa fa-refresh" aria-hidden="true"></i> تحديث</a> 
                </div> -->
                
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