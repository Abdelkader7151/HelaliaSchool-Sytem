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

      


mysqli_select_db($database, $database_database,);
$query_get_kids_absence = "SELECT * FROM `kids-absence` where `kid_id`='{$kid_id}' and `confirm` = 1  ORDER BY `date` DESC ";
$get_kids_absence = mysqli_query($database, $query_get_kids_absence) or die(mysqli_error($database));
$row_get_kids_absence = mysqli_fetch_assoc($get_kids_absence);
$totalRows_get_kids_absence = mysqli_num_rows($get_kids_absence);


$insertSQL = sprintf( "UPDATE `kids-absence` SET `parent_view`=%s  WHERE `kid_id`=%s AND `parent_view` IS NULL ",
                          GetSQLValueString($database,time(), "int"),
                          GetSQLValueString($database,$kid_id, "int")
                      );

mysqli_select_db($database, $database_database,);
mysqli_query($database, $insertSQL) or die(mysqli_error($database));

          $query_get_kids_vacations_accepted = "SELECT sum(days) AS `accepted` FROM `kids_vacations` WHERE `kid_id` = '{$kid_id}' AND `status` = 1 ";
          $get_kids_vacations_accepted = mysqli_query($database, $query_get_kids_vacations_accepted) or die(mysqli_error($database));
          $row_get_kids_vacations_accepted = mysqli_fetch_assoc($get_kids_vacations_accepted); 

          $query_get_kids_vacations_rejected = "SELECT sum(days) AS `rejected` FROM `kids_vacations` WHERE `kid_id` = '{$kid_id}' AND `status` = 2 ";
          $get_kids_vacations_rejected = mysqli_query($database, $query_get_kids_vacations_rejected) or die(mysqli_error($database));
          $row_get_kids_vacations_rejected = mysqli_fetch_assoc($get_kids_vacations_rejected); 



 ?> <!DOCTYPE html>
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
<title>  · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css">
<script src="https://use.fontawesome.com/aac8068caf.js"></script> 
<script src="https://kit.fontawesome.com/94981c2780.js" crossorigin="anonymous"></script>
<style>
  .load-more-btn {
    width: 100%;
    max-width: 200px;
    margin: 12px auto 20px;
    padding: 10px 16px;
    border-radius: 10px;
    border: 1px solid #112c5a;
    background: #fff;
    color: #112c5a;
    font-weight: 600;
    cursor: pointer;
    display: none;
    text-align: center;
    font-family: 'Cairo', system-ui, sans-serif;
  }
  .load-more-btn:hover {
    background: #f2f5fa;
  }
</style>
</head>
<body>
<div class="app">
  

  <header class="hero hero--tall">
    <div class="hero__row">
        <a class="back" href="parent-kid.php?id=<?php echo $kid_id;?>" aria-label="رجوع">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg>
        </a>
         <h1 class="hero__title">  الغياب</h1>
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
    
  
  <div class="stats stats--4up">

    <div class="stat t-coral">
      <p class="stat__label" style="text-transform:uppercase">إجمالي الغياب</p>
      <p class="stat__value"><?php echo $totalRows_get_kids_absence;?> ايام</p>
    </div>

    <div class="stat t-green">
      <p class="stat__label" style="text-transform:uppercase">  المقبولة</p>
      <p class="stat__value"><?php echo $row_get_kids_vacations_accepted['accepted'];?></p>
    </div>

    <div class="stat t-coral">
      <p class="stat__label" style="text-transform:uppercase">غير مقبولة</p>
      <p class="stat__value"><?php echo $row_get_kids_vacations_rejected['rejected'];?></p>
    </div>
  
    <div class=" " align="center" style="margin-top: 20px">  
      <a class="btn btn--gold btn--sm" href="parent-vacation.php?kid=<?php echo $kid_id;?>" style="text-align:center">
      <i class="fa fa-plus fa-lg stat__label pulse " aria-hidden="true"   ></i> طلب إجازة</a>
    </div>

  </div>




 <div class="sec">
    <h2 class="sec__title">ايام الغياب</h2>
  </div>

 <div class="rows" id="absence-rows">
       
    
 
 <?php if ($totalRows_get_kids_absence > 0) {
         do {
          mysqli_select_db($database, $database_database,);
          $query_get_kids_vacations = "SELECT * FROM `kids_vacations` WHERE `kid_id` = '{$kid_id}'  AND `vacation_date` <= '{$row_get_kids_absence['date']}' AND `vacation_end` > '{$row_get_kids_absence['date']}' ";
          $get_kids_vacations = mysqli_query($database, $query_get_kids_vacations) or die(mysqli_error($database));
          $row_get_kids_vacations = mysqli_fetch_assoc($get_kids_vacations);
          $totalRows_get_kids_vacations = mysqli_num_rows($get_kids_vacations);
          ?> 
           <a class="row  <?php if ($totalRows_get_kids_vacations > 0 && $row_get_kids_vacations['status']>0) { if($row_get_kids_vacations['status']==1){echo " t-green ";} if($row_get_kids_vacations['status']==2){echo " t-coral ";} }else{ echo " t-gold ";} ?> " href="<?php if ($totalRows_get_kids_vacations < 1) {echo 'parent-vacation.php?kid='.$kid_id ;}else{echo "#";} ?>"> 
      <span class="row__ico">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="5" width="18" height="16" rx="2"/>
          <path d="M3 10h18M8 3v4M16 3v4"/>
        </svg>
      </span>

      <div class="row__body">
        <p class="row__title"><?php echo date("d M, Y",$row_get_kids_absence['date']);?></p>
        <p class="row__meta">
         <?php if ($totalRows_get_kids_vacations > 0 && $row_get_kids_vacations['status']>0) { ?> 
          <?php if($row_get_kids_vacations['status']==1){echo "استلام الطلب  "; } ?>
          <?php if($row_get_kids_vacations['status']==2){echo "تم رفض السبب"; } ?>
          <?php }else{ echo "يرجى تقديم سبب الغياب"; } ?>
        </p> 
      </div>
        <?php if ($totalRows_get_kids_vacations > 0 && $row_get_kids_vacations['status']>0) { ?> 
          <?php if($row_get_kids_vacations['status']==1){?> <span class="chip chip--ok">مقبولة</span> <?php } ?>
          <?php if($row_get_kids_vacations['status']==2){?> <span class="chip chip--no">غير مقبولة</span> <?php } ?>
          <?php }else{?>
          <span class="chip chip--wait">إجراء معلق</span>
       <?php } ?> 
    </a>
    <?php } while ($row_get_kids_absence = mysqli_fetch_assoc($get_kids_absence));
    } ?>
 

  </div>  
  <button class="load-more-btn" type="button" data-target="absence-rows">تحميل المزيد</button>


   <div class="sec">
    <h2 class="sec__title">طلبات مقدمة</h2>
  </div>

 <div class="rows" id="vacation-rows">  
 
 <?php  
      mysqli_select_db($database, $database_database,);
      $query_get_kids_vacations = "SELECT * FROM `kids_vacations` WHERE `kid_id` = '{$kid_id}' AND `study_year` = '{$row_get_kid_data['study_year']}' AND `absence_id` IS NULL  ORDER BY `vacation_date` DESC ";
      $get_kids_vacations = mysqli_query($database, $query_get_kids_vacations) or die(mysqli_error($database));
      $row_get_kids_vacations = mysqli_fetch_assoc($get_kids_vacations);
      $totalRows_get_kids_vacations = mysqli_num_rows($get_kids_vacations);

      if($totalRows_get_kids_vacations>0){ 
             do {?>
    <a class="row  <?php if ( $row_get_kids_vacations['status']>0) { if($row_get_kids_vacations['status']==1){echo " t-green ";} if($row_get_kids_vacations['status']==2){echo " t-coral ";} }else{ echo " t-gold ";} ?> " href="#"> 
      <span class="row__ico">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="5" width="18" height="16" rx="2"/>
          <path d="M3 10h18M8 3v4M16 3v4"/>
        </svg>
      </span>

      <div class="row__body">
         <p class="row__title" style="font-size:14px"><?php echo date("d M, Y",$row_get_kids_vacations['vacation_date']);?> - <?php echo date("d M, Y",$row_get_kids_vacations['vacation_end']); $days = floor(($row_get_kids_vacations['vacation_end']-$row_get_kids_vacations['vacation_date'])/86400);?></p>
        <p class="row__meta"> 
          <?php if($row_get_kids_vacations['type']==1){echo "Reason Sick"; } ?>
          <?php if($row_get_kids_vacations['status']==2){echo "Reason Championship"; } ?>
          <?php if($row_get_kids_vacations['status']==3){echo "Reason Travel"; } ?>
          <?php if($row_get_kids_vacations['status']==4){echo "Reason Other"; } ?> 
        </p>    
      </div> 
        <?php if ( $row_get_kids_vacations['status']>0) { ?> 
          <?php if($row_get_kids_vacations['status']==1){?> <span class="chip chip--ok" style="text-align:center"><?php echo $days;?>  <?php if($days>1){echo " ايام ";}else{echo " يوم ";}?><br>مقبول</span> <?php } ?>
          <?php if($row_get_kids_vacations['status']==2){?> <span class="chip chip--no" style="text-align:center"><?php echo $days;?>  <?php if($days>1){echo " ايام ";}else{echo " يوم ";}?><br>  غير مقبول</span> <?php } ?>
          <?php }else{?>
          <span class="chip chip--wait" style="text-align:center"><?php echo $days;?>  <?php if($days>1){echo " ايام ";}else{echo " يوم ";}?><br>إجراء معلق</span>
       <?php } ?> 

</a>
    <?php } while ($row_get_kids_vacations = mysqli_fetch_assoc($get_kids_vacations)); }?>
 

  </div>  
  <button class="load-more-btn" type="button" data-target="vacation-rows">تحميل المزيد</button>
  

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
<script src="../assets/js/app.js" defer></script>

<script>
(function () {
  var CHUNK = 3;

  function initLoadMore(containerId) {
    var container = document.getElementById(containerId);
    if (!container) return;

    var rows = container.querySelectorAll(':scope > .row');
    var btn = document.querySelector('.load-more-btn[data-target="' + containerId + '"]');
    if (!btn || rows.length === 0) return;

    var visibleCount = 0;

    function showNextChunk() {
      var next = Math.min(visibleCount + CHUNK, rows.length);
      for (var i = visibleCount; i < next; i++) {
        rows[i].style.display = '';
      }
      visibleCount = next;

      if (visibleCount >= rows.length) {
        btn.style.display = 'none';
      }
    }

    for (var i = 0; i < rows.length; i++) {
      rows[i].style.display = i < CHUNK ? '' : 'none';
    }
    visibleCount = Math.min(CHUNK, rows.length);

    if (rows.length > CHUNK) {
      btn.style.display = 'block';
    }

    btn.addEventListener('click', showNextChunk);
  }

  initLoadMore('absence-rows');
  initLoadMore('vacation-rows');
})();
</script>

<?php if (isset($_GET['done'])) { ?> 
     <style>
      .hl-modal{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
        justify-content:center;padding:20px;background:rgba(17,44,90,.55);
        -webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px);
        opacity:0;transition:opacity .25s ease}
      .hl-modal.is-open{opacity:1}
      .hl-modal__box{width:100%;max-width:340px;background:#fff;border-radius:18px;
        padding:32px 24px;text-align:center;box-shadow:0 20px 50px rgba(0,0,0,.25);
        transform:scale(.9);transition:transform .25s cubic-bezier(.34,1.56,.64,1)}
      .hl-modal.is-open .hl-modal__box{transform:scale(1)}
      .hl-modal__icon{width:64px;height:64px;margin:0 auto 16px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        background:#e6f7ed;color:#1e9e5a}
      .hl-modal__icon svg{width:34px;height:34px}
      .hl-modal__text{margin:0;font-size:19px;font-weight:700;color:#112c5a;
        font-family:'Plus Jakarta Sans',system-ui,sans-serif}
      @media (prefers-reduced-motion:reduce){
        .hl-modal,.hl-modal__box{transition:none}
      }
    </style> 
 
    <div class="hl-modal" id="success-message" role="alertdialog" aria-live="assertive" aria-label="Success">
      <div class="hl-modal__box">
        <div class="hl-modal__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/><path d="M8 12.5l2.5 2.5L16 9.5"/>
          </svg>
        </div>
        <p class="hl-modal__text">تم الإرسال بنجاح</p>
      </div>
    </div>

     <script>
      (function () {
        var m = document.getElementById('success-message');
        if (!m) return;  

        function close() {
          m.classList.remove('is-open');
          setTimeout(function () { m.style.display = 'none'; }, 250);
        }

        requestAnimationFrame(function () { m.classList.add('is-open'); });

        setTimeout(close, 3000);
        m.addEventListener('click', close);
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') close();
        });
      })();
    </script>
 

<?php } ?>


</body>
</html>