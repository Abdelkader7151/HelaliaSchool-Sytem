<?php 
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
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>Unknown extension!</p>";
$errors=1;
}
else
{
$size=filesize($_FILES['picture']['tmp_name']); 
if ($size/1000 > 80000)
{
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>You have exceeded the size limit!</p>";
$errors=1;
}
 
$image_name = time().'.'.$extension; 
$newname = "../gallery/".$image_name; 
	
	//compressImage($_FILES['picture']['tmp_name'],$newname,60);

if ($errors!=1){
$copied = copy($_FILES['picture']['tmp_name'], $newname);
if (!$copied) 
{
$msg .="<p class='alert alert-danger text-left ' style='padding:4px'>Copy unsuccessfull! Try again!</p>";
$errors=1;}
}}}}  
?>