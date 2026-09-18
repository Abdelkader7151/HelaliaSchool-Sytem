<?php
/**
 * Detect staff who are also parents. Login stays on the employee phone.
 */

if (!function_exists('helalia_set_auth_cookies')) {
    $__ap = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'auth-persist.php';
    if (is_file($__ap)) {
        include_once $__ap;
    }
}

function dual_digits($s)
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

/**
 * Manual dual-role allowlist (staff login phones only).
 * Phone + national-ID trusted matches — 24 people.
 *
 * Policy:
 * - Default parent access for these staff = login with the EMP phone → choose Parent.
 * - Same phone on staff + parent roles → chooser, then either UI as picked.
 * - Phone mismatch (4 people): the other/old parent number still opens classic
 *   parent UI normally for now (parent-only login). It is NOT on this allowlist.
 */
function dual_manual_phones()
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }
    $map = array();
    foreach (dual_manual_parent_accounts() as $phone => $_info) {
        $n = dual_digits($phone);
        if ($n !== '') {
            $map[$n] = true;
        }
    }
    return $map;
}

/**
 * Child-file / old parent phones that differ from the staff phone (4 of 24).
 * These stay as normal parent-only logins for now — never force Emp/Parent chooser.
 */
function dual_manual_alt_parent_phones()
{
    return array(
        '01000729089', // Abeer — staff 01001890072
        '01006793696', // Hoda — staff 01288714883
        '01026883620', // Radwa — staff 01007299887
        '01090431443', // Zenat — staff 02280185596
    );
}

/**
 * Staff phone => classic parent app_login id (kids_list.parent_id owner).
 * Looked up from live DB; kept manual so Parent role can switch session id.
 * parent_phone = phone on that parent app_login row (may be spouse / old number).
 * alt_parent_login = extra parent-only phone still valid for now (mismatch cases).
 */
function dual_manual_parent_accounts()
{
    return array(
        '01001890072' => array('parent_id' => 3, 'parent_phone' => '01000729089', 'alt_parent_login' => '01000729089'), // Abeer Mahmoud Mohamed
        '01286423337' => array('parent_id' => 1872, 'parent_phone' => '01286423337'), // basmala hasan ramadan
        // Engy + Moustafa (Omar #1978). Shared parent_id 1857 on 01008288191 — mesh emp spouse phone
        // (old parent_phone=01002206353 khalla Moustafa yefata7 Engy account).
        '01006470320' => array('parent_id' => 1857, 'parent_phone' => '01008288191'), // Engy Hasan
        '01002206353' => array('parent_id' => 1857, 'parent_phone' => '01008288191'), // MOUSTAFA HESEEN MOHAMED
        '01000142977' => array('parent_id' => 1409, 'parent_phone' => '01000077243'), // Esraa Ahmed Megahed
        '01000591167' => array('parent_id' => 1261, 'parent_phone' => '01029479785'), // Gamal Ahmed
        '01222316896' => array('parent_id' => 1039, 'parent_phone' => '01020383447'), // Heba Aftouh
        '01098682448' => array('parent_id' => 1791, 'parent_phone' => '01020940050'), // Hend Adel Mofid
        '01002206451' => array('parent_id' => 1261, 'parent_phone' => '01029479785'), // Hend Ali (same kids_list as Gamal)
        '01288714883' => array('parent_id' => 1181, 'parent_phone' => '01006793696', 'alt_parent_login' => '01006793696'), // Hoda Abou El Maged
        '01201372952' => array('parent_id' => 1072, 'parent_phone' => '01550371473'), // Mervat Abdul Razeq
        '01000610368' => array('parent_id' => 673, 'parent_phone' => '01551924021'), // Nada Yakout
        '01126621669' => array('parent_id' => 1289, 'parent_phone' => '01091461170'), // Nahal Sobhy
        '01009178909' => array('parent_id' => 1429, 'parent_phone' => '01068921487'), // Nashwa Ehab Eid Elfakhrani
        '01090013866' => array('parent_id' => 384, 'parent_phone' => '01229173083'), // nesma ibrahiem
        '01010284888' => array('parent_id' => 1338, 'parent_phone' => '01223211148'), // Nour Al zorba
        '01111006024' => array('parent_id' => 174, 'parent_phone' => '01111006024'), // omnia ahmed ismail
        '01007299887' => array('parent_id' => 1519, 'parent_phone' => '01026883620', 'alt_parent_login' => '01026883620'), // Radwa Yassin Aglan (emp 01007299887 / parent 01026883620)
        '01220035312' => array('parent_id' => 856, 'parent_phone' => '01557333042'), // Randa Moustafa
        '01282232628' => array('parent_id' => 1605, 'parent_phone' => '01501228841'), // Rasha Amin
        '01061655693' => array('parent_id' => 5, 'parent_phone' => '01092468498'), // Reem El Kordy
        '01226890327' => array('parent_id' => 460, 'parent_phone' => '01557092014'), // Sarah Assem
        '01064847016' => array('parent_id' => 267, 'parent_phone' => '01210310102'), // Yasmine Morsy Ali
        '02280185596' => array('parent_id' => 1186, 'parent_phone' => '01090431443', 'alt_parent_login' => '01090431443'), // Zenat mohamed
        '01066727106' => array('parent_id' => 1340, 'parent_phone' => '01211285364'), // عمرو عباس
        // Dev test pair: staff 01065144487 ↔ parent account 01065144489 (#136)
        '01065144487' => array('parent_id' => 136, 'parent_phone' => '01065144489'),
    );
}

/**
 * Resolve dual-role map entry from a staff phone OR its mapped parent / alt phone.
 * Returns info plus staff_phone (canonical employee login phone).
 */
function dual_manual_parent_info_for_phone($rawPhone)
{
    $n = dual_digits($rawPhone);
    if ($n === '') {
        return null;
    }
    $accounts = dual_manual_parent_accounts();
    // 1) Staff phone awwal — law spouse parent_phone = emp phone, mayfata7sh account el tany
    foreach ($accounts as $phone => $info) {
        if (dual_digits($phone) === $n) {
            $out = $info;
            $out['staff_phone'] = $phone;
            return $out;
        }
    }
    // 2) Parent / alt phones
    foreach ($accounts as $phone => $info) {
        if (!empty($info['parent_phone']) && dual_digits($info['parent_phone']) === $n) {
            $out = $info;
            $out['staff_phone'] = $phone;
            return $out;
        }
        if (!empty($info['alt_parent_login']) && dual_digits($info['alt_parent_login']) === $n) {
            $out = $info;
            $out['staff_phone'] = $phone;
            return $out;
        }
    }
    return null;
}

/** Canonical staff login phone for any dual-related phone, or ''. */
function dual_manual_staff_phone_for_any($rawPhone)
{
    $info = dual_manual_parent_info_for_phone($rawPhone);
    if ($info && !empty($info['staff_phone'])) {
        return (string) $info['staff_phone'];
    }
    return '';
}

function dual_manual_parent_info_for_current()
{
    global $row_get_user, $empId, $database;
    $candidates = array();
    if (!empty($_SESSION['helalia_emp_backup']['MM_Username'])) {
        $candidates[] = $_SESSION['helalia_emp_backup']['MM_Username'];
    }
    if (isset($row_get_user['phone'])) {
        $candidates[] = $row_get_user['phone'];
    }
    if (isset($_SESSION['MM_Username'])) {
        $candidates[] = $_SESSION['MM_Username'];
    }
    if (isset($empId) && (int) $empId > 0 && isset($database) && $database instanceof mysqli) {
        static $empPhoneCache = array();
        $eid = (int) $empId;
        if (!array_key_exists($eid, $empPhoneCache)) {
            $empPhoneCache[$eid] = '';
            $q = @mysqli_query($database, "SELECT `phone` FROM `emps` WHERE `id` = '{$eid}' LIMIT 1");
            if ($q && ($row = mysqli_fetch_assoc($q))) {
                $empPhoneCache[$eid] = isset($row['phone']) ? $row['phone'] : '';
            }
        }
        if ($empPhoneCache[$eid] !== '') {
            $candidates[] = $empPhoneCache[$eid];
        }
    }
    foreach ($candidates as $raw) {
        $info = dual_manual_parent_info_for_phone($raw);
        if ($info) {
            return $info;
        }
    }
    return null;
}

/**
 * Emp UI always needs the employee app_login. If Parent role swapped the
 * session to a parent id, put the employee identity back for this request
 * (keep backup so Parent can be chosen again).
 */
function dual_set_login_cookies($phone, $password)
{
    $phone = (string) $phone;
    if ($phone === '') {
        return;
    }
    if (function_exists('helalia_set_auth_cookies')) {
        helalia_set_auth_cookies($phone, $password !== null ? (string) $password : '');
        return;
    }
    $expire = time() + (86400 * 365);
    setcookie('helu', $phone, $expire, '/');
    $_COOKIE['helu'] = $phone;
    if ($password !== null && $password !== '') {
        setcookie('help', (string) $password, $expire, '/');
        $_COOKIE['help'] = (string) $password;
    }
}

function dual_restore_emp_session_for_staff_boot()
{
    if (empty($_SESSION['helalia_emp_backup']) || !is_array($_SESSION['helalia_emp_backup'])) {
        return;
    }
    $b = $_SESSION['helalia_emp_backup'];
    if (empty($b['MM_Userid'])) {
        return;
    }
    $_SESSION['MM_Userid'] = $b['MM_Userid'];
    $_SESSION['MM_Username'] = isset($b['MM_Username']) ? $b['MM_Username'] : null;
    $_SESSION['account_type'] = isset($b['account_type']) ? $b['account_type'] : 2;
    if (array_key_exists('phone_id', $b)) {
        $_SESSION['phone_id'] = $b['phone_id'];
    }
    if (!empty($b['helu'])) {
        dual_set_login_cookies($b['helu'], isset($b['help']) ? $b['help'] : '');
    }
}

function dual_backup_emp_session()
{
    if (!empty($_SESSION['helalia_emp_backup']) && is_array($_SESSION['helalia_emp_backup'])) {
        return;
    }
    if (empty($_SESSION['MM_Userid'])) {
        return;
    }
    // Only backup when current session looks like employee.
    if (isset($_SESSION['account_type']) && (int) $_SESSION['account_type'] !== 2) {
        return;
    }
    $helu = isset($_COOKIE['helu']) ? $_COOKIE['helu'] : (isset($_SESSION['MM_Username']) ? $_SESSION['MM_Username'] : null);
    $help = isset($_COOKIE['help']) ? $_COOKIE['help'] : null;
    $_SESSION['helalia_emp_backup'] = array(
        'MM_Username' => isset($_SESSION['MM_Username']) ? $_SESSION['MM_Username'] : null,
        'MM_Userid' => $_SESSION['MM_Userid'],
        'account_type' => isset($_SESSION['account_type']) ? $_SESSION['account_type'] : 2,
        'phone_id' => isset($_SESSION['phone_id']) ? $_SESSION['phone_id'] : null,
        'helu' => $helu,
        'help' => $help,
    );
}

/**
 * Become the classic parent app_login that owns kids_list — same session shape
 * as a normal parent login so homework/alerts/profile/etc. all resolve by parent id.
 * Keep emp helu/help cookies so reopening the app logs in as staff → chooser again.
 */
function dual_switch_to_parent_session()
{
    global $database, $database_database;
    $info = dual_manual_parent_info_for_current();
    if (!$info || empty($info['parent_id'])) {
        return false;
    }
    dual_backup_emp_session();

    $pid = (int) $info['parent_id'];
    $parent = null;
    if (isset($database) && $database instanceof mysqli) {
        if (!empty($database_database)) {
            mysqli_select_db($database, $database_database);
        } elseif (!empty($GLOBALS['database_database'])) {
            mysqli_select_db($database, $GLOBALS['database_database']);
        }
        $q = mysqli_query($database, "SELECT * FROM `app_login` WHERE `id` = '{$pid}' LIMIT 1");
        if ($q) {
            $parent = mysqli_fetch_assoc($q);
        }
    }

    if ($parent) {
        $_SESSION['MM_Userid'] = (int) $parent['id'];
        $_SESSION['MM_Username'] = isset($parent['phone']) ? $parent['phone'] : (isset($info['parent_phone']) ? $info['parent_phone'] : '');
        $_SESSION['account_type'] = 1;
        $_SESSION['phone_id'] = isset($parent['phone_id']) ? $parent['phone_id'] : null;
        // Do not rewrite helu/help — emp cookies must remain for app reopen → chooser.
        return true;
    }

    $_SESSION['MM_Userid'] = $pid;
    $_SESSION['account_type'] = 1;
    if (!empty($info['parent_phone'])) {
        $_SESSION['MM_Username'] = $info['parent_phone'];
    }
    return true;
}

function dual_clear_emp_backup_after_emp_role()
{
    unset($_SESSION['helalia_emp_backup']);
}

/**
 * Rebuild emp backup from helu/help cookies (or current dual phone) when session lost it.
 * Dual Parent mode keeps emp cookies on purpose — use them to restore Switch role.
 */
function dual_ensure_emp_backup_from_helu()
{
    if (!empty($_SESSION['helalia_emp_backup']) && is_array($_SESSION['helalia_emp_backup'])
        && !empty($_SESSION['helalia_emp_backup']['MM_Userid'])) {
        return true;
    }
    global $database, $database_database, $row_get_user;
    $helu = isset($_COOKIE['helu']) ? trim((string) $_COOKIE['helu']) : '';
    $help = isset($_COOKIE['help']) ? (string) $_COOKIE['help'] : '';
    $candidates = array();
    if ($helu !== '') {
        $candidates[] = $helu;
    }
    if (!empty($_SESSION['MM_Username'])) {
        $candidates[] = (string) $_SESSION['MM_Username'];
    }
    if (isset($row_get_user['phone']) && $row_get_user['phone'] !== '') {
        $candidates[] = (string) $row_get_user['phone'];
    }

    $staffPhone = '';
    foreach ($candidates as $raw) {
        $staffPhone = dual_manual_staff_phone_for_any($raw);
        if ($staffPhone !== '') {
            break;
        }
    }
    if ($staffPhone === '') {
        return false;
    }
    if (!isset($database) || !($database instanceof mysqli)) {
        return false;
    }
    if (!empty($database_database)) {
        mysqli_select_db($database, $database_database);
    } elseif (!empty($GLOBALS['database_database'])) {
        mysqli_select_db($database, $GLOBALS['database_database']);
    }
    $phoneEsc = dual_esc($staffPhone);
    $row = null;
    $q = mysqli_query(
        $database,
        "SELECT `id`, `phone`, `password`, `account_type`, `phone_id` FROM `app_login`
         WHERE `phone` = '{$phoneEsc}' AND `account_type` = 2 LIMIT 1"
    );
    if ($q) {
        $row = mysqli_fetch_assoc($q);
    }
    if (!$row) {
        // Digits-normalized match for staff phone formatting differences.
        $want = dual_digits($staffPhone);
        $q2 = mysqli_query(
            $database,
            "SELECT `id`, `phone`, `password`, `account_type`, `phone_id` FROM `app_login` WHERE `account_type` = 2"
        );
        if ($q2) {
            while ($r = mysqli_fetch_assoc($q2)) {
                if (dual_digits($r['phone']) === $want) {
                    $row = $r;
                    break;
                }
            }
        }
    }
    if (!$row || (int) $row['id'] < 1) {
        return false;
    }
    $cookieHelu = ($helu !== '' && dual_manual_staff_phone_for_any($helu) === $staffPhone)
        ? $helu
        : (isset($row['phone']) ? $row['phone'] : $staffPhone);
    $_SESSION['helalia_emp_backup'] = array(
        'MM_Username' => isset($row['phone']) ? $row['phone'] : $staffPhone,
        'MM_Userid' => (int) $row['id'],
        'account_type' => 2,
        'phone_id' => isset($row['phone_id']) ? $row['phone_id'] : null,
        'helu' => $cookieHelu,
        'help' => ($help !== '' ? $help : (isset($row['password']) ? $row['password'] : '')),
    );
    // Keep emp login cookies pointing at staff phone so reopen → chooser works.
    if (!headers_sent()) {
        dual_set_login_cookies(
            isset($row['phone']) ? $row['phone'] : $staffPhone,
            isset($row['password']) ? $row['password'] : $help
        );
        setcookie('helalia_dual_staff', '1', time() + (86400 * 365), '/');
    }
    $_COOKIE['helalia_dual_staff'] = '1';
    return true;
}

/**
 * Parent Settings: show Switch role only when a real staff app_login exists
 * for this dual phone (prevents parent↔chooser loops when emp was never activated).
 */
function dual_parent_can_switch_role()
{
    global $row_get_user, $database, $database_database;

    dual_ensure_emp_backup_from_helu();
    if (!empty($_SESSION['helalia_emp_backup']) && is_array($_SESSION['helalia_emp_backup'])
        && !empty($_SESSION['helalia_emp_backup']['MM_Userid'])) {
        return true;
    }

    $candidates = array();
    if (!empty($_COOKIE['helu'])) {
        $candidates[] = (string) $_COOKIE['helu'];
    }
    if (!empty($_SESSION['MM_Username'])) {
        $candidates[] = (string) $_SESSION['MM_Username'];
    }
    if (isset($row_get_user['phone']) && $row_get_user['phone'] !== '') {
        $candidates[] = (string) $row_get_user['phone'];
    }
    if (!empty($_SESSION['helalia_emp_backup']['MM_Username'])) {
        $candidates[] = (string) $_SESSION['helalia_emp_backup']['MM_Username'];
    }

    $staffPhone = '';
    foreach ($candidates as $raw) {
        if (dual_manual_parent_info_for_phone($raw)) {
            $staffPhone = dual_manual_staff_phone_for_any($raw);
            if ($staffPhone === '') {
                $staffPhone = (string) $raw;
            }
            break;
        }
    }

    if ($staffPhone !== '' && isset($database) && $database instanceof mysqli) {
        if (!empty($database_database)) {
            mysqli_select_db($database, $database_database);
        } elseif (!empty($GLOBALS['database_database'])) {
            mysqli_select_db($database, $GLOBALS['database_database']);
        }
        $phoneEsc = dual_esc($staffPhone);
        $q = mysqli_query(
            $database,
            "SELECT `id` FROM `app_login`
             WHERE `phone` = '{$phoneEsc}' AND `account_type` = 2 AND `emp_id` > 0
             LIMIT 1"
        );
        if ($q && mysqli_num_rows($q) > 0) {
            if (!headers_sent()) {
                setcookie('helalia_dual_staff', '1', time() + (86400 * 365), '/');
            }
            $_COOKIE['helalia_dual_staff'] = '1';
            return true;
        }
        // Mapped dual phone but staff login missing — do not offer Switch / set dual cookie.
        return false;
    }

    // Staff account opened parent pages without a dual map entry — still allow escape to Emp.
    if (isset($_SESSION['account_type']) && (int) $_SESSION['account_type'] === 2) {
        return true;
    }
    if (isset($row_get_user['account_type']) && (int) $row_get_user['account_type'] === 2) {
        return true;
    }

    return false;
}

function dual_mark_role_pick()
{
    if (empty($_SESSION['helalia_role_pick_token'])) {
        $_SESSION['helalia_role_pick_token'] = bin2hex(function_exists('random_bytes') ? random_bytes(8) : openssl_random_pseudo_bytes(8));
    }
    $token = (string) $_SESSION['helalia_role_pick_token'];
    if (!headers_sent()) {
        setcookie('helalia_dual_pick', $token, 0, '/'); // session cookie
        setcookie('helalia_dual_staff', '1', time() + (86400 * 365), '/');
    }
    $_COOKIE['helalia_dual_pick'] = $token;
    $_COOKIE['helalia_dual_staff'] = '1';
}

function dual_clear_role_pick()
{
    unset($_SESSION['helalia_role'], $_SESSION['helalia_role_pick_token']);
    if (!headers_sent()) {
        setcookie('helalia_dual_pick', '', time() - 3600, '/');
    }
    unset($_COOKIE['helalia_dual_pick']);
}

function dual_role_pick_active()
{
    $t = isset($_SESSION['helalia_role_pick_token']) ? (string) $_SESSION['helalia_role_pick_token'] : '';
    $c = isset($_COOKIE['helalia_dual_pick']) ? (string) $_COOKIE['helalia_dual_pick'] : '';
    return ($t !== '' && $c !== '' && hash_equals($t, $c));
}

function dual_is_manual_dual()
{
    global $row_get_user, $empId, $database;

    dual_ensure_emp_backup_from_helu();

    // Emp/Parent chooser is only for employee logins (or dual session with emp backup).
    // Old/alternate parent-only numbers keep the normal parent UI.
    $hasEmpBackup = (!empty($_SESSION['helalia_emp_backup']) && is_array($_SESSION['helalia_emp_backup']));
    $accountType = isset($_SESSION['account_type']) ? (int) $_SESSION['account_type'] : 0;
    if (!$hasEmpBackup && $accountType !== 2) {
        return false;
    }
    if (!$hasEmpBackup && isset($row_get_user['account_type']) && (int) $row_get_user['account_type'] !== 2) {
        return false;
    }

    $map = dual_manual_phones();
    if (!$map) {
        return false;
    }
    $candidates = array();
    if (!empty($_SESSION['helalia_emp_backup']['MM_Username'])) {
        $candidates[] = $_SESSION['helalia_emp_backup']['MM_Username'];
    }
    if (isset($row_get_user['phone'])) {
        $candidates[] = $row_get_user['phone'];
    }
    if (isset($_SESSION['MM_Username'])) {
        $candidates[] = $_SESSION['MM_Username'];
    }
    if (isset($empId) && (int) $empId > 0 && isset($database) && $database instanceof mysqli) {
        static $empPhoneCache2 = array();
        $eid = (int) $empId;
        if (!array_key_exists($eid, $empPhoneCache2)) {
            $empPhoneCache2[$eid] = '';
            $q = @mysqli_query($database, "SELECT `phone` FROM `emps` WHERE `id` = '{$eid}' LIMIT 1");
            if ($q && ($row = mysqli_fetch_assoc($q))) {
                $empPhoneCache2[$eid] = isset($row['phone']) ? $row['phone'] : '';
            }
        }
        if ($empPhoneCache2[$eid] !== '') {
            $candidates[] = $empPhoneCache2[$eid];
        }
    }
    foreach ($candidates as $raw) {
        $n = dual_digits($raw);
        if ($n !== '' && isset($map[$n])) {
            return true;
        }
    }
    return false;
}

function dual_nid($s)
{
    $d = preg_replace('/\D+/', '', (string) $s);
    return (strlen($d) >= 8) ? $d : '';
}

function dual_esc($s)
{
    global $database;
    if (isset($database) && $database instanceof mysqli) {
        return mysqli_real_escape_string($database, (string) $s);
    }
    return addslashes((string) $s);
}

function dual_is_parent_mode()
{
    return isset($_SESSION['helalia_role']) && $_SESSION['helalia_role'] === 'parent';
}

function staff_home_href()
{
    $file = dual_is_parent_mode() ? 'parent-home.php' : 'emp-view.php';
    return function_exists('dual_gate_href') ? dual_gate_href($file) : $file;
}

function dual_preview_children()
{
    global $staffLang;
    $arb = (isset($staffLang) && $staffLang === 'arb');
    return array(
        array(
            'id' => 1,
            'fn_name' => $arb ? 'يوسف أحمد' : 'Youssef Ahmed',
            'study_year' => 5,
            'class' => 101,
            'picture' => '',
            'role' => 'mother',
            'year_label' => $arb ? 'الابتدائي 3' : 'Junior Three',
            'class_label' => '5-A',
            'photo' => '',
        ),
        array(
            'id' => 2,
            'fn_name' => $arb ? 'ليلى أحمد' : 'Layla Ahmed',
            'study_year' => 5,
            'class' => 101,
            'picture' => '',
            'role' => 'mother',
            'year_label' => $arb ? 'الابتدائي 3' : 'Junior Three',
            'class_label' => '5-A',
            'photo' => '',
        ),
    );
}

function dual_pack_kid($row, $role)
{
    $id = (int) $row['id'];
    $year = isset($row['study_year']) ? (int) $row['study_year'] : 0;
    $class = isset($row['class']) ? $row['class'] : '';
    $picture = isset($row['picture']) ? $row['picture'] : '';
    $photo = '';
    if ($picture !== '' && stripos($picture, 'no-picture') === false) {
        $photo = 'https://system.helalia-ls.org/kids/' . $picture;
    }
    return array(
        'id' => $id,
        'fn_name' => trim((string) (isset($row['fn_name']) && $row['fn_name'] !== '' ? $row['fn_name'] : $row['name'])),
        'study_year' => $year,
        'class' => $class,
        'picture' => $picture,
        'role' => $role,
        'year_label' => '',
        'class_label' => '',
        'photo' => $photo,
    );
}

function dual_cache_key()
{
    global $empId, $row_get_user;
    $loginId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    return (int) $empId . ':' . $loginId;
}

function dual_request_script()
{
    return basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
}

function dual_staff_children()
{
    global $staffPreview, $database, $empId, $row_get_user;
    static $memo = null;
    if ($memo !== null) {
        return $memo;
    }
    if (!empty($staffPreview) && empty($_SESSION['helalia_snapshot_emp'])) {
        $memo = dual_preview_children();
        return $memo;
    }
    $script = dual_request_script();
    $key = dual_cache_key();
    $cached = (isset($_SESSION['helalia_dual_key']) && $_SESSION['helalia_dual_key'] === $key
        && isset($_SESSION['helalia_dual_kids']) && is_array($_SESSION['helalia_dual_kids']));
    if ($script === 'punch.php') {
        $memo = $cached ? $_SESSION['helalia_dual_kids'] : array();
        return $memo;
    }
    if ($cached) {
        $memo = $_SESSION['helalia_dual_kids'];
        return $memo;
    }
    if (!isset($database) || !($database instanceof mysqli)) {
        $memo = array();
        return $memo;
    }
    $empId = (int) $empId;
    if ($empId < 1) {
        $memo = array();
        $_SESSION['helalia_dual_kids'] = $memo;
        $_SESSION['helalia_dual_key'] = $key;
        return $memo;
    }
    mysqli_select_db($database, $GLOBALS['database_database']);
    $emp = null;
    $q = mysqli_query($database, "SELECT `id`, `name`, `phone`, `gov_id` FROM `emps` WHERE `id` = '{$empId}' LIMIT 1");
    if ($q) {
        $emp = mysqli_fetch_assoc($q);
    }
    if (!$emp) {
        $memo = array();
        $_SESSION['helalia_dual_kids'] = $memo;
        $_SESSION['helalia_dual_key'] = $key;
        return $memo;
    }

    $phones = array();
    foreach (array($emp['phone'], isset($row_get_user['phone']) ? $row_get_user['phone'] : '') as $raw) {
        $n = dual_digits($raw);
        if ($n !== '') {
            $phones[$n] = true;
        }
        $rawDigits = preg_replace('/\D+/', '', (string) $raw);
        if ($rawDigits !== '') {
            $phones[ltrim($rawDigits, '0')] = true;
        }
    }
    $gov = dual_nid($emp['gov_id']);
    $name = trim((string) $emp['name']);

    $found = array();

    $or = array();
    if ($gov !== '') {
        $g = dual_esc($gov);
        $or[] = "REPLACE(REPLACE(`father_gov_id`,' ',''),'-','') = '{$g}'";
        $or[] = "REPLACE(REPLACE(`mother_gov_id`,' ',''),'-','') = '{$g}'";
    }
    foreach (array_keys($phones) as $ph) {
        if ($ph === '') {
            continue;
        }
        $p = dual_esc($ph);
        $or[] = "REPLACE(`father_mobile`,' ','') LIKE '%{$p}'";
        $or[] = "REPLACE(`mother_mobile`,' ','') LIKE '%{$p}'";
    }
    if ($or) {
        $sql = "SELECT `id`, `fn_name`, `name`, `study_year`, `class`, `picture`, `father_name`, `mother_name`, `father_mobile`, `mother_mobile`, `father_gov_id`, `mother_gov_id` FROM `kids` WHERE " . implode(' OR ', $or);
        $rs = mysqli_query($database, $sql);
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $role = 'parent';
                if ($gov !== '' && dual_nid($row['mother_gov_id']) === $gov) {
                    $role = 'mother';
                } elseif ($gov !== '' && dual_nid($row['father_gov_id']) === $gov) {
                    $role = 'father';
                } else {
                    $fm = dual_digits($row['father_mobile']);
                    $mm = dual_digits($row['mother_mobile']);
                    foreach (array_keys($phones) as $ph) {
                        if ($ph !== '' && $mm === $ph) {
                            $role = 'mother';
                        }
                        if ($ph !== '' && $fm === $ph) {
                            $role = 'father';
                        }
                    }
                }
                $found[(int) $row['id']] = dual_pack_kid($row, $role);
            }
        }
    }

    if ($name !== '' && strlen($name) >= 8 && !$found) {
        $n = dual_esc($name);
        $rs = mysqli_query(
            $database,
            "SELECT `id`, `fn_name`, `name`, `study_year`, `class`, `picture`, `father_name`, `mother_name`, `father_mobile`, `mother_mobile`
             FROM `kids`
             WHERE TRIM(`father_name`) = '{$n}' OR TRIM(`mother_name`) = '{$n}'
             LIMIT 8"
        );
        $tmp = array();
        $phonesSeen = array();
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $role = (strcasecmp(trim((string) $row['mother_name']), $name) === 0) ? 'mother' : 'father';
                $p = dual_digits($role === 'mother' ? $row['mother_mobile'] : $row['father_mobile']);
                $phonesSeen[$p] = true;
                $tmp[] = dual_pack_kid($row, $role);
            }
        }
        if (count($phonesSeen) <= 1 && count($tmp) <= 4) {
            foreach ($tmp as $kid) {
                $found[$kid['id']] = $kid;
            }
        }
    }

    $loginId = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    if ($loginId > 0) {
        $rs = mysqli_query($database, "SELECT `kid_id` FROM `kids_list` WHERE `parent_id` = '{$loginId}'");
        $extraIds = array();
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $kidId = (int) $row['kid_id'];
                if ($kidId > 0 && !isset($found[$kidId])) {
                    $extraIds[$kidId] = true;
                }
            }
        }
        if ($extraIds) {
            $in = implode(',', array_keys($extraIds));
            $krs = mysqli_query($database, "SELECT `id`, `fn_name`, `name`, `study_year`, `class`, `picture` FROM `kids` WHERE `id` IN ({$in})");
            if ($krs) {
                while ($k = mysqli_fetch_assoc($krs)) {
                    $found[(int) $k['id']] = dual_pack_kid($k, 'parent');
                }
            }
        }
    }

    $out = array_values($found);
    usort($out, function ($a, $b) {
        return strcasecmp($a['fn_name'], $b['fn_name']);
    });
    $_SESSION['helalia_dual_kids'] = $out;
    $_SESSION['helalia_dual_key'] = $key;
    $memo = $out;
    return $out;
}

function dual_owns_kid($kidId)
{
    return dual_find_kid($kidId) !== null;
}

function dual_find_kid($kidId)
{
    global $dualKids;
    $kidId = (int) $kidId;
    if (empty($dualKids)) {
        return null;
    }
    foreach ($dualKids as $kid) {
        if ((int) $kid['id'] === $kidId) {
            return $kid;
        }
    }
    return null;
}

function dual_has_dual()
{
    global $dualKids;
    if (function_exists('dual_ensure_emp_backup_from_helu')) {
        dual_ensure_emp_backup_from_helu();
    }
    if (!empty($dualKids)) {
        return true;
    }
    return dual_is_manual_dual();
}

function dual_in_kid_folder()
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }
    foreach (array('PHP_SELF', 'SCRIPT_NAME', 'SCRIPT_FILENAME', 'REQUEST_URI') as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }
        $v = str_replace('\\', '/', (string) $_SERVER[$key]);
        if (strpos($v, '/kid/') !== false || basename(dirname($v)) === 'kid') {
            $cached = true;
            return true;
        }
    }
    $cached = false;
    return false;
}

function dual_parent_script_ok($script)
{
    $ok = array(
        'choose-role.php',
        'parent-home.php',
        'parent-kid.php',
        'parent-news.php',
        'parent-settings.php',
        'parent-add.php',
        'parent-tool.php',
        'student-view.php',
        'student-absence.php',
        'student-view-vacation.php',
        'profile.php',
        'password.php',
        'emp-settings.php',
        'emp-checkin.php',
        'my-absence.php',
        'my-excuse.php',
        'my-attendance.php',
        'kid-data.php',
        'homework-subjects.php',
        'kid-memo.php',
        'cert.php',
        'revision-subjects.php',
        'plan.php',
        'gallery.php',
        'notifications.php',
        'ask-teacher.php',
        'calendar.php',
        'absence.php',
        'kid-info.php',
        'submit-vacation.php',
        'kids.php',
        'ui-pages-home.php',
        'ui-app-editprofile.php',
        'ui-app-password.php',
    );
    if (in_array($script, $ok, true) || dual_in_kid_folder()) {
        return true;
    }
    return false;
}

function dual_gate_href($file)
{
    return dual_in_kid_folder() ? ('../' . $file) : $file;
}

function dual_live_parent_href()
{
    global $staffLang;
    $lang = (isset($staffLang) && $staffLang === 'arb') ? 'arb' : 'eng';
    return '../../parent/' . $lang . '/parent-view.php';
}

function dual_open_live_parent()
{
    dual_set_role('parent');
    header('Location: ' . dual_live_parent_href() . '?dual_picked=1');
    exit;
}

function dual_gate()
{
    global $dualKids;
    $script = dual_request_script();
    if ($script === 'punch.php') {
        return;
    }
    $manual = dual_is_manual_dual();
    if (empty($dualKids) && !$manual) {
        return;
    }

    // Chooser itself: let the page clear the previous pick and show Emp/Parent.
    if ($script === 'choose-role.php') {
        if ($manual && !headers_sent()) {
            setcookie('helalia_dual_staff', '1', time() + (86400 * 365), '/');
        }
        return;
    }

    if (!dual_role_pick_active()) {
        dual_clear_role_pick();
        dual_restore_emp_session_for_staff_boot();
        header('Location: ' . dual_gate_href('choose-role.php'));
        exit;
    }

    $role = isset($_SESSION['helalia_role']) ? (string) $_SESSION['helalia_role'] : '';
    if ($role === '') {
        header('Location: ' . dual_gate_href('choose-role.php'));
        exit;
    }
    if ($role === 'parent') {
        dual_open_live_parent();
    }
    if ($role === 'emp' && dual_in_kid_folder()) {
        header('Location: ' . dual_gate_href('emp-view.php'));
        exit;
    }
    if ($role === 'emp' && dual_parent_script_ok($script) && $script !== 'choose-role.php'
        && !in_array($script, array(
            'profile.php', 'password.php', 'emp-settings.php', 'emp-checkin.php',
            'my-absence.php', 'my-excuse.php', 'my-attendance.php',
            'student-view.php', 'student-absence.php', 'student-view-vacation.php',
            'absence.php',
            'absence-collect.php', 'absence-collect-class.php', 'absence-collect-kids.php',
            'absence-confirm.php', 'absence-confirm-list.php',
            'absence-accept.php', 'absence-accept-list.php',
        ), true)
    ) {
        header('Location: ' . dual_gate_href('emp-view.php'));
        exit;
    }
}

function dual_set_role($role)
{
    $role = ($role === 'parent') ? 'parent' : 'emp';
    if ($role === 'parent') {
        $_SESSION['helalia_role'] = 'parent';
        dual_switch_to_parent_session();
        dual_mark_role_pick();
        return;
    }
    dual_restore_emp_session_for_staff_boot();
    dual_clear_emp_backup_after_emp_role();
    $_SESSION['helalia_role'] = 'emp';
    dual_mark_role_pick();
}
