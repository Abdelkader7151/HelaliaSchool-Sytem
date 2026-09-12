<?php require_once('includes/access.php'); 
require_once('includes/logout.php'); 
require_once('../Connections/database.php'); 
require_once('includes/functions.php');    
 if($row_get_login['access12sub1']==1){
  
$msg ='';
 
 

  
if(isset($_POST['submit'])){   

  $image_name = null;
  include("includes/banner.php");   

  $insertSQL2 = sprintf("INSERT INTO `push_msg` ( `target`, `image`, `class`, `msg`, title, `date`, `admin_id`) VALUES (%s, %s, %s, %s, %s, %s, %s)", 
                GetSQLValueString($database,$_POST['target'], "int"),
                GetSQLValueString($database,$image_name, "text"),
                GetSQLValueString($database,isset($_POST['class'])?$_POST['class']:0, "int"),
                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                GetSQLValueString($database,$_POST['title'], "text"),
                GetSQLValueString($database,time(), "int"),
                GetSQLValueString($database,$row_get_login['id'], "int"));
     
   mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 


                mysqli_select_db($database, $database_database); 
                $query_get_push_msg = "SELECT `id` FROM `push_msg` WHERE `admin_id` = '{$row_get_login['id']}' ORDER BY `id` DESC ";
                $get_push_msg = mysqli_query($database,$query_get_push_msg) or die(mysqli_error($database));
                $row_get_push_msg = mysqli_fetch_assoc($get_push_msg);
                $totalRows_get_push_msg = mysqli_num_rows($get_push_msg);
    



    if($_POST['target']<100){ 


      $query_get_classs = "SELECT * FROM `class` where `study_year`='{$_POST['target']}' ";
      $get_classs = mysqli_query($database,$query_get_classs) or die(mysqli_error($database));
      $row_get_classs = mysqli_fetch_assoc($get_classs);
      $totalRows_get_classs = mysqli_num_rows($get_classs); 

       if($totalRows_get_classs>0){
           do{ 
                if(isset($_POST['class'.$row_get_classs['id']]) && $_POST['class'.$row_get_classs['id']]==1){    

            mysqli_select_db($database, $database_database); 
            $query_get_target = "SELECT `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id =  `app_login`.id  WHERE `kids`.linked = 1 AND `kids`.study_year = '{$_POST['target']}'  AND `kids`.class = '{$row_get_classs['id']}' ";
            $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
            $row_get_target = mysqli_fetch_assoc($get_target);
            $totalRows_get_target = mysqli_num_rows($get_target);  
        
            do{ 
                $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `image`, `title`, `user_id`, `kid_id`, `class`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,$_POST['title'], "text"),
                                GetSQLValueString($database,$row_get_target['app_login_id'], "int"),
                                GetSQLValueString($database,$row_get_target['kid_id'], "int"),
                                GetSQLValueString($database,$row_get_classs['id'], "int"),
                                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,6, "int"));

              if($row_get_target['parent_id']!=NULL){    
                mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 
                sendMessage($row_get_target['phone_id'],$_POST['title'],str_replace("<br>","",$_POST['msg']));
              }
            }while($row_get_target = mysqli_fetch_assoc($get_target));  

                }
            }while($row_get_classs = mysqli_fetch_assoc($get_classs));
        } 
       
 

 }elseif($_POST['target']==100){

        mysqli_select_db($database, $database_database); 
        $query_get_target = "SELECT `id` FROM `app_login` WHERE `phone_id` IS NOT NULL ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target);   
            do{
              $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `image`, `title`, `user_id`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,$_POST['title'], "text"),
                                GetSQLValueString($database,$row_get_target['id'], "int"),
                                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,6, "int"));

                mysqli_select_db($database, $database_database);     
                $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

            }while($row_get_target = mysqli_fetch_assoc($get_target)); 

            sendMessage2($_POST['title'],$_POST['msg']);  

  }elseif($_POST['target']==200){

        mysqli_select_db($database, $database_database); 
        $query_get_target = "SELECT `id`,`phone_id` FROM `app_login` WHERE `account_type` = 2 AND `phone_id` IS NOT NULL ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target);

           do{ 
                $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `image`, `title`, `user_id`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,$_POST['title'], "text"),
                                GetSQLValueString($database,$row_get_target['id'], "int"),
                                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,6, "int"));

                mysqli_select_db($database, $database_database);     
                $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

                sendMessage($row_get_target['phone_id'],$_POST['title'],str_replace("<br>","",$_POST['msg']));
             

            }while($row_get_target = mysqli_fetch_assoc($get_target));  

    }elseif($_POST['target']==300){

        mysqli_select_db($database, $database_database); 
        $query_get_target = "SELECT `kids`.id AS `kid_id`, `kids`.class AS `class`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id =  `app_login`.id  WHERE `kids`.linked = 1   ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target);  

            do{ 
                $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `image`, `title`, `user_id`, `kid_id`, `class`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,$_POST['title'], "text"),
                                GetSQLValueString($database,$row_get_target['app_login_id'], "int"),
                                GetSQLValueString($database,$row_get_target['kid_id'], "int"), 
                                GetSQLValueString($database,$row_get_target['class'], "int"), 
                                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,6, "int"));

              if($row_get_target['parent_id']!=NULL){    
                $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 
                sendMessage($row_get_target['phone_id'],$_POST['title'],str_replace("<br>","",$_POST['msg']));
              }
            }while($row_get_target = mysqli_fetch_assoc($get_target));   

    }elseif($_POST['target']==400){

        mysqli_select_db($database, $database_database); 
        $query_get_target = "SELECT `kids`.id AS `kid_id`, `kids`.class AS `class`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id =  `app_login`.id  WHERE `kids`.linked = 1 AND ( `kids`.study_year = 1 || `kids`.study_year = 2 )   ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target);  

            do{ 
                $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `image`, `title`, `user_id`, `kid_id`, `class`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                                GetSQLValueString($database,$image_name, "text"),
                                GetSQLValueString($database,$_POST['title'], "text"),
                                GetSQLValueString($database,$row_get_target['app_login_id'], "int"),
                                GetSQLValueString($database,$row_get_target['kid_id'], "int"), 
                                GetSQLValueString($database,$row_get_target['class'], "int"), 
                                GetSQLValueString($database,"<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                                GetSQLValueString($database,time(), "int"),
                                GetSQLValueString($database,6, "int"));

              if($row_get_target['parent_id']!=NULL){    
                $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 
                sendMessage($row_get_target['phone_id'],$_POST['title'],str_replace("<br>","",$_POST['msg']));
              }
            }while($row_get_target = mysqli_fetch_assoc($get_target));   

    }     
 

			header("location: new_push.php?added"); 
			exit(); 
	} 
	

 

$head_title = "  الاشعارات";
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
                <h4>       اشعار جديد  </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-6">
				  <div class="demo-form-wrapper"> 
                    <form action="new_push.php" method="post"   name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">
                    
 
		    <div class="form-group">
              <label class="col-sm-3 control-label" for="title">  العنوان  </label>
              <div class="col-sm-6">
                <input id="name" class="form-control"      type="text" name="title" >
              </div>
            </div>  
 
            
                 

		    <div class="form-group">
              <label class="col-sm-3 control-label" for="msg">  الرسالة  </label>
              <div class="col-sm-6">
                <textarea class="form-control"  id="form-control-8" name="msg"  rows="7"></textarea>
          
                
              </div>
            </div>



            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <input id="picture" class="form-control" accept="image/*" type="file" name="picture">
              </div>
					  </div> 


            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="study_year"><i class="fa fa-spinner fa-spin fa-fw" style="color: blue; display: none;" id="loading"></i> المستهدف  </label>
              <div class="col-sm-4">
                  <select class="form-control"   name="target"  id="target"  >
                        <option selected >...</option> 
                        <option value="100" > جميع المراحل و العاملين</option> 
                        <option value="200" > جميع العاملين</option> 
                        <option value="300" >جميع المراحل</option> 
                        <option value="0" > بريسكول</option> 
                        <option value="1" > اولى حضانة</option> 
                        <option value="2" > ثانية حضانة</option> 
                        <option value="400" >   الحضانة</option> 
                        <option value="3" >  الصف الاول الابتدائى</option> 
                        <option value="4" >  الصف الثانى الابتدائى</option> 
                        <option value="5" >  الصف الثالث الابتدائى</option> 
                        <option value="6" >  الصف الرابع الابتدائى</option> 
                        <option value="7" >  الصف الخامس الابتدائى</option> 
                        <option value="8" >  الصف السادس الابتدائى</option> 
                        <option value="9" >  الصف الاول الاعدادى</option> 
                        <option value="10" >  الصف الثاني الاعدادى</option> 
                        <option value="11" >  الصف الثالث الاعدادى</option> 
                        <option value="12" >  الصف الاول الثانوى</option> 
                        <option value="13" >  الصف الثاني الثانوى</option> 
                        <option value="14" >  الصف الثالث الثانوى</option>  
                  </select>
              </div>
            </div> 


            <div class="form-group" style="display: none" id="class_box">
						<label class="col-sm-3 control-label" for="class"  > الفصل  </label>
						<div class="col-sm-4" id="class_div">
                 
						</div>
            </div> 

					  </div>          
    
 
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						    <div class="col-sm-2"> 
                    <button type="submit" class="btn btn-success btn-block" name="submit" id="submit" style="background-color: green;" ><i class="fa fa-paper-plane-o" aria-hidden="true"></i> ارسال</button>
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw" id="loading" style="display:none"></i> 
                 </div> 
                  <div class="col-sm-5" style="color: green; padding-top:0px ">
                    <?php if(isset($_GET['added'])){?>
                       <h2 style="color: green; padding-top:0px " > <i class="fa fa-smile-o" aria-hidden="true"></i>  تم الارسال بنجاح  </h2> 
                    <?php }?> 
                  </div>  
              </div> 
              

						
					</form>
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

      $("#demo-inputmask2").submit(function(){

        $("#submit").fadeOut();
        $("#loading").fadeIn();

      })


      


  
      $('#demo-inputmask2').on('change', '#target', function (event) {   
        $("#loading").fadeIn(); 
        var year = $(this).val();
        if(year<15){
          $("#class_box").fadeIn();
           $.post("get_class_select.php",
                {
                  year:year
                },
                function(Date,status){ 
                    $("#class_div").html(Date); 
                    $("#loading").fadeOut();
                });
        }else{
           $("#class").prop("selectedIndex", 0);
           $("#class_box").fadeOut(); 
           $("#loading").fadeOut();
          };
       });



      
      $("#study_year").change(function(){
                if($(this).val()==13 || $(this).val()==14){
                    $("#study_type_box").fadeIn();
                    $("#loading").fadeOut();
                  } else {
                    $("#study_type_box").fadeOut();
                    $("#study_type").prop("selectedIndex", 0);
                    $("#loading").fadeOut();
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
 


      $('#demo-inputmask2').on('change', '#study_year', function (event) {   
			  var study_year = $("#study_year").val();  
			  $.post("study_year_class.php",
			  {
          study_year:study_year
		    },
            function(Date,status){ 
                $("#study_year_class").html(Date); 
             }); 
        }); 

        $('#demo-inputmask2').on('blur', '#gov_id', function (event) { 
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