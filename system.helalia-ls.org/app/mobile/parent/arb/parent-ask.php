<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      
      $kid_id = escape($_GET['kid']); 
      
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


      /* -----------------------------------------------------------
         AJAX: mark a replied-to question as viewed.
         Called from the modal-open JS below, only when the question
         has a `respond` timestamp (i.e. it has actually been replied to).
         Scoped to this parent's own kid_id for safety.
      ----------------------------------------------------------- */
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_question_viewed'])) {

          $question_id = escape($_POST['question_id']);

          mysqli_select_db($database, $database_database,);
          $query_check_question = "SELECT `id`, `respond` FROM `ask_teacher` WHERE `id` = '{$question_id}' AND `kid_id` = '{$kid_id}' LIMIT 1";
          $get_check_question   = mysqli_query($database, $query_check_question) or die(mysqli_error($database));
          $row_check_question   = mysqli_fetch_assoc($get_check_question);

          header('Content-Type: application/json');

          if ($row_check_question && (int)$row_check_question['respond'] > 0) {
              $update_view_sql = sprintf(
                  "UPDATE `ask_teacher` SET `view` = %s WHERE `id` = %s AND `kid_id` = %s",
                  GetSQLValueString($database, 1, "int"),
                  GetSQLValueString($database, $question_id, "int"),
                  GetSQLValueString($database, $kid_id, "int")
              );
              mysqli_query($database, $update_view_sql) or die(mysqli_error($database));
              echo json_encode(array('success' => true));
          } else {
              echo json_encode(array('success' => false));
          }
          exit();
      }


      /* -----------------------------------------------------------
         AJAX: soft-delete a question (sets `del` = 1 rather than
         actually removing the row). Called from the modal's delete
         button. Scoped to this parent's own kid_id for safety.
      ----------------------------------------------------------- */
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_question_id'])) {

          $delete_question_id = escape($_POST['delete_question_id']);

          mysqli_select_db($database, $database_database,);
          $query_check_delete_question = "SELECT `id` FROM `ask_teacher` WHERE `id` = '{$delete_question_id}' AND `kid_id` = '{$kid_id}' LIMIT 1";
          $get_check_delete_question   = mysqli_query($database, $query_check_delete_question) or die(mysqli_error($database));
          $row_check_delete_question   = mysqli_fetch_assoc($get_check_delete_question);

          header('Content-Type: application/json');

          if ($row_check_delete_question) {
              $delete_sql = sprintf(
                  "UPDATE `ask_teacher` SET `del` = %s WHERE `id` = %s AND `kid_id` = %s",
                  GetSQLValueString($database, 1, "int"),
                  GetSQLValueString($database, $delete_question_id, "int"),
                  GetSQLValueString($database, $kid_id, "int")
              );
              mysqli_query($database, $delete_sql) or die(mysqli_error($database));
              echo json_encode(array('success' => true));
          } else {
              echo json_encode(array('success' => false));
          }
          exit();
      }


mysqli_select_db($database , $database_database,);
$query_get_question = "SELECT * FROM `ask_teacher` where `kid_id` = '{$kid_id}' and `del` = 0 order by `id` desc   ";
$get_question =mysqli_query($database ,$query_get_question) or die(mysqli_error($database));
$row_get_question = mysqli_fetch_assoc($get_question);
$totalRows_get_question = mysqli_num_rows($get_question);



 ?> 
 <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title>المواد · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css">
<script src="https://use.fontawesome.com/00bc8e036a.js"></script>
<style>
/* Ask-the-school reply modal — move into helalia.css if you prefer a single stylesheet */
.qa-modal { position: fixed; inset: 0; z-index: 999; display: none; }
.qa-modal.is-open { display: block; }
.qa-modal__overlay { position: absolute; inset: 0; background: rgba(17,44,90,.45); }
.qa-modal__box {
  position: relative; margin: auto; margin-top: 12vh;
  width: 90%; max-width: 420px; background: #fff; border-radius: 16px;
  padding: 24px 20px; box-shadow: 0 20px 50px rgba(0,0,0,.25);
  max-height: 74vh; overflow-y: auto;
}
.qa-modal__close {
  position: absolute; top: 12px; left: 12px; background: none; border: none;
  color: #112c5a; padding: 4px; line-height: 0; cursor: pointer;
}
.qa-modal__close svg { width: 22px; height: 22px; }
.qa-modal__subject { color: #112c5a; font-weight: 600; font-size: 13px; margin: 0 0 4px; }
.qa-modal__title { margin: 0 0 6px; font-size: 17px; color: #111; line-height: 1.4; }
.qa-modal__time { color: #777; font-size: 13px; margin: 0; }
.qa-modal__reply { margin-top: 14px; display: none; }
.qa-modal__reply.show { display: block; }
.qa-modal__from { color: brown; font-size: 13px; margin: 0 0 4px; }
.qa-modal__replytext { margin: 0 0 8px; line-height: 1.5; white-space: pre-wrap; }
.qa-modal__replydate { color: green; font-size: 13px; margin: 0; }
.qa-modal__waiting { display: none; color: #888; font-style: italic; margin-top: 14px; }
.qa-modal__waiting.show { display: block; }
.qa-modal__delete-wrap { margin-top: 18px; padding-top: 14px; border-top: 1px solid #eee; }
.qa-modal__delete-wrap .btn { width: 100%; }
.qa-modal__delete-error {
  color: #c0392b; font-size: 13px; margin: 10px 0 0; display: none; text-align: center;
}
.qa-modal__delete-error.show { display: block; }

/* New-message modal (empty for now — form fields go inside #new-message-body) */
.new-msg-modal { position: fixed; inset: 0; z-index: 999; display: none; }
.new-msg-modal.is-open { display: block; }
.new-msg-modal__overlay { position: absolute; inset: 0; background: rgba(17,44,90,.45); }
.new-msg-modal__box {
  position: relative; margin: auto; margin-top: 12vh;
  width: 90%; max-width: 420px; background: #fff; border-radius: 16px;
  padding: 24px 20px; box-shadow: 0 20px 50px rgba(0,0,0,.25);
  max-height: 74vh; overflow-y: auto;
}
.new-msg-modal__close {
  position: absolute; top: 12px; left: 12px; background: none; border: none;
  color: #112c5a; padding: 4px; line-height: 0; cursor: pointer;
}
.new-msg-modal__close svg { width: 22px; height: 22px; }
.new-msg-modal__title { margin: 0 0 12px; font-size: 17px; color: #111; }
.new-msg-modal__box { max-width: 480px; }

/* Recipient picker grid */
#new-message-body .clients-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin: 0 0 18px;
  padding: 0;
}
#new-message-body .col.s6 { margin: 0; }
#new-message-body .client-box {
  background: #f7f8fb;
  border-radius: 14px;
  padding: 16px 8px;
  text-align: center;
}
#new-message-body .client-box a {
  display: block;
  color: #112c5a;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  line-height: 1.3;
}
#new-message-body .client-box i {
  display: block;
  margin: 0 auto 8px;
  font-size: 26px !important;
  width: auto; height: auto;
}
#new-message-body .client-box:active { background: #eef1f8; }

/* Coordinator section (custom accordion — no Materialize JS on this page) */
#new-message-body .collapsible {
  list-style: none; margin: 0; padding: 0;
  border: 1px solid #eee; border-radius: 14px; overflow: hidden;
}
#new-message-body .collapsible-header {
  display: flex; align-items: center; gap: 10px;
  padding: 14px 16px; cursor: pointer;
  color: #112c5a; font-weight: 600; font-size: 15px !important;
}
#new-message-body .collapsible-header i {
  font-size: 20px !important; margin: 0;
}
#new-message-body .collapsible-header::after {
  content: '▾'; margin-left: auto; color: #999; transition: transform .15s ease;
}
#new-message-body .collapsible-header.is-open::after { transform: rotate(180deg); }
#new-message-body .collapsible-body {
  display: none;
  padding: 4px 16px 16px;
}
#new-message-body .collapsible-body.is-open { display: block; }
#new-message-body .collapsible-body .clients-row {
  grid-template-columns: 1fr 1fr; margin: 8px 0 0;
}
#new-message-body .collapsible-body .client-box { background: #f9f1e2; }

 .row {  
    /* the colour bar — inline-start, so it flips in RTL */
    &::before { 
      background:none;
    }
  }
</style>
</head>
<body>
<div class="app">

 <header class="hero hero--tall">
    <div class="hero__row">
        <a class="back" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="رجوع">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg>
        </a>
         <h1 class="hero__title">اسأل المدرسة</h1>
         <div class="bells">
          <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id;?>" aria-label="تنبيهات">
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
        <button class="btn btn--primary" type="button" id="new-message-btn">إرسال رسالة جديدة</button>
      </div>






 <?php
 $loadmore = 0;
  if($totalRows_get_question>0){
  $loadmore = $totalRows_get_question; ?>
      <div class="sec">
        <h2 class="sec__title">أسئلتي</h2>
      </div>
      <div class="qa" id="qa-list">
        




<?php $i = 1;
      do{ ?> 
   <div class="qa__item <?php if($i++>5){echo " qa__item--old ";}?>"
        data-id="<?php echo (int)$row_get_question['id']; ?>"
        data-respond-raw="<?php echo (int)$row_get_question['respond']; ?>"
        data-view="<?php echo (int)$row_get_question['view']; ?>"
        data-title="<?php echo htmlspecialchars($row_get_question['text'], ENT_QUOTES); ?>"
        data-sent="<?php echo date("d/m/Y h:ia",$row_get_question['date']);?>"
        data-subject="<?php echo htmlspecialchars(question_direct($row_get_question['subject']), ENT_QUOTES); ?>"
        data-status="<?php echo (int)$row_get_question['status']; ?>"
        data-reply="<?php echo htmlspecialchars($row_get_question['reply'], ENT_QUOTES); ?>"
        data-teacher="<?php echo $row_get_question['reply'] != null ? htmlspecialchars(emp_name($row_get_question['teacher_id']), ENT_QUOTES) : ''; ?>"
        data-replydate="<?php echo $row_get_question['respond'] ? date("d/m/Y h:ia",$row_get_question['respond']) : ''; ?>">
      <button class="qa__q" type="button">
        <span>
          <span class="qa__title"><?php echo strlen($row_get_question['text']) > 50 ? substr($row_get_question['text'], 0, 50) . '...' : $row_get_question['text']; ?></span>
          <span class="qa__time">Sent <?php echo date("d/m/Y h:ia",$row_get_question['date']);?></span>
          <span class="qa__time" style="color: #112c5a">(<?php echo question_direct($row_get_question['subject']);?>)</span>
        </span>
        <span class="qa__flag-badge <?php switch ($row_get_question['status']) {
                                        case 0:
                                            echo " qa__flag qa__flag--wait ";
                                            break;
                                        case 1:
                                            echo " qa__flag ";
                                            break;
                                    } if($row_get_question['view']==1){echo " qa__flag--wait ";} ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"  >
            <path d="M9 14 4 9l5-5"/>
            <path d="M4 9h7a7 7 0 0 1 7 7v3"/>
          </svg><?php switch ($row_get_question['status']) {
                                        case 0:
                                            echo " منتظر ";
                                            break;
                                        case 1:
                                            echo " تم الرد ";
                                            break;
                                    } ?></span>
      </button>
    </div> 
 <?php $i++; }while($row_get_question = mysqli_fetch_assoc($get_question)); ?>

 
  </div>
  <?php if($loadmore>5){ ?>
      <button class="btn btn--quiet qa__more" id="qa-more" type="button">تحميل الرسائل القديمة</button>
      <?php } ?>
 <?php }?>


 </main>
      
      

    
    









    <nav class="nav" aria-label="الرئيسية"  style="height: 90px">

      <a class="nav__item" href="parent-view.php">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="9" cy="8" r="3.2"/>
          <path d="M3 19a6 6 0 0 1 12 0"/>
          <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
          <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
        </svg>
        <span>الطلاب</span>
        <span class="nav__dot"></span>
      </a>

       <a class="nav__item  " href="parent-calendar.php?kid=<?php echo $row_get_kid_data['id'];?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span>التقويم</span>
        <span class="nav__dot"></span>
      </a>

      <a class="nav__fab" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="<?php echo $row_get_kid_data['fn_name'];?>">
        <img src="../../../../kids/<?php if($row_get_kid_data['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_data['picture'])==1){echo $row_get_kid_data['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_data['fn_name'];?>">
      </a>

      <a class="nav__item" href="parent-timeline.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"></path>
          <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"></path>
          <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"></path>
        </svg>
        <span>الأخبار</span>
        <span class="nav__dot"></span>
      </a>

      <a class="nav__item" href="parent-settings.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="3"/>
          <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
        </svg>
        <span>الإعدادات</span>
        <span class="nav__dot"></span>
      </a>

  </nav>

  <!-- Reply modal -->
  <div class="qa-modal" id="qa-modal">
    <div class="qa-modal__overlay" id="qa-modal-overlay"></div>
    <div class="qa-modal__box" role="dialog" aria-modal="true" aria-labelledby="qa-modal-title">
      <button class="qa-modal__close" id="qa-modal-close" aria-label="Close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
        </svg>
      </button>
      <p class="qa-modal__subject" id="qa-modal-subject"></p>
      <h3 class="qa-modal__title" id="qa-modal-title"></h3>
      <p class="qa-modal__time" id="qa-modal-time"></p>

      <div class="qa-modal__reply" id="qa-modal-reply-wrap">
        <hr>
        <p class="qa-modal__from" id="qa-modal-from"></p>
        <p class="qa-modal__replytext" id="qa-modal-replytext"></p>
        <p class="qa-modal__replydate" id="qa-modal-replydate"></p>
      </div>
      <p class="qa-modal__waiting" id="qa-modal-waiting">أنتظر ردًا من المدرسة.</p>

      <div class="qa-modal__delete-wrap">
        <button class="btn btn--danger" id="qa-modal-delete" type="button">حذف السؤال</button>
        <p class="qa-modal__delete-error" id="qa-modal-delete-error"></p>
      </div>
    </div>
  </div>

  <!-- New message modal (empty — add your form fields inside #new-message-body) -->
  <div class="new-msg-modal" id="new-message-modal">
    <div class="new-msg-modal__overlay" id="new-message-overlay"></div>
    <div class="new-msg-modal__box" role="dialog" aria-modal="true" aria-labelledby="new-message-title">
      <button class="new-msg-modal__close" id="new-message-close" aria-label="Close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="new-msg-modal__title" id="new-message-title">اسأل المدرسة</h3>
      <div id="new-message-body">
        <div class="  clients-row">

            <?php   

            mysqli_select_db($database , $database_database);
            // Same as old app: list this kid's year subjects under Coordinator.
            // (Old code only opened the list if the *first* subject had cor — often empty.)
            $ask_study_year = (int) $row_get_kid_data['study_year'];
            $query_get_subjects = "SELECT * FROM `subjects` WHERE `study_year` = '{$ask_study_year}' ORDER BY `name` ASC, `name_eng` ASC, `id` ASC";
            $get_subjects = mysqli_query($database, $query_get_subjects) or die(mysqli_error($database));
            $ask_coord_subjects = array();
            while ($row_get_subjects = mysqli_fetch_assoc($get_subjects)) {
                $ask_coord_subjects[] = $row_get_subjects;
            }
            $totalRows_get_subjects = count($ask_coord_subjects);


            $query_get_check = "SELECT * FROM `emps` WHERE `app20_1`= 1 ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){ ?>
                <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10001">
                        <i class="fa fa-university fa-3x" aria-hidden="true"></i><br>
                        الإدارة
                    </a>
                    </div>
                </div>
            <?php }?>


            <?php  
                  $app ='';
                  if($row_get_kid_data['study_year'] == 0 )                                     { $app = ' AND `app20_5_1` = 1  '; }
                  if($row_get_kid_data['study_year'] >= 1 && $row_get_kid_data['study_year'] <= 2)  { $app = ' AND `app20_5_2` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 3 && $row_get_kid_data['study_year'] <= 5)  { $app = ' AND `app20_5_3` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 6 && $row_get_kid_data['study_year'] <= 8)  { $app = ' AND `app20_5_4` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 9 && $row_get_kid_data['study_year'] <= 11) { $app = ' AND `app20_5_5` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 12 && $row_get_kid_data['study_year'] <= 14){ $app = ' AND `app20_5_6` = 1  '; }  

            $query_get_check = "SELECT * FROM `emps` WHERE `id`>0  $app ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){ ?>
                <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10004">
                        <i class="fa fa-sitemap fa-3x" aria-hidden="true"></i><br>
                        السكرتارية
                    </a>
                    </div>
                </div>
             <?php }?>


             
            <?php  
                  $app ='';
                  if($row_get_kid_data['study_year'] == 0 )                                     { $app = ' AND `app20_3_1` = 1  '; }
                  if($row_get_kid_data['study_year'] >= 1 && $row_get_kid_data['study_year'] <= 2)  { $app = ' AND `app20_3_2` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 3 && $row_get_kid_data['study_year'] <= 5)  { $app = ' AND `app20_3_3` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 6 && $row_get_kid_data['study_year'] <= 8)  { $app = ' AND `app20_3_4` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 9 && $row_get_kid_data['study_year'] <= 11) { $app = ' AND `app20_3_5` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 12 && $row_get_kid_data['study_year'] <= 14){ $app = ' AND `app20_3_6` = 1  '; }  

            $query_get_check = "SELECT * FROM `emps` WHERE `id`>0  $app ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){ ?>
                <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10002">
                        <i class="fa fa-graduation-cap fa-3x" aria-hidden="true"></i><br>
                       رئيس القسم
                    </a>
                    </div>
                </div>
             <?php }?>


            <?php  
                  $app ='';
                  if($row_get_kid_data['study_year'] == 0 )                                     { $app = ' AND `app20_4_1` = 1  '; }
                  if($row_get_kid_data['study_year'] >= 1 && $row_get_kid_data['study_year'] <= 2)  { $app = ' AND `app20_4_2` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 3 && $row_get_kid_data['study_year'] <= 5)  { $app = ' AND `app20_4_3` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 6 && $row_get_kid_data['study_year'] <= 8)  { $app = ' AND `app20_4_4` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 9 && $row_get_kid_data['study_year'] <= 11) { $app = ' AND `app20_4_5` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 12 && $row_get_kid_data['study_year'] <= 14){ $app = ' AND `app20_4_6` = 1  '; }  

            $query_get_check = "SELECT * FROM `emps` WHERE `id`>0  $app ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){ ?>
                <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10003">
                        <i class="fa fa-graduation-cap fa-3x" aria-hidden="true"></i><br>
                        وكيل المدرسة
                    </a>
                    </div>
                </div>
             <?php }?>


               
                
            <?php 
            $query_get_check = "SELECT * FROM `emps` WHERE `app20_2`= 1 ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){?>  
                 <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10005">
                      <i class="fa fa-user-md fa-3x" aria-hidden="true"></i><br>
                        الطبيب
                    </a>
                    </div>
                </div>
             <?php }?> 
             



               <?php  
                  $app ='';
                  if($row_get_kid_data['study_year'] == 0 )                                     { $app = ' AND `app20_6_1` = 1  '; }
                  if($row_get_kid_data['study_year'] >= 1 && $row_get_kid_data['study_year'] <= 2)  { $app = ' AND `app20_6_2` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 3 && $row_get_kid_data['study_year'] <= 5)  { $app = ' AND `app20_6_3` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 6 && $row_get_kid_data['study_year'] <= 8)  { $app = ' AND `app20_6_4` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 9 && $row_get_kid_data['study_year'] <= 11) { $app = ' AND `app20_6_5` = 1  '; } 
                  if($row_get_kid_data['study_year'] >= 12 && $row_get_kid_data['study_year'] <= 14){ $app = ' AND `app20_6_6` = 1  '; }  

            $query_get_check = "SELECT * FROM `emps` WHERE `id`>0  $app ";    
            $get_check = mysqli_query($database ,$query_get_check) or die(mysqli_error($database));
            $row_get_check = mysqli_fetch_assoc($get_check);
            $totalRows_get_check = mysqli_num_rows($get_check); 
             if($totalRows_get_check>0){ ?>
                <div class="col s6">
                    <div class="client-box">
                    <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=10006">
                       <i class="fa fa-handshake-o fa-3x" aria-hidden="true"></i><br>
                        الأخصائي النفسي
                    </a>
                    </div>
                </div>
              <?php }?>

        </div>

        <?php if ($totalRows_get_subjects > 0) { ?>
        <ul class="collapsible">
          <li>
            <div class="collapsible-header is-open"><i class="fa fa-book" aria-hidden="true"></i> منسق</div>
            <div class="collapsible-body is-open">
              <div class="clients-row">
                <?php foreach ($ask_coord_subjects as $row_get_subjects) {
                    $subjLabel = trim((string) $row_get_subjects['name']);
                    if ($subjLabel === '') {
                        $subjLabel = trim((string) $row_get_subjects['name_eng']);
                    }
                    if ($subjLabel === '') {
                        $subjLabel = 'مادة #' . (int) $row_get_subjects['id'];
                    }
                ?>
                        <div class="col s6">
                            <div class="client-box">
                            <a href="parent-ask-teacher.php?kid=<?php echo $kid_id;?>&subject=<?php echo (int) $row_get_subjects['id']; ?>">
                                <i class="fa fa-book fa-3x" aria-hidden="true"></i><br>
                                <?php echo htmlspecialchars($subjLabel, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            </div>
                        </div>
                <?php } ?>
              </div>
            </div>
          </li>
        </ul>
        <?php } ?>
      </div>
    </div>
  </div>

</div>
<script>
var qaAjaxUrl = 'parent-ask.php?kid=<?php echo $kid_id; ?>';

var more = document.getElementById('qa-more');
if (more) {
  more.addEventListener('click', function () {
    var hiddenItems = document.querySelectorAll('#qa-list .qa__item--old');
    for (var i = 0; i < 5 && i < hiddenItems.length; i++) {
      hiddenItems[i].classList.remove('qa__item--old');
    }
    if (document.querySelectorAll('#qa-list .qa__item--old').length === 0) {
      more.remove();
    }
  });
}

var modal = document.getElementById('qa-modal');
var replyWrap = document.getElementById('qa-modal-reply-wrap');
var waitingMsg = document.getElementById('qa-modal-waiting');
var deleteBtn = document.getElementById('qa-modal-delete');
var deleteErrorEl = document.getElementById('qa-modal-delete-error');
var currentQaItem = null;
var deleteConfirmPending = false;
var deleteConfirmTimeout = null;

function markQuestionViewed(questionId) {
  var formData = new URLSearchParams();
  formData.set('mark_question_viewed', '1');
  formData.set('question_id', questionId);

  fetch(qaAjaxUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  }).catch(function () {
    /* silently ignore — this is a background "mark as read", not critical */
  });
}

function openQaModal(item) {
  currentQaItem = item;

  document.getElementById('qa-modal-subject').textContent = '(' + item.dataset.subject + ')';
  document.getElementById('qa-modal-title').textContent = item.dataset.title;
  document.getElementById('qa-modal-time').textContent = 'مرسل ' + item.dataset.sent;

  if (item.dataset.status === '1') {
    document.getElementById('qa-modal-from').textContent = 'الرد بواسطة \\ ' + item.dataset.teacher;
    document.getElementById('qa-modal-replytext').textContent = item.dataset.reply;
    document.getElementById('qa-modal-replydate').textContent = 'تم الرد ' + item.dataset.replydate;
    replyWrap.classList.add('show');
    waitingMsg.classList.remove('show');
  } else {
    replyWrap.classList.remove('show');
    waitingMsg.classList.add('show');
  }

  modal.classList.add('is-open');

  var respondRaw = parseInt(item.dataset.respondRaw, 10);
  var alreadyViewed = item.dataset.view === '1';

  if (respondRaw > 0 && !alreadyViewed) {
    /* Optimistic UI: mark it read in the list immediately, don't wait on the network */
    var badge = item.querySelector('.qa__flag-badge');
    if (badge) {
      badge.classList.add('qa__flag--wait');
    }
    item.dataset.view = '1';

    markQuestionViewed(item.dataset.id);
  }
}

function resetDeleteButton() {
  deleteConfirmPending = false;
  if (deleteConfirmTimeout) {
    clearTimeout(deleteConfirmTimeout);
    deleteConfirmTimeout = null;
  }
  deleteBtn.disabled = false;
  deleteBtn.textContent = 'حذف السؤال';
  deleteBtn.classList.remove('btn--confirm');
  deleteErrorEl.classList.remove('show');
  deleteErrorEl.textContent = '';
}

function closeQaModal() {
  modal.classList.remove('is-open');
  currentQaItem = null;
  resetDeleteButton();
}

function deleteCurrentQuestion() {
  if (!currentQaItem) {
    return;
  }

  /* No native confirm()/alert() — they don't fire inside Android WebView.
     Two-tap confirm instead: first tap arms it, second tap (within 4s) deletes. */
  if (!deleteConfirmPending) {
    deleteConfirmPending = true;
    deleteBtn.textContent = 'اضغط مرة أخرى للتأكيد';
    deleteBtn.classList.add('btn--confirm');
    deleteErrorEl.classList.remove('show');

    deleteConfirmTimeout = setTimeout(function () {
      resetDeleteButton();
    }, 4000);

    return;
  }

  if (deleteConfirmTimeout) {
    clearTimeout(deleteConfirmTimeout);
    deleteConfirmTimeout = null;
  }

  var itemToRemove = currentQaItem;
  var questionId = itemToRemove.dataset.id;

  deleteBtn.disabled = true;
  deleteBtn.textContent = 'جارٍ الحذف...';
  deleteErrorEl.classList.remove('show');

  var formData = new URLSearchParams();
  formData.set('delete_question_id', questionId);

  fetch(qaAjaxUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
    .then(function (response) { return response.json(); })
    .then(function (data) {
      if (data && data.success) {
        itemToRemove.remove();
        closeQaModal();
      } else {
        resetDeleteButton();
        deleteErrorEl.textContent = 'تعذر حذف السؤال، برجاء المحاولة مرة أخرى.';
        deleteErrorEl.classList.add('show');
      }
    })
    .catch(function () {
      resetDeleteButton();
      deleteErrorEl.textContent = 'تعذر حذف السؤال، برجاء المحاولة مرة أخرى.';
      deleteErrorEl.classList.add('show');
    });
}

document.querySelectorAll('.qa__q').forEach(function (btn) {
  var item = btn.closest('.qa__item');
  btn.addEventListener('click', function () { openQaModal(item); });
});

document.getElementById('qa-modal-close').addEventListener('click', closeQaModal);
document.getElementById('qa-modal-overlay').addEventListener('click', closeQaModal);
deleteBtn.addEventListener('click', deleteCurrentQuestion);
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape' && modal.classList.contains('is-open')) closeQaModal();
  if (e.key === 'Escape' && newMsgModal.classList.contains('is-open')) closeNewMessageModal();
});

/* New message modal */
var newMsgModal = document.getElementById('new-message-modal');
var newMsgBtn = document.getElementById('new-message-btn');

function openNewMessageModal() {
  newMsgModal.classList.add('is-open');
}
function closeNewMessageModal() {
  newMsgModal.classList.remove('is-open');
}

newMsgBtn.addEventListener('click', openNewMessageModal);
document.getElementById('new-message-close').addEventListener('click', closeNewMessageModal);
document.getElementById('new-message-overlay').addEventListener('click', closeNewMessageModal);

/* Coordinator collapsible inside the new-message modal (no Materialize JS on this page) */
document.querySelectorAll('#new-message-body .collapsible-header').forEach(function (header) {
  header.addEventListener('click', function () {
    var body = header.nextElementSibling;
    header.classList.toggle('is-open');
    body.classList.toggle('is-open');
  });
});
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
