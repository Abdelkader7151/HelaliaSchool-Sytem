<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub0']==1){
 
  $study_year ='';

mysqli_select_db($database, $database_database);   
if(isset($_GET['id'])){
    $study_year = " AND `study_year` =  '{$_GET['id']}' ";
}else{ $study_year = '';    }
$query_get_users_info = "SELECT * FROM `kids` WHERE `transfare`=3 $study_year order by `name` asc  ";   
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
 
 

$head_title = "  الطلبة";
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
                <h4>عرض جميع الطلبة المغادرة </h4>  
                <div class="col-md-3">
                <select class="form-control"  name="study_year" id="study_year" onchange="if (this.value) window.location.href=this.value"  >
                      <option  >...</option> 
                      <option value="leave-kid-list.php"  >الجميع</option> 
                      <option value="?id=0"> بري سكول </option> 
                      <option value="?id=1">اولى حضانة</option> 
                      <option value="?id=2">ثانية حضانة</option> 
                      <option value="?id=3">  الصف الاول الابتدائى</option> 
                      <option value="?id=4">  الصف الثانى الابتدائى</option> 
                      <option value="?id=5">  الصف الثالث الابتدائى</option> 
                      <option value="?id=6">  الصف الرابع الابتدائى</option> 
                      <option value="?id=7">  الصف الخامس الابتدائى</option> 
                      <option value="?id=8">  الصف السادس الابتدائى</option> 
                      <option value="?id=9">  الصف الاول الاعدادى</option> 
                      <option value="?id=10">  الصف الثاني الاعدادى</option> 
                      <option value="?id=11">  الصف الثالث الاعدادى</option> 
                      <option value="?id=12">  الصف الاول الثانوى</option> 
                      <option value="?id=13">  الصف الثاني الثانوى</option> 
                      <option value="?id=14">  الصف الثالث الثانوى</option> 

                </select> 
               </div>
            </div>
          </div>
         
			<div class="row">  
                    
                   <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr>  
                        <th class="text-left" >الاسم  </th> 
                        <th class="text-center">الرقم القومي</th>
                        <th class="text-left">المرحلة</th> 
                        <th class="text-center">  النوع</th>    
                        <th class="text-center">  تاريخ سحب الملف</th>  
                        <th class="text-center">  المدرسة     </th>
                        <th class="text-center">  السبب     </th>
                        <th class="text-center"> </th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{  ?>
                      <tr class="count">  
                        <td class="text-left"><?php if($row_get_users_info['fn_name']==NULL){echo $row_get_users_info['name'];}else{echo $row_get_users_info['fn_name'];}?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['gov_id'];?></td>   
                        <td class="text-left"><?php echo year_of_study($row_get_users_info['study_year']);?></td>  
                        <td class="text-center"><?php echo  $row_get_users_info['gender'];?></td>     
                         <td class="text-center"><?php echo date("d/m/Y",$row_get_users_info['leaving_date']);?></td>  
                        </td>
                           
                        <td class="text-center"><?php echo $row_get_users_info['leaving_school'];?></td> 
                        <td class="text-right"><?php echo $row_get_users_info['leaving_comment'];?></td> 
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                                <li><a href="view-kid.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a></li> 
                                <li><a href="edit-kid.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i>  تعديل </a></li>   
                                
                              
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?> 
                     
                     
                    </tbody>
                  </table>


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
			     "aTargets": [ 7 ]  
			   }
			 ]
        }); 
          
          
        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>