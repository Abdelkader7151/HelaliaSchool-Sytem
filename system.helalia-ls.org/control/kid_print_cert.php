<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access7sub9']==1){
 
    mysqli_select_db($database, $database_database); 
    $query_get_kid_info = "SELECT * FROM `kids` where `ed_id`='{$_GET['id']}'  ";
    $get_kid_info = mysqli_query($database,$query_get_kid_info) or die(mysqli_error($database));
    $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
    $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);  
 
      mysqli_select_db($database , $database_database,);
      $query_get_certificate = "SELECT * FROM `success_statement` WHERE `id` = '{$_GET['cert']}' ";
      $get_certificate = mysqli_query($database , $query_get_certificate) or die(mysqli_error($database));
      $row_get_certificate = mysqli_fetch_assoc($get_certificate);
      $totalRows_get_certificate = mysqli_num_rows($get_certificate);

    mysqli_select_db($database, $database_database); 
    $query_get_seats = "SELECT * FROM `seats` where `ed_id`='{$_GET['id']}'  ";
    $get_seats = mysqli_query($database,$query_get_seats) or die(mysqli_error($database));
    $row_get_seats = mysqli_fetch_assoc($get_seats);
    $totalRows_get_seats = mysqli_num_rows($get_seats);



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
    <div class="row" style="margin-top: -20px;">
      <div class="col-xs-4"> 
          <h3 style="color: black; font-size:18px; padding:0px; margin:0px; line-height:24px; text-align:center">محافظة الإسكندرية
            <br>  ادارة شرق التعليمية
            <br>  مدرسة الهلالية للغات
            <br>  العام الدراسي <?php 
            
              echo convertToArabicNumbers($row_get_certificate['year'])."/".convertToArabicNumbers($row_get_certificate['year']-1);  

              
             ?> 
          </h3>  
      </div>
 
      <div class="col-xs-3"> </div>
     
      <div class="col-xs-5" align="left"> 
        <h3 style="text-align: left;padding:0px; margin:0px; line-height:20px; font-size:20px;">(أي كشط أو محو أو تغير يلغيه)</h3> 
          <img src="img/logo.png" style="width: 100px; float:left;  padding:0px; margin:0px; line-height:20px; margin-left:50px"> 
      </div>

      <div class="col-xs-12"> 
         <h2 style="text-align: center; color: black;  font-size:24px; padding:0px; margin:0px; font-weight:bold; margin-top:-20px">بيان نجاح طالب / درجات</h2> 
      </div>
    
      <div class="col-xs-8"> 
        <p style="color: black; font-size:16px; line-height:20px; font-weight: bold;  ">        
        بالكشف في سجلات قيد امتحان  <?php  echo year_of_study($row_get_certificate['study_year']);?> <?php if($row_get_certificate['type']==2){echo "نصف العام";}else{echo "نهاية العام";}?> وجد أن:-
        <br>
        التلميذ:- <span style="color: black; font-size:18px; font-weight:bold"><?php echo $row_get_kid_info['name'];?></span>
        <br>
        مقيد بمدرسة:- <strong>مدرسة الهلالية للغات</strong>
        <br> 
         المولود بتاريخ:-  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp    و السن في اول اكتوبر ...../...../.....<?php echo convertToArabicNumbers(20);?> 
        </p> 
      </div>

      <div class="col-xs-4"> 
        <p style="color: black; font-size:16px; text-align:center"> العام الدراسي <?php 
             
              echo convertToArabicNumbers($row_get_certificate['year'])."/".convertToArabicNumbers($row_get_certificate['year']-1);  
             ?>  
             <br>
        رقم الجلوس:- <?php  echo convertToArabicNumbers($row_get_seats['seat_id']);?> </p>  

            <table border="0" >
                <tr>
                  <td style="color: black; font-size:18px; text-align:center; font-weight: bold;"> يوم </td>
                  <td style="color: black; font-size:18px; text-align:center; font-weight: bold;"> شهر </td>
                  <td style="color: black; font-size:18px; text-align:center; font-weight: bold;"> سنة </td> 
                </tr>
                <tr>
                  <td style="color: black; font-size:16px; text-align:center; border: solid 1px black; width: 50px; height: 40px;">   </td>
                  <td style="color: black; font-size:16px; text-align:center; border: solid 1px black; width: 50px; height: 40px;">   </td>
                  <td style="color: black; font-size:16px; text-align:center; border: solid 1px black; width: 50px; height: 40px;">   </td> 
                </tr>
            </table>
      </div>

    <div class="col-xs-12" style="text-align: center;">
      <h3 style="text-align: center; font-size:24px; color:black; font-weight:bold; margin:0px; padding:0px">وبيان درجاته / تقديراته كالأتى:-
      </h3>
    </div>
     
    </div>

    <div class="row">
        <div class="col-xs-12" dir="rtl"> 
            

    <?php
$total_subject_phases_total_switch = 0; 
$total_subject_switch = 0; 
$Ministry = 0;
$Ministry_total = 0;
$pass = 1;

    ?>

<table style="font-size: 18px; border:solid 1px black; color:black; margin:0px; padding:0px; margin-top:10px;  width:100%" border="1">  

     <tr style="background-color:gray;">
         <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  background-color:gray "><strong style="font-size:18px !important;  ">المادة</strong></td> 
         <?php if( $row_get_certificate['study_year'] != 3 && $row_get_certificate['study_year'] != 4) { ?>
         <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  background-color:gray "><strong style="font-size:18px !important;  ">  النهاية العظمى </strong>  </td>  
         <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  background-color:gray "><strong style="font-size:18px !important;  ">  درجة التلميذ </strong> </td>  
         <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  background-color:gray "><strong style="font-size:18px !important;  ">  التقدير </strong> </td>  
         <?php }else{?>  
         <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  background-color:gray "><strong style="font-size:18px !important;  ">  درجة التلميذ </strong> </td>   
        <?php }?>
          
     </tr> 

     <?php if( $row_get_certificate['study_year'] != 3 && $row_get_certificate['study_year'] != 4) {

     $total_max = 0;
     $total_subject = 0;
     $total_phases = 0;
     $total_subject_phases_total = 0;
     $total_degree  = 0;
     $total_subject_degree_total = 0;
     $x=0;
     
     for($i=1;$i<31;$i++){
            if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==1){$x++;  ?>   
            <tr>

                <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black;  "><?php echo $row_get_certificate['subject'.$i.'_name_arb'];?></td>   
                <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo convertToArabicNumbers($row_get_certificate['subject'.$i.'_total']); ?></td>
                <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo convertToArabicNumbers($row_get_certificate['subject'.$i]); $total_max += $row_get_certificate['subject'.$i.'_total']; $total_subject += $row_get_certificate['subject'.$i]; ?></td>
                <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo evaluation_comment($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);    ?></td>
           
             </tr>
     <?php } } if($x>0){  ?> 
     <tr>
         <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:gray  "><strong style="font-size: 18px;"> المجموع الكلى </strong></td>
         <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:gray  "  ><span style="font-size: 18px;" ><?php echo convertToArabicNumbers($total_max);  ?></span></td> 
         <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:gray  "  ><span style="font-size: 18px;" ><?php echo convertToArabicNumbers($total_subject) ;  ?></span></td> 
         <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:gray  "  ><?php echo evaluation_comment($total_subject,$total_max);    ?></td> 
    </tr>  

    <?php }

 

for($i=1;$i<31;$i++){
       if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==2){ ?>   
       <tr> 
           <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black; "><?php echo $row_get_certificate['subject'.$i.'_name_arb'];?></td>  
           <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo convertToArabicNumbers($row_get_certificate['subject'.$i.'_total']);   ?></td>
           <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo convertToArabicNumbers($row_get_certificate['subject'.$i]);  ?></td> 
           <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo evaluation_comment($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);  ?></td>  
        </tr>
<?php } } 

       }

for($i=1;$i<31;$i++){
       if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==0){ ?>   
       <tr> 
           <td align="center"  style="text-align: center; font-size: 18px; border:solid 1px black; "><?php echo $row_get_certificate['subject'.$i.'_name_arb'];?></td>   
            <?php  if( $row_get_certificate['study_year'] != 3 && $row_get_certificate['study_year'] != 4) {?>
           <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "> </td>  
           <?php }?>
           <td align="center" style="text-align: center; font-size: 18px; border:solid 1px black  "><?php echo evaluation_comment2($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);  ?></td>  
          <?php  if( $row_get_certificate['study_year'] != 3 && $row_get_certificate['study_year'] != 4) {?>
           <td align="center"   style="text-align: center; font-size: 18px; border:solid 1px black  "> </td>  
        <?php }?>
        </tr>
<?php } } ?> 



 </table> 
  
  <div class="col-xs-12" style="text-align: center; margin-bottom:20px;  ">
    <p style="text-align: right; font-size:18px; color:black; margin:0px; margin-top:10px; padding:0px"> منقول إلى الصف -:</p>
    <p style="text-align: right; font-size:18px; color:black; margin:0px; margin-top:20px; padding:0px"> وقد أستخرج هذا البيان بعد سداد</p>
    <p style="text-align: center; font-size:18px; color:black; margin:0px; margin-top:0px; padding:0px"> 
  الرسوم المقرر و قدره / ................ بحوالة أميرية رقم / ............ مجموعة / ............ بتاريخ /..............
  <br>
  و رســــــــــــــم قدرة / ................ بحوالة أميرية رقم / ............ مجموعة / ............ بتاريخ /..............
  <br>
  تم استخراج هذا البيان بناء على طلب ولي الأمر وذلك لتقديمها إلى:- ......................................
  
    </p>
 </div>

 <div class="col-xs-2" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">  الحسابات </h3></div>
 <div class="col-xs-2" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">شئون الطلبة </h3></div>
 <div class="col-xs-3" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">رئيس لجنة النظام و المراقبة </h3></div>
 <div class="col-xs-3" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; padding:0px; margin:0px">مدير المدرسة
   <br>
أ/عزة فرج</h3></div>

 <div class="col-xs-2" style="text-align: center;"><h3 style="font-size: 18px; font-weight:bold; margin-top:-4px">مدير التعليم  
 <?php echo year_of_study2($row_get_certificate['study_year']);?></h3></div>



    </div>





  </div> 
    <?php include("includes/footer-script.php");?> 
    <script src="js/application.min.js"></script>
    
 
	  
	 
  
  </body>
 
</html>

<?php }else{header("location: home.php;");exit();}?>