<?php
declare(strict_types=1);

function password_hash_app(string $plain): string
{
    return md5(strtolower($plain));
}

function is_portal_user(?array $user): bool
{
    if (!$user) {
        return false;
    }
    return in_array((int) $user['account_type'], [1, 3, 4], true);
}

function is_student_user(?array $user): bool
{
    return $user !== null && (int) $user['account_type'] === 3;
}

function portal_home_url(array $user): string
{
    if (is_student_user($user)) {
        $kids = parent_kids((int) $user['id']);
        if (count($kids) === 1) {
            return 'kid.php?id=' . (int) $kids[0]['id'];
        }
    }
    return 'children.php';
}

function current_user(): ?array
{
    $id = (int) ($_SESSION['MM_Userid'] ?? 0);
    if ($id < 1) {
        return try_cookie_login();
    }
    $row = db_one(
        'SELECT `id`, `phone`, `name`, `email`, `picture`, `account_type`, `active` FROM `app_login` WHERE `id` = ? LIMIT 1',
        'i',
        [$id]
    );
    return $row ?: null;
}

function try_cookie_login(): ?array
{
    $phone = isset($_COOKIE['helu']) ? trim((string) $_COOKIE['helu']) : '';
    $hash = isset($_COOKIE['help']) ? (string) $_COOKIE['help'] : '';
    if ($phone === '' || $hash === '') {
        return null;
    }
    $row = db_one(
        'SELECT `id`, `phone`, `name`, `email`, `picture`, `account_type`, `active`, `password` FROM `app_login` WHERE `phone` = ? AND `password` = ? LIMIT 1',
        'ss',
        [$phone, $hash]
    );
    if (!$row || (int) $row['active'] !== 1) {
        return null;
    }
    if (!is_portal_user($row)) {
        return null;
    }
    start_parent_session($row);
    return $row;
}

function start_parent_session(array $row): void
{
    session_regenerate_id(true);
    $_SESSION['MM_Userid'] = (int) $row['id'];
    $_SESSION['MM_Username'] = $row['phone'];
    $_SESSION['account_type'] = (int) $row['account_type'];
    $_SESSION['name'] = $row['name'] ?? '';
    $_SESSION['lang'] = lang();
}

function require_parent(): array
{
    $user = current_user();
    if (!$user) {
        redirect('login.php');
    }
    if (!is_portal_user($user)) {
        session_destroy();
        redirect('login.php?err=staff');
    }
    if ((int) $user['active'] !== 1) {
        session_destroy();
        redirect('login.php?err=inactive');
    }
    return $user;
}

function parent_kids(int $parentId): array
{
    $links = db_all('SELECT `kid_id` FROM `kids_list` WHERE `parent_id` = ?', 'i', [$parentId]);
    $kids = [];
    foreach ($links as $link) {
        $kid = db_one('SELECT * FROM `kids` WHERE `id` = ? LIMIT 1', 'i', [(int) $link['kid_id']]);
        if ($kid) {
            $kids[] = $kid;
        }
    }
    return $kids;
}

function require_kid(array $user, int $kidId): array
{
    $ok = db_one(
        'SELECT `id` FROM `kids_list` WHERE `parent_id` = ? AND `kid_id` = ? LIMIT 1',
        'ii',
        [(int) $user['id'], $kidId]
    );
    if (!$ok) {
        redirect('children.php');
    }
    $kid = db_one('SELECT * FROM `kids` WHERE `id` = ? LIMIT 1', 'i', [$kidId]);
    if (!$kid) {
        redirect('children.php');
    }
    return $kid;
}

function kid_badge_counts(int $parentId, int $kidId): array
{
    $alerts = db_all('SELECT `id` FROM `notifications` WHERE `kid_id` = ? AND `view` = 0', 'i', [$kidId]);
    $asks = db_all(
        'SELECT `id` FROM `ask_teacher` WHERE `user_id` = ? AND `kid_id` = ? AND `view` = 0 AND `status` = 1',
        'ii',
        [$parentId, $kidId]
    );
    return ['alerts' => count($alerts) + count($asks)];
}

function set_remember_cookies(string $phone, string $hash, bool $remember): void
{
    $opts = [
        'path' => '/parent/',
        'httponly' => true,
        'samesite' => 'Lax',
    ];
    if ($remember) {
        $opts['expires'] = time() + (86400 * 365);
        setcookie('helu', $phone, $opts);
        setcookie('help', $hash, $opts);
        return;
    }
    $opts['expires'] = time() - 4000;
    setcookie('helu', '', $opts);
    setcookie('help', '', $opts);
}

function switch_lang_url(): string
{
    $next = is_ar() ? 'eng' : 'arb';
    $qs = $_GET;
    $qs['lang'] = $next;
    $base = strtok($_SERVER['REQUEST_URI'] ?? 'index.php', '?') ?: 'index.php';
    return $base . '?' . http_build_query($qs);
}
