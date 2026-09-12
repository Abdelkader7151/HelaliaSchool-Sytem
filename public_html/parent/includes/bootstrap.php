<?php
declare(strict_types=1);

if (!isset($_SESSION)) {
    session_name('helalia_parent');
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/parent/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        session_set_cookie_params(0, '/parent/', '', false, true);
    }
    session_start();
}

date_default_timezone_set('Africa/Cairo');

$configFile = dirname(__DIR__) . '/config.php';
if (!is_file($configFile)) {
    http_response_code(500);
    exit('Parent portal is not configured yet.');
}

$GLOBALS['PORTAL_CONFIG'] = require $configFile;

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['eng', 'arb'], true)) {
    $_SESSION['lang'] = $_GET['lang'];
}
