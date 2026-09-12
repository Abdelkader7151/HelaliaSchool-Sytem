<?php
require_once dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-tools.php';

$year = isset($_GET['year']) ? staff_int($_GET['year']) : -1;
$class = isset($_GET['class']) ? staff_int($_GET['class']) : 0;
$all = isset($_GET['all']);
$view = isset($toolView) ? $toolView : 'home';

if ($view === 'add' && isset($_GET['del'])) {
    staff_memo_delete(staff_int($_GET['del']));
    $go = 'memo-step3.php?year=' . $year . ($all || $class < 1 ? '&all' : ('&class=' . $class)) . '&deleted';
    staff_redirect($go);
}

if ($view === 'add' && isset($_POST['submit'])) {
    staff_memo_save($year, $all ? 0 : $class);
    $go = 'memo-step3.php?year=' . $year . ($all || $class < 1 ? '&all' : ('&class=' . $class)) . '&done';
    staff_redirect($go);
}

if ($view === 'home') {
    staff_inner($L['memo'], 'emp-view.php');
    if ($staffPreview) {
        echo '<p class="tiny">' . staff_h($L['preview_note']) . '</p>';
    }
    $shown = false;
    if (staff_flag('app17_1access') || staff_flag('app17access')) {
        $rows = array();
        for ($y = 0; $y <= 14; $y++) {
            if (staff_flag_year('app18_', $y)) {
                $rows[] = $y;
            }
        }
        if ($rows) {
            echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['memo_add']) . '</h2></div>';
            staff_lede($L['choose_year']);
            echo '<div class="rows">';
            foreach ($rows as $y) {
                staff_year_row($y, 'memo-step1.php?year=' . $y, 'memo-step3.php?year=' . $y . '&all', '', 't-blue');
            }
            echo '</div>';
            $shown = true;
        }
    }
    if (staff_flag('app18access')) {
        $rows = array();
        for ($y = 0; $y <= 14; $y++) {
            if (staff_flag_year('app18_', $y)) {
                $rows[] = $y;
            }
        }
        if ($rows) {
            echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['memo_uploaded']) . '</h2></div>';
            echo '<div class="rows">';
            foreach ($rows as $y) {
                staff_simple_row(staff_year_label($y), 'memo-confirm.php?year=' . $y, '', 't-navy', 'pin');
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
    staff_inner($L['memo'], 'memo.php');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year)) . '</h2></div>';
    staff_lede($L['choose_class']);
    $classes = staff_classes_for_year($year, false);
    if (!$classes) {
        staff_empty();
    } else {
        echo '<div class="rows">';
        foreach ($classes as $row) {
            $label = !empty($row['name']) ? $row['name'] : staff_class_label($row['id']);
            staff_simple_row($label, 'memo-step3.php?year=' . $year . '&class=' . (int) $row['id'], staff_year_label($year), 't-blue', 'people');
        }
        echo '</div>';
    }
    staff_inner_end();
    exit;
}

if ($view === 'add') {
    $isAll = $all || $class < 1;
    $back = $isAll ? 'memo.php' : ('memo-step1.php?year=' . $year);
    $subTitle = $isAll
        ? (staff_year_label($year) . ' · ' . $L['all_classes'])
        : (staff_year_label($year) . ' · ' . staff_class_label($class));
    staff_inner($L['memo'], $back);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($subTitle) . '</h2></div>';
    staff_notice();
    $action = 'memo-step3.php?year=' . $year . ($isAll ? '&all' : ('&class=' . $class));
    staff_upload_form($action, array(), 0, false);
    if (!$isAll) {
        echo '<p><a class="sec__link" href="memo-prev.php?year=' . $year . '&class=' . $class . '">' . staff_h($L['search']) . '</a></p>';
    }
    $items = staff_memo_today($year, $isAll ? 0 : $class, $isAll);
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

if ($view === 'prev') {
    staff_inner($L['memo'], 'memo-step3.php?year=' . $year . '&class=' . $class);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year) . ' · ' . staff_class_label($class)) . '</h2></div>';
    staff_search_form('memo-prev.php', array('year' => $year, 'class' => $class));
    if (isset($_GET['search'])) {
        $date = isset($_GET['date']) ? strtotime($_GET['date']) : 0;
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['search_on'] . ' ' . (isset($_GET['date']) ? $_GET['date'] : '')) . '</h2></div>';
        $items = staff_memo_search($year, $class, $date);
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
    staff_inner($L['memo'], 'memo.php');
    echo '<div class="sec"><h2 class="sec__title">' . staff_h(staff_year_label($year)) . '</h2></div>';
    $items = staff_memo_uploaded($year);
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['uploaded']) . '</h2></div>';
    if (!$items) {
        staff_empty();
    } else {
        foreach ($items as $row) {
            staff_item_card($row, array('show_class' => true));
        }
    }
    staff_inner_end();
    exit;
}

function staff_memo_save($year, $class)
{
    global $empId, $row_get_user, $staffPreview;
    $banner = staff_upload_file();
    $title = isset($_POST['name_eng']) ? trim((string) $_POST['name_eng']) : '';
    $text = isset($_POST['text_eng']) ? trim((string) $_POST['text_eng']) : '';
    $now = staff_today();
    if ($staffPreview) {
        $rows = staff_preview_rows('memos');
        $rows[] = array(
            'id' => staff_preview_next(),
            'name_eng' => $title,
            'study_year' => $year,
            'class' => (int) $class,
            'subject' => 0,
            'text_eng' => $text,
            'date' => $now,
            'banner' => $banner,
            'emp_id' => $empId,
            'admin_id' => 0,
        );
        staff_preview_set('memos', $rows);
        return;
    }
    $appId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    $sql = 'INSERT INTO `memos` (`name_eng`, `study_year`, `class`, `text_eng`, `date`, `banner`, `emp_id`, `app_id`) VALUES ('
        . staff_sql($title, 'text') . ', ' . staff_sql($year, 'int') . ', ' . staff_sql($class, 'int') . ', '
        . staff_sql($text, 'text') . ', ' . staff_sql($now, 'int') . ', ' . staff_sql($banner, 'text') . ', '
        . staff_sql($empId, 'int') . ', ' . staff_sql($appId, 'int') . ')';
    staff_exec($sql);
}

function staff_memo_delete($id)
{
    global $empId, $staffPreview;
    if ($id < 1) {
        return;
    }
    if ($staffPreview) {
        staff_preview_set('memos', staff_filter_rows(staff_preview_rows('memos'), function ($row) use ($id) {
            return (int) $row['id'] !== $id;
        }));
        return;
    }
    staff_exec('DELETE FROM `memos` WHERE `id` = ' . staff_sql($id, 'int') . ' AND `emp_id` = ' . staff_sql($empId, 'int'));
}

function staff_memo_today($year, $class, $all)
{
    global $empId, $staffPreview;
    $start = staff_today();
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('memos'), function ($row) use ($year, $class, $all, $start, $empId) {
            if ((int) $row['emp_id'] !== (int) $empId || (int) $row['date'] < $start) {
                return false;
            }
            if ((int) $row['study_year'] !== $year && (int) $row['study_year'] !== 300) {
                return false;
            }
            if (!$all && (int) $row['class'] !== $class) {
                return false;
            }
            return true;
        });
    }
    $sql = "SELECT * FROM `memos` WHERE (`study_year` = '{$year}' OR `study_year` = 300) AND `emp_id` = '{$empId}' AND `date` >= '{$start}'";
    if (!$all) {
        $sql .= " AND `class` = '{$class}'";
    }
    return staff_q($sql);
}

function staff_memo_search($year, $class, $date)
{
    global $empId, $staffPreview;
    $date = (int) $date;
    if ($staffPreview) {
        return staff_filter_rows(staff_preview_rows('memos'), function ($row) use ($year, $class, $date, $empId) {
            return (int) $row['study_year'] === $year
                && (int) $row['class'] === $class
                && (int) $row['emp_id'] === (int) $empId
                && (int) $row['date'] === $date;
        });
    }
    $rows = staff_q("SELECT * FROM `memos` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$empId}' AND `date` = '{$date}'");
    if (!$rows) {
        $rows = staff_q("SELECT * FROM `memo` WHERE `study_year` = '{$year}' AND `class` = '{$class}' AND `emp_id` = '{$empId}' AND `date` = '{$date}'");
    }
    return $rows;
}

function staff_memo_uploaded($year)
{
    global $staffPreview;
    if ($staffPreview) {
        $rows = staff_filter_rows(staff_preview_rows('memos'), function ($row) use ($year) {
            return (int) $row['study_year'] === $year || (int) $row['study_year'] === 300;
        });
        usort($rows, function ($a, $b) {
            return (int) $b['date'] - (int) $a['date'];
        });
        return $rows;
    }
    return staff_q("SELECT * FROM `memos` WHERE (`study_year` = '{$year}' OR `study_year` = 300) ORDER BY `date` DESC");
}
