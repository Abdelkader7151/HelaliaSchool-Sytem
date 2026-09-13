<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

if (!isset($showMemo) || (!$staffPreview && !$showMemo)) {
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
if (!memo_has_db()) {
    memo_preview_init();
}

if ($staffLang === 'arb') {
    $MM = array(
        'title' => 'المذكرة',
        'assign' => 'رفع مذكرة',
        'uploaded_sec' => 'المذكرات المرفوعة',
        'all_classes' => 'كل الفصول',
        'year_field' => 'السنة الدراسية',
        'class_field' => 'الفصل',
        'title_field' => 'العنوان',
        'desc_field' => 'الوصف',
        'file_field' => 'رفع ملف',
        'upload' => 'رفع',
        'search' => 'بحث',
        'date' => 'التاريخ',
        'search_on' => 'بحث في',
        'done' => 'تم التحديث بنجاح',
        'deleted' => 'تم الحذف',
        'no_result' => 'لا توجد نتائج',
        'empty' => 'لا توجد عناصر',
        'delete' => 'حذف',
        'delete_q' => 'تأكيد حذف المذكرة المرفوعة؟',
        'download' => 'تحميل',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'today' => 'مذكرات اليوم',
        'uploaded' => 'مرفوع',
        'no_access' => 'المذكرة غير متاحة لهذا الحساب',
        'uploading' => 'جاري الرفع…',
        'back' => 'رجوع',
        'year_missing' => 'لم يتم تحديد السنة الدراسية',
        'year_invalid' => 'هذه السنة الدراسية غير متاحة لحسابك',
        'class_invalid' => 'هذا الفصل غير متاح لحسابك',
        'pick_class' => 'اختر الفصل',
        'pick_year' => 'اختر السنة الدراسية',
    );
} else {
    $MM = array(
        'title' => 'Memo',
        'assign' => 'Upload memo',
        'uploaded_sec' => 'Uploaded memos',
        'all_classes' => 'All classes',
        'year_field' => 'Study year',
        'class_field' => 'Class',
        'title_field' => 'Title',
        'desc_field' => 'Description',
        'file_field' => 'Upload file',
        'upload' => 'Upload',
        'search' => 'Search',
        'date' => 'Date',
        'search_on' => 'Search on',
        'done' => 'Updated successfully',
        'deleted' => 'Deleted',
        'no_result' => 'No result',
        'empty' => 'Nothing here yet',
        'delete' => 'Delete',
        'delete_q' => 'Confirm delete uploaded memo?',
        'download' => 'Download',
        'preview' => 'Local preview — nothing is saved to the database',
        'today' => 'Today',
        'uploaded' => 'Uploaded',
        'no_access' => 'Memo is not available for this account',
        'uploading' => 'Uploading…',
        'back' => 'Back',
        'year_missing' => 'Study year was not specified',
        'year_invalid' => 'This study year is not available for your account',
        'class_invalid' => 'This class is not available for your account',
        'pick_class' => 'Select class',
        'pick_year' => 'Select study year',
    );
}

function memo_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function memo_today()
{
    return strtotime(date('m/d/Y', time()));
}

function memo_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function memo_app()
{
    global $row_get_user;
    return (int) ($row_get_user['id'] ?? 0);
}

function memo_year_group($year)
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

function memo_year_names()
{
    global $staffLang;
    if ($staffLang === 'arb') {
        return array(
            0 => 'بري سكول', 1 => 'رياض أطفال 1', 2 => 'رياض أطفال 2',
            3 => 'الابتدائي 1', 4 => 'الابتدائي 2', 5 => 'الابتدائي 3',
            6 => 'الابتدائي 4', 7 => 'الابتدائي 5', 8 => 'الابتدائي 6',
            9 => 'الاعدادي 1', 10 => 'الاعدادي 2', 11 => 'الاعدادي 3',
            12 => 'الثانوي 1', 13 => 'الثانوي 2', 14 => 'الثانوي 3',
        );
    }
    return array(
        0 => 'PreSchool', 1 => 'KG1', 2 => 'KG2',
        3 => 'Junior One', 4 => 'Junior Two', 5 => 'Junior Three',
        6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
        12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
    );
}

function memo_year_name($year)
{
    $year = (int) $year;
    if (function_exists('year_of_study')) {
        $name = trim((string) year_of_study($year));
        if ($name !== '') {
            return $name;
        }
    }
    $names = memo_year_names();
    return isset($names[$year]) ? $names[$year] : ('Year ' . $year);
}

function memo_dummy_classes($year)
{
    $year = (int) $year;
    return array(
        array('id' => 1000 + ($year * 10) + 1, 'name' => 'A', 'fn_name' => 'أ', 'study_year' => $year),
        array('id' => 1000 + ($year * 10) + 2, 'name' => 'B', 'fn_name' => 'ب', 'study_year' => $year),
    );
}

function memo_preview_init()
{
    if (isset($_SESSION['helalia_memo_preview'])) {
        return;
    }
    $today = memo_today();
    $_SESSION['helalia_memo_preview'] = array(
        'items' => array(
            array(
                'id' => 1,
                'name_eng' => 'Trip permission',
                'text_eng' => 'Please sign and return tomorrow.',
                'study_year' => 5,
                'class' => 1051,
                'banner' => 'sample.pdf',
                'emp_id' => 0,
                'app_id' => 0,
                'date' => $today,
            ),
        ),
        'next' => 2,
    );
}

function memo_preview_items()
{
    memo_preview_init();
    return $_SESSION['helalia_memo_preview']['items'];
}

function memo_preview_save($items)
{
    $_SESSION['helalia_memo_preview']['items'] = $items;
}

function memo_can_assign()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return (function_exists('app17_1access') && app17_1access(memo_emp()) == 1)
        || (function_exists('app17access') && app17access(memo_emp()) == 1);
}

function memo_can_view_uploaded()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return function_exists('app18access') && app18access(memo_emp()) == 1;
}

function memo_year_ok($year)
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    $fn = 'app18_' . memo_year_group((int) $year) . 'access';
    return function_exists($fn) && $fn(memo_emp()) == 1;
}

function memo_assign_years()
{
    $years = array();
    for ($y = 0; $y <= 14; $y++) {
        if (memo_year_ok($y)) {
            $years[] = $y;
        }
    }
    return $years;
}

function memo_fetch($sql)
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

function memo_classes($year)
{
    $year = (int) $year;
    if (!memo_has_db()) {
        return memo_dummy_classes($year);
    }
    $rows = memo_fetch("SELECT * FROM `class` WHERE `study_year` = '{$year}' ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        if (function_exists('check_class_subject') && check_class_subject(memo_emp(), $row['id']) <= 0) {
            continue;
        }
        $out[] = $row;
    }
    return $out;
}

function memo_class_allowed($year, $classId)
{
    $classId = (int) $classId;
    foreach (memo_classes((int) $year) as $row) {
        if ((int) $row['id'] === $classId) {
            return true;
        }
    }
    return false;
}

function memo_class_label($row)
{
    if (is_array($row)) {
        if (isset($row['name']) && $row['name'] !== null && $row['name'] !== '') {
            return (string) $row['name'];
        }
        if (!empty($row['fn_name'])) {
            return (string) $row['fn_name'];
        }
        if (isset($row['id'])) {
            return memo_class_name($row['id']);
        }
        return '';
    }
    return memo_class_name($row);
}

function memo_class_name($id)
{
    $id = (int) $id;
    if (!memo_has_db()) {
        for ($y = 0; $y <= 14; $y++) {
            foreach (memo_dummy_classes($y) as $row) {
                if ((int) $row['id'] === $id) {
                    return memo_class_label($row);
                }
            }
        }
        return '#' . $id;
    }
    $rows = memo_fetch("SELECT * FROM `class` WHERE `id` = '{$id}' LIMIT 1");
    if ($rows) {
        return memo_class_label($rows[0]);
    }
    return '#' . $id;
}

function memo_upload_dir()
{
    return staff_homework_dir();
}

function memo_banner_url($name)
{
    return staff_homework_url($name);
}

function memo_notify($year, $classId, $title)
{
    if (!memo_has_db() || !function_exists('sendMessage')) {
        return;
    }
    global $database, $database_database;
    $year = (int) $year;
    $classId = (int) $classId;
    mysqli_select_db($database, $database_database);
    if ($classId <= 0) {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.study_year = '{$year}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
    } else {
        $sql = "SELECT `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.class = '{$classId}' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0";
    }
    $message = 'Memo: ' . $title . ' is uploaded';
    $q = mysqli_query($database, $sql);
    if (!$q) {
        return;
    }
    while ($row = mysqli_fetch_assoc($q)) {
        if ((int) ($row['kid_id'] ?? 0) === 1741) {
            continue;
        }
        if (!empty($row['phone_id']) && function_exists('sendMessage')) {
            sendMessage($row['phone_id'], 'HLS', $message);
        }
    }
}

function memo_insert_row($year, $classId, $name, $text, $banner)
{
    $year = (int) $year;
    $classId = (int) $classId;
    $now = memo_today();
    if (!memo_has_db()) {
        $items = memo_preview_items();
        $id = (int) $_SESSION['helalia_memo_preview']['next'];
        $_SESSION['helalia_memo_preview']['next'] = $id + 1;
        $items[] = array(
            'id' => $id,
            'name_eng' => $name,
            'text_eng' => $text,
            'study_year' => $year,
            'class' => $classId,
            'banner' => $banner,
            'emp_id' => memo_emp(),
            'app_id' => memo_app(),
            'date' => $now,
        );
        memo_preview_save($items);
        return;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $sql = sprintf(
        "INSERT INTO `memos` (`name_eng`, `study_year`, `class`, `text_eng`, `date`, `banner`, `emp_id`, `app_id`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($database, $name, 'text'),
        GetSQLValueString($database, $year, 'int'),
        GetSQLValueString($database, $classId, 'int'),
        GetSQLValueString($database, $text, 'text'),
        GetSQLValueString($database, $now, 'int'),
        GetSQLValueString($database, $banner, 'text'),
        GetSQLValueString($database, memo_emp(), 'int'),
        GetSQLValueString($database, memo_app(), 'int')
    );
    mysqli_query($database, $sql) or die(mysqli_error($database));
}

function memo_delete_row($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return;
    }
    if (!memo_has_db()) {
        $items = array();
        foreach (memo_preview_items() as $row) {
            if ((int) $row['id'] !== $id || (int) $row['emp_id'] !== memo_emp()) {
                $items[] = $row;
            }
        }
        memo_preview_save($items);
        return;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $emp = memo_emp();
    mysqli_query($database, "DELETE FROM `memos` WHERE `id` = '{$id}' AND `emp_id` = '{$emp}'");
}

function memo_today_rows($year, $classPick)
{
    $year = (int) $year;
    $start = memo_today();
    $emp = memo_emp();
    $all = ($classPick === 'all');
    $classId = $all ? 0 : (int) $classPick;

    if (!memo_has_db()) {
        $allowed = array();
        if ($all) {
            foreach (memo_classes($year) as $row) {
                $allowed[(int) $row['id']] = true;
            }
        }
        $out = array();
        foreach (memo_preview_items() as $row) {
            if ((int) $row['emp_id'] !== $emp || (int) $row['date'] < $start) {
                continue;
            }
            if ((int) $row['study_year'] !== $year && (int) $row['study_year'] !== 300) {
                continue;
            }
            if ($all) {
                if (!isset($allowed[(int) $row['class']])) {
                    continue;
                }
            } elseif ((int) $row['class'] !== $classId) {
                continue;
            }
            $out[] = $row;
        }
        return $out;
    }

    $sql = "SELECT * FROM `memos` WHERE (`study_year` = '{$year}' OR `study_year` = 300) AND `emp_id` = '{$emp}' AND `date` >= '{$start}'";
    if (!$all) {
        $sql .= " AND `class` = '{$classId}'";
    } else {
        $ids = array();
        foreach (memo_classes($year) as $row) {
            $ids[] = (int) $row['id'];
        }
        if ($ids) {
            $sql .= ' AND `class` IN (' . implode(',', $ids) . ')';
        } else {
            return array();
        }
    }
    $sql .= ' ORDER BY `id` DESC';
    return memo_fetch($sql);
}

function memo_search_rows($year, $classId, $dateTs)
{
    $year = (int) $year;
    $classId = (int) $classId;
    $dateTs = (int) $dateTs;
    $emp = memo_emp();
    if (!memo_has_db()) {
        $out = array();
        foreach (memo_preview_items() as $row) {
            if ((int) $row['study_year'] === $year
                && (int) $row['class'] === $classId
                && (int) $row['emp_id'] === $emp
                && (int) $row['date'] === $dateTs) {
                $out[] = $row;
            }
        }
        return $out;
    }
    return memo_fetch("SELECT * FROM `memos` WHERE `study_year` = '{$year}' AND `class` = '{$classId}' AND `emp_id` = '{$emp}' AND `date` = '{$dateTs}' ORDER BY `id` DESC");
}

function memo_uploaded_rows($year)
{
    $year = (int) $year;
    if (!memo_has_db()) {
        $out = array();
        foreach (memo_preview_items() as $row) {
            if ((int) $row['study_year'] === $year || (int) $row['study_year'] === 300) {
                $out[] = $row;
            }
        }
        usort($out, function ($a, $b) {
            return (int) $b['date'] - (int) $a['date'];
        });
        return $out;
    }
    return memo_fetch("SELECT * FROM `memos` WHERE (`study_year` = '{$year}' OR `study_year` = 300) ORDER BY `date` DESC, `id` DESC");
}

function memo_empty($text = null)
{
    global $MM;
    echo '<div class="empty"><p>' . staff_h($text !== null ? $text : $MM['empty']) . '</p></div>';
}

function memo_message_page($title, $text, $backHref)
{
    global $MM;
    staff_inner($title, $backHref, 'home');
    memo_empty($text);
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($MM['back']) . '</a>';
    staff_inner_end();
    exit;
}

function memo_item_row($row, $opts = array())
{
    global $MM;
    $title = (string) ($row['name_eng'] ?? '');
    $text = (string) ($row['text_eng'] ?? '');
    $file = memo_banner_url($row['banner'] ?? '');
    $id = (int) ($row['id'] ?? 0);
    $showClass = !empty($opts['show_class']);

    echo '<div class="row row--hw t-navy" id="memo' . $id . '">';
    echo '<span class="row__ico">' . staff_ico('file') . '</span>';
    echo '<div class="row__body">';
    echo '<p class="row__title"><a href="#" data-hw-text="' . staff_h($text) . '">' . staff_h($title) . '</a></p>';
    if ($showClass && isset($row['class'])) {
        echo '<p class="hw-who">' . staff_h(memo_class_name($row['class'])) . '</p>';
    }
    echo '</div>';
    echo '<div class="hw-acts">';
    if ($file !== '') {
        echo '<a class="hw-act hw-act--quiet" href="' . staff_h($file) . '" target="_blank" rel="noopener" aria-label="' . staff_h($MM['download']) . '">' . staff_ico('download') . '</a>';
    }
    if (!empty($opts['delete_href'])) {
        echo '<a class="hw-act hw-act--danger" href="' . staff_h($opts['delete_href']) . '" onclick="return confirm(' . htmlspecialchars(json_encode($MM['delete_q']), ENT_QUOTES, 'UTF-8') . ')">' . staff_ico('trash') . '</a>';
    }
    echo '</div></div>';
}

function memo_parse_class_pick()
{
    if (!isset($_REQUEST['class'])) {
        return '';
    }
    $raw = (string) $_REQUEST['class'];
    if ($raw === 'all') {
        return 'all';
    }
    $id = (int) $raw;
    return $id > 0 ? (string) $id : '';
}

function memo_handle_main()
{
    global $MM;
    if (isset($_GET['del'])) {
        memo_delete_row((int) $_GET['del']);
        $year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
        $class = memo_parse_class_pick();
        $qs = 'memo.php?year=' . $year;
        if ($class !== '') {
            $qs .= '&class=' . rawurlencode($class);
        }
        header('Location: ' . $qs . '&deleted=1');
        exit;
    }

    if (!isset($_POST['submit'])) {
        return;
    }

    $year = isset($_POST['year']) ? (int) $_POST['year'] : 0;
    $classPick = memo_parse_class_pick();
    if (!memo_year_ok($year)) {
        memo_message_page($MM['title'], $MM['year_invalid'], 'memo.php');
    }
    if ($classPick === '') {
        memo_message_page($MM['title'], $MM['pick_class'], 'memo.php?year=' . $year);
    }

    $image_name = null;
    include __DIR__ . '/memo-up.php';

    $name = isset($_POST['name_eng']) ? trim((string) $_POST['name_eng']) : '';
    $text = isset($_POST['text_eng']) ? trim((string) $_POST['text_eng']) : '';

    if ($classPick === 'all') {
        $targets = array();
        foreach (memo_classes($year) as $row) {
            $targets[] = (int) $row['id'];
        }
        if (!$targets) {
            memo_message_page($MM['title'], $MM['class_invalid'], 'memo.php?year=' . $year);
        }
        foreach ($targets as $classId) {
            memo_insert_row($year, $classId, $name, $text, $image_name);
            memo_notify($year, $classId, $name);
        }
    } else {
        $classId = (int) $classPick;
        if (!memo_class_allowed($year, $classId)) {
            memo_message_page($MM['title'], $MM['class_invalid'], 'memo.php?year=' . $year);
        }
        memo_insert_row($year, $classId, $name, $text, $image_name);
        memo_notify($year, $classId, $name);
    }

    $qs = 'memo.php?year=' . $year . '&class=' . rawurlencode($classPick) . '&done=1';
    header('Location: ' . $qs);
    exit;
}

function memo_page_main()
{
    global $MM, $staffPreview;
    memo_handle_main();

    staff_inner($MM['title'], 'emp-view.php', 'home');
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($MM['preview']) . '</p>';
    }

    $has = false;

    if (memo_can_assign()) {
        $years = memo_assign_years();
        if ($years) {
            $has = true;
            $year = isset($_GET['year']) ? (int) $_GET['year'] : (int) $years[0];
            if (!in_array($year, $years, true)) {
                $year = (int) $years[0];
            }
            $classPick = memo_parse_class_pick();
            $classes = memo_classes($year);

            echo '<div class="sec"><h2 class="sec__title">' . staff_h($MM['assign']) . '</h2></div>';

            echo '<form class="memo-picks card" method="get" action="memo.php" id="memo-picks">';
            echo '<label class="field"><span class="field__label">' . staff_h($MM['year_field']) . '</span>';
            echo '<select class="input" name="year" onchange="this.form.submit()">';
            foreach ($years as $y) {
                echo '<option value="' . $y . '"' . ($y === $year ? ' selected' : '') . '>' . staff_h(memo_year_name($y)) . '</option>';
            }
            echo '</select></label>';
            echo '<label class="field"><span class="field__label">' . staff_h($MM['class_field']) . '</span>';
            echo '<select class="input" name="class" onchange="this.form.submit()">';
            echo '<option value=""' . ($classPick === '' ? ' selected' : '') . '>' . staff_h($MM['pick_class']) . '</option>';
            echo '<option value="all"' . ($classPick === 'all' ? ' selected' : '') . '>' . staff_h($MM['all_classes']) . '</option>';
            foreach ($classes as $row) {
                $cid = (int) $row['id'];
                echo '<option value="' . $cid . '"' . ($classPick === (string) $cid ? ' selected' : '') . '>' . staff_h(memo_class_label($row)) . '</option>';
            }
            echo '</select></label>';
            echo '</form>';

            echo '<form class="card hw-form" action="memo.php" method="post" enctype="multipart/form-data" id="memo-upload">';
            echo '<input type="hidden" name="year" value="' . $year . '">';
            echo '<input type="hidden" name="class" value="' . staff_h($classPick) . '">';
            echo '<label class="field"><span class="field__label">' . staff_h($MM['title_field']) . '</span>';
            echo '<input class="input" id="name_eng" name="name_eng" type="text" required></label>';
            echo '<label class="field"><span class="field__label">' . staff_h($MM['desc_field']) . '</span>';
            echo '<textarea class="input" id="text_eng" name="text_eng"></textarea></label>';
            echo '<label class="hw-file"><span class="field__label">' . staff_h($MM['file_field']) . '</span>';
            echo '<input id="picture" name="picture" type="file" accept="image/*, .pdf, .docx"></label>';
            echo '<button class="btn btn--primary" name="submit" type="submit" data-wait="' . staff_h($MM['uploading']) . '">' . staff_h($MM['upload']) . '</button>';
            echo '</form>';

            if ($classPick !== '') {
                $delBase = 'memo.php?year=' . $year . '&class=' . rawurlencode($classPick) . '&del=';
                $rows = memo_today_rows($year, $classPick);
                echo '<div class="sec"><h2 class="sec__title">' . staff_h($MM['today']) . '</h2></div>';
                if (!$rows) {
                    memo_empty();
                } else {
                    echo '<div class="rows">';
                    foreach ($rows as $row) {
                        memo_item_row($row, array(
                            'show_class' => ($classPick === 'all'),
                            'delete_href' => $delBase . (int) $row['id'],
                        ));
                    }
                    echo '</div>';
                }

                if ($classPick !== 'all' && $classPick !== '') {
                    echo '<p style="margin-top:14px"><a class="sec__link" href="memo-prev.php?year=' . $year . '&class=' . (int) $classPick . '">' . staff_h($MM['search']) . '</a></p>';
                }
            }
        } else {
            memo_empty($MM['year_invalid']);
            echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($MM['back']) . '</a>';
        }
    }

    if (memo_can_view_uploaded()) {
        $years = memo_assign_years();
        if ($years) {
            $has = true;
            echo '<div class="sec"><h2 class="sec__title">' . staff_h($MM['uploaded_sec']) . '</h2></div>';
            echo '<div class="rows">';
            foreach ($years as $y) {
                echo '<a class="row t-gold" href="memo-confirm.php?year=' . $y . '">';
                echo '<span class="row__ico">' . staff_ico('pin') . '</span>';
                echo '<div class="row__body"><p class="row__title">' . staff_h(memo_year_name($y)) . '</p></div>';
                echo '<span class="row__go">›</span></a>';
            }
            echo '</div>';
        }
    }

    if (!$has) {
        memo_empty($MM['no_access']);
        echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($MM['back']) . '</a>';
    }

    echo '<script>
    (function(){
      var picks = document.getElementById("memo-picks");
      var upload = document.getElementById("memo-upload");
      if (!picks || !upload) return;
      function syncClass(){
        var sel = picks.querySelector("select[name=class]");
        var hid = upload.querySelector("input[name=class]");
        if (sel && hid) hid.value = sel.value;
      }
      picks.querySelectorAll("select").forEach(function(el){
        el.addEventListener("change", syncClass);
      });
      syncClass();
    })();
    </script>';
    staff_inner_end();
}

function memo_need_year()
{
    global $MM;
    if (!isset($_GET['year']) || $_GET['year'] === '') {
        memo_message_page($MM['title'], $MM['year_missing'], 'memo.php');
    }
    $year = (int) $_GET['year'];
    if (!memo_year_ok($year)) {
        memo_message_page($MM['title'], $MM['year_invalid'], 'memo.php');
    }
    return $year;
}

function memo_page_uploaded()
{
    global $MM;
    $year = memo_need_year();
    staff_inner($MM['uploaded_sec'], 'memo.php', 'home');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(memo_year_name($year)) . '</h2></div>';
    $rows = memo_uploaded_rows($year);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($MM['uploaded']) . '</h2></div>';
    if (!$rows) {
        memo_empty();
        echo '<a class="btn btn--primary stu-back" href="memo.php">' . staff_h($MM['back']) . '</a>';
    } else {
        echo '<div class="rows">';
        foreach ($rows as $row) {
            memo_item_row($row, array('show_class' => true));
        }
        echo '</div>';
    }
    staff_inner_end();
}

function memo_page_prev()
{
    global $MM;
    $year = memo_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    if ($class <= 0 || !memo_class_allowed($year, $class)) {
        memo_message_page($MM['title'], $MM['class_invalid'], 'memo.php?year=' . $year);
    }
    staff_inner($MM['search'], 'memo.php?year=' . $year . '&class=' . $class, 'home');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(memo_year_name($year) . ' · ' . memo_class_name($class)) . '</h2></div>';

    $dateVal = isset($_GET['date']) ? (string) $_GET['date'] : '';
    echo '<form class="card hw-form" action="memo-prev.php" method="get">';
    echo '<label class="field"><span class="field__label">' . staff_h($MM['date']) . '</span>';
    echo '<input class="input" id="date" name="date" type="date" required value="' . staff_h($dateVal) . '"></label>';
    echo '<input type="hidden" name="year" value="' . $year . '">';
    echo '<input type="hidden" name="class" value="' . $class . '">';
    echo '<button class="btn btn--primary" name="search" type="submit">' . staff_h($MM['search']) . '</button>';
    echo '</form>';

    if (isset($_GET['search'])) {
        $dateTs = strtotime($_GET['date']);
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($MM['search_on'] . ': ' . $_GET['date']) . '</h2></div>';
        $rows = memo_search_rows($year, $class, $dateTs);
        if (!$rows) {
            memo_empty($MM['no_result']);
        } else {
            echo '<div class="rows">';
            foreach ($rows as $row) {
                memo_item_row($row, array());
            }
            echo '</div>';
        }
    }
    staff_inner_end();
}
