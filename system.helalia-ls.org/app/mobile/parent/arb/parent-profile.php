<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      

 if(isset($_POST['save'])){

       // $image_name = $_POST['old_img'];
	     // include('includes/img-up1.php');
       // if($_POST['old_img']!=$image_name && $_POST['old_img']!=null){unlink("../../../uploads/".$_POST['old_img']);}
       
       $updateSQL1 = sprintf("UPDATE `app_login` SET `name`=%s, `email`=%s  WHERE `id`=%s  ",
                            GetSQLValueString($database ,$_POST['name'], "text"),
                            GetSQLValueString($database ,$_POST['email'], "text"),
                           // GetSQLValueString($database ,$image_name, "text"), 
                            GetSQLValueString($database ,$row_get_user['id'], "int"));

         $Result1 = mysqli_query($database , $updateSQL1) or die(mysqli_error($database));


        mysqli_select_db($database, $database_database);
        $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}'";
        $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
        $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
        $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

        if($totalRows_get_kids_list>0){
          do{ 
             $updateSQL2 = sprintf("UPDATE `kids` SET `email`=%s WHERE `id`=%s  ", 
                            GetSQLValueString($database ,$_POST['email'], "text"), 
                            GetSQLValueString($database ,$row_get_kids_list['kid_id'], "int"));

             mysqli_query($database , $updateSQL2) or die(mysqli_error($database));   
          }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list));  
        }  

         header("location: parent-settings.php?done");
         exit();
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
<title>الملف الشخصي · هلاليا</title>
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
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg></a>
        <h1 class="hero__title">الملف الشخصي</h1>
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
       <!--   <div class="row-flex">
          <span class="av av--lg t-gold">سأ</span>
          <div class="grow"><p class="row__title">سارة أحمد</p><p class="row__meta">ولي أمر</p></div>
        </div>-->
       
            <label class="field"><span class="field__label">الاسم الكامل</span><input class="input" type="text" placeholder="" name="name" require value="<?php echo $row_get_user['name'];?>"></label>
            <!--<label class="field"><span class="field__label">رقم الهاتف</span><input class="input" type="tel" placeholder="" value="01000000000"></label>-->
            <label class="field"><span class="field__label">البريد الإلكتروني</span><input class="input" type="email" placeholder="" require name="email" value="<?php echo $row_get_user['email'];?>"></label>
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
<script src="../assets/js/app.js?v=65" defer></script>
</body>
</html>
