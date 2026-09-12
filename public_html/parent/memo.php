<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$second = second_turm();
$first = isset($_GET['turm']) && (string) $_GET['turm'] === '1';
if ($first) {
    $rows = db_all(
        'SELECT * FROM `memos` WHERE (`study_year` = ? OR `study_year` = 300) AND (`class` = ? OR `class` = 0 OR `class` IS NULL) AND `date` <= ? ORDER BY `id` DESC',
        'iii',
        [(int) $kid['study_year'], (int) $kid['class'], $second]
    );
} else {
    $rows = db_all(
        'SELECT * FROM `memos` WHERE (`study_year` = ? OR `study_year` = 300) AND (`class` = ? OR `class` = 0 OR `class` IS NULL) AND `date` > ? ORDER BY `id` DESC',
        'iii',
        [(int) $kid['study_year'], (int) $kid['class'], $second]
    );
}

portal_head(t('memo'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('memo')) . '</h1>';
if (!$rows) {
    empty_state(t('empty'));
} else {
    echo '<div class="list">';
    foreach ($rows as $row) {
        echo '<div class="row"><h3>' . h(field($row, 'name_eng', 'name')) . '</h3>';
        echo '<time>' . h(date('d/m/Y', (int) $row['date'])) . '</time>';
        $text = field($row, 'text_eng', 'text');
        if ($text !== '') {
            echo '<p>' . nl2br(h($text)) . '</p>';
        }
        if (!empty($row['banner'])) {
            echo '<p><a class="btn btn-navy" href="' . h(media_url('homework', $row['banner'])) . '" target="_blank">' . h(t('download')) . '</a></p>';
        }
        echo '</div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
