<style>
  .sidenav-label {
    font-size: 16px !important;
  }

  .sidenav a {
    font-size: 16px !important;
  }
</style>


<div class="layout-sidebar">
  <div class="layout-sidebar-backdrop" style="background-color: #112c5a;"></div>
  <div class="layout-sidebar-body">
    <div class="custom-scrollbar">
      <nav id="sidenav" class="sidenav-collapse collapse " style="border-left: solid 1px #f1595d">
        <ul class="sidenav level-1">
          <li class="sidenav-item <?php if (get_url($_SERVER['REQUEST_URI']) == 'home.php') {
            echo 'active ';
          } ?>" style="margin-top: 70px">
            <a href="home.php">
              <span class="sidenav-icon icon icon-dashboard"></span>
              <span class="sidenav-label f18">الرئيسية</span>
            </a>
          </li>

          <?php if ($row_get_login['access1'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'class-announce.php' || get_url($_SERVER['REQUEST_URI']) == 'all-class-kids.php' || get_url($_SERVER['REQUEST_URI']) == 'new-class.php' || get_url($_SERVER['REQUEST_URI']) == 'all-classs.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-class.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works">&#103;</span>
                <span class="sidenav-label"> الفصول</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access1sub1'] == 1) { ?>
                  <li><a href="new-class.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-class.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> فصل جديد</a></li>
                <?php }
                if ($row_get_login['access1sub2'] == 1) { ?>
                  <li><a href="all-classs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-classs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع الفصول</a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access2'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'cancel-classgroup.php' || get_url($_SERVER['REQUEST_URI']) == 'all-classgroups-new-absence.php' || get_url($_SERVER['REQUEST_URI']) == 'all-classgroups-absence.php' || get_url($_SERVER['REQUEST_URI']) == 'all-classgroup-kids.php' || get_url($_SERVER['REQUEST_URI']) == 'new-classgroup-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'new-classgroup.php' || get_url($_SERVER['REQUEST_URI']) == 'all-classgroups.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-classgroup.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-bolt" aria-hidden="true"></i></span>
                <span class="sidenav-label"> مجموعات التقوية</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access2sub1'] == 1) { ?>
                  <li><a href="new-classgroup.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-classgroup.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> مجموعة جديد</a></li>
                <?php }
                if ($row_get_login['access2sub2'] == 1) { ?>
                  <li><a href="all-classgroups.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-classgroups.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع مجموعات</a></li>
                <?php }
                if ($row_get_login['access2sub3'] == 1) { ?>
                  <li><a href="all-classgroups-new-absence.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-classgroups-new-absence.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> غياب اليوم </a></li>
                <?php }
                if ($row_get_login['access2sub4'] == 1) { ?>
                  <li><a href="all-classgroups-absence.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-classgroups-absence.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> غياب الطلبة </a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access3'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'all-cor-teachers.php' || get_url($_SERVER['REQUEST_URI']) == 'add-cor-teachers.php' || get_url($_SERVER['REQUEST_URI']) == 'coordinators.php' || get_url($_SERVER['REQUEST_URI']) == 'all-teachers.php' || get_url($_SERVER['REQUEST_URI']) == 'all-subject-teachers.php' || get_url($_SERVER['REQUEST_URI']) == 'new-subject.php' || get_url($_SERVER['REQUEST_URI']) == 'all-subjects.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-subject.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                <span class="sidenav-label"> المواد الدراسية</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access3sub1'] == 1) { ?>
                  <li><a href="new-subject.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-subject.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> مادة جديد</a></li>
                <?php }
                if ($row_get_login['access3sub2'] == 1) { ?>
                  <li><a href="all-subjects.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-subjects.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع المواد</a></li>
                <?php }
                if ($row_get_login['access2sub3'] == 1) { ?>
                  <li><a href="all-teachers.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-teachers.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> المدرسين</a></li>
                  <li><a href="coordinators.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'coordinators.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> المنسقين</a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access4'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-appointment.php' || get_url($_SERVER['REQUEST_URI']) == 'all-appointments.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-appointment.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-handshake-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> المقابلات</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access4sub1'] == 1) { ?>
                  <li><a href="new-appointment.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-appointment.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> مقابلة جديد</a></li>
                <?php }
                if ($row_get_login['access4sub2'] == 1) { ?>
                  <li><a href="all-appointments.php?id=1" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-appointments.php' && $_GET['id'] == 1) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع المقابلات المتاحة</a></li>
                <?php }
                if ($row_get_login['access4sub3'] == 1) { ?>
                  <li><a href="all-appointments.php?id=2" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-appointments.php' && $_GET['id'] == 2) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع المقابلات المحجوزة</a></li>
                <?php }
                if ($row_get_login['access4sub4'] == 1) { ?>
                  <li><a href="all-appointments.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-appointments.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع المقابلات</a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access5'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-job.php' || get_url($_SERVER['REQUEST_URI']) == 'new-job.php' || get_url($_SERVER['REQUEST_URI']) == 'all-jobs.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-job.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-address-book" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الوظائف</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access5sub1'] == 1) { ?>
                  <li><a href="new-job.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-job.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> وظيفة جديد</a></li>
                <?php }
                if ($row_get_login['access5sub2'] == 1) { ?>
                  <li><a href="all-jobs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-jobs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع الوظائف</a></li>
                <?php } ?>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access19'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-homework.php' || get_url($_SERVER['REQUEST_URI']) == 'all-homeworks.php' || get_url($_SERVER['REQUEST_URI']) == 'search-homeworks.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-pencil-square" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الواجبات المدرسية</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access19sub1'] == 1) { ?>
                  <li><a href="new-homework.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-homework.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> اضافة</a></li>
                <?php }
                if ($row_get_login['access19sub2'] == 1) { ?>
                  <li><a href="all-homeworks.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-homeworks.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع الواجبات</a></li>
                <?php }
                if ($row_get_login['access19sub3'] == 1) { ?>
                  <li><a href="search-homeworks.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'search-homeworks.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-search" aria-hidden="true"></i> بحث الواجبات</a></li>
                <?php } ?>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access21'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-revision.php' || get_url($_SERVER['REQUEST_URI']) == 'all-revision.php' || get_url($_SERVER['REQUEST_URI']) == 'search-revision.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                <span class="sidenav-label"> المراجعات </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access21sub1'] == 1) { ?>
                  <li><a href="new-revision.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-revision.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> اضافة</a></li>
                <?php }
                if ($row_get_login['access21sub2'] == 1) { ?>
                  <li><a href="all-revision.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-revision.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع المراجعات</a></li>
                <?php }
                if ($row_get_login['access21sub3'] == 1) { ?>
                  <li><a href="search-revision.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'search-revision.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-search" aria-hidden="true"></i> بحث المراجعات</a></li>
                <?php } ?>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access20'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-weeklyplan.php' || get_url($_SERVER['REQUEST_URI']) == 'all-weeklyplans.php' || get_url($_SERVER['REQUEST_URI']) == 'search-weeklyplans.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-arrows" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الخطة الاسبوعية</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access20sub1'] == 1) { ?>
                  <li><a href="new-weeklyplan.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-weeklyplan.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> اضافة</a></li>
                <?php }
                if ($row_get_login['access20sub2'] == 1) { ?>
                  <li><a href="all-weeklyplans.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-weeklyplans.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جمبع الخطط</a></li>
                <?php } ?>
              </ul>
            </li>


          <?php }
          if ($row_get_login['access6'] == 1) { ?>

            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'attendance-settings.php' || get_url($_SERVER['REQUEST_URI']) == 'attend-all.php' || get_url($_SERVER['REQUEST_URI']) == 'attend-today.php' || get_url($_SERVER['REQUEST_URI']) == 'import-attendance.php' || get_url($_SERVER['REQUEST_URI']) == 'birthday-card.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps-exc.php' || get_url($_SERVER['REQUEST_URI']) == 'emp-all-exc.php' || get_url($_SERVER['REQUEST_URI']) == 'view-emps-exc.php' || get_url($_SERVER['REQUEST_URI']) == 'view-emps-vacation.php' || get_url($_SERVER['REQUEST_URI']) == 'emp-all-vac.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-month.php' || get_url($_SERVER['REQUEST_URI']) == 'teacher-subjects.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-today.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-10.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-emp.php' || get_url($_SERVER['REQUEST_URI']) == 'new-emp.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emps.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-users" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الموظفين</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access6sub1'] == 1) { ?>
                  <li><a href="new-emp.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-emp.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> موظف جديد</a></li>
                <?php }
                if ($row_get_login['access6sub2'] == 1) { ?>
                  <li><a href="all-emps.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الموظفين </a></li>
                <?php }
                if ($row_get_login['access6sub4'] == 1) { ?>
                  <li><a href="all-emps-birthday-10.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-10.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-calendar" aria-hidden="true"></i> عياد الميلاد في 10 أيام </a></li>
                  <li><a href="all-emps-birthday-month.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-month.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-calendar" aria-hidden="true"></i> عياد الميلاد خلال الشهر </a></li>
                  <li><a href="all-emps-birthday-today.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-birthday-today.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-birthday-cake" aria-hidden="true"></i> عياد الميلاد اليوم </a></li>
                  <li><a href="birthday-card.php?id=2" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'birthday-card.php?id=2') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-heart" aria-hidden="true"></i> بطاقة التهنئة </a></li>
                <?php }
                if ($row_get_login['access6sub5'] == 1) { ?>
                  <li><a href="all-emps-vacations.php?id=0" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 0) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اجازات جديدى </a></li>
                  <li><a href="all-emps-vacations.php?id=1" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 1) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اجازات مقبولة </a></li>
                  <li><a href="all-emps-vacations.php?id=2" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 2) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اجازات مرفوضة </a></li>
                  <li><a href="all-emps-vacations.php?id=3" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 3) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اجازات ملغية </a></li>
                  <li><a href="all-emps-vacations.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الاجازات </a></li>
                <?php }
                if ($row_get_login['access6sub6'] == 1) { ?>
                  <li><a href="all-emps-exc.php?id=0" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-exec.php' && isset($_GET['id']) && $_GET['id'] == 0) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اذون جديدى </a></li>
                  <li><a href="all-emps-exc.php?id=1" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 1) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اذون مقبولة </a></li>
                  <li><a href="all-emps-exc.php?id=2" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 2) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اذون مرفوضة </a></li>
                  <li><a href="all-emps-exc.php?id=3" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && isset($_GET['id']) && $_GET['id'] == 3) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اذون ملغية </a></li>
                  <li><a href="all-emps-exc.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emps-vacations.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الاذون </a></li>



                  <li><a href="attend-all.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'attend-all.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> حضور و انصارف مجمع </a></li>
                  <li><a href="attend-today.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'attend-today.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> حضور و انصارف اليوم </a></li>
                  <li><a href="import-attendance.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'import-attendance.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-download" aria-hidden="true"></i> تحميل الحضور والانصراف </a></li>
                  <li><a href="attendance-settings.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'attendance-settings.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-cog" aria-hidden="true"></i> مواعيد الحضور </a></li>

                <?php } ?>
              </ul>
            </li>


          <?php }
          if ($row_get_login['access7'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'leave-kid-list.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-reg-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'view-reg-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'reg-kid-list.php' || get_url($_SERVER['REQUEST_URI']) == 'reg-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'find-kids.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-absence-collect-day.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-absence-by-cat.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-absence-collect-class.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-absence-collect.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-absence-by-range.php' || get_url($_SERVER['REQUEST_URI']) == 'view_kid_cert.php' || get_url($_SERVER['REQUEST_URI']) == 'kids-transfer.php' || get_url($_SERVER['REQUEST_URI']) == 'request-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-print.php' || get_url($_SERVER['REQUEST_URI']) == 'birthday-card.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-month.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-new-absence.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-absence.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-vacations.php' || get_url($_SERVER['REQUEST_URI']) == 'view-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-today.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-10.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'new-kid.php' || get_url($_SERVER['REQUEST_URI']) == 'all-kids.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الطلبة</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access7sub0'] == 1) { ?>
                  <li><a href="reg-kid.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'reg-kid.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-file-text" aria-hidden="true"></i> تسجيل جديد</a></li>
                  <li><a href="reg-kid-list.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'reg-kid-list.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> قائمة التسجيل </a></li>
                  <li><a href="leave-kid-list.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'leave-kid-list.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> قائمة سحب الملف </a></li>
                <?php }
                if ($row_get_login['access7sub1'] == 1) { ?>
                  <li><a href="new-kid.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-kid.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> طالب جديد</a></li>
                <?php }
                if ($row_get_login['access7sub2'] == 1) { ?>
                  <li><a href="find-kids.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'find-kids.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-search" aria-hidden="true"></i> بحث الطلبة </a></li>
                  <li><a href="all-kids.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الطلبة </a></li>
                  <!--<li><a href="all-kids.php?id=15" style="<?php //if(get_url($_SERVER['REQUEST_URI'])=='all-kids.php?id=15' ){echo ' color: #f1595d';} ?>"><i class="fa fa-list-ul" aria-hidden="true"></i>     الخرجين </a></li> -->
                  <li><a href="all-kids-print.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-print.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-print" aria-hidden="true"></i> طباعة جميع الطلبة </a></li>
                <?php }
                if ($row_get_login['access7sub3'] == 1) { ?>
                  <li><a href="all-kids-birthday-10.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-10.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-calendar" aria-hidden="true"></i> عياد الميلاد في 10 أيام </a></li>
                  <li><a href="all-kids-birthday-month.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-month.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-calendar" aria-hidden="true"></i> عياد الميلاد خلال الشهر </a></li>
                  <li><a href="all-kids-birthday-today.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-birthday-today.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-birthday-cake" aria-hidden="true"></i> عياد الميلاد اليوم </a></li>
                  <li><a href="birthday-card.php?id=1" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'birthday-card.php?id=1') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-heart" aria-hidden="true"></i> بطاقة التهنئة </a></li>
                <?php }
                if ($row_get_login['access7sub4'] == 1) { ?>
                  <li><a href="all-kids-vacations.php?id=0" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-vacations.php' && isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اجازات جديدة </a></li>
                  <li><a href="all-kids-vacations.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-vacations.php' && !isset($_GET['id'])) {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الاجازات </a></li>
                <?php }
                if ($row_get_login['access7sub2'] == 1) {
                  if ($row_get_login['access18sub1'] == 1) { ?>
                    <li><a href="all-kids.php?id=0" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=0' && $_GET['id'] == 0) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> بري سكول </a></li>
                  <?php }
                  if ($row_get_login['access18sub2'] == 1) { ?>
                    <li><a href="all-kids.php?id=1" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=1' && $_GET['id'] == 1) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> اولى حضانة </a></li>
                  <?php }
                  if ($row_get_login['access18sub3'] == 1) { ?>
                    <li><a href="all-kids.php?id=2" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=2' && $_GET['id'] == 2) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> ثانية حضانة </a></li>
                  <?php }
                  if ($row_get_login['access18sub4'] == 1) { ?>
                    <li><a href="all-kids.php?id=3" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=3' && $_GET['id'] == 3) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الاول الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub5'] == 1) { ?>
                    <li><a href="all-kids.php?id=4" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=4' && $_GET['id'] == 4) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثانى الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub6'] == 1) { ?>
                    <li><a href="all-kids.php?id=5" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=5' && $_GET['id'] == 5) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثالث الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub7'] == 1) { ?>
                    <li><a href="all-kids.php?id=6" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=6' && $_GET['id'] == 6) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الرابع الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub8'] == 1) { ?>
                    <li><a href="all-kids.php?id=7" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=7' && $_GET['id'] == 7) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الخامس الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub9'] == 1) { ?>
                    <li><a href="all-kids.php?id=8" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=8' && $_GET['id'] == 8) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف السادس الابتدائى </a></li>
                  <?php }
                  if ($row_get_login['access18sub10'] == 1) { ?>
                    <li><a href="all-kids.php?id=9" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=9' && $_GET['id'] == 9) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الاول الاعدادى </a></li>
                  <?php }
                  if ($row_get_login['access18sub11'] == 1) { ?>
                    <li><a href="all-kids.php?id=10" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=10' && $_GET['id'] == 10) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثاني الاعدادى </a></li>
                  <?php }
                  if ($row_get_login['access18sub12'] == 1) { ?>
                    <li><a href="all-kids.php?id=11" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=11' && $_GET['id'] == 11) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثالث الاعدادى </a></li>
                  <?php }
                  if ($row_get_login['access18sub13'] == 1) { ?>
                    <li><a href="all-kids.php?id=12" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=12' && $_GET['id'] == 12) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الاول الثانوى </a></li>
                  <?php }
                  if ($row_get_login['access18sub14'] == 1) { ?>
                    <li><a href="all-kids.php?id=13" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=13' && $_GET['id'] == 13) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثاني الثانوى </a></li>
                  <?php }
                  if ($row_get_login['access18sub15'] == 1) { ?>
                    <li><a href="all-kids.php?id=14" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids.php?id=14' && $_GET['id'] == 14) {
                      echo ' color: #f1595d';
                    } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الصف الثالث الثانوى </a></li>
                  <?php }
                }
                if ($row_get_login['access7sub5'] == 1) { ?>
                  <li><a href="kids-absence-collect.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'kids-absence-collect.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تجميع غياب اليوم </a></li>
                  <li><a href="kids-absence-collect-day.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'kids-absence-collect-day.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> غياب يوم سابق </a></li>

                  <li><a href="all-kids-new-absence.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-new-absence.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> غياب اليوم </a></li>
                  <li><a href="all-kids-absence.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-kids-absence.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> غياب الطلبة </a></li>
                  <li><a href="kids-absence-by-range.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'kids-absence-by-range.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تقرير الغياب </a></li>
                  <li><a href="kids-absence-by-cat.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'kids-absence-by-cat.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تقرير الغياب مجمع </a></li>
                <?php } ?>
              </ul>
            </li>


          <?php }
          if ($row_get_login['access8'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'all-app1-accounts.php' || get_url($_SERVER['REQUEST_URI']) == 'all-app2-accounts.php' || get_url($_SERVER['REQUEST_URI']) == 'all-app-accounts.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-app-account.php' || get_url($_SERVER['REQUEST_URI']) == 'view-app-account.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <span class="sidenav-label"> حسابات البرنامج</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access8sub1'] == 1) { ?>
                  <li><a href="all-app-accounts.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-app-accounts.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الحسابات </a></li>
                <?php }
                if ($row_get_login['access8sub2'] == 1) { ?>
                  <li><a href="all-app1-accounts.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-app1-accounts.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> حسابات اولياء الامور </a></li>
                <?php }
                if ($row_get_login['access8sub4'] == 1) { ?>
                  <li><a href="all-app2-accounts.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-app2-accounts.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> حسابات الموظفين </a></li>
                <?php } ?>
              </ul>
            </li>





          <?php }
          if ($row_get_login['access23'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'export-monthly2.php' || get_url($_SERVER['REQUEST_URI']) == 'view_month_deg.php' || get_url($_SERVER['REQUEST_URI']) == 'all-control-year.php' || get_url($_SERVER['REQUEST_URI']) == 'control-year-step2.php' || get_url($_SERVER['REQUEST_URI']) == 'new-control-year.php' || get_url($_SERVER['REQUEST_URI']) == 'control-step2.php' || get_url($_SERVER['REQUEST_URI']) == 'new-control.php' || get_url($_SERVER['REQUEST_URI']) == 'all-control.php' || get_url($_SERVER['REQUEST_URI']) == 'export-control.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-control.php' || get_url($_SERVER['REQUEST_URI']) == 'export-monthly.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الكنترول</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access23sub1'] == 1) { ?>
                  <li><a href="new-control.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-control.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> رصد الدرجات </a></li>
                <?php }
                if ($row_get_login['access23sub5'] == 1) { ?>
                  <li><a href="new-control-year.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-control-year.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> رصد اعمال السنة </a></li>
                <?php }
                if ($row_get_login['access23sub2'] == 1) { ?>
                  <li><a href="all-control.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-control.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> عرض الدرجات </a></li>
                  <li><a href="all-control-year.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-control-year.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> عرض اعمال السنة </a></li>
                  <li><a href="export-monthly.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'export-monthly.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> شهري </a></li>
                  <!--<li><a href="view_month_deg.php" style="<?php //if (get_url($_SERVER['REQUEST_URI']) == 'view_month_deg.php') {
                    //echo ' color: #f1595d';
                 // } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> مراجعة </a></li>-->

                  <li><a href="export-monthly2.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'export-monthly2.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> مجمع </a></li>

                  <li><a href="export-control.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'export-control.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> تصدير </a></li>
                <?php } ?>
              </ul>
            </li>







          <?php }
          if ($row_get_login['access9'] == 1) { ?>

            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-teacher-msg.php' || get_url($_SERVER['REQUEST_URI']) == 'view-teacher-msg.php' || get_url($_SERVER['REQUEST_URI']) == 'all-teacher-msg.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-teacher-msg.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-question-circle-o"
                    aria-hidden="true"></i></span>
                <span class="sidenav-label"> رسائل الي المدرسين</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access9sub1'] == 1) { ?>
                  <li><a href="new-teacher-msg.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-teacher-msg.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> رسائل جديدة </a></li>
                <?php }
                if ($row_get_login['access9sub2'] == 1) { ?>
                  <li><a href="all-teacher-msg.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-teacher-msg.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الرسائل </a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access10'] == 1) { ?>

            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'parents-speed-report.php' || get_url($_SERVER['REQUEST_URI']) == 'emp-parents-settings.php' || get_url($_SERVER['REQUEST_URI']) == 'emp-parents-msgs.php' || get_url($_SERVER['REQUEST_URI']) == 'view-app-msg.php' || get_url($_SERVER['REQUEST_URI']) == 'new-parents-msgs.php' || get_url($_SERVER['REQUEST_URI']) == 'all-parents-msgs.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-commenting-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> رسائل من اولياء الامور</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access10sub1'] == 1) { ?>
                  <li><a href="new-parents-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-parents-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> رسائل جديدة </a></li>
                <?php }
                if ($row_get_login['access10sub2'] == 1) { ?>
                  <li><a href="all-parents-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-parents-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الرسائل </a></li>
                <?php }
                if ($row_get_login['access10sub3'] == 1) { ?>
                  <li><a href="emp-parents-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'emp-parents-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-sliders" aria-hidden="true"></i> صلاحيات الرد </a></li>


                  <li><a href="parents-speed-report.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'parents-speed-report.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تقرير السرعة </a></li>
                <?php } ?>




              </ul>
            </li>


            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'all-to-parents-msgs.php' || get_url($_SERVER['REQUEST_URI']) == 'view-request-msg.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-commenting-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> رسائل الي اولياء الامور</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access10sub2'] == 1) { ?>
                  <li><a href="all-to-parents-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-to-parents-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الرسائل </a></li>
                <?php } ?>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access11'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'view-app-msg.php' || get_url($_SERVER['REQUEST_URI']) == 'new-emp-msgs.php' || get_url($_SERVER['REQUEST_URI']) == 'all-emp-msgs.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-commenting-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> رسائل من الموظفين </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access11sub1'] == 1) { ?>
                  <li><a href="new-emp-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-emp-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> رسائل جديدة </a></li>
                <?php }
                if ($row_get_login['access11sub2'] == 1) { ?>
                  <li><a href="all-emp-msgs.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-emp-msgs.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الرسائل </a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access12'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new_push_emp.php' || get_url($_SERVER['REQUEST_URI']) == 'all_class_push.php' || get_url($_SERVER['REQUEST_URI']) == 'new_push.php' || get_url($_SERVER['REQUEST_URI']) == 'all_push.php' || get_url($_SERVER['REQUEST_URI']) == 'new_event.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-event.php' || get_url($_SERVER['REQUEST_URI']) == 'all_events.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                <span class="sidenav-label"> مناسبات و اشعارات </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access12sub1'] == 1) { ?>
                  <!--<li><a href="new_event.php" style="<?php //if(get_url($_SERVER['REQUEST_URI'])=='new_event.php' ){echo ' color: #f1595d';} ?>"><i class="fa fa-plus" aria-hidden="true"></i>         مناسبة جديدة </a></li>
                    <?php }
                if ($row_get_login['access12sub2'] == 1) { ?>
                    <li><a href="all_events.php" style="<?php // if(get_url($_SERVER['REQUEST_URI'])=='all_events.php' ){echo ' color: #f1595d';} ?>"><i class="fa fa-list-ul" aria-hidden="true"></i>       جميع المناسبات </a></li>  -->
                <?php }
                if ($row_get_login['access12sub1'] == 1) { ?>
                  <li><a href="new_push.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new_push.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> اشعار جديدة </a></li>
                  <li><a href="new_push_emp.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new_push_emp.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-plus" aria-hidden="true"></i> اشعار مدرسين جديدة </a></li>
                <?php }
                if ($row_get_login['access12sub2'] == 1) { ?>
                  <li><a href="all_push.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all_push.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الاشعارات </a></li>
                  <li><a href="all_class_push.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all_class_push.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع اشعارات الفصول </a></li>
                <?php } ?>

              </ul>
            </li>

          <?php }
          if ($row_get_login['access22'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new_memo.php' || get_url($_SERVER['REQUEST_URI']) == 'all-memos.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-memo.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-pencil-square" aria-hidden="true"></i></span>
                <span class="sidenav-label"> مذكرات </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="new_memo.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new_memo.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-plus" aria-hidden="true"></i> مذكرة جديدة </a></li>
                <li><a href="all-memos.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-memos.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع المذكرات </a></li>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access13'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'new-photo-album.php' || get_url($_SERVER['REQUEST_URI']) == 'all-photo-albums.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-photo-album.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> معرض الصور </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="new-photo-album.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-photo-album.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-plus" aria-hidden="true"></i> البوم جديد </a></li>
                <li><a href="all-photo-albums.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-photo-albums.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الالبوم </a></li>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access14'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'add-video.php' || get_url($_SERVER['REQUEST_URI']) == 'new-video-album.php' || get_url($_SERVER['REQUEST_URI']) == 'all-video-albums.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-video-album.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-video-camera" aria-hidden="true"></i></span>
                <span class="sidenav-label"> معرض الفيدو </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="new-video-album.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-video-album.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-plus" aria-hidden="true"></i> البوم جديد </a></li>
                <li><a href="all-video-albums.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-video-albums.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع الالبوم </a></li>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access15'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'vision.php' || get_url($_SERVER['REQUEST_URI']) == 'mission.php' || get_url($_SERVER['REQUEST_URI']) == 'aboutus.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                <span class="sidenav-label"> شاشات المعلومات </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="mission.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'mission.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> المهمة </a></li>
                <li><a href="vision.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'vision.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> الرسالة </a></li>
                <li><a href="aboutus.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'aboutus.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> معلومات عنا </a></li>
              </ul>
            </li>
          <?php }
          if ($row_get_login['access16'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'success_statement_imp.php' || get_url($_SERVER['REQUEST_URI']) == 'view_cert_turm.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_imp_term.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_imp_degree.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_imp_turm1.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_imp.php' || get_url($_SERVER['REQUEST_URI']) == 'all_cert.php' || get_url($_SERVER['REQUEST_URI']) == 'view_cert.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_settings.php' || get_url($_SERVER['REQUEST_URI']) == 'cert_imp_round2.php' || get_url($_SERVER['REQUEST_URI']) == 'view_cert_round2_print.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-certificate" aria-hidden="true"></i></span>
                <span class="sidenav-label"> النتائج </span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="cert_imp.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_imp.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تحميل نتيجة </a></li>
                <li><a href="cert_imp_degree.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_imp_degree.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تحميل الدرجة الفعلية </a></li>
                <li><a href="cert_imp_turm1.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_imp_turm1.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تحميل الدرجة ترم 1 </a></li>
                <li><a href="cert_imp_term.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_imp_term.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تحميل اعمال السنة </a></li>

                <li><a href="all_cert.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all_cert.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> عرض النتائج </a></li>

                <li><a href="cert_imp_round2.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_imp_round2.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-upload" aria-hidden="true"></i> تحميل النتائج(الدور الثاني) </a></li>

                <li><a href="success_statement_imp.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'success_statement_imp.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-id-card-o" aria-hidden="true"></i> تحميل بيان نجاح </a></li>

                <?php if ($row_get_login['id'] == 1) { ?>
                  <li><a href="cert_settings.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'cert_settings.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-cogs" aria-hidden="true"></i> اعدادات </a></li>
                <?php } ?>
              </ul>
            </li>

          <?php }
          if ($row_get_login['access17'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'acc-view-report1.php' || get_url($_SERVER['REQUEST_URI']) == 'acc-upload.php' || get_url($_SERVER['REQUEST_URI']) == 'acc-view.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-money" aria-hidden="true"></i></span>
                <span class="sidenav-label"> الحسابات</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <?php if ($row_get_login['access17sub1'] == 1) { ?>
                  <li><a href="acc-view.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'acc-view.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> تحصيلات </a></li>
                <?php }
                if ($row_get_login['access17sub2'] == 1) { ?>
                  <li><a href="acc-view-report1.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'acc-view-report1.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> استحقاقات </a></li>
                <?php }
                if ($row_get_login['access17sub4'] == 1) { ?>
                  <li><a href="acc-upload.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'acc-upload.php') {
                    echo ' color: #f1595d';
                  } ?>"><i class="fa fa-upload" aria-hidden="true"></i> تحميل </a></li>
                <?php } ?>
              </ul>
            </li>



          <?php }
          if ($row_get_login['access100'] == 1) { ?>
            <li class="sidenav-item has-subnav <?php if (get_url($_SERVER['REQUEST_URI']) == 'edit-user.php' || get_url($_SERVER['REQUEST_URI']) == 'new-user.php' || get_url($_SERVER['REQUEST_URI']) == 'all-users.php' || get_url($_SERVER['REQUEST_URI']) == 'edit-users.php') {
              echo 'active open ';
            } ?>    ">
              <a href="#" aria-haspopup="true">
                <span class="sidenav-icon icon icon-works"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                <span class="sidenav-label"> مستخدمي لوحة التحكم</span>
              </a>
              <ul class="sidenav level-2 collapse">
                <li><a href="new-user.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'new-user.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> مستخدم جديد</a></li>
                <li><a href="all-users.php" style="<?php if (get_url($_SERVER['REQUEST_URI']) == 'all-users.php') {
                  echo ' color: #f1595d';
                } ?>"><i class="fa fa-list-ul" aria-hidden="true"></i> جميع المستخدمين </a></li>
              </ul>
            </li>
          <?php } ?>


        </ul>
      </nav>
    </div>
  </div>
</div>