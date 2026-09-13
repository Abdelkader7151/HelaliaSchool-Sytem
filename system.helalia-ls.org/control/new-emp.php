<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');
 if (!function_exists('helalia_phone_is_taken')) {
   require_once('includes/phone-unique.php');
 }

 if($row_get_login['access6sub1']==1){

$msg ='';

if(isset($_POST['submit']) || isset($_POST['submit2'])){  

  $phoneTaken = helalia_phone_is_taken($database, isset($_POST['phone']) ? $_POST['phone'] : '', array());
  if(!$phoneTaken){

	$insertSQL = sprintf("INSERT INTO `emps` ( `on_duty`, `ext_id`, `name`, `phone`,  `email`, `job`, `gov_id`, `birthday`, `emp`,`start_date`, `date`, 
  `app1`, `app1_1`, `app1_2`, `app1_3`, `app1_4`, `app1_5`,
  `app2`, `app2_1`, `app2_2`, `app2_3`, `app2_4`, `app2_5`,  
  `app3`, `app4`, `app5`,
  `app6`, `app6_1`, `app6_2`, `app6_3`, `app6_4`, `app6_5`, 
  `app7`, `app8`,
  `app9`, `app9_1`, `app9_2`, `app9_3`, `app9_4`, `app9_5`, `app10`,
  `app11`, `app11_1`, `app11_2` ) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                       GetSQLValueString($database,$_POST['on_duty'], "text"),
                       GetSQLValueString($database,$_POST['ext_id'], "int"),
                       GetSQLValueString($database,$_POST['name'], "text"),
                       GetSQLValueString($database,$_POST['phone'], "text"),
                       GetSQLValueString($database,strtolower($_POST['email']), "text"),   
                       GetSQLValueString($database,$_POST['job'], "int"),
                       GetSQLValueString($database,$_POST['gov_id'], "text"), 
                       GetSQLValueString($database,birthday($_POST['gov_id']), "date"), 
                       GetSQLValueString($database,$row_get_login['id'], "int"),
                       GetSQLValueString($database,strtotime($_POST['start_date']), "int"),
                       GetSQLValueString($database,time(), "int"),
                       GetSQLValueString($database,$_POST['app1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_5']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_5']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app3']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app4']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app5']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app6']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app6_1']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app6_2']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app6_3']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app6_4']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app6_5']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app7']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app8']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app9']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app9_1']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_2']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_3']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_4']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app10']?1:0, "int"),
                       GetSQLValueString($database,$_POST['app11']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app11_1']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app11_2']?1:0, "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
       
		$to = strtolower($_POST['email']);
    $subject = "تفعيل الحساب"; 
    $message = "
    <html>
    <head>
    <title>تفعيل الحساب</title>
    </head>
    <body>
    
    <p>
    <img src='http://www.helalia-ls.org/img/logo.png' />
    <br>
    تم تفعيل حساب    xxxx  </p>
    <table>
    <tr> 
    <th>".$_POST['name']." :اسم  </th> 
    </tr> 
    <tr>
    <th>".strtolower($_POST['gov_id'])." :اسم المستخدم</th> 
    </tr> 
    <tr> 
    <th>".strtolower($_POST['password'])." كلمة المرور  </th>
    </tr> 
    </table>
    </body>
    </html>
    ";
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    $headers .= 'From: <activation@helalia-ls.org>' . "\r\n"; 
    
     //mail($to,$subject,$message,$headers); 


     if(isset($_POST['submit'])){  
			  header("location: new-emp.php?done"); 
     }elseif(isset($_POST['submit2'])){   
      $query_get_jobs = "SELECT `id` FROM `emps` order by `id` desc";
      $get_jobs = mysqli_query($database,$query_get_jobs) or die(mysqli_error($database));
      $row_get_jobs = mysqli_fetch_assoc($get_jobs);
      $totalRows_get_jobs = mysqli_num_rows($get_jobs); 
		  	header("location: edit-emp.php?id={$row_get_jobs['id']}&done"); 
     }
			exit();
    } else {
      $msg = '<div class="alert alert-danger" role="alert" style="margin:12px 0;">'
        . htmlspecialchars(helalia_phone_taken_message('ar'), ENT_QUOTES, 'UTF-8')
        . '</div>';
    }
	} 
	
 

  mysqli_select_db($database, $database_database); 
  $query_get_jobs = "SELECT * FROM `jobs` order by `name` asc";
  $get_jobs = mysqli_query($database,$query_get_jobs) or die(mysqli_error($database));
  $row_get_jobs = mysqli_fetch_assoc($get_jobs);
  $totalRows_get_jobs = mysqli_num_rows($get_jobs);

  

$head_title = "  الموظفين";
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
                <h4> أضافة موظف جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-emp.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name" class="form-control" required type="text" name="name">
              </div>
					  </div> 
					 
					  <div class="form-group">
						<label class="col-sm-3 control-label" for="email">   البريد اللإلكتروني  </label>
              <div class="col-sm-6">
              <input id="form-control-9" class="form-control" type="text" data-inputmask="'alias': 'email'" name="email">  
              </div>
            </div> 

            <div class="form-group">
						<label class="col-sm-3 control-label" for="phone">     الهاتف  <span style="color: red;">*</span></label>
              <div class="col-sm-6">
              <input  id="phone"  class="form-control" type="text" maxlength="11" required minlength="11" name="phone">  
                <small style="color: red; display:none" id="check_phone"><?php echo htmlspecialchars(helalia_phone_taken_message('ar'), ENT_QUOTES, 'UTF-8'); ?></small>
              </div>
            </div> 
                      
            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="job"> الوظيفة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="job" id="job" >
                      <option selected disabled >...</option>
                      <?php do{?>
                      <option value="<?php echo $row_get_jobs['id'];?>"><?php echo $row_get_jobs['name'];?></option>
                      <?php }while($row_get_jobs = mysqli_fetch_assoc($get_jobs));?>
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="ext_id">       كود الحضور و الانصراف  </label>
              <div class="col-sm-2">
              <input   class="form-control" type="number"   name="ext_id">  
              </div>
            </div> 

            
             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي   </label>
              <div class="col-sm-4">
                 <input id="gov_id" class="form-control" type="number" name="gov_id"  >
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>        الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">   تاريخ التعين   </label>
              <div class="input-group date col-sm-4">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" type="text" name="start_date"  >
                </div> 
            </div> 
                   
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">     ميعاد الحضور   </label>
              <div class="input-group date col-sm-2">
                <div class="input-with-icon">
                  <input id="demo-timepicker-5" class="form-control" name="on_duty" type="text" >
                  <span class="icon icon-clock-o input-icon"></span>
                </div>  
              </div> 
            </div> 

            <div id="appaccess">  </div>
                      
 
						
						<div class="form-group">
              <label class="col-sm-3 control-label" for="submit"> </label>
              <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block submit" name="submit" id="submit" > <i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ <i class="fa fa-spinner fa-spin fa-fw loading" style="display: none;"></i></button> 
              </div> 

              <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block submit" name="submit2"   > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> حفظ و تعديل <i class="fa fa-spinner fa-spin fa-fw loading" style="display: none;"></i></button> 
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

      $("#demo-inputmask").submit(function(){
           $(".loading").fadeIn(); 
      });
      

      $('#demo-inputmask').on('change', '#job1111', function (event) {  
           
           var id = $("#job").val();  
           $.post("job_access.php",
         {
                id:id
           },
               function(Date,status){  
                   $("#appaccess").html(Date);  
            }); 
         });
         

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
                    $(".submit").attr('disabled', 'disabled');
                 }else{
                    $("#gov_id_warn2").fadeOut();   
                    $(".submit").removeAttr("disabled");
                  }
                  
			   }); 
	    });



       
      $('#demo-inputmask').on('blur', '#phone', function (event) { 
			  // event.preventDefault(); 
           
			  var phone = $("#phone").val();  
			  $.post("check_phone.php",
			  {
          phone:phone
		    },
            function(Date,status){ 

                 if(Date>0){
                    $("#check_phone").fadeIn();  
                    $(".submit").attr('disabled', 'disabled');
                 }else{
                    $("#check_phone").fadeOut();   
                    $(".submit").removeAttr("disabled");
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
  //var gov_id = $("#gov_id").val().length; 
  // if(gov_id<14 || gov_id>14){  
  //   event.preventDefault(); 
  //   $("#gov_id_warn1").fadeIn(); 
  //  } 
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