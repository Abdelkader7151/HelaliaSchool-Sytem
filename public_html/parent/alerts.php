<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));

if (isset($_GET['read'])) {
    $nid = (int) $_GET['read'];
    db_exec('UPDATE `notifications` SET `view` = 1 WHERE `id` = ? AND `kid_id` = ?', 'ii', [$nid, (int) $kid['id']]);
    redirect('alerts.php?id=' . (int) $kid['id']);
}

$rows = db_all('SELECT * FROM `notifications` WHERE `kid_id` = ? ORDER BY `id` DESC', 'i', [(int) $kid['id']]);

portal_head(t('alerts'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('alerts')) . '</h1>';
if (!$rows) {
    empty_state(t('empty'));
} else {
    echo '<div class="list">';
    foreach ($rows as $row) {
        $title = field($row, 'title_eng', 'title') ?: field($row, 'text_eng', 'text');
        $body = field($row, 'text_eng', 'text');
        echo '<div class="row">';
        echo '<h3>' . h($title) . '</h3>';
        if ($body !== '' && $body !== $title) {
            echo '<p>' . nl2br(h($body)) . '</p>';
        }
        if ((int) ($row['view'] ?? 1) === 0) {
            echo '<p><a class="btn btn-navy" href="alerts.php?id=' . (int) $kid['id'] . '&read=' . (int) $row['id'] . '">OK</a></p>';
        }
        echo '</div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
