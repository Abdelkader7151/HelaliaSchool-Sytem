<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

if (!svc_can('app3_access') && empty($showGroups)) {
    svc_go('emp-view.php');
}

$page = basename($_SERVER['PHP_SELF']);
$year = svc_int('year', -1);
$gid = svc_int('id');

if ($page === 'groups-kids.php' && isset($_GET['kid'])) {
    svc_group_mark($gid, (int) $_GET['kid']);
    svc_go('groups-kids.php?id=' . $gid . '&year=' . $year);
}
if ($page === 'groups-kids.php' && isset($_GET['del'])) {
    svc_group_unmark($gid, (int) $_GET['del']);
    svc_go('groups-kids.php?id=' . $gid . '&year=' . $year);
}

if ($page === 'groups-kids.php') {
    $g = svc_group($gid);
    svc_boot($S['groups_title'], 'groups-list.php?year=' . ($g ? (int) $g['study_year'] : $year));
    $title = $g ? (isset($g['name']) ? $g['name'] : svc_subject($g['subject'])) : '';
    echo '<p class="lede">' . staff_h($title) . '</p>';
    $members = svc_group_members($gid);
    $today = svc_group_today($gid);
    $marked = array();
    foreach ($today as $a) {
        $marked[(int) $a['kid_id']] = $a;
    }
    echo '<div class="rows">';
    $any = false;
    foreach ($members as $m) {
        $kid = (int) $m['kid_id'];
        if (isset($marked[$kid])) {
            continue;
        }
        $any = true;
        echo '<a class="row t-blue" href="groups-kids.php?id=' . $gid . '&year=' . $year . '&kid=' . $kid . '">';
        echo '<span class="row__ico">' . staff_ico('user') . '</span>';
        echo '<span class="row__body"><span class="row__title">' . staff_h(svc_kid_name($kid)) . '</span></span>';
        echo '<span class="row__go">+</span></a>';
    }
    echo '</div>';
    if (!$any) {
        svc_empty();
    }
    echo '<div class="sec svc-sub"><h2 class="sec__title">' . staff_h($S['marked']) . '</h2></div>';
    if (!$today) {
        svc_empty();
    } else {
        echo '<div class="rows">';
        foreach ($today as $a) {
            echo '<div class="row t-coral row--plain">';
            echo '<span class="row__ico">' . staff_ico('user') . '</span>';
            echo '<span class="row__body"><span class="row__title">' . staff_h(svc_kid_name($a['kid_id'])) . '</span></span>';
            echo '<a class="row-btn row-btn--danger" href="groups-kids.php?id=' . $gid . '&year=' . $year . '&del=' . (int) $a['id'] . '">' . staff_ico('trash') . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
    staff_inner_end();
    return;
}

if ($page === 'groups-list.php') {
    svc_boot($S['select_group'], 'groups.php');
    $rows = svc_groups_year($year);
    if (!$rows) {
        svc_empty();
    } else {
        echo '<div class="rows">';
        foreach ($rows as $g) {
            $label = isset($g['name']) && $g['name'] !== '' ? $g['name'] : svc_subject($g['subject']);
            svc_row('groups-kids.php?id=' . (int) $g['id'] . '&year=' . $year, $label, svc_year($year), null, 't-blue', 'grid');
        }
        echo '</div>';
    }
    staff_inner_end();
    return;
}

svc_boot($S['groups_title']);
echo '<div class="rows">';
for ($y = 0; $y <= 14; $y++) {
    svc_row('groups-list.php?year=' . $y, svc_year($y), '', null, 't-blue', 'list');
}
echo '</div>';
staff_inner_end();
