<?php
$staffLang = 'arb';
$year = isset($_GET['year']) ? (int) $_GET['year'] : -1;
$qs = $year >= 0 ? ('?year=' . $year) : '';
header('Location: class-notify.php' . $qs);
exit;
