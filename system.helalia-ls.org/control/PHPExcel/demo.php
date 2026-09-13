 
 
 
 
 
 
 
 
 $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
    include("PHPExcel/Classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
    $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
  
    $output .= "<label class='text-success'>Data Inserted</label><br /><table class='table table-bordered'>";
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
      $highestRow = $worksheet->getHighestRow();
      for($row=2; $row<=$highestRow; $row++)
      {
      $output .= "<tr>";
      $name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
      $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
      $query = "INSERT INTO excelData(name, email) VALUES ('".$name."', '".$email."')";
      mysqli_query($connect, $query);
      $output .= '<td>'.$name.'</td>';
      $output .= '<td>'.$email.'</td>';
      $output .= '</tr>';
      }
    } 
    $output .= '</table>';


    <form method="post" enctype="multipart/form-data">
      <label>Select Excel File</label>
      <input type="file" name="excel" />
      <br />
      <input type="submit" name="import" class="btn btn-info" value="Import" />
    </form>