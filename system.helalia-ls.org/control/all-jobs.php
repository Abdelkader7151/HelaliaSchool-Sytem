<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access5sub2']==1){

mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `jobs` order by `id` asc  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);
 
 

$head_title = "  الوظائف";
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
                <h4>عرض جميع الوظائف  </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-center">  الوظيفة</th> 
                        <th class="text-center">  تدريس</th> 
                        <th class="text-center">  تجميع غياب  </th> 
                        <th class="text-center">    تاكيد غياب   </th> 
                        <th class="text-center">    توجية استفسارات    </th> 
                        <th class="text-center">   الرد  استفسارات    </th> 
                        <th class="text-center">    غياب المجموعات</th> 
                        <th class="text-center">  غياب العاملين</th> 
                        <th class="text-center">  اذون العاملين</th>  
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_class_info>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_class_info['name'];?></td>  
                        <td class="text-center"><?php if($row_get_class_info['subjects']==1){echo " تدريس";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app1']==1){echo " مصرح";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app6']==1){echo " مصرح";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app2']==1){echo " مصرح";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app7']==1){echo " مصرح";}?></td>
                        <td class="text-center"><?php if($row_get_class_info['app3']==1){echo " مصرح";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app4']==1){echo " مصرح";}?></td> 
                        <td class="text-center"><?php if($row_get_class_info['app5']==1){echo " مصرح";}?></td> 
                        
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                <li><a href="edit-job.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i>  تعديل </a></li>
                <li><a href="all-emps-job.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-users" aria-hidden="true" style="color: green"></i>  الموظفين </a></li>
                                 
                                 <li role="separator" class="divider"></li> 
								<li><a href="edit-class.php?del=<?php echo $row_get_class_info['id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                                
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_class_info = mysqli_fetch_assoc($get_class_info));} ?> 
                     
                     
                    </tbody>
                  </table>
                </div>
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
            dom: 'Bfrtip',
            buttons: [
            'copy',  'pdf', 'print'
        ],
            language: {
                paginate: {
                    previous: "&laquo;",
                    next: "&raquo;"
                },
                search: "_INPUT_",
                searchPlaceholder: "Search…"
            },
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 9 ]  
			   }
			 ]
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>