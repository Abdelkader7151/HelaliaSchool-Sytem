<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
if (is_student_user($user)) {
    redirect(portal_home_url($user));
}
$error = '';
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ed = trim((string) ($_POST['ed_id'] ?? ''));
    $gov = trim((string) ($_POST['gov_id'] ?? ''));
    $kid = db_one('SELECT * FROM `kids` WHERE `ed_id` = ? AND `gov_id` = ? LIMIT 1', 'ss', [$ed, $gov]);
    if (!$kid) {
        $error = t('child_not_found');
    } else {
        $linked = db_one('SELECT `id` FROM `kids_list` WHERE `kid_id` = ? LIMIT 1', 'i', [(int) $kid['id']]);
        if ($linked || (int) ($kid['linked'] ?? 0) === 1) {
            $already = db_one('SELECT `id` FROM `kids_list` WHERE `kid_id` = ? AND `parent_id` = ? LIMIT 1', 'ii', [(int) $kid['id'], (int) $user['id']]);
            if ($already) {
                redirect('kid.php?id=' . (int) $kid['id']);
            }
            $error = t('child_linked');
        } else {
            db_exec('INSERT INTO `kids_list` (`parent_id`, `kid_id`) VALUES (?, ?)', 'ii', [(int) $user['id'], (int) $kid['id']]);
            $pic = (string) ($kid['picture'] ?? '');
            if (!empty($_FILES['picture']['name'])) {
                $saved = save_upload($_FILES['picture'], (string) cfg('kids_dir'), ['jpg', 'jpeg', 'png', 'gif'], 8);
                if (is_string($saved)) {
                    $pic = $saved;
                }
            }
            db_exec('UPDATE `kids` SET `linked` = 1, `picture` = ? WHERE `id` = ?', 'si', [$pic, (int) $kid['id']]);
            redirect('kid.php?id=' . (int) $kid['id']);
        }
    }
}

portal_head(t('add_child'));
portal_top($user);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('add_child')) . '</h1>';
if ($error) {
    echo '<p class="warn">' . h($error) . '</p>';
}
echo '<form class="paper" method="post" enctype="multipart/form-data">';
echo '<label class="field"><span>' . h(t('school_id')) . '</span><input name="ed_id" required></label>';
echo '<label class="field"><span>' . h(t('national_id')) . '</span><input name="gov_id" required></label>';
echo '<label class="field"><span>' . h(t('photos')) . '</span><input type="file" name="picture" accept="image/*"></label>';
echo '<button class="btn btn-navy" type="submit">' . h(t('save')) . '</button>';
echo '</form></div></main>';
portal_foot();
