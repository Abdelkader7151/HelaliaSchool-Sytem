<?php require_once('includes/access.php');  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');
 if (!function_exists('helalia_phone_is_taken')) {
   require_once('includes/phone-unique.php');
 }

 if($row_get_login['access6sub3']==1){

if(isset($_GET['id'])){  

    mysqli_select_db($database, $database_database); 
    $query_get_users_info = "SELECT * FROM `emps` where `id`='{$_GET['id']}'  ";
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);

    mysqli_select_db($database, $database_database); 
    $query_get_app_login = "SELECT * FROM `app_login` where `emp_id`='{$_GET['id']}'   ";
    $get_app_login = mysqli_query($database,$query_get_app_login) or die(mysqli_error($database));
    $row_get_app_login = mysqli_fetch_assoc($get_app_login);
    $totalRows_get_app_login = mysqli_num_rows($get_app_login);

    $empId = (int) $_GET['id'];
    $phoneTaken = helalia_phone_is_taken($database, $row_get_users_info['phone'], array(
        'exclude_emp_id' => $empId,
        'exclude_app_login_emp_id' => $empId,
    ));

    if ($totalRows_get_app_login < 1 && !$phoneTaken) {
        $insertSQL = sprintf("INSERT INTO `app_login` (`name`, `phone`, `email`, `password`, `emp_id`, `date`,  `account_type`) VALUES (%s, %s, %s, %s, %s, %s, 2)",
                            GetSQLValueString($database,$row_get_users_info['name'], "text"),
                            GetSQLValueString($database,$row_get_users_info['phone'], "text"), 
                            GetSQLValueString($database,$row_get_users_info['email'], "text"), 
                            GetSQLValueString($database,md5(123456), "text"),  
                            GetSQLValueString($database,$_GET['id'], "int"), 
                            GetSQLValueString($database,time(), "int"));

            mysqli_select_db($database, $database_database);   
            $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));  
            header("location: edit-emp.php?id=".$_GET['id']."&app_created=1"); 
            exit();
    }

    if ($phoneTaken) {
        header("location: edit-emp.php?id=".$_GET['id']."&phone_exists=1"); 
        exit();
    }

    header("location: edit-emp.php?id=".$_GET['id']); 
    exit(); 
            

  }}else{header("location: home.php;");exit();}?>
