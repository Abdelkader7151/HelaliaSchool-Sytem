<?php 
        // Compress image
        function compressImage($source, $destination, $quality) {

            $info = @getimagesize($source);
            if (!$info || empty($info['mime'])) {
                return false;
            }

            $image = false;
            if ($info['mime'] == 'image/jpeg')
                $image = @imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif')
                $image = @imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png')
                $image = @imagecreatefrompng($source);

            if (!$image) {
                return false;
            }

            $ok = @imagejpeg($image, $destination, $quality);
            imagedestroy($image);
            return (bool) $ok;

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
	
if ($errors!=1){
	@compressImage($_FILES['picture']['tmp_name'],$newname,60);
	$copied = is_file($newname) && @filesize($newname) > 0;
	if (!$copied) {
		$copied = copy($_FILES['picture']['tmp_name'], $newname);
	}
if (!$copied) 
{ 
$errors=1;}
}}}}?> 