<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub5']==1){

 

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
                <h4>عرض غياب الطلبة       </h4>  
            </div>
          </div>
         

          <div class="row">
				<div class="col-md-12">
				  <div class="demo-form-wrapper">
                    <form action="kids-absence-collect-class.php"   method="get" name="form1" id="demo-inputmask2"   enctype="multipart/form-data" class="form form-horizontal">
 
            <div class="form-group">
						<label class="col-sm-2 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						 
                        <div class="col-sm-4">
                            <select class="form-control"   name="year"  id="target"  >
                                <option selected   >...</option>  
                                <option value="0"> بري سكول </option> 
                                <option value="1" > اولى حضانة</option> 
                                <option value="2" > ثانية حضانة</option> 
                                <option value="3" >  الصف الاول الابتدائى</option> 
                                <option value="4" >  الصف الثانى الابتدائى</option> 
                                <option value="5" >  الصف الثالث الابتدائى</option> 
                                <option value="6" >  الصف الرابع الابتدائى</option> 
                                <option value="7" >  الصف الخامس الابتدائى</option> 
                                <option value="8" >  الصف السادس الابتدائى</option> 
                                <option value="9" >  الصف الاول الاعدادى</option> 
                                <option value="10" >  الصف الثاني الاعدادى</option> 
                                <option value="11" >  الصف الثالث الاعدادى</option> 
                                <option value="12" >  الصف الاول الثانوى</option> 
                                <option value="13" >  الصف الثاني الثانوى</option> 
                                <option value="14" >  الصف الثالث الثانوى</option>  
                            </select>
						</div> 
            </div>

            
            <div class="form-group" style="display: none" id="class_box">
						<label class="col-sm-2 control-label" for="class" id="class_box"> الفصل  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" name="class" id="class" required   >
                                <option selected value="" >...</option>  
                            </select>
						</div>
            </div>
						
						<div class="form-group">
						 <label class="col-sm-2 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block"   id="submit" >عرض</button> 
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

        $('#demo-inputmask2').on('change', '#target', function (event) {    
        var year = $(this).val();
        if(year<15){
          $("#class_box").fadeIn();
           $.post("get_class3.php",
            {
              year:year
            },
            function(Date,status){ 
                $("#class").html(Date); 
             });
        }else{
           $("#class").prop("selectedIndex", 0);
           $("#class_box").fadeOut(); 
          };
       });


		 
          
         
        



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>