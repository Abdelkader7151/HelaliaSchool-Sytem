<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 require_once('includes/app10-students-sync.php');

 if($row_get_login['access6sub3']==1){

$msg ='';


if(isset($_GET['del'])){   
    mysqli_select_db($database, $database_database);
    $delId = (int) $_GET['del'];
    $rowDel = null;
    $rsDel = mysqli_query($database, "SELECT `emp_id`, `study_year` FROM `teachers` WHERE `id` = '{$delId}' LIMIT 1");
    if ($rsDel) {
        $rowDel = mysqli_fetch_assoc($rsDel);
    }
    $deleteSQL = sprintf("DELETE FROM `teachers` WHERE `id`=%s ",
                GetSQLValueString($database,$_GET['del'], "int"));
    $Result1 = mysqli_query($database,$deleteSQL) or die(mysqli_error($database));
    if ($rowDel) {
        helalia_student_search_revoke_stage_if_unassigned($rowDel['emp_id'], $rowDel['study_year']);
    }
} 



if(isset($_POST['submit'])){  

    mysqli_select_db($database, $database_database); 
    $query_get_teachers_subjects = "SELECT * FROM `teachers` WHERE `emp_id`= '{$_POST['id']}' AND  `study_year`= '{$_POST['study_year']}' AND `class`= '{$_POST['class']}' AND `subject`= '{$_POST['subject']}'";
    $get_teachers_subjects = mysqli_query($database,$query_get_teachers_subjects) or die(mysqli_error($database));
    $row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects);
    $totalRows_get_teachers_subjects = mysqli_num_rows($get_teachers_subjects);

    if($totalRows_get_teachers_subjects<1){
      if($_POST['class']>0){ 
            $insertSQL1 = sprintf("INSERT INTO `teachers` (`emp_id`, `study_year`, `class`, `subject`) values (%s, %s, %s, %s) ", 
                                    GetSQLValueString($database,$_POST['id'], "int"),   
                                    GetSQLValueString($database,$_POST['study_year'], "int"), 
                                    GetSQLValueString($database,$_POST['class'], "int"),
                                    GetSQLValueString($database,$_POST['subject'], "int"));

             mysqli_query($database,$insertSQL1) or die(mysqli_error($database));
             helalia_student_search_grant_year($_POST['id'], $_POST['study_year']);
    }
      if($_POST['class']==0){  
        $query_get_data = "SELECT * FROM `class` where `study_year`='{$_POST['study_year']}' ";
        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        $totalRows_get_data = mysqli_num_rows($get_data); 
        if($totalRows_get_data>0){
          do{ 
              $insertSQL2 = sprintf("INSERT INTO `teachers` (`emp_id`, `study_year`, `class`, `subject`) values (%s, %s, %s, %s) ", 
                              GetSQLValueString($database,$_POST['id'], "int"),   
                                      GetSQLValueString($database,$_POST['study_year'], "int"), 
                                      GetSQLValueString($database,$row_get_data['id'], "int"),
                                      GetSQLValueString($database,$_POST['subject'], "int"));
   
              mysqli_query($database,$insertSQL2) or die(mysqli_error($database)); 
           } while($row_get_data = mysqli_fetch_assoc($get_data));
           helalia_student_search_grant_year($_POST['id'], $_POST['study_year']);
        }
      }


    } 
        header("location: teacher-subjects.php?id=".$_GET['id']); 
        exit(); 
  } 
  
 
 
    mysqli_select_db($database, $database_database); 
    $query_get_users_info = "SELECT * FROM `emps` where `id`='{$_GET['id']}'  ";
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);


    mysqli_select_db($database, $database_database); 
    $query_get_teachers_subjects = "SELECT * FROM `teachers` where `emp_id` = '{$_GET['id']}' order by `study_year` asc";
    $get_teachers_subjects = mysqli_query($database,$query_get_teachers_subjects) or die(mysqli_error($database));
    $row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects);
    $totalRows_get_teachers_subjects = mysqli_num_rows($get_teachers_subjects);

      


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
                <h4>     تعين  مدرس على مادة علمية  / <span style="color: #ed1e26"><?php echo $row_get_users_info['name'];?> </span>  </h4>
            </div>
          </div>
			<div class="row">   
        <div class="col-md-5">
      <form action="teacher-subjects.php?id=<?php echo $_GET['id'];?>" method="post" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
            
     


      <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> السنة الدراسية  <span style="color: red;">*</span></label>
						<div class="col-sm-6">
            <select class="form-control" required name="study_year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0">  بري سكول</option> 
                      <option value="1">اولى حضانة</option> 
                      <option value="2">ثانية حضانة</option> 
                      <option value="3">  الصف الاول الابتدائى</option> 
                      <option value="4">  الصف الثانى الابتدائى</option> 
                      <option value="5">  الصف الثالث الابتدائى</option> 
                      <option value="6">  الصف الرابع الابتدائى</option> 
                      <option value="7">  الصف الخامس الابتدائى</option> 
                      <option value="8">  الصف السادس الابتدائى</option> 
                      <option value="9">  الصف الاول الاعدادى</option> 
                      <option value="10">  الصف الثاني الاعدادى</option> 
                      <option value="11">  الصف الثالث الاعدادى</option> 
                      <option value="12">  الصف الاول الثانوى</option> 
                      <option value="13">  الصف الثاني الثانوى</option> 
                      <option value="14">  الصف الثالث الثانوى</option>  
                </select> 
						</div>
        </div>  


            <div class="form-group">
                <label class="col-sm-3 control-label" for="class">   الفصل   </label>
                <div class="col-sm-6" id="class_box">
                    <select class="form-control" required name="class" id="class" ></select> 
                </div>
            </div>     
                              
            <div class="form-group">
			   <label class="col-sm-3 control-label" for="subject">   المادة العلمية   </label>
			   <div class="col-sm-6" id="subject_box">
                <select class="form-control" required name="subject" id="subject" ></select> 
			   </div>
            </div>  
                
            <div class="form-group">
                <label class="col-sm-3 control-label" for="submit"> </label>
                <div class="col-sm-3"> 
                  <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i> حفظ</button> 
                  <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                </div>  

                <div class="col-sm-3"> 
                  <a href="edit-emp.php?id=<?php echo $_GET['id'];?>"   class="btn btn-primary btn-block"   > رجوع <i class="fa fa-chevron-left" aria-hidden="true"></i> </a> 
              
                </div>    
             </div> 

      </form>
      </div>

      <div class="col-md-5">  
            <div class="card-body" data-toggle="match-height" > 
                <table id="court-datatables" class="table table-striped   dataTable" width="100%" style="font-size: 16px; ">
                    <thead> 
                      <tr>   
                        <th class="text-center"> السنة الدراسية</th> 
                        <th class="text-center"> الفصل  </th>  
                        <th class="text-center"> المادة العلمية  </th>  
                        <th class="text-center"> </th> 
                      </tr>
                    </thead>
                    <tbody>  
 
						
						<?php if($totalRows_get_teachers_subjects>0){
	                           do{  ?>
                      <tr class="count">  
                        <td class="text-center"><?php echo year_of_study($row_get_teachers_subjects['study_year']);?></td>
                        <td class="text-center"><?php echo class_name($row_get_teachers_subjects['class']);?></td>  
                        <td class="text-center" style="text-transform: capitalize"><?php echo subject_name($row_get_teachers_subjects['subject']);?></td> 
                        
                        <td class="text-center">
                        <a href="teacher-subjects.php?del=<?php echo $row_get_teachers_subjects['id'];?>&id=<?php echo $_GET['id'];?>" class="btn btn-primary btn-xs " onclick="return confirm('تاكيد الحذف؟');"  >  <i class="fa fa-trash-o" aria-hidden="true" ></i>  حذف </a>
                        </td>
                      </tr>
                      <?php }while($row_get_teachers_subjects = mysqli_fetch_assoc($get_teachers_subjects));} ?> 
                     
                     
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
			     "aTargets": [ 3 ]  
			   }
			 ]
        }); 
          
   
 


        $('#form1').on('change', '#study_year', function (event) {  
			var id = $(this).val();  
			$.post("classes.php",
                {
                    id:id
                },
                function(Date,status){  
                    $("#class_box").html(Date);  
                }); 
	   
            
            $.post("subject.php",
                {
                id:id
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
		  
	  });
	  </script>
  </body>
 
</html>

    <?php }else{header("location: home.php;");exit();}?>