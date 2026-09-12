<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$certs = [];
if (!empty($kid['ed_id'])) {
    $certs = db_all('SELECT * FROM `certificate` WHERE `gov_id` = ? AND `active` = 1 ORDER BY `id` ASC', 's', [(string) $kid['ed_id']]);
}
$marks = db_all(
    'SELECT c.*, s.name_eng, s.name FROM `control` c
     LEFT JOIN `subjects` s ON s.id = c.subject_id
     WHERE c.kid_id = ? AND c.study_year = ? AND c.publish = 1 AND c.confirm = 1
     ORDER BY c.month DESC, c.id ASC',
    'ii',
    [(int) $kid['id'], (int) $kid['study_year']]
);

portal_head(t('results'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('results')) . '</h1>';
if (!$certs && !$marks) {
    empty_state(t('empty'));
}
if ($certs) {
    echo '<div class="list">';
    foreach ($certs as $cert) {
        echo '<div class="row"><h3>' . h(field($cert, 'title_eng', 'title')) . '</h3></div>';
    }
    echo '</div>';
}
if ($marks) {
    echo '<p class="sec">' . h(t('results')) . '</p><div class="list">';
    foreach ($marks as $mark) {
        $sub = is_ar() ? ($mark['name'] ?: $mark['name_eng']) : ($mark['name_eng'] ?: $mark['name']);
        $score = $mark['degree'] ?? $mark['mark'] ?? $mark['grade'] ?? '';
        echo '<div class="row"><h3>' . h((string) $sub) . '</h3><p>' . h((string) ($mark['month'] ?? '')) . ' · ' . h((string) $score) . '</p></div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
