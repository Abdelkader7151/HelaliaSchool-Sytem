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
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
<script>
    window.onload = function() {
        document.body.style.setProperty('transform', 'rotate(0deg)');
            var style = document.createElement('style');
            style.innerHTML = '@page { size: landscape; }';
            document.head.appendChild(style);
            window.print();
    };
</script>
</head> 
 
  <body class="layout layout-header-fixed"> 
	  
   
		 
                <table id="court-datatables" class="table table-striped table-nowrap dataTable print-only-table" cellspacing="0" style="font-size: 16px; width: 100%; table-layout: auto;">
                                  <thead>
                                    <tr> 
                                    <th class="text-left" style="width: 20%">الاسم  </th>  
                                    <th class="text-center" style="width: 13%">متوسط وقت الرد  </th>  
                                    <th class="text-center" style="width: 10%">الردود  </th>  

                                     
                                     
                                    <th class="text-center" style="width: 13%">اقل من 12س  </th>
                                     <th class="text-center" style="width: 13%">اقل من 24س  </th>
                                     <th class="text-center" style="width: 13%">اكثر من 24س  </th>    

                                    <th class="text-center" style="width: 8%">    </th>
                                     
                                    </tr>
                                  </thead>
                                  <tbody>
                                        
                                        <?php if($totalRows_get_question>0){
                                               do{  
                                                
                                                if(emp_name($row_get_question['teacher_id'])!=NULL){ ?>
                                      <tr> 
                                        <td style="width: 20%; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;"><p style="margin: 0;"><?php echo emp_name($row_get_question['teacher_id']); ?></p></td>
                                         <td class="text-center" style="text-align: center; width: 13%;"><?php  
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
                                 
                        <?php if($color=="green"){ ?>
                            <img width="30" height="30" src="img/flag-green.png"  />
                        <?php }elseif($color=="orange"){ ?>  
                            <img width="30" height="30" src="img/flag-orange.png" /> 
                        <?php }elseif($color=="red"){ ?>
                              <img width="30" height="30" src="img/flag-red.png"  />
                        <?php } ?>
                                  
                         
                                 
                        </td>

                      </tr>
                      <?php } }while($row_get_question = mysqli_fetch_assoc($get_question));} ?> 
                     
                     
                    </tbody>
                  </table>
             
			
			 
			
			
 
	  
  
 
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>