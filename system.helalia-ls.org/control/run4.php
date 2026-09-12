<?php require_once('includes/access.php');
require_once('includes/logout.php');
require_once('../Connections/database.php');
error_reporting(E_ALL);
require_once('includes/functions.php');


 

mysqli_select_db($database, $database_database);
$query_get_control = " SELECT * FROM `control_registry_avg2`  ";
$get_control = mysqli_query($database, $query_get_control) or die(mysqli_error($database));
$row_get_control = mysqli_fetch_assoc($get_control);
$totalRows_get_control = mysqli_num_rows($get_control);

if ($totalRows_get_control > 0) {
    do { 
            $query_get_control1 = " SELECT * FROM `control_registry_avg` WHERE `id` = '{$row_get_control['id']}' ";
            $get_control1 = mysqli_query($database, $query_get_control1) or die(mysqli_error($database));
            $row_get_control1 = mysqli_fetch_assoc($get_control1);
            $totalRows_get_control1 = mysqli_num_rows($get_control1);  

            if($totalRows_get_control1 < 0){
                echo "No record found for id: {$row_get_control['id']} <br>";

            }

    } while ($row_get_control = mysqli_fetch_assoc($get_control));
    echo $totalRows_get_control;
}


?>