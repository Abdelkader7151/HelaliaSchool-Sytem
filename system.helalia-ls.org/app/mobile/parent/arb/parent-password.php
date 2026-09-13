<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      
$wrong = 0;

 if(isset($_POST['save'])){  
        $password_old  = escape(md5(strtolower($_POST['old_password'])));    

        mysqli_select_db($database, $database_database);
        $query_get_old_password = "SELECT * FROM `app_login` where `id` = '{$row_get_user['id']}' and `password`='{$password_old}'";
        $get_old_password = mysqli_query($database, $query_get_old_password) or die(mysqli_error($database));
        $row_get_old_password = mysqli_fetch_assoc($get_old_password);
        $totalRows_get_old_password = mysqli_num_rows($get_old_password);


   if($totalRows_get_old_password>0){

        $password  = escape(md5(strtolower($_POST['password'])));

        $updateSQL1 = sprintf("UPDATE `app_login` SET `password`=%s WHERE `id`=%s  ",
                            GetSQLValueString($database ,$password, "text"), 
                            GetSQLValueString($database ,$row_get_user['id'], "int"));

        mysqli_query($database , $updateSQL1) or die(mysqli_error($database));  

         header("location: parent-settings.php?done");
         exit(); 
   }else{
         $wrong = 1;
   }
       
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
<title>تغيير كلمة المرور · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css">
</head>
<body>
<div class="app">
  <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-settings.php" aria-label="رجوع">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg></a>
          <h1 class="hero__title">تغيير كلمة المرور</h1>
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
    
   <form method="post" enctype="multipart/form-data"   > 
      <div class="card stack">
        <label class="field"><span class="field__label">كلمة المرور الحالية</span><input class="input" minlength="4" type="password" name="old_password" required placeholder="••••••••"></label>
        <label class="field"><span class="field__label">كلمة مرور جديدة</span><input class="input" type="text" minlength="4"  name="password" required placeholder="••••••••"></label> 
        <button class="btn btn--primary" type="submit" name="save">حفظ</button>
      </div>
    </form> 
    
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

<?php if ($wrong == 1) { ?> 
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
        background:#fdecec;color:#d93025}
      .hl-modal__icon svg{width:34px;height:34px}
      .hl-modal__text{margin:0;font-size:19px;font-weight:700;color:#112c5a;
        font-family:'Plus Jakarta Sans',system-ui,sans-serif}
      @media (prefers-reduced-motion:reduce){
        .hl-modal,.hl-modal__box{transition:none}
      }
    </style> 
 
    <div class="hl-modal" id="wrong-password" role="alertdialog" aria-live="assertive" aria-label="Login error">
      <div class="hl-modal__box">
        <div class="hl-modal__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </div>
        <p class="hl-modal__text">كلمة مرور خاطئة   </p>
      </div>
    </div>

     <script>
      (function () {
        var m = document.getElementById('wrong-password');
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
<script src="../assets/js/app.js" defer></script>
</body>
</html>
