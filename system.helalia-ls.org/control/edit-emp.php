<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php');   
 require_once('includes/functions.php');   
 require_once('includes/app10-students-sync.php');
 //require_once('erros_check.php');   

 if($row_get_login['access6sub3']==1){

$msg ='';


if(isset($_GET['del'])){   
        $deleteSQL = sprintf("DELETE FROM `emps` WHERE `id`=%s ",
                           GetSQLValueString($database,$_GET['del'], "int"));
    
                mysqli_select_db($database, $database_database);  
                $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

        $deleteSQL2 = sprintf("DELETE FROM `app_login` WHERE `emp_id`=%s ",
                GetSQLValueString($database,$_GET['del'], "int"));

        mysqli_select_db($database, $database_database);  
        $Result2 = mysqli_query($database,$deleteSQL2) or die(mysqli_error($database));

                header("location: all-emps.php"); 
                exit(); 
        } 



        if(isset($_GET['reset'])){    
          $insertSQL1 = sprintf("UPDATE `app_login` SET `password`=%s WHERE `emp_id`=%s ", 
                          GetSQLValueString($database,md5('123456'), "text"), 
                          GetSQLValueString($database,$_GET['id'], "int"));

                mysqli_select_db($database, $database_database);   
                $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

 
                  header("location: edit-emp.php?id=".$_GET['id']."&done"); 
                  exit(); 
          } 
  
  
   

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `emps` SET `on_duty`=%s,`gov_id`=%s, `birthday`=%s, `ext_id`=%s,`name`=%s, `job`=%s, `start_date`=%s, `app1`=%s, `app1_0`=%s,`app1_1`=%s, `app1_2`=%s, `app1_3`=%s, `app1_4`=%s, `app1_5`=%s,`app2`=%s, `app2_0`=%s, `app2_1`=%s, `app2_2`=%s, `app2_3`=%s, `app2_4`=%s, `app2_5`=%s, `app3`=%s, `app4`=%s, `app5`=%s, `app6`=%s, `app6_0`=%s, `app6_1`=%s, `app6_2`=%s, `app6_3`=%s, `app6_4`=%s, `app6_5`=%s, `app7`=%s, `app7_0`=%s, `app7_1`=%s, `app7_2`=%s, `app7_3`=%s, `app7_4`=%s, `app7_5`=%s, `app7_6`=%s,`app8`=%s, `app9`=%s, `app9_0`=%s, `app9_1`=%s, `app9_2`=%s, `app9_3`=%s, `app9_4`=%s, `app9_5`=%s, `app10`=%s, `app10_0`=%s, `app10_1`=%s, `app10_2`=%s, `app10_3`=%s, `app10_4`=%s, `app10_5`=%s, `app11`=%s, `app11_1`=%s, `app11_2`=%s, `app11_2_0`=%s, `app11_2_1`=%s, `app11_2_2`=%s, `app11_2_3`=%s, `app11_2_4`=%s, `app11_2_5`=%s, `app11_2_6`=%s,`app11_2_7`=%s,`app11_2_8`=%s,`app11_2_9`=%s,`app11_2_10`=%s,`app11_2_11`=%s,   `app12`=%s, `app12_0`=%s, `app12_1`=%s, `app12_2`=%s, `app12_3`=%s, `app12_4`=%s, `app12_5`=%s, `app13`=%s, `app13_1`=%s, `app13_1_0`=%s, `app13_1_1`=%s, `app13_1_2`=%s, `app13_1_3`=%s, `app13_1_4`=%s, `app13_1_5`=%s,  `app14`=%s, `app14_1`=%s, `app14_2`=%s, `app14_3`=%s, `app14_4`=%s, `app15`=%s, `app15_1`=%s, `app16`=%s, `app16_0`=%s, `app16_1`=%s, `app16_2`=%s, `app16_3`=%s, `app16_4`=%s, `app16_5`=%s, `app17`=%s, `app17_1`=%s, `app18`=%s, `app18_0`=%s, `app18_1`=%s, `app18_2`=%s, `app18_3`=%s, `app18_4`=%s, `app18_5`=%s, `app19`=%s, `app19_1`=%s WHERE `id` = %s", 
                              GetSQLValueString($database,$_POST['on_duty'], "text"), 
                              GetSQLValueString($database,$_POST['gov_id'], "text"), 
                              GetSQLValueString($database,birthday($_POST['gov_id']), "int"), 
                              GetSQLValueString($database,$_POST['ext_id'], "int"), 
                              GetSQLValueString($database,$_POST['name'], "text"),  
                              GetSQLValueString($database,$_POST['job'], "int"),
                              GetSQLValueString($database,strtotime($_POST['start_date']), "int"), 
                              GetSQLValueString($database,$_POST['app1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_0']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app1_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_0']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app2_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app3']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app4']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app6']?1:0, "int"), 
                                GetSQLValueString($database,$_POST['app6_0']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app7']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_0']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_5']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7_6']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app8']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app9_0']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_1']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_2']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_3']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_4']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app9_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app10']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_0']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_4']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app10_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app11']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app11_1']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app11_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_0']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_4']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_5']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app11_2_6']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app11_2_7']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app11_2_8']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app11_2_9']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app11_2_10']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app11_2_11']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app12']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app12_0']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app12_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app12_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app12_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app12_4']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app12_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app13']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app13_1']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_0']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_1']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_2']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_3']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_4']?1:0, "int"),
                                    GetSQLValueString($database,$_POST['app13_1_5']?1:0, "int"),    
                              GetSQLValueString($database,$_POST['app14']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app14_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app14_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app14_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app14_4']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app15']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app15_1']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app16']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app16_0']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app16_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app16_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app16_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app16_4']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app16_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app17']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app17_1']?1:0, "int"), 
                              GetSQLValueString($database,$_POST['app18']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app18_0']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app18_1']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app18_2']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app18_3']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app18_4']?1:0, "int"),
                                 GetSQLValueString($database,$_POST['app18_5']?1:0, "int"),
                              GetSQLValueString($database,$_POST['app19']?1:0, "int"), 
                                 GetSQLValueString($database,$_POST['app19_1']?1:0, "int"),
                              GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       


       if(app_check($_POST['id'])>0){
        if (!function_exists('helalia_phone_is_taken')) {
          require_once('includes/phone-unique.php');
        }
        $empIdPost = (int) $_POST['id'];
        $phoneClash = helalia_phone_is_taken($database, $_POST['phone'], array(
          'exclude_emp_id' => $empIdPost,
          'exclude_app_login_emp_id' => $empIdPost,
        ));
        if ($phoneClash) {
          header("location: edit-emp.php?id=".$empIdPost."&phone_exists=1");
          exit();
        }
        $updateSQL = sprintf("UPDATE `app_login` SET `name`=%s, `phone`=%s WHERE `emp_id` = %s", 
                                GetSQLValueString($database,$_POST['name'], "text"), 
                                GetSQLValueString($database,$_POST['phone'], "text"),  
                                GetSQLValueString($database,$_POST['id'], "int"));

        mysqli_select_db($database, $database_database);   
        $Result2 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));

       }
 
			header("location: all-emps.php?done"); 
			exit(); 
  } 
  
 
 
    mysqli_select_db($database, $database_database); 
    $query_get_users_info = "SELECT * FROM `emps` where `id`='{$_GET['id']}'  ";
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);

    mysqli_select_db($database, $database_database); 
    $query_get_jobs = "SELECT * FROM `jobs` order by `name` asc";
    $get_jobs = mysqli_query($database,$query_get_jobs) or die(mysqli_error($database));
    $row_get_jobs = mysqli_fetch_assoc($get_jobs);
    $totalRows_get_jobs = mysqli_num_rows($get_jobs);

     
    mysqli_select_db($database, $database_database); 
    $query_get_jobs_access = "SELECT * FROM `jobs` where `id`='{$row_get_users_info['job']}'";
    $get_jobs_access = mysqli_query($database,$query_get_jobs_access) or die(mysqli_error($database));
    $row_get_jobs_access = mysqli_fetch_assoc($get_jobs_access);
    $totalRows_get_jobs_access = mysqli_num_rows($get_jobs_access);


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
  <style>
    #appaccess .control-label{  font-size: 16px;}
  </style>
 </head> 
 
  <body class="layout layout-header-fixed"> 
	  
    <div class="layout-header">
      <div class="navbar navbar-default">
        <div class="navbar-header" style=" background-color: black">
          <a class="navbar-brand navbar-brand-center" href="home.php" style=" padding: 5px">
            
          </a>
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
                <h4> تعديل موظف     </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-10">
				  <div class="demo-form-wrapper">
                    <form action="edit-emp.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-3">
                <input id="name" class="form-control" required type="text" name="name" value="<?php echo $row_get_users_info['name'];?>">
              </div>
            </div>  
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="phone">   الهاتف  <span style="color: red;">*</span> </label>
              <div class="col-sm-2">
                <input id="phone" class="form-control" type="text" name="phone" readonly maxlength="11" minlength="11" value="<?php echo $row_get_users_info['phone'];?>">
                <small style="color: red;"><?php
                  if (!function_exists('helalia_phone_taken_message')) {
                    require_once('includes/phone-unique.php');
                  }
                  if (isset($_GET['phone_exists'])) {
                    echo htmlspecialchars(helalia_phone_taken_message('ar'), ENT_QUOTES, 'UTF-8');
                  } elseif (app_phone($row_get_users_info['phone']) >= 1) {
                    if (app_phone2($row_get_users_info['phone'], $row_get_users_info['id']) < 1) {
                      echo htmlspecialchars(helalia_phone_taken_message('ar'), ENT_QUOTES, 'UTF-8');
                    } else {
                      echo 'يوجد حساب تطبيق مرتبط بهذا الرقم';
                    }
                  }
                ?></small>
              </div> 
            </div> 
               
           <?php if(app_check($row_get_users_info['id'])>0){?> 
            <div class="form-group">
              <label class="col-sm-3 control-label" for="password">  كلمة المرور مؤقتة  </label>
              <div class="col-sm-2">
                <input id="password" class="form-control" type="text" name="password" readonly value="<?php if(app_pass($row_get_users_info['id'])!='e10adc3949ba59abbe56e057f20f883e'){echo "تم تغيير كلمة المرور من قبل الموظف";}else{echo "123456";}?>">
              </div>
              <div class="col-sm-2">
                <a href="edit-emp.php?id=<?php echo $_GET['id'];?>&reset"  class="btn btn-primary btn-block" >اعدة تعين <i class="fa fa-key" aria-hidden="true"></i></a>
              </div>
            </div> 
           <?php }?>

            <div class="form-group">
						<label class="col-sm-3 control-label" for="job"> الوظيفة  <span style="color: red;">*</span></label>
						<div class="col-sm-2">
                <select class="form-control" required name="job" id="job" >
                      <option selected disabled >...</option>
                      <?php do{ ?>
                      <option value="<?php echo $row_get_jobs['id'];?>" <?php if($row_get_jobs['id']==$row_get_users_info['job']){echo " selected ";} ?> ><?php echo $row_get_jobs['name'];?></option>
                      <?php }while($row_get_jobs = mysqli_fetch_assoc($get_jobs)); ?>
                </select>
						</div>
            </div>  
            

            <div class="form-group">
						<label class="col-sm-3 control-label" for="ext_id">       كود الحضور و الانصراف  </label>
              <div class="col-sm-2">
              <input id="form-control-9" class="form-control" type="number" value="<?php echo $row_get_users_info['ext_id'];?>"   name="ext_id">  
              </div>
            </div> 

             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id" style="font-weight:bold">  <strong>الرقم القومي</strong>       </label>
              <div class="col-sm-2">
                <input class="form-control" name="gov_id"   value="<?php echo $row_get_users_info['gov_id'];?>" style="background-color: white; border-color:black">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="birthday" style="font-weight:bold">         تاريخ الميلاد   </label>
              <div class="col-sm-2">
                <input class="form-control" readonly value="<?php isset($row_get_users_info['birthday']) ? date("d/m/Y",$row_get_users_info['birthday']):'';?>"  style="background-color: white; border-color:black">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="vacations" style="font-weight:bold">           رصيد الإجازات  </label>
              <div class="col-sm-1">
                <input class="form-control" readonly value="<?php echo $row_get_users_info['vacations'];?>"  style="background-color: white; border-color:black; text-align:center">
              </div>
            </div> 


            <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">   تاريخ التعين   </label>
              <div class="input-group date col-sm-2">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" type="text" name="start_date"  value="<?php if($row_get_users_info['start_date']!=null){echo date("m/d/Y",$row_get_users_info['start_date']);}?>">
                </div> 
            </div> 
                      
                      
            <div class="form-group">
              <label class="col-sm-3 control-label" for="start_date">     ميعاد الحضور   </label>
              <div class="input-group date col-sm-2">
                <div class="input-with-icon">
                  <input id="demo-timepicker-5" class="form-control" name="on_duty" type="text" value="<?php  echo $row_get_users_info['on_duty'];?>">
                  <span class="icon icon-clock-o input-icon"></span>
                </div>  
              </div> 
            </div> 
            
            
               


<hr>

    <div id="appaccess" <?php if(appaccess($row_get_users_info['job'])<1 || app_phone($row_get_users_info['phone'])==0){echo  " style='display: none;' ";}?>  >

            <div class="form-group  " >   
                    
            <label class="col-sm-3 control-label "  style="font-weight: bold; font-size:20px" >     صلاحيات على الابليكشن</label>
	          </div>
                     


                    
                       <div class="form-group app  "   > 
                       <label class="col-sm-3 control-label"  > تجميع غياب الطلبة</label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app1" class="app_btn " <?php if($row_get_users_info['app1']==1){echo " checked ";} ?> name="app1" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_0']==1){echo " checked ";} ?>  name="app1_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_1']==1){echo " checked ";} ?>  name="app1_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_2']==1){echo " checked ";} ?>  name="app1_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_3']==1){echo " checked ";} ?>  name="app1_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_4']==1){echo " checked ";} ?>  name="app1_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1"  <?php if($row_get_users_info['app1_5']==1){echo " checked ";} ?>  name="app1_5" value="1" >   الثانوي </div>
                       </div>



                       <div class="form-group app  "   > 
                       <label class="col-sm-3 control-label"  > قبول غياب الطلبة</label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app9" class="app_btn " <?php if($row_get_users_info['app9']==1){echo " checked ";} ?> name="app9" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_0']==1){echo " checked ";} ?>  name="app9_0" value="1" >   بري سكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_1']==1){echo " checked ";} ?>  name="app9_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_2']==1){echo " checked ";} ?>  name="app9_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_3']==1){echo " checked ";} ?>  name="app9_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_4']==1){echo " checked ";} ?>  name="app9_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app9"  <?php if($row_get_users_info['app9_5']==1){echo " checked ";} ?>  name="app9_5" value="1" >   الثانوي </div>
                       </div>
 

                       <div class="form-group app  "   > 
                        <label class="col-sm-3 control-label"  >    تاكيد غياب الطلبة   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app6"  class="app_btn "  <?php if($row_get_users_info['app6']==1){echo " checked ";} ?>  name="app6" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_0']==1){echo " checked ";} ?>  name="app6_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_1']==1){echo " checked ";} ?>  name="app6_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_2']==1){echo " checked ";} ?>  name="app6_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_3']==1){echo " checked ";} ?>  name="app6_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_4']==1){echo " checked ";} ?>  name="app6_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app6"  <?php if($row_get_users_info['app6_5']==1){echo " checked ";} ?>  name="app6_5" value="1" >   الثانوي </div>
                       </div>

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  > تجميع غياب المجموعات</label>
					            	<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"  <?php if($row_get_users_info['app3']==1){echo " checked ";} ?>  name="app3" value="1" > </div>
                       </div>

                       
                     <!--  <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >    توجية استفسارات الاباء   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app2" class="app_btn " <?php //if($row_get_users_info['app2']==1){echo " checked ";} ?> name="app2" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_0']==1){echo " checked ";} ?>  name="app2_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_1']==1){echo " checked ";} ?>  name="app2_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_2']==1){echo " checked ";} ?>  name="app2_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_3']==1){echo " checked ";} ?>  name="app2_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_4']==1){echo " checked ";} ?>  name="app2_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app2"  <?php //if($row_get_users_info['app2_5']==1){echo " checked ";} ?>  name="app2_5" value="1" >   الثانوي </div>
                       </div>


                        

                       <div class="form-group app  " style="display: none;"    > 
                        <label class="col-sm-3 control-label"  >    الرد على استفسارات الاباء   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app7" class="app_btn " <?php //if($row_get_users_info['app7']==1){echo " checked ";} ?> name="app7" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_0']==1){echo " checked ";} ?>  name="app7_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_1']==1){echo " checked ";} ?>  name="app7_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_2']==1){echo " checked ";} ?>  name="app7_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_3']==1){echo " checked ";} ?>  name="app7_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_4']==1){echo " checked ";} ?>  name="app7_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_5']==1){echo " checked ";} ?>  name="app7_5" value="1" >   الثانوي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app7"  <?php //if($row_get_users_info['app7_6']==1){echo " checked ";} ?>  name="app7_6" value="1" >   الجميع </div>
                       </div>


                       <div class="form-group app  "  style="display: none;"  > 
                        <label class="col-sm-3 control-label"  >    اقسام      </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app14" class="app_btn " <?php //if($row_get_users_info['app14']==1){echo " checked ";} ?> name="app14" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app14"  <?php //if($row_get_users_info['app14_1']==1){echo " checked ";} ?>  name="app14_1" value="1" > سكرتير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app14"  <?php //if($row_get_users_info['app14_2']==1){echo " checked ";} ?>  name="app14_2" value="1" > رئيس القسم </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app14"  <?php //if($row_get_users_info['app14_3']==1){echo " checked ";} ?>  name="app14_3" value="1" > طبيب </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app14"  <?php //if($row_get_users_info['app14_4']==1){echo " checked ";} ?>  name="app14_4" value="1" > معالج نفسي </div>
                        </div>

-->



                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >    عرض غياب العاملين    </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"  <?php if($row_get_users_info['app4']==1){echo " checked ";} ?>  name="app4" value="1" > </div>
                       </div>

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >    عرض اذون العاملين   </label>
					            	<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"  <?php if($row_get_users_info['app5']==1){echo " checked ";} ?>  name="app5" value="1" > </div>
                       </div>

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >        اشعارات الفصول   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"  <?php if($row_get_users_info['app8']==1){echo " checked ";} ?>  name="app8" value="1" > </div>
                       </div>

                      
                       <div class="form-group app  "     > 
                          <label class="col-sm-3 control-label"  >          عرض الطلبة   </label>
					               	<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app10" class="app_btn"  <?php if($row_get_users_info['app10']==1){echo " checked ";} ?>  name="app10" value="1" > </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_0']==1){echo " checked ";} ?>  name="app10_0" value="1" >   بريسكول </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_1']==1){echo " checked ";} ?>  name="app10_1" value="1" > رياض الاطفال </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_2']==1){echo " checked ";} ?>  name="app10_2" value="1" >    الابتدائي الصغير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_3']==1){echo " checked ";} ?>  name="app10_3" value="1" >   الابتدائي كبير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_4']==1){echo " checked ";} ?>  name="app10_4" value="1" >   الاعدادي </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app10"  <?php if($row_get_users_info['app10_5']==1){echo " checked ";} ?>  name="app10_5" value="1" >   الثانوي </div>
                       </div>
                   
                       <hr>

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >   المراجعات   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app15" class="app_btn " name="app15" value="1" <?php if($row_get_users_info['app15']==1){echo " checked ";} ?> > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app15" name="app15_1" value="1" <?php if($row_get_users_info['app15_1']==1){echo " checked ";} ?>  >   رفع المراجعات </div>
                       </div>
                       

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >   عرض   </label> 
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn  " name="app16"  id="app16" value="1" <?php if($row_get_users_info['app16']==1){echo " checked ";} ?>  >      </div>
                       
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_0']==1){echo " checked ";} ?>  name="app16_0" value="1" >   بريسكول </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_1']==1){echo " checked ";} ?>  name="app16_1" value="1" > رياض الاطفال </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_2']==1){echo " checked ";} ?>  name="app16_2" value="1" >    الابتدائي الصغير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_3']==1){echo " checked ";} ?>  name="app16_3" value="1" >   الابتدائي كبير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_4']==1){echo " checked ";} ?>  name="app16_4" value="1" >   الاعدادي </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app16"  <?php if($row_get_users_info['app16_5']==1){echo " checked ";} ?>  name="app16_5" value="1" >   الثانوي </div>
                       </div>
                       <hr>


                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >   المذكرات   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app17" class="app_btn " name="app17" value="1" <?php if($row_get_users_info['app17']==1){echo " checked ";} ?> > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app17" name="app17_1" value="1" <?php if($row_get_users_info['app17_1']==1){echo " checked ";} ?>  >   رفع المذكرات </div>
                       </div>
                       

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  >   عرض   </label> 
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn  " name="app18"  id="app18" value="1" <?php if($row_get_users_info['app18']==1){echo " checked ";} ?>  >      </div>
                       
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_0']==1){echo " checked ";} ?>  name="app18_0" value="1" >   بريسكول </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_1']==1){echo " checked ";} ?>  name="app18_1" value="1" > رياض الاطفال </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_2']==1){echo " checked ";} ?>  name="app18_2" value="1" >    الابتدائي الصغير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_3']==1){echo " checked ";} ?>  name="app18_3" value="1" >   الابتدائي كبير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_4']==1){echo " checked ";} ?>  name="app18_4" value="1" >   الاعدادي </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app18"  <?php if($row_get_users_info['app18_5']==1){echo " checked ";} ?>  name="app18_5" value="1" >   الثانوي </div>
                       </div>
                       <hr>
                       

                       <div class="form-group app  "    > 
                        <label class="col-sm-3 control-label"  > الواجبات المنزلية   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app11" class="app_btn " name="app11" value="1" <?php if($row_get_users_info['app11']==1){echo " checked ";} ?> > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11" name="app11_1" value="1" <?php if($row_get_users_info['app11_1']==1){echo " checked ";} ?>  >   رفع الواجبات </div>
                       </div>
                       
                       <hr>

                      <div class="form-group app  "    > 
                          <label class="col-sm-3 control-label"  > تاكيد الواجبات</label>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn  " name="app11_2" id="app11_2"  value="1"  <?php if($row_get_users_info['app11_2']==1){echo " checked ";} ?> >   </div>  
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_0']==1){echo " checked ";} ?>  name="app11_2_0" value="1" >   بريسكول </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_1']==1){echo " checked ";} ?>  name="app11_2_1" value="1" > رياض الاطفال </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_2']==1){echo " checked ";} ?>  name="app11_2_2" value="1" >    الابتدائي الصغير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_3']==1){echo " checked ";} ?>  name="app11_2_3" value="1" >   الابتدائي كبير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_4']==1){echo " checked ";} ?>  name="app11_2_4" value="1" >   الاعدادي </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_5']==1){echo " checked ";} ?>  name="app11_2_5" value="1" >   الثانوي </div>
                       </div>
                     
 
                       <div class="form-group app  "    > 
                          <label class="col-sm-3 control-label"  >  حذف الواجبات</label>
                          <div class="col-sm-1" style="padding-top: 5px;">   </div>  
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_6']==1){echo " checked ";} ?>  name="app11_2_6" value="1" >   بريسكول </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_7']==1){echo " checked ";} ?>  name="app11_2_7" value="1" > رياض الاطفال </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_8']==1){echo " checked ";} ?>  name="app11_2_8" value="1" >    الابتدائي الصغير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_9']==1){echo " checked ";} ?>  name="app11_2_9" value="1" >   الابتدائي كبير </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_10']==1){echo " checked ";} ?>  name="app11_2_10" value="1" >   الاعدادي </div>
                          <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app11_2"  <?php if($row_get_users_info['app11_2_11']==1){echo " checked ";} ?>  name="app11_2_11" value="1" >   الثانوي </div>
                       </div>
                       <hr>

                     <div class="form-group app  "   > 
                        <label class="col-sm-3 control-label"  >         الخطة الاسبوعية   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app12" class="app_btn " <?php if($row_get_users_info['app12']==1){echo " checked ";} ?> name="app12" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_0']==1){echo " checked ";} ?>  name="app12_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_1']==1){echo " checked ";} ?>  name="app12_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_2']==1){echo " checked ";} ?>  name="app12_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_3']==1){echo " checked ";} ?>  name="app12_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_4']==1){echo " checked ";} ?>  name="app12_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app12"  <?php if($row_get_users_info['app12_5']==1){echo " checked ";} ?>  name="app12_5" value="1" >   الثانوي </div>
                     </div>



 

                     <div class="form-group app  "   > 
                        <label class="col-sm-3 control-label"  >  التقيم   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app13" class="app_btn " <?php if($row_get_users_info['app13']==1){echo " checked ";} ?> name="app13" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13"  <?php if($row_get_users_info['app13_1']==1){echo " checked ";} ?>  name="app13_1" value="1" > انشاء تقيم </div> 
                           
                    </div>    

                    <div class="form-group app  "   > 
                        <label class="col-sm-3 control-label"  > متابعة التقيم </label> 
                        <div class="col-sm-1" style="padding-top: 5px;">  </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_0']==1){echo " checked ";} ?>  name="app13_1_0" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_1']==1){echo " checked ";} ?>  name="app13_1_1" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_2']==1){echo " checked ";} ?>  name="app13_1_2" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_3']==1){echo " checked ";} ?>  name="app13_1_3" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_4']==1){echo " checked ";} ?>  name="app13_1_4" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app13_2"  <?php if($row_get_users_info['app13_1_5']==1){echo " checked ";} ?>  name="app13_1_5" value="1" >   الثانوي </div>
                     </div>


                     <hr>

                     <div class="form-group app  "   > 
                        <label class="col-sm-3 control-label"  >  الكنترول   </label>
						            <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app19" class="app_btn " <?php if($row_get_users_info['app19']==1){echo " checked ";} ?> name="app19" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app19"  <?php if($row_get_users_info['app19_1']==1){echo " checked ";} ?>  name="app19_1" value="1" >   رصدالدرجات </div> 
                           
                    </div>




 </div>


                       
						<div class="form-group"> 
						    <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                  <input type="hidden" name="id" value="<?php echo $row_get_users_info['id'];?>" />
                </div> 

                <div class="col-sm-2">  
                  <a href="teacher-subjects.php?id=<?php echo $row_get_users_info['id'];?>" class="btn btn-primary btn-block"  ><i class="fa fa-graduation-cap" aria-hidden="true" ></i> تدريس</a> 
                </div> 
              
                 <?php
                   if (!function_exists('helalia_phone_is_taken')) {
                     require_once('includes/phone-unique.php');
                   }
                   $canCreateApp = (app_check($row_get_users_info['id']) == 0)
                     && !helalia_phone_is_taken($database, $row_get_users_info['phone'], array(
                       'exclude_emp_id' => (int) $row_get_users_info['id'],
                       'exclude_app_login_emp_id' => (int) $row_get_users_info['id'],
                     ));
                   if ($canCreateApp) { ?>
                 <div class="col-sm-2">   
                     <a href="create-app.php?id=<?php echo $row_get_users_info['id'];?>"  <?php if($row_get_users_info['phone']==NULL){echo " disabled ";}?> class="btn btn-primary btn-block"  ><i class="fa fa-mobile" aria-hidden="true"></i> انشاء حساب</a> 
                 </div> 
                 <?php }?>
 
               
                <div class="col-sm-2">  
                  <a href="emp-all-vac.php?id=<?php echo $row_get_users_info['id'];?>" class="btn btn-primary btn-block"  ><i class="fa fa-list-alt" aria-hidden="true" ></i> اجازات</a> 
                </div> 

                <div class="col-sm-2">  
                  <a href="emp-all-exc.php?id=<?php echo $row_get_users_info['id'];?>" class="btn btn-primary btn-block"  ><i class="fa fa-hourglass-start" aria-hidden="true" ></i> اذون</a> 
                </div> 

               <div class="col-sm-2"> 
<a href="edit-emp.php?del=<?php echo $row_get_users_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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



        $('#form1').on('blur', '#username', function (event) { 
			  // event.preventDefault();  
			  var email = $("#username").val();  
			  $.post("check_email.php",
          {
            email:email
          },
            function(Date,status){  
                 if(Date>0){
                    $("#email_check").fadeIn();  
                    $("#submit").attr('disabled', 'disabled');
                 }else{
                    $("#email_check").fadeOut();   
                    $("#submit").removeAttr("disabled");
                  } 
            }); 
        });


      $('#form1').on('change', '#job', function (event) {   
			  var id = $("#job").val();  
			  $.post("job_access.php",
			    {
             id:id
		      },
            function(Date,status){  
            $("#appaccess").html(Date);  
			   }); 
	    });
      




<?php for($i=1;$i<20;$i++){?> 

 $("#app<?php echo $i;?>").click(function(){
  if($(this).is(":checked")){
      $(".app<?php echo $i;?>").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app<?php echo $i;?>").each(function(){ 
         $(this).prop( "checked", false );
      });
    } 
  });



$(".app<?php echo $i;?>").click(function(){
  $("#app<?php echo $i;?>").prop( "checked", true );
  var count = 0;
  $(".app<?php echo $i;?>").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app<?php echo $i;?>").prop( "checked", false ); }
});

<?php } ?>



$("#app11_2").click(function(){
  if($(this).is(":checked")){
      $(".app11_2").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app11_2").each(function(){ 
         $(this).prop( "checked", false );
      });
    } 
  });



$(".app11_2").click(function(){
  $("#app11_2").prop( "checked", true );
  var count = 0;
  $(".app11_2").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app11_2").prop( "checked", false ); }
});


$("#app13").click(function(){
  if($(this).is(":checked")){
       $(".app13_2").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app13_2").each(function(){ 
         $(this).prop( "checked", false );
      });
    } 
  });



  $(".app13").click(function(){
  $("#app13").prop( "checked", true );
  var count = 0;
  $(".app13").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  $(".app13_2").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app13").prop( "checked", false ); }
});



$("#app13_2").click(function(){
  if($(this).is(":checked")){
    $("#app13").prop( "checked", true );
      $(".app13_2").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app13_2").each(function(){ 
         $(this).prop( "checked", false );
      });
    } 
  });



$(".app13_2").click(function(){
  $("#app13").prop( "checked", true );
  var count1 = 0;
  var count2 = 0;
  $(".app13").each(function(){ 
         if($(this).is( ":checked" )){ count1++;} 
  });
  $(".app13_2").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count1==0){$("#app13_2").prop( "checked", false ); }
  if((count1+count2)==0){$("#app13").prop( "checked", false ); }
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

		 
		  
 
	          
		  
		  
		  
	<?php if(isset($_GET['done'])){?>	  
		  Command: toastr["success"](" تم التعديل بنجاح") 
		  
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
		  
	  });
	  </script>
  </body>
 
</html>

    <?php }else{header("location: home.php");exit();}?>