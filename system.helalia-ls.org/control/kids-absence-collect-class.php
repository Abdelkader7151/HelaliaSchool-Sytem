<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub5']==1){

 
    
if(isset($_POST['submit'])){

    mysqli_select_db($database, $database_database); 
    $query_get_data = "SELECT * FROM `kids` where `study_year` = '{$_GET['year']}' and class= '{$_GET['class']}' order by `name` ASC ";
    $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
    $row_get_data = mysqli_fetch_assoc($get_data);
    $totalRows_get_data = mysqli_num_rows($get_data);
  
    if(isset($_POST['date'])){
      $day = $_POST['date'];
      $confirm = 1;
      $confirm_useradmin = $row_get_login['id'];
    }else{
      $day = strtotime(date("m/d/Y",time()));
      $confirm = 0;
      $confirm_useradmin = null;
    }


  
    if($totalRows_get_data>0){ 
      do{ 

        mysqli_select_db($database, $database_database); 
        $query_get_kids_absence = "SELECT `kid_id` FROM `kids-absence` WHERE  `kid_id` = '{$row_get_data['id']}' AND  `study_year` = '{$_GET['year']}' AND `class`= '{$_GET['class']}' AND `date` = '{$day}'   ";
        $get_kids_absence = mysqli_query($database,$query_get_kids_absence) or die(mysqli_error($database));
        $row_get_kids_absence = mysqli_fetch_assoc($get_kids_absence);
        $totalRows_get_kids_absence = mysqli_num_rows($get_kids_absence);

        $insertSQL1 = sprintf("INSERT INTO `kids-absence` (`kid_id`, `study_year`, `class`, `date`, `confirm`, `confirm_useradmin`, `emp_id_admin` ) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($database,$row_get_data['id'], "int"),
                                GetSQLValueString($database,$_GET['year'], "int"),
                                GetSQLValueString($database,$_GET['class'], "int"),
                                GetSQLValueString($database,$day, "int"),
                                GetSQLValueString($database,$confirm, "int"),
                                GetSQLValueString($database,$confirm_useradmin, "int"),
                                GetSQLValueString($database,$row_get_login['id'], "int"));
    
            mysqli_select_db($database, $database_database);   
            if(isset($_POST['kid_'.$row_get_data['id']]) && $row_get_data['id']==$_POST['kid_'.$row_get_data['id']] && $totalRows_get_kids_absence<1){
              mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 
            } 
      } while($row_get_data = mysqli_fetch_assoc($get_data)); 
    }
  }
  
  
  
  
  if(isset($_GET['kid'])){
      $day = strtotime(date("m/d/Y",time()));
      $insertSQL1 = sprintf("INSERT INTO `kids-absence` (`kid_id`, `study_year`, `class`, `date`, `emp_id_admin` ) VALUES (%s, %s, %s, %s, %s)",
                              GetSQLValueString($database,$_GET['kid'], "int"),
                              GetSQLValueString($database,$_GET['year'], "int"),
                              GetSQLValueString($database,$_GET['class'], "int"),
                              GetSQLValueString($database,$day, "int"),
                              GetSQLValueString($database,$row_get_login['id'], "int"));
  
          mysqli_select_db($database, $database_database);   
          $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));  
  
          header("location: kids-absence-collect-class.php?year=".$_GET['year']."&class=".$_GET['class']);
          exit();
  }
  
  if(isset($_GET['del']) && !isset($_GET['date'])){   
      $insertSQL1 = sprintf("DELETE FROM `kids-absence` where `id`=%s and `confirm` = 0",
                              GetSQLValueString($database,$_GET['del'], "int"));
  
          mysqli_select_db($database, $database_database);   
          $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));   
          
          header("location: kids-absence-collect-class.php?year=".$_GET['year']."&class=".$_GET['class']);
          exit();
  }


  if(isset($_GET['del']) && isset($_GET['date'])){
    $insertSQL1 = sprintf("DELETE FROM `kids-absence` WHERE `id`=%s AND `confirm` = 1 ",
        GetSQLValueString($database,$_GET['del'], "int"));

    mysqli_select_db($database, $database_database);   
    $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database));   

  header("location: kids-absence-collect-class.php?year=".$_GET['year']."&class=".$_GET['class']."&date=".$_GET['date']);
  exit(); 
  }
    
  
  
  mysqli_select_db($database, $database_database); 
  $query_get_data = "SELECT * FROM `kids` WHERE `study_year` = '{$_GET['year']}' and `class` = '{$_GET['class']}' ORDER BY `name` ASC ";
  $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
  $row_get_data = mysqli_fetch_assoc($get_data);
  $totalRows_get_data = mysqli_num_rows($get_data);
 
  

$head_title = "  غياب الطلبة";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css"> 
  <style>
    .datepicker{z-index: 9999 !important; top:0px !important}
    .dropdown-menu.datepicker-orient-left:after, .dropdown-menu.datepicker-orient-left:before{display: none !important ;}

  </style>
 </head> 
 
  <body class="layout layout-header-fixed"> 
	  
    <div class="layout-header">
      <div class="navbar navbar-default">
        <div class="navbar-header" style=" background-color: black">
          <a class="navbar-brand navbar-brand-center" href="home.php" style=" padding: 5px"> </a>
			<?php require_once('includes/mobile-menu-buttons.php');?> 
		  </div> 
	    <div class="navbar-toggleable">
          <nav id="navbar" class="navbar-collapse collapse">
            <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true" type="button" >
              <span class="sr-only">Toggle navigation</span>
              <span class="bars">
                <span class="bar-line bar-line-1 out"></span>
                <span class="bar-line bar-line-2 out"></span>
                <span class="bar-line bar-line-3 out"></span>
                <span class="bar-line bar-line-4 in"></span>
                <span class="bar-line bar-line-5 in"></span>
                <span class="bar-line bar-line-6 in"></span>
              </span>
            </button>
            <ul class="nav navbar-nav navbar-right"> 
             <?php require_once('includes/notifications.php');?>    
            </ul>  
			 <?php require_once('includes/title-bar.php');?>  
          </nav>
        </div>
      </div>
    </div> 
	  
    <div class="layout-main">
      <?php include("includes/side-nav.php");?>  
		
      <div class="layout-content">
        <div class="layout-content-body"> 
			<div class="row">
            <div class="col-md-12">
                <h4>تجميع غياب الطلبة </h4>  
            </div>
          </div>
         

          <div class="row ">
                <div class="col-md-6  col-xs-12 " > 
<h4><i class="fa fa-graduation-cap fa-lg" aria-hidden="true" style="padding-right: 10px; "></i> <?php echo year_of_study($_GET['year']);?> \ <?php echo class_name($_GET['class']);?>
</h4>
<?php if(isset($_GET['date'])){?>
  <h4 style="color:red; padding-right:50px"> يوم: <?php echo date("d/m/Y",strtotime($_GET['date']));?></h4>
<?php }?>


<form action="kids-absence-collect-class.php?year=<?php echo $_GET['year'];?>&class=<?php echo $_GET['class']; if(isset($_GET['date'])){echo "&date=".$_GET['date'];}?>" id="form" method="POST" enctype="multipart/form-data" > 

<?php if(isset($_GET['date'])){?>
   <input type="hidden" value="<?php echo strtotime($_GET['date']);?>" name="date" />
<?php $day = strtotime($_GET['date']);}else{$day=0;} ?>  

<ul class="collection" style="padding-right: 0px;">

   <?php if($totalRows_get_data>0){
     $i=1; do{
          if(check_absence_day($row_get_data['id'],$day)==0){ ?>
    <li style="padding-top: 5px; padding-bottom:5px; list-style: none; font-size:14px">
      <input type="checkbox" class="filled-in" name="kid_<?php echo $row_get_data['id'];?>" value="<?php echo $row_get_data['id'];?>" style="opacity:1 ; margin-top:5px; float:right;  "  />
      <div style="padding-right: 20px" > <?php if($row_get_data['name']==null){echo $i." - ".$row_get_data['fn_name'];}else{ echo  $i." - ".$row_get_data['name']; } ;?> </div> 
    </li>  
    <?php $i++; }}while($row_get_data = mysqli_fetch_assoc($get_data)); }?>     
     
</ul> 
<div class="col s12">
     <button class="waves-effect waves-light btn-large bg-primary " name="submit" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> ارسال <i class="fa fa-spinner fa-spin fa-fw" id="loading" style="display: none"></i></button>
</div>

</form>      
</div>
<div class="col-md-3  col-xs-12 " > 
<?php

if($day==0){
  $start = strtotime(date("m/d/Y",time()));
  $end = strtotime(date("m/d/Y",time()))+86400; 
}else{ 
  $start = strtotime(date("m/d/Y",$day));
  $end = strtotime(date("m/d/Y",$day))+86400;
}

mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `kids-absence` where `study_year` = '{$_GET['year']}' and class= '{$_GET['class']}' and `date`>='{$start}' and `date`<'{$end}'  ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);
 
?>

<h4 style="padding-top: 10px;"><i class="fa fa-graduation-cap fa-lg" aria-hidden="true" style="padding-right: 10px; "></i>
قائمة الغياب</h4>
<ol class="collection" style="padding-right: 0px;"> 
<?php if($totalRows_get_data>0){
      do{?>
   <li style="padding-top: 5px; padding-bottom:5px; font-size:14px  "><div> <?php echo kid_name($row_get_data['kid_id']); if($row_get_data['confirm']==0 || $day!=0){?> <a href="kids-absence-collect-class.php?year=<?php echo $_GET['year'];?>&class=<?php echo $_GET['class'];?>&del=<?php echo $row_get_data['id']; if(isset($_GET['date'])){echo "&date=".$_GET['date'];}?>" style="float:left" class="secondary-content"><i class="fa fa-trash-o fa-lg" aria-hidden="true" style="color: #ef2123"></i></a> <?php }?></div></li> 
<?php }while($row_get_data = mysqli_fetch_assoc($get_data));}?>     
     
</ol> 
      
                  



    </div>
    </div>
    
            
			
			
        </div>
      </div>
		
		
		 <?php include("includes/footer.php");?> 
      
    </div>
    
	  
	  
    <?php include("includes/footer-script.php");?> 
    <script src="js/application.min.js"></script>
  
	  
	  
	  
 <script>
	  $(document).ready(function(){ 

     
		 
          
         
        



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>