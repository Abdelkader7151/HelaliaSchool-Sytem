<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

if (!svc_can('app5_access') && empty($showStaffExc)) {
    svc_go('emp-view.php');
}

$page = basename($_SERVER['PHP_SELF']);

if ($page === 'staff-excuses-view.php') {
    $id = svc_int('id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        svc_save_excuse($id, (int) $_POST['type']);
        svc_go('staff-excuses.php');
    }
    $row = svc_excuse($id);
    svc_boot($S['view_exc'], 'staff-excuses.php');
    if (!$row) {
        svc_empty();
        staff_inner_end();
        return;
    }
    echo '<form class="stack" method="post" action="staff-excuses-view.php?id=' . $id . '">';
    echo '<p class="field__label">' . staff_h($S['status']) . '</p>';
    echo '<div class="radios">';
    $opts = array(0 => $S['st_pending'], 1 => $S['st_accept'], 2 => $S['st_reject'], 3 => $S['st_cancel']);
    foreach ($opts as $n => $lab) {
        $on = ((int) $row['status'] === $n) ? ' checked' : '';
        echo '<label class="radio"><input type="radio" name="type" value="' . $n . '"' . $on . '><span>' . staff_h($lab) . '</span></label>';
    }
    echo '</div>';
    echo '<div class="svc-facts">';
    echo '<div class="svc-fact"><b>' . staff_h($S['name']) . '</b><span>' . staff_h(svc_emp_name($row['emp_id'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['job']) . '</b><span>' . staff_h(svc_job_name($row['emp_id'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['excuse_date']) . '</b><span>' . staff_h(date('d/m/Y', (int) $row['date'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['excuse_start']) . '</b><span>' . staff_h(date('h:i a', (int) $row['start'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['excuse_end']) . '</b><span>' . staff_h(date('h:i a', (int) $row['end'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['hours']) . '</b><span>' . staff_h($row['hours']) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['desc']) . '</b><span>' . staff_h($row['text']) . '</span></div>';
    echo '</div>';
    echo '<button class="btn btn--primary" name="submit" type="submit">' . staff_h($S['save']) . '</button>';
    echo '</form>';
    staff_inner_end();
    return;
}

svc_boot($S['exc_title']);
$rows = svc_excuses();
if (!$rows) {
    svc_empty();
} else {
    echo '<div class="rows">';
    foreach ($rows as $v) {
        $meta = svc_job_name($v['emp_id']) . ' · ' . date('d/m/Y', (int) $v['date']);
        svc_row('staff-excuses-view.php?id=' . (int) $v['id'], svc_emp_name($v['emp_id']), $meta, null, 't-gold', 'hourglass');
    }
    echo '</div>';
}
staff_inner_end();
