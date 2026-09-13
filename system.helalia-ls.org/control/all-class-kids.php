<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access1sub4']==1){


   

  if(isset($_POST['delete'])){   

       mysqli_select_db($database, $database_database);  
      $query_get_class_info = "SELECT * FROM `kids` where class = '{$_GET['id']}' order by `name` asc  "; 
      $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
      $row_get_class_info = mysqli_fetch_assoc($get_class_info);
      $totalRows_get_class_info = mysqli_num_rows($get_class_info);
      if($totalRows_get_class_info>0){
          do{ 
                 $insertSQL = sprintf("UPDATE `kids` SET `class`=%s WHERE `id` = %s", 
                              GetSQLValueString($database,NULL, "text"),  
                              GetSQLValueString($database,$row_get_class_info['id'], "int"));
 
                if(isset($_POST['kid_id_'.$row_get_class_info['id']]) && $_POST['kid_id_'.$row_get_class_info['id']]==1){
                     $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
                }
             
          }while($row_get_class_info = mysqli_fetch_assoc($get_class_info));
      }
      header("location: all-class-kids.php?id=".$_GET['id']); 
			exit(); 
  }




if(isset($_POST['submit'])){  

  mysqli_select_db($database, $database_database);  
  $query_get_year_kids = "SELECT * FROM `kids` where `study_year` = '{$_POST['study_year']}' order by `name` asc  "; 
  $get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
  $row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
  $totalRows_get_year_kids = mysqli_num_rows($get_year_kids);

  do{ 
	     $insertSQL = sprintf("UPDATE `kids` SET `class`=%s WHERE `id` = %s", 
                              GetSQLValueString($database,$_POST['class_id'], "int"),  
                              GetSQLValueString($database,$row_get_year_kids['id'], "int"));

       mysqli_select_db($database, $database_database);   
       if(isset($_POST['select_kid_'.$row_get_year_kids['id']])){
           $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       }
       
  }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));
  

			header("location: all-class-kids.php?id=".$_POST['class_id']); 
			exit(); 
  } 




  if(isset($_POST['move'])){   
  mysqli_select_db($database, $database_database);  
  $query_get_year_kids = " SELECT * FROM `kids` where `class` = '{$_GET['id']}' order by `name` asc "; 
  $get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
  $row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
  $totalRows_get_year_kids = mysqli_num_rows($get_year_kids);

  do{ 
	     $insertSQL = sprintf("UPDATE `kids` SET `class`=%s WHERE `id` = %s", 
                      GetSQLValueString($database,$_POST['class'], "int"),  
                              GetSQLValueString($database,$row_get_year_kids['id'], "int"));
 
       if(isset($_POST['kid_id_'.$row_get_year_kids['id']])){
             mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       } 
  }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));
  

			header("location: all-class-kids.php?id=".$_POST['class']); 
			exit(); 
  } 
  
  

  
  if(isset($_GET['del'])){   
    $insertSQL = sprintf("UPDATE `kids` SET `class`=null WHERE `id` = %s",  
                                GetSQLValueString($database,$_GET['del'], "int"));
  
         mysqli_select_db($database, $database_database);    
             $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));  
    } 
    




mysqli_select_db($database, $database_database);  
$query_get_class_info = "SELECT * FROM `kids` where `class` = '{$_GET['id']}' order by `name` asc  "; 
$get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
$row_get_class_info = mysqli_fetch_assoc($get_class_info);
$totalRows_get_class_info = mysqli_num_rows($get_class_info);


mysqli_select_db($database, $database_database);  
$query_get_class = "SELECT * FROM `class` where `id` = '{$_GET['id']}'  "; 
$get_class = mysqli_query($database,$query_get_class) or die(mysqli_error($database));
$row_get_class = mysqli_fetch_assoc($get_class);
$totalRows_get_class = mysqli_num_rows($get_class);



mysqli_select_db($database, $database_database);  
$query_get_year_kids = "SELECT * FROM `kids` where `study_year` = '{$row_get_class['study_year']}' order by `name` asc  "; 
$get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
$row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
$totalRows_get_year_kids = mysqli_num_rows($get_year_kids);
 

function check_girl($id){ 
  global $database;
$query_get_year_kids = "SELECT `class` FROM `kids` where `id` = '{$id}'  "; 
$get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
$row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
$totalRows_get_year_kids = mysqli_num_rows($get_year_kids);
return $row_get_year_kids['class'];
}
 
$head_title = "  الفصول";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css"> 
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
                <h4>عرض جميع الطلبة في الفصل <?php echo class_name($_GET['id']);?> 
                <?php echo year_of_study(class_year($_GET['id']));?> </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" >
                <form action="all-class-kids.php?id=<?php echo $_GET['id'];?>" method="post" name="form2" id="form2" enctype="multipart/form-data" class="form form-horizontal">
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-center"> <input type="checkbox" id="check_all"> </th>  
                        <th class="text-left">الاسم  </th>  
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_class_info>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-center"><input type="checkbox"  class="check" name="kid_id_<?php echo $row_get_class_info['id'];?>" value="1" ></td>  
                        <td class="text-left"><?php echo $row_get_class_info['name'];?></td>  
                        <td class="text-center">
                        <a href="view-kid.php?id=<?php echo $row_get_class_info['id'];?>"  class="btn btn-primary">     عرض </a>
                        <a href="all-class-kids.php?id=<?php echo $_GET['id'];?>&del=<?php echo $row_get_class_info['id'];?>"  class="btn btn-danger" onclick="return confirm('تاكيد');">     حذف </a>
                        </td>
                      </tr>
                      <?php }while($row_get_class_info = mysqli_fetch_assoc($get_class_info));} ?> 
                     
                     
                    </tbody>
                  </table>
                  <div class="row"> 
                    <div class="col-md-2">
                        <button type="submit" name="delete"  class="btn btn-danger btn-block" >حذف المحدد</button>
                    </div>


                   <div class="col-md-12" style="padding: 20px;"></div>

                   <?php  if($row_get_login['access1sub5']==1){

                    $study_year = ($row_get_class['study_year']+1); 
                    $query_get_next_class = "SELECT * FROM `class`  where `study_year`='{$study_year}' ";
                    $get_next_class = mysqli_query($database,$query_get_next_class) or die(mysqli_error($database));
                    $row_get_next_class = mysqli_fetch_assoc($get_next_class);
                    $totalRows_get_next_class = mysqli_num_rows($get_next_class);
                    if($totalRows_get_class>0){ ?>
                   
                     <label class="col-sm-2 control-label" for="class">       فصول المرحله الجيدة  </label>
                     <div class="col-md-2">
                          <select class="form-control"   name="class" id="class" >
                                <option value="-1">..</option> 
                                <?php if($totalRows_get_next_class>0){
                                  do{?>
                                  <option value="<?php echo $row_get_next_class['id'];?>" >  <?php echo $row_get_next_class['name'];?></option>  
                                <?php }while($row_get_next_class = mysqli_fetch_assoc($get_next_class)); } ?>
                          </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="move"  class="btn btn-success btn-block" >نقل لفصل اخر</button>
                         <input type="hidden" name="study_year" value="<?php echo $row_get_class['study_year'];?>" />
                    </div>  
                  <?php  }}?>
                </div>
                   </form>
                </div>
              </div>
				</div>
		    </div>
           
			
       
        



        <div class="row">
				<div class="col-md-12">
				   <div class="card"> 
           <form action="all-class-kids.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
                <div class="card-body" data-toggle="match-height" >
                  <h4>  طلبة المرحلة ( <?php echo $totalRows_get_year_kids;?> )</h4>
                <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                      <th class="text-center">تحديد</th> 
                        <th class="text-left">الاسم  </th>  
                        
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_year_kids>0){
	                           do{  
                               if(check_girl($row_get_year_kids['id'])!=$_GET['id']){?>
                      <tr> 
                        <td class="text-center"><input type="checkbox" value="<?php echo $row_get_year_kids['id'];?>"  name="select_kid_<?php echo $row_get_year_kids['id'];?>" /></td> 
                        <td class="text-left"><?php echo $row_get_year_kids['name'];?></td>    
                      </tr>
                      <?php }}while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));} ?> 
                     
                     
                    </tbody>
                  </table>
                  <input type="hidden" name="study_year" value="<?php echo $row_get_class['study_year'];?>" />
                  <input type="hidden" name="class_id" value="<?php echo $_GET['id'];?>" />
                  <div class="col-sm-3">
                  <button type="submit" name="submit"  class="btn btn-danger btn-block" >تحديد</button>
                </div></div>
               </form>
              </div>
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

 
        $("#check_all").click(function(){
            if($(this).is(":checked")){
              $(".check").each(function(){ 
                  $(this).prop( "checked", true );
              });
            }else{
            $(".check").each(function(){ 
                $(this).prop( "checked", false );
            });
            } 
        }); 

		$("#court-datatables").DataTable({
             lengthMenu: [[-1], ["All"]],
            dom: 'Bfrtip',
            buttons: [
            'copy',  'pdf', 'print'
        ],
            language: {
                paginate: {
                    previous: "&laquo;",
                    next: "&raquo;"
                },
                search: "_INPUT_",
                searchPlaceholder: "Search…"
            },
            order: [
                [1, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": true,
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php;");exit();}?>