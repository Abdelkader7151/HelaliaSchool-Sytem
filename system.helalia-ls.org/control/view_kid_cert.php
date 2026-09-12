<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10']==1){


    
mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `certificate` WHERE `id` = '{$_GET['id']}'  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);

mysqli_select_db($database, $database_database);  
$query_get_head = "SELECT * FROM `certificate`  WHERE `id` = '{$_GET['id']}' "; 
$get_head = mysqli_query($database,$query_get_head) or die(mysqli_error($database));
$row_get_head = mysqli_fetch_assoc($get_head);
$totalRows_get_head = mysqli_num_rows($get_head);


 
  
function class_name2($id){ 
    $query_get_data = "SELECT `name` FROM `class` where `id`='{$id}'";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($row_get_data['name']==0){ return 'جميع الفصول';} else{return $row_get_data['name'];}
}
    
function name_gov($id){ 
    $query_get_data = "SELECT `name` FROM `kids` where `gov_id`='{$id}'";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['name']; 
}
    


$head_title = "    النتائج";
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

                <h4> <?php echo name_gov($row_get_class_info['gov_id']);?>
                
                <br> <br> 

                عرض  نتيجة  <?php echo $row_get_class_info['title_arb'];?>
                <br>
                المرحلة  <?php echo year_of_study($row_get_class_info['study_year']);?> 
                 
                
            </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  >
                <table class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 14px">
                    <thead>
                     <tr style="font-size: 12px;">     
                        <?php if($row_get_head['subject1_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject1_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject2_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject2_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject3_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject3_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject4_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject4_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject5_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject5_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject6_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject6_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject7_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject7_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject8_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject8_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject9_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject9_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject10_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject10_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject11_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject11_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject12_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject12_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject13_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject13_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject14_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject14_name'];?></th><?php }?> 
                        <?php if($row_get_head['subject15_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject15_name'];?></th><?php }?>  
                      </tr>
                      <tr> 
                        <?php if($row_get_head['subject1_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject1_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject2_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject2_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject3_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject3_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject4_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject4_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject5_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject5_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject6_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject6_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject7_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject7_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject8_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject8_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject9_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject9_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject10_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject10_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject11_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject11_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject12_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject12_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject13_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject13_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject14_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject14_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject15_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject15_total'];?></th><?php }?>  
                      </tr> 
                    </thead>
                     <tbody>
                      
 
						<?php if($totalRows_get_class_info>0){
	                           do{   ?>
                      <tr>  
                            <?php if($row_get_head['subject1_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject1'];?></td><?php }?> 
                            <?php if($row_get_head['subject2_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject2'];?></td><?php }?> 
                            <?php if($row_get_head['subject3_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject3'];?></td><?php }?> 
                            <?php if($row_get_head['subject4_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject4'];?></td><?php }?> 
                            <?php if($row_get_head['subject5_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject5'];?></td><?php }?> 
                            <?php if($row_get_head['subject6_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject6'];?></td><?php }?> 
                            <?php if($row_get_head['subject7_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject7'];?></td><?php }?> 
                            <?php if($row_get_head['subject8_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject8'];?></td><?php }?> 
                            <?php if($row_get_head['subject9_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject9'];?></td><?php }?> 
                            <?php if($row_get_head['subject10_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject10'];?></td><?php }?> 
                            <?php if($row_get_head['subject11_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject11'];?></td><?php }?> 
                            <?php if($row_get_head['subject12_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject12'];?></td><?php }?> 
                            <?php if($row_get_head['subject13_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject13'];?></td><?php }?> 
                            <?php if($row_get_head['subject14_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject14'];?></td><?php }?> 
                            <?php if($row_get_head['subject15_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject15'];?></td><?php }?>  
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
            } 
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>