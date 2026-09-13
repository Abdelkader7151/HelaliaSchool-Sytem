<?php   
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    
 
 mysqli_select_db($database, $database_database);  
 $query_get_class_info = "SELECT distinct(`emp_id`) FROM `teachers` where `study_year`='{$_POST['study_year']}'  and `subject`='{$_POST['subject']}' and class = '{$_POST['class']}'  "; 
 $get_class_info = mysqli_query($database,$query_get_class_info) or die(mysqli_error($database));
 $row_get_class_info = mysqli_fetch_assoc($get_class_info);
 $totalRows_get_class_info = mysqli_num_rows($get_class_info);

?> 

 <select class="form-control" required name="emp_id" id="emp_id" >
        <option > </option> 
        <?php if($totalRows_get_class_info>0){
        do{?>
        <option value="<?php echo $row_get_class_info['emp_id'];?>" ><?php echo emp_name($row_get_class_info['emp_id']);?></option>  
        <?php }while( $row_get_class_info = mysqli_fetch_assoc($get_class_info)); } ?>
</select>

 