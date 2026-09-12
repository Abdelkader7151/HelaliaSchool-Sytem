<?php
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
  
mysqli_select_db($database, $database_database); 
$query_get_data = "SELECT * FROM `class` where `study_year`='{$_POST['year']}' ";
$get_data = mysqli_query($database,$query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data); 
?> 
 
<option selected value=""> الفصول</option>  
<?php if($totalRows_get_data>0){
      do{?>
          <option value="<?php echo $row_get_data['id'];?>" ><?php echo $row_get_data['name'];?></option>
<?php }while($row_get_data = mysqli_fetch_assoc($get_data)); } ?>
 