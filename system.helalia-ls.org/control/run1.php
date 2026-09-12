<?php  
      require_once('../Connections/database.php'); 
      require_once('includes/functions.php');    


      mysqli_select_db($database, $database_database); 
      $query_get_data = "SELECT * FROM `kids` WHERE `id` >= 1171";
      $get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
      $row_get_data = mysqli_fetch_assoc($get_data);
      $totalRows_get_data = mysqli_num_rows($get_data);


      

do{   
     
   
          //  mysqli_query($database,"UPDATE `kids` set `father_details` = '{$row_get_data['father_details']}',   `home_phone` = '{$row_get_data['home_phone']}', `other_phone` = '{$row_get_data['other_phone']}', `mother_mobile`= '{$row_get_data['mother_phone']}', `father_mobile`= '{$row_get_data['father_phone']}', `other_mobile`= '{$row_get_data['other_mobile']}'  WHERE  `id` = '{$row_get_data_kids['id']}' "); 
                 
      

}while( $row_get_data = mysqli_fetch_assoc($get_data));

 
 
 
echo strtotime("2016/01/16")."</br>"; 
echo strtotime("2016/06/30")."</br>"; 
echo strtotime("2016/06/29")."</br>"; 
echo strtotime("2016/01/18")."</br>"; 
echo strtotime("2015/10/24")."</br>"; 
echo strtotime("2015/10/02")."</br>"; 
echo strtotime("2016/03/20")."</br>"; 
echo strtotime("2015/10/18")."</br>"; 
echo strtotime("2016/03/15")."</br>"; 
echo strtotime("2016/09/22")."</br>"; 
echo strtotime("2015/11/16")."</br>"; 
echo strtotime("2016/02/27")."</br>"; 
echo strtotime("2015/11/22")."</br>"; 
echo strtotime("2015/10/02")."</br>"; 
echo strtotime("2016/08/03")."</br>"; 
echo strtotime("2015/11/01")."</br>"; 
echo strtotime("2016/08/15")."</br>"; 
echo strtotime("2016/01/14")."</br>"; 
echo strtotime("2016/09/22")."</br>"; 
echo strtotime("2015/11/21")."</br>"; 
echo strtotime("2016/01/04")."</br>"; 
echo strtotime("2015/12/09")."</br>"; 
echo strtotime("2015/12/22")."</br>"; 
echo strtotime("2015/12/17")."</br>"; 
echo strtotime("2016/06/14")."</br>"; 
echo strtotime("2016/07/11")."</br>"; 
echo strtotime("2016/07/02")."</br>"; 
echo strtotime("2016/07/15")."</br>"; 
echo strtotime("2016/07/19")."</br>"; 
echo strtotime("2016/08/11")."</br>"; 
echo strtotime("2016/01/25")."</br>"; 
echo strtotime("2015/12/27")."</br>"; 
echo strtotime("2016/09/26")."</br>"; 
echo strtotime("2016/09/12")."</br>"; 
echo strtotime("2016/08/15")."</br>"; 
echo strtotime("2015/11/26")."</br>"; 
echo strtotime("2016/03/13")."</br>"; 
echo strtotime("2016/02/16")."</br>"; 
echo strtotime("2016/09/10")."</br>"; 
echo strtotime("2015/12/07")."</br>"; 
echo strtotime("2015/11/03")."</br>"; 
echo strtotime("2016/08/20")."</br>"; 
echo strtotime("2015/11/15")."</br>"; 
echo strtotime("2015/10/08")."</br>"; 
