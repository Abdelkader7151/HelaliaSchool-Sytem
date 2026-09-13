<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
 
 


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
<title>Subjects Â· Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css">
</head>
<body>
<div class="app">
  <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-view.php" data-helalia-back="parent-view.php" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"></path>
        </svg>
      </a>
        <h1 class="hero__title">Latest News</h1>
        <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php" aria-label="Alerts">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
          <path d="M10 20a2 2 0 0 0 4 0"></path>
        </svg>
       <?php alert($row_get_user['id'], 0); ?>
      </a>
    </div>
  </div>  

  </header>
  
  
  

  
  
  <main class="page">
  <?php
    $query_get_timeline = "SELECT * FROM `timeline` ORDER BY `id` desc ";
    $get_timeline = mysqli_query($database, $query_get_timeline) or die(mysqli_error($database));
    $row_get_timeline = mysqli_fetch_assoc($get_timeline);
    $totalRows_get_timeline = mysqli_num_rows($get_timeline);
    if($totalRows_get_timeline>0){
      $more = $totalRows_get_timeline; ?>
      <div class="posts" id="post-list">
      
      
      
      
 <?php $i=0; do{

    // ---- Build the same data the card displays, once, so the modal
    // can never show anything other than what's on the card you clicked.
    $post_date_display = htmlspecialchars(date("d M Y", $row_get_timeline['date']), ENT_QUOTES, 'UTF-8');
    $post_title        = htmlspecialchars($row_get_timeline['title_eng'], ENT_QUOTES, 'UTF-8');
    $post_text         = htmlspecialchars($row_get_timeline['text_eng'], ENT_QUOTES, 'UTF-8');

    $has_banner = ($row_get_timeline['banner'] != NULL && file_exists('../../../../events/' . $row_get_timeline['banner']) == 1);
    $post_src   = $has_banner ? '../../../../events/' . htmlspecialchars($row_get_timeline['banner'], ENT_QUOTES, 'UTF-8') : '';

    // Only marked as a video when the banner's own extension says so -
    // there's no separate "kind" column in the table.
    $video_exts = array('mp4', 'mov', 'webm', 'm4v');
    $ext        = $has_banner ? strtolower(pathinfo($row_get_timeline['banner'], PATHINFO_EXTENSION)) : '';
    $post_kind  = in_array($ext, $video_exts) ? 'video' : 'photo';

    // No `link` column in this table today - left blank so the modal
    // link row stays hidden. Wire this up if/when the column exists.
    $post_link = '';
    ?>
      <button class="post <?php if($i>4){echo " post--old ";}?>" type="button"
        data-post="<?php echo $i;?>"
        data-date="<?php echo $post_date_display;?>"
        data-title="<?php echo $post_title;?>"
        data-text="<?php echo $post_text;?>"
        data-src="<?php echo $post_src;?>"
        data-kind="<?php echo $post_kind;?>"
        data-link="<?php echo htmlspecialchars($post_link, ENT_QUOTES, 'UTF-8');?>">
        <div class="post__head">
          <img class="post__av" src="../assets/img/logo-icon.png" alt="">
          <span class="post__who">
            <span class="post__author"><?php echo $post_title;?></span> 
          </span>
        </div>
        <span class="post__title"><span class="post__date"><?php echo $post_date_display;?></span></span>
        <span class="post__excerpt"><?php echo $post_text;?></span>
        <div class="post__media">
          <?php if($has_banner){?>
          <img src="<?php echo $post_src;?>" alt="" loading="lazy">
          <?php }?>
        </div>
        <div class="post__foot">
           <?php if($has_banner){?>
          <span class="post__tag">Photo</span>
           <?php }?>
          <span>Tap to read more</span>
        </div>
      </button>
<?php $i++; }while($row_get_timeline = mysqli_fetch_assoc($get_timeline));?>
 

   
   
      </div>
       <?php if($more>5){?>
        <button class="btn btn--quiet btn--more" id="post-more" type="button">Load more</button>
       <?php }} ?>
    </main>
    


          
 <nav class="nav nav--trio" aria-label="Home"  style="height: 90px">

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
    
    <a class="nav__item is-active" href="parent-timeline.php">
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
        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
        <span>Settings</span>
        <span class="nav__dot"></span>
    </a>
  </nav>





  <div class="modal" id="post-modal" role="dialog" aria-modal="true" aria-labelledby="pm-title">
    <div class="modal__card">
      <div class="modal__media" id="pm-media"><img id="pm-img" alt=""></div>
      <p class="modal__date" id="pm-date"></p>
      <p class="modal__title" id="pm-title"></p>
      <p class="modal__meta" id="pm-text"></p>
      <a class="modal__link" id="pm-link" href="#" target="_blank" rel="noopener"></a>
      <button class="btn btn--quiet modal__close" id="pm-close" type="button">Close</button>
    </div>
  </div>
</div>



<script>
(function () {
  var modal = document.getElementById('post-modal');
  var img = document.getElementById('pm-img');
  var media = document.getElementById('pm-media');
  var link = document.getElementById('pm-link');

  // Reads straight off the clicked card's own data-* attributes, so
  // the modal can never show a different post than the one tapped -
  // no separate array to fall out of sync with what's on screen.
  function open(card) {
    var d = card.dataset;

    if (d.src) {
      img.src = d.src;
      img.alt = d.title || '';
      media.style.display = '';
    } else {
      img.removeAttribute('src');
      media.style.display = 'none';
    }
    media.classList.toggle('light__frame--vid', d.kind === 'video');

    document.getElementById('pm-date').textContent = d.date + (d.kind === 'video' ? ' Â· Video' : '');
    document.getElementById('pm-title').textContent = d.title || '';
    document.getElementById('pm-text').textContent = d.text || '';

    if (d.link) {
      link.href = d.link;
      link.textContent = d.link;
      link.style.display = '';
    } else {
      link.style.display = 'none';
    }

    modal.classList.add('is-open');
  }
  function close() { modal.classList.remove('is-open'); }

  document.querySelectorAll('.post').forEach(function (card) {
    card.addEventListener('click', function () { open(card); });
  });
  document.getElementById('pm-close').addEventListener('click', close);
  modal.addEventListener('click', function (e) { if (e.target === modal) close(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

  var more = document.getElementById('post-more');
  if (more) {
    more.addEventListener('click', function () {
      more.setAttribute('aria-busy', 'true');
      more.innerHTML = '<span class="spin"></span>Loading';
      setTimeout(function () {
        document.getElementById('post-list').classList.add('is-expanded');
        more.remove();
      }, 500);
    });
  }
})();
</script>
<script src="../assets/js/app.js?v=41" defer></script>
</body>
</html>
