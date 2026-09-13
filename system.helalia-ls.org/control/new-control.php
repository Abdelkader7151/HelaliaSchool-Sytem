<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub1']==1){

 

  mysqli_select_db($database, $database_database);  
  $query_get_data = "SELECT distinct `subject_id` FROM `control`   ";    
  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);
  
  if($totalRows_get_data>0){ 
      do{      
        
          mysqli_select_db($database, $database_database);  
          $query_get_subject = "SELECT * FROM `subjects`  WHERE `id` = '{$row_get_data['subject_id']}'  "; 
          $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
          $row_get_subject = mysqli_fetch_assoc($get_subject);
          $totalRows_get_subject = mysqli_num_rows($get_subject);

          if($totalRows_get_subject<1){
              $deleteSQL = sprintf("DELETE FROM `control` WHERE `subject_id` = %s ",
                               GetSQLValueString($database,$row_get_data['subject_id'], "int"));

              mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

              $deleteSQL2 = sprintf("DELETE FROM `control_year` WHERE `subject_id` = %s ",
                               GetSQLValueString($database,$row_get_data['subject_id'], "int"));
                               
              mysqli_query($database,$deleteSQL2) or die(mysqli_error($database));
          }

      }while($row_get_data = mysqli_fetch_assoc($get_data)); 
  } 




 if(isset($_POST['submit'])){
 
        if($_POST['class']>0){  $class = " AND `class` = '{$_POST['class']}' "; }else{ $class = ""; } 
        if($_POST['gender']!='الاثنين'){ $gender = " AND `gender` = '{$_POST['gender']}' "; }else{ $gender = ""; } 
        

        mysqli_select_db($database, $database_database); 
        $query_get_kids = "SELECT * FROM `kids` WHERE `study_year`= '{$_POST['study_year']}' $class $gender ORDER BY `gender` DESC, `name` ASC ";
        $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
        $row_get_kids = mysqli_fetch_assoc($get_kids);
        $totalRows_get_kids = mysqli_num_rows($get_kids);
        if($totalRows_get_kids>0){  

        mysqli_select_db($database, $database_database); 
        $query_get_subject = "SELECT * FROM `subjects` WHERE `id`= '{$_POST['subject']}'  ";
        $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
        $row_get_subject = mysqli_fetch_assoc($get_subject);
        $totalRows_get_subject = mysqli_num_rows($get_subject); 

            do{  
                mysqli_select_db($database, $database_database); 
                $query_get_control = "SELECT * FROM `control` WHERE `kid_id` = '{$row_get_kids['id']}' AND `study_year`= '{$row_get_kids['study_year']}' AND `class`= '{$row_get_kids['class']}' AND `subject_id` = '{$_POST['subject']}' AND `month` = '{$_POST['month']}' ";
                $get_control = mysqli_query($database,$query_get_control) or die(mysqli_error($database));
                $row_get_control = mysqli_fetch_assoc($get_control);
                $totalRows_get_control = mysqli_num_rows($get_control);
                        if($totalRows_get_control<1){ 
                            $insertSQL = sprintf("INSERT INTO `control` ( `order`, `kid_id`, `seat_id`, `name`, `arb_name`, `gender`, `study_year`, `class`, `subject_id`, `subject_name`, `admin_id`, `date`, `month`, `ex_total`,  `month_total` ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                                            GetSQLValueString($database,$row_get_subject['order'], "int"),  
                                            GetSQLValueString($database,$row_get_kids['id'], "int"), 
                                            GetSQLValueString($database,$row_get_kids['ed_id'], "int"), 
                                            GetSQLValueString($database,$row_get_kids['fn_name'], "text"), 
                                            GetSQLValueString($database,$row_get_kids['name'], "text"), 
                                            GetSQLValueString($database,$row_get_kids['gender'], "text"), 
                                            GetSQLValueString($database,$row_get_kids['study_year'], "int"), 
                                            GetSQLValueString($database,$row_get_kids['class'], "int"), 
                                            GetSQLValueString($database,$row_get_subject['id'], "int"), 
                                            GetSQLValueString($database,$row_get_subject['name'], "text"), 
                                            GetSQLValueString($database,$row_get_login['id'], "int"),
                                            GetSQLValueString($database,time(), "int"),
                                            GetSQLValueString($database,$_POST['month'], "int"),  
                                            GetSQLValueString($database,$row_get_subject['score'], "double"),   
                                            GetSQLValueString($database,$row_get_subject['month_score'], "double"));

                            mysqli_query($database,$insertSQL) or die(mysqli_error($database));  
                        }            
            }while($row_get_kids = mysqli_fetch_assoc($get_kids));
        }

        header("location: control-step2.php?year=".$_POST['study_year']."&class=".$_POST['class']."&gender=".$_POST['gender']."&subject=".$_POST['subject']."&month=".$_POST['month']);
        exit();
 } 
  

$head_title = "  الكنترول";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css">  

<script>
 $(document).ready(function(){ 
 
  
});
</script>
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
                <h4>     رصد الدرجات </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-control.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     

            <div class="form-group" >
			  <label class="col-sm-3 control-label" for="month"> الشهر  <span style="color: red;">*</span></label>
              <div class="col-sm-2">
                  <select class="form-control" name="month" id="month" required >
                        <option selected >...</option> 
                        <option value="10">اكتوبر</option>  
                        <option value="11">نوفمبر</option>  
                        <option value="12">ديسمبر</option>  
                        <option value="1">يناير</option>  
                        <option value="2" disabled>فبراير</option>  
                        <option value="3">امتحان شهر اول</option>  
                        <option value="4">امتحان شهر ثاني</option>  
                        <option value="5">مايو</option>  
                        <option value="6" disabled>يونيو</option>  
                        <option value="7" disabled>يوليو</option>  
                        <option value="8" disabled>اغسطس</option>  
                  </select>
              </div>
            </div>
           
   

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-3">
                <select class="form-control" required name="study_year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0"> بري سكول </option> 
                      <option value="1">اولى حضانة</option> 
                      <option value="2">ثانية حضانة</option> 
                      <option value="3">  الصف الاول الابتدائى</option> 
                      <option value="4">  الصف الثانى الابتدائى</option> 
                      <option value="5">  الصف الثالث الابتدائى</option> 
                      <option value="6">  الصف الرابع الابتدائى</option> 
                      <option value="7">  الصف الخامس الابتدائى</option> 
                      <option value="8">  الصف السادس الابتدائى</option> 
                      <option value="9">  الصف الاول الاعدادى</option> 
                      <option value="10">  الصف الثاني الاعدادى</option> 
                      <option value="11">  الصف الثالث الاعدادى</option> 
                      <option value="12">  الصف الاول الثانوى</option> 
                      <option value="13">  الصف الثاني الثانوى</option> 
                      <option value="14">  الصف الثالث الثانوى</option> 

                </select>
						</div>
            </div> 

         
      
            <div class="form-group">
			     <label class="col-sm-3 control-label" for="class" > الفصل <span style="color: red;">*</span></label>
                <div class="col-sm-3" >
                    <select class="form-control"  name="class" id="class" required >
                        <option selected></option>  
                    </select>
                </div>
            </div> 

         

            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع  <span style="color: red;">*</span></label>
						<div class="col-sm-2">
                            <select class="form-control"   name="gender" id="gender" > 
                                <option value="الاثنين">  الاثنين</option>  
                                <option value="ذكر">  ذكر</option> 
                                <option value="انثى">  انثى</option>   
                            </select>
						</div>
            </div> 

             
            
            <div class="form-group" >
                    <label class="col-sm-3 control-label" for="subject"> المادة  <span style="color: red;">*</span></label>
                    <div class="col-sm-3" id="subject_box">
                        <select class="form-control" name="subject" id="subject" > 
                        </select>
                    </div>
            </div>


 
						
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >حفظ</button> 
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
 

   $("#study_year").change(function(){
        var year = $(this).val(); 
 
        $.post("get_class2.php",
            {
                year:year
            },
                function(Date,status){  
                    $("#class").html(Date);   
            }); 

            $.post("get_subject2.php",
                {
                    year:year
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