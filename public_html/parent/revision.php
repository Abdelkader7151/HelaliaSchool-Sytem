<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$subjects = db_all('SELECT * FROM `subjects` WHERE `study_year` = ?', 'i', [(int) $kid['study_year']]);
$second = second_turm();
$first = isset($_GET['turm']) && (string) $_GET['turm'] === '1';

portal_head(t('revision'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('revision')) . '</h1>';
$shown = 0;
foreach ($subjects as $sub) {
    if ($first) {
        $rows = db_all(
            'SELECT * FROM `revision` WHERE `study_year` = ? AND (`class` = ? OR `class` = 0) AND `confirm` = 1 AND `subject` = ? AND `start` <= ? ORDER BY `id` DESC',
            'iiii',
            [(int) $kid['study_year'], (int) $kid['class'], (int) $sub['id'], $second]
        );
    } else {
        $rows = db_all(
            'SELECT * FROM `revision` WHERE `study_year` = ? AND (`class` = ? OR `class` = 0) AND `confirm` = 1 AND `subject` = ? AND `start` > ? ORDER BY `id` DESC',
            'iiii',
            [(int) $kid['study_year'], (int) $kid['class'], (int) $sub['id'], $second]
        );
    }
    if (!$rows) {
        continue;
    }
    $shown++;
    $label = is_ar() ? ($sub['name'] ?: $sub['name_eng']) : ($sub['name_eng'] ?: $sub['name']);
    echo '<p class="sec">' . h((string) $label) . '</p><div class="list">';
    foreach ($rows as $row) {
        echo '<div class="row"><h3>' . h(field($row, 'name_eng', 'name')) . '</h3>';
        echo '<time>' . h(date('d/m/Y', (int) ($row['date'] ?? $row['start']))) . '</time>';
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
if ($shown === 0) {
    empty_state(t('empty'));
}
echo '</div></main>';
portal_foot();
