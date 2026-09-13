<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access16']==1 && access_Cert($row_get_login['id'],$_GET['id'])==1){


    
mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `certificate` WHERE `study_year` = '{$_GET['id']}' AND `type` = '{$_GET['type']}'  ORDER BY `id` DESC  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);

mysqli_select_db($database, $database_database);  
$query_get_head = "SELECT * FROM `certificate` WHERE `study_year` = '{$_GET['id']}' AND `type` = '{$_GET['type']}'  ORDER BY `id` DESC  "; 
$get_head = mysqli_query($database,$query_get_head) or die(mysqli_error($database));
$row_get_head = mysqli_fetch_assoc($get_head);
$totalRows_get_head = mysqli_num_rows($get_head);


 
  
function class_name2($id){ 
  global $database;
    $query_get_data = "SELECT `name` FROM `class` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($row_get_data['name']==0){ return 'جميع الفصول';} else{return $row_get_data['name'];}
}
    
function name_ed($id){ 
  global $database;
    $query_get_data = "SELECT `name` FROM `kids` where `ed_id`='{$id}'";
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
  <style>
    th{padding-left: 0px !important; padding-right: 0px !important;}
    td{padding-left: 0px !important; padding-right: 0px !important;}
  </style>
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
                <h4> عرض   اعمال السنة  <?php echo $row_get_class_info['title'];?>
                <br>
                المرحلة  <?php echo year_of_study($row_get_class_info['study_year']);?> 
                <br>
                <?php echo class_name2($row_get_data['class']);?>     </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 14px">
                    <thead>
                     <tr style="font-size: 12px;">  
                        <th class="text-left">الاسم  </th>    
                        <th class="text-center">الرقم التعليمي  </th>    
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
                        <?php if($row_get_head['subject16_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject16_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject17_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject17_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject18_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject18_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject19_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject19_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject20_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject20_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject21_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject21_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject22_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject22_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject23_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject23_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject24_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject24_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject25_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject25_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject26_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject26_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject27_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject27_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject28_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject28_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject29_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject29_name'];?></th><?php }?>  
                        <?php if($row_get_head['subject30_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject30_name'];?></th><?php }?>  
                        <th class="text-center">ولي الامر</th>  
                      </tr>
                    </thead>
                     <tbody>
                      <tr>
                        <th class="text-left" >    </th>    
                        <th class="text-center" >اجمالب الدرجة  </th>    
                        <?php if($row_get_head['subject1_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject1_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject2_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject2_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject3_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject3_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject4_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject4_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject5_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject5_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject6_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject6_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject7_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject7_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject8_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject8_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject9_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject9_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject10_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject10_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject11_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject11_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject12_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject12_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject13_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject13_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject14_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject14_phases_total'];?></th><?php }?> 
                        <?php if($row_get_head['subject15_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject15_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject16_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject16_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject17_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject17_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject18_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject18_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject19_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject19_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject20_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject20_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject21_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject21_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject22_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject22_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject23_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject23_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject24_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject24_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject25_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject25_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject26_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject26_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject27_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject27_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject28_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject28_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject29_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject29_phases_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject30_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject30_phases_total'];?></th><?php }?>  
                        <th class="text-center">   </th>  
                      </tr> 
 
						<?php if($totalRows_get_class_info>0){
	                           do{   ?>
                      <tr> 
                            <td class="text-left"><?php echo name_ed($row_get_class_info['gov_id']);?></td>
                            <td class="text-center"><?php echo $row_get_class_info['gov_id'];?></td>
                            
                            <?php if($row_get_head['subject1_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject1_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject2_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject2_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject3_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject3_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject4_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject4_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject5_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject5_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject6_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject6_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject7_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject7_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject8_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject8_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject9_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject9_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject10_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject10_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject11_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject11_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject12_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject12_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject13_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject13_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject14_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject14_phases'];?></td><?php }?> 
                            <?php if($row_get_head['subject15_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject15_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject16_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject16_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject17_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject17_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject18_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject18_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject19_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject19_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject20_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject20_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject21_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject21_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject22_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject22_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject23_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject23_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject24_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject24_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject25_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject25_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject26_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject26_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject27_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject27_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject28_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject28_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject29_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject29_phases'];?></td><?php }?>  
                            <?php if($row_get_head['subject30_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject30_phases'];?></td><?php }?>  
                            <td class="text-center"><?php if($row_get_class_info['viewed']>0){echo date("d/m/Y h:i",$row_get_class_info['viewed']);}?></td>
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
            "sScrollX": "100%",
            "sScrollXInner": "110%",
            "bScrollCollapse": true,
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