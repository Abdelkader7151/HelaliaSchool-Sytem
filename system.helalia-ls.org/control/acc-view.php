<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access17sub1']==1){

 
if(isset($_GET['id']) ){

  $id = GetSQLValueString($database,$_GET['id'], "int"); 

mysqli_select_db($database, $database_database);  
$query_get_accounting_info = "SELECT * FROM `kids_accounting` WHERE `study_year` = '{$id}' order by `name` asc  "; 
$get_accounting_info = mysqli_query($database,$query_get_accounting_info) or die(mysqli_error($database));
$row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info);
$totalRows_get_accounting_info = mysqli_num_rows($get_accounting_info);

}


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
                    <form action="acc-view.php" method="get" name="form1" id="form1" enctype="multipart/form-data" class="form form-horizontal">
                    
					   
             
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

    <?php  if(isset($_GET['id'])  ){?>
       <div class="row">
				<div class="col-md-12">
				   <div class="card"> 

            <h3 style="padding-right: 50px;"><?php echo year_of_study($_GET['id']);?></h3>

             <div class="card-body table" data-toggle="match-height" >
                <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px">
                    <thead>
                      <tr> 
                        <th class="text-left">الاسم </th> 
                        <th class="text-center">الرقم التعليمي </th>  
                        <th class="text-center"> رسوم التعليم </th>  
                        <th class="text-center"> رسوم نشاط</th>  
                        <th class="text-center"> ايرادات الباص </th>
                        <th class="text-center"> ايرادات الزي </th>
                        <th class="text-center"> كتب وزاري   </th> 
                        <th class="text-center"> ايرادات الزي الاضافي </th>
                        <th class="text-center"> حاسب الي </th>  
                        <th class="text-center"> كامبريدج وابليكشن </th>    
                        <th class="text-center"> تكنوكيدز </th>    
                        <th class="text-center"> كورس / استضافة </th>    
                        <th class="text-center"> الاجمالي</th>     
                        <th class="text-center"> رسوم تسجيل</th>     
                        <th class="text-center"> اجمالي التعليم</th>     
                        <th class="text-center"> مستحقات</th>     
                      </tr>
                    </thead>
                    <tbody>  
						<?php if($totalRows_get_accounting_info>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_accounting_info['name'];?></td> 
                        <td class="text-center"><?php echo $row_get_accounting_info['ed_id'];?></td>  
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
                      </tr>
                      <?php }while($row_get_accounting_info = mysqli_fetch_assoc($get_accounting_info));} ?> 
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
                          </tr>
                    </tfoot> 
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
	  $(document).ready(function(){ 


      
 



        

      $("#court-datatables").DataTable({ 
            fixedHeader: true,
            dom: '<"html5buttons"B>lTfgitp',
            lengthMenu: [
            [  -1  ],
            [  'All' ]
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
                        columns: [ 0, 1, 15 ]
                        }
                    }
                ],
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": true,
			      "aTargets": [ 0 ]  
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
 

      for($x=2;$x<=15;$x++){   // Total over all pages
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