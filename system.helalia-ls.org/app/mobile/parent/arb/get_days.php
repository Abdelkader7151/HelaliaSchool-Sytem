<?php

$start = strtotime($_POST['start']);
$end = strtotime($_POST['end']);
$days = 0;
if($start>0 && $end>0){ 
    $step1 = $end - $start;
    $days = round(($step1/86400),0);
}
$s=" <span style='font-size: 20px;  color:#112c5a'>ايام</span>";
if($days==1){ $s= " <span style='font-size: 20px;  color:#112c5a'>يوم</span>";}
echo $days." ".$s; 
?>