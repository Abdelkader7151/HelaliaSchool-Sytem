<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10']==1){


  if(isset($_GET['id'])){$id = GetSQLValueString($database,$_GET['id'], "int");}
  if(isset($_GET['del'])){$id = GetSQLValueString($database,$_GET['del'], "int");}


  mysqli_select_db($database, $database_database); 
  $query_get_app_info = "SELECT * FROM `app_login` where `id`='{$id}'  ";
  $get_app_info = mysqli_query($database,$query_get_app_info) or die(mysqli_error($database));
  $row_get_app_info = mysqli_fetch_assoc($get_app_info);
  $totalRows_get_app_info = mysqli_num_rows($get_app_info);

if($totalRows_get_app_info<1){header("location: all-app-accounts.php"); exit();}


if(isset($_GET['del'])){  


      $insertSQL = sprintf("INSERT INTO `log` ( `user_id`, `app_id`, `app_name`, `app_phone`,`delete`, `date`) VALUES ( %s, %s, %s, %s, %s, %s )", 
                GetSQLValueString($database,$row_get_login['id'], "int"), 
                GetSQLValueString($database,$id, "int"), 
                GetSQLValueString($database,$row_get_app_info['name'], "text"), 
                GetSQLValueString($database,$row_get_app_info['phone'], "text"), 
                GetSQLValueString($database,1, "int"), 
                GetSQLValueString($database,time(), "int"));
   
      $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));

 
     $insertSQL1 = sprintf("DELETE from `app_login` WHERE `id`=%s ",  
                   GetSQLValueString($database,$id, "int"));
 
     mysqli_query($database,$insertSQL1) or die(mysqli_error($database));

     mysqli_select_db($database, $database_database); 
     $query_get_kids_list = "SELECT * FROM `kids_list` WHERE `parent_id`='{$id}'  ";
     $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
     $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
     $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

      if($totalRows_get_kids_list>0){
        do{
            $insertSQL3 = sprintf("UPDATE `kids` SET `linked`= 0 WHERE `id`=%s ",  
                      GetSQLValueString($database,$row_get_kids_list['kid_id'], "int"));
    
            mysqli_query($database,$insertSQL3) or die(mysqli_error($database));   
        }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list)); 
      }

      $insertSQL3 = sprintf("DELETE from `kids_list` WHERE `parent_id`=%s ",  
            GetSQLValueString($database,$id, "int"));

      mysqli_query($database,$insertSQL3) or die(mysqli_error($database));   

      header("location: all-app-accounts.php"); 
      exit(); 
  } 


   if(isset($_GET['reset'])){  
        $insertSQL1 = sprintf("UPDATE `app_login` SET `password`=%s WHERE `id`=%s ", 
                           GetSQLValueString($database,md5(123456), "text"), 
                           GetSQLValueString($database,$_GET['id'], "int"));
    
           mysqli_select_db($database, $database_database);   
           $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
 
            header("location: edit-app-account.php?id=".$_GET['id']."&done"); 
            exit(); 
        } 


        
   if(isset($_GET['reset_phone'])){  
        $insertSQL1 = sprintf("UPDATE `app_login` SET `phone_id`=%s WHERE `id`=%s ", 
                       GetSQLValueString($database,NULL, "text"), 
                               GetSQLValueString($database,$_GET['id'], "int"));
    
            mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
 
            header("location: edit-app-account.php?id=".$_GET['id']."&done"); 
            exit(); 
        } 

    if(isset($_GET['remove'])){  
        $insertSQL1 = sprintf("DELETE from `kids_list` WHERE `kid_id`=%s ",  
                            GetSQLValueString($database,$_GET['remove'], "int"));
    
            mysqli_select_db($database, $database_database);   
            $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));


        $insertSQL2 = sprintf("UPDATE `kids` SET `linked`= 0 WHERE `id`=%s ",  
                    GetSQLValueString($database,$_GET['remove'], "int"));

        mysqli_select_db($database, $database_database);   
        $Result2 = mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 

            header("location: edit-app-account.php?id=".$_GET['id']."&done"); 
            exit(); 
        } 



   

            if(isset($_POST['submit'])){  
              $insertSQL1 = sprintf("UPDATE `app_login` SET `name`=%s, `email`=%s,  `gender`=%s  WHERE `id`=%s ", 
                                 GetSQLValueString($database,$_POST['name'], "text"), 
                                 GetSQLValueString($database,$_POST['email'], "text"), 
                                 GetSQLValueString($database,$_POST['gender'], "int"), 
                                 GetSQLValueString($database,$_POST['id'], "int"));
          
                 mysqli_select_db($database, $database_database);   
                 mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
                     
if($row_get_app_info['account_type']==1){

                 $image_name = $_POST['old_picture'];
                 include("includes/img-up-welaya_copy.php");
                 if($image_name!=$_POST['old_picture']){ unlink("../uploads/".$_POST['old_picture']);} 

      
                 $insertSQL2 = sprintf("UPDATE `data_form` SET `father_name`=%s, `father_phone`=%s, `father_gov_id`=%s, `father_job`=%s ,
                                                               `mother_name`=%s, `mother_phone`=%s, `mother_gov_id`=%s, `mother_job`=%s ,
                                                               `whatsapp`=%s, `ed_welaya`=%s, `ed_welaya_copy`=%s, `divorce_living`=%s, `divorce_living_why`=%s, `death`=%s, `emergency_phone`=%s, `emergency_relative`=%s  
                  WHERE `app_id`=%s ", 
                            GetSQLValueString($database,$_POST['father_name'], "text"), 
                            GetSQLValueString($database,$_POST['father_phone'], "text"),
                            GetSQLValueString($database,$_POST['father_gov_id'], "text"), 
                            GetSQLValueString($database,$_POST['father_job'], "text"), 
      
                            GetSQLValueString($database,$_POST['mother_name'], "text"), 
                            GetSQLValueString($database,$_POST['mother_phone'], "text"),
                            GetSQLValueString($database,$_POST['mother_gov_id'], "text"), 
                            GetSQLValueString($database,$_POST['mother_job'], "text"), 
      
                            GetSQLValueString($database,$_POST['whatsapp'], "text"), 
                            GetSQLValueString($database,$_POST['ed_welaya'], "text"), 
                            GetSQLValueString($database,$image_name, "text"), 
                            GetSQLValueString($database,$_POST['divorce_living'], "text"), 
                            GetSQLValueString($database,$_POST['divorce_living_why'], "text"), 
                            GetSQLValueString($database,$_POST['death'], "text"), 
                            GetSQLValueString($database,$_POST['emergency_phone'], "text"), 
                            GetSQLValueString($database,$_POST['emergency_relative'], "text"), 
      
                            GetSQLValueString($database,$_POST['id'], "int"));
      
                  mysqli_select_db($database, $database_database);   
                  mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 
}
                            
                  header("location: edit-app-account.php?id=".$_POST['id']."&done"); 
                  exit(); 
              } 
        
  

              if(isset($_POST['add'])){  

                mysqli_select_db($database, $database_database); 
                $query_get_kids = "SELECT `id` FROM `kids` WHERE `ed_id` = '{$_POST['ed_id']}' AND `linked` = 0 ";
                $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
                $row_get_kids = mysqli_fetch_assoc($get_kids);
                $totalRows_get_kids = mysqli_num_rows($get_kids);
                
                  if($totalRows_get_kids>0){  

                      if($row_get_app_info['account_type']==1){ 

                        mysqli_select_db($database, $database_database); 
                        $query_get_kids_list = "SELECT * FROM `kids_list` WHERE `kid_id` = '{$row_get_kids['id']}' ";
                        $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
                        $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
                        $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

                        if($totalRows_get_kids_list<1){ 

                              $insertSQL = sprintf("INSERT INTO `kids_list` ( `parent_id`, `kid_id` ) VALUES ( %s, %s )", 
                                        GetSQLValueString($database,$_POST['id'], "int"),  
                                        GetSQLValueString($database,$row_get_kids['id'], "int"));
                          
                              mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 

                              $updateSQL = sprintf("UPDATE `kids` SET `linked`=%s WHERE `id`=%s ", 
                                              GetSQLValueString($database,1, "int"), 
                                              GetSQLValueString($database,$row_get_kids['id'], "int"));
      
                              mysqli_query($database,$updateSQL) or die(mysqli_error($database));   
                          }
                        } 
                  }    
                    header("location: edit-app-account.php?id=".$_POST['id']."&done"); 
                    exit(); 
              } 


 

 if($row_get_app_info['account_type']==1){

  mysqli_select_db($database, $database_database); 
  $query_get_data_form = "SELECT * FROM `data_form` where `app_id`='{$_GET['id']}'  ";
  $get_data_form = mysqli_query($database,$query_get_data_form) or die(mysqli_error($database));
  $row_get_data_form = mysqli_fetch_assoc($get_data_form);
  $totalRows_get_data_form = mysqli_num_rows($get_data_form);

 
  mysqli_select_db($database, $database_database); 
  $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id`='{$_GET['id']}'  ";
  $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
  $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
  $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

 }
  


$head_title = "  حساب البرنامج";
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
                <h4> عرض بيانات حساب   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-6">
				  <div class="demo-form-wrapper">
              <form action="edit-app-account.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			     <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم </label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name"   value="<?php echo $row_get_app_info['name'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني </label>
              <div class="col-sm-6">
                <input id="email" class="form-control" required type="text" name="email"   value="<?php echo $row_get_app_info['email'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="phone">  الهاتف </label>
              <div class="col-sm-6">
                <input   class="form-control"  readonly type="text"     value="<?php echo $row_get_app_info['phone'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="gender">  النوع </label>
              <div class="col-sm-6">
                  <select id="gender" class="form-control" required   name="gender"  >
                     <option value="" <?php if($row_get_app_info['gender']==null){echo " selected ";} ?> ></option>
                     <option value="1" <?php if($row_get_app_info['gender']==1){echo " selected ";} ?> >ذكر</option>
                     <option value="2" <?php if($row_get_app_info['gender']==2){echo " selected ";} ?> >انثي</option> 
                  </select> 
              </div>
            </div>  
             

            <div class="form-group">
						  <label class="col-sm-3 control-label" for="submit"> </label> 

                        <div class="col-sm-3"> 
                            <a href="edit-app-account.php?id=<?php echo $_GET['id'];?>&reset" class="btn btn-danger btn-block" ><i class="fa fa-key fa-lg" aria-hidden="true"></i>  اعدة تعين كلمة السر   </a> 
                        </div>
                        <div class="col-sm-3"> 
                             <a href="edit-app-account.php?id=<?php echo $_GET['id'];?>&reset_phone" class="btn btn-danger btn-block" ><i class="fa fa-mobile fa-lg" aria-hidden="true"></i>  اعدة تسجيل الهاتف  </a> 
                        </div> 
            </div>
               
                    <hr>

        <?php if($totalRows_get_data_form>0 && $row_get_app_info['account_type']==1){?>
                    <h3>بيانات الاب</h3> 

        <div class="form-group">
          <label class="col-sm-3 control-label" for="father_name">  الاسم </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="father_name"   value="<?php echo $row_get_data_form['father_name'];?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label" for="father_phone">  رقم تليفون </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="father_phone"   value="<?php echo $row_get_data_form['father_phone'];?>">
          </div>
        </div>


        <div class="form-group">
          <label class="col-sm-3 control-label" for="father_gov_id">    رقم بطاقة او جواز السفر  </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="father_gov_id"   value="<?php echo $row_get_data_form['father_gov_id'];?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label" for="father_job">  الوظيفة   والمؤهل الدراسى </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="father_job"   value="<?php echo $row_get_data_form['father_job'];?>">
          </div>
        </div> 
                        
        <h3>بيانات الام</h3> 


        <div class="form-group">
          <label class="col-sm-3 control-label" for="mother_name">  الاسم </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="mother_name"   value="<?php echo $row_get_data_form['mother_name'];?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label" for="mother_phone">  رقم تليفون </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="mother_phone"   value="<?php echo $row_get_data_form['mother_phone'];?>">
          </div>
        </div>


        <div class="form-group">
          <label class="col-sm-3 control-label" for="mother_gov_id">    رقم بطاقة او جواز السفر  </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="mother_gov_id"   value="<?php echo $row_get_data_form['mother_gov_id'];?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label" for="mother_job">  الوظيفة   والمؤهل الدراسى </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="mother_job"   value="<?php echo $row_get_data_form['mother_job'];?>">
          </div>
        </div>   



        <h3 class="bot-20 sec-tit center white-text" style="color: #455a64 !important">بيانات هامة</h3>


        <div class="form-group">
          <label class="col-sm-3 control-label" for="whatsapp">  واتس اب </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="whatsapp"   value="<?php echo $row_get_data_form['whatsapp'];?>">
          </div>
        </div>

 
            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_welaya">  ولاية تعليمية </label>
              <div class="col-sm-3">
                  <select id="ed_welaya" class="form-control" name="ed_welaya"  >
                     <option value="There is no divorce" <?php if($row_get_data_form['ed_welaya']=="There is no divorce"){echo " selected ";} ?> >لا يوجد طلاق</option>
                     <option value="Father" <?php if($row_get_data_form['ed_welaya']=="Father"){echo " selected ";} ?> >الاب</option>
                     <option value="Mother" <?php if($row_get_data_form['ed_welaya']=="Mother"){echo " selected ";} ?> >الام</option> 
                     <option value="Other" <?php if($row_get_data_form['ed_welaya']=="Other"){echo " selected ";} ?> >آخرى</option> 
                  </select> 
              </div>
              <label class="col-sm-3 control-label ed_welaya_copy" for="ed_welaya" <?php if($row_get_data_form['ed_welaya']!="Other"){echo " style='display:none' ";}?> > <?php if($row_get_data_form['ed_welaya_copy']!=NULL){ ?>
                                         <a href="../uploads/<?php echo $row_get_data_form['ed_welaya_copy'];?>" target="_blank">عرض</a> 
                                         <?PHP }?>  صورة من الولاية التعليمية </label>
              <div class="col-sm-3  ed_welaya_copy"<?php if($row_get_data_form['ed_welaya']!="Other"){echo " style='display:none' ";}?> >  
              <input id="ed_welaya_copy" name="ed_welaya_copy" type="file"   class="form-control"  >
              <input id="old_picture" name="old_picture" type="hidden"   value="<?php echo $row_get_data_form['ed_welaya_copy'];?>"  >
              </div>
            </div>

 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="divorce_living">  فى حالة الانفصال سكن الطالب مع </label>
              <div class="col-sm-3">
                  <select id="divorce_living" class="form-control" name="divorce_living"  >
                     <option value="There is no separation" <?php if($row_get_data_form['ed_welaya']=="There is no separation"){echo " selected ";} ?> >لا يوجد انفصال</option>
                     <option value="Father" <?php if($row_get_data_form['divorce_living']=="Father"){echo " selected ";} ?> >الاب</option>
                     <option value="Mother" <?php if($row_get_data_form['divorce_living']=="Mother"){echo " selected ";} ?> >الام</option> 
                     <option value="Other" <?php if($row_get_data_form['divorce_living']=="Other"){echo " selected ";} ?> >آخرى</option> 
                  </select> 
              </div> 
              
                <div class="col-sm-3  divorce_living_why" <?php if($row_get_data_form['divorce_living']!="Other"){?> style="display:none" <?php }?>> 
                    <input id="divorce_living_why" class="form-control" name="divorce_living_why" type="text"  value="<?php echo $row_get_data_form['divorce_living_why'];?>" > 
                </div>
              
            </div>



            <div class="form-group">
              <label class="col-sm-3 control-label" for="death">  فى حالة الوفاة للوالدين</label>
              <div class="col-sm-3">
                  <select id="death" class="form-control" name="death"  >
                     <option value="No death" <?php if($row_get_data_form['death']=="No death"){echo " selected ";} ?> >لا يوجد وفاة</option>
                     <option value="Father" <?php if($row_get_data_form['death']=="Father"){echo " selected ";} ?> >الاب</option>
                     <option value="Mother" <?php if($row_get_data_form['death']=="Mother"){echo " selected ";} ?> >الام</option> 
                     <option value="Both" <?php if($row_get_data_form['death']=="Both"){echo " selected ";} ?> >الاثنين</option> 
                  </select> 
              </div>  
            </div>


 
        <div class="form-group">
          <label class="col-sm-3 control-label" for="emergency_phone">  رقم تليفون للطوارئ </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="emergency_phone"   value="<?php echo $row_get_data_form['emergency_phone'];?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label" for="emergency_relative">  درجة القرابة </label>
          <div class="col-sm-6">
            <input class="form-control" type="text" name="emergency_relative"   value="<?php echo $row_get_data_form['emergency_relative'];?>">
          </div>
        </div>

 

        <?php }?>

						
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="submit"> </label>
						  <div class="col-sm-2"> 
                  <button type="submit" class="btn btn-danger btn-block"  name="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ   </button>
                  <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>" />
              </div> 
              
						  <label class="col-sm-3 control-label" for="delete"> </label>
						  <div class="col-sm-2">  
                  <a href="edit-app-account.php?del=<?php echo $_GET['id'];?>" class="btn btn-danger btn-block" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash" aria-hidden="true" style="color: white"></i>  حذف </a>
              </div> 
             </div>

            
						
					</form>
				  </div>
                </div>
                <?php if($row_get_app_info['account_type']==1){?>
            <div class="col-md-6">
              <h4>الطلبة المسجلة</h4>
            <div class="card-body" data-toggle="match-height" > 
                <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px; ">
                    <thead> 
                      <tr>   
                        <th class="text-center">   الاسم</th> 
                        <th class="text-center"> السنة  </th>  
                        <th class="text-center"> الفصل  </th>  
                        <th class="text-center"> </th> 
                      </tr>
                    </thead>

                    	
						<?php if($totalRows_get_kids_list>0){
	                           do{  ?>
                      <tr class="count">   
                        <td class="text-center"><?php echo kid_name($row_get_kids_list['kid_id']);?></td> 
                        <td class="text-center"><?php echo year_of_study(kid_study_year($row_get_kids_list['kid_id']));?></td>    
                        <td class="text-center"><?php echo class_name(kid_class($row_get_kids_list['kid_id']));?></td>      
                        <td class="text-center">
                        <a href="view-kid.php?id=<?php echo $row_get_kids_list['kid_id'];?>" class="btn btn-primary" >  <i class="fa fa-eye" aria-hidden="true"></i>  عرض </a>
                        <a href="edit-app-account.php?id=<?php echo $_GET['id'];?>&remove=<?php echo $row_get_kids_list['kid_id'];?>" class="btn btn-primary" >  <i class="fa fa-eye" aria-hidden="true"></i>  حذف </a>
                        </td>
                      </tr>
                      <?php }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list));} ?> 
                     

                    <tbody>  
  
                     
                     
                    </tbody>
                  </table>

                  <h4><i class="fa fa-user-circle-o" aria-hidden="true"></i>  ربط طالب </h4> 

                  <form action="edit-app-account.php?id=<?php echo $_GET['id'];?>" method="post" name="form2" id="form2"  enctype="multipart/form-data" class="form form-horizontal">

                       <div class="form-group">
                          <label class="col-sm-2 control-label" for="ed_id"> الرقم التعليمي  <span style="color: red;">*</span></label>
                          <div class="col-sm-4">
                            <input id="ed_id" class="form-control" type="number" name="ed_id" required> 
                            <p id="ed_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> الرقم  مسجل من قبل </p>
                          </div>
                        </div>

                      <div class="form-group"> 
                        <label class="col-sm-2 control-label" for="add"> </label>
                        <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-danger btn-block"  name="add" id="add" ><i class="fa fa-floppy-o" aria-hidden="true"></i> ربط   </button>
                            <input type="hidden" name="id"   value="<?php echo $_GET['id'];?>" />
                        </div>   
                      </div>

                  </form>


                </div>
             </div>
            <?php }?>




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

      $('#form2').on('blur', '#ed_id', function (event) {   
           var ed = $("#ed_id").val();  
           $.post("check-ed-exist.php",
           {
             ed:ed
           },
               function(Date,status){  
                    if(Date>0){
                       $("#ed_id_warn2").fadeIn();  
                       $("#add").attr('disabled', 'disabled');
                    }else{
                       $("#ed_id_warn2").fadeOut();   
                       $("#add").removeAttr("disabled");
                     } 
            });    
      });
             


      $('#ed_welaya').change(function(){
        var val = $(this).val();
        if(val!="There is no divorce" && val!="Father") { 
           $(".ed_welaya_copy").fadeIn();  
        }else{
           $(".ed_welaya_copy").fadeOut();  
        } 
      });
 
        $('#divorce_living').change(function(){
        var val = $(this).val();
        if(val=="Other") { 
          $(".divorce_living_why").fadeIn(); 
          $("#divorce_living_why").prop('required',true);  
        }else{
            $(".divorce_living_why").fadeOut(); 
           $("#divorce_living_why").val('').prop('required',false); 
        }  
      });



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
          
   


        
	  });
 </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>