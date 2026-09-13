<?php

if (!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION['MM_Userid']) || !isset($_SESSION['MM_Userid']) || !isset($_SESSION['account_type'])) {  
    header("location: ../../index.php");
    exit;
} 
?>