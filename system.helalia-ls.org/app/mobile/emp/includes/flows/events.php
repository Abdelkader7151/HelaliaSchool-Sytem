<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

$page = basename($_SERVER['PHP_SELF']);

if ($page === 'events-view.php') {
    $id = svc_int('id');
    $ev = svc_event($id);
    svc_boot($S['event_info'], 'events.php');
    if (!$ev) {
        svc_empty();
        staff_inner_end();
        return;
    }
    $name = ($staffLang === 'arb' && !empty($ev['name_arb'])) ? $ev['name_arb'] : $ev['name_eng'];
    $text = ($staffLang === 'arb' && !empty($ev['text_arb'])) ? $ev['text_arb'] : $ev['text_eng'];
    echo '<div class="svc-facts">';
    echo '<div class="svc-fact"><b>' . staff_h($S['events_title']) . '</b><span>' . staff_h($name) . '</span></div>';
    if (!empty($ev['start'])) {
        echo '<div class="svc-fact"><b>' . staff_h($S['start']) . '</b><span>' . staff_h(date('d/m/Y', (int) $ev['start'])) . '</span></div>';
    }
    if (!empty($ev['end'])) {
        echo '<div class="svc-fact"><b>' . staff_h($S['end']) . '</b><span>' . staff_h(date('d/m/Y', (int) $ev['end'])) . '</span></div>';
    }
    echo '<div class="svc-fact"><b>' . staff_h($S['year']) . '</b><span>' . staff_h(svc_year($ev['study_year'])) . '</span></div>';
    if ($text !== '') {
        echo '<div class="svc-fact"><b></b><span>' . staff_h($text) . '</span></div>';
    }
    echo '</div>';
    staff_inner_end();
    return;
}

svc_boot($S['events_title']);
$year = isset($_GET['id']) ? (int) $_GET['id'] : null;
$rows = svc_events($year);
if (!$rows) {
    svc_empty();
} else {
    echo '<div class="rows">';
    foreach ($rows as $e) {
        $name = ($staffLang === 'arb' && !empty($e['name_arb'])) ? $e['name_arb'] : $e['name_eng'];
        $meta = '';
        if (!empty($e['start'])) {
            $meta = $S['start'] . ': ' . date('d/m/Y', (int) $e['start']);
        }
        if (!empty($e['end'])) {
            $meta .= ($meta ? ' · ' : '') . $S['end'] . ': ' . date('d/m/Y', (int) $e['end']);
        }
        svc_row('events-view.php?id=' . (int) $e['id'], $name, $meta, null, 't-green', 'flag');
    }
    echo '</div>';
}
staff_inner_end();
