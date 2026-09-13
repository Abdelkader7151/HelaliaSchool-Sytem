<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access2sub2']==1){

mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `classgroup` order by `study_year` asc  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);
 
 

$head_title = "  مجموعات التقوية";
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
                <h4>عرض جميع مجموعات التقوية  </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        
                        <th class="text-center">المرحلة</th> 
                        <th class="text-left">المادة  </th> 
                        <th class="text-left">المدرس  </th>
                        <th class="text-center">الطالبات  </th> 
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_class_info>0){
	                           do{  ?>
                      <tr>  
                        <td class="text-center"><?php echo year_of_study($row_get_class_info['study_year']);?></td>  
                        <td class="text-left"><?php echo subject_name($row_get_class_info['subject']);?></td> 
                        <td class="text-left"><?php echo emp_name($row_get_class_info['emp_id']);?></td> 
                        <td class="text-center"><?php echo group_kid_count($row_get_class_info['id']);?></td> 
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                <?php if($row_get_login['access2sub3']==1){?>
                <li><a href="edit-classgroup.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i>  تعديل </a></li>
                <li><a href="cancel-classgroup.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-ban" aria-hidden="true" style="color: red"></i>  اعتذار </a></li>
               
                <?php } if($row_get_login['access2sub4']==1){?>
                <li><a href="all-classgroup-kids.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-users" aria-hidden="true" style="color: green"></i>  الطلبة </a></li>
                <li><a href="new-classgroup-kid.php?id=<?php echo $row_get_class_info['id'];?>" >  <i class="fa fa-user-plus" aria-hidden="true" style="color: green"></i>  اضافة طالب </a></li>
                <?php } if(group_kid_count($row_get_class_info['id'])<1){?>                  
								<li><a href="edit-classgroup.php?del=<?php echo $row_get_class_info['id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                <?php }?>              
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
			     "aTargets": [ 4 ]  
			   }
			 ]
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>