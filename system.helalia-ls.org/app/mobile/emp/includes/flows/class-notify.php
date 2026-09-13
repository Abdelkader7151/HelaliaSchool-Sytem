<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

if (!svc_can('app8_access') && empty($showNotify)) {
    svc_go('emp-view.php');
}

$page = basename($_SERVER['PHP_SELF']);
$year = svc_int('year', -1);
$class = svc_int('class');

if ($page === 'class-notify-send.php' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msg'])) {
    svc_send_notify($year, $class, $_POST['msg']);
    svc_go('class-notify-send.php?year=' . $year . '&class=' . $class);
}

if ($page === 'class-notify-send.php') {
    svc_boot($S['notify_title'], 'class-notify-class.php?year=' . $year);
    echo '<p class="lede">' . staff_h(trim(svc_year($year) . ' · ' . svc_class_name($class))) . '</p>';
    echo '<form class="stack" method="post" action="class-notify-send.php?year=' . $year . '&class=' . $class . '">';
    echo '<label class="field"><span class="field__label">' . staff_h($S['message']) . '</span>';
    echo '<textarea class="input" name="msg" required></textarea></label>';
    echo '<button class="btn btn--primary" type="submit">' . staff_h($S['send']) . '</button>';
    echo '</form>';
    staff_inner_end();
    return;
}

if ($page === 'class-notify-class.php') {
    svc_boot($S['select_class'], 'class-notify.php');
    $rows = svc_classes_notify($year);
    if (!$rows) {
        svc_empty();
    } else {
        echo '<div class="rows">';
        foreach ($rows as $row) {
            $cid = (int) $row['class'];
            svc_row('class-notify-send.php?year=' . $year . '&class=' . $cid, svc_class_name($cid), svc_year($year), null, 't-navy', 'people');
        }
        echo '</div>';
    }
    staff_inner_end();
    return;
}

svc_boot($S['select_year']);
$rows = svc_years_notify();
if (!$rows) {
    svc_empty();
} else {
    echo '<div class="rows">';
    foreach ($rows as $row) {
        $y = (int) $row['study_year'];
        svc_row('class-notify-class.php?year=' . $y, svc_year($y), '', null, 't-navy', 'list');
    }
    echo '</div>';
}
staff_inner_end();
