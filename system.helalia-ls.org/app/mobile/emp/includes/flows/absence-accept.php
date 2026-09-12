<?php

if (!isset($staffLang)) {

    $staffLang = 'eng';

}

require_once dirname(__DIR__) . '/staff.php';

require_once dirname(__DIR__) . '/services.php';

require_once dirname(__DIR__) . '/staff-absence.php';



if (!svc_can('app9_access') && empty($showAbsAccept)) {

    svc_go('emp-view.php');

}



$page = basename($_SERVER['PHP_SELF']);

$stage = svc_int('id', -1);



if ($page === 'absence-accept-list.php' && isset($_GET['accept'])) {

    staff_abs_need_stage($stage, 'accept');

    svc_accept_one((int) $_GET['accept']);

    svc_go('absence-accept-list.php?id=' . $stage);

}



if ($page === 'absence-accept-list.php') {

    staff_abs_need_stage($stage, 'accept');

    svc_boot($S['accept_title'], 'absence-accept.php');

    echo '<p class="lede">' . staff_h($S['students'] . ' · ' . svc_stage($stage)) . '</p>';

    $rows = svc_accept_list($stage);

    if (!$rows) {

        svc_empty();

    } else {

        echo '<div class="rows">';

        foreach ($rows as $a) {

            echo '<div class="row t-coral">';

            echo '<span class="row__ico">' . staff_ico('user') . '</span>';

            echo '<span class="row__body"><span class="row__title">' . staff_h(svc_kid_name($a['kid_id'])) . '</span>';

            echo '<span class="row__meta">' . staff_h(svc_year($a['study_year']) . ' · ' . svc_class_name($a['class'])) . '</span></span>';

            echo '<a class="row-btn t-green" href="absence-accept-list.php?id=' . $stage . '&accept=' . (int) $a['id'] . '" aria-label="' . staff_h($S['accept']) . '">' . staff_ico('send') . '</a>';

            echo '</div>';

        }

        echo '</div>';

    }

    staff_inner_end();

    return;

}



svc_boot($S['accept_title'], 'absence.php');

$stages = svc_stage_access('accept');

if (!$stages) {

    svc_empty();

} else {

    echo '<div class="rows">';

    foreach ($stages as $id) {

        svc_row('absence-accept-list.php?id=' . $id, svc_stage($id), '', null, 't-coral', 'clipboard');

    }

    echo '</div>';

}

staff_inner_end();

