<?php require_once('../../Connections/database.php');
      include("../../includes/functions_arb.php");
      
      mysqli_select_db($database, $database_database,);
      $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}'";
      $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
      $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
      $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

 

      
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
<title>أبنائي · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=21">
<script src="https://use.fontawesome.com/00bc8e036a.js"></script>
</head>
<body>
<div class="app">
  <header class="hero hero--tall">

    <div class="hero__row">
      <div class="grow">
              <p class="hero__eyebrow">ولي الأمر</p>
              <h1 class="hero__title">أبنائي</h1></div>
        <div class="bells">
          <a class="bell bell--alert" href="parent-alerts.php" aria-label="تنبيهات">
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
    <div class="kids">
      <?php if($totalRows_get_kids_list>0){ 
   do{  
        $query_get_kid_info = "SELECT * FROM `kids` where `id` = '{$row_get_kids_list['kid_id']}'";
        $get_kid_info = mysqli_query($database, $query_get_kid_info) or die(mysqli_error($database));
        $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
        $totalRows_get_kid_info = mysqli_num_rows($get_kid_info); 
         if($totalRows_get_kid_info>0){  ?> 
              <a class="kidcard" href="<?php if($row_get_kid_info['data_update']==0){echo "parent-kid-update-data.php";}else{echo "parent-kid.php";}?>?id=<?php echo $row_get_kid_info['id'];?>">
              <?php 
                $query_get_question = "SELECT `id` FROM `ask_teacher` where `kid_id` = '{$row_get_kids_list['kid_id']}' AND `view` = 0 AND `respond` > 0 AND `del` = 0  ";
                $get_question =mysqli_query($database ,$query_get_question) or die(mysqli_error($database));
                $row_get_question = mysqli_fetch_assoc($get_question);
                $totalRows_get_question = mysqli_num_rows($get_question); 
                 ?>
    <div class="kidcard__photo">
          <img src="../../../../kids/<?php if($row_get_kid_info['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_info['picture'])==1){echo $row_get_kid_info['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_info['fn_name'];?>">
          
              <?php if($totalRows_get_question>0){ ?>
                <span class="kidcard__hw " title="New">
                 <i class="fa fa-question fa-lg pulse" aria-hidden="true" style="margin-top:3px"></i><?php echo $totalRows_get_question; ?></span>
              <?php } ?>

          <span class="kidcard__stage"><?php echo year_of_study_title($row_get_kid_info['study_year']); ?></span>
        </div>
        <div class="kidcard__body">
          <p class="kidcard__name"><?php echo $row_get_kid_info['fn_name'];?></p>
          <p class="kidcard__meta"><?php echo year_of_study($row_get_kid_info['study_year']); ?> · ⁦<?php echo class_name($row_get_kid_info['class']);?>⁩</p>
        </div>
      </a>   
     <?php } }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list)); }?> 
    </div>
</main>

<nav class="nav nav--trio" aria-label="الرئيسية" style="height: 90px">

    <a class="nav__item is-active" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="9" cy="8" r="3.2"/>
        <path d="M3 19a6 6 0 0 1 12 0"/>
        <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
        <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
      </svg>
      <span>الطلاب</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/>
        <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/>
        <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/>
      </svg>
      <span>الاخبار</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
      </svg>
      <span>الإعدادات</span>
      <span class="nav__dot"></span>
    </a>

  </nav>


 
     <a class="fab" href="parent-add-kid.php" aria-label="Add Kid" style="bottom:100px">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M12 5v14M5 12h14"/></svg>
    </a>
 

</div>
<script>
/* bell__badge drops out at zero, so the bell only rings when there is news */
document.querySelectorAll('.bell__badge').forEach(function (b) {
  if (parseInt(b.textContent, 10) > 0 === false) b.remove();
});
</script>
<script src="../assets/js/app.js?v=65" defer></script>
</body>
</html> 