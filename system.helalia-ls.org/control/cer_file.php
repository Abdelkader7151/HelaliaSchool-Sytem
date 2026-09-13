<?php require_once('includes/access.php');  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access16']==1){
 
mysqli_select_db($database, $database_database);  
$query_get_subjects = "SELECT * FROM `subjects` WHERE `study_year` = '{$_POST['year']}'  ORDER BY `order` ASC "; 
$get_subjects = mysqli_query($database,$query_get_subjects) or die(mysqli_error($database));
$row_get_subjects = mysqli_fetch_assoc($get_subjects);
$totalRows_get_subjects = mysqli_num_rows($get_subjects);


mysqli_select_db($database, $database_database);  
if($_POST['class']==0){
    $class = 'جميع الفصول';
    $query_get_kids = "SELECT `name` FROM `kids` WHERE `study_year` = '{$_POST['year']}' AND `class` IS NOT NULL"; 
}else{
    $query_get_kids = "SELECT `name` FROM `kids` WHERE `study_year` = '{$_POST['year']}' AND `class` = '{$_POST['class']}' "; 
    $class = class_name($_POST['class']);
} 
$get_kids = mysqli_query($database,$query_get_kids) or die(mysqli_error($database));
$row_get_kids = mysqli_fetch_assoc($get_kids);
$totalRows_get_kids = mysqli_num_rows($get_kids);
  
 ?> 
 
  <?php include("includes/top-script.php");?> 
  <link rel="stylesheet" href="css/application-rtl.min.css">
  <link rel="stylesheet" href="css/dashboard-3-rtl.min.css"> 
 
     
		        <div class="col-xs-12" >
                <h3>  ملف التحميل</h3> 
                  <table id="court-datatables" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px;">
                    <thead>
                       <tr>    
                          <th></th>
                          <?php if($totalRows_get_subjects>0){ do{ ?>
                          <th class="text-right" style="text-align: right;" ><?php echo $row_get_subjects['name'];?></th>   
                          <?php }while($row_get_subjects = mysqli_fetch_assoc($get_subjects));} ?>  
                      </tr> 
                    </thead>
                     <tbody>
                      <tr>
                        <td> </td>
                        <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_subjects = "SELECT * FROM `subjects` WHERE `study_year` = '{$_POST['year']}'  ORDER BY `order` ASC "; 
                        $get_subjects = mysqli_query($database,$query_get_subjects) or die(mysqli_error($database));
                        $row_get_subjects = mysqli_fetch_assoc($get_subjects);
                        $totalRows_get_subjects = mysqli_num_rows($get_subjects);
                        
                        if($totalRows_get_subjects>0){
                           do{ 
                           //for($i=1;$i<=$totalRows_get_subjects;$i++){echo "<td>100</td>"; }
                           echo "<td>".$row_get_subjects['score']."</td>";
                           }while($row_get_subjects = mysqli_fetch_assoc($get_subjects));
                           }?>  
                      </tr>
                        <?php if($totalRows_get_kids>0){
                             do{?>
                           <tr>   
                            <td class="text-right" style="text-align: right !important;" ><?php echo $row_get_kids['name'];?></td>  
                            <?php if($totalRows_get_subjects>0){ for($i=1;$i<=$totalRows_get_subjects;$i++){echo "<td></td> "; }}?>  
                        </tr> 
                        <?php }while($row_get_kids = mysqli_fetch_assoc($get_kids)); }?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>

 
	   
    <script src="js/application.min.js"></script>  
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
 <script>
	  $(document).ready(function(){ 

		$("#court-datatables").DataTable({ 
            dom: 'Bfrtip', 
            lengthMenu: [
            [ -1  ],
            [ 'All' ]
              ],
              buttons: [
            'copy',
            {
                extend: 'excel',
                messageTop: 'المرحلة:    <?php echo year_of_study($_POST['year']);?> - الفصل: <?php echo $class;?>'
            },
             
            {
                extend: 'print',
                messageTop: 'المرحلة:    <?php echo year_of_study($_POST['year']);?> - الفصل: <?php echo $class;?>'
            }
        ]

            }); 
		  
	  });
 </script>
	  
 
<?php }else{header("location: home.php");exit();}?>