<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access12sub1']==1){

$msg ='';

if(isset($_POST['submit'])){  
    $image_name = null;
    include("includes/banner.php");
	  $insertSQL = sprintf("INSERT INTO `events` ( `name_eng`, `name_frn`, `name_arb`, `study_year`, `text_eng`, `text_frn`, `text_arb`, `start`, `end`, `banner`) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                       GetSQLValueString($database,$_POST['name_eng'], "text"),
                       GetSQLValueString($database,$_POST['name_frn'], "text"),
                       GetSQLValueString($database,$_POST['name_arb'], "text"),
                       GetSQLValueString($database,$_POST['study_year'], "int"), 
                       GetSQLValueString($database,$_POST['text_eng'], "text"), 
                       GetSQLValueString($database,$_POST['text_frn'], "text"), 
                       GetSQLValueString($database,$_POST['text_arb'], "text"), 
                       GetSQLValueString($database,strtotime($_POST['start']), "int"),
                       GetSQLValueString($database,strtotime($_POST['end']), "int"),
                       GetSQLValueString($database,$image_name, "text"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));



       if($_POST['study_year']==15){ 
        $study_year  = ""; 
      }else{
        $study_year = " AND `kids`.study_year = '{$_POST['study_year']}' ";
      }

        mysqli_select_db($database, $database_database); 
        $query_get_target = "SELECT `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id = `app_login`.id  WHERE `kids`.linked = 1  $study_year ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target);   
            do{  
              if($row_get_target['parent_id']!=NULL){     
                sendMessage($row_get_target['phone_id'],$_POST['name_eng'], $_POST['text_eng']);
              }
            }while($row_get_target = mysqli_fetch_assoc($get_target));  
 
       header("location: all-events.php?done"); 
			exit(); 
	} 
	 

  

$head_title = "  المناسبات";
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
                <h4> أضافة مناسبة جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new_event.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
			 <div class="form-group">
              <label class="col-sm-3 control-label" for="name_eng">  الالعنوان انجليزي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_eng" class="form-control" required type="text" name="name_eng">
              </div>
			  </div> 

              <div class="form-group" style="display: none;" >
              <label class="col-sm-3 control-label" for="name_frn">  الالعنوان فرنسي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_frn" class="form-control"   type="text" name="name_frn">
              </div>
			  </div>

              <div class="form-group">
              <label class="col-sm-3 control-label" for="name_arb">  الالعنوان عربي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_arb" class="form-control" required type="text" name="name_arb">
              </div>
			  </div>

      
            <div class="form-group">
			  <label class="col-sm-3 control-label" for="text_eng">     مقدمة انجليزي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_eng" > </textarea> 
              </div>
            </div> 

            <div class="form-group" style="display: none;">
			  <label class="col-sm-3 control-label" for="text_frn">     مقدمة فرنسي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_frn" > </textarea> 
              </div>
            </div> 

            <div class="form-group">
			  <label class="col-sm-3 control-label" for="text_arb">     مقدمة عربي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_arb" > </textarea> 
              </div>
            </div> 
                      
            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="job"> السنة الدراسية  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                        <select class="form-control" required name="study_year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0"> بري سكول</option> 
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
                      <option value="15"> عام</option> 
                </select>
						</div>
            </div> 

             

            <div class="form-group">
              <label class="col-sm-3 control-label" for="start">   تاريخ البداية   </label>
              <div class="input-group date col-sm-4">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" type="text" name="start"  >
                </div> 
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="end">   تاريخ الانتهاء   </label>
              <div class="input-group date col-sm-4">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-2-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-2" class="form-control" type="text" name="end"  >
                </div> 
            </div> 
                   
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <input id="picture" class="form-control"   type="file" name="picture">
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