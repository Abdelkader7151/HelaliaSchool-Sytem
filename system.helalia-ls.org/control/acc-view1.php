<?php
mysqli_select_db($database, $database_database);  
$query_get_users_info = "SELECT * FROM `kids_accounting` WHERE `study_year` = '{$_GET['id']}' order by `name` asc  "; 
$get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
$row_get_users_info = mysqli_fetch_assoc($get_users_info);
$totalRows_get_users_info = mysqli_num_rows($get_users_info);
 
?>
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
                        <th class="text-center"> نشاط</th>   
                        <th class="text-center"> ايرادات الباص </th>
                        <th class="text-center"> ايرادات الزي </th>
                        <th class="text-center"> كتب وزارة   </th> 
                        <th class="text-center"> كتب نشاط   </th> 
                        <th class="text-center"> ايرادات الزي الاضافي </th>
                      
                        <th class="text-center"> حاسب الي </th>    
                        <th class="text-center"> تكنوكيدز </th>    
                        <th class="text-center"> استضافة </th>    
                        <th class="text-center"> الاجمالي</th>     
                        <th class="text-center"> رسوم تسجيل</th>     
                      </tr>
                    </thead>
                    <tbody>  
						<?php if($totalRows_get_users_info>0){
	                           do{  ?>
                      <tr> 
                        <td class="text-left"><?php echo $row_get_users_info['name'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['ed_id'];?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['ed_fees'];?></td>    
                        <td class="text-center"><?php echo $row_get_users_info['activity'];?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['bus'];?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['uniform1'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['books1'];?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['books2'];?></td>  
                        <td class="text-center"><?php echo $row_get_users_info['uniform2'];?></td>   
                        
                        <td class="text-center"><?php echo $row_get_users_info['pc'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['technokids'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['hosting'];?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['total'];?></td>     
                        <td class="text-center"><?php echo $row_get_users_info['registration'];?></td>     
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));} ?> 
                      </tbody>
                      <tfoot>
                      <tr>  
                          <th colspan="2"></th>    
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


        <?php include("includes/footer-script.php");?> 
        <script src="js/application.min.js"></script>

 <script>
	  $(document).ready(function(){ 

      $("#court-datatables").DataTable({ 
            fixedHeader: true,
            dom: '<"html5buttons"B>lTfgitp',
            lengthMenu: [
            [ 25, 50,-1  ],
            [ '25', '50','All' ]
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
                        columns: [ 0, 1, 2 ]
                        }
                    }
                ],
                order: [
                [0, "desc"]
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



   for($i=2;$i<=13;$i++){   // Total over all pages
      total = api
      .column( $i )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );

      // Total over this page
      pageTotal = api
      .column( $i, { page: 'current'} )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );

      // Update footer
      $( api.column( $i ).footer() ).html(
      pageTotal.toFixed(2)
      //pageTotal.toFixed(2)+' L.E. '
      );
    }


      }

}); 
		  
	  });
 </script> 