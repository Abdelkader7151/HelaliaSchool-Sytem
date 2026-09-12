<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access3sub2']==1){


$msg ='';

    if(isset($_POST['submit'])){   
    	$insertSQL = sprintf("INSERT INTO `coordinators_teachers` ( `cor_id`, `teacher_id` ) VALUES ( %s, %s )",  
                       GetSQLValueString($database,$_GET['id'], "int"),
                       GetSQLValueString($database,$_POST['teacher_id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
        header("location: add-cor-teachers.php?id=".$_GET['id']."&done"); 
        exit(); 
	} 
	
 
 
  mysqli_select_db($database, $database_database);  
  $query_get_teachers = "SELECT distinct `emp_id`  FROM `teachers_view` ORDER BY `name` ASC  "; 
  $get_teachers = mysqli_query($database,$query_get_teachers) or die(mysqli_error($database));
  $row_get_teachers = mysqli_fetch_assoc($get_teachers);
  $totalRows_get_teachers = mysqli_num_rows($get_teachers);
  

$head_title = "      ربط المدرس";
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
                <h4>   ربط مدرس جديد جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">

                <h3>المنسق / <?php echo emp_name($_GET['id']);?></h3>
				  <div class="demo-form-wrapper">
                    <form action="add-cor-teachers.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
              

                    <div class="form-group">
						<label class="col-sm-3 control-label" for="teacher"> المدرس  </label>
						<div class="col-sm-4">
                            <select class="form-control select2"   name="teacher_id" id="teacher_id" > 
                                <option value="" > </option>  
                                <?php if($totalRows_get_teachers>0){
                                     do{  
                                        mysqli_select_db($database, $database_database);  
                                        $query_check_teachers = "SELECT * FROM `coordinators_teachers`  WHERE `cor_id` ='{$_GET['id']}' AND `teacher_id` = '{$row_get_teachers['emp_id']}'  "; 
                                        $check_teachers = mysqli_query($database,$query_check_teachers) or die(mysqli_error($database));
                                        $row_check_teachers = mysqli_fetch_assoc($check_teachers);
                                        $totalRows_check_teachers = mysqli_num_rows($check_teachers);
                                        if($totalRows_check_teachers<1){ ?>
                                         <option value="<?php echo $row_get_teachers['emp_id'];?>" ><?php echo emp_name($row_get_teachers['emp_id']);?></option>  
                                        <?php  } }while($row_get_teachers = mysqli_fetch_assoc($get_teachers));}?> 
                         </select>
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
        if(study_year==13 || study_year==14){ $("#major_box").fadeIn();}else{ $("#major_box").fadeOut(); }
			  $.post("study_year_subjects.php",
			  {
                study_year:study_year
		    },
            function(Date,status){ 

                  $("#subject_box").html(Date);
                  
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
		  
		  
$(".select2").select2({
					dir: "rtl"
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