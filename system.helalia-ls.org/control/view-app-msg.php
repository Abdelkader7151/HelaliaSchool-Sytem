<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10']==1){
 
  
if(isset($_GET['del'])){  
         
  $deleteSQL = sprintf("DELETE FROM `contacts` WHERE `id`=%s  ",
                     GetSQLValueString($database,$_GET['del'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
          header("location: all-parents-msgs.php"); 
          exit(); 
  } 

    mysqli_select_db($database, $database_database); 
    $query_get_app_info = "SELECT * FROM `contacts` where `id`='{$_GET['id']}'  ";
    $get_app_info = mysqli_query($database,$query_get_app_info) or die(mysqli_error($database));
    $row_get_app_info = mysqli_fetch_assoc($get_app_info);
    $totalRows_get_app_info = mysqli_num_rows($get_app_info);

  if($totalRows_get_app_info<1){header("location: all-kids.php"); exit();}


  $updateSQL = sprintf("UPDATE `contacts` SET  `view`=1 WHERE `id` = %s and `view`=0 ", 
                      GetSQLValueString($database,$_GET['id'], "text"));

                  mysqli_select_db($database, $database_database);   
                  $Result1 = mysqli_query($database,$updateSQL) or die(mysqli_error($database));

 

  mysqli_select_db($database, $database_database); 
  $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id`='{$row_get_app_info['user_id']}'  ";
  $get_kids_list = mysqli_query($database,$query_get_kids_list) or die(mysqli_error($database));
  $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
  $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

  


$head_title = "  رسائل اولياء الامور";
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
                <h4> عرض  بيانات الرسالة   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-12">
				  <div class="demo-form-wrapper">
                  
                    <form action="#" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
                    <div class="form-group">
              <label class="col-sm-2 control-label" for="name">  تاريخ  </label>
              <div class="col-sm-2">
                <input class="form-control" required type="text" readonly value="<?php echo date("m/d/Y",$row_get_app_info['date']);?>" style="text-align: center;">
              </div>
            </div> 


			 <div class="form-group">
              <label class="col-sm-2 control-label" for="name">  الاسم </label>
              <div class="col-sm-3">
                <input id="name" class="form-control" required type="text" name="name" readonly value="<?php echo parent_app($row_get_app_info['user_id']);?>">
              </div>
              <div class="col-sm-1" style="padding-top: 7px;">
              <a href="view-app-account.php?id=<?php echo $row_get_app_info['user_id'];?>" class="btn btn-xs btn-danger btn-block"  > <i class="fa fa-eye" aria-hidden="true"></i>  عرض   </a>
              </div>
            </div>  
            
 

            
  

          
<?php if( $row_get_app_info['account_type']==1) { do{?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nationality">  ولي امر </label>
              <div class="col-sm-3">
                <input  class="form-control"  readonly type="text"  value="<?php echo kid_name($row_get_kids_list['kid_id']);?>">
              </div>
              <label class="col-sm-1 control-label" for="nationality">    سنة </label>
              <div class="col-sm-2">
                <input  class="form-control"  readonly type="text"  value="<?php echo year_of_study(kid_study_year($row_get_kids_list['kid_id']));?>">
              </div> 
              <label class="col-sm-1 control-label" for="nationality">    فصل </label>
              <div class="col-sm-2">
                <input  class="form-control"  readonly type="text"  value="<?php echo class_name(kid_class($row_get_kids_list['kid_id']));?>">
              </div>
              <div class="col-sm-1" style="padding-top: 7px;">
              <a href="view-kid.php?id=<?php echo $row_get_kids_list['kid_id'];?>" class="btn btn-xs btn-danger btn-block"  > <i class="fa fa-eye" aria-hidden="true"></i>  عرض   </a>
              </div>
            </div> 
<?php }while($row_get_kids_list = mysqli_fetch_assoc($get_kids_list));} ?>
 
            
                      
            
           
<div class="form-group">
              <label class="col-sm-2 control-label" for="name">  الرسالة </label>
              <div class="col-sm-6" style="border: solid 1px black; padding:20px; margin-top:10px" >
                 <p><?php echo $row_get_app_info['text'];?></p>
              </div> 
            </div>  


            
 
						
						<div class="form-group">
						 <label class="col-sm-10 control-label" for="submit"> </label>
						 <div class="col-sm-1"> 
                         <a href="view-app-msg.php?del=<?php echo $row_get_app_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
                         </div> 
                          
                      </div> 
                      
                     



					   <div class="form-group">
						 <label class="col-sm-3 control-label" > </label>
						 <div class="col-sm-6"> 
						   <?php echo $msg;?> 
						 </div> 
					  </div>
						
						
						
						
						
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

$("input").css("backgroundColor","white");
$("select").css("backgroundColor","white");

	  });
    </script>
    <script>
	  $(document).ready(function(){ 

		$("#court-datatables").DataTable({ 
            paging: false,
            dom: 'Bfrtip', 
 
            
            language: {
                paginate: {
                    previous: "السابق",
                    next: "التالي"
                },
                search: "_INPUT_",
                searchPlaceholder: "بحث"
            },
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 
          
   


        
	  });
 </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>