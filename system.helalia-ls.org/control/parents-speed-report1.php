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
  <style>
    @media print {
      .noprint {
       display: none !important;
      }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <br> <span style="color:brown; font-size:14px">من: <?php echo date("d/m/Y",$from);?> - الي: <?php echo date("d/m/Y",$to);?></span></h4>
 


    <div class="row noprint">
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
      <div class="row" style="width: 100%;   margin: 0 auto; box-sizing: border-box;">
        <style>
          @media print {
            body, html {
              width: 210mm;
              height: 297mm;
              margin: 0;
              padding: 0;
            }
            .row {
              width: 100% !important;
              max-width: 210mm !important;
              margin: 0 !important;
              box-sizing: border-box;
            }
            .card, .card-body, table {
              width: 100% !important;
              max-width: 100% !important;
              box-sizing: border-box;
            }
            table {
              table-layout: fixed;
              word-break: break-word;
            }
            th, td {
              white-space: normal !important;
              word-break: break-word !important;
            }
          }
        </style>
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px; max-width: 100% !important;">
                    <thead>
                      <tr> 
                        <th class="text-left" style="width: 200px;">الاسم  </th>  
                        <th class="text-center">متوسط وقت الرد  </th>  
                        <th class="text-center">الردود  </th>  

                       
                         
                        <th class="text-center">اقل من 12س  </th>
                         <th class="text-center">اقل من 24س  </th>
                         <th class="text-center">اكثر من 24س  </th>    

                        <th class="text-center">    </th>
                         
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_question>0){
	                           do{  
                                
                                if(emp_name($row_get_question['teacher_id'])!=NULL){ ?>
                      <tr> 
                         <td><?php echo emp_name($row_get_question['teacher_id']); ?></td> 
                         <td class="text-center" style="  text-align: center"><?php  
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
                        $days = floor($secs / 86400);
                        $remainder = $secs % 86400;
                        $timeStr = '';
                        if ($days > 0) {
                          $timeStr .= $days . 'Days ';
                        }
                        $timeStr .= gmdate('H:i:s', $remainder);
                        echo trim($timeStr);
                    }
                }
                ?></td>
                        <td class="text-center"><?php echo $row_get_question['total_replies'];?></td>   
                       
                        <td class="text-center" style="color:green; text-align: center">  
                               <?php 
                                $query_get_count = "SELECT COUNT(*) AS `count_less_12h` FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `respond` > 0 AND (`respond` - `date`) < 43200 AND `teacher_id` = '{$row_get_question['teacher_id']}'  AND `date`>='{$from}' AND `date` <='{$to}'";
                                $get_count = mysqli_query($database, $query_get_count) or die(mysqli_error($database));
                                $row_get_count = mysqli_fetch_assoc($get_count); 
                                echo $row_get_count['count_less_12h'];  $count_less_12h = $row_get_count['count_less_12h']; ?>
                        </td>
                        
                         
                         <td class="text-center" style="color:orange; text-align: center">  
                            <?php 
                                $query_get_count = "SELECT COUNT(*) AS `count_less_24h` FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `respond` > 0 AND (`respond` - `date`) > 43200 AND (`respond` - `date`) < 86400 AND `teacher_id` = '{$row_get_question['teacher_id']}'  AND `date`>='{$from}' AND `date` <='{$to}'";
                                $get_count = mysqli_query($database, $query_get_count) or die(mysqli_error($database));
                                $row_get_count = mysqli_fetch_assoc($get_count); 
                                echo $row_get_count['count_less_24h'];  $count_less_24h = $row_get_count['count_less_24h']; ?>
                        </td>

                          
                          <td class="text-center" style="color:red; text-align: center">  
                            <?php 
                                $query_get_count = "SELECT COUNT(*) AS `count_over_24h` FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `respond` > 0 AND (`respond` - `date`) > 86400 AND `teacher_id` = '{$row_get_question['teacher_id']}'  AND `date`>='{$from}' AND `date` <='{$to}'";
                                $get_count = mysqli_query($database, $query_get_count) or die(mysqli_error($database));
                                $row_get_count = mysqli_fetch_assoc($get_count); 
                                echo $row_get_count['count_over_24h'];   $count_over_24h = $row_get_count['count_over_24h'];
                                ?>
                        </td>
                        
                        <td class="text-right" style=" text-align: right">  

                        <?php 

                        if ($count_less_12h > $count_less_24h && $count_less_12h > $count_over_24h) {
                          $color = "green";
                        } 
                        if ($count_less_24h >= $count_less_12h && $count_less_24h > $count_over_24h) {
                          $color = "orange";
                       }
                       if ($count_over_24h >= $count_less_24h && $count_over_24h > $count_less_12h) {
                          $color = "red";
                        }
                        ?>
                                <i class="fa-solid fa-flag fa-2x" style="color: <?php echo $color; ?>; display: inline-block !important; " aria-hidden="true"></i>
                                 
                        </td>

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
            'copy',  'pdf',  
                    {
                        extend: 'print',
                        title: '<?php  echo "  تقرير سرعة الرد </br>  من: ".date("d/m/Y",$from)." - الي: ".date("d/m/Y",$to) ; ?>  ',
                        customize: function (win) {
                            $(win.document.body).css('text-align', 'center');
                            $(win.document.body).find('h1').css('font-size', '16px').css('text-align', 'center');
                        }
                    }
                
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
                [2, "desc"]
            ] 
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>