<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_guard_view($L['c_subject'], 'control.php');
$year = staff_ctrl_need_year();
$class = staff_ctrl_need_class($year);
staff_inner($L['c_subject'], 'control-class.php?' . staff_ctrl_qs(array('class' => null, 'subject' => null, 'month' => null, 'kid_id' => null)));
staff_ctrl_render_types($year, $class);
staff_inner_end();
