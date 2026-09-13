<?php
/**
 * Local preview may be opened from this PC or a phone on the same Wi-Fi.
 * The live school host never uses this path.
 */
function staff_is_local_request()
{
    $addr = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
    if ($addr === '127.0.0.1' || $addr === '::1') {
        return true;
    }
    if (strpos($addr, '192.168.') === 0 || strpos($addr, '10.') === 0) {
        return true;
    }
    if (preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $addr)) {
        return true;
    }
    return false;
}

function staff_is_production_host()
{
    $host = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
    $host = preg_replace('/:\d+$/', '', $host);
    return (strpos($host, 'helalia-ls.org') !== false);
}

function staff_is_local_dev()
{
    return !staff_is_production_host() && staff_is_local_request();
}

function staff_is_local_conn_file($path)
{
    if (!is_file($path)) {
        return false;
    }
    $head = @file_get_contents($path, false, null, 0, 600);
    if ($head === false) {
        return false;
    }
    return (strpos($head, 'Local-only') !== false)
        || (strpos($head, 'staff_is_local_request') !== false);
}

function staff_resolve_connections($empHome, $mobileRoot)
{
    $siteRoot = dirname($mobileRoot);
    $candidates = array(
        $mobileRoot . '/Connections/database.php',
        $siteRoot . '/Connections/database.php',
        $mobileRoot . '/mobile/Connections/database.php',
        $empHome . '/Connections/database.php',
    );
    foreach ($candidates as $path) {
        if (!is_file($path)) {
            continue;
        }
        if (staff_is_production_host() && staff_is_local_conn_file($path)) {
            continue;
        }
        return $path;
    }
    return $mobileRoot . '/Connections/database.php';
}

function staff_include_first(array $paths)
{
    foreach ($paths as $path) {
        if (!is_file($path)) {
            continue;
        }
        extract($GLOBALS, EXTR_SKIP);
        include_once $path;
        foreach (get_defined_vars() as $k => $v) {
            if ($k === 'paths' || $k === 'path' || $k === 'k' || $k === 'v') {
                continue;
            }
            $GLOBALS[$k] = $v;
        }
        return $path;
    }
    return false;
}

function staff_boot_live_auth($lang, $empHome, $mobileRoot)
{
    $lang = ($lang === 'arb') ? 'arb' : 'eng';
    staff_include_first(array(
        $mobileRoot . '/includes/access.php',
        $empHome . '/' . $lang . '/includes/access.php',
        $mobileRoot . '/mobile/' . $lang . '/includes/access.php',
    ));
    staff_include_first(array(
        $mobileRoot . '/includes/functions_' . $lang . '.php',
        $mobileRoot . '/includes/functions.php',
        $empHome . '/' . $lang . '/includes/functions.php',
        $mobileRoot . '/mobile/' . $lang . '/includes/functions.php',
    ));
}

function staff_ensure_user_row()
{
    global $database, $database_database, $row_get_user;
    if (!empty($row_get_user) && isset($row_get_user['account_type'])) {
        return;
    }
    if (empty($_SESSION['MM_Userid']) || !isset($database) || !($database instanceof mysqli)) {
        return;
    }
    if (!empty($database_database)) {
        mysqli_select_db($database, $database_database);
    }
    $uid = (int) $_SESSION['MM_Userid'];
    $rs = mysqli_query($database, "SELECT * FROM `app_login` WHERE `id` = '{$uid}' LIMIT 1");
    $row_get_user = $rs ? mysqli_fetch_assoc($rs) : null;
}
