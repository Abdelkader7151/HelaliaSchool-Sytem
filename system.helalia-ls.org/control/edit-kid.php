<?php require_once('includes/access.php'); 
require_once('includes/logout.php'); 
require_once('../Connections/database.php'); 
require_once('includes/functions.php');    

 if($row_get_login['access7sub6']==1){

    if(isset($_GET['del'])  && $row_get_login['access7sub11']==1){ 

        mysqli_select_db($database, $database_database); 
        $query_get_users_info = "SELECT `picture` FROM `kids` where `id`='{$_GET['del']}'  ";
        $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
        $row_get_users_info = mysqli_fetch_assoc($get_users_info);
        $totalRows_get_users_info = mysqli_num_rows($get_users_info);

        if($row_get_users_info['picture']!=null){ unlink("../kids/".$row_get_users_info['picture']);}

 
        $query_get_kids_list = "SELECT `parent_id` FROM `kids_list` where `kid_id`='{$_GET['del']}'  ";
        $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
        $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
        $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);
        
        if($totalRows_get_kids_list>0){
            $query_get_parent_id = "SELECT `kid_id` FROM `kids_list` where `parent_id`='{$row_get_kids_list['parent_id']}'  ";
            $get_parent_id = mysqli_query($database,$query_get_parent_id) or die(mysqli_error($database));
            $row_get_parent_id = mysqli_fetch_assoc($get_parent_id);
            $totalRows_get_parent_id = mysqli_num_rows($get_parent_id);
            if($totalRows_get_parent_id<2){
                  $deleteSQL0 = sprintf("DELETE FROM `app_login` WHERE `id`=%s ",
                                    GetSQLValueString($database,$row_get_kids_list['parent_id'], "int"));
                  mysqli_query($database,$deleteSQL0) or die(mysqli_error($database)); 
            } 
        }


              $deleteSQL1 = sprintf("DELETE FROM `kids_list` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL1) or die(mysqli_error($database));


              $deleteSQL2 = sprintf("DELETE FROM `control` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL2) or die(mysqli_error($database));

              
              $deleteSQL3 = sprintf("DELETE FROM `ask_teacher` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL3) or die(mysqli_error($database));


              $deleteSQL4 = sprintf("DELETE FROM `control_registry` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL4) or die(mysqli_error($database));

              $deleteSQL5 = sprintf("DELETE FROM `control_year` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL5) or die(mysqli_error($database));

             $deleteSQL6 = sprintf("DELETE FROM `notifications` WHERE `kid_id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL6) or die(mysqli_error($database));


              $deleteSQL7 = sprintf("DELETE FROM `kids` WHERE `id`=%s ",
                                GetSQLValueString($database,$_GET['del'], "int"));
              mysqli_query($database,$deleteSQL7) or die(mysqli_error($database));

              

                header("location: all-kids.php"); 
                exit(); 
        } 



$msg ='';

if(isset($_POST['submit'])){  
  $image_name = $_POST['old_picture'];
  include("includes/img-up-kids.php");
  if($image_name!=$_POST['old_picture']){ unlink("../kids/".$_POST['old_picture']);}
 
	$insertSQL = sprintf("UPDATE `kids` SET `birthday`=%s, `picture`=%s, `gov_id`=%s, `gender`=%s,  `ed_id`=%s,`lang`=%s, `name`=%s, `fn_name`=%s, `email`=%s, `class`=%s, `responsible`=%s, `study_type`=%s, `transfare`=%s, `leaving_school`=%s, `leaving_date`=%s, `leaving_comment`=%s, `religion`=%s, `nationality`=%s, `birth_place`=%s, `father_details`=%s, `home_phone`=%s, `other_phone`=%s,  `mother_mobile`=%s, `father_mobile`=%s, `other_mobile`=%s, `study_year`=%s, `cert`=%s, `block_cert`=%s WHERE `id` = %s ",
                       GetSQLValueString($database,$_POST['birthday'], "int"),  
                       GetSQLValueString($database,$image_name, "text"),  
                       GetSQLValueString($database,$_POST['gov_id'], "text"), 
                       GetSQLValueString($database,$_POST['gender'], "text"), 
                       GetSQLValueString($database,$_POST['ed_id'], "text"), 
                       GetSQLValueString($database,$_POST['lang'], "int"), 
                       GetSQLValueString($database,rtrim(ltrim($_POST['name'])), "text"), 
                       GetSQLValueString($database,$_POST['fn_name'], "text"),
                       GetSQLValueString($database,strtolower($_POST['email']), "text"),
                       GetSQLValueString($database,$_POST['class'], "int"), 
                       GetSQLValueString($database,$_POST['responsible'], "text"),
                       GetSQLValueString($database,$_POST['study_type'], "int"),
                       GetSQLValueString($database,$_POST['transfare'], "int"), 
                       
                       GetSQLValueString($database,$_POST['leaving_school'], "text"), 
                       GetSQLValueString($database,strtotime($_POST['leaving_date']), "int"), 
                       GetSQLValueString($database,$_POST['leaving_comment'], "text"), 


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
                       GetSQLValueString($database,$_POST['cert'], "int"), 
                       GetSQLValueString($database,$_POST['block_cert'], "int"), 
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
        

       $insertSQL2 = sprintf("UPDATE `data_form_kids` SET `address`=%s, `brothers`=%s, `brother_name_study_year`=%s, `club`=%s , `club_name`=%s , `sick`=%s, `medicine`=%s, `mental`=%s , `mental_desc`=%s, `go_to_school`=%s  WHERE `kid_id`=%s ", 
                GetSQLValueString($database,$_POST['address'], "text"), 
                GetSQLValueString($database,$_POST['brothers'], "text"),
                GetSQLValueString($database,$_POST['brother_name_study_year'], "text"), 
                GetSQLValueString($database,$_POST['club'], "text"),  
                GetSQLValueString($database,$_POST['club_name'], "text"),  
                GetSQLValueString($database,$_POST['sick'], "text"),
                GetSQLValueString($database,$_POST['medicine'], "text"), 
                GetSQLValueString($database,$_POST['mental'], "text"),  
                GetSQLValueString($database,$_POST['mental_desc'], "text"),   
                GetSQLValueString($database,$_POST['go_to_school'], "text"),  

                GetSQLValueString($database,$_POST['id'], "int"));

                mysqli_select_db($database, $database_database);   
                mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
         


                if($_POST['transfare']==3){

                  mysqli_select_db($database, $database_database); 
                  $query_get_kid_info = "SELECT * FROM `kids_leaving` where `kid_id`='{$_GET['id']}' AND `leaving_date` ='{$_POST['leaving_date']}'  ";
                  $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
                  $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
                  $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);

                  if($totalRows_get_kid_info<1){

                        $insertSQL = sprintf("INSERT INTO `kids_leaving` (`kid_id`, `gov_id`, `ed_id`, `name`, `fn_name`,`gender`, `email`, `birthday`,`father_name`, `father_details`, `mother_mobile`, `father_mobile`, `study_year`, `leaving_school`, `leaving_comment`, `emp`, `leaving_date`, `date`) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                      GetSQLValueString($database,$_GET['id'], "int"), 
                                      GetSQLValueString($database,$_POST['gov_id'], "text"), 
                                      GetSQLValueString($database,$_POST['ed_id'], "text"), 
                                      GetSQLValueString($database,rtrim(ltrim($_POST['name'])), "text"),
                                      GetSQLValueString($database,$_POST['fn_name'], "text"),
                                      GetSQLValueString($database,$gender, "text"),
                                      GetSQLValueString($database,strtolower($_POST['email']), "text"),
                                      GetSQLValueString($database,birthday($_POST['gov_id']), "int"),
                                      GetSQLValueString($database,$_POST['father_name'], "text"), 
                                      GetSQLValueString($database,$_POST['father_details'], "text"), 
                                      GetSQLValueString($database,$_POST['mother_mobile'], "text"),
                                      GetSQLValueString($database,$_POST['father_mobile'], "text"),
                                      GetSQLValueString($database,$_POST['study_year'], "int"),  
                                      GetSQLValueString($database,$_POST['leaving_school'], "text"),   
                                      GetSQLValueString($database,$_POST['leaving_comment'], "text"),  
                                      GetSQLValueString($database,$row_get_login['id'], "int"), 
                                      GetSQLValueString($database,strtotime($_POST['leaving_date']), "int"),  
                                      GetSQLValueString($database,time(), "int"));
 
                      mysqli_query($database,$insertSQL) or die(mysqli_error($database));

              }else{

                $updateSQL = sprintf("UPDATE `kids_leaving` SET  `leaving_school`= %s, `leaving_comment`= %s, `emp`= %s, `leaving_date`= %s, `date`= %s WHERE `id` = %s",
                              GetSQLValueString($database,$_POST['leaving_school'], "text"),   
                              GetSQLValueString($database,$_POST['leaving_comment'], "text"),  
                              GetSQLValueString($database,$row_get_login['id'], "int"), 
                              GetSQLValueString($database,strtotime($_POST['leaving_date']), "int"), 
                              GetSQLValueString($database,time(), "int"),
                              GetSQLValueString($database,$row_get_kid_info['id'], "int"));

                mysqli_query($database,$updateSQL) or die(mysqli_error($database));

              }
            
            
            
            
            }



			header("location: all-kids.php?updated"); 
			exit(); 
	} 
	
 

    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids` where `id`='{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);

  if($totalRows_get_kid_info<1){header("location: all-kids.php"); exit();}

  mysqli_select_db($database, $database_database); 
  $query_get_kid_data_form = "SELECT * FROM `data_form_kids` WHERE `kid_id`='{$_GET['id']}'  ";
  $get_kid_data_form = mysqli_query($database,$query_get_kid_data_form) or die(mysqli_error($database));
  $row_get_kid_data_form = mysqli_fetch_assoc($get_kid_data_form);
  $totalRows_get_kid_data_form = mysqli_num_rows($get_kid_data_form);


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
                <h4> تعديل بيانات طالب   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                  
                    <form action="edit-kid.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			      <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text"   name="name" value="<?php echo $row_get_kid_info['name'];?>"  >
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
						<label class="col-sm-3 control-label" for="class"> الفصل </label>
						<div class="col-sm-4" id="study_year_class">
                <select class="form-control"   name="class" id="class" >
                      <option     ></option> 
                      <?php if($totalRows_get_class>0){
                        do{?>
                        <option value="<?php echo $row_get_class['id'];?>"  <?php if($row_get_kid_info['class']==$row_get_class['id']){echo " selected ";}?>>  <?php echo $row_get_class['name'];?></option>  
                      <?php }while($row_get_class = mysqli_fetch_assoc($get_class)); } ?>
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="transfare"> الحالة  <span style="color: red;">*</span></label>
						<div class="col-sm-3">
                <select class="form-control" required name="transfare" id="transfare" >
                      <option   disabled >...</option> 
                      <option value="1"  <?php if($row_get_kid_info['transfare']==1){echo " selected ";}?>>  مستجد</option> 
                      <option value="2"  <?php if($row_get_kid_info['transfare']==2){echo " selected ";}?>>  منقول للعام التالي </option>  
                      <option value="0"  <?php if($row_get_kid_info['transfare']==0){echo " selected ";}?>>  باقي</option>   
                      <option value="3"  <?php if($row_get_kid_info['transfare']==3){echo " selected ";}?>>  منقول من المدرسة </option>   
                </select>
						</div>

              <div class="col-sm-6"  <?php if($row_get_kid_info['transfare']!=3){echo ' style="display: none;" ';}?> id="transfare3">

                <div class="form-group" style="padding-bottom: 10px;">   
                  <label class="col-sm-2 control-label" for="leaving_date">    تاريخ المغادرة  </label>
                    <div class="input-group date col-sm-4" style="padding-right: 15px;">
                        <span class="input-group-btn">
                          <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                            <span class="icon icon-calendar"></span>
                          </button>
                        </span>
                        <input id="demo-datepicker-1" class="form-control" type="text" name="leaving_date"  value="<?php if($row_get_kid_info['leaving_date']>0){echo date("m/d/Y",$row_get_kid_info['leaving_date']);}?>">
                    </div> 
                  </div>

                  <div class="form-group" style="padding-bottom: 10px;">  
                    <label class="col-sm-2 control-label" for="leaving_school">  اسم المدرسة  </label>
                    <div class="col-sm-8">
                      <input id="leaving_school" class="form-control"   type="text" name="leaving_school" value="<?php echo $row_get_kid_info['leaving_school'];?>"  >
                    </div> 
                  </div> 
 
                  <div class="form-group" style="padding-bottom: 10px;"> 
                    <label class="col-sm-2 control-label"  style="text-align: right;" for="leaving_comment	">    تعليق  </label>
                    <div class="col-sm-10"> 
                      <textarea id="leaving_comment" class="form-control"   name="leaving_comment"><?php echo $row_get_kid_info['leaving_comment'];?></textarea> 
                    </div> 
                  </div>
 
              </div> 
            </div> 









            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="religion"> الديانة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                <select class="form-control"   name="religion" id="religion" >
                      <option disabled >...</option> 
                      <option value="1" <?php if($row_get_kid_info['religion']==1){echo " selected ";}?> >  مسلم</option> 
                      <option value="2" <?php if($row_get_kid_info['religion']==2){echo " selected ";}?> >  مسيحي</option>  
                      <option value="3" <?php if($row_get_kid_info['religion']==3){echo " selected ";}?> >  يهودي</option>  
                </select>
						</div>
            </div> 



            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع   </label>
              <div class="col-sm-1">
                        <select class="form-control" name="gender" id="gender" > 
                            <option value=""></option>  
                            <option value="ذكر" <?php if($row_get_kid_info['gender']=="ذكر"){echo " selected ";}?>>  ذكر</option> 
                            <option value="أنثى" <?php if($row_get_kid_info['gender']=="أنثى"){echo " selected ";}?>>  أنثى</option>   
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
            

            <div class="form-group">
						<label class="col-sm-3 control-label" for="cert"> الشهادة  </label>
						<div class="col-sm-4">
                <select class="form-control"   name="cert" id="cert" > 
                      <option value="0" <?php if($row_get_kid_info['cert']==0){echo " selected ";}?> >  غير معلن</option> 
                      <option value="1" <?php if($row_get_kid_info['cert']==1){echo " selected ";}?> >  اجتازت </option> 
                      <option value="2" <?php if($row_get_kid_info['cert']==2){echo " selected ";}?> >   لما تجتاز </option>   
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="block_cert"> حجب النتيجة  </label>
						<div class="col-sm-4">
                <select class="form-control"   name="block_cert" id="block_cert" > 
                      <option value="0" <?php if($row_get_kid_info['block_cert']==0){echo " selected ";}?> > اظهار</option> 
                      <option value="1" <?php if($row_get_kid_info['block_cert']==1){echo " selected ";}?> >  حجب </option>  
                </select>
						</div>
            </div> 



            


 
<hr>
<h3>بيانات التسجيل</h3>


<div class="form-group">
              <label class="col-sm-3 control-label" for="address">      العنوان الحالى   </label>
              <div class="col-sm-4">
                <input id="address" class="form-control" type="text" name="address" value="<?php echo $row_get_kid_data_form['address'];?>">
              </div>
            </div>

           
            <div class="form-group">
              <label class="col-sm-3 control-label" for="brothers">      لديه اخوة   </label>
              <div class="col-sm-2">
                 <select class="form-control"   name="brothers" id="brothers" > 
                      <option value="Yes" <?php if($row_get_kid_data_form['brothers']=='Yes'){echo " selected ";}?> >    نعم</option> 
                      <option value="No" <?php if($row_get_kid_data_form['brothers']=='No'){echo " selected ";}?> >  لا </option>     
                </select> 
              </div>   
             
              <label class="col-sm-3 control-label brother_name_study_year" for="brother_name_study_year" <?php if($row_get_kid_data_form['brothers']=='No'){;?> style="display: none;" <?php }?>>      اسم الاخوة فى المدرسة والصف الدراسى   </label>
              <div class="col-sm-4 brother_name_study_year">
                <input id="brother_name_study_year" class="form-control brother_name_study_year"    type="text" name="brother_name_study_year" value="<?php echo $row_get_kid_data_form['brother_name_study_year'];?>">
              </div>  
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label" for="club">      مشترك فى نادى   </label>
              <div class="col-sm-2">
                 <select class="form-control"   name="club" id="club" > 
                      <option value="Yes" <?php if($row_get_kid_data_form['club']=='Yes'){echo " selected ";}?> >    نعم</option> 
                      <option value="No" <?php if($row_get_kid_data_form['club']=='No'){echo " selected ";}?> >  لا </option>     
                </select> 
              </div>   
             
              <label class="col-sm-3 control-label club_name" for="club_name" <?php if($row_get_kid_data_form['club']=='No'){;?> style="display: none;" <?php }?>>    اسم النادي  </label>
              <div class="col-sm-4 club_name">
                <input id="club_name" class="form-control club_name"    type="text" name="club_name" value="<?php echo $row_get_kid_data_form['club_name'];?>">
              </div>  
          </div>

       
          <div class="form-group">
              <label class="col-sm-3 control-label" for="sick">      اى امراض عضوية؟   </label>
              <div class="col-sm-2">
                 <select class="form-control"   name="sick" id="sick" > 
                      <option value="Yes" <?php if($row_get_kid_data_form['sick']=='Yes'){echo " selected ";}?> >    نعم</option> 
                      <option value="No" <?php if($row_get_kid_data_form['sick']=='No'){echo " selected ";}?> >  لا </option>     
                </select> 
              </div>   
             
              <label class="col-sm-3 control-label medicine" for="medicine" <?php if($row_get_kid_data_form['sick']=='No'){;?> style="display: none;" <?php }?>>    يذكر الحالة واسماء الادوية و مواعدها  </label>
              <div class="col-sm-4 club_name">
                <input id="medicine" class="form-control medicine"    type="text" name="medicine" value="<?php echo $row_get_kid_data_form['medicine'];?>">
              </div>  
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label" for="mental">      اى امراض نفسية؟  </label>
              <div class="col-sm-2">
                 <select class="form-control"   name="mental" id="mental" > 
                      <option value="Yes" <?php if($row_get_kid_data_form['mental']=='Yes'){echo " selected ";}?> >    نعم</option> 
                      <option value="No" <?php if($row_get_kid_data_form['mental']=='No'){echo " selected ";}?> >  لا </option>     
                </select> 
              </div>   
             
              <label class="col-sm-3 control-label mental_desc" for="mental_desc" <?php if($row_get_kid_data_form['mental']=='No'){;?> style="display: none;" <?php }?>>    ويذكر الحالة  </label>
              <div class="col-sm-4 mental_desc">
                <input id="mental_desc" class="form-control mental_desc "    type="text" name="mental_desc" value="<?php echo $row_get_kid_data_form['mental_desc'];?>">
              </div>  
          </div>

       
           <div class="form-group">
              <label class="col-sm-3 control-label" for="go_to_school">      وسيلة الذهاب للمدرسة  </label>
              <div class="col-sm-4">
              <select class="form-control"   name="go_to_school" id="go_to_school" > 
                      <option value="School bus" <?php if($row_get_kid_data_form['go_to_school']=='School bus'){echo " selected ";}?> >    باص المدرسة</option> 
                      <option value="Car" <?php if($row_get_kid_data_form['go_to_school']=='Car'){echo " selected ";}?> > سيارة</option>     
                </select> 
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
                             <?php if( $row_get_login['access7sub11']==1){?>
<a href="edit-kid.php?del=<?php echo $row_get_kid_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                              <?php }?>                        
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

       

        $('#demo-inputmask').on('change', '#transfare', function (event) {   
           var transfare = $(this).val();   
                    if(transfare==3){
                       $("#transfare3").fadeIn();   
                    }else{
                       $("#transfare3").fadeOut(); 
                       $("#leaving_school").val(''); 
                       $("#demo-datepicker-1").val(''); 
                       $("#leaving_comment").val(''); 
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