<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$links = db_all('SELECT `album_id` FROM `gallery-albums-classs` WHERE `class_id` = ? ORDER BY `id` DESC', 'i', [(int) $kid['class']]);

portal_head(t('photos'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('photos')) . '</h1>';
if (!$links) {
    empty_state(t('empty'));
} else {
    echo '<div class="tiles">';
    foreach ($links as $link) {
        $album = db_one('SELECT * FROM `gallery-albums` WHERE `id` = ? LIMIT 1', 'i', [(int) $link['album_id']]);
        if ($album) {
            tile('photo-album.php?id=' . (int) $kid['id'] . '&album=' . (int) $album['id'], (string) $album['title'], 't-navy');
        }
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
