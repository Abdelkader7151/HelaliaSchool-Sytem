<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/services.php';
require dirname(__DIR__) . '/includes/staff-absence.php';
staff_abs_boot();
staff_inner($L['absence'], 'emp-view.php');
staff_abs_render_hub();
staff_inner_end();
