<?php
/**
 * Shared mobile-number uniqueness for Helalia (control + app).
 * Matches formatting variants (010… / 10… / 20…) against app_login and emps.
 */

if (!function_exists('helalia_phone_digits')) {
    /**
     * Normalize to last 10 significant national digits (no leading country/trunk zeros).
     */
    function helalia_phone_digits($phone)
    {
        $d = preg_replace('/\D+/', '', (string) $phone);
        if ($d === null || $d === '') {
            return '';
        }
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

if (!function_exists('helalia_phone_taken_message')) {
    /**
     * @param string $lang 'ar' | 'en'
     */
    function helalia_phone_taken_message($lang = 'ar')
    {
        if ($lang === 'en') {
            return 'This mobile number is already registered. Please sign in with it, or use a different number.';
        }
        return 'لا يمكن المتابعة — رقم الهاتف مسجّل بالفعل في النظام. سجّل الدخول بهذا الرقم أو استخدم رقماً آخر.';
    }
}

if (!function_exists('helalia_phone_already_used')) {
    /**
     * True if this number already exists on app_login and/or emps (digit-normalized).
     *
     * $exclude keys (optional):
     *   - exclude_emp_id (int): ignore this row in emps
     *   - exclude_app_login_id (int): ignore this app_login id
     *   - exclude_app_login_emp_id (int): ignore app_login rows for this emp_id
     *
     * @return array{used:bool,in_app_login:bool,in_emps:bool,app_login_ids:int[],emp_ids:int[]}
     */
    function helalia_phone_already_used($database, $phone, $exclude = array())
    {
        $out = array(
            'used' => false,
            'in_app_login' => false,
            'in_emps' => false,
            'app_login_ids' => array(),
            'emp_ids' => array(),
        );
        $needle = helalia_phone_digits($phone);
        if ($needle === '' || strlen($needle) < 9) {
            return $out;
        }

        $exLoginId = isset($exclude['exclude_app_login_id']) ? (int) $exclude['exclude_app_login_id'] : 0;
        $exLoginEmp = isset($exclude['exclude_app_login_emp_id']) ? (int) $exclude['exclude_app_login_emp_id'] : 0;
        $exEmpId = isset($exclude['exclude_emp_id']) ? (int) $exclude['exclude_emp_id'] : 0;

        $q = @mysqli_query($database, "SELECT `id`, `phone`, `emp_id` FROM `app_login` WHERE `phone` IS NOT NULL AND `phone` != ''");
        if ($q) {
            while ($r = mysqli_fetch_assoc($q)) {
                $id = (int) $r['id'];
                if ($exLoginId > 0 && $id === $exLoginId) {
                    continue;
                }
                if ($exLoginEmp > 0 && (int) $r['emp_id'] === $exLoginEmp) {
                    continue;
                }
                if (helalia_phone_digits($r['phone']) === $needle) {
                    $out['in_app_login'] = true;
                    $out['app_login_ids'][] = $id;
                }
            }
        }

        $q2 = @mysqli_query($database, "SELECT `id`, `phone` FROM `emps` WHERE `phone` IS NOT NULL AND `phone` != ''");
        if ($q2) {
            while ($r = mysqli_fetch_assoc($q2)) {
                $id = (int) $r['id'];
                if ($exEmpId > 0 && $id === $exEmpId) {
                    continue;
                }
                if (helalia_phone_digits($r['phone']) === $needle) {
                    $out['in_emps'] = true;
                    $out['emp_ids'][] = $id;
                }
            }
        }

        $out['used'] = $out['in_app_login'] || $out['in_emps'];
        return $out;
    }
}

if (!function_exists('helalia_phone_is_taken')) {
    /** @return bool */
    function helalia_phone_is_taken($database, $phone, $exclude = array())
    {
        $info = helalia_phone_already_used($database, $phone, $exclude);
        return !empty($info['used']);
    }
}
