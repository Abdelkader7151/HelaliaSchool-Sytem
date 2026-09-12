<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plain = (string) ($_POST['password'] ?? '');
    if ($plain !== '') {
        $hash = password_hash_app($plain);
        db_exec('UPDATE `app_login` SET `password` = ? WHERE `id` = ?', 'si', [$hash, (int) $user['id']]);
        $flash = t('saved');
    }
}

portal_head(t('change_password'));
portal_top($user);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('change_password')) . '</h1>';
if ($flash) {
    echo '<p class="flash">' . h($flash) . '</p>';
}
echo '<form class="paper" method="post">';
echo '<label class="field"><span>' . h(t('new_password')) . '</span><input type="password" name="password" required></label>';
echo '<button class="btn btn-navy" type="submit">' . h(t('save')) . '</button>';
echo '</form></div></main>';
portal_foot();
