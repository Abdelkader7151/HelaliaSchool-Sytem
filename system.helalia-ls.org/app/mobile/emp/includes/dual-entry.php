<?php
/**
 * Lightweight dual-entry helper for mobile index/login (no emp staff bootstrap).
 * Sends the 24 trusted staff phones to Emp/Parent chooser on every open/login.
 */

if (!function_exists('helalia_set_auth_cookies')) {
    $__ap = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'auth-persist.php';
    if (is_file($__ap)) {
        include_once $__ap;
    }
}

if (!function_exists('dual_entry_digits')) {
    function dual_entry_digits($s)
    {
        $d = preg_replace('/\D+/', '', (string) $s);
        if (strpos($d, '20') === 0 && strlen($d) >= 12) {
            $d = substr($d, 2);
        }
        $d = ltrim($d, '0');
        if (strlen($d) >= 10) {
            $d = substr($d, -10);
        }
        return $d;
    }
}

if (!function_exists('dual_entry_staff_phones')) {
    function dual_entry_staff_phones()
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        $raw = array(
            '01001890072', '01286423337', '01006470320', '01000142977', '01000591167',
            '01222316896', '01098682448', '01002206451', '01288714883', '01201372952',
            '01000610368', '01126621669', '01009178909', '01090013866', '01010284888',
            '01111006024', '01007299887', '01220035312', '01282232628', '01061655693',
            '01226890327', '01064847016', '02280185596', '01066727106',
            '01065144487', // Developer staff ↔ parent 01065144489
        );
        $map = array();
        foreach ($raw as $ph) {
            $n = dual_entry_digits($ph);
            if ($n !== '') {
                $map[$n] = true;
            }
        }
        return $map;
    }
}

if (!function_exists('dual_entry_is_staff_phone')) {
    function dual_entry_is_staff_phone($phone)
    {
        $n = dual_entry_digits($phone);
        return ($n !== '' && isset(dual_entry_staff_phones()[$n]));
    }
}

if (!function_exists('dual_entry_clear_pick')) {
    function dual_entry_clear_pick()
    {
        unset($_SESSION['helalia_role'], $_SESSION['helalia_role_pick_token']);
        if (!headers_sent()) {
            setcookie('helalia_dual_pick', '', time() - 3600, '/');
        }
        unset($_COOKIE['helalia_dual_pick']);
    }
}

if (!function_exists('dual_entry_restore_emp_backup')) {
    function dual_entry_restore_emp_backup()
    {
        if (empty($_SESSION['helalia_emp_backup']) || !is_array($_SESSION['helalia_emp_backup'])) {
            return false;
        }
        $b = $_SESSION['helalia_emp_backup'];
        if (empty($b['MM_Userid'])) {
            return false;
        }
        $_SESSION['MM_Userid'] = $b['MM_Userid'];
        $_SESSION['MM_Username'] = isset($b['MM_Username']) ? $b['MM_Username'] : null;
        $_SESSION['account_type'] = isset($b['account_type']) ? $b['account_type'] : 2;
        if (array_key_exists('phone_id', $b)) {
            $_SESSION['phone_id'] = $b['phone_id'];
        }
        if (!headers_sent() && !empty($b['helu'])) {
            if (function_exists('helalia_set_auth_cookies')) {
                helalia_set_auth_cookies($b['helu'], !empty($b['help']) ? $b['help'] : '');
            } else {
                setcookie('helu', $b['helu'], time() + (86400 * 365), '/');
                $_COOKIE['helu'] = $b['helu'];
                if (!empty($b['help'])) {
                    setcookie('help', $b['help'], time() + (86400 * 365), '/');
                    $_COOKIE['help'] = $b['help'];
                }
            }
        }
        return true;
    }
}

/**
 * On app open / login: dual staff always land on choose-role (not last UI).
 */
if (!function_exists('dual_entry_redirect_if_dual_staff')) {
    function dual_entry_redirect_if_dual_staff($phone, $accountType, $langDir)
    {
        $langDir = ($langDir === 'arb') ? 'arb' : 'eng';
        $accountType = (int) $accountType;
        $hadBackup = dual_entry_restore_emp_backup();
        if ($hadBackup) {
            $phone = isset($_SESSION['MM_Username']) ? $_SESSION['MM_Username'] : $phone;
            $accountType = isset($_SESSION['account_type']) ? (int) $_SESSION['account_type'] : 2;
        }
        $isDualPhone = dual_entry_is_staff_phone($phone);
        $flag = (!empty($_COOKIE['helalia_dual_staff']) && $_COOKIE['helalia_dual_staff'] === '1');
        if ($accountType !== 2 || (!$isDualPhone && !$hadBackup && !$flag)) {
            return false;
        }
        if (!$isDualPhone && $hadBackup) {
            // restored emp from backup — treat as dual
        } elseif (!$isDualPhone && !$hadBackup) {
            return false;
        }
        dual_entry_clear_pick();
        unset($_SESSION['helalia_emp_backup']);
        if (!headers_sent()) {
            setcookie('helalia_dual_staff', '1', time() + (86400 * 365), '/');
        }
        header('Location: emp/' . $langDir . '/choose-role.php');
        exit;
    }
}
