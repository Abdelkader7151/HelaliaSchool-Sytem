<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
      
      $kid_id = escape($_GET['kid']); 
      $subject_id = escape($_GET['subject']); 
      
      mysqli_select_db($database, $database_database,);
      $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}' and `kid_id` = '{$kid_id}'";
      $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
      $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
      $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

      if($totalRows_get_kids_list==0){
          header("Location: parent-view.php");
          exit();
      }

 
        $query_get_kid_data = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
        $get_kid_data = mysqli_query($database, $query_get_kid_data) or die(mysqli_error($database));
        $row_get_kid_data = mysqli_fetch_assoc($get_kid_data);
        $totalRows_get_kid_data = mysqli_num_rows($get_kid_data);
 
      if($totalRows_get_kid_data==0){
          header("Location: parent-view.php");
          exit();
      }

      
      
 if(isset($_POST['submit'])){

          $done = 0;
          $hour  = (time()-3600);

          mysqli_select_db($database , $database_database,);
          $query_get_check = "SELECT * FROM `ask_teacher` WHERE `user_id` = '{$row_get_user['id']}' AND `kid_id` = '{$kid_id}' AND  `subject` = '{$_POST['subject']}' AND `text` = '{$_POST['text']}'  AND `date` > '{$hour}' ";
          $get_check = mysqli_query($database,$query_get_check) or die(mysqli_error($database));
          $row_get_check = mysqli_fetch_assoc($get_check);
          $totalRows_get_check = mysqli_num_rows($get_check);

if($totalRows_get_check<1){   

          mysqli_select_db($database , $database_database,);
          $query_get_kids = "SELECT * FROM `kids` WHERE `id` = '{$kid_id}' ";
          $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
          $row_get_kids = mysqli_fetch_assoc($get_kids);
          $totalRows_get_kids = mysqli_num_rows($get_kids);


                  $insertSQL = sprintf("INSERT INTO `ask_teacher` (`user_id`, `kid_id`, `text`, `study_year`, `subject`,  `date` ) VALUES (%s, %s, %s, %s, %s, %s)",
                             GetSQLValueString($database ,$row_get_user['id'], "int"),
                             GetSQLValueString($database ,$kid_id, "int"),
                             GetSQLValueString($database ,$_POST['text'], "text"),
                             GetSQLValueString($database ,$row_get_kids['study_year'], "int"),
                             GetSQLValueString($database ,$_POST['subject'], "int"),
                             GetSQLValueString($database ,time(), "int"));

                   mysqli_query($database , $insertSQL) or die(mysqli_error($database)); 



 
                  $app =''; 
                
 
                if($_POST['subject']>1000 && $_POST['subject']!=10001 && $_POST['subject']!=10005){   
                  if($row_get_kids['study_year'] == 0 ) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_1` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_1` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_1` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_1` = 1  '; }
                  }
                  if($row_get_kids['study_year'] >= 1 && $row_get_kids['study_year'] <= 2) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_2` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_2` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_2` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_2` = 1  '; }
                  }
                  if($row_get_kids['study_year'] >= 3 && $row_get_kids['study_year'] <= 5) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_3` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_3` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_3` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_3` = 1  '; }
                  }
                  if($row_get_kids['study_year'] >= 6 && $row_get_kids['study_year'] <= 8) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_4` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_4` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_4` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_4` = 1  '; }
                  }
                  if($row_get_kids['study_year'] >= 9 && $row_get_kids['study_year'] <= 11) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_5` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_5` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_5` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_5` = 1  '; }
                  }
                  if($row_get_kids['study_year'] >= 12 && $row_get_kids['study_year'] <= 14) { 
                                    if($_POST['subject']==10002){ $app = ' AND `app20_3_6` = 1  '; }
                                    if($_POST['subject']==10003){ $app = ' AND `app20_4_6` = 1  '; }
                                    if($_POST['subject']==10004){ $app = ' AND `app20_5_6` = 1  '; }
                                    if($_POST['subject']==10006){ $app = ' AND `app20_6_6` = 1  '; }
                  }

 
                    $query_get_app = "SELECT * FROM `emps` WHERE `id`>0  $app ";    
                    $get_app = mysqli_query($database ,$query_get_app) or die(mysqli_error($database));
                    $row_get_app = mysqli_fetch_assoc($get_app);
                    $totalRows_get_app = mysqli_num_rows($get_app); 

                    if($totalRows_get_app>0){
                      do{    
                          sendMessage(app_msg_id2($row_get_app['id']),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id));  
                      }while($row_get_app = mysqli_fetch_assoc($get_app));
                    }
                }

             
 
               //مدير المدرسة
                if($_POST['subject']==10001 ){  
                    $query_get_app = "SELECT * FROM `emps` WHERE `app20_1`= 1 ";    
                    $get_app = mysqli_query($database ,$query_get_app) or die(mysqli_error($database));
                    $row_get_app = mysqli_fetch_assoc($get_app);
                    $totalRows_get_app = mysqli_num_rows($get_app); 

                    if($totalRows_get_app>0){
                      do{    
                          sendMessage(app_msg_id2($row_get_app['id']),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id));  
                      }while($row_get_app = mysqli_fetch_assoc($get_app));
                    }
                }


                
               //  الطبيب
                if($_POST['subject']==10005){  
                    $query_get_app = "SELECT * FROM `emps` WHERE `app20_2`= 1 ";    
                    $get_app = mysqli_query($database ,$query_get_app) or die(mysqli_error($database));
                    $row_get_app = mysqli_fetch_assoc($get_app);
                    $totalRows_get_app = mysqli_num_rows($get_app); 

                    if($totalRows_get_app>0){
                      do{    
                          sendMessage(app_msg_id2($row_get_app['id']),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id));  
                      }while($row_get_app = mysqli_fetch_assoc($get_app));
                    }
                } 

                  // For coordinators — subject da bas (cor aw job Coordinator bey3alemoh)
                  if($_POST['subject']<1000){
                     if (function_exists('subject_coordinator_emps')) {
                       $cooList = subject_coordinator_emps($_POST['subject']);
                       foreach ($cooList as $cooId) {
                         sendMessage(app_msg_id2($cooId),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id));
                       }
                     } elseif(check_teacher_subject($_POST['subject'])>0){
                         sendMessage(app_msg_id2(check_teacher_subject($_POST['subject'])),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id)); 
                      }
                      
                      //head of department
                      if(check_head_subject($_POST['subject'])>0){
                         sendMessage(app_msg_id2(check_head_subject($_POST['subject'])),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id)); 
                      }
                      
                      //supervisor (app20_7) — mesh Coordinator job; stage supervisors
                      $app =''; 
                      if($row_get_kids['study_year'] == 0 )                                     { $app = ' AND `app20_7_1` = 1  '; } 
                      if($row_get_kids['study_year'] >= 1 && $row_get_kids['study_year'] <= 2)  { $app = ' AND `app20_7_2` = 1  '; } 
                      if($row_get_kids['study_year'] >= 3 && $row_get_kids['study_year'] <= 5)  { $app = ' AND `app20_7_3` = 1  '; } 
                      if($row_get_kids['study_year'] >= 6 && $row_get_kids['study_year'] <= 8)  { $app = ' AND `app20_7_4` = 1  '; } 
                      if($row_get_kids['study_year'] >= 9 && $row_get_kids['study_year'] <= 11) { $app = ' AND `app20_7_5` = 1  '; } 
                      if($row_get_kids['study_year'] >= 12 && $row_get_kids['study_year'] <= 14){ $app = ' AND `app20_7_6` = 1  '; }  
 
                      $query_get_app = "SELECT * FROM `emps` WHERE `id`>0 AND `job` != 81 $app ";    
                      $get_app = mysqli_query($database ,$query_get_app) or die(mysqli_error($database));
                      $row_get_app = mysqli_fetch_assoc($get_app);
                      $totalRows_get_app = mysqli_num_rows($get_app); 

                      if($totalRows_get_app>0){
                        do{    
                             sendMessage(app_msg_id2($row_get_app['id']),'HLS', date("d/m/Y",time()).' سؤال من ولي امر  '.kid_name($kid_id));  
                        }while($row_get_app = mysqli_fetch_assoc($get_app));
                      }
                   } 
$done = 1;
                }
            header("location: parent-ask-teacher.php?kid=".$kid_id."&subject=".$subject_id."&done=".$done);
            exit();
      }



mysqli_select_db($database , $database_database,);
$query_get_subjects = "SELECT * FROM `subjects` where `study_year` = '{$row_get_kid_data['study_year']}'";
$get_subjects =mysqli_query($database ,$query_get_subjects) or die(mysqli_error($database));
$row_get_subjects = mysqli_fetch_assoc($get_subjects);
$totalRows_get_subjects = mysqli_num_rows($get_subjects);
 


mysqli_select_db($database , $database_database,);
$query_get_question = "SELECT * FROM `ask_teacher` where `kid_id` = '{$kid_id}' order by `id` desc   ";
$get_question =mysqli_query($database ,$query_get_question) or die(mysqli_error($database));
$row_get_question = mysqli_fetch_assoc($get_question);
$totalRows_get_question = mysqli_num_rows($get_question);



 ?> 
 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title>Ask The School · Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/helalia.css">
<script src="https://use.fontawesome.com/00bc8e036a.js"></script>
<style>
/* Ask-the-school form — plain CSS, no Materialize dependency */
.ask-head {
  text-align: center;
  color: #112c5a;
  margin: 4px 0 18px;
}
.ask-head i { font-size: 34px; margin-bottom: 8px; display: block; }
.ask-head span { display: block; font-size: 15px; font-weight: 600; }

.ask-crumbs {
  display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
  background: #fdece2;
  border-radius: 14px;
  padding: 12px 16px;
  font-size: 13px;
  color: #112c5a;
  margin-bottom: 16px;
}
.ask-crumbs span:not(:last-child)::after { content: '›'; margin-left: 6px; color: #c98a63; }
.ask-crumbs .current { font-weight: 700; }

.ask-card {
  background: #fff;
  border: 1px solid #e3e7f0;
  border-radius: 20px;
  padding: 20px 16px;
}

.ask-textarea {
  width: 100%;
  min-height: 140px;
  border: 1px solid #d9dee8;
  border-radius: 14px;
  padding: 14px;
  font-family: inherit;
  font-size: 15px;
  resize: vertical;
  box-sizing: border-box;
}
.ask-textarea:focus { outline: none; border-color: #112c5a; }

.ask-submit-row { text-align: center; margin-top: 16px; }
.ask-submit {
  display: inline-flex; align-items: center; gap: 8px;
  background: #112c5a; color: #fff; border: none;
  border-radius: 999px; padding: 12px 28px;
  font-size: 15px; font-weight: 600; cursor: pointer;
}
.ask-submit:active { background: #0c1f40; }
.ask-submit .fa-spinner { display: none; }

.ask-success {
  margin-top: 16px;
  background: #e9f7ee;
  color: #1c7c3e;
  border: 1px solid #bfe8cd;
  border-radius: 14px;
  padding: 12px 16px;
  font-size: 14px;
  display: flex; align-items: center; gap: 8px;
}
</style>
</head>
<body>
<div class="app">
   <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-ask.php?kid=<?php echo $kid_id;?>" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"></path>
        </svg>
      </a>
        <h1 class="hero__title">Ask The School</h1>
        <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id;?>" aria-label="Alerts">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
          <path d="M10 20a2 2 0 0 0 4 0"></path>
        </svg>
        <?php alert($row_get_user['id'], $kid_id); ?>
      </a>
    </div>
  </div>  

  </header>


  <main class="page">
    <div class="card stack">

   <?php if($subject_id==10001 ){?><div class="ask-head"><i class="fa fa-university" aria-hidden="true"></i><span>Administration</span></div><?php } ?>
   <?php if($subject_id==10002){?><div class="ask-head"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Head Of Department</span></div><?php } ?>
   <?php if($subject_id==10003){?><div class="ask-head"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Vice Head Of Department</span></div><?php } ?>
   <?php if($subject_id==10004){?><div class="ask-head"><i class="fa fa-sitemap" aria-hidden="true"></i><span>Secretary</span></div><?php } ?>
   <?php if($subject_id==10005){?><div class="ask-head"><i class="fa fa-user-md" aria-hidden="true"></i><span>Doctor</span></div><?php } ?>
   <?php if($subject_id==10006){?><div class="ask-head"><i class="fa fa-handshake-o" aria-hidden="true"></i><span>Therapist</span></div><?php } ?>
   <?php if($subject_id<1000){?><div class="ask-head"><i class="fa fa-book" aria-hidden="true"></i><span>Coordinator</span></div><?php } ?>

 

        <form action="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=<?php echo $subject_id;?>" method="post" enctype="multipart/form-data" name="send-form" id="send-form">

               <textarea id="text" name="text" class="ask-textarea" placeholder="Write your Question ..." required></textarea>
               <input type="hidden" name="subject" value="<?php echo $subject_id;?>" />
               <input type="hidden" name="study_year" value="<?php echo $row_get_kid_data['study_year'];?>" />

                <div class="ask-submit-row">
                    <button type="submit" class="ask-submit" id="submit" name="submit">
                      <i class="fa fa-paper-plane" id="send" aria-hidden="true"></i>
                      <i class="fa fa-spinner fa-spin fa-fw" id="loading"></i>
                      Send
                    </button>
                </div>

                <?php if(isset($_GET['done'])){?>
              <div class="ask-success" id="done"><i class="fa fa-check-circle" aria-hidden="true"></i> Sent Successfully</div>
            <?php }?>

            </form>

     

  </div>


 </main>
      
      

    
    









 <nav class="nav" aria-label="Home"  style="height: 90px">
    <a class="nav__item" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="9" cy="8" r="3.2"/>
        <path d="M3 19a6 6 0 0 1 12 0"/>
        <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
        <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
      </svg>
      <span>Students</span>
      <span class="nav__dot"></span>
    </a>

  <a class="nav__item  " href="parent-calendar.php?kid=<?php echo (int) $kid_id; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      <span>Calendar</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__fab" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="<?php echo $row_get_kid_data['fn_name'];?>">
      <img src="../../../../kids/<?php if($row_get_kid_data['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_data['picture'])==1){echo $row_get_kid_data['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_data['fn_name'];?>">
    </a>
    
    <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/>
        <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/>
        <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/>
      </svg>
      <span>Latest News</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
      </svg>
      <span>Settings</span>
      <span class="nav__dot"></span>
    </a>
  </nav>


</div>
<script type="text/javascript"> 
  $(document).ready(function(){
      $("#send-form").submit(function(){
          $("#loading").fadeIn(); 
      });

   });
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html> 