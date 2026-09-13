<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff_students.php';
staff_students_render_absence();
