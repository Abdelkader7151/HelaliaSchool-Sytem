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
                <h4>       طباعة الرجستر </h4>
            </div>
          </div>
			<div class="row">
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="export-monthly.php" method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                     

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

             
                  
            mysqli_select_db($database, $database_database);  
            $query_get_data = "SELECT * FROM `kids` WHERE   `class` = '{$_GET['class']}' ";    
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
     
        ?>
      	<div class="row">
				<div class="col-md-12">     

        <?php  if($row_get_login['access23sub4']==1){?>
            <button  class="btn btn-primary btn-block" style=" width: 100px; margin-right:30px; float:left" onClick="printdiv('printable_div_id');">طباعة <i class="fa fa-print" aria-hidden="true"></i></button> 
            
       <?php }?>

        <h3 style="padding-right: 40px;"><span  style="color:brown">السنة الدراسية:</span>   <?php echo year_of_study($_GET['year']);?></h3>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  الفصل:</span>           <?php echo class_name($_GET['class']);?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  شهر:</span>             <?php echo $_GET['month'];?></h3>
        
        
   

			 <div class="card" id="printable_div_id" style=" width: 100%; font-size: 12px;"> 
                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                    
                      <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left;" ><img src="img/logo.png" width="50px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

           



                <table  class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px ">
                    <thead>
                        <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; width: 100x;  font-size: 16px;" >Name   </td>
                            <td colspan="11" style="text-align: center;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
                                    echo $dateObj->format('F'); ?>
                            </td>
                        </tr>
                        <tr> 
                            <th class="text-center">كراسة <br>الحصة </th>  
                            <th class="text-center">كراسة <br>الواجب </th>  
                            <th class="text-center">كراسة <br>النشاط </th>  
                            <th class="text-center">التقييم<br> 1 </th>  
                            <th class="text-center">التقييم<br> 2 </th>  
                            <th class="text-center">التقييم<br> 3 </th>  
                            <th class="text-center">التقييم<br> 4 </th>  
                            <th class="text-center"> المهام <br>الشفهية </th>  
                            <th class="text-center"> المهام<br> المهارية </th>  
                            <th class="text-center"> الحضور <br>والمواظبة </th>  
                            <th class="text-center"> المجموع </th>   
                       </tr>
                       <tr>  
                            <th class="text-center">20</th>  
                            <th class="text-center">20</th>  
                            <th class="text-center">20</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">10</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">5</th>  
                            <th class="text-center">100</th>   
                       </tr>
                    </thead>
                    <tbody>  
                     <?php if($totalRows_get_data>0){
                            $i=1; do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black"><?php echo $i;?></td>
                            <td class="text-left" style=" border:solid 1px black; width: 100px"><?php echo $row_get_data['fn_name'];?></td> 
                            
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>    
                        </tr>
                     <?php $i++;}while($row_get_data = mysqli_fetch_assoc($get_data));}?>  
                    </tbody>
                  </table>
                  
                </div>



                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                    
                      <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left;" ><img src="img/logo.png" width="50px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

           
                         <?php  
                            $z = 0;
                            $days = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                        for($i=1;$i<=$days;$i++){
                            if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){ $z++; } }?>


                <table  class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px ">
                    <thead>
                        <tr>
                            <td rowspan="2" style="text-align: center; vertical-align: middle; font-size: 16px;" >م  </td>
                            <td rowspan="2" style="text-align: center; vertical-align: middle; width: 100x;  font-size: 16px;" >Name   </td>
                            <td colspan="<?php echo $z;?>" style="text-align: center;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
                                    echo $dateObj->format('F'); ?>  غياب شهر 
                            </td>
                        </tr> 
                       <tr>  
                         <?php  
                            $days = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                        for($i=1;$i<=$days;$i++){
                           if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center"><?php echo $i;?></th> 
                         <?php } }?>  
                       </tr>
                    </thead>
                    <tbody>  
                     <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_data = "SELECT * FROM `kids` WHERE   `class` = '{$_GET['class']}' ";    
                        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                        $row_get_data = mysqli_fetch_assoc($get_data);
                        $totalRows_get_data = mysqli_num_rows($get_data);
            
            if($totalRows_get_data>0){
                            $x=1; do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black"><?php echo $x;?></td>
                            <td class="text-left" style=" border:solid 1px black; width: 100px"><?php echo $row_get_data['fn_name'];?></td>  
                           <?php  
                            $days = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                            for($i=1;$i<=$days;$i++){
                            if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){?>
                            <td class="text-center"></td> 
                          <?php } }?>    
                        </tr>
                     <?php $x++;}while($row_get_data = mysqli_fetch_assoc($get_data));}?>  
                    </tbody>
                  </table>
                  
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
        function printdiv(elem) {
        var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
        var footer_str = '</body></html>';
        var new_str = document.getElementById(elem).innerHTML;
        var old_str = document.body.innerHTML;
        document.body.innerHTML = header_str + new_str + footer_str;
        window.print();
        document.body.innerHTML = old_str;
        return false;
        }
        
	  $(document).ready(function(){  


        

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