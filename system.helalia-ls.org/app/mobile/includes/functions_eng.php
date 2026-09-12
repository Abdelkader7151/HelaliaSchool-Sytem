<?php
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
 
$lang = 1;
$lang_dir = "eng";
$today = strtotime(date("m/d/Y", time()));


$pdf = '<span class="fold__item-ico fold__item-ico--pdf"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5"/><path d="M9 17v-4.5h1.6a1.4 1.4 0 0 1 0 2.8H9"/><path d="M13.5 17v-4.5h1.2a2.25 2.25 0 0 1 0 4.5h-1.2z"/></svg></span>';
$xls = '<span class="fold__item-ico fold__item-ico--xls"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5"/><path d="m9.5 12.5 5 5m0-5-5 5"/></svg></span>';
$doc = '<span class="fold__item-ico fold__item-ico--doc"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h8l4 4v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v5h5M9 13h6M9 17h4"/></svg></span>';

 


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



 //update languages
function language_update($id,$lang) { 
    global $database;
        $updateSQL = sprintf( "UPDATE `app_login` SET `languages`=%s WHERE `id`=%s ", 
                 GetSQLValueString($database, $lang, "int"),
                 GetSQLValueString($database, $id, "int"));
        mysqli_query($database, $updateSQL) or die(mysqli_error($database));  
 }



if (isset($_GET['exit'])) {
    //to fully log out a visitor we need to clear the session varialbles
    $_SESSION['MM_Username'] = NULL; 
    $_SESSION['MM_Userid'] = NULL;
    $_SESSION['account_type'] = NULL;
    $_SESSION['phone_id'] = NULL; 
    unset($_SESSION['MM_Username']); 
    unset($_SESSION['MM_Userid']); 
    unset($_SESSION['account_type']);
    setcookie("helu", "", time() - (86400 * 400), "/");
    setcookie("help", "", time() - (86400 * 400), "/");  
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





function year_of_study($id)
{
    switch ($id) {
        case 0:
            return " Preschool ";
            break;
        case 1:
            return " KG1 ";
            break;
        case 2:
            return " KG2 ";
            break;
        case 3:
            return " Junior One";
            break;
        case 4:
            return " Junior Two";
            break;
        case 5:
            return " Junior Three";
            break;
        case 6:
            return "Junior Four";
            break;
        case 7:
            return " Junior Five";
            break;
        case 8:
            return " Junior Six";
            break;
        case 9:
            return "  Middle One";
            break;
        case 10:
            return " Middle Two";
            break;
        case 11:
            return "    Middle Three ";
            break;
        case 12:
            return "     Senior  One ";
            break;
        case 13:
            return "     Senior  Two";
            break;
        case 14:
            return "     Senior  Three";
            break;
        case 15:
            return "     General  ";
            break;
    }
}


function year_of_study_title($id)
{
    switch ($id) {
        case 0:
            return " Preschool ";
            break;
        case 1:
            return " KG ";
            break;
        case 2:
            return " KG ";
            break;
        case 3:
            return " Junior ";
            break;
        case 4:
            return " Junior ";
            break;
        case 5:
            return " Junior ";
            break;
        case 6:
            return "Junior ";
            break;
        case 7:
            return " Junior ";
            break;
        case 8:
            return " Junior ";
            break;
        case 9:
            return "  Middle ";
            break;
        case 10:
            return " Middle ";
            break;
        case 11:
            return "    Middle  ";
            break;
        case 12:
            return "     Senior  ";
            break;
        case 13:
            return "     Senior ";
            break;
        case 14:
            return "     Senior ";
            break; 
    }
}






function class_name($id)
{
    global $database;
    $query_get_data = "SELECT `name` FROM `class` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($id>0 && $row_get_data['name']!=NULL){
          return $row_get_data['name'];
    } 
}






function getRandomColor() {
    $colors = [
        't-gold', 't-coral', 't-green', 't-navy'
    ];

    return $colors[array_rand($colors)];
} 




  function getExtension($str) {
            $i = strrpos($str,".");
            if (!$i) { return ""; }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
            }


 


function emp_name($id)
{
    global $database;
    $query_get_data = "SELECT `name` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($row_get_data['name']!=NULL){return $row_get_data['name'];}
}


function empjob($id)
{
    global $database;
    $query_get_data = "SELECT `job` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['job'];
}


function job_name($id)
{
    global $database;
    $query_get_data = "SELECT `name` FROM `jobs` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['name'];
}




 

function question_direct($id)
{
    switch ($id) { 
        case 1000:
            return "Head Of Department";
            break;
        case 2000:
             return "Secretary"; 
            break;
        case 3000:
            return "Doctor";
            break;
        case 4000:
            return "Therapist";
            break;  


         case 10001:
            return "Administration";
            break;
        case 10005:
             return "Doctor"; 
            break;
        case 10002:
             return "Head Of Department"; 
            break;
        case 10003:
            return "Vice Head";
            break;
        case 10004:
            return "Secretary";
            break;
         case 10006:
            return "Therapist";
            break; 
         case 10007:
            return "Supervisor";
            break;    
        default:

         return subject_name($id);
         break; 
    }
}







function optimizeImage($source, $destination, $extension, $maxWidth = 1600, $maxHeight = 1600, $quality = 75) {
    // Get original dimensions
    list($width, $height) = getimagesize($source);

    // Calculate new dimensions (only downscale, never upscale)
    $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
    $newWidth = (int)($width * $ratio);
    $newHeight = (int)($height * $ratio);

    // Load source image based on type
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($source);
            break;
        case 'png':
            $src = imagecreatefrompng($source);
            break;
        default:
            return false;
    }

    if (!$src) return false;

    // Create resized canvas
    $dst = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    if ($extension == 'png') {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save optimized image
    $result = false;
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $result = imagejpeg($dst, $destination, $quality);
            break;
        case 'png':
            // PNG compression level: 0 (no compression) - 9 (max)
            $result = imagepng($dst, $destination, 6);
            break;
    }

    imagedestroy($src);
    imagedestroy($dst);

    return $result;
}






/** Kept for older call sites; bell no longer uses a rolling day window. */
function helalia_alert_new_days()
{
  return 0;
}

/**
 * Soft reset for the parent bell inbox (list + badge).
 * Anything older than this timestamp is hidden. New school pushes still appear.
 * 2026-09-13 01:50:00 Africa/Cairo (UTC+3).
 */
function helalia_alert_inbox_reset_at()
{
  return 1789253400;
}

function helalia_alert_new_since()
{
  return (int) helalia_alert_inbox_reset_at();
}

/**
 * Bell badge: count only unread at/after the inbox reset. Old backlog is ignored.
 */
function alert($parent_id, $kid_id)
{
  global $database;
  $since = (int) helalia_alert_new_since();
  $parent_id = (int) $parent_id;
  $kid_id = (int) $kid_id;

  if ($kid_id > 0) {
    $query_get_alert = "SELECT COUNT(`id`) AS `total` FROM `notifications` WHERE `kid_id` = '{$kid_id}' AND `view` = 0 AND `del` = 0 AND `date` >= '{$since}'";
    $get_alert = mysqli_query($database, $query_get_alert) or die(mysqli_error($database));
    $row_get_alert = mysqli_fetch_assoc($get_alert);
    if ($row_get_alert && (int) $row_get_alert['total'] > 0) {
      echo "<span class='bell__badge'>" . (int) $row_get_alert['total'] . "</span>";
    }
    return;
  }

  $query_get_kids_list_alert = "SELECT `kid_id` FROM `kids_list` WHERE `parent_id` = '{$parent_id}'";
  $get_kids_list_alert = mysqli_query($database, $query_get_kids_list_alert) or die(mysqli_error($database));
  $row_get_kids_list_alert = mysqli_fetch_assoc($get_kids_list_alert);
  $totalRows_get_kids_list_alert = mysqli_num_rows($get_kids_list_alert);
  if ($totalRows_get_kids_list_alert < 1) {
    return;
  }

  $alerts = 0;
  do {
    $kid = (int) $row_get_kids_list_alert['kid_id'];
    $query_get_alert = "SELECT COUNT(`id`) AS `total` FROM `notifications` WHERE `kid_id` = '{$kid}' AND `view` = 0 AND `del` = 0 AND `date` >= '{$since}'";
    $get_alert = mysqli_query($database, $query_get_alert) or die(mysqli_error($database));
    $row_get_alert = mysqli_fetch_assoc($get_alert);
    if ($row_get_alert) {
      $alerts += (int) $row_get_alert['total'];
    }
  } while ($row_get_kids_list_alert = mysqli_fetch_assoc($get_kids_list_alert));

  if ($alerts > 0) {
    echo "<span class='bell__badge'>{$alerts}</span>";
  }
}









///////////////////









function cert_absence($id, $study_year)
{
    global $database;
    $query_get_data = "SELECT `id` FROM `kids-absence` where `kid_id`='{$id}' and `study_year`= '{$study_year}'  AND `accept` = 0 ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $totalRows_get_data;
}

function subject_name_eng($name_arb)
{
    global $database;
    $query_get_data = "SELECT `name_frn` FROM `subjects` where `name` = '{$name_arb}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if ($totalRows_get_data > 0) {
        return $row_get_data['name_frn'];
    } else {
        return $name_arb;
    }
}





function users_name($id)
{
    global $database;
    $query_get_data = "SELECT `name` FROM `users` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($row_get_data['name']!=NULL){return $row_get_data['name'];}
}







function check_absence($id)
{
    global $database;
    $start = strtotime(date("m/d/Y", time()));
    $end = strtotime(date("m/d/Y", time())) + 86400;

    $query_get_data = "SELECT `id` FROM `kids-absence` where `kid_id`='{$id}' and `date`>= '{$start}' and `date` <'{$end}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $totalRows_get_data;
}

function app1_access($id)
{
    global $database;
    $query_get_data = "SELECT `app1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1'];
}

function app1_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_0'];
}

function app1_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_1'];
}

function app1_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_2'];
}

function app1_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_3'];
}

function app1_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_4'];
}

function app1_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app1_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app1_5'];
}


function app2_access($id)
{
    global $database;
    $query_get_data = "SELECT `app2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2'];
}

function app2_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_0'];
}

function app2_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_1'];
}

function app2_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_2'];
}

function app2_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_3'];
}

function app2_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_4'];
}

function app2_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app2_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app2_5'];
}


function app3_access($id)
{
    global $database;
    $query_get_data = "SELECT `app3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app3'];
}

function app4_access($id)
{
    global $database;
    $query_get_data = "SELECT `app4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app4'];
}
function app5_access($id)
{
    global $database;
    $query_get_data = "SELECT `app5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app5'];
}

function app6_access($id)
{
    global $database;
    $query_get_data = "SELECT `app6` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6'];
}

function app6_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_0'];
}

function app6_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_1'];
}

function app6_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_2'];
}

function app6_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_3'];
}

function app6_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_4'];
}

function app6_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app6_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app6_5'];
}

function app7_access($id)
{
    global $database;
    $query_get_data = "SELECT `app7` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7'];
}

function app7_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_0'];
}



function app7_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_1'];
}

function app7_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_2'];
}

function app7_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_3'];
}

function app7_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_4'];
}

function app7_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_5'];
}

function app7_6access($id)
{
    global $database;
    $query_get_data = "SELECT `app7_6` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app7_6'];
}


function app8_access($id)
{
    global $database;
    $query_get_data = "SELECT `app8` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app8'];
}


function app9_access($id)
{
    global $database;
    $query_get_data = "SELECT `app9` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9'];
}

function app9_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_0'];
}

function app9_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_1'];
}

function app9_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_2'];
}

function app9_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_3'];
}

function app9_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_4'];
}

function app9_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app9_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['app9_5'];
}

function app10access($id)
{
    global $database;
    $query_get_data = "SELECT `app10` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10'];}  
}

function app10_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_0'];}  
}

function app10_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_1'];}  
}

function app10_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_2'];}  
}

function app10_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_3'];}  
}

function app10_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_4'];}  
}

function app10_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app10_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app10_5'];}  
}

function app11access($id)
{
    global $database;
    $query_get_data = "SELECT `app11` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11'];}  
}



function app11_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_1'];}  
}


function app11_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2'];}  
}


function app11_2_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_0'];}  
}

function app11_2_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_1'];}  
}

function app11_2_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_2'];}  
}

function app11_2_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_3'];}  
}

function app11_2_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_4'];}  
}

function app11_2_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_5'];}  
}

function app11_2_6access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_6` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_6'];}  
}

function app11_2_7access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_7` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_7'];}  
}


function app11_2_8access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_8` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_8'];}  
}

function app11_2_9access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_9` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_9'];}  
}

function app11_2_10access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_10` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_10'];}  
}


function app11_2_11access($id)
{
    global $database;
    $query_get_data = "SELECT `app11_2_11` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app11_2_11'];}  
}


function app11_2access_confirm($year,$id)
{
 
    if($year<3){$access = ' `app11_2_1` '; }
    if($year>2 && $year<6){$access = ' `app11_2_2` '; }
    if($year>5 && $year<9){$access = ' `app11_2_3` '; }
    if($year>8 && $year<12){$access = ' `app11_2_4` '; }
    if($year>11){$access = ' `app11_2_5` '; }
 

    global $database;
    $query_get_data = "SELECT  $access FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $totalRows_get_data; 
}


function app12access($id)
{
    global $database;
    $query_get_data = "SELECT `app12` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12'];}  
}

function app12_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_0'];}  
}

function app12_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_1'];}  
}

function app12_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_2'];}  
}

function app12_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_3'];}  
}

function app12_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_4'];}  
}

function app12_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app12_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app12_5'];}  
}



function app13access($id)
{
    global $database;
    $query_get_data = "SELECT `app13` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13'];}  
}

function app13_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1'];}  
}

function app13_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_2'];}  
}

function app13_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_3'];}  
}




function app13_1_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_0'];}  
}

function app13_1_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_1'];}  
}

function app13_1_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_2'];}  
}


function app13_1_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_3'];}  
}


function app13_1_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_4'];}  
}



function app13_1_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app13_1_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app13_1_5'];}  
}


function app14access($id)
{
    global $database;
    $query_get_data = "SELECT `app14` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app14'];}  
}

function app14_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app14_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app14_1'];}  
}

function app14_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app14_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app14_2'];}  
}

function app14_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app14_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app14_3'];}  
}

function app14_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app14_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app14_4'];}  
}

function app15access($id)
{
    global $database;
    $query_get_data = "SELECT `app15` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app15'];}  
}

function app15_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app15_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app15_1'];}  
}



function app16access($id)
{
    global $database;
    $query_get_data = "SELECT `app16` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16'];}  
}

function app16_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_0'];}  
}

function app16_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_1'];}  
}

function app16_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_2'];}  
}

function app16_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_3'];}  
}

function app16_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_4'];}  
}

function app16_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app16_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app16_5'];}  
}

/////

function app17access($id)
{
    global $database;
    $query_get_data = "SELECT `app17` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app17'];}  
}

function app17_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app17_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app17_1'];}  
}



function app18access($id)
{
    global $database;
    $query_get_data = "SELECT `app18` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18'];}  
}

function app18_0access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_0` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_0'];}  
}

function app18_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_1'];}  
}

function app18_2access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_2` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_2'];}  
}

function app18_3access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_3` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_3'];}  
}

function app18_4access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_4` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_4'];}  
}

function app18_5access($id)
{
    global $database;
    $query_get_data = "SELECT `app18_5` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app18_5'];}  
}


function app19access($id)
{
    global $database;
    $query_get_data = "SELECT `app19` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app19'];}  
}

 
function app19_1access($id)
{
    global $database;
    $query_get_data = "SELECT `app19_1` FROM `emps` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $row_get_data['app19_1'];}  
}


function app20access($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `emps` where `id`='{$id}' AND ( `app20_1` = 1 OR `app20_2` = 1 OR `app20_3` = 1 OR `app20_4` = 1 OR `app20_5` = 1 OR `app20_6` = 1 OR `app20_7` = 1) ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $totalRows_get_data;}  
}

function app20_8access($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `emps` where `id`='{$id}' AND  `app20_8` = 1 ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $totalRows_get_data;}  
}


function app20access_edit($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `emps` where `id`='{$id}' AND  `app20` = 1  ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){return $totalRows_get_data;}  
}
 




function cordnator($emp){
    global $database; 
    $query_get_subject = "SELECT `cor` FROM `subjects` WHERE `cor`= '{$emp}'  ";
    $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
    $row_get_subject = mysqli_fetch_assoc($get_subject);
    $totalRows_get_subject = mysqli_num_rows($get_subject); 
    return $totalRows_get_subject;
}


function head($emp){
    global $database; 
    $query_get_subject = "SELECT `head` FROM `subjects` WHERE `head`= '{$emp}'  ";
    $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
    $row_get_subject = mysqli_fetch_assoc($get_subject);
    $totalRows_get_subject = mysqli_num_rows($get_subject); 
    return $totalRows_get_subject;
}


function teacher1($emp,$year){
    global $database; 
    $query_get_subject = "SELECT `id` FROM `teachers` WHERE `emp_id`= '{$emp}' AND `study_year` = '{$year}'  ";
    $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
    $row_get_subject = mysqli_fetch_assoc($get_subject);
    $totalRows_get_subject = mysqli_num_rows($get_subject); 
    return $totalRows_get_subject;
}

function teacher2($emp,$year,$class){
    global $database; 
    $query_get_subject = "SELECT `id` FROM `teachers` WHERE `emp_id`= '{$emp}' AND `study_year` = '{$year}' && `class` = '{$class}'  ";
    $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
    $row_get_subject = mysqli_fetch_assoc($get_subject);
    $totalRows_get_subject = mysqli_num_rows($get_subject); 
    return $totalRows_get_subject;
}

function homework_waitting($year){
    global $database;
    $query_get_data = "SELECT * FROM `homework` where `study_year`='{$year}' and `confirm` = 0";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);

    if($totalRows_get_data>0){
       return "<span class='new badge amber ' style='padding:5px; color: black'>".$totalRows_get_data."</span>"; 
    } 
}


function check_study_year($id,$year)
{
    global $database;
    $query_get_data = "SELECT `id` FROM `teachers` WHERE `emp_id`='{$id}' AND `study_year` = '{$year}' ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
     return $totalRows_get_data;   
}



 

function nickname($id)
{
    global $database;
    $query_get_data = "SELECT * FROM applications where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['nickname'];
}

function kid_name($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `kids` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data); 
    if ($row_get_data['fn_name'] == null) {
        return $row_get_data['name'];
    } else {
        return $row_get_data['fn_name'];
    }
}

function kid_pic($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `kids` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['picture'];
}


function study_year($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `kids` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['study_year'];
}

function kid_class($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `kids` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['class'];
}


function vacation_check($vacation_date, $kid_id)
{
    global $database;
    $query_get_date = "SELECT * FROM `kids_vacations` where `vacation_date`<='{$vacation_date}' and `vacation_end`>'{$vacation_date}'  and `kid_id`='{$kid_id}' ";
    $get_date = mysqli_query($database, $query_get_date) or die(mysqli_error($database));
    $row_get_date = mysqli_fetch_assoc($get_date);
    $totalRows_get_date = mysqli_num_rows($get_date);
    return $totalRows_get_date;
}

function subject_name($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `subjects` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){
      return $row_get_data['name_eng'];
    }
    
}


function app_name($id)
{
    global $database;
    $query_get_data = "SELECT `name` FROM `app_login` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['name'];
}



function last_meeting($kid_id, $emp_id)
{
    global $database;
    $query_get_data = "SELECT * FROM `appointment` where `kid_id` = '{$kid_id}' and `emp_id` = '{$emp_id}' order by `id` desc";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    if ($totalRows_get_data > 0) {
        if ($row_get_data['day'] < (time() - 2592000)) {
            return 0;
        } else {
            return 1;
        }
    } else {
        return 0;
    }
}


function check_kid_name_lang($id)
{
    global $database;
    $query_get_data = "SELECT `fn_name` FROM `kids` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['fn_name'];
}



function classgroup($id)
{
    global $database;
    $query_get_data = "SELECT * FROM `classgroup` where `id` = '{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return subject_name($row_get_data['subject']);
}


function check_groupabsence($id, $day, $group)
{
    global $database;
    $query_get_data = "SELECT * FROM `group_absence` where `kid_id`='{$id}' and `day` ='{$day}' and `group_id` = '{$group}' ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $totalRows_get_data;
}



function parent_id($id)
{
    global $database;
    $query_get_data = "SELECT `parent_id` FROM `kids_list` where `kid_id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $row_get_data['parent_id'];
}


function group_subject($id)
{
    global $database;
    $query_get_data = "SELECT `subject` FROM `classgroup` where `id`='{$id}'";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return subject_name($row_get_data['subject']);
}



function check_year_subject($emp_id,$study_year){
    global $database;  
$query_get_data = "SELECT * FROM `teachers` WHERE `emp_id` = '{$emp_id}' AND `study_year` = '{$study_year}' ";
$get_data = mysqli_query($database , $query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);
return $totalRows_get_data;
}

function check_class_subject($emp_id,$class){
    global $database;  
$query_get_data = "SELECT * FROM `teachers` WHERE `emp_id` = '{$emp_id}' AND  `class` ='{$class}' ";
$get_data = mysqli_query($database , $query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);
return $totalRows_get_data;
}

function check_teacher_subject($id){
    global $database;  
  $query_get_data = "SELECT `cor` FROM `subjects` WHERE `id` = '{$id}' ";
  $get_data = mysqli_query($database , $query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){ return $row_get_data['cor'];}
  }


  function check_head_subject($id){
    global $database;  
  $query_get_data = "SELECT `head` FROM `subjects` WHERE `id` = '{$id}' ";
  $get_data = mysqli_query($database , $query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);
    if($totalRows_get_data>0){ return $row_get_data['head'];}
  }

  
function stage($study_year){
    if($study_year == 0 ) { $app = ' `app2_0` = 1  '; }
    if($study_year >= 1 && $study_year <= 2) { $app = ' `app2_1` = 1  '; }
    if($study_year >= 3 && $study_year <= 5) { $app = ' `app2_2` = 1 '; }
    if($study_year >= 6 && $study_year <= 8) { $app = ' `app2_3` = 1  '; }
    if($study_year >= 9 && $study_year <= 11) { $app = ' `app2_4` = 1  '; }
    if($study_year >= 12 && $study_year <= 14) { $app = ' `app2_5` = 1  '; }
    return  $app;
}

 
function day_today($date){
      $today = strtotime(date('Y-m-d', time()));
      $day = strtotime(date('Y-m-d', $date));
      if($today == $day){
          return 1;
        }else{ 
          return 0; } 
}


function file_type($file){
    if($file == null){ return " class='fa fa-hand-o-right' style='color: #112c5a; "; 
     }else{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
     if($ext =='pdf'){ return "  class='fa fa-file-pdf-o' style='color:red'; "; }
     elseif($ext =='doc' || $ext =='docx'){ return "  class='fa fa-file-word-o'  style='color:blue'; "; }
     elseif($ext =='xls' || $ext =='xlsx'){ return " class='fa fa-file-excel-o'  style='color:green'; "; }
     elseif($ext =='jpge' || $ext =='jpg' || $ext == 'png'){ return " class='fa fa-picture-o' style='color:orange'; "; }
     else{ return " class='fa fa-hand-o-right' style=' color: #112c5a; ";  }
    }
}



function file_icon($file){
    if($file == null){ return " <i class='fa fa-download' aria-hidden='true' style='color: #112c5a;></i> "; 
     }else{
     $ext = pathinfo($file, PATHINFO_EXTENSION);
     if($ext =='pdf'){ return "  <i class='fa fa-file-pdf-o' aria-hidden='true'  style='color:red'; '></i> ";  } 
     if($ext =='xls' || $ext =='xlsx'){ return "  <i class='fa fa-file-excel-o' aria-hidden='true'  style='color:green'; '></i> ";  } 
     if($ext =='doc' || $ext =='docx'){ return "  <i class='fa fa-file-text-o' aria-hidden='true'  style='color:blue'; '></i> ";  } 
    }
}

 

function urlpage()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

function fullurl()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
}


function bgcolor($id)
{
    switch ($id) {
        case 1:
            return "#c8efff";
            break;
        case 2:
            return "#d4ffc9";
            break;
        case 3:
            return "#fed9c7";
            break;
        case 4:
            return "#c8efff";
            break;
        case 5:
            return "#d4ffc9";
            break;
        case 6:
            return "#fed9c7";
            break; 
    }
}



function year_of_study_frn($id)
{
    switch ($id) {
        case 1:
            return " Jardin d'enfants 1 ";
            break;
        case 2:
            return " Jardin d'enfants 2 ";
            break;
        case 3:
            return " Première primaire";
            break;
        case 4:
            return " Deuxième primaire";
            break;
        case 5:
            return " Troisième primaire";
            break;
        case 6:
            return " Quatrième primaire";
            break;
        case 7:
            return " Cinquième primaire";
            break;
        case 8:
            return " Sixième primaire";
            break;
        case 9:
            return "  1ère Préparatoire";
            break;
        case 10:
            return " 2ère Préparatoire";
            break;
        case 11:
            return " 3ère Préparatoire";
            break;
        case 12:
            return "     Première secondaire";
            break;
        case 13:
            return "     Deuxième secondaire";
            break;
        case 14:
            return "     Troisième secondaire";
            break;
        case 15:
            return "     Général  ";
            break;
    }
}




function year_of_study_eng($id)
{
    switch ($id) {
        case 0:
            return " Preschool ";
            break;
        case 1:
            return " KG1 ";
            break;
        case 2:
            return " KG2 ";
            break;
        case 3:
            return " Junior One";
            break;
        case 4:
            return " Junior Two";
            break;
        case 5:
            return " Junior Three";
            break;
        case 6:
            return "Junior Four";
            break;
        case 7:
            return " Junior Five";
            break;
        case 8:
            return " Junior Six";
            break;
        case 9:
            return "  Middle One";
            break;
        case 10:
            return " Middle Two";
            break;
        case 11:
            return "    Middle Three ";
            break;
        case 12:
            return "     Senior  One ";
            break;
        case 13:
            return "     Senior  Two";
            break;
        case 14:
            return "     Senior  Three";
            break;
        case 15:
            return "     General  ";
            break;
    }
}




function study_type($id)
{
    switch ($id) {
        case 1:
            return "Scientific";
            break;
        case 2:
            return "Sciences";
            break;
        case 3:
            return "Maths";
            break;
        case 4:
            return "Literature";
            break;
    }
}



function month_name($id)
{
    switch ($id) {
        case 1:
            return "January";
            break;
        case 2:
            return "February";
            break;
        case 3:
            return "March";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "May";
            break;
        case 6:
            return "June";
            break;
        case 7:
            return "July";
            break;
        case 8:
            return "August";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "October";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "December";
            break;

    }
}


//teachers
function vac_type($id)
{
    switch ($id) {
        case 1:
            return "Regular";
            break;
        case 2:
            return "Urgent";
            break;
        case 3:
            return "Sick";
            break;
        case 4:
            return "Pregnancy";
            break;
        case 5:
            return "Exceptional";
            break;
        case 6:
            return "Marriage";
            break;
        case 7:
            return "Death";
            break;
        case 8:
            return "with no salary";
            break;
    }
}



function vac_days($start, $end)
{
    $step1 = $end - $start;
    $days = round($step1 / 86400, 0);
    if ($days == 1) {
        return $days . " Day";
    } else {
        return $days . " Days";
    }
}


function exc_time($start, $end)
{
    $step1 = $end - $start;
    $days = round($step1 / 3600, 2);
    $step1 = $end - $start;
    return gmdate("H:i", $step1);
}





function vac_status($id)
{
    switch ($id) {
        case 0:
            return "Pending";
            break;
        case 1:
            return "Accepted";
            break;
        case 2:
            return "Rejected";
            break;
        case 3:
            return "Canceled";
            break;
    }
}


function vac_color($id)
{
    switch ($id) {
        case 0:
            return "blue";
            break;
        case 1:
            return "green";
            break;
        case 2:
            return "red";
            break;
        case 3:
            return "orange";
            break;
    }
}





//kids

function kid_vac_type($id)
{
    switch ($id) {
        case 1:
            return "Sick";
            break;
        case 2:
            return "Championship";
            break;
        case 3:
            return "Travel";
            break;
        case 4:
            return "N/A";
            break;
    }
}




function evaluation($study_year, $dgree, $total)
{
    if ($study_year < 9) {
        if ($dgree == 0) {
            return "Absence";
        }
        if ((($dgree / $total) * 100) < 50) {
            return "Faible";
        }
        if ((($dgree / $total) * 100) >= 50 && (($dgree / $total) * 100) < 65) {
            return "Bien";
        }
        if ((($dgree / $total) * 100) >= 65 && (($dgree / $total) * 100) < 85) {
            return "Très Bien  ";
        }
        if ((($dgree / $total) * 100) >= 85 && (($dgree / $total) * 100) <= 120) {
            return "Excellent";
        }
    }
    if ($study_year > 8 && $study_year < 12) {
        if ($dgree == 0) {
            return "Absence";
        }
        if ((($dgree / $total) * 100) < 50) {
            return "Faible";
        }
        if ((($dgree / $total) * 100) >= 50 && (($dgree / $total) * 100) < 65) {
            return "Acceptable";
        }
        if ((($dgree / $total) * 100) >= 65 && (($dgree / $total) * 100) < 75) {
            return "Bien";
        }
        if ((($dgree / $total) * 100) >= 75 && (($dgree / $total) * 100) < 85) {
            return "Très Bien  ";
        }
        if ((($dgree / $total) * 100) >= 85 && (($dgree / $total) * 100) <= 120) {
            return "Excellent";
        }
    }
    if ($study_year > 11) {
        if ($dgree == 0) {
            return "Absence";
        }
        if ((($dgree / $total) * 100) < 50) {
            return "Faible";
        }
        if ((($dgree / $total) * 100) >= 50 && (($dgree / $total) * 100) < 65) {
            return "Bien";
        }
        if ((($dgree / $total) * 100) >= 65 && (($dgree / $total) * 100) < 85) {
            return "Très Bien  ";
        }
        if ((($dgree / $total) * 100) >= 85 && (($dgree / $total) * 100) <= 120) {
            return "Excellent";
        }
    }
}


function evaluation_color($dgree, $total)
{
    return (($dgree / $total) * 100);
}


function cert_study_type($study_year, $subject_name, $major)
{
    global $database;
    if ($study_year < 13) {
        return 1;
    } else {

        $return = 0;
        $query_get_data = "SELECT `major` FROM `subjects` WHERE `name`='{$subject_name}' AND `study_year` = '{$study_year}' ";
        $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        if ($major < 4 && $row_get_data['major'] != 3) {
            $return = 1;
        }
        if ($major > 3 && $row_get_data['major'] != 2) {
            $return = 1;
        }
        return $return;
    }
}


function birthday($gov_id){ 
    if(substr($gov_id,0,1)==2){$year0 = 19;}
    if(substr($gov_id,0,1)==3){$year0 = 20;}
    $year = substr($gov_id,1,2);
    $month = substr($gov_id,3,2);
    $day = substr($gov_id,5,2);
    $birthday =  $year0.$year."-".$month."-".$day;
    
    return strtotime($birthday);
    }



    function october_age_d($birthday){
        $y =  date("Y",time());  
    
      $date = strtotime(date($y."-10-01",time()));  
      $sec = $date-$birthday;    
      $date1 = new DateTime("@0");
      $date2 = new DateTime("@$sec");
      $interval =  date_diff($date1, $date2);
      return $interval->format('%d');
      }
    
      function october_age_m($birthday){
        $y =  date("Y",time());  
    
      $date = strtotime(date($y."-10-01",time()));  
      $sec = $date-$birthday;    
      $date1 = new DateTime("@0");
      $date2 = new DateTime("@$sec");
      $interval =  date_diff($date1, $date2);
      return $interval->format('%m');
      }
    
      function october_age_y($birthday){
        $y =  date("Y",time());  
    
      $date = strtotime(date($y."-10-01",time()));  
      $sec = $date-$birthday;    
      $date1 = new DateTime("@0");
      $date2 = new DateTime("@$sec");
      $interval =  date_diff($date1, $date2);
      return $interval->format('%y');
      }







$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function getOS()
{

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }

    return $os_platform;
}

function getBrowser()
{

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/edge/i'       =>  'Edge',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }

    return $browser;
}


$user_os        =   getOS();
$user_browser   =   getBrowser();


function app_msg_id($id)
{
    global $database;
    $query_get_data = " SELECT * FROM `kids_list` where `kid_id`='{$id}'  ";
    $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data); 

    $query_get_data2 = " SELECT * FROM `app_login` where `id`='{$row_get_data['parent_id']}'  ";
    $get_data2 = mysqli_query($database, $query_get_data2) or die(mysqli_error($database));
    $row_get_data2 = mysqli_fetch_assoc($get_data2); 
    return $row_get_data2['phone_id'];
}

function app_msg_id2($id)
{
    global $database;
    $query_get_data2 = " SELECT * FROM `app_login` where `emp_id`='{$id}'  ";
    $get_data2 = mysqli_query($database, $query_get_data2) or die(mysqli_error($database));
    $row_get_data2 = mysqli_fetch_assoc($get_data2);
    $totalRows_get_data2 = mysqli_num_rows($get_data2);
    return $row_get_data2['phone_id'];
}

function sendMessage($user_ids, $title, $msg)
{
    $fields = array(
        'app_id' => "65ddec18-ce30-4e8c-ae11-5bfa7d1979a5",
        'include_player_ids' => array($user_ids),
        'data' => array("foo" => "bar"),
        'headings' => array("en" => $title),
        'contents' => array("en" => $msg)
    );

    $fields = json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ODk5YTMwYWUtYjIyNy00MjAwLWFhNTgtZjk4ODFhY2JjZWMx'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);
}
