<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$classId = (int) $kid['class'];
$links = db_all('SELECT `album_id` FROM `video-albums-classs` WHERE `class_id` = ? ORDER BY `id` DESC', 'i', [$classId]);

portal_head(t('videos'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('videos')) . '</h1>';
if (isset($_GET['done'])) {
    echo '<p class="flash">' . h(t('saved')) . '</p>';
}
echo '<p><a class="btn btn-sun" href="upload.php?id=' . (int) $kid['id'] . '">' . h(t('upload_video')) . '</a></p>';
if (!$links) {
    empty_state(t('empty'));
} else {
    echo '<div class="tiles">';
    foreach ($links as $link) {
        $album = db_one('SELECT * FROM `video-albums` WHERE `id` = ? LIMIT 1', 'i', [(int) $link['album_id']]);
        if ($album) {
            tile('album.php?id=' . (int) $kid['id'] . '&album=' . (int) $album['id'], (string) $album['title'], 't-gold');
        }
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
