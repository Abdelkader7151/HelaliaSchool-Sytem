<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access16']==1 && access_Cert($row_get_login['id'],$_GET['id'])==1){

    
  if(isset($_GET['active'])){ 
          $updateSQL = sprintf("UPDATE `certificate` SET `active`=1 WHERE `id`=%s ",
                         GetSQLValueString($database,$_GET['active'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));
          header("location: view_cert.php?id={$_GET['id']}&type={$_GET['type']}"); 
          exit(); 
  }
  
  if(isset($_GET['hide'])){ 
          $updateSQL = sprintf("UPDATE `certificate` SET `active`=0 WHERE `id`=%s ",
                         GetSQLValueString($database,$_GET['hide'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));
          header("location: view_cert.php?id={$_GET['id']}&type={$_GET['type']}"); 
          exit();
  } 



    
mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `certificate` WHERE `study_year` = '{$_GET['id']}' AND `type` = '{$_GET['type']}' ORDER BY `id` DESC  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);

mysqli_select_db($database, $database_database);  
$query_get_head = "SELECT * FROM `certificate` WHERE `study_year` = '{$_GET['id']}'  AND `type` = '{$_GET['type']}'  ORDER BY `id` DESC  "; 
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
    .card-body { overflow-x: auto; }
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
                <h4> عرض   نتائج  <?php echo $row_get_class_info['title'];?>
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
                        <th class="text-left" style="width: 10%;">الاسم  </th>    
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
                        <th class="text-center">   </th>  
                      </tr>
                    </thead>
                     <tbody>
                      <tr> 
                         <th class="text-left" >    </th>   
                         <th class="text-left" >    </th>
                       
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
                        <?php if($row_get_head['subject16_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject16_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject17_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject17_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject18_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject18_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject19_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject19_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject20_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject20_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject21_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject21_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject22_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject22_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject23_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject23_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject24_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject24_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject25_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject25_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject26_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject26_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject27_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject27_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject28_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject28_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject29_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject29_total'];?></th><?php }?>  
                        <?php if($row_get_head['subject30_name']!=NULL){?><th class="text-center"><?php echo $row_get_head['subject30_total'];?></th><?php }?>  
                        <th class="text-center">   </th>  
                        <th class="text-center">   </th>  
                      </tr> 
 
						<?php if($totalRows_get_class_info>0){
	                           do{   ?>
                      <tr> 
                            <td class="text-left"><?php echo name_ed($row_get_class_info['gov_id']);?></td>
                            <td class="text-center"><?php echo $row_get_class_info['gov_id'];?></td>
                            
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
                            <?php if($row_get_head['subject16_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject16'];?></td><?php }?>  
                            <?php if($row_get_head['subject17_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject17'];?></td><?php }?>  
                            <?php if($row_get_head['subject18_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject18'];?></td><?php }?>  
                            <?php if($row_get_head['subject19_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject19'];?></td><?php }?>  
                            <?php if($row_get_head['subject20_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject20'];?></td><?php }?>  
                            <?php if($row_get_head['subject21_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject21'];?></td><?php }?>  
                            <?php if($row_get_head['subject22_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject22'];?></td><?php }?>  
                            <?php if($row_get_head['subject23_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject23'];?></td><?php }?>  
                            <?php if($row_get_head['subject24_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject24'];?></td><?php }?>  
                            <?php if($row_get_head['subject25_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject25'];?></td><?php }?>  
                            <?php if($row_get_head['subject26_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject26'];?></td><?php }?>  
                            <?php if($row_get_head['subject27_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject27'];?></td><?php }?>  
                            <?php if($row_get_head['subject28_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject28'];?></td><?php }?>  
                            <?php if($row_get_head['subject29_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject29'];?></td><?php }?>  
                            <?php if($row_get_head['subject30_name']!=NULL){?><td class="text-center"><?php echo $row_get_class_info['subject30'];?></td><?php }?>  
                            <td class="text-center"><?php if($row_get_class_info['viewed']>0){echo date("d/m/Y h:i",$row_get_class_info['viewed']);}?></td>
                            <td class="text-center">
                              <?php
                              // If this student has دور الثاني (type=4) for the same stage, open that certificate.
                              $round2_cert_id = 0;
                              $q_r2 = mysqli_query(
                                $database,
                                "SELECT `id` FROM `certificate` WHERE `gov_id` = '".mysqli_real_escape_string($database, $row_get_class_info['gov_id'])."' AND `study_year` = '".mysqli_real_escape_string($database, $row_get_class_info['study_year'])."' AND `type` = 4 ORDER BY `id` DESC LIMIT 1"
                              );
                              if ($q_r2 && ($row_r2 = mysqli_fetch_assoc($q_r2))) {
                                $round2_cert_id = intval($row_r2['id']);
                              }

                              if ($round2_cert_id > 0 || intval($row_get_class_info['type']) === 4) {
                                $print_id = $round2_cert_id > 0 ? $round2_cert_id : intval($row_get_class_info['id']);
                              ?>
                                 <a href="view_cert_round2_print.php?id=<?php echo $print_id;?>" target="_blank" class="btn btn-info btn-sm">عرض الشهادة</a>
                              <?php }elseif($row_get_class_info['study_year']<5){?>
                                 <a href="view_cert_small.php?id=<?php echo $row_get_class_info['id'];?>" target="_blank" class="btn btn-info btn-sm">عرض الشهادة</a>
                              <?php }else{?>
                                 <a href="view_cert_big<?php if($row_get_class_info['type']==3){echo "_final";}?>.php?id=<?php echo $row_get_class_info['id'];?>" target="_blank" class="btn btn-info btn-sm">عرض الشهادة</a>
                              <?php }
                             if($row_get_login['id']==1){?>
                                &nbsp; 
                              <?php if($row_get_class_info['active']==0){?><a href="view_cert.php?id=<?php  echo $_GET['id'];?>&type=<?php  echo $_GET['type'];?>&active=<?php  echo $row_get_class_info['id'];?>" class="btn btn-success btn-sm">Active</a><?php  }else{?><a href="view_cert.php?id=<?php echo $_GET['id'];?>&type=<?php  echo $_GET['type'];?>&hide=<?php echo $row_get_class_info['id'];?>" class="btn btn-danger btn-sm">HIDE</a><?php  }
                              } ?>
                              
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
        scrollX: false,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: ['copy', 'pdf', 'print'],
        language: {
            paginate: { previous: "&laquo;", next: "&raquo;" },
            search: "_INPUT_",
            searchPlaceholder: "Search…"
        }
    });
  });
</script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>