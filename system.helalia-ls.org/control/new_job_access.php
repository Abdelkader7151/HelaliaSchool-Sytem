<?php require_once('includes/access.php');  
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
  
mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `jobs` where `id`='{$_POST['id']}' ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data);
 

    if($row_get_data['app1']==1 || $row_get_data['app2']==1 || $row_get_data['app3']==1 || $row_get_data['app4']==1 || $row_get_data['app5']==1 || $row_get_data['app6']==1 || $row_get_data['app7']==1   ){  ?>
    <div class="form-group " > 
      <label class="col-sm-3 control-label "  style="font-weight: bold;" >     صلاحيات على الابليكشن</label>
	 </div>
                     


            <div class="form-group app"   <?php if($row_get_data['app1']==0 ){echo ' style="display: none;" ';} ?>    >  
                        <label class="col-sm-3 control-label"  > تجميع غياب الطلبة</label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" class="app_btn"  name="app1" value="1" > </div>
                       </div>
                       
                       <div class="form-group app  "  <?php if($row_get_jobs_access['app1']==0 ){echo ' style="display: none;" ';} ?> > 
                         <label class="col-sm-3 control-label"  > تجميع غياب الطلبة</label>
						 <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" id="app1" class="app_btn "  name="app1" value="1" > </div>
                                <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1" name="app1_1" value="1" > رياض الاطفال </div>
                                <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1" name="app1_2" value="1" >    الابتدائي الصغير </div>
                                <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1" name="app1_3" value="1" >   الابتدائي كبير </div>
                                <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1" name="app1_4" value="1" >   الاعدادي </div>
                                <div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn app1" name="app1_5" value="1" >   الثانوي </div>
                       </div>


                       <div class="form-group app"  <?php if($row_get_data['app6']==0 ){echo ' style="display: none;" ';} ?>      >  
                        <label class="col-sm-3 control-label"  >             تاكيد غياب الطلاب    </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"   name="app6" value="1" > </div>
                       </div>

                       <div class="form-group app"   <?php if($row_get_data['app3']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  > تجميع غياب المجموعات</label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox" class="app_btn"   name="app3" value="1" > </div>
                       </div>

                       <div class="form-group app"    <?php if($row_get_data['app2']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  >       توجية استفسارات الاباء   </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"   name="app2" value="1" > </div>
                       </div>

                       <div class="form-group app"     <?php if($row_get_data['app7']==0 ){echo ' style="display: none;" ';} ?>    >  
                        <label class="col-sm-3 control-label"  >       الرد على  استفسارات الاباء   </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"    name="app7" value="1" > </div>
                       </div>
                     
                       <div class="form-group app"   <?php if($row_get_data['app4']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  >         عرض غياب العاملين  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"     name="app4" value="1" > </div>
                       </div>

                       <div class="form-group app"   <?php if($row_get_data['app5']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  >         عرض اذون العاملين   </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"     name="app5" value="1" > </div>
                       </div>

 
    <?php } if($row_get_data['app8']==1 || $row_get_data['app9']==1 ){  ?>
           
 
                       <div class="form-group " <?php if($row_get_data['app8']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  >  اشعارات للفصل  </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"     name="app8" value="1" > </div>
                       </div>

                       <div class="form-group " <?php if($row_get_data['app9']==0 ){echo ' style="display: none;" ';} ?>     >  
                        <label class="col-sm-3 control-label"  >  قبول غياب الطلبة   </label>
						<div class="col-sm-1" style="padding-top: 5px;">   <input type="checkbox"  class="app_btn"     name="app9" value="1" > </div>
                       </div>

 
    <?php }?>


    
						 