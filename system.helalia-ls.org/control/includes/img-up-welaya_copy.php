<?php
 

        // Compress image
        function compressImage($source, $destination, $quality) {

            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, $destination, $quality);

        }
 
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}
 
$errors=0;
 
if(isset($_POST['submit'])) 
{ 
$image = $_FILES['ed_welaya_copy']['name']; 
if ($image) 
{ 
$filename = stripslashes($_FILES['ed_welaya_copy']['name']); 
$extension = getExtension($filename);
$extension = strtolower($extension); 
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
{ 
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>Unknown extension!</p>";
$errors=1;
}
else
{
$size=filesize($_FILES['ed_welaya_copy']['tmp_name']); 
if ($size/1000 > 10000)
{
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>You have exceeded the size limit!</p>";
$errors=1;
}
 
$image_name = time().'.'.$extension; 
$newname = "../uploads/".$image_name; 
	
	compressImage($_FILES['ed_welaya_copy']['tmp_name'],$newname,60);

if ($errors!=1){
$copied = copy($_FILES['ed_welaya_copy']['tmp_name'], $newname);
if (!$copied) 
{
$msg .="<p class='alert alert-danger text-left ' style='padding:4px'>Copy unsuccessfull! Try again!</p>";
$errors=1;}
}}}} 
 
?>