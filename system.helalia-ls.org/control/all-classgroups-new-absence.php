<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access2sub5']==1){
 
if(isset($_GET['del'])){  

  $insertSQL1 = sprintf("DELETE FROM `group_absence` where `id`=%s ",
                          GetSQLValueString($database,$_GET['del'], "int"));

      mysqli_select_db($database, $database_database);   
      $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));  
      header("location: all-classgroups-new-absence.php");
      exit();
}


 
  $day = strtotime(date("m/d/Y",time()));

mysqli_select_db($database, $database_database);    
$query_get_users_info = "SELECT * FROM `group_absence` WHERE `day`='{$day}'   ";   
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
 
 

$head_title = "  غياب المجموعات";
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
                <h4>عرض غياب المجموعات اليوم     <?php echo date("d/m/Y",$day); ?>    </h4>  
            </div>
          </div>
         
			<div class="row">  
              <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"   >الاسم  </th> 
                        <th class="text-center">المرحلة</th>
                        <th class="text-center">الفصل</th> 
                        <th class="text-center">  المادة</th>  
                        <th class="text-center">       </th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{  ?>
                      <tr class="count"> 
                        <td class="text-left"><a href="view-kid.php?id=<?php echo $row_get_users_info['kid_id'];?>" style="color:blue"><?php echo kid_name($row_get_users_info['kid_id']);?></a></td>  
                        <td class="text-center"><?php echo year_of_study(kid_study_year($row_get_users_info['kid_id']));?></td>  
                        <td class="text-center"><?php echo class_name(kid_class($row_get_users_info['kid_id']));?></td>  
                        <td class="text-center"><?php echo group_subject_name($row_get_users_info['group_id']);?></td>  
                         
                        <td class="text-center"> 
                        <a href="all-classgroups-new-absence.php?del=<?php echo $row_get_users_info['id'];?>" class="btn btn-danger"  onclick="return confirm('تاكيد؟');">حذف <i class="fa fa-trash-o" aria-hidden="true"></i></a> </td>  
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?>   
                    </tbody>
                  </table>


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
               { "bSortable": false,
			     "aTargets": [ 4 ]  
			   }
			 ]
        }); 
          
         
        



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>