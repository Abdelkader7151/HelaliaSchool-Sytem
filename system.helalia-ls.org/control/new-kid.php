<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub1']==1){

$msg ='';




if(isset($_POST['submit'])){  
 

if($_POST['gov_id']>0){
  $gender = gender($_POST['gov_id']);
}else{
   $gender = $_POST['gender'];
}

$image_name = null;
include("includes/img-up1.php");

	$insertSQL = sprintf("INSERT INTO `kids` ( `lang`, `picture`, `gov_id`, `ed_id`,`name`, `fn_name`, `study_type`, `class`, `responsible`, `gender`, `email`, `birthday`, `october_age_d`, `october_age_m`, `october_age_y`, `transfare`, `religion`, `nationality`, `birth_place`, `father_details`,   `home_phone`, `other_phone`, `mother_mobile`, `father_mobile`, `other_mobile`, `study_year`, `emp`, `date`) VALUES ( %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                       GetSQLValueString($database,$_POST['lang'], "int"), 
                       GetSQLValueString($database,$image_name, "text"),
                       GetSQLValueString($database,$_POST['gov_id'], "text"), 
                       GetSQLValueString($database,$_POST['ed_id'], "text"), 
                       GetSQLValueString($database,rtrim(ltrim($_POST['name'])), "text"),
                       GetSQLValueString($database,$_POST['fn_name'], "text"),
                       GetSQLValueString($database,$_POST['study_type'], "int"),
                       GetSQLValueString($database,$_POST['class'], "int"),
                       GetSQLValueString($database,$_POST['responsible'], "text"),
                       GetSQLValueString($database,$gender, "text"),
                       GetSQLValueString($database,strtolower($_POST['email']), "text"),
                       GetSQLValueString($database,birthday($_POST['gov_id']), "int"),
                       GetSQLValueString($database,october_age_d(birthday($_POST['gov_id'])), "date"),   
                       GetSQLValueString($database,october_age_m(birthday($_POST['gov_id'])), "date"),
                       GetSQLValueString($database,october_age_y(birthday($_POST['gov_id'])), "date"),
                       GetSQLValueString($database,$_POST['transfare'], "int"), 
                       GetSQLValueString($database,$_POST['religion'], "int"),
                       GetSQLValueString($database,$_POST['nationality'], "text"),
                       GetSQLValueString($database,$_POST['birth_place'], "text"),
                       GetSQLValueString($database,$_POST['father_details'], "text"), 
                       GetSQLValueString($database,$_POST['home_phone'], "text"),
                       GetSQLValueString($database,$_POST['other_phone'], "text"),
                       GetSQLValueString($database,$_POST['mother_mobile'], "text"),
                       GetSQLValueString($database,$_POST['father_mobile'], "text"),
                       GetSQLValueString($database,$_POST['other_mobile'], "text"), 
                       GetSQLValueString($database,$_POST['study_year'], "int"),  
                       GetSQLValueString($database,$row_get_login['id'], "int"), 
                       GetSQLValueString($database,time(), "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
         
			header("location: new-kid.php?done"); 
			exit();
	      
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

<script>
 $(document).ready(function(){ 
 
  
});
</script>
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
                <h4> أضافة طالب جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-kid.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name" class="form-control" required type="text" name="name">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="fn_name">  الاسم باللغة الانجليزية</label>
              <div class="col-sm-9">
                <input id="fn_name" class="form-control " style="text-align:left"   type="text" name="fn_name">
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <input id="picture" class="form-control"   type="file" name="picture">
              </div>
					  </div> 

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="study_year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0"> بري سكول </option> 
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

                </select>
						</div>
            </div> 

            <div class="form-group" style="display: none;" id="study_type_box">
						<label class="col-sm-3 control-label" for="study_type"> التخصص  </label>
              <div class="col-sm-4">
                  <select class="form-control" name="study_type" id="study_type" >
                        <option selected >...</option> 
                        <option value="1">علمى</option> 
                        <option value="2">علمي علوم</option> 
                        <option value="3">علمي رياضة</option>  
                        <option value="4">أدبي</option>  
                  </select>
              </div>
            </div> 

            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="lang"> لغة ثانية   </label>
						<div class="col-sm-4">
                <select class="form-control" name="lang" id="lang" >
                      <option  value=""   >...</option> 
                      <option value="1">  فرنسية</option> 
                      <option value="2">  المانية</option>  
                      <option value="3">  ايطالية</option>  
                </select>
						</div>
            </div>


            <div class="form-group">
						<label class="col-sm-3 control-label" for="class"> الفصل </label>
						<div class="col-sm-4" id="study_year_class">
                <select class="form-control"  name="class" id="class" >
                      <option selected></option>  
                </select>
						</div>
            </div> 

            <div class="form-group">
						<label class="col-sm-3 control-label" for="transfare"> الحالة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="transfare" id="transfare" >
                      <option selected disabled >...</option> 
                      <option value="1">  مستجد</option> 
                      <option value="2">  منقول</option>  
                      <option value="0">  باقي</option> 

                </select>
						</div>
            </div> 

            <div class="form-group" style="display:none">
						<label class="col-sm-3 control-label" for="religion"> الديانة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" name="religion" id="religion" >
                      <option selected disabled >...</option> 
                      <option value="1">  مسلم</option> 
                      <option value="2">  مسيحي</option>  
                      <option value="3">  يهودي</option>  
                </select>
						</div>
            </div> 


            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع   </label>
              <div class="col-sm-1">
                        <select class="form-control" name="gender" id="gender" > 
                            <option value=""></option>  
                            <option value="ذكر">  ذكر</option> 
                            <option value="انثى">  انثى</option>   
                        </select>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="nationality">  الجنسية <span style="color: red;">*</span></label>
              <div class="col-sm-4">
                <input id="nationality" class="form-control" required type="text" name="nationality">
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="birth_place">  محل الميلاد  </label>
              <div class="col-sm-4">
                <input id="birth_place" class="form-control"   type="text" name="birth_place">
              </div>
            </div> 
            
           

             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي  <span style="color: red;">*</span></label>
              <div class="col-sm-4">
                 <input id="gov_id" class="form-control" type="number" name="gov_id" required>
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>        الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 


            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_id"> الرقم التعليمي  <span style="color: red;">*</span></label>
              <div class="col-sm-4">
                 <input id="ed_id" class="form-control" type="number" name="ed_id" required> 
                 <p id="ed_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>        الرقم   مسجل من قبل </p>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="age_october">    السن فى اول اكتوبر  </label>
              <div class="col-sm-6" id="age_october" style="padding-top: 7px; "> 
              <p style="font-weight:bold; font-size:18px" id="birthday_october" >   </p> 
              </div>
            </div> 
                   
            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني  </label>
              <div class="col-sm-4">
                <input id="email" class="form-control"   type="email" name="email">
              </div>
            </div> 
            
              <div class="form-group">
              <label class="col-sm-3 control-label" for="father_details">  اسم الوالد وصناعته والعنوانه </label>
              <div class="col-sm-9">
                <textarea id="father_details" class="form-control"   name="father_details"></textarea>
              </div>
					  </div>          

            <div class="form-group">
              <label class="col-sm-3 control-label" for="responsible">        الولاية  </label>
              <div class="col-sm-4">
                <input id="responsible" class="form-control"   type="text" name="responsible">
              </div>
            </div> 
            

            <div class="form-group">
              <label class="col-sm-3 control-label" for="home_phone">      هاتف المنزل  </label>
              <div class="col-sm-4">
                <input id="home_phone" class="form-control"   type="number" name="home_phone">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="other_phone">      هاتف اخر  </label>
              <div class="col-sm-4">
                <input id="other_phone" class="form-control"   type="number" name="other_phone">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_mobile">      هاتف الام  </label>
              <div class="col-sm-4">
                <input id="mother_mobile" class="form-control"   type="number" name="mother_mobile">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_mobile">    هاتف الاب  </label>
              <div class="col-sm-4">
                <input id="father_mobile" class="form-control"  type="number" name="father_mobile">
              </div>
            </div> 

            <div class="form-group">
            <label class="col-sm-3 control-label" for="		other_mobile">    هاتف محمول اخر  </label>
              <div class="col-sm-4">
                <input id="other_mobile" class="form-control"   type="number" name="other_mobile">
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
 


      $("#study_year").change(function(){
                    var year = $(this).val(); 
                      $.post("get_class.php",
                                    {
                                      year:year
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

          $('#demo-inputmask').on('blur', '#ed_id', function (event) { 
			  // event.preventDefault(); 
           
			  var ed = $("#ed_id").val();  
			  $.post("check-ed.php",
			  {
          ed:ed
		    },
            function(Date,status){ 

                 if(Date>0){
                    $("#ed_id_warn2").fadeIn();  
                    $("#submit").attr('disabled', 'disabled');
                 }else{
                    $("#ed_id_warn2").fadeOut();   
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
 



$("#study_year").change(function(){
  if($(this).val()==13 || $(this).val()==14){
    $("#study_type_box").fadeIn();
  } else {
    $("#study_type_box").fadeOut();
    $("#study_type").prop("selectedIndex", 0);
  }
});
 





	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>