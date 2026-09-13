<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub5']==1){


    if(isset($_GET['from'])){ 

        $from = strtotime($_GET['from']);
        $to = strtotime($_GET['to']);

        mysqli_select_db($database, $database_database);    
        if(isset($_GET['class']) && $_GET['class']>0){
          $query_get_data = "SELECT * FROM `kids` WHERE  `study_year` = '{$_GET['study_year']}' AND `class` = '{$_GET['class']}' order by `id` asc";
        }else{
          $query_get_data = "SELECT * FROM `kids` WHERE  `study_year` = '{$_GET['study_year']}' order by `id` asc";
        }
        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
        $row_get_data = mysqli_fetch_assoc($get_data);
        $totalRows_get_data = mysqli_num_rows($get_data);
        
   }

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
                    <form   method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                      
					 
             
            <div class="form-group">
              <label class="col-sm-2 control-label" for="from">     من تاريخ   <span style="color: red;">*</span></label>
              <div class="input-group date col-sm-2">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-1-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-1" class="form-control" type="text" name="from"  required >
                </div> 
            </div> 
                   

            <div class="form-group">
              <label class="col-sm-2 control-label" for="to">     الي تاريخ   <span style="color: red;">*</span></label>
              <div class="input-group date col-sm-2">
                  <span class="input-group-btn">
                    <button id="demo-datepicker-2-btn" class="btn btn-primary" type="button">
                      <span class="icon icon-calendar"></span>
                    </button>
                  </span>
                  <input id="demo-datepicker-2" class="form-control" type="text" name="to" required  >
                </div> 
            </div> 
                   
             
            <div class="form-group">
						<label class="col-sm-2 control-label" for="study_year"> المرحلة  <span style="color: red;">*</span></label>
						<div class="col-sm-3">
                <select class="form-control" required name="study_year" id="study_year"    >
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

            <div class="form-group" style="display: none" id="class_box">
						<label class="col-sm-2 control-label" for="class" id="class_box"> الفصل  <span style="color: red;">*</span></label>
						<div class="col-sm-3">
                            <select class="form-control" name="class" id="class" required   >
                                <option selected value="" >...</option>  
                            </select>
						</div>
            </div>
						

						<div class="form-group">
						 <label class="col-sm-2 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block" id="submit" >بحث</button> 
						 </div> 
					  </div> 
					    
					 
					</form>
				  </div>
				</div>
		    </div>
           


          <?php  if(isset($_GET['from'])){?>
			<div class="row">  
              <div class="col-md-12">        
              <div class="col-sm-3"><h3>السنة الدراسية <?php 
                    if(date("m",time())>8){echo date("Y",time())." - ".date('Y', strtotime('+1 year'));}      
                    if(date("m",time())<9){echo date('Y', strtotime('-1 year')." - ".date("Y",time()));} ?> </h3></div>
                <div class="col-sm-3"><h3>المرحلة: <?php echo year_of_study($_GET['study_year']);?></h3> </div>
                <div class="col-sm-3"><h3>التاريخ من:  <?php echo date("d/m/Y",strtotime($_GET['from']));?></h3> </div>
                <div class="col-sm-3"><h3>التاريخ الي:  <?php echo date("d/m/Y",strtotime($_GET['to']));?></h3> </div>

                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"   >الكود  </th> 
                        <th class="text-center">رقم الكشف</th>
                        <th class="text-center">الاسم</th>
                        <th class="text-center">  الفصل</th>  
                        <th class="text-center">  عدد ايام الغياب</th>  
                        <th class="text-center">  ايام الغياب</th> 
                        <th class="text-center">  ايام الغياب المبرر</th> 
                        <th class="text-center">  ايام الغياب المقبولة</th> 
                        <th class="text-center"> ملاحظات</th> 
                      </tr>
                    </thead>
                    <tbody>
						
					 <?php if($totalRows_get_data>0){
                        $id = 1;
                        $absence = 0;
                              do{ 
                                mysqli_select_db($database, $database_database);   
                                $query_get_absence = "SELECT * FROM `kids-absence` WHERE `kid_id` = '{$row_get_data['id']}' AND `date`>='{$from}' AND `date`<'{$to}' ORDER BY `id` asc  ";   
                                $get_absence = mysqli_query($database,$query_get_absence) or die(mysqli_error($database));
                                $row_get_absence = mysqli_fetch_assoc($get_absence);
                                $totalRows_get_absence = mysqli_num_rows($get_absence);
                                ?>
                        <tr class="count"> 
                             <td class="text-center"><?php echo $row_get_data['id'];?></td>  
                             <td class="text-center"><?php echo $id;?></td>  
                             <td class="text-center"><?php echo $row_get_data['name'];?></td>  
                             <td class="text-center"><?php echo class_name($row_get_data['class']);?></td>  
                             <td class="text-center"><?php echo $totalRows_get_absence; $total = $totalRows_get_absence;?></td>    
                             <td class="text-center"><?php if($totalRows_get_absence>0){
                              $accept = 0;
                              $absence = 0;
                                 do{
                                   echo date("d/m/Y",$row_get_absence['date'])."<br>"; 
                                   if($row_get_absence['accept']==1){$accept++;}
                                   if(vacation_check($row_get_absence['date'],$row_get_absence['kid_id'])==1){$absence++;}
                                }while($row_get_absence = mysqli_fetch_assoc($get_absence)); } ?>
                            </td>    
                            <td class="text-center"><?php echo  $absence ;?></td> 
                            <td class="text-center"><?php echo  $accept ;?></td> 
                            <td class="text-center"> </td> 
                             
                        </tr>
                      <?php $id++; }while($row_get_data = mysqli_fetch_assoc($get_data));} ?>   
                    </tbody>
                  </table>


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

      $('#demo-inputmask').on('change', '#study_year', function (event) {    
        var year = $(this).val();
        if(year<15){
          $("#class_box").fadeIn();
           $.post("get_class2.php",
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


		$("#court-datatables").DataTable({ 
            paging: false,
            dom: 'Bfrtip', 
            buttons: [
            {
                extend: 'print',
                messageTop: " <h3>عدد ايام غياب الطالبات</h3><h4>السنة الدراسية 2023-2024  المرحلة: <?php echo year_of_study($_GET['study_year']);?> التاريخ من:  <?php echo date('d/m/Y',strtotime($_GET['from']));?> التاريخ الي:  <?php echo date('d/m/Y',strtotime($_GET['to']));?></h4> "
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
                [1, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false 
			       
			   }
			 ]
        }); 
          
         
        



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>