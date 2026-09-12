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
  
 
//initialize the session
if (!isset($_SESSION)) {session_start();}  
 

mysqli_select_db($database, $database_database); 
$query_get_settings = "SELECT * FROM settings";
$get_settings = mysqli_query($database,$query_get_settings) or die(mysqli_error($database));
$row_get_settings = mysqli_fetch_assoc($get_settings);
$totalRows_get_settings = mysqli_num_rows($get_settings);

  
$head_title = $row_get_settings['website_title_eng'];



//start Login
if(isset($_SESSION['MM_Username']) && isset($_SESSION['admin'])){
	mysqli_select_db($database, $database_database); 
	$query_get_login = "SELECT * FROM users where username = '{$_SESSION['MM_Username']}'";
	$get_login = mysqli_query($database,$query_get_login) or die(mysqli_error($database));
	$row_get_login = mysqli_fetch_assoc($get_login);
	$totalRows_get_login = mysqli_num_rows($get_login);
	
	
	
//return url
function get_url($url){ 
$val = explode('/', $url);  
	$result = end($val);
	$arr = explode("?", $result, 2);
return  $arr[0];
}

function get_url2($url){ 
$val = explode('/', $url);  
	$result = end($val); 
return  $result;
}
 

function check_absence_day($id,$day){ 
	global $database;
	if($day==0){
	    $start = strtotime(date("m/d/Y",time()));
	    $end = strtotime(date("m/d/Y",time()))+86400; 
	}else{ 
		$start = strtotime(date("m/d/Y",$day));
	    $end = strtotime(date("m/d/Y",$day))+86400;
	 }
	
	  $query_get_data = "SELECT `id` FROM `kids-absence` where `kid_id`='{$id}' and `date`>= '{$start}' and `date` <'{$end}'";
	  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	  $row_get_data = mysqli_fetch_assoc($get_data);
	  $totalRows_get_data = mysqli_num_rows($get_data); 
	  return $totalRows_get_data;
	}

function check_absence($id){ 
	global $database;
	$start = strtotime(date("m/d/Y",time()));
	$end = strtotime(date("m/d/Y",time()))+86400; 
	
	  $query_get_data = "SELECT `id` FROM `kids-absence` where `kid_id`='{$id}' and `date`>= '{$start}' and `date` <'{$end}'";
	  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	  $row_get_data = mysqli_fetch_assoc($get_data);
	  $totalRows_get_data = mysqli_num_rows($get_data); 
	  return $totalRows_get_data;
	}

function check_photo_gallery($id){
	global $database;
$query_get_data = "SELECT * FROM `gallery-pictures`  where `album_id` = '{$id}'  "; 
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);
return $totalRows_get_data;
}

function check_video_gallery($id){
	global $database; 
	$query_get_data = "SELECT * FROM `videos`  where `album_id` = '{$id}'  "; 
	$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	$row_get_data = mysqli_fetch_assoc($get_data);
	$totalRows_get_data = mysqli_num_rows($get_data);
	return $totalRows_get_data;
	}

	function video_album($id){ 
		global $database;
		$query_get_data = "SELECT * FROM `video-albums`  where `id` = '{$id}'  "; 
		$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
		$row_get_data = mysqli_fetch_assoc($get_data);
		$totalRows_get_data = mysqli_num_rows($get_data);
		return $row_get_data['title'];
		}


function teacher($id){ 
	global $database;
	$query_get_data = "SELECT `subjects` FROM `jobs` where `id`='{$id}'";
	   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	   $row_get_data = mysqli_fetch_assoc($get_data);
	   $totalRows_get_data = mysqli_num_rows($get_data); 
	   return $row_get_data['subjects'];
	}
 

	function kid_app($id){
		global $database; 
		   $query_get_data = "SELECT `id` FROM `kids_list` where `kid_id`='{$id}'";
		   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
		   $row_get_data = mysqli_fetch_assoc($get_data);
		   $totalRows_get_data = mysqli_num_rows($get_data); 
		   return $totalRows_get_data;
		}

 

 function job_name($id){ 
	global $database;
 $query_get_data = "SELECT `name` FROM `jobs` where `id`='{$id}'";
	$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	$row_get_data = mysqli_fetch_assoc($get_data);
	$totalRows_get_data = mysqli_num_rows($get_data); 
	return $row_get_data['name'];
 }

 function emp_job($id){ 
	global $database;
	   $query_get_data = "SELECT `job` FROM `emps` where `id`='{$id}'";
	   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	   $row_get_data = mysqli_fetch_assoc($get_data);
	   $totalRows_get_data = mysqli_num_rows($get_data); 
	   return $row_get_data['job'];
	}

 function kid_name($id){
	global $database;
	$query_get_data = "SELECT `name` FROM `kids` where `id`='{$id}'";
	   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	   $row_get_data = mysqli_fetch_assoc($get_data);
	   $totalRows_get_data = mysqli_num_rows($get_data); 
	   return $row_get_data['name'];
	}




	

	function kid_study_year($id){ 
		global $database;
		$query_get_data = "SELECT `study_year` FROM `kids` where `id`='{$id}'";
		   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
		   $row_get_data = mysqli_fetch_assoc($get_data);
		   $totalRows_get_data = mysqli_num_rows($get_data); 
		   return $row_get_data['study_year'];
		}

	function emp_name($id){ 
		global $database;
		$query_get_data = "SELECT `name` FROM `emps` where `id`='{$id}'";
		   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
		   $row_get_data = mysqli_fetch_assoc($get_data);
		   $totalRows_get_data = mysqli_num_rows($get_data); 
		   return $row_get_data['name'];
		} 


		function users_name($id){ 
			global $database;
			$query_get_data = "SELECT `name` FROM `users` where `id`='{$id}' ";
			   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
			   $row_get_data = mysqli_fetch_assoc($get_data);
			   $totalRows_get_data = mysqli_num_rows($get_data); 
			   return $row_get_data['name'];
			}
		

    function class_name($id){ 
		global $database;
			   $query_get_data = "SELECT `name` FROM `class` where `id`='{$id}'";
			   $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
			   $row_get_data = mysqli_fetch_assoc($get_data);
			   $totalRows_get_data = mysqli_num_rows($get_data); 
			   return $row_get_data['name'];
			}

    function app_check($id){ 
		global $database;
				$query_get_data = "SELECT * FROM `app_login` where `account_type`=2  and `emp_id`='{$id}' ";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $totalRows_get_data;
			 }
	
	function app_pass($id){ 
		global $database;
				$query_get_data = "SELECT * FROM `app_login` where `account_type`=2 and `emp_id`='{$id}' ";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['password'];
			 }
    function app_phone($id){ 
		global $database;
				$query_get_data = "SELECT * FROM `app_login` where `phone`='{$id}' ";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $totalRows_get_data;
			 }		
			 
     function app_phone2($phone,$emp_id){ 
		global $database;
				$query_get_data = "SELECT * FROM `app_login` where `phone`='{$phone}' and `emp_id`='{$emp_id}' ";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $totalRows_get_data;
			 }	

	 
			 function kid_class($id){ 
				global $database;
				$query_get_data = "SELECT `class` FROM `kids` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['class'];
			 }


			
            function class_year($id){ 
				global $database;
				$query_get_data = "SELECT `study_year` FROM `class` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['study_year'];
			 }
 
			
			 function classgroup_name($id){
				global $database; 
				$query_get_data = "SELECT `name` FROM `classgroupclassgroup` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['name'];
			 }
 

			 function classgroup_year($id){ 
				global $database;
				$query_get_data = "SELECT `study_year` FROM `classgroup` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['study_year'];
			 }

			 function subject_name($id){ 
				global $database;
				$query_get_data = "SELECT `name` FROM `subjects` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $row_get_data['name'];
			 }


			 function group_subject_name($id){ 
				global $database;  
				$query_get_data = "SELECT `subject` FROM `classgroup` where `id`='{$id}'";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return  subject_name($row_get_data['subject']);
			 }


			 function classgroup_kid_exist($classgroup_id,$kid_id){ 
				global $database;
				$query_get_data = "SELECT * FROM `classgroup_list`  where `classgroup_id`='{$classgroup_id}' and `kid_id`='{$kid_id}' ";
				$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
				$row_get_data = mysqli_fetch_assoc($get_data);
				$totalRows_get_data = mysqli_num_rows($get_data); 
				return $totalRows_get_data;
			 }

 function year_of_study($id){
	switch($id){
		case 0:
			return "بري سكول";
			break;  
	   case 1:
			return "اولى حضانة";
			break;
	   case 2:
			return "ثانية حضانة";
			break; 
	   case 3:
			return "الصف الاول الابتدائى";
			break; 	  
	   case 4:
			return "الصف الثانى الابتدائى";
			break; 		
	   case 5:
			return "الصف الثالث الابتدائى";
			break; 
	   case 6:
	  	    return "الصف الرابع الابتدائى";
			break;
	   case 7:
			 return "الصف الخامس الابتدائى";
			 break;	
	   case 8:
			 return "الصف السادس الابتدائى";
			 break;
	   case 9:
			return "الصف الاول الاعدادى";
			break;	 
	   case 10:
			return "الصف الثاني الاعدادى";
			break;	
	   case 11:
			return "الصف الثالث الاعدادى";
			break;	
	    case 12:
			return " الصف الاول الثانوى";
			break;
	    case 13:
			return " الصف الثاني الثانوى";
			break;
	    case 14:
			return " الصف الثالث الثانوى";
			break;	
	    case 15:
		return " خريجين";
		break;
		
		case 16:
			return " رياض الاطفال";
			break;
		case 17:
			return " الصف   الابتدائى";
			break;
		case 18:
			return " الصف   الاعدادى";
			break;
		case 19:
			return " الصف   الثانوى";
			break;
		case 20:
			return " جميع الصفوف";
			break; 
		case 21:
			return " جميع الصفوف";
			break;
		case 100:
			return " جميع المراحل و العاملين";
			break;		
		case 200:
			return " جميع العاملين";
			break;
		case 300:
			return " جميع المراحل";
			break;									

   }    
}

function religion($id){
	switch($id){
	   case 1:
			return " مسلم";
			break;
	   case 2:
			return " مسيحي";
			break;  
   }    
}

function transfare($id){
	switch($id){
	   case 1:
			return " مستجد";
			break; 
	   case 2:
			return " منقول";
			break;
	    
   }    
}

function study_type($id){
	switch($id){
	   case 1:
			return " علمى";
			break;
	   case 2:
			return " علمي علوم";
			break; 
		case 3:
			return " علمي رياضة";
			break;
		case 4:
			return " أدبي";
			break; 
   }    
}


function kid_vac_title($id){
	switch($id){
	   case 1:
			return "مرضي";
			break;
	   case 2:
			return "بطولة";
			break; 
		case 3:
			return "سفر";
			break;
		case 4:
			return "N/A";
			break; 
   }    
}
function vacation_check($vacation_date,$kid_id){ 
	global $database;
	$query_get_date = "SELECT * FROM `kids_vacations` where `vacation_date`<='{$vacation_date}' and `vacation_end`>'{$vacation_date}'  and `kid_id`='{$kid_id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	return $totalRows_get_date;  
}

function sick_note($absence_id){ 
	global $database;
	$query_get_date = "SELECT `sick_note` FROM `kids_vacations` where `absence_id`='{$absence_id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	 if($totalRows_get_date>0){
		return " <a target='_blank' href='../attachments/".$row_get_date['sick_note']."'>مرفق <i class='fa fa-paperclip'  ></i> </a>";
	 }
}



function kid_vac_type($vacation_date,$kid_id){ 
	global $database;
	$query_get_date = "SELECT * FROM `kids_vacations` where `vacation_date`<='{$vacation_date}' and `vacation_end`>'{$vacation_date}'  and `kid_id`='{$kid_id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	return $row_get_date['type'] ;  
}




function added_kids($id){ 
	global $database;
	$query_get_date = "SELECT `id` FROM `kids_list` where `parent_id`='{$id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	return $totalRows_get_date;  
}



function parent_app($id){ 
	global $database;
	$query_get_date = "SELECT `name` FROM `app_login` where `id`='{$id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	return $row_get_date['name'];  
}


	 
 function cities_manager($id){ 
	global $database;
	$query_get_date = "SELECT `id` FROM `cities`  where `manager`='{$id}' ";
	$get_date = mysqli_query($database,$query_get_date) or die(mysqli_error($database));
	$row_get_date = mysqli_fetch_assoc($get_date);
	$totalRows_get_date = mysqli_num_rows($get_date);
	return $row_get_date['id'];  
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

 

function birthday10($birthday){ 
	$y = date("Y",time());
	$birthday = strtotime(date("m/d/".$y,$birthday)); 
	$date10 = time()+864000;  
	if($date10>=$birthday && $birthday>time()){return 1;}else{return 0;}  
}

function birthdaytoday($birthday){ 
	$y = date("Y",time());
	$birthday = strtotime(date("m/d/".$y,$birthday));  
    $today = strtotime(date("m/d/Y",time()));   
	if($today==$birthday){return 1;}else{return 0;}  
}

function birthdaymonth($birthday){  
	$birthday =   date("m",$birthday);  
    $month = date("m",time());   
	if($month==$birthday){return 1;}else{return 0;}  
}

 

function convertSecToTime($birthday){
    $y =  date("Y",time());  

  $date = strtotime(date($y."-10-01",time()));  
  $sec = $date-$birthday;    
  $date1 = new DateTime("@0");
  $date2 = new DateTime("@$sec");
  $interval =  date_diff($date1, $date2);
  return $interval->format('%y سنة   %m شهر  %d يوم');
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


  function count_class_kid($id){
	global $database;
	$query_get_data = " SELECT * FROM `kids`  where class = '{$id}'"; 
	$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	$row_get_data = mysqli_fetch_assoc($get_data);
	$totalRows_get_data = mysqli_num_rows($get_data);
	return  $totalRows_get_data; 
	}


	function group_kid_count($id){
		global $database;
		$query_get_data = " SELECT * FROM `classgroup_list` where `classgroup_id` = '{$id}' "; 
		$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
		$row_get_data = mysqli_fetch_assoc($get_data);
		$totalRows_get_data = mysqli_num_rows($get_data);
		return  $totalRows_get_data;
		}


  function vac_days($start,$end){
	$step1 = $end-$start;
	$days = round($step1/86400,0);
	if($days==1){return $days." Day";}else{return $days." Days"; } 
	}


  function vac_status($id){
	switch($id){
	   case 0:
			return "معلق";
			break;
	   case 1:
			return "مقبول";
			break; 
		case 2:
			return "مرفوض";
			break;
		case 3:
			return "ملغي";
      break;  
   }    
}




  function vac_type($id){
	switch($id){
	   case 1:
			return "اعتيادية";
			break;
	   case 2:
			return "عارضة";
			break; 
		case 3:
			return "مرضي";
			break;
		case 4:
			return "وضع";
      break; 
    case 5:
      return "استثنائية";
      break;   
    case 6:
      return "زواج";
      break;  
    case 7:
      return "وفاة";
      break;  
    case 8:
      return "بدون راتب";
      break;      
   }    
}




function vac_color($id){
	switch($id){
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



function exc_time($start,$end){
	$step1 = $end-$start;
	$days = round($step1/3600,2);
	$step1 = $end - $start;
    return gmdate("H:i", $step1);
	}
	  

}
 



function add_notifications($user_id,$kid_id,$text,$type){ 
	global $database;

$insertSQL = sprintf("INSERT INTO `notifications` ( `user_id`, `kid_id`, `text`, `type`, `date`) VALUES ( %s, %s, %s, %s, %s)", 
                                GetSQLValueString($database,$user_id, "int"),
								GetSQLValueString($database,$kid_id, "int"),        
								GetSQLValueString($database,$text, "text"),        
								GetSQLValueString($database,$type, "int"),        
								GetSQLValueString($database,time(), "int"));
 
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
	
}


   
    
function app_msg_id($id){ 
	global $database;
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

  function sendMessage2($title,$msg){ 
	$content = array(
		"en" => $msg
		);

   $headings = array(
			"en" => $title
			); 

	$fields = array(
		'app_id' => "65ddec18-ce30-4e8c-ae11-5bfa7d1979a5",
		'included_segments' => array('All'),
		'data' => array("foo" => "bar"), 
		'headings' => $headings,
		'contents' => $content
	);

	$fields = json_encode($fields); 

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
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



function sendMessage3($user_ids,$title,$msg){  
	$fields = array(
		'app_id' => "65ddec18-ce30-4e8c-ae11-5bfa7d1979a5",
		'include_player_ids' => $user_ids,
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


function emp_id($id){ 
	global $database;
	$query_get_data = "SELECT `id` FROM `emps` where `ext_id`='{$id}'";
	$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
	$row_get_data = mysqli_fetch_assoc($get_data);
	$totalRows_get_data = mysqli_num_rows($get_data); 
	return $row_get_data['id'];
 }

 
//end login
?>