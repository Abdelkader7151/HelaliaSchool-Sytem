<?php
require_once dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-tools.php';

$view = isset($toolView) ? $toolView : 'home';
$teacherId = isset($_GET['id']) ? staff_int($_GET['id']) : 0;
$code = isset($_GET['q']) ? staff_int($_GET['q']) : 0;

if ($view === 'home' && isset($_POST['start']) && staff_flag('app13_1access')) {
    $tid = staff_int(isset($_POST['teacher']) ? $_POST['teacher'] : 0);
    if ($tid > 0) {
        $open = staff_eval_open($tid);
        if ($open) {
            staff_redirect('evaluation-start.php?id=' . $tid . '&q=' . (int) $open);
        }
        $code = staff_eval_create($tid);
        staff_redirect('evaluation-start.php?id=' . $tid . '&q=' . (int) $code . '&done');
    }
}

if ($view === 'home' && isset($_POST['search'])) {
    $tid = staff_int(isset($_POST['teacher']) ? $_POST['teacher'] : 0);
    if ($tid > 0) {
        staff_redirect('evaluation.php?id=' . $tid);
    }
}

if ($view === 'start' && isset($_POST['save']) && staff_flag('app13_1access')) {
    staff_eval_save($teacherId, $code);
    staff_redirect('evaluation.php?done');
}

$teachers = staff_eval_teachers();

if ($view === 'home') {
    staff_inner($L['evaluation'], 'emp-view.php');
    if ($staffPreview) {
        echo '<p class="tiny">' . staff_h($L['preview_note']) . '</p>';
    }
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['evaluation']) . '</h2></div>';
    staff_lede($L['choose_teacher']);
    staff_notice();
    $canHead = staff_eval_is_head();
    $canStart = staff_flag('app13_1access');
    echo '<form class="card stack" action="evaluation.php" method="post">';
    echo '<label class="field"><span class="field__label">' . staff_h($L['teacher']) . '</span>';
    echo '<select class="input" name="teacher" required><option value="">' . staff_h($L['choose_teacher']) . '</option>';
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
        $sel = ($teacherId === $tid) ? ' selected' : '';
        echo '<option value="' . $tid . '"' . $sel . '>' . staff_h($name) . '</option>';
    }
    echo '</select></label>';
    echo '<div class="tool-btns">';
    if ($canHead) {
        echo '<button class="btn btn--quiet" type="submit" name="search" value="1">' . staff_h($L['find']) . '</button>';
    }
    if ($canStart) {
        echo '<button class="btn btn--primary" type="submit" name="start" value="1">' . staff_h($L['start']) . '</button>';
    }
    echo '</div></form>';

    if ($teacherId > 0) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['eval_for'] . ' ' . staff_emp_label($teacherId)) . '</h2></div>';
        $dates = staff_eval_dates($teacherId);
        if (!$dates) {
            staff_empty();
        } else {
            echo '<div class="rows">';
            foreach ($dates as $row) {
                $q = (int) $row['date'];
                $score = isset($row['score']) ? $row['score'] : 0;
                $total = isset($row['total']) ? $row['total'] : 0;
                $meta = $score . ' / ' . $total;
                staff_simple_row(date('d/m/Y', $q) . ' ' . $L['evaluation'], 'evaluation-start.php?id=' . $teacherId . '&q=' . $q, $meta, 't-green', 'bars');
            }
            echo '</div>';
        }
    }
    staff_inner_end();
    exit;
}

if ($view === 'start') {
    $rows = staff_eval_questions($teacherId, $code);
    $name = staff_emp_label($teacherId);
    $evalBy = '';
    if ($rows && !empty($rows[0]['evaluator_id'])) {
        $evalBy = staff_emp_label($rows[0]['evaluator_id']);
    }
    staff_inner($L['evaluation'], 'evaluation.php' . ($teacherId ? ('?id=' . $teacherId) : ''));
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['eval_for'] . ' ' . $name) . '</h2></div>';
    if ($evalBy !== '') {
        echo '<p class="lede">' . staff_h($L['by'] . ' ' . $evalBy) . '</p>';
    }
    staff_notice();
    $locked = false;
    foreach ($rows as $row) {
        if (!empty($row['score'])) {
            $locked = true;
            break;
        }
    }
    echo '<form class="stack" action="evaluation-start.php?id=' . $teacherId . '&q=' . $code . '" method="post">';
    foreach ($rows as $row) {
        $q = ($staffLang === 'arb' && !empty($row['question_arb'])) ? $row['question_arb'] : $row['question_eng'];
        echo '<article class="card stack--sm">';
        echo '<p class="row__title">' . staff_h($q) . '</p>';
        if ($locked || !staff_flag('app13_1access')) {
            $sc = isset($row['score']) ? $row['score'] : '—';
            echo '<p class="lede">' . staff_h($L['score'] . ': ' . $sc) . '</p>';
        } else {
            echo '<label class="field"><span class="field__label">' . staff_h($L['score']) . '</span>';
            echo '<select class="input" name="score_' . (int) $row['id'] . '" required>';
            echo '<option value=""></option>';
            for ($n = 1; $n <= 5; $n++) {
                echo '<option value="' . $n . '">' . $n . '</option>';
            }
            echo '</select></label>';
        }
        echo '</article>';
    }
    if (!$locked && $rows && staff_flag('app13_1access')) {
        echo '<button class="btn btn--primary" type="submit" name="save" value="1">' . staff_h($L['save']) . '</button>';
    }
    echo '</form>';
    staff_inner_end();
    exit;
}

function staff_eval_is_head()
{
    return staff_flag('app13_1_0access') || staff_flag('app13_1_1access') || staff_flag('app13_1_2access')
        || staff_flag('app13_1_3access') || staff_flag('app13_1_4access') || staff_flag('app13_1_5access');
}

function staff_eval_teachers()
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
    if (staff_flag('app13_1access') && !staff_eval_is_head()) {
        $sql = "SELECT `coordinators_teachers`.*, (SELECT `name` FROM `emps` WHERE `emps`.id = `coordinators_teachers`.teacher_id) AS `name` FROM `coordinators_teachers` WHERE `cor_id` = '{$empId}' ORDER BY `name` ASC";
        return staff_q($sql);
    }
    $rows = staff_q("SELECT `coordinators_teachers`.*, (SELECT `name` FROM `emps` WHERE `emps`.id = `coordinators_teachers`.teacher_id) AS `name` FROM `coordinators_teachers` ORDER BY `name` ASC");
    $out = array();
    foreach ($rows as $row) {
        if (staff_eval_teacher_ok($row)) {
            $out[] = $row;
        }
    }
    return $out;
}

function staff_eval_teacher_ok($row)
{
    global $empId;
    if ((int) $row['cor_id'] === (int) $empId) {
        return true;
    }
    $tid = (int) $row['teacher_id'];
    if (!function_exists('check_study_year')) {
        return true;
    }
    $ok = false;
    if (staff_flag('app13_1_0access') && check_study_year($tid, 0) == 1) {
        $ok = true;
    }
    if (staff_flag('app13_1_1access') && (check_study_year($tid, 1) == 1 || check_study_year($tid, 2) == 1)) {
        $ok = true;
    }
    if (staff_flag('app13_1_2access') && (check_study_year($tid, 3) == 1 || check_study_year($tid, 4) == 1 || check_study_year($tid, 5) == 1)) {
        $ok = true;
    }
    if (staff_flag('app13_1_3access') && (check_study_year($tid, 6) == 1 || check_study_year($tid, 7) == 1 || check_study_year($tid, 8) == 1)) {
        $ok = true;
    }
    if (staff_flag('app13_1_4access') && (check_study_year($tid, 9) == 1 || check_study_year($tid, 10) == 1 || check_study_year($tid, 11) == 1)) {
        $ok = true;
    }
    if (staff_flag('app13_1_5access') && (check_study_year($tid, 12) == 1 || check_study_year($tid, 13) == 1 || check_study_year($tid, 14) == 1)) {
        $ok = true;
    }
    return $ok;
}

function staff_eval_open($tid)
{
    global $staffPreview;
    if ($staffPreview) {
        foreach (staff_preview_rows('evaluation_data') as $row) {
            if ((int) $row['emp_id'] === $tid && ($row['score'] === null || $row['score'] === '')) {
                return (int) $row['date'];
            }
        }
        return 0;
    }
    $rows = staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$tid}' AND `score` IS NULL LIMIT 1");
    return $rows ? (int) $rows[0]['date'] : 0;
}

function staff_eval_create($tid)
{
    global $staffPreview;
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
                'emp_id' => $tid,
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
            . staff_sql($q['id'], 'int') . ', ' . staff_sql($q['question_eng'], 'text') . ', ' . staff_sql($q['question_arb'], 'text') . ', '
            . staff_sql($q['total'], 'int') . ', ' . staff_sql($tid, 'int') . ', ' . staff_sql($code, 'int') . ')';
        staff_exec($sql);
    }
    return $code;
}

function staff_eval_questions($tid, $code)
{
    global $staffPreview;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('evaluation_data'), function ($row) use ($tid, $code) {
            return (int) $row['emp_id'] === $tid && (int) $row['date'] === $code;
        });
    }
    return staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$tid}' AND `date` = '{$code}'");
}

function staff_eval_save($tid, $code)
{
    global $empId, $staffPreview;
    $rows = staff_eval_questions($tid, $code);
    if ($staffPreview) {
        $all = staff_preview_rows('evaluation_data');
        foreach ($all as &$row) {
            if ((int) $row['emp_id'] === $tid && (int) $row['date'] === $code) {
                $key = 'score_' . $row['id'];
                if (isset($_POST[$key])) {
                    $row['score'] = staff_int($_POST[$key]);
                    $row['evaluator_id'] = $empId;
                }
            }
        }
        unset($row);
        staff_preview_set('evaluation_data', $all);
        return;
    }
    foreach ($rows as $row) {
        $key = 'score_' . $row['id'];
        $score = isset($_POST[$key]) ? staff_int($_POST[$key]) : 0;
        $sql = 'UPDATE `evaluation_data` SET `score`=' . staff_sql($score, 'int') . ', `evaluator_id`=' . staff_sql($empId, 'int')
            . ' WHERE `emp_id`=' . staff_sql($tid, 'int') . ' AND `id`=' . staff_sql($row['id'], 'int');
        staff_exec($sql);
    }
}

function staff_eval_dates($tid)
{
    global $empId, $staffPreview;
    $rows = $staffPreview
        ? staff_filter_rows(staff_preview_rows('evaluation_data'), function ($row) use ($tid) {
            return (int) $row['emp_id'] === $tid;
        })
        : staff_q("SELECT * FROM `evaluation_data` WHERE `emp_id` = '{$tid}' ORDER BY `date` DESC");
    $groups = array();
    foreach ($rows as $row) {
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
