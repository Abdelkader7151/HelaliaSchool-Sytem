<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access9sub1']==1 || $row_get_login['access9sub2']==1){


  if(isset($_GET['del'])){    
    $deleteSQL = sprintf("DELETE FROM `ask_teacher` WHERE `id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
            header("location: all-teacher-msg.php"); 
            exit(); 
    } 


$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `ask_teacher` SET `reply`=%s, `status`=1, `view`=1 WHERE `id`=%s ", 
                       GetSQLValueString($database,$_POST['reply'], "text"),  
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
        header("location: all-teacher-msg.php?&done"); 
        exit(); 
	} 
	
 

    
    mysqli_select_db($database, $database_database); 
    $query_get_question = "SELECT * FROM `ask_teacher` where `id` = '{$_GET['id']}'";
    $get_question = mysqli_query($database,$query_get_question) or die(mysqli_error($database));
    $row_get_question = mysqli_fetch_assoc($get_question);
    $totalRows_get_question = mysqli_num_rows($get_question);
    
    mysqli_select_db($database, $database_database); 
    $query_get_kids = "SELECT * FROM `kids` where `id` = '{$row_get_question['kid_id']}'";
    $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
    $row_get_kids = mysqli_fetch_assoc($get_kids);
    $totalRows_get_kids = mysqli_num_rows($get_kids);
    
    
    mysqli_select_db($database, $database_database); 
    $query_get_teachers = "SELECT * FROM `teachers` where `study_year` = '{$row_get_question['study_year']}'  and `class` = '{$row_get_kids['class']}' and `subject` = '{$row_get_question['subject']}'";
    $get_teachers = mysqli_query($database,$query_get_teachers) or die(mysqli_error($database));
    $row_get_teachers = mysqli_fetch_assoc($get_teachers);
    $totalRows_get_teachers = mysqli_num_rows($get_teachers);

  if($totalRows_get_question<1){header("location: all-teacher-msg.php");exit();}

$head_title = "  الفصول";
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
                <h4>   استفسار من ولي امر   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="view-teacher-msg.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الحالة  </label>
                        <div class="col-sm-9">
                        <?php switch($row_get_question['status']){
                            case 0:
                                echo "<span style='color: blue'>معلق</span>";
                                break;
                            case 1:
                                echo "<span style='color: green'>تم الرد</span>";
                                break;   
                            } ?> 
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  تاريخ  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo date("d/m/Y",$row_get_question['date']);?>">
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الطالب  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo kid_name($row_get_question['kid_id']);?>">
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  المرحلة  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo year_of_study($row_get_question['study_year']);?>">
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الفصل  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo class_name($row_get_kids['class']);?>">
                        </div>
					  </div> 
				 
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  المادة  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo question_direct($row_get_question['subject']);?>">
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  السؤال  </label>
                        <div class="col-sm-9">
                            <textarea  class="form-control" style="background-color:white" readonly><?php echo $row_get_question['text'];?></textarea> 
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  المدرس  </label>
                        <div class="col-sm-9">
                        <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo emp_name($row_get_question['teacher_id']);?>">
                        </div>
					  </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  موجة الرسالة  </label>
                        <div class="col-sm-9">
                        <input id="name" class="form-control" style="background-color:white" readonly type="text" name="name" value="<?php echo emp_name($row_get_question['director_id']);?>">
                        </div>
					  </div> 


                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الرد  </label>
                        <div class="col-sm-9">
                            <textarea  class="form-control" style="background-color:white"   required name="reply"><?php echo $row_get_question['reply'];?></textarea> 
                        </div>
					  </div> 
              
 
                      <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_question['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                          <div class="col-sm-2"> 
                            <a href="view-teacher-msg.php?del=<?php echo $row_get_question['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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



        $('#demo-inputmask').on('blur', '#gov_id', function (event) { 
			  // event.preventDefault(); 
           
			  var gov = $("#gov_id").val();  
			  $.post("check-gov.php",
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