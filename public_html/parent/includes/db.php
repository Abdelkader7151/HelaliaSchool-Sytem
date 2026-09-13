<?php
declare(strict_types=1);

function db(): mysqli
{
    static $mysqli = null;
    if ($mysqli instanceof mysqli) {
        return $mysqli;
    }
    $cfg = $GLOBALS['PORTAL_CONFIG'];
    $mysqli = @mysqli_connect($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    if (!$mysqli) {
        http_response_code(500);
        exit('Database unavailable.');
    }
    $mysqli->set_charset('utf8');
    return $mysqli;
}

function db_bind(mysqli_stmt $stmt, string $types, array $params): bool
{
    if ($types === '') {
        return true;
    }
    $refs = [$types];
    foreach ($params as $key => $value) {
        $refs[] = &$params[$key];
    }
    return (bool) call_user_func_array([$stmt, 'bind_param'], $refs);
}

function db_one(string $sql, string $types = '', array $params = []): ?array
{
    $rows = db_all($sql, $types, $params);
    return $rows[0] ?? null;
}

function db_all(string $sql, string $types = '', array $params = []): array
{
    $mysqli = db();
    if ($types === '') {
        $result = $mysqli->query($sql);
        if (!$result) {
            return [];
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
        return $rows;
    }
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return [];
    }
    if (!db_bind($stmt, $types, $params)) {
        $stmt->close();
        return [];
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    $stmt->close();
    return $rows;
}

function db_exec(string $sql, string $types = '', array $params = []): bool
{
    $mysqli = db();
    if ($types === '') {
        return (bool) $mysqli->query($sql);
    }
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return false;
    }
    if (!db_bind($stmt, $types, $params)) {
        $stmt->close();
        return false;
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function db_insert_id(): int
{
    return (int) db()->insert_id;
}
