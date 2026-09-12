<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access8sub3']==1){


    

   if(isset($_GET['reset'])){  
        $insertSQL1 = sprintf("UPDATE `app_login` SET `password`=%s WHERE `id`=%s ", 
                           GetSQLValueString($database,md5('123456'), "text"), 
                           GetSQLValueString($database,$_GET['id'], "int"));
    
           mysqli_select_db($database, $database_database);   
           $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
 
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


            if(isset($_GET['del'])){  
              $insertSQL1 = sprintf("DELETE from `app_login` WHERE `id`=%s ",  
                                 GetSQLValueString($database,$_GET['del'], "int"));
          
                 mysqli_select_db($database, $database_database);   
                 $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
  
   
                  header("location: all-app-accounts.php"); 
                  exit(); 
              } 



    if(isset($_POST['submit'])){  
        $insertSQL1 = sprintf("UPDATE `app_login` SET `name`=%s, `email`=%s, `phone`=%s, `gender`=%s  WHERE `id`=%s ", 
                           GetSQLValueString($database,$_POST['name'], "text"), 
                           GetSQLValueString($database,$_POST['email'], "text"),
                           GetSQLValueString($database,$_POST['phone'], "text"), 
                           GetSQLValueString($database,$_POST['gender'], "int"), 
                           GetSQLValueString($database,$_POST['id'], "int"));
    
           mysqli_select_db($database, $database_database);   
           mysqli_query($database,$insertSQL1) or die(mysqli_error($database));  
             
            header("location: edit-app-account.php?id=".$_POST['id']."&done"); 
            exit(); 
        } 
 
        

 
    mysqli_select_db($database, $database_database); 
    $query_get_app_info = "SELECT * FROM `app_login` where `id`='{$_GET['id']}'  ";
    $get_app_info = mysqli_query($database,$query_get_app_info) or die(mysqli_error($database));
    $row_get_app_info = mysqli_fetch_assoc($get_app_info);
    $totalRows_get_app_info = mysqli_num_rows($get_app_info);

  if($totalRows_get_app_info<1){header("location: all-app-accounts.php"); exit();}

 

  mysqli_select_db($database, $database_database); 
  $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id`='{$_GET['id']}'  ";
  $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
  $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
  $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

  
  mysqli_select_db($database, $database_database); 
  $query_get_data_form = "SELECT * FROM `data_form` where `app_id`='{$_GET['id']}'  ";
  $get_data_form = mysqli_query($database,$query_get_data_form) or die(mysqli_error($database));
  $row_get_data_form = mysqli_fetch_assoc($get_data_form);
  $totalRows_get_data_form = mysqli_num_rows($get_data_form);


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
                <input id="phone" class="form-control" required type="text" name="phone"   value="<?php echo $row_get_app_info['phone'];?>">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="gender">  النوع </label>
              <div class="col-sm-6">
                  <select id="gender" class="form-control" required   name="gender"  >
                     <option value="" <?php if($row_get_app_info['gender']==null){echo " selected ";} ?> ></option>
                     <option value="1" <?php if($row_get_app_info['gender']==1){echo " selected ";} ?> >ذكر</option>
                     <option value="2" <?php if($row_get_app_info['gender']==2){echo " selected ";} ?> >انثى</option> 
                  </select> 
              </div>
            </div>  
          

						
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="submit"> </label>
						  <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-danger btn-block"  ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ   </button>
                            <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>" />
                        </div> 
                        
                        

                        <div class="col-sm-3"> 
                            <a href="edit-app-accounts.php?id=<?php echo $_GET['id'];?>&reset" class="btn btn-danger btn-block" ><i class="fa fa-key" aria-hidden="true"></i>  اعدة تعين كلمة السر   </a> 
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