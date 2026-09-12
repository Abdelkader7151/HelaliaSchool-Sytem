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
$image = $_FILES['picture']['name']; 
if ($image) 
{ 
$filename = stripslashes($_FILES['picture']['name']); 
$extension = getExtension($filename);
$extension = strtolower($extension); 
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
{  
$errors=1;
}
else
{
$size=filesize($_FILES['picture']['tmp_name']); 
if ($size/1000 > 5000)
{ 
$errors=1;
}
 
$image_name = "banner_".time().'.'.$extension; 
$newname = "../attachments/".$image_name; 
	
	compressImage($_FILES['picture']['tmp_name'],$newname,60);

if ($errors!=1){
$copied = copy($_FILES['picture']['tmp_name'], $newname);
if (!$copied) 
{ 
$errors=1;}
}}}}?> 