<?php

function staff_abs_boot()
{
    global $showAbsence, $showAbsCollect, $showAbsConfirm, $showAbsAccept, $staffPreview;

    if ($staffPreview) {
        return;
    }
    if (empty($showAbsence)) {
        header('Location: emp-view.php');
        exit;
    }
}

function staff_abs_has_access()
{
    global $showAbsCollect, $showAbsConfirm, $showAbsAccept, $staffPreview;

    if ($staffPreview) {
        return true;
    }
    return !empty($showAbsCollect) || !empty($showAbsConfirm) || !empty($showAbsAccept);
}

function staff_abs_message_page($title, $text, $backHref)
{
    global $L;
    staff_inner($title, $backHref, 'home');
    echo '<div class="tool-empty"><p>' . staff_h($text) . '</p></div>';
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($backHref) . '">' . staff_h($L['back']) . '</a>';
    staff_inner_end();
    exit;
}

function staff_abs_pick($href, $icon, $label)
{
    global $staffLang;
    $go = ($staffLang === 'arb') ? '‹' : '›';
    echo '<a class="settings__item pick" href="' . staff_h($href) . '">';
    echo '<span class="pick__ico">' . staff_ico($icon) . '</span>';
    echo '<span>' . staff_h($label) . '</span>';
    echo '<span class="settings__go">' . $go . '</span>';
    echo '</a>';
}

function staff_abs_render_hub()
{
    global $L, $showAbsCollect, $showAbsConfirm, $showAbsAccept, $S;

    if (!staff_abs_has_access()) {
        staff_abs_message_page($L['absence'], $L['absence_empty'], 'emp-view.php');
    }

    echo '<p class="lede staff-lede">' . staff_h($L['absence_lede']) . '</p>';

    $rows = array();
    if (!empty($showAbsCollect)) {
        $rows[] = array('absence-collect.php', 'list', isset($S['collect_title']) ? $S['collect_title'] : $L['absence_collect']);
    }
    if (!empty($showAbsConfirm)) {
        $rows[] = array('absence-confirm.php', 'check', isset($S['confirm_title']) ? $S['confirm_title'] : $L['absence_confirm']);
    }
    if (!empty($showAbsAccept)) {
        $rows[] = array('absence-accept.php', 'clipboard', isset($S['accept_title']) ? $S['accept_title'] : $L['absence_accept']);
    }

    if (!$rows) {
        echo '<div class="tool-empty"><p>' . staff_h($L['absence_empty']) . '</p></div>';
        return;
    }

    echo '<div class="settings">';
    foreach ($rows as $row) {
        staff_abs_pick($row[0], $row[1], $row[2]);
    }
    echo '</div>';
}

function staff_abs_need_collect_year($year)
{
    global $L, $S;
    $year = (int) $year;
    $allowed = function_exists('svc_collect_years') ? svc_collect_years() : array();
    if (!in_array($year, $allowed, true)) {
        staff_abs_message_page(
            isset($S['collect_title']) ? $S['collect_title'] : $L['absence_collect'],
            $L['absence_year_invalid'],
            'absence-collect.php'
        );
    }
    return $year;
}

function staff_abs_need_collect_class($year, $class)
{
    global $L, $S;
    $year = (int) $year;
    $class = (int) $class;
    if ($class < 1) {
        staff_abs_message_page(
            isset($S['select_class']) ? $S['select_class'] : $L['absence_collect'],
            $L['absence_class_invalid'],
            'absence-collect.php?year=' . $year
        );
    }
    $allowed = function_exists('svc_classes_year') ? svc_classes_year($year) : array();
    foreach ($allowed as $row) {
        if ((int) $row['id'] === $class) {
            return $class;
        }
    }
    staff_abs_message_page(
        isset($S['select_class']) ? $S['select_class'] : $L['absence_collect'],
        $L['absence_class_invalid'],
        'absence-collect.php?year=' . $year
    );
}

function staff_abs_need_stage($stage, $kind)
{
    global $L, $S;
    $stage = (int) $stage;
    $allowed = function_exists('svc_stage_access') ? svc_stage_access($kind) : array();
    if (!in_array($stage, $allowed, true)) {
        $title = $L['absence'];
        if ($kind === 'confirm' && isset($S['confirm_title'])) {
            $title = $S['confirm_title'];
        } elseif ($kind === 'accept' && isset($S['accept_title'])) {
            $title = $S['accept_title'];
        }
        staff_abs_message_page($title, $L['absence_stage_invalid'], 'absence.php');
    }
    return $stage;
}
