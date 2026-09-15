<?php
// ============================================================
// device-lock.php — one phone_id per account (On/Off)
// ============================================================

// 0 = OFF → ay mobile yedkhol (multi-device)
// 1 = ON  → zay ch50, account linked le device wahed bas
define('HELALIA_DEVICE_LOCK', 0);

/**
 * helalia_device_lock_on
 * Return 1 law el one-device lock shaghal.
 */
function helalia_device_lock_on()
{
    return defined('HELALIA_DEVICE_LOCK') && (int) HELALIA_DEVICE_LOCK === 1;
}

/**
 * helalia_device_login_check
 * Login aw splash: check device id vs app_login.phone_id
 *
 * Return 'linked' = block (device tany w el lock ON)
 * Return 'ok'     = kamel login
 *
 * Law lock OFF: ma ye7gebsh block, bas ye7faz akher phone_id (push)
 */
function helalia_device_login_check($row, $deviceId)
{
    if (!function_exists('phone_id_update')) {
        return 'ok';
    }

    $boundId = isset($row['phone_id']) ? trim((string) $row['phone_id']) : '';
    $deviceId = ($deviceId !== null && $deviceId !== '') ? trim((string) $deviceId) : '';

    if (helalia_device_lock_on()) {
        if ($boundId !== '' && $deviceId !== '' && $boundId !== $deviceId) {
            return 'linked';
        }
        if ($deviceId !== '' && $boundId === '') {
            phone_id_update($deviceId, $row['id']);
        }
        return 'ok';
    }

    // lock OFF — kol el devices, update phone_id 3ashan notifications
    if ($deviceId !== '') {
        phone_id_update($deviceId, $row['id']);
    }
    return 'ok';
}
