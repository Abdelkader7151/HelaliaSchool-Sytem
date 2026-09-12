<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$start = strtotime(date('m/d/Y'));
$events = db_all(
    'SELECT * FROM `events` WHERE (`study_year` = ? OR `study_year` = 15) AND `start` >= ? ORDER BY `start` ASC',
    'ii',
    [(int) $kid['study_year'], $start]
);

portal_head(t('calendar'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('calendar')) . '</h1>';
if (!$events) {
    empty_state(t('empty'));
} else {
    echo '<div class="list">';
    foreach ($events as $event) {
        $title = field($event, 'title_eng', 'title');
        echo '<div class="row"><h3>' . h($title) . '</h3>';
        echo '<time>' . h(date('d/m/Y', (int) $event['start'])) . '</time>';
        $text = field($event, 'text_eng', 'text');
        if ($text !== '') {
            echo '<p>' . nl2br(h($text)) . '</p>';
        }
        echo '</div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
