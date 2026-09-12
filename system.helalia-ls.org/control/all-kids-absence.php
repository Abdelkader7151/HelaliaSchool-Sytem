<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub5']==1){

  
  if(isset($_GET['accept']) && $row_get_login['access7sub7']==1){

    $updateSQL = sprintf("UPDATE `kids-absence` SET `accept`=%s, `accept_user`=%s WHERE `id`=%s  ", 
                            GetSQLValueString($database,1, "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,$_GET['accept'], "int"));

    mysqli_select_db($database, $database_database);   
    $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));  

}



  $start = strtotime('1/1/2024');


if(isset($_POST['submit'])){ 
mysqli_select_db($database, $database_database);   
$query_get_users_info = "SELECT * FROM `kids-absence` WHERE `date`>'{$start}' AND `confirm` = 1 order by `id` desc";   
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
if($totalRows_get_users_info>0){
  do{
    if(isset($_POST['check_'.$row_get_users_info['id']]) && $_POST['check_'.$row_get_users_info['id']]==1){
      $updateSQL = sprintf("UPDATE `kids-absence` SET `accept`=%s, `accept_user`=%s WHERE `id`=%s  ", 
            GetSQLValueString($database,1, "int"),
            GetSQLValueString($database,$row_get_login['id'], "int"),
            GetSQLValueString($database,$row_get_users_info['id'], "int")); 
      $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));   
    } 
  }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));
}}








mysqli_select_db($database, $database_database);   
$query_get_users_info = "SELECT * FROM `kids-absence` WHERE `date`>'{$start}' AND `confirm` = 1 order by `id` desc";   
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
 
 

$head_title = "  غياب الطلبة";
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
                <h4>عرض غياب الطلبة    <i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color:#ed1e26;" id="loading"></i>   </h4>  
            </div>
          </div>
         
			<div class="row">  
              <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <form method="post"    enctype="multipart/form-data" class="form form-horizontal">
 
                <button type="submit" name="submit" class="btn btn-danger  " style="float: right; padding:4px; margin-left:10px; background-color:#ed1e26" >  تاكيد <i class="fa fa-check-square-o" aria-hidden="true"></i></button> 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"   >الاسم  </th> 
                        <th class="text-center">المرحلة</th>
                        <th class="text-center">الفصل</th>
                        <th class="text-center">  اليوم</th>  
                        <th class="text-center">  النوع</th>  
                        <th class="text-center">  استلام ولي الامر</th> 
                        <th class="text-center"> التسوية</th> 
                        <th class="text-left" width="50"></th> 
                        <th class="text-center">قبول الغياب</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{
                               if(kid_name($row_get_users_info['kid_id'])!=NULL){ ?>
                      <tr class="count"> 
                        <td class="text-left"><a href="view-kid.php?id=<?php echo $row_get_users_info['kid_id'];?>" style="color:blue"><?php echo kid_name($row_get_users_info['kid_id']);?></a></td>  
                        <td class="text-center"><?php echo year_of_study(kid_study_year($row_get_users_info['kid_id']));?></td>  
                        <td class="text-center"><?php echo class_name(kid_class($row_get_users_info['kid_id']));?></td> 
                        <td class="text-center"><?php echo date("d/m/Y",$row_get_users_info['date']);?></td>  
                        <td class="text-center"><?php echo kid_vac_title(kid_vac_type($row_get_users_info['date'],$row_get_users_info['kid_id']));?></td>  
                        <td class="text-center"><?php if(kid_app($row_get_users_info['kid_id'])>0){ if($row_get_users_info['parent_view']!=null){echo date("d/m/Y h:iA",$row_get_users_info['parent_view']);}}else{echo " غير مسجل";}?></td> 
                        <td class="text-center"><?php if(vacation_check($row_get_users_info['date'],$row_get_users_info['kid_id'])==1){echo "<span style='color: green;'>تم التسوية</span>"; echo sick_note($row_get_users_info['id']); }else{echo "<span style='color: red;'>  غير مبرر</span>";}?></td>    
                        <td class="text-left">
                          <?php if($row_get_users_info['confirm']==1 && $row_get_users_info['accept']==0 && $row_get_login['access7sub7']==1){?>
                          <input type="checkbox" name="check_<?php echo $row_get_users_info['id'];?>" value="1" />
                          <?php } if($row_get_users_info['confirm']==1 && $row_get_users_info['accept']==1){echo "  تم القبول بواسطة   (".users_name($row_get_users_info['accept_user']).emp_name($row_get_users_info['app_user']).")";} ?></td>    
                         <td class="text-center">
                          <?php if($row_get_users_info['confirm']==1 && $row_get_users_info['accept']==0 && $row_get_login['access7sub7']==1){?>
                          <a href="all-kids-absence.php?accept=<?php echo $row_get_users_info['id'];?>" class="btn btn-success btn-block" onclick="return confirm('تاكيد القبول؟');" >قبول</a>
                       <?php } if($row_get_users_info['confirm']==1 && $row_get_users_info['accept']==1){echo "  تم القبول بواسطة   (".users_name($row_get_users_info['accept_user']).emp_name($row_get_users_info['app_user']).")";} ?></td>    
                      </tr>
                     
                      <?php } }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?>   
                    </tbody>
                  </table>
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
               { "bSortable": false 
			       
			   }
			 ]
        }); 
          
         
      $("#loading").fadeOut();



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>