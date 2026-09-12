<?php
require_once __DIR__ . '/includes/bootstrap.php';
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $params['path'] ?: '/parent/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}
session_destroy();
set_remember_cookies('', '', false);
header('Location: login.php');
exit;
