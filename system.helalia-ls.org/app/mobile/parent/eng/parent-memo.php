<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
       
      $kid_id = escape($_GET['id']); 
      
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
<title>Subjects · Helalia</title>
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
      <a class="back" href="parent-kid.php?id=<?php echo $kid_id;?>" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/>
        </svg>
      </a>
      <div class="grow">
        <p class="hero__eyebrow">Memo</p> 
      </div>

      <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id; ?>" aria-label="Alerts">
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

        <div class="sec">
          <h2 class="sec__title">Today</h2>
        </div>

    <?php
      // Only this kid's year (or school-wide 300) + this class (or all-classes 0/NULL).
      $memoYear = (int) $row_get_kid_data['study_year'];
      $memoClass = (int) $row_get_kid_data['class'];
      $memoTarget = "(`study_year` = '{$memoYear}' OR `study_year` = 300) AND (`class` = '{$memoClass}' OR `class` = 0 OR `class` IS NULL OR `class` = '')";

      $query_get_data_today = "SELECT * FROM `memos` WHERE {$memoTarget} AND `date` >= '{$today}' AND `date` < ('{$today}' + 86400) ORDER BY `id` DESC ";
      $get_data_today = mysqli_query($database, $query_get_data_today) or die(mysqli_error($database));
      $row_get_data_today = mysqli_fetch_assoc($get_data_today);
      $totalRows_get_data_today = mysqli_num_rows($get_data_today);

      $query_get_data_old = "SELECT * FROM `memos` WHERE {$memoTarget} AND `date` < '{$today}' ORDER BY `id` DESC ";
      $get_data_old = mysqli_query($database, $query_get_data_old) or die(mysqli_error($database));
      $row_get_data_old = mysqli_fetch_assoc($get_data_old);
      $totalRows_get_data_old = mysqli_num_rows($get_data_old);
    ?>

    <div class="rows">
      <?php
        if($totalRows_get_data_today>0){
          do{ ?> 
          <a class="row t-gold" href="parent-memo-item.php?id=<?php echo $row_get_data_today['id'];?>&kid=<?php echo $row_get_kid_data['id'];?>">
            <span class="row__ico">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"></path>
                <path d="M15 3v5h5M8 13h8M8 17h6"></path>
              </svg>
            </span>
              <div class="row__body">
                <p class="row__title"><?php echo $row_get_data_today['name_eng']; ?></p>
                <p class="row__meta"><?php echo date('d M Y', $row_get_data_today['date']); ?></p> 
              </div>
              <span class="chip chip--solid">New</span>
          </a> 
      <?php }while($row_get_data_today = mysqli_fetch_assoc($get_data_today));
       }else{ ?> 
        <a class="row " href="#">No memo found</a>    
        <?php } ?>     
  </div>

 

    <div class="rows<?php echo ($totalRows_get_data_today == 0 && $totalRows_get_data_old > 0) ? ' is-expanded' : ''; ?>">
      <?php
        if($totalRows_get_data_old >0){?>
          <div class="sec">
            <h2 class="sec__title">Previous</h2>
          </div>
      <?php
          do{ ?>
            <a class="row t-green hw--old" href="parent-memo-item.php?id=<?php echo $row_get_data_old['id'];?>&kid=<?php echo $row_get_kid_data['id'];?>">
              <span class="row__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"></path><path d="M15 3v5h5M8 13h8M8 17h6"></path></svg></span>
              <div class="row__body">
                <p class="row__title"><?php echo $row_get_data_old['name_eng']; ?></p>
                <p class="row__meta"><?php echo date('d M Y', $row_get_data_old['date']); ?></p>
              </div>
              <!-- <span class="chip chip--solid">Done</span> -->
            </a>
      <?php }while($row_get_data_old = mysqli_fetch_assoc($get_data_old)); 
       } ?>  
  </div>
         
     
 

      <?php if($totalRows_get_data_old >0){ ?>
         <button class="btn btn--quiet btn--more" id="hw-more" type="button">Load more</button>
      <?php } ?>
    
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

<script>
(function () {
  var more = document.getElementById('hw-more');
  if (!more) return;
  more.addEventListener('click', function () {
    more.setAttribute('aria-busy', 'true');
    more.innerHTML = '<span class="spin"></span>Loading';
    setTimeout(function () {
      var old = document.querySelector('.hw--old');
      if (old && old.closest('.rows')) {
        old.closest('.rows').classList.add('is-expanded');
      }
      more.remove();
    }, 600);
  });
})();
</script>
<script src="../assets/js/app.js?v=65" defer></script>
</body>
</html>
