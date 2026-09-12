<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access2sub3']==1){

$msg ='';

if(isset($_GET['del'])){     
  $deleteSQL = sprintf("DELETE FROM `classgroup` WHERE `id`=%s ",
                     GetSQLValueString($database,$_GET['del'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

 $deleteSQL = sprintf("DELETE FROM `classgroup_list` WHERE `classgroup_id`=%s ",
          GetSQLValueString($database,$_GET['del'], "int"));

mysqli_select_db($database, $database_database);  
$Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
          header("location: all-classgroups.php"); 
          exit(); 
  } 



if(isset($_POST['submit'])){  
	$updateSQL = sprintf("UPDATE `classgroup` SET `emp_id`=%s, `study_year`=%s, `subject`=%s, `friday`=%s,  `friday_time`=%s,  `saturday`=%s, `saturday_time`=%s, `sunday`=%s, `sunday_time`=%s, `monday`=%s, `monday_time`=%s, `tuesday`=%s, `tuesday_time`=%s, `wednesday`=%s, `wednesday_time`=%s, `thursday`=%s, `thursday_time`=%s where `id`=%s", 
                       GetSQLValueString($database,$_POST['emp_id'], "int"),
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['subject'], "int"), 
                       GetSQLValueString($database,$_POST['friday'], "int"),
                       GetSQLValueString($database,$_POST['friday_time'], "text"),
                       GetSQLValueString($database,$_POST['saturday'], "int"),
                       GetSQLValueString($database,$_POST['saturday_time'], "text"),
                       GetSQLValueString($database,$_POST['sunday'], "int"),
                       GetSQLValueString($database,$_POST['sunday_time'], "text"),
                       GetSQLValueString($database,$_POST['monday'], "int"),
                       GetSQLValueString($database,$_POST['monday_time'], "text"),
                       GetSQLValueString($database,$_POST['tuesday'], "int"),
                       GetSQLValueString($database,$_POST['tuesday_time'], "text"),
                       GetSQLValueString($database,$_POST['wednesday'], "int"),
                       GetSQLValueString($database,$_POST['wednesday_time'], "text"),
                       GetSQLValueString($database,$_POST['thursday'], "int"),
                       GetSQLValueString($database,$_POST['thursday_time'], "text"),
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));
       
			header("location: edit-classgroup.php?id=".$_GET['id']."&done"); 
			exit();
	      
	} 
	
 

  mysqli_select_db($database, $database_database);  
  $query_get_class_info = "SELECT * FROM `classgroup` where `id`='{$_GET['id']}' "; 
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
  

$head_title = "  مجموعات التقوية";
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
                <h4> تعديل مجموعة تقوية </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="edit-classgroup.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     
             
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" > 
                                <option value="0" <?php if($row_get_class_info['study_year']==0){echo " selected ";}?> >  بلى سكول</option> 
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
                            <select class="form-control"   name="emp_id" id="emp_id" >
                            <option value="">...</option>
                            <?php   if($totalRows_get_teachers>0){ do{ ?>
                              <option value="<?php echo $row_get_teachers['emp_id'];?>" <?php if($row_get_teachers['emp_id']==$row_get_class_info['emp_id']){echo " selected ";}?> > <?php echo emp_name($row_get_teachers['emp_id']);?> </option>
                              <?php } while($row_get_teachers = mysqli_fetch_assoc($get_teachers)); }?>
                            </select>
						</div>
           </div>   

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="friday">     الجمعة  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"   name="friday" value="1"  <?php if($row_get_class_info['friday']==1){echo " checked ";} ?>> </div>
                        <label class="col-sm-1 control-label" for="friday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-1" class="form-control ui-timepicker-input" name="friday_time" value="<?php echo $row_get_class_info['friday_time'];?>" type="text" autocomplete="off">
                            <span id="timepicker-1-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="saturday">     السبت  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"   name="saturday" value="1" <?php if($row_get_class_info['saturday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="saturday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-2" class="form-control ui-timepicker-input" name="saturday_time" value="<?php echo $row_get_class_info['saturday_time'];?>"   type="text" autocomplete="off">
                            <span id="timepicker-2-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div>
                     
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="sunday">     الاحد  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="sunday" value="1" <?php if($row_get_class_info['sunday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="sunday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-3" class="form-control ui-timepicker-input"   name="sunday_time" value="<?php echo $row_get_class_info['sunday_time'];?>"   type="text" autocomplete="off">
                            <span id="timepicker-3-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="monday">     الاثنين  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="monday" value="1" <?php if($row_get_class_info['monday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="monday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-4" class="form-control ui-timepicker-input"   name="monday_time"    value="<?php echo $row_get_class_info['monday_time'];?>"  type="text" autocomplete="off">
                            <span id="timepicker-4-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="tuesday">     الثلاثاء  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="tuesday" value="1" <?php if($row_get_class_info['tuesday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="tuesday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-5" class="form-control ui-timepicker-input" name="tuesday_time"  value="<?php echo $row_get_class_info['tuesday_time'];?>"  type="text" autocomplete="off">
                            <span id="timepicker-5-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="wednesday">     الاربعاء  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="wednesday" value="1" <?php if($row_get_class_info['wednesday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="wednesday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-6" class="form-control ui-timepicker-input" name="wednesday_time" value="<?php echo $row_get_class_info['wednesday_time'];?>"  type="text" autocomplete="off">
                            <span id="timepicker-6-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="thursday">     الخميس  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="thursday" value="1"  <?php if($row_get_class_info['thursday']==1){echo " checked ";} ?> > </div>
                        <label class="col-sm-1 control-label" for="thursday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-7" class="form-control ui-timepicker-input" name="thursday_time" value="<?php echo $row_get_class_info['thursday_time'];?>"  type="text" autocomplete="off">
                            <span id="timepicker-7-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 



						
                     <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_class_info['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                         <?php if(group_kid_count($row_get_class_info['id'])<1){?>  
                          <div class="col-sm-2"> 
<a href="edit-classgroup.php?del=<?php echo $row_get_class_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                          </div>
                          <?php }?>
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
           $.post("subjects_teacher.php",
           {
                   study_year:study_year,
                   subject:subject
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