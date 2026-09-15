<?php
session_start();
if (isset($_GET['mobile']) && $_GET['mobile'] == '1') {
    $_SESSION['is_mobile_app'] = true;
} else {
    // Direct browser access without the app flag — block it here.
    http_response_code(403);
    $_SESSION['is_mobile_app'] = false;
    die('This page can only be accessed through the Helalia app.');
}


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

//initialize the session
if (!isset($_SESSION)) {
    session_start();
} 
mysqli_select_db($database, $database_database);  

mysqli_select_db($database, $database_database);
$query_get_settings = "SELECT * FROM `settings`";
$get_settings = mysqli_query($database, $query_get_settings) or die(mysqli_error($database));
$row_get_settings = mysqli_fetch_assoc($get_settings);
$totalRows_get_settings = mysqli_num_rows($get_settings);
 
//get Login if loged
if (isset($_SESSION['MM_Username'])) {
    mysqli_select_db($database, $database_database);
    $query_get_user = "SELECT * FROM `app_login` where `id` = '{$_SESSION['MM_Userid']}' ";
    $get_user = mysqli_query($database, $query_get_user) or die(mysqli_error($database));
    $row_get_user = mysqli_fetch_assoc($get_user);
    $totalRows_get_user = mysqli_num_rows($get_user); 
}

include_once __DIR__ . '/auth-persist.php';
if (function_exists('helalia_require_fresh_auth')) {
    helalia_require_fresh_auth('index.php');
}

 
function phone_id_update($phone_id, $user_id)
{
    global $database; 
    $update = sprintf("UPDATE `app_login` SET `phone_id` = %s WHERE `id`=%s ",
        GetSQLValueString($database, $phone_id, "text"),
                GetSQLValueString($database, $user_id, "int"));
    mysqli_query($database, $update) or die(mysqli_error($database));
}

 
function account_type_url($id)
{
    switch ($id) {
        case 1:
            return "parent-view.php";
            break;
        case 2:
            return "emp-view.php";
            break;
        case 3:
            return "kid-view.php";
            break; 
        case 4:
            return "parent-switch.php";
            break;
    }
}

function account_type_folder($id)
{
    switch ($id) {
        case 1:
            return "parent";
            break;
        case 2:
            return "emp";
            break;
        case 3:
            return "kid";
            break;
        case 4:
            return "parent";
            break;
    }
}


function escape($data)
{  return  htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8'); }

 

function switch_lang($id){
  switch ($id) {
        case 1:
            return "eng";
            break;
        case 2:
            return "arb";
            break; 
    }
 }