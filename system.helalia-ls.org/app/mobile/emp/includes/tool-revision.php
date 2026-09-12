<?php
require_once dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-tools.php';

$year = isset($_GET['year']) ? staff_int($_GET['year']) : -1;
$class = isset($_GET['class']) ? staff_int($_GET['class']) : 0;
$subject = isset($_GET['subject']) ? staff_int($_GET['subject']) : 0;
$all = isset($_GET['all']);
$view = isset($toolView) ? $toolView : 'home';

if ($view === 'confirm-data') {
    $id = isset($_POST['id']) ? staff_int($_POST['id']) : 0;
    echo staff_revision_confirm($id) ? '1' : '0';
    exit;
}

if ($view === 'add' && isset($_GET['del'])) {
    staff_revision_delete(staff_int($_GET['del']));
    $go = 'revision-step3.php?year=' . $year . ($all ? '&all' : ('&class=' . $class . '&subject=' . $subject)) . '&deleted';
    staff_redirect($go);
}

if ($view === 'add' && isset($_POST['submit'])) {
    staff_revision_save($year, $class, $subject, $all);
    $go = 'revision-step3.php?year=' . $year . ($all ? '&all' : ('&class=' . $class . '&subject=' . $subject)) . '&done';
    staff_redirect($go);
}

if ($view === 'confirm' && isset($_GET['ok'])) {
    staff_revision_confirm(staff_int($_GET['ok']));
    staff_redirect('revision-confirm.php?year=' . $year . '&done');
}

if ($view === 'home') {
    staff_inner($L['revision'], 'emp-view.php');
    if ($staffPreview) {
        echo '<p class="tiny">' . staff_h($L['preview_note']) . '</p>';
    }
    $shown = false;
    if (staff_flag('app15_1access') || staff_flag('app15access')) {
        $rows = array();
        for ($y = 0; $y <= 14; $y++) {
            if (staff_year_has_subject($y)) {
                $rows[] = $y;
            }
        }
        if ($rows) {
            echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['revision_add']) . '</h2></div>';
            staff_lede($L['choose_year']);
            echo '<div class="rows">';
            foreach ($rows as $y) {
                $up = staff_flag('app15_1access') ? ('revision-step3.php?year=' . $y . '&all') : '';
                staff_year_row($y, 'revision-step1.php?year=' . $y, $up, '', 't-gold');
            }
            echo '</div>';
            $shown = true;
        }
    }
    if (staff_flag('app16access')) {
        $rows = array();
        for ($y = 0; $y <= 14; $y++) {
            if (staff_flag_year('app16_', $y)) {
                $rows[] = $y;
            }
        }
        if ($rows) {
            echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['revision_uploaded']) . '</h2></div>';
            echo '<div class="rows">';
            foreach ($rows as $y) {
                staff_simple_row(staff_year_label($y), 'revision-confirm.php?year=' . $y, '', 't-navy', 'check');
            }
            echo '</div>';
            $shown = true;
        }
    }
    if (!$shown) {
        staff_empty($L['empty_years']);
    }
    staff_inner_end();
    exit;
}

if ($view === 'classes') {
    staff_inner($L['revision'], 'revision.php');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year)) . '</h2></div>';
    staff_lede($L['choose_class']);
    $classes = staff_classes_for_year($year, true);
    if (!$classes) {
        staff_empty();
    } else {
        echo '<div class="rows">';
        foreach ($classes as $row) {
            $label = !empty($row['name']) ? $row['name'] : staff_class_label($row['id']);
            staff_simple_row($label, 'revision-step2.php?year=' . $year . '&class=' . (int) $row['id'], staff_year_label($year), 't-gold', 'people');
        }
        echo '</div>';
    }
    staff_inner_end();
    exit;
}

if ($view === 'subjects') {
    staff_inner($L['revision'], 'revision-step1.php?year=' . $year);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year) . ' · ' . staff_class_label($class)) . '</h2></div>';
    staff_lede($L['choose_subject']);
    $subs = staff_subjects_for($year, $class);
    if (!$subs) {
        staff_empty();
    } else {
        echo '<div class="rows">';
        foreach ($subs as $row) {
            $sid = (int) $row['subject'];
            $hrefOpen = 'revision-prev.php?year=' . $year . '&class=' . $class . '&subject=' . $sid;
            $hrefAdd = 'revision-step3.php?year=' . $year . '&class=' . $class . '&subject=' . $sid;
            echo '<div class="row t-gold">';
            echo '<span class="row__ico">' . staff_ico('book') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(staff_subject_label($sid)) . '</p></div>';
            echo '<div class="row__acts">';
            echo '<a class="mini" href="' . staff_h($hrefOpen) . '" title="' . staff_h($L['search']) . '">' . staff_tool_ico('search') . '</a>';
            echo '<a class="mini" href="' . staff_h($hrefAdd) . '" title="' . staff_h($L['upload']) . '">' . staff_tool_ico('upload') . '</a>';
            echo '</div></div>';
        }
        echo '</div>';
    }
    staff_inner_end();
    exit;
}

if ($view === 'add') {
    $back = $all ? 'revision.php' : ('revision-step2.php?year=' . $year . '&class=' . $class);
    $subTitle = $all
        ? (staff_year_label($year) . ' · ' . $L['all_classes'])
        : (staff_year_label($year) . ' · ' . staff_class_label($class) . ' · ' . staff_subject_label($subject));
    staff_inner($L['revision'], $back);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($subTitle) . '</h2></div>';
    staff_notice();
    $action = 'revision-step3.php?year=' . $year . ($all ? '&all' : ('&class=' . $class . '&subject=' . $subject));
    $subs = $all ? staff_subjects_for($year, 0) : array();
    staff_upload_form($action, $subs, $subject, false);
    $items = staff_revision_today($year, $class, $subject, $all);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['today']) . '</h2></div>';
    if (!$items) {
        staff_empty();
    } else {
        foreach ($items as $row) {
            $del = $action . '&del=' . (int) $row['id'];
            staff_item_card($row, array('show_class' => $all, 'show_subject' => $all, 'delete_href' => $del));
        }
    }
    staff_tool_js();
    staff_inner_end();
    exit;
}

if ($view === 'prev') {
    staff_inner($L['revision'], 'revision-step2.php?year=' . $year . '&class=' . $class);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year) . ' · ' . staff_class_label($class) . ' · ' . staff_subject_label($subject)) . '</h2></div>';
    staff_search_form('revision-prev.php', array('year' => $year, 'class' => $class, 'subject' => $subject));
    if (isset($_GET['search'])) {
        $date = isset($_GET['date']) ? strtotime($_GET['date']) : 0;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['search_on'] . ' ' . (isset($_GET['date']) ? $_GET['date'] : '')) . '</h2></div>';
        $items = staff_revision_search($year, $class, $subject, $date);
        if (!$items) {
            staff_empty($L['no_result']);
        } else {
            foreach ($items as $row) {
                staff_item_card($row, array());
            }
        }
    }
    staff_inner_end();
    exit;
}

if ($view === 'confirm') {
    staff_inner($L['revision'], 'revision.php');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year)) . '</h2></div>';
    staff_notice();
    $waiting = staff_revision_list($year, 0);
    $done = staff_revision_list($year, 1);
    if ($waiting) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['waiting']) . '</h2></div>';
        foreach ($waiting as $row) {
            staff_item_card($row, array(
                'show_class' => true,
                'show_subject' => true,
                'confirm_href' => 'revision-confirm.php?year=' . $year . '&ok=' . (int) $row['id'],
            ));
        }
    }
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['uploaded']) . '</h2></div>';
    if (!$done) {
        staff_empty();
    } else {
        foreach ($done as $row) {
            staff_item_card($row, array('show_class' => true, 'show_subject' => true));
        }
    }
    staff_inner_end();
    exit;
}

function staff_revision_save($year, $class, $subject, $all)
{
    global $empId, $row_get_user, $staffPreview;
    $banner = staff_upload_file();
    $title = isset($_POST['name_eng']) ? trim((string) $_POST['name_eng']) : '';
    $text = isset($_POST['text_eng']) ? trim((string) $_POST['text_eng']) : '';
    $subj = isset($_POST['subject']) ? staff_int($_POST['subject']) : $subject;
    $now = staff_today();
    $classes = $all ? staff_teacher_classes_for_subject($year, $subj) : array(array('class' => $class));
    if ($staffPreview) {
        $rows = staff_preview_rows('revision');
        foreach ($classes as $c) {
            $rows[] = array(
                'id' => staff_preview_next(),
                'name_eng' => $title,
                'study_year' => $year,
                'class' => (int) $c['class'],
                'subject' => $subj,
                'text_eng' => $text,
                'start' => $now,
                'date' => $now,
                'banner' => $banner,
                'emp_id' => $empId,
                'confirm' => 1,
                'admin_id' => 0,
            );
        }
        staff_preview_set('revision', $rows);
        return;
    }
    $appId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    foreach ($classes as $c) {
        $cid = (int) $c['class'];
        $sql = 'INSERT INTO `revision` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `app_id`, `confirm`, `confirm_by`, `confirm_by_app_id`, `confirm_date`) VALUES ('
            . staff_sql($title, 'text') . ', ' . staff_sql($year, 'int') . ', ' . staff_sql($cid, 'int') . ', ' . staff_sql($subj, 'int') . ', '
            . staff_sql($text, 'text') . ', ' . staff_sql($now, 'int') . ', ' . staff_sql($now, 'int') . ', ' . staff_sql($banner, 'text') . ', '
            . staff_sql($empId, 'int') . ', ' . staff_sql($appId, 'int') . ', 1, ' . staff_sql($empId, 'int') . ', ' . staff_sql($appId, 'int') . ', ' . staff_sql(time(), 'int') . ')';
        staff_exec($sql);
    }
}

function staff_revision_delete($id)
{
    global $empId, $staffPreview;
    if ($id < 1) {
        return;
    }
    if ($staffPreview) {
        $rows = staff_filter_rows(staff_preview_rows('revision'), function ($row) use ($id) {
            return (int) $row['id'] !== $id;
        });
        staff_preview_set('revision', $rows);
        return;
    }
    staff_exec('DELETE FROM `revision` WHERE `id` = ' . staff_sql($id, 'int') . ' AND `emp_id` = ' . staff_sql($empId, 'int'));
}

function staff_revision_confirm($id)
{
    global $empId, $row_get_user, $staffPreview;
    if ($id < 1) {
        return false;
    }
    if ($staffPreview) {
        $rows = staff_preview_rows('revision');
        foreach ($rows as &$row) {
            if ((int) $row['id'] === $id) {
                $row['confirm'] = 1;
            }
        }
        unset($row);
        staff_preview_set('revision', $rows);
        return true;
    }
    $appId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    return (bool) staff_exec(
        'UPDATE `revision` SET `confirm`=1, `confirm_by`=' . staff_sql($empId, 'int')
        . ', `confirm_by_app_id`=' . staff_sql($appId, 'int')
        . ', `confirm_date`=' . staff_sql(time(), 'int')
        . ' WHERE `id`=' . staff_sql($id, 'int') . ' AND `confirm`=0'
    );
}

function staff_revision_today($year, $class, $subject, $all)
{
    global $empId, $staffPreview;
    $start = staff_today();
    $end = $start + 86400;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('revision'), function ($row) use ($year, $class, $subject, $all, $start, $end, $empId) {
            if ((int) $row['study_year'] !== $year || (int) $row['emp_id'] !== (int) $empId) {
                return false;
            }
            if ((int) $row['start'] < $start || (int) $row['start'] >= $end) {
                return false;
            }
            if (!$all && ((int) $row['class'] !== $class || (int) $row['subject'] !== $subject)) {
                return false;
            }
            return true;
        });
    }
    $sql = "SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `emp_id` = '{$empId}' AND `start` >= '{$start}' AND `start` < '{$end}'";
    if (!$all) {
        $sql .= " AND `class` = '{$class}' AND `subject` = '{$subject}'";
    }
    return staff_q($sql);
}

function staff_revision_search($year, $class, $subject, $date)
{
    global $empId, $staffPreview;
    $date = (int) $date;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('revision'), function ($row) use ($year, $class, $subject, $date, $empId) {
            return (int) $row['study_year'] === $year
                && (int) $row['class'] === $class
                && (int) $row['subject'] === $subject
                && (int) $row['emp_id'] === (int) $empId
                && (int) $row['start'] === $date;
        });
    }
    return staff_q("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$empId}' AND `subject` = '{$subject}' AND `start` = '{$date}'");
}

function staff_revision_list($year, $confirm)
{
    global $staffPreview;
    $confirm = (int) $confirm;
    if ($staffPreview) {
        $rows = staff_filter_rows(staff_preview_rows('revision'), function ($row) use ($year, $confirm) {
            return (int) $row['study_year'] === $year && (int) $row['confirm'] === $confirm;
        });
        usort($rows, function ($a, $b) {
            return (int) $b['date'] - (int) $a['date'];
        });
        return $rows;
    }
    return staff_q("SELECT * FROM `revision` WHERE `study_year` = '{$year}' AND `confirm` = '{$confirm}' ORDER BY `date` DESC");
}
