<li class="visible-xs-block">
  <h4 class="navbar-text text-center"><?php echo $row_get_login['name'];?></h4>
</li>
 

<?php
 //if(get_url($_SERVER['REQUEST_URI'])=='home.php'){}
 
if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_emp_birthday_notification = "SELECT `birthday` FROM `emps` ";
  $get_emp_birthday_notification = mysqli_query($database,$query_get_emp_birthday_notification) or die(mysqli_error($database));
  $row_get_emp_birthday_notification = mysqli_fetch_assoc($get_emp_birthday_notification);
  $totalRows_emp_birthday_notification = mysqli_num_rows($get_emp_birthday_notification);
  if($totalRows_emp_birthday_notification>0){
    $emp_birthday_notification=0;
    do{ 
      if(birthdaytoday($row_get_emp_birthday_notification['birthday'])==1){$emp_birthday_notification++;}
  }while ($row_get_emp_birthday_notification = mysqli_fetch_assoc($get_emp_birthday_notification));
      if($emp_birthday_notification>0){
  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="all-emps-birthday-today.php"  aria-haspopup="true" title=" اعياد ميلاد الموظفين اليوم">
                      <span class="icon-with-child hidden-xs">
                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $emp_birthday_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $emp_birthday_notification;?></span>
                              اليوماعياد ميلاد الموظفين اليوم
                      </span>
                    </a> 
                </li>
<?php  } } }

if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_kids_birthday_notification = "SELECT `birthday` FROM `kids` ";
  $get_kids_birthday_notification = mysqli_query($database,$query_get_kids_birthday_notification) or die(mysqli_error($database));
  $row_get_kids_birthday_notification = mysqli_fetch_assoc($get_kids_birthday_notification);
  $totalRows_kids_birthday_notification = mysqli_num_rows($get_kids_birthday_notification);
  if($totalRows_kids_birthday_notification>0){
    $kids_birthday_notification=0;
    do{ 
      if(birthdaytoday($row_get_kids_birthday_notification['birthday'])==1){$kids_birthday_notification++;}
  }while ($row_get_kids_birthday_notification = mysqli_fetch_assoc($get_kids_birthday_notification));
      if($kids_birthday_notification>0){
  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="all-kids-birthday-today.php"  aria-haspopup="true" title=" اعياد ميلاد الطلبة اليوم">
                      <span class="icon-with-child hidden-xs">
                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $kids_birthday_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $kids_birthday_notification;?></span>
                             اعياد ميلاد الطلبة اليوم
                      </span>
                    </a> 
                </li>
<?php  } } }

if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database);
  $query_get_kids_vacations_notification = "SELECT `id` FROM `kids_vacations` WHERE `status` = 0 ";
  $get_kids_vacations_notification = mysqli_query($database,$query_get_kids_vacations_notification) or die(mysqli_error($database));
  $row_get_kids_vacations_notification = mysqli_fetch_assoc($get_kids_vacations_notification);
  $totalRows_kids_vacations_notification = mysqli_num_rows($get_kids_vacations_notification);
  if($totalRows_kids_vacations_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="all-kids-vacations.php"  aria-haspopup="true" title="طلب اجاذة لطالب">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_kids_vacations_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_kids_vacations_notification;?></span>
                        طلب اجاذة لطالب
                      </span>
                    </a> 
                </li>
<?php  } }  
 
 if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_emps_vacations_notification = "SELECT `id` FROM `emps_vacations` WHERE `status` = 0 ";
  $get_emps_vacations_notification = mysqli_query($database,$query_get_emps_vacations_notification) or die(mysqli_error($database));
  $row_get_emps_vacations_notification = mysqli_fetch_assoc($get_emps_vacations_notification);
  $totalRows_emps_vacations_notification = mysqli_num_rows($get_emps_vacations_notification);
  if($totalRows_kids_vacations_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="all-emps-vacations.php"  aria-haspopup="true" title="طلب اجاذة للموظفين">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_emps_vacations_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_emps_vacations_notification;?></span>
                        طلب اجاذة للموظفين
                      </span>
                    </a> 
                </li>
<?php  } }  

if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_emps_excuse_notification = "SELECT `id` FROM `emps_excuse` WHERE `status` = 0 ";
  $get_emps_excuse_notification = mysqli_query($database,$query_get_emps_excuse_notification) or die(mysqli_error($database));
  $row_get_emps_excuse_notification = mysqli_fetch_assoc($get_emps_excuse_notification);
  $totalRows_emps_excuse_notification = mysqli_num_rows($get_emps_excuse_notification);
  if($totalRows_emps_excuse_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="all-emps-exc.php?id=0"  aria-haspopup="true" title="طلبات اذون للموظفين">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_emps_excuse_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_emps_excuse_notification;?></span>
                        طلبات اذون للموظفين
                      </span>
                    </a> 
                </li>
<?php  } }  
if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_app_contact_notification = "SELECT `id` FROM `contacts` WHERE  `view` = 0 and `account_type`=1";
  $get_app_contact_notification = mysqli_query($database,$query_get_app_contact_notification) or die(mysqli_error($database));
  $row_get_app_contact_notification = mysqli_fetch_assoc($get_app_contact_notification);
  $totalRows_app_contact_notification = mysqli_num_rows($get_app_contact_notification);
  if($totalRows_app_contact_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="new-parents-msgs.php"  aria-haspopup="true" title="    رسائل من اولياء الامور">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_app_contact_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_app_contact_notification;?></span>
                        رسائل من اولياء الامور
                      </span>
                    </a> 
                </li>
<?php  } } 

if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_app_contact_notification = "SELECT `id` FROM `contacts` WHERE  `view` = 0 and `account_type`=2";
  $get_app_contact_notification = mysqli_query($database,$query_get_app_contact_notification) or die(mysqli_error($database));
  $row_get_app_contact_notification = mysqli_fetch_assoc($get_app_contact_notification);
  $totalRows_app_contact_notification = mysqli_num_rows($get_app_contact_notification);
  if($totalRows_app_contact_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="new-emp-msgs.php"  aria-haspopup="true" title="    رسائل من   الموظفين">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_app_contact_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_app_contact_notification;?></span>
                        رسائل من   الموظفين
                      </span>
                    </a> 
                </li>
<?php  } }  
 
 if($row_get_login['access1']==1){  

  mysqli_select_db($database, $database_database); 
  $query_get_app_contact_notification = "SELECT `id` FROM `ask_teacher` WHERE  `status` = 0 ";
  $get_app_contact_notification = mysqli_query($database,$query_get_app_contact_notification) or die(mysqli_error($database));
  $row_get_app_contact_notification = mysqli_fetch_assoc($get_app_contact_notification);
  $totalRows_app_contact_notification = mysqli_num_rows($get_app_contact_notification);
  if($totalRows_app_contact_notification>0){  ?> 
           <li class="dropdown">
                    <a class="dropdown-toggle blink" href="new-teacher-msg.php"  aria-haspopup="true" title="    رسائل الي   المدرسين">
                        <span class="icon-with-child hidden-xs">
                        <i class="fa fa-question-circle-o" aria-hidden="true"></i> 
                        <span class="badge badge-primary badge-above right"><?php echo $totalRows_app_contact_notification;?></span>
                      </span>
                      <span class="visible-xs-block">
                        <span class="icon icon-inbox icon-lg icon-fw"></span>
                        <span class="badge badge-primary pull-right"><?php echo $totalRows_app_contact_notification;?></span>
                        رسائل من الموظفين
                      </span>
                    </a> 
                </li>
<?php  } }    ?>
 
<li class="dropdown hidden-xs">
                <button class="navbar-account-btn" data-toggle="dropdown" aria-haspopup="true">
                  <img class="circle" width="36" height="36" src="img/profile-pic.png" alt="<?php echo $row_get_login['name'];?>"> <?php echo $row_get_login['name'];?>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right"> 
                  <li class="divider"></li>
                  <li class="navbar-upgrade-version">Version: 1.0.4</li>
                  <li class="divider"></li> 
              <!--<li><a href="#!">Profile</a></li> -->
                  <li><a href="<?php echo $logoutAction;?>">الخروج  </a></li>
                </ul>
</li>

<!--
<li class="visible-xs-block">
  <a href="profile.php">
    <span class="icon icon-user icon-lg icon-fw"></span>
    Profile
  </a>
</li> -->

<li class="visible-xs-block">
  <a href="<?php echo $logoutAction;?>">
    <span class="icon icon-power-off icon-lg icon-fw"></span>
    الخروج
  </a>
</li> 