#!/usr/local/bin/ea-php56
<?php
$fd = fopen("php://stdin", "r");
$email = ""; // This will be the variable holding the data.
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}
fclose($fd);
$fdw = fopen("/home/sja/public_html/pipemail.txt", "w+");
fwrite($fdw, $email);
fclose($fdw);
//echo file_put_contents("/home/sja/public_html/pipemail.txt","Hello World. Testing!");
?>
