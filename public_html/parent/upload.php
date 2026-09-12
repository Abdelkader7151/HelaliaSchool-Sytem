<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$flash = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $linkRaw = trim((string) ($_POST['link'] ?? ''));
    $embed = youtube_iframe($linkRaw);
    $fileName = null;
    if (!empty($_FILES['video']['name'])) {
        $saved = save_upload(
            $_FILES['video'],
            (string) cfg('gallery_dir'),
            ['mp4'],
            (int) cfg('max_video_mb', 32)
        );
        if ($saved === false) {
            $error = t('upload_fail');
        } else {
            $fileName = $saved;
        }
    }
    if ($error === '' && $embed === '' && !$fileName) {
        $error = t('need_video');
    }
    if ($error === '') {
        $albumId = ensure_parent_album($kid);
        if (!$albumId) {
            $error = t('upload_fail');
        } else {
            db_exec(
                'INSERT INTO `videos` (`album_id`, `link`, `video`) VALUES (?, NULLIF(?, \'\'), NULLIF(?, \'\'))',
                'iss',
                [$albumId, $embed, $fileName ?: '']
            );
            redirect('videos.php?id=' . (int) $kid['id'] . '&done=1');
        }
    }
}

portal_head(t('upload_video'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('upload_video')) . '</h1>';
echo '<p class="lead">' . h(t('upload_hero')) . ' — ' . h(t('parent_videos')) . '</p>';
if ($error) {
    echo '<p class="warn">' . h($error) . '</p>';
}
echo '<form class="paper" method="post" enctype="multipart/form-data">';
echo '<label class="field"><span>' . h(t('youtube')) . '</span><textarea name="link" placeholder="https://www.youtube.com/watch?v=..."></textarea></label>';
echo '<label class="field"><span>' . h(t('mp4')) . '</span><input type="file" name="video" accept="video/mp4,.mp4"></label>';
echo '<button class="btn btn-sun btn-block" type="submit">' . h(t('save')) . '</button>';
echo '</form></div></main>';
portal_foot();
