<?php

function staff_ctrl_boot($needWrite = false)
{
    global $L, $showControl, $staffLang, $empId, $staffPreview;

    $extra = ($staffLang === 'arb')
        ? array(
            'c_title' => 'الكنترول',
            'c_lede' => 'درجات الامتحان حسب الصف والفصل والمادة',
            'c_empty' => 'لا توجد عناصر للعرض',
            'c_denied' => 'ليس لديك صلاحية الكنترول',
            'c_class' => 'الفصل',
            'c_subject' => 'المادة',
            'c_type' => 'نوع التقرير',
            'c_score' => 'الدرجة',
            'c_avg' => 'المتوسط',
            'c_reg' => 'السجل',
            'c_saved' => 'تم الحفظ',
            'c_invalid' => 'قيمة غير صحيحة',
            'c_locked' => 'مؤكد',
            'c_total' => 'من',
            'c_month' => 'الشهر',
            'c_open' => 'فتح',
            'c_oct' => 'أكتوبر',
            'c_nov' => 'نوفمبر',
            'c_dec' => 'ديسمبر',
            'c_jan' => 'يناير',
            'c_exam1' => 'امتحان شهر أول',
            'c_exam2' => 'امتحان شهر ثاني',
            'c_course' => 'أعمال السنة',
            'c_year_missing' => 'اختر السنة الدراسية',
            'c_year_invalid' => 'سنة دراسية غير صالحة',
            'c_class_invalid' => 'فصل غير صالح',
            'c_subject_invalid' => 'مادة غير صالحة',
            'c_month_invalid' => 'شهر غير صالح',
        )
        : array(
            'c_title' => 'Control',
            'c_lede' => 'Exam scores by grade, class and subject',
            'c_empty' => 'Nothing to show',
            'c_denied' => 'You do not have Control access',
            'c_class' => 'Class',
            'c_subject' => 'Subject',
            'c_type' => 'Report type',
            'c_score' => 'Score',
            'c_avg' => 'Average',
            'c_reg' => 'Registry',
            'c_saved' => 'Saved',
            'c_invalid' => 'Invalid value',
            'c_locked' => 'Confirmed',
            'c_total' => 'of',
            'c_month' => 'Month',
            'c_open' => 'Open',
            'c_oct' => 'October',
            'c_nov' => 'November',
            'c_dec' => 'December',
            'c_jan' => 'January',
            'c_exam1' => 'First exam',
            'c_exam2' => 'Second exam',
            'c_course' => 'Coursework',
            'c_year_missing' => 'Choose a study year',
            'c_year_invalid' => 'Invalid study year',
            'c_class_invalid' => 'Invalid class',
            'c_subject_invalid' => 'Invalid subject',
            'c_month_invalid' => 'Invalid month',
        );
    $L = array_merge($L, $extra);

    $ok = $showControl;
    if ($needWrite && !$staffPreview && function_exists('app19_1access')) {
        $ok = $ok && app19_1access($empId) == 1;
    }
    if (!$ok) {
        header('Location: emp-view.php');
        exit;
    }
}

function staff_ctrl_use_demo()
{
    global $staffPreview, $database;

    if ($staffPreview) {
        return true;
    }
    if (isset($database) && $database instanceof mysqli) {
        return false;
    }
    return !empty($_SESSION['helalia_snapshot_emp']);
}

function staff_ctrl_can_view()
{
    global $staffPreview, $empId;

    if ($staffPreview || staff_ctrl_use_demo()) {
        return true;
    }
    if (function_exists('app19_1access')) {
        return app19_1access($empId) == 1;
    }
    return false;
}

function staff_ctrl_message_page($title, $text, $backHref)
{
    global $L;
    staff_inner($title, $backHref, 'home');
    echo '<div class="tool-empty"><p>' . staff_h($text) . '</p></div>';
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($L['back']) . '</a>';
    staff_inner_end();
    exit;
}

function staff_ctrl_need_year()
{
    global $L;
    if (!isset($_GET['year']) || $_GET['year'] === '') {
        staff_ctrl_message_page($L['c_title'], $L['c_year_missing'], 'control.php');
    }
    $year = (int) $_GET['year'];
    if ($year < 0 || $year > 14) {
        staff_ctrl_message_page($L['c_title'], $L['c_year_invalid'], 'control.php');
    }
    if (!in_array($year, staff_ctrl_teacher_years(), true)) {
        staff_ctrl_message_page($L['c_title'], $L['c_year_invalid'], 'control.php');
    }
    return $year;
}

function staff_ctrl_need_class($year)
{
    global $L;
    $class = staff_ctrl_int('class');
    if ($class < 1) {
        staff_ctrl_message_page($L['c_class'], $L['c_class_invalid'], 'control.php?year=' . (int) $year);
    }
    $allowed = staff_ctrl_classes($year);
    foreach ($allowed as $row) {
        if ((int) $row['id'] === $class) {
            return $class;
        }
    }
    staff_ctrl_message_page($L['c_class'], $L['c_class_invalid'], 'control.php?year=' . (int) $year);
}

function staff_ctrl_need_subject($year, $class)
{
    global $L;
    $subject = staff_ctrl_int('subject');
    if ($subject < 1) {
        staff_ctrl_message_page($L['c_subject'], $L['c_subject_invalid'], 'control-type.php?' . staff_ctrl_qs(array('class' => $class)));
    }
    $allowed = staff_ctrl_subjects($year, $class);
    foreach ($allowed as $row) {
        if ((int) $row['id'] === $subject) {
            return $subject;
        }
    }
    staff_ctrl_message_page($L['c_subject'], $L['c_subject_invalid'], 'control-type.php?' . staff_ctrl_qs(array('class' => $class)));
}

function staff_ctrl_need_month()
{
    global $L;
    $month = staff_ctrl_int('month');
    if (!in_array($month, staff_ctrl_types(), true)) {
        staff_ctrl_message_page($L['c_month'], $L['c_month_invalid'], 'control-month.php?' . staff_ctrl_qs());
    }
    return $month;
}

function staff_ctrl_int($key, $default = 0)
{
    if (isset($_GET[$key])) {
        return (int) $_GET[$key];
    }
    if (isset($_POST[$key])) {
        return (int) $_POST[$key];
    }
    return $default;
}

function staff_ctrl_can_write()
{
    global $empId, $showControl;
    if (staff_ctrl_use_demo()) {
        return true;
    }
    if (function_exists('app19_1access')) {
        return app19_1access($empId) == 1;
    }
    return (bool) $showControl;
}

function staff_ctrl_year_name($id)
{
    if (function_exists('year_of_study')) {
        return trim((string) year_of_study($id));
    }
    global $staffLang;
    $eng = array(
        0 => 'Preschool', 1 => 'KG1', 2 => 'KG2', 3 => 'Junior One', 4 => 'Junior Two',
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
    return isset($map[(int) $id]) ? $map[(int) $id] : '';
}

function staff_ctrl_class_name($id)
{
    if (function_exists('class_name')) {
        return trim((string) class_name($id));
    }
    $map = array(1 => 'A', 2 => 'B');
    if (isset($map[(int) $id])) {
        return $map[(int) $id];
    }
    return $id ? ('Class ' . $id) : '';
}

function staff_ctrl_subject_name($id)
{
    if (function_exists('subject_name')) {
        return trim((string) subject_name($id));
    }
    $map = array(1 => 'English', 2 => 'Mathematics', 3 => 'Science');
    return isset($map[(int) $id]) ? $map[(int) $id] : ('#' . $id);
}

function staff_ctrl_month_label($id)
{
    global $L;
    $map = array(
        10 => $L['c_oct'],
        11 => $L['c_nov'],
        12 => $L['c_dec'],
        1 => $L['c_jan'],
        3 => $L['c_exam1'],
        4 => $L['c_exam2'],
        5 => $L['c_course'],
    );
    if (isset($map[(int) $id])) {
        return $map[(int) $id];
    }
    if (function_exists('month_name')) {
        return trim((string) month_name($id));
    }
    return (string) $id;
}

function staff_ctrl_qs($extra = array())
{
    $keys = array('year', 'class', 'subject', 'month', 'kid_id');
    $out = array();
    foreach ($keys as $key) {
        if (array_key_exists($key, $extra)) {
            if ($extra[$key] === null) {
                continue;
            }
            $out[$key] = (int) $extra[$key];
        } elseif (isset($_GET[$key]) && $_GET[$key] !== '') {
            $out[$key] = (int) $_GET[$key];
        }
    }
    return http_build_query($out);
}

function staff_ctrl_crumb()
{
    global $L;
    $parts = array();
    if (isset($_GET['year'])) {
        $parts[] = staff_ctrl_year_name($_GET['year']);
    }
    if (!empty($_GET['class'])) {
        $parts[] = staff_ctrl_class_name($_GET['class']);
    }
    if (!empty($_GET['subject'])) {
        $parts[] = staff_ctrl_subject_name($_GET['subject']);
    }
    if (isset($_GET['month']) && $_GET['month'] !== '') {
        $parts[] = staff_ctrl_month_label($_GET['month']);
    }
    if (!$parts) {
        echo '<p class="lede staff-lede">' . staff_h($L['c_lede']) . '</p>';
        return;
    }
    echo '<p class="lede staff-lede">' . staff_h(implode(' · ', $parts)) . '</p>';
}

function staff_ctrl_pick($href, $icon, $label)
{
    global $staffLang;
    $go = ($staffLang === 'arb') ? '‹' : '›';
    echo '<a class="settings__item pick" href="' . staff_h($href) . '">';
    echo '<span class="pick__ico">' . staff_ico($icon) . '</span>';
    echo '<span>' . staff_h($label) . '</span>';
    echo '<span class="settings__go">' . $go . '</span>';
    echo '</a>';
}

function staff_ctrl_teacher1($emp, $year)
{
    global $database;
    if (function_exists('teacher1')) {
        return (int) teacher1($emp, $year);
    }
    if (!isset($database)) {
        return 0;
    }
    $emp = (int) $emp;
    $year = (int) $year;
    $res = mysqli_query($database, "SELECT `id` FROM `teachers` WHERE `emp_id`='{$emp}' AND `study_year`='{$year}'");
    return $res ? (int) mysqli_num_rows($res) : 0;
}

function staff_ctrl_teacher2($emp, $year, $class)
{
    global $database;
    if (function_exists('teacher2')) {
        return (int) teacher2($emp, $year, $class);
    }
    if (!isset($database)) {
        return 0;
    }
    $emp = (int) $emp;
    $year = (int) $year;
    $class = (int) $class;
    $res = mysqli_query($database, "SELECT `id` FROM `teachers` WHERE `emp_id`='{$emp}' AND `study_year`='{$year}' AND `class`='{$class}'");
    return $res ? (int) mysqli_num_rows($res) : 0;
}

function staff_ctrl_teacher_years()
{
    global $empId, $staffPreview, $database, $database_database;

    if ($staffPreview) {
        return array(0, 1, 5, 12);
    }

    if (isset($database) && $database instanceof mysqli) {
        $eid = (int) $empId;
        mysqli_select_db($database, $database_database);
        $res = mysqli_query($database, "SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id`='{$eid}' ORDER BY `study_year` ASC");
        $years = array();
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $years[] = (int) $row['study_year'];
            }
        }
        return $years;
    }

    $years = array();
    for ($y = 0; $y <= 14; $y++) {
        if (staff_ctrl_teacher1($empId, $y) > 0) {
            $years[] = $y;
        }
    }
    return $years;
}

function staff_ctrl_years()
{
    $out = array();
    foreach (staff_ctrl_teacher_years() as $y) {
        $out[] = array('id' => (int) $y, 'name' => staff_ctrl_year_name($y));
    }
    return $out;
}

function staff_ctrl_classes($year)
{
    global $database, $database_database, $empId;
    $year = (int) $year;
    if (staff_ctrl_use_demo()) {
        return array(
            array('id' => 1, 'name' => 'A'),
            array('id' => 2, 'name' => 'B'),
        );
    }
    if (!isset($database)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `class` WHERE `study_year` = '{$year}' ORDER BY `name` ASC");
    $out = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            if (staff_ctrl_teacher2($empId, $year, $row['id']) > 0) {
                $name = ($row['name'] === null || $row['name'] === '') ? $row['fn_name'] : $row['name'];
                $out[] = array('id' => (int) $row['id'], 'name' => $name);
            }
        }
    }
    return $out;
}

function staff_ctrl_subjects($year, $class)
{
    global $database, $database_database, $empId;
    $year = (int) $year;
    $class = (int) $class;
    if (staff_ctrl_use_demo()) {
        return array(
            array('id' => 1, 'name' => 'English', 'score' => 50, 'month_score' => 50),
            array('id' => 2, 'name' => 'Mathematics', 'score' => 50, 'month_score' => 50),
        );
    }
    if (!isset($database)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $emp = (int) $empId;
    $res = mysqli_query($database, "SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}'");
    $out = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $out[] = array(
                'id' => (int) $row['subject'],
                'name' => staff_ctrl_subject_name($row['subject']),
            );
        }
    }
    return $out;
}

function staff_ctrl_types()
{
    return array(10, 11, 12, 1, 3, 4, 5);
}

function staff_ctrl_subject_row($subjectId)
{
    global $database, $database_database;
    $subjectId = (int) $subjectId;
    if (staff_ctrl_use_demo()) {
        return array('id' => $subjectId, 'order' => 1, 'name' => staff_ctrl_subject_name($subjectId), 'score' => 50, 'month_score' => 50);
    }
    if (!isset($database)) {
        return array('id' => $subjectId, 'order' => 0, 'name' => '', 'score' => 0, 'month_score' => 0);
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `subjects` WHERE `id`= '{$subjectId}'");
    $row = $res ? mysqli_fetch_assoc($res) : null;
    return $row ? $row : array('id' => $subjectId, 'order' => 0, 'name' => '', 'score' => 0, 'month_score' => 0);
}

function staff_ctrl_seed_rows($year, $class, $subject, $month)
{
    global $staffPreview, $database, $database_database, $row_get_user;

    if (staff_ctrl_use_demo() || !staff_ctrl_can_write() || !isset($database)) {
        return true;
    }

    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $month = (int) $month;
    $classSql = $class > 0 ? " AND `class` = '{$class}' " : '';

    mysqli_select_db($database, $database_database);
    $kids = mysqli_query($database, "SELECT * FROM `kids` WHERE `study_year`= '{$year}' {$classSql}");
    if (!$kids || mysqli_num_rows($kids) < 1) {
        return true;
    }
    $sub = staff_ctrl_subject_row($subject);
    $adminId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;

    while ($kid = mysqli_fetch_assoc($kids)) {
        $kidId = (int) $kid['id'];
        $kClass = (int) $kid['class'];
        $exists = mysqli_query($database, "SELECT `id` FROM `control` WHERE `kid_id` = '{$kidId}' AND `study_year`= '{$year}' AND `class`= '{$kClass}' AND `subject_id` = '{$subject}' AND `month` = '{$month}'");
        if ($exists && mysqli_num_rows($exists) > 0) {
            continue;
        }
        if (function_exists('GetSQLValueString')) {
            $sql = sprintf(
                "INSERT INTO `control` (`order`, `kid_id`, `seat_id`, `name`, `arb_name`, `gender`, `study_year`, `class`, `subject_id`, `subject_name`, `admin_id`, `date`, `month`, `ex_total`, `month_total`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($database, $sub['order'], 'int'),
                GetSQLValueString($database, $kid['id'], 'int'),
                GetSQLValueString($database, $kid['ed_id'], 'int'),
                GetSQLValueString($database, $kid['fn_name'], 'text'),
                GetSQLValueString($database, $kid['name'], 'text'),
                GetSQLValueString($database, $kid['gender'], 'text'),
                GetSQLValueString($database, $kid['study_year'], 'int'),
                GetSQLValueString($database, $kid['class'], 'int'),
                GetSQLValueString($database, $sub['id'], 'int'),
                GetSQLValueString($database, $sub['name'], 'text'),
                GetSQLValueString($database, $adminId, 'int'),
                GetSQLValueString($database, time(), 'int'),
                GetSQLValueString($database, $month, 'int'),
                GetSQLValueString($database, $sub['score'], 'double'),
                GetSQLValueString($database, $sub['month_score'], 'double')
            );
            mysqli_query($database, $sql);
        }
    }
    return true;
}

function staff_ctrl_guard_view($title, $backHref = 'control.php')
{
    global $L;
    if (!staff_ctrl_can_view()) {
        staff_ctrl_message_page($title, $L['c_denied'], $backHref);
    }
}

function staff_ctrl_handle_activate()
{
    if (!isset($_GET['active'])) {
        return;
    }
    staff_ctrl_guard_view($GLOBALS['L']['c_type'], 'control.php');
    $year = staff_ctrl_need_year();
    $class = staff_ctrl_need_class($year);
    $subject = staff_ctrl_need_subject($year, $class);
    $month = staff_ctrl_need_month();
    staff_ctrl_seed_rows($year, $class, $subject, $month);
    header('Location: control-scores.php?' . staff_ctrl_qs(array('year' => $year, 'class' => $class, 'subject' => $subject, 'month' => $month)));
    exit;
}

function staff_ctrl_dummy_scores($year, $class, $subject, $month)
{
    global $staffLang;
    $ar = ($staffLang === 'arb');
    $rows = array(
        array('id' => 501, 'kid_id' => 11, 'name' => $ar ? 'سارة أحمد' : 'Sara Ahmed', 'ex_result' => 42, 'confirm' => 0),
        array('id' => 502, 'kid_id' => 12, 'name' => $ar ? 'يوسف محمد' : 'Youssef Mohamed', 'ex_result' => 38, 'confirm' => 0),
        array('id' => 503, 'kid_id' => 13, 'name' => $ar ? 'ليان كريم' : 'Layan Karim', 'ex_result' => '', 'confirm' => 0),
    );
    if (!isset($_SESSION['staff_c_preview'])) {
        $_SESSION['staff_c_preview'] = array();
    }
    foreach ($rows as &$row) {
        if (isset($_SESSION['staff_c_preview'][$row['id']])) {
            $row['ex_result'] = $_SESSION['staff_c_preview'][$row['id']];
        }
    }
    unset($row);
    return $rows;
}

function staff_ctrl_scores($year, $class, $subject, $month)
{
    global $staffPreview, $database, $database_database;
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $month = (int) $month;
    if (staff_ctrl_use_demo()) {
        return staff_ctrl_dummy_scores($year, $class, $subject, $month);
    }
    if (!isset($database)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `control` WHERE `study_year` = '{$year}' AND `class`= '{$class}' AND `subject_id` ='{$subject}' AND `month` ='{$month}' ORDER BY `gender` DESC, `arb_name` ASC");
    $out = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $out[] = $row;
        }
    }
    return $out;
}

function staff_ctrl_save_ex()
{
    global $staffPreview, $database, $database_database, $empId, $row_get_user;

    if (!staff_ctrl_can_write()) {
        return false;
    }
    if (!isset($_POST['id'], $_POST['ex_result'], $_POST['ex_total'])) {
        return false;
    }
    $id = (int) $_POST['id'];
    $result = $_POST['ex_result'];
    $total = $_POST['ex_total'];
    if ($result === '' || !is_numeric($result) || !is_numeric($total) || (float) $total < (float) $result) {
        return false;
    }

    if (staff_ctrl_use_demo()) {
        if (!isset($_SESSION['staff_c_preview'])) {
            $_SESSION['staff_c_preview'] = array();
        }
        $_SESSION['staff_c_preview'][$id] = $result;
        return true;
    }

    if (!isset($database)) {
        return false;
    }
    mysqli_select_db($database, $database_database);
    $sql = sprintf(
        "UPDATE `control` SET `ex_result`=%s, `emp_id`=%s, `app_id`=%s, `date`=%s WHERE `id`=%s AND `confirm` =%s",
        GetSQLValueString($database, $result, 'double'),
        GetSQLValueString($database, $empId, 'int'),
        GetSQLValueString($database, $row_get_user['id'], 'int'),
        GetSQLValueString($database, time(), 'double'),
        GetSQLValueString($database, $id, 'int'),
        GetSQLValueString($database, 0, 'int')
    );
    mysqli_query($database, $sql);
    return true;
}

function staff_ctrl_avg_month($month)
{
    $month = (int) $month;
    if ($month === 10 || $month === 11 || $month === 12) {
        return 12;
    }
    return 3;
}

function staff_ctrl_kid($year, $class, $kidId)
{
    global $staffPreview, $database, $database_database, $staffLang;
    $year = (int) $year;
    $class = (int) $class;
    $kidId = (int) $kidId;
    if (staff_ctrl_use_demo()) {
        foreach (staff_ctrl_dummy_scores($year, $class, staff_ctrl_int('subject'), staff_ctrl_int('month')) as $row) {
            if ((int) $row['kid_id'] === $kidId) {
                return array('id' => $kidId, 'fn_name' => $row['name'], 'name' => $row['name'], 'ed_id' => 1000 + $kidId, 'gender' => '1');
            }
        }
        $fallback = ($staffLang === 'arb') ? 'طالب' : 'Student';
        return array('id' => $kidId, 'fn_name' => $fallback, 'name' => $fallback, 'ed_id' => 0, 'gender' => '1');
    }
    if (!isset($database)) {
        return null;
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `kids` WHERE `study_year` = '{$year}' AND `class`= '{$class}' AND `id` ='{$kidId}'");
    return $res ? mysqli_fetch_assoc($res) : null;
}

function staff_ctrl_dummy_cols($avg = true)
{
    global $staffLang;
    $ar = ($staffLang === 'arb');
    return array(
        1 => array('label' => $ar ? 'واجب' : 'Homework', 'total' => 10, 'value' => 8),
        2 => array('label' => $ar ? 'اختبار' : 'Quiz', 'total' => 10, 'value' => 9),
        3 => array('label' => $ar ? 'مشاركة' : 'Participation', 'total' => 10, 'value' => ''),
    );
}

function staff_ctrl_ensure_registry($table, $year, $kidId, $subject, $month, $kid)
{
    global $staffPreview, $database, $database_database, $row_get_user, $empId;
    if (staff_ctrl_use_demo()) {
        return array('id' => 900 + $kidId, 'confirm' => 0);
    }
    if (!isset($database) || !$kid) {
        return null;
    }
    $year = (int) $year;
    $kidId = (int) $kidId;
    $subject = (int) $subject;
    $month = (int) $month;
    $calYear = (int) date('Y');
    mysqli_select_db($database, $database_database);
    $sql = "SELECT * FROM `{$table}` WHERE `study_year`= '{$year}' AND `kid_id` = '{$kidId}' AND `subject_id` = '{$subject}' AND `month` = '{$month}' AND `year` = '{$calYear}' LIMIT 1";
    $res = mysqli_query($database, $sql);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if ($row) {
        return $row;
    }
    if ($table === 'control_registry_avg' && function_exists('GetSQLValueString')) {
        $insert = sprintf(
            "INSERT INTO `control_registry_avg` (`study_year`, `kid_id`, `subject_id`, `month`, `year`, `ed_id`, `name`, `arb_name`, `gender`, `app_id`, `emp_id`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($database, $year, 'int'),
            GetSQLValueString($database, $kidId, 'int'),
            GetSQLValueString($database, $subject, 'int'),
            GetSQLValueString($database, $month, 'int'),
            GetSQLValueString($database, $calYear, 'int'),
            GetSQLValueString($database, $kid['ed_id'], 'int'),
            GetSQLValueString($database, $kid['fn_name'], 'text'),
            GetSQLValueString($database, $kid['name'], 'text'),
            GetSQLValueString($database, $kid['gender'], 'text'),
            GetSQLValueString($database, $row_get_user['id'], 'int'),
            GetSQLValueString($database, $empId, 'int')
        );
        mysqli_query($database, $insert);
    } else {
        $fn = mysqli_real_escape_string($database, (string) $kid['fn_name']);
        $nm = mysqli_real_escape_string($database, (string) $kid['name']);
        $gd = mysqli_real_escape_string($database, (string) $kid['gender']);
        $insert = "INSERT INTO `{$table}` (`study_year`, `kid_id`, `subject_id`, `month`, `year`, `ed_id`, `name`, `arb_name`, `gender`, `app_id`, `emp_id`) VALUES ('{$year}', '{$kidId}', '{$subject}', '{$month}', '{$calYear}', '" . (int) $kid['ed_id'] . "', '{$fn}', '{$nm}', '{$gd}', '" . (int) $row_get_user['id'] . "', '" . (int) $empId . "')";
        mysqli_query($database, $insert);
    }
    $res = mysqli_query($database, $sql);
    return $res ? mysqli_fetch_assoc($res) : null;
}

function staff_ctrl_title_cols($table, $year)
{
    global $staffPreview, $database, $database_database;
    $year = (int) $year;
    if (staff_ctrl_use_demo()) {
        return null;
    }
    if (!isset($database)) {
        return null;
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `{$table}` WHERE `study_year`= '{$year}'");
    return $res ? mysqli_fetch_assoc($res) : null;
}

function staff_ctrl_cols($titleTable, $regTable, $year, $class, $subject, $month, $kidId, $avg = false)
{
    $kid = staff_ctrl_kid($year, $class, $kidId);
    $storeMonth = $avg ? staff_ctrl_avg_month($month) : (int) $month;
    $reg = staff_ctrl_ensure_registry($regTable, $year, $kidId, $subject, $storeMonth, $kid);
    $title = staff_ctrl_title_cols($titleTable, $year);
    $cols = array();
    if ($title) {
        for ($i = 1; $i < 16; $i++) {
            if (!empty($title['col' . $i . '_total']) && $title['col' . $i . '_total'] > 0) {
                $cols[] = array(
                    'i' => $i,
                    'label' => $title['col' . $i],
                    'total' => $title['col' . $i . '_total'],
                    'value' => isset($reg['col' . $i]) ? $reg['col' . $i] : '',
                );
            }
        }
    } else {
        foreach (staff_ctrl_dummy_cols($avg) as $i => $col) {
            $val = $col['value'];
            $sessKey = ($avg ? 'avg' : 'reg') . '-' . (int) $reg['id'] . '-' . $i;
            if (isset($_SESSION['staff_c_cols'][$sessKey])) {
                $val = $_SESSION['staff_c_cols'][$sessKey];
            }
            $cols[] = array('i' => $i, 'label' => $col['label'], 'total' => $col['total'], 'value' => $val);
        }
    }
    return array(
        'kid' => $kid,
        'reg' => $reg ? $reg : array('id' => 0, 'confirm' => 0),
        'cols' => $cols,
    );
}

function staff_ctrl_save_col($table)
{
    global $staffPreview, $database, $database_database, $empId, $row_get_user;

    if (!staff_ctrl_can_write()) {
        return false;
    }
    if (!isset($_POST['id'], $_POST['reg_result'], $_POST['reg_total'], $_POST['row'])) {
        return false;
    }
    $col = (int) $_POST['id'];
    if ($col < 1 || $col > 15) {
        return false;
    }
    $result = $_POST['reg_result'];
    $total = $_POST['reg_total'];
    $rowId = (int) $_POST['row'];
    if ($result === '' || !is_numeric($result) || !is_numeric($total) || (float) $total < (float) $result) {
        return false;
    }

    if (staff_ctrl_use_demo()) {
        if (!isset($_SESSION['staff_c_cols'])) {
            $_SESSION['staff_c_cols'] = array();
        }
        $kind = ($table === 'control_registry_avg') ? 'avg' : 'reg';
        $_SESSION['staff_c_cols'][$kind . '-' . $rowId . '-' . $col] = $result;
        return true;
    }

    if (!isset($database) || !function_exists('GetSQLValueString')) {
        return false;
    }
    mysqli_select_db($database, $database_database);
    $sql = sprintf(
        "UPDATE `{$table}` SET `col{$col}`=%s, `emp_id`=%s, `app_id`=%s, `date`=%s WHERE `id`=%s AND `confirm` =%s",
        GetSQLValueString($database, $result, 'double'),
        GetSQLValueString($database, $empId, 'int'),
        GetSQLValueString($database, $row_get_user['id'], 'int'),
        GetSQLValueString($database, time(), 'double'),
        GetSQLValueString($database, $rowId, 'int'),
        GetSQLValueString($database, 0, 'int')
    );
    mysqli_query($database, $sql);
    return true;
}

function staff_ctrl_render_years()
{
    global $L;
    staff_ctrl_crumb();
    if (!staff_ctrl_can_view()) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }
    $rows = staff_ctrl_years();
    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }
    echo '<div class="settings">';
    foreach ($rows as $row) {
        staff_ctrl_pick('control-class.php?year=' . (int) $row['id'], 'people', $row['name']);
    }
    echo '</div>';
}

function staff_ctrl_render_classes($year = null)
{
    global $L;
    if ($year === null) {
        $year = staff_ctrl_int('year');
    }
    staff_ctrl_crumb();
    $rows = staff_ctrl_classes($year);
    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }
    echo '<div class="settings">';
    foreach ($rows as $row) {
        staff_ctrl_pick('control-type.php?' . staff_ctrl_qs(array('class' => $row['id'])), 'grid', $row['name']);
    }
    echo '</div>';
}

function staff_ctrl_render_types($year = null, $class = null)
{
    global $L;
    if ($year === null) {
        $year = staff_ctrl_int('year');
    }
    if ($class === null) {
        $class = staff_ctrl_int('class');
    }
    staff_ctrl_crumb();
    $rows = staff_ctrl_subjects($year, $class);
    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }
    echo '<div class="settings">';
    foreach ($rows as $row) {
        staff_ctrl_pick('control-month.php?' . staff_ctrl_qs(array('subject' => $row['id'])), 'book', $row['name']);
    }
    echo '</div>';
}

function staff_ctrl_render_months()
{
    global $L;
    staff_ctrl_crumb();
    echo '<div class="settings">';
    foreach (staff_ctrl_types() as $month) {
        $href = 'control-month.php?' . staff_ctrl_qs(array('month' => $month)) . '&active=1';
        staff_ctrl_pick($href, 'calendar', staff_ctrl_month_label($month));
    }
    echo '</div>';
}

function staff_ctrl_render_scores()
{
    global $L;
    $year = staff_ctrl_int('year');
    $class = staff_ctrl_int('class');
    $subject = staff_ctrl_int('subject');
    $month = staff_ctrl_int('month');
    $sub = staff_ctrl_subject_row($subject);
    $total = isset($sub['score']) ? $sub['score'] : 50;
    $showAvg = ($year > 2 && ($month == 12 || $month == 5));
    $rows = staff_ctrl_scores($year, $class, $subject, $month);

    staff_ctrl_crumb();
    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }

    echo '<div class="scorelist" data-score-url="get_update_ex_result.php">';
    $i = 1;
    foreach ($rows as $row) {
        $locked = !empty($row['confirm']);
        echo '<article class="scorecard card">';
        echo '<header class="scorecard__top"><span>' . $i . '. ' . staff_h($row['name']) . '</span>';
        if ($locked) {
            echo '<span class="chip">' . staff_h($L['c_locked']) . '</span>';
        }
        echo '</header>';
        echo '<label class="field"><span class="field__label">' . staff_h($L['c_score']) . ' ' . staff_h($L['c_total']) . ' ' . staff_h($total) . '</span>';
        echo '<input class="input scorecard__input" type="number" step="0.1" inputmode="decimal" value="' . staff_h($row['ex_result']) . '"';
        echo ' data-id="' . (int) $row['id'] . '" data-total="' . staff_h($total) . '"';
        if ($locked) {
            echo ' readonly';
        }
        echo '></label>';
        if ($showAvg) {
            $avgHref = 'control-avg.php?' . staff_ctrl_qs(array('kid_id' => $row['kid_id']));
            $regHref = 'control-reg.php?' . staff_ctrl_qs(array('kid_id' => $row['kid_id']));
            echo '<div class="tool-btns">';
            echo '<a class="btn btn--quiet" href="' . staff_h($avgHref) . '">' . staff_h($L['c_avg']) . '</a>';
            echo '<a class="btn btn--quiet" href="' . staff_h($regHref) . '">' . staff_h($L['c_reg']) . '</a>';
            echo '</div>';
        }
        echo '</article>';
        $i++;
    }
    echo '</div>';
    echo '<div class="staff-spin" id="staff-spin" hidden></div>';
}

function staff_ctrl_render_avg()
{
    staff_ctrl_render_registry(true);
}

function staff_ctrl_render_reg()
{
    staff_ctrl_render_registry(false);
}

function staff_ctrl_render_registry($avg)
{
    global $L;
    $year = staff_ctrl_int('year');
    $class = staff_ctrl_int('class');
    $subject = staff_ctrl_int('subject');
    $month = staff_ctrl_int('month');
    $kidId = staff_ctrl_int('kid_id');
    $titleTable = $avg ? 'control_registry_avg_title' : 'control_registry_title';
    $regTable = $avg ? 'control_registry_avg' : 'control_registry';
    $endpoint = $avg ? 'get_update_avg_result.php' : 'get_update_reg_result.php';
    $data = staff_ctrl_cols($titleTable, $regTable, $year, $class, $subject, $month, $kidId, $avg);
    $kid = $data['kid'];
    $reg = $data['reg'];
    $locked = !empty($reg['confirm']);

    staff_ctrl_crumb();
    if ($kid) {
        echo '<h2 class="sec__title staff-kid">' . staff_h($kid['fn_name']) . '</h2>';
    }
    if (!$data['cols']) {
        echo '<div class="tool-empty"><p>' . staff_h($L['c_empty']) . '</p></div>';
        return;
    }
    echo '<div class="scorelist" data-score-url="' . staff_h($endpoint) . '" data-row="' . (int) $reg['id'] . '">';
    foreach ($data['cols'] as $col) {
        echo '<article class="scorecard card">';
        echo '<label class="field"><span class="field__label">' . staff_h($col['label']) . ' (' . staff_h($col['total']) . ')</span>';
        echo '<input class="input scorecard__input" type="number" step="0.1" inputmode="decimal" value="' . staff_h($col['value']) . '"';
        echo ' data-id="' . (int) $col['i'] . '" data-total="' . staff_h($col['total']) . '"';
        if ($locked) {
            echo ' readonly';
        }
        echo '></label></article>';
    }
    echo '</div>';
    echo '<div class="staff-spin" id="staff-spin" hidden></div>';
}
