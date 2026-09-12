<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

if (!isset($showRevision) || (!$staffPreview && !$showRevision)) {
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
if (!rev_has_db()) {
    rev_preview_init();
}

if ($staffLang === 'arb') {
    $RV = array(
        'title' => 'المراجعة',
        'assign' => 'رفع المراجعة',
        'confirm_sec' => 'تأكيد المراجعة',
        'all_classes' => 'كل الفصول',
        'classes' => 'الفصول',
        'subjects' => 'المواد',
        'previous' => 'السابق',
        'add' => 'رفع مراجعة',
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
        'delete_q' => 'تأكيد حذف المراجعة المرفوعة؟',
        'cancel' => 'إلغاء',
        'agree' => 'موافق',
        'download' => 'تحميل',
        'open' => 'فتح',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'today' => 'مراجعة اليوم',
        'confirm_btn' => 'تأكيد',
        'no_access' => 'لا توجد صلاحية للمراجعة',
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
    $RV = array(
        'title' => 'Revision',
        'assign' => 'Revision',
        'confirm_sec' => 'Confirm revision',
        'all_classes' => 'All classes',
        'classes' => 'Classes',
        'subjects' => 'Subjects',
        'previous' => 'Previous',
        'add' => 'Upload revision',
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
        'delete_q' => 'Confirm delete uploaded revision?',
        'cancel' => 'Cancel',
        'agree' => 'Agree',
        'download' => 'Download',
        'open' => 'Open',
        'preview' => 'Local preview — nothing is saved to the database',
        'today' => 'Today',
        'confirm_btn' => 'Confirm',
        'no_access' => 'Revision is not available for this account',
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

function rev_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function rev_today()
{
    return strtotime(date('m/d/Y', time()));
}

function rev_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function rev_app()
{
    global $row_get_user;
    return (int) ($row_get_user['id'] ?? 0);
}

function rev_year_names()
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

function rev_year_name($year)
{
    $year = (int) $year;
    if (function_exists('year_of_study')) {
        $name = trim((string) year_of_study($year));
        if ($name !== '') {
            return $name;
        }
    }
    $names = rev_year_names();
    return isset($names[$year]) ? $names[$year] : ('Year ' . $year);
}

function rev_dummy_subjects()
{
    return array(
        array('subject' => 1, 'name_eng' => 'English', 'name_arb' => 'اللغة الإنجليزية'),
        array('subject' => 2, 'name_eng' => 'Math', 'name_arb' => 'الرياضيات'),
        array('subject' => 3, 'name_eng' => 'Science', 'name_arb' => 'العلوم'),
    );
}

function rev_dummy_classes($year)
{
    $year = (int) $year;
    return array(
        array('id' => 1000 + ($year * 10) + 1, 'name' => 'A', 'fn_name' => 'أ', 'study_year' => $year),
        array('id' => 1000 + ($year * 10) + 2, 'name' => 'B', 'fn_name' => 'ب', 'study_year' => $year),
    );
}

function rev_preview_init()
{
    if (isset($_SESSION['helalia_rev_preview'])) {
        return;
    }
    $today = rev_today();
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
    $_SESSION['helalia_rev_preview'] = array('items' => $items, 'next' => $id);
}

function rev_preview_items()
{
    rev_preview_init();
    return $_SESSION['helalia_rev_preview']['items'];
}

function rev_preview_save($items)
{
    $_SESSION['helalia_rev_preview']['items'] = $items;
}

function rev_can_assign()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return function_exists('app15_1access') && app15_1access(rev_emp()) == 1;
}

function rev_can_confirm()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return function_exists('app16access') && app16access(rev_emp()) == 1;
}

function rev_preview_years()
{
    return array(0, 1, 5, 12);
}

function rev_years()
{
    if (!rev_has_db()) {
        return rev_preview_years();
    }
    $emp = rev_emp();
    $rows = rev_fetch("SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '{$emp}' ORDER BY `study_year` ASC");
    $years = array();
    foreach ($rows as $row) {
        $years[] = (int) $row['study_year'];
    }
    return $years;
}

function rev_year_allowed($year)
{
    return in_array((int) $year, rev_years(), true);
}

function rev_teaches_year($year)
{
    return rev_year_allowed($year);
}

function rev_class_allowed($year, $classId)
{
    $classId = (int) $classId;
    foreach (rev_classes((int) $year) as $row) {
        if ((int) $row['id'] === $classId) {
            return true;
        }
    }
    return false;
}

function rev_parse_classes_param()
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

function rev_validate_classes($year, $classIds)
{
    $allowed = array();
    foreach (rev_classes((int) $year) as $row) {
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

function rev_classes_query($classIds)
{
    $classIds = array_values(array_filter(array_map('intval', (array) $classIds)));
    if (!$classIds) {
        return '';
    }
    return implode(',', $classIds);
}

function rev_subjects_for_classes($year, $classIds)
{
    $year = (int) $year;
    $classIds = rev_validate_classes($year, $classIds);
    if (!$classIds) {
        return array();
    }
    if (!rev_has_db()) {
        return rev_dummy_subjects();
    }
    $emp = rev_emp();
    $in = rev_classes_query($classIds);
    return rev_fetch("SELECT DISTINCT `subject` FROM `teachers` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `class` IN ({$in})");
}

function rev_year_group($year)
{
    $year = (int) $year;
    if ($year < 1) {
        return 0;
    }
    if ($year < 3) {
        return 1;
    }
    if ($year < 6) {
        return 2;
    }
    if ($year < 9) {
        return 3;
    }
    if ($year < 12) {
        return 4;
    }
    return 5;
}

function rev_confirm_year_ok($year)
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    $fn = 'app16_' . rev_year_group((int) $year) . 'access';
    return function_exists($fn) && $fn(rev_emp()) == 1;
}

function rev_fetch($sql)
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

function rev_waiting_count($year)
{
    $year = (int) $year;
    if (!rev_has_db()) {
        $n = 0;
        foreach (rev_preview_items() as $row) {
            if ((int) $row['study_year'] === $year && (int) $row['confirm'] === 0) {
                $n++;
            }
        }
        return $n;
    }
    if (function_exists('revision_waitting')) {
        $html = revision_waitting($year);
        if (is_string($html) && preg_match('/>(\d+)</', $html, $m)) {
            return (int) $m[1];
        }
    }
    $rows = rev_fetch("SELECT `id` FROM `revision` WHERE `study_year` = '{$year}' AND `confirm` = 0");
    return count($rows);
}

function rev_classes($year)
{
    $year = (int) $year;
    if (!rev_has_db()) {
        return rev_dummy_classes($year);
    }
    $rows = rev_fetch("SELECT * FROM `class` WHERE `study_year` = '{$year}' ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        if (function_exists('check_class_subject') && check_class_subject(rev_emp(), $row['id']) <= 0) {
            continue;
        }
        $out[] = $row;
    }
    return $out;
}

function rev_class_label($row)
{
    if (is_array($row)) {
        if (isset($row['name']) && $row['name'] !== null && $row['name'] !== '') {
            return (string) $row['name'];
        }
        if (!empty($row['fn_name'])) {
            return (string) $row['fn_name'];
        }
        if (isset($row['id'])) {
            return rev_class_name($row['id']);
        }
        return '';
    }
    return rev_class_name($row);
}

function rev_class_name($id)
{
    $id = (int) $id;
    if (!rev_has_db()) {
        for ($y = 0; $y <= 14; $y++) {
            foreach (rev_dummy_classes($y) as $row) {
                if ((int) $row['id'] === $id) {
                    return rev_class_label($row);
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

function rev_subject_label($id)
{
    global $staffLang;
    $id = (int) $id;
    if (!rev_has_db()) {
        foreach (rev_dummy_subjects() as $row) {
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

function rev_subjects_for_class($year, $class)
{
    $year = (int) $year;
    $class = (int) $class;
    if (!rev_has_db()) {
        return rev_dummy_subjects();
    }
    $emp = rev_emp();
    return rev_fetch("SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}'");
}

function rev_subjects_for_year($year)
{
    $year = (int) $year;
    if (!rev_has_db()) {
        return rev_dummy_subjects();
    }
    $emp = rev_emp();
    return rev_fetch("SELECT DISTINCT `subject` FROM `teachers` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}'");
}

function rev_banner_url($banner)
{
    return staff_homework_url($banner);
}

function rev_who($row)
{
    global $staffLang;
    $emp = rev_emp();
    $admin = (int) ($row['admin_id'] ?? 0);
    if ((int) ($row['emp_id'] ?? 0) === $emp && $admin <= 0) {
        return '';
    }
    if (!rev_has_db()) {
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

function rev_filter_items($fn)
{
    $out = array();
    foreach (rev_preview_items() as $row) {
        if ($fn($row)) {
            $out[] = $row;
        }
    }
    return $out;
}

function rev_today_rows($year, $class, $subject, $all, $classIds = null)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $start = rev_today();
    $end = $start + 86400;
    $emp = rev_emp();
    $multi = is_array($classIds) && count($classIds) > 0;
    if (!rev_has_db()) {
        return rev_filter_items(function ($row) use ($year, $class, $subject, $all, $multi, $classIds, $start, $end, $emp) {
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
        return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `start` >= '{$start}' AND `start` < '{$end}'");
    }
    if ($multi) {
        $in = rev_classes_query($classIds);
        return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `class` IN ({$in}) AND `start` >= '{$start}' AND `start` < '{$end}'");
    }
    return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}' AND `subject` = '{$subject}' AND `start` >= '{$start}' AND `start` < '{$end}'");
}

function rev_prev_rows($year, $class, $subject, $dateTs)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $dateTs = (int) $dateTs;
    $emp = rev_emp();
    if (!rev_has_db()) {
        return rev_filter_items(function ($row) use ($year, $class, $subject, $dateTs, $emp) {
            return (int) $row['study_year'] === $year
                && (int) $row['class'] === $class
                && (int) $row['subject'] === $subject
                && (int) $row['emp_id'] === $emp
                && (int) $row['start'] === $dateTs;
        });
    }
    return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$emp}' AND `subject` = '{$subject}' AND `start` = '{$dateTs}'");
}

function rev_waiting_rows($year)
{
    $year = (int) $year;
    if (!rev_has_db()) {
        return rev_filter_items(function ($row) use ($year) {
            return (int) $row['study_year'] === $year && (int) $row['confirm'] === 0;
        });
    }
    return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `confirm` = 0");
}

function rev_confirmed_today_rows($year)
{
    $year = (int) $year;
    $date = rev_today();
    if (!rev_has_db()) {
        return rev_filter_items(function ($row) use ($year, $date) {
            return (int) $row['study_year'] === $year && (int) $row['confirm'] === 1 && (int) $row['start'] === $date;
        });
    }
    return rev_fetch("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `confirm` = 1 AND `start` = '{$date}'");
}

function rev_upload_dir()
{
    return staff_homework_dir();
}

function rev_notify($year, $class, $subject, $all)
{
    if (!rev_has_db() || !function_exists('sendMessage')) {
        return;
    }
    global $database, $database_database;
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    mysqli_select_db($database, $database_database);
    if ($all) {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids`.fn_name AS `kid_name`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.study_year = '{$year}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
        $message = 'Revision: ' . rev_subject_label($subject);
    } else {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids`.fn_name AS `kid_name`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.class = '{$class}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
        $message = 'Revision: ' . rev_subject_label($subject) . ' is uploaded';
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

function rev_insert_row($year, $class, $subject, $name, $text, $banner)
{
    global $database, $database_database;
    $now = time();
    $day = rev_today();
    if (!rev_has_db()) {
        $items = rev_preview_items();
        $id = (int) $_SESSION['helalia_rev_preview']['next'];
        $_SESSION['helalia_rev_preview']['next'] = $id + 1;
        $items[] = array(
            'id' => $id,
            'name_eng' => $name,
            'text_eng' => $text,
            'study_year' => (int) $year,
            'class' => (int) $class,
            'subject' => (int) $subject,
            'banner' => $banner,
            'emp_id' => rev_emp(),
            'app_id' => rev_app(),
            'confirm' => 1,
            'confirm_by' => rev_emp(),
            'admin_id' => 0,
            'start' => $day,
            'date' => $day,
        );
        rev_preview_save($items);
        return;
    }
    $insertSQL = sprintf(
        "INSERT INTO `revision` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `app_id`, `confirm`, `confirm_by`, `confirm_by_app_id`, `confirm_date`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($database, $name, 'text'),
        GetSQLValueString($database, $year, 'int'),
        GetSQLValueString($database, $class, 'int'),
        GetSQLValueString($database, $subject, 'int'),
        GetSQLValueString($database, $text, 'text'),
        GetSQLValueString($database, $day, 'int'),
        GetSQLValueString($database, $day, 'int'),
        GetSQLValueString($database, $banner, 'text'),
        GetSQLValueString($database, rev_emp(), 'int'),
        GetSQLValueString($database, rev_app(), 'int'),
        GetSQLValueString($database, 1, 'int'),
        GetSQLValueString($database, rev_emp(), 'int'),
        GetSQLValueString($database, rev_app(), 'int'),
        GetSQLValueString($database, $now, 'int')
    );
    mysqli_select_db($database, $database_database);
    mysqli_query($database, $insertSQL) or die(mysqli_error($database));
}

function rev_delete_row($id, $year, $class, $subject, $all, $classIds = null)
{
    $id = (int) $id;
    $year = (int) $year;
    if (!rev_has_db()) {
        $keep = array();
        foreach (rev_preview_items() as $row) {
            if ((int) $row['id'] === $id && (int) $row['emp_id'] === rev_emp() && (int) $row['app_id'] === rev_app()) {
                continue;
            }
            $keep[] = $row;
        }
        rev_preview_save($keep);
    } else {
        global $database, $database_database;
        $deleteSQL = sprintf(
            "DELETE FROM `revision` WHERE `id`=%s AND `emp_id`=%s AND `app_id`=%s",
            GetSQLValueString($database, $id, 'int'),
            GetSQLValueString($database, rev_emp(), 'int'),
            GetSQLValueString($database, rev_app(), 'int')
        );
        mysqli_select_db($database, $database_database);
        mysqli_query($database, $deleteSQL) or die(mysqli_error($database));
    }
    if ($all) {
        header('Location: revision-step3.php?year=' . $year . '&all&deleted');
    } elseif (is_array($classIds) && count($classIds) > 0) {
        header('Location: revision-step3.php?year=' . $year . '&classes=' . rawurlencode(rev_classes_query($classIds)) . '&deleted');
    } else {
        header('Location: revision-step3.php?year=' . $year . '&class=' . (int) $class . '&subject=' . (int) $subject . '&deleted');
    }
    exit;
}

function rev_handle_step3()
{
    $year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    $classIds = rev_validate_classes($year, rev_parse_classes_param());
    $multi = !$all && $class <= 0 && count($classIds) > 0;

    if (isset($_GET['del'])) {
        rev_delete_row((int) $_GET['del'], $year, $class, $subject, $all, $multi ? $classIds : null);
    }

    if (!isset($_POST['submit'])) {
        return;
    }

    $image_name = null;
    include __DIR__ . '/revision-up.php';

    $name = isset($_POST['name_eng']) ? (string) $_POST['name_eng'] : '';
    $text = isset($_POST['text_eng']) ? (string) $_POST['text_eng'] : '';

    if ($all) {
        $subject = isset($_POST['subject']) ? (int) $_POST['subject'] : 0;
        $classes = array();
        if (!rev_has_db()) {
            foreach (rev_dummy_classes($year) as $row) {
                $classes[] = (int) $row['id'];
            }
        } else {
            $emp = rev_emp();
            $rows = rev_fetch("SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `subject` = '{$subject}' AND `emp_id` = '{$emp}'");
            foreach ($rows as $row) {
                $classes[] = (int) $row['class'];
            }
        }
        foreach ($classes as $classId) {
            rev_insert_row($year, $classId, $subject, $name, $text, $image_name);
        }
        rev_notify($year, 0, $subject, true);
        header('Location: revision-step3.php?year=' . $year . '&all&done');
        exit;
    }

    if ($multi) {
        $subject = isset($_POST['subject']) ? (int) $_POST['subject'] : 0;
        $targets = array();
        if (!rev_has_db()) {
            $targets = $classIds;
        } else {
            $emp = rev_emp();
            $in = rev_classes_query($classIds);
            $rows = rev_fetch("SELECT `class` FROM `teachers` WHERE `study_year` = '{$year}' AND `subject` = '{$subject}' AND `emp_id` = '{$emp}' AND `class` IN ({$in})");
            foreach ($rows as $row) {
                $targets[] = (int) $row['class'];
            }
        }
        foreach ($targets as $classId) {
            rev_insert_row($year, $classId, $subject, $name, $text, $image_name);
        }
        foreach ($targets as $classId) {
            rev_notify($year, $classId, $subject, false);
        }
        header('Location: revision-step3.php?year=' . $year . '&classes=' . rawurlencode(rev_classes_query($classIds)) . '&done');
        exit;
    }

    rev_insert_row($year, $class, $subject, $name, $text, $image_name);
    rev_notify($year, $class, $subject, false);
    header('Location: revision-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject . '&done');
    exit;
}

function rev_confirm_one($id)
{
    $id = (int) $id;
    if (!rev_has_db()) {
        $items = rev_preview_items();
        $ok = 0;
        foreach ($items as &$row) {
            if ((int) $row['id'] === $id && (int) $row['confirm'] === 0) {
                $row['confirm'] = 1;
                $row['confirm_by'] = rev_emp();
                $ok = 1;
            }
        }
        unset($row);
        rev_preview_save($items);
        return $ok;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $rows = rev_fetch("SELECT * FROM `revision` WHERE `id` = '{$id}' AND `confirm` = 0");
    if (!$rows) {
        return 0;
    }
    $updateSQL = sprintf(
        "UPDATE `revision` SET `confirm`=%s, `confirm_by`=%s, `confirm_by_app_id`=%s, `confirm_date`=%s WHERE `id`=%s AND `confirm`=%s",
        GetSQLValueString($database, 1, 'int'),
        GetSQLValueString($database, rev_emp(), 'int'),
        GetSQLValueString($database, rev_app(), 'int'),
        GetSQLValueString($database, time(), 'int'),
        GetSQLValueString($database, $id, 'int'),
        GetSQLValueString($database, 0, 'int')
    );
    $result = mysqli_query($database, $updateSQL) or die(mysqli_error($database));
    return $result ? 1 : 0;
}

function rev_message_page($title, $text, $backHref)
{
    global $RV;
    staff_inner($title, $backHref, 'home');
    rev_empty($text);
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($RV['back']) . '</a>';
    staff_inner_end();
    exit;
}

function rev_need_year()
{
    global $RV;
    if (!isset($_GET['year']) || $_GET['year'] === '') {
        rev_message_page($RV['title'], $RV['year_missing'], 'revision.php');
    }
    $year = (int) $_GET['year'];
    if (!rev_year_allowed($year)) {
        rev_message_page($RV['title'], $RV['year_invalid'], 'revision.php');
    }
    return $year;
}

function rev_crumb($parts)
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

function rev_empty($text)
{
    echo '<div class="empty"><p>' . staff_h($text) . '</p></div>';
}

function rev_toast_markup()
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

function rev_item_row($row, $opts)
{
    global $RV;
    $all = !empty($opts['all']);
    $mode = isset($opts['mode']) ? $opts['mode'] : 'view';
    $title = (string) ($row['name_eng'] ?? '');
    if ($all) {
        $title = rev_class_name($row['class']) . ' · ' . rev_subject_label($row['subject']) . ' · ' . $title;
    }
    $text = (string) ($row['text_eng'] ?? '');
    $who = rev_who($row);
    $file = rev_banner_url($row['banner'] ?? '');
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
        echo '<a class="hw-act hw-act--quiet" href="' . staff_h($file) . '" target="_blank" rel="noopener" aria-label="' . staff_h($RV['download']) . '">' . staff_ico('download') . '</a>';
    }
    if ($mode === 'waiting') {
        echo '<button class="hw-act hw-confirm" type="button" value="' . $id . '" aria-label="' . staff_h($RV['confirm_btn']) . '">' . staff_ico('check') . '</button>';
    } elseif ($mode === 'confirmed') {
        echo '<span class="hw-act is-on" aria-hidden="true">' . staff_ico('check') . '</span>';
    } elseif ($mode === 'today' && (int) ($row['confirm'] ?? 1) === 0) {
        $delHref = isset($opts['del']) ? $opts['del'] . $id : '#';
        echo '<a class="hw-act hw-act--danger" href="' . staff_h($delHref) . '" onclick="return confirm(' . htmlspecialchars(json_encode($RV['delete_q']), ENT_QUOTES, 'UTF-8') . ')">' . staff_ico('trash') . '</a>';
    }
    echo '</div></div>';
}

function rev_page_landing()
{
    global $RV, $staffPreview;
    staff_inner($RV['title'], 'emp-view.php', 'home');
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($RV['preview']) . '</p>';
    }

    $has = false;
    if (rev_can_assign()) {
        $has = true;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['assign']) . '</h2></div>';
        echo '<div class="rows">';
        $any = false;
        foreach (rev_years() as $y) {
            $any = true;
            echo '<a class="row t-navy" href="revision-step1.php?year=' . $y . '">';
            echo '<span class="row__ico">' . staff_ico('book') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(rev_year_name($y)) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
        if (!$any) {
            rev_empty($RV['empty']);
        }
    }

    if (rev_can_confirm()) {
        $has = true;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['confirm_sec']) . '</h2></div>';
        echo '<div class="rows">';
        $any = false;
        for ($y = 0; $y <= 14; $y++) {
            if (!rev_confirm_year_ok($y)) {
                continue;
            }
            $any = true;
            $wait = rev_waiting_count($y);
            echo '<a class="row t-gold" href="revision-confirm.php?year=' . $y . '">';
            echo '<span class="row__ico">' . staff_ico('check') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(rev_year_name($y)) . '</p></div>';
            if ($wait > 0) {
                echo '<span class="row__count row__count--gold">' . (int) $wait . '</span>';
            }
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
        if (!$any) {
            rev_empty($RV['empty']);
        }
    }

    if (!$has) {
        rev_empty($RV['no_access']);
    }
    staff_inner_end();
}

function rev_page_step1()
{
    global $RV;
    $year = rev_need_year();
    staff_inner($RV['title'], 'revision.php', 'home');
    rev_crumb(array(rev_year_name($year), $RV['classes']));
    $rows = rev_classes($year);
    if (!$rows) {
        rev_empty($RV['empty']);
        echo '<a class="btn btn--primary stu-back" href="revision.php">' . staff_h($RV['back']) . '</a>';
        staff_inner_end();
        return;
    }

    $multi = count($rows) >= 2;
    if ($multi) {
        echo '<form class="hw-pick-form" action="revision-step3.php" method="get" id="hw-pick-form">';
        echo '<input type="hidden" name="year" value="' . (int) $year . '">';
        echo '<label class="hw-choice hw-pick__all"><input type="checkbox" id="hw-pick-all"> <span>' . staff_h($RV['select_all']) . '</span></label>';
        echo '<div class="hw-pick">';
        foreach ($rows as $row) {
            $id = (int) $row['id'];
            echo '<div class="row row--hw-pick t-navy">';
            echo '<label class="hw-pick__check" aria-label="' . staff_h(rev_class_label($row)) . '">';
            echo '<input type="checkbox" class="hw-pick__box" name="classes[]" value="' . $id . '">';
            echo '</label>';
            echo '<a class="row__body" href="revision-step2.php?year=' . $year . '&class=' . $id . '">';
            echo '<p class="row__title">' . staff_h(rev_class_label($row)) . '</p></a>';
            echo '<a class="row__go" href="revision-step2.php?year=' . $year . '&class=' . $id . '" aria-hidden="true">›</a>';
            echo '</div>';
        }
        echo '</div>';
        echo '<button class="btn btn--primary hw-pick__submit" type="submit">' . staff_h($RV['upload_selected']) . '</button>';
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
              alert(' . json_encode($RV['pick_classes'], JSON_UNESCAPED_UNICODE) . ');
            }
          });
        })();
        </script>';
    } else {
        echo '<div class="rows">';
        foreach ($rows as $row) {
            $id = (int) $row['id'];
            echo '<a class="row t-navy" href="revision-step2.php?year=' . $year . '&class=' . $id . '">';
            echo '<span class="row__ico">' . staff_ico('grid') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(rev_class_label($row)) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
    }
    staff_inner_end();
}

function rev_page_step2()
{
    global $RV;
    $year = rev_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    if ($class <= 0 || !rev_class_allowed($year, $class)) {
        rev_message_page($RV['title'], $RV['class_invalid'], 'revision-step1.php?year=' . $year);
    }
    staff_inner($RV['title'], 'revision-step1.php?year=' . $year, 'home');
    rev_crumb(array(rev_year_name($year), rev_class_name($class)));
    $rows = rev_subjects_for_class($year, $class);
    if (!$rows) {
        rev_empty($RV['empty']);
        staff_inner_end();
        return;
    }
    echo '<div class="rows">';
    foreach ($rows as $row) {
        $sid = (int) $row['subject'];
        echo '<div class="row t-navy">';
        echo '<span class="row__ico">' . staff_ico('book') . '</span>';
        echo '<div class="row__body"><p class="row__title">' . staff_h(rev_subject_label($sid)) . '</p></div>';
        echo '<div class="hw-acts">';
        echo '<a class="hw-act hw-act--quiet" href="revision-prev.php?year=' . $year . '&class=' . $class . '&subject=' . $sid . '" aria-label="' . staff_h($RV['previous']) . '">' . staff_ico('search') . '</a>';
        echo '<a class="hw-act" href="revision-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $sid . '" aria-label="' . staff_h($RV['add']) . '">' . staff_ico('upload') . '</a>';
        echo '</div></div>';
    }
    echo '</div>';
    staff_inner_end();
}

function rev_page_step3()
{
    global $RV;
    rev_handle_step3();
    $year = rev_need_year();
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    $classIds = rev_validate_classes($year, rev_parse_classes_param());
    $multi = !$all && $class <= 0 && count($classIds) > 0;
    if (!$all && !$multi && ($class <= 0 || !rev_class_allowed($year, $class))) {
        rev_message_page($RV['title'], $RV['class_invalid'], 'revision-step1.php?year=' . $year);
    }

    if ($all) {
        $back = 'revision.php';
    } elseif ($multi) {
        $back = 'revision-step1.php?year=' . $year;
    } else {
        $back = 'revision-step2.php?year=' . $year . '&class=' . $class;
    }
    staff_inner($RV['add'], $back, 'home');
    if ($all) {
        rev_crumb(array(rev_year_name($year), $RV['all_classes']));
        $action = 'revision-step3.php?year=' . $year . '&all';
        $subjects = rev_subjects_for_year($year);
        $showSubjectPicker = true;
    } elseif ($multi) {
        $labels = array();
        foreach ($classIds as $cid) {
            $labels[] = rev_class_name($cid);
        }
        rev_crumb(array(rev_year_name($year), $RV['selected_classes'] . ': ' . implode(', ', $labels)));
        $action = 'revision-step3.php?year=' . $year . '&classes=' . rawurlencode(rev_classes_query($classIds));
        $subjects = rev_subjects_for_classes($year, $classIds);
        $showSubjectPicker = true;
    } else {
        rev_crumb(array(rev_year_name($year), rev_class_name($class), rev_subject_label($subject)));
        $action = 'revision-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject;
        $subjects = array(array('subject' => $subject));
        $showSubjectPicker = false;
    }

    if ($subjects) {
        echo '<form class="card hw-form" action="' . staff_h($action) . '" method="post" enctype="multipart/form-data" id="form_upload">';
        if ($showSubjectPicker) {
            echo '<div><p class="field__label">' . staff_h($RV['subjects']) . '</p><div class="hw-choices">';
            $i = 0;
            foreach ($subjects as $row) {
                $sid = (int) $row['subject'];
                $i++;
                echo '<label class="hw-choice"><input type="radio" name="subject" value="' . $sid . '"' . ($i === 1 ? ' checked' : '') . '> <span>' . staff_h(rev_subject_label($sid)) . '</span></label>';
            }
            echo '</div></div>';
        }
        echo '<label class="field"><span class="field__label">' . staff_h($RV['title_field']) . '</span>';
        echo '<input class="input" id="name_eng" name="name_eng" type="text"></label>';
        echo '<label class="field"><span class="field__label">' . staff_h($RV['desc_field']) . '</span>';
        echo '<textarea class="input" id="text_eng" name="text_eng"></textarea></label>';
        echo '<label class="hw-file"><span class="field__label">' . staff_h($RV['file_field']) . '</span>';
        echo '<input id="picture" name="picture" type="file" accept="image/*, .pdf, .docx"></label>';
        echo '<button class="btn btn--primary" name="submit" type="submit" data-wait="' . staff_h($RV['uploading']) . '">' . staff_h($RV['upload']) . '</button>';
        echo '</form>';
    } else {
        rev_empty($RV['empty']);
    }

    $rows = rev_today_rows($year, $class, $subject, $all, $multi ? $classIds : null);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['today']) . '</h2></div>';
    if (!$rows) {
        rev_empty($RV['empty']);
    } else {
        if ($all) {
            $delBase = 'revision-step3.php?year=' . $year . '&all&del=';
            $listAll = true;
        } elseif ($multi) {
            $delBase = 'revision-step3.php?year=' . $year . '&classes=' . rawurlencode(rev_classes_query($classIds)) . '&del=';
            $listAll = true;
        } else {
            $delBase = 'revision-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $subject . '&del=';
            $listAll = false;
        }
        echo '<div class="rows">';
        foreach ($rows as $row) {
            rev_item_row($row, array('mode' => 'today', 'all' => $listAll, 'del' => $delBase));
        }
        echo '</div>';
    }
    rev_toast_markup();
    staff_inner_end();
}

function rev_page_prev()
{
    global $RV;
    $year = rev_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    staff_inner($RV['previous'], 'revision-step2.php?year=' . $year . '&class=' . $class, 'home');
    rev_crumb(array(rev_year_name($year), rev_class_name($class), rev_subject_label($subject)));

    $dateVal = isset($_GET['date']) ? (string) $_GET['date'] : '';
    echo '<form class="card hw-form" action="revision-prev.php" method="get">';
    echo '<label class="field"><span class="field__label">' . staff_h($RV['date']) . '</span>';
    echo '<input class="input" id="date" name="date" type="date" required value="' . staff_h($dateVal) . '"></label>';
    echo '<input type="hidden" name="year" value="' . $year . '">';
    echo '<input type="hidden" name="class" value="' . $class . '">';
    echo '<input type="hidden" name="subject" value="' . $subject . '">';
    echo '<button class="btn btn--primary" name="search" type="submit">' . staff_h($RV['search']) . '</button>';
    echo '</form>';

    if (isset($_GET['search'])) {
        $dateTs = strtotime($_GET['date']);
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['search_on'] . ': ' . $_GET['date']) . '</h2></div>';
        $rows = rev_prev_rows($year, $class, $subject, $dateTs);
        if (!$rows) {
            rev_empty($RV['no_result']);
        } else {
            echo '<div class="rows">';
            foreach ($rows as $row) {
                rev_item_row($row, array('mode' => 'view'));
            }
            echo '</div>';
        }
    }
    rev_toast_markup();
    staff_inner_end();
}

function rev_confirm_item_html($row)
{
    ob_start();
    rev_item_row($row, array('mode' => 'confirmed'));
    return ob_get_clean();
}

function rev_page_confirm()
{
    global $RV;
    $year = rev_need_year();
    staff_inner($RV['confirm_sec'], 'revision.php', 'home');
    rev_crumb(array(rev_year_name($year)));

    $canAct = true;
    if (rev_has_db()) {
        $canAct = rev_confirm_year_ok($year);
    }

    $waiting = rev_waiting_rows($year);
    if ($waiting) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['waiting']) . '</h2></div>';
        echo '<div class="rows" id="waiting">';
        foreach ($waiting as $row) {
            if ($canAct) {
                rev_item_row($row, array('mode' => 'waiting'));
            }
        }
        echo '</div>';
    }

    $confirmed = rev_confirmed_today_rows($year);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($RV['confirmed']) . '</h2></div>';
    echo '<div class="rows" id="confirmed">';
    if ($confirmed) {
        foreach ($confirmed as $row) {
            rev_item_row($row, array('mode' => 'confirmed'));
        }
    } else {
        echo '<div class="empty" id="confirmed-empty"><p>' . staff_h($RV['empty']) . '</p></div>';
    }
    echo '</div>';
    rev_toast_markup();
    echo '<script>
    (function(){
      var year = ' . (int) $year . ';
      document.querySelectorAll(".hw-confirm").forEach(function(btn){
        btn.addEventListener("click", function(){
          var id = this.value;
          this.disabled = true;
          var body = new URLSearchParams();
          body.set("id", id);
          fetch("revision-confirm-data.php", { method:"POST", headers:{"Content-Type":"application/x-www-form-urlencoded"}, body: body.toString() })
            .then(function(r){ return r.text(); })
            .then(function(txt){
              if (!(parseInt(String(txt).trim(), 10) > 0)) { btn.disabled = false; return; }
              var row = document.getElementById("row"+id);
              if (row) row.remove();
              var waitBox = document.getElementById("waiting");
              if (waitBox && !waitBox.querySelector(".row")) waitBox.remove();
              var y = new URLSearchParams();
              y.set("year", year);
              return fetch("revision-confirm-result.php", { method:"POST", headers:{"Content-Type":"application/x-www-form-urlencoded"}, body: y.toString() })
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

function rev_page_confirm_data()
{
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if ($id <= 0) {
        return;
    }
    echo rev_confirm_one($id);
}

function rev_page_confirm_result()
{
    $year = isset($_POST['year']) ? (int) $_POST['year'] : 0;
    $rows = rev_confirmed_today_rows($year);
    if (!$rows) {
        return;
    }
    foreach ($rows as $row) {
        echo rev_confirm_item_html($row);
    }
}
