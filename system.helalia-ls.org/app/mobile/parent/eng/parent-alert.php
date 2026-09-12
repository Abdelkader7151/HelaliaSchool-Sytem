<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
       
 
 
        $kid_id = escape($_GET['kid']);    
        $id = escape($_GET['id']);    
             
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
   

        $query_get_notifications = "SELECT * FROM `notifications` WHERE `kid_id` = '{$kid_id}' and `id` = '{$id}' limit 1 ";
        $get_notifications = mysqli_query($database, $query_get_notifications) or die(mysqli_error($database));
        $row_get_notifications = mysqli_fetch_assoc($get_notifications);
        $totalRows_get_notifications = mysqli_num_rows($get_notifications); 
        
        if($totalRows_get_notifications==0){
              header("Location: parent-view.php");
              exit();
          }


          
          $updateSQL1 = sprintf("UPDATE `notifications` SET `view`=%s  WHERE `id`=%s AND `kid_id` =%s  ",
                            GetSQLValueString($database ,1, "int"),
                            GetSQLValueString($database ,$id, "int"), 
                            GetSQLValueString($database ,$kid_id, "int"));

           mysqli_query($database , $updateSQL1) or die(mysqli_error($database));   

      $listKid = isset($_GET['list_kid']) ? (int) $_GET['list_kid'] : -1;
      if ($listKid < 0) {
          $listKid = (int) $kid_id;
      }
      $listMore = isset($_GET['list_more']) ? max(0, (int) $_GET['list_more']) : 0;
      $alertsBack = 'parent-alerts.php';
      $q = array();
      if ($listKid > 0) {
          $q[] = 'kid=' . $listKid;
      }
      if ($listMore > 0) {
          $q[] = 'more=' . $listMore;
      }
      if ($q) {
          $alertsBack .= '?' . implode('&', $q);
      }
      $delUrl = 'parent-alerts.php?del=' . (int) $id . '&kid=' . (int) $kid_id;
      if ($listKid > 0) {
          $delUrl .= '&list_kid=' . $listKid;
      }
      if ($listMore > 0) {
          $delUrl .= '&list_more=' . $listMore;
      }

      // Safe HTML body: allow basic tags only; open links in new tab. No DOMDocument (glitchy on Arabic).
      $rawText = (string) $row_get_notifications['text'];
      $title = trim((string) $row_get_notifications['title']);
      if ($title !== '' && strpos($rawText, $title) === 0) {
          $rawText = ltrim(substr($rawText, strlen($title)), " \t\n\r\0\x0B,<");
          if (strpos($rawText, 'br>') === 0 || strpos($rawText, 'br/>') === 0 || strpos($rawText, 'br />') === 0) {
              $rawText = preg_replace('/^br\s*\/?\s*>\s*,?/i', '', $rawText);
          }
      }
      $allowed = '<p><br><br/><b><strong><i><em><u><ul><ol><li><pre><span><div><a>';
      $notification_text = strip_tags($rawText, $allowed);
      $notification_text = preg_replace_callback(
          '/<a\s+([^>]*href=["\']([^"\']+)["\'][^>]*)>/i',
          function ($m) {
              $href = $m[2];
              if (!preg_match('#^https?://#i', $href)) {
                  return '<a href="#" class="external">';
              }
              return '<a class="external adet__link" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">';
          },
          $notification_text
      );

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
<title>Alerts Â· Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=18">
<style>
.row.row--hidden { display: none; }
.alerts-more { display: block; width: 100%; text-align: center; margin: 14px 0 4px; }
</style>
</head>
<body>
<div class="app">
   <header class="hero hero--tall">
        <div class="hero__row">
          <a class="back" href="<?php echo htmlspecialchars($alertsBack, ENT_QUOTES, 'UTF-8'); ?>" data-helalia-back="<?php echo htmlspecialchars($alertsBack, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M15 19 8 12l7-7"></path>
            </svg>
          </a>
              <h1 class="hero__title">Alerts</h1> 
        </div>  
    </header>
  
  
  
  
  
  
  
  
  <main class="page">
    <article class="card adet">
      <?php if($row_get_notifications['image']!=NULL && file_exists('../../../../alert/'.$row_get_notifications['image'])==1){?>
        <div class="adet__media"><img src="../../../../alert/<?php if($row_get_notifications['image']!=NULL && file_exists('../../../../alert/'.$row_get_notifications['image'])==1){echo $row_get_notifications['image'];}?>" alt="Helalia Language School"></div>
        <?php }?>
        <div class="adet__body">
          <p class="adet__when">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="8.5"/>
              <path d="M12 7.5V12l3 2"/>
            </svg><?php echo date("d M, Y",$row_get_notifications['date']);?></p>
          <h2 class="adet__title"><?php echo htmlspecialchars((string) $row_get_notifications['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
          <div class="adet__text"><?php echo $notification_text; ?></div>

          <!--<a class="adet__link" href="http://www.google.com" target="_blank" rel="noopener">http://www.google.com</a>-->
        </div>
      </article>

      <div class="adet__actions">
        <a class="btn btn--quiet" href="<?php echo htmlspecialchars($alertsBack, ENT_QUOTES, 'UTF-8'); ?>" data-helalia-back="<?php echo htmlspecialchars($alertsBack, ENT_QUOTES, 'UTF-8'); ?>">Back to alerts</a>
        <a class="btn btn--danger" href="<?php echo htmlspecialchars($delUrl, ENT_QUOTES, 'UTF-8'); ?>" type="button">Delete</a>
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
 
<script src="../assets/js/app.js?v=41" defer></script>
</body>
</html>
