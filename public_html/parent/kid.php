<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$counts = kid_badge_counts((int) $user['id'], (int) $kid['id']);
$id = (int) $kid['id'];

portal_head(kid_display_name($kid));
portal_top($user);
echo '<section class="hero"><div class="wrap hero-inner">';
echo '<a class="back" href="children.php">←</a>';
echo '<img class="av" src="' . h(kid_photo($kid)) . '" alt="">';
echo '<div><p class="kname">' . h(kid_display_name($kid)) . '</p>';
echo '<p class="kmeta">' . h(trim(year_label((int) $kid['study_year']) . ' · ' . class_name((int) $kid['class']))) . '</p></div>';
echo '</div></section>';
echo '<main class="page"><div class="wrap">';
echo '<a class="btn btn-hero" href="upload.php?id=' . $id . '">' . h(t('upload_video')) . '<small>' . h(t('upload_hero')) . '</small></a>';
echo '<div class="quick">';
echo '<a href="alerts.php?id=' . $id . '">' . h(t('alerts')) . ($counts['alerts'] ? ' · ' . $counts['alerts'] : '') . '</a>';
echo '<a href="ask.php?id=' . $id . '">' . h(t('ask_school')) . '</a>';
echo '<a href="calendar.php?id=' . $id . '">' . h(t('calendar')) . '</a>';
echo '<a href="summary.php?id=' . $id . '">' . h(t('summary')) . '</a>';
echo '</div>';
echo '<p class="sec">' . h(t('everything')) . '</p>';
echo '<div class="tiles">';
tile('homework.php?id=' . $id, t('homework'), 't-navy');
tile('memo.php?id=' . $id, t('memo'), 't-gold');
tile('results.php?id=' . $id, t('results'), 't-navy');
tile('revision.php?id=' . $id, t('revision'), 't-gold');
tile('plan.php?id=' . $id, t('weekly_plan'), 't-navy');
tile('gallery.php?id=' . $id, t('gallery'), 't-gold');
echo '</div></div></main>';
portal_foot();
