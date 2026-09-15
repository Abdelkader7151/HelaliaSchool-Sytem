<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
require_once('includes/functions.php');

if ($row_get_login['access100'] == 1) {

  $msg = '';

  if (isset($_POST['submit'])) {
    $insertSQL = sprintf("INSERT INTO `users` (`username`, `password`, `name`,
    `access1`, `access1sub1`, `access1sub2`, `access1sub3`, `access1sub4`,
    `access2`, `access2sub1`, `access2sub2`, `access2sub3`, `access2sub4`,`access2sub5`,`access2sub6`,
    `access3`, `access3sub1`, `access3sub2`, `access3sub3`, `access3sub4`, 
    `access4`, `access4sub1`, `access4sub2`, `access4sub3`, `access4sub4`,`access4sub5`,`access4sub6`,
    `access5`, `access5sub1`, `access5sub2`, `access5sub3`, `access5sub4`, 
    `access6`, `access6sub1`, `access6sub2`, `access6sub3`, `access6sub4`,`access6sub5`,`access6sub6`,`access6sub7`,
    `access7`, `access7sub0`, `access7sub1`, `access7sub2`, `access7sub3`, `access7sub4`,`access7sub5`,`access7sub6`,`access7sub7`, `access7sub8`, `access7sub9`,  `access7sub11`,
    `access8`, `access8sub1`, `access8sub2`, `access8sub3`, `access8sub4`, 
    `access9`, `access9sub1`, `access9sub2`,
    `access10`, `access10sub1`, `access10sub2`, `access10sub3`,
    `access11`, `access11sub1`, `access11sub2`,
    `access12`, `access12sub1`, `access12sub2`, `access12sub3`,
    `access13`,
    `access14`,
    `access15`, 
    `access16`, 
    `access17`, `access17sub1`, `access17sub2`, `access17sub3`, `access17sub4`,
    `access18`, `access18sub1`, `access18sub2`, `access18sub3`, `access18sub4`, `access18sub5`,`access18sub6`,`access18sub7`,`access18sub8`, `access18sub9`, `access18sub10`,`access18sub11`,`access18sub12`,`access18sub13`,`access18sub14`,`access18sub15`, 
    `access19`,`access19sub1`, `access19sub2`, `access19sub3`,  
    `access20`,`access20sub1`, `access20sub2`,      
    `access21`,`access21sub1`, `access21sub2`, `access21sub3`, 
    `access22`, 
    `access23`, `access23sub1`,  `access23sub2`,  `access23sub3`, `access23sub4`, `access23sub5`, 
    `access100`,`access100sub1`, `access100sub2`, `access100sub3`,  
     `emp`, `date`)
     VALUES 
     (  %s, %s, %s,
        %s, %s, %s, %s, %s,  
        %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  
        %s, %s, %s, %s, %s,
        %s, %s, %s, %s, 
        %s, %s, %s, 
        %s, %s, %s,  
        %s, %s, %s, %s,
        %s,
        %s,
        %s,  
        %s,  
        %s, %s, %s, %s, %s, 
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
        %s, %s, %s, 
        %s, %s, %s, %s,
        %s, %s, %s, %s,
        %s, 
        %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s,
        %s, %s)",
      GetSQLValueString($database, strtolower(trim($_POST['username'])), "text"),
      GetSQLValueString($database, strtolower(trim($_POST['password'])), "text"),
      GetSQLValueString($database, $_POST['name'], "text"),

      GetSQLValueString($database, $_POST['access1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access1sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access1sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access1sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access1sub4'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access2sub6'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access3sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access3sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access3sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access3sub4'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access4sub6'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access5sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access5sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access5sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access5sub4'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access6'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub6'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access6sub7'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access7'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub0'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub6'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub7'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub8'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub9'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access7sub11'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access8'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access8sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access8sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access8sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access8sub4'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access9'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access9sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access9sub2'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access10'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access10sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access10sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access10sub3'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access11'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access11sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access11sub2'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access12'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access12sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access12sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access12sub3'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access13'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access14'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access15'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access16'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access17'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access17sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access17sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access17sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access17sub4'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access18'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub5'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub6'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub7'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub8'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub9'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub10'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub11'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub12'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub13'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub14'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access18sub15'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access19'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access19sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access19sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access19sub3'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access20'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access20sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access20sub2'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access21'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access21sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access21sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access21sub3'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access22'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access23'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access23sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access23sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access23sub3'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access23sub4'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access23sub5'] ? 1 : 0, "int"),

      GetSQLValueString($database, $_POST['access100'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access100sub1'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access100sub2'] ? 1 : 0, "int"),
      GetSQLValueString($database, $_POST['access100sub3'] ? 1 : 0, "int"),

      GetSQLValueString($database, $row_get_login['id'], "int"),
      GetSQLValueString($database, time(), "int")
    );

    mysqli_select_db($database, $database_database);
    $Result1 = mysqli_query($database, $insertSQL) or die(mysqli_error($database));


    $to = strtolower($_POST['username']);
    $subject = "تفعيل الحساب";
    $message = "
    <html>
    <head>
    <title>تفعيل الحساب</title>
    </head>
    <body>
    
    <p>
    <img src='https://www.helalia-ls.org/control/img/logo.png' />
    <br>
    تم تفعيل حساب لوحة التحكم       </p>
    <table>
    <tr> 
    <th>" . $_POST['name'] . " :اسم  </th> 
    </tr> 
    <tr>
    <th>" . strtolower($_POST['username']) . " :اسم المستخدم</th> 
    </tr> 
    <tr> 
    <th>" . strtolower($_POST['password']) . " :كلمة المرور  </th>
    </tr> 
    <tr> 
    <th> <a href='https://system.helalia-ls.org/' > https://system.helalia-ls.org/ </a>   :الرابط  </th>
    </tr> 


    
    </table>
    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <activation@domain.com>' . "\r\n";

    //mail($to,$subject,$message,$headers); 



    header("location: new-user.php?done");
    exit();

  }





  $head_title = "  المستخدمين";
  ?>
  <!DOCTYPE html>
  <html lang="en" dir="rtl">

  <head>
    <?php include("includes/header.php"); ?>
    <?php include("includes/share.php"); ?>
    <?php include("includes/top-script.php"); ?>
    <link rel="stylesheet" href="css/application-rtl.min.css">
    <link rel="stylesheet" href="css/dashboard-3-rtl.min.css">
  </head>

  <body class="layout layout-header-fixed">

    <div class="layout-header">
      <div class="navbar navbar-default">
        <div class="navbar-header" style=" background-color: black">
          <a class="navbar-brand navbar-brand-center" href="home.php" style=" padding: 5px"> </a>
          <?php require_once('includes/mobile-menu-buttons.php'); ?>
        </div>
        <div class="navbar-toggleable">
          <nav id="navbar" class="navbar-collapse collapse">
            <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="bars">
                <span class="bar-line bar-line-1 out"></span>
                <span class="bar-line bar-line-2 out"></span>
                <span class="bar-line bar-line-3 out"></span>
                <span class="bar-line bar-line-4 in"></span>
                <span class="bar-line bar-line-5 in"></span>
                <span class="bar-line bar-line-6 in"></span>
              </span>
            </button>
            <ul class="nav navbar-nav navbar-right">
              <?php require_once('includes/notifications.php'); ?>
            </ul>
            <?php require_once('includes/title-bar.php'); ?>
          </nav>
        </div>
      </div>
    </div>

    <div class="layout-main">
      <?php include("includes/side-nav.php"); ?>

      <div class="layout-content">
        <div class="layout-content-body">
          <div class="row">
            <div class="col-md-12">
              <h4> أضافة مستخدم جديد </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="demo-form-wrapper">
                <form action="new-user.php" method="post" name="form1" id="form1" enctype="multipart/form-data"
                  class="form form-horizontal">

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="name"> الاسم </label>
                    <div class="col-sm-9">
                      <input id="name" class="form-control" required type="text" name="name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="username"> البريد اللإلكتروني </label>
                    <div class="col-sm-9">
                      <input id="username" class="form-control" required type="text" name="username">
                      <p id="email_check" style="display: none; color:red">البريد اللإلكتروني مسجل من قبل</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="password"> كلمة المرور </label>
                    <div class="col-sm-9">
                      <input id="password" class="form-control" required type="text" name="password">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-3 control-label"> المستويات </label>
                    <div class="col-sm-9">

                      <div class="col-sm-4">
                        <input type="checkbox" id="access1" name="access1" value="1" style="margin-left: 5px;">
                        <label for="access1"> <strong style="color:black">الفصول</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access1" id="access1sub1" name="access1sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access1sub1"> فصل جديد </label><br>
                          <input type="checkbox" class="access1" id="access1sub2" name="access1sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access1sub2"> جمبع الفصول </label><br>
                          <input type="checkbox" class="access1" id="access1sub3" name="access1sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access1sub3"> تعديل الفصول </label><br>
                          <input type="checkbox" class="access1" id="access1sub4" name="access1sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access1sub4"> الطلبة </label><br>
                        </div>


                        <input type="checkbox" id="access2" name="access2" value="1" style="margin-left: 5px;">
                        <label for="access2"> <strong style="color:black">مجموعات التقوية</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access2" id="access2sub1" name="access2sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub1"> مجموعة جديد </label><br>
                          <input type="checkbox" class="access2" id="access2sub2" name="access2sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub2"> جمبع مجموعات </label><br>
                          <input type="checkbox" class="access2" id="access2sub3" name="access2sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub3"> تعديل مجموعات </label><br>
                          <input type="checkbox" class="access2" id="access2sub4" name="access2sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub4"> الطلبة </label><br>
                          <input type="checkbox" class="access2" id="access2sub5" name="access2sub5" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub5"> غياب اليوم </label><br>
                          <input type="checkbox" class="access2" id="access2sub6" name="access2sub6" value="1"
                            style="margin-left: 5px;">
                          <label for="access2sub6"> غياب المجموعات </label><br>

                        </div>
                      </div>
                      <div class="col-sm-4">

                        <input type="checkbox" id="access3" name="access3" value="1" style="margin-left: 5px;">
                        <label for="access3"> <strong style="color:black"> المواد الدراسية</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access3" id="access3sub1" name="access3sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access3sub1"> أضافة مادة جديد </label><br>
                          <input type="checkbox" class="access3" id="access3sub2" name="access3sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access3sub2"> جمبع المواد </label><br>
                          <input type="checkbox" class="access3" id="access3sub3" name="access3sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access3sub3"> تعديل المواد </label><br>
                          <input type="checkbox" class="access3" id="access3sub4" name="access3sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access3sub4"> المدرسين </label><br>
                        </div>


                        <input type="checkbox" id="access4" name="access4" value="1" style="margin-left: 5px;">
                        <label for="access4"> <strong style="color:black"> المقابلات</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access4" id="access4sub1" name="access4sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access4sub1"> مقابلة جديد </label><br>
                          <input type="checkbox" class="access4" id="access4sub2" name="access4sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access4sub2"> جمبع المقابلات المتاحة </label><br>
                          <input type="checkbox" class="access4" id="access4sub3" name="access4sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access4sub3"> جمبع المقابلات المحجوزة </label><br>
                          <input type="checkbox" class="access4" id="access4sub4" name="access4sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access4sub4"> جمبع المقابلات </label><br>
                          <input type="checkbox" class="access4" id="access4sub5" name="access4sub5" value="1"
                            style="margin-left: 5px;">
                          <label for="access4sub5"> تعديل المقابلات </label><br>
                        </div>
                      </div>
                      <div class="col-sm-4">

                        <input type="checkbox" id="access5" name="access5" value="1" style="margin-left: 5px;">
                        <label for="access5"> <strong style="color:black"> الوظائف</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access5" id="access5sub1" name="access5sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access5sub1"> وظيفة جديد </label><br>
                          <input type="checkbox" class="access5" id="access5sub2" name="access5sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access5sub2"> جمبع الوظائف </label><br>
                          <input type="checkbox" class="access5" id="access5sub3" name="access5sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access5sub3"> تعديل الوظائف </label><br>
                          <input type="checkbox" class="access5" id="access5sub4" name="access5sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access5sub4"> الموظفين على الوظيفة </label><br>
                        </div>


                        <input type="checkbox" id="access6" name="access6" value="1" style="margin-left: 5px;">
                        <label for="access6"> <strong style="color:black"> الموظفين</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access6" id="access6sub1" name="access6sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub1"> موظف جديد </label><br>
                          <input type="checkbox" class="access6" id="access6sub2" name="access6sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub2"> جميع الموظفين </label><br>
                          <input type="checkbox" class="access6" id="access6sub3" name="access6sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub3"> تعديل موظف </label><br>
                          <input type="checkbox" class="access6" id="access6sub4" name="access6sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub4"> عياد الميلاد </label><br>
                          <input type="checkbox" class="access6" id="access6sub5" name="access6sub5" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub5"> اجازات </label><br>
                          <input type="checkbox" class="access6" id="access6sub6" name="access6sub6" value="1"
                            style="margin-left: 5px;">
                          <label for="access6sub6"> اذون </label><br>
                          <input type="checkbox" class="access6" id="access6sub7" name="access6sub7" value="1"
                            style="margin-left: 5px;">
                          <label for="access6su7"> حضور و انصارف </label><br>

                        </div>
                      </div>
                      <div class="col-sm-4">

                        <input type="checkbox" id="access7" name="access7" value="1" style="margin-left: 5px;">
                        <label for="access7"> <strong style="color:black"> الطلبة</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access7" id="access7sub0" name="access7sub0" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub0"> تسجيل جديد </label><br>
                          <input type="checkbox" class="access7" id="access7sub1" name="access7sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub1"> طالب جديد </label><br>
                          <input type="checkbox" class="access7" id="access7sub2" name="access7sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub2"> عرض جميع الطلبة </label><br>
                          <input type="checkbox" class="access7" id="access7sub3" name="access7sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub3"> عياد الميلاد </label><br>
                          <input type="checkbox" class="access7" id="access7sub4" name="access7sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub4"> اجازات جديدى</label><br>
                          <input type="checkbox" class="access7" id="access7sub5" name="access7sub5" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub5"> غياب </label><br>

                          <input type="checkbox" class="access7" id="access7sub8" name="access7sub8" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub8"> رساله </label><br>
                          <input type="checkbox" class="access7" id="access7sub7" name="access7sub7" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub7"> قبول غياب </label><br>
                          <input type="checkbox" class="access7" id="access7sub9" name="access7sub9" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub9"> بيان نجاح </label><br>

                          <input type="checkbox" class="access7" id="access7sub6" name="access7sub6" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub6"> تعديل بيانات الطالب </label><br>
                          <input type="checkbox" class="access7" id="access7sub11" name="access7sub11" value="1"
                            style="margin-left: 5px;">
                          <label for="access7sub11"> حذف بيانات الطالب </label><br>
                        </div>


                        <input type="checkbox" id="access8" name="access8" value="1" style="margin-left: 5px;">
                        <label for="access8"> <strong style="color:black"> حسابات البرنامج</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access8" id="access8sub1" name="access8sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access8sub1"> حسابات البرنامج </label><br>
                          <input type="checkbox" class="access8" id="access8sub2" name="access8sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access8sub2"> حسابات اولياء الامور </label><br>
                          <input type="checkbox" class="access8" id="access8sub4" name="access8sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access8sub4"> حسابات الموظفين </label><br>
                          <input type="checkbox" class="access8" id="access8sub3" name="access8sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access8sub3"> تعديل حسابات </label><br>
                        </div>
                      </div>
                      <div class="col-sm-4">

                        <input type="checkbox" id="access9" name="access9" value="1" style="margin-left: 5px;">
                        <label for="access9"> <strong style="color:black"> رسائل الي المدرسين</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access9" id="access9sub1" name="access9sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access9sub1"> الرسائل الجديدة </label><br>
                          <input type="checkbox" class="access9" id="access9sub2" name="access9sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access9sub2"> جميع الرسائل </label><br>
                        </div>


                        <input type="checkbox" id="access10" name="access10" value="1" style="margin-left: 5px;">
                        <label for="access10"> <strong style="color:black"> رسائل من اولياء الامور</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access10" id="access10sub1" name="access10sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access10sub1"> الرسائل الجديدة </label><br>
                          <input type="checkbox" class="access10" id="access10sub2" name="access10sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access10sub2"> جميع الرسائل </label><br>
                          <input type="checkbox" class="access10" id="access10sub3" name="access10sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access10sub2"> صلاحيات الرد , تقرير السرعة </label><br>
                        </div>





                      </div>
                      <div class="col-sm-4">


                        <input type="checkbox" id="access11" name="access11" value="1" style="margin-left: 5px;">
                        <label for="access11"> <strong style="color:black"> رسائل من الموظفين </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access11" id="access11sub1" name="access11sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access11sub1"> الرسائل الجديدة </label><br>
                          <input type="checkbox" class="access11" id="access11sub2" name="access11sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access11sub2"> جميع الرسائل </label><br>
                        </div>



                        <input type="checkbox" id="access12" name="access12" value="1" style="margin-left: 5px;">
                        <label for="access12"> <strong style="color:black"> المناسبات </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access12" id="access12sub1" name="access12sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access12sub1"> أضافة مناسبة جديد </label><br>
                          <input type="checkbox" class="access12" id="access12sub2" name="access12sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access12sub2"> عرض جميع المناسبات </label><br>
                          <input type="checkbox" class="access12" id="access12sub3" name="access12sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access12sub3"> تعديل المناسبات </label><br>
                        </div>


                      </div>

                      <div class="col-sm-4">

                        <input type="checkbox" id="access13" name="access13" value="1" style="margin-left: 5px;">
                        <label for="access13"> <strong style="color:black"> معرض الصور </strong> </label><br>

                        <input type="checkbox" id="access14" name="access14" value="1" style="margin-left: 5px;">
                        <label for="access14"> <strong style="color:black"> معرض الفيديو </strong> </label><br>

                        <input type="checkbox" id="access15" name="access15" value="1" style="margin-left: 5px;">
                        <label for="access15"> <strong style="color:black"> شاشات المعلومات </strong> </label><br>

                        <?php if ($row_get_login['id'] == 1) { ?>
                          <input type="checkbox" id="access16" name="access16" value="1" style="margin-left: 5px;">
                          <label for="access16"> <strong style="color:black">النتائج </strong> </label><br>
                        <?php } ?>




                        <input type="checkbox" id="access22" name="access22" value="1" style="margin-left: 5px;">
                        <label for="access22"> <strong style="color:black"> المذكرات </strong> </label> <br>

                      </div>



                      <div class="col-sm-4">
                        <input type="checkbox" id="access100" name="access100" value="1" style="margin-left: 5px;">
                        <label for="access100"> <strong style="color:black">مستخدمي لوحة التحكم</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access100" id="access100sub1" name="access100sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access100sub1"> مستخدم جديد </label><br>
                          <input type="checkbox" class="access100" id="access100sub2" name="access100sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access100sub2"> جميع المستخدمين </label><br>
                          <input type="checkbox" class="access100" id="access100sub3" name="access100sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access100sub3"> تعديل المستخدمين </label><br>
                        </div>
                      </div>


                      <div class="col-sm-4">
                        <input type="checkbox" id="access19" name="access19" value="1" style="margin-left: 5px;">
                        <label for="access19"> <strong style="color:black">الواجبات المنزلية </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access19" id="access19sub1" name="access19sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access19sub1"> اضافة </label><br>
                          <input type="checkbox" class="access19" id="access19sub2" name="access19sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access19sub2"> جمبع الواجبات </label><br>
                          <input type="checkbox" class="access19" id="access19sub3" name="access19sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access19sub3"> بحث الواجبات </label><br>
                        </div>
                      </div>


                      <div class="col-sm-4">
                        <input type="checkbox" id="access21" name="access21" value="1" style="margin-left: 5px;">
                        <label for="access21"> <strong style="color:black"> المراجعات </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access21" id="access21sub1" name="access21sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="aaccess21sub1"> اضافة </label><br>
                          <input type="checkbox" class="access21" id="access21sub2" name="access21sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access21sub2"> جمبع المراجعات </label><br>
                          <input type="checkbox" class="access21" id="access21sub3" name="access21sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access21sub3"> بحث المراجعات </label><br>
                        </div>
                      </div>




                      <div class="col-sm-4">
                        <input type="checkbox" id="access20" name="access20" value="1" style="margin-left: 5px;">
                        <label for="access20"> <strong style="color:black">الخطة الاسبوعية </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access20" id="access20sub1" name="access20sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access20sub1"> اضافة </label><br>
                          <input type="checkbox" class="access20" id="access20sub2" name="access20sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access20sub2"> جمبع الخطط </label><br>
                        </div>
                      </div>



                      <div class="col-sm-4">
                        <input type="checkbox" id="access17" name="access17" value="1" style="margin-left: 5px;">
                        <label for="access17"> <strong style="color:black">الحسابات </strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access17" id="access17sub1" name="access17sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access17sub1"> تحصيلات </label><br>
                          <input type="checkbox" class="access17" id="access17sub2" name="access17sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access17sub2"> استحقاقات </label><br>
                          <input type="checkbox" class="access17" id="access17sub3" name="access17sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access17sub3"> اخطار سداد </label><br>
                          <input type="checkbox" class="access17" id="access17sub4" name="access17sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access17sub4"> تحميل </label><br>
                        </div>
                      </div>





                      <?php if ($row_get_login['id'] == 1) { ?>
                        <div class="col-sm-4">
                          <input type="checkbox" id="access23" name="access23" value="1" style="margin-left: 5px;">
                          <label for="access23"> <strong style="color:black"> الكنترول </strong> </label><br>

                          <div
                            style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                            <input type="checkbox" class="access23" id="access23sub1" name="access23sub1" value="1"
                              style="margin-left: 5px;">
                            <label for="aaccess21sub1"> رصد الدرجات </label><br>
                            <input type="checkbox" class="access23" id="access23sub5" name="access23sub5" value="1"
                              style="margin-left: 5px;">
                            <label for="aaccess21sub5"> رصد اعمال السنة </label><br>
                            <input type="checkbox" class="access23" id="access23sub2" name="access23sub2" value="1"
                              style="margin-left: 5px;">
                            <label for="access21sub2"> تصدير </label><br>
                            <input type="checkbox" class="access23" id="access23sub3" name="access23sub3" value="1"
                              style="margin-left: 5px;">
                            <label for="access21sub3"> التاكيد </label><br>
                            <input type="checkbox" class="access23" id="access23sub4" name="access23sub4" value="1"
                              style="margin-left: 5px;">
                            <label for="access21sub4"> اصدار الشهادات </label><br>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="col-sm-4">
                        <input type="checkbox" id="access18" name="access18" value="1" style="margin-left: 5px;">
                        <label for="access18"> <strong style="color:black">المراحل</strong> </label><br>

                        <div
                          style="margin-right: 40px;padding-right: 10px; margin-bottom: 20px; border-right: solid 2px black; ">
                          <input type="checkbox" class="access18" id="access18sub1" name="access18sub1" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub1"> بري سكول </label><br>
                          <input type="checkbox" class="access18" id="access18sub2" name="access18sub2" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub2"> اولى حضانة </label><br>
                          <input type="checkbox" class="access18" id="access18sub3" name="access18sub3" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub3"> ثانية حضانة </label><br>
                          <input type="checkbox" class="access18" id="access18sub4" name="access18sub4" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub4"> الصف الاول الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub5" name="access18sub5" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub5"> الصف الثانى الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub6" name="access18sub6" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub6"> الصف الثالث الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub7" name="access18sub7" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub7"> الصف الرابع الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub8" name="access18sub8" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub8"> الصف الخامس الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub9" name="access18sub9" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub9"> الصف السادس الابتدائى </label><br>
                          <input type="checkbox" class="access18" id="access18sub10" name="access18sub10" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub10"> الصف الاول الاعدادى </label><br>
                          <input type="checkbox" class="access18" id="access18sub11" name="access18sub11" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub11"> الصف الثاني الاعدادى </label><br>
                          <input type="checkbox" class="access18" id="access18sub12" name="access18sub12" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub12"> الصف الثالث الاعدادى </label><br>
                          <input type="checkbox" class="access18" id="access18sub13" name="access18sub13" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub13"> الصف الاول الثانوى </label><br>
                          <input type="checkbox" class="access18" id="access18sub14" name="access18sub14" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub14"> الصف الثاني الثانوى </label><br>
                          <input type="checkbox" class="access18" id="access18sub15" name="access18sub15" value="1"
                            style="margin-left: 5px;">
                          <label for="access18sub15"> الصف الثالث الثانوى </label><br>
                        </div>
                      </div>



                    </div>
                  </div>



                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="submit"> </label>
                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit"><i
                          class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label"> </label>
                    <div class="col-sm-6">
                      <?php echo $msg; ?>
                    </div>
                  </div>





                </form>
              </div>
            </div>
          </div>



        </div>
      </div>


      <?php include("includes/footer.php"); ?>

    </div>





    <?php include("includes/footer-script.php"); ?>
    <script src="js/application.min.js"></script>





    <script>
      $(document).ready(function () {



        $('#form1').on('blur', '#username', function (event) {
          // event.preventDefault(); 

          var email = $("#username").val();
          $.post("check_email.php",
            {
              email: email
            },
            function (Date, status) {

              if (Date > 0) {
                $("#email_check").fadeIn();
                $("#submit").attr('disabled', 'disabled');
              } else {
                $("#email_check").fadeOut();
                $("#submit").removeAttr("disabled");
              }

            });
        });




        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
          }
        }

        <?php for ($i = 1; $i <= 23; $i++) { ?>

          $("#access<?php echo $i; ?>").click(function () {
            if ($(this).is(":checked")) {
              $(".access<?php echo $i; ?>").each(function () {
                $(this).prop("checked", true);
              });
            } else {
              $(".access<?php echo $i; ?>").each(function () {
                $(this).prop("checked", false);
              });
            }
          });

          $(".access<?php echo $i; ?>").click(function () {
            $("#access<?php echo $i; ?>").prop("checked", true);
          });

        <?php } ?>


        $("#access100").click(function () {
          if ($(this).is(":checked")) {
            $(".access100").each(function () {
              $(this).prop("checked", true);
            });
          } else {
            $(".access100").each(function () {
              $(this).prop("checked", false);
            });
          }
        });


        $(".access100").click(function () {
          $("#access100").prop("checked", true);
        });



        <?php if (isset($_GET['done'])) { ?>
          Command: toastr["success"](" تم اضافة بنجاح")

          toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
        <?php } ?>

      });
    </script>
  </body>

  </html>

<?php } else {
  header("location: home.php");
  exit();
} ?>