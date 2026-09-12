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
<title>   Helalia</title>
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
      <a class="back" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"></path>
        </svg>
      </a>
        <h1 class="hero__title">Revision</h1>
        <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id; ?>" aria-label="Alerts">
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

      <div class="tabs">
        <a class="tab " href="parent-homework.php?id=<?php echo $row_get_kid_data['id'];?>">Homework</a>
        <a class="tab is-active" href="parent-revision.php?id=<?php echo $row_get_kid_data['id'];?>">Revision</a> 
      </div>

      <div class="rows">

 <?php 
    mysqli_select_db($database , $database_database); 
    $query_get_subjects = "SELECT * FROM `subjects` WHERE `study_year` = '{$row_get_kid_data['study_year']}'  and `app` = 1  ";
    $get_subjects = mysqli_query($database ,$query_get_subjects) or die(mysqli_error($database));
    $row_get_subjects = mysqli_fetch_assoc($get_subjects);
    $totalRows_get_subjects = mysqli_num_rows($get_subjects);

  if($totalRows_get_subjects>0){ 
 
       do{ 
        $query_get_data = "SELECT COUNT(*) as `revision` FROM `revision` WHERE `study_year` = '{$row_get_kid_data['study_year']}' AND (`class` = '{$row_get_kid_data['class']}' ||  `class` = 0 ) AND `confirm` = 1 AND `subject` = '{$row_get_subjects['id']}' AND `date` ='{$today}' order BY `id` desc  ";
        $get_data = mysqli_query($database ,$query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        $totalRows_get_data = mysqli_num_rows($get_data);
        ?>

        <a class="row <?php echo getRandomColor(); ?>" href="parent-revision-view.php?id=<?php echo $row_get_subjects['id'];?>&kid=<?php echo $row_get_kid_data['id'];?>">
           <div class="row__body">
             <p class="row__title"><?php echo $row_get_subjects['name_eng']; ?></p>
           </div>
        <?php if($row_get_data['revision']>0){ ?>
          <span class="row__count row__count--gold"><?php echo $row_get_data['revision']; ?></span>
        <?php } ?>
        </a>
 <?php   }while($row_get_subjects = mysqli_fetch_assoc($get_subjects)); } ?> 
 


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

    <a class="nav__item  " href="parent-timeline.php">
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
<script src="../assets/js/app.js" defer></script>
</body>
</html> 