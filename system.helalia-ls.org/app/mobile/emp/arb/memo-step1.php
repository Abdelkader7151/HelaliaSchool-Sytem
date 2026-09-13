<?php
$staffLang = 'arb';
$year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
$qs = $year >= 0 ? ('?year=' . $year) : '';
header('Location: memo.php' . $qs);
exit;
