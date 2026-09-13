<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub9']==1){
 
    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids` where `ed_id`= '{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);  
  

 



 function  evaluation_comment($degree,$total){ 
    if((($degree/$total)*100)>=85 && (($degree/$total)*100)<=100){return "ممتاز ";}
    if((($degree/$total)*100)>=65 && (($degree/$total)*100)<85){return "جيد جدا";}
    if((($degree/$total)*100)>=50 && (($degree/$total)*100)<65){return "جيد";}
    if((($degree/$total)*100)<50){return "ضعيف";}
}

 function  evaluation_comment2($degree,$total){ 
    if((($degree/$total)*100)>=50){return "اجتاز ";}else{return "لم يجتاز";}
}


function convertToArabicNumbers($number) {
    $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    return strtr($number, array_combine(range(0, 9), $arabicNumbers));
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
 
  <body class="layout layout-header-fixed" style="background-color: white !important;">  
  
  <div class="container">   



<form action="kid_print_cert_travel.php"  method="get" name="form1" id="demo-inputmask"  enctype="multipart/form-data" class="form form-horizontal">
                    
                    
            
<?php if(!isset($_GET['print'])){?>


 <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">    تاريخ الميلاد</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="birthday"     >
              </div>
            </div> 


			      <div class="form-group">
              <label class="col-sm-3 control-label" for="year">  السنه الدراسية </label>
              <div class="col-sm-6">
                <input id="year" class="form-control" required type="text" name="year" placeholder="2024 /   2025"  >
              </div>
            </div>  
            
            <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  للعام الدراسى</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="to"  placeholder="2025/ 2026"   >
              </div>
            </div>  

            <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  لتقديمة الى</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="place"  placeholder="مدرسة  بدولة السعودية"   >
              </div>
            </div> 


             <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  الرسم المقرر وقدره</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees"  placeholder="عشرة  جنيهات"   >
              </div>
            </div> 


           <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">      رقم الحواله</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees_number"    >
              </div>
            </div> 

             <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  بتاريخ الرسوم المقرر  </label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees_date"    >
              </div>
            </div> 

            <?php if($row_get_kid_info['study_year']==2){?>

   <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  الرسم المقرر وقدره</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees2"  placeholder="عشرة  جنيهات"   >
              </div>
            </div> 


           <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">      رقم الحواله</label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees_number2"    >
              </div>
            </div> 

             <div class="form-group">
            <label class="col-sm-3 control-label" for="fn_name">  بتاريخ الرسوم المقرر  </label>
              <div class="col-sm-6">
                <input  class="form-control" style="text-align: right;"   type="text" name="fees_date2"    >
              </div>
            </div> 




            <?php }?> 

            <div class="form-group">
						   <label class="col-sm-3 control-label" for="submit"> </label>
                <div class="col-sm-2"> 
                  <button type="submit" name="print" class="btn btn-danger btn-block">عرض</button> 
                </div> 
            </div>
            
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />

</form>
<?php }else{?>

 


    <div class="row" style="margin-top: -20px;">
      <div class="col-xs-4"> 
          <h3 style="color: black; font-weight:bold; font-size:22px; padding:0px; margin:0px; line-height:24px; text-align:right">
            محافظة الإسكندرية
            <br>  ادارة شرق التعليمية 
            <br>  العام الدراسي 
            <br>  رياض الأطفال 
            <br> مدارس هلالية الخاصة للغات
             
          </h3>  
      </div>
 
      <div class="col-xs-3"> </div>
     
      <div class="col-xs-5" align="left"> 
        <h3 style="text-align: left;padding:0px; margin:0px; line-height:20px; font-size:20px;"> </h3> 
        
      </div>

      <div class="col-xs-12"> 
         <h2 style="text-align: center; color: black;  font-size:24px; padding:0px; margin:0px; font-weight:bold; margin-top:50px">بيــــــــــــان قيـــــــــــد/نجــــــــاح</h2> 
      </div>
     
    </div>

 


    <div class="row" style="padding-top:0px">
        <div class="col-xs-12" dir="rtl"> 
            
<p style="font-size:22px; font-weight:bold; color:black; line-height:42px; text-align:right; padding:10px">
  بالكشف فى سجلات قيد الصف الاول رياض الاطفال لمدرسة هلاليه للغات

<br>

نوعها خاص فى العــــــــــــــــــام الدراســــــــــــى         <?php echo $_GET['year'];?> 

<br>

وجد ان الطالب/  <?php echo $row_get_kid_info['name'];?> المولود بتاريخ: <?php echo $_GET['birthday'];?>

<br>

منقول من الصف <?php if($row_get_kid_info['study_year']==1){echo "الاول";}else{echo "الثاني";}?>  رياض الأطفال الى الصف <?php if($row_get_kid_info['study_year']==1){echo  " الثانى رياض الاطفال ";}else{echo  " الاول الابتدائي ";}?> للعام الدراسى: <?php echo $_GET['year'];?>  م  

<br>

وقد استخرج هذا البيان بناء على طلب ولى الأمر لتقديمة الى/  <?php echo $_GET['place'];?>  

<br>

 على الإدارة او الوزارة وقد سدد الرسم المقرر وقدره /   <?php echo $_GET['fees'];?> بحوالة بريدية 

<br>

رقم : <?php echo $_GET['fees_number'];?>    / بتاريخ :    <?php echo $_GET['fees_date'];?>   

<br>

<?php if($row_get_kid_info['study_year']==2){?>

ورسم النقل /التحويل بمبلغ <?php echo $_GET['fees2'];?>
 -  بحوالة بريدية رقم:
 <?php echo $_GET['fees_number2'];?>
 بتاريخ :-
 <?php echo $_GET['fees_date2'];?> 
 <br>
<?php }?> 



الجهة المرسل اليها طلب القيد/ <?php echo $_GET['place'];?>

</p> 
 

 
 
 
        <div class="col-xs-4" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">شئون طلبه <br> جيلان فريج </h3></div>
        <div class="col-xs-4" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">  </h3></div>

        <div class="col-xs-4" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; margin-top:-4px">مديرة المدرسة  
          <br>                                                  
	ا/ عزه فرج 
        </h3></div>



      </div>

  <script>
  window.addEventListener('load', () => {
    window.print();
  });
</script>

<?php }?>

  </div> 
    <?php include("includes/footer-script.php");?> 
    <script src="js/application.min.js"></script>
    
 
	
	 
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>