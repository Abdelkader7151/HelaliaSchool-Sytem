<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_guard_view($L['c_avg'], 'control.php');
$year = staff_ctrl_need_year();
$class = staff_ctrl_need_class($year);
staff_ctrl_need_subject($year, $class);
staff_ctrl_need_month();
if (staff_ctrl_int('kid_id') < 1) {
    staff_ctrl_message_page($L['c_avg'], $L['c_empty'], 'control-scores.php?' . staff_ctrl_qs());
}
staff_inner($L['c_avg'], 'control-scores.php?' . staff_ctrl_qs(array('kid_id' => null)));
staff_ctrl_render_avg();
staff_inner_end();
