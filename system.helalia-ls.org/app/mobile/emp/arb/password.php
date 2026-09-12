<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
staff_boot_password();
$back = (isset($_GET['from']) && $_GET['from'] === 'profile') ? 'profile.php' : 'emp-settings.php';
staff_inner($L['password'], $back, 'password');
staff_render_password();
staff_inner_end('password');
