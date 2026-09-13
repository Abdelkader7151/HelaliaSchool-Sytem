<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      require_once dirname(__DIR__) . '/includes/file-media.php';
      
      $kid_id = escape($_GET['kid']); 
      $id = escape($_GET['id']); 
      
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

       

        $query_get_data = "SELECT * FROM `memos` WHERE `id` = '{$id}' ";
        $get_data = mysqli_query($database ,$query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        $totalRows_get_data = mysqli_num_rows($get_data);

        if($totalRows_get_data==0){
          header("Location: parent-view.php");
          exit();
        }

        // Block opening a memo that is not for this kid's year/class.
        $kidYear = (int) $row_get_kid_data['study_year'];
        $kidClass = (int) $row_get_kid_data['class'];
        $memoYear = (int) $row_get_data['study_year'];
        $memoClassRaw = $row_get_data['class'];
        $memoClassOk = ($memoClassRaw === null || $memoClassRaw === '' || (int) $memoClassRaw === 0 || (int) $memoClassRaw === $kidClass);
        $memoYearOk = ($memoYear === $kidYear || $memoYear === 300);
        if (!$memoYearOk || !$memoClassOk) {
          header("Location: parent-memo.php?id=" . rawurlencode($kid_id));
          exit();
        }


       
      
 


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
<title>الواجبات · الإنجليزية · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=18">
</head>
<body>
<div class="app">
    <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-memo.php?id=<?php echo $kid_id; ?>" aria-label="رجوع">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/>
        </svg>
      </a>
      <div class="grow">
        <p class="hero__eyebrow">مذكرة</p>
        
      </div>


      <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id; ?>" aria-label="التنبيهات">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"/>
          <path d="M10 20a2 2 0 0 0 4 0"/>
        </svg>
        <?php alert($row_get_user['id'], $kid_id); ?>
      </a>
    </div>
  </div>
    
    
  </header>
 
  
<main class="page">
  
<div class="card stack">

        <?php
          $memoTitle = trim((string) ((!empty($row_get_data['name_arb'])) ? $row_get_data['name_arb'] : $row_get_data['name_eng']));
          $memoText = trim((string) ((!empty(trim((string) $row_get_data['text_arb']))) ? $row_get_data['text_arb'] : $row_get_data['text_eng']));
        ?>
        <h2 class="hwtitle"><?php echo htmlspecialchars($memoTitle !== '' ? $memoTitle : 'مذكرة', ENT_QUOTES, 'UTF-8'); ?></h2>
        <?php if ($memoText !== '') { ?>
        <p class="lede">
         <?php echo $memoText; ?></p>
        <?php } ?>
        <div class="chiprow">
          <span class="chip t-gold"><?php echo emp_name($row_get_data['emp_id']); ?></span>
          <span class="chip t-coral chip--solid"><?php echo date("d M, Y", $row_get_data['date']); ?></span>
        </div>
         <?php echo parent_render_banner_media($row_get_data['banner'], '../../../../homework/', 'arb'); ?>
      </div>


      <div class="sec">
        <h2 class="sec__title">بيانات</h2>
      </div>


      <div class="folds"> 


       <?php
          $query_get_memo_videos = "SELECT * FROM `memo_attachments` WHERE `memo_id` = '{$id}' AND `type` = 1 ";
          $get_memo_videos = mysqli_query($database ,$query_get_memo_videos) or die(mysqli_error($database));
          $row_get_memo_videos = mysqli_fetch_assoc($get_memo_videos);
          $totalRows_get_memo_videos = mysqli_num_rows($get_memo_videos);
         
          if($totalRows_get_memo_videos > 0){ ?>

                      <!-- videos  type 1-->
                      <div class="fold t-coral">     
                        <button class="fold__head" type="button">
                          <span class="row__ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 6.5A1.5 1.5 0 0 1 5.5 5h8A1.5 1.5 0 0 1 15 6.5v11A1.5 1.5 0 0 1 13.5 19h-8A1.5 1.5 0 0 1 4 17.5v-11z"/>
                            <path d="m15 10.5 5-3v9l-5-3"/>
                          </svg>
                        </span>
                          <span class="fold__body">
                            <span class="row__title">فيديو</span>
                            <span class="row__meta"><?php echo $totalRows_get_memo_videos;?> ملف</span>
                          </span>
                          <span class="fold__chev">›</span>
                        </button>  

                        <div class="fold__panel">
                          <div class="shots shots--2">
                           <?php $vid_n = 0; do{ $vid_n++;
                             $vid_path = '../../../../homework/' . $row_get_memo_videos['video'];
                             $vid_title = 'Video ' . $vid_n;
                           ?>
                             <button class="shot shot--vid" type="button" data-kind="video" title="<?php echo htmlspecialchars($vid_title); ?>" data-title="<?php echo htmlspecialchars($vid_title); ?>" data-src="<?php echo htmlspecialchars($vid_path); ?>">
                              <video src="<?php echo htmlspecialchars($vid_path); ?>" preload="metadata" muted playsinline></video>
                              <span class="shot__play">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                  <path d="M9 7.5v9l7.5-4.5z"/></svg>
                                </span>
                              <span class="shot__len"></span>
                            </button>
                           <?php  }while($row_get_memo_videos = mysqli_fetch_assoc($get_memo_videos)); ?> 

                          </div>
                        </div>
                      </div> 
  <?php } 
 

          $query_get_memo_picture = "SELECT `picture` FROM `memo_attachments` WHERE `memo_id` = '{$id}' AND `type` = 2 ";
          $get_memo_picture = mysqli_query($database ,$query_get_memo_picture) or die(mysqli_error($database));
          $row_get_memo_picture = mysqli_fetch_assoc($get_memo_picture);
          $totalRows_get_memo_picture = mysqli_num_rows($get_memo_picture);
         
          if($totalRows_get_memo_picture > 0){ ?>

            <!-- pictures type 2 --> 
            <div class="fold t-navy">
              <button class="fold__head" type="button">
                <span class="row__ico">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="3" y="5" width="18" height="14" rx="2"/>
                  <circle cx="9" cy="11" r="2"/>
                  <path d="m21 16-5-5-8 8"/></svg>
                </span>
                <span class="fold__body">
                  <span class="row__title">Pictures</span>
                  <span class="row__meta"><?php echo $totalRows_get_memo_picture;?> images</span>
                </span>
                <span class="fold__chev">›</span>
              </button>
              <div class="fold__panel">
                <div class="shots">
                  <?php $pic_n = 0; do{ $pic_n++;
                    $pic_path = '';
                    if ($row_get_memo_picture['picture'] != NULL && file_exists('../../../../homework/' . $row_get_memo_picture['picture'])) {
                      $pic_path = '../../../../homework/' . $row_get_memo_picture['picture'];
                    }
                    $pic_title = 'Picture ' . $pic_n;
                  ?>
                  <button class="shot" type="button" data-kind="photo" title="<?php echo htmlspecialchars($pic_title); ?>" data-title="<?php echo htmlspecialchars($pic_title); ?>" data-src="<?php echo htmlspecialchars($pic_path); ?>">
                    <img src="<?php echo htmlspecialchars($pic_path); ?>" alt="<?php echo htmlspecialchars($pic_title); ?>">
                  </button>
                  <?php  } while($row_get_memo_picture = mysqli_fetch_assoc($get_memo_picture)); ?> 
                </div>
              </div>
            </div>

 <?php } 
 
          $query_get_memo_links = "SELECT `url` FROM `memo_attachments` WHERE `memo_id` = '{$id}' AND `type` = 3 ";
          $get_memo_links = mysqli_query($database ,$query_get_memo_links) or die(mysqli_error($database));
          $row_get_memo_links = mysqli_fetch_assoc($get_memo_links);
          $totalRows_get_memo_links = mysqli_num_rows($get_memo_links);
         
          if($totalRows_get_memo_links > 0){ ?>


    <!-- Links type 3 -->
    <div class="fold t-gold">
      <button class="fold__head" type="button">
        <span class="row__ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M10.5 13.5a4 4 0 0 0 5.7 0l2.3-2.3a4 4 0 1 0-5.7-5.7l-1 1"/>
            <path d="M13.5 10.5a4 4 0 0 0-5.7 0l-2.3 2.3a4 4 0 1 0 5.7 5.7l1-1"/>
          </svg>
        </span>
        <span class="fold__body">
          <span class="row__title">روابط</span>
          <span class="row__meta"><?php echo $totalRows_get_memo_links;?> رابط</span>
        </span>
        <span class="fold__chev">›</span>
      </button>
      <div class="fold__panel">
         <?php do{ ?>
        <a class="fold__item" href="<?php echo $row_get_memo_links['url'];?>" >
          <span class="fold__item-ico fold__item-ico--link">›</span>
          <!--span class="fold__item-title">Practice exercises</span>-->
          <span class="fold__item-meta"><?php echo $row_get_memo_links['url'];?></span>
        </a>
          <?php  } while($row_get_memo_links = mysqli_fetch_assoc($get_memo_links)); ?> 
      </div>
    </div>
     <?php }  
 
          $query_get_memo_files = "SELECT `file` FROM `memo_attachments` WHERE `memo_id` = '{$id}' AND `type` = 4 ";
          $get_memo_files = mysqli_query($database ,$query_get_memo_files) or die(mysqli_error($database));
          $row_get_memo_files = mysqli_fetch_assoc($get_memo_files);
          $totalRows_get_memo_files = mysqli_num_rows($get_memo_files);
         
          if($totalRows_get_memo_files > 0){ ?> 

    <!-- files type 4 -->
    <div class="fold t-green">
     
     <button class="fold__head" type="button">
        <span class="row__ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
          <path d="M15 3v5h5M8 13h8M8 17h6"/>
        </svg>
      </span>
        <span class="fold__body">
          <span class="row__title">ملفات</span>
          <span class="row__meta">Word · Excel · PDF</span>
        </span>
        <span class="fold__chev">›</span>
      </button>  
      
      <div class="fold__panel">
<?php do{
        $fileName = trim((string) $row_get_memo_files['file']);
        $fileHref = parent_homework_public_url($fileName);
        if ($fileHref === '') { continue; }
?>
        <a class="fold__item" href="<?php echo htmlspecialchars($fileHref, ENT_QUOTES, 'UTF-8'); ?>" rel="noopener">  
          <?php if(strtolower(pathinfo($fileName, PATHINFO_EXTENSION))=='pdf'){ echo $pdf; } ?>
          <?php if(strtolower(pathinfo($fileName, PATHINFO_EXTENSION))=='doc' || strtolower(pathinfo($fileName, PATHINFO_EXTENSION))=='docx' ){ echo $doc; } ?> 
          <?php if(strtolower(pathinfo($fileName, PATHINFO_EXTENSION))=='xls' || strtolower(pathinfo($fileName, PATHINFO_EXTENSION))=='xlsx' ){ echo $doc; } ?> 
       
          <!--<span class="fold__item-title">Unit 4 worksheet.docx</span>-->
          <span class="fold__item-meta">تحميل</span>
        </a> 
    <?php  } while($row_get_memo_files = mysqli_fetch_assoc($get_memo_files)); ?>     
      </div>

    </div>
<?php }?>



  </div>



</main>



<!-- Lightbox modal (was missing — required by the JS below) -->
<style>
  #lightbox {
    display: none !important;
    position: fixed;
    inset: 0;
    z-index: 999;
  }
  #lightbox.is-open {
    display: block !important;
  }
  .lightbox .light__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.85);
  }
  .lightbox .light__frame {
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
  }
  .lightbox .light__media {
    max-width: 90vw;
    max-height: 75vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .lightbox .light__media img {
    max-width: 100%;
    max-height: 75vh;
    object-fit: contain;
    border-radius: 8px;
  }
  .lightbox .light__media video {
    max-width: 100%;
    max-height: 75vh;
    border-radius: 8px;
    display: none;
  }
  .lightbox .light__close {
    position: fixed;
    top: 16px;
    right: 16px;
    z-index: 2;
    background: rgba(0,0,0,0.4);
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
  }
  .lightbox .light__close svg { width: 24px; height: 24px; display: block; }
  .lightbox .light__nav {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    background: rgba(0,0,0,0.4);
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
  }
  .lightbox .light__nav svg { width: 24px; height: 24px; display: block; }
  .lightbox .light__nav--prev { left: 16px; }
  .lightbox .light__nav--next { right: 16px; }
  .lightbox .light__footer {
    margin-top: 16px;
    color: #fff;
    text-align: center;
  }
  .lightbox .light__caption { display: block; font-size: 15px; }
  .lightbox .light__count { display: block; font-size: 13px; opacity: 0.7; margin-top: 4px; }
</style>
<div class="lightbox" id="lightbox">
  <div class="light__backdrop"></div>
  <div class="light__frame" id="lb-frame">
    <button class="light__close" id="lb-close" type="button" aria-label="Close">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M18 6 6 18M6 6l12 12"/>
      </svg>
    </button>

    <button class="light__nav light__nav--prev" id="lb-prev" type="button" aria-label="Previous">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M15 19 8 12l7-7"/>
      </svg>
    </button>

    <div class="light__media">
      <img id="lb-img" src="" alt="">
      <video id="lb-video" controls playsinline></video>
    </div>

    <button class="light__nav light__nav--next" id="lb-next" type="button" aria-label="Next">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="m9 5 7 7-7 7"/>
      </svg>
    </button>

    <div class="light__footer">
      <span class="light__caption" id="lb-caption"></span>
      <span class="light__count" id="lb-count"></span>
    </div>
  </div>
</div>


 
       
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
  var SHOTS = [];
  var light = document.getElementById('lightbox');
  var frame = document.getElementById('lb-frame');
  var caption = document.getElementById('lb-caption');
  var count = document.getElementById('lb-count');
  var img = document.getElementById('lb-img');
  var video = document.getElementById('lb-video');
  var i = 0;

  function stopVideo() {
    if (!video) return;
    video.pause();
    video.removeAttribute('src');
    video.load();
    video.style.display = 'none';
  }

  function show(n) {
    i = (n + SHOTS.length) % SHOTS.length;
    var item = SHOTS[i];

    if (item.kind === 'video') {
      if (img) img.style.display = 'none';
      if (video) {
        video.src = item.src;
        video.style.display = 'block';
        video.load();
      }
    } else {
      stopVideo();
      if (img) {
        img.alt = item.title;
        img.src = item.src;
        img.style.display = 'block';
      }
    }

    if (caption) caption.textContent = item.title + (item.meta ? ' · ' + item.meta : '');
    if (count) count.textContent = (i + 1) + ' / ' + SHOTS.length;
    if (frame) frame.classList.toggle('light__frame--vid', item.kind === 'video');
  }
  function open(n) { show(n); if (light) light.classList.add('is-open'); }
  function close() { stopVideo(); if (light) light.classList.remove('is-open'); }

  document.querySelectorAll('.shots').forEach(function (row) {
    var tiles = Array.prototype.slice.call(row.querySelectorAll('.shot'));
    var set = tiles.map(function (t) {
      return {
        title: t.getAttribute('data-title'),
        meta: t.getAttribute('data-meta') || '',
        kind: t.getAttribute('data-kind'),
        src: t.getAttribute('data-src') || ''
      };
    });
    tiles.forEach(function (t, n) {
      t.addEventListener('click', function () { SHOTS = set; open(n); });
    });
  });

  // Show real durations on video thumbnails once metadata loads
  document.querySelectorAll('.shot--vid video').forEach(function (v) {
    v.addEventListener('loadedmetadata', function () {
      var lenEl = v.closest('.shot') ? v.closest('.shot').querySelector('.shot__len') : null;
      if (!lenEl || !isFinite(v.duration)) return;
      var total = Math.round(v.duration);
      var m = Math.floor(total / 60);
      var s = total % 60;
      lenEl.textContent = m + ':' + (s < 10 ? '0' : '') + s;
    });
  });

  if (light) {
    var prev = document.getElementById('lb-prev');
    var next = document.getElementById('lb-next');
    var closeBtn = document.getElementById('lb-close');
    if (prev) prev.addEventListener('click', function () { show(i - 1); });
    if (next) next.addEventListener('click', function () { show(i + 1); });
    if (closeBtn) closeBtn.addEventListener('click', close);
    var backdrop = light.querySelector('.light__backdrop');
    if (backdrop) backdrop.addEventListener('click', close);
    light.addEventListener('click', function (e) { if (e.target === light) close(); });
    document.addEventListener('keydown', function (e) {
      if (!light.classList.contains('is-open')) return;
      if (e.key === 'Escape') close();
      if (e.key === 'ArrowRight') show(i + 1);
      if (e.key === 'ArrowLeft') show(i - 1);
    });
  }
})();

document.querySelectorAll('.fold__head').forEach(function (head) {
  head.addEventListener('click', function () {
    head.parentElement.classList.toggle('is-open');
  });
});
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
