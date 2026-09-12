<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
require_once('includes/functions.php');

if ($row_get_login['access23sub2'] == 1) {

  $head_title = "الكنترول";
  ?>
  <!DOCTYPE html>
  <html lang="en" dir="rtl">

  <head>
    <?php include("includes/header.php"); ?>
    <?php include("includes/share.php"); ?>
    <?php include("includes/top-script.php"); ?>
    <link rel="stylesheet" href="css/application-rtl.min.css">
    <link rel="stylesheet" href="css/dashboard-3-rtl.min.css">
    <style>
      table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }

      th,
      td {
        text-align: left;
        padding: 0px !important;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2
      }

      @media print {
        * {
          color: black !important;
        }

        @page {
          size: landscape;
          margin: 10mm;
          <?php if (isset($_GET['lang']) && $_GET['lang'] == 1) {
            echo ' direction: ltr; ';
          } ?>
          <?php if (isset($_GET['lang']) && $_GET['lang'] == 2) {
            echo ' direction: rtl; ';
          } ?>
        }

        body {
          width: 100%;
          max-width: 100%;
          margin: 0 auto;
          font-size: 12pt;
        }

        #printable_div_id {
          width: 90%;
          margin: 0 auto;
          <?php if (isset($_GET['lang']) && $_GET['lang'] == 1) {
            echo ' direction: ltr important; ';
          } ?>
          <?php if (isset($_GET['lang']) && $_GET['lang'] == 2) {
            echo ' direction: rtl important; ';
          } ?>
        }

        header,
        footer,
        nav,
        .no-print {
          display: none;
        }

        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100% !important;
          border: 1px solid #ddd;
        }

        td,
        th {
          font-size: 8px !important;
        }

        .card-body {
          page-break-after: always;
        }

        .card-body:last-of-type {
          page-break-after: auto;
        }
      }
    </style>
  </head>

  <body class="layout layout-header-fixed">

    <div class="layout-header">
      <div class="navbar navbar-default">
        <div class="navbar-header" style="background-color: black">
          <a class="navbar-brand navbar-brand-center" href="home.php" style="padding: 5px"></a>
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

          <?php if (!isset($_GET['month'])) { ?>

            <div class="row">
              <div class="col-md-12">
                <h4>طباعة الرجستر</h4>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="demo-form-wrapper">
                  <form action="export-monthly2.php" method="get" name="form1" id="demo-inputmask"
                    enctype="multipart/form-data" class="form form-horizontal">

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="month">الشهر <span style="color: red;">*</span></label>
                      <div class="col-sm-2">
                        <select class="form-control" name="month" id="month" required>
                          <option value="10">ترم اول</option>
                          <option value="3" selected>ترم ثاني</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="study_year">المرحلة <span
                          style="color: red;">*</span></label>
                      <div class="col-sm-3">
                        <select class="form-control" required name="year" id="study_year">
                          <option selected disabled>...</option>
                          <option value="0">بري سكول</option>
                          <option value="1">اولى حضانة</option>
                          <option value="2">ثانية حضانة</option>
                          <option value="3">الصف الاول الابتدائى</option>
                          <option value="4">الصف الثانى الابتدائى</option>
                          <option value="5">الصف الثالث الابتدائى</option>
                          <option value="6">الصف الرابع الابتدائى</option>
                          <option value="7">الصف الخامس الابتدائى</option>
                          <option value="8">الصف السادس الابتدائى</option>
                          <option value="9">الصف الاول الاعدادى</option>
                          <option value="10">الصف الثاني الاعدادى</option>
                          <option value="11">الصف الثالث الاعدادى</option>
                          <option value="12">الصف الاول الثانوى</option>
                          <option value="13">الصف الثاني الثانوى</option>
                          <option value="14">الصف الثالث الثانوى</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="class">الفصل <span style="color: red;">*</span></label>
                      <div class="col-sm-3">
                        <select class="form-control" name="class" id="class" required>
                          <option selected></option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group" style="display: none;">
                      <label class="col-sm-3 control-label" for="lang">العرض</label>
                      <div class="col-sm-2">
                        <select class="form-control" name="lang" id="lang">
                          <option value="2">انجليزي</option>
                          <option value="1">عربي</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary">عرض</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>

          <?php } else {

            if (!isset($_GET['class'])) {
              echo "<div class='row'>
                      <div class='col-md-12'>
                        <h1 class='text-center'>Class " . class_name($_GET['class']) . "</h1>
                      </div>
                    </div>";
            }

            if ($_GET['month'] == 10) {
              $month1 = 10;
              $month2 = 11;
              $month = 12;
            }
            if ($_GET['month'] == 3) {
              $month1 = 3;
              $month2 = 4;
              $month = 3;
            }

            if ($_GET['class'] == 0) {
              $class = "";
            } else {
              $class = " AND `class` = '{$_GET['class']}' ";
            }

            $sort = ' `name` ASC ';
            ?>

            <!-- Action Buttons Row -->
            <div class="row no-print" style="margin-bottom: 15px; margin-top: 10px;">
              <div class="col-md-12">
                <button onclick="window.print();" class="btn btn-default">
                  <i class="fa fa-print"></i> طباعة
                </button>
                &nbsp;
                <button onclick="exportTableToExcel('court-datatables-kids2')" class="btn btn-success">
                  <i class="fa fa-file-excel-o"></i> تصدير Excel
                </button>
                &nbsp;
                <a href="export-monthly2.php" class="btn btn-default">
                  <i class="fa fa-arrow-right"></i> رجوع
                </a>
              </div>
            </div>

            <?php
            if ($_GET['year'] > 11 && $_GET['month'] != 0) {
              include("export-monthly-data-senior2.php");
            }
            if (($_GET['year'] == 3 || $_GET['year'] == 4) && $_GET['month'] != 0) {
              include("export-monthly-data-j-small2.php");
            }
            if ($_GET['year'] > 4 && $_GET['year'] < 9 && $_GET['month'] != 0) {
              include("export-monthly-data-j-big2.php");
            }
            if ($_GET['year'] > 8 && $_GET['year'] < 12 && $_GET['month'] != 0) {
              include("export-monthly-data-med2.php");
            }

          } ?>

        </div>
      </div>

      <?php include("includes/footer.php"); ?>
    </div>

    <?php include("includes/footer-script.php"); ?>
    <script src="js/application.min.js"></script>

    <script>
      function exportTableToExcel(tableID) {
        var table = document.getElementById(tableID);
        if (!table) {
          // Fallback: grab the first table inside the content area
          table = document.querySelector('.layout-content-body table');
        }
        if (!table) {
          alert('لم يتم العثور على الجدول');
          return;
        }

        var html =
          '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
                'xmlns="http://www.w3.org/TR/REC-html40">' +
          '<head>' +
            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' +
            '<!--[if gte mso 9]><xml>' +
              '<x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>' +
                '<x:Name>Register</x:Name>' +
                '<x:WorksheetOptions>' +
                  '<x:DisplayRightToLeft/>' +
                  '<x:DisplayGridlines/>' +
                '</x:WorksheetOptions>' +
              '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook>' +
            '</xml><![endif]-->' +
            '<style>td, th { mso-number-format:"\\@"; border:1px solid #000; padding:3px; }</style>' +
          '</head>' +
          '<body dir="rtl">' + table.outerHTML + '</body></html>';

        // '\uFEFF' is the UTF-8 BOM — required for Excel to render Arabic correctly
        var blob = new Blob(['\uFEFF', html], {
          type: 'application/vnd.ms-excel;charset=utf-8'
        });

        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'register_' + Date.now() + '.xls';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
      }

      function printdiv(elem) {
        var header_str = '<html><head><title>' + document.title + '</title></head><body>';
        var footer_str = '</body></html>';
        var new_str = document.getElementById(elem).innerHTML;
        var old_str = document.body.innerHTML;
        document.body.innerHTML = header_str + new_str + footer_str;
        window.print();
        document.body.innerHTML = old_str;
        return false;
      }

      $(document).ready(function () {
        $("#study_year").change(function () {
          var year = $(this).val();

          $.post("get_class4.php", { year: year }, function (Date, status) {
            $("#class").html(Date);
          });

          $.post("get_subject3.php", { year: year }, function (Date, status) {
            $("#subject").html(Date);
          });
        });
      });
    </script>

  </body>

  </html>

<?php } else {
  header("location: home.php");
  exit();
} ?>