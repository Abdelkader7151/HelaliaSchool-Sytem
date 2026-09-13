<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10']==1){ 

mysqli_select_db($database, $database_database);  
$query_get_kids_vacations = "SELECT * FROM `emps_excuse` where `emp_id` = '{$_GET['id']}' order by `date` asc  "; 
$get_kids_vacations = mysqli_query($database,$query_get_kids_vacations) or die(mysqli_error($database));
$row_get_kids_vacations = mysqli_fetch_assoc($get_kids_vacations);
$totalRows_get_kids_vacations = mysqli_num_rows($get_kids_vacations);
 
 

$head_title = "  الموظفين";
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
                <h4>عرض اذون لموظف / <?php echo  emp_name($_GET['id']);?></h4>  
            </div>
          </div>
         
			<div class="row"> 
				<div class="col-md-12"> 
				   <div class="card">   
                <div class="card-body" data-toggle="match-height" > 
                <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr>   
                        <th class="text-center">من</th>
                        <th class="text-center">الي</th>
                        <th class="text-center">المدة</th> 
                        <th class="text-center">تاريخ التقديم</th>  
                        <th class="text-center">الحالة</th> 
                        <th class="text-center"> </th> 
                        
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_kids_vacations>0){
	                           do{  ?>
                      <tr class="count">   
                        <td class="text-center"><?php echo date("h:i a",$row_get_kids_vacations['start']);?></td>  
                        <td class="text-center"><?php echo date("h:i a",$row_get_kids_vacations['end']);?></td>  
                        <td class="text-center"> <?php echo exc_time($row_get_kids_vacations['start'],$row_get_kids_vacations['end']);?> </td>  
                        <td class="text-center"><?php echo date("m/d/Y",$row_get_kids_vacations['date']);?></td>  
                        <td class="text-center" style="color: <?php echo vac_color($row_get_kids_vacations['status']);?>"> <?php echo vac_status($row_get_kids_vacations['status']);?> </td>   
                        <td class="text-center">
                        <a href="view-emps-exc.php?id=<?php echo $row_get_kids_vacations['id'];?>" class="btn btn-info" > عرض </a>
                        </td>
                      </tr>
                      <?php }while($row_get_kids_vacations = mysqli_fetch_assoc($get_kids_vacations));} ?> 
                     
                     
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
			     "aTargets": [ 5 ]  
			   }
			 ]
        }); 
          
         
        var reg1 = $('.reg1').length;
        $('#reg1').text(reg1);

        var reg2 = $('.reg2').length;
        $('#reg2').text(reg2);

        var trans1 = $('.trans1').length;
        $('#trans1').text(trans1);

        var trans2 = $('.trans2').length;
        $('#trans2').text(trans2);

        var trans3 = $('.trans3').length;
        $('#trans3').text(trans3);

        var count = $('.count').length;
        $('#count').text(count);

$("input").keyup(function(){
        var reg1 = $('.reg1').length;
        $('#reg1').text(reg1);

        var reg2 = $('.reg2').length;
        $('#reg2').text(reg2);

        var trans1 = $('.trans1').length;
        $('#trans1').text(trans1);

        var trans2 = $('.trans2').length;
        $('#trans2').text(trans2);

        var trans3 = $('.trans3').length;
        $('#trans3').text(trans3);

        var count = $('.count').length;
        $('#count').text(count);

});




        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php;");exit();}?>