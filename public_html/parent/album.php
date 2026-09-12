<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$albumId = (int) ($_GET['album'] ?? 0);
$allowed = db_one(
    'SELECT `id` FROM `video-albums-classs` WHERE `album_id` = ? AND `class_id` = ? LIMIT 1',
    'ii',
    [$albumId, (int) $kid['class']]
);
if (!$allowed) {
    redirect('videos.php?id=' . (int) $kid['id']);
}
$album = db_one('SELECT * FROM `video-albums` WHERE `id` = ? LIMIT 1', 'i', [$albumId]);
$clips = db_all('SELECT * FROM `videos` WHERE `album_id` = ? ORDER BY `id` DESC', 'i', [$albumId]);

portal_head($album['title'] ?? t('videos'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h((string) ($album['title'] ?? t('videos'))) . '</h1>';
if (!$clips) {
    empty_state(t('empty'));
} else {
    echo '<div class="list">';
    foreach ($clips as $clip) {
        echo '<div class="row player">';
        if (!empty($clip['link'])) {
            echo $clip['link'];
        }
        if (!empty($clip['video'])) {
            echo '<video controls playsinline src="' . h(media_url('gallery', $clip['video'])) . '"></video>';
        }
        echo '</div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
