<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

if (!svc_can('app4_access') && empty($showStaffAbs)) {
    svc_go('emp-view.php');
}

$page = basename($_SERVER['PHP_SELF']);

if ($page === 'staff-absence-view.php') {
    $id = svc_int('id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        svc_save_vac($id, (int) $_POST['type']);
        svc_go('staff-absence.php');
    }
    $row = svc_vac($id);
    svc_boot($S['view_vac'], 'staff-absence.php');
    if (!$row) {
        svc_empty();
        staff_inner_end();
        return;
    }
    echo '<form class="stack" method="post" action="staff-absence-view.php?id=' . $id . '">';
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
    echo '<div class="svc-fact"><b>' . staff_h($S['vac_start']) . '</b><span>' . staff_h(date('d/m/Y', (int) $row['vacation_start'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['vac_end']) . '</b><span>' . staff_h(date('d/m/Y', (int) $row['vacation_end'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['days']) . '</b><span>' . staff_h(svc_vac_days($row['vacation_start'], $row['vacation_end'])) . '</span></div>';
    echo '<div class="svc-fact"><b>' . staff_h($S['type']) . '</b><span>' . staff_h(svc_vac_type($row['type'])) . '</span></div>';
    if (!empty($row['sick_note'])) {
        echo '<div class="svc-fact"><b>' . staff_h($S['attached']) . '</b><span>' . staff_h($S['attached']) . '</span></div>';
    }
    echo '<div class="svc-fact"><b>' . staff_h($S['desc']) . '</b><span>' . staff_h($row['text']) . '</span></div>';
    echo '</div>';
    echo '<button class="btn btn--primary" name="submit" type="submit">' . staff_h($S['save']) . '</button>';
    echo '</form>';
    staff_inner_end();
    return;
}

svc_boot($S['vac_title']);
$rows = svc_vacs();
if (!$rows) {
    svc_empty();
} else {
    echo '<div class="rows">';
    foreach ($rows as $v) {
        $meta = svc_job_name($v['emp_id']) . ' · ' . date('d/m/Y', (int) $v['vacation_start']);
        svc_row('staff-absence-view.php?id=' . (int) $v['id'], svc_emp_name($v['emp_id']), $meta, null, 't-coral', 'thermo');
    }
    echo '</div>';
}
staff_inner_end();
