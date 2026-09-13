<?php
require_once __DIR__ . '/includes/bootstrap.php';
$user = current_user();
if ($user && is_portal_user($user)) {
    header('Location: ' . portal_home_url($user));
    exit;
}
header('Location: login.php');
exit;
