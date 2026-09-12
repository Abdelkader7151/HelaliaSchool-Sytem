<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access3sub4']==1){

mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `subjects` where `id` = '{$_GET['id']}' "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);
 

mysqli_select_db($database, $database_database);  
$query_get_teachers = "SELECT `teachers`.* , (SELECT `name` FROM `emps` WHERE `id`=`teachers`.emp_id) AS `emp_name`, (SELECT `name` FROM `class` where `id`=`teachers`.class) AS `class_name`, (SELECT `name` FROM `subjects` where `id`=`teachers`.subject) AS `subject_name`  FROM `teachers`    order by  `study_year`  ASC "; 
$get_teachers = mysqli_query($database,$query_get_teachers) or die(mysqli_error($database));
$row_get_teachers = mysqli_fetch_assoc($get_teachers);
$totalRows_get_teachers = mysqli_num_rows($get_teachers);

$head_title = "    المواد الدراسية";
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
                <h4>عرض المدرسين  </h4>
                <h4 style="padding-right: 30px;"><?php echo $row_get_class_info['name'];?> </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-left">اسم المدرس</th>  
                        <th class="text-left">  المرحلة</th> 
                        <th class="text-left">  الفصل</th>
                        <th class="text-left">  المادة</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_teachers>0){
	                           do{ 
                              if($row_get_teachers['emp_name']==NULL){  
                                    $deleteSQL = sprintf("DELETE FROM `teachers` WHERE `id`=%s ",
                                              GetSQLValueString($database,$row_get_teachers['id'], "int"));
                                    mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
                                  }else{ ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_teachers['emp_name'];  ?></td>
                        <td class="text-left"><?php echo year_of_study($row_get_teachers['study_year']);?></td> 
                        <td class="text-left"><?php echo $row_get_teachers['class_name']; ?></td> 
                        <td class="text-left"><?php echo $row_get_teachers['subject_name'];?></td>    
                      </tr>
                      <?php   }}while($row_get_teachers = mysqli_fetch_assoc($get_teachers));} ?> 
                     
                     
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
          
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>