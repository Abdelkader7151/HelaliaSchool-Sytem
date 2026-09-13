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
if ($size/1000 > 80000)
{ 
$errors=1;
}
 
$image_name = "request_".time().'.'.$extension; 
$newname = "../attachments/".$image_name; 
	 

if ($errors!=1){
$copied = copy($_FILES['picture']['tmp_name'], $newname);
if (!$copied) 
{ 
$errors=1;}
}}}}?> 