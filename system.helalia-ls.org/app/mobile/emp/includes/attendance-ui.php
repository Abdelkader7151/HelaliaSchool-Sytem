<?php
require_once __DIR__ . '/attendance-punch.php';

function staff_render_checkin()
{
    global $L, $empId, $staffLang, $staffPreview;
    $status = punch_status((int) $empId, $staffLang);
    $api = '../api/punch.php?lang=' . (($staffLang === 'arb') ? 'arb' : 'eng');
    $handoff = '../api/gps-handoff.php?lang=' . (($staffLang === 'arb') ? 'arb' : 'eng');
    $cfg = htmlspecialchars(json_encode($status), ENT_QUOTES, 'UTF-8');
    echo '<div class="punch" id="punch-root" data-api="' . staff_h($api) . '" data-handoff="' . staff_h($handoff) . '" data-status="' . $cfg . '">';

    echo '<section class="punch-card punch-loc" data-loc-card>';
    echo '<p class="punch-kicker">' . staff_h($L['loc_title']) . '</p>';
    echo '<p class="punch-loc__state" data-loc-state>' . staff_h($L['loc_off']) . '</p>';
    echo '<p class="punch-loc__meta" data-loc-meta></p>';
    echo '<p class="punch-loc__hint" data-loc-hint hidden></p>';
    echo '<button class="punch-loc__enable" type="button" data-loc-enable hidden>' . staff_h($L['loc_enable']) . '</button>';
    echo '<a class="punch-loc__safari" data-loc-safari hidden href="#" rel="noopener">' . staff_h(isset($L['loc_safari']) ? $L['loc_safari'] : 'Open in Safari') . '</a>';
    echo '</section>';

    echo '<section class="punch-card punch-today">';
    echo '<p class="punch-kicker">' . staff_h($L['today_title']) . '</p>';
    echo '<p class="punch-today__empty" data-today-empty>' . staff_h($L['today_empty']) . '</p>';
    echo '<div class="punch-recorded" data-today-in hidden>';
    echo '<span>' . staff_h($L['today_recorded']) . '</span>';
    echo '<b data-fact-recorded>—</b>';
    echo '</div>';
    echo '<div class="punch-facts" data-today-facts hidden>';
    echo '<div><span>' . staff_h($L['att_in']) . '</span><b data-fact-in>—</b></div>';
    echo '<div><span>' . staff_h($L['att_out']) . '</span><b data-fact-out>—</b></div>';
    echo '<div><span>' . staff_h($L['att_delay']) . '</span><b data-fact-delay>—</b></div>';
    echo '<div><span>' . staff_h($L['att_early']) . '</span><b data-fact-early>—</b></div>';
    echo '<div class="punch-facts__wide"><span>' . staff_h($L['worked_label']) . '</span><b data-fact-worked>—</b></div>';
    echo '</div></section>';

    echo '<p class="punch-msg" data-punch-msg hidden></p>';

    echo '<button class="btn btn--gold punch-btn" type="button" data-punch-btn disabled>' . staff_h($L['checkin_btn']) . '</button>';
    echo '<p class="punch-closed" data-checkout-closed hidden>' . staff_h($L['checkout_closed']) . '</p>';
    echo '<nav class="punch-quick" aria-label="' . staff_h($L['checkin']) . '">';
    echo '<a class="punch-quick__link punch-quick__link--vac" href="my-absence.php?from=checkin">';
    echo staff_ico('thermo') . '<span>' . staff_h($L['my_absence']) . '</span></a>';
    echo '<a class="punch-quick__link punch-quick__link--report" href="my-attendance.php?from=checkin">';
    echo staff_ico('clipboard') . '<span>' . staff_h($L['att_report_btn']) . '</span></a>';
    echo '</nav>';
    echo '</div>';

    $i18n = array(
        'loc_off' => $L['loc_off'],
        'loc_ask' => $L['loc_ask'],
        'loc_ask_hint' => isset($L['loc_ask_hint']) ? $L['loc_ask_hint'] : '',
        'loc_checking' => isset($L['loc_checking']) ? $L['loc_checking'] : 'Finding your location…',
        'loc_ios' => isset($L['loc_ios']) ? $L['loc_ios'] : '',
        'loc_safari' => isset($L['loc_safari']) ? $L['loc_safari'] : 'Open in Safari',
        'loc_safari_hint' => isset($L['loc_safari_hint']) ? $L['loc_safari_hint'] : '',
        'loc_denied' => $L['loc_denied'],
        'loc_timeout' => isset($L['loc_timeout']) ? $L['loc_timeout'] : '',
        'loc_enable' => $L['loc_enable'],
        'loc_retry' => $L['loc_retry'],
        'loc_https' => $L['loc_https'],
        'loc_unsupported' => $L['loc_unsupported'],
        'loc_on' => $L['loc_on'],
        'loc_inside' => $L['loc_inside'],
        'loc_outside' => $L['loc_outside'],
        'loc_accuracy' => $L['loc_accuracy'],
        'loc_away' => $L['loc_away'],
        'today_empty' => $L['today_empty'],
        'today_recorded' => $L['today_recorded'],
        'punch_wait' => $L['punch_wait'],
        'checkin_btn' => $L['checkin_btn'],
        'checkout_btn' => $L['checkout_btn'],
        'err_preview' => $L['err_preview'],
        'err_outside' => $L['err_outside'],
        'err_accuracy' => $L['err_accuracy'],
        'err_already_in' => $L['err_already_in'],
        'err_already_out' => $L['err_already_out'],
        'err_need_in' => $L['err_need_in'],
        'err_vacation' => $L['err_vacation'],
        'err_too_soon' => $L['err_too_soon'],
        'err_checkout_closed' => $L['err_checkout_closed'],
        'err_csrf' => $L['err_csrf'],
        'err_rate' => $L['err_rate'],
        'err_generic' => $L['err_generic'],
        'location_invalid' => $L['err_generic'],
        'forbidden' => $L['err_generic'],
        'write_failed' => $L['err_generic'],
        'method' => $L['err_generic'],
        'bad_action' => $L['err_generic'],
        'csrf' => $L['err_csrf'],
        'preview_only' => $L['err_preview'],
        'outside' => $L['err_outside'],
        'accuracy_poor' => $L['err_accuracy'],
        'already_in' => $L['err_already_in'],
        'already_out' => $L['err_already_out'],
        'need_in' => $L['err_need_in'],
        'on_vacation' => $L['err_vacation'],
        'too_soon' => $L['err_too_soon'],
        'checkout_closed' => $L['err_checkout_closed'],
        'rate_limited' => $L['err_rate'],
    );
    echo '<script type="application/json" id="punch-i18n">' . json_encode($i18n) . '</script>';
    echo '<script src="../assets/js/emp-checkin.js?v=16"></script>';
}
