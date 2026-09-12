<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access23sub1']==1){
 
 
 
 if(isset($_GET['year']) && isset($_GET['class']) && isset($_GET['gender']) && isset($_GET['subject']) && isset($_GET['month'])){


    if($_GET['gender']!='الاثنين'){ $gender = " AND `gender` = '{$_GET['gender']}' "; }else{ $gender = ""; } 
    if($_GET['class']>0){ $class = " AND `class` = '{$_GET['class']}' "; }else{ $class = ""; } 

        mysqli_select_db($database, $database_database);  
        $query_get_users_info = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND  `subject_id`='{$_GET['subject']}' AND `month`='{$_GET['month']}'  $gender $class ORDER BY `gender` desc, `arb_name` asc   ";    
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

 </head> <style>
   
 td {
      text-align: left;
      padding: 4px !important;
    }
 
</style>
 
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

            <h3 style="font-size: 18px; margin-top:10px"><span  style="color:brown">السنة الدراسية:</span>    <?php echo year_of_study($_GET['year']);?></h3>
            <h3 style="font-size: 18px; margin-top:10px"><span  style="color:brown">  الفصل:</span>        <?php echo class_name($_GET['class']);?></h3>
            <h3 style="font-size: 18px; margin-top:10px"><span  style="color:brown">  المادة:</span>         <?php echo subject_name($_GET['subject']);?></h3>
            <h3 style="font-size: 18px; margin-top:10px"><span  style="color:brown">  شهر:</span>        <?php echo $row_get_users_info['month'];?></h3>
            <input type="hidden" value="<?php echo $row_get_subject['score'];?>" id="ex_total" />
            </div>
				 
                 
                   <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"  >الاسم  </th> 
                        <th class="text-left"  >الاسم  </th> 
                        <th class="text-left"  >النوع  </th> 
                        <th class="text-center">رقم الجلوس</th>   
                        <th class="text-center" width="50" >الدرجة</th>   
                       <!-- <th class="text-center" width="50" >اعمال الشهر</th>   -->
                        <?php if($row_get_login['access23sub3']==1){ ?>
                        <th class="text-center" width="50" >تاكيد   <input type="checkbox" style="text-align: center;" id="confirm" value="1"  ></th>   
                        <?php }?>
                      </tr>
                    </thead>
                    <tbody>
						
						<?php if($totalRows_get_users_info>0){
	                           do{?>
                      <tr class="count"> 
                        <td class="text-left"><?php echo $row_get_users_info['name'];?></td> 
                        <td class="text-left"><?php echo $row_get_users_info['arb_name'];?></td> 
                        <td class="text-left"><?php echo $row_get_users_info['gender'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['seat_id'];?></td>    
                        <td class="text-center"><input type="number" style="text-align: center;"   id="ex_result_<?php echo $row_get_users_info['id'];?>"    class="ex_result"    <?php if($row_get_users_info['confirm']==1){ echo " readonly ";} ?>  step="0.1" value="<?php echo $row_get_users_info['ex_result'];?>" ></td>     
                       <!--
                        <td class="text-center"><input type="number" style="text-align: center;"   id="month_result_<?php //echo $row_get_users_info['id'];?>" class="month_result" <?php //if($row_get_users_info['confirm']==1){ echo " readonly ";} ?>  step="0.1" value="<?php //echo $row_get_users_info['month_result'];?>" ></td>     
                             -->
                        <?php if($row_get_login['access23sub3']==1){ ?>
                         <td class="text-center"><input type="checkbox" style="text-align: center;" id="confirm_<?php echo $row_get_users_info['id'];?>"      class="confirm"  value="1" <?php if($row_get_users_info['confirm']==1){ echo " checked "; } ?>  ></td>     
                        <?php }?>
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
             "aTargets": [ 4,5 ]  
           }
         ] 
        }); 


   
 

  $(".ex_result").change(function(){ 

      $("#loading").fadeIn();

      var ex_total = $("#ex_total").val();
      var myId = $(this).prop("id");  
      var id = myId.replace("ex_result_", ""); 
      var ex_result = $(this).val();

      $.post("update_ex_result.php",
      {
          id:id,
          ex_result:ex_result,
          ex_total:ex_total
      },
          function(Date,status){  
            if(Date==0){ $("#ex_result_"+id).val('');}
            $("#loading").fadeOut();  
      });   
  });




  $(".month_result").change(function(){  
      $("#loading").fadeIn(); 
      var myId = $(this).prop("id");  
      var id = myId.replace("month_result_", ""); 
      var month_result = $(this).val();

      $.post("update_month_result.php",
        {
          id:id,
          month_result:month_result 
        },
      function(Date,status){  
          $("#loading").fadeOut();  
      });   
  });




<?php if($row_get_login['access23sub3']==1){ ?>





  $("#confirm").click(function(){

        $("#loading").fadeIn();  

          if($(this).is(":checked")){
            $(".confirm").each(function(){  
                $(this).prop( "checked", true );   
                var myId = $(this).prop("id");  
                var id = myId.replace("confirm_", "");    
                var ex_total = $("#ex_total").val();
                var ex_result = $("#ex_result_"+id).val(); 
                if(parseInt(ex_result)<=parseInt(ex_total) && parseInt(ex_result)>=0){
                    $.post("update_ex_result_confirm.php",
                        {
                          id:id,
                          confirm:1 
                        },
                        function(Date,status){   
                              $("#ex_result_"+id).attr('readonly', true);
                              $("#month_result_"+id).attr('readonly', true);   
                    });
                  }else{  $(this).prop( "checked", false );  }   
            });

            $("#loading").fadeOut();  

          }else{ 
            $(".confirm").each(function(){  
              var myId = $(this).prop("id");  
              var id = myId.replace("confirm_", "");     
                $.post("update_ex_result_confirm.php",
                    {
                      id:id,
                      confirm:0 
                    },
                    function(Date,status){   
                      $("#ex_result_"+id).attr('readonly', false);
                      $("#month_result_"+id).attr('readonly', false);  
                });
            

                $(".confirm").each(function(){ 
                    $(this).prop( "checked", false );
                });  
            }); 
               $("#loading").fadeOut(); 
           }
      }); 




    $(".confirm").click(function(){  
        $("#loading").fadeIn();  
        
        var myId = $(this).prop("id");  
        var id = myId.replace("confirm_", "");    
        var ex_total = $("#ex_total").val();
        var ex_result = $("#ex_result_"+id).val();

        if($(this).prop('checked')){  var confirm = 1; }else{ var confirm = 0; }
        if(parseInt(ex_result)<=parseInt(ex_total) && parseInt(ex_result)>=0){
        $.post("update_ex_result_confirm.php",
            {
              id:id,
              confirm:confirm 
            },
            function(Date,status){  
              if(confirm==1){  
                  $("#ex_result_"+id).attr('readonly', true);
                  $("#month_result_"+id).attr('readonly', true);
              }
              if(confirm==0){  
                  $("#ex_result_"+id).attr('readonly', false);
                  $("#month_result_"+id).attr('readonly', false);
              }  
              $("#loading").fadeOut();  
        });
      }else{
          alert(' Wrong Number ');
          $("#"+myId).prop('checked', false);
          $("#loading").fadeOut();  
      }   
    });

<?php }?>



        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>