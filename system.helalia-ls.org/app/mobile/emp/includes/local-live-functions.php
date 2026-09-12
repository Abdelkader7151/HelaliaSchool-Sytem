<?php
/**
 * Read-only helpers for local testing against the school database.
 * Does not update live rows.
 */

if (!function_exists('GetSQLValueString')) {
    function GetSQLValueString($conn, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = addslashes((string) $theValue);
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

function staff_local_emp_row($id)
{
    global $database, $database_database;
    static $cache = array();
    $id = (int) $id;
    if ($id < 1) {
        return array();
    }
    if (isset($cache[$id])) {
        return $cache[$id];
    }
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT * FROM `emps` WHERE `id` = '{$id}' LIMIT 1");
    $cache[$id] = ($rs ? mysqli_fetch_assoc($rs) : null) ?: array();
    return $cache[$id];
}

function staff_local_emp_col($id, $col)
{
    $row = staff_local_emp_row($id);
    return isset($row[$col]) ? $row[$col] : 0;
}

function emp_name($id)
{
    $name = staff_local_emp_col($id, 'name');
    return $name ? $name : '';
}

function empjob($id)
{
    return staff_local_emp_col($id, 'job');
}

function job_name($id)
{
    global $database, $database_database;
    static $cache = array();
    $id = (int) $id;
    if (isset($cache[$id])) {
        return $cache[$id];
    }
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT `name` FROM `jobs` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    $cache[$id] = $row ? (string) $row['name'] : '';
    return $cache[$id];
}

function year_of_study($id)
{
    $map = array(
        0 => 'Preschool', 1 => 'KG1', 2 => 'KG2',
        3 => 'Junior One', 4 => 'Junior Two', 5 => 'Junior Three',
        6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
        12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
        15 => 'General',
    );
    $id = (int) $id;
    return isset($map[$id]) ? $map[$id] : '';
}

function class_name($id)
{
    global $database, $database_database;
    static $cache = array();
    $id = (int) $id;
    if (isset($cache[$id])) {
        return $cache[$id];
    }
    if ($id < 1) {
        $cache[$id] = '';
        return '';
    }
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT `name` FROM `class` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    $cache[$id] = ($row && !empty($row['name'])) ? (string) $row['name'] : '';
    return $cache[$id];
}

function kid_pic($id)
{
    global $database, $database_database;
    $id = (int) $id;
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT `picture` FROM `kids` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    if (!$row || $row['picture'] === null || $row['picture'] === '') {
        return null;
    }
    return $row['picture'];
}

function kid_name($id)
{
    $kid = function_exists('dual_find_kid') ? dual_find_kid($id) : null;
    if ($kid) {
        return $kid['fn_name'];
    }
    global $database, $database_database;
    $id = (int) $id;
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT `fn_name` FROM `kids` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    return $row ? (string) $row['fn_name'] : '';
}

function urlpage()
{
    return basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
}

function day_today($date)
{
    $today = strtotime(date('Y-m-d', time()));
    $day = strtotime(date('Y-m-d', $date));
    return ($today == $day) ? 1 : 0;
}

function file_type($file)
{
    if ($file == null) {
        return " class='fa fa-hand-o-right' style='color: #112c5a; ";
    }
    return " class='fa fa-file-o' style='color: #112c5a; ";
}

function cordnator($emp)
{
    global $database;
    $emp = (int) $emp;
    if ($emp < 1 || !isset($database)) {
        return 0;
    }
    $rs = mysqli_query($database, "SELECT `cor` FROM `subjects` WHERE `cor` = '{$emp}' LIMIT 1");
    return ($rs && mysqli_num_rows($rs) > 0) ? 1 : 0;
}

function head($emp)
{
    global $database;
    $emp = (int) $emp;
    if ($emp < 1 || !isset($database)) {
        return 0;
    }
    $rs = mysqli_query($database, "SELECT `head` FROM `subjects` WHERE `head` = '{$emp}' LIMIT 1");
    return ($rs && mysqli_num_rows($rs) > 0) ? 1 : 0;
}

function check_teacher_subject($id)
{
    global $database;
    $id = (int) $id;
    if ($id < 1 || !isset($database)) {
        return 0;
    }
    $rs = mysqli_query($database, "SELECT `cor` FROM `subjects` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    return ($row && isset($row['cor'])) ? (int) $row['cor'] : 0;
}

function check_head_subject($id)
{
    global $database;
    $id = (int) $id;
    if ($id < 1 || !isset($database)) {
        return 0;
    }
    $rs = mysqli_query($database, "SELECT `head` FROM `subjects` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    return ($row && isset($row['head'])) ? (int) $row['head'] : 0;
}

function app_name($id)
{
    global $database, $database_database;
    $id = (int) $id;
    if ($id < 1 || !isset($database)) {
        return '';
    }
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query($database, "SELECT `name` FROM `app_login` WHERE `id` = '{$id}' LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    return ($row && !empty($row['name'])) ? (string) $row['name'] : '';
}

function question_direct($id)
{
    $id = (int) $id;
    $map = array(
        1000 => 'Head Of Department',
        2000 => 'Secretary',
        3000 => 'Doctor',
        4000 => 'Therapist',
        10001 => 'Administration',
        10002 => 'Head Of Department',
        10003 => 'Vice Head',
        10004 => 'Secretary',
        10005 => 'Doctor',
        10006 => 'Therapist',
        10007 => 'Supervisor',
    );
    return isset($map[$id]) ? $map[$id] : '';
}

function app10access($id) { return staff_local_emp_col($id, 'app10'); }
function app11access($id) { return staff_local_emp_col($id, 'app11'); }
function app11_2access($id) { return staff_local_emp_col($id, 'app11_2'); }
function app12access($id) { return staff_local_emp_col($id, 'app12'); }
function app12_0access($id) { return staff_local_emp_col($id, 'app12_0'); }
function app12_1access($id) { return staff_local_emp_col($id, 'app12_1'); }
function app12_2access($id) { return staff_local_emp_col($id, 'app12_2'); }
function app12_3access($id) { return staff_local_emp_col($id, 'app12_3'); }
function app12_4access($id) { return staff_local_emp_col($id, 'app12_4'); }
function app12_5access($id) { return staff_local_emp_col($id, 'app12_5'); }
function app13access($id) { return staff_local_emp_col($id, 'app13'); }
function app14access($id) { return staff_local_emp_col($id, 'app14'); }
function app15access($id) { return staff_local_emp_col($id, 'app15'); }
function app16access($id) { return staff_local_emp_col($id, 'app16'); }
function app17access($id) { return staff_local_emp_col($id, 'app17'); }
function app18access($id) { return staff_local_emp_col($id, 'app18'); }
function app19access($id) { return staff_local_emp_col($id, 'app19'); }
function app19_1access($id) { return staff_local_emp_col($id, 'app19_1'); }

function teacher1($emp, $year)
{
    global $database, $database_database;
    $emp = (int) $emp;
    $year = (int) $year;
    if ($emp < 1) {
        return 0;
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT `id` FROM `teachers` WHERE `emp_id`='{$emp}' AND `study_year`='{$year}'");
    return $res ? (int) mysqli_num_rows($res) : 0;
}

function teacher2($emp, $year, $class)
{
    global $database, $database_database;
    $emp = (int) $emp;
    $year = (int) $year;
    $class = (int) $class;
    if ($emp < 1) {
        return 0;
    }
    mysqli_select_db($database, $database_database);
    $res = mysqli_query($database, "SELECT `id` FROM `teachers` WHERE `emp_id`='{$emp}' AND `study_year`='{$year}' AND `class`='{$class}'");
    return $res ? (int) mysqli_num_rows($res) : 0;
}
function app20access($id)
{
    $row = staff_local_emp_row($id);
    for ($i = 1; $i <= 7; $i++) {
        if (!empty($row['app20_' . $i]) && (int) $row['app20_' . $i] === 1) {
            return 1;
        }
    }
    return 0;
}

function app20_8access($id) { return staff_local_emp_col($id, 'app20_8'); }

function app20access_edit($id) { return staff_local_emp_col($id, 'app20'); }
function app1_access($id) { return staff_local_emp_col($id, 'app1'); }
function app1_0access($id) { return staff_local_emp_col($id, 'app1_0'); }
function app1_1access($id) { return staff_local_emp_col($id, 'app1_1'); }
function app1_2access($id) { return staff_local_emp_col($id, 'app1_2'); }
function app1_3access($id) { return staff_local_emp_col($id, 'app1_3'); }
function app1_4access($id) { return staff_local_emp_col($id, 'app1_4'); }
function app1_5access($id) { return staff_local_emp_col($id, 'app1_5'); }
function app2_access($id) { return staff_local_emp_col($id, 'app2'); }
function app3_access($id) { return staff_local_emp_col($id, 'app3'); }
function app4_access($id) { return staff_local_emp_col($id, 'app4'); }
function app5_access($id) { return staff_local_emp_col($id, 'app5'); }
function app6_access($id) { return staff_local_emp_col($id, 'app6'); }
function app6_0access($id) { return staff_local_emp_col($id, 'app6_0'); }
function app6_1access($id) { return staff_local_emp_col($id, 'app6_1'); }
function app6_2access($id) { return staff_local_emp_col($id, 'app6_2'); }
function app6_3access($id) { return staff_local_emp_col($id, 'app6_3'); }
function app6_4access($id) { return staff_local_emp_col($id, 'app6_4'); }
function app6_5access($id) { return staff_local_emp_col($id, 'app6_5'); }
function app7_access($id) { return staff_local_emp_col($id, 'app7'); }
function app8_access($id) { return staff_local_emp_col($id, 'app8'); }
function app9_access($id) { return staff_local_emp_col($id, 'app9'); }
function app9_0access($id) { return staff_local_emp_col($id, 'app9_0'); }
function app9_1access($id) { return staff_local_emp_col($id, 'app9_1'); }
function app9_2access($id) { return staff_local_emp_col($id, 'app9_2'); }
function app9_3access($id) { return staff_local_emp_col($id, 'app9_3'); }
function app9_4access($id) { return staff_local_emp_col($id, 'app9_4'); }
function app9_5access($id) { return staff_local_emp_col($id, 'app9_5'); }
