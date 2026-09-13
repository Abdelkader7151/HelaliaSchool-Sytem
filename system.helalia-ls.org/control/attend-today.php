<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access6sub5']==1){
    
    $today = strtotime(date("m/d/Y",time()));

mysqli_select_db($database, $database_database);  
if(isset($_GET['id'])){
  $query_get_att_today = "SELECT * FROM `attendance_log` WHERE `emp_id` = '{$_GET['id']}' AND `date` = '{$today}'  "; 
}else{
  $query_get_att_today = "SELECT * FROM `attendance_log` WHERE`date` = '{$today}' "; 
} 
$get_att_today = mysqli_query($database,$query_get_att_today) or die(mysqli_error($database));
$row_get_att_today = mysqli_fetch_assoc($get_att_today);
$totalRows_get_att_today = mysqli_num_rows($get_att_today);
 



 

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
                <h4> عرض حضور يوم <?php echo date("d/m/Y",$today); ?>  
            <br>
            <?php if(isset($_GET['id'])){ emp_name($row_get_att_today['emp_id']); }?>
        </h4>  
            </div>
          </div>
         
			<div class="row"> 
				<div class="col-md-12"> 
        <div class="card">   
                <div class="card-body" data-toggle="match-height" > 
                <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <?php if(!isset($_GET['id'])){?>
                        <th class="text-left" >الاسم  </th> 
                        <th class="text-center" >كود  </th> 
                        <?php }?>
                        <th class="text-center">الوظيفة</th>
                        <th class="text-center">ميعاد</th>
                        <th class="text-center">حضور</th>
                       <!-- <th class="text-center">ميعاد</th>
                        <th class="text-center">انصراف</th>--> 
                        <th class="text-center"> تاخير</th> 
                        <!--<th class="text-center"> انصراف باكر</th> 
                        <th class="text-center">ساعات العمل</th>-->
                        <th class="text-center">اذن</th>     
                        <th class="text-center">اليوم</th>     
                      </tr>
                    </thead>
                    <tbody>
						
					<?php if($totalRows_get_att_today>0){
            $late_in = 0; 
	                   do{ $check_exc = NULL;  ?>
                      <tr class="count"> 
                        <?php if(!isset($_GET['id'])){?>  
                        <td class="text-left" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><a href="attend-all.php?id=<?php echo $row_get_att_today['emp_id'];?>" style="color:blue"><?php echo emp_name($row_get_att_today['emp_id']); ?></a></td>  
                        <td class="text-left" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><a href="attend-all.php?id=<?php echo $row_get_att_today['emp_id'];?>" style="color:blue"><?php echo $row_get_att_today['exp_id']; ?></a></td>  
                        <?php }?>
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php if($row_get_att_today['emp_id']>0){echo job_name(emp_job($row_get_att_today['emp_id']));} ?></td>  


                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php if($row_get_att_today['absent']==0){ echo date("H:i",$row_get_att_today['on_duty']); }?></td>  
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php if($row_get_att_today['absent']==0 && $row_get_att_today['sign_in']!=NULL){ echo date("H:i",$row_get_att_today['sign_in']); }else{echo "-";}?></td>  
                        <!--<td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0){ echo date("H:i",$row_get_att_today['off_duty']); }?></td> 
                        <td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0 && $row_get_att_today['sign_out']!=NULL){ echo date("H:i",$row_get_att_today['sign_out']); }else{echo "-";}?></td>-->  
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" >
                          <?php $check_exc = check_exc($row_get_att_today['date'],$row_get_att_today['emp_id']);
                           if($row_get_att_today['absent']==0){ //echo gmdate("H:i", $row_get_att_today['late_in']); 
                               if($check_exc!=1){ if($row_get_att_today['late_in']==420){echo "DAY"; $late_in +=(420*60);}else{echo  $row_get_att_today['late_in']; $late_in +=$row_get_att_today['late_in'];}  }
                           }else{ echo " غياب ";}?>?>
                        </td>  
                        <!--<td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0){ echo gmdate("H:i",$row_get_att_today['late_out']); }?></td> 
                        <td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0){ echo gmdate("H:i",$row_get_att_today['att_time']); }?></td>  --> 
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php echo check_delay($check_exc); ?></td>  
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php echo date("d/m/Y",$row_get_att_today['date']);?></td>  
                     </tr>
                    <?php }while($row_get_att_today = mysqli_fetch_assoc($get_att_today));} ?>  
                     
                    </tbody>
                  </table>


                </div>

                <?php if(isset($_GET['id'])){ 
                  echo " <h3> اجمالي تاخيرات ".SPRINTF("%d:%02d", ABS((int)($late_in/60)), ABS((int)($late_in%60)))." ساعة</h3>"; 
                 }?>
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
            ] 
        }); 
 
        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>