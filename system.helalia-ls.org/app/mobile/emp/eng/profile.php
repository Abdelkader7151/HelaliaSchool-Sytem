<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
staff_boot_profile();
$edit = isset($_GET['edit']) ? (string) $_GET['edit'] : '';
$title = $L['profile'];
$back = staff_home_href();
if ($edit === 'name') {
    $title = $L['edit_name'];
    $back = 'profile.php';
} elseif ($edit === 'email') {
    $title = $L['edit_email'];
    $back = 'profile.php';
}
staff_inner($title, $back, 'profile');
staff_render_profile();
staff_inner_end('profile');
