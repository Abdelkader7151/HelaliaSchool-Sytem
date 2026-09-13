<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10sub1']==1){

mysqli_select_db($database, $database_database);  
$query_get_new_contacts = "SELECT * FROM `ask_teacher` WHERE `status` = 1 ORDER by `id` desc  "; 
$get_new_contacts = mysqli_query($database,$query_get_new_contacts) or die(mysqli_error($database));
$row_get_new_contacts = mysqli_fetch_assoc($get_new_contacts);
$totalRows_get_new_contacts = mysqli_num_rows($get_new_contacts);
 
 

$head_title = "  رسائل من اولياء الامور";
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
                <h4>عرض   الرسائل    </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px; display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; white-space: nowrap;">
                  <thead>
                    <tr> 
                    <th class="text-left">#  </th>  
                    <th class="text-left">الاسم  </th>  
                    <th class="text-left">الطالب  </th>  
                    <th class="text-left">المرحله  </th>  
                    <th class="text-left">الفصل  </th>  
                    <th class="text-left">التوجية  </th>  
                    <th class="text-center"> تاريخ   M/D/Y </th>  
                    <th class="text-center"> توقيت الرد </th> 
                    <th class="text-center">   الموظف </th> 
                    <th class="text-center">   مدة الرد </th> 
                     </tr>
                  </thead>
                  <tbody>
						
						<?php if($totalRows_get_new_contacts>0){
	                           do{ 
                              mysqli_select_db($database, $database_database);  
                              $query_get_kid = "SELECT * FROM `kids` WHERE `id` = '{$row_get_new_contacts['kid_id']}'  "; 
                              $get_kid = mysqli_query($database,$query_get_kid) or die(mysqli_error($database));
                              $row_get_kid = mysqli_fetch_assoc($get_kid);
                              $totalRows_get_kid = mysqli_num_rows($get_kid);
                              ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_new_contacts['id']?></td>  
                        <td class="text-left"><?php echo parent_app($row_get_new_contacts['user_id']);?></td>  
                        <td class="text-left"><?php echo $row_get_kid['fn_name'];?></td>  
                        <td class="text-left"><?php echo year_of_study($row_get_kid['study_year']);?></td>  
                        <td class="text-left"><?php echo class_name($row_get_kid['class']);?></td>  

                        <td class="text-left"><?php echo question_direct($row_get_new_contacts['subject']);?></td>  
                    
                    
                        <td class="text-center"><?php echo date("m/d/Y h:iA",$row_get_new_contacts['date']);?></td>  
                        
                        <td class="text-center"><?php if($row_get_new_contacts['respond']>0){echo date("m/d/Y h:iA",$row_get_new_contacts['respond']);}?></td>  
                        <td class="text-left"><?php echo emp_name($row_get_new_contacts['teacher_id']);?></td>  
                        <td class="text-left">
                          <?php
                          if ($row_get_new_contacts['teacher_id'] != NULL && $row_get_new_contacts['respond'] > 0) {
                            $diff = $row_get_new_contacts['respond'] - $row_get_new_contacts['date'];
                            $days = floor($diff / 86400);
                            $hours = floor(($diff % 86400) / 3600);
                            $minutes = floor(($diff % 3600) / 60);
                            $result = [];
                            if ($days > 0) $result[] = $days . ' يوم';
                            if ($hours > 0) $result[] = $hours . ' ساعة';
                            if ($minutes > 0) $result[] = $minutes . ' دقيقة';
                            echo implode(' ', $result);
                          }
                          ?>
                        </td>
                       
                      </tr>
                      <?php }while($row_get_new_contacts = mysqli_fetch_assoc($get_new_contacts));} ?> 
                     
                     
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
                [0, "desc"]
            ] 
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>