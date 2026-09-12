<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub2']==1){
 
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
    $query_get_data_form = "SELECT * FROM `data_form` where `app_id`='{$row_get_kid_data_form['app_id']}'  ";
    $get_data_form = mysqli_query($database,$query_get_data_form) or die(mysqli_error($database));
    $row_get_data_form = mysqli_fetch_assoc($get_data_form);
    $totalRows_get_data_form = mysqli_num_rows($get_data_form);

  mysqli_select_db($database, $database_database); 
  $query_get_kid_vac = "SELECT * FROM `kids_vacations` where `kid_id`='{$_GET['id']}'  ";
  $get_kid_vac = mysqli_query($database,$query_get_kid_vac) or die(mysqli_error($database));
  $row_get_kid_vac = mysqli_fetch_assoc($get_kid_vac);
  $totalRows_get_kid_vac = mysqli_num_rows($get_kid_vac);

  mysqli_select_db($database, $database_database); 
  $query_get_kids_list = "SELECT * FROM `kids_list` where `kid_id`='{$_GET['id']}'  ";
  $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
  $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
  $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

  mysqli_select_db($database, $database_database); 
  $query_get_kids_list2 = "SELECT * FROM `kids-absence` where `kid_id`='{$_GET['id']}' and `confirm` = 1  ";
  $get_kids_list2 = mysqli_query($database,$query_get_kids_list2) or die(mysqli_error($database));
  $row_get_kids_list2 = mysqli_fetch_assoc($get_kids_list2);
  $totalRows_get_kids_list2 = mysqli_num_rows($get_kids_list2);


mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `certificate` WHERE `gov_id` = '{$row_get_kid_info['gov_id']}' ORDER BY `date` DESC  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);


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
                <h4> تعديل بيانات طالب   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-6">
				  <div class="demo-form-wrapper">
                  
                    <form action="edit-kid.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			 <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم </label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name" readonly value="<?php echo $row_get_kid_info['name'];?>">
              </div>
            </div>  
            
            <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  الاسم باللغة الانجليزية</label>
              <div class="col-sm-6">
                <input id="fn_name" class="form-control" style="text-align: left;"   type="text" name="fn_name" readonly value="<?php echo $row_get_kid_info['fn_name'];?>">
              </div>
            </div>  

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" required name="study_year" disabled id="study_year" >
                      <option   disabled >...</option> 
                      <option value="1" <?php if($row_get_kid_info['study_year']==0){echo " selected ";}?> >بريسكول</option> 
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
                <select class="form-control" required name="lang" disabled id="lang" >
                      <option value=""  <?php if($row_get_kid_info['lang']<1){echo " selected ";}?>>...</option> 
                      <option value="1" <?php if($row_get_kid_info['lang']==1){echo " selected ";}?>>  فرنسية</option> 
                      <option value="2" <?php if($row_get_kid_info['lang']==2){echo " selected ";}?>>  المانية</option>  
                      <option value="3" <?php if($row_get_kid_info['lang']==3){echo " selected ";}?>>  ايطالية</option> 

                </select>
						</div>
            </div> 


            <div class="form-group">
              <label class="col-sm-3 control-label" for="class">  الفصل </label>
              <div class="col-sm-4">
                <input id="class" class="form-control" required type="text" name="class" readonly value="<?php echo class_name($row_get_kid_info['class']);?>">
              </div>
            </div> 

            <div class="form-group">
						<label class="col-sm-3 control-label" for="transfare"> الحالة  </label>
						<div class="col-sm-4">
                <select class="form-control" required name="transfare" disabled id="transfare" >
                      <option   disabled >...</option> 
                      <option value="1"  <?php if($row_get_kid_info['transfare']==1){echo " selected ";}?>>  مستجد</option> 
                      <option value="2"  <?php if($row_get_kid_info['transfare']==2){echo " selected ";}?>>  منقول</option>  
                      <option value="0"  <?php if($row_get_kid_info['transfare']==0){echo " selected ";}?>>  باقي</option> 

                </select>
						</div>
            </div> 

            <div class="form-group" style="display:none">
						<label class="col-sm-3 control-label" for="religion"> الديانة </label>
						<div class="col-sm-4">
                <select class="form-control"   name="religion" id="religion" disabled >
                      <option disabled >...</option> 
                      <option value="1" <?php if($row_get_kid_info['religion']==1){echo " selected ";}?> >  مسلم</option> 
                      <option value="2" <?php if($row_get_kid_info['religion']==2){echo " selected ";}?> >  مسيحي</option>  
                      <option value="3" <?php if($row_get_kid_info['religion']==3){echo " selected ";}?> >  يهودي</option>  
                </select>
						</div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="nationality">  الجنسية </label>
              <div class="col-sm-4">
                <input id="nationality" class="form-control"  readonly type="text" name="nationality" value="<?php echo $row_get_kid_info['nationality'];?>">
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="birth_place">  محل الميلاد  </label>
              <div class="col-sm-4">
                <input id="birth_place" class="form-control" readonly   type="text" name="birth_place"  value="<?php echo $row_get_kid_info['birth_place'];?>">
              </div>
            </div> 
            
          

            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني  </label>
              <div class="col-sm-4">
                 <input class="form-control" type="text" readonly  value="<?php echo $row_get_kid_info['email'];?>">  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_id"> الرقم التعليمي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"    readonly  value="<?php echo $row_get_kid_info['ed_id'];?>">  
              </div>
            </div>


             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"    readonly  value="<?php echo $row_get_kid_info['gov_id'];?>">
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="age_october">    السن فى اول اكتوبر  </label>
              <div class="col-sm-6" id="age_october" style="padding-top: 7px; "> 
              <p style="font-weight:bold; font-size:18px" id="birthday_october" ><?php echo convertSecToTime($row_get_kid_info['birthday']);?></p> 
              </div>
            </div> 
                      
            <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاجازات في عام <?php echo date("Y",time())."/"; echo (date("Y",time())+1);?> </label>
              <div class="col-sm-3">
                <input class="form-control" required type="text" readonly value="<?php echo $row_get_kid_info['vacation'];?>" style="text-align: center;">
              </div>
            </div> 
            
            <?php if($row_get_kid_info['linked']==1){?>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="app_id"> مسجل على حساب  </label>
              <div class="col-sm-4"> 
               <h5>  <a href="view-app-account.php?id=<?php echo $row_get_kids_list['parent_id'];?>">  <?php echo parent_app($row_get_kids_list['parent_id']);?>  </a></h5>
                
              </div>
            </div> 
            <?php }?>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_details">  اسم الوالد وصناعته والعنوانه  </label>
              <div class="col-sm-6"  style="padding-top: 7px;">
              <p style="padding:20px; background-color:white;"><?php echo $row_get_kid_info['father_details'];?> </p>
                 
              </div>
      </div> 
      
      
     
            <div class="form-group">
              <label class="col-sm-3 control-label" for="address">      العنوان الحالى   </label>
              <div class="col-sm-4">
                <input id="address" class="form-control"  readonly type="text" name="address" value="<?php echo $row_get_kid_data_form['address'];?>">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="brothers">      لديه اخوة   </label>
              <div class="col-sm-2">
                <input id="brothers" class="form-control"  readonly type="text" name="brothers" value="<?php echo $row_get_kid_data_form['brothers'];?>">
              </div>  
           <?php if($row_get_kid_data_form['brothers']=='Yes'){;?>
             
              <label class="col-sm-3 control-label" for="brother_name_study_year">      اسم الاخوة فى المدرسة والصف الدراسى   </label>
              <div class="col-sm-4">
                <input id="brother_name_study_year" class="form-control"  readonly type="text" name="brother_name_study_year" value="<?php echo $row_get_kid_data_form['brother_name_study_year'];?>">
              </div> 
           <?php }?>
          </div>

           <div class="form-group">
              <label class="col-sm-3 control-label" for="club">      مشترك فى نادى   </label>
              <div class="col-sm-2">
                <input id="club" class="form-control"  readonly type="text" name="club" value="<?php echo $row_get_kid_data_form['club'];?>">
              </div>
             

            <?php if($row_get_kid_data_form['club']=='Yes'){;?> 
              <label class="col-sm-3 control-label" for="club_name">      اسم النادي   </label>
              <div class="col-sm-4">
                <input id="club_name" class="form-control"  readonly type="text" name="club_name" value="<?php echo $row_get_kid_data_form['club_name'];?>">
              </div> 
           <?php }?>
       </div>


           

           <div class="form-group">
              <label class="col-sm-3 control-label" for="sick">      اى امراض عضوية؟   </label>
              <div class="col-sm-2">
                <input id="sick" class="form-control"  readonly type="text" name="sick" value="<?php echo $row_get_kid_data_form['sick'];?>">
              </div>  
            <?php if($row_get_kid_data_form['sick']=='Yes'){;?>  
              <label class="col-sm-3 control-label" for="medicine">      يذكر الحالة واسماء الادوية و مواعدها   </label>
              <div class="col-sm-4">
                <input id="medicine" class="form-control"  readonly type="text" name="medicine" value="<?php echo $row_get_kid_data_form['medicine'];?>">
              </div> 
           <?php }?>
            </div>


           <div class="form-group">
              <label class="col-sm-3 control-label" for="mental">       اى امراض نفسية؟  </label>
              <div class="col-sm-2">
                <input id="mental" class="form-control"  readonly type="text" name="mental" value="<?php echo $row_get_kid_data_form['mental'];?>">
              </div> 

            <?php if($row_get_kid_data_form['mental']=='Yes'){;?> 
              <label class="col-sm-3 control-label" for="mental_desc">      ويذكر الحالة   </label>
              <div class="col-sm-4">
                <input id="mental_desc" class="form-control"  readonly type="text" name="mental_desc" value="<?php echo $row_get_kid_data_form['mental_desc'];?>">
              </div> 
           <?php }?>
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label" for="go_to_school">      وسيلة الذهاب للمدرسة  </label>
              <div class="col-sm-4">
                <input id="go_to_school" class="form-control"  readonly type="text" name="go_to_school" value="<?php echo $row_get_kid_data_form['go_to_school'];?>">
              </div>
            </div>






            <div class="form-group">
              <label class="col-sm-3 control-label" for="home_phone">      هاتف المنزل  </label>
              <div class="col-sm-4">
                <input id="home_phone" class="form-control"  readonly type="text" name="home_phone" value="<?php echo $row_get_kid_info['home_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="other_phone">      هاتف اخر  </label>
              <div class="col-sm-4">
                <input id="other_phone" class="form-control" readonly  type="text" name="other_phone" value="<?php echo $row_get_kid_info['other_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_mobile">      هاتف الام  </label>
              <div class="col-sm-4">
                <input id="mother_mobile" class="form-control" readonly  type="text" name="mother_mobile" value="<?php echo $row_get_kid_info['mother_mobile'];?>"> 
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_mobile">    هاتف الاب  </label>
              <div class="col-sm-4">
                <input id="father_mobile" class="form-control" readonly   type="text" name="father_mobile"  value="<?php echo $row_get_kid_info['father_mobile'];?>">
              </div>
            </div> 

            <div class="form-group">
            <label class="col-sm-3 control-label" for="		other_mobile">    هاتف محمول اخر  </label>
              <div class="col-sm-4">
                <input id="other_mobile" class="form-control" readonly  type="text" name="other_mobile"  value="<?php echo $row_get_kid_info['other_mobile'];?>">
              </div>
            </div> 
 
						
             
					  <div class="form-group">
						   <label class="col-sm-3 control-label" for="submit"> </label>
                <div class="col-sm-2"> 
                    <a href="edit-kid.php?id=<?php echo $row_get_kid_info['id'];?>" class="btn btn-danger btn-block"  ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> تعديل   </a>
                </div> 
            </div>




  <div class="col-xs-12">
    <?php if($totalRows_get_data_form>0){?>
    <hr>
<h4> بيانات التسجيل</h4>

 
                        
            
          <h3>بيانات الاب</h3> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_name">  الاسم </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="father_name" readonly value="<?php echo $row_get_data_form['father_name'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_phone">  رقم تليفون </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="father_phone" readonly value="<?php echo $row_get_data_form['father_phone'];?>">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_gov_id">    رقم بطاقة او جواز السفر  </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="father_gov_id" readonly value="<?php echo $row_get_data_form['father_gov_id'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_job">  الوظيفة   والمؤهل الدراسى </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="father_job" readonly value="<?php echo $row_get_data_form['father_job'];?>">
              </div>
            </div> 
                            
          <h3>بيانات الام</h3> 


          <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_name">  الاسم </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="mother_name" readonly value="<?php echo $row_get_data_form['mother_name'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_phone">  رقم تليفون </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="mother_phone" readonly value="<?php echo $row_get_data_form['mother_phone'];?>">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_gov_id">    رقم بطاقة او جواز السفر  </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="mother_gov_id" readonly value="<?php echo $row_get_data_form['mother_gov_id'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_job">  الوظيفة   والمؤهل الدراسى </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="mother_job" readonly value="<?php echo $row_get_data_form['mother_job'];?>">
              </div>
            </div>   

          <h5 class="bot-20 sec-tit center white-text" style="color: #455a64 !important">بيانات هامة</h5>


           <div class="form-group">
              <label class="col-sm-3 control-label" for="whatsapp">  واتس اب </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="whatsapp" readonly value="<?php echo $row_get_data_form['whatsapp'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_welaya">    ولاية تعليمية </label>
              <div class="col-sm-3">
                <input class="form-control" type="text" name="ed_welaya" readonly value="<?php echo $row_get_data_form['ed_welaya'];?>">
              </div>
              <?php if($row_get_data_form['ed_welaya_copy']!=NULL){?>
                <div class="col-sm-3">  
                   <a href="../uploads/<?php echo $row_get_data_form['ed_welaya_copy'];?>" target="_blank">صورة من الولاية التعليمية</a>
              </div>
              <?php }?>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="divorce_living">    فى حالة الانفصال سكن الطالب مع </label>
              <div class="col-sm-3">
                <input class="form-control" type="text" name="divorce_living" readonly value="<?php echo $row_get_data_form['divorce_living'];?>">
              </div>
              <?php if($row_get_data_form['divorce_living_why']!=NULL){?>
                <div class="col-sm-3">  
                <input class="form-control" type="text" name="divorce_living" readonly value="<?php echo $row_get_data_form['divorce_living_why'];?>">
              </div>
              <?php }?>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="death">    فى حالة الوفاة للوالدين </label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="death" readonly value="<?php echo $row_get_data_form['death'];?>">
              </div>
            </div>
  
            <div class="form-group">
              <label class="col-sm-3 control-label" for="emergency_phone">رقم تليفون للطوارئ</label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="emergency_phone" readonly value="<?php echo $row_get_data_form['emergency_phone'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="emergency_relative"> درجة القرابة</label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="emergency_relative" readonly value="<?php echo $row_get_data_form['emergency_relative'];?>">
              </div>
            </div>
            
 <?php }?> 
            <hr> 

<?php if($row_get_login['access7sub9']==1){

        mysqli_select_db($database , $database_database,);
        $query_get_kids_certificate = "SELECT * FROM `success_statement` where `gov_id` = '{$row_get_kid_info['ed_id']}'";
        $get_kids_certificate = mysqli_query($database , $query_get_kids_certificate) or die(mysqli_error($database));
        $row_get_kids_certificate = mysqli_fetch_assoc($get_kids_certificate);
        $totalRows_get_kids_certificate = mysqli_num_rows($get_kids_certificate);


        mysqli_select_db($database , $database_database,);
        $query_get_block_certificate = "SELECT * FROM `certificate` where `gov_id` = '{$row_get_kid_info['ed_id']}' and `active` = 0 order by `id` DESC limit 1 ";
        $get_block_certificate = mysqli_query($database , $query_get_block_certificate) or die(mysqli_error($database));
        $row_get_block_certificate = mysqli_fetch_assoc($get_block_certificate);
        $totalRows_get_block_certificate = mysqli_num_rows($get_block_certificate);

if($totalRows_get_kids_certificate>0 && $row_get_kid_info['block_cert']==0 && $totalRows_get_block_certificate <1){
        do{
          
          if($row_get_kids_certificate['type']==2){?>
            <div class="form-group">
						   <label class="col-sm-3 control-label" for="submit"> </label>
                <div class="col-sm-4"> 
                    <a href="kid_print_cert.php?id=<?php echo $row_get_kid_info['ed_id'];?>&type=2&cert=<?php echo $row_get_kids_certificate['id'];?>" class="btn btn-danger btn-block" target="_blank"  ><i class="fa fa-print" aria-hidden="true"></i> طباعة بيان نجاح نصف العام    <?php echo $row_get_kids_certificate['year'];?> </a>
                </div> 

                <div class="col-sm-4"> 
                    <a href="kid_print_cert_edara.php?id=<?php echo $row_get_kid_info['ed_id'];?>&type=2&cert=<?php echo $row_get_kids_certificate['id'];?>" class="btn btn-danger btn-block" target="_blank"  ><i class="fa fa-print" aria-hidden="true"></i> طباعة بيان نجاح نصف العام ادارة     <?php echo $row_get_kids_certificate['year'];?> </a>
                </div> 
            </div>
<?php } if($row_get_kids_certificate['type']==3){?>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="submit"> </label>
              <div class="col-sm-4"> 
                  <a href="kid_print_cert.php?id=<?php echo $row_get_kid_info['ed_id'];?>&type=3&cert=<?php echo $row_get_kids_certificate['id'];?>" class="btn btn-danger btn-block" target="_blank"  ><i class="fa fa-print" aria-hidden="true"></i> طباعة بيان نجاح نهاية العام  <?php echo $row_get_kids_certificate['year'];?>  </a>
              </div> 

              <div class="col-sm-4"> 
                  <a href="kid_print_cert_edara.php?id=<?php echo $row_get_kid_info['ed_id'];?>&type=3&cert=<?php echo $row_get_kids_certificate['id'];?>" class="btn btn-danger btn-block" target="_blank"  ><i class="fa fa-print" aria-hidden="true"></i> طباعة بيان نجاح نهاية   العام ادارة   <?php echo $row_get_kids_certificate['year'];?>  </a>
              </div> 
          </div>
<?php } 


}while($row_get_kids_certificate = mysqli_fetch_assoc($get_kids_certificate));  } }?>
          </div> 

         <?php if($row_get_kid_info['study_year']==1 || $row_get_kid_info['study_year']==2){?> 
           <div class="form-group">
            <label class="col-sm-3 control-label" for="submit"> </label>
              <div class="col-sm-4"> 
                  <a href="kid_print_cert_travel.php?id=<?php echo $row_get_kid_info['id'];?>" class="btn btn-danger btn-block" target="_blank"  ><i class="fa fa-print" aria-hidden="true"></i> طباعة بيان نجاح  موجه لجه   </a>
              </div>   
           </div>
        <?php } ?>






            
                      
                     



					   <div class="form-group">
						 <label class="col-sm-3 control-label" > </label>
						 <div class="col-sm-6"> 
						   <?php echo $msg;?> 
						 </div> 
					  </div>
						
						
						
						
						
					</form>
				  </div>
                </div>
            <div class="col-md-6">
            <div class="col-md-6">
            <img src="../kids/<?php  if($row_get_kid_info['picture']!=null){echo $row_get_kid_info['picture'];}else{echo "no-picture.png";}?>" class="img-responsive img-rounded img-thumbnail"  style="float:left" />
            </div>
            <div class="col-md-10">
            <div class="card-body" data-toggle="match-height" >  
                <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px; ">
                    <thead> 
                      <tr>   
                        <th class="text-center">  نوع الاجازة</th> 
                        <th class="text-center"> التاريخ  </th>  
                        <th class="text-center"> الحالة  </th>  
                        <th class="text-center"> </th> 
                      </tr>
                    </thead>
                    <tbody>  
 
						
						<?php if($totalRows_get_kid_vac>0){
	                           do{  ?>
                      <tr class="count">  
                        <td class="text-center">
                            <?php if($row_get_kid_vac['type']==1){echo " مرضي";}
                                  if($row_get_kid_vac['type']==2){echo " منقول";}  ?>
                        </td>
                        <td class="text-center"><?php echo date("m/d/Y",$row_get_kid_vac['vacation_date']);?></td>   
                        <td class="text-center">
                            <?php if($row_get_kid_vac['status']==0){echo " معلق";}
                                  if($row_get_kid_vac['status']==1){echo " مقبول";} 
                                  if($row_get_kid_vac['status']==2){echo " مرفوض";}  ?>
                        </td>
                        <td class="text-center">
                        <a href="view-kid-vacation.php?id=<?php echo $row_get_kid_vac['id'];?>" class="btn btn-primary" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a>
                        </td>
                      </tr>
                      <?php }while($row_get_kid_vac = mysqli_fetch_assoc($get_kid_vac));}  
                      
                      if($totalRows_get_kids_list2>0){
	                           do{ if(vacation_check($row_get_kids_list2['date'],$row_get_kids_list2['kid_id'])==0){ ?>
                      <tr class="count" style="color: red;">  
                        <td class="text-center">غير مبررة</td>
                        <td class="text-center"><?php echo date("m/d/Y",$row_get_kids_list2['date']);?></td>   
                        <td class="text-center"> معلق </td>
                        <td class="text-center"> </td>
                      </tr>
                      <?php }}while($row_get_kids_list2 = mysqli_fetch_assoc($get_kids_list2));} ?> 
                     
                     
                    </tbody>
                  </table>


                </div>
               </div>






          <div class="col-md-10">
            <hr>

            <h4>النتائج </h4>
            <div class="card-body" data-toggle="match-height" >  
                <table id="court-datatables2" class="table table-striped  dataTable" width="100%" style="font-size: 16px; ">
                <thead>
                      <tr>  
                        <th class="text-left">نتيجة  </th>  
                        <th class="text-center">تاريخ  </th>  
                        <th > </th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_class_info>0){
	                           do{?>
                                 
                      <tr> 
                        
                        <td class="text-left"><?php echo $row_get_class_info['title_arb'];?></td>   
                        <td class="text-center"><?php echo date("d/m/Y",$row_get_class_info['date']);?></td>   
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                               <li><a href="view_kid_cert.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a></li> 
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_class_info = mysqli_fetch_assoc($get_class_info));} ?> 
                     
                     
                    </tbody>
                  </table>


                </div>
<?php if($row_get_login['access17sub3']==1){ ?>
          <h4 style="padding-bottom: 0px;">الوضع المالي </h4> 
            <div class="card-body table" data-toggle="match-height" style="padding-bottom: 0px;" >
                <table  class="table " cellspacing="0" width="100%" style="font-size: 12px">
                    <thead>
                      <tr> 
                        
                        <th class="text-center"> رسوم التعليم </th>  
                        <th class="text-center"> رسوم نشاط</th>  
                        <th class="text-center"> ايرادات الباص </th>
                        <th class="text-center"> ايرادات الزي </th>
                        <th class="text-center"> كتب وزاري   </th> 
                        <th class="text-center"> ايرادات الزي الاضافي </th>
                        <th class="text-center"> حاسب الي </th>  
                        <th class="text-center"> كامبريدج وابليكشن </th>    
                        <th class="text-center"> تكنوكيدز </th>    
                        <th class="text-center"> كورس / استضافة </th>    
                        <th class="text-center"> الاجمالي</th>     
                        <th class="text-center"> رسوم تسجيل</th>     
                        <th class="text-center"> اجمالي التعليم</th>     
                        <th class="text-center"> مستحقات</th>     
                      </tr>
                    </thead>
                    <tbody>  
						<?php 
            mysqli_select_db($database, $database_database);  
            $query_get_accounting_info = "SELECT * FROM `kids_accounting` WHERE `ed_id` = '{$row_get_kid_info['ed_id']}'    "; 
            $get_accounting_info = mysqli_query($database,$query_get_accounting_info) or die(mysqli_error($database));
            $row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info);
            $totalRows_get_accounting_info = mysqli_num_rows($get_accounting_info);
            if($totalRows_get_accounting_info>0){ ?>
                      <tr>  
                        <td class="text-center"><?php echo $row_get_accounting_info['ed_fees'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['activity'];?></td>    
                        <td class="text-center"><?php echo $row_get_accounting_info['bus'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['uniform1'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['books1'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['uniform2'];?></td>   
                        <td class="text-center"><?php echo $row_get_accounting_info['pc'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['cambrage'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['technokids'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['hosting'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['total'];?></td>     
                        <td class="text-center"><?php echo $row_get_accounting_info['registration'];?></td>     
                        <td class="text-center"><?php echo $row_get_accounting_info['total_ed'];?></td>       
                        <td class="text-center"><?php echo $row_get_accounting_info['rest'];?></td>     
                      </tr>
                      <?php } ?> 
                      </tbody>
                  
                  </table> 

                </div>
            
           <?php   mysqli_select_db($database, $database_database);  
            $query_get_payment_notification = "SELECT * FROM `payment_notification` WHERE `kid_id` = '{$row_get_kid_info['id']}'    "; 
            $get_payment_notification = mysqli_query($database,$query_get_payment_notification) or die(mysqli_error($database));
            $row_get_payment_notification = mysqli_fetch_assoc($get_payment_notification);
            $totalRows_get_payment_notification = mysqli_num_rows($get_payment_notification);
            if($totalRows_get_payment_notification>0){  ?>
                <h3>اخطار سداد</h3>
                <ul>
                  <?php $i=1; do{ ?>
                  <li><?php echo $i." - ".date("d/m/Y h:i A",$row_get_payment_notification['sent_date'])." - ". $row_get_payment_notification['msg'];?></li>
                  <?php $i++; }while($row_get_payment_notification = mysqli_fetch_assoc($get_payment_notification));?>
                </ul>
                <?php } } ?>

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

$("input").css("backgroundColor","white");
$("select").css("backgroundColor","white");

	  });
    </script>
    <script>
	  $(document).ready(function(){ 

		$("#court-datatables").DataTable({ 
            paging: false,
            dom: 'Bfrtip', 
 
            
            language: {
                paginate: {
                    previous: "السابق",
                    next: "التالي"
                },
                search: "_INPUT_",
                searchPlaceholder: "بحث"
            },
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 

       

        $("#court-datatables2").DataTable({  
            order: [
                [1, "desc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 
          
   


        
	  });
 </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>