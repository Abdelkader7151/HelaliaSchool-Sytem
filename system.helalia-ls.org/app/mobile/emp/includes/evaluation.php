<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

require_once dirname(__DIR__) . '/includes/staff-tools.php';

if (!isset($showEval) || (!$staffPreview && !$showEval)) {
    header('Location: emp-view.php');
    exit;
}

if ($staffLang === 'arb') {
    $EV = array(
        'title' => 'التقييم',
        'teacher' => 'المعلم',
        'choose_teacher' => 'اختر المعلم',
        'find' => 'بحث',
        'start' => 'بدء',
        'save' => 'حفظ',
        'score' => 'الدرجة',
        'eval_for' => 'تقييم',
        'by' => 'بواسطة',
        'history' => 'التقييمات السابقة',
        'preview' => 'معاينة محلية — بدون حفظ في قاعدة البيانات',
        'empty' => 'لا توجد تقييمات مكتملة',
        'no_teachers' => 'لا يوجد معلمون متاحون لحسابك',
        'no_access' => 'التقييم غير متاح لهذا الحساب',
        'teacher_invalid' => 'هذا المعلم غير متاح لحسابك',
        'session_missing' => 'لم يتم تحديد جلسة التقييم',
        'questions_missing' => 'لا توجد أسئلة لهذا التقييم',
        'back' => 'رجوع',
        'saving' => 'جاري الحفظ…',
        'starting' => 'جاري البدء…',
    );
} else {
    $EV = array(
        'title' => 'Evaluation',
        'teacher' => 'Teacher',
        'choose_teacher' => 'Choose a teacher',
        'find' => 'Find',
        'start' => 'Start',
        'save' => 'Save',
        'score' => 'Score',
        'eval_for' => 'Evaluation for',
        'by' => 'By',
        'history' => 'Previous evaluations',
        'preview' => 'Local preview — nothing is saved to the database',
        'empty' => 'No completed evaluations yet',
        'no_teachers' => 'No teachers are available for your account',
        'no_access' => 'Evaluation is not available for this account',
        'teacher_invalid' => 'This teacher is not available for your account',
        'session_missing' => 'Evaluation session was not specified',
        'questions_missing' => 'No questions found for this evaluation',
        'back' => 'Back',
        'saving' => 'Saving…',
        'starting' => 'Starting…',
    );
}

function eval_emp()
{
    global $empId, $row_get_user;
    if (!empty($empId)) {
        return (int) $empId;
    }
    return (int) ($row_get_user['emp_id'] ?? 0);
}

function eval_has_db()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return false;
    }
    return isset($database) && ($database instanceof mysqli);
}

function eval_fetch($sql)
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

function eval_is_head()
{
    return staff_flag('app13_1_0access') || staff_flag('app13_1_1access') || staff_flag('app13_1_2access')
        || staff_flag('app13_1_3access') || staff_flag('app13_1_4access') || staff_flag('app13_1_5access');
}

function eval_can_start()
{
    global $staffPreview;
    if ($staffPreview) {
        return true;
    }
    return staff_flag('app13_1access');
}

function eval_can_find()
{
    return eval_is_head();
}

function eval_teacher_ok($row)
{
    global $empId;
    if ((int) $row['cor_id'] === (int) $empId) {
        return true;
    }
    $tid = (int) $row['teacher_id'];
    if (!function_exists('check_study_year')) {
        return true;
    }
    if (staff_flag('app13_1_0access') && check_study_year($tid, 0) == 1) {
        return true;
    }
    if (staff_flag('app13_1_1access') && (check_study_year($tid, 1) == 1 || check_study_year($tid, 2) == 1)) {
        return true;
    }
    if (staff_flag('app13_1_2access') && (check_study_year($tid, 3) == 1 || check_study_year($tid, 4) == 1 || check_study_year($tid, 5) == 1)) {
        return true;
    }
    if (staff_flag('app13_1_3access') && (check_study_year($tid, 6) == 1 || check_study_year($tid, 7) == 1 || check_study_year($tid, 8) == 1)) {
        return true;
    }
    if (staff_flag('app13_1_4access') && (check_study_year($tid, 9) == 1 || check_study_year($tid, 10) == 1 || check_study_year($tid, 11) == 1)) {
        return true;
    }
    if (staff_flag('app13_1_5access') && (check_study_year($tid, 12) == 1 || check_study_year($tid, 13) == 1 || check_study_year($tid, 14) == 1)) {
        return true;
    }
    return false;
}

function eval_teachers()
{
    global $empId, $staffPreview, $staffLang;
    if ($staffPreview) {
        $out = array();
        foreach (staff_preview_rows('eval_teachers') as $row) {
            $row['name'] = ($staffLang === 'arb' && !empty($row['name_arb'])) ? $row['name_arb'] : $row['name'];
            $out[] = $row;
        }
        return $out;
    }
    if (staff_flag('app13_1access') && !eval_is_head()) {
        return staff_q("SELECT `coordinators_teachers`.*, (SELECT `name` FROM `emps` WHERE `emps`.id = `coordinators_teachers`.teacher_id) AS `name` FROM `coordinators_teachers` WHERE `cor_id` = '{$empId}' ORDER BY `name` ASC");
    }
    $rows = staff_q("SELECT `coordinators_teachers`.*, (SELECT `name` FROM `emps` WHERE `emps`.id = `coordinators_teachers`.teacher_id) AS `name` FROM `coordinators_teachers` ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        if (eval_teacher_ok($row)) {
            $out[] = $row;
        }
    }
    return $out;
}

function eval_teacher_allowed($teacherId)
{
    $teacherId = (int) $teacherId;
    foreach (eval_teachers() as $row) {
        if ((int) $row['teacher_id'] === $teacherId) {
            return true;
        }
    }
    return false;
}

function eval_open_session($teacherId)
{
    global $staffPreview;
    $teacherId = (int) $teacherId;
    if ($staffPreview) {
        foreach (staff_preview_rows('evaluation_data') as $row) {
            if ((int) $row['emp_id'] === $teacherId && ($row['score'] === null || $row['score'] === '')) {
                return (int) $row['date'];
            }
        }
        return 0;
    }
    $rows = staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$teacherId}' AND `score` IS NULL LIMIT 1");
    return $rows ? (int) $rows[0]['date'] : 0;
}

function eval_create_session($teacherId)
{
    global $staffPreview;
    $teacherId = (int) $teacherId;
    $code = time();
    if ($staffPreview) {
        $rows = staff_preview_rows('evaluation_data');
        foreach (staff_preview_rows('evaluation_q') as $q) {
            $rows[] = array(
                'id' => staff_preview_next(),
                'question_id' => $q['id'],
                'question_eng' => $q['question_eng'],
                'question_arb' => $q['question_arb'],
                'total' => $q['total'],
                'emp_id' => $teacherId,
                'date' => $code,
                'score' => null,
                'evaluator_id' => 0,
            );
        }
        staff_preview_set('evaluation_data', $rows);
        return $code;
    }
    $qs = staff_q('SELECT * FROM `evaluation` ORDER BY `id` ASC');
    foreach ($qs as $q) {
        $sql = 'INSERT INTO `evaluation_data` (`question_id`, `question_eng`, `question_arb`, `total`, `emp_id`, `date`) VALUES ('
            . eval_sql($q['id'], 'int') . ', ' . eval_sql($q['question_eng'], 'text') . ', '
            . eval_sql($q['question_arb'], 'text') . ', ' . eval_sql($q['total'], 'int') . ', '
            . eval_sql($teacherId, 'int') . ', ' . eval_sql($code, 'int') . ')';
        staff_exec($sql);
    }
    return $code;
}

function eval_sql($value, $type)
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

function eval_questions($teacherId, $code)
{
    global $staffPreview;
    $teacherId = (int) $teacherId;
    $code = (int) $code;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('evaluation_data'), function ($row) use ($teacherId, $code) {
            return (int) $row['emp_id'] === $teacherId && (int) $row['date'] === $code;
        });
    }
    return staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$teacherId}' AND `date` = '{$code}' ORDER BY `id` ASC");
}

function eval_save_scores($teacherId, $code)
{
    global $empId, $staffPreview;
    $teacherId = (int) $teacherId;
    $code = (int) $code;
    $rows = eval_questions($teacherId, $code);
    if ($staffPreview) {
        $all = staff_preview_rows('evaluation_data');
        foreach ($all as &$row) {
            if ((int) $row['emp_id'] === $teacherId && (int) $row['date'] === $code) {
                $key = 'score_' . $row['id'];
                if (isset($_POST[$key])) {
                    $row['score'] = (int) $_POST[$key];
                    $row['evaluator_id'] = (int) $empId;
                }
            }
        }
        unset($row);
        staff_preview_set('evaluation_data', $all);
        return;
    }
    foreach ($rows as $row) {
        $key = 'score_' . $row['id'];
        $score = isset($_POST[$key]) ? (int) $_POST[$key] : 0;
        $sql = 'UPDATE `evaluation_data` SET `score`=' . eval_sql($score, 'int') . ', `evaluator_id`=' . eval_sql($empId, 'int')
            . ' WHERE `emp_id`=' . eval_sql($teacherId, 'int') . ' AND `id`=' . eval_sql($row['id'], 'int');
        staff_exec($sql);
    }
}

function eval_dates($teacherId)
{
    global $empId, $staffPreview;
    $teacherId = (int) $teacherId;
    $rows = $staffPreview
        ? staff_filter_rows(staff_preview_rows('evaluation_data'), function ($row) use ($teacherId) {
            return (int) $row['emp_id'] === $teacherId;
        })
        : staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$teacherId}' ORDER BY `date` DESC, `id` ASC");
    $groups = array();
    foreach ($rows as $row) {
        if (eval_can_start() && !eval_is_head()) {
            $ev = (int) ($row['evaluator_id'] ?? 0);
            if ($ev > 0 && $ev !== (int) $empId) {
                continue;
            }
        }
        $d = (int) $row['date'];
        if (!isset($groups[$d])) {
            $groups[$d] = array('date' => $d, 'score' => 0, 'total' => 0, 'open' => false);
        }
        $groups[$d]['total'] += 5;
        if ($row['score'] === null || $row['score'] === '') {
            $groups[$d]['open'] = true;
        } else {
            $groups[$d]['score'] += (int) $row['score'];
        }
    }
    $out = array();
    foreach ($groups as $g) {
        if (!$g['open']) {
            $out[] = $g;
        }
    }
    return $out;
}

function eval_question_text($row)
{
    global $staffLang;
    if ($staffLang === 'arb' && !empty($row['question_arb'])) {
        return (string) $row['question_arb'];
    }
    return (string) ($row['question_eng'] ?? '');
}

function eval_empty($text = null)
{
    global $EV;
    echo '<div class="empty"><p>' . staff_h($text !== null ? $text : $EV['empty']) . '</p></div>';
}

function eval_message_page($title, $text, $backHref)
{
    global $EV;
    staff_inner($title, $backHref, 'home');
    eval_empty($text);
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($EV['back']) . '</a>';
    staff_inner_end();
    exit;
}

function eval_handle_home_post()
{
    if (isset($_POST['search']) && eval_can_find()) {
        $tid = isset($_POST['teacher']) ? (int) $_POST['teacher'] : 0;
        if ($tid > 0 && eval_teacher_allowed($tid)) {
            header('Location: evaluation.php?id=' . $tid);
            exit;
        }
        eval_message_page($GLOBALS['EV']['title'], $GLOBALS['EV']['teacher_invalid'], 'evaluation.php');
    }

    if (isset($_POST['start']) && eval_can_start()) {
        $tid = isset($_POST['teacher']) ? (int) $_POST['teacher'] : 0;
        if ($tid < 1 || !eval_teacher_allowed($tid)) {
            eval_message_page($GLOBALS['EV']['title'], $GLOBALS['EV']['teacher_invalid'], 'evaluation.php');
        }
        $open = eval_open_session($tid);
        if ($open) {
            header('Location: evaluation-start.php?id=' . $tid . '&q=' . $open);
            exit;
        }
        $code = eval_create_session($tid);
        header('Location: evaluation-start.php?id=' . $tid . '&q=' . $code);
        exit;
    }
}

function eval_handle_start_post()
{
    if (!isset($_POST['save']) || !eval_can_start()) {
        return;
    }
    $teacherId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $code = isset($_GET['q']) ? (int) $_GET['q'] : 0;
    if ($teacherId < 1 || $code < 1 || !eval_teacher_allowed($teacherId)) {
        eval_message_page($GLOBALS['EV']['title'], $GLOBALS['EV']['teacher_invalid'], 'evaluation.php');
    }
    eval_save_scores($teacherId, $code);
    header('Location: evaluation.php?done=1');
    exit;
}

function eval_page_home()
{
    global $EV, $staffPreview;
    eval_handle_home_post();

    $teacherId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    if ($teacherId > 0 && !eval_teacher_allowed($teacherId)) {
        eval_message_page($EV['title'], $EV['teacher_invalid'], 'evaluation.php');
    }

    staff_inner($EV['title'], 'emp-view.php', 'home');
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($EV['preview']) . '</p>';
    }

    $teachers = eval_teachers();
    $canFind = eval_can_find();
    $canStart = eval_can_start();

    if (!$canFind && !$canStart) {
        eval_empty($EV['no_access']);
        echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($EV['back']) . '</a>';
        staff_inner_end();
        return;
    }

    echo '<div class="sec"><h2 class="sec__title">' . staff_h($EV['title']) . '</h2></div>';
    if (!$teachers) {
        eval_empty($EV['no_teachers']);
        echo '<a class="btn btn--primary stu-back" href="emp-view.php">' . staff_h($EV['back']) . '</a>';
        staff_inner_end();
        return;
    }

    echo '<form class="card hw-form" action="evaluation.php" method="post" id="eval-home-form">';
    echo '<label class="field"><span class="field__label">' . staff_h($EV['teacher']) . '</span>';
    echo '<select class="input" name="teacher" required>';
    echo '<option value="">' . staff_h($EV['choose_teacher']) . '</option>';
    $seen = array();
    foreach ($teachers as $row) {
        $tid = (int) $row['teacher_id'];
        if ($tid < 1 || isset($seen[$tid])) {
            continue;
        }
        $seen[$tid] = 1;
        $name = !empty($row['name']) ? $row['name'] : staff_emp_label($tid);
        if ($name === '') {
            continue;
        }
        echo '<option value="' . $tid . '"' . ($teacherId === $tid ? ' selected' : '') . '>' . staff_h($name) . '</option>';
    }
    echo '</select></label>';
    echo '<div class="tool-btns">';
    if ($canFind) {
        echo '<button class="btn btn--quiet" type="submit" name="search" value="1">' . staff_h($EV['find']) . '</button>';
    }
    if ($canStart) {
        echo '<button class="btn btn--primary" type="submit" name="start" value="1" data-wait="' . staff_h($EV['starting']) . '">' . staff_h($EV['start']) . '</button>';
    }
    echo '</div></form>';

    if ($teacherId > 0) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($EV['eval_for'] . ' ' . staff_emp_label($teacherId)) . '</h2></div>';
        $dates = eval_dates($teacherId);
        if (!$dates) {
            eval_empty();
            echo '<a class="btn btn--primary stu-back" href="evaluation.php">' . staff_h($EV['back']) . '</a>';
        } else {
            echo '<div class="rows">';
            foreach ($dates as $row) {
                $q = (int) $row['date'];
                $meta = (int) $row['score'] . ' / ' . (int) $row['total'];
                echo '<a class="row t-green" href="evaluation-start.php?id=' . $teacherId . '&q=' . $q . '">';
                echo '<span class="row__ico">' . staff_ico('bars') . '</span>';
                echo '<div class="row__body">';
                echo '<p class="row__title">' . staff_h(date('d/m/Y', $q) . ' · ' . $EV['title']) . '</p>';
                echo '<p class="row__meta">' . staff_h($meta) . '</p>';
                echo '</div><span class="row__go">›</span></a>';
            }
            echo '</div>';
        }
    }

    staff_inner_end();
}

function eval_page_start()
{
    global $EV, $staffPreview;
    eval_handle_start_post();

    $teacherId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $code = isset($_GET['q']) ? (int) $_GET['q'] : 0;
    if ($teacherId < 1 || $code < 1) {
        eval_message_page($EV['title'], $EV['session_missing'], 'evaluation.php');
    }
    if (!eval_teacher_allowed($teacherId)) {
        eval_message_page($EV['title'], $EV['teacher_invalid'], 'evaluation.php');
    }

    $rows = eval_questions($teacherId, $code);
    if (!$rows) {
        eval_message_page($EV['title'], $EV['questions_missing'], 'evaluation.php');
    }

    $name = staff_emp_label($teacherId);
    $evalBy = '';
    if (!empty($rows[0]['evaluator_id'])) {
        $evalBy = staff_emp_label($rows[0]['evaluator_id']);
    }

    $locked = false;
    foreach ($rows as $row) {
        if ($row['score'] !== null && $row['score'] !== '') {
            $locked = true;
            break;
        }
    }

    $back = $teacherId > 0 ? ('evaluation.php?id=' . $teacherId) : 'evaluation.php';
    staff_inner($EV['title'], $back, 'home');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($EV['eval_for'] . ' ' . $name) . '</h2></div>';
    if ($evalBy !== '') {
        echo '<p class="hw-sub">' . staff_h($EV['by'] . ' ' . $evalBy) . '</p>';
    }
    if ($staffPreview) {
        echo '<p class="note" style="margin-bottom:14px">' . staff_h($EV['preview']) . '</p>';
    }

    echo '<form class="stack" action="evaluation-start.php?id=' . $teacherId . '&q=' . $code . '" method="post" id="eval-start-form">';
    foreach ($rows as $row) {
        echo '<article class="card hw-form">';
        echo '<p class="row__title">' . staff_h(eval_question_text($row)) . '</p>';
        if ($locked || !eval_can_start()) {
            $sc = ($row['score'] !== null && $row['score'] !== '') ? (int) $row['score'] : '—';
            echo '<p class="row__meta">' . staff_h($EV['score'] . ': ' . $sc) . '</p>';
        } else {
            echo '<label class="field"><span class="field__label">' . staff_h($EV['score']) . '</span>';
            echo '<select class="input" name="score_' . (int) $row['id'] . '" required>';
            echo '<option value=""></option>';
            for ($n = 1; $n <= 5; $n++) {
                echo '<option value="' . $n . '">' . $n . '</option>';
            }
            echo '</select></label>';
        }
        echo '</article>';
    }
    if (!$locked && eval_can_start()) {
        echo '<button class="btn btn--primary" type="submit" name="save" value="1" data-wait="' . staff_h($EV['saving']) . '">' . staff_h($EV['save']) . '</button>';
    }
    echo '</form>';
    staff_inner_end();
}
