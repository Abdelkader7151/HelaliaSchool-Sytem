<div class="row">
				<div class="col-md-12">     

        <?php  //($row_get_login['access23sub4']==1){?>
                <button class="btn btn-success btn-block" style="width: 100px; margin-right:10px; float:left" onclick="exportTableToExcel('court-datatables-kids1');exportTableToExcel('court-datatables-kids2');exportTableToExcel('court-datatables-kids3')">
                    تصدير Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </button>


            <button class="btn btn-primary btn-block" style="width: 100px; margin-right:30px; float:left; margin-top: 0px" onClick="printdiv('printable_div_id');" <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>Print <i class="fa fa-print" aria-hidden="true"></i></button>
          
             
       <?php //}?>

        <h3 style="padding-right: 40px;"><span  style="color:brown">السنة الدراسية:</span>   <?php echo year_of_study($_GET['year']);?></h3>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  الفصل:</span>           <?php echo class_name($_GET['class']);?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  شهر:</span>             <?php echo $_GET['month'];?></h3>
        <?php if($_GET['subject']>0){ ?>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  المادة:</span>             <?php echo subject_name($_GET['subject']);?></h3>
        <?php } ?>
        
        
        
   

			 <div class="card" id="printable_div_id" style=" width: 100%; font-size: 12px;"> 
                 <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                    
                      <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%;  font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

           
                        <?php  
                        $query_get_title = "SELECT * FROM `control_registry_title` WHERE `study_year`= '{$_GET['year']}'  ";
                        $get_title = mysqli_query($database,$query_get_title) or die(mysqli_error($database));
                        $row_get_title = mysqli_fetch_assoc($get_title);
                        $totalRows_get_title = mysqli_num_rows($get_title); 
                                  if($row_get_title['col1_total']>0){ $rowspan = 1; }?>
                            <?php if($row_get_title['col2_total']>0){ $rowspan = 2;  }?>   
                            <?php if($row_get_title['col3_total']>0){ $rowspan = 3;  }?>    
                            <?php if($row_get_title['col4_total']>0){ $rowspan = 4;  }?>     
                            <?php if($row_get_title['col5_total']>0){ $rowspan = 5;  }?>     
                            <?php if($row_get_title['col6_total']>0){ $rowspan = 6;  }?>    
                            <?php if($row_get_title['col7_total']>0){ $rowspan = 7;  }?>   
                            <?php if($row_get_title['col8_total']>0){ $rowspan = 8;  }?>     
                            <?php if($row_get_title['col9_total']>0){ $rowspan = 9;  }?>     
                            <?php if($row_get_title['col10_total']>0){ $rowspan = 10;  }?>   
                            <?php if($row_get_title['col11_total']>0){ $rowspan = 11;  }?>   
                            <?php if($row_get_title['col12_total']>0){ $rowspan = 12;  }?>   
                            <?php if($row_get_title['col13_total']>0){ $rowspan = 13;  }?>   
                            <?php if($row_get_title['col14_total']>0){ $rowspan = 14;  }?>     
                            <?php if($row_get_title['col15_total']>0){ $rowspan = 15;  }
                            
                            $rowspan++;  ?>    

                <table id="court-datatables-kids1"  class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px " <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>
                    <thead> 
                        <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle;  font-size: 16px !important; width: 20px;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle;     font-size: 16px !important;" >الاســـــم   </td>
                            <td colspan="<?php echo $rowspan;?>"style="text-align: center; font-weight: bold;  font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
                                    echo $dateObj->format('F'); ?>
                            </td>
                            <td colspan="<?php echo $rowspan;?>" style="text-align: center;  font-weight: bold;  font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+1));
                                    echo $dateObj->format('F'); ?>
                            </td>
                            <td colspan="<?php echo $rowspan;?>" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+2));
                                    echo $dateObj->format('F'); ?>
                            </td>
                        </tr>
                        <tr>  
                        <?php   

                        for($i=1;$i<=3;$i++){ ?>
                            <?php if($row_get_title['col1_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col1'];?></th><?php }?>
                            <?php if($row_get_title['col2_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col2'];?></th><?php }?>   
                            <?php if($row_get_title['col3_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col3'];?></th><?php }?>   
                            <?php if($row_get_title['col4_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col4'];?></th><?php }?>   
                            <?php if($row_get_title['col5_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col5'];?></th><?php }?>   
                            <?php if($row_get_title['col6_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col6'];?></th><?php }?>   
                            <?php if($row_get_title['col7_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col7'];?></th><?php }?>   
                            <?php if($row_get_title['col8_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col8'];?></th><?php }?>   
                            <?php if($row_get_title['col9_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col9'];?></th><?php }?>   
                            <?php if($row_get_title['col10_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col10'];?></th><?php }?>   
                            <?php if($row_get_title['col11_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col11'];?></th><?php }?>   
                            <?php if($row_get_title['col12_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col12'];?></th><?php }?>   
                            <?php if($row_get_title['col13_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col13'];?></th><?php }?>   
                            <?php if($row_get_title['col14_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col14'];?></th><?php }?>   
                            <?php if($row_get_title['col15_total']>0){?><th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col15'];?></th><?php }?>    
                            <th class="text-center" style="width: 25px;"> المجموع </th>
                       <?php } ?>  
                       </tr>
                       <tr>  
                     <?php for($i=1;$i<=3;$i++){ ?>
                            <?php if($row_get_title['col1_total']>0){?><th class="text-center"><?php echo $row_get_title['col1_total'];?></th><?php }?> 
                            <?php if($row_get_title['col2_total']>0){?><th class="text-center"><?php echo $row_get_title['col2_total'];?></th><?php }?> 
                            <?php if($row_get_title['col3_total']>0){?><th class="text-center"><?php echo $row_get_title['col3_total'];?></th><?php }?> 
                            <?php if($row_get_title['col4_total']>0){?><th class="text-center"><?php echo $row_get_title['col4_total'];?></th><?php }?> 
                            <?php if($row_get_title['col5_total']>0){?><th class="text-center"><?php echo $row_get_title['col5_total'];?></th><?php }?> 
                            <?php if($row_get_title['col6_total']>0){?><th class="text-center"><?php echo $row_get_title['col6_total'];?></th><?php }?> 
                            <?php if($row_get_title['col7_total']>0){?><th class="text-center"><?php echo $row_get_title['col7_total'];?></th><?php }?> 
                            <?php if($row_get_title['col8_total']>0){?><th class="text-center"><?php echo $row_get_title['col8_total'];?></th><?php }?> 
                            <?php if($row_get_title['col9_total']>0){?><th class="text-center"><?php echo $row_get_title['col9_total'];?></th><?php }?> 
                            <?php if($row_get_title['col10_total']>0){?><th class="text-center"><?php echo $row_get_title['col10_total'];?></th><?php }?> 
                            <?php if($row_get_title['col11_total']>0){?><th class="text-center"><?php echo $row_get_title['col11_total'];?></th><?php }?> 
                            <?php if($row_get_title['col12_total']>0){?><th class="text-center"><?php echo $row_get_title['col12_total'];?></th><?php }?> 
                            <?php if($row_get_title['col13_total']>0){?><th class="text-center"><?php echo $row_get_title['col13_total'];?></th><?php }?> 
                            <?php if($row_get_title['col14_total']>0){?><th class="text-center"><?php echo $row_get_title['col14_total'];?></th><?php }?> 
                            <?php if($row_get_title['col15_total']>0){?><th class="text-center"><?php echo $row_get_title['col15_total'];?></th><?php }?>  
                            <th class="text-center"><?php echo ($row_get_title['col1_total']+$row_get_title['col2_total']+$row_get_title['col7_total']+$row_get_title['col8_total']+$row_get_title['col9_total']+$row_get_title['col10_total']+$row_get_title['col11_total']+$row_get_title['col12_total']+$row_get_title['col13_total']+$row_get_title['col14_total']+$row_get_title['col15_total']);?></th>  
                            <!--<th class="text-center"><?php //echo ($row_get_title['col1_total']+$row_get_title['col2_total']+$row_get_title['col3_total']+$row_get_title['col4_total']+$row_get_title['col5_total']+$row_get_title['col6_total']+$row_get_title['col7_total']+$row_get_title['col8_total']+$row_get_title['col9_total']+$row_get_title['col10_total']+$row_get_title['col11_total']+$row_get_title['col12_total']+$row_get_title['col13_total']+$row_get_title['col14_total']+$row_get_title['col15_total']);?></th>  -->
                       <?php } ?>   
                       </tr> 
                    </thead>
                    <tbody>
                       <?php 
                       
            mysqli_select_db($database, $database_database);  
            $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc, $sort ";
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
            
            for($i=$_GET['month'];$i<=($_GET['month']+2);$i++){ 
                         if($totalRows_get_data>0){
                          $x = 1;
                            do{ if($row_get_data['id']!=NULL){?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black; vertical-align: middle;"><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black; width: 120px; font-size: 14px !important; padding-top:3px !important; padding-bottom: 2px !important; color: black; padding-left: 3px !important;  padding-right:5px !important;"><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td> 
                          
                            
                       <?php  $month = $_GET['month'];
                       for($i=1;$i<=3;$i++){
                            if($_GET['subject']>0){  $subject = " AND `subject_id` ='{$_GET['subject']}' "; }else{ $subject =""; }

                            $query_get_registry = "SELECT * FROM `control_registry` WHERE `study_year`= '{$_GET['year']}' AND `kid_id`= '{$row_get_data['id']}' AND `month`= '{$month}' $subject  ";
                            $get_registry = mysqli_query($database,$query_get_registry) or die(mysqli_error($database));
                            $row_get_registry = mysqli_fetch_assoc($get_registry);
                            $totalRows_get_registry = mysqli_num_rows($get_registry); 
                            ?>
                             <?php if($row_get_title['col1_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col1'];?></td><?php } ?>  
                             <?php if($row_get_title['col2_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col2'];?></td><?php } ?>  
                             <?php if($row_get_title['col3_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col3'];?></td><?php } ?>  
                             <?php if($row_get_title['col4_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col4'];?></td><?php } ?>  
                             <?php if($row_get_title['col5_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col5'];?></td><?php } ?>  
                             <?php if($row_get_title['col6_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col6'];?></td><?php } ?>  
                             <?php if($row_get_title['col7_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col7'];?></td><?php } ?>  
                             <?php if($row_get_title['col8_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col8'];?></td><?php } ?>  
                             <?php if($row_get_title['col9_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col9'];?></td><?php } ?>  
                             <?php if($row_get_title['col10_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col10'];?></td><?php } ?>  
                             <?php if($row_get_title['col11_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col11'];?></td><?php } ?>  
                             <?php if($row_get_title['col12_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col12'];?></td><?php } ?>  
                             <?php if($row_get_title['col13_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col13'];?></td><?php } ?>  
                             <?php if($row_get_title['col14_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col14'];?></td><?php } ?>  
                             <?php if($row_get_title['col15_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col15'];?></td><?php } ?>     
                             <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php if(($row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15'])>0){echo ($row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15']);}?></td> 
                        <?php  $month++; } ?>   
                        

                        
                          
                        </tr>
                     <?php $x++;}}while($row_get_data = mysqli_fetch_assoc($get_data));} }?>  
                    </tbody>
                  </table> 

                          <table  class="table " cellspacing="0" border="0" width="100%" style="font-size: 16px; border: none !important; margin-top: 20px !important; "> 
                            <tr>  
                                <th class="text-right"  style="width: 33%; font-size: 16px !important; text-align: right;  border-bottom:none !important;" >توقيع المدرس </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important; border-bottom:none !important;" >توقيع مشرف المادة</th> 
                                <th class="text-left"   style="width: 33%; font-size: 16px !important; text-align: left; border-bottom:none !important;" > توقيع مشرف المرحلة</th> 
                            </tr> 
                       </table>

                </div>






                  <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " > 

                   <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%;  font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>
                    
                

                <table  id="court-datatables-kids2" class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 10px !important "  <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?> >
                    <thead> 
                        <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important; width: 20px;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; width: 100x; font-size: 16px !important;" >الاســـــم   </td>
                            <td colspan="10" style="text-align: center; font-weight: bold; font-size: 16px !important;"> متوسط </td>   
                        </tr>
                        <tr> 
                       <?php  
                        $query_get_title = "SELECT * FROM `control_registry_avg_title` WHERE `study_year`= '{$_GET['year']}'  ";
                        $get_title = mysqli_query($database,$query_get_title) or die(mysqli_error($database));
                        $row_get_title = mysqli_fetch_assoc($get_title);
                        $totalRows_get_title = mysqli_num_rows($get_title); 

                        if($_GET['month']==10 || $_GET['month']==11 || $_GET['month']==12 ){
                            $month_condition1 = " AND `month` = 10 ";
                            $month_condition2 = " AND `month` = 11 ";
                            $turm = 12;
                        }else{
                            $month_condition1 = " AND `month` = 2 ";
                            $month_condition2 = " AND `month` = 3 ";
                            $turm = 3;
                        } 

                        $query_get_exam1 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `subject_id` = '{$_GET['subject']}' $month_condition1 ";
                        $get_exam1 = mysqli_query($database,$query_get_exam1) or die(mysqli_error($database));
                        $row_get_exam1 = mysqli_fetch_assoc($get_exam1);
                        $totalRows_get_exam1 = mysqli_num_rows($get_exam1); 

                        $query_get_exam2 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `subject_id` = '{$_GET['subject']}' $month_condition2 ";
                        $get_exam2 = mysqli_query($database,$query_get_exam2) or die(mysqli_error($database));
                        $row_get_exam2 = mysqli_fetch_assoc($get_exam2);
                        $totalRows_get_exam2 = mysqli_num_rows($get_exam2); 

                        $query_get_subjects = "SELECT `score` FROM `subjects` WHERE  `id` = '{$_GET['subject']}'   ";
                        $get_subjects = mysqli_query($database,$query_get_subjects) or die(mysqli_error($database));
                        $row_get_subjects = mysqli_fetch_assoc($get_subjects);
                        $totalRows_get_subjects = mysqli_num_rows($get_subjects); 

                        ?>
                            <?php if($row_get_title['col1_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col1'];?></th><?php }?>
                            <?php if($row_get_title['col2_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col2'];?></th><?php }?>   
                            <?php if($row_get_title['col3_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col3'];?></th><?php }?>   
                            <?php if($row_get_title['col4_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col4'];?></th><?php }?>   
                            <?php if($row_get_title['col5_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col5'];?></th><?php }?>   
                            <?php if($row_get_title['col6_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col6'];?></th><?php }?>   
                            <?php if($row_get_title['col7_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col7'];?></th><?php }?>   
                            <?php if($row_get_title['col8_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col8'];?></th><?php }?>   
                            <?php if($row_get_title['col9_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col9'];?></th><?php }?>   
                            <?php if($row_get_title['col10_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col10'];?></th><?php }?>   
                            <?php if($row_get_title['col11_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col11'];?></th><?php }?>   
                            <?php if($row_get_title['col12_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col12'];?></th><?php }?>   
                            <?php if($row_get_title['col13_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col13'];?></th><?php }?>   
                            <?php if($row_get_title['col14_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col14'];?></th><?php }?>   
                            <?php if($row_get_title['col15_total']>0){?><th class="text-center" style=" white-space: pre-wrap; word-wrap: break-word;"><?php echo $row_get_title['col15'];?></th><?php }?>    
                            <th class="text-center"  > المجموع </th> 

                            <?php if($_GET['year']>=5){?>
                            <th class="text-center" style="width: 120px; font-size: 14px !important;"> شهر 1 </th> 
                            <th class="text-center" style="width: 120px; font-size: 14px !important;"> شهر 2 </th> 
                            <th class="text-center" style="width: 120px; font-size: 14px !important;"> المجموع </th> 
                            <?php } ?>
                       </tr>
                       <tr>  
                            <?php if($row_get_title['col1_total']>0){?><th class="text-center"><?php echo $row_get_title['col1_total'];?></th><?php }?> 
                            <?php if($row_get_title['col2_total']>0){?><th class="text-center"><?php echo $row_get_title['col2_total'];?></th><?php }?> 
                            <?php if($row_get_title['col3_total']>0){?><th class="text-center"><?php echo $row_get_title['col3_total'];?></th><?php }?> 
                            <?php if($row_get_title['col4_total']>0){?><th class="text-center"><?php echo $row_get_title['col4_total'];?></th><?php }?> 
                            <?php if($row_get_title['col5_total']>0){?><th class="text-center"><?php echo $row_get_title['col5_total'];?></th><?php }?> 
                            <?php if($row_get_title['col6_total']>0){?><th class="text-center"><?php echo $row_get_title['col6_total'];?></th><?php }?> 
                            <?php if($row_get_title['col7_total']>0){?><th class="text-center"><?php echo $row_get_title['col7_total'];?></th><?php }?> 
                            <?php if($row_get_title['col8_total']>0){?><th class="text-center"><?php echo $row_get_title['col8_total'];?></th><?php }?> 
                            <?php if($row_get_title['col9_total']>0){?><th class="text-center"><?php echo $row_get_title['col9_total'];?></th><?php }?> 
                            <?php if($row_get_title['col10_total']>0){?><th class="text-center"><?php echo $row_get_title['col10_total'];?></th><?php }?> 
                            <?php if($row_get_title['col11_total']>0){?><th class="text-center"><?php echo $row_get_title['col11_total'];?></th><?php }?> 
                            <?php if($row_get_title['col12_total']>0){?><th class="text-center"><?php echo $row_get_title['col12_total'];?></th><?php }?> 
                            <?php if($row_get_title['col13_total']>0){?><th class="text-center"><?php echo $row_get_title['col13_total'];?></th><?php }?> 
                            <?php if($row_get_title['col14_total']>0){?><th class="text-center"><?php echo $row_get_title['col14_total'];?></th><?php }?> 
                            <?php if($row_get_title['col15_total']>0){?><th class="text-center"><?php echo $row_get_title['col15_total'];?></th><?php }?>   
                            <th class="text-center" style="width: 120px; font-size: 14px !important;"><?php echo ($row_get_title['col1_total']+$row_get_title['col2_total']+$row_get_title['col3_total']+$row_get_title['col4_total']+$row_get_title['col5_total']+$row_get_title['col6_total']+$row_get_title['col7_total']+$row_get_title['col8_total']+$row_get_title['col9_total']+$row_get_title['col10_total']+$row_get_title['col11_total']+$row_get_title['col12_total']+$row_get_title['col13_total']+$row_get_title['col14_total']+$row_get_title['col15_total']);?> </th>  
                            
                             <?php if($_GET['year']>=5){?>
                             <th class="text-center" ><?php if($row_get_exam1['ex_total']>0){echo $row_get_exam1['ex_total']; $score1 = $row_get_exam1['ex_total'];}else{echo $row_get_subjects['score']; $score1 = $row_get_subjects['score'];} ?></th> 
                             <th class="text-center" ><?php if($row_get_exam2['ex_total']>0){echo $row_get_exam2['ex_total']; $score2 = $row_get_exam2['ex_total'];}else{echo $row_get_subjects['score']; $score2 = $row_get_subjects['score'];} ?></th> 
                             <th class="text-center" ><?php echo ($score1+$score2+$row_get_title['col1_total']+$row_get_title['col2_total']+$row_get_title['col3_total']+$row_get_title['col4_total']+$row_get_title['col5_total']+$row_get_title['col6_total']+$row_get_title['col7_total']+$row_get_title['col8_total']+$row_get_title['col9_total']+$row_get_title['col10_total']+$row_get_title['col11_total']+$row_get_title['col12_total']+$row_get_title['col13_total']+$row_get_title['col14_total']+$row_get_title['col15_total']);?> </th> 
                            <?php } ?>
                       </tr> 
                    </thead>
                    <tbody>
                       <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc, $sort ";    
                        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                        $row_get_data = mysqli_fetch_assoc($get_data);
                        $totalRows_get_data = mysqli_num_rows($get_data);

                            $x=1;  if($totalRows_get_data>0){
                              do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black; vertical-align: middle; "><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black; width:130px; font-size: 14px !important; padding-top: 1px !important; padding-bottom: 1px !important;color: black; padding-left: 3px !important;  padding-right:5px !important;"><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td> 
                            
                     <?php  if($_GET['subject']>0){  $subject = " AND `subject_id` ='{$_GET['subject']}' "; }else{ $subject =""; }

                              $query_get_registry = "SELECT * FROM `control_registry_avg` WHERE `study_year`= '{$_GET['year']}' AND `kid_id`= '{$row_get_data['id']}' AND `month`= '{$turm}' $subject  ";
                              $get_registry = mysqli_query($database,$query_get_registry) or die(mysqli_error($database));
                              $row_get_registry = mysqli_fetch_assoc($get_registry);
                              $totalRows_get_registry = mysqli_num_rows($get_registry); 

                              
                        $query_get_exam1 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `kid_id` = '{$row_get_data['id']}' AND `subject_id` = '{$_GET['subject']}'  $month_condition1 ";
                        $get_exam1 = mysqli_query($database,$query_get_exam1) or die(mysqli_error($database));
                        $row_get_exam1 = mysqli_fetch_assoc($get_exam1);
                        $totalRows_get_exam1 = mysqli_num_rows($get_exam1); 

                        $query_get_exam2 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `kid_id` = '{$row_get_data['id']}' AND `subject_id` = '{$_GET['subject']}'  $month_condition2 ";
                        $get_exam2 = mysqli_query($database,$query_get_exam2) or die(mysqli_error($database));
                        $row_get_exam2 = mysqli_fetch_assoc($get_exam2);
                        $totalRows_get_exam2 = mysqli_num_rows($get_exam2); 

                            ?>
                             <?php if($row_get_title['col1_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col1'];?></td><?php } ?>  
                             <?php if($row_get_title['col2_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col2'];?></td><?php } ?>  
                             <?php if($row_get_title['col3_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col3'];?></td><?php } ?>  
                             <?php if($row_get_title['col4_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col4'];?></td><?php } ?>  
                             <?php if($row_get_title['col5_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col5'];?></td><?php } ?>  
                             <?php if($row_get_title['col6_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col6'];?></td><?php } ?>  
                             <?php if($row_get_title['col7_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col7'];?></td><?php } ?>  
                             <?php if($row_get_title['col8_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col8'];?></td><?php } ?>  
                             <?php if($row_get_title['col9_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col9'];?></td><?php } ?>  
                             <?php if($row_get_title['col10_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col10'];?></td><?php } ?>  
                             <?php if($row_get_title['col11_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col11'];?></td><?php } ?>  
                             <?php if($row_get_title['col12_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col12'];?></td><?php } ?>  
                             <?php if($row_get_title['col13_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col13'];?></td><?php } ?>  
                             <?php if($row_get_title['col14_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col14'];?></td><?php } ?>  
                             <?php if($row_get_title['col15_total']>0){ ?><td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_registry['col15'];?></td><?php } ?>     
                             <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php if(($row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15'])>0){echo ($row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15']);}?></td>  
                             <?php if($_GET['year']>=5){?>
                              <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_exam1['ex_result'];?></td> 
                              <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php echo $row_get_exam2['ex_result'];?></td> 
                              <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;"><?php if(($row_get_exam1['ex_result']+$row_get_exam2['ex_result']+$row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15'])>0){echo ($row_get_exam1['ex_result']+$row_get_exam2['ex_result']+$row_get_registry['col1']+$row_get_registry['col2']+$row_get_registry['col3']+$row_get_registry['col4']+$row_get_registry['col5']+$row_get_registry['col6']+$row_get_registry['col7']+$row_get_registry['col8']+$row_get_registry['col9']+$row_get_registry['col10']+$row_get_registry['col11']+$row_get_registry['col12']+$row_get_registry['col13']+$row_get_registry['col14']+$row_get_registry['col15']);}?></td> 
                             <?php } ?>
                            </tr>
                     <?php $x++;}while($row_get_data = mysqli_fetch_assoc($get_data));}   ?>  
                    </tbody>
                  </table>
                  <table  class="table " cellspacing="0" border="0" width="100%" style="font-size: 16px; border: none !important; margin-top: 20px !important; "> 
                            <tr>  
                                <th class="text-right"  style="width: 33%; font-size: 16px !important; text-align: right;  border-bottom:none !important;" >توقيع المدرس </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important; border-bottom:none !important;" >توقيع مشرف المادة</th> 
                                <th class="text-left"   style="width: 33%; font-size: 16px !important; text-align: left; border-bottom:none !important;" > توقيع مشرف المرحلة</th> 
                            </tr> 
                       </table>
                </div>







                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >

                 <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%;  font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

                    
                    

           
                         <?php  
                            $z1 = 0;
                            $z2 = 0;
                            $z3 = 0;
                            $days1 = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                            $days2 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+1), date("Y",time()));  
                            $days3 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+2), date("Y",time()));  
                        for($i=1;$i<=$days1;$i++){ if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){ $z1++; } } 
                        for($i=1;$i<=$days2;$i++){ if(date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Friday"){ $z2++; } }
                        for($i=1;$i<=$days3;$i++){ if(date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Friday"){ $z3++; } }
                        
                        ?>


                <table id="court-datatables-kids3" class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px " <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>
                    <thead>
                         <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important; width: 20px !important;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important;" >الاســـــم   </td>
                            <td colspan="<?php echo ($z1+$z2+$z3);?>" style="text-align: center; font-weight: bold;  font-size: 16px !important;"> غياب </td>  
                       </tr> 
                       <tr>  
                            <td colspan="<?php echo $z1;?>" style="text-align: center;  font-weight: bold ; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
                                    echo $dateObj->format('F'); ?>      
                            </td>

                              <td colspan="<?php echo $z2;?>" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+1));
                                    echo $dateObj->format('F'); ?>      
                            </td>

                             <td colspan="<?php echo $z3;?>" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+2));
                                    echo $dateObj->format('F'); ?>      
                            </td>
                        </tr> 
                       <tr>  
                         <?php  
                            $days1 = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                        for($i=1;$i<=$days1;$i++){
                           if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center" style="width: 16px !important;"><?php echo $i;?></th> 
                         <?php } }

                            $days2 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+1), date("Y",time()));  
                        for($i=1;$i<=$days2;$i++){
                           if(date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center" style="width: 16px !important;"><?php echo $i;?></th> 
                         <?php } }

                            $days3 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+2), date("Y",time()));  
                        for($i=1;$i<=$days3;$i++){
                           if(date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center" style="width: 16px !important;"><?php echo $i;?></th> 
                         <?php } }?>


                       </tr>
                    </thead>
                    <tbody>  
                     <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc, $sort ";    
                        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                        $row_get_data = mysqli_fetch_assoc($get_data);
                        $totalRows_get_data = mysqli_num_rows($get_data);
            
            if($totalRows_get_data>0){
                            $x=1; do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black; vertical-align: middle; "><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black; width:130px; font-size: 12px !important; padding-top:2px !important; padding-bottom: 2px !important; color: black; padding-left: 3px !important;  padding-right:5px !important; "><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td>  
                           <?php  
                            $days1 = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], date("Y",time()));  
                            for($i=1;$i<=$days1;$i++){
                            if(date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime($_GET['month']."/".$i."/".date("Y",time())))!="Friday"){?>
                            <td class="text-center"  style=" border:solid 1px black"></td> 
                          <?php } }

                            $days2 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+1), date("Y",time()));  
                            for($i=1;$i<=$days2;$i++){
                            if(date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <td class="text-center"  style=" border:solid 1px black"></td> 
                          <?php } } 
                          
                            $days3 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+2), date("Y",time()));  
                            for($i=1;$i<=$days3;$i++){
                            if(date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <td class="text-center"  style=" border:solid 1px black"></td> 
                          <?php } }?>  


                        </tr>
                     <?php $x++;}while($row_get_data = mysqli_fetch_assoc($get_data));}?>  
                    </tbody>
                  </table>
                  <table  class="table " cellspacing="0" border="0" width="100%" style="font-size: 16px; border: none !important; margin-top: 20px !important; "> 
                            <tr>  
                                <th class="text-right"  style="width: 33%; font-size: 16px !important; text-align: right;  border-bottom:none !important;" >توقيع المدرس </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important; border-bottom:none !important;" >توقيع مشرف المادة</th> 
                                <th class="text-left"   style="width: 33%; font-size: 16px !important; text-align: left; border-bottom:none !important;" > توقيع مشرف المرحلة</th> 
                            </tr> 
                       </table>
                </div>








              </div>
				</div>
      </div>