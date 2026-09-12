<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
error_reporting(E_ALL);
require_once('includes/functions.php');


$study_year = $_GET['year'];
$subject_id = $_GET['sub'];
$new_month = 3;

mysqli_select_db($database, $database_database);
$query_get_control = "SELECT * FROM `control` WHERE `study_year` = '{$study_year}' AND `subject_id` = '{$subject_id}'  AND `month` = 5  AND `move_temp` = 0 ";
$get_control = mysqli_query($database, $query_get_control) or die(mysqli_error($database));
$row_get_control = mysqli_fetch_assoc($get_control);
$totalRows_get_control = mysqli_num_rows($get_control);

if ($totalRows_get_control > 0) {
    do {

        mysqli_select_db($database, $database_database);
        $query_get_registry_avg = "SELECT * FROM `control_registry_avg` WHERE `study_year` = '{$study_year}' AND `subject_id` ='{$subject_id}'  AND `month` = '{$new_month}'  AND `ed_id` = '{$row_get_control['seat_id']}' ";
        $get_registry_avg = mysqli_query($database, $query_get_registry_avg) or die(mysqli_error($database));
        $row_get_registry_avg = mysqli_fetch_assoc($get_registry_avg);
        $totalRows_get_registry_avg = mysqli_num_rows($get_registry_avg);

        if ($totalRows_get_registry_avg < 1) {

            $insertSQL = sprintf(
                "INSERT INTO `control_registry_avg` ( `kid_id`, `ed_id`, `name`, `arb_name`, `gender`, `study_year`, `subject_id`, `month`, `year`, `col1`, `col2`, `col3`  ) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                GetSQLValueString($database, $row_get_control['kid_id'], "int"),
                GetSQLValueString($database, $row_get_control['seat_id'], "int"),
                GetSQLValueString($database, $row_get_control['name'], "text"),
                GetSQLValueString($database, $row_get_control['arb_name'], "text"),
                GetSQLValueString($database, $row_get_control['gender'], "text"),
                GetSQLValueString($database, $row_get_control['study_year'], "int"),
                GetSQLValueString($database, $row_get_control['subject_id'], "int"),
                GetSQLValueString($database, $new_month, "int"),
                GetSQLValueString($database, 2026, "int"),
                GetSQLValueString($database, 15, "double"), 
                GetSQLValueString($database, $row_get_control['ex_result'], "double"), 
                GetSQLValueString($database, 10, "double")
            );

            mysqli_query($database, $insertSQL) or die(mysqli_error($database));


            $UPDATESQL = sprintf(
                "UPDATE `control` SET `move_temp`=%s WHERE `id`=%s  ",
                GetSQLValueString($database, 1, "int"),
                GetSQLValueString($database, $row_get_control['id'], "int")
            );

            mysqli_query($database, $UPDATESQL) or die(mysqli_error($database));


        } else {


            $query_get_registry_avg = "SELECT * FROM `control_registry_avg` WHERE `study_year` = '{$study_year}' AND `subject_id` ='{$subject_id}'  AND `month` = '{$new_month}'  AND `ed_id` = '{$row_get_control['seat_id']}'     ";
            $get_registry_avg = mysqli_query($database, $query_get_registry_avg) or die(mysqli_error($database));
            $row_get_registry_avg = mysqli_fetch_assoc($get_registry_avg);
            $totalRows_get_registry_avg = mysqli_num_rows($get_registry_avg);

            if ($totalRows_get_registry_avg > 0 && $row_get_control['ex_result']>0 ) {

                $deleteSQL = sprintf(
                    "DELETE FROM `control_registry_avg`  WHERE  `id`=%s  ",
                    GetSQLValueString($database, $row_get_registry_avg['id'], "int")
                );

                mysqli_query($database, $deleteSQL) or die(mysqli_error($database));




                $insertSQL = sprintf(
                    "INSERT INTO `control_registry_avg` ( `kid_id`, `ed_id`, `name`, `arb_name`, `gender`, `study_year`, `subject_id`, `month`, `year`, `col1`, `col2`, `col3` ) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                    GetSQLValueString($database, $row_get_control['kid_id'], "int"),
                    GetSQLValueString($database, $row_get_control['seat_id'], "int"),
                    GetSQLValueString($database, $row_get_control['name'], "text"),
                    GetSQLValueString($database, $row_get_control['arb_name'], "text"),
                    GetSQLValueString($database, $row_get_control['gender'], "text"),
                    GetSQLValueString($database, $row_get_control['study_year'], "int"),
                    GetSQLValueString($database, $row_get_control['subject_id'], "int"),
                    GetSQLValueString($database, $new_month, "int"),
                    GetSQLValueString($database, 2026, "int"),
                    GetSQLValueString($database, 5, "double"), 
                    GetSQLValueString($database, $row_get_control['ex_result'], "double"), 
                    GetSQLValueString($database, 10, "double")
                );

                mysqli_query($database, $insertSQL) or die(mysqli_error($database));


                $UPDATESQL = sprintf(
                    "UPDATE `control` SET `move_temp`=%s WHERE `id`=%s  ",
                    GetSQLValueString($database, 1, "int"),
                    GetSQLValueString($database, $row_get_control['id'], "int")
                );

                mysqli_query($database, $UPDATESQL) or die(mysqli_error($database));


            }

        }
    } while ($row_get_control = mysqli_fetch_assoc($get_control));
}


?>