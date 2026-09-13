<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $picture = (string) ($user['picture'] ?? '');
    if (!empty($_FILES['picture']['name'])) {
        $saved = save_upload($_FILES['picture'], (string) cfg('uploads_dir'), ['jpg', 'jpeg', 'png', 'gif'], 8);
        if (is_string($saved)) {
            $picture = $saved;
        }
    }
    db_exec('UPDATE `app_login` SET `name` = ?, `email` = ?, `picture` = ? WHERE `id` = ?', 'sssi', [$name, $email, $picture, (int) $user['id']]);
    $kids = parent_kids((int) $user['id']);
    foreach ($kids as $kid) {
        db_exec('UPDATE `kids` SET `email` = ? WHERE `id` = ?', 'si', [$email, (int) $kid['id']]);
    }
    $_SESSION['name'] = $name;
    $user = require_parent();
    $flash = t('saved');
}

portal_head(t('profile'));
portal_top($user);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('profile')) . '</h1>';
if ($flash) {
    echo '<p class="flash">' . h($flash) . '</p>';
}
echo '<form class="paper" method="post" enctype="multipart/form-data">';
echo '<label class="field"><span>' . h(t('name')) . '</span><input name="name" required value="' . h((string) ($user['name'] ?? '')) . '"></label>';
echo '<label class="field"><span>' . h(t('email')) . '</span><input type="email" name="email" value="' . h((string) ($user['email'] ?? '')) . '"></label>';
echo '<label class="field"><span>' . h(t('profile')) . '</span><input type="file" name="picture" accept="image/*"></label>';
echo '<button class="btn btn-navy" type="submit">' . h(t('save')) . '</button>';
echo '</form></div></main>';
portal_foot();
