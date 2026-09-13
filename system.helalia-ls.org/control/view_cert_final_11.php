<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

 if($row_get_login['access16']==1){


      mysqli_select_db($database , $database_database,);
      $query_get_certificate = "SELECT * FROM `certificate` WHERE `id` = '{$_GET['id']}' ORDER BY `id` ASC  ";
      $get_certificate = mysqli_query($database , $query_get_certificate) or die(mysqli_error($database));
      $row_get_certificate = mysqli_fetch_assoc($get_certificate);
      $totalRows_get_certificate = mysqli_num_rows($get_certificate);

      if($row_get_certificate['study_year']!=11){ 
        header("location: view_cert_big.php?id=".$_GET['id']); 
        exit();
      }

      mysqli_select_db($database , $database_database,);
      $query_get_cert_settings = "SELECT * FROM `cert_settings`   ";
      $get_cert_settings = mysqli_query($database , $query_get_cert_settings) or die(mysqli_error($database));
      $row_get_cert_settings = mysqli_fetch_assoc($get_cert_settings);
      $totalRows_get_cert_settings = mysqli_num_rows($get_cert_settings);


        mysqli_select_db($database , $database_database,);
        $query_get_kids_info = "SELECT * FROM `kids` where `ed_id` = '{$row_get_certificate['gov_id']}'";
        $get_kids_info = mysqli_query($database , $query_get_kids_info) or die(mysqli_error($database));
        $row_get_kids_info = mysqli_fetch_assoc($get_kids_info);
        $totalRows_get_kids_info = mysqli_num_rows($get_kids_info);

 

        function subject_name_return($name){
            return $name;
        }

       

        function Coursework($year){
          if($year<9){ return 40;}
          if($year>8 && $year<12){ return 70;}
          if($year>11){ return 70;}  
        }

        function TermExam($year){
          if($year<9){ return 60;}
          if($year>8 && $year<12){ return 30;}
          if($year>11){ return 30;}  
        }




        

        function head_name($year){ 
          if($year<6){ return "Mrs. Reem El Kordy";}
          if($year>5 && $year<9){ return "Mrs. Nashwa Ahmed";}
          if($year>8 && $year<12){ return "Mr. Mohamed Mahdy";}
          if($year>11){ return "Mr. Hazem Mohamed Hamed";}  
        }

        function head_number($year){
                if($year<6){ return 1;}
                if($year>5 && $year<9){ return 2;}
                if($year>8 && $year<12){ return 3;}
                if($year>11){ return 4;}
        }



        function head_name_mid($gender){ 
          if($gender=='ذكر'){ return  "Mr. Mohamed Mahdy";  }
          if($gender=='أنثى'){ return  "Mrs. Doaa Mobarak";  }   
        }

        function head_number_mid($gender){ 
           if($gender=='ذكر'){ return  3; }
           if($gender=='أنثى'){ return  5; }   
        }
         

  function evaluation_comment_term($degree,$total){ 
    if((($degree/$total)*100)>=85 && (($degree/$total)*100)<=100){return "Excellent";}
    if((($degree/$total)*100)>=65 && (($degree/$total)*100)<85){return "Very Good";}
    if((($degree/$total)*100)>=50 && (($degree/$total)*100)<65){return "Fair";}
    if((($degree/$total)*100)<50){return "Weak";}
  }

  function evaluation_comment_Course($degree,$total){ 
    if((($degree/$total)*100)>=85 && (($degree/$total)*100)<=100){return "Excellent";}
    if((($degree/$total)*100)>=65 && (($degree/$total)*100)<85){return "Very Good";}
    if((($degree/$total)*100)>=50 && (($degree/$total)*100)<65){return "Fair";}
    if((($degree/$total)*100)<50){return "Weak";}
  }


 

  function evaluation_comment($degree,$total){ 
    if((($degree/$total)*100)>=85 && (($degree/$total)*100)<=100){return "Excellent";}
    if((($degree/$total)*100)>=65 && (($degree/$total)*100)<85){return "Very Good";}
    if((($degree/$total)*100)>=50 && (($degree/$total)*100)<65){return "Fair";}
    if((($degree/$total)*100)<50){return "Weak";}
}

function evaluation_comment2($degree,$total){ 
  if((($degree/$total)*100)>=50){return "Pass";}else{return "Failed";}
}


function evaluation_color2($degree,$total){ 
  if((($degree/$total)*100)>=85 && (($degree/$total)*100)<=100){return "blue";}
  if((($degree/$total)*100)>=65 && (($degree/$total)*100)<85){return "green";}
  if((($degree/$total)*100)>=50 && (($degree/$total)*100)<65){return "yellow";}
  if((($degree/$total)*100)<50){return "red";}
}
 

function Place_order($id){
  switch($id){
    case 1:
      return "1<sup>st</sup> Place";
      break;

    case 2:
      return "2<sup>nd</sup> Place";
      break;

    case 3:
      return "3<sup>rd</sup> Place";
      break;

    case 4:
      return "4<sup>th</sup> Place";
      break;

    case 5:
      return "5<sup>th</sup> Place";
      break;

    case 6:
      return "6<sup>th</sup> Place";
      break;

    case 7:
      return "7<sup>th</sup> Place";
      break;

    case 8:
      return "8<sup>th</sup> Place";
      break;

    case 9:
      return "9<sup>th</sup> Place";
      break;

    case 10:
      return "10<sup>th</sup> Place";
      break;  
  }  
}


?>
<!DOCTYPE html>
<html>

 <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <title>Helalia   </title>
        <meta content="Helalia" name="description" />
        <meta content="themepassion" name="author" />


    <!-- App Icons -->
    <link rel="apple-touch-icon" sizes="57x57" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../app/mobile/eng/assets/images/icons/logo.png">
    <link rel="manifest" href="../app/mobile/eng/assets/images/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../app/mobile/eng/assets/images/icons/logo.png">
    <meta name="theme-color" content="#ffffff">






        <!-- CORE CSS FRAMEWORK - START -->
        <link href="../app/mobile/eng/assets/css/preloader.css" type="text/css" rel="stylesheet" media="screen,projection"/>

        <link href="../app/mobile/eng/assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="../app/mobile/eng/assets/fonts/mdi/materialdesignicons.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="../app/mobile/eng/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection"/>


        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
                <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

        <!-- CORE CSS TEMPLATE - START -->


                <link href="../app/mobile/eng/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" id="main-style"/>
        <!-- CORE CSS TEMPLATE - END -->

        <script src="https://use.fontawesome.com/00bc8e036a.js"></script>
 
<style> 
  body{ background-color: #f9f1e2 !important; }
  
  .sidenav.sidemenu li.exit a:after { display: none !important; }
  .btn-large{ height:35px !important; line-height:25px !important;   margin-top: -5px !important; padding-right:12px !important; padding-left:12px !important}

  <?php if(isset($_SESSION['MM_Username']) && $row_get_user['colors']==2){ ?>

    *{color:white !important}

  <?php }?>

 @keyframes fadeinout_nav {
0% { opacity: 0; font-size: 8px;  }
50% { opacity: 1; font-size: 12px !important; }
100% { opacity: 0; font-size: 8px; }
}

@keyframes bell_nav {
  0% { transform: rotate(0); }
  15% { transform: rotate(5deg); }
  30% { transform: rotate(-5deg); }
  45% { transform: rotate(4deg); }
  60% { transform: rotate(-4deg); }
  75% { transform: rotate(2deg); }
  85% { transform: rotate(-2deg); }
  92% { transform: rotate(1deg); }
  100% { transform: rotate(0); }
}

 
            td{ padding:3px !important; line-height: 16px !important;}
            td strong{  line-height: 16px !important;}
            th{ padding:3px !important}  
        </style>

    </head>
     <style>
            @media print {
                body {
                    background-color: #ffffff !important;
                }
            }
        </style>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->

 
    <body class="html" data-header="light" data-footer="dark"  data-header_align="center"  data-menu_type="left" data-menu="light" data-menu_icons="on" data-footer_type="left" data-site_mode="light" data-footer_menu="show" data-footer_menu_style="light"> 
     
  

  <div class="container-fluid" style="padding-bottom: 10px; padding-top:10px; padding-right:0px; padding-top:0px; width:500px; margin-right:auto; margin-left:auto" >

  
 <table style="width: 100%; border-collapse: collapse; margin-top:40px;-webkit-box-shadow:none; background-color:transparent;" border="0" >
        <tr style="border: none;">
            <td style="text-align: center; vertical-align:middle; color: black; font-size:10px; padding:0px; border: none; font-weight:bold; line-height: 18px; padding:2px"   width="33%"> 
               <img src="../app/mobile/eng/images/logo.png" class="img-responsive " width="60px" /> 
             </td>

             <td style="text-align: center; color: black; font-size:12px; padding:0px; border: none;" width="34%">
               <strong style="font-size: 12px !important;"><?php echo $row_get_certificate['title_eng'];?></strong><br>
               <?php echo year_of_study_eng($row_get_certificate['study_year']);?>
             </td>

             <td style="text-align: center; color: black; font-size:10px; vertical-align:top; padding:0px; border: none; font-weight:bold; padding:2px"   width="33%">
               <img src="../app/mobile/eng/images/cambridge.png" class="img-responsive " width="60px" /> 
             </td>

        </tr>
    </table>

    <p style="font-size:10px !important; padding-left:50px">
     <?php if($row_get_certificate['order']>0){?>
       <strong style="text-align: right;float:right; color:blue; font-size:20px; padding-right:20px">  <?php echo Place_order($row_get_certificate['order']);?></strong>
    <?php }?> 

       <strong style="font-size:14px !important;  ">Name: <?php echo $row_get_kids_info['fn_name'];?>  <br>
                                                    Absence: <?php echo cert_absence($row_get_kids_info['id'],$row_get_certificate['study_year']);?>  </strong> 
    </p>




  <div style="padding-left: 20px; padding-right:20px" >




    <?php
$total_subject_phases_total_switch = 0; 
$total_subject_switch = 0; 
$Ministry = 0;
$Ministry_total = 0;
$pass = 1;

     for($i=1;$i<31;$i++){
     if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==1){?>
        <?php 
        $total_subject_phases_total_switch += $row_get_certificate['subject'.$i.'_phases_total'];   
        $total_subject_switch += $row_get_certificate['subject'.$i.'_total'];  
        ?> 
         
     <?php }} 
     if($total_subject_switch>0){?>

<table style="font-size: 12px; border:solid 1px black; color:black; margin-bottom:25px" border="1">  
    <tr style="background-color: #eed484;">   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 35%; "><strong style="font-size:10px !important;  "> Subject </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Max </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Mark </strong> </td>   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 25%; "><strong style="font-size:10px !important;  "> Grade </strong> </td>   
    </tr>

     <?php

     $total_max = 0;
     $total_subject = 0;
     $total_phases = 0;
     $total_subject_phases_total = 0;
     $total_degree  = 0;
     $total_subject_degree_total = 0;
     
     for($i=1;$i<31;$i++){
            if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==1){ ?>   
            <tr> 
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black;  "><?php echo subject_name_return($row_get_certificate['subject'.$i.'_name']);?></td> 
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo $row_get_certificate['subject'.$i.'_total']; ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo round($row_get_certificate['subject'.$i],2);  if(($row_get_certificate['subject'.$i]/$row_get_certificate['subject'.$i.'_total'])<0.283 && $row_get_certificate['subject'.$i.'_total']>0){$pass = 0;} $total_max += $row_get_certificate['subject'.$i]; $total_subject += $row_get_certificate['subject'.$i.'_total'];  ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo evaluation_comment_Course($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);?></td> 
            </tr>
     <?php    }  } ?>
 
     <tr>
         <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:#eed484 " colspan="2"><strong style="font-size: 14px;">Ministry Total</strong></td>
         <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black  " colspan="2" ><span style="font-size: 14px;" ><?php echo (round($total_max,2)." / ".$total_subject); $Ministry_total = $total_subject; $Ministry = round($total_max,2); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style="font-size: 14px;" ><?php echo round((($total_max/$total_subject)*100),2);?>%</span> </td>
    </tr> 

 </table>
<?php }?>
  
  
  
  



<?php
$total_subject_phases_total_switch = 0; 
$total_subject_switch = 0; 
 

     for($i=1;$i<31;$i++){
     if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==2){?>
        <?php 
        $total_subject_phases_total_switch += $row_get_certificate['subject'.$i.'_phases_total'];   
        $total_subject_switch += $row_get_certificate['subject'.$i.'_total'];  
        ?> 
         
     <?php }} 
     if($total_subject_switch>0){?>

<table style="font-size: 12px; border:solid 1px black; color:black; margin-bottom:25px" border="1">


    <tr style="background-color: #eed484;">   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 35%; "><strong style="font-size:10px !important;  "> Subject </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Max </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Mark </strong> </td>   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 25%; "><strong style="font-size:10px !important;  "> Grade </strong> </td>    
    </tr>

     <?php
     $total_max = 0;
     $total_subject = 0;
     $total_phases = 0;
     $total_subject_phases_total = 0;
     $total_degree  = 0;
     $total_subject_degree_total = 0;
     
     for($i=1;$i<31;$i++){
            if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==2){ ?>   
           <tr> 
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black;  "><?php echo subject_name_return($row_get_certificate['subject'.$i.'_name']);?></td> 
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo $row_get_certificate['subject'.$i.'_total']; ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo round($row_get_certificate['subject'.$i],2);  if(($row_get_certificate['subject'.$i]/$row_get_certificate['subject'.$i.'_total'])<0.283 && $row_get_certificate['subject'.$i.'_total']>0){$pass = 0;} $total_max += $row_get_certificate['subject'.$i]; $total_subject += $row_get_certificate['subject'.$i.'_total'];  ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo evaluation_comment_Course($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);?></td> 
            </tr>
     <?php    }  } ?>

      <tr>
         <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:#eed484 " colspan="2"><strong style="font-size: 14px;"> Total</strong></td>
         <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black; font-weight:bold; border-bottom: double 1px black  " colspan="2" ><span style="font-size: 14px;" ><?php echo (round($total_max,2)." / ".$total_subject); $hls = round($total_max,2); $hls_total = $total_subject; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style="font-size: 14px;" ><?php echo round((($total_max/$total_subject)*100),2);?>%</span> </td>
    </tr>   
 </table>

 

<?php }?>





 <table style="font-size: 12px !important; width:100%; border:solid 1px black; color:black; margin-bottom:25px" border="1"> 
 
<tr>
    <td align="center"  width="40%"   style="text-align: center; font-size: 12px !important; border:solid 1px black; font-weight:bold; border-bottom: double 1px black; background-color:#eed484  "><strong style="font-size: 14px;">Helalia’s Total </strong></td>
    <td align="center"      style="text-align: center; font-size: 12px !important; border:solid 1px black; font-weight:bold; border-bottom: double 1px black  "   ><span style="margin-right:30px; font-size: 14px;  "><?php  echo (round(($hls+$Ministry),2)." / ".($hls_total+$Ministry_total)); ?></span>   <span style="font-size: 14px;" ><?php  echo round(((($hls+$Ministry)/($hls_total+$Ministry_total))*100),2);?>%</span> </td>  
</tr> 
</table> 






    <?php 
$total_subject_switch = 0; 

     for($i=1;$i<31;$i++){
     if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==0 ){?>
        <?php   
        $total_subject_switch += $row_get_certificate['subject'.$i.'_total'];  
        ?> 
         
     <?php }} 
     if($total_subject_switch>0){?>
     
<table style="font-size: 12px;   border:solid 1px black; color:black;  margin-top: 30px" border="1" >


    <tr style="background-color: #eed484;">   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 35%; "><strong style="font-size:10px !important;  "> Subject </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Max </strong> </td> 
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 20%; "><strong style="font-size:10px !important;  "> Mark </strong> </td>   
         <td align="center" style="text-align: center; border:solid 1px black;  background-color:#eed484; width: 25%; "><strong style="font-size:10px !important;  "> Grade </strong> </td>    
    </tr>

     <?php 

     for($i=1;$i<31;$i++){
            if($row_get_certificate['subject'.$i.'_total']>0 && $row_get_certificate['subject'.$i.'_count']==0 ){?>
            <tr>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black;  "><?php echo subject_name_return($row_get_certificate['subject'.$i.'_name']);?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo $row_get_certificate['subject'.$i.'_total']; ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo round($row_get_certificate['subject'.$i],2);  if(($row_get_certificate['subject'.$i]/$row_get_certificate['subject'.$i.'_total'])<0.283 && $row_get_certificate['subject'.$i.'_total']>0){$pass = 0;} $total_max += $row_get_certificate['subject'.$i]; $total_subject += $row_get_certificate['subject'.$i.'_total'];  ?></td>
                 <td align="center" style="text-align: center; font-size: 10px; border:solid 1px black  "><?php echo evaluation_comment_Course($row_get_certificate['subject'.$i],$row_get_certificate['subject'.$i.'_total']);?></td> 
              </tr>
     <?php  }  } ?> 

 </table>
<?php }?>

 




   <?php //if(round(((($hls+$Ministry)/($hls_total+$Ministry_total))*100),2)>=50){
         if($pass==1){?>
      <h2 style="text-align:center; font-size:20px; line-height:20px; color:black; padding-right:15px; padding-left:15px">Congratulations on your well-deserved success</h2>
    <?php }else{?>
      <h2 style="text-align:center; font-size:20px; line-height:20px; color:black; padding-right:15px; padding-left:15px">The student needs a remedial program in the subject(s) they failed. </h2>
      <?php }?>
    <!--<p style="text-align: center; font-size:12px">Absence <?php //echo cert_absence($row_get_kids_info['id'],$row_get_certificate['study_year']);?> </p>-->

   

 
 <table style="width: 100%; margin-top:30px; border:collapse !important; border:none !important ; background-color:transparent; -webkit-box-shadow:none "   border="0" >
          <tr style="border-bottom:none !important"> 
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">Head of Control</td> 
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">Head of Department</td> 
            <td align="center"  style="font-size: 12px !important; text-align: center; font-weight:bold; padding:  0px;  width: 33%; border:none !important">School Principal </td>  
          </tr>  
           <tr style="border-bottom:none !important">
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/control.png" width="90%"  /></td>  
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/department<?php if($row_get_certificate['study_year']>8 && $row_get_certificate['study_year']<12){echo head_number_mid($row_get_kids_info['gender']);}else{echo head_number($row_get_certificate['study_year']);}?>.png" width="90%"   /></td> 
             <td  align="center" style="font-size: 12px !important; text-align: center; border:none !important"><img src="../app/mobile/eng/images/principal.png" width="90%"   /></td> 
          </tr>   
          <tr style="border-bottom:none !important">
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important ">Dr. Mohamed Saied</td> 
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important "><?php if($row_get_certificate['study_year']>8 && $row_get_certificate['study_year']<12){echo head_name_mid($row_get_kids_info['gender']);}else{echo head_name($row_get_certificate['study_year']);}?></td> 
             <td align="center"  style="font-size: 12px !important; text-align: center; padding:  2px; border:none !important ">Mrs. Azza Farag</td> 
           </tr>  
    </table>

    </div>



 

<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

<!-- CORE JS FRAMEWORK - START -->
<script src="../app/mobile/eng/assets/js/jquery-2.2.4.min.js"></script>
<script src="../app/mobile/eng/assets/js/materialize.js"></script>
<script src="../app/mobile/eng/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- CORE JS FRAMEWORK - END -->


<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
<script type="text/javascript">
  $(document).ready(function(){

      $(".carousel-fullscreen.carousel-slider").carousel({
        fullWidth: true,
        indicators: true
      });
      setTimeout(autoplay, 3500);
      function autoplay() {
          $(".carousel").carousel("next");
          setTimeout(autoplay, 3500);
      }
         $(".slider3").slider({
                indicators: false,
                height: 200,
        });

  });
    </script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


<!-- CORE TEMPLATE JS - START -->
<script src="../app/mobile/eng/assets/js/init.js"></script>
<script src="../app/mobile/eng/assets/js/settings.js"></script>

<script src="../app/mobile/eng/assets/js/scripts.js"></script>

<!-- END CORE TEMPLATE JS - END -->


<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function(){
    $('.preloader-background').delay(10).fadeOut('slow');
  });
</script>
</body> 
</html> 
<?php }else{header("location: home.php");exit();}?>