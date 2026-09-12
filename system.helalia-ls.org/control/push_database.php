<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if (!isset($_SESSION)){session_start();}   
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set('display_errors', 'On'); 
ini_set('max_execution_time', 600);
date_default_timezone_set("Africa/Cairo"); 
$hostname_database = "localhost";
$database_database = "helalia_control";
$username_database = "helalia_user";
$password_database = "VIxfR}%rc#~X";

$database = mysqli_connect($hostname_database,$username_database,$password_database,$database_database);

 if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error(); exit();}
  
mysqli_set_charset($database,"utf8"); 
mysqli_character_set_name($database);
?>