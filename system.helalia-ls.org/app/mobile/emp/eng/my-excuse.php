<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
staff_boot_excuse();
$back = (isset($_GET['new']) || isset($_GET['id'])) ? 'my-excuse.php' : staff_profile_href();
$title = isset($_GET['new']) ? $L['submit_excuse'] : (isset($_GET['id']) ? $L['view_excuse'] : $L['my_excuse']);
staff_inner($title, $back, 'excuse');
staff_render_excuse();
staff_inner_end('excuse');
