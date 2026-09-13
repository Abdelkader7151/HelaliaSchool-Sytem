<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access10sub3']==1){
 
	
 
 
  mysqli_select_db($database, $database_database);  
  $query_get_emp = "SELECT * FROM `emps`  "; 
  $get_emp = mysqli_query($database,$query_get_emp) or die(mysqli_error($database));
  $row_get_emp = mysqli_fetch_assoc($get_emp);
  $totalRows_get_emp = mysqli_num_rows($get_emp);
  

$head_title = "    رسائل من اولياء الامور";
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
                <h4>     صلاحيات الرد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="emp-parents-settings.php" method="GET" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
           

                    <div class="form-group">
						<label class="col-sm-3 control-label" for="id"> الموظف  </label>
						<div class="col-sm-4">
                            <select class="form-control select2"    name="id" id="id" > 
                                <option value=""   > </option>  
                                <?php if($totalRows_get_emp>0){ do{?>
                                <option value="<?php echo $row_get_emp['id'];?>" >  <?php echo $row_get_emp['name'];?> </option>  
                                <?php }while($row_get_emp = mysqli_fetch_assoc($get_emp));}?> 
                         </select>
						</div>
                  
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block"   >تعديل صلاحيات</button> 
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
 

        $(".select2").select2({
					dir: "rtl"
			 });
 
 


	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>