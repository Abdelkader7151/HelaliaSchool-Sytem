<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php');   
 require_once('includes/functions.php');   
 //require_once('erros_check.php');   

 if($row_get_login['access10sub3']==1){

$msg ='';
 

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `emps` SET  `app20`=%s,
                                            `app20_1`=%s,
                                            `app20_2`=%s,
                                            `app20_3`=%s, `app20_3_1`=%s, `app20_3_2`=%s, `app20_3_3`=%s, `app20_3_4`=%s, `app20_3_5`=%s, `app20_3_6`=%s,
                                            `app20_4`=%s, `app20_4_1`=%s, `app20_4_2`=%s, `app20_4_3`=%s, `app20_4_4`=%s, `app20_4_5`=%s, `app20_4_6`=%s,
                                            `app20_5`=%s, `app20_5_1`=%s, `app20_5_2`=%s, `app20_5_3`=%s, `app20_5_4`=%s, `app20_5_5`=%s, `app20_5_6`=%s,
                                            `app20_6`=%s, `app20_6_1`=%s, `app20_6_2`=%s, `app20_6_3`=%s, `app20_6_4`=%s, `app20_6_5`=%s, `app20_6_6`=%s,
                                            `app20_7`=%s, `app20_7_1`=%s, `app20_7_2`=%s, `app20_7_3`=%s, `app20_7_4`=%s, `app20_7_5`=%s, `app20_7_6`=%s,
                                            `app20_8`=%s,
                                            `def`=%s
                                      WHERE `id` = %s",  
                               GetSQLValueString($database,isset($_POST['app20'])?1:0, "int"),
                               GetSQLValueString($database,isset($_POST['app20_1'])?1:0, "int"),
                               GetSQLValueString($database,isset($_POST['app20_2'])?1:0, "int"),

                               GetSQLValueString($database,isset($_POST['app20_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_1'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_2'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_3_6'])?1:0, "int"),
                              
                                GetSQLValueString($database,isset($_POST['app20_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_1'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_2'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_4_6'])?1:0, "int"),  
   
                               GetSQLValueString($database,isset($_POST['app20_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_1'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_2'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_5_6'])?1:0, "int"),  
  
                               GetSQLValueString($database,isset($_POST['app20_6'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_1'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_2'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_6_6'])?1:0, "int"),       
                                
                               GetSQLValueString($database,isset($_POST['app20_7'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_1'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_2'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_3'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_4'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_5'])?1:0, "int"),
                                 GetSQLValueString($database,isset($_POST['app20_7_6'])?1:0, "int"),       
                              GetSQLValueString($database,isset($_POST['app20_8'])?1:0, "int"),       
                             
                               GetSQLValueString($database, $_POST['def'], "int"), 
                               GetSQLValueString($database,$_POST['id'], "int"));

             mysqli_query($database,$insertSQL) or die(mysqli_error($database));  
 
			header("location: emp-parents-settings.php?id=".$_GET['id']."&updated"); 
			exit(); 
  } 
  
 
 
    mysqli_select_db($database, $database_database); 
    $query_get_users_info = "SELECT * FROM `emps` where `id`='{$_GET['id']}'  ";
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);

 

$head_title = "  رسائل من اولياء الامور";
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
                <h4> تعديل صلاحيات الرد     </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-10">
				  <div class="demo-form-wrapper">
                    <form action="emp-parents-settings.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
                        <div class="col-sm-3">
                            <input  class="form-control" type="text" readonly value="<?php echo $row_get_users_info['name'];?>">
                        </div>
                        </div>  
                        
                        <div class="form-group">
                        <label class="col-sm-3 control-label" for="phone">   الهاتف  <span style="color: red;">*</span> </label>
                        <div class="col-sm-2">
                            <input   class="form-control" type="text"   readonly maxlength="11" minlength="11" value="<?php echo $row_get_users_info['phone'];?>">
                            <small style="color: red;"><?php if(app_phone($row_get_users_info['phone'])==1){echo "  يوجد  حساب   "; if(app_phone2($row_get_users_info['phone'],$row_get_users_info['id'])!=1){echo " اخر ";} echo " مسجل برقم الهاتف";}?></small>
                        </div> 
                        </div>  
                    

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="job"> الوظيفة  <span style="color: red;">*</span></label>
                            <div class="col-sm-2">
                                    <input  class="form-control" type="text" readonly value="<?php echo job_name($row_get_users_info['job']);?>"> 
                            </div>
                        </div>  
 
<hr>

    
            <div class="form-group  " >   
                    
            <label class="col-sm-3 control-label "  style="font-weight: bold; font-size:20px" >     صلاحيات الرد على استفسارات الاباء</label>
	          </div>
                     

                    <div class="form-group app  "    >  
                          <label class="col-sm-4 control-label" style="font-size:14px"  >    </label> 
                          <div class="col-sm-1" style="padding-top: 5px; font-size:16px  ">   <input type="checkbox"  class="app_btn  "  <?php if($row_get_users_info['app20']==1){echo " checked ";} ?>    name="app20" value="1" > تعديل الرد </div>  
                          <div class="col-sm-1" style="padding-top: 5px; font-size:16px  ">   <input type="checkbox"  class="app_btn  "  <?php if($row_get_users_info['app20_8']==1){echo " checked ";} ?>    name="app20_8" value="1" >   تقارير </div>  
                      
                    </div>


                   <div class="form-group app  "    >    
                          <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==1){echo " checked ";} ?>    name="def" value="1" > مدير المدرسة </label><!-- 10001 --> 
                          <div class="col-sm-1" style="padding-top: 5px; font-size:14px">    <input type="checkbox"  class="app_btn  "  <?php if($row_get_users_info['app20_1']==1){echo " checked ";} ?>  name="app20_1" value="1" >  </div> <!-- 10001 -->   
                      
                    </div>


                   <div class="form-group app  "    >    
                          <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==2){echo " checked ";} ?>    name="def" value="2" >  الطبيب </label>       
                          <div class="col-sm-1" style="padding-top: 5px; font-size:14px">    <input type="checkbox"  class="app_btn  "  <?php if($row_get_users_info['app20_2']==1){echo " checked ";} ?>  name="app20_2" value="1" >  </div>  
                      
                    </div>
                   
 
                        

                    <div class="form-group app  " style="padding-top: 20px;"    > 
                          
                        <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==3){echo " checked ";} ?>    name="def" value="3" > رئيس القسم </label>      
						            <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  id="app20_3" class="app_btn " <?php if($row_get_users_info['app20_3']==1){echo " checked ";} ?> name="app20_3" value="1" > </div> 
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_1']==1){echo " checked ";} ?>  name="app20_3_1" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_2']==1){echo " checked ";} ?>  name="app20_3_2" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_3']==1){echo " checked ";} ?>  name="app20_3_3" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_4']==1){echo " checked ";} ?>  name="app20_3_4" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_5']==1){echo " checked ";} ?>  name="app20_3_5" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_3"  <?php if($row_get_users_info['app20_3_6']==1){echo " checked ";} ?>  name="app20_3_6" value="1" >   الثانوي </div> 
                    </div>


                    <div class="form-group app  " style="padding-top: 20px;"    >  
                        <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==4){echo " checked ";} ?>    name="def" value="4" >نائب القسم </label>      
						            <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  id="app20_4" class="app_btn " <?php if($row_get_users_info['app20_4']==1){echo " checked ";} ?> name="app20_4" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_1']==1){echo " checked ";} ?>  name="app20_4_1" value="1" >   بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_2']==1){echo " checked ";} ?>  name="app20_4_2" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_3']==1){echo " checked ";} ?>  name="app20_4_3" value="1" >    الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_4']==1){echo " checked ";} ?>  name="app20_4_4" value="1" >   الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_5']==1){echo " checked ";} ?>  name="app20_4_5" value="1" >   الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_4"  <?php if($row_get_users_info['app20_4_6']==1){echo " checked ";} ?>  name="app20_4_6" value="1" >   الثانوي </div> 
                    </div>


                    
                   <div class="form-group app  " style="padding-top: 20px;"    > 
                         
                        <label class="col-sm-3 control-label" style="font-size:14px"  ><input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==5){echo " checked ";} ?>    name="def" value="5" >  سكرتير   </label><!-- 10004 -->
						            <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox" id="app20_5" class="app_btn " <?php if($row_get_users_info['app20_5']==1){echo " checked ";} ?> name="app20_5" value="1" > </div> 
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_1']==1){echo " checked ";} ?>  name="app20_5_1" value="1" >  بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_2']==1){echo " checked ";} ?>  name="app20_5_2" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_3']==1){echo " checked ";} ?>  name="app20_5_3" value="1" > الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_4']==1){echo " checked ";} ?>  name="app20_5_4" value="1" > الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_5']==1){echo " checked ";} ?>  name="app20_5_5" value="1" > الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_5"  <?php if($row_get_users_info['app20_5_6']==1){echo " checked ";} ?>  name="app20_5_6" value="1" > الثانوي </div> 
                    </div>



     
                   <div class="form-group app  " style="padding-top: 20px;"    > 
                         
                        <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==6){echo " checked ";} ?>    name="def" value="6" > معالج نفسي   </label> <!-- 10006 -->
						            <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox" id="app20_6" class="app_btn " <?php if($row_get_users_info['app20_6']==1){echo " checked ";} ?> name="app20_6" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_1']==1){echo " checked ";} ?>  name="app20_6_1" value="1" >  بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_2']==1){echo " checked ";} ?>  name="app20_6_2" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_3']==1){echo " checked ";} ?>  name="app20_6_3" value="1" > الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_4']==1){echo " checked ";} ?>  name="app20_6_4" value="1" > الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_5']==1){echo " checked ";} ?>  name="app20_6_5" value="1" > الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_6"  <?php if($row_get_users_info['app20_6_6']==1){echo " checked ";} ?>  name="app20_6_6" value="1" > الثانوي </div> 
                    </div>
                      
                    <div class="form-group app  " style="padding-top: 20px;"    > 
                           
                        <label class="col-sm-3 control-label" style="font-size:14px"  > <input type="radio"  class="app_btn  "  <?php if($row_get_users_info['def']==7){echo " checked ";} ?>    name="def" value="7" >  مراجع منسق   </label> <!-- 10007 -->
						            <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox" id="app20_7" class="app_btn " <?php if($row_get_users_info['app20_7']==1){echo " checked ";} ?> name="app20_7" value="1" > </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_1']==1){echo " checked ";} ?>  name="app20_7_1" value="1" >  بريسكول </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_2']==1){echo " checked ";} ?>  name="app20_7_2" value="1" > رياض الاطفال </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_3']==1){echo " checked ";} ?>  name="app20_7_3" value="1" > الابتدائي الصغير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_4']==1){echo " checked ";} ?>  name="app20_7_4" value="1" > الابتدائي كبير </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_5']==1){echo " checked ";} ?>  name="app20_7_5" value="1" > الاعدادي </div>
                        <div class="col-sm-1" style="padding-top: 5px; font-size:14px">   <input type="checkbox"  class="app_btn app20_7"  <?php if($row_get_users_info['app20_7_6']==1){echo " checked ";} ?>  name="app20_7_6" value="1" > الثانوي </div> 
                    </div>
                      


                     
 
                       
			    <div class="form-group"> 
				 <div class="col-sm-2 col-sm-offset-3"> 
                  <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" style="font-size: 14px;" ><i class="fa fa-floppy-o" id="saveIcon" aria-hidden="true"></i>  حفظ <i class="fa fa-spinner fa-spin  fa-fw" id="loading" style="display: none;"></i></button> 
                  <input type="hidden" name="id" value="<?php echo $row_get_users_info['id'];?>" />
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


        $("#form1").submit(function(){
            $("#saveIcon").fadeOut();
            $("#loading").show();
        });
  

<?php for($i=1;$i<8;$i++){ ?> 

 $("#app20_<?php echo $i;?>").click(function(){
  if($(this).is(":checked")){
      $(".app20_<?php echo $i;?>").each(function(){ 
          $(this).prop( "checked", true );
      });
  }else{
      $(".app20_<?php echo $i;?>").each(function(){ 
         $(this).prop( "checked", false );
      });
    } 
  });



$(".app20_<?php echo $i;?>").click(function(){
  $("#app20_<?php echo $i;?>").prop( "checked", true );
  var count = 0;
  $(".app20_<?php echo $i;?>").each(function(){ 
         if($(this).is( ":checked" )){ count++;} 
  });
  if(count==0){$("#app20_<?php echo $i;?>").prop( "checked", false ); }
});

<?php } ?>

 
		  
 
	          
		  
		  
		  
	<?php if(isset($_GET['updated'])){?>	  
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
  "hideDuration": "10000",
  "timeOut": "5000",
  "extendedTimeOut": "10000",
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