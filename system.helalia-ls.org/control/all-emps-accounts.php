<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access6sub2']==1){

mysqli_select_db($database, $database_database);  
$query_get_users_info = "SELECT * FROM `emps` order by `name` asc  "; 
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info); 
 

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
                <h4>عرض جميع الموظفين  </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-left">الاسم  </th> 
                        <th class="text-center">الوظيفة</th> 
                        <th class="text-center">  هاتف</th> 
                        <th class="text-center">البرنامج</th>
                        <th class="text-center">  تليفون الحساب</th>
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_users_info['name'];?></td> 
                        <td class="text-center"><?php echo job_name($row_get_users_info['job']);?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['phone'];?></td>  
                        <td class="text-center"><?php if(app_check($row_get_users_info['id'])>0){echo " مفعل";}?></td> 
                        <td class="text-left">
                       <?php
                        mysqli_select_db($database, $database_database);  
                        $query_get_app_login = "SELECT * FROM `app_login` WHERE `emp_id` = '{$row_get_users_info['id']}' "; 
                        $get_app_login = mysqli_query($database,$query_get_app_login) or die(mysqli_error($database));
                        $row_get_app_login = mysqli_fetch_assoc($get_app_login);
                        $totalRows_get_app_login = mysqli_num_rows($get_app_login); 
                        if($totalRows_get_app_login>0){
                           do{
                            echo $row_get_app_login['phone']."</br>"; 
                           }while($row_get_app_login = mysqli_fetch_assoc($get_app_login));
                        } 
                         ?>
                        </td> 
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                 <?php if($row_get_login['access6sub3']==1){?>
								<li><a href="edit-emp.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i>  تعديل </a></li>
                <?php if(teacher($row_get_users_info['job'])==1){?>
                <li><a href="teacher-subjects.php?id=<?php echo $row_get_users_info['id'];?>" > <i class="fa fa-graduation-cap" aria-hidden="true" style="color: green"></i>  تدريس </a></li>
                <?php }} if($row_get_login['access6sub5']==1){?>
                <li><a href="emp-all-vac.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-list-alt" aria-hidden="true" style="color: green"></i>  اجازات </a></li>
                <?php  } if($row_get_login['access6sub6']==1){?>
                <li><a href="emp-all-exc.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-hourglass-start" aria-hidden="true" style="color: green"></i>  اذون </a></li>
                <?php  } if($row_get_login['access6sub7']==1){?>
                <li><a href="attend-all.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-address-card-o" aria-hidden="true" style="color: green"></i>  الحضور </a></li>
                <?php }?>
 
                                <?php if($row_get_users_info['id']!=1){?>
                              <li role="separator" class="divider"></li> 
								<li><a href="edit-emp.php?del=<?php echo $row_get_users_info['id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                                <?php }?>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?> 
                     
                     
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
            lengthMenu: [
            [ -1  ],
            [  'Show all' ]
              ],
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