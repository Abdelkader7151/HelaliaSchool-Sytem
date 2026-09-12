<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

svc_boot($S['appt_title']);
$rows = svc_appointments();
if (!$rows) {
    echo '<p class="svc-empty">' . staff_h($S['no_meetings']) . '</p>';
} else {
    echo '<div class="rows">';
    foreach ($rows as $a) {
        $meta = $S['date'] . ': ' . date('d/m/Y', (int) $a['day']) . ' · ' . $S['at'] . ' ' . $a['meeting_time'];
        $badge = empty($a['kid_id']) ? $S['open'] : $S['booked'];
        $title = svc_subject($a['subject']) . ' (' . svc_year($a['study_year']) . ')';
        echo '<div class="row t-gold">';
        echo '<span class="row__ico">' . staff_ico('clock') . '</span>';
        echo '<span class="row__body"><span class="row__title">' . staff_h($title) . '</span>';
        echo '<span class="row__meta">' . staff_h($meta) . '</span></span>';
        echo '<span class="chip">' . staff_h($badge) . '</span>';
        echo '</div>';
    }
    echo '</div>';
}
staff_inner_end();
