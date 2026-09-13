<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub0']==1){
 
    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids_reg` where `id`='{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);
  
  if($totalRows_get_kid_info<1){header("location: reg-kid-list.php"); exit();}

  


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
                <h4>   بيانات تسجيل طالب   </h4>
            </div>
          </div>
			<div class="row"> 
				<div class="col-md-6">
				  <div class="demo-form-wrapper">
                  
                    <form action="edit-reg-kid.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            

			 <div class="form-group">
              <label class="col-sm-3 control-label" for="name">  الاسم </label>
              <div class="col-sm-6">
                <input id="name" class="form-control" required type="text" name="name" readonly value="<?php echo $row_get_kid_info['name'];?>">
              </div>
            </div>  
            
            <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  الاسم باللغة الانجليزية</label>
              <div class="col-sm-6">
                <input id="fn_name" class="form-control" style="text-align: left;"   type="text" name="fn_name" readonly value="<?php echo $row_get_kid_info['fn_name'];?>">
              </div>
            </div>  

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  </label>
						<div class="col-sm-4">
                        <input id="study_year" class="form-control" style="text-align: center;"   type="text" name="study_year" readonly value="<?php echo year_of_study($row_get_kid_info['study_year']);?>">
               
						</div>
            </div> 


            <div class="form-group" style="<?php if($row_get_kid_info['study_year']!=13 && $row_get_kid_info['study_year']!=14){?>display: none;<?php }?>" id="study_type_box">
						<label class="col-sm-3 control-label" for="study_type"> التخصص  </label>
						<div class="col-sm-4">
                <select class="form-control" name="study_type" id="study_type" >
                      <option <?php if($row_get_kid_info['study_type']<1){echo " selected ";}?> >...</option> 
                      <option <?php if($row_get_kid_info['study_type']==1){echo " selected ";}?> value="1">علمى</option> 
                      <option <?php if($row_get_kid_info['study_type']==2){echo " selected ";}?> value="2">علمي علوم</option> 
                      <option <?php if($row_get_kid_info['study_type']==3){echo " selected ";}?> value="3">علمي رياضة</option>  
                      <option <?php if($row_get_kid_info['study_type']==4){echo " selected ";}?> value="4">أدبي</option>  
                </select>
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="lang"> لغة ثانية  </label>
						<div class="col-sm-4">
                        <input id="lang" class="form-control" style="text-align: center;"   type="text" name="lang" readonly value="<?php  if($row_get_kid_info['lang']==1){echo " فرنسية ";} if($row_get_kid_info['lang']==2){echo " المانية ";}  if($row_get_kid_info['lang']==3){echo " ايطالية ";}?>">
                 
						</div>
            </div> 


            <div class="form-group">
						<label class="col-sm-3 control-label" for="class"> السنة </label>
						<div class="col-sm-2"  >
                        <input id="join_year" class="form-control" style="text-align: center;"   type="text" name="join_year" readonly value="<?php echo $row_get_kid_info['join_year'];?>">
                   </div>
            </div> 

             

        
            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع   </label>
              <div class="col-sm-2">
              <input id="gender" class="form-control" style="text-align: center;"   type="text" name="join_year" readonly value="<?php echo $row_get_kid_info['gender'];?>">
                      
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="nationality">  الجنسية </label>
              <div class="col-sm-4">
                <input id="nationality" class="form-control"  readonly type="text" name="nationality" value="<?php echo $row_get_kid_info['nationality'];?>">
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="birth_place">  محل الميلاد  </label>
              <div class="col-sm-4">
                <input id="birth_place" class="form-control" readonly   type="text" name="birth_place"  value="<?php echo $row_get_kid_info['birth_place'];?>">
              </div>
            </div> 
            
           
             <div class="form-group">
              <label class="col-sm-3 control-label" for="gov_id"> الرقم القومي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"    readonly  value="<?php echo $row_get_kid_info['gov_id'];?>">
                 <p id="gov_id_warn1" style="color: red; display:none"><i class="fa fa-times-circle-o" aria-hidden="true"></i> رقم البطاقة غير صحيح </p>
                 <p id="gov_id_warn2" style="color: orange; display:none"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  الرقم القمومي مسجل من قبل </p>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="ed_id"> الرقم التعليمي </label>
              <div class="col-sm-4">
                 <input   class="form-control" type="number"    readonly  value="<?php echo $row_get_kid_info['ed_id'];?>">  
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="age_october">    السن فى اول اكتوبر  </label>
              <div class="col-sm-6" id="age_october" style="padding-top: 7px; "> 
              <p style="font-weight:bold; font-size:18px" id="birthday_october" ><?php echo convertSecToTime($row_get_kid_info['birthday']);?></p> 
              </div>
            </div> 
                      
        

            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="email">  البريد الالكتروني  </label>
              <div class="col-sm-4">
                 <input class="form-control" type="text" readonly  value="<?php echo $row_get_kid_info['email'];?>">  </div>
            </div> 



            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_details">  اسم الوالد وصناعته والعنوانه  </label>
              <div class="col-sm-6"  style="padding-top: 7px;">
              <p style="padding:20px; background-color:white;"><?php echo $row_get_kid_info['father_details'];?> </p>
                 
              </div>
            </div> 
      
      
     
             <div class="form-group">
              <label class="col-sm-3 control-label" for="responsible">        الولاية  </label>
              <div class="col-sm-4">
                <input id="responsible" class="form-control" readonly  type="text" name="responsible"  value="<?php echo $row_get_kid_info['responsible'];?>">
              </div>
            </div>

  




            <div class="form-group">
              <label class="col-sm-3 control-label" for="home_phone">      هاتف المنزل  </label>
              <div class="col-sm-4">
                <input id="home_phone" class="form-control"  readonly type="text" name="home_phone" value="<?php echo $row_get_kid_info['home_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="other_phone">      هاتف اخر  </label>
              <div class="col-sm-4">
                <input id="other_phone" class="form-control" readonly  type="text" name="other_phone" value="<?php echo $row_get_kid_info['other_phone'];?>">
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="mother_mobile">      هاتف الام  </label>
              <div class="col-sm-4">
                <input id="mother_mobile" class="form-control" readonly  type="text" name="mother_mobile" value="<?php echo $row_get_kid_info['mother_mobile'];?>"> 
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-3 control-label" for="father_mobile">    هاتف الاب  </label>
              <div class="col-sm-4">
                <input id="father_mobile" class="form-control" readonly   type="text" name="father_mobile"  value="<?php echo $row_get_kid_info['father_mobile'];?>">
              </div>
            </div> 

            <div class="form-group">
            <label class="col-sm-3 control-label" for="		other_mobile">    هاتف محمول اخر  </label>
              <div class="col-sm-4">
                <input id="other_mobile" class="form-control" readonly  type="text" name="other_mobile"  value="<?php echo $row_get_kid_info['other_mobile'];?>">
              </div>
            </div> 
 

            <hr>
<h3>بيانات المدرسة المحول من</h3>

            <div class="form-group">
            <label class="col-sm-3 control-label" for="from_school">     المدرسة المحول من  </label>
              <div class="col-sm-4">
                <input id="from_school" class="form-control"  readonly type="text" name="from_school" value="<?php echo $row_get_kid_info['from_school'];?>">
              </div>
            </div>

            
            <div class="form-group">
            <label class="col-sm-3 control-label" for="school_ed"> الإدارة التعليمية التابع له  </label>
              <div class="col-sm-4">
                <input id="school_ed" class="form-control"  readonly type="text" name="school_ed" value="<?php echo $row_get_kid_info['school_ed'];?>">
              </div>
            </div>
            

            <div class="form-group">
            <label class="col-sm-3 control-label" for="transfare_comment">         سبب التحويل  </label>
              <div class="col-sm-4">
                <input id="transfare_comment" class="form-control" readonly  type="text" name="transfare_comment" value="<?php echo $row_get_kid_info['transfare_comment'];?>">
              </div>
            </div>
            


						
             
			 <div class="form-group">
				 <label class="col-sm-3 control-label" for="submit"> </label>
                <div class="col-sm-2"> 
                    <a href="edit-reg-kid.php?id=<?php echo $row_get_kid_info['id'];?>" class="btn btn-danger btn-block"  ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> تعديل   </a>
                </div> 
            </div>

  	
					</form>
				  </div>
                </div>
            <div class="col-md-6">
            <div class="col-md-6">
            <img src="../kids/<?php  if($row_get_kid_info['picture']!=null){echo $row_get_kid_info['picture'];}else{echo "no-picture.png";}?>" class="img-responsive img-rounded img-thumbnail"  style="float:left" />
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

$("input").css("backgroundColor","white");
$("select").css("backgroundColor","white");

	  });
    </script>
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
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 

       

        $("#court-datatables2").DataTable({  
            order: [
                [1, "desc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ 2 ]  
			   }
			 ]
        }); 
          
   


        
	  });
 </script>
    
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>