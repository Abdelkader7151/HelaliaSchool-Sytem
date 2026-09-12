<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access5sub1']==1){

$msg ='';

if(isset($_POST['submit'])){  
	$insertSQL = sprintf("INSERT INTO `jobs` ( `name`, `app`,`app0`,`app1`, `app2`,`app3`,`app4`,`app5`, `app6`, `app7` ,`app8`,`app9`,`app10`,`app11`,`app12`, `app13`,`subjects`) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", 
                                GetSQLValueString($database,$_POST['name'], "text"),
                                GetSQLValueString($database,$_POST['app']?1:0, "int"),        
                                GetSQLValueString($database,$_POST['app0']?1:0, "int"),        
                                GetSQLValueString($database,$_POST['app1']?1:0, "int"),        
                                GetSQLValueString($database,$_POST['app2']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app3']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app4']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app5']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app6']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app7']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app8']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app9']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app10']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app11']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app12']?1:0, "int"),
                                GetSQLValueString($database,$_POST['app13']?1:0, "int"),
                                GetSQLValueString($database,$_POST['subjects']?1:0, "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
			header("location: new-job.php?done"); 
			exit();
	      
	} 
	
 

  mysqli_select_db($database, $database_database); 
  $query_get_jobs = "SELECT * FROM `jobs` order by `name` asc";
  $get_jobs = mysqli_query($database,$query_get_jobs) or die(mysqli_error($database));
  $row_get_jobs = mysqli_fetch_assoc($get_jobs);
  $totalRows_get_jobs = mysqli_num_rows($get_jobs);

  

$head_title = "  الوظائف";
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
        <div class="navbar-header" style=" background-color: #fcc100">
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
                <h4> أضافة وظيفة جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-job.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
					  <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم <span style="color: red;">*</span></label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name">
              </div>
					  </div> 
					 
              <div class="form-group"> 
                <label class="col-sm-3 control-label"  >         مواد دراسية</label>
					    	<div class="col-sm-1" style="padding-top: 5px;"> <input type="checkbox"   name="subjects" id="subjects" value="1" > </div>
              </div>
 

                       <div class="form-group"> 
                        <label class="col-sm-3 control-label"  >     صلاحيات على الابليكشن</label>
					          	  <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"   name="app" id="app" value="1" > </div>
                       </div>
                     
                   <div class="col-sm-8 col-sm-offset-2 col-xs-12" >  

                       <div class="form-group app"  style="display: none;">  
						             <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox" class="app_btn" name="app0" value="1" > </div>
                         <label class="col-sm-3 control-label" style="text-align: right;"  >   استخدام عام  </label>
                       </div>


                      <div class="form-group app"  style="display: none;">  
						            <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox" class="app_btn"   name="app1" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >  تجميع غياب الطلبة</label>
                      </div>

                       <div class="form-group app"  style="display: none;">  
                        <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn"   name="app6" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >               تاكيد غياب الطلاب   </label>
                       </div>
 

                       <div class="form-group app"  style="display: none;">  
                        <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox" class="app_btn"   name="app3" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >  تجميع غياب المجموعات</label>
                       </div>

                       <div class="form-group app"  style="display: none;">  
                        <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn"   name="app2" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >       توجية استفسارات الاباء   </label>
                       </div>

                       <div class="form-group app"  style="display: none;">  
						            <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn"   name="app7" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >       الرد على  استفسارات الاباء   </label>
                       </div>

                       <div class="form-group app"  style="display: none;">  
						            <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn"   name="app4" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >          عرض غياب العاملين   </label>
                       </div>
                     
                       <div class="form-group app"  style="display: none;">  
						            <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn"   name="app5" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >          عرض اذون العاملين   </label>
                       </div>
 

                       <div class="form-group app "    style="display: none;"  >   
					              	<div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox" class="app_btn"  name="app11" value="1" > </div>
                          <label class="col-sm-3 control-label" style="text-align: right;"  >             الواجبات المنزلية   </label>
                       </div>

                       <div class="form-group  app"  style="display: none;"    >   
					              	<div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >  <input type="checkbox"  class="app_btn" name="app10" value="1" > </div>
                          <label class="col-sm-3 control-label" style="text-align: right;"  >   عرض الطلبة   </label>
                       </div>

                       <div class="form-group app "  style="display: none;"    >   
					              	<div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn" name="app12" value="1" > </div>
                          <label class="col-sm-3 control-label" style="text-align: right;"  >    الخطة الاسبوعية   </label>
                       </div>

                       <div class="form-group app "  style="display: none;"      >   
                        <div class="col-sm-1" style="padding-top: 5px; padding-left:0px; text-align:left !important  "  >   <input type="checkbox"  class="app_btn" name="app13" value="1" > </div>
                        <label class="col-sm-3 control-label" style="text-align: right;"  >     التقيم   </label>
                      </div>

                       </div>


                       <div class="form-group  "    >  
                          <label class="col-sm-3 control-label"  >             قبول غياب الطلبة   </label>
					              	<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" name="app9" value="1" > </div>
                       </div>
                       
                       <div class="form-group  "      >  
                        <label class="col-sm-3 control-label"  >  اشعارات للفصل   </label>
				              	<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"     name="app8" value="1" > </div>
                       </div>  

                       

                       

						
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >حفظ</button> 
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



    


       








        $("#app").click(function(){   
            if($(this).is(":checked")){
                $(".app").fadeIn();  
             }else{
                $(".app_btn").each(function(){ 
                    $(this).prop( "checked", false );
                });
                $(".app").fadeOut(); 
           } 

        });

 

		 
		  
 $("#access7").click(function(){
    if($(this).is(":checked")){
      $(".access7").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access7").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
});    

$(".access7").click(function(){
   $("#access7").prop( "checked", true ); 
});   


$("#access9").click(function(){
    if($(this).is(":checked")){
      $(".access9").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access9").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
}); 


$(".access9").click(function(){
   $("#access9").prop( "checked", true ); 
});  



$("#access5").click(function(){
    if($(this).is(":checked")){
      $(".access5").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".access5").each(function(){ 
         $(this).prop( "checked", false );
    });
    }
  
});   

$(".access5").click(function(){
   $("#access5").prop( "checked", true ); 
});  
		  
		  
		  
	<?php if(isset($_GET['done'])){?>	  
		  Command: toastr["success"](" تم اضافة بنجاح") 
		  
 toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-left",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
<?php }?>		  
      

$("#submit").click(function(){ 
  var gov_id = $("#gov_id").val().length; 
  if(gov_id<14 || gov_id>14){  
    event.preventDefault(); 
    $("#gov_id_warn1").fadeIn(); 
  } 
});

$("#gov_id").keydown(function(){
  $("#gov_id_warn1").fadeOut(); 
  $("#gov_id_warn2").fadeOut(); 
});
 


	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>