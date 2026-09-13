<?php

if (!isset($staffLang)) {

    $staffLang = 'eng';

}

require_once dirname(__DIR__) . '/staff.php';

require_once dirname(__DIR__) . '/services.php';

require_once dirname(__DIR__) . '/staff-absence.php';



if (!svc_can('app6_access') && empty($showAbsConfirm)) {

    svc_go('emp-view.php');

}



$page = basename($_SERVER['PHP_SELF']);

$stage = svc_int('id', -1);



if ($page === 'absence-confirm-list.php' && isset($_GET['del'])) {

    staff_abs_need_stage($stage, 'confirm');

    svc_delete_absence((int) $_GET['del']);

    svc_go('absence-confirm-list.php?id=' . $stage);

}



if ($page === 'absence-confirm-list.php' && isset($_GET['confirm'])) {

    staff_abs_need_stage($stage, 'confirm');

    svc_confirm_all($stage);

    svc_go('absence-confirm-list.php?id=' . $stage);

}



if ($page === 'absence-confirm-list.php') {

    staff_abs_need_stage($stage, 'confirm');

    svc_boot($S['confirm_title'], 'absence-confirm.php');

    echo '<p class="lede">' . staff_h($S['students'] . ' · ' . svc_stage($stage)) . '</p>';

    $rows = svc_confirm_list($stage);

    if (!$rows) {

        svc_empty();

    } else {

        echo '<div class="rows">';

        foreach ($rows as $a) {

            echo '<div class="row t-green">';

            echo '<span class="row__ico">' . staff_ico('user') . '</span>';

            echo '<span class="row__body"><span class="row__title">' . staff_h(svc_kid_name($a['kid_id'])) . '</span>';

            echo '<span class="row__meta">' . staff_h(svc_year($a['study_year']) . ' · ' . svc_class_name($a['class'])) . '</span></span>';

            if ((int) $a['confirm'] === 0) {

                echo '<a class="row-btn row-btn--danger" href="absence-confirm-list.php?id=' . $stage . '&del=' . (int) $a['id'] . '">' . staff_ico('trash') . '</a>';

            } else {

                echo '<span class="chip chip--gold">' . staff_h($S['confirm']) . '</span>';

            }

            echo '</div>';

        }

        echo '</div>';

    }

    if (svc_confirm_pending($stage)) {

        echo '<div class="svc-actions"><a class="btn btn--primary" href="absence-confirm-list.php?id=' . $stage . '&confirm=1">' . staff_h($S['confirm']) . '</a></div>';

    }

    staff_inner_end();

    return;

}



svc_boot($S['confirm_title'], 'absence.php');

$stages = svc_stage_access('confirm');

if (!$stages) {

    svc_empty();

} else {

    echo '<div class="rows">';

    foreach ($stages as $id) {

        svc_row('absence-confirm-list.php?id=' . $id, svc_stage($id), '', null, 't-green', 'check');

    }

    echo '</div>';

}

staff_inner_end();

