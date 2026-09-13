<?php  
 
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
$image = $_FILES['video']['name']; 
if ($image) 
{ 
$filename = stripslashes($_FILES['video']['name']); 
$extension = getExtension($filename);
$extension = strtolower($extension); 
if (($extension != "mp4") && ($extension != "avi")) 
{ 
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>Unknown extension!</p>";
$errors=1;
}
else
{
$size=filesize($_FILES['video']['tmp_name']); 
if ($size/1000 > 100000)
{
$msg .= "<p class='alert alert-danger text-left ' style='padding:4px'>You have exceeded the size limit!</p>";
$errors=1;
}
 
$image_name = time().'.'.$extension; 
$newname = "../gallery/".$image_name; 
	 
if ($errors!=1){
$copied = copy($_FILES['video']['tmp_name'], $newname);
if (!$copied) 
{
$msg .="<p class='alert alert-danger text-left ' style='padding:4px'>Copy unsuccessfull! Try again!</p>";
$errors=1;}
}}}}  
?>