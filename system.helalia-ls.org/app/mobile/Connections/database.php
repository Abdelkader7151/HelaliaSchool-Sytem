<?php

# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

if (!isset($_SESSION)){
  // Keep PHP session alive across iPhone app reopen (fallback; main auth is helu/help cookies).
  if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params(array(
      'lifetime' => 86400 * 365,
      'path' => '/',
      'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443'),
      'httponly' => true,
      'samesite' => 'Lax',
    ));
  } else {
    session_set_cookie_params(86400 * 365, '/');
  }
  session_start();
} 

 //error_reporting(E_ERROR | E_WARNING | E_PARSE);

 //error_reporting(E_ALL);

 error_reporting(0); 

ini_set('display_errors', 'On'); 

ini_set('max_execution_time', 600);

date_default_timezone_set("Africa/Cairo"); 

$hostname_database = "localhost";

$database_database = "helalia_control";

$username_database = "helalia_user";

$password_database = "VIxfR}%rc#~X";



$database = mysqli_connect($hostname_database,$username_database,$password_database,$database_database); 

$database2 = mysqli_connect($hostname_database,$username_database,$password_database,$database_database); 



 if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error(); exit();}

  

mysqli_set_charset($database,"utf8"); 

mysqli_character_set_name($database);





 



?>