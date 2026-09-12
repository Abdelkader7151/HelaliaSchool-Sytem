<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
staff_inner($L['my_attendance'], staff_attendance_back_href(), 'attendance');
staff_render_attendance();
staff_inner_end('attendance');
