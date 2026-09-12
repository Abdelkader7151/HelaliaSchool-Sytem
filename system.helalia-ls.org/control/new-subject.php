<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access3sub1']==1){

$msg ='';

if(isset($_POST['submit'])){  
  if($_POST['study_year']<13){$major = 1; }else{$major = $_POST['major']; }
	$insertSQL = sprintf("INSERT INTO `subjects` ( `app`, `cor`, `head`, `study_year`, `total`, `h_total`, `name`, `name_eng`, `name_frn`, `score`, `h_score`, `phase1_total`, `phase2_total`, `major` ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s )",  
                       GetSQLValueString($database,isset($_POST['app'])?1:0, "int"),
                       GetSQLValueString($database,$_POST['cor'], "int"),
                       GetSQLValueString($database,$_POST['head'], "int"),
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['total']?1:0, "int"),
                       GetSQLValueString($database,$_POST['h_total']?1:0, "int"),
                       GetSQLValueString($database,$_POST['name'], "text"),
                       GetSQLValueString($database,$_POST['name_eng'], "text"),
                       GetSQLValueString($database,$_POST['name_frn'], "text"),
                       GetSQLValueString($database,$_POST['score'], "double"),
                       GetSQLValueString($database,$_POST['h_score'], "double"),
                       GetSQLValueString($database,$_POST['phase1_total'], "double"),
                       GetSQLValueString($database,$_POST['phase2_total'], "double"),
                       GetSQLValueString($database,$major, "int"));

       mysqli_select_db($database, $database_database);   
       $Result1 = mysqli_query($database,$insertSQL) or die(mysqli_error($database));
       
        header("location: new-subject.php?done"); 
        exit();
	      
	} 
	
 
 
  mysqli_select_db($database, $database_database);  
  $query_get_cor = "SELECT * FROM `emps`  "; 
  $get_cor = mysqli_query($database,$query_get_cor) or die(mysqli_error($database));
  $row_get_cor = mysqli_fetch_assoc($get_cor);
  $totalRows_get_cor = mysqli_num_rows($get_cor);
  

$head_title = "    المواد الدراسية";
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
                <h4> أضافة مادة جديد </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="new-subject.php" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
             
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" >
                                <option selected disabled >...</option> 
                                <option value="0"> بري سكول </option> 
                                <option value="1">اولى حضانة</option> 
                                <option value="2">ثانية حضانة</option> 
                                <option value="3"> الصف الاول الابتدائى</option> 
                                <option value="4"> الصف الثانى الابتدائى</option> 
                                <option value="5"> الصف الثالث الابتدائى</option> 
                                <option value="6"> الصف الرابع الابتدائى</option> 
                                <option value="7"> الصف الخامس الابتدائى</option> 
                                <option value="8"> الصف السادس الابتدائى</option> 
                                <option value="9"> الصف الاول الاعدادى</option> 
                                <option value="10"> الصف الثاني الاعدادى</option> 
                                <option value="11"> الصف الثالث الاعدادى</option> 
                                <option value="12"> الصف الاول الثانوى</option> 
                                <option value="13"> الصف الثاني الثانوى</option> 
                                <option value="14"> الصف الثالث الثانوى</option>  
                            </select>
						</div>
                     </div> 

            <div class="form-group" style="display: none;" id="major_box">
						    <label class="col-sm-3 control-label" for="major" > التخصص  </label>
                <div class="col-sm-4">
                    <select class="form-control" name="major" id="major" > 
                        <option value="1"> مشترك</option> 
                        <option value="2"> علمي</option> 
                        <option value="3"> ادبي</option>    
                        <option value="4"> علمي  علوم </option>  
                        <option value="5"> علمي رياضة  </option>  
                    </select>
                </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  اسم المادة عربي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name" class="form-control" required type="text" name="name">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="name_eng">    اسم المادة انجليزي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_eng" class="form-control" required type="text" name="name_eng"  style="text-align: left;">
              </div>
            </div>  
                      
            <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="name_frn">    اسم المادة فرنسي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_frn" class="form-control"   type="text" name="name_frn" style="text-align: left;">
              </div>
            </div>  
                      

            <div class="form-group">
						<label class="col-sm-3 control-label" for="cor"> منسق  </label>
						<div class="col-sm-4"> 
                            <select class="form-control select2"   name="cor" id="cor" > 
                                <option value=""   > </option>  
                                <?php if($totalRows_get_cor>0){ do{?>
                                <option value="<?php echo $row_get_cor['id'];?>" >  <?php echo $row_get_cor['name'];?> </option>  
                                <?php }while($row_get_cor = mysqli_fetch_assoc($get_cor));}?> 
                         </select>
						</div>
                     </div>

            <div class="form-group">
						<label class="col-sm-3 control-label" for="head"> رئيس القسم  </label>
						<div class="col-sm-4">
              <?php
                mysqli_select_db($database, $database_database);  
                $query_get_head = "SELECT * FROM `emps`  "; 
                $get_head = mysqli_query($database,$query_get_head) or die(mysqli_error($database));
                $row_get_head= mysqli_fetch_assoc($get_head);
                $totalRows_get_head = mysqli_num_rows($get_head);
              ?>
                            <select class="form-control select2"   name="head" id="head" > 
                                <option value=""   > </option>  
                                <?php if($totalRows_get_head>0){ do{?>
                                <option value="<?php echo $row_get_head['id'];?>" >  <?php echo $row_get_head['name'];?> </option>  
                                <?php }while($row_get_head = mysqli_fetch_assoc($get_head));}?> 
                         </select>
						</div>
            </div>


            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="total">     العرض في البرنامج </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="app"  value="1" checked  type="checkbox" name="app" style="text-align: left;">
              </div>
            </div>  


            <div class="form-group">
              <label class="col-sm-3 control-label" for="total"> داخل في المجموع </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="total"  value="1"   type="checkbox" name="total" style="text-align: left;">
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-3 control-label" for="h_total"> داخل في مجمزع الهلالية </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="h_total"  value="1"   type="checkbox" name="h_total" style="text-align: left;">
              </div>
            </div>
                           
            <div class="form-group">
              <label class="col-sm-3 control-label" for="name_frn">        درجة المجموع  </label>
              <div class="col-sm-2">
                <input id="score" class="form-control"   type="number" name="score" min="0" step="0.01" max="100"  step="0.1" style="text-align: left;" value="20">
              </div>
            </div>  
                      
            <div class="form-group">
              <label class="col-sm-3 control-label" for="h_score">        درجة  مجموع الهلالية  </label>
              <div class="col-sm-2">
                <input id="h_score" class="form-control"   type="number" name="h_score" min="0" max="100"   step="0.1" style="text-align: left;" value="0">
              </div>
            </div>  
                   
            <div class="form-group">
              <label class="col-sm-3 control-label" for="phase1_total">  درجة    اعمال السنة ترم 1  </label>
              <div class="col-sm-2">
                <input id="phase1_total" class="form-control"  type="number" name="phase1_total" min="0" max="100" step="0.1" style="text-align: left;" value="40">
              </div>
            </div>  
                   
            <div class="form-group">
              <label class="col-sm-3 control-label" for="phase2_total">  درجة    اعمال السنة ترم 2  </label>
              <div class="col-sm-2">
                <input id="phase2_total" class="form-control"  type="number" name="phase2_total" min="0" max="100" step="0.1" style="text-align: left;" value="40">
              </div>
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

        $("#timepicker-1").timepicker({
            step: 10
        });

        $("#timepicker-2").timepicker({
            step: 10
        });


        $("#timepicker-3").timepicker({
            step: 10
        });


        $("#timepicker-4").timepicker({
            step: 10
        });


        $("#timepicker-5").timepicker({
            step: 10
        });


        $("#timepicker-6").timepicker({
            step: 10
        });


        $("#timepicker-7").timepicker({
            step: 10
        });






        $('#demo-inputmask').on('change', '#study_year', function (event) {  
           
			  var study_year = $("#study_year").val();  
        if(study_year==13 || study_year==14){ $("#major_box").fadeIn();}else{ $("#major_box").fadeOut(); }
			  $.post("study_year_subjects.php",
			  {
                study_year:study_year
		    },
            function(Date,status){ 

                  $("#subject_box").html(Date);
                  
			   }); 

          
	    });



       

      



        





		    function readURL(input) {
			  if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
				  $('#blah').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]); // convert to base64 string
			  }
           }

		 
		  
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