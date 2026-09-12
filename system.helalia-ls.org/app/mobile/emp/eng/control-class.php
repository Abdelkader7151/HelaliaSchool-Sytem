<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_guard_view($L['c_class'], 'control.php');
$year = staff_ctrl_need_year();
staff_inner($L['c_class'], 'control.php');
staff_ctrl_render_classes($year);
staff_inner_end();
