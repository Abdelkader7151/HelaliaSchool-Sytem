<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access4sub1']==1){

$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("INSERT INTO `appointment` ( `emp_id`,  `study_year`, `class`, `subject`, `day`, `meeting_time` ) VALUES ( %s, %s, %s, %s, %s, %s )", 
                       GetSQLValueString($database,$_POST['emp_id'], "int"),
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['class'], "int"),
                       GetSQLValueString($database,$_POST['subject'], "int"), 
                       GetSQLValueString($database,strtotime($_POST['day']), "int"),
                       GetSQLValueString($database,$_POST['meeting_time'], "text"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
			header("location: new-appointment.php?done"); 
			exit();
	      
	} 
	
 
 
  
  

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
                <h4> أضافة مقابلة جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper"  style="padding-top: 50px;">
                    <form action="new-appointment.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal"> 
                    
				   
                    
          <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" >
                                <option selected disabled >...</option> 
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
						<label class="col-sm-3 control-label" for="class">   الفصل  <span style="color: red;">*</span></label>
						<div class="col-sm-4" id="class_box">
                            <select class="form-control" required name="class" id="class" >
                                 
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
						<label class="col-sm-3 control-label" for="emp_id"> المدرس <span style="color: red;">*</span> </label>
						<div class="col-sm-4" id="teachers">
                            <select class="form-control" required name="emp_id" id="emp_id" >
                                <option selected   >...</option>  
                            </select>
						</div>
           </div>   

                   
           <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">     اليوم  <span style="color: red;">*</span> </label>
              <div class="input-group date col-sm-4">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" required type="text" name="day"  >
                </div> 
            </div> 

                    <div class="form-group">  
                        <label class="col-sm-3 control-label" for="friday">     الميعاد   </label>
                        <div class="input-group col-sm-2">
                            <input id="timepicker-1" class="form-control ui-timepicker-input" required name="meeting_time" type="text" autocomplete="off">
                            <span id="timepicker-1-btn" class="input-group-btn">
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