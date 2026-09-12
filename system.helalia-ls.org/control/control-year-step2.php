<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub5']==1){
 
 
 
 if(isset($_GET['year']) && isset($_GET['class']) && isset($_GET['gender']) && isset($_GET['subject'])){


    if($_GET['gender']!='الاثنين'){ $gender = " AND `gender` = '{$_GET['gender']}' "; }else{ $gender = ""; } 
    if($_GET['class']>0){ $class = " AND `class` = '{$_GET['class']}' "; }else{ $class = ""; } 

        mysqli_select_db($database, $database_database);  
        $query_get_users_info = "SELECT * FROM `control_year` WHERE `study_year`= '{$_GET['year']}' AND  `subject_id`='{$_GET['subject']}'  $gender $class ORDER BY `gender` DESC, `arb_name` ASC  ";    
        $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
        $row_get_users_info = mysqli_fetch_assoc($get_users_info);
        $totalRows_get_users_info = mysqli_num_rows($get_users_info);



        mysqli_select_db($database, $database_database); 
        $query_get_subject = "SELECT * FROM `subjects` WHERE `id`= '{$_GET['subject']}'  ";
        $get_subject = mysqli_query($database,$query_get_subject) or die(mysqli_error($database));
        $row_get_subject = mysqli_fetch_assoc($get_subject);
        $totalRows_get_subject = mysqli_num_rows($get_subject); 

        
}else{ header("location: new-control.php");exit();}

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
                <h4>عرض   الطلبة </h4>  
            </div>
          </div>
         
			<div class="row"> 

            <div class="col-md-12" style="padding-right: 40px;">      

            <h3><span  style="color:brown">السنة الدراسية:</span>    <?php echo year_of_study($_GET['year']);?></h3>
            <h3><span  style="color:brown">  الفصل:</span>        <?php echo class_name($_GET['class']);?></h3>
            <h3><span  style="color:brown">  المادة:</span>         <?php echo subject_name($_GET['subject']);?></h3> 
            <input type="hidden" value="<?php echo $row_get_subject['phase1_total'];?>" id="phase1_total" />
            <input type="hidden" value="<?php echo $row_get_subject['phase2_total'];?>" id="phase2_total" />
            </div>
				 
                 
                   <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"  >الاسم  </th>  
                        <th class="text-left"  >النوع  </th>  
                        <th class="text-center" width="50" >ترم 1</th>      
                        <th class="text-center" width="50" >ترم 2</th>      
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{?>
                      <tr class="count"> 
                        <td class="text-left"><?php if($row_get_users_info['fn_name']==NULL){echo $row_get_users_info['name'];}else{echo $row_get_users_info['fn_name'];}?></td>  
                        <td class="text-left"><?php  echo $row_get_users_info['gender'];?></td>  
                        <td class="text-center"><input type="number" style="text-align: center;"   id="phase1_<?php echo $row_get_users_info['id'];?>"    class="phase1"  step="0.1" value="<?php echo $row_get_users_info['phase1_result'];?>" ></td>     
                        <td class="text-center"><input type="number" style="text-align: center;"   id="phase2_<?php echo $row_get_users_info['id'];?>"    class="phase2"  step="0.1" value="<?php echo $row_get_users_info['phase2_result'];?>" ></td>     
                     
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?> 
                     
                     
                    </tbody>
                  </table>


                </div> 
				</div>
		    </div>
           
			
			 
			
			
        </div>
      </div>
		
      <i class="fa fa-spinner fa-spin fa-5x fa-fw" style="position: fixed; top:45%; right:51%; color:blue; display:none  " id="loading"></i>
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
        order: [[2, "desc"], [1, "asc"]],
        columnDefs: [
           { searchable: false, orderable: false, targets: [4, 5] }
        ],
        "aoColumnDefs": [
           { "bSortable": false,
             "aTargets": [ 2,3 ]  
           }
         ] 
        }); 
 

  $(".phase1").change(function(){ 

      $("#loading").fadeIn();

      var phase1_total = $("#phase1_total").val();
      var myId = $(this).prop("id");  
      var id = myId.replace("phase1_", ""); 
      var phase1 = $(this).val();

      $.post("update_phase1_result.php",
      {
          id:id,
          ex_result:phase1,
          ex_total:phase1_total
      },
          function(Date,status){  
            if(Date==0){ $("#phase1_"+id).val('');}
            $("#loading").fadeOut();  
      });   
  });



 
  $(".phase2").change(function(){ 

        $("#loading").fadeIn();

        var phase2_total = $("#phase2_total").val();
        var myId = $(this).prop("id");  
        var id = myId.replace("phase2_", ""); 
        var phase2 = $(this).val();

        $.post("update_phase2_result.php",
        {
            id:id,
            ex_result:phase2,
            ex_total:phase2_total
        },
            function(Date,status){  
            if(Date==0){ $("#phase2_"+id).val('');}
            $("#loading").fadeOut();  
        });   
});

 

 



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>