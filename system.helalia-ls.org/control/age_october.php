<?php
  
  function birthday($gov_id){ 
    if(substr($gov_id,0,1)==2){$year0 = 19;}
    if(substr($gov_id,0,1)==3){$year0 = 20;}
    $year = substr($gov_id,1,2);
    $month = substr($gov_id,3,2);
    $day = substr($gov_id,5,2);
    $birthday =  $year0.$year."-".$month."-".$day; 
    return strtotime($birthday);
    }


  function convertSecToTime($birthday){
    $y =  date("Y",time());  

  $date = strtotime(date($y."-10-01",time()));  
  $sec = $date-$birthday;    
  $date1 = new DateTime("@0");
  $date2 = new DateTime("@$sec");
  $interval =  date_diff($date1, $date2);
  return $interval->format('%y سنة   %m شهر  %d يوم');
  }
  
  
   echo convertSecToTime(birthday($_POST['gov']));

?>