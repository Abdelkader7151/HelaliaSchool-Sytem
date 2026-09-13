 
<?php require_once('Connections/database.php'); 
      include("includes/functions_arb.php");
      if (!function_exists('helalia_phone_is_taken')) {
        require_once('includes/phone-unique.php');
      }


     $error = 0;

      if(isset($_POST['submit'])){    
            if (!helalia_phone_is_taken($database, isset($_POST['phone']) ? $_POST['phone'] : '', array())) { 
                //open account for  parent
                $insertSQL = sprintf("INSERT INTO `app_login` (`name`, `phone`, `email`, `password`, `account_type`, `date`, `active`) VALUES (%s, %s, %s, %s, %s, %s, %s)", 
                              GetSQLValueString($database ,$_POST['name'], "text"),
                              GetSQLValueString($database ,$_POST['phone'], "text"),
                              GetSQLValueString($database ,strtolower($_POST['email']), "text"),
                              GetSQLValueString($database ,md5(strtolower($_POST['password'])), "text"),
                              GetSQLValueString($database ,1, "int"),
                              GetSQLValueString($database ,time(), "int"),
                              GetSQLValueString($database ,1, "int"));

                mysqli_query($database, $insertSQL) or die(mysqli_error($database));   
                if(isset($_SESSION['phone_id'])) {
                header("location: login-arb.php?id=".$_SESSION['phone_id']); 
                } else {
                  header("location: login-arb.php");
                } 
                exit();     
            }else{
              //the phone is already added  
               $error = 1; 
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
<title>هلاليا : تسجيل الدخول</title>
<link rel="icon" href="parent/assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="parent/assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="parent/assets/css/helalia.css">
</head>
<body>

<div class="app app--auth">
  <div class="auth">
    <div class="auth__hero" style="height: 110%;">
      <img class="auth__hero-img" src="parent/assets/img/bg-school.jpg" alt="مدرسة هلاليا للغات">
    </div>

     <div class="between">
      <a class="back" href="login-arb.php?id=<?php echo $_SESSION['phone_id'];?>" aria-label="رجوع"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg></a>
      <a class="lang lang--onnavy" href="login-eng.php?id=<?php echo $_SESSION['phone_id'];?>" hreflang="en">English</a>
    </div>

    <div class="auth__brand">
      <img class="auth__logo" src="parent/assets/img/logo-icon.png" alt="مدرسة هلاليا للغات">
      <h1 class="auth__name">مدرسة هلاليا للغات</h1>
      <p class="auth__tag">تطبيق أولياء الأمور · تطبيق إدارة المدرسة للهواتف المحمولة</p>
    </div>

    <form class="auth__form"   method="POST" name="form1" id="form1">
      <label class="field"><span class="field__label">الاسم الكامل</span><input class="input" required type="text" name="name" ></label>
      <label class="field">
        <span class="field__label">رقم الهاتف  <small  class="auth__tag">هو لتسجيل الدخول</small></span><input class="input" required type="tel" name="phone" placeholder="01xxxxxxxxx"></label>
      <label class="field"><span class="field__label">البريد الإلكتروني</span><input class="input" required type="email" name="email"  ></label>
      <label class="field"><span class="field__label">كلمة المرور</span><input class="input" required type="text" minlength="6" maxlength="20" name="password" placeholder="••••••••"></label>
      <button class="btn btn--gold" type="submit" name="submit">إنشاء الحساب</button>
    </form>


    <div class="auth__foot"  style="margin-top: 20px;" >
      <p class="auth__fine">ستقوم المدرسة بمراجعة طلبك وتفعيل حسابك.</p>
      <a class="auth__link" href="login-arb.php?id=<?php echo $_SESSION['phone_id'];?>">تسجيل الدخول</a>
    


    </div>

  </div> 
</div>


<?php if ($error == 1) { ?> 
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
        <p class="hl-modal__text"><?php echo htmlspecialchars(helalia_phone_taken_message('ar'), ENT_QUOTES, 'UTF-8'); ?></p>
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

<script src="parent/assets/js/app.js" defer></script>
</body>
</html> 