<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
staff_ctrl_boot();
staff_ctrl_guard_view($L['c_title'], 'emp-view.php');
staff_inner($L['c_title'], 'emp-view.php');
staff_ctrl_render_years();
staff_inner_end();
