<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_handle_activate();
staff_ctrl_guard_view($L['c_type'], 'control.php');
$year = staff_ctrl_need_year();
$class = staff_ctrl_need_class($year);
staff_ctrl_need_subject($year, $class);
staff_inner($L['c_type'], 'control-type.php?' . staff_ctrl_qs(array('subject' => null, 'month' => null, 'kid_id' => null)));
staff_ctrl_render_months();
staff_inner_end();
