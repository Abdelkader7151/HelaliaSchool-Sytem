<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access15']==1){

$msg ='';
 

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `settings` SET `mission_eng`=%s, `mission_arb`=%s, `mission_frn`=%s WHERE `id`=1 ", 
                                GetSQLValueString($database,$_POST['mission_eng'], "text"),
                                GetSQLValueString($database,$_POST['mission_arb'], "text"),
                                GetSQLValueString($database,$_POST['mission_frn'], "text"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));

       
			header("location: mission.php?id=".$_POST['id']."&done"); 
			exit();
	      
	} 
	
 

 

$head_title = "  المهمة";
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
                <h4>   المهمة   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-10">
				  <div class="demo-form-wrapper">
                    <form action="mission.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الانجليزية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="mission_eng" class="form-control text_editor"    name="mission_eng" ><?php echo $row_get_settings['mission_eng'];?></textarea>
              </div>
                      </div> 
                      
                      <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="name">  الفرنسية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="mission_frn" class="form-control text_editor"    name="mission_frn" ><?php echo $row_get_settings['mission_frn'];?></textarea>
              </div>
                      </div> 
                      
                      <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  العربية <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <textarea   id="mission_arb" class="form-control text_editor"    name="mission_arb" ><?php echo $row_get_settings['mission_arb'];?></textarea>
              </div>
					  </div> 
					 
            
 

                      
                     
 
 
                       
 
						
					
                       <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_jobs['id'];?>" />
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



    


       








        $("#app").click(function(){   
            if($(this).is(":checked")){
                $(".app").fadeIn();  
             }else{
                $(".app_btn").each(function(){ 
                    $(this).prop( "checked", false );
                });
                $(".app").fadeOut(); 
           } 

        });

 

		 
		  
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
      

 
 


	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>