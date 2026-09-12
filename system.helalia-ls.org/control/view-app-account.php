<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access8sub1']==1){

  if(isset($_GET['del'])){    
    $deleteSQL = sprintf("DELETE FROM `kids_list` WHERE `kid_id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));

    $dupdateSQL = sprintf("UPDATE `kids` SET `linked`=0 WHERE `id`=%s ",
            GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result2 = mysqli_query($database,$dupdateSQL) or die(mysqli_error($database));        

            header("location: view-app-account.php?id=".$_GET['id']); 
            exit(); 
    } 
 
    mysqli_select_db($database, $database_database); 
    $query_get_app_info = "SELECT * FROM `app_login` where `id`='{$_GET['id']}'  ";
    $get_app_info = mysqli_query($database,$query_get_app_info) or die(mysqli_error($database));
    $row_get_app_info = mysqli_fetch_assoc($get_app_info);
    $totalRows_get_app_info = mysqli_num_rows($get_app_info);

  if($totalRows_get_app_info<1){header("location: all-app-accounts.php"); exit();}

 
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
              <form action="edit-app-account.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			     <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم </label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name" readonly value="<?php echo $row_get_app_info['name'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني </label>
              <div class="col-sm-6">
                <input id="email" class="form-control" required type="text" name="email" readonly value="<?php echo $row_get_app_info['email'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="phone">  الهاتف </label>
              <div class="col-sm-6">
                <input id="phone" class="form-control" required type="text" name="phone" readonly value="<?php echo $row_get_app_info['phone'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="gender">  النوع </label>
              <div class="col-sm-6">
                <input id="gender" class="form-control" required type="text" name="gender" readonly value="<?php if($row_get_app_info['gender']==1){echo "ذكر";}else{echo "انسة";}?>">
              </div>
            </div>  


            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="type">  الحساب </label>
              <div class="col-sm-6">
                <input id="type" class="form-control" required type="text" name="type" readonly value="<?php if($row_get_app_info['account_type']==2){echo " موظف";}else{echo "ولي امر";}?>">
              </div>
            </div>  
             
						
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="submit"> </label>
						  <div class="col-sm-2"> 
                <a href="edit-app-account.php?id=<?php echo $row_get_app_info['id'];?>" class="btn btn-danger btn-block"  ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> تعديل   </a>
              </div>  
            </div> 
                 
						
					</form>


          <?php if($row_get_app_info['account_type']==1){?>

<div class="col-xs-12">
<h4> بيانات التسجيل</h4>

<form  method="post"  enctype="multipart/form-data" class="form form-horizontal">
                              
                        
            
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
            
  

          </form>
          </div>
<?php }?>

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
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 

                                <li><a href="view-kid.php?id=<?php echo $row_get_kids_list['kid_id'];?>" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a></li>
								                <li role="separator" class="divider"></li> 
								                <li><a href="view-app-account.php?id=<?php echo $_GET['id']."&del=".$row_get_kids_list['kid_id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                                
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list));} ?> 
                     

                    <tbody>  
  
                     
                     
                    </tbody>
                  </table>


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

<?php }else{header("location: home.php");exit();}?>