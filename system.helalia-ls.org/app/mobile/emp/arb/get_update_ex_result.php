<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-control.php';
header('Content-Type: text/plain; charset=UTF-8');
echo staff_ctrl_save_ex() ? '1' : '0';
