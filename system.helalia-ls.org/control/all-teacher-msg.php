<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access9sub2']==1){

mysqli_select_db($database, $database_database);  
$query_get_new_contacts = "SELECT * FROM `ask_teacher`  order by `id` asc  "; 
$get_new_contacts = mysqli_query($database,$query_get_new_contacts) or die(mysqli_error($database));
$row_get_new_contacts = mysqli_fetch_assoc($get_new_contacts);
$totalRows_get_new_contacts = mysqli_num_rows($get_new_contacts);
 
 

$head_title = "  رسائل الي المدرسين";
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
                <h4>عرض  جميع الرسائل    </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-12">
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-center">#  </th>  
                        <th class="text-left">الاسم  </th>  
                        <th class="text-center"> تاريخ   M/D/Y </th> 
                        <th class="text-center"> المادة </th>
                        <th class="text-center"> موجة السؤال </th>
                        <th class="text-center"> توجية </th>
                        <th class="text-center"> الحالة </th>
                        <th class="text-center">التحكم</th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_new_contacts>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_new_contacts['id'];?></td>  
                        <td class="text-left"><?php echo parent_app($row_get_new_contacts['user_id']);?></td>  
                        <td class="text-center"><?php echo date("m/d/Y",$row_get_new_contacts['date']);?></td>  
                        <td class="text-center"><?php echo question_direct($row_get_new_contacts['subject']);?></td> 
                        <td class="text-center"><?php echo emp_name($row_get_new_contacts['director_id']);?></td> 
                        <td class="text-center"><?php echo emp_name($row_get_new_contacts['teacher_id']);?></td> 
                        <td class="text-center"><?php if($row_get_new_contacts['status']==0){echo " معلق ";}else{echo " تم الرد";}?></td> 
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 

                                <li><a href="view-teacher-msg.php?id=<?php echo $row_get_new_contacts['id'];?>" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a></li>
							    <li role="separator" class="divider"></li> 
								<li><a href="view-teacher-msg.php?del=<?php echo $row_get_new_contacts['id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                                
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_new_contacts = mysqli_fetch_assoc($get_new_contacts));} ?> 
                     
                     
                    </tbody>
                  </table>
                </div>
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
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 7 ]  
			   }
			 ]
        }); 
		  
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>