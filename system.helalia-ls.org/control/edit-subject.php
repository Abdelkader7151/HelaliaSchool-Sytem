<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access3sub3']==1){

$msg ='';

if(isset($_GET['del'])){   
         $deleteSQL = sprintf("DELETE FROM `subjects` WHERE `id`=%s ",
                     GetSQLValueString($database,$_GET['del'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));


          $deleteSQL2 = sprintf("DELETE FROM `control` WHERE `subject_id`=%s ",
                    GetSQLValueString($database,$_GET['del'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result2 = mysqli_query($database,$deleteSQL2) or die(mysqli_error($database));
                    
          $deleteSQL3 = sprintf("DELETE FROM `control_year` WHERE `subject_id`=%s ",
                    GetSQLValueString($database,$_GET['del'], "int"));

          mysqli_select_db($database, $database_database);  
          $Result3 = mysqli_query($database,$deleteSQL3) or die(mysqli_error($database));
                     
          header("location: all-subjects.php"); 
          exit(); 
  } 


if(isset($_POST['submit'])){  
  if($_POST['study_year']<13){$major = 1; }else{$major = $_POST['major']; }
	$updateSQL = sprintf("UPDATE `subjects` SET `app`=%s, `cert_view`=%s, `cor`=%s, `head`=%s, `study_year`=%s, `total`=%s, `h_total`=%s, `name`=%s,  `name_eng`=%s, `name_frn`=%s, `order`=%s, `major`=%s, `score`=%s, `phase1_total`=%s, `phase2_total`=%s, `h_score`=%s WHERE `id`=%s", 
                       GetSQLValueString($database,$_POST['app']?1:0, "int"),
                       GetSQLValueString($database,$_POST['cert_view']?1:0, "int"),
                       GetSQLValueString($database,$_POST['cor'], "int"),
                       GetSQLValueString($database,$_POST['head'], "int"),
                       GetSQLValueString($database,$_POST['study_year'], "int"),
                       GetSQLValueString($database,$_POST['total']?1:0, "int"),
                       GetSQLValueString($database,$_POST['h_total']?1:0, "int"),
                       GetSQLValueString($database,$_POST['name'], "text"), 
                       GetSQLValueString($database,$_POST['name_eng'], "text"),
                       GetSQLValueString($database,$_POST['name_frn'], "text"), 
                       GetSQLValueString($database,$_POST['order'], "int"), 
                       GetSQLValueString($database,$major, "int"),
                       GetSQLValueString($database,$_POST['score'], "double"),
                       GetSQLValueString($database,$_POST['phase1_total'], "double"),
                       GetSQLValueString($database,$_POST['phase2_total'], "double"),
                       GetSQLValueString($database,$_POST['h_score'], "int"),
                       GetSQLValueString($database,$_POST['id'], "int"));
 
        mysqli_query($database,$updateSQL) or die(mysqli_error($database));


       $insertSQL2 = sprintf("UPDATE `control` SET `cert_view`=%s, `ex_total`=%s, `subject_name`=%s, `order`=%s WHERE `subject_id`=%s ", 
                        GetSQLValueString($database,$_POST['cert_view']?1:0, "int"),
                        GetSQLValueString($database,$_POST['score'], "double"),
                        GetSQLValueString($database,$_POST['name_eng'], "text"), 
                        GetSQLValueString($database,$_POST['order'], "int"),
                        GetSQLValueString($database,$_POST['id'], "int"));
 
       mysqli_query($database,$insertSQL2) or die(mysqli_error($database));
       

       $insertSQL3 = sprintf("UPDATE `control_year` SET `phase1_total`=%s, `phase1_total`=%s, `subject_name`=%s  WHERE `subject_id`=%s ", 
              GetSQLValueString($database,$_POST['phase1_total'], "text"),  
              GetSQLValueString($database,$_POST['phase2_total'], "text"),  
              GetSQLValueString($database,$_POST['name_eng'], "text"),  
              GetSQLValueString($database,$_POST['id'], "int"));
 
        mysqli_query($database,$insertSQL3) or die(mysqli_error($database));

       
			header("location: edit-subject.php?id=".$_GET['id']."&done"); 
			exit();
	      
	} 
	
 

  mysqli_select_db($database, $database_database);  
  $query_get_class_info = "SELECT * FROM `subjects` where `id`='{$_GET['id']}' "; 
  $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
  $row_get_class_info = mysqli_fetch_assoc($get_class_info);
  $totalRows_get_class_info = mysqli_num_rows($get_class_info);

if($totalRows_get_class_info<1){header("location: home.php");exit();}

  mysqli_select_db($database, $database_database);  
  $query_get_cor = "SELECT * FROM `emps`   "; 
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
                <h4> تعديل   مادة دراسية </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="edit-subject.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     
             
                      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-4">
                            <select class="form-control" required name="study_year" id="study_year" > 
                                <option value="0" <?php if($row_get_class_info['study_year']==0){echo " selected ";}?> >  بلى سكول</option> 
                                <option value="1" <?php if($row_get_class_info['study_year']==1){echo " selected ";}?>  >اولى حضانة</option> 
                                <option value="2" <?php if($row_get_class_info['study_year']==2){echo " selected ";}?> >ثانية حضانة</option> 
                                <option value="3" <?php if($row_get_class_info['study_year']==3){echo " selected ";}?> > الصف الاول الابتدائى</option> 
                                <option value="4" <?php if($row_get_class_info['study_year']==4){echo " selected ";}?> > الصف الثانى الابتدائى</option> 
                                <option value="5" <?php if($row_get_class_info['study_year']==5){echo " selected ";}?> > الصف الثالث الابتدائى</option> 
                                <option value="6" <?php if($row_get_class_info['study_year']==6){echo " selected ";}?> > الصف الرابع الابتدائى</option> 
                                <option value="7" <?php if($row_get_class_info['study_year']==7){echo " selected ";}?> > الصف الخامس الابتدائى</option> 
                                <option value="8" <?php if($row_get_class_info['study_year']==8){echo " selected ";}?> > الصف السادس الابتدائى</option> 
                                <option value="9" <?php if($row_get_class_info['study_year']==9){echo " selected ";}?> > الصف الاول الاعدادى</option> 
                                <option value="10" <?php if($row_get_class_info['study_year']==10){echo " selected ";}?> > الصف الثاني الاعدادى</option> 
                                <option value="11" <?php if($row_get_class_info['study_year']==11){echo " selected ";}?> > الصف الثالث الاعدادى</option> 
                                <option value="12" <?php if($row_get_class_info['study_year']==12){echo " selected ";}?> > الصف الاول الثانوى</option> 
                                <option value="13" <?php if($row_get_class_info['study_year']==13){echo " selected ";}?> > الصف الثاني الثانوى</option> 
                                <option value="14" <?php if($row_get_class_info['study_year']==14){echo " selected ";}?> > الصف الثالث الثانوى</option>  
                            </select>
						</div>
                     </div> 
                      
           
 
            <div class="form-group" <?php if($row_get_class_info['study_year']<13){echo " style='display:none' ";}?>  id="major_box">
						    <label class="col-sm-3 control-label" for="major" > التخصص  </label>
                <div class="col-sm-4">
                    <select class="form-control" name="major" id="major" > 
                        <option value="1" <?php if($row_get_class_info['major']==1){echo " selected ";}?>> مشترك</option> 
                        <option value="2" <?php if($row_get_class_info['major']==2){echo " selected ";}?>> علمي</option> 
                        <option value="3" <?php if($row_get_class_info['major']==3){echo " selected ";}?>> ادبي</option>   
                        <option value="4" <?php if($row_get_class_info['major']==4){echo " selected ";}?>>  علمي  علوم </option>  
                        <option value="5" <?php if($row_get_class_info['major']==5){echo " selected ";}?>>   علمي رياضة  </option>  
                    </select>
                </div>
            </div>
                     <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">     اسم المادة عربي <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" required type="text" name="name" value="<?php echo $row_get_class_info['name'];?>">
                        </div>
                     </div>  

                     <div class="form-group">
              <label class="col-sm-3 control-label" for="name_eng">    اسم المادة انجليزي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_eng" class="form-control" required type="text" name="name_eng"  style="text-align: left;" value="<?php echo $row_get_class_info['name_eng'];?>">
              </div>
            </div>  
                      
            <div class="form-group" style="display: none;">
              <label class="col-sm-3 control-label" for="name_frn">    اسم المادة فرنسي <span style="color: red;">*</span></label>
              <div class="col-sm-9">
                <input id="name_frn" class="form-control"   type="text" name="name_frn" style="text-align: left;" value="<?php echo $row_get_class_info['name_frn'];?>">
              </div>
            </div>  
                      
            <div class="form-group">
						<label class="col-sm-3 control-label" for="cor"> منسق  </label>
						<div class="col-sm-4">
                            <select class="form-control select2"   name="cor" id="cor" > 
                                <option value=""   > </option>  
                                <?php if($totalRows_get_cor>0){ do{?>
                                <option value="<?php echo $row_get_cor['id'];?>" <?php if($row_get_class_info['cor']==$row_get_cor['id']){echo " selected ";}?> >  <?php echo $row_get_cor['name'];?> </option>  
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
                                <option value="<?php echo $row_get_head['id'];?>" <?php if($row_get_class_info['head']==$row_get_head['id']){echo " selected ";}?> >  <?php echo $row_get_head['name'];?> </option>  
                                <?php }while($row_get_head = mysqli_fetch_assoc($get_head));}?> 
                         </select>
						</div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="order"> الترتيب   </label>
              <div class="col-sm-4">
                              <select class="form-control" name="order" id="order" > 
                              <option value="0"></option>
                              <?php for($i=1;$i<21;$i++){?>  
                              <option value="<?php echo $i;?>" <?php if($row_get_class_info['order']==$i){echo " selected ";}?>  ><?php echo $i;?></option>  
                              <?php }?>  
                            </select>
              </div>
            </div> 


              <div class="form-group">
              <label class="col-sm-3 control-label" for="total">     العرض في البرنامج </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="app"  value="1"    type="checkbox" name="app" style="text-align: left;" <?php if($row_get_class_info['app']==1){echo " checked ";}?> >
              </div>
            </div>  




            <div class="form-group">
              <label class="col-sm-3 control-label" for="cert_view">   ظاهر في الشهادة   </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="cert_view" value="1" type="checkbox" name="cert_view" style="text-align: left;" <?php if($row_get_class_info['cert_view']==1){echo " checked ";}?> >
              </div>
            </div> 


            <div class="form-group">
              <label class="col-sm-3 control-label" for="total"> داخل في المجموع </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="total" value="1" type="checkbox" name="total" style="text-align: left;" <?php if($row_get_class_info['total']==1){echo " checked ";}?> >
              </div>
            </div>  
                    

            <div class="form-group">
              <label class="col-sm-3 control-label" for="h_total"> داخل في مجمزع الهلالية </label>
              <div class="col-sm-9" style="padding-top: 5px;">
                <input id="total" value="1" type="checkbox" name="h_total" style="text-align: left;" <?php if($row_get_class_info['h_total']==1){echo " checked ";}?> >
              </div>
            </div>

            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="score">        درجة المجموع  </label>
              <div class="col-sm-2">
                <input id="score" class="form-control"   type="number" name="score" min="0" step="0.01" max="100" style="text-align: left;"  value="<?php echo $row_get_class_info['score'];?>">
              </div>
            </div>
 
            <div class="form-group">
              <label class="col-sm-3 control-label" for="h_score">         درجة  مجموع الهلالية  </label>
              <div class="col-sm-2">
                <input id="h_score" class="form-control"   type="number" name="h_score" min="0" max="100" style="text-align: left;"  value="<?php echo $row_get_class_info['h_score'];?>">
              </div>
            </div>


            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="phase1_total">         درجة    اعمال السنة ترم 1  </label>
              <div class="col-sm-2">
                <input id="phase1_total" class="form-control"   type="number" name="phase1_total" min="0" step="0.01" max="100" style="text-align: left;"  value="<?php echo $row_get_class_info['phase1_total'];?>">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label" for="phase2_total">         درجة    اعمال السنة ترم 2  </label>
              <div class="col-sm-2">
                <input id="phase2_total" class="form-control"   type="number" name="phase2_total" min="0" step="0.01"  max="100" style="text-align: left;"  value="<?php echo $row_get_class_info['phase2_total'];?>">
              </div>
            </div>

                     <div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                            <input type="hidden" name="id" value="<?php echo $row_get_class_info['id'];?>" />
                         </div> 
                         <div class="col-sm-5"> </div> 
                          <div class="col-sm-2"> 
<a href="edit-subject.php?del=<?php echo $row_get_class_info['id'];?>" class="btn btn-danger btn-block" onclick="return confirm('تاكيد الحذف؟');" ><i class="fa fa-trash-o" aria-hidden="true"></i> حذف   </a>
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