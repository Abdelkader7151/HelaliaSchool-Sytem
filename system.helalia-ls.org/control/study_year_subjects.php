<?php   
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 
 mysqli_select_db($database, $database_database);  
 $query_get_class_info = "SELECT * FROM `subjects` where `study_year`='{$_POST['study_year']}'  "; 
 $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
 $row_get_class_info = mysqli_fetch_assoc($get_class_info);
 $totalRows_get_class_info = mysqli_num_rows($get_class_info);

?> 

 <select class="form-control" required name="subject" id="subject" >
        <option > </option> 
        <?php if($totalRows_get_class_info>0){
        do{?>
        <option value="<?php echo $row_get_class_info['id'];?>" ><?php echo $row_get_class_info['name'];?></option>  
        <?php }while( $row_get_class_info = mysqli_fetch_assoc($get_class_info)); } ?>
</select>

 