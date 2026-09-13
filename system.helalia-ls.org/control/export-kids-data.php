<div class="row">
				<div class="col-md-12">     

        <?php  //if($row_get_login['access23sub4']==1){?>
            <button  class="btn btn-primary btn-block" style=" width: 100px; margin-right:30px; float:left" onClick="printdiv('printable_div_id');">طباعة <i class="fa fa-print" aria-hidden="true"></i></button> 
       <?php //}?>


        
                <div class="card" id="printable_div_id" style=" width: 100%; font-size: 12px;"> 
                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                    
                <button class="btn btn-success btn-block" style="width: 100px; margin-right:10px; float:left" onclick="exportTableToExcel('court-datatables-kids')">
                    تصدير Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </button>
		
                
                       <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

            

                <table id="court-datatables-kids"  class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px "  dir="ltr">
                      <thead>  
                        <tr> 
                            <th class="text-center">م</th>                          
                            <th class="text-center">الاسم</th>    

                            <th class="text-center">رقم تعليمي</th>                          
                            <th class="text-center">رقم قومي</th>                          
                            <th class="text-center"> المرحله</th>                          
                            <th class="text-center"> الفصل</th>                          
                            <th class="text-center"> اسم الاب</th>                          
                            <th class="text-center"> اسم الام</th>                          
                            <th class="text-center"> رقم الاب</th>                          
                            <th class="text-center"> رقم الام</th>                          
                            <th class="text-center">  امراض مزمنة</th>                          
                            <th class="text-center">   حساسية</th>                          
                            <th class="text-center">   ولاية تعليمية</th>                          
                            <th class="text-center">     الحضور للمدرسة</th>                          
                       </tr>                 
                    </thead>
                    <tbody>
                       <?php
                            mysqli_select_db($database, $database_database);  
                            $query_get_data = "SELECT `kids`.* , ( SELECT `go_to_school` FROM `data_form_kids` WHERE `data_form_kids`.kid_id = `kids`.id ORDER BY `id` DESC LIMIT 1 ) AS `go_to_school` FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc, $sort ";
                            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                            $row_get_data = mysqli_fetch_assoc($get_data);
                            $totalRows_get_data = mysqli_num_rows($get_data);
             
                         if($totalRows_get_data>0){
                            $x=1;
                             do{ if($row_get_data['fn_name']!=NULL){?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black;  vertical-align: middle; width: 20px"><?php echo $x;?></td>
                            <td class="text-left" style="text-align:left; border:solid 1px black; width: 200px; font-size: 14px !important; padding-top:3px !important; padding-bottom: 2px !important; color: black; padding-left: 3px !important;"><?php echo $row_get_data['fn_name'];?></td> 
                            
                            <td class="text-center" style="  "><?php echo $row_get_data['ed_id'];?></td>      
                            <td class="text-center" style="  "><?php echo $row_get_data['gov_id'];?></td>      
                            <td class="text-center" style="  "><?php echo year_of_study($row_get_data['study_year']);?></td>   
                            <td class="text-center" style="  "><?php echo class_name($row_get_data['class']);?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['father_name'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['mother_name'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['father_mobile'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['mother_mobile'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['chronic_disease_name'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['allergy_to_med_name'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['ed_welaya'];?></td>   
                            <td class="text-center" style="  "><?php echo $row_get_data['go_to_school'];?></td>   
                        </tr>
                     <?php $x++;}}while($row_get_data = mysqli_fetch_assoc($get_data));} ?>  
                    </tbody>
                </table>

 </div>
 
              <script>
                function exportTableToExcel(tableID) {
                    var BOM = "\uFEFF"; // For Arabic characters support
                    var table = document.getElementById(tableID);
                    var html = table.outerHTML;
                    
                    // Convert to blob with BOM
                    var processedHtml = html.replace(/<td/g, '<td style="mso-number-format:\'@\'"');
                    var blob = new Blob([BOM + processedHtml], {
                        type: 'application/vnd.ms-excel;charset=utf-8'
                    });
                    
                    // Create download link
                    // Add CSS style to force text format for all cells
                    var css = '<style>td { mso-number-format:"\\@"; } </style>';
                    var link = document.createElement("a");
                    var url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", "تقرير_الطلاب.xls");
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
                </script>

 
 




              </div>
				</div>
      </div>