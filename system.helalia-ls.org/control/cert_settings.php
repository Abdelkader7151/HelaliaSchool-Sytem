<?php require_once('includes/access.php'); 
require_once('includes/logout.php'); 
require_once('../Connections/database.php'); 
require_once('includes/functions.php');    
 

 if($row_get_login['access16']==1 && $row_get_login['id']==1){
 
  
  

if(isset($_POST['save'])){ 

    
    $updateSQL = sprintf("UPDATE `cert_settings` SET `mid_year`=%s, `end_year`=%s ,`color0`=%s, `color1`=%s, `color2`=%s, `color3`=%s, `color4`=%s, `color5`=%s, `color6`=%s, `color7`=%s, `color8`=%s, `color9`=%s, `color10`=%s, `color11`=%s, `color12`=%s, `color13`=%s, `color14`=%s,
                                                     `comment0`=%s, `comment1`=%s, `comment2`=%s, `comment3`=%s, `comment4`=%s, `comment5`=%s, `comment6`=%s, `comment7`=%s, `comment8`=%s, `comment9`=%s, `comment10`=%s, `comment11`=%s, `comment12`=%s, `comment13`=%s, `comment14`=%s ", 
                                GetSQLValueString($database,$_POST['mid_year'], "int"), 
                                GetSQLValueString($database,$_POST['end_year'], "int"), 
                                GetSQLValueString($database,$_POST['color0'], "int"), 
                                GetSQLValueString($database,$_POST['color1'], "int"), 
                                GetSQLValueString($database,$_POST['color2'], "int"), 
                                GetSQLValueString($database,$_POST['color3'], "int"),
                                GetSQLValueString($database,$_POST['color4'], "int"),
                                GetSQLValueString($database,$_POST['color5'], "int"),
                                GetSQLValueString($database,$_POST['color6'], "int"),
                                GetSQLValueString($database,$_POST['color7'], "int"),
                                GetSQLValueString($database,$_POST['color8'], "int"),
                                GetSQLValueString($database,$_POST['color9'], "int"),
                                GetSQLValueString($database,$_POST['color10'], "int"),
                                GetSQLValueString($database,$_POST['color11'], "int"),
                                GetSQLValueString($database,$_POST['color12'], "int"),
                                GetSQLValueString($database,$_POST['color13'], "int"),
                                GetSQLValueString($database,$_POST['color14'], "int"),
                                GetSQLValueString($database,$_POST['comment0'], "int"),
                                GetSQLValueString($database,$_POST['comment1'], "int"),
                                GetSQLValueString($database,$_POST['comment2'], "int"),
                                GetSQLValueString($database,$_POST['comment3'], "int"),
                                GetSQLValueString($database,$_POST['comment4'], "int"),
                                GetSQLValueString($database,$_POST['comment5'], "int"),
                                GetSQLValueString($database,$_POST['comment6'], "int"),
                                GetSQLValueString($database,$_POST['comment7'], "int"),
                                GetSQLValueString($database,$_POST['comment8'], "int"),
                                GetSQLValueString($database,$_POST['comment9'], "int"),
                                GetSQLValueString($database,$_POST['comment10'], "int"),
                                GetSQLValueString($database,$_POST['comment11'], "int"),
                                GetSQLValueString($database,$_POST['comment12'], "int"),
                                GetSQLValueString($database,$_POST['comment13'], "int"),
                                GetSQLValueString($database,$_POST['comment14'], "int"));

    mysqli_query($database,$updateSQL) or die(mysqli_error($database)); 






  if(isset($_POST['mid_year'])){ 
          $updateSQL = sprintf("UPDATE `certificate` SET `active`= %s WHERE `type`=2 ",
                         GetSQLValueString($database,$_POST['mid_year'], "int"));

           mysqli_query($database,$updateSQL) or die(mysqli_error($database));
           
  }

  
 if(isset($_POST['end_year'])){ 
          $updateSQL = sprintf("UPDATE `certificate` SET `active`= %s WHERE `type`=3 ",
                          GetSQLValueString($database,$_POST['end_year'], "int"));

           mysqli_query($database,$updateSQL) or die(mysqli_error($database));
           
  }








    header("location: cert_settings.php?updated");
    exit();
  
}




    mysqli_select_db($database, $database_database); 
    $query_get_cert_settings = "SELECT * FROM `cert_settings`    ";
    $get_cert_settings = mysqli_query($database,$query_get_cert_settings) or die(mysqli_error($database));
    $row_get_cert_settings = mysqli_fetch_assoc($get_cert_settings);
    $totalRows_get_cert_settings = mysqli_num_rows($get_cert_settings);



$head_title = "  النتائج";
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
			<?php include('includes/mobile-menu-buttons.php');?> 
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
                <h4>         تحميل نتيجة  </h4>
            </div>
          </div>
			<div class="row">  
				<div class="col-md-4">
				  <div class="demo-form-wrapper"> 
                    <form  method="POST" name="form1" id="demo-inputmask2"  enctype="multipart/form-data" class="form form-horizontal">  
                 
 
            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > بري سكول  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color0" value="1" <?php if($row_get_cert_settings['color0']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color0" value="0" <?php if($row_get_cert_settings['color0']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment0" value="1" <?php if($row_get_cert_settings['comment0']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment0" value="0" <?php if($row_get_cert_settings['comment0']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div> 

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > اولى حضانة  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color1" value="1" <?php if($row_get_cert_settings['color1']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="color1" value="0" <?php if($row_get_cert_settings['color1']==0){echo " checked ";}?>> اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment1" value="1" <?php if($row_get_cert_settings['comment1']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment1" value="0" <?php if($row_get_cert_settings['comment1']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > ثانية حضانة  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color2" value="1" <?php if($row_get_cert_settings['color2']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color2" value="0" <?php if($row_get_cert_settings['color2']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment2" value="1" <?php if($row_get_cert_settings['comment2']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment2" value="0" <?php if($row_get_cert_settings['comment2']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الاول الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color3" value="1" <?php if($row_get_cert_settings['color3']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="color3" value="0" <?php if($row_get_cert_settings['color3']==0){echo " checked ";}?>> اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment3" value="1" <?php if($row_get_cert_settings['comment3']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment3" value="0" <?php if($row_get_cert_settings['comment3']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثانى الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color4" value="1" <?php if($row_get_cert_settings['color4']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color4" value="0" <?php if($row_get_cert_settings['color4']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment4" value="1" <?php if($row_get_cert_settings['comment4']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment4" value="0" <?php if($row_get_cert_settings['comment4']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثالث الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color5" value="1" <?php if($row_get_cert_settings['color5']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color5" value="0" <?php if($row_get_cert_settings['color5']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment5" value="1" <?php if($row_get_cert_settings['comment5']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment5" value="0" <?php if($row_get_cert_settings['comment5']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الرابع الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color6" value="1" <?php if($row_get_cert_settings['color6']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color6" value="0" <?php if($row_get_cert_settings['color6']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment6" value="1" <?php if($row_get_cert_settings['comment6']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment6" value="0" <?php if($row_get_cert_settings['comment6']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الخامس الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color7" value="1" <?php if($row_get_cert_settings['color7']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color7" value="0" <?php if($row_get_cert_settings['color7']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment7" value="1" <?php if($row_get_cert_settings['comment7']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment7" value="0" <?php if($row_get_cert_settings['comment7']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف السادس الابتدائى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color8" value="1" <?php if($row_get_cert_settings['color8']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color8" value="0" <?php if($row_get_cert_settings['color8']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment8" value="1" <?php if($row_get_cert_settings['comment8']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment8" value="0" <?php if($row_get_cert_settings['comment8']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الاول الاعدادى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color9" value="1" <?php if($row_get_cert_settings['color9']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color9" value="0" <?php if($row_get_cert_settings['color9']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment9" value="1" <?php if($row_get_cert_settings['comment9']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment9" value="0" <?php if($row_get_cert_settings['comment9']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثانى الاعدادى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color10" value="1" <?php if($row_get_cert_settings['color10']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color10" value="0" <?php if($row_get_cert_settings['color10']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment10" value="1" <?php if($row_get_cert_settings['comment10']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment10" value="0" <?php if($row_get_cert_settings['comment10']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثالث الاعدادى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color11" value="1" <?php if($row_get_cert_settings['color11']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color11" value="0" <?php if($row_get_cert_settings['color11']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment11" value="1" <?php if($row_get_cert_settings['comment11']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment11" value="0" <?php if($row_get_cert_settings['comment11']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الاول الثانوى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color12" value="1" <?php if($row_get_cert_settings['color12']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color12" value="0" <?php if($row_get_cert_settings['color12']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment12" value="1" <?php if($row_get_cert_settings['comment12']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment12" value="0" <?php if($row_get_cert_settings['comment12']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثاني الثانوى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color13" value="1" <?php if($row_get_cert_settings['color13']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color13" value="0" <?php if($row_get_cert_settings['color13']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment13" value="1" <?php if($row_get_cert_settings['comment13']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment13" value="0" <?php if($row_get_cert_settings['comment13']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  > الصف الثالث الثانوى  </label>
						<div class="col-sm-1"> الوان </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="color14" value="1" <?php if($row_get_cert_settings['color14']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="color14" value="0" <?php if($row_get_cert_settings['color14']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> التعليق </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="comment14" value="1" <?php if($row_get_cert_settings['comment14']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="comment14" value="0" <?php if($row_get_cert_settings['comment14']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div>

          

            <hr>


            <div class="form-group">
						<label class="col-sm-2 control-label" style="padding-top: 0px;"  >   نشر النتائج  </label>
						<div class="col-sm-1"> نصف العام </div>  
						<div class="col-sm-4"> 
                            <input type="radio" name="mid_year" value="1" <?php if($row_get_cert_settings['mid_year']==1){echo " checked ";}?> > عرض    
                            <input type="radio" name="mid_year" value="0" <?php if($row_get_cert_settings['mid_year']==0){echo " checked ";}?> > اخفاء    
						</div>

                        <div class="col-sm-1"> اخر العام </div>  
						<div class="col-sm-4">  
                            <input type="radio" name="end_year" value="1" <?php if($row_get_cert_settings['end_year']==1){echo " checked ";}?>> عرض    
                            <input type="radio" name="end_year" value="0" <?php if($row_get_cert_settings['end_year']==0){echo " checked ";}?>> اخفاء    
						</div>
            </div> 

             
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						  <div class="col-sm-3"> 
                            <button type="submit" class="btn btn-success btn-block" name="save"   style="background-color: green;" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
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
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
  
 
	  
	  <script>  
	  $(document).ready(function(){

      $("#court-datatables").DataTable({ 
            dom: 'Bfrtip',
            lengthMenu: [
            [ -1  ],
            [ 'All' ]
              ],
              buttons: [
                'excel','copy',   
                ]

            }); 
  
      $('#demo-inputmask2').on('change', '#target', function (event) {    
        var year = $(this).val();
        if(year<15){
          $("#class_box").fadeIn();
           $.post("get_class2.php",
            {
              year:year
            },
            function(Date,status){ 
                $("#class").html(Date);   
                $("#loading").fadeIn();
            
              $.post("cer_file.php",
                {
                  year:year,
                  class:0
                },
                  function(Date,status){ 
                      $("#result").html(Date); 
                      $("#loading").fadeOut();
                  });
                });
        }else{
           $("#class").prop("selectedIndex", 0);
           $("#class_box").fadeOut(); 
          };
       });


       $('#demo-inputmask2').on('change', '#class', function (event) {    
            var year = $("#target").val(); 
            var clas = $(this).val();
            $("#loading").fadeIn();
            
           $.post("cer_file.php",
            {
              year:year,
              class:clas
            },
            function(Date,status){ 
                $("#result").html(Date); 
                $("#loading").fadeOut();
             });
        
       });
  

	  });
    </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php");exit();}?>