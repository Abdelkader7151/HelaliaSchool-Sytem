<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
require_once('includes/functions.php');

if ($row_get_login['access16'] == 1 && access_Cert($row_get_login['id'], $_GET['year']) == 1) {









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
        <!-- SheetJS for Excel export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <style>
            th {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            td {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .export-btn-wrap {
                margin-bottom: 15px;
                text-align: left;
            }
        </style>
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
                        <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true"
                            type="button">
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
                            <h4> عرض نتائج
                                المرحلة
                                <?php echo year_of_study($_GET['year']); ?>

                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">

                                <?php if (isset($_GET['year']) && isset($_GET['month'])) { ?>

                                    <div class="card-body" data-toggle="match-height">

                                        <div class="export-btn-wrap">
                                            <button type="button" id="export-excel-btn" class="btn btn-success">
                                                <i class="fa fa-file-excel-o"></i> تصدير إلى Excel
                                            </button>
                                        </div>

                                        <div style="overflow-x:auto;">
                                            <table id="results-table" class="table table-striped table-bordered" cellspacing="0"
                                                width="100%" style="font-size: 14px">
                                                <thead>
                                                    <tr style="font-size: 12px;">
                                                        <th class="text-center" style=" font-size: 16px;">الاسم
                                                        </th>
                                                        <th class="text-center" style="width:150px">الرقم التعليمي </th>
                                                        <?php
                                                        mysqli_select_db($database, $database_database);
                                                        $query_get_head = "SELECT distinct `subject_id` FROM `control` WHERE `study_year` = '{$_GET['year']}' AND `month` = '{$_GET['month']}' ORDER BY `subject_id` ASC ";
                                                        $get_head = mysqli_query($database, $query_get_head) or die(mysqli_error($database));
                                                        $row_get_head = mysqli_fetch_assoc($get_head);
                                                        $totalRows_get_head = mysqli_num_rows($get_head);
                                                        do { ?>
                                                            <th class="text-center" style="width:100px">
                                                                <?php echo subject_name($row_get_head['subject_id']); ?>
                                                                <br>
                                                                (<?php echo $row_get_head['subject_id']; ?>)
                                                            </th>
                                                        <?php } while ($row_get_head = mysqli_fetch_assoc($get_head)); ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th class="text-left"> </th>
                                                        <th class="text-center">اجمالب الدرجة </th>
                                                        <?php
                                                        $query_get_total = "SELECT distinct `subject_id`, `ex_total` FROM `control` WHERE `study_year` = '{$_GET['year']}' AND `month` = '{$_GET['month']}' ORDER BY `subject_id` ASC  ";
                                                        $get_total = mysqli_query($database, $query_get_total) or die(mysqli_error($database));
                                                        $row_get_total = mysqli_fetch_assoc($get_total);
                                                        $totalRows_get_total = mysqli_num_rows($get_total);
                                                        do { ?>
                                                            <th class="text-center">
                                                                <?php echo $row_get_total['ex_total']; ?>
                                                            </th>
                                                        <?php } while ($row_get_total = mysqli_fetch_assoc($get_total)); ?>
                                                    </tr>



                                                    <?php
                                                    $query_get_kids = "SELECT distinct `seat_id`, `arb_name`  FROM `control` WHERE `study_year` = '{$_GET['year']}' AND `month` = '{$_GET['month']}'  ORDER BY `arb_name` ASC  ";
                                                    $get_kids = mysqli_query($database, $query_get_kids) or die(mysqli_error($database));
                                                    $row_get_kids = mysqli_fetch_assoc($get_kids);
                                                    $totalRows_get_kids = mysqli_num_rows($get_kids);

                                                    do {
                                                        if ($row_get_kids['arb_name'] != NULL) { ?>
                                                            <tr>
                                                                <th class="text-left" style="padding-right: 10px !important;">
                                                                    <?php echo $row_get_kids['arb_name']; ?>
                                                                </th>
                                                                <th class="text-center"> <?php echo $row_get_kids['seat_id']; ?> </th>
                                                                <?php
                                                                mysqli_select_db($database, $database_database);
                                                                $query_get_class_info = "SELECT * FROM `control` WHERE `study_year` = '{$_GET['year']}' AND `month` = '{$_GET['month']}' and `seat_id` = '{$row_get_kids['seat_id']}' ORDER BY `subject_id` ASC ";
                                                                $get_class_info = mysqli_query($database, $query_get_class_info) or die(mysqli_error($database));
                                                                $row_get_class_info = mysqli_fetch_assoc($get_class_info);
                                                                $totalRows_get_class_info = mysqli_num_rows($get_class_info);

                                                                if ($totalRows_get_class_info > 0) {

                                                                    do { ?>
                                                                        <th class="text-center">
                                                                            <?php echo round($row_get_class_info['ex_result'], 2); ?>
                                                                        </th>
                                                                    <?php } while ($row_get_class_info = mysqli_fetch_assoc($get_class_info));
                                                                } ?>
                                                            </tr>
                                                        <?php }
                                                    } while ($row_get_kids = mysqli_fetch_assoc($get_kids)); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="card-body" data-toggle="match-height">


                                        <form method="get" name="form1" id="demo-inputmask" enctype="multipart/form-data"
                                            class="form form-horizontal">


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="month"> الشهر <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="month" required>
                                                        <option value="" selected> ...</option> --
                                                        <option value="10"> شهر 10 </option>
                                                        <option value="11"> شهر 11 </option>
                                                        <option value="12"> شهر 12 </option>
                                                        <option value="2"> شهر 2 </option>
                                                        <option value="3"> شهر 3 </option>
                                                        <option value="4"> شهر 4 </option>
                                                        <option value="5"> شهر 5 </option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="study_year"> المرحلة <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" required name="year">
                                                        <option selected disabled>...</option>
                                                        <option value="0"> بري سكول </option>
                                                        <option value="1">اولى حضانة</option>
                                                        <option value="2">ثانية حضانة</option>
                                                        <option value="3"> الصف الاول الابتدائى</option>
                                                        <option value="4"> الصف الثانى الابتدائى</option>
                                                        <option value="5"> الصف الثالث الابتدائى</option>
                                                        <option value="6"> الصف الرابع الابتدائى</option>
                                                        <option value="7"> الصف الخامس الابتدائى</option>
                                                        <option value="8"> الصف السادس الابتدائى</option>
                                                        <option value="9"> الصف الاول الاعدادى</option>
                                                        <option value="10"> الصف الثاني الاعدادى</option>
                                                        <option value="11"> الصف الثالث الاعدادى</option>
                                                        <option value="12"> الصف الاول الثانوى</option>
                                                        <option value="13"> الصف الثاني الثانوى</option>
                                                        <option value="14"> الصف الثالث الثانوى</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="submit"> </label>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-primary btn-block">عرض</button>
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                <?php } ?>
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
            document.addEventListener('DOMContentLoaded', function () {
                var btn = document.getElementById('export-excel-btn');
                if (!btn) return;

                btn.addEventListener('click', function () {
                    var table = document.getElementById('results-table');
                    if (!table) return;

                    // Build the workbook from the HTML table
                    var wb = XLSX.utils.table_to_book(table, { sheet: "النتائج" });

                    // Set sheet direction to RTL for Arabic
                    var ws = wb.Sheets["النتائج"];
                    if (!ws['!views']) ws['!views'] = [{}];
                    ws['!views'][0].RTL = true;

                    // Build filename
                    var year = "<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>";
                    var month = "<?php echo isset($_GET['month']) ? $_GET['month'] : ''; ?>";
                    var filename = "نتائج_المرحلة_" + year + "_شهر_" + month + ".xlsx";

                    XLSX.writeFile(wb, filename);
                });
            });
        </script>


    </body>

    </html>
<?php } else {
    header("location: home.php");
    exit();
} ?>