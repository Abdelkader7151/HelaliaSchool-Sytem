<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access1sub3']==1){


  if(isset($_GET['del'])){   
    $updateSQL = sprintf("UPDATE `kids` SET `class`=null  WHERE `class`=%s ",  
                         GetSQLValueString($database,$_GET['del'], "int"));

    mysqli_select_db($database, $database_database);   
    $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));

         
    $deleteSQL = sprintf("DELETE FROM `class` WHERE `id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
            header("location: all-classs.php"); 
            exit(); 
    } 


$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `class` SET `name`=%s, `study_year`=%s WHERE `id`=%s ", 
                       GetSQLValueString($database,$_POST['name'], "text"), 
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
        header("location: edit-class.php?id=".$_POST['id']."&done"); 
        exit(); 
	} 
	
 

  mysqli_select_db($database, $database_database); 
  $query_get_class = "SELECT * FROM `class` where `id`='{$_GET['id']}'";
  $get_class = mysqli_query($database,$query_get_class) or die(mysqli_error($database));
  $row_get_class = mysqli_fetch_assoc($get_class);
  $totalRows_get_class = mysqli_num_rows($get_class);

  if($totalRows_get_class<1){header("location: all-classs.php");exit();}

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
                <h4> تعديل فصل   </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="edit-class.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">



             <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  عدد الطالبات  </label>
              <div class="col-sm-1">
                <input class="form-control" disabled type="text"  value="<?php echo count_class_kid($_GET['id']);?>">
              </div>
					  </div> 


					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name" class="form-control" required type="text" name="name" value="<?php echo $row_get_class['name'];?>">
              </div>
					  </div> 
					 
				 

             
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="study_year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0" <?php if($row_get_class['study_year']==0){echo " selected ";}?>  >  بري سكول</option> 
                      <option value="1" <?php if($row_get_class['study_year']==1){echo " selected ";}?>  >اولى حضانة</option> 
                      <option value="2" <?php if($row_get_class['study_year']==2){echo " selected ";}?>>ثانية حضانة</option> 
                      <option value="3" <?php if($row_get_class['study_year']==3){echo " selected ";}?>>  الصف الاول الابتدائى</option> 
                      <option value="4" <?php if($row_get_class['study_year']==4){echo " selected ";}?>>  الصف الثانى الابتدائى</option> 
                      <option value="5" <?php if($row_get_class['study_year']==5){echo " selected ";}?>>  الصف الثالث الابتدائى</option> 
                      <option value="6" <?php if($row_get_class['study_year']==6){echo " selected ";}?>>  الصف الرابع الابتدائى</option> 
                      <option value="7" <?php if($row_get_class['study_year']==7){echo " selected ";}?>>  الصف الخامس الابتدائى</option> 
                      <option value="8" <?php if($row_get_class['study_year']==8){echo " selected ";}?>>  الصف السادس الابتدائى</option> 
                      <option value="9" <?php if($row_get_class['study_year']==9){echo " selected ";}?>>  الصف الاول الاعدادى</option> 
                      <option value="10" <?php if($row_get_class['study_year']==10){echo " selected ";}?>>  الصف الثاني الاعدادى</option> 
                      <option value="11" <?php if($row_get_class['study_year']==11){echo " selected ";}?>>  الصف الثالث الاعدادى</option> 
                      <option value="12" <?php if($row_get_class['study_year']==12){echo " selected ";}?>>  الصف الاول الثانوى</option> 
                      <option value="13" <?php if($row_get_class['study_year']==13){echo " selected ";}?>>  الصف الثاني الثانوى</option> 
                      <option value="14" <?php if($row_get_class['study_year']==14){echo " selected ";}?>>  الصف الثالث الثانوى</option>  
                </select>
						</div>
            </div> 
                      
                      
 
            <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_class['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                       
                          <?php if(count_class_kid($_GET['id'])<1){?>
                          <div class="col-sm-2">  
                            <a href="edit-class.php?del=<?php echo $row_get_class['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                          </div>
                          <?php }?>
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

<?php }else{header("location: home.php;");exit();}?>