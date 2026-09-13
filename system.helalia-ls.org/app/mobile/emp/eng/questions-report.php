<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require dirname(__DIR__) . '/includes/staff-questions.php';
staff_q_boot();
staff_q_page_report();
