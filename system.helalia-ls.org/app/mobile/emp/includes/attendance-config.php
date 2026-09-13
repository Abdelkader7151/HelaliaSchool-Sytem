<?php
/**
 * GPS attendance fence for Helalia. Writes the same attendance_log rows
 * as the fingerprint reports. Official hours 07:30–14:30, Cairo time.
 */
if (!defined('HELALIA_PUNCH_CONFIG')) {
    define('HELALIA_PUNCH_CONFIG', true);
}

function punch_config()
{
    return array(
        'lat' => 31.1774369,
        'lng' => 29.9892744,
        'radius_m' => 55.0,
        // Old phones often report ±80–120 m. Do not block a campus punch for that.
        'max_accuracy_m' => 120.0,
        'preview_max_accuracy_m' => 150.0,
        // If the error circle still reaches the 55 m fence, treat as at school.
        'gps_slack_m' => 50.0,
        'timezone' => 'Africa/Cairo',
        'official_in' => '07:30',
        'official_out' => '14:30',
        'late_grace_seconds' => 0,
        'min_gap_seconds' => 120,
        'checkout_until' => '18:00',
        'rate_seconds' => 5,
        'earth_m' => 6371000.0,
        'test_relax_accuracy' => false,
    );
}

function punch_apply_timezone()
{
    $cfg = punch_config();
    date_default_timezone_set($cfg['timezone']);
}
