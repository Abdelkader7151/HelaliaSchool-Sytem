<?php
$staffLang = 'arb';
$year = isset($_GET['year']) ? (int) $_GET['year'] : 0;
$qs = $year >= 0 ? ('?year=' . $year) : '';
if (isset($_GET['all'])) {
    $qs .= ($qs === '' ? '?' : '&') . 'class=all';
} elseif (isset($_GET['class'])) {
    $qs .= ($qs === '' ? '?' : '&') . 'class=' . (int) $_GET['class'];
}
header('Location: memo.php' . $qs);
exit;
