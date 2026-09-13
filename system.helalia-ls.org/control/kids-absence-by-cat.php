<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub5']==1){


    if(isset($_POST['from'])){ 

        $from = strtotime($_POST['from']);
        $to = strtotime($_POST['to']);
        if($_POST['study_year']!=20){
            mysqli_select_db($database, $database_database);    
            if($_POST['study_year']<15){
            $query_get_data = "SELECT * FROM `kids-absence` WHERE `study_year` = '{$_POST['study_year']}'  AND `date`>='{$from}' AND `date`<'{$to}'  ";
            }else{
                if($_POST['study_year']==16){ $query_get_data = "SELECT *  FROM `kids-absence` WHERE `study_year` < 3  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                if($_POST['study_year']==17){ $query_get_data = "SELECT *  FROM `kids-absence` WHERE `study_year` > 2  AND `study_year` < 9  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                if($_POST['study_year']==18){ $query_get_data = "SELECT *  FROM `kids-absence` WHERE `study_year` > 8  AND `study_year` < 12  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                if($_POST['study_year']==19){ $query_get_data = "SELECT *  FROM `kids-absence` WHERE `study_year` > 11 AND `study_year` < 15  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                 
            }
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
        }
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
                <h4>عرض غياب المراحل       </h4>  
            </div>
          </div>
         

          <div class="row">
				<div class="col-md-12">
				  <div class="demo-form-wrapper">
                    <form   method="post" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
 
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
                      <option value="16">  رياض الاطفال</option> 
                      <option value="1">اولى حضانة</option> 
                      <option value="2">ثانية حضانة</option> 
                     
                      <option value="17">  الصف   الابتدائى</option> 
                      <option value="3">  الصف الاول الابتدائى</option> 
                      <option value="4">  الصف الثانى الابتدائى</option> 
                      <option value="5">  الصف الثالث الابتدائى</option> 
                      <option value="6">  الصف الرابع الابتدائى</option> 
                      <option value="7">  الصف الخامس الابتدائى</option> 
                      <option value="8">  الصف السادس الابتدائى</option> 
                      
                      <option value="18">  الصف   الاعدادى</option> 
                      <option value="9">  الصف الاول الاعدادى</option> 
                      <option value="10">  الصف الثاني الاعدادى</option> 
                      <option value="11">  الصف الثالث الاعدادى</option> 
                     
                      <option value="19">  الصف   الثانوى</option> 
                      <option value="12">  الصف الاول الثانوى</option> 
                      <option value="13">  الصف الثاني الثانوى</option> 
                      <option value="14">  الصف الثالث الثانوى</option> 

                      <option value="20">     جميع الصفوف</option>  

                </select>
						</div>
            </div>
 		

						<div class="form-group">
						 <label class="col-sm-2 control-label" for="submit"> </label>
						 <div class="col-sm-2"> 
						    <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit" >بحث</button> 
						 </div> 
					  </div> 
					    
					 
					</form>
				  </div>
				</div>
		    </div>
           


          <?php  if(isset($_POST['from'])){?>
			<div class="row">  
              <div class="col-md-12">     
                <div class="col-sm-3"><h3>السنة الدراسية <?php 
                    if(date("m",time())>8){echo date("Y",time())." - ".date('Y', strtotime('+1 year'));}      
                    if(date("m",time())<9){echo date('Y', strtotime('-1 year')." - ".date("Y",time()));} ?> </h3></div>
                <div class="col-sm-3"><h3>المرحلة: <?php echo year_of_study($_POST['study_year']);?></h3> </div>
                <div class="col-sm-3"><h3>التاريخ من:  <?php echo date("d/m/Y",strtotime($_POST['from']));?></h3> </div>
                <div class="col-sm-3"><h3>التاريخ الي:  <?php echo date("d/m/Y",strtotime($_POST['to']));?></h3> </div>

                <div class="card-body" data-toggle="match-height"  > 
                <table  class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left" >المرحلة  </th> 
                        <th class="text-center"> مقيد</th>
                        <th class="text-center">حاضر</th>
                        <th class="text-center"> غائب</th>   
                      </tr>
                    </thead>
                    <tbody>
						
					 <?php if($_POST['study_year']<20){
                        if($totalRows_get_data>0 ){
                         
                               
                                mysqli_select_db($database, $database_database);  
                                if($_POST['study_year']<15){
                                    $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` = '{$_POST['study_year']}'     ";
                                  }else{
                                      if($_POST['study_year']==16){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` < 3 ";  }
                                      if($_POST['study_year']==17){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 2  AND `study_year` < 9   ";  }
                                      if($_POST['study_year']==18){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 8 AND `study_year` < 12 ";  }
                                      if($_POST['study_year']==19){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 11 AND `study_year` < 15 ";  } 
                                  } 
                                $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
                                $row_get_kids = mysqli_fetch_assoc($get_kids);
                                $totalRows_get_kids = mysqli_num_rows($get_kids);
                                ?>
                        <tr class="count"> 
                             <td class="text-center"><?php echo year_of_study($_POST['study_year']);?></td>  
                             <td class="text-center"><?php echo $totalRows_get_kids;?></td>   
                             <td class="text-center"><?php echo ($totalRows_get_kids-$totalRows_get_data) ;?></td>  
                             <td class="text-center"><?php echo $totalRows_get_data ;?></td>   
                        </tr>
                      <?php  }}


                      
                      if(isset($_POST['study_year']) && $_POST['study_year']==20){   

                        for($i=16;$i<20;$i++){ 
                            mysqli_select_db($database, $database_database);   
                            if($i==16){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` < 3 ";  }
                            if($i==17){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 2  AND `study_year` < 9   ";  }
                            if($i==18){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 8 AND `study_year` < 12 ";  }
                            if($i==19){ $query_get_kids = "SELECT * FROM `kids` WHERE `study_year` > 11 AND `study_year` < 15 ";  } 
                            $get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
                            $row_get_kids = mysqli_fetch_assoc($get_kids);
                            $totalRows_get_kids = mysqli_num_rows($get_kids);

                            if($i==16){ $query_get_data = "SELECT * FROM `kids-absence` WHERE `study_year` < 3  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                            if($i==17){ $query_get_data = "SELECT * FROM `kids-absence` WHERE `study_year` > 2  AND `study_year` < 9  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                            if($i==18){ $query_get_data = "SELECT * FROM `kids-absence` WHERE `study_year` > 8  AND `study_year` < 12  AND `date`>='{$from}' AND `date`<'{$to}'  ";  }
                            if($i==19){ $query_get_data = "SELECT * FROM `kids-absence` WHERE `study_year` > 11 AND `study_year` < 15  AND `date`>='{$from}' AND `date`<'{$to}'  ";  } 
                            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                            $row_get_data = mysqli_fetch_assoc($get_data);
                            $totalRows_get_data = mysqli_num_rows($get_data);

                            ?>
                    <tr class="count"> 
                         <td class="text-center"><?php echo year_of_study($i);?> </td>  
                         <td class="text-center"><?php echo $totalRows_get_kids; $totalRows_get_kids_total += $totalRows_get_kids;?></td>   
                         <td class="text-center"><?php echo ($totalRows_get_kids-$totalRows_get_data); $attend +=($totalRows_get_kids-$totalRows_get_data);?></td>  
                         <td class="text-center"><?php echo $totalRows_get_data; $totalRows_get_data_total +=$totalRows_get_data;?></td>   
                    </tr>
                  <?php }?>
                  <tr class="count"> 
                         <th class="text-center">اجمالي</th>  
                         <th class="text-center"><?php echo $totalRows_get_kids_total;?></th>   
                         <th class="text-center"><?php echo $attend ;?></th>  
                         <th class="text-center"><?php echo $totalRows_get_data_total;?></th>   
                    </tr>
                    <?php }?>                    
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
                messageTop: " <h3>عدد ايام غياب الطالبات</h3><h4>السنة الدراسية 2023-2024  المرحلة: <?php echo year_of_study($_POST['study_year']);?> التاريخ من:  <?php echo date('d/m/Y',strtotime($_POST['from']));?> التاريخ الي:  <?php echo date('d/m/Y',strtotime($_POST['to']));?></h4> "
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