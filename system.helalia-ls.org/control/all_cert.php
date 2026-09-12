<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
require_once('includes/functions.php');

if ($row_get_login['access16'] == 1) {




  if (isset($_GET['active']) && isset($_GET['type'])) {
    mysqli_select_db($database, "db");
    $updateSQL = sprintf(
      "UPDATE `certificate` SET `active`= %s  WHERE `type`= %s AND `study_year`= %s ",
      GetSQLValueString($database, $_GET['active'], "int"),
      GetSQLValueString($database, $_GET['type'], "int"),
      GetSQLValueString($database, $_GET['id'], "int")
    );

    mysqli_query($database, $updateSQL) or die(mysqli_error($database));
    header("location: all_cert.php");
    exit();
  }




  if (isset($_GET['del']) && access_Cert($row_get_login['id'], $_GET['del']) == 1) {
    mysqli_select_db($database, "db");
    mysqli_query($database, " DELETE FROM `certificate` WHERE `study_year` = '{$_GET['del']}'  ");
    header("location: all_cert.php");
    exit();
  }

  mysqli_select_db($database, $database_database);
  $query_get_class_info = "SELECT distinct `study_year`  FROM `certificate` ORDER BY `id` DESC  ";
  $get_class_info = mysqli_query($database, $query_get_class_info) or die(mysqli_error($database));
  $row_get_class_info = mysqli_fetch_assoc($get_class_info);
  $totalRows_get_class_info = mysqli_num_rows($get_class_info);

  function class_name2($id)
  {
    global $database;
    $query_get_data = "SELECT `name` FROM `class` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if ($row_get_data['name'] == 0) {
      return 'جميع الفصول';
    } else {
      return $row_get_data['name'];
    }
  }


  $head_title = "    النتائج";
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
              <h4>عرض جميع النتائج </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body" data-toggle="match-height">
                  <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0"
                    width="100%" style="font-size: 16px">
                    <thead>
                      <tr>

                        <th class="text-left">الالعنوان </th>
                        <th class="text-left">السنة الدراسية </th>
                        <th class="text-left"> الفصل </th>
                        <th class="text-center">تاريخ </th>
                        <th class="text-center"> </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php if ($totalRows_get_class_info > 0) {
                        do {

                          if (access_Cert($row_get_login['id'], $row_get_class_info['study_year']) == 1) {

                            mysqli_select_db($database, $database_database);
                            $query_get_data = "SELECT * FROM `certificate` WHERE `study_year` = '{$row_get_class_info['study_year']}' and `type` = 2  ";
                            $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
                            $row_get_data = mysqli_fetch_assoc($get_data);
                            $totalRows_get_data = mysqli_num_rows($get_data);
                            if ($totalRows_get_data > 0) { ?>
                              <tr>

                                <td class="text-left"><?php echo $row_get_data['title_arb']; ?></td>
                                <td class="text-left"><?php echo year_of_study($row_get_data['study_year']); ?></td>
                                <td class="text-left"><?php echo class_name2($row_get_data['class']); ?></td>
                                <td class="text-center"><?php echo date("d/m/Y", $row_get_data['date']); ?></td>
                                <td class="text-center">
                                  <div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button"
                                      aria-expanded="false">
                                      التحكم
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li><a
                                          href="view_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> النتائج </a></li>
                                      <li><a
                                          href="view_cert_turm.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> اعمال السنة </a></li>
                                      <?php if ($row_get_login['id'] == 1) { ?>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=1">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اظهار النتائج
                                          </a></li>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=0">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اخفاء النتائج
                                          </a></li>
                                        <li></li>
                                        <li><a href="all_cert.php?del=<?php echo $row_get_data['study_year']; ?>"
                                            onClick="return confirm('تاكيد؟');"> <i class="fa fa-trash-o" aria-hidden="true"
                                              style="color: red"></i> حذف </a></li>
                                      <?php } ?>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                            <?php }

                            mysqli_select_db($database, $database_database);
                            $query_get_data = "SELECT * FROM `certificate` WHERE `study_year` = '{$row_get_class_info['study_year']}' and `type` = 3   ";
                            $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
                            $row_get_data = mysqli_fetch_assoc($get_data);
                            $totalRows_get_data = mysqli_num_rows($get_data);
                            if ($totalRows_get_data > 0) { ?>
                              <tr>

                                <td class="text-left"><?php echo $row_get_data['title_arb']; ?></td>
                                <td class="text-left"><?php echo year_of_study($row_get_data['study_year']); ?></td>
                                <td class="text-left"><?php echo class_name2($row_get_data['class']); ?></td>
                                <td class="text-center"><?php echo date("d/m/Y", $row_get_data['date']); ?></td>
                                <td class="text-center">
                                  <div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button"
                                      aria-expanded="false">
                                      التحكم
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li><a
                                          href="view_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> النتائج </a></li>
                                      <li><a
                                          href="view_cert_turm.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> اعمال السنة </a></li>
                                      <?php if ($row_get_login['id'] == 1) { ?>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=1">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اظهار النتائج
                                          </a></li>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=0">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اخفاء النتائج
                                          </a></li>
                                        <li></li>
                                        <li><a href="all_cert.php?del=<?php echo $row_get_data['study_year']; ?>"
                                            onClick="return confirm('تاكيد؟');"> <i class="fa fa-trash-o" aria-hidden="true"
                                              style="color: red"></i> حذف </a></li>
                                      <?php } ?>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                            <?php }

                             mysqli_select_db($database, $database_database);
                            $query_get_data = "SELECT * FROM `certificate` WHERE `study_year` = '{$row_get_class_info['study_year']}' and `type` = 4   ";
                            $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
                            $row_get_data = mysqli_fetch_assoc($get_data);
                            $totalRows_get_data = mysqli_num_rows($get_data);
                            if ($totalRows_get_data > 0) { ?>
                              <tr>

                                <td class="text-left"><?php echo $row_get_data['title_arb']; ?></td>
                                <td class="text-left"><?php echo year_of_study($row_get_data['study_year']); ?></td>
                                <td class="text-left"><?php echo class_name2($row_get_data['class']); ?></td>
                                <td class="text-center"><?php echo date("d/m/Y", $row_get_data['date']); ?></td>
                                <td class="text-center">
                                  <div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button"
                                      aria-expanded="false">
                                      التحكم
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li><a
                                          href="view_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> النتائج </a></li>
                                      <li><a
                                          href="view_cert_turm.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>">
                                          <i class="fa fa-eye" aria-hidden="true" style="color: green"></i> اعمال السنة </a></li>
                                      <?php if ($row_get_login['id'] == 1) { ?>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=1">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اظهار النتائج
                                          </a></li>
                                        <li><a
                                            href="all_cert.php?id=<?php echo $row_get_data['study_year']; ?>&type=<?php echo $row_get_data['type']; ?>&active=0">
                                            <i class="fa fa-certificate" aria-hidden="true" style="color: green"></i> اخفاء النتائج
                                          </a></li>
                                        <li></li>
                                        <li><a href="all_cert.php?del=<?php echo $row_get_data['study_year']; ?>"
                                            onClick="return confirm('تاكيد؟');"> <i class="fa fa-trash-o" aria-hidden="true"
                                              style="color: red"></i> حذف </a></li>
                                      <?php } ?>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                            <?php }

                          }
                        } while ($row_get_class_info = mysqli_fetch_assoc($get_class_info));
                      } ?>


                    </tbody>
                  </table>
                </div>
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
          dom: 'Bfrtip',
          buttons: [
            'copy', 'pdf', 'print'
          ],
          language: {
            paginate: {
              previous: "&laquo;",
              next: "&raquo;"
            },
            search: "_INPUT_",
            searchPlaceholder: "Search…"
          },
          order: [
            [3, "desc"]
          ],
          "aoColumnDefs": [
            {
              "bSortable": false,
              "aTargets": [4]
            }
          ]
        });

      });
    </script>


  </body>

  </html>
<?php } else {
  header("location: home.php");
  exit();
} ?>