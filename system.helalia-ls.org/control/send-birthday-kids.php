<?php 
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true" 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set("Africa/Cairo"); 
$hostname_database = "localhost";
$database_database = "sja_db";
$username_database = "sja_school";
$password_database = "qwerASDF1234";
$database = mysql_pconnect($hostname_database, $username_database, $password_database) or trigger_error(mysql_error(),E_USER_ERROR); 
mysqli_query($database,"set character_set_server='utf8'");
mysqli_query($database,"set names 'utf8'"); 

 if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($database,$theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
      if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
      }
    
      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
    
      switch ($theType) {
        case "text":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;    
        case "long":
        case "int":
          $theValue = ($theValue != "") ? intval($theValue) : "NULL";
          break;
        case "double":
          $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
          break;
        case "date":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;
        case "defined":
          $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
          break;
      }
      return $theValue;
    }
 }  


 function kid_link($id){ 
    $query_get_data = " SELECT * FROM `kids_list` where `kid_id`='{$id}'  "; 
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
    return $totalRows_get_data;
 }

 function app_msg_id($id){ 
    $query_get_data = " SELECT * FROM `kids_list` where `kid_id`='{$id}'  "; 
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);

    $query_get_data2 = " SELECT * FROM `app_login` where `id`='{$row_get_data['parent_id']}'  "; 
    $get_data2 = mysqli_query($database,$query_get_data2) or die(mysqli_error($database));
    $row_get_data2 = mysqli_fetch_assoc($get_data2);
    $totalRows_get_data2 = mysqli_num_rows($get_data2);
    return $row_get_data2['phone_id'];
 }

 function parent_id($id){ 
    $query_get_data = " SELECT * FROM `kids_list` where `kid_id`='{$id}' "; 
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data); 
    return $row_get_data['parent_id'];
 }
 
 function birthday_check($birthday){ 
	$y = date("Y",time());
	$birthday = strtotime(date("m/d/".$y,$birthday));  
    $today = strtotime(date("m/d/Y",time()));   
	if($today==$birthday){return 1;}else{return 0;}  
}


function add_notifications($user_id,$kid_id,$text,$type){  
    $insertSQL = sprintf("INSERT INTO `notifications` ( `user_id`, `kid_id`, `text`, `type`, `date`) VALUES ( %s, %s, %s, %s, %s)", 
                                    GetSQLValueString($database,$user_id, "int"),
                                    GetSQLValueString($database,$kid_id, "int"),        
                                    GetSQLValueString($database,$text, "text"),        
                                    GetSQLValueString($database,$type, "int"),        
                                    GetSQLValueString($database,time(), "int"));
     
           $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database)); 
    }

    

function sendMessage($user_ids,$title,$msg){  
    $fields = array(
        'app_id' => "7cfa22a5-96be-4435-bd3e-253d0427f44b",
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
                                           'Authorization: Basic YjNiODg5NDgtMWJhOS00OTBmLWIzZmEtMzIwOGQ3NGIzMWVl'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    $response = curl_exec($ch);
    curl_close($ch);  
}




mysqli_select_db($database, $database_database);  
$query_get_users_info = " SELECT * FROM `kids` "; 
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
   if($totalRows_get_users_info>0){ 
	  do{ 
          if(birthday_check($row_get_users_info['birthday'])==1){ 
               if(kid_link($row_get_users_info['id'])>0){
                  // echo $row_get_users_info['name']."<br>"; 
                  //echo app_msg_id($row_get_users_info['id']);
                  if(app_msg_id($row_get_users_info['id'])!=null){sendMessage(app_msg_id($row_get_users_info['id']),"SJA","Happy Birthday"); } 
                  if($row_get_users_info['fn_name']!=null){$name = $row_get_users_info['fn_name'];}else{$name = $row_get_users_info['name'];}
                  add_notifications(parent_id($row_get_users_info['id']),$row_get_users_info['id'],"Happy Birthday ".$name,2);
               }  
           }
          
             }while($row_get_users_info = mysqli_fetch_assoc($get_users_info)); 
   }            


    



?>  