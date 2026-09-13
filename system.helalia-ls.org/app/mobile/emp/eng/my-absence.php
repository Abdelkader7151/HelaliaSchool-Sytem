<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
staff_boot_absence();
$back = staff_absence_back_href();
$title = isset($_GET['new']) ? $L['submit_vacation'] : (isset($_GET['id']) ? $L['view_vacation'] : $L['my_absence']);
staff_inner($title, $back, 'absence');
staff_render_absence();
staff_inner_end('absence');
