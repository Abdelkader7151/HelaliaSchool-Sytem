<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access6sub4']==1 || $row_get_login['access7sub3']==1){

$msg ='';
 

if(isset($_POST['submit'])){  
    $image_name = $_POST['old_picture'];
    include("includes/img-up3.php");
    if($image_name!=$_POST['old_picture']){ unlink("../uploads/".$_POST['old_picture']);}

	$insertSQL = sprintf("UPDATE `birthday` SET `text_eng`=%s,`text_frn`=%s,`text_arb`=%s, `picture`=%s WHERE `id`=%s ",  
                                GetSQLValueString($database,$_POST['text_eng'], "text"),
                                GetSQLValueString($database,$_POST['text_frn'], "text"),
                                GetSQLValueString($database,$_POST['text_arb'], "text"),
                                GetSQLValueString($database,$image_name, "text"), 
                                GetSQLValueString($database,$_GET['id'], "int"));

                                mysqli_select_db($database, $database_database);  
                                $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));

			header("location: birthday-card.php?id=".$_GET['id']."&done"); 
			exit();
	      
	} 
	
 
mysqli_select_db($database, $database_database);  
$query_get_users_birthday = "SELECT * FROM `birthday` where `id`  ='{$_GET['id']}' "; 
$get_users_birthday = mysqli_query($database,$query_get_users_birthday) or die(mysqli_error($database));
$row_get_users_birthday = mysqli_fetch_assoc($get_users_birthday);
$totalRows_get_users_birthday = mysqli_num_rows($get_users_birthday);

 

$head_title = "  بطاقة التهنئة";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css"> 
  <?php require_once('includes/text-editor.php'); ?>
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
                <h4>   بطاقة التهنئة   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-10">
				  <div class="demo-form-wrapper">
                    <form action="birthday-card.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" enctype="multipart/form-data" class="form form-horizontal">
                    

                    <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-9">
              <img src="../uploads/<?php echo $row_get_users_birthday['picture'];?>" class="image-responsive" />
                <input id="picture" class="form-control"   type="file" name="picture">
                <input type="hidden" name="old_picture" value="<?php echo $row_get_users_birthday['picture'];?>" />
              </div>
		        </div> 

                      
                      <div class="form-group">
              <label class="col-sm-3 control-label" for="text_eng">  الانجليزية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="text_eng" class="form-control text_editor" name="text_eng" ><?php echo $row_get_users_birthday['text_eng'];?></textarea>
              </div>
                      </div> 
                      
                      <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="text_frn">  الفرنسية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="mission_frn" class="form-control text_editor"  name="text_frn" ><?php echo $row_get_users_birthday['text_frn'];?></textarea>
              </div>
                      </div> 
                      
                      <div class="form-group">
              <label class="col-sm-3 control-label" for="text_arb">  العربية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="mission_arb" class="form-control text_editor" name="text_arb" ><?php echo $row_get_users_birthday['text_arb'];?></textarea>
              </div>
					  </div> 
					 
            
 
 
					
                       <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
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