<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
      
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

       

function get_week_thursday_range($reference = 'now') {
    $ref = new DateTime($reference);

    // Find this week's Thursday (the most recent Thursday on/before $reference)
    $start = clone $ref;
    $dayOfWeek = (int)$start->format('N'); // 1 (Mon) .. 7 (Sun); Thursday = 4
    $diffToThursday = $dayOfWeek - 4;
    if ($diffToThursday < 0) {
        $diffToThursday += 7; // go back to the previous Thursday
    }
    $start->modify("-{$diffToThursday} days");
    $start->setTime(0, 0, 0); // normalize to midnight

    // End Thursday is exactly 7 days later
    $end = clone $start;
    $end->modify('+7 days');

    return [
        'start_label'     => $start->format('D j M'),
        'end_label'       => $end->format('D j M'),
        'start_timestamp' => $start->getTimestamp(),
        'end_timestamp'   => $end->getTimestamp(),
    ];
}



 $range = get_week_thursday_range();



 //echo $range['start_label'] . ' → ' . $range['end_label'] . "\n";
// e.g. "Fri 28 Aug → Fri 4 Sep"

 $start = $range['start_timestamp']; // e.g. 1756339200
 $end   = $range['end_timestamp'];   // e.g. 1756944000
 $date = strtotime(date("m/d/Y",time())); 
    

        mysqli_select_db($database , $database_database); 
        $query_get_data = "SELECT * FROM `weeklyplan` WHERE `study_year` = '{$row_get_kid_data['study_year']}' AND  `confirm` = 1 AND ( `class` = '{$row_get_kid_data['class']}' || `class` = 0 ) and `start` >= '{$start}' and `start` < '{$end}' ORDER BY `id` desc ";
        $get_data = mysqli_query($database ,$query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        $totalRows_get_data = mysqli_num_rows($get_data);

 

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
</head>
<body>
<div class="app"> 

   <header class="hero hero--tall">
    <div class="hero__row">
        <a class="back" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="رجوع">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg>
        </a>
         <h1 class="hero__title">الخطة الأسبوعية</h1>
         <div class="bells">
          <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id; ?>" aria-label="تنبيهات">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
              <path d="M10 20a2 2 0 0 0 4 0"></path>
            </svg>
            <?php alert($row_get_user['id'], $kid_id); ?>
          </a>
        </div>
      </div> 
      <p class="hero__lede">من الخميس إلى الخميس</p>
    </header>

  
 
  
  <main class="page">
      <div class="week">
        <div class="weekhead">
          <span class="weekhead__range"><?php  echo $range['end_label'] . ' ← ' . $range['start_label'];?></span>
          <span class="weekhead__tag weekhead__tag--now">هذا الاسبوع</span>
        </div>   
 <div class="plan">   



  <?php if($totalRows_get_data>0){
                 $day = 0;
                     do{ ?>
     <div class="planitem">
        <button class="plan__row <?php echo getRandomColor();?>" type="button">
            <span class="plan__day"><?php echo date("D",$row_get_data['date']);?></span>
            <div>
              <p class="row__title"><?php echo $row_get_data['name_eng'];?></p>
               <p class="row__meta"><?php echo date("d M, Y",$row_get_data['date']);?></p>
             </div>
        </button>
        <div class="plan__panel">
          <p class="plan__note"> 
           <?php if($row_get_data['banner']!=NULL && file_exists('../../../../homework/'.$row_get_data['banner'])==1){
           if(strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='jpg' || strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='png'){?>
          <img src="../../../../homework/<?php if($row_get_data['banner']!=NULL && file_exists('../../../../homework/'.$row_get_data['banner'])==1){echo $row_get_data['banner'];} ?>" alt=" ">
           <?php }  if(strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='pdf' || strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='doc' || strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='docx' || strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='xls' || strtolower(pathinfo(trim('../../../../homework/'.$row_get_data['banner']), PATHINFO_EXTENSION))=='xlsx'){ ?>
           <a href="../../../../homework/<?php if($row_get_data['banner']!=NULL && file_exists('../../../../homework/'.$row_get_data['banner'])==1){echo $row_get_data['banner'];} ?>" target="_blank"  class="external">
            <?php echo file_icon("../../../../homework/".$row_get_data['banner'])." ";?>  Download</a>
           <?php }?>
          
          <br>
          <?php }   echo $row_get_data['text_eng'];?></p>
          
          
           
           
          
        </div>
       </div>

   <?php  }while($row_get_data = mysqli_fetch_assoc($get_data)); }?>


     
     
         




        </div>  
      </div>



<!--
      <div class="week week--old">
        <div class="weekhead">
          <span class="weekhead__range">Fri 21 → Fri 28 Aug</span>
          <span class="weekhead__tag">Previous week</span>
        </div>
        <div class="plan">
          <div class="planitem">
        <button class="plan__row t-gold" type="button">
            <span class="plan__day">Sat</span>
            <div><p class="row__title">English · Unit 5</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">English · Unit 5 — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="English · Unit 5 board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="English · Unit 5 worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="English · Unit 5 lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">English · Unit 5 worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
          <div class="planitem">
        <button class="plan__row t-green" type="button">
            <span class="plan__day">Sun</span>
            <div><p class="row__title">Math · Decimals</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">Math · Decimals — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="Math · Decimals board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="Math · Decimals worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="Math · Decimals lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">Math · Decimals worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
          <div class="planitem">
        <button class="plan__row t-navy" type="button">
            <span class="plan__day">Mon</span>
            <div><p class="row__title">Science · Plants</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">Science · Plants — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="Science · Plants board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="Science · Plants worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="Science · Plants lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">Science · Plants worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
          <div class="planitem">
        <button class="plan__row t-coral" type="button">
            <span class="plan__day">Tue</span>
            <div><p class="row__title">Arabic · Grammar</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">Arabic · Grammar — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="Arabic · Grammar board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="Arabic · Grammar worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="Arabic · Grammar lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">Arabic · Grammar worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
          <div class="planitem">
        <button class="plan__row t-gold" type="button">
            <span class="plan__day">Wed</span>
            <div><p class="row__title">Music</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">Music — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="Music board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="Music worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="Music lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">Music worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
          <div class="planitem">
        <button class="plan__row t-green" type="button">
            <span class="plan__day">Thu</span>
            <div><p class="row__title">Library</p><p class="row__meta">⁦08:30 – 14:00⁩</p></div>
        </button>
        <div class="plan__panel">
          <p class="plan__note">Library — bring your notebook and the printed worksheet. The teacher will review the exercise in class.</p>
          <p class="plan__sub">Pictures</p>
          <div class="shots">
            <button class="shot" type="button" data-title="Library board" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
            <button class="shot" type="button" data-title="Library worksheet" data-src="../assets/img/hw/sample.webp"><img src="../assets/img/hw/sample.webp" alt="" loading="lazy"></button>
          </div>
          <p class="plan__sub">Video</p>
          <div class="shots shots--2">
            <button class="shot shot--vid" type="button" data-title="Library lesson" data-meta="03:10" data-src="../assets/img/hw/sample.webp">
              <img src="../assets/img/hw/sample.webp" alt="" loading="lazy">
              <span class="shot__play"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 7.5v9l7.5-4.5z"/></svg></span>
              <span class="shot__len">03:10</span>
            </button>
          </div>
          <p class="plan__sub">Links &amp; files</p>
          <a class="fold__item" href="http://www.google.com" target="_blank" rel="noopener">
            <span class="fold__item-ico fold__item-ico--link">WWW</span>
            <span class="fold__item-title">Practice exercises</span>
            <span class="fold__item-meta">www.google.com</span>
          </a>
          <a class="fold__item" href="#">
            <span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>
            <span class="fold__item-title">Library worksheet.docx</span>
            <span class="fold__item-meta">Word · 210 KB</span>
          </a>
        </div>
          </div>
        </div>
      </div>




      <button class="btn btn--quiet btn--more" id="week-more" type="button">Load more</button>
-->





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

</div>
<script>
(function () {
  document.querySelectorAll('.planitem .plan__row').forEach(function (row) {
    row.addEventListener('click', function () { row.parentElement.classList.toggle('is-open'); });
  });
  var more = document.getElementById('week-more');
  more.addEventListener('click', function () {
    more.setAttribute('aria-busy', 'true');
    more.innerHTML = '<span class="spin"></span>Loading';
    setTimeout(function () {
      document.querySelectorAll('.week--old').forEach(function (w) { w.classList.add('is-shown'); });
      more.remove();
    }, 500);
  });
})();
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
