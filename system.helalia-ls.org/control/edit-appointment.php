<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access4sub5']==1){

$msg ='';

if(isset($_GET['cancel'])){     
  $updateSQL = sprintf("UPDATE `appointment` SET `kid_id`=null  where `id`=%s",  
                       GetSQLValueString($database,$_GET['cancel'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));
       
			header("location: all-appointments.php?done"); 
			exit();
  } 



if(isset($_GET['del'])){     
    $deleteSQL = sprintf("DELETE FROM `appointment` WHERE `id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
            header("location: all-appointments.php"); 
            exit(); 
    } 



if(isset($_POST['submit'])){  
	$updateSQL = sprintf("UPDATE `appointment` SET `emp_id`=%s, `study_year`=%s,  `class`=%s, `subject`=%s, `day`=%s, `meeting_time`=%s  where `id`=%s", 
                       GetSQLValueString($database,$_POST['emp_id'], "int"),
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['class'], "int"),
                       GetSQLValueString($database,$_POST['subject'], "int"), 
                       GetSQLValueString($database,strtotime($_POST['day']), "int"),
                       GetSQLValueString($database,$_POST['meeting_time'], "text"), 
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));
       
			header("location: all-appointments.php?done"); 
			exit();
	      
	} 
	
 

  mysqli_select_db($database, $database_database);  
  $query_get_class_info = "SELECT * FROM `appointment` where `id`='{$_GET['id']}' "; 
  $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
  $row_get_class_info = mysqli_fetch_assoc($get_class_info);
  $totalRows_get_class_info = mysqli_num_rows($get_class_info);

 
  mysqli_select_db($database, $database_database);  
  $query_get_subjects = "SELECT * FROM `subjects` where `study_year`='{$row_get_class_info['study_year']}' "; 
  $get_subjects = mysqli_query($database,$query_get_subjects) or die(mysqli_error($database));
  $row_get_subjects = mysqli_fetch_assoc($get_subjects);
  $totalRows_get_subjects = mysqli_num_rows($get_subjects);

  mysqli_select_db($database, $database_database); 
  $query_get_teachers = "SELECT distinct(`emp_id`) FROM `teachers` where  `subject`='{$row_get_class_info['subject']}' and `study_year`='{$row_get_class_info['study_year']}'    ";
  $get_teachers = mysqli_query($database,$query_get_teachers) or die(mysqli_error($database));
  $row_get_teachers = mysqli_fetch_assoc($get_teachers);
  $totalRows_get_teachers = mysqli_num_rows($get_teachers);
  

  mysqli_select_db($database, $database_database);  
  $query_get_classs = "SELECT * FROM `class` where `study_year`='{$row_get_class_info['study_year']}' "; 
  $get_classs = mysqli_query($database,$query_get_classs) or die(mysqli_error($database));
  $row_get_classs = mysqli_fetch_assoc($get_classs);
  $totalRows_get_classs = mysqli_num_rows($get_classs);

$head_title = "    المقابلات";
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
                <h4> تعديل  مقابلة   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				<div class="demo-form-wrapper"  style="padding-top: 50px;">
                    <form action="edit-appointment.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     
             
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" > 
                                <option value="1" <?php if($row_get_class_info['study_year']==1){echo " selected ";}?>  >اولى حضانة</option> 
                                <option value="2" <?php if($row_get_class_info['study_year']==2){echo " selected ";}?> >ثانية حضانة</option> 
                                <option value="3" <?php if($row_get_class_info['study_year']==3){echo " selected ";}?> > الصف الاول الابتدائى</option> 
                                <option value="4" <?php if($row_get_class_info['study_year']==4){echo " selected ";}?> > الصف الثانى الابتدائى</option> 
                                <option value="5" <?php if($row_get_class_info['study_year']==5){echo " selected ";}?> > الصف الثالث الابتدائى</option> 
                                <option value="6" <?php if($row_get_class_info['study_year']==6){echo " selected ";}?> > الصف الرابع الابتدائى</option> 
                                <option value="7" <?php if($row_get_class_info['study_year']==7){echo " selected ";}?> > الصف الخامس الابتدائى</option> 
                                <option value="8" <?php if($row_get_class_info['study_year']==8){echo " selected ";}?> > الصف السادس الابتدائى</option> 
                                <option value="9" <?php if($row_get_class_info['study_year']==9){echo " selected ";}?> > الصف الاول الاعدادى</option> 
                                <option value="10" <?php if($row_get_class_info['study_year']==10){echo " selected ";}?> > الصف الثاني الاعدادى</option> 
                                <option value="11" <?php if($row_get_class_info['study_year']==11){echo " selected ";}?> > الصف الثالث الاعدادى</option> 
                                <option value="12" <?php if($row_get_class_info['study_year']==12){echo " selected ";}?> > الصف الاول الثانوى</option> 
                                <option value="13" <?php if($row_get_class_info['study_year']==13){echo " selected ";}?> > الصف الثاني الثانوى</option> 
                                <option value="14" <?php if($row_get_class_info['study_year']==14){echo " selected ";}?> > الصف الثالث الثانوى</option>  
                            </select>
						</div>
                     </div> 
                      
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="class">   الفصل  <span style="color: red;">*</span></label>
						<div class="col-sm-4" id="class_box">
                  <select class="form-control" required name="class" id="class" >
                  <?php do{ ?>
                    <option value="<?php echo $row_get_classs['id'];?>" <?php if($row_get_classs['id']==$row_get_class_info['class']){echo " selected ";}?> > <?php echo $row_get_classs['name'];?> </option>
                    <?php } while(  $row_get_classs = mysqli_fetch_assoc($get_classs));?>
                  </select>
						</div>
           </div> 
                      
 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="subject"> المادة الدراسية  <span style="color: red;">*</span></label>
						<div class="col-sm-4" id="subject_box">
                            <select class="form-control" required name="subject" id="subject"  >
                              <?php do{ ?>
                              <option value="<?php echo $row_get_subjects['id'];?>" <?php if($row_get_subjects['id']==$row_get_class_info['subject']){echo " selected ";}?> > <?php echo $row_get_subjects['name'];?> </option>
                              <?php } while($row_get_subjects = mysqli_fetch_assoc($get_subjects));?>
                            </select>
						</div>
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="emp_id"> المدرس  </label>
						<div class="col-sm-4" id="teachers">
                            <select class="form-control" name="emp_id" id="emp_id" >
                            <option value="">...</option>
                            <?php   if($totalRows_get_teachers>0){ do{ ?>
                              <option value="<?php echo $row_get_teachers['emp_id'];?>" <?php if($row_get_teachers['emp_id']==$row_get_class_info['emp_id']){echo " selected ";}?> > <?php echo emp_name($row_get_teachers['emp_id']);?> </option>
                              <?php } while($row_get_teachers = mysqli_fetch_assoc($get_teachers)); }?>
                            </select>
						</div>
           </div>   

           <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">     اليوم   </label>
              <div class="input-group date col-sm-4">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" type="text" name="day" value="<?php echo date("m/d/Y",$row_get_class_info['day']);?>"  >
                </div> 
            </div> 

                    <div class="form-group">  
                        <label class="col-sm-3 control-label" for="friday">     الميعاد   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-1" class="form-control ui-timepicker-input" name="meeting_time" type="text" autocomplete="off"  value="<?php echo $row_get_class_info['meeting_time'];?>" >
                            <span id="timepicker-1-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                       
            <?php if($row_get_class_info['kid_id']!=null){?>
             <div class="form-group">
              <label class="col-sm-3 control-label" for="book">     الحجز   </label>
              <div class=" col-sm-2" style="padding-top: 10px;">
                <p><?php echo kid_name($row_get_class_info['kid_id']);  ?>  </p>
               </div> 
               <div class="col-sm-2"> 
               <a href="edit-appointment.php?cancel=<?php echo $row_get_class_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> الغاء   </a>
            </div> 
            </div> 
            <?php }?>
            
                     <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_class_info['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                          <div class="col-sm-2"> 
<a href="edit-appointment.php?del=<?php echo $row_get_class_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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
    
 
	  
	  <script>
	  $(document).ready(function(){

        $("#timepicker-1").timepicker({
            step: 10
        });

        $("#timepicker-2").timepicker({
            step: 10
        });


        $("#timepicker-3").timepicker({
            step: 10
        });


        $("#timepicker-4").timepicker({
            step: 10
        });


        $("#timepicker-5").timepicker({
            step: 10
        });


        $("#timepicker-6").timepicker({
            step: 10
        });


        $("#timepicker-7").timepicker({
            step: 10
        });







        $('#demo-inputmask').on('change', '#study_year', function (event) {  
           $("#teachers option").remove(); 
           $("#emp_id option").remove();
           $("#subject option").remove();
         var study_year = $("#study_year").val();   
          $.post("study_year_class.php",
         {
                 study_year:study_year
         },
             function(Date,status){ 
 
                   $("#class_box").html(Date);
                   
          }); 
       });
       
       $('#demo-inputmask').on('change', '#class', function (event) {  
         $("#teachers option").remove();
         $("#subject option").remove();
          var study_year = $("#study_year").val();  
          $.post("study_year_subjects.php",
          {
                  study_year:study_year
          },
              function(Date,status){ 
  
                    $("#subject_box").html(Date);
                    
           });  
           
        });
 
 
  
 
 
       $('#demo-inputmask').on('change', '#subject', function (event) {    
            var study_year = $("#study_year").val();  
            var subject = $("#subject").val();
            var class_year = $("#class").val();
            
            $.post("subjects_teacher2.php",
            {
                    study_year:study_year,
                    subject:subject,
                    class:class_year
            },
                function(Date,status){ 
    
                      $("#teachers").html(Date);
                      
             }); 
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
      

 

 

	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>