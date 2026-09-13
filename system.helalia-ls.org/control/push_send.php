<?php
 require_once('push_database.php'); 
 require_once('push_functions.php');   
  
if(isset($_POST['title']) && isset($_POST['msg']) && isset($_POST['target']) && isset($_POST['classes'])){  
  
  $sent=0;

           $insertSQL2 = sprintf("INSERT INTO `push_msg` ( `target`, `class`, `msg`, title, `date`, `admin_id`) VALUES (%s, %s, %s, %s, %s, %s)", 
                    GetSQLValueString($database,$database, $_POST['target'], "int"),
                    GetSQLValueString($database,$database, isset($_POST['classes'])?$_POST['classes']:0, "int"),
                    GetSQLValueString($database,$database, "<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                    GetSQLValueString($database,$database, $_POST['title'], "text"),
                    GetSQLValueString($database,$database, time(), "int"),
                    GetSQLValueString($database,$database, 0, "int"));

           mysqli_select_db($database,$database_database);    
           $Result2 = mysqli_query($database, $insertSQL2) or die(mysqli_error($database)); 
 

  mysqli_select_db($database, $database_database); 
  $query_get_push_msg = "SELECT `id` FROM `push_msg` WHERE `admin_id` = 0 ORDER BY `id` DESC ";
  $get_push_msg = mysqli_query($database,$query_get_push_msg) or die(mysqli_error($database));
  $row_get_push_msg = mysqli_fetch_assoc($get_push_msg);
  $totalRows_get_push_msg = mysqli_num_rows($get_push_msg);



  if($_POST['classes']<1){ 
    $class  = ""; 
  }else{
    $class = " AND `kids`.class = '{$_POST['classes']}' ";
  }

    mysqli_select_db($database, $database_database); 
    $query_get_target = "SELECT `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id =  `app_login`.id  WHERE `kids`.linked = 1 AND `kids`.study_year = '{$_POST['target']}'  $class ";
    $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
    $row_get_target = mysqli_fetch_assoc($get_target);
    $totalRows_get_target = mysqli_num_rows($get_target); 


        do{ 
            $insertSQL1 = sprintf("INSERT INTO `notifications` (`not_id`, `title`, `user_id`, `kid_id`, `class`, `text`, `date`, `type`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($database,$row_get_push_msg['id'], "int"),
                            GetSQLValueString($database,"Model - E-learning", "text"),
                            GetSQLValueString($database,$row_get_target['app_login_id'], "int"),
                            GetSQLValueString($database,$row_get_target['kid_id'], "int"),
                            GetSQLValueString($database,$_POST['classes'], "int"),
                            GetSQLValueString($database,$_POST['title']."<br>,<pre style='white-space:pre-wrap'>".$_POST['msg']."</pre>", "text"),
                            GetSQLValueString($database,time(), "int"),
                            GetSQLValueString($database,6, "int"));

          if($row_get_target['parent_id']!=NULL){    
            $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 
            sendMessage($row_get_target['phone_id'],$_POST['title'],str_replace("<br>","",$_POST['msg']));
            $sent++;
          }
        }while($row_get_target = mysqli_fetch_assoc($get_target)); 

        echo $sent;
	}  
    ?>