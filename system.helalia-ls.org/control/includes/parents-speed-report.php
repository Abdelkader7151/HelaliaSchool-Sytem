<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10sub1']==1){

 


    if(isset($_GET['from']) && isset($_GET['to'])){
          $from = strtotime($_GET['from']);
          $to = strtotime($_GET['to'].' 23:59:59'); 
        }else{  
            $from = strtotime(date("Y-m-1",time()));
            $to = strtotime(date("Y-m-t 23:59:59", time()));
        }
  
            mysqli_select_db($database, $database_database); 
            $query_get_question = "SELECT `teacher_id`, COUNT(*) AS `total_replies` 
                FROM `ask_teacher`
                WHERE `reply` IS NOT NULL AND `status` = 1 AND `date`>='{$from}' AND `date` <='{$to}'
                GROUP BY `teacher_id`
                ORDER BY `total_replies` DESC
            "; 
            $get_question = mysqli_query($database, $query_get_question) or die(mysqli_error($database));
            $row_get_question = mysqli_fetch_assoc($get_question);
            $totalRows_get_question = mysqli_num_rows($get_question);



 
 

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
                <h4>تقرير سرعة الرد        
                        <br> <span style="color:brown; font-size:14px">من: <?php echo date("d/m/Y",$from);?> - الي: <?php echo date("d/m/Y",$to);?></span></h>
 


    <div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form  method="GET" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
                        <label class="col-sm-3 control-label" for="from">  من <span style="color: red;">*</span></label>
                        <div class="col-sm-3">
                            <input id="from" class="form-control" required type="date" name="from">
                        </div>
					   
                        <label class="col-sm-1 control-label" for="to">  الي <span style="color: red;">*</span></label>
                        <div class="col-sm-3">
                            <input id="to" class="form-control" required type="date" name="to">
                        </div>
 
                            <div class="col-sm-1"> 
                                <button type="submit" class="btn btn-primary btn-block"  ><i class="fa fa-search" aria-hidden="true"></i> </button> 
                            </div> 
                        </div>  
						
					</form>
				  </div>
				</div>
		    </div>



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
                        <th class="text-center">متوسط وقت الرد  </th>  
                        <th class="text-center">الردود  </th>  
                        <th class="text-center">اكثر من ٢٤س  </th>    
                        <th class="text-center">اقل من ٢٤س  </th>
                        <th class="text-center">اقل من ٢س  </th>
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_question>0){
	                           do{  
                                if(emp_name($row_get_question['teacher_id'])!=NULL){ ?>
                      <tr> 
                         <td><a href="questions-speed-report-view.php?id=<?php echo $row_get_question['teacher_id'].'&from='.$from.'&to='.$to;?>" style="color:blue"><?php echo emp_name($row_get_question['teacher_id']); ?></a></td> 
                         <td class="text-center"><?php  
                            $query_get_respond = "SELECT AVG(`respond` - `date`) AS `avg_response_seconds` FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `respond` > 0 AND `teacher_id` = '{$row_get_question['teacher_id']}'  AND `date`>='{$from}' AND `date` <='{$to}'";
                            $get_respond = mysqli_query($database, $query_get_respond) or die(mysqli_error($database));
                            $row_get_respond = mysqli_fetch_assoc($get_respond); 

                            $secs = $row_get_respond['avg_response_seconds'];
                            if ($secs === null) {
                                echo 'N/A';
                            } else {
                                $secs = (int) round($secs);
                                if ($secs < 60) {
                                    echo $secs . 's';
                                } else {
                                    // show as H:i:s for durations >= 1 minute
                                    echo gmdate('H:i:s', $secs);
                                }
                            }
                            ?></td>
                        <td class="text-center"><?php echo $row_get_question['total_replies'];?></td>   
 
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>

                        <td class="text-center"> </td>

                      </tr>
                      <?php } }while($row_get_question = mysqli_fetch_assoc($get_question));} ?> 
                     
                     
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
			     "aTargets": [ 6 ]  
			   }
			 ]
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>