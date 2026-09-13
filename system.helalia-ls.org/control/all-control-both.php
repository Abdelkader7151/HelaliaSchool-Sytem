<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub2']==1){

 

$head_title = "  الكنترول";
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
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
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
                    <form action="all-control.php" method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     

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
            $query_get_subject_header = "SELECT * FROM `subjects` WHERE `study_year`= '{$_GET['year']}'  ORDER BY `id` asc  ";
            $get_subject_header = mysqli_query($database,$query_get_subject_header) or die(mysqli_error($database));
            $row_get_subject_header = mysqli_fetch_assoc($get_subject_header);
            $totalRows_get_subject_header = mysqli_num_rows($get_subject_header); 

          
        

        ?>
      	<div class="row">
				<div class="col-md-12">     
        <h3 style="padding-right: 40px;"><span  style="color:brown">السنة الدراسية:</span>   <?php echo year_of_study($_GET['year']);?></h3>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  الفصل:</span>           <?php echo class_name($_GET['class']);?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  شهر:</span>             <?php echo $_GET['month'];?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  النوع:</span>           <?php  if($_GET['gender']!='الاثنين'){echo $_GET['gender'];}else{echo " ولاد / بنات";}?></h3> 
       <input type="hidden" id="month" value="<?php echo $_GET['month'];?>" />
       
				   <div class="card"> 
                <div class="card-body" data-toggle="match-height" style="overflow-x:auto;  "  >
                <?php if($totalRows_get_data>0){  ?>

                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr>  
                        <th class="text-left">Name  </th> 
                        <th class="text-center">  Code  </th> 
                        <th class="text-center">  Class  </th> 

                        <?php if($totalRows_get_subject_header>0){
                          do{?>
                       
                       <th class="text-center">   <?php echo $row_get_subject_header['name']." -1- <br>".$row_get_subject_header['score'];?></th>  
                       <th class="text-center">   <?php echo $row_get_subject_header['name']." -2- <br>".$row_get_subject_header['score'];?></th>  
                       <?php if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_header['id']==337){ ?> 
                         <th class="text-center">  Total Math</th>  
                       <?php } ?>
                        <!--<th class="text-center">   <?php //echo  " Month <br>".$row_get_subject_header['month_score'];?></th>  -->
                        <?php }while($row_get_subject_header = mysqli_fetch_assoc($get_subject_header)); 
                         }?>
                         <th class="text-center">  Total  </th> 
                        <th class="text-center">  HLS  </th> 
                        <?php if($row_get_login['access23sub3']==1){ ?>
                        <th class="text-center" width="50" >تاكيد   <input type="checkbox" style="text-align: center;" id="confirm" value="1"  ></th>   
                        <?php }?>
                        
                      </tr>
                    </thead>
                    <tbody>
						
					   	<?php do{  $total = 0; $hls = 0; ?>
                      <tr>  
                      <td class="text-left" style=" border:solid 1px black"><?php if($row_get_data['fn_name']==NULL){echo $row_get_data['name'];}else{echo $row_get_data['fn_name'];}?></td> 
                      <td class="text-center" style=" border:solid 1px black"><?php echo $row_get_data['ed_id'];?></td>  
                      <td class="text-center" style=" border:solid 1px black"><?php echo class_name($row_get_data['class']);?></td>  
                    
                      <?php 
                        mysqli_select_db($database, $database_database); 
                        $query_get_subject_result = "SELECT * FROM `subjects` WHERE `study_year` = '{$_GET['year']}' ORDER BY `id` asc  ";
                        $get_subject_result = mysqli_query($database,$query_get_subject_result) or die(mysqli_error($database));
                        $row_get_subject_result = mysqli_fetch_assoc($get_subject_result);
                        $totalRows_get_subject_result = mysqli_num_rows($get_subject_result); 
                        
                        if($totalRows_get_subject_result>0){
                            $Algebra = 0;
                            $Geometry = 0;
                          do{
                            
                            mysqli_select_db($database, $database_database);  
                            $query_get_users_info = "SELECT * FROM `control` WHERE `kid_id` ='{$row_get_data['id']}' AND  `study_year`= '{$_GET['year']}' AND  `subject_id`='{$row_get_subject_result['id']}' AND   `month`= 3     ";    
                            $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
                            $row_get_users_info = mysqli_fetch_assoc($get_users_info);
                            $totalRows_get_users_info = mysqli_num_rows($get_users_info);

                             mysqli_select_db($database, $database_database);  
                            $query_get_users_info2 = "SELECT * FROM `control` WHERE `kid_id` ='{$row_get_data['id']}' AND  `study_year`= '{$_GET['year']}' AND  `subject_id`='{$row_get_subject_result['id']}' AND   `month`= 4     ";    
                            $get_users_info2 = mysqli_query($database,$query_get_users_info2) or die(mysqli_error($database));
                            $row_get_users_info2 = mysqli_fetch_assoc($get_users_info2);
                            $totalRows_get_users_info2 = mysqli_num_rows($get_users_info2);

                            ?> 
                              <td class="text-center <?PHP if($row_get_users_info['ex_result']!=NULL ){echo " ex_result_".$row_get_data['id'];}?>"  style=" border:solid 1px gray; <?php if($row_get_users_info['confirm']==1){echo " background-color:aquamarine ";}?>"><?php   echo $row_get_users_info['ex_result'];  if($row_get_subject_result['total']==1){ $total += $row_get_users_info['ex_result'];}  if($row_get_subject_result['h_total']==1){ $hls += $row_get_users_info['ex_result'];} ?> </td>  
                              <td class="text-center <?PHP if($row_get_users_info2['ex_result']!=NULL){echo " ex_result_".$row_get_data['id'];}?>"  style=" border:solid 1px gray; <?php if($row_get_users_info2['confirm']==1){echo " background-color:aquamarine ";}?>"><?php  echo $row_get_users_info2['ex_result'];  if($row_get_subject_result['total']==1){ $total += $row_get_users_info2['ex_result'];}  if($row_get_subject_result['h_total']==1){ $hls += $row_get_users_info2['ex_result'];} ?> </td>  
                                <!--<td class="text-center"  style=" border:solid 1px gray"><?php //echo $row_get_users_info['month_result'];?>  </td>  -->
                              <?php 
                              if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_result['id']==336){ $Algebra = ($row_get_users_info['ex_result']=$row_get_users_info2['ex_result']); } 
                              if(isset($_GET['year']) && $_GET['year']==100 && $row_get_subject_result['id']==337){ $Geometry = ($row_get_users_info['ex_result']+$row_get_users_info2['ex_result']); ?> 
                                <td class="text-center" style=" border:solid 1px black"><?php echo ($Algebra+$Geometry) ;$Algebra = 0; $Geometry = 0; ;?></td> 
                              <?php } ?>
                                
                        
                        <?php }while($row_get_subject_result = mysqli_fetch_assoc($get_subject_result)); 
                         }?>



                      <td class="text-center" style=" border:solid 1px black"><?php echo $total;?></td>  
                        <td class="text-center" style=" border:solid 1px black"><?php echo ($hls+$total);?></td>  
                      <?php  if($row_get_login['access23sub3']==1){ ?>
                         <td class="text-center"><input type="checkbox" style="text-align: center;" id="confirm_<?php echo $row_get_data['id'];?>" class="confirm"  value="1"   ></td>     
                        <?php }?>
                       
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
    
      
    <i class="fa fa-spinner fa-spin fa-5x fa-fw" style="position: fixed; top:45%; right:51%; color:blue; display:none  " id="loading"></i>
 
	  
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


 



    <?php if($row_get_login['access23sub3']==1){ ?>





$("#confirm").click(function(){   
      $("#loading").fadeIn();  
 
          $(".confirm").each(function(){  
              $(this).prop( "checked", true );   
              var myId = $(this).prop("id");  
              var id = myId.replace("confirm_", "");  
              var month = $("#month").val();   
                 $.post("update_ex_result_confirm_all.php",
                      {
                        id:id,
            month:month 
                      },
                      function(Date,status){   
                        $(".ex_result_"+id).css("background-color","aquamarine");
                  });
                 
          });

          $("#loading").fadeOut();   
         
    }); 




  $(".confirm").click(function(){  
      $("#loading").fadeIn();    
      var myId = $(this).prop("id");  
      var id = myId.replace("confirm_", "");    
      var month = $("#month").val();
      $.post("update_ex_result_confirm_all.php",
          {
            id:id,
            month:month 
          },
          function(Date,status){  
            $(".ex_result_"+id).css("background-color","aquamarine");
            $("#loading").fadeOut();  
      });
        
  });

<?php }?>

  






	  });
    </script>
    
  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>