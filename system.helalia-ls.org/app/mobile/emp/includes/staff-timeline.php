<?php

function staff_news_href()
{
    return staff_nav_path('staff-news.php');
}

function staff_timeline_events_dir()
{
    $events = dirname(__DIR__, 4) . '/events';
    return is_dir($events) ? $events : '';
}

function staff_timeline_events_url($banner)
{
    $banner = basename((string) $banner);
    if ($banner === '') {
        return '';
    }
    return '../../../../events/' . $banner;
}

function staff_timeline_demo_allowed()
{
    global $staffPreview;
    if (!empty($staffPreview)) {
        return true;
    }
    if (function_exists('staff_is_production_host') && staff_is_production_host()) {
        return false;
    }
    return function_exists('staff_is_local_dev') && staff_is_local_dev();
}

function staff_timeline_preview_rows()
{
    global $staffLang;
    $now = time();
    if ($staffLang === 'arb') {
        return array(
                array(
                    'id' => 1,
                    'date' => $now - 86400,
                    'title' => 'افتتاح العام الدراسي',
                    'text' => 'نرحب بجميع أولياء الأمور والطلاب في العام الدراسي الجديد. نتمنى للجميع عاماً مليئاً بالنجاح.',
                    'banner' => '',
                ),
                array(
                    'id' => 2,
                    'date' => $now - 172800,
                    'title' => 'اجتماع أولياء الأمور',
                    'text' => 'يُعقد الاجتماع الأسبوع القادم. يرجى متابعة الجدول من خلال التطبيق.',
                    'banner' => '',
                ),
            );
    }
    return array(
        array(
            'id' => 1,
            'date' => $now - 86400,
            'title' => 'New school year kickoff',
            'text' => 'Welcome back to Helalia Language School. We wish all students a successful year ahead.',
            'banner' => '',
        ),
        array(
            'id' => 2,
            'date' => $now - 172800,
            'title' => 'Parents meeting reminder',
            'text' => 'The parents meeting is next week. Please check the schedule in the app.',
            'banner' => '',
        ),
    );
}

function staff_timeline_rows()
{
    global $staffPreview, $database, $database_database, $staffLang;

    if (!empty($staffPreview)) {
        return staff_timeline_preview_rows();
    }

    if (!isset($database) || !($database instanceof mysqli)) {
        return staff_timeline_demo_allowed() ? staff_timeline_preview_rows() : array();
    }
    mysqli_select_db($database, $database_database);
    $titleCol = ($staffLang === 'arb') ? 'title_arb' : 'title_eng';
    $textCol = ($staffLang === 'arb') ? 'text_arb' : 'text_eng';
    $sql = "SELECT `id`, `date`, `banner`, `{$titleCol}` AS `title`, `{$textCol}` AS `text` FROM `timeline` ORDER BY `id` DESC";
    $res = mysqli_query($database, $sql);
    $rows = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }
    if (!$rows && staff_timeline_demo_allowed()) {
        return staff_timeline_preview_rows();
    }
    return $rows;
}

function staff_timeline_post_kind($banner)
{
    $ext = strtolower(pathinfo((string) $banner, PATHINFO_EXTENSION));
    $video = array('mp4', 'mov', 'webm', 'm4v');
    return in_array($ext, $video, true) ? 'video' : 'photo';
}

function staff_timeline_has_banner($banner)
{
    $banner = (string) $banner;
    if ($banner === '') {
        return false;
    }
    $banner = basename($banner);
    $path = staff_timeline_events_dir() . '/' . $banner;
    return $path !== '' && is_file($path);
}

function staff_timeline_render_list()
{
    global $L, $icon;
    $rows = staff_timeline_rows();
    if (!$rows) {
        echo '<p class="staff-news-empty">' . staff_h($L['news_empty']) . '</p>';
        return;
    }
    $total = count($rows);
    echo '<div class="staff-posts" id="staff-post-list">';
    foreach ($rows as $i => $row) {
        $dateDisplay = date('d M Y', (int) $row['date']);
        $title = (string) $row['title'];
        $text = (string) $row['text'];
        $hasBanner = staff_timeline_has_banner(isset($row['banner']) ? $row['banner'] : '');
        $src = $hasBanner ? staff_timeline_events_url($row['banner']) : '';
        $kind = staff_timeline_post_kind(isset($row['banner']) ? $row['banner'] : '');
        $oldClass = ($i > 4) ? ' staff-post--old' : '';
        echo '<button class="staff-post' . $oldClass . '" type="button"';
        echo ' data-date="' . staff_h($dateDisplay) . '"';
        echo ' data-title="' . staff_h($title) . '"';
        echo ' data-text="' . staff_h($text) . '"';
        echo ' data-src="' . staff_h($src) . '"';
        echo ' data-kind="' . staff_h($kind) . '">';
        echo '<div class="staff-post__head">';
        echo '<img class="staff-post__av" src="' . staff_h($icon) . '" alt="">';
        echo '<span class="staff-post__who"><span class="staff-post__author">' . staff_h($title) . '</span></span>';
        echo '</div>';
        echo '<span class="staff-post__title"><span class="staff-post__date">' . staff_h($dateDisplay) . '</span></span>';
        echo '<span class="staff-post__excerpt">' . staff_h($text) . '</span>';
        if ($hasBanner) {
            echo '<div class="staff-post__media"><img src="' . staff_h($src) . '" alt="" loading="lazy"></div>';
        }
        echo '<div class="staff-post__foot">';
        if ($hasBanner) {
            echo '<span class="staff-post__tag">' . staff_h($L['news_photo']) . '</span>';
        }
        echo '<span>' . staff_h($L['news_tap_more']) . '</span>';
        echo '</div></button>';
    }
    echo '</div>';
    if ($total > 5) {
        echo '<button class="btn btn--quiet staff-posts-more" id="staff-post-more" type="button">' . staff_h($L['news_load_more']) . '</button>';
    }
    staff_timeline_render_modal();
    staff_timeline_render_script();
}

function staff_timeline_render_modal()
{
    global $L;
    echo '<div class="staff-post-modal" id="staff-post-modal" role="dialog" aria-modal="true" aria-labelledby="staff-post-modal-title" hidden>';
    echo '<div class="staff-post-modal__veil" data-staff-post-close></div>';
    echo '<div class="staff-post-modal__card">';
    echo '<div class="staff-post-modal__media" id="staff-post-modal-media"><img id="staff-post-modal-img" alt=""></div>';
    echo '<p class="staff-post-modal__date" id="staff-post-modal-date"></p>';
    echo '<p class="staff-post-modal__title" id="staff-post-modal-title"></p>';
    echo '<p class="staff-post-modal__text" id="staff-post-modal-text"></p>';
    echo '<button class="btn btn--quiet staff-post-modal__close" type="button" data-staff-post-close>' . staff_h($L['news_close']) . '</button>';
    echo '</div></div>';
}

function staff_timeline_render_script()
{
    echo '<script>(function(){';
    echo 'var modal=document.getElementById("staff-post-modal");';
    echo 'if(!modal)return;';
    echo 'var img=document.getElementById("staff-post-modal-img");';
    echo 'var media=document.getElementById("staff-post-modal-media");';
    echo 'function open(card){var d=card.dataset;';
    echo 'if(d.src){img.src=d.src;img.alt=d.title||"";media.style.display="";}else{img.removeAttribute("src");media.style.display="none";}';
    echo 'document.getElementById("staff-post-modal-date").textContent=d.date+(d.kind==="video"?" · Video":"");';
    echo 'document.getElementById("staff-post-modal-title").textContent=d.title||"";';
    echo 'document.getElementById("staff-post-modal-text").textContent=d.text||"";';
    echo 'modal.hidden=false;modal.classList.add("is-open");document.body.classList.add("staff-post-open");}';
    echo 'function close(){modal.hidden=true;modal.classList.remove("is-open");document.body.classList.remove("staff-post-open");}';
    echo 'document.querySelectorAll(".staff-post").forEach(function(card){card.addEventListener("click",function(){open(card);});});';
    echo 'modal.querySelectorAll("[data-staff-post-close]").forEach(function(btn){btn.addEventListener("click",close);});';
    echo 'document.addEventListener("keydown",function(e){if(e.key==="Escape")close();});';
    echo 'var more=document.getElementById("staff-post-more");';
    echo 'if(more){more.addEventListener("click",function(){document.getElementById("staff-post-list").classList.add("is-expanded");more.remove();});}';
    echo '})();</script>';
}
