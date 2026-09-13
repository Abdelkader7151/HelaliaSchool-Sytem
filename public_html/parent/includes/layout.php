<?php
declare(strict_types=1);

function portal_head(string $title, string $bodyExtra = ''): void
{
    $dir = is_ar() ? 'rtl' : 'ltr';
    $lang = is_ar() ? 'ar' : 'en';
    echo '<!DOCTYPE html><html lang="' . $lang . '" dir="' . $dir . '"><head>';
    echo '<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">';
    echo '<title>' . h($title) . ' · Helalia</title>';
    echo '<meta name="theme-color" content="#112c5a">';
    echo '<link rel="icon" href="/assets/media/settings/9qeOWv_1725134635.png">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Manrope:wght@400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,200..600;1,6..72,200..400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">';
    echo '<link rel="stylesheet" href="assets/css/portal.css?v=2">';
    echo '</head><body class="portal' . (is_ar() ? ' is-ar' : '') . h($bodyExtra) . '">';
}

function portal_top(?array $user = null, ?array $kid = null): void
{
    echo '<header class="portal-bar"><div class="wrap bar-inner">';
    echo '<a class="brand" href="' . ($user ? 'children.php' : 'login.php') . '">Helalia <span>Families</span></a>';
    echo '<nav class="bar-links">';
    echo '<a href="' . h(switch_lang_url()) . '">' . h(t('language')) . '</a>';
    if ($user) {
        echo '<a href="settings.php">' . h(t('settings')) . '</a>';
        echo '<a href="logout.php">' . h(t('sign_out')) . '</a>';
    } else {
        echo '<a href="https://helalia-ls.org/">' . h(t('back_site')) . '</a>';
    }
    echo '</nav></div></header>';
    if ($kid) {
        echo '<section class="hero"><div class="wrap hero-inner">';
        echo '<a class="back" href="kid.php?id=' . (int) $kid['id'] . '">←</a>';
        echo '<img class="av" src="' . h(kid_photo($kid)) . '" alt="">';
        echo '<div><p class="kname">' . h(kid_display_name($kid)) . '</p>';
        echo '<p class="kmeta">' . h(trim(year_label((int) $kid['study_year']) . ' · ' . class_name((int) $kid['class']))) . '</p></div>';
        echo '</div></section>';
    }
}

function portal_foot(): void
{
    echo '<footer class="portal-foot"><div class="wrap"><a href="https://helalia-ls.org/">helalia-ls.org</a></div></footer>';
    echo '</body></html>';
}

function flash(?string $msg): void
{
    if ($msg) {
        echo '<p class="flash">' . h($msg) . '</p>';
    }
}

function empty_state(string $text): void
{
    echo '<p class="empty">' . h($text) . '</p>';
}

function tile(string $href, string $label, string $tone = '', string $meta = ''): void
{
    echo '<a class="tile ' . h($tone) . '" href="' . h($href) . '"><span class="tile-label">' . h($label) . '</span>';
    if ($meta !== '') {
        echo '<span class="tile-meta">' . h($meta) . '</span>';
    }
    echo '</a>';
}
