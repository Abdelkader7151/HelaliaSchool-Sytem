<?php

function gps_pending_dir()
{
    $dir = __DIR__ . '/gps-pending';
    if (!is_dir($dir)) {
        @mkdir($dir, 0700, true);
    }
    return $dir;
}

function gps_pending_path($token)
{
    $token = preg_replace('/[^a-f0-9]/', '', strtolower((string) $token));
    if (strlen($token) !== 32) {
        return '';
    }
    return gps_pending_dir() . '/' . $token . '.json';
}

function gps_pending_read($token)
{
    $path = gps_pending_path($token);
    if ($path === '' || !is_file($path)) {
        return null;
    }
    $raw = @file_get_contents($path);
    $data = json_decode((string) $raw, true);
    if (!is_array($data)) {
        return null;
    }
    $exp = isset($data['exp']) ? (int) $data['exp'] : 0;
    if ($exp < time()) {
        @unlink($path);
        return null;
    }
    return $data;
}

function gps_pending_write($token, $data)
{
    $path = gps_pending_path($token);
    if ($path === '') {
        return false;
    }
    $json = json_encode($data);
    return $json !== false && @file_put_contents($path, $json, LOCK_EX) !== false;
}

function gps_pending_create($empId)
{
    $token = bin2hex(function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16));
    $data = array(
        'emp_id' => (int) $empId,
        'exp' => time() + 600,
        'lat' => null,
        'lng' => null,
        'accuracy' => null,
    );
    if (!gps_pending_write($token, $data)) {
        return '';
    }
    return $token;
}
