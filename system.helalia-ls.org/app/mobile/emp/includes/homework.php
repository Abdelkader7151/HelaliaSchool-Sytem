<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

if (!isset($showHomework) || (!$staffPreview && !$showHomework)) {
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
if (!hw_has_db()) {
    hw_preview_init();
}

if ($staffLang === 'arb') {
    $HW = array(
        'title' => 'الواجب',
        'assign' => 'رفع الواجب',
        'confirm_sec' => 'تأكيد الواجب',
        'all_classes' => 'كل الفصول',
        'classes' => 'الفصول',
        'subjects' => 'المواد',
        'previous' => 'السابق',
        'add' => 'رفع واجب',
        'title_field' => 'العنوان',
        'desc_field' => 'الوصف',
        'file_field' => 'رفع ملف',
        'upload' => 'رفع',
        'search' => 'بحث',
        'date' => 'التاريخ',
        'search_on' => 'بحث في',
        'waiting' => 'في انتظار التأكيد',
        'confirmed' => 'تم التأكيد',
        'done' => 'تم التحديث بنجاح',
        'deleted' => 'تم الحذف',
        'no_result' => 'لا توجد نتائج',
        'empty' => 'لا توجد عناصر',
        'delete' => 'حذف',
        'delete_q' => 'تأكيد حذف الواجب المرفوع؟',
        'cancel' => 'إلغاء',
        'agree' => 'موافق',
        'download' => 'تحميل',
        'open' => 'فتح',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'today' => 'واجب اليوم',
        'confirm_btn' => 'تأكيد',
        'no_access' => 'لا توجد صلاحية للواجب',
        'uploading' => 'جاري الرفع…',
        'back' => 'رجوع',
        'year_missing' => 'لم يتم تحديد السنة الدراسية',
        'year_invalid' => 'هذه السنة الدراسية غير متاحة لحسابك',
        'class_invalid' => 'هذا الفصل غير متاح لحسابك',
        'pick_classes' => 'اختر فصلًا واحدًا على الأقل',
        'select_all' => 'تحديد كل الفصول',
        'upload_selected' => 'رفع للفصول المحددة',
        'selected_classes' => 'فصول محددة',
    );
} else {
    $HW = array(
        'title' => 'Homework',
        'assign' => 'Homework',
        'confirm_sec' => 'Confirm homework',
        'all_classes' => 'All classes',
        'classes' => 'Classes',
        'subjects' => 'Subjects',
        'previous' => 'Previous',
        'add' => 'Upload homework',
        'title_field' => 'Title',
        'desc_field' => 'Description',
        'file_field' => 'Upload file',
        'upload' => 'Upload',
        'search' => 'Search',
        'date' => 'Date',
        'search_on' => 'Search on',
        'waiting' => 'Waiting for confirm',
        'confirmed' => 'Confirmed',
        'done' => 'Updated successfully',
        'deleted' => 'Deleted',
        'no_result' => 'No result',
        'empty' => 'Nothing here yet',
        'delete' => 'Delete',
        'delete_q' => 'Confirm delete uploaded homework?',
        'cancel' => 'Cancel',
        'agree' => 'Agree',
        'download' => 'Download',
        'open' => 'Open',
        'preview' => 'Local preview — nothing is saved to the database',
        'today' => 'Today',
        'confirm_btn' => 'Confirm',
        'no_access' => 'Homework is not available for this account',
        'uploading' => 'Uploading…',
        'back' => 'Back',
        'year_missing' => 'Study year was not specified',
        'year_invalid' => 'This study year is not available for your account',
        'class_invalid' => 'This class is not available for your account',
        'pick_classes' => 'Select at least one class',
        'select_all' => 'Select all classes',
        'upload_selected' => 'Upload to selected classes',
        'selected_classes' => 'Selected classes',
    );
}

function hw_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function hw_today()
{
    return strtotime(date('m/d/Y', time()));
}

function hw_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function hw_app()
{
    global $row_get_user;
    return (int) ($row_get_user['id'] ?? 0);
}

function hw_year_names()
{
    global $staffLang;
    if ($staffLang === 'arb') {
        return array(
            0 => 'بري سكول',
            1 => 'رياض أطفال 1',
            2 => 'رياض أطفال 2',
            3 => 'الابتدائي 1',
            4 => 'الابتدائي 2',
            5 => 'الابتدائي 3',
            6 => 'الابتدائي 4',
            7 => 'الابتدائي 5',
            8 => 'الابتدائي 6',
            9 => 'الاعدادي 1',
            10 => 'الاعدادي 2',
            11 => 'الاعدادي 3',
            12 => 'الثانوي 1',
            13 => 'الثانوي 2',
            14 => 'الثانوي 3',
        );
    }
    return array(
        0 => 'PreSchool',
        1 => 'KG1',
        2 => 'KG2',
        3 => 'Junior One',
        4 => 'Junior Two',
        5 => 'Junior Three',
        6 => 'Junior Four',
        7 => 'Junior Five',
        8 => 'Junior Six',
        9 => 'Middle One',
        10 => 'Middle Two',
        11 => 'Middle Three',
        12 => 'Senior One',
        13 => 'Senior Two',
        14 => 'Senior Three',
    );
}

function hw_year_name($year)
{
    $year = (int) $year;
    if (function_exists('year_of_study')) {
        $name = trim((string) year_of_study($year));
        if ($name !== '') {
            return $name;
        }
    }
    $names = hw_year_names();
    return isset($names[$year]) ? $names[$year] : ('Year ' . $year);
}

function hw_dummy_subjects()
{
    return array(
        array('subject' => 1, 'name_eng' => 'English', 'name_arb' => 'اللغة الإنجليزية'),
        array('subject' => 2, 'name_eng' => 'Math', 'name_arb' => 'الرياضيات'),
        array('subject' => 3, 'name_eng' => 'Science', 'name_arb' => 'العلوم'),
    );
}

function hw_dummy_classes($year)
{
    $year = (int) $year;
    return array(
        array('id' => 1000 + ($year * 10) + 1, 'name' => 'A', 'fn_name' => 'أ', 'study_year' => $year),
        array('id' => 1000 + ($year * 10) + 2, 'name' => 'B', 'fn_name' => 'ب', 'study_year' => $year),
    );
}

function hw_preview_init()
{
    if (isset($_SESSION['helalia_hw_preview'])) {
        return;
    }
    $today = hw_today();
    $items = array();
    $id = 1;
    for ($y = 0; $y <= 14; $y++) {
        $class = 1000 + ($y * 10) + 1;
        $items[] = array(
            'id' => $id++,
            'name_eng' => 'Worksheet ' . ($y + 1),
            'text_eng' => 'Complete the worksheet and bring it tomorrow.',
            'study_year' => $y,
            'class' => $class,
            'subject' => 1,
            'banner' => 'sample.pdf',
            'emp_id' => 0,
            'app_id' => 0,
            'confirm' => 0,
            'confirm_by' => 0,
            'admin_id' => 0,
            'start' => $today,
            'date' => $today,
        );
        $items[] = array(
            'id' => $id++,
            'name_eng' => 'Reading log',
            'text_eng' => 'Read for ten minutes tonight.',
            'study_year' => $y,
            'class' => $class,
            'subject' => 1,
            'banner' => null,
            'emp_id' => 0,
            'app_id' => 0,
            'confirm' => 1,
            'confirm_by' => 0,
            'admin_id' => 0,
            'start' => $today,
            'date' => $today,
        );
    }
    $_SESSION['helalia_hw_preview'] = array('items' => $items, 'next' => $id);
}

function hw_preview_items()
{
    hw_preview_init();
    return $_SESSION['helalia_hw_preview']['items'];
}

function hw_preview_save($items)
{
    $_SESSION['helalia_hw_preview']['items'] = $items;
}

function hw_can_assign()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return function_exists('app11_1access') && app11_1access(hw_emp()) == 1;
}

function hw_can_confirm()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return function_exists('app11_2access') && app11_2access(hw_emp()) == 1;
}

function hw_preview_years()
{
    return array(0, 1, 5, 12);
}

function hw_years()
{
    if (!hw_has_db()) {
        return hw_preview_years();
    }
    $emp = hw_emp();
    $rows = hw_fetch("SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '{$emp}' ORDER BY `study_year` ASC");
    $years = array();
    foreach ($rows as $row) {
        $years[] = (int) $row['study_year'];
    }
    return $years;
}

function hw_year_allowed($year)
{
    return in_array((int) $year, hw_years(), true);
}

function hw_teaches_year($year)
{
    return hw_year_allowed($year);
}

function hw_class_allowed($year, $classId)
{
    $classId = (int) $classId;
    foreach (hw_classes((int) $year) as $row) {
        if ((int) $row['id'] === $classId) {
            return true;
        }
    }
    return false;
}

function hw_parse_classes_param()
{
    $ids = array();
    if (isset($_GET['classes'])) {
        $raw = $_GET['classes'];
        if (is_array($raw)) {
            foreach ($raw as $part) {
                $ids[] = (int) $part;
            }
        } else {
            foreach (explode(',', (string) $raw) as $part) {
                $ids[] = (int) trim($part);
            }
        }
    }
    $ids = array_values(array_unique(array_filter($ids, function ($id) {
        return $id > 0;
    })));
    sort($ids, SORT_NUMERIC);
    return $ids;
}

function hw_validate_classes($year, $classIds)
{
    $allowed = array();
    foreach (hw_classes((int) $year) as $row) {
        $allowed[(int) $row['id']] = true;
    }
    $valid = array();
    foreach ($classIds as $id) {
        $id = (int) $id;
        if (isset($allowed[$id])) {
            $valid[] = $id;
        }
    }
    return $valid;
}

function hw_classes_query($classIds)
{
    $classIds = array_values(array_filter(array_map('intval', (array) $classIds)));
    if (!$classIds) {
        return '';
    }
    return implode(',', $classIds);
}

function hw_subjects_for_classes($year, $classIds)
{
    $year = (int) $year;
    $classIds = hw_validate_classes($year, $classIds);
    if (!$classIds) {
        return array();
    }
    if (!hw_has_db()) {
        return hw_dummy_subjects();
    }
    $emp = hw_emp();
    $in = hw_classes_query($classIds);
    return hw_fetch("SELECT DISTINCT `subject` FROM `teachers` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `class` IN ({$in})");
}

function hw_confirm_year_ok($year)
{
    global $staffPreview;
    $year = (int) $year;
    if ($staffPreview) {
        return true;
    }
    $map = array(
        0 => array('app11_2_0access', 'app11_2_6access'),
        1 => array('app11_2_1access', 'app11_2_7access'),
        2 => array('app11_2_1access', 'app11_2_7access'),
        3 => array('app11_2_2access', 'app11_2_8access'),
        4 => array('app11_2_2access', 'app11_2_8access'),
        5 => array('app11_2_2access', 'app11_2_8access'),
        6 => array('app11_2_3access', 'app11_2_9access'),
        7 => array('app11_2_3access', 'app11_2_9access'),
        8 => array('app11_2_3access', 'app11_2_9access'),
        9 => array('app11_2_4access', 'app11_2_10access'),
        10 => array('app11_2_4access', 'app11_2_10access'),
        11 => array('app11_2_4access', 'app11_2_10access'),
        12 => array('app11_2_5access', 'app11_2_11access'),
        13 => array('app11_2_5access', 'app11_2_11access'),
        14 => array('app11_2_5access', 'app11_2_11access'),
    );
    if (!isset($map[$year])) {
        return false;
    }
    foreach ($map[$year] as $fn) {
        if (function_exists($fn) && $fn(hw_emp()) == 1) {
            return true;
        }
    }
    return false;
}

function hw_fetch($sql)
{
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $q = mysqli_query($database, $sql);
    $rows = array();
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function hw_waiting_count($year)
{
    $year = (int) $year;
    if (!hw_has_db()) {
        $n = 0;
        foreach (hw_preview_items() as $row) {
            if ((int) $row['study_year'] === $year && (int) $row['confirm'] === 0) {
                $n++;
            }
        }
        return $n;
    }
    if (function_exists('homework_waitting')) {
        $html = homework_waitting($year);
        if (is_string($html) && preg_match('/>(\d+)</', $html, $m)) {
            return (int) $m[1];
        }
    }
    $rows = hw_fetch("SELECT `id` FROM `homework` WHERE `study_year` = '{$year}' AND `confirm` = 0");
    return count($rows);
}

function hw_classes($year)
{
    $year = (int) $year;
    if (!hw_has_db()) {
        return hw_dummy_classes($year);
    }
    $rows = hw_fetch("SELECT * FROM `class` WHERE `study_year` = '{$year}' ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        if (function_exists('check_class_subject') && check_class_subject(hw_emp(), $row['id']) <= 0) {
            continue;
        }
        $out[] = $row;
    }
    return $out;
}

function hw_class_label($row)
{
    if (is_array($row)) {
        if (isset($row['name']) && $row['name'] !== null && $row['name'] !== '') {
            return (string) $row['name'];
        }
        if (!empty($row['fn_name'])) {
            return (string) $row['fn_name'];
        }
        if (isset($row['id'])) {
            return hw_class_name($row['id']);
        }
        return '';
    }
    return hw_class_name($row);
}

function hw_class_name($id)
{
    $id = (int) $id;
    if (!hw_has_db()) {
        for ($y = 0; $y <= 14; $y++) {
            foreach (hw_dummy_classes($y) as $row) {
                if ((int) $row['id'] === $id) {
                    return hw_class_label($row);
                }
            }
        }
        return '';
    }
    if (function_exists('class_name')) {
        return (string) class_name($id);
    }
    return '';
}

function hw_subject_label($id)
{
    global $staffLang;
    $id = (int) $id;
    if (!hw_has_db()) {
        foreach (hw_dummy_subjects() as $row) {
            if ((int) $row['subject'] === $id) {
                return ($staffLang === 'arb') ? $row['name_arb'] : $row['name_eng'];
            }
        }
        return '';
    }
    if (function_exists('subject_name')) {
        return (string) subject_name($id);
    }
    return '';
}

function hw_subjects_for_class($year, $class)
{
    $year = (int) $year;
    $class = (int) $class;
    if (!hw_has_db()) {
        return hw_dummy_subjects();
    }
    $emp = hw_emp();
    return hw_fetch("SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}'");
}

function hw_subjects_for_year($year)
{
    $year = (int) $year;
    if (!hw_has_db()) {
        return hw_dummy_subjects();
    }
    $emp = hw_emp();
    return hw_fetch("SELECT DISTINCT `subject` FROM `teachers` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}'");
}

function hw_banner_url($banner)
{
    return staff_homework_url($banner);
}

function hw_who($row)
{
    global $staffLang;
    $emp = hw_emp();
    $admin = (int) ($row['admin_id'] ?? 0);
    if ((int) ($row['emp_id'] ?? 0) === $emp && $admin <= 0) {
        return '';
    }
    if (!hw_has_db()) {
        return ($staffLang === 'arb') ? '(معلم تجريبي)' : '(Preview teacher)';
    }
    $name = '';
    if (function_exists('emp_name')) {
        $name .= (string) emp_name($row['emp_id']);
    }
    if ($admin > 0 && function_exists('users_name')) {
        $name .= (string) users_name($admin);
    }
    $name = trim($name);
    return $name !== '' ? ('(' . $name . ')') : '';
}

function hw_filter_items($fn)
{
    $out = array();
    foreach (hw_preview_items() as $row) {
        if ($fn($row)) {
            $out[] = $row;
        }
    }
    return $out;
}

function hw_today_rows($year, $class, $subject, $all, $classIds = null)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $start = hw_today();
    $end = $start + 86400;
    $emp = hw_emp();
    $multi = is_array($classIds) && count($classIds) > 0;
    if (!hw_has_db()) {
        return hw_filter_items(function ($row) use ($year, $class, $subject, $all, $multi, $classIds, $start, $end, $emp) {
            if ((int) $row['study_year'] !== $year || (int) $row['emp_id'] !== $emp) {
                return false;
            }
            if ((int) $row['start'] < $start || (int) $row['start'] >= $end) {
                return false;
            }
            if ($all) {
                return true;
            }
            if ($multi) {
                return in_array((int) $row['class'], $classIds, true);
            }
            return (int) $row['class'] === $class && (int) $row['subject'] === $subject;
        });
    }
    if ($all) {
        return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `start` >= '{$start}' AND `start` < '{$end}'");
    }
    if ($multi) {
        $in = hw_classes_query($classIds);
        return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `class` IN ({$in}) AND `start` >= '{$start}' AND `start` < '{$end}'");
    }
    return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}' AND `subject` = '{$subject}' AND `start` >= '{$start}' AND `start` < '{$end}'");
}

function hw_prev_rows($year, $class, $subject, $dateTs)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $dateTs = (int) $dateTs;
    $emp = hw_emp();
    if (!hw_has_db()) {
        return hw_filter_items(function ($row) use ($year, $class, $subject, $dateTs, $emp) {
            return (int) $row['study_year'] === $year
                && (int) $row['class'] === $class
                && (int) $row['subject'] === $subject
                && (int) $row['emp_id'] === $emp
                && (int) $row['start'] === $dateTs;
        });
    }
    return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}' AND `subject` = '{$subject}' AND `start` = '{$dateTs}'");
}

function hw_waiting_rows($year)
{
    $year = (int) $year;
    if (!hw_has_db()) {
        return hw_filter_items(function ($row) use ($year) {
            return (int) $row['study_year'] === $year && (int) $row['confirm'] === 0;
        });
    }
    return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `confirm` = 0");
}

function hw_confirmed_today_rows($year)
{
    $year = (int) $year;
    $date = hw_today();
    if (!hw_has_db()) {
        return hw_filter_items(function ($row) use ($year, $date) {
            return (int) $row['study_year'] === $year && (int) $row['confirm'] === 1 && (int) $row['start'] === $date;
        });
    }
    return hw_fetch("SELECT * FROM `homework` WHERE `study_year` = '{$year}' AND `confirm` = 1 AND `start` = '{$date}'");
}

function hw_upload_dir()
{
    return staff_homework_dir();
}

function hw_notify($year, $class, $subject, $all)
{
    if (!hw_has_db() || !function_exists('sendMessage')) {
        return;
    }
    global $database, $database_database;
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    mysqli_select_db($database, $database_database);
    if ($all) {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids`.fn_name AS `kid_name`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.study_year = '{$year}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
        $message = 'Homework: ' . hw_subject_label($subject);
    } else {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids`.fn_name AS `kid_name`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.class = '{$class}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
        $message = 'Homework: ' . hw_subject_label($subject) . ' is uploaded';
    }
    $q = mysqli_query($database, $sql);
    if (!$q) {
        return;
    }
    while ($row = mysqli_fetch_assoc($q)) {
        if (!empty($row['phone_id']) && function_exists('sendMessage')) {
            sendMessage($row['phone_id'], 'HLS', $message);
        }
    }
}

function hw_insert_row($year, $class, $subject, $name, $text, $banner)
{
    global $database, $database_database;
    $now = time();
    $day = hw_today();
    if (!hw_has_db()) {
        $items = hw_preview_items();
        $id = (int) $_SESSION['helalia_hw_preview']['next'];
        $_SESSION['helalia_hw_preview']['next'] = $id + 1;
        $items[] = array(
            'id' => $id,
            'name_eng' => $name,
            'text_eng' => $text,
            'study_year' => (int) $year,
            'class' => (int) $class,
            'subject' => (int) $subject,
            'banner' => $banner,
            'emp_id' => hw_emp(),
            'app_id' => hw_app(),
            'confirm' => 1,
            'confirm_by' => hw_emp(),
            'admin_id' => 0,
            'start' => $day,
            'date' => $day,
        );
        hw_preview_save($items);
        return;
    }
    $insertSQL = sprintf(
        "INSERT INTO `homework` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `app_id`, `confirm`, `confirm_by`, `confirm_by_app_id`, `confirm_date`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($database, $name, 'text'),
        GetSQLValueString($database, $year, 'int'),
        GetSQLValueString($database, $class, 'int'),
        GetSQLValueString($database, $subject, 'int'),
        GetSQLValueString($database, $text, 'text'),
        GetSQLValueString($database, $day, 'int'),
        GetSQLValueString($database, $day, 'int'),
        GetSQLValueString($database, $banner, 'text'),
        GetSQLValueString($database, hw_emp(), 'int'),
        GetSQLValueString($database, hw_app(), 'int'),
        GetSQLValueString($database, 1, 'int'),
        GetSQLValueString($database, hw_emp(), 'int'),
        GetSQLValueString($database, hw_app(), 'int'),
        GetSQLValueString($database, $now, 'int')
    );
    mysqli_select_db($database, $database_database);
    mysqli_query($database, $insertSQL) or die(mysqli_error($database));
}

function hw_delete_row($id, $year, $class, $subject, $all, $classIds = null)
{
    $id = (int) $id;
    $year = (int) $year;
    if (!hw_has_db()) {
        $keep = array();
        foreach (hw_preview_items() as $row) {
            if ((int) $row['id'] === $id && (int) $row['emp_id'] === hw_emp() && (int) $row['app_id'] === hw_app()) {
                continue;
            }
            $keep[] = $row;
        }
        hw_preview_save($keep);
    } else {
        global $database, $database_database;
        $deleteSQL = sprintf(
            "DELETE FROM `homework` WHERE `id`=%s AND `emp_id`=%s AND `app_id`=%s",
            GetSQLValueString($database, $id, 'int'),
            GetSQLValueString($database, hw_emp(), 'int'),
            GetSQLValueString($database, hw_app(), 'int')
        );
        mysqli_select_db($database, $database_database);
        mysqli_query($database, $deleteSQL) or die(mysqli_error($database));
    }
    if ($all) {
        header('Location: homework-step3.php?year=' . $year . '&all&deleted');
    } elseif (is_array($classIds) && count($classIds) > 0) {
        header('Location: homework-step3.php?year=' . $year . '&classes=' . rawurlencode(hw_classes_query($classIds)) . '&deleted');
    } else {
        header('Location: homework-step3.php?year=' . $year . '&class=' . (int) $class . '&subject=' . (int) $subject . '&deleted');
    }
    exit;
}

function hw_handle_step3()
{
    $year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    $classIds = hw_validate_classes($year, hw_parse_classes_param());
    $multi = !$all && $class <= 0 && count($classIds) > 0;

    if (isset($_GET['del'])) {
        hw_delete_row((int) $_GET['del'], $year, $class, $subject, $all, $multi ? $classIds : null);
    }

    if (!isset($_POST['submit'])) {
        return;
    }

    $image_name = null;
    include __DIR__ . '/homework-up.php';

    $name = isset($_POST['name_eng']) ? (string) $_POST['name_eng'] : '';
    $text = isset($_POST['text_eng']) ? (string) $_POST['text_eng'] : '';

    if ($all) {
        $subject = isset($_POST['subject']) ? (int) $_POST['subject'] : 0;
        $classes = array();
        if (!hw_has_db()) {
            foreach (hw_dummy_classes($year) as $row) {
                $classes[] = (int) $row['id'];
            }
        } else {
            $emp = hw_emp();
            $rows = hw_fetch("SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `subject` = '{$subject}' AND `emp_id` = '{$emp}'");
            foreach ($rows as $row) {
                $classes[] = (int) $row['class'];
            }
        }
        foreach ($classes as $classId) {
            hw_insert_row($year, $classId, $subject, $name, $text, $image_name);
        }
        hw_notify($year, 0, $subject, true);
        header('Location: homework-step3.php?year=' . $year . '&all&done');
        exit;
    }

    if ($multi) {
        $subject = isset($_POST['subject']) ? (int) $_POST['subject'] : 0;
        $targets = array();
        if (!hw_has_db()) {
            $targets = $classIds;
        } else {
            $emp = hw_emp();
            $in = hw_classes_query($classIds);
            $rows = hw_fetch("SELECT `class` FROM `teachers` WHERE `study_year` = '{$year}' AND `subject` = '{$subject}' AND `emp_id` = '{$emp}' AND `class` IN ({$in})");
            foreach ($rows as $row) {
                $targets[] = (int) $row['class'];
            }
        }
        foreach ($targets as $classId) {
            hw_insert_row($year, $classId, $subject, $name, $text, $image_name);
        }
        foreach ($targets as $classId) {
            hw_notify($year, $classId, $subject, false);
        }
        header('Location: homework-step3.php?year=' . $year . '&classes=' . rawurlencode(hw_classes_query($classIds)) . '&done');
        exit;
    }

    hw_insert_row($year, $class, $subject, $name, $text, $image_name);
    hw_notify($year, $class, $subject, false);
    header('Location: homework-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject . '&done');
    exit;
}

function hw_confirm_one($id)
{
    $id = (int) $id;
    if (!hw_has_db()) {
        $items = hw_preview_items();
        $ok = 0;
        foreach ($items as &$row) {
            if ((int) $row['id'] === $id && (int) $row['confirm'] === 0) {
                $row['confirm'] = 1;
                $row['confirm_by'] = hw_emp();
                $ok = 1;
            }
        }
        unset($row);
        hw_preview_save($items);
        return $ok;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $rows = hw_fetch("SELECT * FROM `homework` WHERE `id` = '{$id}' AND `confirm` = 0");
    if (!$rows) {
        return 0;
    }
    $updateSQL = sprintf(
        "UPDATE `homework` SET `confirm`=%s, `confirm_by`=%s, `confirm_by_app_id`=%s, `confirm_date`=%s WHERE `id`=%s AND `confirm`=%s",
        GetSQLValueString($database, 1, 'int'),
        GetSQLValueString($database, hw_emp(), 'int'),
        GetSQLValueString($database, hw_app(), 'int'),
        GetSQLValueString($database, time(), 'int'),
        GetSQLValueString($database, $id, 'int'),
        GetSQLValueString($database, 0, 'int')
    );
    $result = mysqli_query($database, $updateSQL) or die(mysqli_error($database));
    return $result ? 1 : 0;
}

function hw_message_page($title, $text, $backHref)
{
    global $HW;
    staff_inner($title, $backHref, 'home');
    hw_empty($text);
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($HW['back']) . '</a>';
    staff_inner_end();
    exit;
}

function hw_need_year()
{
    global $HW;
    if (!isset($_GET['year']) || $_GET['year'] === '') {
        hw_message_page($HW['title'], $HW['year_missing'], 'homework.php');
    }
    $year = (int) $_GET['year'];
    if (!hw_year_allowed($year)) {
        hw_message_page($HW['title'], $HW['year_invalid'], 'homework.php');
    }
    return $year;
}

function hw_crumb($parts)
{
    $bits = array();
    foreach ($parts as $part) {
        $part = trim((string) $part);
        if ($part !== '') {
            $bits[] = staff_h($part);
        }
    }
    if (!$bits) {
        return;
    }
    echo '<p class="hw-sub">' . implode(' · ', $bits) . '</p>';
}

function hw_empty($text)
{
    echo '<div class="empty"><p>' . staff_h($text) . '</p></div>';
}

function hw_toast_markup()
{
    echo '<div class="hw-toast" id="hw-toast" hidden></div>';
    echo '<script>
    (function(){
      var t = document.getElementById("hw-toast");
      var timer;
      document.addEventListener("click", function(e){
        var btn = e.target.closest("[data-hw-text]");
        if (!btn || !t) return;
        e.preventDefault();
        var text = btn.getAttribute("data-hw-text") || "";
        if (!text) return;
        t.hidden = false;
        t.textContent = text;
        t.classList.add("is-on");
        clearTimeout(timer);
        timer = setTimeout(function(){ t.classList.remove("is-on"); }, 2800);
      });
      var form = document.getElementById("form_upload");
      if (form) {
        form.addEventListener("submit", function(){
          var b = form.querySelector("[type=submit]");
          if (b) b.textContent = b.getAttribute("data-wait") || "…";
        });
      }
    })();
    </script>';
}

function hw_item_row($row, $opts)
{
    global $HW;
    $all = !empty($opts['all']);
    $mode = isset($opts['mode']) ? $opts['mode'] : 'view';
    $title = (string) ($row['name_eng'] ?? '');
    if ($all) {
        $title = hw_class_name($row['class']) . ' · ' . hw_subject_label($row['subject']) . ' · ' . $title;
    }
    $text = (string) ($row['text_eng'] ?? '');
    $who = hw_who($row);
    $file = hw_banner_url($row['banner'] ?? '');
    $id = (int) $row['id'];

    echo '<div class="row row--hw t-navy" id="row' . $id . '">';
    echo '<span class="row__ico">' . staff_ico('file') . '</span>';
    echo '<div class="row__body">';
    echo '<p class="row__title"><a href="#" data-hw-text="' . staff_h($text) . '">' . staff_h($title) . '</a></p>';
    if ($who !== '') {
        echo '<p class="hw-who">' . staff_h($who) . '</p>';
    }
    echo '</div>';
    echo '<div class="hw-acts">';
    if ($file !== '') {
        echo '<a class="hw-act hw-act--quiet" href="' . staff_h($file) . '" target="_blank" rel="noopener" aria-label="' . staff_h($HW['download']) . '">' . staff_ico('download') . '</a>';
    }
    if ($mode === 'waiting') {
        echo '<button class="hw-act hw-confirm" type="button" value="' . $id . '" aria-label="' . staff_h($HW['confirm_btn']) . '">' . staff_ico('check') . '</button>';
    } elseif ($mode === 'confirmed') {
        echo '<span class="hw-act is-on" aria-hidden="true">' . staff_ico('check') . '</span>';
    } elseif ($mode === 'today' && (int) ($row['confirm'] ?? 1) === 0) {
        $delHref = isset($opts['del']) ? $opts['del'] . $id : '#';
        echo '<a class="hw-act hw-act--danger" href="' . staff_h($delHref) . '" onclick="return confirm(' . htmlspecialchars(json_encode($HW['delete_q']), ENT_QUOTES, 'UTF-8') . ')">' . staff_ico('trash') . '</a>';
    }
    echo '</div></div>';
}

function hw_page_landing()
{
    global $HW, $staffPreview;
    staff_inner($HW['title'], 'emp-view.php', 'home');
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($HW['preview']) . '</p>';
    }

    $has = false;
    if (hw_can_assign()) {
        $has = true;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['assign']) . '</h2></div>';
        echo '<div class="rows">';
        $any = false;
        foreach (hw_years() as $y) {
            $any = true;
            echo '<a class="row t-navy" href="homework-step1.php?year=' . $y . '">';
            echo '<span class="row__ico">' . staff_ico('book') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(hw_year_name($y)) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
        if (!$any) {
            hw_empty($HW['empty']);
        }
    }

    if (hw_can_confirm()) {
        $has = true;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['confirm_sec']) . '</h2></div>';
        echo '<div class="rows">';
        $any = false;
        for ($y = 0; $y <= 14; $y++) {
            if (!hw_confirm_year_ok($y)) {
                continue;
            }
            $any = true;
            $wait = hw_waiting_count($y);
            echo '<a class="row t-gold" href="homework-confirm.php?year=' . $y . '">';
            echo '<span class="row__ico">' . staff_ico('check') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(hw_year_name($y)) . '</p></div>';
            if ($wait > 0) {
                echo '<span class="row__count row__count--gold">' . (int) $wait . '</span>';
            }
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
        if (!$any) {
            hw_empty($HW['empty']);
        }
    }

    if (!$has) {
        hw_empty($HW['no_access']);
    }
    staff_inner_end();
}

function hw_page_step1()
{
    global $HW;
    $year = hw_need_year();
    staff_inner($HW['title'], 'homework.php', 'home');
    hw_crumb(array(hw_year_name($year), $HW['classes']));
    $rows = hw_classes($year);
    if (!$rows) {
        hw_empty($HW['empty']);
        echo '<a class="btn btn--primary stu-back" href="homework.php">' . staff_h($HW['back']) . '</a>';
        staff_inner_end();
        return;
    }

    $multi = count($rows) >= 2;
    if ($multi) {
        echo '<form class="hw-pick-form" action="homework-step3.php" method="get" id="hw-pick-form">';
        echo '<input type="hidden" name="year" value="' . (int) $year . '">';
        echo '<label class="hw-choice hw-pick__all"><input type="checkbox" id="hw-pick-all"> <span>' . staff_h($HW['select_all']) . '</span></label>';
        echo '<div class="hw-pick">';
        foreach ($rows as $row) {
            $id = (int) $row['id'];
            echo '<div class="row row--hw-pick t-navy">';
            echo '<label class="hw-pick__check" aria-label="' . staff_h(hw_class_label($row)) . '">';
            echo '<input type="checkbox" class="hw-pick__box" name="classes[]" value="' . $id . '">';
            echo '</label>';
            echo '<a class="row__body" href="homework-step2.php?year=' . $year . '&class=' . $id . '">';
            echo '<p class="row__title">' . staff_h(hw_class_label($row)) . '</p></a>';
            echo '<a class="row__go" href="homework-step2.php?year=' . $year . '&class=' . $id . '" aria-hidden="true">›</a>';
            echo '</div>';
        }
        echo '</div>';
        echo '<button class="btn btn--primary hw-pick__submit" type="submit">' . staff_h($HW['upload_selected']) . '</button>';
        echo '</form>';
        echo '<script>
        (function(){
          var form = document.getElementById("hw-pick-form");
          var all = document.getElementById("hw-pick-all");
          if (!form || !all) return;
          var boxes = form.querySelectorAll(".hw-pick__box");
          all.addEventListener("change", function(){
            boxes.forEach(function(box){ box.checked = all.checked; });
          });
          form.addEventListener("submit", function(e){
            var picked = form.querySelectorAll(".hw-pick__box:checked");
            if (!picked.length) {
              e.preventDefault();
              alert(' . json_encode($HW['pick_classes'], JSON_UNESCAPED_UNICODE) . ');
            }
          });
        })();
        </script>';
    } else {
        echo '<div class="rows">';
        foreach ($rows as $row) {
            $id = (int) $row['id'];
            echo '<a class="row t-navy" href="homework-step2.php?year=' . $year . '&class=' . $id . '">';
            echo '<span class="row__ico">' . staff_ico('grid') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(hw_class_label($row)) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
    }
    staff_inner_end();
}

function hw_page_step2()
{
    global $HW;
    $year = hw_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    if ($class <= 0 || !hw_class_allowed($year, $class)) {
        hw_message_page($HW['title'], $HW['class_invalid'], 'homework-step1.php?year=' . $year);
    }
    staff_inner($HW['title'], 'homework-step1.php?year=' . $year, 'home');
    hw_crumb(array(hw_year_name($year), hw_class_name($class)));
    $rows = hw_subjects_for_class($year, $class);
    if (!$rows) {
        hw_empty($HW['empty']);
        staff_inner_end();
        return;
    }
    echo '<div class="rows">';
    foreach ($rows as $row) {
        $sid = (int) $row['subject'];
        echo '<div class="row t-navy">';
        echo '<span class="row__ico">' . staff_ico('book') . '</span>';
        echo '<div class="row__body"><p class="row__title">' . staff_h(hw_subject_label($sid)) . '</p></div>';
        echo '<div class="hw-acts">';
        echo '<a class="hw-act hw-act--quiet" href="homework-prev.php?year=' . $year . '&class=' . $class . '&subject=' . $sid . '" aria-label="' . staff_h($HW['previous']) . '">' . staff_ico('search') . '</a>';
        echo '<a class="hw-act" href="homework-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $sid . '" aria-label="' . staff_h($HW['add']) . '">' . staff_ico('upload') . '</a>';
        echo '</div></div>';
    }
    echo '</div>';
    staff_inner_end();
}

function hw_page_step3()
{
    global $HW;
    hw_handle_step3();
    $year = hw_need_year();
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    $classIds = hw_validate_classes($year, hw_parse_classes_param());
    $multi = !$all && $class <= 0 && count($classIds) > 0;
    if (!$all && !$multi && ($class <= 0 || !hw_class_allowed($year, $class))) {
        hw_message_page($HW['title'], $HW['class_invalid'], 'homework-step1.php?year=' . $year);
    }

    if ($all) {
        $back = 'homework.php';
    } elseif ($multi) {
        $back = 'homework-step1.php?year=' . $year;
    } else {
        $back = 'homework-step2.php?year=' . $year . '&class=' . $class;
    }
    staff_inner($HW['add'], $back, 'home');
    if ($all) {
        hw_crumb(array(hw_year_name($year), $HW['all_classes']));
        $action = 'homework-step3.php?year=' . $year . '&all';
        $subjects = hw_subjects_for_year($year);
        $showSubjectPicker = true;
    } elseif ($multi) {
        $labels = array();
        foreach ($classIds as $cid) {
            $labels[] = hw_class_name($cid);
        }
        hw_crumb(array(hw_year_name($year), $HW['selected_classes'] . ': ' . implode(', ', $labels)));
        $action = 'homework-step3.php?year=' . $year . '&classes=' . rawurlencode(hw_classes_query($classIds));
        $subjects = hw_subjects_for_classes($year, $classIds);
        $showSubjectPicker = true;
    } else {
        hw_crumb(array(hw_year_name($year), hw_class_name($class), hw_subject_label($subject)));
        $action = 'homework-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject;
        $subjects = array(array('subject' => $subject));
        $showSubjectPicker = false;
    }

    if ($subjects) {
        echo '<form class="card hw-form" action="' . staff_h($action) . '" method="post" enctype="multipart/form-data" id="form_upload">';
        if ($showSubjectPicker) {
            echo '<div><p class="field__label">' . staff_h($HW['subjects']) . '</p><div class="hw-choices">';
            $i = 0;
            foreach ($subjects as $row) {
                $sid = (int) $row['subject'];
                $i++;
                echo '<label class="hw-choice"><input type="radio" name="subject" value="' . $sid . '"' . ($i === 1 ? ' checked' : '') . '> <span>' . staff_h(hw_subject_label($sid)) . '</span></label>';
            }
            echo '</div></div>';
        }
        echo '<label class="field"><span class="field__label">' . staff_h($HW['title_field']) . '</span>';
        echo '<input class="input" id="name_eng" name="name_eng" type="text"></label>';
        echo '<label class="field"><span class="field__label">' . staff_h($HW['desc_field']) . '</span>';
        echo '<textarea class="input" id="text_eng" name="text_eng"></textarea></label>';
        echo '<label class="hw-file"><span class="field__label">' . staff_h($HW['file_field']) . '</span>';
        echo '<input id="picture" name="picture" type="file" accept="image/*, .pdf, .docx"></label>';
        echo '<button class="btn btn--primary" name="submit" type="submit" data-wait="' . staff_h($HW['uploading']) . '">' . staff_h($HW['upload']) . '</button>';
        echo '</form>';
    } else {
        hw_empty($HW['empty']);
    }

    $rows = hw_today_rows($year, $class, $subject, $all, $multi ? $classIds : null);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['today']) . '</h2></div>';
    if (!$rows) {
        hw_empty($HW['empty']);
    } else {
        if ($all) {
            $delBase = 'homework-step3.php?year=' . $year . '&all&del=';
            $listAll = true;
        } elseif ($multi) {
            $delBase = 'homework-step3.php?year=' . $year . '&classes=' . rawurlencode(hw_classes_query($classIds)) . '&del=';
            $listAll = true;
        } else {
            $delBase = 'homework-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject . '&del=';
            $listAll = false;
        }
        echo '<div class="rows">';
        foreach ($rows as $row) {
            hw_item_row($row, array('mode' => 'today', 'all' => $listAll, 'del' => $delBase));
        }
        echo '</div>';
    }
    hw_toast_markup();
    staff_inner_end();
}

function hw_page_prev()
{
    global $HW;
    $year = hw_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    staff_inner($HW['previous'], 'homework-step2.php?year=' . $year . '&class=' . $class, 'home');
    hw_crumb(array(hw_year_name($year), hw_class_name($class), hw_subject_label($subject)));

    $dateVal = isset($_GET['date']) ? (string) $_GET['date'] : '';
    echo '<form class="card hw-form" action="homework-prev.php" method="get">';
    echo '<label class="field"><span class="field__label">' . staff_h($HW['date']) . '</span>';
    echo '<input class="input" id="date" name="date" type="date" required value="' . staff_h($dateVal) . '"></label>';
    echo '<input type="hidden" name="year" value="' . $year . '">';
    echo '<input type="hidden" name="class" value="' . $class . '">';
    echo '<input type="hidden" name="subject" value="' . $subject . '">';
    echo '<button class="btn btn--primary" name="search" type="submit">' . staff_h($HW['search']) . '</button>';
    echo '</form>';

    if (isset($_GET['search'])) {
        $dateTs = strtotime($_GET['date']);
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['search_on'] . ': ' . $_GET['date']) . '</h2></div>';
        $rows = hw_prev_rows($year, $class, $subject, $dateTs);
        if (!$rows) {
            hw_empty($HW['no_result']);
        } else {
            echo '<div class="rows">';
            foreach ($rows as $row) {
                hw_item_row($row, array('mode' => 'view'));
            }
            echo '</div>';
        }
    }
    hw_toast_markup();
    staff_inner_end();
}

function hw_confirm_item_html($row)
{
    ob_start();
    hw_item_row($row, array('mode' => 'confirmed'));
    return ob_get_clean();
}

function hw_page_confirm()
{
    global $HW;
    $year = hw_need_year();
    staff_inner($HW['confirm_sec'], 'homework.php', 'home');
    hw_crumb(array(hw_year_name($year)));

    $canAct = true;
    if (hw_has_db() && function_exists('app11_2access_confirm')) {
        $canAct = app11_2access_confirm($year, hw_emp()) == 1;
    }

    $waiting = hw_waiting_rows($year);
    if ($waiting) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['waiting']) . '</h2></div>';
        echo '<div class="rows" id="waiting">';
        foreach ($waiting as $row) {
            if ($canAct) {
                hw_item_row($row, array('mode' => 'waiting'));
            }
        }
        echo '</div>';
    }

    $confirmed = hw_confirmed_today_rows($year);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($HW['confirmed']) . '</h2></div>';
    echo '<div class="rows" id="confirmed">';
    if ($confirmed) {
        foreach ($confirmed as $row) {
            hw_item_row($row, array('mode' => 'confirmed'));
        }
    } else {
        echo '<div class="empty" id="confirmed-empty"><p>' . staff_h($HW['empty']) . '</p></div>';
    }
    echo '</div>';
    hw_toast_markup();
    echo '<script>
    (function(){
      var year = ' . (int) $year . ';
      document.querySelectorAll(".hw-confirm").forEach(function(btn){
        btn.addEventListener("click", function(){
          var id = this.value;
          this.disabled = true;
          var body = new URLSearchParams();
          body.set("id", id);
          fetch("homework-confirm-data.php", { method:"POST", headers:{"Content-Type":"application/x-www-form-urlencoded"}, body: body.toString() })
            .then(function(r){ return r.text(); })
            .then(function(txt){
              if (!(parseInt(String(txt).trim(), 10) > 0)) { btn.disabled = false; return; }
              var row = document.getElementById("row"+id);
              if (row) row.remove();
              var waitBox = document.getElementById("waiting");
              if (waitBox && !waitBox.querySelector(".row")) waitBox.remove();
              var y = new URLSearchParams();
              y.set("year", year);
              return fetch("homework-confirm-result.php", { method:"POST", headers:{"Content-Type":"application/x-www-form-urlencoded"}, body: y.toString() })
                .then(function(r){ return r.text(); })
                .then(function(html){
                  var box = document.getElementById("confirmed");
                  if (box) box.innerHTML = html;
                  if (window.staffShowSuccess && window.__staffActionMsgs) {
                    window.staffShowSuccess(window.__staffActionMsgs.confirmed);
                  }
                });
            })
            .catch(function(){ btn.disabled = false; });
        });
      });
    })();
    </script>';
    staff_inner_end();
}

function hw_page_confirm_data()
{
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if ($id <= 0) {
        return;
    }
    echo hw_confirm_one($id);
}

function hw_page_confirm_result()
{
    $year = isset($_POST['year']) ? (int) $_POST['year'] : 0;
    $rows = hw_confirmed_today_rows($year);
    if (!$rows) {
        return;
    }
    foreach ($rows as $row) {
        echo hw_confirm_item_html($row);
    }
}
