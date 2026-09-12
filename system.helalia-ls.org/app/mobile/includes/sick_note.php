<?php
$errors = 0;
if (isset($_POST['start'])) {
    $image = $_FILES['sick_note']['name'];
    if ($image) {
        $filename = stripslashes($_FILES['sick_note']['name']);
        $extension = getExtension($filename);
        $extension = strtolower($extension);

        if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "pdf")) {
            $errors = 1;
        } else {
            $size = filesize($_FILES['sick_note']['tmp_name']);
            if ($size / 1000 > 10000) {
                $errors = 1;
            }

            $image_name = time() . '.' . $extension;
            $newname = "../../../../attachments/" . $image_name;

            if ($errors != 1) {
                if ($extension == "pdf") {
                    // PDFs can't be optimized with GD, just copy as-is
                    $copied = copy($_FILES['sick_note']['tmp_name'], $newname);
                    if (!$copied) { $errors = 1; }
                } else {
                    // Optimize image before saving
                    $optimized = optimizeImage($_FILES['sick_note']['tmp_name'], $newname, $extension);
                    if (!$optimized) { $errors = 1; }
                }
            }
        }
    }
}


?>