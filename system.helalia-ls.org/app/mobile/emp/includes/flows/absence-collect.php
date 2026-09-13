<?php

if (!isset($staffLang)) {

    $staffLang = 'eng';

}

require_once dirname(__DIR__) . '/staff.php';

require_once dirname(__DIR__) . '/services.php';

require_once dirname(__DIR__) . '/staff-absence.php';



if (!svc_can('app1_access') && empty($showAbsCollect)) {

    svc_go('emp-view.php');

}



$page = basename($_SERVER['PHP_SELF']);

$year = svc_int('year', -1);

$class = svc_int('class');



if ($page === 'absence-collect-kids.php' && isset($_GET['del'])) {

    staff_abs_need_collect_year($year);

    staff_abs_need_collect_class($year, $class);

    svc_delete_absence((int) $_GET['del']);

    svc_go('absence-collect-kids.php?year=' . $year . '&class=' . $class);

}



if ($page === 'absence-collect-kids.php' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    staff_abs_need_collect_year($year);

    staff_abs_need_collect_class($year, $class);

    svc_collect_submit($year, $class, $_POST);

    svc_go('absence-collect-kids.php?year=' . $year . '&class=' . $class);

}



if ($page === 'absence-collect-kids.php') {

    staff_abs_need_collect_year($year);

    staff_abs_need_collect_class($year, $class);

    svc_boot($S['collect_title'], 'absence-collect-class.php?year=' . $year);

    echo '<p class="lede">' . staff_h(trim(svc_year($year) . ' · ' . svc_class_name($class))) . '</p>';

    $kids = svc_kids_class($year, $class);

    echo '<form method="post" action="absence-collect-kids.php?year=' . $year . '&class=' . $class . '">';

    echo '<div class="svc-checks">';

    $shown = 0;

    $i = 1;

    foreach ($kids as $k) {

        $kidId = (int) $k['id'];

        if (svc_kid_absent_today($kidId)) {

            $i++;

            continue;

        }

        $shown++;

        $label = svc_kid_name($kidId) . ' — ' . $i;

        echo '<label class="svc-check"><input type="checkbox" name="kid_' . $kidId . '" value="' . $kidId . '"><span>' . staff_h($label) . '</span></label>';

        $i++;

    }

    if ($shown === 0) {

        echo '</div>';

        svc_empty();

    } else {

        echo '</div><div class="svc-actions"><button class="btn btn--primary" name="submit" type="submit">' . staff_h($S['submit']) . '</button></div>';

    }

    echo '</form>';

    $marked = svc_today_absences($year, $class);

    echo '<div class="sec svc-sub"><h2 class="sec__title">' . staff_h($S['marked']) . '</h2></div>';

    if (!$marked) {

        svc_empty();

    } else {

        echo '<div class="rows">';

        foreach ($marked as $a) {

            echo '<div class="row t-coral row--plain">';

            echo '<span class="row__ico">' . staff_ico('user') . '</span>';

            echo '<span class="row__body"><span class="row__title">' . staff_h(svc_kid_name($a['kid_id'])) . '</span></span>';

            if ((int) $a['confirm'] === 0) {

                echo '<a class="row-btn row-btn--danger" href="absence-collect-kids.php?year=' . $year . '&class=' . $class . '&del=' . (int) $a['id'] . '" aria-label="' . staff_h($S['delete']) . '">' . staff_ico('trash') . '</a>';

            }

            echo '</div>';

        }

        echo '</div>';

    }

    staff_inner_end();

    return;

}



if ($page === 'absence-collect-class.php') {

    staff_abs_need_collect_year($year);

    svc_boot($S['select_class'], 'absence-collect.php');

    $rows = svc_classes_year($year);

    if (!$rows) {

        svc_empty();

    } else {

        echo '<div class="rows">';

        foreach ($rows as $row) {

            $cid = (int) $row['id'];

            $name = isset($row['name']) && $row['name'] !== '' ? $row['name'] : (isset($row['fn_name']) ? $row['fn_name'] : svc_class_name($cid));

            svc_row('absence-collect-kids.php?year=' . $year . '&class=' . $cid, $name, svc_year($year), null, 't-gold', 'people');

        }

        echo '</div>';

    }

    staff_inner_end();

    return;

}



svc_boot($S['collect_title'], 'absence.php');

$years = svc_collect_years();

if (!$years) {

    svc_empty();

} else {

    echo '<div class="rows">';

    foreach ($years as $y) {

        svc_row('absence-collect-class.php?year=' . $y, svc_year($y), '', null, 't-gold', 'list');

    }

    echo '</div>';

}

staff_inner_end();

