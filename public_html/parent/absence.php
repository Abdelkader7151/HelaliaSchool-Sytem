<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = require_parent();
$kid = require_kid($user, (int) ($_GET['id'] ?? ($_POST['kid_id'] ?? 0)));
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = (int) ($_POST['type'] ?? 4);
    $start = strtotime((string) ($_POST['start'] ?? ''));
    $end = strtotime((string) ($_POST['end'] ?? ''));
    $text = trim((string) ($_POST['text'] ?? ''));
    $note = '';
    if ($type < 3 && !empty($_FILES['sick_note']['name'])) {
        $saved = save_upload($_FILES['sick_note'], (string) cfg('attachments_dir'), ['jpg', 'jpeg', 'png', 'gif'], 15);
        if (is_string($saved)) {
            $note = $saved;
        }
    }
    $dup = db_one(
        'SELECT `id`, `date` FROM `kids_vacations` WHERE `kid_id` = ? AND `type` = ? AND `vacation_date` = ? AND `vacation_end` = ? AND `study_year` = ? AND `text` = ? ORDER BY `id` DESC LIMIT 1',
        'iiiiis',
        [(int) $kid['id'], $type, $start, $end, (int) $kid['study_year'], $text]
    );
    if (!$dup || (int) $dup['date'] < (time() - 5)) {
        db_exec(
            'INSERT INTO `kids_vacations` (`kid_id`, `type`, `vacation_date`, `vacation_end`, `study_year`, `text`, `sick_note`, `absence_id`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'iiiiiissii',
            [(int) $kid['id'], $type, $start, $end, (int) $kid['study_year'], $text, $note, 0, time()]
        );
    }
    $flash = t('saved');
}

$past = db_all(
    'SELECT * FROM `kids_vacations` WHERE `kid_id` = ? AND `study_year` = ? ORDER BY `id` DESC',
    'ii',
    [(int) $kid['id'], (int) $kid['study_year']]
);

portal_head(t('absence'));
portal_top($user, $kid);
echo '<main class="page"><div class="wrap">';
echo '<h1 class="page-title">' . h(t('absence')) . '</h1>';
if ($flash) {
    echo '<p class="flash">' . h($flash) . '</p>';
}
echo '<form class="paper" method="post" enctype="multipart/form-data">';
echo '<input type="hidden" name="kid_id" value="' . (int) $kid['id'] . '">';
echo '<label class="field"><span>' . h(t('from')) . '</span><input type="date" name="start" required></label>';
echo '<label class="field"><span>' . h(t('to')) . '</span><input type="date" name="end" required></label>';
echo '<label class="field"><span>' . h(t('note')) . '</span><textarea name="text"></textarea></label>';
echo '<label class="field"><span>' . h(t('absence')) . '</span><select name="type">';
echo '<option value="1">' . h(t('type_sick')) . '</option>';
echo '<option value="2">' . h(t('type_champ')) . '</option>';
echo '<option value="3">' . h(t('type_travel')) . '</option>';
echo '<option value="4" selected>' . h(t('type_na')) . '</option>';
echo '</select></label>';
echo '<label class="field"><span>' . h(t('sick_note')) . '</span><input type="file" name="sick_note" accept="image/*"></label>';
echo '<button class="btn btn-navy" type="submit">' . h(t('send')) . '</button>';
echo '</form>';
if ($past) {
    echo '<div class="list" style="margin-top:20px">';
    foreach ($past as $row) {
        echo '<div class="row"><time>' . h(date('d/m/Y', (int) $row['vacation_date'])) . ' – ' . h(date('d/m/Y', (int) $row['vacation_end'])) . '</time>';
        echo '<p>' . h((string) $row['text']) . '</p></div>';
    }
    echo '</div>';
}
echo '</div></main>';
portal_foot();
