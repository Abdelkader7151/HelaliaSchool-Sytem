<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$id = (int) $kid['id'];

portal_head(t('gallery'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('gallery')) . '</h1>';
echo '<a class="btn btn-hero" href="upload.php?id=' . $id . '">' . h(t('upload_video')) . '</a>';
echo '<div class="tiles">';
tile('photos.php?id=' . $id, t('photos'), 't-navy');
tile('videos.php?id=' . $id, t('videos'), 't-gold');
echo '</div></div></main>';
portal_foot();
