<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access6sub5']==1){



//if(isset($_GET['update'])){
 // mysqli_select_db($database, $database_database); 
 // $query_get_data = "SELECT `id`,`exp_id` FROM `attendance_log` WHERE `emp_id` IS NULL";
  //$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
  //$row_get_data = mysqli_fetch_assoc($get_data);
 /// $totalRows_get_data = mysqli_num_rows($get_data);  
  //if($totalRows_get_data>0){
  //  do{
  //    mysqli_select_db($database, $database_database); 
  //    $query_get_data2 = "SELECT `id` FROM `emps` WHERE `ext_id` ='{$row_get_data['exp_id']}' ";
    //  $get_data2 = mysqli_query($database,$query_get_data2) or die(mysqli_error($database));
    //  $row_get_data2 = mysqli_fetch_assoc($get_data2);
     // $totalRows_get_data2 = mysqli_num_rows($get_data2); 
     // mysqli_query($database,"UPDATE `attendance_log` SET  `emp_id` ='{$row_get_data2['id']}' WHERE `id` = '{$row_get_data['id']}' "); 
   // }while($row_get_data = mysqli_fetch_assoc($get_data));
  //}
  //header("location: attend-all.php");
  //exit();
//}







    
  if(isset($_POST['submit'])){
    $start = strtotime($_POST['from']);
    $end = strtotime($_POST['to']); 
    $late = " AND `late_in` = '{$_POST['late']}' ";
    if($_POST['late']=='1260'){$late = " AND `late_in` IS NULL ";} 
    if($_POST['late']==-1){$late = " ";} 
  }else{ 
    $firstDay = new \DateTime('first day of this month');
    $lastDay = new \DateTime('last day of this month');
    $start = strtotime($firstDay->format('Y-m-d'));
    $end = strtotime($lastDay->format('Y-m-d'));
    $late = '';
 }
 

mysqli_select_db($database, $database_database);  
if(isset($_GET['id'])){
  $query_get_att_today = "SELECT * FROM `attendance_log` WHERE `emp_id` = '{$_GET['id']}'  AND `date`>='{$start}' AND `date`<='{$end}'  $late"; 
}else{ 
  $query_get_att_today = "SELECT * FROM `attendance_log` WHERE `date`>='{$start}' AND `date`<'{$end}' $late "; 
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
                <h4> عرض حضور والانصراف لفترة 
                  من
                  <?php echo date("d/m/Y",$start); ?>  
                الي 
                <?php echo date("d/m/Y",$end); ?> 

            <br>
            <strong>  <?php if(isset($_GET['id'])){ echo "<br>".emp_name($_GET['id']); }?></strong>
        </h4>  
            </div>
          </div>
         
			<div class="row"> 
				<div class="col-md-12"> 
          
        <form action="attend-all.php<?php if(isset($_GET['id'])){?>?id=<?php echo $_GET['id'];}?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    


            <div class="form-group">
              <label class="col-sm-2 control-label" for="link">  من <span style="color: red;">*</span></label>
              <div class="col-sm-3">
                  <input type="date" name="from" class="form-control"  required    > 
              </div>

              <label class="col-sm-2 control-label" for="link">  الي <span style="color: red;">*</span></label>
              <div class="col-sm-3">
                  <input type="date" name="to" class="form-control"  required   > 
              </div>

          
              <div class="col-sm-2">
                 <button type="submit" name="submit" class="btn btn-primary" >عرض</button> 
              </div>
           </div> 
                      

           <div class="form-group">
              <label class="col-sm-2 control-label" for="link">  تاخير  </label>
              <div class="col-sm-2">
                <select name="late" class="form-control"  >
                  <option value="-1">...</option>
                  <option value="0"   <?php if(isset($_POST['late']) && $_POST['late']==0){echo " selected ";} ?> >لا يوجد</option>
                  <option value="4"   <?php if(isset($_POST['late']) && $_POST['late']==4){echo " selected ";} ?> >جميع</option>
                  <option value="5"   <?php if(isset($_POST['late']) && $_POST['late']==5){echo " selected ";} ?> >5</option>
                  <option value="10"  <?php if(isset($_POST['late']) && $_POST['late']==10){echo " selected ";} ?> >10</option>
                  <option value="15"  <?php if(isset($_POST['late']) && $_POST['late']==15){echo " selected ";} ?> >15</option>
                  <option value="420" <?php if(isset($_POST['late']) && $_POST['late']==420){echo " selected ";} ?> >يوم</option>
                  <option value="1260" <?php if(isset($_POST['late']) && $_POST['late']==1260){echo " selected ";} ?> >غياب</option>
                </select> 
              </div>

            
           
           </div> 
        </form>


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
	                           do{ $check_exc = NULL; ?>
                      <tr class="count"> 
                        <?php if(!isset($_GET['id'])){?>  
                        <td class="text-left" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><a href="attend-all.php?id=<?php echo $row_get_att_today['emp_id'];?>" style="color:blue"><?php echo emp_name($row_get_att_today['emp_id']); ?></a></td>  
                        <td class="text-left" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><a href="attend-all.php?id=<?php echo $row_get_att_today['emp_id'];?>" style="color:blue"><?php echo $row_get_att_today['exp_id']; ?></a></td>  
                        <?php }?>
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php echo job_name(emp_job($row_get_att_today['emp_id'])); ?></td>  


                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php if($row_get_att_today['absent']==0){ echo date("H:i",$row_get_att_today['on_duty']); }?></td>  
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php if($row_get_att_today['absent']==0 && $row_get_att_today['sign_in']!=NULL){ echo date("H:i",$row_get_att_today['sign_in']); }else{echo "-";}?></td>  
                        <!--<td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0){ echo date("H:i",$row_get_att_today['off_duty']); }?></td> 
                        <td class="text-center" style="<?php //if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" ><?php //if($row_get_att_today['absent']==0 && $row_get_att_today['sign_out']!=NULL){ echo date("H:i",$row_get_att_today['sign_out']); }else{echo "-";}?></td>-->  
                        <td class="text-center" style="<?php if($row_get_att_today['absent']==1 && $row_get_att_today['exception']==0){echo " color:red";}?>" >
                          <?php $check_exc = check_exc($row_get_att_today['date'],$row_get_att_today['emp_id']);
                           if($row_get_att_today['absent']==0){ //echo gmdate("H:i", $row_get_att_today['late_in']); 
                               if($check_exc!=1){ if($row_get_att_today['late_in']==420){echo "DAY"; $late_in +=(420*60);}else{echo  $row_get_att_today['late_in']; $late_in +=$row_get_att_today['late_in'];}  }
                           }else{ echo " غياب ";}?>
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
      fixedHeader: true,		
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
                [<?php if(isset($_GET['id'])){echo "5";}else{echo "7";}?>, "asc"]
            ] 
        }); 
 
        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>