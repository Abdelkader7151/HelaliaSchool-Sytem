<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access1sub4']==1 && $row_get_login['access7sub6']==1){


 




if(isset($_POST['submit'])){  

  mysqli_select_db($database, $database_database);  
  $query_get_year_kids = "SELECT * FROM `kids` where `study_year` = '{$_POST['study_year']}' order by `name` asc  "; 
  $get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
  $row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
  $totalRows_get_year_kids = mysqli_num_rows($get_year_kids);

  do{ 
	     $insertSQL = sprintf("UPDATE `kids` SET `study_year`=%s, `class`= %s WHERE `id` = %s", 
                              GetSQLValueString($database,($row_get_year_kids['study_year']+1), "int"),  
                              GetSQLValueString($database,NULL, "text"),  
                              GetSQLValueString($database,$row_get_year_kids['id'], "int"));

       mysqli_select_db($database, $database_database);   
       if(isset($_POST['select_kid_'.$row_get_year_kids['id']])){
           $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       }
       
  }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));
  

			header("location: kids-transfer.php?id=".$_POST['study_year']); 
			exit(); 
  } 
  

  
  
    
 

mysqli_select_db($database, $database_database);  
$query_get_year_kids = "SELECT * FROM `kids` where `study_year` = '{$_GET['id']}' order by `name` asc  "; 
$get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
$row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
$totalRows_get_year_kids = mysqli_num_rows($get_year_kids);
 

function check_girl($id){ 
$query_get_year_kids = "SELECT `class` FROM `kids` where `id` = '{$id}'  "; 
$get_year_kids = mysqli_query($database,$query_get_year_kids) or die(mysqli_error($database));
$row_get_year_kids = mysqli_fetch_assoc($get_year_kids);
$totalRows_get_year_kids = mysqli_num_rows($get_year_kids);
return $row_get_year_kids['class'];
}
 
$head_title = "  المراحل";
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
                <h4>عرض جميع الطلبة في المرحلة <?php echo year_of_study($_GET['id']);?>  
            </div>
          </div>
	 

        <div class="row">
				<div class="col-md-12">
				   <div class="card"> 
           <form action="kids-transfer.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
                <div class="card-body" data-toggle="match-height" >
                  <h4>  طلبة المرحلة ( <?php echo $totalRows_get_year_kids;?> )</h4>
                  <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                     <thead>
                      <tr> 
                      <th class="text-center">تحديد</th> 
                        <th class="text-left">الاسم  </th>  
                        
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_year_kids>0){
	                           do{   ?>
                      <tr> 
                        <td class="text-center"><input type="checkbox" value="<?php echo $row_get_year_kids['id'];?>"  name="select_kid_<?php echo $row_get_year_kids['id'];?>" /></td> 
                        <td class="text-left"><?php echo $row_get_year_kids['name'];?></td>    
                      </tr>
                      <?php }while($row_get_year_kids = mysqli_fetch_assoc($get_year_kids));} ?> 
                     
                     
                    </tbody>
                  </table> 
                  <input type="hidden" name="study_year" value="<?php echo $_GET['id'];?>" />
                  <div class="col-sm-3">
                  <button type="submit" name="submit"  class="btn btn-danger btn-block" >ترحيل الي <?php echo year_of_study($_GET['id']+1);?> </button>
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

		$("#court-datatables").DataTable({
            paging: false,
            dom: 'Bfrtip', 
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
               { "bSortable": false,
			     "aTargets": [ 1 ]  
			   }
			 ]
        }); 



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


		  
	  });
 </script> 
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php;");exit();}?>