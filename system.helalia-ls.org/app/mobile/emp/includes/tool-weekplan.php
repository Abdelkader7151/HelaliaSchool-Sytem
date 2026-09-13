<?php
require_once dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-tools.php';

$year = isset($_GET['year']) ? staff_int($_GET['year']) : -1;
$class = isset($_GET['class']) ? staff_int($_GET['class']) : 0;
$subject = isset($_GET['subject']) ? staff_int($_GET['subject']) : 0;
$all = isset($_GET['all']);
$view = isset($toolView) ? $toolView : 'home';

if ($view === 'upload' && isset($_GET['del'])) {
    staff_plan_delete(staff_int($_GET['del']));
    $go = 'plan-upload.php?year=' . $year . ($all ? '&all' : ('&class=' . $class . '&subject=' . $subject)) . '&deleted';
    staff_redirect($go);
}

if ($view === 'upload' && isset($_POST['submit'])) {
    staff_plan_save($year, $class, $subject, $all);
    $go = 'plan-upload.php?year=' . $year . ($all ? '&all' : ('&class=' . $class . '&subject=' . $subject)) . '&done';
    staff_redirect($go);
}

if ($view === 'home') {
    staff_inner($L['plan'], 'emp-view.php');
    if ($staffPreview) {
        echo '<p class="tiny">' . staff_h($L['preview_note']) . '</p>';
    }
    if (!staff_flag('app12access')) {
        staff_empty($L['empty_years']);
        staff_inner_end();
        exit;
    }
    $rows = array();
    for ($y = 0; $y <= 14; $y++) {
        if (staff_flag_year('app12_', $y)) {
            $rows[] = $y;
        }
    }
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['plan']) . '</h2></div>';
    staff_lede($L['choose_year']);
    if (!$rows) {
        staff_empty($L['empty_years']);
    } else {
        echo '<div class="rows">';
        foreach ($rows as $y) {
            $uploadHref = staff_flag('app12access') && staff_flag_year('app12_', $y)
                ? ('plan-upload.php?all&year=' . $y)
                : '';
            staff_year_row($y, 'weekly-search.php?year=' . $y, $uploadHref, '', 't-navy');
        }
        echo '</div>';
    }
    staff_inner_end();
    exit;
}

if ($view === 'upload') {
    $isAll = $all || $class < 1;
    staff_inner($L['plan'], 'weekplan.php');
    $subTitle = $isAll
        ? (staff_year_label($year) . ' · ' . $L['all_classes'])
        : (staff_year_label($year) . ' · ' . staff_class_label($class) . ($subject ? (' · ' . staff_subject_label($subject)) : ''));
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($subTitle) . '</h2></div>';
    staff_notice();
    $action = 'plan-upload.php?year=' . $year . ($isAll ? '&all' : ('&class=' . $class . '&subject=' . $subject));
    staff_upload_form($action, array(), 0, true, $L['plan_file']);
    $items = staff_plan_today($year, $class, $subject, $isAll);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['today']) . '</h2></div>';
    if (!$items) {
        staff_empty();
    } else {
        foreach ($items as $row) {
            staff_item_card($row, array('show_class' => $isAll, 'delete_href' => $action . '&del=' . (int) $row['id']));
        }
    }
    staff_tool_js();
    staff_inner_end();
    exit;
}

if ($view === 'search') {
    staff_inner($L['plan'], 'weekplan.php');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year)) . '</h2></div>';
    $hidden = array('year' => $year);
    if ($class > 0) {
        $hidden['class'] = $class;
    }
    if ($subject > 0) {
        $hidden['subject'] = $subject;
    }
    staff_search_form('weekly-search.php', $hidden);
    if (isset($_GET['search'])) {
        $date = isset($_GET['date']) ? strtotime($_GET['date']) : 0;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['search_on'] . ' ' . (isset($_GET['date']) ? $_GET['date'] : '')) . '</h2></div>';
        $items = staff_plan_search($year, $class, $subject, $date);
        if (!$items) {
            staff_empty($L['no_result']);
        } else {
            foreach ($items as $row) {
                staff_item_card($row, array('show_class' => true, 'show_subject' => true));
            }
        }
    }
    staff_inner_end();
    exit;
}

function staff_plan_save($year, $class, $subject, $all)
{
    global $empId, $row_get_user, $staffPreview;
    $banner = staff_upload_file();
    $title = isset($_POST['name_eng']) ? trim((string) $_POST['name_eng']) : '';
    $text = isset($_POST['text_eng']) ? trim((string) $_POST['text_eng']) : '';
    $subj = isset($_POST['subject']) ? staff_int($_POST['subject']) : $subject;
    $now = staff_today();
    $cid = $all ? 0 : $class;
    if ($staffPreview) {
        $rows = staff_preview_rows('weeklyplan');
        $rows[] = array(
            'id' => staff_preview_next(),
            'name_eng' => $title,
            'study_year' => $year,
            'class' => $cid,
            'subject' => $subj,
            'text_eng' => $text,
            'start' => $now,
            'date' => $now,
            'banner' => $banner,
            'emp_id' => $empId,
            'confirm' => 1,
        );
        staff_preview_set('weeklyplan', $rows);
        return;
    }
    $appId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    if ($all) {
        $sql = 'INSERT INTO `weeklyplan` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `confirm`, `app_id`) VALUES ('
            . staff_sql($title, 'text') . ', ' . staff_sql($year, 'int') . ', 0, ' . staff_sql($subj, 'int') . ', '
            . staff_sql($text, 'text') . ', ' . staff_sql($now, 'int') . ', ' . staff_sql($now, 'int') . ', '
            . staff_sql($banner, 'text') . ', ' . staff_sql($empId, 'int') . ', 1, ' . staff_sql($appId, 'int') . ')';
    } else {
        $sql = 'INSERT INTO `weeklyplan` (`name_eng`, `study_year`, `class`, `subject`, `text_eng`, `start`, `date`, `banner`, `emp_id`, `app_id`) VALUES ('
            . staff_sql($title, 'text') . ', ' . staff_sql($year, 'int') . ', ' . staff_sql($class, 'int') . ', ' . staff_sql($subj, 'int') . ', '
            . staff_sql($text, 'text') . ', ' . staff_sql($now, 'int') . ', ' . staff_sql($now, 'int') . ', '
            . staff_sql($banner, 'text') . ', ' . staff_sql($empId, 'int') . ', ' . staff_sql($appId, 'int') . ')';
    }
    staff_exec($sql);
}

function staff_plan_delete($id)
{
    global $empId, $staffPreview;
    if ($id < 1) {
        return;
    }
    if ($staffPreview) {
        staff_preview_set('weeklyplan', staff_filter_rows(staff_preview_rows('weeklyplan'), function ($row) use ($id) {
            return (int) $row['id'] !== $id;
        }));
        return;
    }
    staff_exec('DELETE FROM `weeklyplan` WHERE `id` = ' . staff_sql($id, 'int') . ' AND `emp_id` = ' . staff_sql($empId, 'int'));
}

function staff_plan_today($year, $class, $subject, $all)
{
    global $empId, $staffPreview;
    $start = staff_today();
    $end = $start + 86400;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('weeklyplan'), function ($row) use ($year, $class, $subject, $all, $start, $end, $empId) {
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
    $sql = "SELECT * FROM `weeklyplan` WHERE `study_year` = '{$year}' AND `emp_id` = '{$empId}' AND `start` >= '{$start}' AND `start` < '{$end}'";
    if (!$all) {
        $sql .= " AND `class` = '{$class}' AND `subject` = '{$subject}'";
    }
    return staff_q($sql);
}

function staff_plan_search($year, $class, $subject, $date)
{
    global $empId, $staffPreview;
    $date = (int) $date;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('weeklyplan'), function ($row) use ($year, $class, $subject, $date, $empId) {
            if ((int) $row['study_year'] !== $year || (int) $row['emp_id'] !== (int) $empId || (int) $row['start'] !== $date) {
                return false;
            }
            if ($class > 0 && (int) $row['class'] !== $class) {
                return false;
            }
            if ($subject > 0 && (int) $row['subject'] !== $subject) {
                return false;
            }
            return true;
        });
    }
    $sql = "SELECT * FROM `weeklyplan` WHERE `study_year` = '{$year}' AND `emp_id` = '{$empId}' AND `start` = '{$date}'";
    if ($class > 0) {
        $sql .= " AND `class` = '{$class}'";
    }
    if ($subject > 0) {
        $sql .= " AND `subject` = '{$subject}'";
    }
    return staff_q($sql);
}
