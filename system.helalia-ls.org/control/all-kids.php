<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
require_once('includes/functions.php');

if ($row_get_login['access7sub2'] == 1) {

  $study_year = '';

  mysqli_select_db($database, $database_database);

  if (isset($_GET['id'])) {
    $study_year = " and `study_year` = '{$_GET['id']}' ";
    if ($_GET['id'] > 14) {
      $study_year = " AND `study_year` >= '{$_GET['id']}' ";
    }

    $query_get_users_info = "SELECT `kids`.*, (SELECT `name` FROM `class` WHERE `class`.id = `kids`.class) AS `class_name` FROM `kids` WHERE `id`>0 $study_year order by `name` asc  ";
  } else {
    $query_get_users_info = "SELECT `kids`.*, (SELECT `name` FROM `class` WHERE `class`.id = `kids`.class) AS `class_name` FROM `kids` order by `name` asc  ";
  }

  if (isset($_GET['trans1'])) {
    $query_get_users_info = " SELECT * FROM `kids` WHERE `transfare` = 1  $study_year  order by `name` asc  ";
  }
  if (isset($_GET['trans2'])) {
    $query_get_users_info = " SELECT * FROM `kids` WHERE `transfare` = 2  $study_year  order by `name` asc  ";
  }
  if (isset($_GET['trans3'])) {
    $query_get_users_info = " SELECT * FROM `kids` WHERE `transfare` = 3  $study_year  order by `name` asc  ";
  }
  if (isset($_GET['reg1'])) {
    $query_get_users_info = " SELECT * FROM `kids` WHERE `religion` = 1 $study_year  order by `name` asc  ";
  }
  if (isset($_GET['reg2'])) {
    $query_get_users_info = " SELECT * FROM `kids` WHERE `religion` = 2 $study_year  order by `name` asc  ";
  }

  $get_users_info = mysqli_query($database, $query_get_users_info) or die(mysqli_error($database));
  $row_get_users_info = mysqli_fetch_assoc($get_users_info);
  $totalRows_get_users_info = mysqli_num_rows($get_users_info);



  $head_title = "  الطلبة";
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
              <h4>عرض جميع الطلبة </h4>
            </div>
          </div>

          <div class="row">

            <div class="col-xs-12" style="padding: 20px;">
              <div class="col-md-2" style="font-weight: bold;"><a href="all-kids.php?trans2<?php if (isset($_GET['id'])) {
                echo "&id=" . $_GET['id'];
              } ?>">منقول</a> : <span id="trans2"></span></div>
              <div class="col-md-2" style="font-weight: bold;"><a href="all-kids.php?trans1<?php if (isset($_GET['id'])) {
                echo "&id=" . $_GET['id'];
              } ?>">مستجد</a> : <span id="trans1"></span></div>
              <div class="col-md-2" style="font-weight: bold;"><a href="all-kids.php?trans3<?php if (isset($_GET['id'])) {
                echo "&id=" . $_GET['id'];
              } ?>">باقين</a> : <span id="trans3"></span></div>
              <div class="col-md-2" style="font-weight: bold; display:none"><a href="all-kids.php?reg1<?php if (isset($_GET['id'])) {
                echo "&id=" . $_GET['id'];
              } ?>">مسلم</a> : <span id="reg1"></span></div>
              <div class="col-md-2" style="font-weight: bold; display:none"><a href="all-kids.php?reg2<?php if (isset($_GET['id'])) {
                echo "&id=" . $_GET['id'];
              } ?>">مسيحي</a> : <span id="reg2"></span></div>
              <div class="col-md-2" style="font-weight: bold;"><a href="all-kids.php<?php if (isset($_GET['id'])) {
                echo "?id=" . $_GET['id'];
              } ?>">اجمالى</a> : <span id="count"></span></div>

              <div class="col-md-3" style="font-weight: bold; padding-top:20px">
                <?php if ($row_get_login['access7sub6'] == 1 && isset($_GET['id'])) { ?>
                  <a href="kids-transfer.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger btn-block">ترحيل الي
                    <?php echo year_of_study($_GET['id'] + 1); ?> </a>
                <?php } ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card-body" data-toggle="match-height">
                <table id="court-datatables" class="table table-striped  dataTable" width="100%"
                  style="font-size: 16px;  ">
                  <thead>
                    <tr>
                      <th class="text-left">الاسم </th>
                      <th class="text-center"> التليفزن</th>
                      <th class="text-center"> العنوان</th>
                      <th class="text-center">رقم تعليمي</th>
                      <th class="text-center">رقم القومي</th>
                      <th class="text-left">المرحلة</th>
                      <?php if ($_GET['id'] == 13 || $_GET['id'] == 14) { ?>
                        <th class="text-center">التخصص</th>
                      <?php } ?>
                      <th class="text-center"> الفصل</th>
                      <th class="text-center"> تاريخ الميلاد</th>
                      <th class="text-center">النوع</th>
                      <th class="text-center">الحالة</th>
                      <th class="text-center"> </th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if ($totalRows_get_users_info > 0) {
                      do { ?>
                        <tr class="count">
                          <td class="text-left">
                            <?php if ($row_get_users_info['fn_name'] == NULL) {
                              echo $row_get_users_info['name'];
                            } else {
                              echo $row_get_users_info['fn_name'];
                            } ?>
                          </td>
                          <td class="text-center"><?php echo $row_get_users_info['father_mobile']; ?></td>
                          <td class="text-center"><?php echo $row_get_users_info['address']; ?></td>
                          <td class="text-center"><?php echo $row_get_users_info['ed_id']; ?></td>
                          <td class="text-center"><?php echo $row_get_users_info['gov_id']; ?></td>
                          <td class="text-left"><?php echo year_of_study($row_get_users_info['study_year']); ?></td>
                          <?php if ($_GET['id'] == 13 || $_GET['id'] == 14) { ?>
                            <td class="text-left"><?php echo study_type($row_get_users_info['study_type']); ?></td>
                          <?php } ?>
                          <td class="text-center"><?php echo $row_get_users_info['class_name']; ?></td>
                          <td class="text-center">
                            <?php if ($row_get_users_info['birthday'] > 0) {
                              echo date("m/d/Y", $row_get_users_info['birthday']);
                            } ?>
                          </td>
                          <td class="text-center"><?php echo $row_get_users_info['gender']; ?></td>
                          <td class="text-center <?php if ($row_get_users_info['transfare'] == 1) {
                            echo ' trans1 ';
                          }
                          if ($row_get_users_info['transfare'] == 2) {
                            echo ' trans2 ';
                          }
                          if ($row_get_users_info['transfare'] == 3) {
                            echo ' trans3 ';
                          } ?>">
                            <?php if ($row_get_users_info['transfare'] == 1) {
                              echo " مستجد";
                            }
                            if ($row_get_users_info['transfare'] == 2) {
                              echo " منقول";
                            }
                            if ($row_get_users_info['transfare'] == 0) {
                              echo " باقي";
                            } ?>
                          </td>

                          <td class="text-center">
                            <div class="dropdown">
                              <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button"
                                aria-expanded="false">
                                التحكم
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="view-kid.php?id=<?php echo $row_get_users_info['id']; ?>"> <i class="fa fa-eye"
                                      aria-hidden="true" style="color: green"></i> عرض </a></li>
                                <?php if ($row_get_login['access7sub6'] == 1) { ?>
                                  <li><a href="edit-kid.php?id=<?php echo $row_get_users_info['id']; ?>"> <i
                                        class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i> تعديل </a>
                                  </li>
                                <?php }
                                if ($row_get_users_info['linked'] == 1 && $row_get_login['access7sub8'] == 1) { ?>
                                  <li><a href="request-kid.php?id=<?php echo $row_get_users_info['id']; ?>"> <i
                                        class="fa fa-handshake-o" aria-hidden="true" style="color: green"></i> رساله </a></li>
                                <?php } ?>
                                <?php if ($row_get_users_info['id'] != 1 && $row_get_login['access7sub11'] == 1) { ?>
                                  <li role="separator" class="divider"></li>
                                  <li><a href="edit-kid.php?del=<?php echo $row_get_users_info['id']; ?>"
                                      onClick="return confirm('تاكيد؟');"> <i class="fa fa-trash-o" aria-hidden="true"
                                        style="color: red"></i> حذف </a></li>
                                <?php } ?>
                              </ul>
                            </div>
                          </td>
                        </tr>
                      <?php } while ($row_get_users_info = mysqli_fetch_assoc($get_users_info));
                    } ?>


                  </tbody>
                </table>


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

        $("#court-datatables").DataTable({
          paging: false,
          dom: 'Bfrtip',


          language: {
            paginate: {
              previous: "السابق",
              next: "التالي"
            },
            search: "_INPUT_",
            searchPlaceholder: "بحث"
          },
          order: [
            [0, "asc"]
          ],
          "aoColumnDefs": [
            {
              "bSortable": false,
              "aTargets": [<?php if ($_GET['id'] == 13 || $_GET['id'] == 14) {
                echo 9;
              } else {
                echo 7;
              } ?>]
            }
          ]
        });


        var reg1 = $('.reg1').length;
        $('#reg1').text(reg1);

        var reg2 = $('.reg2').length;
        $('#reg2').text(reg2);

        var trans1 = $('.trans1').length;
        $('#trans1').text(trans1);

        var trans2 = $('.trans2').length;
        $('#trans2').text(trans2);

        var trans3 = $('.trans3').length;
        $('#trans3').text(trans3);

        var count = $('.count').length;
        $('#count').text(count);

        $("input").keyup(function () {
          var reg1 = $('.reg1').length;
          $('#reg1').text(reg1);

          var reg2 = $('.reg2').length;
          $('#reg2').text(reg2);

          var trans1 = $('.trans1').length;
          $('#trans1').text(trans1);

          var trans2 = $('.trans2').length;
          $('#trans2').text(trans2);

          var trans3 = $('.trans3').length;
          $('#trans3').text(trans3);

          var count = $('.count').length;
          $('#count').text(count);

        });





      });
    </script>


  </body>

  </html>
<?php } else {
  header("location: home.php");
  exit();
} ?>