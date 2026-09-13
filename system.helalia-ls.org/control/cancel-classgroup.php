<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access2sub3']==1){

$msg ='';
 

  mysqli_select_db($database, $database_database);  
  $query_get_class_info = "SELECT * FROM `classgroup` where `id`='{$_GET['id']}' "; 
  $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
  $row_get_class_info = mysqli_fetch_assoc($get_class_info);
  $totalRows_get_class_info = mysqli_num_rows($get_class_info);

 
  if(isset($_POST['day'])){

    mysqli_select_db($database, $database_database);   
    $query_get_kid = "SELECT * FROM `classgroup_list` WHERE `classgroup_id` = '{$_GET['id']}'  ";   
    $get_kid = mysqli_query($database,$query_get_kid) or die(mysqli_error($database));
    $row_get_kid = mysqli_fetch_assoc($get_kid);
    $totalRows_get_kid = mysqli_num_rows($get_kid);

    if($totalRows_get_kid>0){
      do{
        mysqli_select_db($database, $database_database); 
        $query_get_kids_list = "SELECT `parent_id` FROM `kids_list` where `kid_id`='{$row_get_kid['kid_id']}'  ";
        $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
        $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
        $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);
          if($totalRows_get_kids_list>0){
            $insertSQL1 = sprintf("INSERT INTO `notifications` (`user_id`, `kid_id`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s)",
                  GetSQLValueString($database,$row_get_kids_list['parent_id'], "int"),
                  GetSQLValueString($database,$row_get_kid['kid_id'], "int"),
                  GetSQLValueString($database,' تم الغاء مجموعة التقوى ليوم '.$_POST['day'].' لسنة '.year_of_study($row_get_class_info['study_year']).' في مادة '.subject_name($row_get_class_info['subject']), "text"),
                  GetSQLValueString($database,time(), "int"),
                  GetSQLValueString($database,4, "int"));

            mysqli_select_db($database, $database_database);     
            $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

             if(app_msg_id($row_get_kid['kid_id'])!=null){sendMessage(app_msg_id($row_get_kid['kid_id']),'HLS',' تم الغاء مجموعة التقوى ليوم '.$_POST['day'].' لسنة '.year_of_study($row_get_class_info['study_year']).' في مادة '.subject_name($row_get_class_info['subject']));}

          }

        }while($row_get_kid = mysqli_fetch_assoc($get_kid));  
    }
 

  }


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
                <h4> اعتذار عن  مجموعة تقوية </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="cancel-classgroup.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                      
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة </label>
						<div class="col-sm-4">
                            <h4><?php echo year_of_study($row_get_class_info['study_year']);?> </h4> 
						</div>
                     </div> 
                      
                      
 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="subject"> المادة الدراسية </label>
						<div class="col-sm-4" id="subject_box">
                            <h4><?php echo subject_name($row_get_class_info['subject']);?></h4> 
						</div>
                     </div> 

                     <div class="form-group">
						<label class="col-sm-3 control-label" for="emp_id"> المدرس  </label>
						<div class="col-sm-4" id="teachers">
                        <h4><?php echo emp_name($row_get_class_info['emp_id']);?></h4>  
						</div>
                      </div>   
                   
                   <?php if($row_get_class_info['friday']==1){ ?>
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="friday"> الجمعة  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الجمعة"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div> 
                     <?php } if($row_get_class_info['saturday']==1){ ?>   
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="saturday">     السبت  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
                          <button type="submit" name="day" value="السبت"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div>
                     <?php } if($row_get_class_info['sunday']==1){ ?> 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="sunday">     الاحد  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الاحد"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div> 
                     <?php } if($row_get_class_info['monday']==1){ ?> 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="monday">     الاثنين  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الاثنين"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div> 
                     <?php } if($row_get_class_info['tuesday']==1){ ?> 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="tuesday">     الثلاثاء  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الثلاثاء"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div> 
                     <?php } if($row_get_class_info['wednesday']==1){ ?> 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="wednesday">     الاربعاء  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الاربعاء"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                       </div> 
                     <?php } if($row_get_class_info['thursday']==1){ ?> 
                     <div class="form-group">
						<label class="col-sm-3 control-label" for="thursday">     الخميس  </label>
						<div class="col-sm-2" style="padding-top: 5px;"> 
            <button type="submit" name="day" value="الخميس"  class="btn btn-primary btn-block" >اعتذار</button>
                        </div>
                     </div> 
                     <?php } ?> 


				 
						
						
						
						
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