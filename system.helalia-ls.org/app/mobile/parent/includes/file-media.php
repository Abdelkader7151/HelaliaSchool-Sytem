<?php
/**
 * Shared parent media helpers: image vs file banners (PDF/Office/etc).
 * Android WebView breaks when a PDF is forced into <img>; iPhone often still
 * shows a usable page. Always use <img> only for real image extensions.
 */

if (!function_exists('parent_homework_public_url')) {
    function parent_homework_public_url($name)
    {
        $name = basename(str_replace('\\', '/', trim((string) $name)));
        if ($name === '' || strcasecmp($name, 'null') === 0) {
            return '';
        }
        return 'https://system.helalia-ls.org/homework/' . rawurlencode($name);
    }
}

if (!function_exists('parent_file_ext')) {
    function parent_file_ext($name)
    {
        return strtolower(pathinfo((string) $name, PATHINFO_EXTENSION));
    }
}

if (!function_exists('parent_is_image_ext')) {
    function parent_is_image_ext($ext)
    {
        return in_array(strtolower((string) $ext), array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'), true);
    }
}

if (!function_exists('parent_file_ico_class')) {
    function parent_file_ico_class($ext)
    {
        $ext = strtolower((string) $ext);
        if ($ext === 'pdf') {
            return 'fold__item-ico--pdf';
        }
        if ($ext === 'xls' || $ext === 'xlsx' || $ext === 'csv') {
            return 'fold__item-ico--xls';
        }
        return 'fold__item-ico--doc';
    }
}

/**
 * Render homework/memo/revision banner: images as <img>, all other files as Open link.
 * Uses absolute HTTPS URL so Android WebView can hand off PDFs reliably.
 *
 * @param string|null $banner filename in /homework/
 * @param string      $fsRel  relative filesystem prefix from the calling script
 * @param string      $lang   eng|arb
 * @return string HTML (may be empty)
 */
if (!function_exists('parent_render_banner_media')) {
    function parent_render_banner_media($banner, $fsRel = '../../../../homework/', $lang = 'eng')
    {
        $banner = trim((string) $banner);
        if ($banner === '' || strcasecmp($banner, 'null') === 0) {
            return '';
        }
        $fsPath = rtrim($fsRel, '/\\') . '/' . $banner;
        if (!is_file($fsPath)) {
            return '';
        }

        $ext = parent_file_ext($banner);
        $href = parent_homework_public_url($banner);
        if ($href === '') {
            return '';
        }
        $safeHref = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');

        if (parent_is_image_ext($ext)) {
            return '<img src="' . $safeHref . '" alt="" loading="lazy">';
        }

        $openLabel = ($lang === 'arb') ? 'فتح الملف' : 'Open file';
        $meta = ($ext !== '') ? strtoupper($ext) : (($lang === 'arb') ? 'ملف' : 'File');
        $ico = parent_file_ico_class($ext);

        return '<a class="fold__item" href="' . $safeHref . '" rel="noopener">'
            . '<span class="fold__item-ico ' . htmlspecialchars($ico, ENT_QUOTES, 'UTF-8') . '">›</span>'
            . '<span class="fold__item-title">' . htmlspecialchars($openLabel, ENT_QUOTES, 'UTF-8') . '</span>'
            . '<span class="fold__item-meta">' . htmlspecialchars($meta, ENT_QUOTES, 'UTF-8') . '</span>'
            . '</a>';
    }
}
