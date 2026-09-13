<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access17sub2']==1){

    $study_year = '';

if(isset($_GET['id']) ){ 
  $id = GetSQLValueString($database,$_GET['id'], "int"); 
  $study_year = " AND `study_year` = '{$id}' ";
}


if(isset($_POST['send_rest'])){

  mysqli_select_db($database, $database_database);  
  $query_get_accounting_info = "SELECT * FROM `kids_accounting` WHERE `rest` >0 $study_year order by `name` asc  "; 
  $get_accounting_info = mysqli_query($database,$query_get_accounting_info) or die(mysqli_error($database));
  $row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info);
  $totalRows_get_accounting_info = mysqli_num_rows($get_accounting_info);

  do{
      if($row_get_accounting_info['rest']>0 && $row_get_accounting_info['rest']!=850 && $row_get_accounting_info['rest']!=6800 && $_POST['send_rest_'.$row_get_accounting_info['id']]==$row_get_accounting_info['id']){  
       
        $query_get_target = "SELECT `kids`.linked AS `linked`, `kids`.class AS `class`, `kids`.id AS `kid_id`, `kids_list`.parent_id AS `parent_id`,  `app_login`.phone_id  AS `phone_id`, `app_login`.id  AS `app_login_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `kids_list`.parent_id =  `app_login`.id  WHERE `kids`.linked = 1 AND `kids`.id = '{$row_get_accounting_info['kid_id']}'   ";
        $get_target = mysqli_query($database,$query_get_target) or die(mysqli_error($database));
        $row_get_target = mysqli_fetch_assoc($get_target);
        $totalRows_get_target = mysqli_num_rows($get_target); 

        if($row_get_target['linked']==1 && $row_get_target['app_login_id']>0){

          $insertSQL1 = sprintf("INSERT INTO `notifications` ( `title`, `user_id`, `kid_id`, `class`, `text`, `date`, `type`, `emp_id`) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)", 
                    GetSQLValueString($database," HLS Accounting Department", "text"),
                    GetSQLValueString($database,$row_get_target['app_login_id'], "int"),
                    GetSQLValueString($database,$row_get_target['kid_id'], "int"),
                    GetSQLValueString($database,$row_get_target['class'], "int"),
                    GetSQLValueString($database,"Accounting Department,<pre style='white-space:pre-wrap'> رجاء سداد مستحقات بقيمة ".$row_get_accounting_info['rest']." جنية على الطالب   في  اقرب وقت ممكن </pre>", "text"),
                    GetSQLValueString($database,time(), "int"),
                    GetSQLValueString($database,6, "int"),
                    GetSQLValueString($database,$row_get_login['id'], "int"));

          if($row_get_target['parent_id']!=NULL){    
           $Result1 = mysqli_query($database,$insertSQL1) or die(mysqli_error($database)); 

            sendMessage($row_get_target['phone_id']," HLS Accounting Department",str_replace("<br>","","  رجاء سداد مستحقات بقيمة ".$row_get_accounting_info['rest']." جنية على الطالب ".$row_get_accounting_info['name']."  في اقرب وقت ممكن  "));

 
            $insertSQL2 = sprintf("INSERT INTO `payment_notification` (`kid_id`, `msg`, `sent_date`, `rest`, `emp_id`) VALUES (%s, %s, %s, %s, %s)",
                        GetSQLValueString($database,$row_get_target['kid_id'], "int"),
                        GetSQLValueString($database,"رجاء سداد مستحقات بقيمة ".$row_get_accounting_info['rest']." جنية على الطالب ".$row_get_accounting_info['name']."  في اقرب وقت ممكن  ", "text"),
                        GetSQLValueString($database,time(), "int"), 
                        GetSQLValueString($database,$row_get_accounting_info['rest'], "double"), 
                        GetSQLValueString($database,$row_get_login['id'], "int"));
            
            mysqli_query($database,$insertSQL2) or die(mysqli_error($database));   

          }  

        }
      }
    }while($row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info)); 
}




mysqli_select_db($database, $database_database);  
$query_get_accounting_info = "SELECT * FROM `kids_accounting` WHERE `rest` > 0 $study_year ORDER BY `name` ASC  "; 
$get_accounting_info = mysqli_query($database,$query_get_accounting_info) or die(mysqli_error($database));
$row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info);
$totalRows_get_accounting_info = mysqli_num_rows($get_accounting_info);






$head_title = "  حسابات  ";
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
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
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
                <h4>عرض   تحصيلات   </h4>
            </div>
          </div>


          <div class="row"> 
				<div class="col-md-8">
				  <div class="demo-form-wrapper">
                    <form action="acc-view-report1.php" method="get" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
					   
             
            <div class="form-group">
						<label class="col-sm-3 control-label" for="id"> المرحلة  </label>
						<div class="col-sm-4">
                <select class="form-control" name="id"  id="id"  required >
                      <option     >...</option>  
                      <option value="0" <?php if(isset($_GET['id']) && $_GET['id']==0){ echo " selected ";}?> >   بري سكول</option> 
                      <option value="1" <?php if(isset($_GET['id']) && $_GET['id']==1){ echo " selected ";}?> > اولى حضانة</option> 
                      <option value="2" <?php if(isset($_GET['id']) && $_GET['id']==2){ echo " selected ";}?> > ثانية حضانة</option> 
                      <option value="3" <?php if(isset($_GET['id']) && $_GET['id']==3){ echo " selected ";}?> >  الصف الاول الابتدائى</option> 
                      <option value="4" <?php if(isset($_GET['id']) && $_GET['id']==4){ echo " selected ";}?> >  الصف الثانى الابتدائى</option> 
                      <option value="5" <?php if(isset($_GET['id']) && $_GET['id']==5){ echo " selected ";}?> >  الصف الثالث الابتدائى</option> 
                      <option value="6" <?php if(isset($_GET['id']) && $_GET['id']==6){ echo " selected ";}?> >  الصف الرابع الابتدائى</option> 
                      <option value="7" <?php if(isset($_GET['id']) && $_GET['id']==7){ echo " selected ";}?> >  الصف الخامس الابتدائى</option> 
                      <option value="8" <?php if(isset($_GET['id']) && $_GET['id']==8){ echo " selected ";}?> >  الصف السادس الابتدائى</option> 
                      <option value="9" <?php if(isset($_GET['id']) && $_GET['id']==9){ echo " selected ";}?> >  الصف الاول الاعدادى</option> 
                      <option value="10" <?php if(isset($_GET['id']) && $_GET['id']==10){ echo " selected ";}?> >  الصف الثاني الاعدادى</option> 
                      <option value="11" <?php if(isset($_GET['id']) && $_GET['id']==11){ echo " selected ";}?> >  الصف الثالث الاعدادى</option> 
                      <option value="12" <?php if(isset($_GET['id']) && $_GET['id']==12){ echo " selected ";}?> >  الصف الاول الثانوى</option> 
                      <option value="13" <?php if(isset($_GET['id']) && $_GET['id']==13){ echo " selected ";}?> >  الصف الثاني الثانوى</option> 
                      <option value="14" <?php if(isset($_GET['id']) && $_GET['id']==14){ echo " selected ";}?> >  الصف الثالث الثانوى</option>  
                </select>
						</div>

           </div> 
                       

 


						<div class="form-group"> 
						    <div class="col-sm-2 col-sm-offset-3"> 
                  <button type="submit" class="btn btn-primary btn-block"    ><i class="fa fa-refresh" aria-hidden="true"></i> عرض</button> 
                </div>  
                    
	 
          </div> 
 	
					</form>
				  </div>
        </div> 
		    </div>
 
       <div class="row">
				<div class="col-md-12">
				   <div class="card"> 

            <h3 style="padding-right: 50px;"><?php if(isset($_GET['id'])){echo year_of_study($_GET['id']);}else{echo " جميع المراحل";} ?></h3>

             <div class="card-body table" data-toggle="match-height" >
             <form action="acc-view-report1.php<?php if(isset($_GET['id'])){echo "?id=".$_GET['id'];}?>" method="POST" name="form2" id="form2" enctype="multipart/form-data" class="form form-horizontal ">
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 14px">
                    <thead>
                      <tr> 
                        <th class="text-left"  >الاسم </th> 
                        <th class="text-center">الرقم التعليمي </th>  
                        <th class="text-center">  المرحله </th>  
                        <th class="text-center">   التعليم </th>  
                        <th class="text-center">   نشاط</th>  
                        <th class="text-center">   الباص </th>
                        <th class="text-center">   الزي </th>
                        <th class="text-center"> كتب وزاري   </th> 
                        <th class="text-center">   الزي الاضافي </th>
                        <th class="text-center"> حاسب الي </th>  
                        <th class="text-center"> كامبريدج وابليكشن </th>    
                        <th class="text-center"> تكنوكيدز </th>    
                        <th class="text-center"> كورس/استضافة </th>    
                        <th class="text-center"> الاجمالي</th>     
                        <th class="text-center"> رسوم تسجيل</th>     
                        <th class="text-center"> اجمالي التعليم</th>     
                        <th class="text-center"> مستحقات</th>     
                        <th class="text-center"> اخطار <?php if(  $row_get_login['access17sub3']==1){?><input type="checkbox" id="check_all" /><?php }?></th>     
                      </tr>
                    </thead>
                    <tbody>  
						<?php if($totalRows_get_accounting_info>0){
	                           do{ if($row_get_accounting_info['rest']>0 && $row_get_accounting_info['rest']!=850 && $row_get_accounting_info['rest']!=6800){ 
                              
                              mysqli_select_db($database, $database_database); 
                              $query_get_kid_info = "SELECT `linked` FROM `kids` where `id`='{$row_get_accounting_info['kid_id']}'  ";
                              $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
                              $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
                              $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);
                              ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_accounting_info['name'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['ed_id'];?></td>  
                        <td class="text-center"><?php echo year_of_study($row_get_accounting_info['study_year']);?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['ed_fees'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['activity'];?></td>    
                        <td class="text-center"><?php echo $row_get_accounting_info['bus'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['uniform1'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['books1'];?></td>  
                        <td class="text-center"><?php echo $row_get_accounting_info['uniform2'];?></td>   
                        <td class="text-center"><?php echo $row_get_accounting_info['pc'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['cambrage'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['technokids'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['hosting'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['total'];?></td>     
                        <td class="text-center"><?php echo $row_get_accounting_info['registration'];?></td>     
                        <td class="text-center"><?php echo $row_get_accounting_info['total_ed'];?></td>       
                        <td class="text-center"><?php echo $row_get_accounting_info['rest'];?></td>     
                        <td class="text-center"><?php if($row_get_kid_info['linked']==1 && $row_get_login['access17sub3']==1){?><input type="checkbox" class="check_all" value="<?php echo $row_get_accounting_info['id'];?>" name="send_rest_<?php echo $row_get_accounting_info['id'];?>" /><?php }?></td>     
                      </tr>
                      <?php } }while($row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info));} ?> 
                      </tbody>
                      <tfoot>
                          <tr>   
                              <td class="text-center"></td>   
                              <td class="text-center"></td>   
                              <td class="text-center"></td>   
                              <td class="text-center"></td>   
                              <td class="text-center"></td>    
                              <td class="text-center"></td>   
                              <td class="text-center"></td>    
                              <td class="text-center"></td>   
                              <td class="text-center"></td>     
                              <td class="text-center"></td>  
                              <td class="text-center"></td>     
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                              <td class="text-center"></td>  
                          </tr>
                    </tfoot> 
                  </table>
                  <?php if($row_get_login['access17sub3']==1){?>
                   <button type="submit" name="send_rest" class="btn btn-primary btn-block" style="width: 100px;"  >اخطار بالسداد <i class="fa fa-bell" aria-hidden="true"></i></button>
                   <?php }?>
                  </form>
                </div>
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


      
 
 $("#check_all").click(function(){
    if($(this).is(":checked")){
      $(".check_all").each(function(){ 
          $(this).prop( "checked", true );
      });
    }else{
    $(".check_all").each(function(){ 
         $(this).prop( "checked", false );
    });
    } 
 }); 


        

      $("#court-datatables").DataTable({ 
            fixedHeader: true,
            dom: '<"html5buttons"B>lTfgitp',
            lengthMenu: [
            [ -1  ],
            [ 'عرض الجميع'  ]
              ],
                buttons: [
                    { extend: 'copy' 
                    },
                    {extend: 'csv' 
                    },
                    {extend: 'excel', title: 'تحصيلات' 
                    },
                    {extend: 'pdf', title: 'تحصيلات' 
                    }, 
                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    },
                        exportOptions: {
                        columns: [ 0, 1, 15, 17 ]
                        }
                    }
                ],
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			      "aTargets": [ 17 ]  
              }
            ],

        "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) { 
        return typeof i === 'string' ?
        //i.replace(/[\$,]/g,'')*1 :
        i.replace(' L.E.', '')*1:                   
        typeof i === 'number' ?
        i : 0;
        };
 

      for($x=3;$x<=16;$x++){   // Total over all pages
          total = api
          .column( $x )
          .data()
          .reduce( function (a, b) {
          return intVal(a) + intVal(b);
          }, 0 );

          // Total over this page
          pageTotal = api
          .column( $x, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
          return intVal(a) + intVal(b);
          }, 0 );

          // Update footer
          $( api.column( $x ).footer() ).html(
          pageTotal.toFixed(2)
          //pageTotal.toFixed(2)+' L.E. '
          );
        }


      }

    }); 
		  
	  });
 </script> 
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>