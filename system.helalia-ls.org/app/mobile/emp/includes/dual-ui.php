<?php

function dual_kid_initials($name)
{
    $parts = preg_split('/\s+/u', trim((string) $name));
    $out = '';
    if (!empty($parts[0])) {
        $out .= function_exists('mb_substr') ? mb_substr($parts[0], 0, 1, 'UTF-8') : substr($parts[0], 0, 1);
    }
    if (!empty($parts[1])) {
        $out .= function_exists('mb_substr') ? mb_substr($parts[1], 0, 1, 'UTF-8') : substr($parts[1], 0, 1);
    }
    if ($out === '') {
        $out = 'H';
    }
    return function_exists('mb_strtoupper') ? mb_strtoupper($out, 'UTF-8') : strtoupper($out);
}

function dual_kid_meta($kid)
{
    $year = trim((string) (isset($kid['year_label']) ? $kid['year_label'] : ''));
    $class = trim((string) (isset($kid['class_label']) ? $kid['class_label'] : ''));
    if ($year === '' && isset($kid['study_year'])) {
        if (function_exists('staff_students_year_label')) {
            $year = staff_students_year_label($kid['study_year']);
        } elseif (function_exists('year_of_study')) {
            $year = trim((string) year_of_study($kid['study_year']));
        } else {
            $years = array(
                0 => 'Preschool', 1 => 'KG1', 2 => 'KG2',
                3 => 'Junior One', 4 => 'Junior Two', 5 => 'Junior Three',
                6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
                9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
                12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
            );
            $y = (int) $kid['study_year'];
            if (isset($years[$y])) {
                $year = $years[$y];
            }
        }
    }
    if ($class === '' && isset($kid['class'])) {
        if (function_exists('staff_students_class_label')) {
            $class = staff_students_class_label($kid['class']);
        } elseif (function_exists('class_name')) {
            $class = trim((string) class_name($kid['class']));
        }
    }
    if ($year !== '' && $class !== '') {
        return $year . ' · ' . $class;
    }
    return $year !== '' ? $year : $class;
}

function dual_kid_photo($kid)
{
    if (!empty($kid['photo'])) {
        return $kid['photo'];
    }
    if (function_exists('staff_students_pic_url')) {
        $photo = staff_students_pic_url((int) $kid['id'], $kid);
        if ($photo !== '' && stripos($photo, 'no-picture') === false) {
            return $photo;
        }
    }
    return '';
}

function dual_kid_tone($i)
{
    $tones = array('t-gold', 't-green', 't-coral', 't-blue');
    return $tones[$i % count($tones)];
}

function dual_job_is_teacher($job)
{
    $job = trim((string) $job);
    if ($job === '') {
        return false;
    }
    $j = function_exists('mb_strtolower') ? mb_strtolower($job, 'UTF-8') : strtolower($job);
    foreach (array('teacher', 'teach', 'tutor', 'معلم', 'معلمة', 'مدرس', 'مُدرس', 'مُعلمة') as $needle) {
        if ($needle === '') {
            continue;
        }
        $hit = function_exists('mb_stripos')
            ? mb_stripos($j, $needle, 0, 'UTF-8')
            : stripos($j, $needle);
        if ($hit !== false) {
            return true;
        }
    }
    return false;
}

function dual_emp_account_label($jobLabel, $staffLang)
{
    $job = trim((string) $jobLabel);
    $arb = ($staffLang === 'arb');
    if ($job === '') {
        return $arb ? 'إداري' : 'Employee';
    }
    if ($arb) {
        $key = function_exists('mb_strtolower') ? mb_strtolower($job, 'UTF-8') : strtolower($job);
        $map = array(
            'teacher' => 'معلم',
            'coordinator' => 'منسق',
            'admin' => 'إداري',
            'employee' => 'موظف',
        );
        if (isset($map[$key])) {
            return $map[$key];
        }
    }
    return $job;
}

function dual_role_handle_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    if (empty($GLOBALS['dualKids']) && !(function_exists('dual_is_manual_dual') && dual_is_manual_dual())) {
        header('Location: emp-view.php');
        exit;
    }
    $csrf = isset($_POST['staff_csrf']) ? (string) $_POST['staff_csrf'] : '';
    $expect = isset($_SESSION['staff_csrf']) ? (string) $_SESSION['staff_csrf'] : '';
    if ($expect === '' || !hash_equals($expect, $csrf)) {
        return;
    }
    $role = isset($_POST['helalia_role']) ? (string) $_POST['helalia_role'] : '';
    dual_set_role($role);
    if ($role === 'parent') {
        dual_open_live_parent();
    }
    header('Location: emp-view.php?dual_picked=1');
    exit;
}

function dual_render_choose()
{
    global $L, $css, $icon, $staffLang, $displayName, $jobLabel, $photoUrl, $initials, $row_get_user, $dualKids, $logo;
    $GLOBALS['staffHideChrome'] = true;
    $dir = ($staffLang === 'arb') ? 'rtl' : 'ltr';
    $go = ($staffLang === 'arb') ? '‹' : '›';
    $phone = isset($row_get_user['phone']) ? (string) $row_get_user['phone'] : '';
    $csrf = isset($_SESSION['staff_csrf']) ? $_SESSION['staff_csrf'] : '';
    $empTitle = dual_emp_account_label($jobLabel, $staffLang);
    $empIco = dual_job_is_teacher($jobLabel) ? 'cap' : 'briefcase';
    staff_head($L['role_title'], $dir, $css, $icon);
    echo '<header class="hero hero--tall hero--staff hero--choose">';
    echo '<div class="hero__row">';
    echo '<a class="menu-btn" href="' . staff_h($L['lang_href']) . '" aria-label="' . staff_h($L['nav_language']) . '">' . staff_ico('globe') . '</a>';
    echo '<div class="grow">';
    echo '<p class="hero__eyebrow">' . staff_h($L['school']) . '</p>';
    echo '<h1 class="hero__title">' . staff_h($L['role_hello']) . '</h1>';
    echo '</div></div>';
    echo '<section class="featured">';
    if (!empty($photoUrl)) {
        echo '<img class="av av--lg" src="' . staff_h($photoUrl) . '" alt="">';
    } elseif (!empty($logo)) {
        echo '<img class="av av--lg" src="' . staff_h($logo) . '" alt="">';
    } else {
        echo '<span class="av av--lg t-gold">' . staff_h($initials) . '</span>';
    }
    echo '<div class="featured__body">';
    echo '<p class="featured__name">' . staff_h($displayName) . '</p>';
    $meta = trim($phone . ($jobLabel !== '' ? ' · ' . $jobLabel : ''));
    if ($meta !== '') {
        echo '<p class="featured__meta">' . staff_h($meta) . '</p>';
    }
    echo '</div></section></header>';
    echo '<main class="page page--staff page--choose">';
    echo '<h2 class="rolepick__title">' . staff_h($L['role_title']) . '</h2>';
    echo '<form class="rolepick" method="post" action="choose-role.php">';
    echo '<input type="hidden" name="staff_csrf" value="' . staff_h($csrf) . '">';
    echo '<button class="rolecard rolecard--emp" type="submit" name="helalia_role" value="emp">';
    echo '<span class="rolecard__ico">' . staff_ico($empIco) . '</span>';
    echo '<span class="rolecard__body"><strong>' . staff_h($empTitle) . '</strong></span>';
    echo '</button>';
    echo '<button class="rolecard rolecard--parent" type="submit" name="helalia_role" value="parent">';
    echo '<span class="rolecard__ico">' . staff_ico('family') . '</span>';
    echo '<span class="rolecard__body"><strong>' . staff_h($L['role_parent']) . '</strong></span>';
    echo '</button>';
    echo '</form>';
    echo '</main>';
    staff_nav('role');
}

function dual_parent_asset($rel)
{
    return '../assets/' . ltrim((string) $rel, '/');
}

function dual_svg($name)
{
    $paths = array(
        'bell' => '<path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
        'news' => '<path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/><path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/><path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/>',
        'students' => '<circle cx="9" cy="8" r="3.2"/><path d="M3 19a6 6 0 0 1 12 0"/><path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/><path d="M18 13.5a6 6 0 0 1 3 5.5"/>',
        'cog' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'back' => '<path d="M15 19 8 12l7-7"/>',
        'hw' => '<path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H19v14H6a2 2 0 0 0-2 2V5.5z"/><path d="M8 8.5h7M8 12h5"/>',
    );
    if (!isset($paths[$name])) {
        return '';
    }
    $sw = ($name === 'hw') ? '2.2' : '2';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $sw . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths[$name] . '</svg>';
}

function dual_kid_stage($kid)
{
    global $staffLang;
    $y = isset($kid['study_year']) ? (int) $kid['study_year'] : 0;
    $arb = (isset($staffLang) && $staffLang === 'arb');
    if ($y <= 8) {
        return $arb ? 'ابتدائي' : 'Junior';
    }
    if ($y <= 11) {
        return $arb ? 'إعدادي' : 'Middle';
    }
    return $arb ? 'ثانوي' : 'Senior';
}

function dual_parent_head($title)
{
    global $staffLang;
    $GLOBALS['staffHideChrome'] = true;
    $dir = ($staffLang === 'arb') ? 'rtl' : 'ltr';
    $lang = ($dir === 'rtl') ? 'ar' : 'en';
    $css = dual_parent_asset('css/parent-app.css') . '?v=40';
    $ico = dual_parent_asset('img/logo-icon.png');
    if (!headers_sent()) {
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
    echo '<!DOCTYPE html><html lang="' . $lang . '" dir="' . $dir . '"><head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">';
    echo '<meta name="theme-color" content="#112c5a">';
    echo '<meta name="apple-mobile-web-app-capable" content="yes">';
    echo '<meta name="mobile-web-app-capable" content="yes">';
    echo '<title>' . staff_h($title) . ' · Helalia</title>';
    echo '<link rel="icon" href="' . staff_h($ico) . '">';
    echo '<link rel="apple-touch-icon" href="' . staff_h($ico) . '">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    if ($dir === 'rtl') {
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">';
    } else {
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">';
    }
    echo '<link rel="stylesheet" href="' . staff_h($css) . '">';
    echo '</head><body><div class="app">';
}

function dual_parent_bell($href)
{
    global $L;
    echo '<div class="bells">';
    echo '<a class="bell bell--alert" href="' . staff_h($href) . '" aria-label="' . staff_h($L['parent_alerts']) . '">';
    echo dual_svg('bell');
    echo '</a></div>';
}

function dual_parent_nav($active)
{
    global $L, $staffLang;
    $label = ($staffLang === 'arb') ? 'الرئيسية' : 'Home';
    $items = array(
        array('home', 'parent-home.php', 'students', $L['parent_students_nav']),
        array('news', 'parent-news.php', 'news', $L['parent_news']),
        array('settings', 'parent-settings.php', 'cog', $L['settings']),
    );
    echo '<nav class="nav nav--3" aria-label="' . staff_h($label) . '">';
    foreach ($items as $it) {
        $on = ($active === $it[0]) ? ' is-active' : '';
        echo '<a class="nav__item' . $on . '" href="' . staff_h($it[1]) . '">';
        echo dual_svg($it[2]);
        echo '<span>' . staff_h($it[3]) . '</span><span class="nav__dot"></span>';
        echo '</a>';
    }
    echo '</nav>';
}

function dual_parent_end()
{
    echo '</div>';
    echo '<script>document.querySelectorAll(".bell__badge").forEach(function(b){if(parseInt(b.textContent,10)>0===false)b.remove();});</script>';
    echo '<script src="' . staff_h(dual_parent_asset('js/app.js')) . '" defer></script>';
    echo '</body></html>';
}

function dual_parent_art($file)
{
    return dual_parent_asset('img/quick/' . $file);
}

function dual_parent_go()
{
    global $staffLang;
    return ($staffLang === 'arb') ? '‹' : '›';
}

function dual_render_parent_home()
{
    global $L, $dualKids;
    $kids = is_array($dualKids) ? $dualKids : array();
    dual_parent_head($L['parent_home']);
    echo '<header class="hero hero--tall">';
    echo '<div class="hero__row">';
    echo '<div class="grow"><p class="hero__eyebrow">' . staff_h($L['parent_eyebrow']) . '</p>';
    echo '<h1 class="hero__title">' . staff_h($L['parent_home']) . '</h1></div>';
    dual_parent_bell('parent-news.php');
    echo '</div></header>';
    echo '<main class="page">';
    if (!$kids) {
        echo '<p>' . staff_h($L['parent_empty']) . '</p>';
    } else {
        echo '<div class="kids">';
        foreach ($kids as $kid) {
            $href = 'parent-kid.php?id=' . urlencode((string) $kid['id']);
            $photo = dual_kid_photo($kid);
            echo '<a class="kidcard" href="' . staff_h($href) . '">';
            echo '<div class="kidcard__photo">';
            if ($photo !== '') {
                echo '<img src="' . staff_h($photo) . '" alt="' . staff_h($kid['fn_name']) . '">';
            } else {
                echo '<span class="kidcard__initials">' . staff_h(dual_kid_initials($kid['fn_name'])) . '</span>';
            }
            echo '<span class="kidcard__stage">' . staff_h(dual_kid_stage($kid)) . '</span>';
            echo '</div>';
            echo '<div class="kidcard__body">';
            echo '<p class="kidcard__name">' . staff_h($kid['fn_name']) . '</p>';
            echo '<p class="kidcard__meta">' . staff_h(dual_kid_meta($kid)) . '</p>';
            echo '</div></a>';
        }
        echo '</div>';
    }
    echo '</main>';
    echo '<a class="fab" href="parent-add.php" aria-label="' . staff_h($L['parent_add']) . '">' . dual_svg('plus') . '</a>';
    dual_parent_nav('home');
    dual_parent_end();
}

function dual_render_parent_kid()
{
    global $L, $staffLang;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $kid = dual_find_kid($id);
    if (!$kid) {
        header('Location: parent-home.php');
        exit;
    }
    $qs = 'id=' . urlencode((string) $id);
    $pfx = 'kid/';
    $photo = dual_kid_photo($kid);
    $meta = dual_kid_meta($kid);
    $idLabel = $L['parent_id'] . ' ' . $kid['id'];
    dual_parent_head($kid['fn_name']);
    echo '<header class="hero hero--tall">';
    echo '<div class="hero__row"><div class="grow"></div>';
    dual_parent_bell('parent-news.php');
    echo '</div>';
    echo '<section class="featured featured--profile">';
    if ($photo !== '') {
        echo '<img class="av av--lg" src="' . staff_h($photo) . '" alt="' . staff_h($kid['fn_name']) . '">';
    } else {
        echo '<span class="av av--lg t-gold">' . staff_h(dual_kid_initials($kid['fn_name'])) . '</span>';
    }
    echo '<div class="featured__body">';
    echo '<p class="featured__name">' . staff_h($kid['fn_name']) . '</p>';
    if ($meta !== '') {
        echo '<p class="featured__meta">' . staff_h($meta) . '</p>';
    }
    echo '<div class="featured__tags"><span class="tag">' . staff_h($idLabel) . '</span></div>';
    echo '</div></section></header>';
    echo '<main class="page">';
    echo '<div class="quickrow quickrow--3">';
    echo '<a class="quick t-navy" href="' . $pfx . 'ask-teacher.php?' . $qs . '"><span class="quick__ico quick__ico--art"><img src="' . staff_h(dual_parent_art('ask.webp')) . '" alt="" aria-hidden="true"></span>' . staff_h($L['parent_ask']) . '</a>';
    echo '<a class="quick t-blue" href="' . $pfx . 'calendar.php?' . $qs . '"><span class="quick__ico quick__ico--art"><img src="' . staff_h(dual_parent_art('calendar.avif')) . '" alt="" aria-hidden="true"></span>' . staff_h($L['parent_calendar']) . '</a>';
    echo '<a class="quick t-green" href="' . $pfx . 'absence.php?' . $qs . '"><span class="quick__ico quick__ico--art"><img src="' . staff_h(dual_parent_art('attendance.webp')) . '" alt="" aria-hidden="true"></span>' . staff_h($L['parent_attendance']) . '</a>';
    echo '</div>';
    echo '<div class="tiles">';
    $tiles = array(
        array('homework.webp', $L['parent_homework_live'], $pfx . 'homework-subjects.php?' . $qs, 't-coral'),
        array('memo.webp', $L['parent_memo_live'], $pfx . 'kid-memo.php?' . $qs, 't-blue'),
        array('certificate.webp', $L['parent_results'], $pfx . 'cert.php?' . $qs, 't-green'),
        array('revision.webp', $L['parent_revision'], $pfx . 'revision-subjects.php?' . $qs, 't-gold'),
        array('plan.webp', $L['parent_plan'], $pfx . 'plan.php?' . $qs, 't-navy'),
        array('gallery.webp', $L['parent_gallery'], $pfx . 'gallery.php?' . $qs, 't-coral'),
    );
    foreach ($tiles as $tile) {
        echo '<a class="tile ' . $tile[3] . '" href="' . staff_h($tile[2]) . '">';
        echo '<span class="tile__ico tile__ico--art"><img src="' . staff_h(dual_parent_art($tile[0])) . '" alt="" aria-hidden="true"></span>';
        echo '<span class="tile__label">' . staff_h($tile[1]) . '</span>';
        echo '</a>';
    }
    echo '</div></main>';
    dual_parent_nav('home');
    dual_parent_end();
}

function dual_render_parent_news()
{
    global $L;
    dual_parent_head($L['parent_news']);
    echo '<header class="hero">';
    echo '<div class="hero__row">';
    echo '<h1 class="hero__title">' . staff_h($L['parent_news']) . '</h1>';
    dual_parent_bell('parent-news.php');
    echo '</div></header>';
    echo '<main class="page">';
    echo '<div class="card stack"><p>' . staff_h($L['parent_news_empty']) . '</p></div>';
    echo '</main>';
    dual_parent_nav('news');
    dual_parent_end();
}

function dual_render_parent_settings()
{
    global $L, $staffLang;
    $go = dual_parent_go();
    $other = ($staffLang === 'arb') ? '../eng/parent-settings.php' : '../arb/parent-settings.php';
    $otherLabel = ($staffLang === 'arb') ? 'English' : 'العربية';
    $otherTiny = ($staffLang === 'arb') ? 'العربية' : 'English';
    dual_parent_head($L['settings']);
    echo '<header class="hero hero--tall">';
    echo '<div class="hero__row">';
    echo '<h1 class="hero__title">' . staff_h($L['settings']) . '</h1>';
    dual_parent_bell('parent-news.php');
    echo '</div></header>';
    echo '<main class="page">';
    echo '<div class="settings">';
    echo '<a class="settings__item" href="profile.php"><span>' . staff_h($L['profile']) . '</span><span class="settings__go">' . $go . '</span></a>';
    echo '<a class="settings__item" href="password.php"><span>' . staff_h($L['password']) . '</span><span class="settings__go">' . $go . '</span></a>';
    if (function_exists('dual_has_dual') && dual_has_dual()) {
        echo '<a class="settings__item" href="choose-role.php"><span>' . staff_h($L['role_switch']) . '</span><span class="settings__go">' . $go . '</span></a>';
    }
    echo '<a class="settings__item" href="' . staff_h($other) . '"><span>' . staff_h($otherLabel) . '</span><span class="tiny">' . staff_h($otherTiny) . '</span><span class="settings__go">' . $go . '</span></a>';
    echo '</div>';
    echo '<div class="settings">';
    echo '<a class="settings__item settings__item--danger" href="emp-view.php?exit=1"><span>' . staff_h($L['exit']) . '</span><span class="settings__go"></span></a>';
    echo '</div></main>';
    dual_parent_nav('settings');
    dual_parent_end();
}

function dual_render_parent_add()
{
    global $L;
    dual_parent_head($L['parent_add']);
    echo '<header class="hero">';
    echo '<div class="hero__row">';
    echo '<a class="back" href="parent-home.php" aria-label="' . staff_h($L['back']) . '">' . dual_svg('back') . '</a>';
    echo '<h1 class="hero__title">' . staff_h($L['parent_add']) . '</h1>';
    dual_parent_bell('parent-news.php');
    echo '</div></header>';
    echo '<main class="page"><div class="card stack">';
    echo '<label class="field"><span class="field__label">' . staff_h($L['parent_edu_id']) . '</span>';
    echo '<input class="input" type="text" value="" readonly></label>';
    echo '<a class="btn btn--primary" href="parent-home.php">' . staff_h($L['parent_add']) . '</a>';
    echo '</div></main>';
    dual_parent_nav('home');
    dual_parent_end();
}

function dual_render_parent_tool()
{
    global $L;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $kid = dual_find_kid($id);
    if (!$kid) {
        header('Location: ' . ((function_exists('dual_in_kid_folder') && dual_in_kid_folder()) ? '../parent-home.php' : 'parent-home.php'));
        exit;
    }
    $kinds = array(
        'homework' => 'parent_homework',
        'memo' => 'parent_memo',
        'results' => 'parent_results',
        'revision' => 'parent_revision',
        'plan' => 'parent_plan',
        'gallery' => 'parent_gallery',
        'alerts' => 'parent_alerts',
        'ask' => 'parent_ask',
        'calendar' => 'parent_calendar',
        'summary' => 'parent_summary',
    );
    $kind = isset($_GET['kind']) ? (string) $_GET['kind'] : 'homework';
    if (!isset($kinds[$kind])) {
        $kind = 'homework';
    }
    $title = $L[$kinds[$kind]];
    $back = (function_exists('dual_in_kid_folder') && dual_in_kid_folder())
        ? ('kid-data.php?id=' . urlencode((string) $id))
        : ('kid/kid-data.php?id=' . urlencode((string) $id));
    staff_inner($title, $back, 'home');
    echo '<div class="parent-soon">';
    echo '<span class="parent-soon__ico t-gold">' . staff_ico($kind === 'results' ? 'star' : ($kind === 'gallery' ? 'camera' : 'book')) . '</span>';
    echo '<h2>' . staff_h($kid['fn_name']) . '</h2>';
    echo '<p>' . staff_h($L['parent_tool_soon']) . '</p>';
    echo '<a class="btn parent-soon__btn" href="student-view.php?id=' . urlencode((string) $id) . '">' . staff_h($L['parent_open_file']) . '</a>';
    echo '</div>';
    staff_inner_end('home');
}
