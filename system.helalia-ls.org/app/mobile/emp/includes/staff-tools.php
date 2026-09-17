<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

$L = array_merge($L, staff_tool_strings());

if ($staffPreview) {
    if (!isset($row_get_user['id'])) {
        $row_get_user['id'] = 1;
    }
    if (!isset($row_get_user['emp_id'])) {
        $row_get_user['emp_id'] = 0;
    }
    if (!isset($row_get_user['account_type'])) {
        $row_get_user['account_type'] = 2;
    }
    staff_preview_boot();
}

function staff_tool_strings()
{
    global $staffLang;
    if ($staffLang === 'arb') {
        return array(
            'choose_year' => 'اختر السنة الدراسية',
            'choose_class' => 'اختر الفصل',
            'choose_subject' => 'اختر المادة',
            'all_classes' => 'كل الفصول',
            'uploaded' => 'المرفوع',
            'waiting' => 'بانتظار التأكيد',
            'upload' => 'رفع',
            'search' => 'بحث',
            'open' => 'فتح',
            'confirm' => 'تأكيد',
            'confirmed' => 'مؤكد',
            'delete' => 'حذف',
            'download' => 'تنزيل',
            'title' => 'العنوان',
            'description' => 'الوصف',
            'file' => 'ملف PDF أو Word أو صورة',
            'date' => 'التاريخ',
            'today' => 'اليوم',
            'no_items' => 'لا توجد عناصر',
            'no_result' => 'لا توجد نتائج',
            'done' => 'تم الحفظ بنجاح',
            'deleted' => 'تم الحذف',
            'subjects' => 'المواد',
            'teacher' => 'المعلم',
            'start' => 'بدء',
            'find' => 'بحث',
            'save' => 'حفظ',
            'score' => 'الدرجة',
            'by' => 'بواسطة',
            'eval_for' => 'تقييم',
            'choose_teacher' => 'اختر المعلم',
            'revision_add' => 'رفع مراجعة',
            'revision_uploaded' => 'المراجعة المرفوعة',
            'memo_add' => 'رفع مذكرة',
            'memo_uploaded' => 'المذكرات المرفوعة',
            'plan_file' => 'PDF أو Word أو صورة (jpg/png)',
            'search_on' => 'بحث بتاريخ',
            'preview_note' => 'عرض تجريبي — بدون قاعدة بيانات',
            'empty_years' => 'لا توجد سنوات متاحة',
            'text_more' => 'التفاصيل',
            'class' => 'الفصل',
            'subject' => 'المادة',
            'required' => 'مطلوب',
        );
    }
    return array(
        'choose_year' => 'Choose a study year',
        'choose_class' => 'Choose a class',
        'choose_subject' => 'Choose a subject',
        'all_classes' => 'All classes',
        'uploaded' => 'Uploaded',
        'waiting' => 'Waiting for confirm',
        'upload' => 'Upload',
        'search' => 'Search',
        'open' => 'Open',
        'confirm' => 'Confirm',
        'confirmed' => 'Confirmed',
        'delete' => 'Delete',
        'download' => 'Download',
        'title' => 'Title',
        'description' => 'Description',
        'file' => 'PDF, Word, or photo',
        'date' => 'Date',
        'today' => 'Today',
        'no_items' => 'Nothing here yet',
        'no_result' => 'No result',
        'done' => 'Saved successfully',
        'deleted' => 'Deleted',
        'subjects' => 'Subjects',
        'teacher' => 'Teacher',
        'start' => 'Start',
        'find' => 'Find',
        'save' => 'Save',
        'score' => 'Score',
        'by' => 'By',
        'eval_for' => 'Evaluation for',
        'choose_teacher' => 'Choose a teacher',
        'revision_add' => 'Revision',
        'revision_uploaded' => 'Revision uploaded',
        'memo_add' => 'Memo',
        'memo_uploaded' => 'Memo uploaded',
        'plan_file' => 'PDF, Word, or photo (jpg/png)',
        'search_on' => 'Search on',
        'preview_note' => 'Preview — no database connected',
        'empty_years' => 'No years available',
        'text_more' => 'Details',
        'class' => 'Class',
        'subject' => 'Subject',
        'required' => 'Required',
    );
}

function staff_tool_ico($name)
{
    $extra = array(
        'upload' => '<path d="M12 16V5M8 9l4-4 4 4"/><path d="M5 19h14"/>',
        'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4 4"/>',
        'trash' => '<path d="M5 7h14M10 7V5h4v2M8 7l1 13h6l1-13"/>',
        'download' => '<path d="M12 5v11M8 12l4 4 4-4"/><path d="M5 19h14"/>',
        'eye' => '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
    );
    if (isset($extra[$name])) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $extra[$name] . '</svg>';
    }
    return staff_ico($name);
}

function staff_year_group($year)
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

function staff_year_label($id)
{
    global $staffLang, $staffPreview;
    $id = (int) $id;
    if (!$staffPreview && function_exists('year_of_study')) {
        return trim((string) year_of_study($id));
    }
    $eng = array(
        0 => 'PreSchool', 1 => 'KG1', 2 => 'KG2', 3 => 'Junior One', 4 => 'Junior Two',
        5 => 'Junior Three', 6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
        12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
    );
    $arb = array(
        0 => 'بري سكول', 1 => 'رياض أطفال 1', 2 => 'رياض أطفال 2', 3 => 'الابتدائي 1', 4 => 'الابتدائي 2',
        5 => 'الابتدائي 3', 6 => 'الابتدائي 4', 7 => 'الابتدائي 5', 8 => 'الابتدائي 6',
        9 => 'الاعدادي 1', 10 => 'الاعدادي 2', 11 => 'الاعدادي 3',
        12 => 'الثانوي 1', 13 => 'الثانوي 2', 14 => 'الثانوي 3',
    );
    $map = ($staffLang === 'arb') ? $arb : $eng;
    return isset($map[$id]) ? $map[$id] : ('Year ' . $id);
}

function staff_flag($fn)
{
    global $empId, $staffPreview;
    if ($staffPreview) {
        return true;
    }
    if (!function_exists($fn)) {
        return false;
    }
    return $fn($empId) == 1;
}

function staff_flag_year($prefix, $year)
{
    return staff_flag($prefix . staff_year_group($year) . 'access');
}

function staff_today()
{
    return strtotime(date('m/d/Y'));
}

function staff_int($v)
{
    return (int) $v;
}

function staff_esc($v)
{
    global $database;
    if (!empty($database)) {
        return mysqli_real_escape_string($database, (string) $v);
    }
    return addslashes((string) $v);
}

if (!function_exists('staff_q')) {
    function staff_q($sql)
    {
        global $database, $database_database, $staffPreview;
        if ($staffPreview || empty($database)) {
            return array();
        }
        if (!empty($database_database)) {
            mysqli_select_db($database, $database_database);
        }
        $res = mysqli_query($database, $sql);
        if (!$res) {
            return array();
        }
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

function staff_exec($sql)
{
    global $database, $database_database, $staffPreview;
    if ($staffPreview || empty($database)) {
        return false;
    }
    if (!empty($database_database)) {
        mysqli_select_db($database, $database_database);
    }
    return mysqli_query($database, $sql);
}

function staff_preview_boot()
{
    if (isset($_SESSION['staff_tools_preview']) && is_array($_SESSION['staff_tools_preview'])) {
        return;
    }
    $today = staff_today();
    $_SESSION['staff_tools_preview'] = array(
        'seq' => 40,
        'revision' => array(
            array(
                'id' => 1, 'name_eng' => 'Unit 3 revision', 'study_year' => 5, 'class' => 51,
                'subject' => 1, 'text_eng' => 'Pages 40–48. Bring the workbook.',
                'start' => $today, 'date' => $today, 'banner' => '', 'emp_id' => 0,
                'confirm' => 0, 'admin_id' => 0,
            ),
            array(
                'id' => 2, 'name_eng' => 'Grammar sheet', 'study_year' => 5, 'class' => 51,
                'subject' => 1, 'text_eng' => 'Past simple worksheet.',
                'start' => $today - 86400, 'date' => $today - 86400, 'banner' => '', 'emp_id' => 0,
                'confirm' => 1, 'admin_id' => 0,
            ),
        ),
        'memos' => array(
            array(
                'id' => 3, 'name_eng' => 'Trip permission', 'study_year' => 5, 'class' => 51,
                'subject' => 0, 'text_eng' => 'Please sign and return tomorrow.',
                'date' => $today, 'banner' => '', 'emp_id' => 0, 'admin_id' => 0,
            ),
        ),
        'weeklyplan' => array(
            array(
                'id' => 4, 'name_eng' => 'Week 6 plan', 'study_year' => 5, 'class' => 0,
                'subject' => 0, 'text_eng' => 'Reading, writing, and science lab.',
                'start' => $today, 'date' => $today, 'banner' => '', 'emp_id' => 0, 'confirm' => 1,
            ),
        ),
        'evaluation_q' => array(
            array('id' => 1, 'question_eng' => 'Classroom management', 'question_arb' => 'إدارة الفصل', 'total' => 5),
            array('id' => 2, 'question_eng' => 'Lesson preparation', 'question_arb' => 'تحضير الدرس', 'total' => 5),
            array('id' => 3, 'question_eng' => 'Student engagement', 'question_arb' => 'مشاركة الطلاب', 'total' => 5),
            array('id' => 4, 'question_eng' => 'Assessment quality', 'question_arb' => 'جودة التقييم', 'total' => 5),
        ),
        'evaluation_data' => array(
            array('id' => 11, 'question_id' => 1, 'question_eng' => 'Classroom management', 'question_arb' => 'إدارة الفصل', 'total' => 5, 'emp_id' => 21, 'date' => $today - 86400 * 7, 'score' => 4, 'evaluator_id' => 0),
            array('id' => 12, 'question_id' => 2, 'question_eng' => 'Lesson preparation', 'question_arb' => 'تحضير الدرس', 'total' => 5, 'emp_id' => 21, 'date' => $today - 86400 * 7, 'score' => 5, 'evaluator_id' => 0),
            array('id' => 13, 'question_id' => 3, 'question_eng' => 'Student engagement', 'question_arb' => 'مشاركة الطلاب', 'total' => 5, 'emp_id' => 21, 'date' => $today - 86400 * 7, 'score' => 4, 'evaluator_id' => 0),
            array('id' => 14, 'question_id' => 4, 'question_eng' => 'Assessment quality', 'question_arb' => 'جودة التقييم', 'total' => 5, 'emp_id' => 21, 'date' => $today - 86400 * 7, 'score' => 3, 'evaluator_id' => 0),
        ),
        'eval_teachers' => array(
            array('teacher_id' => 21, 'cor_id' => 0, 'name' => 'Mona Hassan', 'name_arb' => 'منى حسن', 'years' => array(5)),
            array('teacher_id' => 22, 'cor_id' => 0, 'name' => 'Karim Adel', 'name_arb' => 'كريم عادل', 'years' => array(1, 2)),
            array('teacher_id' => 23, 'cor_id' => 0, 'name' => 'Sara Nabil', 'name_arb' => 'سارة نبيل', 'years' => array(12)),
        ),
    );
}

function staff_preview_next()
{
    $_SESSION['staff_tools_preview']['seq'] = (int) $_SESSION['staff_tools_preview']['seq'] + 1;
    return (int) $_SESSION['staff_tools_preview']['seq'];
}

function staff_preview_rows($key)
{
    staff_preview_boot();
    return isset($_SESSION['staff_tools_preview'][$key]) ? $_SESSION['staff_tools_preview'][$key] : array();
}

function staff_preview_set($key, $rows)
{
    $_SESSION['staff_tools_preview'][$key] = $rows;
}

function staff_class_label($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if ($id < 1) {
        global $L;
        return $L['all_classes'];
    }
    if (!$staffPreview && function_exists('class_name')) {
        $name = trim((string) class_name($id));
        if ($name !== '') {
            return $name;
        }
    }
    $letter = chr(64 + max(1, $id % 10));
    return ($staffLang === 'arb' ? 'فصل ' : 'Class ') . $letter;
}

function staff_subject_label($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if ($id < 1) {
        return '';
    }
    if (!$staffPreview && function_exists('subject_name')) {
        $name = trim((string) subject_name($id));
        if ($staffLang === 'arb') {
            $rows = staff_q("SELECT `name_arb`, `name`, `name_eng` FROM `subjects` WHERE `id` = '{$id}' LIMIT 1");
            if ($rows) {
                foreach (array('name_arb', 'name', 'name_eng') as $col) {
                    if (!empty($rows[0][$col])) {
                        return $rows[0][$col];
                    }
                }
            }
        }
        if ($name !== '') {
            return $name;
        }
    }
    $eng = array(1 => 'English', 2 => 'Math', 3 => 'Science', 4 => 'Arabic');
    $arb = array(1 => 'الإنجليزية', 2 => 'الرياضيات', 3 => 'العلوم', 4 => 'العربية');
    $map = ($staffLang === 'arb') ? $arb : $eng;
    return isset($map[$id]) ? $map[$id] : ('#' . $id);
}

function staff_emp_label($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if (!$staffPreview && function_exists('emp_name')) {
        $name = trim((string) emp_name($id));
        if ($name !== '') {
            return $name;
        }
    }
    foreach (staff_preview_rows('eval_teachers') as $row) {
        if ((int) $row['teacher_id'] === $id) {
            return ($staffLang === 'arb' && !empty($row['name_arb'])) ? $row['name_arb'] : $row['name'];
        }
    }
    return $id > 0 ? ('#' . $id) : '';
}

function staff_classes_for_year($year, $requireSubject = true)
{
    global $empId, $staffPreview;
    $year = (int) $year;
    if ($staffPreview) {
        return array(
            array('id' => $year * 10 + 1, 'name' => 'A'),
            array('id' => $year * 10 + 2, 'name' => 'B'),
        );
    }
    $rows = staff_q("SELECT * FROM `class` WHERE `study_year` = '{$year}' ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        $cid = (int) $row['id'];
        if ($requireSubject && function_exists('check_class_subject') && check_class_subject($empId, $cid) < 1) {
            continue;
        }
        $row['name'] = !empty($row['name']) ? $row['name'] : (isset($row['fn_name']) ? $row['fn_name'] : '');
        $out[] = $row;
    }
    return $out;
}

function staff_subjects_for($year, $class = 0)
{
    global $empId, $staffPreview;
    $year = (int) $year;
    $class = (int) $class;
    if ($staffPreview) {
        return array(
            array('subject' => 1),
            array('subject' => 2),
            array('subject' => 3),
        );
    }
    $sql = "SELECT DISTINCT `subject` FROM `teachers` WHERE `study_year` = '{$year}' AND `emp_id` = '{$empId}'";
    if ($class > 0) {
        $sql .= " AND `class` = '{$class}'";
    }
    return staff_q($sql);
}

function staff_teacher_classes_for_subject($year, $subject)
{
    global $empId, $staffPreview;
    $year = (int) $year;
    $subject = (int) $subject;
    if ($staffPreview) {
        return array(
            array('class' => $year * 10 + 1),
            array('class' => $year * 10 + 2),
        );
    }
    return staff_q("SELECT * FROM `teachers` WHERE `study_year` = '{$year}' AND `subject` = '{$subject}' AND `emp_id` = '{$empId}'");
}

function staff_year_has_subject($year)
{
    global $empId, $staffPreview;
    if ($staffPreview) {
        return true;
    }
    if (function_exists('check_year_subject')) {
        return check_year_subject($empId, (int) $year) > 0;
    }
    return true;
}

function staff_upload_file()
{
    return staff_homework_copy();
}

function staff_banner_url($name)
{
    return staff_homework_url($name);
}

function staff_redirect($path)
{
    header('Location: ' . $path);
    exit;
}

function staff_qs(array $extra = array(), array $drop = array())
{
    $q = $_GET;
    foreach ($drop as $key) {
        unset($q[$key]);
    }
    foreach ($extra as $k => $v) {
        $q[$k] = $v;
    }
    return $q ? ('?' . http_build_query($q)) : '';
}

function staff_notice()
{
}

function staff_empty($text = '')
{
    global $L;
    if ($text === '') {
        $text = $L['no_items'];
    }
    echo '<p class="tool-empty">' . staff_h($text) . '</p>';
}

function staff_lede($text)
{
    echo '<p class="lede">' . staff_h($text) . '</p>';
}

function staff_year_row($year, $openHref, $uploadHref = '', $searchHref = '', $tone = 't-gold')
{
    global $L;
    $year = (int) $year;
    echo '<div class="row ' . $tone . '">';
    echo '<span class="row__ico">' . staff_ico('file') . '</span>';
    echo '<a class="row__body" href="' . staff_h($openHref) . '">';
    echo '<p class="row__title">' . staff_h(staff_year_label($year)) . '</p>';
    echo '</a>';
    echo '<div class="row__acts">';
    if ($searchHref !== '') {
        echo '<a class="mini" href="' . staff_h($searchHref) . '" title="' . staff_h($L['search']) . '">' . staff_tool_ico('search') . '</a>';
    }
    if ($uploadHref !== '') {
        echo '<a class="mini" href="' . staff_h($uploadHref) . '" title="' . staff_h($L['upload']) . '">' . staff_tool_ico('upload') . '</a>';
    }
    echo '<a class="mini mini--go" href="' . staff_h($openHref) . '" title="' . staff_h($L['open']) . '">' . staff_ico('chevron') . '</a>';
    echo '</div></div>';
}

function staff_simple_row($title, $href, $meta = '', $tone = 't-navy', $icon = 'list')
{
    echo '<a class="row ' . $tone . '" href="' . staff_h($href) . '">';
    echo '<span class="row__ico">' . staff_ico($icon) . '</span>';
    echo '<div class="row__body"><p class="row__title">' . staff_h($title) . '</p>';
    if ($meta !== '') {
        echo '<p class="row__meta">' . staff_h($meta) . '</p>';
    }
    echo '</div><span class="row__go">›</span></a>';
}

function staff_item_card($row, $opts)
{
    global $L;
    $title = isset($row['name_eng']) ? $row['name_eng'] : '';
    $text = isset($row['text_eng']) ? $row['text_eng'] : '';
    $date = !empty($row['date']) ? date('d/m/Y', (int) $row['date']) : '';
    $meta = array();
    if (!empty($opts['show_class']) && isset($row['class'])) {
        $meta[] = staff_class_label($row['class']);
    }
    if (!empty($opts['show_subject']) && !empty($row['subject'])) {
        $meta[] = staff_subject_label($row['subject']);
    }
    if ($date !== '') {
        $meta[] = $date;
    }
    echo '<article class="card tool-item">';
    echo '<div class="tool-item__top">';
    echo '<div><p class="row__title">' . staff_h($title) . '</p>';
    if ($meta) {
        echo '<p class="row__meta">' . staff_h(implode(' · ', $meta)) . '</p>';
    }
    echo '</div>';
    echo '<div class="row__acts">';
    $banner = staff_banner_url(isset($row['banner']) ? $row['banner'] : '');
    if ($banner !== '') {
        echo '<a class="mini" href="' . staff_h($banner) . '" target="_blank" rel="noopener">' . staff_tool_ico('download') . '</a>';
    }
    if (!empty($opts['confirm_href'])) {
        echo '<a class="mini mini--ok" href="' . staff_h($opts['confirm_href']) . '" data-confirm="1">' . staff_ico('check') . '</a>';
    }
    if (!empty($opts['delete_href'])) {
        echo '<a class="mini mini--danger" href="' . staff_h($opts['delete_href']) . '" data-del="' . staff_h($L['delete']) . '">' . staff_tool_ico('trash') . '</a>';
    }
    echo '</div></div>';
    if ($text !== '') {
        echo '<p class="tool-item__text">' . nl2br(staff_h($text)) . '</p>';
    }
    echo '</article>';
}

function staff_upload_form($action, $subjects = array(), $fixedSubject = 0, $fileRequired = false, $fileHint = '')
{
    global $L;
    echo '<form class="card stack" action="' . staff_h($action) . '" method="post" enctype="multipart/form-data">';
    if ($subjects) {
        echo '<fieldset class="field"><span class="field__label">' . staff_h($L['subjects']) . '</span>';
        $i = 0;
        foreach ($subjects as $row) {
            $sid = (int) $row['subject'];
            $i++;
            echo '<label class="radio"><input type="radio" name="subject" value="' . $sid . '"' . ($i === 1 ? ' checked' : '') . '> ';
            echo staff_h(staff_subject_label($sid)) . '</label>';
        }
        echo '</fieldset>';
    } elseif ($fixedSubject > 0) {
        echo '<input type="hidden" name="subject" value="' . (int) $fixedSubject . '">';
    } else {
        echo '<input type="hidden" name="subject" value="0">';
    }
    echo '<label class="field"><span class="field__label">' . staff_h($L['title']) . '</span>';
    echo '<input class="input" type="text" name="name_eng" required></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['description']) . '</span>';
    echo '<textarea class="input" name="text_eng"></textarea></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['file']) . '</span>';
    // PDF/Word awwal — mesh image/* awwal (Android beyfata7 photos bas)
    echo '<input class="input" type="file" name="picture" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,application/pdf"' . ($fileRequired ? ' required' : '') . '></label>';
    if ($fileHint !== '') {
        echo '<p class="tiny">' . staff_h($fileHint) . '</p>';
    }
    echo '<button class="btn btn--primary" type="submit" name="submit" value="1">' . staff_h($L['upload']) . '</button>';
    echo '</form>';
}

function staff_search_form($action, $hidden = array())
{
    global $L;
    $date = isset($_GET['date']) ? (string) $_GET['date'] : '';
    echo '<form class="card stack" action="' . staff_h($action) . '" method="get">';
    foreach ($hidden as $k => $v) {
        echo '<input type="hidden" name="' . staff_h($k) . '" value="' . staff_h($v) . '">';
    }
    echo '<label class="field"><span class="field__label">' . staff_h($L['date']) . '</span>';
    echo '<input class="input" type="date" name="date" value="' . staff_h($date) . '" required></label>';
    echo '<button class="btn btn--primary" type="submit" name="search" value="1">' . staff_h($L['search']) . '</button>';
    echo '</form>';
}

function staff_tool_js()
{
    echo '<script>document.querySelectorAll("[data-del]").forEach(function(a){a.addEventListener("click",function(e){if(!confirm(a.getAttribute("data-del")))e.preventDefault();});});</script>';
}

function staff_filter_rows($rows, $fn)
{
    $out = array();
    foreach ($rows as $row) {
        if ($fn($row)) {
            $out[] = $row;
        }
    }
    return $out;
}
