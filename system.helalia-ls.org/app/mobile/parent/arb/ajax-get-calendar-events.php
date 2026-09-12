<?php
require_once('../../Connections/database.php'); 
include("../../includes/access.php");

if (!isset($_SESSION)) { session_start(); }

if (!function_exists("GetSQLValueString")) {

	function GetSQLValueString($conn_vote, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		$theValue = function_exists("mysqli_real_escape_string") ?   mysqli_real_escape_string($conn_vote, $theValue) :
	mysqli_escape_string($conn_vote, $theValue);

		switch ($theType) {
		  case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		  case "long":
		  case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		  case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		  case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		  case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue :
		$theNotDefinedValue;
		break;
		}

	return $theValue;
	}
  }


header('Content-Type: application/json; charset=utf-8');

mysqli_select_db($database, $database_database);

// ---- Params -------------------------------------------------------
$year        = isset($_GET['year'])       ? (int)$_GET['year']  : (int)date('Y');
$month       = isset($_GET['month'])      ? (int)$_GET['month'] : (int)date('m');
$study_year_raw = isset($_GET['study_year']) ? trim($_GET['study_year']) : '';

if ($month < 1 || $month > 12) {
    $month = (int)date('m');
}
if ($year < 2000 || $year > 2100) {
    $year = (int)date('Y');
}
// Check the RAW value before casting - casting to int first means an
// empty/missing param silently becomes 0 and this check never fires.
if ($study_year_raw === '') {
    echo json_encode(array('error' => 'study_year is required'));
    exit();
}
$study_year = (int)$study_year_raw;


$start_date = sprintf('%04d-%02d-01', $year, $month);
$end_date   = date('Y-m-t', strtotime($start_date)); // last day of month

// ---- Query ----------------------------------------------------------
// `start`/`end` are stored as unix timestamps (int), so the bounds we
// compare against need to be ints too, not date strings.
// An event "overlaps" this month if it starts on/before the month's
// last day AND ends on/after the month's first day - this correctly
// catches multi-day events that only partially fall in this month.
// GetSQLValueString() here requires the connection as its FIRST arg -
// omitting it silently shifts every other argument by one.
$query_events = sprintf(
    "SELECT * FROM `events` WHERE `start` <= %s AND `end` >= %s AND ( `study_year` = %s || `study_year` = %s) ORDER BY `start` ASC",
    GetSQLValueString($database, strtotime($end_date . ' 23:59:59'), "int"),
    GetSQLValueString($database, strtotime($start_date . ' 00:00:00'), "int"),
    GetSQLValueString($database, $study_year, "int"),
    GetSQLValueString($database, -1, "int")
);
 
   $get_events = mysqli_query($database, $query_events) or die(json_encode(array('error' => mysqli_error($database)))); 

// ---- Build two maps ---------------------------------------------------
// events: one entry per event, keyed by its start date - used to render
//         the list/stack (so a 3-day event shows up ONCE, not 3 times).
// days:   every calendar day covered by an event, mapped back to that
//         event's anchor key above - used to light up the grid so the
//         whole range is marked, while every day in the range opens the
//         same single event card.
$events = array();
$days   = array();

while ($row = mysqli_fetch_assoc($get_events)) {
    // start/end are already unix timestamps in the DB - do NOT run them
    // through strtotime() again, a raw epoch int isn't a parseable date
    // string and strtotime() will just return false for it.
    $start_ts = is_numeric($row['start']) ? (int)$row['start'] : false;
    $end_ts   = is_numeric($row['end'])   ? (int)$row['end']   : $start_ts;

    if ($start_ts === false) {
        continue; // skip malformed rows rather than corrupting the response
    }
    if ($end_ts === false || $end_ts < $start_ts) {
        $end_ts = $start_ts;
    }

    $anchor_key = date('Y-m-d', $start_ts);

    if (!empty($row['banner'])) {
        $banner = "<img src='../../../../events/" . $row['banner'] . "' style='width:100%' />";
    } else {
        $banner = "";
    }

    if (date('Y-m-d', $start_ts) != date('Y-m-d', $end_ts)) {
        $from_to = date("d/M Y", $start_ts) . " - " . date("d/M Y", $end_ts);
    } else {
        $from_to = date("d/M Y", $start_ts);
    }

    $details = "<p>" . $banner . "<br>" . $row['text_arb'] . "<br> <br> <strong>" . $from_to . "</strong></p>";
    $date_title = htmlspecialchars($row['name_arb'], ENT_QUOTES, 'UTF-8')."<br><span style ='font-size:12px; color:green'>".$from_to."</span>";
    $title = htmlspecialchars($row['name_arb'], ENT_QUOTES, 'UTF-8');

    $events[$anchor_key] = array(
        $date_title,
        $details,
        't-gold',
         $title,
    );

    // Mark every day between start and end (inclusive) as belonging
    // to this event, so the whole range highlights on the grid.
    for ($ts = $start_ts; $ts <= $end_ts; $ts = strtotime('+1 day', $ts)) {
        $day_key = date('Y-m-d', $ts);
        $days[$day_key] = $anchor_key;
    }
}

echo json_encode(array('events' => $events, 'days' => $days), JSON_UNESCAPED_UNICODE);
exit();
