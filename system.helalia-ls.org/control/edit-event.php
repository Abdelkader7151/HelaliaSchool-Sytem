<?php
 require_once('../Connections/database.php');  
 require_once('includes/functions.php');    
 require_once('includes/access.php'); 
 require_once('includes/logout.php');  


 if($row_get_login['access12sub3']==1){

$msg ='';

if(isset($_GET['del'])){   
    $deleteSQL = sprintf("DELETE FROM `events` WHERE `id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));
  
            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
            header("location: all_events.php"); 
            exit(); 
    } 



if(isset($_POST['submit'])){  
    $image_name = $_POST['old_banner'];
    include("includes/banner.php");
    if($image_name != $_POST['old_banner']){unlink("../attachments/".$_POST['old_banner']); }

	$insertSQL = sprintf("UPDATE `events` SET `name_eng`=%s, `name_frn`=%s, `name_arb`=%s, `study_year`=%s, `text_eng`=%s, `text_frn`=%s, `text_arb`=%s, `start`=%s, `end`=%s, `banner`=%s WHERE `id`=%s  ",
                       GetSQLValueString($database,$_POST['name_eng'], "text"),
                       GetSQLValueString($database,$_POST['name_frn'], "text"),
                       GetSQLValueString($database,$_POST['name_arb'], "text"),
                       GetSQLValueString($database,$_POST['study_year'], "int"), 
                       GetSQLValueString($database,$_POST['text_eng'], "text"), 
                       GetSQLValueString($database,$_POST['text_frn'], "text"), 
                       GetSQLValueString($database,$_POST['text_arb'], "text"), 
                       GetSQLValueString($database,strtotime($_POST['start']), "int"),
                       GetSQLValueString($database,strtotime($_POST['end']), "int"),
                       GetSQLValueString($database,$image_name, "text"),
                       GetSQLValueString($database,$_GET['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
        
       header("location: all_events.php?done"); 
	      exit(); 
	} 
	 

    mysqli_select_db($database, $database_database);  
    $query_get_event = "SELECT * FROM `events`  WHERE `id` = '{$_GET['id']}'  "; 
    $get_event = mysqli_query($database,$query_get_event) or die(mysqli_error($database));
    $row_get_event = mysqli_fetch_assoc($get_event);
    $totalRows_get_event = mysqli_num_rows($get_event);

    if($totalRows_get_event<1){header("location: all_events.php");exit();}


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
                <h4> تعديل مناسبة   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="edit-event.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
			 <div class="form-group">
              <label class="col-sm-3 control-label" for="name_eng">  الالعنوان انجليزي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_eng" class="form-control" required type="text" name="name_eng" value="<?php echo $row_get_event['name_eng'];?>">
              </div>
			  </div> 

              <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="name_frn">  الالعنوان فرنسي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_frn" class="form-control"   type="text" name="name_frn" value="<?php echo $row_get_event['name_frn'];?>">
              </div>
			  </div>

              <div class="form-group">
              <label class="col-sm-3 control-label" for="name_arb">  الالعنوان عربي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_arb" class="form-control" required type="text" name="name_arb" value="<?php echo $row_get_event['name_arb'];?>">
              </div>
			  </div>

      
            <div class="form-group">
			  <label class="col-sm-3 control-label" for="text_eng">     مقدمة انجليزي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_eng" ><?php echo $row_get_event['text_eng'];?></textarea> 
              </div>
            </div> 

            <div class="form-group" style="display: none;">
			  <label class="col-sm-3 control-label" for="text_frn">     مقدمة فرنسي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_frn" ><?php echo $row_get_event['text_frn'];?></textarea> 
              </div>
            </div> 

            <div class="form-group">
			  <label class="col-sm-3 control-label" for="text_arb">     مقدمة عربي  </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="text_arb" ><?php echo $row_get_event['text_arb'];?></textarea> 
              </div>
            </div> 
                      
            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="job"> السنة الدراسية  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                        <select class="form-control" required name="study_year" id="study_year" >
                      <option disabled >...</option> 
                      <option value="1" <?php if($row_get_event['study_year']==1){echo " selected ";}?> >اولى حضانة</option> 
                      <option value="2" <?php if($row_get_event['study_year']==2){echo " selected ";}?> >ثانية حضانة</option> 
                      <option value="3" <?php if($row_get_event['study_year']==3){echo " selected ";}?>>  الصف الاول الابتدائى</option> 
                      <option value="4" <?php if($row_get_event['study_year']==4){echo " selected ";}?>>  الصف الثانى الابتدائى</option> 
                      <option value="5" <?php if($row_get_event['study_year']==5){echo " selected ";}?>>  الصف الثالث الابتدائى</option> 
                      <option value="6" <?php if($row_get_event['study_year']==6){echo " selected ";}?>>  الصف الرابع الابتدائى</option> 
                      <option value="7" <?php if($row_get_event['study_year']==7){echo " selected ";}?>>  الصف الخامس الابتدائى</option> 
                      <option value="8" <?php if($row_get_event['study_year']==8){echo " selected ";}?>>  الصف الخامس الابتدائى</option> 
                      <option value="9" <?php if($row_get_event['study_year']==9){echo " selected ";}?>>  الصف الاول الاعدادى</option> 
                      <option value="10" <?php if($row_get_event['study_year']==10){echo " selected ";}?>>  الصف الثاني الاعدادى</option> 
                      <option value="11" <?php if($row_get_event['study_year']==11){echo " selected ";}?>>  الصف الثالث الاعدادى</option> 
                      <option value="12" <?php if($row_get_event['study_year']==12){echo " selected ";}?>>  الصف الاول الثانوى</option> 
                      <option value="13" <?php if($row_get_event['study_year']==13){echo " selected ";}?>>  الصف الثاني الثانوى</option> 
                      <option value="14" <?php if($row_get_event['study_year']==14){echo " selected ";}?>>  الصف الثالث الثانوى</option> 
                      <option value="15" <?php if($row_get_event['study_year']==15){echo " selected ";}?>> عام</option> 
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
                  <input id="demo-datepicker-1" class="form-control" type="text" name="start" value="<?php echo date("m/d/Y",$row_get_event['start']);?>"  >
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
                  <input id="demo-datepicker-2" class="form-control" type="text" name="end"  value="<?php echo date("m/d/Y",$row_get_event['end']);?>" >
                </div> 
            </div> 
                   
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <img src="../attachments/<?php echo $row_get_event['banner'];?>" />
                <input id="picture" class="form-control" type="file" name="picture">
                <input id="old_banner"   type="hidden" name="old_banner" value="<?php echo $row_get_event['banner'];?>">
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