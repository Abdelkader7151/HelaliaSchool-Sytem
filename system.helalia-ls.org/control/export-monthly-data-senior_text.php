<div class="row">
				<div class="col-md-12">     

        <?php  //if($row_get_login['access23sub4']==1){?>
              <button class="btn btn-success btn-block" style="width: 100px; margin-right:10px; float:left" onclick="exportTableToExcel('court-datatables-kids1'),exportTableToExcel('court-datatables-kids2'),exportTableToExcel('court-datatables-kids3')">
                    تصدير Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </button>


            <button class="btn btn-primary btn-block" style="width: 100px; margin-right:30px; float:left; margin-top: 0px" onClick="printdiv('printable_div_id');" <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>Print <i class="fa fa-print" aria-hidden="true"></i></button>
          
             
       <?php //}?>

        <h3 style="padding-right: 40px;"><span  style="color:brown">السنة الدراسية:</span>   <?php echo year_of_study($_GET['year']);?></h3>
        <h3 style="padding-right: 40px;"><span  style="color:brown">  الفصل:</span>           <?php echo class_name($_GET['class']);?></h3> 
        <h3 style="padding-right: 40px;"><span  style="color:brown">  شهر:</span>             <?php echo $_GET['month'];?></h3>
        
        
   

			 <div class="card" id="printable_div_id" style=" width: 100%; font-size: 12px;"> 
                <div class="card-body" data-toggle="match-height"  style="overflow-x:auto;  " >
                    
                       <table  class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%" style="font-size: 16px ">
                        <thead>
                            <tr>  
                                <th class="text-right"  style="width: 33%; text-align: right;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

           



                <table id="court-datatables-kids1" class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px "  <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>
                    <thead> 
                        <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important; width: 20px" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; width: 170x;  font-size: 16px !important;  " >الاســـــم   </td>
                            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
                                    echo $dateObj->format('F'); ?>
                            </td>
                            <td colspan="8" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+1));
                                    echo $dateObj->format('F'); ?>
                            </td>
                            <td colspan="8" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', ($_GET['month']+2));
                                    echo $dateObj->format('F'); ?>
                            </td>
                        </tr>
                        <tr> 
                            <th class="text-center">كراسة</th>    
                            <th class="text-center">تقيم<br>1</th>  
                            <th class="text-center">تقيم<br>2</th>    
                            <th class="text-center">تقيم<br>3</th>     
                            <th class="text-center">تقيم<br>4</th>     
                            <th class="text-center"> مجموع <br>تقيمات </th>  
                            <th class="text-center"> مواظبة<br>وسلوك </th>   
                            <th class="text-center"> المجموع </th>
                            
                            <th class="text-center">كراسة</th>    
                            <th class="text-center">تقيم<br>1</th>  
                            <th class="text-center">تقيم<br>2</th>    
                            <th class="text-center">تقيم<br>3</th>
                             <th class="text-center">تقيم<br>4</th>   
                            <th class="text-center"> مجموع <br>تقيمات </th>  
                            <th class="text-center"> مواظبة<br>وسلوك </th>   
                            <th class="text-center"> المجموع </th>

                            <th class="text-center">كراسة</th>    
                            <th class="text-center">تقيم<br>1</th>  
                            <th class="text-center">تقيم<br>2</th>    
                            <th class="text-center">تقيم<br>3</th>  
                             <th class="text-center">تقيم<br>4</th>   
                            <th class="text-center"> مجموع <br>تقيمات </th>  
                            <th class="text-center"> مواظبة<br>وسلوك </th>   
                            <th class="text-center"> المجموع </th>
                       </tr>
                       <tr>  
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">10</th>   
                            <th class="text-center">40</th>  
                            
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">10</th>   
                            <th class="text-center">40</th>  

                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">10</th>   
                            <th class="text-center">40</th>   
                       </tr> 
                    </thead>
                    <tbody>
                       <?php
                       
            mysqli_select_db($database, $database_database);  
            $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc,  $sort ";
            $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
            $row_get_data = mysqli_fetch_assoc($get_data);
            $totalRows_get_data = mysqli_num_rows($get_data);
            
            for($i=$_GET['month']; $i<=($_GET['month']+2);$i++){ 
                         if($totalRows_get_data>0){
                            $x=1;
                             do{ if($row_get_data['id']!=NULL){?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black;  vertical-align: middle;"><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black; width: 170px; font-size: 14px !important; padding-top:3px !important; padding-bottom: 2px !important; color: black; padding-left: 3px !important;  padding-right:5px !important;"><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td> 
                            
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>  
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td> 
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td> 
                            
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>  
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td> 
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td> 

                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>  
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>   
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td> 
                            <td class="text-center" style=" border:solid 1px black; width:43px"> </td>
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
                                <th class="text-right"  style="width: 33%; text-align: right; width:25px;  font-size: 16px !important; padding:5px !important;" >ادارة شرق التعليمية<br> مدرسة هلالية للغات  </th>  
                                <th class="text-center" style="width: 34%; font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
                                <th class="text-left"   style="width: 33%; text-align: left; padding: 5px !important; vertical-align: middle;"  ><img src="img/logo.png" width="40px" />  </th> 
                            </tr>
                       </thead> 
                      </table>

                <table id="court-datatables-kids2"  class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px "  <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>
                    <thead> 
                        <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important; width:20px;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; width: 150x;  font-size: 16px !important;" >الاســـــم   </td>
                            <td colspan="7" style="text-align: center; font-weight: bold; font-size: 16px !important;"> متوسط </td>   
                        </tr>
                        <tr> 
                            <th class="text-center" style="font-size: 14px !important; width: 140px">كراسة الواجب والحصة</th>    
                            <th class="text-center" style="font-size: 14px !important; width: 140px">مجموع التقيمات</th>  
                            <th class="text-center" style="font-size: 14px !important; width: 140px">مواظية وسلوك</th>  
                            <th class="text-center" style="font-size: 14px !important; width: 140px">مجموع</th>   
                            <th class="text-center" style="font-size: 14px !important; width: 140px"> شهر 1</th>   
                            <th class="text-center" style="font-size: 14px !important; width: 140px"> شهر 2</th>   
                            <th class="text-center" style="font-size: 14px !important; width: 140px"> المجموع </th> 
                       </tr>
                       <tr>  
                            <th class="text-center">15</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">10</th>  
                            <th class="text-center">40</th>   
                            <th class="text-center">15</th>  
                            <th class="text-center">15</th>   
                            <th class="text-center">70</th>   
                       </tr> 
                    </thead>
                    <tbody>
                       <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc,  $sort "; 
                        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                        $row_get_data = mysqli_fetch_assoc($get_data);
                        $totalRows_get_data = mysqli_num_rows($get_data);

                            $x=1;  if($totalRows_get_data>0){
                              do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black;  vertical-align: middle;"><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black; width: 150px; font-size: 14px !important; padding-top:3px !important; padding-bottom: 3px !important;  color: black; padding-left: 3px !important;  padding-right:5px !important;"><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td> 
                            
                            <td class="text-center" style=" border:solid 1px black"> </td>  
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>   
                            <td class="text-center" style=" border:solid 1px black"> </td>  
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
                                <th class="text-center" style="width: 34%; font-size: 16px !important;" ><?php echo year_of_study($_GET['year']);?> <br> <?php echo class_name($_GET['class']);?></th> 
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


                <table id="court-datatables-kids3" class="table table-striped table-nowrap dataTable" border="1" cellspacing="0" width="100%" style="font-size: 12px "  <?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  ' dir="ltr" ';}?>>
                    <thead>
                       <tr>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important; width:20px !important;" >م  </td>
                            <td rowspan="3" style="text-align: center; vertical-align: middle; font-size: 16px !important;" >الاســـــم   </td>
                            <td colspan="<?php echo ($z1+$z2+$z3);?>" style="text-align: center; font-weight: bold;  font-size: 14px !important;"> غياب </td>  
                       </tr> 
                            <td colspan="<?php echo $z1;?>" style="text-align: center;  font-weight: bold; font-size: 16px !important;"><?php $dateObj = DateTime::createFromFormat('!m', $_GET['month']);
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
                            <th class="text-center" style="width: 17px;"><?php echo $i;?></th> 
                         <?php } }

                            $days2 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+1), date("Y",time()));  
                        for($i=1;$i<=$days2;$i++){
                           if(date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+1)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center" style="width: 17px;"><?php echo $i;?></th> 
                         <?php } }

                            $days3 = cal_days_in_month(CAL_GREGORIAN, ($_GET['month']+2), date("Y",time()));  
                        for($i=1;$i<=$days3;$i++){
                           if(date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Saturday" && date('l', strtotime(($_GET['month']+2)."/".$i."/".date("Y",time())))!="Friday"){?>
                            <th class="text-center" style="width: 17px;"><?php echo $i;?></th> 
                         <?php } }?>


                       </tr>
                    </thead>
                    <tbody>  
                     <?php 
                        mysqli_select_db($database, $database_database);  
                        $query_get_data = "SELECT * FROM `kids` WHERE `class` = '{$_GET['class']}' ORDER BY `gender` desc,  $sort ";    
                        $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
                        $row_get_data = mysqli_fetch_assoc($get_data);
                        $totalRows_get_data = mysqli_num_rows($get_data);
            
            if($totalRows_get_data>0){
                            $x=1; do{ ?>
                        <tr>  
                            <td class="text-center" style=" border:solid 1px black; padding: 3px;  vertical-align: middle;"><?php echo $x;?></td>
                            <td class="text-<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>" style="text-align:<?php if(isset($_GET['lang']) && $_GET['lang']==2){ echo  'left';}else{echo 'right';}?>; border:solid 1px black;  font-size: 14px !important; padding-top:4px !important; padding-bottom: 3px !important; color: black; padding-left: 3px !important;  padding-right:5px !important;"><?php  if(isset($_GET['lang']) && $_GET['lang']==2){echo $row_get_data['fn_name'];}else{echo $row_get_data['name'];} ?></td>  
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