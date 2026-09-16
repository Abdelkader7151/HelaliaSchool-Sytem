<?php

if (!defined('STAFF_Q_GREEN_SECONDS')) {
    define('STAFF_Q_GREEN_SECONDS', 14 * 3600);
    define('STAFF_Q_YELLOW_SECONDS', 26 * 3600);
}

function staff_q_boot()
{
    global $L, $showQuestions, $staffLang;

    $extra = ($staffLang === 'arb')
        ? array(
            'q_title' => 'الأسئلة',
            'q_lede' => 'أسئلة أولياء الأمور التي تنتظر ردك',
            'q_empty' => 'لا توجد أسئلة بانتظار الرد',
            'q_denied' => 'ليس لديك صلاحية عرض الأسئلة',
            'q_pending' => 'قيد الانتظار',
            'q_replied' => 'تم الرد',
            'q_status' => 'الحالة',
            'q_date' => 'التاريخ',
            'q_parent' => 'ولي الأمر',
            'q_student' => 'الطالب',
            'q_grade' => 'الصف',
            'q_class' => 'الفصل',
            'q_subject' => 'المادة',
            'q_text' => 'السؤال',
            'q_teacher' => 'المعلم',
            'q_director' => 'المدير',
            'q_respond' => 'وقت الرد',
            'q_reply' => 'الرد',
            'q_reply_by' => 'الرد بواسطة',
            'q_save' => 'حفظ الرد',
            'q_saved' => 'تم حفظ الرد',
            'q_missing' => 'لم يتم العثور على السؤال',
            'q_days' => 'يوم',
            'q_hours' => 'ساعة',
            'q_minutes' => 'دقيقة',
            'q_open' => 'فتح',
            'q_report' => 'تقرير',
            'q_replies' => 'الردود',
            'q_report_title' => 'تقرير سرعة الرد',
            'q_from' => 'من',
            'q_to' => 'إلى',
            'q_run' => 'عرض',
            'q_teacher_replies' => 'ردود المعلم',
            'q_avg' => 'متوسط وقت الرد',
            'q_total' => 'إجمالي الردود',
            'q_flag_green' => 'خلال 14 ساعة',
            'q_flag_yellow' => 'بعد 14 ساعة',
            'q_flag_red' => 'متأخر',
            'q_denied_view' => 'لا يمكنك عرض هذا السؤال',
            'q_load_more' => 'عرض المزيد',
        )
        : array(
            'q_title' => 'Questions',
            'q_lede' => 'Parent questions waiting for a reply',
            'q_empty' => 'No questions waiting for a reply',
            'q_denied' => 'You do not have access to questions',
            'q_pending' => 'Pending',
            'q_replied' => 'Replied',
            'q_status' => 'Status',
            'q_date' => 'Date',
            'q_parent' => 'Parent',
            'q_student' => 'Student',
            'q_grade' => 'Grade',
            'q_class' => 'Class',
            'q_subject' => 'Subject',
            'q_text' => 'Question',
            'q_teacher' => 'Teacher',
            'q_director' => 'Director',
            'q_respond' => 'Respond time',
            'q_reply' => 'Reply',
            'q_reply_by' => 'Reply by',
            'q_save' => 'Save reply',
            'q_saved' => 'Reply saved',
            'q_missing' => 'Question not found',
            'q_days' => 'Days',
            'q_hours' => 'Hours',
            'q_minutes' => 'Minutes',
            'q_open' => 'Open',
            'q_report' => 'Report',
            'q_replies' => 'Replies',
            'q_report_title' => 'Reply speed report',
            'q_from' => 'From',
            'q_to' => 'To',
            'q_run' => 'Show',
            'q_teacher_replies' => 'Teacher replies',
            'q_avg' => 'Average reply time',
            'q_total' => 'Total replies',
            'q_flag_green' => 'Within 14 hours',
            'q_flag_yellow' => 'After 14 hours',
            'q_flag_red' => 'Overdue',
            'q_denied_view' => 'You cannot view this question',
            'q_load_more' => 'Load more',
        );
    $L = array_merge($L, $extra);
    staff_q_handle_chunk_request();
}

function staff_q_page_size()
{
    return 6;
}

function staff_q_chunk_json($html, $hasMore)
{
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array(
        'html' => $html,
        'has_more' => (bool) $hasMore,
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

function staff_q_handle_chunk_request()
{
    global $staffLang;
    if (!isset($_GET['q_chunk'])) {
        return;
    }
    $variant = (isset($_GET['q_chunk']) && $_GET['q_chunk'] === 'replied') ? 'replied' : 'pending';
    if ($variant === 'replied') {
        if (!staff_q_can_replies()) {
            staff_q_chunk_json('', false);
        }
    } elseif (!staff_q_has_menu_access()) {
        staff_q_chunk_json('', false);
    }
    $offset = max(0, staff_q_int('offset'));
    $limit = staff_q_page_size();
    $rows = ($variant === 'replied')
        ? staff_q_list_replied($limit, $offset)
        : staff_q_list($limit, $offset);
    $total = ($variant === 'replied')
        ? staff_q_count_replied()
        : staff_q_count_pending();
    $go = ($staffLang === 'arb') ? '‹' : '›';
    ob_start();
    foreach ($rows as $i => $row) {
        if ($variant === 'replied') {
            staff_q_render_replied_card($row, $go);
        } else {
            staff_q_render_pending_card($row, $offset + $i + 1, $go);
        }
    }
    staff_q_chunk_json(ob_get_clean(), ($offset + count($rows)) < $total);
}

function staff_q_render_load_more($listId, $variant, $nextOffset)
{
    global $L;
    echo '<button class="btn q-load-more" type="button" data-q-load-more data-q-variant="' . staff_h($variant) . '" data-q-offset="' . (int) $nextOffset . '" data-step="' . (int) staff_q_page_size() . '" aria-controls="' . staff_h($listId) . '">';
    echo staff_h($L['q_load_more']);
    echo '</button>';
}

function staff_q_render_pending_card($row, $index, $go)
{
    global $L;
    $subject = isset($row['subject_name']) ? $row['subject_name'] : staff_q_subject_name($row['subject']);
    $kid = isset($row['kid_name']) ? $row['kid_name'] : staff_q_kid_name($row['kid_id']);
    $year = isset($row['year_name']) ? $row['year_name'] : staff_q_year_name($row['study_year']);
    $when = !empty($row['date']) ? date('d/m/Y h:iA', (int) $row['date']) : '';
    $urgency = staff_q_urgency($row['date']);
    $flagLabel = staff_q_urgency_label($urgency);
    echo '<a class="qcard qcard--' . staff_h($urgency) . '" href="view-question.php?id=' . (int) $row['id'] . '">';
    echo '<span class="qcard__num">' . (int) $index . '</span>';
    echo '<span class="qcard__body">';
    echo '<span class="qcard__top"><span class="chip">' . staff_h($subject) . '</span>';
    echo '<span class="qflag qflag--' . staff_h($urgency) . '" title="' . staff_h($flagLabel) . '"></span>';
    echo '<span class="qcard__when">' . staff_h($when) . '</span></span>';
    echo '<strong>' . staff_h($kid) . '</strong>';
    echo '<span class="qcard__meta">' . staff_h($year) . '</span>';
    $preview = staff_q_text_preview(isset($row['text']) ? $row['text'] : '');
    if ($preview !== '') {
        echo '<span class="qcard__text">' . staff_h($preview) . '</span>';
    }
    echo '</span>';
    echo '<span class="qcard__go">' . staff_h($go) . '</span>';
    echo '</a>';
}

function staff_q_render_replied_card($row, $go)
{
    global $L;
    $subject = isset($row['subject_name']) ? $row['subject_name'] : staff_q_subject_name($row['subject']);
    $kid = isset($row['kid_name']) ? $row['kid_name'] : staff_q_kid_name($row['kid_id']);
    $year = isset($row['year_name']) ? $row['year_name'] : staff_q_year_name($row['study_year']);
    $when = !empty($row['date']) ? date('d/m/Y h:iA', (int) $row['date']) : '';
    echo '<a class="qcard qcard--replied" href="view-question.php?id=' . (int) $row['id'] . '">';
    echo '<span class="qcard__body">';
    echo '<span class="qcard__top"><span class="chip chip--ok">' . staff_h($L['q_replied']) . '</span><span class="qcard__when">' . staff_h($when) . '</span></span>';
    echo '<strong>' . staff_h($kid) . '</strong>';
    echo '<span class="qcard__meta">' . staff_h($subject . ' · ' . $year) . '</span>';
    $preview = staff_q_text_preview(isset($row['text']) ? $row['text'] : '');
    if ($preview !== '') {
        echo '<span class="qcard__text">' . staff_h($preview) . '</span>';
    }
    echo '</span>';
    echo '<span class="qcard__go">' . staff_h($go) . '</span>';
    echo '</a>';
}

function staff_q_render_cards($rows, $variant, $offset, $total)
{
    global $staffLang;
    $go = ($staffLang === 'arb') ? '‹' : '›';
    $listId = ($variant === 'replied') ? 'qlist-replied' : 'qlist-pending';
    echo '<div class="qlist" id="' . staff_h($listId) . '">';
    foreach ($rows as $i => $row) {
        if ($variant === 'replied') {
            staff_q_render_replied_card($row, $go);
        } else {
            staff_q_render_pending_card($row, $offset + $i + 1, $go);
        }
    }
    echo '</div>';
    if (($offset + count($rows)) < $total) {
        staff_q_render_load_more($listId, $variant, $offset + count($rows));
    }
}

function staff_q_int($key, $default = 0)
{
    return isset($_GET[$key]) ? (int) $_GET[$key] : $default;
}

function staff_q_year_name($id)
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

function staff_q_subject_name($id)
{
    $id = (int) $id;
    if (function_exists('question_direct')) {
        return trim((string) question_direct($id));
    }
    $map = array(
        10001 => 'Administration',
        10002 => 'Head Of Department',
        10003 => 'Vice Head',
        10004 => 'Secretary',
        10005 => 'Doctor',
        10006 => 'Therapist',
        10007 => 'Supervisor',
        1 => 'English',
        2 => 'Mathematics',
    );
    return isset($map[$id]) ? $map[$id] : ('#' . $id);
}

function staff_q_class_name($id)
{
    if (function_exists('class_name')) {
        return trim((string) class_name($id));
    }
    return $id ? ('Class ' . $id) : '';
}

function staff_q_kid_name($id)
{
    if (function_exists('kid_name')) {
        return trim((string) kid_name($id));
    }
    return '';
}

function staff_q_emp_name($id)
{
    if (function_exists('emp_name')) {
        return trim((string) emp_name($id));
    }
    return '';
}

function staff_q_app_name($id)
{
    if (function_exists('app_name')) {
        return trim((string) app_name($id));
    }
    return '';
}

function staff_q_urgency($date)
{
    $age = time() - (int) $date;
    if ($age < STAFF_Q_GREEN_SECONDS) {
        return 'green';
    }
    if ($age < STAFF_Q_YELLOW_SECONDS) {
        return 'yellow';
    }
    return 'red';
}

function staff_q_urgency_label($level)
{
    global $L;
    if ($level === 'green') {
        return $L['q_flag_green'];
    }
    if ($level === 'yellow') {
        return $L['q_flag_yellow'];
    }
    return $L['q_flag_red'];
}

function staff_q_text_preview($text, $max = 72)
{
    $text = strip_tags((string) $text);
    $lines = preg_split('/\R/u', $text, 2);
    $text = trim(preg_replace('/\s+/u', ' ', $lines[0]));
    if ($text === '') {
        return '';
    }
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text) > $max) {
            return mb_substr($text, 0, $max - 1) . '…';
        }
        return $text;
    }
    if (strlen($text) > $max) {
        return substr($text, 0, $max - 1) . '…';
    }
    return $text;
}

function staff_q_is_staff_account()
{
    global $row_get_user;
    return isset($row_get_user['account_type']) && (int) $row_get_user['account_type'] === 2;
}

function staff_q_has_menu_access()
{
    global $showQuestions;
    return !empty($showQuestions) && staff_q_is_staff_account();
}

function staff_q_can_report()
{
    global $empId;
    return staff_q_is_staff_account()
        && function_exists('app20_8access')
        && app20_8access($empId) > 0;
}

function staff_q_can_replies()
{
    global $showReplyQ;
    return staff_q_is_staff_account()
        && (staff_q_has_menu_access() || !empty($showReplyQ));
}

function staff_q_count()
{
    if (!staff_q_has_menu_access()) {
        return 0;
    }
    return staff_q_count_pending();
}

function staff_q_count_pending()
{
    return count(staff_q_pending_visible_rows());
}

function staff_q_count_replied()
{
    return count(staff_q_replied_visible_rows());
}

function staff_q_pending_visible_rows()
{
    global $staffPreview, $database, $database_database, $empId, $row_get_user;

    if (!staff_q_has_db()) {
        $out = array();
        foreach (staff_q_dummy_rows() as $row) {
            if ((int) $row['status'] === 0 && $row['reply'] === null) {
                $out[] = $row;
            }
        }
        return $out;
    }

    if ((int) $row_get_user['account_type'] !== 2) {
        return array();
    }

    $access = staff_q_access_row($empId);
    mysqli_select_db($database, $database_database);
    $emp = (int) $empId;
    $sql = "SELECT * FROM `ask_teacher` WHERE `reply` IS NULL AND `status` = 0 AND (`teacher_id` IS NULL OR `teacher_id` = '{$emp}') ORDER BY `id` DESC";
    $res = mysqli_query($database, $sql);
    $rows = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }
    return staff_q_filter_rows($rows, $access, $empId);
}

function staff_q_replied_visible_rows()
{
    global $staffPreview, $database, $database_database, $empId, $row_get_user;

    if (!staff_q_has_db()) {
        $out = array();
        foreach (staff_q_dummy_rows() as $row) {
            if ($row['reply'] !== null && $row['reply'] !== '') {
                $out[] = $row;
            }
        }
        return $out;
    }

    if ((int) $row_get_user['account_type'] !== 2) {
        return array();
    }

    $access = staff_q_access_row($empId);
    mysqli_select_db($database, $database_database);
    $sql = "SELECT * FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `teacher_id` > 0 ORDER BY `id` DESC";
    $res = mysqli_query($database, $sql);
    $rows = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }
    return staff_q_filter_rows($rows, $access, $empId);
}

function staff_q_year_band($studyYear)
{
    $y = (int) $studyYear;
    if ($y === 0) {
        return 1;
    }
    if ($y <= 2) {
        return 2;
    }
    if ($y <= 5) {
        return 3;
    }
    if ($y <= 8) {
        return 4;
    }
    if ($y <= 11) {
        return 5;
    }
    return 6;
}

function staff_q_visible($row, $access, $empId)
{
    $ok = 0;
    $subject = (int) $row['subject'];
    $year = (int) $row['study_year'];

    if (function_exists('check_teacher_subject') && $subject < 1000 && (int) check_teacher_subject($subject) === (int) $empId) {
        $ok++;
    }
    // Job Coordinator: yeshof subject questions law howa cor, aw bey3alem el subject
    if ($subject < 1000 && function_exists('staff_job_is_coordinator') && staff_job_is_coordinator($empId)) {
        if (function_exists('staff_teaches_subject') && staff_teaches_subject($empId, $subject)) {
            $ok++;
        }
    }
    if (function_exists('check_head_subject') && $subject < 1000 && (int) check_head_subject($subject) === (int) $empId) {
        $ok++;
    }
    if (!empty($access['app20_1']) && (int) $access['app20_1'] === 1 && $subject === 10001) {
        $ok++;
    }
    if (!empty($access['app20_2']) && (int) $access['app20_2'] === 1 && $subject === 10005) {
        $ok++;
    }

    $band = staff_q_year_band($year);
    $app = '';
    if ($subject === 10004) {
        $app = 'app20_5_' . $band;
    } elseif ($subject === 10002) {
        $app = 'app20_3_' . $band;
    } elseif ($subject === 10003) {
        $app = 'app20_4_' . $band;
    } elseif ($subject === 10006) {
        $app = 'app20_6_' . $band;
    }

    global $database, $staffPreview;
    if ($subject > 1000 && $subject !== 10001 && $subject !== 10005) {
        if ($staffPreview) {
            if ($app !== '' && !empty($access[$app])) {
                $ok++;
            }
        } elseif ($app !== '' && isset($database)) {
            $emp = (int) $empId;
            $sql = "SELECT `id` FROM `emps` WHERE `id`='{$emp}' AND `{$app}` = 1";
            $res = mysqli_query($database, $sql);
            if ($res && mysqli_num_rows($res) > 0) {
                $ok++;
            }
        }
    }

    if ($subject < 1000) {
        $sup = 'app20_7_' . $band;
        if ($staffPreview) {
            if (!empty($access[$sup])) {
                $ok++;
            }
        } elseif (isset($database)) {
            $emp = (int) $empId;
            $sql = "SELECT `id` FROM `emps` WHERE `id`='{$emp}' AND `{$sup}` = 1";
            $res = mysqli_query($database, $sql);
            if ($res && mysqli_num_rows($res) > 0) {
                $ok++;
            }
        }
    }

    return $ok > 0;
}

function staff_q_has_db()
{
    global $staffPreview, $database;
    if ($staffPreview) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function staff_q_preview_store()
{
    if (!isset($_SESSION['staff_q_preview'])) {
        $_SESSION['staff_q_preview'] = array();
    }
    return $_SESSION['staff_q_preview'];
}

function staff_q_dummy_rows()
{
    global $staffLang, $displayName;
    $ar = ($staffLang === 'arb');
    $now = time();
    $rows = array(
        array(
            'id' => 101,
            'user_id' => 9,
            'kid_id' => 11,
            'text' => $ar ? 'متى موعد امتحان اللغة الإنجليزية القادم؟' : 'When is the next English exam?',
            'study_year' => 3,
            'subject' => 1,
            'date' => $now - (3 * 3600),
            'status' => 0,
            'reply' => null,
            'teacher_id' => null,
            'director_id' => null,
            'respond' => 0,
            'class_id' => 1,
            'kid_name' => $ar ? 'سارة أحمد' : 'Sara Ahmed',
            'parent_name' => $ar ? 'أحمد علي' : 'Ahmed Ali',
            'class_name' => 'A',
        ),
        array(
            'id' => 102,
            'user_id' => 10,
            'kid_id' => 12,
            'text' => $ar ? 'نحتاج خطاب غياب للرحلة المدرسية يوم الخميس.' : 'We need an absence letter for Thursday’s school trip.',
            'study_year' => 6,
            'subject' => 10001,
            'date' => $now - (16 * 3600),
            'status' => 0,
            'reply' => null,
            'teacher_id' => null,
            'director_id' => null,
            'respond' => 0,
            'class_id' => 2,
            'kid_name' => $ar ? 'يوسف محمد' : 'Youssef Mohamed',
            'parent_name' => $ar ? 'منى حسن' : 'Mona Hassan',
            'class_name' => 'B',
        ),
        array(
            'id' => 103,
            'user_id' => 11,
            'kid_id' => 13,
            'text' => $ar ? 'هل يمكن متابعة درجات الرياضيات لهذا الشهر؟' : 'Can we follow up on this month’s maths scores?',
            'study_year' => 9,
            'subject' => 10002,
            'date' => $now - (30 * 3600),
            'status' => 0,
            'reply' => null,
            'teacher_id' => null,
            'director_id' => null,
            'respond' => 0,
            'class_id' => 1,
            'kid_name' => $ar ? 'ليان كريم' : 'Layan Karim',
            'parent_name' => $ar ? 'كريم نبيل' : 'Karim Nabil',
            'class_name' => 'A',
        ),
    );

    $saved = staff_q_preview_store();
    $out = array();
    foreach ($rows as $row) {
        $id = (int) $row['id'];
        if (isset($saved[$id])) {
            $row['reply'] = $saved[$id]['reply'];
            $row['status'] = 1;
            $row['teacher_id'] = 0;
            $row['teacher_name'] = $displayName;
            $row['respond'] = $saved[$id]['respond'];
        }
        $out[] = $row;
    }
    return $out;
}

function staff_q_access_row($empId)
{
    global $staffPreview, $database, $database_database;
    if ($staffPreview || !staff_q_has_db()) {
        return array(
            'app20_1' => 1, 'app20_2' => 1,
            'app20_3_1' => 1, 'app20_3_2' => 1, 'app20_3_3' => 1, 'app20_3_4' => 1, 'app20_3_5' => 1, 'app20_3_6' => 1,
            'app20_4_1' => 1, 'app20_4_2' => 1, 'app20_4_3' => 1, 'app20_4_4' => 1, 'app20_4_5' => 1, 'app20_4_6' => 1,
            'app20_5_1' => 1, 'app20_5_2' => 1, 'app20_5_3' => 1, 'app20_5_4' => 1, 'app20_5_5' => 1, 'app20_5_6' => 1,
            'app20_6_1' => 1, 'app20_6_2' => 1, 'app20_6_3' => 1, 'app20_6_4' => 1, 'app20_6_5' => 1, 'app20_6_6' => 1,
            'app20_7_1' => 1, 'app20_7_2' => 1, 'app20_7_3' => 1, 'app20_7_4' => 1, 'app20_7_5' => 1, 'app20_7_6' => 1,
        );
    }
    if (!isset($database)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $emp = (int) $empId;
    $res = mysqli_query($database, "SELECT * FROM `emps` WHERE `id`='{$emp}'");
    $row = $res ? mysqli_fetch_assoc($res) : null;
    return $row ? $row : array();
}

function staff_q_enrich_row($row)
{
    $row['kid_name'] = staff_q_kid_name($row['kid_id']);
    $row['subject_name'] = staff_q_subject_name($row['subject']);
    $row['year_name'] = staff_q_year_name($row['study_year']);
    return $row;
}

function staff_q_filter_rows($rows, $access, $empId)
{
    $out = array();
    foreach ($rows as $row) {
        if (staff_q_visible($row, $access, $empId)) {
            $out[] = staff_q_enrich_row($row);
        }
    }
    return $out;
}

function staff_q_list($limit = null, $offset = 0)
{
    return staff_q_slice_rows(staff_q_pending_visible_rows(), $limit, $offset);
}

function staff_q_list_replied($limit = null, $offset = 0)
{
    return staff_q_slice_rows(staff_q_replied_visible_rows(), $limit, $offset);
}

function staff_q_slice_rows($rows, $limit, $offset)
{
    if ($limit === null) {
        return $rows;
    }
    $offset = max(0, (int) $offset);
    $limit = max(1, (int) $limit);
    return array_slice($rows, $offset, $limit);
}

function staff_q_one($id)
{
    global $staffPreview, $database, $database_database, $empId;

    $id = (int) $id;
    if ($id < 1) {
        return null;
    }

    if (!staff_q_has_db()) {
        foreach (staff_q_dummy_rows() as $row) {
            if ((int) $row['id'] === $id) {
                $row['subject_name'] = staff_q_subject_name($row['subject']);
                $row['year_name'] = staff_q_year_name($row['study_year']);
                return $row;
            }
        }
        return null;
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT * FROM `ask_teacher` WHERE `id` = '{$id}'");
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if (!$row) {
        return null;
    }

    $kid = array();
    $kidRes = mysqli_query($database, "SELECT * FROM `kids` WHERE `id` = '" . (int) $row['kid_id'] . "'");
    if ($kidRes) {
        $kid = mysqli_fetch_assoc($kidRes);
        if (!$kid) {
            $kid = array();
        }
    }
    $access = staff_q_access_row($empId);
    if (!staff_q_visible($row, $access, $empId)) {
        return null;
    }

    $row['kid_name'] = staff_q_kid_name($row['kid_id']);
    $row['parent_name'] = staff_q_app_name($row['user_id']);
    $row['class_id'] = isset($kid['class']) ? $kid['class'] : 0;
    $row['class_name'] = staff_q_class_name(isset($kid['class']) ? $kid['class'] : 0);
    $row['subject_name'] = staff_q_subject_name($row['subject']);
    $row['year_name'] = staff_q_year_name($row['study_year']);
    $row['teacher_name'] = $row['teacher_id'] ? staff_q_emp_name($row['teacher_id']) : '';
    $row['director_name'] = !empty($row['director_id']) ? staff_q_emp_name($row['director_id']) : '';
    $row['kid_row'] = $kid;
    return $row;
}

function staff_q_can_edit($row)
{
    global $empId, $staffPreview;
    if ($staffPreview) {
        return true;
    }
    $hasReply = isset($row['reply']) && $row['reply'] !== null && $row['reply'] !== '';
    $canEdit = function_exists('app20access_edit') && app20access_edit($empId) == 1;
    if ($hasReply && !$canEdit) {
        return false;
    }
    return !$hasReply || $canEdit;
}

function staff_q_save_reply($id, $text)
{
    global $staffPreview, $database, $database_database, $empId, $row_get_user;

    $id = (int) $id;
    $text = trim((string) $text);
    if ($id < 1 || $text === '') {
        return false;
    }

    if (!staff_q_has_db()) {
        if (!isset($_SESSION['staff_q_preview'])) {
            $_SESSION['staff_q_preview'] = array();
        }
        $_SESSION['staff_q_preview'][$id] = array('reply' => $text, 'respond' => time());
        return true;
    }

    $row = staff_q_one($id);
    if (!$row || !staff_q_can_edit($row)) {
        return false;
    }

    mysqli_select_db($database, $database_database);
    if (function_exists('GetSQLValueString')) {
        $sql = sprintf(
            "UPDATE `ask_teacher` SET `teacher_id`=%s, `reply`=%s, `status` = 1, `respond`=%s WHERE `id`=%s",
            GetSQLValueString($database, $empId, 'int'),
            GetSQLValueString($database, $text, 'text'),
            GetSQLValueString($database, time(), 'int'),
            GetSQLValueString($database, $id, 'int')
        );
    } else {
        $sql = "UPDATE `ask_teacher` SET `teacher_id`='" . (int) $empId . "', `reply`='" . mysqli_real_escape_string($database, $text) . "', `status` = 1, `respond`='" . time() . "' WHERE `id`='{$id}'";
    }
    mysqli_query($database, $sql);

    if (function_exists('sendMessage') && function_exists('app_msg_id') && function_exists('kid_name')) {
        sendMessage(
            app_msg_id($row['kid_id']),
            'HLS',
            date('d/m/Y', time()) . ' رد سؤال من ولي امر  ' . kid_name($row['kid_id'])
        );
    }

    return true;
}

function staff_q_duration($from, $to)
{
    global $L;
    $diff = (int) $to - (int) $from;
    if ($diff <= 0) {
        return '';
    }
    $days = floor($diff / 86400);
    $hours = floor(($diff % 86400) / 3600);
    $minutes = floor(($diff % 3600) / 60);
    $parts = array();
    if ($days > 0) {
        $parts[] = $days . ' ' . $L['q_days'];
    }
    if ($hours > 0) {
        $parts[] = $hours . ' ' . $L['q_hours'];
    }
    if ($minutes > 0) {
        $parts[] = $minutes . ' ' . $L['q_minutes'];
    }
    return implode(' ', $parts);
}

function staff_q_handle_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit2'])) {
        return;
    }
    $id = isset($_POST['q_id']) ? (int) $_POST['q_id'] : staff_q_int('id');
    $text = isset($_POST['reply']) ? $_POST['reply'] : '';
    if (staff_q_save_reply($id, $text)) {
        header('Location: questions.php?saved=1');
        exit;
    }
}

function staff_q_message_page($title, $text, $backHref)
{
    global $L;
    staff_inner($title, $backHref, 'home');
    echo '<div class="tool-empty"><p>' . staff_h($text) . '</p></div>';
    $backLabel = isset($L['back']) ? $L['back'] : 'Back';
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($backLabel) . '</a>';
    staff_inner_end();
    exit;
}

function staff_q_render_dock()
{
    global $L;
    $showReport = staff_q_can_report();
    $showReplies = staff_q_can_replies();
    if (!$showReport && !$showReplies) {
        return;
    }
    echo '<div class="q-dock">';
    if ($showReport) {
        echo '<a class="q-dock__btn" href="questions-report.php">';
        echo '<span class="q-dock__ico">' . staff_ico('clipboard') . '</span>';
        echo '<span>' . staff_h($L['q_report']) . '</span></a>';
    }
    if ($showReplies) {
        echo '<a class="q-dock__btn" href="questions-replies.php">';
        echo '<span class="q-dock__ico">' . staff_ico('mail') . '</span>';
        echo '<span>' . staff_h($L['q_replies']) . '</span></a>';
    }
    echo '</div>';
}

function staff_q_render_list()
{
    global $L;

    if (!staff_q_has_menu_access()) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_denied']) . '</p></div>';
        return;
    }

    $offset = 0;
    $limit = staff_q_page_size();
    $total = staff_q_count_pending();
    $rows = staff_q_list($limit, $offset);
    echo '<p class="lede staff-lede">' . staff_h($L['q_lede']) . '</p>';

    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_empty']) . '</p></div>';
        return;
    }

    staff_q_render_cards($rows, 'pending', $offset, $total);
}

function staff_q_render_view()
{
    global $L, $displayName, $empId;

    $id = staff_q_int('id');
    $row = staff_q_one($id);
    if (!$row) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_missing']) . '</p></div>';
        return;
    }

    $status = ((int) $row['status'] === 1 || ($row['reply'] !== null && $row['reply'] !== '')) ? $L['q_replied'] : $L['q_pending'];
    $statusClass = ((int) $row['status'] === 1 || ($row['reply'] !== null && $row['reply'] !== '')) ? 'chip--ok' : 'chip--wait';
    $when = !empty($row['date']) ? date('d/m/Y h:iA', (int) $row['date']) : '';
    $teacherName = isset($row['teacher_name']) ? $row['teacher_name'] : staff_q_emp_name($row['teacher_id']);
    $canEdit = staff_q_can_edit($row);

    echo '<div class="facts">';
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_date']) . '</span><span class="facts__v">' . staff_h($when) . '</span></div>';
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_status']) . '</span><span class="facts__v"><span class="chip ' . $statusClass . '">' . staff_h($status) . '</span></span></div>';
    if (!empty($row['parent_name'])) {
        echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_parent']) . '</span><span class="facts__v">' . staff_h($row['parent_name']) . '</span></div>';
    }
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_student']) . '</span><span class="facts__v">' . staff_h($row['kid_name']) . '</span></div>';
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_grade']) . '</span><span class="facts__v">' . staff_h($row['year_name']) . '</span></div>';
    if (!empty($row['class_name'])) {
        echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_class']) . '</span><span class="facts__v">' . staff_h($row['class_name']) . '</span></div>';
    }
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_subject']) . '</span><span class="facts__v">' . staff_h($row['subject_name']) . '</span></div>';
    echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_text']) . '</span><span class="facts__v">' . nl2br(staff_h($row['text'])) . '</span></div>';
    if (!empty($row['teacher_id']) || !empty($teacherName)) {
        echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_teacher']) . '</span><span class="facts__v">' . staff_h($teacherName) . '</span></div>';
    }
    if (!empty($row['respond'])) {
        $dur = staff_q_duration($row['date'], $row['respond']);
        echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_respond']) . '</span><span class="facts__v">' . staff_h(date('d/m/Y h:iA', (int) $row['respond']));
        if ($dur !== '') {
            echo '<br><span class="kv__hint">' . staff_h($dur) . '</span>';
        }
        echo '</span></div>';
    }
    if (!empty($row['director_id'])) {
        $dirName = isset($row['director_name']) ? $row['director_name'] : staff_q_emp_name($row['director_id']);
        echo '<div class="facts__row"><span class="facts__k">' . staff_h($L['q_director']) . '</span><span class="facts__v">' . staff_h($dirName) . '</span></div>';
    }
    echo '</div>';

    $replyBy = $canEdit ? ($displayName !== '' ? $displayName : staff_q_emp_name($empId)) : $teacherName;
    echo '<form class="form-stack staff-form" method="post" action="view-question.php?id=' . (int) $id . '">';
    echo '<label class="field">';
    echo '<span class="field__label">' . staff_h($L['q_reply_by']) . ' ' . staff_h($replyBy) . '</span>';
    if ($canEdit) {
        echo '<textarea class="input" name="reply" id="reply" required>' . staff_h($row['reply']) . '</textarea>';
        echo '</label>';
        echo '<input type="hidden" name="q_id" value="' . (int) $id . '">';
        echo '<button class="btn btn--primary" type="submit" name="submit2" value="1">' . staff_h($L['q_save']) . '</button>';
    } else {
        echo '<textarea class="input" readonly>' . staff_h($row['reply']) . '</textarea>';
        echo '</label>';
    }
    echo '</form>';
}

function staff_q_render_replied_list()
{
    global $L;
    $offset = 0;
    $limit = staff_q_page_size();
    $total = staff_q_count_replied();
    $rows = staff_q_list_replied($limit, $offset);

    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_empty']) . '</p></div>';
        return;
    }

    staff_q_render_cards($rows, 'replied', $offset, $total);
}

function staff_q_report_range()
{
    if (isset($_GET['from'], $_GET['to']) && $_GET['from'] !== '' && $_GET['to'] !== '') {
        return array(
            'from' => strtotime((string) $_GET['from']),
            'to' => strtotime((string) $_GET['to'] . ' 23:59:59'),
            'from_val' => (string) $_GET['from'],
            'to_val' => (string) $_GET['to'],
        );
    }
    return array(
        'from' => strtotime(date('Y-m-01')),
        'to' => strtotime(date('Y-m-t 23:59:59')),
        'from_val' => date('Y-m-01'),
        'to_val' => date('Y-m-t'),
    );
}

function staff_q_report_rows($from, $to)
{
    global $staffPreview, $database, $database_database;

    if ($staffPreview) {
        return array(
            array('teacher_id' => 0, 'total_replies' => 12, 'teacher_name' => 'Preview Teacher'),
            array('teacher_id' => 1, 'total_replies' => 8, 'teacher_name' => 'Another Teacher'),
        );
    }
    if (!isset($database)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $from = (int) $from;
    $to = (int) $to;
    $sql = "SELECT `teacher_id`, COUNT(*) AS `total_replies`
            FROM `ask_teacher`
            WHERE `reply` IS NOT NULL AND `status` = 1 AND `date` >= '{$from}' AND `date` <= '{$to}'
            GROUP BY `teacher_id`
            ORDER BY `total_replies` DESC";
    $res = mysqli_query($database, $sql);
    $out = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $row['teacher_name'] = staff_q_emp_name($row['teacher_id']);
            $out[] = $row;
        }
    }
    return $out;
}

function staff_q_page_replies()
{
    global $L;
    if (!staff_q_can_replies()) {
        staff_q_message_page($L['q_title'], $L['q_denied'], 'questions.php');
    }
    staff_inner($L['q_replies'], 'questions.php', 'questions');
    staff_q_render_replied_list();
    staff_inner_end('questions');
}

function staff_q_page_report()
{
    global $L;
    if (!staff_q_can_report()) {
        staff_q_message_page($L['q_report_title'], $L['q_denied'], 'questions.php');
    }
    $range = staff_q_report_range();
    staff_inner($L['q_report_title'], 'questions.php', 'questions');
    echo '<form class="card hw-form" method="get" action="questions-report.php">';
    echo '<label class="field"><span class="field__label">' . staff_h($L['q_from']) . '</span>';
    echo '<input class="input" type="date" name="from" required value="' . staff_h($range['from_val']) . '"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['q_to']) . '</span>';
    echo '<input class="input" type="date" name="to" required value="' . staff_h($range['to_val']) . '"></label>';
    echo '<button class="btn btn--primary" type="submit">' . staff_h($L['q_run']) . '</button>';
    echo '</form>';

    $rows = staff_q_report_rows($range['from'], $range['to']);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['q_report_title']) . '</h2></div>';
    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_empty']) . '</p></div>';
    } else {
        echo '<div class="rows">';
        foreach ($rows as $row) {
            $href = 'questions-report-view.php?id=' . (int) $row['teacher_id'] . '&from=' . urlencode($range['from_val']) . '&to=' . urlencode($range['to_val']);
            echo '<a class="row t-navy" href="' . staff_h($href) . '">';
            echo '<span class="row__ico">' . staff_ico('user') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h($row['teacher_name']) . '</p>';
            echo '<p class="row__meta">' . staff_h($L['q_total'] . ': ' . (int) $row['total_replies']) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
        }
        echo '</div>';
    }
    staff_inner_end('questions');
}

function staff_q_page_report_view()
{
    global $L, $database, $database_database, $staffPreview;
    if (!staff_q_can_report()) {
        staff_q_message_page($L['q_report_title'], $L['q_denied'], 'questions.php');
    }
    $teacherId = staff_q_int('id');
    $range = staff_q_report_range();
    $teacherName = staff_q_emp_name($teacherId);
    if ($teacherName === '' && $staffPreview) {
        $teacherName = 'Preview Teacher';
    }

    staff_inner($L['q_teacher_replies'], 'questions-report.php?from=' . urlencode($range['from_val']) . '&to=' . urlencode($range['to_val']), 'home');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($teacherName) . '</h2></div>';
    echo '<p class="lede">' . staff_h(date('d/m/Y', $range['from']) . ' – ' . date('d/m/Y', $range['to'])) . '</p>';

    $avg = '';
    if ($staffPreview) {
        $avg = '2 ' . $L['q_hours'];
        $rows = staff_q_list_replied();
    } else {
        mysqli_select_db($database, $database_database);
        $from = (int) $range['from'];
        $to = (int) $range['to'];
        $tid = (int) $teacherId;
        $rs = mysqli_query($database, "SELECT AVG(`respond` - `date`) AS `avg_response_seconds` FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `respond` > 0 AND `teacher_id` = '{$tid}' AND `date` >= '{$from}' AND `date` <= '{$to}'");
        $avgRow = $rs ? mysqli_fetch_assoc($rs) : null;
        if ($avgRow && $avgRow['avg_response_seconds'] !== null) {
            $avg = staff_q_duration(0, (int) round($avgRow['avg_response_seconds']));
        }
        $sql = "SELECT * FROM `ask_teacher` WHERE `reply` IS NOT NULL AND `status` = 1 AND `teacher_id` = '{$tid}' AND `date` >= '{$from}' AND `date` <= '{$to}' ORDER BY `id` DESC";
        $res = mysqli_query($database, $sql);
        $rows = array();
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $rows[] = staff_q_enrich_row($row);
            }
        }
    }

    if ($avg !== '') {
        echo '<p class="note">' . staff_h($L['q_avg'] . ': ' . $avg) . '</p>';
    }

    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['q_empty']) . '</p></div>';
    } else {
        echo '<div class="qlist">';
        foreach ($rows as $row) {
            $when = !empty($row['date']) ? date('d/m/Y h:iA', (int) $row['date']) : '';
            echo '<a class="qcard qcard--replied" href="view-question.php?id=' . (int) $row['id'] . '">';
            echo '<span class="qcard__body">';
            echo '<span class="qcard__top"><span class="chip">' . staff_h($row['subject_name']) . '</span><span class="qcard__when">' . staff_h($when) . '</span></span>';
            echo '<strong>' . staff_h($row['kid_name']) . '</strong>';
            echo '<span class="qcard__meta">' . staff_h($row['year_name']) . '</span>';
            $preview = staff_q_text_preview(isset($row['text']) ? $row['text'] : '');
            if ($preview !== '') {
                echo '<span class="qcard__text">' . staff_h($preview) . '</span>';
            }
            echo '</span><span class="qcard__go">›</span></a>';
        }
        echo '</div>';
    }
    staff_inner_end();
}
