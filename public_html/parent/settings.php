<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();

portal_head(t('settings'));
portal_top($user);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('settings')) . '</h1>';
echo '<div class="list">';
echo '<a class="row" href="children.php"><h3>' . h(is_student_user($user) ? t('my_student') : t('home')) . '</h3></a>';
echo '<a class="row" href="profile.php"><h3>' . h(t('profile')) . '</h3></a>';
echo '<a class="row" href="password.php"><h3>' . h(t('change_password')) . '</h3></a>';
if (!is_student_user($user)) {
    echo '<a class="row" href="add-child.php"><h3>' . h(t('add_child')) . '</h3></a>';
}
$kids = parent_kids((int) $user['id']);
if ($kids) {
    echo '<a class="row" href="absence.php?id=' . (int) $kids[0]['id'] . '"><h3>' . h(t('absence')) . '</h3></a>';
}
echo '<a class="row" href="' . h(switch_lang_url()) . '"><h3>' . h(t('language')) . '</h3></a>';
echo '<a class="row" href="logout.php"><h3>' . h(t('sign_out')) . '</h3></a>';
echo '</div></div></main>';
portal_foot();
