<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access13']==1){

     

    if(isset($_GET['remove'])){    
        mysqli_select_db($database, $database_database); 
        $query_get_users_info = "SELECT `link` FROM `gallery-pictures` where `id`='{$_GET['remove']}'  ";
        $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
        $row_get_users_info = mysqli_fetch_assoc($get_users_info);
        $totalRows_get_users_info = mysqli_num_rows($get_users_info);

        if($row_get_users_info['link']!=null){ unlink("../gallery/".$row_get_users_info['link']);}

        $deleteSQL = sprintf("DELETE FROM `gallery-pictures` WHERE `id`=%s ",
                           GetSQLValueString($database,$_GET['remove'], "int"));
    
                mysqli_select_db($database, $database_database);  
                $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database)); 
        } 


    if(isset($_GET['del'])){    
        mysqli_select_db($database, $database_database); 
        $query_get_users_info = "SELECT `link` FROM `gallery-albums` where `id`='{$_GET['del']}'  ";
        $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
        $row_get_users_info = mysqli_fetch_assoc($get_users_info);
        $totalRows_get_users_info = mysqli_num_rows($get_users_info);

        if($row_get_users_info['link']!=null){ unlink("../gallery/".$row_get_users_info['link']);}

        $deleteSQL = sprintf("DELETE FROM `gallery-albums` WHERE `id`=%s ",
                           GetSQLValueString($database,$_GET['del'], "int"));
    
                mysqli_select_db($database, $database_database);  
                $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
                header("location: all-photo-albums.php"); 
                exit(); 
        } 

$msg ='';

if(isset($_POST['submit'])){  
    $image_name = $_POST['old_picture'];
    include("includes/img-up2.php");
    if($image_name!=$_POST['old_picture']){ unlink("../gallery/".$_POST['old_picture']);}

        $insertSQL = sprintf("UPDATE `gallery-albums` SET `link`=%s, `year`=%s, `title`=%s WHERE `id` = %s",
                    GetSQLValueString($database,$image_name, "text"), 
                    GetSQLValueString($database,$_POST['year'], "int"), 
                    GetSQLValueString($database,$_POST['title'], "text"),  
                    GetSQLValueString($database,$_POST['id'], "int"));
   
        mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 

              $deleteSQL = sprintf("DELETE FROM `gallery-albums-classs` WHERE `album_id`=%s ",
                           GetSQLValueString($database,$_POST['id'], "int"));
    
              mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

      $query_get_gallery_albums = "SELECT * FROM `class` where `study_year`='{$_POST['year']}' ";
      $get_gallery_albums = mysqli_query($database,$query_get_gallery_albums) or die(mysqli_error($database));
      $row_get_gallery_albums = mysqli_fetch_assoc($get_gallery_albums);
      $totalRows_get_gallery_albums = mysqli_num_rows($get_gallery_albums); 

        if($totalRows_get_gallery_albums>0){
           do{ 
                if(isset($_POST['class'.$row_get_gallery_albums['id']]) && $_POST['class'.$row_get_gallery_albums['id']]==1){ 
                    $insertSQL2 = sprintf("INSERT INTO `gallery-albums-classs` ( `album_id`, `class_id`) VALUES ( %s, %s )", 
                     GetSQLValueString($database,$_POST['id'], "int"), 
                             GetSQLValueString($database,$row_get_gallery_albums['id'], "int")); 

                    mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
                }  
          }while($row_get_gallery_albums = mysqli_fetch_assoc($get_gallery_albums));
       }  



        $error = 0;
        // Count total files
        $countfiles = count($_FILES['file']['name']);
    
        // Looping all files
        for($i=0;$i<$countfiles;$i++){ 
            
            $filename = stripslashes($_FILES['file']['name'][$i]); 
            $size = filesize($_FILES['file']['tmp_name'][$i]); 
            $extension = getExtension($filename);
            $extension = strtolower($extension); 
            if ($size/1000 > 25000){  $error = 1;  } 
            if (($extension != "tif") && ($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "pdf") && ($extension != "doc") && ($extension != "docx") && ($extension != "jfif")){ $error = 1; } 
            
            $image_name = $_POST['id'].'-'.($i+1).'-'.time().'.'.$extension;  
            
            if($error == 0){
                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i],'../gallery/'.$image_name);

                $insertSQL3 = sprintf("INSERT INTO `gallery-pictures` ( `album_id`,  `link` ) VALUES (%s, %s)",
                                GetSQLValueString($database,$_POST['id'], "int"), 
                                GetSQLValueString($database,$image_name, "text"));

                $Result3 = mysqli_query($database,$insertSQL3) or die(mysqli_error($database));   
            } 
        }  
} 
	
 
mysqli_select_db($database, $database_database); 
$query_get_gallery_albums = "SELECT * FROM `gallery-albums` where `id`='{$_GET['id']}'  ";
$get_gallery_albums = mysqli_query($database,$query_get_gallery_albums) or die(mysqli_error($database));
$row_get_gallery_albums = mysqli_fetch_assoc($get_gallery_albums);
$totalRows_get_gallery_albums= mysqli_num_rows($get_gallery_albums);

if($totalRows_get_gallery_albums<1){header("location: all-photo-albums.php"); exit();}



mysqli_select_db($database, $database_database); 
$query_get_gallery = "SELECT * FROM `gallery-pictures` where `album_id`='{$_GET['id']}'  ";
$get_gallery  = mysqli_query($database,$query_get_gallery) or die(mysqli_error($database));
$row_get_gallery  = mysqli_fetch_assoc($get_gallery);
$totalRows_get_gallery = mysqli_num_rows($get_gallery);


$head_title = "  معرض الصور";
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
                <h4>       تعديل البوم </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-6">
				  <div class="demo-form-wrapper">
                    <form action="edit-photo-album.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
           <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  الغلاف </label>
              <div class="col-sm-4">
              <?php if($row_get_gallery_albums['link']!=null){?><img src="../gallery/<?php echo $row_get_gallery_albums['link'];?>" class="img-responsive" ><?php }?>
                <input id="picture" class="form-control"   type="file" name="picture">
                <input type="hidden" name="old_picture" value="<?php echo $row_get_gallery_albums['link'];?>" />
              </div>
           </div> 


					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الالعنوان <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="title" class="form-control" required type="text" name="title" value="<?php echo $row_get_gallery_albums['title'];?>">
              </div>
					  </div> 
					 
				 

             
          <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="year" id="year" >
                      <option   disabled >...</option> 
                      <option value="0" <?php if($row_get_gallery_albums['year']==0){echo " selected ";}?> >  بريسكول</option> 
                      <option value="1" <?php if($row_get_gallery_albums['year']==1){echo " selected ";}?> >اولى حضانة</option> 
                      <option value="2" <?php if($row_get_gallery_albums['year']==2){echo " selected ";}?> >ثانية حضانة</option> 
                      <option value="3" <?php if($row_get_gallery_albums['year']==3){echo " selected ";}?> >  الصف الاول الابتدائى</option> 
                      <option value="4" <?php if($row_get_gallery_albums['year']==4){echo " selected ";}?> >  الصف الثانى الابتدائى</option> 
                      <option value="5" <?php if($row_get_gallery_albums['year']==5){echo " selected ";}?> >  الصف الثالث الابتدائى</option> 
                      <option value="6" <?php if($row_get_gallery_albums['year']==6){echo " selected ";}?> >  الصف الرابع الابتدائى</option> 
                      <option value="7" <?php if($row_get_gallery_albums['year']==7){echo " selected ";}?> >  الصف الخامس الابتدائى</option> 
                      <option value="8" <?php if($row_get_gallery_albums['year']==8){echo " selected ";}?> >  الصف الخامس الابتدائى</option> 
                      <option value="9" <?php if($row_get_gallery_albums['year']==9){echo " selected ";}?> >  الصف الاول الاعدادى</option> 
                      <option value="10" <?php if($row_get_gallery_albums['year']==10){echo " selected ";}?> >  الصف الثاني الاعدادى</option> 
                      <option value="11" <?php if($row_get_gallery_albums['year']==11){echo " selected ";}?> >  الصف الثالث الاعدادى</option> 
                      <option value="12" <?php if($row_get_gallery_albums['year']==12){echo " selected ";}?> >  الصف الاول الثانوى</option> 
                      <option value="13" <?php if($row_get_gallery_albums['year']==13){echo " selected ";}?> >  الصف الثاني الثانوى</option> 
                      <option value="14" <?php if($row_get_gallery_albums['year']==14){echo " selected ";}?> >  الصف الثالث الثانوى</option> 
                      <option value="15" <?php if($row_get_gallery_albums['year']==15){echo " selected ";}?> >      عام</option> 
                </select>
						</div>
            </div> 
                      

          


  <?php 
    $query_get_data = "SELECT * FROM `class` WHERE `study_year`='{$row_get_gallery_albums['year']}' ";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data); ?>
 
           <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الفصول <span style="color: red;">*</span></label>
              <div class="col-sm-6"  id="study_year_class">
                  <?php if($totalRows_get_data>0){
                        do{
                          $query_get_classs = "SELECT * FROM `gallery-albums-classs` WHERE `album_id`='{$row_get_gallery_albums['id']}' AND `class_id`='{$row_get_data['id']}' ";
                          $get_classs = mysqli_query($database,$query_get_classs) or die(mysqli_error($database));
                          $row_get_classs = mysqli_fetch_assoc($get_classs);
                          $totalRows_get_classs = mysqli_num_rows($get_classs); ?>
                            <input type="checkbox" name="class<?php echo $row_get_data['id'];?>" value="1" <?php if($totalRows_get_classs>0){echo " checked ";}?>  /> <?php echo $row_get_data['name'];?> <br> 
                  <?php }while($row_get_data = mysqli_fetch_assoc($get_data)); } ?>
              </div>
					  </div>


           

              <div class="form-group" id="attach" style="padding-top: 50px;">
                    <label class="col-sm-3 control-label">تحميل الصور</label> 
                    <div class="col-sm-6">
                      <input type="file" name="file[]" id="file" multiple accept="image/png, image/jpeg, image/tiff, image/gif, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" >
                    </div>
                </div>
                      
             
					   <div class="form-group">
						 <label class="col-sm-3 control-label" > </label>
						 <div class="col-sm-6"> 
						   <?php echo $msg;?> 
						 </div> 
					  </div>
						
           
              <div class="form-group">
              <label class="col-sm-3 control-label" for="submit"> </label>
              <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                  <input type="hidden" name="id" value="<?php echo $row_get_gallery_albums['id'];?>" />
                </div> 
                <div class="col-sm-5"> </div> 
                <div class="col-sm-2"> 
                    <?php if(check_photo_gallery($row_get_gallery_albums['id'])==0){?>  
                          <a href="edit-photo-album.php?del=<?php echo $row_get_gallery_albums['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                      <?php }?>   
                    </div>
            </div> 
                      


						
					</form>
				  </div>
				</div>

        <div class="col-md-6">  
           <?php if($totalRows_get_gallery>0){
                     do{ ?>
                      <div class="col-sm-3 center-block" style="height:250px; padding: 10px; margin-bottom: 30px; text-align: center;">
                          <img src="../gallery/<?php echo $row_get_gallery['link'];?>" style=" max-height: 200px; max-width: 100%;" >
                          <a href="edit-photo-album.php?remove=<?php echo $row_get_gallery['id'];?>&id=<?php echo $_GET['id'];?>" style="width: 100%; margin-top: 10px;"  class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                      </div>      
                    <?php }while($row_get_gallery  = mysqli_fetch_assoc($get_gallery));  
               }?>	 
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