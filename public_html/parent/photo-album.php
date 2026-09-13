<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$albumId = (int) ($_GET['album'] ?? 0);
$allowed = db_one(
    'SELECT `id` FROM `gallery-albums-classs` WHERE `album_id` = ? AND `class_id` = ? LIMIT 1',
    'ii',
    [$albumId, (int) $kid['class']]
);
if (!$allowed) {
    redirect('photos.php?id=' . (int) $kid['id']);
}
$album = db_one('SELECT * FROM `gallery-albums` WHERE `id` = ? LIMIT 1', 'i', [$albumId]);
$pics = db_all('SELECT * FROM `gallery-pictures` WHERE `album_id` = ? ORDER BY `id` DESC', 'i', [$albumId]);

portal_head($album['title'] ?? t('photos'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h((string) ($album['title'] ?? t('photos'))) . '</h1>';
if (!$pics) {
    empty_state(t('empty'));
} else {
    echo '<div class="photos">';
    foreach ($pics as $pic) {
        $src = media_url('gallery', $pic['link'] ?? '');
        echo '<a href="' . h($src) . '" target="_blank"><img src="' . h($src) . '" alt=""></a>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
