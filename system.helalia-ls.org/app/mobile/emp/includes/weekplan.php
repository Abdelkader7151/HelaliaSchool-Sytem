<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

require_once dirname(__DIR__) . '/includes/staff-tools.php';

if (!isset($showPlan) || (!$staffPreview && !$showPlan)) {
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
if (!wp_has_db()) {
    wp_preview_init();
}

if ($staffLang === 'arb') {
    $WP = array(
        'title' => 'الخطة الأسبوعية',
        'all_classes' => 'كل الفصول',
        'title_field' => 'العنوان',
        'desc_field' => 'الوصف',
        'file_field' => 'رفع ملف',
        'file_hint' => 'jpg - png - pdf - doc',
        'upload' => 'رفع',
        'search' => 'بحث',
        'date' => 'التاريخ',
        'search_on' => 'بحث في',
        'no_result' => 'لا توجد نتائج',
        'empty' => 'لا توجد عناصر',
        'delete' => 'حذف',
        'delete_q' => 'تأكيد حذف الخطة المرفوعة؟',
        'download' => 'تحميل',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'today' => 'خطة اليوم',
        'no_access' => 'الخطة الأسبوعية غير متاحة لهذا الحساب',
        'uploading' => 'جاري الرفع…',
        'back' => 'رجوع',
        'year_missing' => 'لم يتم تحديد السنة الدراسية',
        'year_invalid' => 'هذه السنة الدراسية غير متاحة لحسابك',
        'upload_invalid' => 'رفع الخطة الأسبوعية غير متاح لهذا الحساب',
        'class_invalid' => 'هذا الفصل غير متاح لحسابك',
        'choose_year' => 'اختر السنة الدراسية',
        'empty_years' => 'لا توجد سنوات متاحة',
    );
} else {
    $WP = array(
        'title' => 'Weekly plan',
        'all_classes' => 'All classes',
        'title_field' => 'Title',
        'desc_field' => 'Description',
        'file_field' => 'Upload file',
        'file_hint' => 'jpg - png - pdf - doc',
        'upload' => 'Upload',
        'search' => 'Search',
        'date' => 'Date',
        'search_on' => 'Search on',
        'no_result' => 'No result',
        'empty' => 'Nothing here yet',
        'delete' => 'Delete',
        'delete_q' => 'Confirm delete uploaded plan?',
        'download' => 'Download',
        'preview' => 'Local preview — nothing is saved to the database',
        'today' => 'Today',
        'no_access' => 'Weekly plan is not available for this account',
        'uploading' => 'Uploading…',
        'back' => 'Back',
        'year_missing' => 'Study year was not specified',
        'year_invalid' => 'This study year is not available for your account',
        'upload_invalid' => 'Weekly plan upload is not available for your account',
        'class_invalid' => 'This class is not available for your account',
        'choose_year' => 'Choose study year',
        'empty_years' => 'No years available',
    );
}

function wp_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function wp_today()
{
    return strtotime(date('m/d/Y', time()));
}

function wp_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function wp_app()
{
    global $row_get_user;
    return (int) ($row_get_user['id'] ?? 0);
}

function wp_year_group($year)
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

function wp_year_names()
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

function wp_year_name($year)
{
    $year = (int) $year;
    if (function_exists('year_of_study')) {
        $name = trim((string) year_of_study($year));
        if ($name !== '') {
            return $name;
        }
    }
    $names = wp_year_names();
    return isset($names[$year]) ? $names[$year] : ('Year ' . $year);
}

function wp_year_ok($year)
{
    return staff_flag_year('app12_', (int) $year);
}

function wp_can_upload($year)
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    if (!staff_flag('app12access')) {
        return false;
    }
    return wp_year_ok((int) $year);
}

function wp_need_upload_year()
{
    global $WP;
    $year = wp_need_year();
    if (!wp_can_upload($year)) {
        wp_message_page($WP['title'], $WP['upload_invalid'], 'weekplan.php');
    }
    return $year;
}

function wp_assign_years()
{
    $years = array();
    for ($y = 0; $y <= 14; $y++) {
        if (wp_year_ok($y)) {
            $years[] = $y;
        }
    }
    return $years;
}

function wp_preview_init()
{
    if (isset($_SESSION['helalia_wp_preview'])) {
        return;
    }
    $today = wp_today();
    $_SESSION['helalia_wp_preview'] = array(
        'items' => array(
            array(
                'id' => 1,
                'name_eng' => 'Week 6 plan',
                'text_eng' => 'Reading, writing, and science lab.',
                'study_year' => 5,
                'class' => 0,
                'subject' => 0,
                'banner' => 'sample.pdf',
                'emp_id' => 0,
                'app_id' => 0,
                'confirm' => 1,
                'start' => $today,
                'date' => $today,
            ),
        ),
        'next' => 2,
    );
}

function wp_preview_items()
{
    wp_preview_init();
    return $_SESSION['helalia_wp_preview']['items'];
}

function wp_preview_save($items)
{
    $_SESSION['helalia_wp_preview']['items'] = $items;
}

function wp_fetch($sql)
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

function wp_sql($value, $type)
{
    global $database;
    if (function_exists('GetSQLValueString') && !empty($database)) {
        return GetSQLValueString($database, $value, $type);
    }
    if ($type === 'int') {
        return ($value === '' || $value === null) ? 'NULL' : (string) (int) $value;
    }
    if ($value === '' || $value === null) {
        return 'NULL';
    }
    $escaped = isset($database) ? mysqli_real_escape_string($database, (string) $value) : addslashes((string) $value);
    return "'" . $escaped . "'";
}

function wp_upload_dir()
{
    return staff_homework_dir();
}

function wp_banner_url($name)
{
    return staff_homework_url($name);
}

function wp_class_name($id)
{
    if (function_exists('class_name')) {
        $name = trim((string) class_name((int) $id));
        if ($name !== '') {
            return $name;
        }
    }
    return staff_class_label((int) $id);
}

function wp_subject_name($id)
{
    if (function_exists('subject_name')) {
        $name = trim((string) subject_name((int) $id));
        if ($name !== '') {
            return $name;
        }
    }
    return staff_subject_label((int) $id);
}

function wp_insert_row($year, $class, $subject, $name, $text, $banner, $all)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $now = wp_today();
    if (!wp_has_db()) {
        $items = wp_preview_items();
        $id = (int) $_SESSION['helalia_wp_preview']['next'];
        $_SESSION['helalia_wp_preview']['next'] = $id + 1;
        $items[] = array(
            'id' => $id,
            'name_eng' => $name,
            'text_eng' => $text,
            'study_year' => $year,
            'class' => $all ? 0 : $class,
            'subject' => $subject,
            'banner' => $banner,
            'emp_id' => wp_emp(),
            'app_id' => wp_app(),
            'confirm' => $all ? 1 : 0,
            'start' => $now,
            'date' => $now,
        );
        wp_preview_save($items);
        return;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    if ($all) {
        $sql = 'INSERT INTO `weeklyplan` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `confirm`, `app_id`) VALUES ('
            . wp_sql($name, 'text') . ', ' . wp_sql($year, 'int') . ', 0, ' . wp_sql($subject, 'int') . ', '
            . wp_sql($text, 'text') . ', ' . wp_sql($now, 'int') . ', ' . wp_sql($now, 'int') . ', '
            . wp_sql($banner, 'text') . ', ' . wp_sql(wp_emp(), 'int') . ', 1, ' . wp_sql(wp_app(), 'int') . ')';
    } else {
        $sql = 'INSERT INTO `weeklyplan` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `app_id`) VALUES ('
            . wp_sql($name, 'text') . ', ' . wp_sql($year, 'int') . ', ' . wp_sql($class, 'int') . ', ' . wp_sql($subject, 'int') . ', '
            . wp_sql($text, 'text') . ', ' . wp_sql($now, 'int') . ', ' . wp_sql($now, 'int') . ', '
            . wp_sql($banner, 'text') . ', ' . wp_sql(wp_emp(), 'int') . ', ' . wp_sql(wp_app(), 'int') . ')';
    }
    mysqli_query($database, $sql) or die(mysqli_error($database));
}

function wp_delete_row($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return;
    }
    if (!wp_has_db()) {
        $items = array();
        foreach (wp_preview_items() as $row) {
            if ((int) $row['id'] !== $id || (int) $row['emp_id'] !== wp_emp()) {
                $items[] = $row;
            }
        }
        wp_preview_save($items);
        return;
    }
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $emp = wp_emp();
    mysqli_query($database, "DELETE FROM `weeklyplan` WHERE `id` = '{$id}' AND `emp_id` = '{$emp}'");
}

function wp_today_rows($year, $class, $subject, $all)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $start = wp_today();
    $end = $start + 86400;
    $emp = wp_emp();
    if (!wp_has_db()) {
        return array_values(array_filter(wp_preview_items(), function ($row) use ($year, $class, $subject, $all, $start, $end, $emp) {
            if ((int) $row['study_year'] !== $year || (int) $row['emp_id'] !== $emp) {
                return false;
            }
            if ((int) $row['start'] < $start || (int) $row['start'] >= $end) {
                return false;
            }
            if (!$all && ((int) $row['class'] !== $class || (int) $row['subject'] !== $subject)) {
                return false;
            }
            return true;
        }));
    }
    $sql = "SELECT * FROM `weeklyplan` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `start` >= '{$start}' AND `start` < '{$end}'";
    if (!$all) {
        $sql .= " AND `class` = '{$class}' AND `subject` = '{$subject}'";
    }
    $sql .= ' ORDER BY `id` DESC';
    return wp_fetch($sql);
}

function wp_search_rows($year, $class, $subject, $dateTs)
{
    $year = (int) $year;
    $class = (int) $class;
    $subject = (int) $subject;
    $dateTs = (int) $dateTs;
    $emp = wp_emp();
    if (!wp_has_db()) {
        $out = array();
        foreach (wp_preview_items() as $row) {
            if ((int) $row['study_year'] !== $year || (int) $row['emp_id'] !== $emp || (int) $row['start'] !== $dateTs) {
                continue;
            }
            if ($class > 0 && (int) $row['class'] !== $class) {
                continue;
            }
            if ($subject > 0 && (int) $row['subject'] !== $subject) {
                continue;
            }
            $out[] = $row;
        }
        return $out;
    }
    $sql = "SELECT * FROM `weeklyplan` WHERE `study_year` = '{$year}' AND `emp_id` = '{$emp}' AND `start` = '{$dateTs}'";
    if ($class > 0) {
        $sql .= " AND `class` = '{$class}'";
    }
    if ($subject > 0) {
        $sql .= " AND `subject` = '{$subject}'";
    }
    $sql .= ' ORDER BY `id` DESC';
    return wp_fetch($sql);
}

function wp_empty($text = null)
{
    global $WP;
    echo '<div class="empty"><p>' . staff_h($text !== null ? $text : $WP['empty']) . '</p></div>';
}

function wp_message_page($title, $text, $backHref)
{
    global $WP;
    staff_inner($title, $backHref, 'home');
    wp_empty($text);
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($WP['back']) . '</a>';
    staff_inner_end();
    exit;
}

function wp_need_year()
{
    global $WP;
    if (!isset($_GET['year']) || $_GET['year'] === '') {
        wp_message_page($WP['title'], $WP['year_missing'], 'weekplan.php');
    }
    $year = (int) $_GET['year'];
    if (!wp_year_ok($year)) {
        wp_message_page($WP['title'], $WP['year_invalid'], 'weekplan.php');
    }
    return $year;
}

function wp_item_row($row, $opts = array())
{
    global $WP;
    $title = (string) ($row['name_eng'] ?? '');
    $text = (string) ($row['text_eng'] ?? '');
    $file = wp_banner_url($row['banner'] ?? '');
    $id = (int) ($row['id'] ?? 0);
    $showClass = !empty($opts['show_class']);
    $canDelete = !empty($opts['delete_href']) && (int) ($row['confirm'] ?? 1) === 0;

    echo '<div class="row row--hw t-navy" id="wp' . $id . '">';
    echo '<span class="row__ico">' . staff_ico('file') . '</span>';
    echo '<div class="row__body">';
    echo '<p class="row__title"><a href="#" data-hw-text="' . staff_h($text) . '">' . staff_h($title) . '</a></p>';
    if ($showClass && isset($row['class'])) {
        $meta = wp_class_name($row['class']);
        if (!empty($row['subject'])) {
            $meta .= ' · ' . wp_subject_name($row['subject']);
        }
        echo '<p class="hw-who">' . staff_h($meta) . '</p>';
    }
    echo '</div>';
    echo '<div class="hw-acts">';
    if ($file !== '') {
        echo '<a class="hw-act hw-act--quiet" href="' . staff_h($file) . '" target="_blank" rel="noopener" aria-label="' . staff_h($WP['download']) . '">' . staff_ico('download') . '</a>';
    }
    if ($canDelete) {
        echo '<a class="hw-act hw-act--danger" href="' . staff_h($opts['delete_href']) . '" onclick="return confirm(' . htmlspecialchars(json_encode($WP['delete_q']), ENT_QUOTES, 'UTF-8') . ')">' . staff_ico('trash') . '</a>';
    }
    echo '</div></div>';
}

function wp_toast_markup()
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
    })();
    </script>';
}

function wp_handle_upload()
{
    global $WP;
    $year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;

    if (isset($_GET['del'])) {
        if (!wp_can_upload($year)) {
            wp_message_page($WP['title'], $WP['upload_invalid'], 'weekplan.php');
        }
        wp_delete_row((int) $_GET['del']);
        $qs = 'plan-upload.php?year=' . $year;
        if ($all) {
            $qs .= '&all';
        } else {
            $qs .= '&class=' . $class . '&subject=' . $subject;
        }
        header('Location: ' . $qs . '&deleted=1');
        exit;
    }

    if (!isset($_POST['submit'])) {
        return;
    }

    if (!wp_can_upload($year)) {
        wp_message_page($WP['title'], $WP['upload_invalid'], 'weekplan.php');
    }

    $image_name = null;
    include __DIR__ . '/weekplan-up.php';

    $name = isset($_POST['name_eng']) ? trim((string) $_POST['name_eng']) : '';
    $text = isset($_POST['text_eng']) ? trim((string) $_POST['text_eng']) : '';
    $subj = isset($_POST['subject']) ? (int) $_POST['subject'] : $subject;

    wp_insert_row($year, $class, $subj, $name, $text, $image_name, $all);

    $qs = 'plan-upload.php?year=' . $year;
    if ($all) {
        $qs .= '&all';
    } else {
        $qs .= '&class=' . $class . '&subject=' . $subject;
    }
    header('Location: ' . $qs . '&done=1');
    exit;
}

function wp_page_landing()
{
    global $WP, $staffPreview;
    staff_inner($WP['title'], 'emp-view.php', 'home');
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($WP['preview']) . '</p>';
    }

    if (!$staffPreview && !staff_flag('app12access')) {
        wp_empty($WP['no_access']);
        echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($WP['back']) . '</a>';
        staff_inner_end();
        return;
    }

    $years = wp_assign_years();
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($WP['title']) . '</h2></div>';
    staff_lede($WP['choose_year']);
    if (!$years) {
        wp_empty($WP['empty_years']);
        echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($WP['back']) . '</a>';
    } else {
        echo '<div class="rows">';
        foreach ($years as $y) {
            $uploadHref = wp_can_upload($y) ? ('plan-upload.php?all&year=' . $y) : '';
            staff_year_row(
                $y,
                'weekly-search.php?year=' . $y,
                $uploadHref,
                '',
                't-navy'
            );
        }
        echo '</div>';
    }
    staff_inner_end();
}

function wp_page_upload()
{
    global $WP, $staffPreview;
    wp_handle_upload();
    $year = wp_need_upload_year();
    $all = isset($_GET['all']);
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;
    $isAll = $all || $class < 1;

    $back = 'weekplan.php';
    staff_inner($WP['title'], $back, 'home');
    if ($isAll) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h(wp_year_name($year) . ' · ' . $WP['all_classes']) . '</h2></div>';
        $action = 'plan-upload.php?year=' . $year . '&all';
    } else {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h(wp_year_name($year) . ' · ' . wp_class_name($class) . ' · ' . wp_subject_name($subject)) . '</h2></div>';
        $action = 'plan-upload.php?year=' . $year . '&class=' . $class . '&subject=' . $subject;
    }
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($WP['preview']) . '</p>';
    }

    echo '<form class="card hw-form" action="' . staff_h($action) . '" method="post" enctype="multipart/form-data" id="form_upload">';
    echo '<input type="hidden" name="subject" value="0">';
    echo '<label class="field"><span class="field__label">' . staff_h($WP['title_field']) . '</span>';
    echo '<input class="input" id="name_eng" name="name_eng" type="text" required></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($WP['desc_field']) . '</span>';
    echo '<textarea class="input" id="text_eng" name="text_eng"></textarea></label>';
    echo '<label class="hw-file"><span class="field__label">' . staff_h($WP['file_field']) . '</span>';
    // Zay el website control: jpg - png - pdf - doc (PDF/Word awwal 3ashan Android)
    echo '<input id="picture" name="picture" type="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"></label>';
    echo '<p class="tiny">' . staff_h($WP['file_hint']) . '</p>';
    echo '<button class="btn btn--primary" name="submit" type="submit" data-wait="' . staff_h($WP['uploading']) . '">' . staff_h($WP['upload']) . '</button>';
    echo '</form>';

    $rows = wp_today_rows($year, $class, $subject, $isAll);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($WP['today']) . '</h2></div>';
    if (!$rows) {
        wp_empty();
    } else {
        $delBase = $action . '&del=';
        echo '<div class="rows">';
        foreach ($rows as $row) {
            wp_item_row($row, array(
                'show_class' => $isAll,
                'delete_href' => $delBase . (int) $row['id'],
            ));
        }
        echo '</div>';
    }
    wp_toast_markup();
    staff_inner_end();
}

function wp_page_search()
{
    global $WP;
    $year = wp_need_year();
    $class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
    $subject = isset($_GET['subject']) ? (int) $_GET['subject'] : 0;

    staff_inner($WP['search'], 'weekplan.php', 'home');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(wp_year_name($year)) . '</h2></div>';

    $dateVal = isset($_GET['date']) ? (string) $_GET['date'] : '';
    echo '<form class="card hw-form" action="weekly-search.php" method="get">';
    echo '<label class="field"><span class="field__label">' . staff_h($WP['date']) . '</span>';
    echo '<input class="input" id="date" name="date" type="date" required value="' . staff_h($dateVal) . '"></label>';
    echo '<input type="hidden" name="year" value="' . $year . '">';
    if ($class > 0) {
        echo '<input type="hidden" name="class" value="' . $class . '">';
    }
    if ($subject > 0) {
        echo '<input type="hidden" name="subject" value="' . $subject . '">';
    }
    echo '<button class="btn btn--primary" name="search" type="submit">' . staff_h($WP['search']) . '</button>';
    echo '</form>';

    if (isset($_GET['search'])) {
        $dateTs = strtotime($_GET['date']);
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($WP['search_on'] . ': ' . $_GET['date']) . '</h2></div>';
        $rows = wp_search_rows($year, $class, $subject, $dateTs);
        if (!$rows) {
            wp_empty($WP['no_result']);
            echo '<a class="btn btn--primary stu-back" href="weekplan.php">' . staff_h($WP['back']) . '</a>';
        } else {
            echo '<div class="rows">';
            foreach ($rows as $row) {
                wp_item_row($row, array('show_class' => true));
            }
            echo '</div>';
        }
    }
    wp_toast_markup();
    staff_inner_end();
}
