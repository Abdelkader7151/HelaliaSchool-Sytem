<?php require_once('../Connections/database.php'); 
error_reporting(0); 
require_once('includes/access.php'); 
require_once('includes/logout.php');  
require_once('includes/functions.php');  

 if($row_get_login['access7sub8']==1){
  
$msg =''; 
$done = 0;

    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids` where `id`='{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);

  if($totalRows_get_kid_info<1){header("location: all-kids.php"); exit();}

  
if(isset($_POST['submit'])){  
    

  $image_name = null;
  include("includes/upload-image.php");

    mysqli_select_db($database, $database_database); 
    $query_get_kids_list = "SELECT `parent_id` FROM `kids_list` where `kid_id`='{$_GET['id']}'  ";
    $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
    $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
    $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);
      if($totalRows_get_kids_list>0){

        $message = '  ولي امر ';
        $message .= $row_get_kid_info['name'];
        $message .=' '.$_POST['msg'];

        $insertSQL1 = sprintf("INSERT INTO `notifications` (`user_id`, `title`, `kid_id`, `text`, `image`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_kids_list['parent_id'], "int"),
                                GetSQLValueString($database,'رساله الي ولي امر', "text"),
                                GetSQLValueString($database,$_GET['id'], "int"),
                                GetSQLValueString($database,$message, "text"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,5, "int"));

        mysqli_select_db($database, $database_database);     
        mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

        $insertSQL2 = sprintf("INSERT INTO `requests_attend` (`parent_id`, `kid_id`, `msg`, `date`, `emp_id`) VALUES (%s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_kids_list['parent_id'], "int"),
                                GetSQLValueString($database,$_GET['id'], "int"),
                                GetSQLValueString($database,$message, "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,$row_get_login['id'], "int"));

         mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 

         if(app_msg_id($_GET['id'])!=null){sendMessage(app_msg_id($_GET['id']),'HLS',$message);}
         $done = 1;
      }

			 //header('location: request-kid.php?done&id='.$_GET['id']); 
			 //exit(); 
	} 
	


  mysqli_select_db($database, $database_database); 
  $query_get_class = "SELECT * FROM `class`  where `study_year`='{$row_get_kid_info['study_year']}'";
  $get_class = mysqli_query($database,$query_get_class) or die(mysqli_error($database));
  $row_get_class = mysqli_fetch_assoc($get_class);
  $totalRows_get_class = mysqli_num_rows($get_class);

$head_title = "  الطلبة";
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
			<?php include('includes/mobile-menu-buttons.php');?> 
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
                <h4> طلب رساله ولي امر   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-6">
				  <div class="demo-form-wrapper"> 
                    <form action="request-kid.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

		    <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم  </label>
              <div class="col-sm-6">
                <input id="name" class="form-control"  disabled   type="text" name="name" value="<?php echo $row_get_kid_info['name'];?>">
              </div>
            </div>  

           
  

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" disabled name="study_year" id="study_year" >
                      <option   disabled >...</option> 
                      <option value="0" <?php if($row_get_kid_info['study_year']==1){echo " selected ";}?> >  بري سكول</option> 
                      <option value="1" <?php if($row_get_kid_info['study_year']==1){echo " selected ";}?> >اولى حضانة</option> 
                      <option value="2" <?php if($row_get_kid_info['study_year']==2){echo " selected ";}?> >ثانية حضانة</option> 
                      <option value="3" <?php if($row_get_kid_info['study_year']==3){echo " selected ";}?> >  الصف الاول الابتدائى</option> 
                      <option value="4" <?php if($row_get_kid_info['study_year']==4){echo " selected ";}?> >  الصف الثانى الابتدائى</option> 
                      <option value="5" <?php if($row_get_kid_info['study_year']==5){echo " selected ";}?> >  الصف الثالث الابتدائى</option> 
                      <option value="6" <?php if($row_get_kid_info['study_year']==6){echo " selected ";}?> >  الصف الرابع الابتدائى</option> 
                      <option value="7" <?php if($row_get_kid_info['study_year']==7){echo " selected ";}?> >  الصف الخامس الابتدائى</option> 
                      <option value="8" <?php if($row_get_kid_info['study_year']==8){echo " selected ";}?> >  الصف السادس الابتدائى</option> 
                      <option value="9" <?php if($row_get_kid_info['study_year']==9){echo " selected ";}?> >  الصف الاول الاعدادى</option> 
                      <option value="10" <?php if($row_get_kid_info['study_year']==10){echo " selected ";}?> >  الصف الثاني الاعدادى</option> 
                      <option value="11" <?php if($row_get_kid_info['study_year']==11){echo " selected ";}?> >  الصف الثالث الاعدادى</option> 
                      <option value="12" <?php if($row_get_kid_info['study_year']==12){echo " selected ";}?> >  الصف الاول الثانوى</option> 
                      <option value="13" <?php if($row_get_kid_info['study_year']==13){echo " selected ";}?> >  الصف الثاني الثانوى</option> 
                      <option value="14" <?php if($row_get_kid_info['study_year']==14){echo " selected ";}?> >  الصف الثالث الثانوى</option> 

                </select>
						</div>
            </div> 

           
            <div class="form-group">
						<label class="col-sm-3 control-label" for="class"> الفصل </label>
						<div class="col-sm-4" id="study_year_class">
                <select class="form-control" disabled   name="class" id="class" >
                      <option     ></option> 
                      <?php if($totalRows_get_class>0){
                        do{?>
                        <option value="<?php echo $row_get_class['id'];?>"  <?php if($row_get_kid_info['class']==$row_get_class['id']){echo " selected ";}?>>  <?php echo $row_get_class['name'];?></option>  
                      <?php }while($row_get_class = mysqli_fetch_assoc($get_class)); } ?>
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="transfare"> الحالة   </label>
						<div class="col-sm-4">
                <select class="form-control" disabled name="transfare" id="transfare" >
                      <option   disabled >...</option> 
                      <option value="1"  <?php if($row_get_kid_info['transfare']==1){echo " selected ";}?>>  مستجد</option> 
                      <option value="2"  <?php if($row_get_kid_info['transfare']==2){echo " selected ";}?>>  منقول</option>  
                      <option value="0"  <?php if($row_get_kid_info['transfare']==0){echo " selected ";}?>>  باقي</option>  
                </select>
						</div>
            </div> 
 

             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"     readonly  value="<?php echo $row_get_kid_info['gov_id'];?>">
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 
 

            
		       <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الرسالة  </label>
              <div class="col-sm-6">
                <textarea id="msg" class="form-control"  name="msg"></textarea>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <input id="picture" class="form-control"   type="file" name="picture">
              </div>
					  </div>


				</div>          
    
 
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-success btn-block" name="submit" id="submit" style="background-color: green;" ><i class="fa fa-paper-plane-o" aria-hidden="true"></i> ارسال</button> 
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                          
                      </div> 
                      
                     



					   <div class="form-group">
						 <label class="col-sm-3 control-label" > </label>
						 <div class="col-sm-6"> 
						   <?php echo $msg;?> 
						 </div> 
					  </div>
						
						
						
						
						
					</form>
				  </div>
                  <div class="col-md-6">
                  <div class="col-md-6">
                    <img src="../kids/<?php  if($row_get_kid_info['picture']!=null){echo $row_get_kid_info['picture'];}else{echo "no-picture.png";}?>" class="img-responsive img-rounded img-thumbnail"  style="float:left" />
                  </div>
           
           <div class="col-xs-12">
            <h3>رسائل سابقة</h3>
            <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px; ">
                   <tr>
                       <td>الرسالة</td>
                       <td>التاريخ</td>
                       <td>الراسل</td>
                   </tr> 
                   <?php
                     mysqli_select_db($database, $database_database); 
                     $query_get_requests_attend = "SELECT * FROM `requests_attend` WHERE `kid_id`='{$_GET['id']}'";
                     $get_requests_attend = mysqli_query($database,$query_get_requests_attend) or die(mysqli_error($database));
                     $row_get_requests_attend = mysqli_fetch_assoc($get_requests_attend);
                     $totalRows_get_requests_attend = mysqli_num_rows($get_requests_attend);
                     if($totalRows_get_requests_attend>0){
                         do{?>
                      <tr>
                        <td><?php echo $row_get_requests_attend['msg'];?></td>
                        <td><?php echo date("d/m/Y",$row_get_requests_attend['date']);?></td>
                        <td><?php echo users_name($row_get_requests_attend['emp_id']);?></td>
                      </tr>
                   <?php }while($row_get_requests_attend = mysqli_fetch_assoc($get_requests_attend));}?>
               </table>


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
                if($(this).val()==13 || $(this).val()==14){
                    $("#study_type_box").fadeIn();
                  } else {
                    $("#study_type_box").fadeOut();
                    $("#study_type").prop("selectedIndex", 0);
                  } 
                    var year = $(this).val(); 
                      $.post("get_class.php",
                                    {
                                      year:year
                                    },
                                        function(Date,status){  
                                            $("#study_year_class").html(Date); 
                                    }); 
   

});
 


      $('#demo-inputmask').on('change', '#study_year', function (event) {   
			  var study_year = $("#study_year").val();  
			  $.post("study_year_class.php",
			  {
          study_year:study_year
		    },
            function(Date,status){ 
                $("#study_year_class").html(Date); 
             }); 
        }); 

        $('#demo-inputmask').on('blur', '#gov_id', function (event) { 
			  // event.preventDefault(); 
           
			  var gov = $("#gov_id").val();  
			  $.post("check-gov2.php",
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


        var gov_id = $("#gov_id").val().length; 
        if(gov_id<14 || gov_id>14){  
          $("#gov_id_warn1").fadeIn(); 
           } else{ 
            $.post("age_october.php",
                {
                  gov:gov
                },
                    function(Date,status){  
                        $("#birthday_october").text(Date); 
                });   
            } 

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