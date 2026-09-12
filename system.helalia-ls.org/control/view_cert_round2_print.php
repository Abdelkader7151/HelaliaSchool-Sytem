<?php require_once('includes/access.php');
 require_once('includes/logout.php');
 require_once('../Connections/database.php');
 require_once('includes/functions.php');
 require_once('includes/cert-pass.php');

 if($row_get_login['access16']==1){

      mysqli_select_db($database , $database_database);
      $query_get_certificate = "SELECT * FROM `certificate` WHERE `id` = '{$_GET['id']}' AND `type` = 4 ORDER BY `id` ASC  ";
      $get_certificate = mysqli_query($database , $query_get_certificate) or die(mysqli_error($database));
      $row_get_certificate = mysqli_fetch_assoc($get_certificate);
      $totalRows_get_certificate = mysqli_num_rows($get_certificate);

      if($totalRows_get_certificate == 0){
        echo "Certificate not found.";
        exit();
      }

      mysqli_select_db($database , $database_database);
      $query_get_kids_info = "SELECT * FROM `kids` where `ed_id` = '{$row_get_certificate['gov_id']}'";
      $get_kids_info = mysqli_query($database , $query_get_kids_info) or die(mysqli_error($database));
      $row_get_kids_info = mysqli_fetch_assoc($get_kids_info);

      function head_name($year){
        if($year<6){ return "Mrs. Reem El Kordy";}       // Junior One–Three (and below)
        if($year>5 && $year<9){ return "Mrs. Nashwa Ahmed";} // Junior Four–Six
        if($year>8 && $year<12){ return "Mr. Mohamed Mahdy";} // Middle (fallback)
        if($year>11){ return "Mr. Hazem Mohamed Hamed";}   // Senior
      }

      function head_number($year){
        if($year<6){ return 1;}
        if($year>5 && $year<9){ return 2;}
        if($year>8 && $year<12){ return 3;}
        if($year>11){ return 4;}
      }

      function head_name_mid($gender){
        // Middle One–Three: different head by gender
        if($gender=='ذكر'){ return  "Mr. Mohamed Mahdy";  }
        if($gender=='أنثى'){ return  "Mrs. Doaa Mobarak";  }
        return head_name(9);
      }

      function head_number_mid($gender){
         if($gender=='ذكر'){ return  3; }
         if($gender=='أنثى'){ return  5; }
         return 3;
      }

      $title_eng = $row_get_certificate['title_eng'] ? $row_get_certificate['title_eng'] : 'Second Sitting';
      $study_year = intval($row_get_certificate['study_year']);
      $is_middle = ($study_year > 8 && $study_year < 12);
      $dept_img_num = $is_middle ? head_number_mid($row_get_kids_info['gender']) : head_number($study_year);
      $dept_head_name = $is_middle ? head_name_mid($row_get_kids_info['gender']) : head_name($study_year);
?>
<!DOCTYPE html>
<html>
 <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <title>Helalia — Second Sitting</title>
        <meta content="Helalia" name="description" />

    <link rel="icon" type="image/png" sizes="32x32" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link href="../app/mobile/eng/assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../app/mobile/eng/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" id="main-style"/>

<style>
  body{ background-color: #f9f1e2 !important; }
  td{ padding:3px !important; line-height: 16px !important;}
  td strong{  line-height: 16px !important;}
  th{ padding:3px !important}
  /* Keep logos at the same visual size as the old certificates (prevent CSS shrink) */
  .cert-logo{ width: 110px !important; max-width: none !important; height: auto !important; display: inline-block; }
  .cert-table{ width: 100% !important; min-width: 100% !important; table-layout: fixed !important; font-size: 14px !important; border: solid 1px black; color: black; margin-bottom: 25px; border-collapse: collapse; }
  .cert-table td{ font-size: 14px !important; padding: 8px 6px !important; }
  @media print {
    body { background-color: #ffffff !important; }
  }
</style>
</head>

<body class="html" data-header="light" data-footer="dark" data-header_align="center" data-menu_type="left" data-menu="light" data-menu_icons="on" data-footer_type="left" data-site_mode="light" data-footer_menu="show" data-footer_menu_style="light">

  <div class="container-fluid" style="padding-bottom: 10px; padding-top:0px; padding-right:0px; width:560px; margin-right:auto; margin-left:auto" >

  <table style="width: 100%; border-collapse: collapse; margin-top:40px;-webkit-box-shadow:none; background-color:transparent;" border="0" >
        <tr style="border: none;">
            <td style="text-align: center; vertical-align:middle; color: black; font-size:10px; padding:0px; border: none; font-weight:bold; line-height: 18px; padding:2px"   width="33%">
               <img src="../app/mobile/eng/images/logo.png" class="img-responsive cert-logo" width="110" />
             </td>

             <td style="text-align: center; color: black; font-size:14px; padding:0px; border: none;" width="34%">
               <strong style="font-size: 14px !important;"><?php echo htmlspecialchars($title_eng);?></strong><br>
               <?php echo year_of_study_eng($row_get_certificate['study_year']);?>
             </td>

             <td style="text-align: center; color: black; font-size:10px; vertical-align:top; padding:0px; border: none; font-weight:bold; padding:2px"   width="33%">
               <img src="../app/mobile/eng/images/cambridge.png" class="img-responsive cert-logo" width="110" />
             </td>

        </tr>
    </table>

    <p style="font-size:10px !important; padding-left:50px">
       <strong style="font-size:14px !important;  ">Name: <?php echo $row_get_kids_info['fn_name'];?></strong>
    </p>

    <div style="padding-left: 20px; padding-right:20px" >

<?php
$has_subjects = false;
for($i=1;$i<=30;$i++){
  if(!empty($row_get_certificate['subject'.$i.'_name']) && floatval($row_get_certificate['subject'.$i.'_total']) > 0){
    $has_subjects = true;
    break;
  }
}
if($has_subjects){ ?>
<table class="cert-table" style="font-size: 14px !important; width:100%; min-width:100%; table-layout:fixed; border:solid 1px black; color:black; margin-bottom:25px" border="1">
     <tr style="background-color: #eed484;">
         <td align="center"  style="text-align: center; font-size: 14px !important; border:solid 1px black;  background-color:#eed484 "><strong style="font-size:12px !important;  ">Subject</strong></td>
         <td align="center" width="40%" style="text-align: center; font-size: 14px !important; border:solid 1px black;  background-color:#eed484 "><strong style="font-size:12px !important;  ">Total </strong></td>
     </tr>
     <?php
     for($i=1;$i<=30;$i++){
            if(!empty($row_get_certificate['subject'.$i.'_name']) && floatval($row_get_certificate['subject'.$i.'_total']) > 0){ ?>
            <tr>
                <td align="center"  style="text-align: center; font-size: 14px !important; border:solid 1px black;  "><?php echo htmlspecialchars($row_get_certificate['subject'.$i.'_name']);?></td>
                <td align="center" style="text-align: center; font-size: 14px !important; border:solid 1px black  "><?php echo round($row_get_certificate['subject'.$i],2); ?></td>
            </tr>
     <?php    }
     } ?>
 </table>
<?php } else { ?>
  <p style="text-align:center; color:#666;">No subjects found for this certificate.</p>
<?php }

$pass = helalia_cert_is_pass($row_get_certificate);
if ($pass) {
  if ((int) $row_get_certificate['study_year'] === 14) { ?>
       <h2 style="text-align:center; font-size:20px; line-height:20px; color:black">Congratulations on your well-deserved success.</h2>
  <?php } else { ?>
       <h2 style="text-align:center; font-size:20px; line-height:20px; color:black">Congratulations! Promoted to<br><?php echo year_of_study_eng(($row_get_certificate['study_year']+1));?> </h2>
  <?php }
} ?>


    <table style="width: 100%; margin-top:30px; border:collapse !important; border:none !important ; background-color:transparent; -webkit-box-shadow:none "   border="0" >
          <tr style="border-bottom:none !important">
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">Head of Control</td>
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">Head of Department</td>
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">School Principal </td>
          </tr>
           <tr style="border-bottom:none !important">
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/control.png" width="90%"  /></td>
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/department<?php echo intval($dept_img_num);?>.png" width="90%"   /></td>
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/principal.png" width="90%"   /></td>
          </tr>
          <tr style="border-bottom:none !important">
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important ">Dr. Mohamed Saied</td>
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important "><?php echo $dept_head_name;?></td>
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important ">Mrs. Azza Farag</td>
           </tr>
    </table>

    </div>
  </div>

<script src="../app/mobile/eng/assets/js/jquery-2.2.4.min.js"></script>
</body>
</html>
<?php }else{header("location: home.php");exit();}?>
