<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_guard_view($L['c_score'], 'control.php');
$year = staff_ctrl_need_year();
$class = staff_ctrl_need_class($year);
staff_ctrl_need_subject($year, $class);
staff_ctrl_need_month();
staff_inner($L['c_score'], 'control-month.php?' . staff_ctrl_qs(array('month' => null, 'kid_id' => null)));
staff_ctrl_render_scores();
staff_inner_end();
