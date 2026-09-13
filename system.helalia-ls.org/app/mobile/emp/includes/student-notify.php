<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

if (!isset($showNotify) || (!$staffPreview && !$showNotify)) {
    header('Location: emp-view.php');
    exit;
}

if ($staffPreview) {
    if (!isset($row_get_user['id'])) {
        $row_get_user['id'] = 0;
    }
    if (!isset($row_get_user['emp_id'])) {
        $row_get_user['emp_id'] = 0;
    }
}

if ($staffLang === 'arb') {
    $SN = array(
        'title' => 'إشعار الطلاب',
        'lede' => 'أرسل إشعارًا لأولياء أمور الطلاب المحددين',
        'year_field' => 'السنة الدراسية',
        'class_field' => 'الفصل',
        'students' => 'الطلاب',
        'message' => 'الرسالة',
        'send' => 'إرسال',
        'sent' => 'تم إرسال الرسالة بنجاح',
        'select_all' => 'تحديد كل الطلاب',
        'pick_year' => 'اختر السنة الدراسية',
        'pick_class' => 'اختر الفصل',
        'pick_students' => 'اختر طالبًا واحدًا على الأقل',
        'empty' => 'لا توجد بيانات',
        'empty_students' => 'لا يوجد طلاب مرتبطون بهذا الفصل',
        'no_access' => 'لا توجد صلاحية لإشعارات الطلاب',
        'year_invalid' => 'هذه السنة الدراسية غير متاحة لحسابك',
        'class_invalid' => 'هذا الفصل غير متاح لحسابك',
        'message_missing' => 'اكتب نص الإشعار',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'back' => 'رجوع',
        'sending' => 'جاري الإرسال…',
    );
} else {
    $SN = array(
        'title' => 'Student notification',
        'lede' => 'Send a notification to selected parents',
        'year_field' => 'Study year',
        'class_field' => 'Class',
        'students' => 'Students',
        'message' => 'Message',
        'send' => 'Send',
        'sent' => 'Message sent successfully',
        'select_all' => 'Select all students',
        'pick_year' => 'Select study year',
        'pick_class' => 'Select class',
        'pick_students' => 'Select at least one student',
        'empty' => 'Nothing here yet',
        'empty_students' => 'No linked students in this class',
        'no_access' => 'Student notifications are not available for this account',
        'year_invalid' => 'This study year is not available for your account',
        'class_invalid' => 'This class is not available for your account',
        'message_missing' => 'Enter a notification message',
        'preview' => 'Local preview — nothing is saved to the database',
        'back' => 'Back',
        'sending' => 'Sending…',
    );
}

function sn_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function sn_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function sn_app()
{
    global $row_get_user;
    return (int) ($row_get_user['id'] ?? 0);
}

function sn_int($key, $default = 0)
{
    if (isset($_GET[$key])) {
        return (int) $_GET[$key];
    }
    if (isset($_POST[$key])) {
        return (int) $_POST[$key];
    }
    return $default;
}

function sn_year_name($year)
{
    global $staffLang;
    $year = (int) $year;
    if (function_exists('year_of_study')) {
        $name = trim((string) year_of_study($year));
        if ($name !== '') {
            return $name;
        }
    }
    $eng = array(
        0 => 'PreSchool', 1 => 'KG1', 2 => 'KG2', 3 => 'Junior One', 4 => 'Junior Two',
        5 => 'Junior Three', 6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
        12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
    );
    $arb = array(
        0 => 'بري سكول', 1 => 'رياض أطفال 1', 2 => 'رياض أطفال 2', 3 => 'الابتدائي 1',
        4 => 'الابتدائي 2', 5 => 'الابتدائي 3', 6 => 'الابتدائي 4', 7 => 'الابتدائي 5',
        8 => 'الابتدائي 6', 9 => 'الاعدادي 1', 10 => 'الاعدادي 2', 11 => 'الاعدادي 3',
        12 => 'الثانوي 1', 13 => 'الثانوي 2', 14 => 'الثانوي 3',
    );
    $map = ($staffLang === 'arb') ? $arb : $eng;
    return isset($map[$year]) ? $map[$year] : ('Year ' . $year);
}

function sn_preview_data()
{
    return array(
        'teacher_years' => array(3, 4, 9),
        'classes' => array(
            array('id' => 11, 'study_year' => 3, 'name_en' => 'Class A', 'name_ar' => 'فصل أ'),
            array('id' => 12, 'study_year' => 3, 'name_en' => 'Class B', 'name_ar' => 'فصل ب'),
            array('id' => 21, 'study_year' => 4, 'name_en' => 'Class A', 'name_ar' => 'فصل أ'),
            array('id' => 31, 'study_year' => 9, 'name_en' => 'Class C', 'name_ar' => 'فصل ج'),
        ),
        'kids' => array(
            array('id' => 101, 'class' => 11, 'name_en' => 'Youssef Hassan', 'name_ar' => 'يوسف حسن', 'parent_id' => 501),
            array('id' => 102, 'class' => 11, 'name_en' => 'Mariam Adel', 'name_ar' => 'مريم عادل', 'parent_id' => 502),
            array('id' => 103, 'class' => 11, 'name_en' => 'Omar Nabil', 'name_ar' => 'عمر نبيل', 'parent_id' => 503),
            array('id' => 104, 'class' => 21, 'name_en' => 'Lina Fathy', 'name_ar' => 'لينا فتحي', 'parent_id' => 504),
            array('id' => 105, 'class' => 31, 'name_en' => 'Karim Samir', 'name_ar' => 'كريم سمير', 'parent_id' => 505),
        ),
    );
}

function sn_class_name($id)
{
    global $staffLang, $staffPreview;
    $id = (int) $id;
    if (!$staffPreview && sn_has_db() && function_exists('class_name')) {
        $name = trim((string) class_name($id));
        if ($name !== '') {
            return $name;
        }
    }
    foreach (sn_preview_data()['classes'] as $c) {
        if ((int) $c['id'] === $id) {
            return ($staffLang === 'arb') ? $c['name_ar'] : $c['name_en'];
        }
    }
    return 'Class ' . $id;
}

function sn_fetch($sql)
{
    global $database, $database_database;
    if (!sn_has_db()) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, $sql);
    $rows = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function sn_one($sql)
{
    $rows = sn_fetch($sql);
    return $rows ? $rows[0] : null;
}

function sn_years()
{
    $emp = sn_emp();
    if (!sn_has_db()) {
        $out = array();
        foreach (sn_preview_data()['teacher_years'] as $y) {
            $out[] = array('study_year' => (int) $y);
        }
        return $out;
    }
    return sn_fetch("SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '{$emp}' ORDER BY `study_year` ASC");
}

function sn_classes($year)
{
    $emp = sn_emp();
    $year = (int) $year;
    if (!sn_has_db()) {
        $out = array();
        foreach (sn_preview_data()['classes'] as $c) {
            if ((int) $c['study_year'] === $year) {
                $out[] = array('class' => (int) $c['id']);
            }
        }
        return $out;
    }
    return sn_fetch("SELECT DISTINCT `class` FROM `teachers` WHERE `emp_id` = '{$emp}' AND `study_year` = '{$year}' ORDER BY `class` ASC");
}

function sn_year_ok($year)
{
    $year = (int) $year;
    foreach (sn_years() as $row) {
        if ((int) $row['study_year'] === $year) {
            return true;
        }
    }
    return false;
}

function sn_class_ok($year, $class)
{
    $year = (int) $year;
    $class = (int) $class;
    if ($class < 1 || !sn_year_ok($year)) {
        return false;
    }
    foreach (sn_classes($year) as $row) {
        if ((int) $row['class'] === $class) {
            return true;
        }
    }
    return false;
}

function sn_students($class)
{
    $class = (int) $class;
    if ($class < 1) {
        return array();
    }
    if (!sn_has_db()) {
        global $staffLang;
        $out = array();
        foreach (sn_preview_data()['kids'] as $k) {
            if ((int) $k['class'] !== $class) {
                continue;
            }
            $out[] = array(
                'kid_id' => (int) $k['id'],
                'kid_name' => ($staffLang === 'arb') ? $k['name_ar'] : $k['name_en'],
                'parent_id' => (int) $k['parent_id'],
                'phone_id' => null,
            );
        }
        return $out;
    }
    return sn_fetch(
        "SELECT `kids`.`id` AS `kid_id`, `kids`.`fn_name` AS `kid_name`, `kids_list`.`parent_id` AS `parent_id`, `app_login`.`phone_id` AS `phone_id`
         FROM `kids`
         RIGHT JOIN `kids_list` ON `kids`.`id` = `kids_list`.`kid_id`
         RIGHT JOIN `app_login` ON `app_login`.`id` = `kids_list`.`parent_id`
         WHERE `kids`.`class` = '{$class}' AND `kids`.`linked` = 1 AND `kids_list`.`parent_id` > 0
         ORDER BY `kids`.`fn_name` ASC"
    );
}

function sn_message_page($title, $text, $backHref)
{
    global $SN;
    staff_inner($title, $backHref, 'home');
    echo '<div class="tool-empty"><p>' . staff_h($text) . '</p></div>';
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($SN['back']) . '</a>';
    staff_inner_end();
    exit;
}

function sn_sql($value, $type = 'text')
{
    global $database;
    if (function_exists('GetSQLValueString') && isset($database)) {
        return GetSQLValueString($database, $value, $type);
    }
    if ($type === 'int') {
        return "'" . (int) $value . "'";
    }
    if (!isset($database)) {
        return "'" . addslashes((string) $value) . "'";
    }
    return "'" . mysqli_real_escape_string($database, (string) $value) . "'";
}

function sn_send($year, $class, $msg, $kidIds)
{
    global $staffPreview, $SN;
    $class = (int) $class;
    $msg = trim((string) $msg);
    $kidIds = array_values(array_unique(array_map('intval', (array) $kidIds)));
    $kidIds = array_filter($kidIds, function ($id) {
        return $id > 0;
    });
    if ($msg === '' || !$kidIds || !sn_class_ok($year, $class)) {
        return false;
    }

    $allowed = array();
    foreach (sn_students($class) as $row) {
        $allowed[(int) $row['kid_id']] = $row;
    }
    $targets = array();
    foreach ($kidIds as $kidId) {
        if (isset($allowed[$kidId])) {
            $targets[] = $allowed[$kidId];
        }
    }
    if (!$targets) {
        return false;
    }

    if (!sn_has_db()) {
        return true;
    }

    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $emp = sn_emp();
    $app = sn_app();
    mysqli_query(
        $database,
        sprintf(
            'INSERT INTO `class_announce` (`class_id`, `msg`, `date`, `emp_id`) VALUES (%s, %s, %s, %s)',
            sn_sql($class, 'int'),
            sn_sql($msg, 'text'),
            sn_sql(time(), 'int'),
            sn_sql($emp, 'int')
        )
    );

    foreach ($targets as $row) {
        $text = $row['kid_name'] . ' ' . $msg;
        mysqli_query(
            $database,
            sprintf(
                'INSERT INTO `notifications` (`user_id`, `kid_id`, `text`, `date`, `type`, `emp_id`) VALUES (%s, %s, %s, %s, %s, %s)',
                sn_sql($row['parent_id'], 'int'),
                sn_sql($row['kid_id'], 'int'),
                sn_sql($text, 'text'),
                sn_sql(time(), 'int'),
                sn_sql(6, 'int'),
                sn_sql($app, 'int')
            )
        );
        if (!empty($row['phone_id']) && function_exists('sendMessage')) {
            sendMessage($row['phone_id'], 'HLS', $text);
        } elseif (function_exists('sendMessage') && function_exists('app_msg_id')) {
            $pid = app_msg_id($row['kid_id']);
            if ($pid) {
                sendMessage($pid, 'HLS', $text);
            }
        }
    }
    return true;
}

function sn_handle_post()
{
    global $SN;
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['sn_send'])) {
        return;
    }

    $year = sn_int('year');
    $class = sn_int('class');
    $msg = isset($_POST['msg']) ? trim((string) $_POST['msg']) : '';
    $kids = isset($_POST['kids']) ? (array) $_POST['kids'] : array();

    if (!sn_year_ok($year)) {
        sn_message_page($SN['title'], $SN['year_invalid'], 'class-notify.php');
    }
    if (!sn_class_ok($year, $class)) {
        sn_message_page($SN['title'], $SN['class_invalid'], 'class-notify.php?year=' . $year);
    }
    if ($msg === '') {
        sn_message_page($SN['title'], $SN['message_missing'], 'class-notify.php?year=' . $year . '&class=' . $class);
    }
    if (!$kids) {
        sn_message_page($SN['title'], $SN['pick_students'], 'class-notify.php?year=' . $year . '&class=' . $class);
    }
    if (!sn_send($year, $class, $msg, $kids)) {
        sn_message_page($SN['title'], $SN['pick_students'], 'class-notify.php?year=' . $year . '&class=' . $class);
    }

    header('Location: class-notify.php?year=' . $year . '&class=' . $class . '&sent=1');
    exit;
}

function sn_render_filters($year, $class)
{
    global $SN;
    $years = sn_years();
    echo '<form class="card hw-form sn-filters" method="get" action="class-notify.php">';
    echo '<label class="field"><span class="field__label">' . staff_h($SN['year_field']) . '</span>';
    echo '<select class="input" name="year" onchange="this.form.submit()">';
    echo '<option value="">' . staff_h($SN['pick_year']) . '</option>';
    foreach ($years as $row) {
        $y = (int) $row['study_year'];
        echo '<option value="' . $y . '"' . ($y === $year ? ' selected' : '') . '>' . staff_h(sn_year_name($y)) . '</option>';
    }
    echo '</select></label>';

    if ($year >= 0 && sn_year_ok($year)) {
        $classes = sn_classes($year);
        echo '<label class="field"><span class="field__label">' . staff_h($SN['class_field']) . '</span>';
        echo '<select class="input" name="class" onchange="this.form.submit()">';
        echo '<option value="">' . staff_h($SN['pick_class']) . '</option>';
        foreach ($classes as $row) {
            $cid = (int) $row['class'];
            echo '<option value="' . $cid . '"' . ($cid === $class ? ' selected' : '') . '>' . staff_h(sn_class_name($cid)) . '</option>';
        }
        echo '</select></label>';
    }
    echo '</form>';
}

function sn_render_send_form($year, $class)
{
    global $SN, $staffPreview;
    $students = sn_students($class);
    if (!$students) {
        echo '<div class="tool-empty"><p>' . staff_h($SN['empty_students']) . '</p></div>';
        return;
    }

    echo '<form class="form-stack staff-form sn-send" method="post" action="class-notify.php?year=' . $year . '&class=' . $class . '" data-staff-wait>';
    echo '<input type="hidden" name="year" value="' . (int) $year . '">';
    echo '<input type="hidden" name="class" value="' . (int) $class . '">';
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($SN['students']) . '</h2></div>';
    echo '<div class="hw-choices sn-pick">';
    echo '<label class="hw-choice hw-pick__all"><input type="checkbox" id="sn-pick-all" checked> <span>' . staff_h($SN['select_all']) . '</span></label>';
    foreach ($students as $row) {
        $kidId = (int) $row['kid_id'];
        echo '<label class="hw-choice sn-pick__row">';
        echo '<input type="checkbox" class="sn-pick__box" name="kids[]" value="' . $kidId . '" checked>';
        echo '<span>' . staff_h($row['kid_name']) . '</span>';
        echo '</label>';
    }
    echo '</div>';
    echo '<label class="field"><span class="field__label">' . staff_h($SN['message']) . '</span>';
    echo '<textarea class="input" name="msg" rows="4" required></textarea></label>';
    echo '<button class="btn btn--primary" type="submit" name="sn_send" value="1" data-wait="' . staff_h($SN['sending']) . '">' . staff_h($SN['send']) . '</button>';
    echo '</form>';
    echo '<script>
    (function () {
      var all = document.getElementById("sn-pick-all");
      var boxes = document.querySelectorAll(".sn-pick__box");
      if (!all || !boxes.length) return;
      all.addEventListener("change", function () {
        boxes.forEach(function (box) { box.checked = all.checked; });
      });
      boxes.forEach(function (box) {
        box.addEventListener("change", function () {
          var on = 0;
          boxes.forEach(function (b) { if (b.checked) on++; });
          all.checked = on === boxes.length;
          all.indeterminate = on > 0 && on < boxes.length;
        });
      });
    })();
    </script>';
    if ($staffPreview) {
        echo '<p class="note">' . staff_h($SN['preview']) . '</p>';
    }
}

function sn_page()
{
    global $SN, $staffPreview;
    sn_handle_post();

    $year = isset($_GET['year']) && $_GET['year'] !== '' ? (int) $_GET['year'] : -1;
    $class = isset($_GET['class']) && $_GET['class'] !== '' ? (int) $_GET['class'] : 0;

    staff_inner($SN['title'], 'emp-view.php', 'home');

    $years = sn_years();
    if (!$years) {
        echo '<div class="tool-empty"><p>' . staff_h($SN['empty']) . '</p></div>';
        staff_inner_end();
        return;
    }

    sn_render_filters($year, $class);
    echo '<p class="lede staff-lede sn-lede">' . staff_h($SN['lede']) . '</p>';

    if ($year < 0 || !sn_year_ok($year)) {
        staff_inner_end();
        return;
    }

    if ($class < 1 || !sn_class_ok($year, $class)) {
        staff_inner_end();
        return;
    }

    sn_render_send_form($year, $class);
    staff_inner_end();
}
