<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kids = parent_kids((int) $user['id']);
$student = is_student_user($user);

portal_head($student ? t('my_student') : t('my_children'));
portal_top($user);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h($student ? t('my_student') : t('my_children')) . '</h1>';
echo '<p class="lead">' . h($user['name'] ?? '') . '</p>';
if (!$kids) {
    empty_state(t('no_children'));
} else {
    echo '<div class="kids">';
    foreach ($kids as $kid) {
        $counts = kid_badge_counts((int) $user['id'], (int) $kid['id']);
        echo '<a class="kid-card" href="kid.php?id=' . (int) $kid['id'] . '">';
        echo '<img src="' . h(kid_photo($kid)) . '" alt="">';
        echo '<div><h2>' . h(kid_display_name($kid)) . '</h2><p>' . h(trim(year_label((int) $kid['study_year']) . ' · ' . class_name((int) $kid['class']))) . '</p></div>';
        if ($counts['alerts'] > 0) {
            echo '<span class="badge">' . (int) $counts['alerts'] . '</span>';
        } else {
            echo '<span></span>';
        }
        echo '</a>';
    }
    echo '</div>';
}
if (!$student) {
    echo '<p style="margin-top:22px"><a class="btn btn-navy" href="add-child.php">' . h(t('add_child')) . '</a></p>';
}
echo '</div></main>';
portal_foot();
