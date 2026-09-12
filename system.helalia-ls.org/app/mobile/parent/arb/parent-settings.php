<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      
       
       //update lang
       language_update($row_get_user['id'],$lang);

       $helaliaCanSwitchRole = false;
       $dualRoleFile = __DIR__ . '/../../emp/includes/dual-role.php';
       if (is_file($dualRoleFile)) {
           require_once $dualRoleFile;
           if (function_exists('dual_parent_can_switch_role')) {
               $helaliaCanSwitchRole = dual_parent_can_switch_role();
           }
       }
       if (!$helaliaCanSwitchRole) {
           $helaliaCanSwitchRole = (!empty($_SESSION['helalia_emp_backup']) && is_array($_SESSION['helalia_emp_backup']));
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
<title>الإعدادات · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=21">
</head>
<body>
<div class="app"> 
  
    <header class="hero hero--tall"> 
    <div class="hero__row">
      <div class="grow"> 
              <h1 class="hero__title">الإعدادات</h1>
            </div>
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
    <div class="settings">
    <?php if ($helaliaCanSwitchRole) { ?>
    <a class="settings__item" href="../../emp/arb/choose-role.php">
      <span style="display:inline-flex;align-items:center;gap:.55rem">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M16 3h5v5"/><path d="M8 21H3v-5"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/>
        </svg>
        تبديل الحساب
      </span>
      <span class="settings__go">‹</span>
    </a>
    <?php } ?>
    <a class="settings__item" href="parent-profile.php">
      <span>    الملف الشخصي</span> 
      <span class="settings__go">‹</span>
    </a>
    
    <a class="settings__item" href="parent-password.php">
      <span>تغيير كلمة المرور</span> 
      <span class="settings__go">‹</span>
    </a>

  
    <a class="settings__item" href="../eng/parent-settings.php">
      <span>English</span>
      <span class="tiny">العربية</span>
      <span class="settings__go">‹</span>
    </a>
 </div>
     
     
      <div class="settings">
    <a class="settings__item settings__item--danger" href="?exit">
      <span>خروج</span>
      
      <span class="settings__go"></span>
    </a></div> 
    
     <div style="text-align:center; width:100%">
            <img src='../assets/img/ascendra-logo-black.png' width='100px' style="text-align:center; display:inline-flex" />
            <p style="font-size:10px">بدعم من</p>
          </div>
    
    </main>
    

<nav class="nav nav--trio" aria-label="الرئيسية" style="height: 90px">

    <a class="nav__item " href="parent-view.php">
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

    <a class="nav__item is-active" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
      </svg>
      <span>الإعدادات</span>
      <span class="nav__dot"></span>
    </a>

  </nav>

    
 


</div>
<script>
/* bell__badge drops out at zero, so the bell only rings when there is news */
document.querySelectorAll('.bell__badge').forEach(function (b) {
  if (parseInt(b.textContent, 10) > 0 === false) b.remove();
});
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
