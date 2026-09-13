<?php
declare(strict_types=1);

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function cfg(string $key, $default = null)
{
    return $GLOBALS['PORTAL_CONFIG'][$key] ?? $default;
}

function media_url(string $folder, ?string $file): string
{
    if ($file === null || $file === '') {
        return '';
    }
    return rtrim((string) cfg('media_base'), '/') . '/' . trim($folder, '/') . '/' . rawurlencode($file);
}

function kid_photo(?array $kid): string
{
    $pic = $kid['picture'] ?? '';
    if ($pic === '' || $pic === null) {
        return rtrim((string) cfg('media_base'), '/') . '/kids/no-picture.png';
    }
    return media_url('kids', $pic);
}

function kid_display_name(?array $kid): string
{
    if (!$kid) {
        return '';
    }
    $fn = trim((string) ($kid['fn_name'] ?? ''));
    return $fn !== '' ? $fn : trim((string) ($kid['name'] ?? ''));
}

function class_name(?int $id): string
{
    if (!$id) {
        return '';
    }
    $row = db_one('SELECT `name` FROM `class` WHERE `id` = ? LIMIT 1', 'i', [$id]);
    return $row['name'] ?? '';
}

function term_sql(string $column = 'start'): array
{
    $settings = db_one('SELECT `second_turm` FROM `settings` LIMIT 1');
    $second = $settings ? strtotime((string) $settings['second_turm']) : 0;
    $first = isset($_GET['turm']) && (string) $_GET['turm'] === '1';
    if ($first) {
        return [' AND `' . $column . '` <= ? ', 'i', [$second]];
    }
    return [' AND `' . $column . '` > ? ', 'i', [$second]];
}

function second_turm(): int
{
    $settings = db_one('SELECT `second_turm` FROM `settings` LIMIT 1');
    return $settings ? (int) strtotime((string) $settings['second_turm']) : 0;
}

function youtube_iframe(?string $input): string
{
    $input = trim((string) $input);
    if ($input === '') {
        return '';
    }
    if (preg_match('/<iframe\b[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $input, $m)) {
        $src = $m[1];
        if (preg_match('#^(https?:)?//(www\.)?(youtube\.com|youtube-nocookie\.com|youtu\.be)/#i', $src)) {
            return '<iframe src="' . h($src) . '" allowfullscreen loading="lazy"></iframe>';
        }
        return '';
    }
    $id = '';
    if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})#', $input, $m)) {
        $id = $m[1];
    }
    if ($id === '') {
        return '';
    }
    return '<iframe src="https://www.youtube.com/embed/' . h($id) . '" allowfullscreen loading="lazy"></iframe>';
}

function parent_album_titles(): array
{
    return ['Parent videos', 'فيديوهات أولياء الأمور'];
}

function ensure_parent_album(array $kid): ?int
{
    $classId = (int) ($kid['class'] ?? 0);
    $year = (int) ($kid['study_year'] ?? 0);
    if ($classId < 1) {
        return null;
    }
    $titles = parent_album_titles();
    $rows = db_all(
        'SELECT a.`id` FROM `video-albums` a
         INNER JOIN `video-albums-classs` c ON c.`album_id` = a.`id`
         WHERE c.`class_id` = ? AND (a.`title` = ? OR a.`title` = ?)
         ORDER BY a.`id` DESC LIMIT 1',
        'iss',
        [$classId, $titles[0], $titles[1]]
    );
    if ($rows) {
        return (int) $rows[0]['id'];
    }
    $title = is_ar() ? $titles[1] : $titles[0];
    if (!db_exec('INSERT INTO `video-albums` (`year`, `title`) VALUES (?, ?)', 'is', [$year, $title])) {
        return null;
    }
    $albumId = db_insert_id();
    db_exec('INSERT INTO `video-albums-classs` (`album_id`, `class_id`) VALUES (?, ?)', 'ii', [$albumId, $classId]);
    return $albumId;
}

function save_upload(array $file, string $dir, array $exts, int $maxMb)
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE || empty($file['name'])) {
        return null;
    }
    if (($file['error'] ?? 1) !== UPLOAD_ERR_OK) {
        return false;
    }
    $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $exts, true)) {
        return false;
    }
    if (($file['size'] ?? 0) > $maxMb * 1000 * 1000) {
        return false;
    }
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return false;
    }
    $name = (string) time() . '.' . $ext;
    $dest = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return false;
    }
    return $name;
}

function field(array $row, string $eng, string $arb = ''): string
{
    if (is_ar() && $arb !== '' && isset($row[$arb]) && (string) $row[$arb] !== '') {
        return (string) $row[$arb];
    }
    if (isset($row[$eng]) && (string) $row[$eng] !== '') {
        return (string) $row[$eng];
    }
    return (string) ($row[$arb] ?? '');
}
