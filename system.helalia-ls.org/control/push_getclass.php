<?php
 require_once('push_database.php'); 
 require_once('push_functions.php');    
  
mysqli_select_db($database,$database_database);
$query_get_data = "SELECT * FROM `class` where `study_year`='{$_POST['year']}' ";
$get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
$row_get_data = mysqli_fetch_assoc($get_data);
$totalRows_get_data = mysqli_num_rows($get_data); 
?> 
 
 <select id="class" style="padding: 10px;" >  
    <option selected value="0">   All Classes </option>  
    <?php if($totalRows_get_data>0){
        do{?>
            <option value="<?php echo $row_get_data['id'];?>" ><?php echo $row_get_data['name'];?></option>
    <?php }while($row_get_data = mysqli_fetch_assoc($get_data)); } ?>
</select>