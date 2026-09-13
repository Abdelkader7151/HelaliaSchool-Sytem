<?php require_once('includes/access.php'); 
require_once('includes/logout.php'); 
require_once('../Connections/database.php'); 
require_once('includes/functions.php');    

 if($row_get_login['access7sub0']==1){

    if(isset($_GET['del'])){    
        mysqli_select_db($database, $database_database); 
        $query_get_users_info = "SELECT `picture` FROM `kids_reg` where `id`='{$_GET['del']}'  ";
        $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
        $row_get_users_info = mysqli_fetch_assoc($get_users_info);
        $totalRows_get_users_info = mysqli_num_rows($get_users_info);

        if($row_get_users_info['picture']!=null){ unlink("../kids/".$row_get_users_info['picture']);}

        $deleteSQL = sprintf("DELETE FROM `kids_reg` WHERE `id`=%s ",
                           GetSQLValueString($database,$_GET['del'], "int"));
    
                mysqli_select_db($database, $database_database);  
                $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
                header("location: reg-kid-list.php"); 
                exit(); 
        } 



$msg ='';

if(isset($_POST['submit'])){  
  $image_name = $_POST['old_picture'];
  include("includes/img-up-kids.php");
  if($image_name!=$_POST['old_picture']){ unlink("../kids/".$_POST['old_picture']);}
 
	$insertSQL = sprintf("UPDATE `kids_reg` SET `birthday`=%s, `picture`=%s, `gov_id`=%s, `gender`=%s,  `ed_id`=%s, `lang`=%s, `join_year`=%s, `name`=%s, `fn_name`=%s, `email`=%s,   `responsible`=%s, `study_type`=%s, `transfare`=%s, `religion`=%s, `nationality`=%s, `birth_place`=%s, `father_details`=%s, `home_phone`=%s, `other_phone`=%s,  `mother_mobile`=%s, `father_mobile`=%s, `other_mobile`=%s, `study_year`=%s, `from_school`=%s, `school_ed`=%s, `transfare_comment`=%s    WHERE `id` = %s ",
                       GetSQLValueString($database,$_POST['birthday'], "int"),  
                       GetSQLValueString($database,$image_name, "text"),  
                       GetSQLValueString($database,$_POST['gov_id'], "text"), 
                       GetSQLValueString($database,$_POST['gender'], "text"), 
                       GetSQLValueString($database,$_POST['ed_id'], "text"), 
                       GetSQLValueString($database,$_POST['lang'], "int"), 
                       GetSQLValueString($database,$_POST['join_year'], "int"),
                       GetSQLValueString($database,rtrim(ltrim($_POST['name'])), "text"), 
                       GetSQLValueString($database,$_POST['fn_name'], "text"),
                       GetSQLValueString($database,strtolower($_POST['email']), "text"), 
                       GetSQLValueString($database,$_POST['responsible'], "text"),
                       GetSQLValueString($database,$_POST['study_type'], "int"),
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
                       GetSQLValueString($database,$_POST['from_school'], "text"), 
                       GetSQLValueString($database,$_POST['school_ed'], "text"), 
                       GetSQLValueString($database,$_POST['transfare_comment'], "text"), 
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
        
 
         
			header("location: reg-kid-list.php?updated"); 
			exit(); 
	} 
	
 

    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids_reg` where `id`='{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);

  if($totalRows_get_kid_info<1){header("location: reg-kid-list.php"); exit();}

 

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
                <h4> تعديل بيانات تسجيل  طالب   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                  
                    <form action="edit-reg-kid.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			      <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name" value="<?php echo $row_get_kid_info['name'];?>"  >
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="fn_name">  الاسم باللغة الانجليزية</label>
              <div class="col-sm-6">
                <input id="fn_name" class="form-control " style="text-align:left"   type="text" name="fn_name" value="<?php echo $row_get_kid_info['fn_name'];?>">
              </div>
            </div> 
            

            <div class="form-group">
              <label class="col-sm-3 control-label" for="picture">  صورة </label>
              <div class="col-sm-4">
                <input id="picture" class="form-control"   type="file" name="picture">
                <input type="hidden" name="old_picture" value="<?php echo $row_get_kid_info['picture'];?>" />
              </div>
		        </div> 

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control" required name="study_year" id="study_year" >
                      <option   disabled >...</option> 
                      <option value="0" <?php if($row_get_kid_info['study_year']==0){echo " selected ";}?> >  بري سكول</option> 
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

            <div class="form-group" style="<?php if($row_get_kid_info['study_year']!=13 && $row_get_kid_info['study_year']!=14){?>display: none;<?php }?>" id="study_type_box">
						<label class="col-sm-3 control-label" for="study_type"> التخصص  </label>
						<div class="col-sm-4">
                <select class="form-control" name="study_type" id="study_type" >
                      <option <?php if($row_get_kid_info['study_type']<1){echo " selected ";}?> >...</option> 
                      <option <?php if($row_get_kid_info['study_type']==1){echo " selected ";}?> value="1">علمى</option> 
                      <option <?php if($row_get_kid_info['study_type']==2){echo " selected ";}?> value="2">علمي علوم</option> 
                      <option <?php if($row_get_kid_info['study_type']==3){echo " selected ";}?> value="3">علمي رياضة</option>  
                      <option <?php if($row_get_kid_info['study_type']==4){echo " selected ";}?> value="4">أدبي</option>  
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="lang"> لغة ثانية  </label>
						<div class="col-sm-4">
                <select class="form-control"   name="lang" id="lang" >
                      <option value="" >...</option> 
                      <option value="1" <?php if($row_get_kid_info['lang']==1){echo " selected ";}?>>  فرنسية</option> 
                      <option value="2" <?php if($row_get_kid_info['lang']==2){echo " selected ";}?>>  المانية</option>  
                      <option value="3" <?php if($row_get_kid_info['lang']==3){echo " selected ";}?>>  ايطالية</option>  
                </select>
						</div>
            </div> 

         

            
            <div class="form-group">
						<label class="col-sm-3 control-label" for="class"> السنة </label>
						<div class="col-sm-2"  >
                          <input id="join_year" class="form-control "    type="text" name="join_year" value="<?php echo $row_get_kid_info['join_year'];?>"> 
						</div>
            </div> 

         



            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع   </label>
              <div class="col-sm-1">
                        <select class="form-control" name="gender" id="gender" > 
                            <option value=""></option>  
                            <option value="ذكر" <?php if($row_get_kid_info['gender']=="ذكر"){echo " selected ";}?>>  ذكر</option> 
                            <option value="انثى" <?php if($row_get_kid_info['gender']=="انثى"){echo " selected ";}?>>  انثى</option>   
                        </select>
              </div>
            </div> 
            


            <div class="form-group">
              <label class="col-sm-3 control-label" for="nationality">  الجنسية <span style="color: red;">*</span></label>
              <div class="col-sm-4">
                <input id="nationality" class="form-control" required type="text" name="nationality" value="<?php echo $row_get_kid_info['nationality'];?>">
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="birth_place">  محل الميلاد  </label>
              <div class="col-sm-4">
                <input id="birth_place" class="form-control"   type="text" name="birth_place"  value="<?php echo $row_get_kid_info['birth_place'];?>">
              </div>
            </div> 
             

             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"  name="gov_id"  id="gov_id"     value="<?php echo $row_get_kid_info['gov_id'];?>">
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_id"> الرقم التعليمي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"  name="ed_id" id="ed_id"      value="<?php echo $row_get_kid_info['ed_id'];?>"> 
                 <p id="ed_id_warn" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  الرقم التعليمي مسجل من قبل </p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="age_october">    السن فى اول اكتوبر  </label>
              <div class="col-sm-6" id="age_october" style="padding-top: 7px; "> 
              <p style="font-weight:bold; font-size:18px" id="birthday_october" ><?php echo convertSecToTime($row_get_kid_info['birthday']);?></p> 
              <input type="hidden" value="<?php if($row_get_kid_info['gov_id']>0){ echo birthday($row_get_kid_info['gov_id']); }else{ echo $row_get_kid_info['birthday']; } ?>" name="birthday" >
              </div>
            </div> 
                      
                      

            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني  </label>
              <div class="col-sm-4">
                <input id="email" class="form-control"   type="email" name="email" value="<?php echo $row_get_kid_info['email'];?>">
              </div>
            </div> 
            
              <div class="form-group">
              <label class="col-sm-3 control-label" for="father_details">  اسم الوالد وصناعته والعنوانه </label>
              <div class="col-sm-9">
                <textarea id="father_details" class="form-control"   name="father_details"><?php echo $row_get_kid_info['father_details'];?></textarea>
              </div>
					  </div>          

 
            <div class="form-group">
              <label class="col-sm-3 control-label" for="responsible">        الولاية  </label>
              <div class="col-sm-4">
                <input id="responsible" class="form-control"   type="text" name="responsible" value="<?php echo $row_get_kid_info['responsible'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="home_phone">      هاتف المنزل  </label>
              <div class="col-sm-4">
                <input id="home_phone" class="form-control"   type="text" name="home_phone" value="<?php echo $row_get_kid_info['home_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="other_phone">      هاتف اخر  </label>
              <div class="col-sm-4">
                <input id="other_phone" class="form-control"   type="text" name="other_phone" value="<?php echo $row_get_kid_info['other_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_mobile">      هاتف الام  </label>
              <div class="col-sm-4">
                <input id="mother_mobile" class="form-control"   type="text" name="mother_mobile" value="<?php echo $row_get_kid_info['mother_mobile'];?>"> 
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_mobile">    هاتف الاب  </label>
              <div class="col-sm-4">
                <input id="father_mobile" class="form-control"   type="text" name="father_mobile"  value="<?php echo $row_get_kid_info['father_mobile'];?>">
              </div>
            </div> 

            <div class="form-group">
            <label class="col-sm-3 control-label" for="		other_mobile">    هاتف محمول اخر  </label>
              <div class="col-sm-4">
                <input id="other_mobile" class="form-control"   type="text" name="other_mobile"  value="<?php echo $row_get_kid_info['other_mobile'];?>">
              </div>
            </div> 
            

        

         
            <hr>
<h3>بيانات المدرسة المحول من</h3>

            <div class="form-group">
            <label class="col-sm-3 control-label" for="from_school">     المدرسة المحول من  </label>
              <div class="col-sm-4">
                <input id="from_school" class="form-control"   type="text" name="from_school" value="<?php echo $row_get_kid_info['from_school'];?>">
              </div>
            </div>


            <div class="form-group">
            <label class="col-sm-3 control-label" for="school_ed"> الإدارة التعليمية التابع له  </label>
              <div class="col-sm-4">
                <input id="school_ed" class="form-control"   type="text" name="school_ed" value="<?php echo $row_get_kid_info['school_ed'];?>">
              </div>
            </div>
            

            <div class="form-group">
            <label class="col-sm-3 control-label" for="transfare_comment">         سبب التحويل  </label>
              <div class="col-sm-4">
                <input id="transfare_comment" class="form-control"   type="text" name="transfare_comment" value="<?php echo $row_get_kid_info['transfare_comment'];?>">
              </div>
            </div>
            






						
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-success btn-block" name="submit" id="submit" style="background-color: green;" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                          <div class="col-sm-2"> 
<a href="edit-reg-kid.php?del=<?php echo $row_get_kid_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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
                <div class="col-md-3">
                <img src="../kids/<?php  if($row_get_kid_info['picture']!=null){echo $row_get_kid_info['picture'];}else{echo "no-picture.png";}?>" class="img-responsive img-rounded img-thumbnail"  style="float:left" />
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

  

      
                
    $('#demo-inputmask').on('click', '#brothers', function (event) {
        var val = $(this).val();
        if(val=="Yes") { 
           $(".brother_name_study_year").fadeIn(); 
           $("#brother_name_study_year").prop('required',true); 
        }else{
           $(".brother_name_study_year").fadeOut(); 
           $("#brother_name_study_year").val('').prop('required',false); 
        } 
      });


      $('#demo-inputmask').on('click', '#club', function (event) {
        var val = $(this).val();
        if(val=="Yes") { 
           $(".club_name").fadeIn(); 
           $("#club_name").prop('required',true); 
        }else{
           $(".club_name").fadeOut(); 
           $("#club_name").val('').prop('required',false); 
        } 
      });


      $('#demo-inputmask').on('click', '#sick', function (event) {
        var val = $(this).val();
        if(val=="Yes") { 
           $(".medicine").fadeIn(); 
           $("#medicine").prop('required',true); 
        }else{
           $(".medicine").fadeOut(); 
           $("#medicine").val('').prop('required',false); 
        } 
      });
      

      $('#demo-inputmask').on('click', '#mental', function (event) {
        var val = $(this).val();
        if(val=="Yes") { 
           $(".mental_desc").fadeIn(); 
           $("#mental_desc").prop('required',true); 
        }else{
           $(".mental_desc").fadeOut(); 
           $("#mental_desc").val('').prop('required',false); 
        } 
      });
      



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
           
			  var gov = $("#gov_id").val();  
			  $.post("check-gov3.php",
			  {
          gov:gov,
          id:<?php echo $_GET['id'];?>
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
           }else{ 
            $.post("age_october.php",
                {
                  gov:gov
                },
                    function(Date,status){  
                        $("#birthday_october").text(Date); 
                });   
            } 

	        });




      $('#demo-inputmask').on('change', '#ed_id', function (event) {  
           
			  var ed_id = $("#ed_id").val();  
			  $.post("check-ed_id.php",
			  {
          ed_id:ed_id,
          kidid:<?php echo $_GET['id'];?>
		    },
            function(Date,status){ 

                 if(Date>0){
                    $("#ed_id_warn").fadeIn();  
                    $("#submit").attr('disabled', 'disabled');
                 }else{
                    $("#ed_id_warn").fadeOut();   
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

<?php }else{header("location: home.php");exit();}?>