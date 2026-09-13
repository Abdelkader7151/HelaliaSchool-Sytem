<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? 0));
$error = '';

$special = [
    10001 => t('admin'),
    10002 => t('head_office'),
    10003 => t('vice'),
    10004 => t('secretary'),
    10005 => t('doctor'),
    10006 => t('therapist'),
];
$subjects = db_all('SELECT `id`, `name_eng`, `name` FROM `subjects` WHERE `study_year` = ?', 'i', [(int) $kid['study_year']]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim((string) ($_POST['text'] ?? ''));
    $subject = (int) ($_POST['subject'] ?? 0);
    if ($text === '' || $subject === 0) {
        $error = is_ar() ? 'أكمل الحقول.' : 'Please complete the fields.';
    } else {
        $hour = time() - 3600;
        $dup = db_one(
            'SELECT `id` FROM `ask_teacher` WHERE `user_id` = ? AND `kid_id` = ? AND `subject` = ? AND `text` = ? AND `date` > ? LIMIT 1',
            'iiisi',
            [(int) $user['id'], (int) $kid['id'], $subject, $text, $hour]
        );
        if (!$dup) {
            db_exec(
                'INSERT INTO `ask_teacher` (`user_id`, `kid_id`, `text`, `study_year`, `subject`, `date`) VALUES (?, ?, ?, ?, ?, ?)',
                'iisiii',
                [(int) $user['id'], (int) $kid['id'], $text, (int) $kid['study_year'], $subject, time()]
            );
        }
        redirect('ask.php?id=' . (int) $kid['id'] . '&done=1');
    }
}

if (isset($_GET['view'])) {
    db_exec(
        'UPDATE `ask_teacher` SET `view` = 1 WHERE `id` = ? AND `user_id` = ? AND `kid_id` = ?',
        'iii',
        [(int) $_GET['view'], (int) $user['id'], (int) $kid['id']]
    );
}

$questions = db_all('SELECT * FROM `ask_teacher` WHERE `kid_id` = ? ORDER BY `id` DESC', 'i', [(int) $kid['id']]);

portal_head(t('ask_school'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('ask_school')) . '</h1>';
if (isset($_GET['done'])) {
    echo '<p class="flash">' . h(t('saved')) . '</p>';
}
if ($error) {
    echo '<p class="warn">' . h($error) . '</p>';
}
echo '<form class="paper" method="post">';
echo '<label class="field"><span>' . h(t('recipient')) . '</span><select name="subject" required><option value="">...</option>';
foreach ($special as $sid => $label) {
    echo '<option value="' . $sid . '">' . h($label) . '</option>';
}
foreach ($subjects as $sub) {
    $label = is_ar() ? ($sub['name'] ?: $sub['name_eng']) : ($sub['name_eng'] ?: $sub['name']);
    echo '<option value="' . (int) $sub['id'] . '">' . h((string) $label) . '</option>';
}
echo '</select></label>';
echo '<label class="field"><span>' . h(t('question')) . '</span><textarea name="text" required></textarea></label>';
echo '<button class="btn btn-navy" type="submit">' . h(t('send')) . '</button>';
echo '</form>';
if (!$questions) {
    empty_state(t('empty'));
} else {
    echo '<div class="list" style="margin-top:20px">';
    foreach ($questions as $q) {
        $sid = (int) $q['subject'];
        $who = $special[$sid] ?? '';
        if ($who === '') {
            foreach ($subjects as $sub) {
                if ((int) $sub['id'] === $sid) {
                    $who = (string) (is_ar() ? ($sub['name'] ?: $sub['name_eng']) : ($sub['name_eng'] ?: $sub['name']));
                }
            }
        }
        echo '<div class="row"><h3>' . h($who) . '</h3><p>' . nl2br(h((string) $q['text'])) . '</p>';
        if (!empty($q['reply'])) {
            echo '<p><strong>' . h(t('reply')) . ':</strong> ' . nl2br(h((string) $q['reply'])) . '</p>';
            if ((int) ($q['view'] ?? 1) === 0) {
                echo '<p><a href="ask.php?id=' . (int) $kid['id'] . '&view=' . (int) $q['id'] . '">OK</a></p>';
            }
        }
        echo '</div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
