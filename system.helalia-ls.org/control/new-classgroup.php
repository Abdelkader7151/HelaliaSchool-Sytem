<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access2sub1']==1){

$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("INSERT INTO `classgroup` ( `emp_id`,  `study_year`, `subject`, `friday`,  `friday_time`,  `saturday`, `saturday_time`, `sunday`, `sunday_time`, `monday`, `monday_time`, `tuesday`, `tuesday_time`, `wednesday`, `wednesday_time`, `thursday`, `thursday_time` ) VALUES (   %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
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
                       GetSQLValueString($database,$_POST['thursday_time'], "text"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
			header("location: new-classgroup.php?done"); 
			exit();
	      
	} 
	
 
 
  
  

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
                <h4> أضافة مجموعة جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-classgroup.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
				   
                    
          <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" >
                                <option selected disabled >...</option> 
                                <option value="0"> بري سكول </option> 
                                <option value="1">اولى حضانة</option> 
                                <option value="2">ثانية حضانة</option> 
                                <option value="3"> الصف الاول الابتدائى</option> 
                                <option value="4"> الصف الثانى الابتدائى</option> 
                                <option value="5"> الصف الثالث الابتدائى</option> 
                                <option value="6"> الصف الرابع الابتدائى</option> 
                                <option value="7"> الصف الخامس الابتدائى</option> 
                                <option value="8"> الصف السادس الابتدائى</option> 
                                <option value="9"> الصف الاول الاعدادى</option> 
                                <option value="10"> الصف الثاني الاعدادى</option> 
                                <option value="11"> الصف الثالث الاعدادى</option> 
                                <option value="12"> الصف الاول الثانوى</option> 
                                <option value="13"> الصف الثاني الثانوى</option> 
                                <option value="14"> الصف الثالث الثانوى</option>  
                            </select>
						</div>
           </div> 
                      
                      
 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="subject"> المادة الدراسية  <span style="color: red;">*</span></label>
						<div class="col-sm-4" id="subject_box">
                            <select class="form-control" required name="subject" id="subject" >
                                 
                            </select>
						</div>
                     </div> 

           <div class="form-group">
						<label class="col-sm-3 control-label" for="emp_id"> المدرس  </label>
						<div class="col-sm-4" id="teachers">
                            <select class="form-control" required name="emp_id" id="emp_id" >
                                <option selected   >...</option>  
                            </select>
						</div>
           </div>   

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="friday">     الجمعة  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"   name="friday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="friday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-1" class="form-control ui-timepicker-input" name="friday_time" type="text" autocomplete="off">
                            <span id="timepicker-1-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="saturday">     السبت  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"   name="saturday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="saturday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-2" class="form-control ui-timepicker-input" name="saturday_time"  type="text" autocomplete="off">
                            <span id="timepicker-2-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div>
                     
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="sunday">     الاحد  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="sunday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="sunday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-3" class="form-control ui-timepicker-input"   name="sunday_time"  type="text" autocomplete="off">
                            <span id="timepicker-3-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="monday">     الاثنين  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="monday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="monday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-4" class="form-control ui-timepicker-input"   name="monday_time"  type="text" autocomplete="off">
                            <span id="timepicker-4-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="tuesday">     الثلاثاء  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="tuesday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="tuesday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-5" class="form-control ui-timepicker-input" name="tuesday_time"  type="text" autocomplete="off">
                            <span id="timepicker-5-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="wednesday">     الاربعاء  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="wednesday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="wednesday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-6" class="form-control ui-timepicker-input" name="wednesday_time"  type="text" autocomplete="off">
                            <span id="timepicker-6-btn" class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                <span class="icon icon-clock-o"></span>
                                </button>
                            </span>
                        </div> 
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="thursday">     الخميس  </label>
						<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="thursday" value="1" > </div>
                        <label class="col-sm-1 control-label" for="thursday">     التوقيت   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-7" class="form-control ui-timepicker-input" name="thursday_time"  type="text" autocomplete="off">
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
						    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >حفظ</button> 
						 </div> 
                      </div>
                       
					   <div class="form-group">
						 <label class="col-sm-3 control-label" > </label>
						 <div class="col-sm-6"> 
						   <?php echo $msg;?> 
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