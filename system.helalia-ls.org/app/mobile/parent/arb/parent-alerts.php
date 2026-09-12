<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
       
     if(isset($_GET['del']) && escape($_GET['del']) >0 ){
          $del = escape($_GET['del']);
          $kid_id = escape($_GET['kid']);  
          $updateSQL1 = sprintf("UPDATE `notifications` SET `del`=%s  WHERE `id`=%s AND `kid_id` =%s  ",
                            GetSQLValueString($database ,1, "int"),
                            GetSQLValueString($database ,$del, "int"), 
                            GetSQLValueString($database ,$kid_id, "int"));

           mysqli_query($database , $updateSQL1) or die(mysqli_error($database));   
       }

       
 if(isset($_GET['kid']) && escape($_GET['kid']) >0 ){  
    
        $kid_id = escape($_GET['kid']);    
             
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
  }



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
<title>المواد · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css">
<style>
.row.row--hidden { display: none; }
.alerts-more { display: block; width: 100%; text-align: center; margin: 14px 0 4px; }
</style>
</head>
<body>
<div class="app">
  <header class="hero hero--tall">
    <div class="hero__row">
        <a class="back" href="#" onclick="event.preventDefault(); history.back();" aria-label="رجوع">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg>
        </a>
         <h1 class="hero__title">الاشعارات</h1> 
      </div> 
    </header>
 
  
  
  <main class="page">

  <?php    
    $query_get_kids_list = "SELECT * FROM `kids_list` WHERE `parent_id` = '{$row_get_user['id']}'  ";
    $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
    $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
    $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);     
    
if($totalRows_get_kids_list > 1){ ?> 
   <div class="tabs tabs--scroll"> 
    <?php do{
        
        $query_get_kid_data = "SELECT * FROM `kids` WHERE `id` = '{$row_get_kids_list['kid_id']}' ";
        $get_kid_data = mysqli_query($database, $query_get_kid_data) or die(mysqli_error($database));
        $row_get_kid_data = mysqli_fetch_assoc($get_kid_data);
        $totalRows_get_kid_data = mysqli_num_rows($get_kid_data); 
        
         if($totalRows_get_kid_data>0){?>
            <a class="tab <?php if(isset($_GET['kid']) && $kid_id == $row_get_kid_data['id']){ echo " is-active "; }?>" href="parent-alerts.php?kid=<?php echo $row_get_kids_list['kid_id'];?>" ><?php echo $row_get_kid_data['fn_name'];?></a>
    <?php }}while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list)); ?>
   </div>
<?php } ?>





<?php  
  if(!isset($_GET['kid'])){   $query_get_kids_list = "SELECT * FROM `kids_list` WHERE `parent_id` = '{$row_get_user['id']}'  "; }
  if(isset($_GET['kid']) && escape($_GET['kid']) >0 ){   $query_get_kids_list = "SELECT * FROM `kids_list` WHERE `parent_id` = '{$row_get_user['id']}' AND `kid_id` = '{$kid_id}'  "; } 
  $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
  $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
  $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);     
    
if($totalRows_get_kids_list > 0){ ?> 
    <div class="rows" id="alerts-list"> 
    <?php
    $notif_index = 0;
    do{ 
        $query_get_notifications = "SELECT * FROM `notifications` WHERE `kid_id` = '{$row_get_kids_list['kid_id']}' AND `del` = 0 ORDER BY `id` DESC ";
        $get_notifications = mysqli_query($database, $query_get_notifications) or die(mysqli_error($database));
        $row_get_notifications = mysqli_fetch_assoc($get_notifications);
        $totalRows_get_notifications = mysqli_num_rows($get_notifications); 
        
       if($totalRows_get_notifications>0){
          do{
              $notif_index++;
              $row_hidden_class = ($notif_index > 5) ? ' row--hidden' : '';
          ?> 
              <a data-alert="homework-en" data-idx="<?php echo $notif_index; ?>" class="row<?php echo $row_hidden_class; ?> <?php if($row_get_notifications['view']==0){echo " t-green ";} ?>" href="parent-alert.php?id=<?php echo $row_get_notifications['id']; ?>&kid=<?php echo $row_get_kids_list['kid_id'];?>">
                  <span class="row__ico">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 4h8a2 2 0 0 1 2 2v14l-6-3-6 3V6a2 2 0 0 1 2-2z"/></svg>
                  </span>
                  <div class="row__body">
                    <p class="row__title"><?php echo $row_get_notifications['title'];?></p>
                    <p class="row__meta"> <?php if(!isset($_GET['kid'])){ echo kid_name($row_get_kids_list['kid_id'])." - " ;}   if($row_get_notifications['type'] == 1){echo " غياب";} if($row_get_notifications['type'] == 6){echo " إعلان";}if($row_get_notifications['type'] == 65){echo " رسالة";}   ?></p>
                    <p class="row__time" style="color:#1a3d7a"><?php echo date("d M, Y",$row_get_notifications['date']);?></p>
                  </div>
                  <span class="row__go">›</span>
                </a> 
        <?php } while($row_get_notifications = mysqli_fetch_assoc($get_notifications)); }
         } while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list)); ?>
   </div>

   <?php if($notif_index > 5){ ?>
      <button class="btn btn--quiet alerts-more" id="alerts-more" type="button">Load more</button>
   <?php } ?>

<?php }  ?>  
     
    




        
</main>
    
    
    
    
    


<?php if(isset($_GET['kid']) && escape($_GET['kid']) >0 ){
  
          $query_get_kid_data = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
          $get_kid_data = mysqli_query($database, $query_get_kid_data) or die(mysqli_error($database));
          $row_get_kid_data = mysqli_fetch_assoc($get_kid_data);
          $totalRows_get_kid_data = mysqli_num_rows($get_kid_data);
          ?>

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

<?php }else{ ?>

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
<?php } ?>


 


</div>

<script>
var alertsMoreBtn = document.getElementById('alerts-more');
if (alertsMoreBtn) {
  alertsMoreBtn.addEventListener('click', function () {
    var hiddenRows = document.querySelectorAll('#alerts-list .row.row--hidden');
    for (var i = 0; i < 5 && i < hiddenRows.length; i++) {
      hiddenRows[i].classList.remove('row--hidden');
    }
    if (document.querySelectorAll('#alerts-list .row.row--hidden').length === 0) {
      alertsMoreBtn.remove();
    }
  });
}
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
