<?php
$staffLang = 'arb';
$year = isset($_GET['year']) ? (int) $_GET['year'] : -1;
$class = isset($_GET['class']) ? (int) $_GET['class'] : 0;
$qs = array();
if ($year >= 0) {
    $qs[] = 'year=' . $year;
}
if ($class > 0) {
    $qs[] = 'class=' . $class;
}
header('Location: class-notify.php' . ($qs ? ('?' . implode('&', $qs)) : ''));
exit;
