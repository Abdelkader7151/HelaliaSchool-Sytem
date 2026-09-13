<?php 
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
 
 
	 
  function sendMessage($user_ids,$title,$msg){  
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
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
										   'Authorization: Basic ODk5YTMwYWUtYjIyNy00MjAwLWFhNTgtZjk4ODFhY2JjZWMx'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	$response = curl_exec($ch);
	curl_close($ch);  
  }

  
?>