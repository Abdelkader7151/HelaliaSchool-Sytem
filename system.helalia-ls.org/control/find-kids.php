<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub2']==1){
 
  $study_year ='';



if(isset($_GET['find'])){
 
  if($_GET['name']!=NULL){$name = " AND ( `name` LIKE '%{$_GET['name']}%'  OR `fn_name` LIKE '%{$_GET['name']}%' )";}else{$name =''; }
  if($_GET['ed']>0){$ed_id = " AND `ed_id` = '{$_GET['ed']}' ";}else{ $ed_id = '';}
  if($_GET['gov']>0){$gov_id = " AND `gov_id` = '{$_GET['gov']}' ";}else{ $gov_id = '';}
  if($_GET['year']>0){$study_year = " AND `study_year` = '{$_GET['year']}' ";}else{ $study_year = '';}
 
    mysqli_select_db($database, $database_database);  
    $query_get_users_info = "SELECT * FROM `kids` WHERE `id`>0 $name $study_year $gov_id $ed_id   "; 
    $get_users_info = mysqli_query($database,$query_get_users_info) or die(mysqli_error($database));
    $row_get_users_info = mysqli_fetch_assoc($get_users_info);
    $totalRows_get_users_info = mysqli_num_rows($get_users_info);
    
 }

$head_title = "  الطلبة";
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
                <h4>البحث عن طالب </h4>  
            </div>
          </div>
         
			<div class="row"> 
				
                   <div class="col-xs-12" style="padding: 20px;">  
                   <form   method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    

                     <div class="form-group">
                        <label class="col-sm-1 control-label" for="name">  الاسم  </label>
                        <div class="col-sm-3">
                            <input id="name" class="form-control"   type="text" name="name">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-1 control-label" for="gov"> الرقم القومي   </label>
                        <div class="col-sm-2">
                            <input id="gov" class="form-control" type="number" name="gov"  > 
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-1 control-label" for="ed"> الرقم التعليمي   </label>
                        <div class="col-sm-2">
                            <input id="ed" class="form-control" type="number" name="ed"  >  
                        </div>
                    </div>

                      <div class="form-group">
						<label class="col-sm-1 control-label" for="year"> المرحلة   </label>
						<div class="col-sm-3">
                            <select class="form-control"   name="year" id="year" >
                                <option selected disabled >...</option> 
                                <option value="0"> بري سكول </option> 
                                <option value="1">اولى حضانة</option> 
                                <option value="2">ثانية حضانة</option> 
                                <option value="3">  الصف الاول الابتدائى</option> 
                                <option value="4">  الصف الثانى الابتدائى</option> 
                                <option value="5">  الصف الثالث الابتدائى</option> 
                                <option value="6">  الصف الرابع الابتدائى</option> 
                                <option value="7">  الصف الخامس الابتدائى</option> 
                                <option value="8">  الصف السادس الابتدائى</option> 
                                <option value="9">  الصف الاول الاعدادى</option> 
                                <option value="10">  الصف الثاني الاعدادى</option> 
                                <option value="11">  الصف الثالث الاعدادى</option> 
                                <option value="12">  الصف الاول الثانوى</option> 
                                <option value="13">  الصف الثاني الثانوى</option> 
                                <option value="14">  الصف الثالث الثانوى</option> 

                            </select>
                                    </div>
                        </div> 

                        <div class="form-group">
						 <label class="col-sm-1 control-label" for="submit"> </label>
						 <div class="col-sm-1"> 
						    <button type="submit" class="btn btn-primary btn-block" name="find" id="find" >بحث</button> 
						 </div> 
					  </div>

                     </form>
                  </div> 
                   
                  <?php if(isset($_GET['find'])){ 
                    if($totalRows_get_users_info>0){ ?>
               <div class="col-md-12">        
                <div class="card-body" data-toggle="match-height"  > 
                <table id="court-datatables" class="table table-striped  dataTable" width="100%" style="font-size: 16px;  ">
                    <thead> 
                      <tr> 
                        <th class="text-left"    >الاسم  </th> 
                        <th class="text-center">كود</th>
                        <th class="text-left">المرحلة</th>
                        <?php if($_GET['id']==13 || $_GET['id']==14){?>
                        <th class="text-center">التخصص</th>
                        <?php }?>
                        <th class="text-center">  الفصل</th>  
                        <th class="text-center"> تاريخ الميلاد</th> 
                        <!-- <th class="text-center"> السن في اكتوبر</th> --> 
                        <th class="text-center">الحالة</th> 
                        <!--<th class="text-center">محل الميلاد</th>
                        <th class="text-center">الجنسية  </th>
                        <th class="text-center">رقم القيد   </th> -->
                        <th class="text-center"> </th> 
                      </tr>
                    </thead>
                    <tbody>
						
						<?php  
	                           do{  ?>
                      <tr class="count"> 
                        <td class="text-left"><?php if($row_get_users_info['fn_name']==NULL){echo $row_get_users_info['name'];}else{echo $row_get_users_info['fn_name'];}?></td> 
                        <td class="text-center"><?php echo $row_get_users_info['ed_id'];?></td>   
                        <td class="text-left"><?php echo year_of_study($row_get_users_info['study_year']);?></td> 
                        <?php if($_GET['id']==13 || $_GET['id']==14){?>
                          <td class="text-left"><?php echo study_type($row_get_users_info['study_type']);?></td> 
                        <?php }?>
                        <td class="text-center"><?php echo class_name($row_get_users_info['class']);?></td>    
                        <td class="text-center"><?php if($row_get_users_info['birthday']>0){echo date("m/d/Y",$row_get_users_info['birthday']);}?></td> 
                         <!-- <td class="text-left"><?php //echo convertSecToTime($row_get_users_info['birthday']);?></td> --> 
                         <td class="text-center <?php if($row_get_users_info['transfare']==1){echo ' trans1 ';} if($row_get_users_info['transfare']==2){echo ' trans2 ';} if($row_get_users_info['transfare']==3){echo ' trans3 ';} ?>">
                            <?php if($row_get_users_info['transfare']==1){echo " مستجد";}
                                  if($row_get_users_info['transfare']==2){echo " منقول";}
                                  if($row_get_users_info['transfare']==0){echo " باقي";}  ?>
                        </td>
                          
                      <!--  <td class="text-center"><?php //echo $row_get_users_info['birth_place'];?></td> 
                        <td class="text-center"><?php //echo $row_get_users_info['nationality'];?></td> 
                        <td class="text-center"><?php //echo $row_get_users_info['id'];?></td> -->
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                              التحكم
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"> 
                            <li><a href="view-kid.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-eye" aria-hidden="true" style="color: green"></i>  عرض </a></li>
                            <li><a href="edit-kid.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: green"></i>  تعديل </a></li>
                            <?php if($row_get_users_info['linked']==1){?>
                            <li><a href="request-kid.php?id=<?php echo $row_get_users_info['id'];?>" >  <i class="fa fa-handshake-o" aria-hidden="true" style="color: green"></i>  رساله </a></li>
                            <?php }?>   
                                <?php if($row_get_users_info['id']!=1){?>
                              <li role="separator" class="divider"></li> 
								<li><a href="edit-kid.php?del=<?php echo $row_get_users_info['id'];?>" onClick="return confirm('تاكيد؟');">  <i class="fa fa-trash-o" aria-hidden="true" style="color: red"></i>  حذف </a></li>
                                <?php }?>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <?php }while($row_get_users_info = mysqli_fetch_assoc($get_users_info));?> 
                     
                     
                    </tbody>
                  </table>


                </div> 
				</div>
                <?php }else{?>
                    <h2 style="padding: 20px; color: red"> <i class="fa fa-frown-o fa-lg" aria-hidden="true"></i>   لا يوجد نتائج  </h2>
                <?php } }?>


		    </div>
           
			
			 
			
			
        </div>
      </div>
		
		
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
            order: [
                [0, "asc"]
            ],
            "aoColumnDefs": [
               { "bSortable": false,
			     "aTargets": [ <?php if($_GET['id']==13 || $_GET['id']==14){echo 7;}else{echo 6;}?> ]  
			   }
			 ]
        }); 
          
         
        var reg1 = $('.reg1').length;
        $('#reg1').text(reg1);

        var reg2 = $('.reg2').length;
        $('#reg2').text(reg2);

        var trans1 = $('.trans1').length;
        $('#trans1').text(trans1);

        var trans2 = $('.trans2').length;
        $('#trans2').text(trans2);

        var trans3 = $('.trans3').length;
        $('#trans3').text(trans3);

        var count = $('.count').length;
        $('#count').text(count);

$("input").keyup(function(){
        var reg1 = $('.reg1').length;
        $('#reg1').text(reg1);

        var reg2 = $('.reg2').length;
        $('#reg2').text(reg2);

        var trans1 = $('.trans1').length;
        $('#trans1').text(trans1);

        var trans2 = $('.trans2').length;
        $('#trans2').text(trans2);

        var trans3 = $('.trans3').length;
        $('#trans3').text(trans3);

        var count = $('.count').length;
        $('#count').text(count);

});




        
	  });
 </script>
	  
	  
  </body> 
</html> 
<?php }else{header("location: home.php");exit();}?>