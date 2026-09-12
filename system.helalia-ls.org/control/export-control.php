<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub2']==1){  







  if(isset($_GET['certificate']) && $row_get_login['access23sub4']==1){      
   
    mysqli_select_db($database, $database_database);  
    $query_get_users_info = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `month`='{$_GET['month']}' AND `confirm` = 1   ";    
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);
    
    if($totalRows_get_users_info>0){ 
      do{      
           $updateSQL1 = sprintf("UPDATE `control` SET `publish`=%s, `publish_by`=%s, `publish_date`=%s WHERE `id`=%s  ",    
                            GetSQLValueString($database,1, "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "int"),
                            GetSQLValueString($database,$row_get_users_info['id'], "int"));

            mysqli_query($database,$updateSQL1) or die(mysqli_error($database)); 
        }while($row_get_users_info = mysqli_fetch_assoc($get_users_info)); 
    } 
    header("location: export-control.php?month={$_GET['month']}&year={$_GET['year']}&class={$_GET['class']}&gender={$_GET['gender']}&submit");
    exit();
} 


 if(isset($_GET['cert']) && $row_get_login['access23sub4']==1){      
   
    mysqli_select_db($database, $database_database);  
    $query_get_users_info = "SELECT * FROM `control` WHERE `kid_id` ='{$_GET['cert']}' AND `study_year`= '{$_GET['year']}' AND `month`='{$_GET['month']}' AND `confirm` = 1   ";    
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);
    
    if($totalRows_get_users_info>0){ 
      do{      
           $updateSQL1 = sprintf("UPDATE `control` SET `publish`=%s, `publish_by`=%s, `publish_date`=%s WHERE `id`=%s  ",    
                            GetSQLValueString($database,1, "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "int"),
                            GetSQLValueString($database,$row_get_users_info['id'], "int"));

            mysqli_query($database,$updateSQL1) or die(mysqli_error($database)); 
        }while($row_get_users_info = mysqli_fetch_assoc($get_users_info)); 
    } 
    header("location: export-control.php?month={$_GET['month']}&year={$_GET['year']}&class={$_GET['class']}&gender={$_GET['gender']}&submit");
    exit();
} 


if(isset($_GET['hide']) && $row_get_login['access23sub4']==1){      
   
    mysqli_select_db($database, $database_database);  
    $query_get_users_info = "SELECT * FROM `control` WHERE `kid_id` ='{$_GET['hide']}' AND `study_year`= '{$_GET['year']}' AND `month`='{$_GET['month']}' AND `confirm` = 1   ";    
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);
    
    if($totalRows_get_users_info>0){ 
      do{      
           $updateSQL1 = sprintf("UPDATE `control` SET `publish`=%s, `publish_by`=%s, `publish_date`=%s WHERE `id`=%s  ",    
                            GetSQLValueString($database,0, "int"),
                            GetSQLValueString($database,$row_get_login['id'], "int"),
                            GetSQLValueString($database,time(), "int"),
                            GetSQLValueString($database,$row_get_users_info['id'], "int"));

            mysqli_query($database,$updateSQL1) or die(mysqli_error($database)); 
        }while($row_get_users_info = mysqli_fetch_assoc($get_users_info)); 
    } 
    header("location: export-control.php?month={$_GET['month']}&year={$_GET['year']}&class={$_GET['class']}&gender={$_GET['gender']}&submit");
    exit();
} 



$head_title = "  الكنترول";
 ?> 
<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
  <?php include("includes/header.php");?>
  <?php include("includes/share.php");?>
  <?php include("includes/top-script.php");?> 
  <title>رصد الدرجات شهر <?php echo htmlspecialchars($_GET['month']); ?></title>
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css">  
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      text-align: right;
      padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}
</style>
<script>
 $(document).ready(function(){ 
 
  
});
</script>
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
          <?php if(!isset($_GET['submit'])){?> 
			<div class="row">
            <div class="col-md-12">
                <h4>     رصد الدرجات </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="export-control.php" method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     

            <div class="form-group" >
			  <label class="col-sm-3 control-label" for="month"> الشهر  <span style="color: red;">*</span></label>
              <div class="col-sm-2">
                  <select class="form-control" name="month" id="month" required >
                        <option selected >...</option> 
                        <option value="10">اكتوبر</option>  
                        <option value="11">نوفمبر</option>  
                        <option value="12">ديسمبر</option>  
                        <option value="1">يناير</option>  
                        <option value="2">فبراير</option>  
                        <option value="3">امتحان شهر اول</option>  
                        <option value="4">امتحان شهر ثاني</option>   
                        <option value="6">يونيو</option>  
                        <option value="7">يوليو</option>  
                        <option value="8">اغسطس</option>  
                  </select>
              </div>
            </div>
           
   

            <div class="form-group">
						<label class="col-sm-3 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-3">
                <select class="form-control" required name="year" id="study_year" >
                      <option selected disabled >...</option> 
                      <option value="0"> بري سكول </option> 
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
			     <label class="col-sm-3 control-label" for="class" > الفصل <span style="color: red;">*</span></label>
                <div class="col-sm-3" >
                    <select class="form-control"  name="class" id="class" required >
                        <option selected></option>  
                    </select>
                </div>
            </div> 

         

            <div class="form-group"  >
						<label class="col-sm-3 control-label" for="gender"> النوع  <span style="color: red;">*</span></label>
						<div class="col-sm-1">
                            <select class="form-control"   name="gender" id="gender" > 
                                <option value="الاثنين">  الاثنين</option>  
                                <option value="ذكر">  ذكر</option> 
                                <option value="انثى">  انثى</option>   
                            </select>
						</div>
            </div> 

             
             
 
						
						<div class="form-group">
						 <label class="col-sm-3 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >عرض</button> 
						 </div> 
					    </div> 


 
						
						
						
						
					</form>
				  </div>
				</div>
		    </div>
       <?php }else{  

            if($_GET['gender']!='الاثنين'){ $gender = " AND `gender` = '{$_GET['gender']}' "; }else{ $gender = ""; } 
            if($_GET['class']>0){ $class = " AND `class` = '{$_GET['class']}' "; }else{ $class = ""; }
                  
            mysqli_select_db($database, $database_database);  
            $query_get_data = "SELECT * FROM `kids` WHERE `study_year` = '{$_GET['year']}' $gender $class ";    
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
    
            mysqli_select_db($database, $database_database); 
            $query_get_subject_header = "SELECT * FROM `subjects` WHERE `study_year`= '{$_GET['year']}' ORDER BY `id` asc  ";
            $get_subject_header = mysqli_query($database,$query_get_subject_header) or die(mysqli_error($database));
            $row_get_subject_header = mysqli_fetch_assoc($get_subject_header);
            $totalRows_get_subject_header = mysqli_num_rows($get_subject_header); 

          
        

        ?>
      	<div class="row">
				<div class="col-md-12">     

        <?php  if($row_get_login['access23sub4']==1){?>
        <a href="export-control.php?month=<?php echo $_GET['month'];?>&year=<?php echo $_GET['year'];?>&class=<?php echo $_GET['class'];?>&gender=<?php echo $_GET['gender'];?>&certificate" class="btn btn-primary btn-block" style=" width: 100px; margin-right:30px; float:left" onclick="return confirm('تاكيد اصدار شهادات الشهر؟  ');"    >اصدار الشهادات</a> 
       <?php }?>

        <h3 style="padding-right: 40px;"><span  style="color:brown">السنة الدراسية:</span>   <?php echo year_of_study($_GET['year']);?></h3>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  الفصل:</span>           <?php echo class_name($_GET['class']);?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  شهر:</span>             <?php echo $_GET['month'];?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  النوع:</span>           <?php  if($_GET['gender']!='الاثنين'){echo $_GET['gender'];}else{echo " ولاد / بنات";}?></h3> 
       
   

				   <div class="card"> 
                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                <?php if($totalRows_get_data>0){  ?>

                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                    <thead>
                      <tr>  
                        <th class="text-left">Name  </th> 
                        <th class="text-center">  ولي الامر  </th> 
                        <th class="text-center">  Code  </th> 

                        <?php if($totalRows_get_subject_header>0){
                          do{?>
                        <th class="text-center">   <?php echo $row_get_subject_header['name']."<br>".$row_get_subject_header['score'];?></th>  
                        <!--<th class="text-center">   <?php //echo  " Month <br>".$row_get_subject_header['month_score'];?></th>  -->
                        <?php if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_header['id']==337){ ?> 
                         <th class="text-center">  Total Math</th>  
                       <?php } ?>
                        <?php }while($row_get_subject_header = mysqli_fetch_assoc($get_subject_header)); 
                         }?>
                      <th class="text-center">  Total  </th> 
                      <th class="text-center">  HLS  </th> 
                      <th class="text-center" >اصدار \ إخفاء  </th> 
                      
                      </tr>
                    </thead>
                    <tbody>
						
					   	<?php do{ $total = 0; $hls = 0; ?>
                      <tr>  
                      <td class="text-left" style=" border:solid 1px black"><?php if($row_get_data['fn_name']==NULL){echo $row_get_data['name'];}else{echo $row_get_data['fn_name'];}?></td> 
                      <td class="text-center" style=" border:solid 1px black"><?php if($row_get_users_info['view_time']>0){ echo date('Y-m-d H:i:s',$row_get_users_info['view_time']) ;}?></td>  
                      <td class="text-center" style=" border:solid 1px black"><?php echo $row_get_data['ed_id'];?></td>   
                    
                      <?php 
                        mysqli_select_db($database, $database_database); 
                        $query_get_subject_result = "SELECT * FROM `subjects` WHERE `study_year` = '{$_GET['year']}' ORDER BY `id` asc  ";
                        $get_subject_result = mysqli_query($database,$query_get_subject_result) or die(mysqli_error($database));
                        $row_get_subject_result = mysqli_fetch_assoc($get_subject_result);
                        $totalRows_get_subject_result = mysqli_num_rows($get_subject_result); 
                        
                        if($totalRows_get_subject_result>0){
                          do{
                            mysqli_select_db($database, $database_database);  
                            $query_get_users_info = "SELECT * FROM `control` WHERE `kid_id` ='{$row_get_data['id']}' AND  `study_year`= '{$_GET['year']}' AND  `subject_id`='{$row_get_subject_result['id']}' AND `month`='{$_GET['month']}' AND `confirm` = 1   ";    
                            $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
                            $row_get_users_info = mysqli_fetch_assoc($get_users_info);
                            $totalRows_get_users_info = mysqli_num_rows($get_users_info);
                            
                            ?>
                              <td class="text-center"  style=" border:solid 1px gray; color:black; background-color: <?php if($row_get_users_info['ex_result']!=NULL){ if($row_get_users_info['publish']==1){ echo " aqua ";}else{echo "white";}  }else{echo "lightpink";}?>"><?php echo $row_get_users_info['ex_result']; if($row_get_subject_result['total']==1){ $total += $row_get_users_info['ex_result'];}  if($row_get_subject_result['h_total']==1){ $hls += $row_get_users_info['ex_result'];} ?> </td>  
                              <!--<td class="text-center"  style=" border:solid 1px gray"><?php //echo $row_get_users_info['month_result'];?>  </td> --> 

                              <?php 
                              if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_result['id']==336){ $Algebra = $row_get_users_info['ex_result']; } 
                              if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_result['id']==337){ $Geometry = $row_get_users_info['ex_result']; ?> 
                                <td class="text-center" style=" border:solid 1px black"><?php echo ($Algebra+$Geometry) ;$Algebra = 0; $Geometry = 0; ;?></td> 
                              <?php } ?>
                              
                      <?php  }while($row_get_subject_result = mysqli_fetch_assoc($get_subject_result)); 
                     }?> 
                         <td class="text-center" style=" border:solid 1px black"><?php echo $total;?></td>  
                         <td class="text-center" style=" border:solid 1px black"><?php echo ($hls+$total);?></td>  
                         <td class="text-center" style=" border:solid 1px black">
                          <a href="export-control.php?month=<?php echo $_GET['month'];?>&year=<?php echo $_GET['year'];?>&class=<?php echo $_GET['class'];?>&gender=<?php echo $_GET['gender'];?>&cert=<?php echo $row_get_data['id'];?>"  class="btn btn-primary  " style="background-color: blue; padding:2px" onclick="return confirm('تاكيد اصدار شهادة الشهر؟  ');"  >اصدار</a>
                          <a href="export-control.php?month=<?php echo $_GET['month'];?>&year=<?php echo $_GET['year'];?>&class=<?php echo $_GET['class'];?>&gender=<?php echo $_GET['gender'];?>&hide=<?php echo $row_get_data['id'];?>"  class="btn btn-primary  " style="padding:2px" onclick="return confirm('تاكيد سحب شهادة الشهر؟  ');"  >سحب</a>
                        </td>
                       
                      </tr>
                      <?php }while($row_get_data = mysqli_fetch_assoc($get_data));  ?> 
                     
                     
                    </tbody>
                  </table>
                  <?php }?>
                </div>
              </div>
				</div>
      </div> 
      <?php }?>
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
  buttons: [
    {
      extend: 'csvHtml5',
      text: 'CSV',
      filename: 'classes',
      fieldSeparator: ',',
      charset: 'utf-8',
      bom: true,
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },
    {
      extend: 'excelHtml5',
      text: 'Excel',
      filename: 'classes',
      bom: true,
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },
    {
      extend: 'print',
      text: 'طباعة',
      exportOptions: {
        columns: [0, 1]
      }
    }
  ],
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
  ]  
});
     
   
            

        $("#study_year").change(function(){
        var year = $(this).val(); 
 
        $.post("get_class2.php",
            {
                year:year
            },
                function(Date,status){  
                    $("#class").html(Date);   
            });  
            
    });


 



  






	  });
    </script>
    
  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>