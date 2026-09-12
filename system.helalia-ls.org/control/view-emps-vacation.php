<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access6sub5']==1){


  if(isset($_GET['del'])){     
    $deleteSQL = sprintf("DELETE FROM `emps_vacations` WHERE `id`=%s ",
                       GetSQLValueString($database,$_GET['del'], "int"));

            mysqli_select_db($database, $database_database);  
            $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
            header("location: home.php"); 
            exit(); 
    } 


$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("UPDATE `emps_vacations` SET `status`=%s WHERE `id`=%s ", 
                       GetSQLValueString($database,$_POST['status'], "int"),  
                       GetSQLValueString($database,$_POST['id'], "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
        header("location: view-emps-vacation.php?id=".$_POST['id']."&done"); 
        exit(); 
	} 
 
  mysqli_select_db($database, $database_database); 
  $query_get_emps_vacations = "SELECT * FROM `emps_vacations`  where `id`='{$_GET['id']}'";
  $get_emps_vacations = mysqli_query($database,$query_get_emps_vacations) or die(mysqli_error($database));
  $row_get_emps_vacations = mysqli_fetch_assoc($get_emps_vacations);
  $totalRows_get_emps_vacations = mysqli_num_rows($get_emps_vacations);

  if($totalRows_get_emps_vacations<1){header("location: home.php");exit();}

$head_title = "  الاجازات";
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
                <h4> عرض اجازة     </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="view-emps-vacation.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  الاسم  </label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" readonly type="text" style=" background-color:white" name="name" value="<?php echo emp_name($row_get_emps_vacations['emp_id']);?>">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="job">  الوظيفة  </label>
                        <div class="col-sm-4">
                            <input id="job" class="form-control" readonly type="text" name="job" style=" background-color:white" value="<?php echo job_name(emp_job($row_get_emps_vacations['emp_id']));?>">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">  النوع  </label>
                        <div class="col-sm-3">
                            <input id="name" class="form-control" readonly type="text" style=" background-color:white" name="name" value="<?php echo vac_type($row_get_emps_vacations['type']);?>">
                        </div>
                    </div> 


                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="job">  من  </label>
                        <div class="col-sm-2">
                            <input id="start" class="form-control" readonly type="text" name="start" style=" background-color:white" value="<?php echo date("d/m/Y",$row_get_emps_vacations['vacation_start']);?>">
                        </div>
              
                        <label class="col-sm-1 control-label" for="job">  الي  </label>
                        <div class="col-sm-2">
                            <input id="end" class="form-control" readonly type="text" name="end" style=" background-color:white" value="<?php echo date("d/m/Y",$row_get_emps_vacations['vacation_end']);?>">
                        </div>

                        <label class="col-sm-1 control-label" for="job">  المدة  </label>

                        <div class="col-sm-2">
                            <input id="end" class="form-control" readonly type="text" name="end" style=" background-color:white; text-align:center" value="<?php echo vac_days($row_get_emps_vacations['vacation_start'],$row_get_emps_vacations['vacation_end']);?>">
                        </div>
                     </div> 
					  
            
                     <div class="form-group">
                        <label class="col-sm-3 control-label" for="text">  الوصف  </label>
                        <div class="col-sm-6">
                          <textarea readonly  class="form-control"  style=" background-color:white; resize:none" ><?php echo $row_get_emps_vacations['text'];?></textarea>
                        </div>
                    </div> 



                      <div class="form-group">
						<label class="col-sm-3 control-label" for="status"> الحالة </label>
						<div class="col-sm-4">
                        <select class="form-control" required name="status" id="status" >
                            <option selected disabled >...</option> 
                            <option value="0" <?php if($row_get_emps_vacations['status']==0){echo " selected ";}?>> معلق</option> 
                            <option value="1" <?php if($row_get_emps_vacations['status']==1){echo " selected ";}?>> مقبول</option> 
                            <option value="2" <?php if($row_get_emps_vacations['status']==2){echo " selected ";}?>> مرفوض</option> 
                            <option value="3" <?php if($row_get_emps_vacations['status']==3){echo " selected ";}?>> ملغي</option> 
                        </select>
						</div>
                      </div> 
                      
                      
 
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="submit"> </label>
                    <div class="col-sm-2"> 
                    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                    </div> 
                    <div class="col-sm-5"> </div> 
                    <div class="col-sm-2"> 
                    <a href="view-emps-vacation.php?del=<?php echo $_GET['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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
    
  
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>