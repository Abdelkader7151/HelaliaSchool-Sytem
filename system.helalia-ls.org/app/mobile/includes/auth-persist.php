<?php
/**
 * Auth cookies that survive iPhone WebView app reopen.
 * Uses Secure + SameSite=Lax (required on modern iOS) and a localStorage backup.
 *
 * helv = auth epoch. Bump HELALIA_AUTH_EPOCH to force every device to log in again.
 */

if (!function_exists('helalia_auth_epoch')) {
    function helalia_auth_epoch()
    {
        // ch50: school-wide logout + device rebind. Bump this string to force logout again.
        return 'ch50-20260913';
    }
}

if (!function_exists('helalia_auth_cookie_opts')) {
    function helalia_auth_cookie_opts($expires)
    {
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443')
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        return array(
            'expires' => $expires,
            'path' => '/',
            'secure' => $secure,
            'httponly' => false, // readable by splash localStorage bridge in WKWebView
            'samesite' => 'Lax',
        );
    }
}

if (!function_exists('helalia_auth_epoch_ok')) {
    function helalia_auth_epoch_ok()
    {
        if (empty($_COOKIE['helv'])) {
            return false;
        }
        return hash_equals(helalia_auth_epoch(), (string) $_COOKIE['helv']);
    }
}

if (!function_exists('helalia_set_auth_cookies')) {
    function helalia_set_auth_cookies($phone, $passwordHash)
    {
        $phone = trim((string) $phone);
        $passwordHash = (string) $passwordHash;
        if ($phone === '' || $passwordHash === '') {
            return;
        }
        $expires = time() + (86400 * 365);
        $epoch = helalia_auth_epoch();
        if (PHP_VERSION_ID >= 70300) {
            setcookie('helu', $phone, helalia_auth_cookie_opts($expires));
            setcookie('help', $passwordHash, helalia_auth_cookie_opts($expires));
            setcookie('helv', $epoch, helalia_auth_cookie_opts($expires));
        } else {
            setcookie('helu', $phone, $expires, '/');
            setcookie('help', $passwordHash, $expires, '/');
            setcookie('helv', $epoch, $expires, '/');
        }
        $_COOKIE['helu'] = $phone;
        $_COOKIE['help'] = $passwordHash;
        $_COOKIE['helv'] = $epoch;
    }
}

if (!function_exists('helalia_clear_auth_cookies')) {
    function helalia_clear_auth_cookies()
    {
        $expires = time() - (86400 * 400);
        if (PHP_VERSION_ID >= 70300) {
            setcookie('helu', '', helalia_auth_cookie_opts($expires));
            setcookie('help', '', helalia_auth_cookie_opts($expires));
            setcookie('helv', '', helalia_auth_cookie_opts($expires));
        } else {
            setcookie('helu', '', $expires, '/');
            setcookie('help', '', $expires, '/');
            setcookie('helv', '', $expires, '/');
        }
        unset($_COOKIE['helu'], $_COOKIE['help'], $_COOKIE['helv']);
    }
}

if (!function_exists('helalia_clear_login_session')) {
    function helalia_clear_login_session()
    {
        $_SESSION['MM_Username'] = null;
        $_SESSION['MM_Userid'] = null;
        $_SESSION['account_type'] = null;
        unset(
            $_SESSION['MM_Username'],
            $_SESSION['MM_Userid'],
            $_SESSION['account_type'],
            $_SESSION['helalia_role'],
            $_SESSION['helalia_dual_kids'],
            $_SESSION['helalia_dual_key'],
            $_SESSION['helalia_emp_backup'],
            $_SESSION['helalia_role_pick_token']
        );
    }
}

if (!function_exists('helalia_clear_local_auth_script')) {
    function helalia_clear_local_auth_script()
    {
        return 'try{localStorage.removeItem("helalia_helu");localStorage.removeItem("helalia_help");localStorage.removeItem("helalia_helv");}catch(e){}';
    }
}

/**
 * Explicit logout: drop cookies + localStorage, then go to splash.
 */
if (!function_exists('helalia_logout_and_redirect')) {
    function helalia_logout_and_redirect($dest)
    {
        helalia_clear_login_session();
        helalia_clear_auth_cookies();
        $dest = (string) $dest;
        if ($dest === '') {
            $dest = 'index.php';
        }
        header('Content-Type: text/html; charset=UTF-8');
        $d = json_encode($dest, JSON_UNESCAPED_UNICODE);
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
        echo '<title>Helalia</title></head><body style="background:#112c5a;color:#fff;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0">';
        echo '<p>Signing out…</p><script>';
        echo '(function(){' . helalia_clear_local_auth_script();
        echo 'location.replace(' . $d . ');})();';
        echo '</script></body></html>';
        exit();
    }
}

/**
 * Kick mid-app sessions from before the current auth epoch (Android + iPhone).
 * Cookie-only reopen is handled on the splash (index.php).
 */
if (!function_exists('helalia_require_fresh_auth')) {
    function helalia_require_fresh_auth($dest)
    {
        if (empty($_SESSION['MM_Username'])) {
            return;
        }
        if (helalia_auth_epoch_ok()) {
            return;
        }
        helalia_logout_and_redirect($dest);
    }
}

if (!function_exists('helalia_normalize_login_phone')) {
    function helalia_normalize_login_phone($raw)
    {
        $s = trim((string) $raw);
        $s = preg_replace('/\s+/', '', $s);
        return $s;
    }
}

/**
 * After login: write localStorage backup then go to destination (iPhone-safe).
 */
if (!function_exists('helalia_persist_and_redirect')) {
    function helalia_persist_and_redirect($phone, $passwordHash, $dest)
    {
        helalia_set_auth_cookies($phone, $passwordHash);
        $dest = (string) $dest;
        if ($dest === '') {
            $dest = 'index.php';
        }
        header('Content-Type: text/html; charset=UTF-8');
        $u = json_encode((string) $phone, JSON_UNESCAPED_UNICODE);
        $p = json_encode((string) $passwordHash, JSON_UNESCAPED_UNICODE);
        $v = json_encode(helalia_auth_epoch(), JSON_UNESCAPED_UNICODE);
        $d = json_encode($dest, JSON_UNESCAPED_UNICODE);
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
        echo '<title>Helalia</title></head><body style="background:#112c5a;color:#fff;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0">';
        echo '<p>Signing you in…</p><script>';
        echo '(function(){try{localStorage.setItem("helalia_helu",' . $u . ');localStorage.setItem("helalia_help",' . $p . ');localStorage.setItem("helalia_helv",' . $v . ');}catch(e){}';
        echo 'location.replace(' . $d . ');})();';
        echo '</script></body></html>';
        exit();
    }
}
