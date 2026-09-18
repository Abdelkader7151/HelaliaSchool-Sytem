<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/local-request.php';
require_once __DIR__ . '/dual-role.php';

/**
 * staff_job_is_coordinator
 * True law el emp job title = Coordinator (jobs.id = 81)
 * Job title bas — mesh subjects.cor
 */
if (!function_exists('staff_job_is_coordinator')) {
    function staff_job_is_coordinator($empId)
    {
        global $database, $database_database;
        $empId = (int) $empId;
        if ($empId < 1 || !isset($database) || !($database instanceof mysqli)) {
            return false;
        }
        if (!empty($database_database)) {
            mysqli_select_db($database, $database_database);
        }
        $sql = "SELECT e.`id` FROM `emps` e
                LEFT JOIN `jobs` j ON j.`id` = e.`job`
                WHERE e.`id` = '{$empId}'
                  AND (e.`job` = 81 OR LOWER(TRIM(IFNULL(j.`name`, ''))) = 'coordinator')
                LIMIT 1";
        $rs = mysqli_query($database, $sql);
        return ($rs && mysqli_num_rows($rs) > 0);
    }
}

/**
 * staff_teaches_subject
 * True law el emp 3ando el subject fe teachers table
 * (benesta3melha lel Coordinator 3ashan subjects.cor mesh dayman filled)
 */
if (!function_exists('staff_teaches_subject')) {
    function staff_teaches_subject($empId, $subjectId)
    {
        global $database, $database_database;
        $empId = (int) $empId;
        $subjectId = (int) $subjectId;
        if ($empId < 1 || $subjectId < 1 || !isset($database) || !($database instanceof mysqli)) {
            return false;
        }
        if (!empty($database_database)) {
            mysqli_select_db($database, $database_database);
        }
        $sql = "SELECT `id` FROM `teachers` WHERE `emp_id` = '{$empId}' AND `subject` = '{$subjectId}' LIMIT 1";
        $rs = mysqli_query($database, $sql);
        return ($rs && mysqli_num_rows($rs) > 0);
    }
}

dual_restore_emp_session_for_staff_boot();
if (function_exists('helalia_require_fresh_auth')) {
    $staffInKidEarly = false;
    $staffSelfEarly = isset($_SERVER['PHP_SELF']) ? str_replace('\\', '/', (string) $_SERVER['PHP_SELF']) : '';
    $staffFileEarly = isset($_SERVER['SCRIPT_FILENAME']) ? str_replace('\\', '/', (string) $_SERVER['SCRIPT_FILENAME']) : '';
    $staffInKidEarly = (strpos($staffSelfEarly, '/kid/') !== false) || (strpos($staffFileEarly, '/kid/') !== false);
    helalia_require_fresh_auth($staffInKidEarly ? '../../../index.php' : '../../index.php');
}
if (empty($_SESSION['staff_csrf'])) {
    $_SESSION['staff_csrf'] = bin2hex(function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16));
}

$staffLang = (isset($staffLang) && $staffLang === 'arb') ? 'arb' : 'eng';
$loginFile = ($staffLang === 'arb') ? 'login-arb.php' : 'login-eng.php';

$empHome = dirname(__DIR__);
$mobileRoot = dirname($empHome);
$localConn = $empHome . '/Connections/database.php';
$staffLocalLive = false;
if (staff_is_local_dev() && is_file($localConn)) {
    $connections = $localConn;
    $staffLocalLive = true;
} else {
    $connections = staff_resolve_connections($empHome, $mobileRoot);
}
$staffPreview = !is_file($connections);
if ($staffPreview && staff_is_production_host()) {
    http_response_code(503);
    exit('Employee app cannot open the school database.');
}
$staffSnapshot = false;
$staffScript = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$staffLocalPicker = ($staffScript === 'local-real-user.php');

$staffSelf = isset($_SERVER['PHP_SELF']) ? str_replace('\\', '/', (string) $_SERVER['PHP_SELF']) : '';
$staffFile = isset($_SERVER['SCRIPT_FILENAME']) ? str_replace('\\', '/', (string) $_SERVER['SCRIPT_FILENAME']) : '';
$staffInKid = (strpos($staffSelf, '/kid/') !== false) || (strpos($staffFile, '/kid/') !== false);

function staff_local_picker_href()
{
    global $staffInKid, $staffLang, $empHome;
    $engPicker = $empHome . '/eng/local-real-user.php';
    if ($staffInKid) {
        return '../../eng/local-real-user.php';
    }
    if ($staffLang === 'arb' && is_file($engPicker)) {
        return '../eng/local-real-user.php';
    }
    return 'local-real-user.php';
}

if (isset($_GET['exit'])) {
    $_SESSION['MM_Username'] = null;
    $_SESSION['MM_Userid'] = null;
    $_SESSION['account_type'] = null;
    $_SESSION['phone_id'] = null;
    unset(
        $_SESSION['MM_Username'],
        $_SESSION['MM_Userid'],
        $_SESSION['account_type'],
        $_SESSION['phone_id'],
        $_SESSION['helalia_role'],
        $_SESSION['helalia_dual_kids'],
        $_SESSION['helalia_dual_key'],
        $_SESSION['helalia_local_test'],
        $_SESSION['helalia_snapshot_emp'],
        $_SESSION['helalia_emp_backup'],
        $_SESSION['helalia_role_pick_token'],
        $_SESSION['helalia_is_manual_dual']
    );
    setcookie('helalia_dual_pick', '', time() - 3600, '/');
    setcookie('helalia_dual_role', '', time() - 3600, '/');
    setcookie('helalia_dual_staff', '', time() - 3600, '/');
    $up = $staffInKid ? '../' : '';
    $loginUp = $staffInKid ? '../../../' : '../../';
    if ($staffLocalLive) {
        $dest = staff_local_picker_href();
    } else {
        $dest = $staffPreview ? ($up . 'emp-view.php') : ($loginUp . $loginFile);
    }
    if (function_exists('helalia_logout_and_redirect')) {
        helalia_logout_and_redirect($dest);
    }
    setcookie('helu', '', time() - (86400 * 400), '/');
    setcookie('help', '', time() - (86400 * 400), '/');
    header('Location: ' . $dest);
    exit;
}

$row_get_user = array('phone' => '');

if ($staffLocalLive && $_SERVER['REQUEST_METHOD'] === 'POST'
    && !in_array($staffScript, array(
        'choose-role.php',
        'local-real-user.php',
        'punch.php',
        'gps-handoff.php',
        'homework-step3.php',
        'homework-confirm-data.php',
        'homework-confirm-result.php',
        'revision-step3.php',
        'revision-confirm-data.php',
        'revision-confirm-result.php',
        'memo.php',
        'evaluation.php',
        'evaluation-start.php',
        'plan-upload.php',
        'view-question.php',
        'class-notify.php',
        'get_update_ex_result.php',
        'get_update_reg_result.php',
        'get_update_avg_result.php',
        'absence-collect-kids.php',
        'my-absence.php',
        'my-attendance.php',
        'profile.php',
    ), true)
) {
    $qs = (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '') ? ('?' . $_SERVER['QUERY_STRING']) : '';
    header('Location: ' . $staffScript . $qs);
    exit;
}

if ($staffPreview) {
    $empId = 0;
    $displayName = ($staffLang === 'arb') ? 'موظف تجريبي' : 'Preview employee';
    $jobLabel = ($staffLang === 'arb') ? 'كل الوظائف' : 'All school jobs';
    $initials = ($staffLang === 'arb') ? 'م' : 'PE';
    $row_get_user = array(
        'id' => 2,
        'emp_id' => 0,
        'phone' => '01000000000',
        'name' => $displayName,
        'email' => 'preview@helalia-ls.org',
        'picture' => '',
        'gender' => '1',
        'colors' => 1,
        'languages' => ($staffLang === 'arb') ? 1 : 2,
        'account_type' => 2,
    );
    $photoUrl = staff_photo_url($row_get_user);
    $old = 'https://system.helalia-ls.org/app/old/' . $staffLang . '/';
    $css = '../assets/css/helalia.css';
    $extraCss = '../assets/css/staff.css?v=74';
    $js = '../assets/js/staff.js?v=20';
    $icon = '../assets/img/logo-icon.png';
    $logo = '../assets/img/logo.png';
    $showStudent = $showHomework = $showRevision = $showMemo = true;
    $showPlan = $showEval = $showQuestions = $showControl = true;
    $showDirectQ = $showStaffAbs = $showNotify = true;
    $showAbsCollect = $showAbsConfirm = $showAbsAccept = true;
    $showAbsence = true;
    $showReplyQ = $showGroups = $showEvents = $showAppointments = true;
    $showStaffExc = true;
    $vacCount = 2;
    $eventCount = 1;
} else {
    require_once $connections;
    if ($staffLocalLive) {
        require_once __DIR__ . '/local-real-snapshot.php';
        $picker = staff_local_picker_href();
        $dbLive = (isset($database) && $database instanceof mysqli);
        if ($dbLive) {
            require_once __DIR__ . '/local-live-functions.php';
            if (isset($_GET['as'])) {
                $asId = (int) $_GET['as'];
                mysqli_select_db($database, $database_database);
                $asEsc = mysqli_real_escape_string($database, (string) $asId);
                $rs = mysqli_query($database, "SELECT * FROM `app_login` WHERE `id` = '{$asEsc}' AND `account_type` = 2 AND `emp_id` > 0 LIMIT 1");
                $asUser = $rs ? mysqli_fetch_assoc($rs) : null;
                if ($asUser) {
                    $_SESSION['MM_Username'] = $asUser['phone'];
                    $_SESSION['MM_Userid'] = (int) $asUser['id'];
                    $_SESSION['account_type'] = 2;
                    $_SESSION['helalia_local_test'] = 1;
                    unset($_SESSION['helalia_role'], $_SESSION['helalia_dual_kids'], $_SESSION['helalia_dual_key'], $_SESSION['helalia_is_manual_dual']);
                    header('Location: choose-role.php?fresh=1');
                    exit;
                }
            }
        }
        if (isset($_GET['as'])) {
            $person = local_real_snapshot_person($_GET['as']);
            if ($person) {
                $_SESSION['MM_Username'] = $person['phone'];
                $_SESSION['MM_Userid'] = (int) $person['id'];
                $_SESSION['account_type'] = 2;
                $_SESSION['helalia_local_test'] = 1;
                $_SESSION['helalia_snapshot_emp'] = $person;
                $_SESSION['helalia_dual_kids'] = local_real_pack_kids($person);
                $_SESSION['helalia_dual_key'] = $person['emp_id'] . ':' . $person['id'];
                unset($_SESSION['helalia_role'], $_SESSION['helalia_is_manual_dual']);
                header('Location: choose-role.php?fresh=1');
                exit;
            }
            header('Location: ' . $picker);
            exit;
        }
        if (empty($_SESSION['MM_Username']) || empty($_SESSION['MM_Userid'])) {
            header('Location: ' . $picker);
            exit;
        }
        if ($dbLive) {
            mysqli_select_db($database, $database_database);
            $uid = (int) $_SESSION['MM_Userid'];
            $rs = mysqli_query($database, "SELECT * FROM `app_login` WHERE `id` = '{$uid}' AND `account_type` = 2 LIMIT 1");
            $row_get_user = $rs ? mysqli_fetch_assoc($rs) : null;
        } else {
            $person = local_real_snapshot_person($_SESSION['MM_Userid']);
            if (!$person && isset($_SESSION['helalia_snapshot_emp'])) {
                $person = $_SESSION['helalia_snapshot_emp'];
            }
            if (!$person) {
                header('Location: ' . $picker);
                exit;
            }
            $_SESSION['helalia_snapshot_emp'] = $person;
            if (!function_exists('emp_name')) {
                function emp_name($id)
                {
                    $p = isset($_SESSION['helalia_snapshot_emp']) ? $_SESSION['helalia_snapshot_emp'] : array();
                    return isset($p['name']) ? $p['name'] : '';
                }
                function empjob($id)
                {
                    return 0;
                }
                function job_name($id)
                {
                    $p = isset($_SESSION['helalia_snapshot_emp']) ? $_SESSION['helalia_snapshot_emp'] : array();
                    return isset($p['job']) ? $p['job'] : '';
                }
                function app10access($id) { return 1; }
                function app11access($id) { return 1; }
                function app11_1access($id) { return 1; }
                function app11_2access($id) { return 1; }
                function app12access($id) { return staff_emp_perm($id, 'app12'); }
                function app12_0access($id) { return staff_emp_perm($id, 'app12_0'); }
                function app12_1access($id) { return staff_emp_perm($id, 'app12_1'); }
                function app12_2access($id) { return staff_emp_perm($id, 'app12_2'); }
                function app12_3access($id) { return staff_emp_perm($id, 'app12_3'); }
                function app12_4access($id) { return staff_emp_perm($id, 'app12_4'); }
                function app12_5access($id) { return staff_emp_perm($id, 'app12_5'); }
                function app13access($id) { return 1; }
                function app13_1access($id) { return 1; }
                function app13_1_0access($id) { return 1; }
                function app13_1_1access($id) { return 1; }
                function app13_1_2access($id) { return 1; }
                function app13_1_3access($id) { return 1; }
                function app13_1_4access($id) { return 1; }
                function app13_1_5access($id) { return 1; }
                function app14access($id) { return 1; }
                function app15access($id) { return 1; }
                function app15_1access($id) { return 1; }
                function app16access($id) { return 1; }
                function app16_0access($id) { return 1; }
                function app16_1access($id) { return 1; }
                function app16_2access($id) { return 1; }
                function app16_3access($id) { return 1; }
                function app16_4access($id) { return 1; }
                function app16_5access($id) { return 1; }
                function app17access($id) { return 1; }
                function app17_1access($id) { return 1; }
                function app18access($id) { return 1; }
                function app18_0access($id) { return 1; }
                function app18_1access($id) { return 1; }
                function app18_2access($id) { return 1; }
                function app18_3access($id) { return 1; }
                function app18_4access($id) { return 1; }
                function app18_5access($id) { return 1; }
                function app19access($id) { return staff_emp_perm($id, 'app19'); }
                function app19_1access($id) { return staff_emp_perm($id, 'app19_1'); }
                function teacher1($emp, $year) { return ((int) $year === 5) ? 1 : 0; }
                function teacher2($emp, $year, $class) { return ((int) $year === 5 && (int) $class > 0) ? 1 : 0; }
                function app20access($id)
                {
                    for ($i = 1; $i <= 7; $i++) {
                        if (staff_emp_perm($id, 'app20_' . $i)) {
                            return 1;
                        }
                    }
                    return 0;
                }
                function app20_8access($id) { return staff_emp_perm($id, 'app20_8'); }
                function app20access_edit($id) { return 0; }
                function app1_access($id) { return staff_emp_perm($id, 'app1'); }
                function app1_0access($id) { return staff_emp_perm($id, 'app1_0'); }
                function app1_1access($id) { return staff_emp_perm($id, 'app1_1'); }
                function app1_2access($id) { return staff_emp_perm($id, 'app1_2'); }
                function app1_3access($id) { return staff_emp_perm($id, 'app1_3'); }
                function app1_4access($id) { return staff_emp_perm($id, 'app1_4'); }
                function app1_5access($id) { return staff_emp_perm($id, 'app1_5'); }
                function app2_access($id) { return 1; }
                function app3_access($id) { return 1; }
                function app4_access($id) { return 1; }
                function app5_access($id) { return 1; }
                function app6_access($id) { return staff_emp_perm($id, 'app6'); }
                function app6_0access($id) { return staff_emp_perm($id, 'app6_0'); }
                function app6_1access($id) { return staff_emp_perm($id, 'app6_1'); }
                function app6_2access($id) { return staff_emp_perm($id, 'app6_2'); }
                function app6_3access($id) { return staff_emp_perm($id, 'app6_3'); }
                function app6_4access($id) { return staff_emp_perm($id, 'app6_4'); }
                function app6_5access($id) { return staff_emp_perm($id, 'app6_5'); }
                function app7_access($id) { return 1; }
                function app8_access($id) { return 1; }
                function app9_access($id) { return staff_emp_perm($id, 'app9'); }
                function app9_0access($id) { return staff_emp_perm($id, 'app9_0'); }
                function app9_1access($id) { return staff_emp_perm($id, 'app9_1'); }
                function app9_2access($id) { return staff_emp_perm($id, 'app9_2'); }
                function app9_3access($id) { return staff_emp_perm($id, 'app9_3'); }
                function app9_4access($id) { return staff_emp_perm($id, 'app9_4'); }
                function app9_5access($id) { return staff_emp_perm($id, 'app9_5'); }
                function cordnator($emp) { return 0; }
                function head($emp) { return 0; }
            }
            $row_get_user = array(
                'id' => (int) $person['id'],
                'emp_id' => (int) $person['emp_id'],
                'phone' => $person['phone'],
                'name' => $person['name'],
                'email' => '',
                'picture' => '',
                'gender' => '2',
                'colors' => 1,
                'languages' => 2,
                'account_type' => 2,
            );
        }
        if (!$row_get_user) {
            header('Location: ' . $picker);
            exit;
        }
    } else {
        staff_boot_live_auth($staffLang, $empHome, $mobileRoot);
        if (!function_exists('emp_name') && isset($database) && $database instanceof mysqli) {
            require_once __DIR__ . '/local-live-functions.php';
        }
        staff_ensure_user_row();
    }

    if (!function_exists('GetSQLValueString')) {
        function GetSQLValueString($conn, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
        {
            $theValue = (isset($conn) && $conn instanceof mysqli)
                ? mysqli_real_escape_string($conn, (string) $theValue)
                : addslashes((string) $theValue);
            switch ($theType) {
                case 'text':
                    return ($theValue !== '') ? "'" . $theValue . "'" : 'NULL';
                case 'int':
                case 'long':
                    return ($theValue !== '') ? (string) intval($theValue) : 'NULL';
                default:
                    return ($theValue !== '') ? "'" . $theValue . "'" : 'NULL';
            }
        }
    }

    if (!isset($row_get_user) || (int) $row_get_user['account_type'] !== 2) {
        $type = isset($row_get_user['account_type']) ? (int) $row_get_user['account_type'] : 0;
        // Dual Parent mode switches session to account_type=1. Opening choose-role
        // must restore the emp backup first — otherwise we bounce parent↔chooser forever.
        if (($type === 1 || $type === 4) && $staffScript === 'choose-role.php') {
            if (function_exists('dual_ensure_emp_backup_from_helu')) {
                dual_ensure_emp_backup_from_helu();
            }
            if (function_exists('dual_restore_emp_session_for_staff_boot')) {
                dual_restore_emp_session_for_staff_boot();
            }
            // Reload emp login row after restoring backup (Parent mode had switched to type 1).
            if (isset($database) && $database instanceof mysqli && !empty($_SESSION['MM_Userid'])) {
                $uidFix = (int) $_SESSION['MM_Userid'];
                mysqli_select_db($database, $database_database);
                $rsFix = mysqli_query($database, "SELECT * FROM `app_login` WHERE `id` = '{$uidFix}' AND `account_type` = 2 LIMIT 1");
                if ($rsFix && ($rowFix = mysqli_fetch_assoc($rsFix))) {
                    $row_get_user = $rowFix;
                }
            }
        }
    }
    if (!isset($row_get_user) || (int) $row_get_user['account_type'] !== 2) {
        $type = isset($row_get_user['account_type']) ? (int) $row_get_user['account_type'] : 0;
        if (($type === 1 || $type === 4) && $staffScript !== 'choose-role.php') {
            header('Location: ../../parent/' . $staffLang . '/parent-view.php');
            exit;
        }
        if ($type === 1 || $type === 4) {
            // Still parent after restore attempt — cannot show emp chooser.
            header('Location: ../../parent/' . $staffLang . '/parent-view.php');
            exit;
        }
        header('Location: ../../' . $loginFile);
        exit;
    }

    $empId = (int) $row_get_user['emp_id'];
    $displayName = trim((string) emp_name($empId));
    if ($displayName === '') {
        $displayName = trim((string) ($row_get_user['name'] ?? ''));
    }
    if ($displayName === '') {
        $displayName = (string) ($row_get_user['phone'] ?? '');
    }

    $jobLabel = '';
    if ($empId > 0) {
        $jobLabel = trim((string) job_name(empjob($empId)));
    }

    $parts = preg_split('/\s+/u', $displayName);
    $initials = '';
    if (!empty($parts[0])) {
        $initials .= function_exists('mb_substr') ? mb_substr($parts[0], 0, 1, 'UTF-8') : substr($parts[0], 0, 1);
    }
    if (!empty($parts[1])) {
        $initials .= function_exists('mb_substr') ? mb_substr($parts[1], 0, 1, 'UTF-8') : substr($parts[1], 0, 1);
    }
    if ($initials === '') {
        $initials = 'H';
    }
    $initials = function_exists('mb_strtoupper') ? mb_strtoupper($initials, 'UTF-8') : strtoupper($initials);

    $photoUrl = staff_photo_url($row_get_user);

    $old = 'https://system.helalia-ls.org/app/old/' . $staffLang . '/';
    $css = '../assets/css/helalia.css';
    $extraCss = '../assets/css/staff.css?v=74';
    $js = '../assets/js/staff.js?v=20';
    $icon = '../assets/img/logo-icon.png';
    $logo = '../assets/img/logo.png';
    $parentCss = $mobileRoot . '/parent/assets/css/helalia.css';
    if (!$staffLocalLive && is_file($parentCss)) {
        $css = '../../parent/assets/css/helalia.css?v=30';
        $icon = '../../parent/assets/img/logo-icon.png';
        $logo = '../../parent/assets/img/logo.png';
    }

    $showStudent = function_exists('app10access') && app10access($empId) == 1;
    $showHomework = (function_exists('app11access') && app11access($empId) == 1)
        || (function_exists('app11_2access') && app11_2access($empId) == 1);
    $showRevision = (function_exists('app15access') && app15access($empId) == 1)
        || (function_exists('app16access') && app16access($empId) == 1);
    $showMemo = (function_exists('app17access') && app17access($empId) == 1)
        || (function_exists('app18access') && app18access($empId) == 1);
    $showPlan = function_exists('app12access') && app12access($empId) == 1;
    $showEval = function_exists('app13access') && app13access($empId) == 1;
    // Questions: app20 flags, OR subjects.cor/head, OR job title Coordinator
    $showQuestions = ((function_exists('app20access') && app20access($empId) > 0)
        || (function_exists('cordnator') && cordnator($empId) > 0)
        || (function_exists('head') && head($empId) > 0)
        || (function_exists('staff_job_is_coordinator') && staff_job_is_coordinator($empId)));
    $showControl = function_exists('app19access') && app19access($empId) == 1;
    $showDirectQ = function_exists('app2_access') && app2_access($empId) == 1;
    $showStaffAbs = function_exists('app4_access') && app4_access($empId) == 1;
    $showNotify = function_exists('app8_access') && app8_access($empId) == 1;
    $showAbsCollect = function_exists('app1_access') && app1_access($empId) == 1;
    $showAbsConfirm = function_exists('app6_access') && app6_access($empId) == 1;
    $showAbsAccept = function_exists('app9_access') && app9_access($empId) == 1;
    $showAbsence = $showAbsCollect || $showAbsConfirm || $showAbsAccept;
    $showReplyQ = (function_exists('app7_access') && app7_access($empId) == 1)
        || (function_exists('app14access') && app14access($empId) == 1);
    $showGroups = function_exists('app3_access') && app3_access($empId) == 1;
    $showEvents = true;
    $showAppointments = true;
    $showStaffExc = function_exists('app5_access') && app5_access($empId) == 1;
    $staffSnapshot = $staffLocalLive && (!isset($database) || !($database instanceof mysqli));

    $vacCount = 0;
    $eventCount = 0;
    if (!$staffLocalLive) {
        if ($showStaffAbs) {
            mysqli_select_db($database, $database_database);
            $qVac = mysqli_query($database, "SELECT `id` FROM `emps_vacations` WHERE `status` = 0");
            $vacCount = $qVac ? (int) mysqli_num_rows($qVac) : 0;
        }
        mysqli_select_db($database, $database_database);
        $now = time();
        $qEv = mysqli_query($database, "SELECT `id` FROM `events` WHERE `start` >= '{$now}'");
        $eventCount = $qEv ? (int) mysqli_num_rows($qEv) : 0;
    }
}

require_once __DIR__ . '/dual-role.php';
$dualKids = dual_staff_children();
dual_gate();

if ($staffLang === 'arb') {
    $L = array(
        'home_title' => 'الرئيسية',
        'eyebrow' => 'موظف',
        'school' => 'مدرسة هلاليا للغات',
        'student' => 'الطلبة',
        'homework' => 'الواجب',
        'questions' => 'الأسئلة',
        'control' => 'الكنترول',
        'tools' => 'أدوات العمل',
        'revision' => 'المراجعة',
        'memo' => 'المذكرة',
        'plan' => 'الخطة الأسبوعية',
        'evaluation' => 'التقييم',
        'attention' => 'يحتاج متابعة',
        'direct_q' => 'أسئلة أولياء الأمور المباشرة',
        'staff_abs' => 'غياب الموظفين',
        'events' => 'الفعاليات',
        'nav_home' => 'الرئيسية',
        'nav_language' => 'اللغة',
        'nav_news' => 'آخر الأخبار',
        'news_empty' => 'لا توجد أخبار مدرسية حالياً.',
        'news_load_more' => 'عرض المزيد',
        'news_close' => 'إغلاق',
        'news_tap_more' => 'اضغط لقراءة المزيد',
        'news_photo' => 'صورة',
        'lang_pick' => 'اختر اللغة',
        'lang_pick_hint' => 'كيف تريد عرض التطبيق',
        'lang_en' => 'English',
        'lang_ar' => 'العربية',
        'nav_choices' => 'الخيارات',
        'nav_questions' => 'الأسئلة',
        'nav_profile' => 'الحساب',
        'choices_title' => 'خيارات الطلبة',
        'choices_lede' => 'نفس خدمات التطبيق القديم.',
        'choices_empty' => 'لا توجد خيارات متاحة لهذا الحساب.',
        'office_tools' => 'أدوات المكتب',
        'nav_fab_notify' => 'إشعار الطلاب',
        'nav_fab_checkin' => 'تسجيل الحضور',
        'notify' => 'إشعار الطلاب',
        'student_opts' => 'خيارات الطلبة',
        'emp_opts' => 'خيارات الموظفين',
        'class_notify' => 'إشعار الطلاب',
        'absence' => 'الغياب',
        'absence_lede' => 'حصر وتأكيد وقبول غياب الطلاب',
        'absence_empty' => 'لا توجد صلاحيات للغياب',
        'absence_year_invalid' => 'سنة دراسية غير صالحة',
        'absence_class_invalid' => 'فصل غير صالح',
        'absence_stage_invalid' => 'مرحلة غير صالحة',
        'absence_collect' => 'حصر الغياب',
        'absence_confirm' => 'تأكيد الغياب',
        'absence_accept' => 'قبول الغياب',
        'questions_direct' => 'أسئلة أولياء الأمور المباشرة',
        'questions_reply' => 'الرد على أسئلة أولياء الأمور',
        'groups' => 'المجموعات',
        'appointments' => 'المواعيد',
        'staff_abs_approvals' => 'موافقات غياب الموظفين',
        'staff_excuses' => 'أذونات الموظفين',
        'settings' => 'الإعدادات',
        'profile' => 'الملف الشخصي',
        'password' => 'تغيير كلمة المرور',
        'my_absence' => 'الغياب',
        'my_excuse' => 'الإذن',
        'my_attendance' => 'الحضور',
        'exit' => 'خروج',
        'navigation' => 'القائمة',
        'languages' => 'اللغات',
        'back' => 'رجوع',
        'menu' => 'القائمة',
        'close' => 'إغلاق',
        'lang' => 'English',
        'lang_href' => '../eng/' . basename($_SERVER['PHP_SELF']),
        'save_profile' => 'حفظ الملف',
        'save_password' => 'حفظ كلمة المرور',
        'field_name' => 'الاسم',
        'field_email' => 'البريد الإلكتروني',
        'field_phone' => 'الهاتف',
        'profile_job' => 'الوظيفة',
        'profile_emp_id' => 'رقم الموظف',
        'profile_years' => 'السنوات الدراسية',
        'profile_school' => 'سجل المدرسة',
        'profile_account' => 'حساب التطبيق',
        'profile_gender' => 'النوع',
        'gender_m' => 'ذكر',
        'gender_f' => 'أنثى',
        'profile_dash' => '—',
        'profile_edit' => 'تعديل الملف',
        'edit_name' => 'تعديل الاسم',
        'edit_email' => 'تعديل البريد الإلكتروني',
        'change_password' => 'تغيير كلمة المرور',
        'updated' => 'تم التحديث بنجاح',
        'action_uploaded' => 'تم الرفع بنجاح',
        'action_deleted' => 'تم الحذف بنجاح',
        'action_saved' => 'تم الحفظ بنجاح',
        'action_sent' => 'تم إرسال الرسالة بنجاح',
        'action_confirmed' => 'تم التأكيد بنجاح',
        'action_working' => 'جاري العمل…',
        'action_ok' => 'حسنًا',
        'preview_note' => 'معاينة فقط — لم يُحفظ في قاعدة البيانات',
        'vac_not_settled' => 'غياب غير مُسوّى',
        'vac_settled' => 'غياب مُسوّى',
        'submit_vacation' => 'تقديم إجازة جديدة',
        'submit_excuse' => 'تقديم إذن جديد',
        'pending_excuses' => 'أذونات قيد الانتظار',
        'excuses_settled' => 'أذونات مُسوّاة',
        'vac_start' => 'تاريخ بداية الإجازة',
        'vac_end' => 'تاريخ نهاية الإجازة',
        'vac_return_hint' => 'يوم العودة إلى العمل',
        'days_label' => 'أيام',
        'type_label' => 'النوع',
        'attach' => 'إرفاق',
        'brief' => 'وصف مختصر',
        'submit_vac_btn' => 'تقديم الإجازة',
        'submit_exc_btn' => 'تقديم الإذن',
        'excuse_date' => 'تاريخ الإذن',
        'excuse_start' => 'بداية الإذن',
        'excuse_return' => 'ساعة العودة إلى العمل',
        'hours_label' => 'ساعات',
        'view_vacation' => 'عرض الإجازة',
        'view_excuse' => 'عرض الإذن',
        'attached' => 'مرفق',
        'uploaded' => 'تم الرفع',
        'att_in' => 'دخول',
        'att_out' => 'خروج',
        'att_delay' => 'تأخير',
        'att_early' => 'انصراف مبكر',
        'att_date' => 'التاريخ',
        'att_from' => 'من',
        'att_to' => 'إلى',
        'att_submit' => 'عرض',
        'att_lede' => 'سجلات الحضور والانصراف خلال الفترة المحددة',
        'att_report_btn' => 'تقرير الحضور',
        'att_absent' => 'غائب',
        'vac_1' => 'اعتيادي',
        'vac_2' => 'عاجل',
        'vac_3' => 'مرضي',
        'vac_4' => 'وضع',
        'vac_5' => 'استثنائي',
        'vac_6' => 'زواج',
        'vac_7' => 'وفاة',
        'vac_8' => 'بدون راتب',
        'st_pending' => 'قيد الانتظار',
        'st_accepted' => 'مقبول',
        'st_rejected' => 'مرفوض',
        'st_canceled' => 'ملغي',
        'empty_list' => 'لا يوجد شيء للعرض',
        'change_photo' => 'تغيير الصورة',
        'photo_saved' => 'تم حفظ صورة الملف الشخصي بنجاح',
        'photo_failed' => 'تعذر حفظ الصورة. حاول مرة أخرى.',
        'password_label' => 'كلمة المرور',
        'day_one' => 'يوم',
        'day_many' => 'أيام',
        'type_prefix' => 'النوع:',
        'not_found' => 'غير موجود',
        'hours_word' => 'ساعات',
        'checkin' => 'سجل الحضور',
        'checkin_open' => 'سجل الحضور',
        'checkin_hint' => '',
        'loc_title' => 'الموقع',
        'loc_off' => 'الموقع غير مفعّل',
        'loc_ask' => 'جاري طلب إذن الموقع…',
        'loc_ask_hint' => 'اضغط سماح إذا ظهرت رسالة من الهاتف.',
        'loc_checking' => 'جاري تحديد موقعك…',
        'loc_ios' => 'تطبيق Helalia على الآيفون لا يملك إذن GPS (الإعدادات تظهر When I Share فقط). التطبيقات الأخرى تطلب الموقع عند الفتح لأن ذلك مبني داخل التطبيق. افتح Safari للسماح بالموقع ثم ارجع.',
        'loc_safari' => 'فتح في Safari',
        'loc_safari_hint' => 'Safari سيطلب Allow. بعد السماح ارجع لتطبيق Helalia.',
        'loc_denied' => 'تم رفض الموقع. فعّله من إعدادات الهاتف ثم اضغط طلب الموقع.',
        'loc_timeout' => 'لم يصل الموقع. اضغط طلب الموقع، أو فعّل الموقع من إعدادات الهاتف.',
        'loc_enable' => 'طلب الموقع',
        'loc_retry' => 'طلب الموقع',
        'loc_https' => 'افتح الصفحة عبر https حتى يعمل الموقع على الهاتف.',
        'loc_unsupported' => 'هذا المتصفح لا يدعم الموقع.',
        'loc_on' => 'الموقع مفعّل',
        'loc_inside' => 'أنت داخل سور المدرسة',
        'loc_outside' => 'أنت خارج سور المدرسة',
        'loc_accuracy' => 'دقة الموقع ضعيفة',
        'loc_away' => 'أنت على بعد {d} من المدرسة',
        'today_title' => 'اليوم',
        'today_empty' => 'لم يتم تسجيل الحضور بعد',
        'today_recorded' => 'تم تسجيل الحضور',
        'checkin_btn' => 'سجل الحضور',
        'checkout_btn' => 'سجل الانصراف',
        'checkout_closed' => 'انتهى وقت الانصراف الساعة 6:00 م. لم يُسجَّل انصراف.',
        'worked_label' => 'ساعات العمل',
        'punch_wait' => 'جاري التسجيل…',
        'err_preview' => 'معاينة فقط — لم يُحفظ في قاعدة البيانات',
        'err_outside' => 'يجب أن تكون داخل سور المدرسة',
        'err_accuracy' => 'دقة الموقع غير كافية',
        'err_already_in' => 'تم تسجيل الحضور اليوم',
        'err_already_out' => 'تم تسجيل الانصراف اليوم',
        'err_need_in' => 'سجّل الحضور أولاً',
        'err_vacation' => 'أنت في إجازة اليوم',
        'err_too_soon' => 'انتظر دقيقتين بعد الحضور',
        'err_checkout_closed' => 'انتهى وقت الانصراف الساعة 6:00 م. لم يُسجَّل انصراف.',
        'err_csrf' => 'انتهت الجلسة. حدّث الصفحة.',
        'err_rate' => 'حاول مرة أخرى بعد لحظات',
        'err_generic' => 'تعذر التسجيل. حاول مرة أخرى.',
        'role_title' => 'اختر حساباً',
        'role_hello' => 'مرحباً',
        'role_hint' => 'اختر حساباً',
        'role_emp' => 'موظف',
        'role_emp_meta' => 'أدوات المدرسة والحضور والعمل',
        'role_parent' => 'ولي أمر',
        'role_parent_meta' => 'متابعة أبنائك في المدرسة',
        'role_found' => 'حسابان على نفس الرقم',
        'role_kids' => 'أبناء',
        'role_switch' => 'تبديل الحساب',
        'role_as_parent' => 'وضع ولي الأمر',
        'role_as_emp' => 'وضع الموظف',
        'parent_home' => 'أبنائي',
        'parent_eyebrow' => 'ولي الأمر',
        'parent_dash' => 'لوحة الأبناء',
        'parent_student' => 'طالب',
        'parent_hub' => 'ملف الطالب',
        'parent_everything' => 'كل ما يخص هذا الطالب',
        'parent_today' => 'اليوم',
        'parent_file' => 'بيانات الطالب',
        'parent_absence' => 'الغياب',
        'parent_vacation' => 'الإجازة',
        'parent_alerts' => 'التنبيهات',
        'parent_ask' => 'اسأل المدرسة',
        'parent_calendar' => 'التقويم',
        'parent_summary' => 'الملخص',
        'parent_homework' => 'الواجب',
        'parent_memo' => 'المذكرة',
        'parent_results' => 'النتائج',
        'parent_revision' => 'المراجعة',
        'parent_plan' => 'الخطة الأسبوعية',
        'parent_gallery' => 'المعرض',
        'parent_tool_soon' => 'هذه الأداة بنفس مسار ولي الأمر. سنربطها بالبيانات الحية في الخطوة التالية.',
        'parent_open_file' => 'فتح ملف الطالب',
        'parent_empty' => 'لا يوجد أبناء مرتبطون بهذا الحساب',
        'parent_mode_bar' => 'تتابع أبناءك الآن',
        'parent_news' => 'الأخبار',
        'parent_students_nav' => 'الطلاب',
        'parent_id' => 'رقم الطالب:',
        'parent_add' => 'إضافة ابن',
        'parent_attendance' => 'الملخص',
        'parent_news_empty' => 'لا توجد أخبار الآن',
        'parent_edu_id' => 'الرقم التعليمي',
        'parent_homework_live' => 'الواجبات',
        'parent_memo_live' => 'المذكرات',
        'mother_of' => 'الأم',
        'father_of' => 'الأب',
    );
} else {
    $L = array(
        'home_title' => 'Home',
        'eyebrow' => 'Employee',
        'school' => 'Helalia Language School',
        'student' => 'Student',
        'homework' => 'Homework',
        'questions' => 'Questions',
        'control' => 'Control',
        'tools' => 'School tools',
        'revision' => 'Revision',
        'memo' => 'Memo',
        'plan' => 'Weekly plan',
        'evaluation' => 'Evaluation',
        'attention' => 'Needs attention',
        'direct_q' => 'Direct parents questions',
        'staff_abs' => 'Staff absence',
        'events' => 'Events',
        'nav_home' => 'Home',
        'nav_language' => 'Language',
        'nav_news' => 'Latest News',
        'news_empty' => 'No school news right now.',
        'news_load_more' => 'Load more',
        'news_close' => 'Close',
        'news_tap_more' => 'Tap to read more',
        'news_photo' => 'Photo',
        'lang_pick' => 'Choose language',
        'lang_pick_hint' => 'How the app is shown',
        'lang_en' => 'English',
        'lang_ar' => 'العربية',
        'nav_choices' => 'Choices',
        'nav_questions' => 'Questions',
        'nav_profile' => 'Profile',
        'choices_title' => 'Student options',
        'choices_lede' => 'Same services as the old app.',
        'choices_empty' => 'No options are available for this account.',
        'office_tools' => 'Office tools',
        'nav_fab_notify' => 'Student notification',
        'nav_fab_checkin' => 'Check in',
        'notify' => 'Student notification',
        'student_opts' => 'Student options',
        'emp_opts' => 'Employee options',
        'class_notify' => 'Student notification',
        'absence' => 'Absence',
        'absence_lede' => 'Collect, confirm and accept student absence',
        'absence_empty' => 'No absence permissions for this account',
        'absence_year_invalid' => 'Invalid study year',
        'absence_class_invalid' => 'Invalid class',
        'absence_stage_invalid' => 'Invalid stage',
        'absence_collect' => 'Collect absence',
        'absence_confirm' => 'Confirm absence',
        'absence_accept' => 'Accept absence',
        'questions_direct' => 'Direct parent questions',
        'questions_reply' => 'Reply to parent questions',
        'groups' => 'Groups',
        'appointments' => 'Appointments',
        'staff_abs_approvals' => 'Staff absence approvals',
        'staff_excuses' => 'Staff excuses',
        'settings' => 'Settings',
        'profile' => 'Profile',
        'password' => 'Change Password',
        'my_absence' => 'Absence',
        'my_excuse' => 'Excuse',
        'my_attendance' => 'Attendance',
        'exit' => 'Sign out',
        'navigation' => 'Navigation',
        'languages' => 'Languages',
        'back' => 'Back',
        'menu' => 'Menu',
        'close' => 'Close',
        'lang' => 'العربية',
        'lang_href' => '../arb/' . basename($_SERVER['PHP_SELF']),
        'save_profile' => 'Save Profile',
        'save_password' => 'Save Password',
        'field_name' => 'Name',
        'field_email' => 'Email',
        'field_phone' => 'Phone',
        'profile_job' => 'Job',
        'profile_emp_id' => 'Employee ID',
        'profile_years' => 'Years taught',
        'profile_school' => 'School record',
        'profile_account' => 'App account',
        'profile_gender' => 'Gender',
        'gender_m' => 'Male',
        'gender_f' => 'Female',
        'profile_dash' => '—',
        'profile_edit' => 'Edit profile',
        'edit_name' => 'Edit name',
        'edit_email' => 'Edit email',
        'change_password' => 'Change password',
        'updated' => 'Updated successfully',
        'action_uploaded' => 'Uploaded successfully',
        'action_deleted' => 'Deleted successfully',
        'action_saved' => 'Saved successfully',
        'action_sent' => 'Message sent successfully',
        'action_confirmed' => 'Confirmed successfully',
        'action_working' => 'Working…',
        'action_ok' => 'OK',
        'preview_note' => 'Preview only — not saved to the database',
        'vac_not_settled' => 'Absences not settled',
        'vac_settled' => 'Absences settled',
        'submit_vacation' => 'Submit new vacation',
        'submit_excuse' => 'Submit new excuse',
        'pending_excuses' => 'Pending excuses',
        'excuses_settled' => 'Excuses settled',
        'vac_start' => 'Vacation start date',
        'vac_end' => 'Vacation end date',
        'vac_return_hint' => 'The day of returning to work',
        'days_label' => 'Days',
        'type_label' => 'Type',
        'attach' => 'Attach',
        'brief' => 'Brief description',
        'submit_vac_btn' => 'Submit vacation',
        'submit_exc_btn' => 'Submit excuse',
        'excuse_date' => 'Excuse date',
        'excuse_start' => 'Excuse start on',
        'excuse_return' => 'Hour of returning to work',
        'hours_label' => 'Hours',
        'view_vacation' => 'View vacation',
        'view_excuse' => 'View excuse',
        'attached' => 'Attached',
        'uploaded' => 'Uploaded',
        'att_in' => 'In',
        'att_out' => 'Out',
        'att_delay' => 'Delay',
        'att_early' => 'Early',
        'att_date' => 'Date',
        'att_from' => 'From',
        'att_to' => 'To',
        'att_submit' => 'Submit',
        'att_lede' => 'Your check-in and check-out records for the selected period',
        'att_report_btn' => 'Attendance report',
        'att_absent' => 'Absent',
        'vac_1' => 'Regular',
        'vac_2' => 'Urgent',
        'vac_3' => 'Sick',
        'vac_4' => 'Pregnancy',
        'vac_5' => 'Exceptional',
        'vac_6' => 'Marriage',
        'vac_7' => 'Death',
        'vac_8' => 'with no salary',
        'st_pending' => 'Pending',
        'st_accepted' => 'Accepted',
        'st_rejected' => 'Rejected',
        'st_canceled' => 'Canceled',
        'empty_list' => 'Nothing to show yet',
        'change_photo' => 'Change picture',
        'photo_saved' => 'Your profile photo has been saved',
        'photo_failed' => 'Could not save the photo. Please try again.',
        'password_label' => 'Password',
        'day_one' => 'Day',
        'day_many' => 'Days',
        'type_prefix' => 'Type:',
        'not_found' => 'Not found',
        'hours_word' => 'Hours',
        'checkin' => 'Record attendance',
        'checkin_open' => 'Record attendance',
        'checkin_hint' => '',
        'loc_title' => 'Location',
        'loc_off' => 'Location is off',
        'loc_ask' => 'Getting location…',
        'loc_ask_hint' => 'Tap Allow if the phone asks.',
        'loc_checking' => 'Finding your location…',
        'loc_ios' => 'The Helalia iPhone app cannot show the usual location popup. Settings only has When I Share because this app was never given GPS. Other apps ask on first open because they built that in. Tap Open in Safari — Safari will ask Allow. Then return here.',
        'loc_safari' => 'Open in Safari',
        'loc_safari_hint' => 'Safari will ask Allow. After you allow, return to the Helalia app.',
        'loc_denied' => 'Location denied. Turn it on in phone settings, then tap Ask for location.',
        'loc_timeout' => 'No GPS yet. Tap Ask for location, or turn Location on in Settings.',
        'loc_enable' => 'Ask for location',
        'loc_retry' => 'Ask for location',
        'loc_https' => 'Open this page with https so location works on a phone.',
        'loc_unsupported' => 'This browser cannot use location.',
        'loc_on' => 'Location is on',
        'loc_inside' => 'You are inside the school fence',
        'loc_outside' => 'You are outside the school fence',
        'loc_accuracy' => 'GPS accuracy is too weak',
        'loc_away' => 'You are {d} away from school',
        'today_title' => 'Today',
        'today_empty' => 'Not checked in yet',
        'today_recorded' => 'Recorded attendance',
        'checkin_btn' => 'Record attendance',
        'checkout_btn' => 'Record departure',
        'checkout_closed' => 'Record departure closed at 6:00 PM. No departure was recorded.',
        'worked_label' => 'Worked',
        'punch_wait' => 'Saving…',
        'err_preview' => 'Preview only — not saved to the database',
        'err_outside' => 'You must be inside the school fence',
        'err_accuracy' => 'GPS accuracy is not good enough',
        'err_already_in' => 'Already checked in today',
        'err_already_out' => 'Already checked out today',
        'err_need_in' => 'Check in first',
        'err_vacation' => 'You are on vacation today',
        'err_too_soon' => 'Wait two minutes after check in',
        'err_checkout_closed' => 'Record departure closed at 6:00 PM. No departure was recorded.',
        'err_csrf' => 'Session expired. Refresh the page.',
        'err_rate' => 'Try again in a moment',
        'err_generic' => 'Could not save. Try again.',
        'role_title' => 'Choose an Account',
        'role_hello' => 'Welcome',
        'role_hint' => 'Choose an Account',
        'role_emp' => 'Employee',
        'role_emp_meta' => 'School work, attendance, and tools',
        'role_parent' => 'Parent',
        'role_parent_meta' => 'Follow your children at school',
        'role_found' => 'Two profiles on this number',
        'role_kids' => 'children',
        'role_switch' => 'Switch role',
        'role_as_parent' => 'Parent mode',
        'role_as_emp' => 'Employee mode',
        'parent_home' => 'My children',
        'parent_eyebrow' => 'Parent',
        'parent_dash' => 'My dashboard',
        'parent_student' => 'Student',
        'parent_hub' => 'Student',
        'parent_everything' => 'Everything for this student',
        'parent_today' => 'Today',
        'parent_file' => 'Student file',
        'parent_absence' => 'Absence',
        'parent_vacation' => 'Vacation',
        'parent_alerts' => 'Alerts',
        'parent_ask' => 'Ask school',
        'parent_calendar' => 'Calendar',
        'parent_summary' => 'Summary',
        'parent_homework' => 'Homework',
        'parent_memo' => 'Memo',
        'parent_results' => 'Results',
        'parent_revision' => 'Revision',
        'parent_plan' => 'Weekly plan',
        'parent_gallery' => 'Gallery',
        'parent_tool_soon' => 'This follows the parent app for this child. Live data for this tool will connect next.',
        'parent_open_file' => 'Open student file',
        'parent_empty' => 'No children are linked to this account',
        'parent_mode_bar' => 'You are following your children',
        'parent_news' => 'Latest News',
        'parent_students_nav' => 'Students',
        'parent_id' => 'ID#:',
        'parent_add' => 'Add child',
        'parent_attendance' => 'Attendance',
        'parent_news_empty' => 'No news right now',
        'parent_edu_id' => 'Education ID',
        'parent_homework_live' => 'Homework',
        'parent_memo_live' => 'Memo',
        'mother_of' => 'Mother',
        'father_of' => 'Father',
    );
}

function staff_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function staff_homework_dir()
{
    $dir = '';
    if (function_exists('staff_site_dir')) {
        $dir = staff_site_dir('homework');
    }
    if ($dir === '' || !is_dir($dir)) {
        $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'homework';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
    return $dir;
}

function staff_homework_url($name)
{
    $name = trim((string) $name);
    if ($name === '' || strcasecmp($name, 'null') === 0) {
        return '';
    }
    $name = basename(str_replace('\\', '/', $name));
    if (staff_is_production_host()) {
        return 'https://system.helalia-ls.org/homework/' . rawurlencode($name);
    }
    $local = staff_homework_dir() . DIRECTORY_SEPARATOR . $name;
    if (is_file($local)) {
        return '../homework/' . rawurlencode($name);
    }
    global $staffPreview;
    if (!empty($staffPreview)) {
        return '';
    }
    return 'https://system.helalia-ls.org/homework/' . rawurlencode($name);
}

function staff_homework_copy()
{
    global $empId, $row_get_user, $errors;
    $errors = 0;
    if (!isset($_FILES['picture']) || !is_array($_FILES['picture'])) {
        return null;
    }
    // Upload error mn el phone (size / cancel / network)
    $upErr = isset($_FILES['picture']['error']) ? (int) $_FILES['picture']['error'] : UPLOAD_ERR_NO_FILE;
    if ($upErr !== UPLOAD_ERR_OK) {
        if ($upErr !== UPLOAD_ERR_NO_FILE) {
            $errors = 1;
        }
        return null;
    }
    $image = isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : '';
    if (!$image) {
        return null;
    }
    $filename = stripslashes((string) $_FILES['picture']['name']);
    $i = strrpos($filename, '.');
    $extension = ($i !== false) ? strtolower(substr($filename, $i + 1)) : '';
    // jpg - png - pdf - doc (+ jpeg/docx); gif/webp ok lel HW/memo el adeem
    if (!in_array($extension, array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'webp'), true)) {
        $errors = 1;
        return null;
    }
    $tmp = isset($_FILES['picture']['tmp_name']) ? $_FILES['picture']['tmp_name'] : '';
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        $errors = 1;
        return null;
    }
    if (filesize($tmp) / 1000 > 80000) {
        $errors = 1;
        return null;
    }
    $eid = !empty($empId) ? (int) $empId : (int) ($row_get_user['emp_id'] ?? 0);
    $imageName = $eid . '-' . time() . '.' . $extension;
    $dest = staff_homework_dir() . DIRECTORY_SEPARATOR . $imageName;
    // move_uploaded_file awla — a7san 3ala mobile; copy fallback
    if (!@move_uploaded_file($tmp, $dest) && !@copy($tmp, $dest)) {
        $errors = 1;
        return null;
    }
    return $imageName;
}

function staff_photo_url($row)
{
    $uploads = 'https://system.helalia-ls.org/uploads/';
    $pic = trim((string) ($row['picture'] ?? ''));
    if ($pic !== '' && strcasecmp($pic, 'null') !== 0) {
        $pic = basename(str_replace('\\', '/', $pic));
        return $uploads . rawurlencode($pic);
    }
    $gender = (string) ($row['gender'] ?? '1');
    if ($gender !== '1' && $gender !== '2') {
        $gender = '1';
    }
    return $uploads . 'no-picture-' . $gender . '.png';
}

function staff_ico($name)
{
    $icons = array(
        'people' => '<circle cx="9" cy="8" r="3.5"/><path d="M3.5 19a5.5 5.5 0 0 1 11 0"/><circle cx="17" cy="9" r="2.5"/><path d="M14.5 19a4.5 4.5 0 0 1 6 0"/>',
        'book' => '<path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M8 13h8M8 17h6"/>',
        'chat' => '<path d="M5 18 4 21l3.2-1.2A9 9 0 1 0 5 18z"/>',
        'star' => '<path d="m12 3 2.7 5.5 6 .9-4.4 4.3 1 6L12 16.8 6.7 19.7l1-6L3.3 9.4l6-.9L12 3z"/>',
        'file' => '<path d="M4 5a3 3 0 0 1 3-2h13v16H7a3 3 0 0 0-3 3V5z"/><path d="M4 19a3 3 0 0 1 3-3h13"/>',
        'pin' => '<path d="M8 4h8a2 2 0 0 1 2 2v14l-6-3-6 3V6a2 2 0 0 1 2-2z"/>',
        'list' => '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 9h8M8 13h8M8 17h5"/>',
        'bars' => '<path d="M4 19V5m5 14V9m5 10V7m5 12V11"/>',
        'flag' => '<path d="M5 21V4m0 0h11l-2 4 2 4H5"/>',
        'home' => '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5z"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
        'user' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 19a7 7 0 0 1 14 0"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'bell' => '<path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="M6 6l12 12M18 6 6 18"/>',
        'cog' => '<circle cx="12" cy="12" r="3"/><path d="M12 3v2m0 14v2M3 12h2m14 0h2m-3.05-6.95 1.4-1.4M5.65 18.35l1.4-1.4m0-9.9-1.4-1.4m12.7 12.7-1.4-1.4"/>',
        'key' => '<circle cx="8" cy="14" r="3.5"/><path d="M11 12.5 20 4v4h-3"/>',
        'thermo' => '<path d="M10 14.5V6a2 2 0 1 1 4 0v8.5a3.5 3.5 0 1 1-4 0z"/>',
        'hourglass' => '<path d="M7 4h10M7 20h10M8 4c0 4 8 4 8 8s-8 4-8 8M16 4c0 4-8 4-8 8s8 4 8 8"/>',
        'clipboard' => '<rect x="6" y="5" width="12" height="16" rx="2"/><path d="M9 5V4h6v1M9 10h6M9 14h4"/>',
        'logout' => '<path d="M10 6H6v12h4M14 16l4-4-4-4M9 12h9"/>',
        'laptop' => '<rect x="4" y="5" width="16" height="11" rx="1.5"/><path d="M2 19h20"/>',
        'pencil' => '<path d="M13 5 19 11M4 20l1.5-6L16.5 3 21 7.5 10 18.5 4 20z"/>',
        'chevron' => '<path d="M15 6 9 12l6 6"/>',
        'chevron-down' => '<path d="M6 9l6 6 6-6"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.4 2.7 3.7 5.8 3.7 9s-1.3 6.3-3.7 9c-2.4-2.7-3.7-5.8-3.7-9S9.6 5.7 12 3z"/>',
        'check' => '<path d="M4 12.5 9 17.5 20 6.5"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.2l3.4 2"/>',
        'calendar' => '<rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/>',
        'send' => '<path d="M4 12 20 4l-7 16-1.5-6.5L4 12z"/>',
        'trash' => '<path d="M4 7h16M9 7V5h6v2m-8 0v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V7"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
        'upload' => '<path d="M12 16V6m0 0-4 4m4-4 4 4M5 19h14"/>',
        'download' => '<path d="M12 5v10m0 0 4-4m-4 4-4-4M5 19h14"/>',
        'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-3.2-3.2"/>',
        'map-pin' => '<path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
        'heart' => '<path d="M12 20s-7-4.35-7-10a4 4 0 0 1 7-2 4 4 0 0 1 7 2c0 5.65-7 10-7 10z"/>',
        'briefcase' => '<rect x="3" y="8" width="18" height="12" rx="2"/><path d="M8 8V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 13h18"/>',
        'family' => '<circle cx="8" cy="7" r="3"/><path d="M3 20v-1.5A4.5 4.5 0 0 1 7.5 14h1A4.5 4.5 0 0 1 13 18.5V20"/><circle cx="17" cy="10" r="2.4"/><path d="M14.2 20v-1.2A3.3 3.3 0 0 1 17.5 15.6h.4A3.3 3.3 0 0 1 21 18.8V20"/>',
        'swap' => '<path d="M7 7h11l-3.5-3M17 17H6l3.5 3"/>',
        'camera' => '<path d="M4 8h3l2-2h6l2 2h3v11H4V8z"/><circle cx="12" cy="13" r="3.5"/>',
        'cap' => '<path d="m3 10 9-5 9 5-9 5-9-5z"/><path d="M7 12v5c3 2 7 2 10 0v-5"/>',
    );
    $d = isset($icons[$name]) ? $icons[$name] : $icons['star'];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
}

function staff_head($title, $dir, $css, $icon)
{
    global $extraCss;
    if (!headers_sent()) {
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
    $lang = ($dir === 'rtl') ? 'ar' : 'en';
    echo '<!DOCTYPE html><html lang="' . $lang . '" dir="' . $dir . '"><head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">';
    echo '<meta name="theme-color" content="#112c5a">';
    echo '<meta name="apple-mobile-web-app-capable" content="yes">';
    echo '<title>' . staff_h($title) . ' · Helalia</title>';
    echo '<link rel="icon" href="' . staff_h($icon) . '">';
    echo '<link rel="apple-touch-icon" href="' . staff_h($icon) . '">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    if ($dir === 'rtl') {
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=optional">';
    } else {
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=optional">';
    }
    echo '<link rel="stylesheet" href="' . staff_h($css) . '">';
    if (!empty($extraCss)) {
        echo '<link rel="stylesheet" href="' . staff_h($extraCss) . '">';
    }
    $appClass = !empty($GLOBALS['staffHideChrome']) ? 'app app--choose' : 'app';
    $dualAttr = (function_exists('dual_has_dual') && dual_has_dual()) ? ' data-helalia-dual="1"' : '';
    echo '</head><body' . $dualAttr . '><div class="' . $appClass . '">';
}

function staff_header_actions()
{
    global $L;
    $onNews = (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'staff-news.php');
    echo '<div class="hero__actions">';
    if (!$onNews) {
        if (!function_exists('staff_news_href')) {
            require_once __DIR__ . '/staff-timeline.php';
        }
        echo '<a class="menu-btn menu-btn--news" href="' . staff_h(staff_news_href()) . '" aria-label="' . staff_h($L['nav_news']) . '">' . staff_ico('bell') . '</a>';
    }
    echo '<button class="menu-btn menu-btn--lang" type="button" data-lang-open aria-expanded="false" aria-controls="lang-sheet" aria-label="' . staff_h($L['nav_language']) . '">' . staff_ico('globe') . '</button>';
    echo '</div>';
}

function staff_inner($title, $backHref = 'emp-view.php', $navActive = 'home')
{
    global $L, $css, $icon, $staffLang;
    if ($backHref === '' || $backHref === null) {
        $backHref = function_exists('staff_home_href') ? staff_home_href() : 'emp-view.php';
    }
    $GLOBALS['staffInnerNav'] = $navActive;
    $dir = ($staffLang === 'arb') ? 'rtl' : 'ltr';
    staff_head($title, $dir, $css, $icon);
    echo '<header class="hero hero--staff hero--inner">';
    echo '<div class="hero__row">';
    echo '<a class="back" href="' . staff_h($backHref) . '" aria-label="' . staff_h($L['back']) . '">' . staff_ico('chevron') . '</a>';
    echo '<h1 class="hero__title">' . staff_h($title) . '</h1>';
    staff_header_actions();
    echo '</div></header>';
    echo '<main class="page page--staff page--fab">';
}

function staff_inner_end($navActive = null)
{
    echo '</main>';
    if ($navActive === null) {
        $navActive = isset($GLOBALS['staffInnerNav']) ? $GLOBALS['staffInnerNav'] : 'home';
    }
    staff_nav($navActive);
}

function staff_action_shell()
{
    global $L;
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;
    echo '<div class="staff-working" id="staff-working" hidden aria-hidden="true">';
    echo '<div class="staff-working__card" role="status" aria-live="polite">';
    echo '<span class="staff-working__spin" aria-hidden="true"></span>';
    echo '<p class="staff-working__text" id="staff-working-text">' . staff_h($L['action_working']) . '</p>';
    echo '</div></div>';
    echo '<div class="staff-success" id="staff-success" hidden aria-hidden="true">';
    echo '<div class="staff-success__veil" data-staff-success-close tabindex="-1"></div>';
    echo '<div class="staff-success__card" role="alertdialog" aria-modal="true" aria-labelledby="staff-success-title">';
    echo '<span class="staff-success__ico" aria-hidden="true">✓</span>';
    echo '<h2 class="staff-success__title" id="staff-success-title"></h2>';
    echo '<button class="btn btn--primary staff-success__ok" type="button" data-staff-success-close>' . staff_h($L['action_ok']) . '</button>';
    echo '</div></div>';
    echo '<script>window.__staffActionMsgs=' . json_encode(array(
        'uploaded' => $L['action_uploaded'],
        'deleted' => $L['action_deleted'],
        'saved' => $L['action_saved'],
        'sent' => $L['action_sent'],
        'confirmed' => $L['action_confirmed'],
        'working' => $L['action_working'],
        'photo_saved' => $L['photo_saved'],
    ), JSON_UNESCAPED_UNICODE) . ';</script>';
}

function staff_profile_href()
{
    $up = (function_exists('dual_in_kid_folder') && dual_in_kid_folder()) ? '../' : '';
    return $up . 'profile.php';
}

function staff_hero($title, $showEyebrow = false, $meta = '', $showTags = false)
{
    global $L, $logo, $photoUrl, $initials, $displayName, $jobLabel;
    if ($meta === '') {
        $meta = $showTags ? '' : $jobLabel;
    }
    $tagText = $jobLabel !== '' ? $jobLabel : '';
    echo '<header class="hero hero--tall hero--staff">';
    echo '<div class="hero__row">';
    echo '<button class="menu-btn" type="button" data-drawer-open aria-expanded="false" aria-controls="staff-drawer" aria-label="' . staff_h($L['menu']) . '">' . staff_ico('menu') . '</button>';
    echo '<div class="grow">';
    if ($showEyebrow) {
        $eye = (function_exists('dual_is_parent_mode') && dual_is_parent_mode() && isset($L['parent_eyebrow']))
            ? $L['parent_eyebrow']
            : $L['eyebrow'];
        echo '<p class="hero__eyebrow">' . staff_h($eye) . '</p>';
    }
    echo '<h1 class="hero__title">' . staff_h($title) . '</h1>';
    echo '</div>';
    staff_header_actions();
    echo '</div>';
    $profileHref = staff_profile_href();
    echo '<a class="featured featured--link" href="' . staff_h($profileHref) . '" aria-label="' . staff_h($L['profile']) . '">';
    if (!empty($photoUrl)) {
        echo '<img class="av av--lg" src="' . staff_h($photoUrl) . '" alt="">';
    } else {
        echo '<span class="av av--lg t-gold">' . staff_h($initials) . '</span>';
    }
    echo '<div class="featured__body">';
    echo '<p class="featured__name">' . staff_h($displayName) . '</p>';
    if ($meta !== '') {
        echo '<p class="featured__meta">' . staff_h($meta) . '</p>';
    }
    if ($showTags && $tagText !== '') {
        echo '<div class="featured__tags"><span class="tag">' . staff_h($tagText) . '</span></div>';
    }
    echo '</div></a></header>';
}

function staff_drawer($active)
{
    global $L, $photoUrl, $logo, $displayName, $row_get_user;
    $phone = isset($row_get_user['phone']) ? (string) $row_get_user['phone'] : '';
    $year = date('Y');
    $whoSrc = !empty($photoUrl) ? $photoUrl : $logo;
    echo '<aside class="drawer" id="staff-drawer" aria-hidden="true">';
    echo '<div class="drawer__veil" data-drawer-close></div>';
    echo '<div class="drawer__panel" role="dialog" aria-label="' . staff_h($L['navigation']) . '">';
    echo '<button class="drawer__close" type="button" data-drawer-close aria-label="' . staff_h($L['close']) . '">' . staff_ico('close') . '</button>';
    $profileHref = staff_profile_href();
    echo '<a class="drawer__who" href="' . staff_h($profileHref) . '" aria-label="' . staff_h($L['profile']) . '">';
    echo '<img src="' . staff_h($whoSrc) . '" alt="">';
    echo '<div><p class="drawer__name">' . staff_h($displayName) . '</p>';
    if ($phone !== '') {
        echo '<p class="drawer__phone">' . staff_h($phone) . '</p>';
    }
    echo '</div></a>';
    echo '<div class="drawer__nav">';
    echo '<p class="drawer__label">' . staff_h($L['navigation']) . '</p>';
    $homeHref = function_exists('staff_home_href') ? staff_home_href() : staff_nav_path('emp-view.php');
    echo '<a class="drawer__link' . ($active === 'home' ? ' is-active' : '') . '" href="' . staff_h($homeHref) . '">' . staff_ico('home') . '<span>' . staff_h($L['nav_home']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'choices' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('choices.php')) . '">' . staff_ico('grid') . '<span>' . staff_h($L['nav_choices']) . '</span></a>';
    if (function_exists('dual_has_dual') && dual_has_dual()) {
        echo '<a class="drawer__link' . ($active === 'role' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('choose-role.php?fresh=1')) . '">' . staff_ico('swap') . '<span>' . staff_h($L['role_switch']) . '</span></a>';
    }
    echo '<a class="drawer__link' . ($active === 'checkin' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('emp-checkin.php')) . '">' . staff_ico('map-pin') . '<span>' . staff_h($L['checkin']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'profile' ? ' is-active' : '') . '" href="' . staff_h(staff_profile_href()) . '">' . staff_ico('laptop') . '<span>' . staff_h($L['profile']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'absence' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('my-absence.php')) . '">' . staff_ico('thermo') . '<span>' . staff_h($L['my_absence']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'excuse' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('my-excuse.php')) . '">' . staff_ico('hourglass') . '<span>' . staff_h($L['my_excuse']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'attendance' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('my-attendance.php')) . '">' . staff_ico('clipboard') . '<span>' . staff_h($L['my_attendance']) . '</span></a>';
    echo '<a class="drawer__link' . ($active === 'password' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('password.php')) . '">' . staff_ico('key') . '<span>' . staff_h($L['password']) . '</span></a>';
    echo '<a class="drawer__link is-exit" href="' . staff_h(staff_nav_path('emp-view.php') . '?exit=1') . '">' . staff_ico('logout') . '<span>' . staff_h($L['exit']) . '</span></a>';
    echo '</div>';
    echo '<p class="drawer__copy">&copy; Copyright ' . staff_h($year) . '</p>';
    echo '</div></aside>';
}

function staff_nav_path($file)
{
    $up = (function_exists('dual_in_kid_folder') && dual_in_kid_folder()) ? '../' : '';
    return $up . $file;
}

function staff_nav_q_badge()
{
    global $showQuestions;
    if (empty($showQuestions)) {
        return 0;
    }
    if (!function_exists('staff_q_count')) {
        require_once __DIR__ . '/staff-questions.php';
    }
    return max(0, (int) staff_q_count());
}

function staff_nav($active, $L = null, $old = null, $showQuestions = false, $showNotify = false)
{
    global $js, $staffLang;
    if ($L === null) {
        global $L;
    }
    $here = basename($_SERVER['PHP_SELF']);
    $qs = (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '') ? ('?' . $_SERVER['QUERY_STRING']) : '';
    $inKid = function_exists('dual_in_kid_folder') && dual_in_kid_folder();
    if ($inKid) {
        $engHref = '../../eng/kid/' . $here . $qs;
        $arbHref = '../../arb/kid/' . $here . $qs;
    } else {
        $engHref = '../eng/' . $here . $qs;
        $arbHref = '../arb/' . $here . $qs;
    }
    $engOn = ($staffLang !== 'arb');
    $tab = $active;
    if (in_array($active, array('profile', 'absence', 'excuse', 'attendance', 'password', 'settings'), true)) {
        $tab = 'profile';
    }
    if (in_array($active, array('checkin', 'role'), true)) {
        $tab = 'home';
    }
    $homeHref = function_exists('staff_home_href') ? staff_home_href() : staff_nav_path('emp-view.php');
    $qBadge = staff_nav_q_badge();
    if (empty($GLOBALS['staffHideChrome']) && !(function_exists('dual_is_parent_mode') && dual_is_parent_mode())) {
        echo '<nav class="nav nav--emp" aria-label="' . staff_h($L['navigation']) . '">';
        echo '<a class="nav__item' . ($tab === 'home' ? ' is-active' : '') . '" href="' . staff_h($homeHref) . '">';
        echo staff_ico('home') . '<span>' . staff_h($L['nav_home']) . '</span><span class="nav__dot"></span></a>';
        echo '<a class="nav__item' . ($tab === 'choices' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('choices.php')) . '">';
        echo staff_ico('grid') . '<span>' . staff_h($L['nav_choices']) . '</span><span class="nav__dot"></span></a>';
        echo '<a class="nav__item' . ($tab === 'questions' ? ' is-active' : '') . '" href="' . staff_h(staff_nav_path('questions.php')) . '">';
        echo staff_ico('chat') . '<span>' . staff_h($L['nav_questions']) . '</span>';
        if ($qBadge > 0) {
            $badgeLabel = $qBadge > 99 ? '99+' : (string) (int) $qBadge;
            $badgeClass = 'nav__badge' . ($qBadge > 9 ? ' nav__badge--wide' : '');
            echo '<span class="' . staff_h($badgeClass) . '" aria-label="' . staff_h((string) $qBadge) . '">' . staff_h($badgeLabel) . '</span>';
        }
        echo '<span class="nav__dot"></span></a>';
        echo '<a class="nav__item' . ($tab === 'profile' ? ' is-active' : '') . '" href="' . staff_h(staff_profile_href()) . '">';
        echo staff_ico('user') . '<span>' . staff_h($L['nav_profile']) . '</span><span class="nav__dot"></span></a>';
        echo '</nav>';
    }
    echo '<div class="langsheet" id="lang-sheet" aria-hidden="true">';
    echo '<div class="langsheet__veil" data-lang-close></div>';
    echo '<div class="langsheet__card" role="dialog" aria-modal="true" aria-labelledby="lang-sheet-title">';
    echo '<button class="langsheet__x" type="button" data-lang-close aria-label="' . staff_h($L['close']) . '">' . staff_ico('close') . '</button>';
    echo '<p class="langsheet__kicker">' . staff_h($L['school']) . '</p>';
    echo '<h2 id="lang-sheet-title">' . staff_h($L['lang_pick']) . '</h2>';
    echo '<p class="langsheet__hint">' . staff_h($L['lang_pick_hint']) . '</p>';
    echo '<div class="langsheet__opts">';
    echo '<a class="langsheet__opt' . ($engOn ? ' is-on' : '') . '" href="' . staff_h($engHref) . '">';
    echo '<span class="langsheet__mark">Aa</span><span class="langsheet__copy"><strong>' . staff_h($L['lang_en']) . '</strong><small>English</small></span><span class="langsheet__tick" aria-hidden="true">✓</span>';
    echo '</a>';
    echo '<a class="langsheet__opt' . (!$engOn ? ' is-on' : '') . '" href="' . staff_h($arbHref) . '">';
    echo '<span class="langsheet__mark">ع</span><span class="langsheet__copy"><strong>' . staff_h($L['lang_ar']) . '</strong><small>Arabic</small></span><span class="langsheet__tick" aria-hidden="true">✓</span>';
    echo '</a>';
    echo '</div></div></div>';
    if (empty($GLOBALS['staffHideChrome'])) {
        staff_drawer($active);
    }
    staff_action_shell();
    if (!empty($js)) {
        echo '<script src="' . staff_h($js) . '"></script>';
    }
    echo '</div></body></html>';
}

function staff_tiles($tiles)
{
    global $L;
    if (!$tiles) {
        return;
    }
    echo '<div class="tiles">';
    foreach ($tiles as $tile) {
        $badge = (isset($tile[4]) && $tile[4] !== '' && $tile[4] !== null) ? max(0, (int) $tile[4]) : 0;
        echo '<a class="tile ' . $tile[3] . '" href="' . staff_h($tile[2]) . '">';
        echo '<span class="tile__ico">' . staff_ico($tile[0]) . '</span>';
        echo '<span class="tile__label">' . staff_h($L[$tile[1]]) . '</span>';
        if ($badge > 0) {
            echo '<span class="tile__badge" aria-label="' . staff_h((string) $badge) . '">' . $badge . '</span>';
        }
        echo '</a>';
    }
    echo '</div>';
}

function staff_home_checkin()
{
    global $L;
    echo '<a class="checkin-launch" href="' . staff_h(staff_nav_path('emp-checkin.php')) . '">';
    echo '<span class="checkin-launch__ico">' . staff_ico('map-pin') . '</span>';
    echo '<span class="checkin-launch__copy"><strong>' . staff_h($L['checkin_open']) . '</strong>';
    if ($L['checkin_hint'] !== '') {
        echo '<small>' . staff_h($L['checkin_hint']) . '</small>';
    }
    echo '</span>';
    echo '</a>';
}

function staff_home_quick($icon, $textKey, $href, $tone, $badge = 0)
{
    global $L;
    echo '<a class="quick ' . staff_h($tone) . '" href="' . staff_h($href) . '">';
    echo '<span class="quick__ico">' . staff_ico($icon) . '</span>';
    echo staff_h($L[$textKey]);
    if ($badge > 0) {
        echo '<span class="quick__badge">' . (int) $badge . '</span>';
    }
    echo '</a>';
}

function staff_home_quickrow()
{
    global $L, $showStudent, $showHomework, $showQuestions, $showControl;

    $items = array();
    if ($showStudent) {
        $items[] = array('people', 'student', staff_nav_path('students.php'), 't-navy', 0);
    }
    if ($showHomework) {
        $items[] = array('book', 'homework', staff_nav_path('homework.php'), 't-gold', 0);
    }
    if ($showQuestions) {
        $items[] = array('chat', 'questions', staff_nav_path('questions.php'), 't-coral', staff_nav_q_badge());
    }
    if ($showControl) {
        $items[] = array('star', 'control', staff_nav_path('control.php'), 't-green', 0);
    }
    if (!$items) {
        return;
    }
    $cols = count($items) === 3 ? ' quickrow--3' : '';
    echo '<div class="quickrow' . $cols . '">';
    foreach ($items as $item) {
        staff_home_quick($item[0], $item[1], $item[2], $item[3], $item[4]);
    }
    echo '</div>';
}

function staff_home_office()
{
    global $L, $showRevision, $showMemo, $showPlan, $showEval;

    $tiles = array();
    if ($showRevision) {
        $tiles[] = array('file', 'revision', staff_nav_path('revision.php'), 't-gold');
    }
    if ($showMemo) {
        $tiles[] = array('pin', 'memo', staff_nav_path('memo.php'), 't-blue');
    }
    if ($showPlan) {
        $tiles[] = array('list', 'plan', staff_nav_path('weekplan.php'), 't-navy');
    }
    if ($showEval) {
        $tiles[] = array('bars', 'evaluation', staff_nav_path('evaluation.php'), 't-green');
    }
    if (!$tiles) {
        return;
    }
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['office_tools']) . '</h2></div>';
    staff_tiles($tiles);
}

function staff_home_dashboard()
{
    staff_home_checkin();
    staff_home_quickrow();
    staff_home_office();
}

function staff_home_tools_grid()
{
    global $showStudent, $showHomework, $showRevision, $showMemo, $showPlan, $showEval, $showQuestions, $showControl, $L;

    $qCount = staff_nav_q_badge();
    $tiles = array();
    if ($showQuestions) {
        $questionTile = array('chat', 'questions', staff_nav_path('questions.php'), 't-coral');
        if ($qCount > 0) {
            $questionTile[] = $qCount;
        }
        $tiles[] = $questionTile;
    }
    if ($showStudent) {
        $tiles[] = array('people', 'student', staff_nav_path('students.php'), 't-navy');
    }
    if ($showHomework) {
        $tiles[] = array('book', 'homework', staff_nav_path('homework.php'), 't-gold');
    }
    if ($showRevision) {
        $tiles[] = array('file', 'revision', staff_nav_path('revision.php'), 't-gold');
    }
    if ($showMemo) {
        $tiles[] = array('pin', 'memo', staff_nav_path('memo.php'), 't-blue');
    }
    if ($showPlan) {
        $tiles[] = array('list', 'plan', staff_nav_path('weekplan.php'), 't-navy');
    }
    if ($showEval) {
        $tiles[] = array('bars', 'evaluation', staff_nav_path('evaluation.php'), 't-green');
    }
    if ($showControl) {
        $tiles[] = array('star', 'control', staff_nav_path('control.php'), 't-green');
    }
    if (!$tiles) {
        return false;
    }
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['tools']) . '</h2></div>';
    staff_tiles($tiles);
    return true;
}

function staff_home_extra($prependEmployee = array())
{
    global $L, $showNotify, $showAbsence, $showStaffAbs, $showStaffExc;

    $student = array();
    if ($showNotify) {
        $student[] = array('bell', 'class_notify', staff_nav_path('class-notify.php'), 't-navy');
    }
    if ($showAbsence) {
        $student[] = array('thermo', 'absence', staff_nav_path('absence.php'), 't-coral');
    }

    $employee = is_array($prependEmployee) ? $prependEmployee : array();
    $employee[] = array('thermo', 'my_absence', staff_nav_path('my-absence.php'), 't-gold');
    if ($showStaffAbs) {
        $employee[] = array('thermo', 'staff_abs_approvals', staff_nav_path('staff-absence.php'), 't-coral');
    }
    if ($showStaffExc) {
        $employee[] = array('hourglass', 'staff_excuses', staff_nav_path('staff-excuses.php'), 't-gold');
    }

    $has = false;
    if ($student) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['student_opts']) . '</h2></div>';
        staff_tiles($student);
        $has = true;
    }
    if ($employee) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['emp_opts']) . '</h2></div>';
        staff_tiles($employee);
        $has = true;
    }
    return $has;
}

function staff_home_tools()
{
    staff_home_tools_grid();
    staff_home_extra();
}

if (is_file(__DIR__ . '/staff-screens.php')) {
    require_once __DIR__ . '/staff-screens.php';
}

