<?php

function helalia_study_year_stage($studyYear)
{
    $year = (int) $studyYear;
    if ($year < 1) {
        return 0;
    }
    if ($year < 3) {
        return 1;
    }
    if ($year < 6) {
        return 2;
    }
    if ($year < 9) {
        return 3;
    }
    if ($year < 12) {
        return 4;
    }
    return 5;
}

function helalia_study_year_stage_bounds($stage)
{
    $stage = (int) $stage;
    $map = array(
        0 => array(0, 0),
        1 => array(1, 2),
        2 => array(3, 5),
        3 => array(6, 8),
        4 => array(9, 11),
        5 => array(12, 14),
    );
    return isset($map[$stage]) ? $map[$stage] : array(0, 0);
}

function helalia_student_search_stage_column($studyYear)
{
    return 'app10_' . helalia_study_year_stage($studyYear);
}

function helalia_student_search_grant_year($empId, $studyYear)
{
    global $database, $database_database;
    $empId = (int) $empId;
    if ($empId < 1) {
        return;
    }
    $col = helalia_student_search_stage_column($studyYear);
    if (!preg_match('/^app10_[0-5]$/', $col)) {
        return;
    }
    mysqli_select_db($database, $database_database);
    mysqli_query(
        $database,
        "UPDATE `emps` SET `app10` = 1, `{$col}` = 1 WHERE `id` = '{$empId}' LIMIT 1"
    );
}

function helalia_student_search_revoke_stage_if_unassigned($empId, $studyYear)
{
    global $database, $database_database;
    $empId = (int) $empId;
    if ($empId < 1) {
        return;
    }
    $stage = helalia_study_year_stage($studyYear);
    $bounds = helalia_study_year_stage_bounds($stage);
    $col = 'app10_' . $stage;
    if (!preg_match('/^app10_[0-5]$/', $col)) {
        return;
    }
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query(
        $database,
        "SELECT COUNT(*) AS `c` FROM `teachers`
         WHERE `emp_id` = '{$empId}'
           AND `study_year` >= '{$bounds[0]}'
           AND `study_year` <= '{$bounds[1]}'"
    );
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    $count = $row ? (int) $row['c'] : 0;
    if ($count > 0) {
        return;
    }
    mysqli_query($database, "UPDATE `emps` SET `{$col}` = 0 WHERE `id` = '{$empId}' LIMIT 1");
    $rs2 = mysqli_query(
        $database,
        "SELECT (`app10_0` + `app10_1` + `app10_2` + `app10_3` + `app10_4` + `app10_5`) AS `on`
         FROM `emps` WHERE `id` = '{$empId}' LIMIT 1"
    );
    $row2 = $rs2 ? mysqli_fetch_assoc($rs2) : null;
    if ($row2 && (int) $row2['on'] === 0) {
        mysqli_query($database, "UPDATE `emps` SET `app10` = 0 WHERE `id` = '{$empId}' LIMIT 1");
    }
}

function helalia_student_search_backfill_from_teachers()
{
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $rs = mysqli_query(
        $database,
        "SELECT DISTINCT `emp_id`, `study_year` FROM `teachers` WHERE `emp_id` > 0 ORDER BY `emp_id`, `study_year`"
    );
    if (!$rs) {
        return 0;
    }
    $count = 0;
    while ($row = mysqli_fetch_assoc($rs)) {
        helalia_student_search_grant_year($row['emp_id'], $row['study_year']);
        $count++;
    }
    return $count;
}

function helalia_student_search_ensure_columns()
{
    global $database, $database_database;
    mysqli_select_db($database, $database_database);
    $added = 0;
    for ($i = 0; $i <= 5; $i++) {
        $col = 'app10_' . $i;
        $rs = mysqli_query($database, "SHOW COLUMNS FROM `emps` LIKE '{$col}'");
        if ($rs && mysqli_num_rows($rs) > 0) {
            continue;
        }
        $sql = "ALTER TABLE `emps` ADD `{$col}` TINYINT(1) NOT NULL DEFAULT 0";
        if (mysqli_query($database, $sql)) {
            $added++;
        }
    }
    return $added;
}
