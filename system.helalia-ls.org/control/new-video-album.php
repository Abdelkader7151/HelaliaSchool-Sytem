<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access14']==1){

$msg ='';

if(isset($_POST['submit'])){   
  	$insertSQL = sprintf("INSERT INTO `video-albums` ( `year`, `title`) VALUES ( %s, %s )", 
                       GetSQLValueString($database,$_POST['year'], "int"), 
                       GetSQLValueString($database,$_POST['title'], "text"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
        
	} 


  if(isset($_POST['submit'])){   
      	$insertSQL = sprintf("INSERT INTO `video-albums` ( `year`, `title` ) VALUES ( %s, %s )", 
               GetSQLValueString($database,$_POST['year'], "int"), 
                       GetSQLValueString($database,$_POST['title'], "text")); 

        mysqli_query($database,$insertSQL) or die(mysqli_error($database));

      $query_get_data = "SELECT * FROM `video-albums` WHERE `year`='{$_POST['year']}' ORDER BY `id` DESC limit 1";
      $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
      $row_get_data = mysqli_fetch_assoc($get_data);
      $totalRows_get_data = mysqli_num_rows($get_data);  
 
      $query_get_gallery_albums = "SELECT * FROM `class` where `study_year`='{$_POST['year']}' ";
      $get_gallery_albums = mysqli_query($database,$query_get_gallery_albums) or die(mysqli_error($database));
      $row_get_gallery_albums = mysqli_fetch_assoc($get_gallery_albums);
      $totalRows_get_gallery_albums = mysqli_num_rows($get_gallery_albums); 

        if($totalRows_get_gallery_albums>0){
           do{ 
                if(isset($_POST['class'.$row_get_gallery_albums['id']]) && $_POST['class'.$row_get_gallery_albums['id']]==1){ 
                    $insertSQL2 = sprintf("INSERT INTO `video-albums-classs` ( `album_id`, `class_id`) VALUES ( %s, %s )", 
                     GetSQLValueString($database,$row_get_data['id'], "int"), 
                             GetSQLValueString($database,$row_get_gallery_albums['id'], "int")); 

                    mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
                }  
          }while($row_get_gallery_albums = mysqli_fetch_assoc($get_gallery_albums));
       }  

        header("location: edit-video-album.php?id=".$row_get_data['id']."&done"); 
        exit();
        
	} 
	
 
 

$head_title = "  معرض الفيديو";
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
                <h4>     البوم جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-video-album.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الالعنوان <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="title" class="form-control" required type="text" name="title">
              </div>
					  </div> 
					 
				 

             
           <div class="form-group">
						<label class="col-sm-3 control-label" for="year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="year" id="year" >
                      <option selected disabled >...</option> 
                      <option value="0">  بريسكول</option> 
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
                      <option value="15">      عام</option> 
                </select>
						</div>
            </div> 
                      
                      
        
            <div class="form-group">
              <label class="col-sm-3 control-label" for="class"> الفصل </label>
              <div class="col-sm-4" id="study_year_class"> </div>
            </div>

						
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						     <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >حفظ</button> 
                 <i class="fa fa-spinner fa-spin fa-fw fa-lg" style="color: blue; display: none;" id="loading_submit"></i>
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


 

  $("#demo-inputmask").on('submit', function(){
          $("#loading_submit").fadeIn(); 
           $("#submit").fadeOut();
      });

       

    $("#year").change(function(){
          var year = $(this).val(); 
          $("#loading").fadeIn();
            $.post("get_class_select.php",
              {
                year:year
              },
                  function(Date,status){  
                      $("#loading").fadeOut();
                      $("#study_year_class").html(Date); 
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