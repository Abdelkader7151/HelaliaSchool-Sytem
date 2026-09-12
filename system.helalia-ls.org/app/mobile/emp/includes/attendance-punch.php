<?php
require_once __DIR__ . '/attendance-config.php';

function punch_now()
{
    punch_apply_timezone();
    return time();
}

function punch_day_start($now = null)
{
    punch_apply_timezone();
    if ($now === null) {
        $now = time();
    }
    return (int) strtotime(date('Y-m-d 00:00:00', $now));
}

function punch_day_end($now = null)
{
    return punch_day_start($now) + 86400 - 1;
}

function punch_haversine($lat1, $lng1, $lat2, $lng2)
{
    $cfg = punch_config();
    $r = $cfg['earth_m'];
    $p1 = deg2rad((float) $lat1);
    $p2 = deg2rad((float) $lat2);
    $dLat = deg2rad((float) $lat2 - (float) $lat1);
    $dLng = deg2rad((float) $lng2 - (float) $lng1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos($p1) * cos($p2) * sin($dLng / 2) * sin($dLng / 2);
    $c = 2 * asin(min(1, sqrt($a)));
    return round($r * $c, 2);
}

function punch_clock_to_unix($hhmm, $dayStart)
{
    $parts = explode(':', (string) $hhmm);
    $h = isset($parts[0]) ? (int) $parts[0] : 0;
    $m = isset($parts[1]) ? (int) $parts[1] : 0;
    return $dayStart + ($h * 3600) + ($m * 60);
}

function punch_official_times($now = null)
{
    $cfg = punch_config();
    $day = punch_day_start($now);
    $in = $cfg['official_in'];
    $out = $cfg['official_out'];
    $grace = (int) $cfg['late_grace_seconds'];

    if (!empty($GLOBALS['database']) && empty($GLOBALS['staffPreview'])) {
        $loaded = punch_load_official_from_db($GLOBALS['database'], $now);
        if (is_array($loaded)) {
            $in = $loaded['in'];
            $out = $loaded['out'];
            if (isset($loaded['grace'])) {
                $grace = (int) $loaded['grace'];
            }
        }
    }

    return array(
        'in' => punch_clock_to_unix($in, $day),
        'out' => punch_clock_to_unix($out, $day),
        'in_label' => $in,
        'out_label' => $out,
        'grace' => $grace,
    );
}

function punch_load_official_from_db($database, $now)
{
    $tables = array('attendance_settings', 'attend_settings', 'attendance_setting');
    foreach ($tables as $table) {
        $safe = preg_replace('/[^a-z0-9_]/i', '', $table);
        $res = @mysqli_query($database, 'SHOW TABLES LIKE \'' . mysqli_real_escape_string($database, $safe) . '\'');
        if (!$res || mysqli_num_rows($res) < 1) {
            continue;
        }
        $q = @mysqli_query($database, 'SELECT * FROM `' . $safe . '` LIMIT 1');
        if (!$q || mysqli_num_rows($q) < 1) {
            continue;
        }
        $row = mysqli_fetch_assoc($q);
        $in = punch_pick_time($row, array('time_in', 'sign_in', 'in_time', 'start', 'from_time', 'official_in'));
        $out = punch_pick_time($row, array('time_out', 'sign_out', 'out_time', 'end', 'to_time', 'official_out'));
        if ($in && $out) {
            return array('in' => $in, 'out' => $out);
        }
    }
    return null;
}

function punch_pick_time($row, $keys)
{
    foreach ($keys as $key) {
        if (!isset($row[$key]) || $row[$key] === '' || $row[$key] === null) {
            continue;
        }
        $v = trim((string) $row[$key]);
        if (preg_match('/^(\d{1,2}):(\d{2})/', $v, $m)) {
            return sprintf('%02d:%02d', (int) $m[1], (int) $m[2]);
        }
        if (ctype_digit($v) && (int) $v > 86400) {
            return date('H:i', (int) $v);
        }
        if (ctype_digit($v) && (int) $v < 86400) {
            return gmdate('H:i', (int) $v);
        }
    }
    return null;
}

function punch_late_in($signIn, $official)
{
    $late = (int) $signIn - (int) $official['in'] - (int) $official['grace'];
    return $late > 0 ? $late : 0;
}

function punch_late_out($signOut, $official)
{
    $early = (int) $official['out'] - (int) $signOut;
    return $early > 0 ? $early : 0;
}

function punch_hm($seconds)
{
    $seconds = (int) $seconds;
    if ($seconds <= 0) {
        return '00:00';
    }
    return gmdate('H:i', $seconds);
}

function punch_clock($unix)
{
    if (!$unix) {
        return '';
    }
    punch_apply_timezone();
    return date('H:i', (int) $unix);
}

function punch_checkout_deadline($now = null)
{
    $cfg = punch_config();
    $until = isset($cfg['checkout_until']) ? $cfg['checkout_until'] : '18:00';
    return punch_clock_to_unix($until, punch_day_start($now));
}

function punch_checkout_open($now = null)
{
    if ($now === null) {
        $now = punch_now();
    }
    return $now < punch_checkout_deadline($now);
}

function punch_max_accuracy()
{
    $cfg = punch_config();
    if (!empty($GLOBALS['staffPreview']) || !empty($GLOBALS['staffLocalLive']) || !empty($cfg['test_relax_accuracy'])) {
        return (float) $cfg['preview_max_accuracy_m'];
    }
    return (float) $cfg['max_accuracy_m'];
}

function punch_validate_coords($lat, $lng, $accuracy)
{
    $cfg = punch_config();
    $maxAcc = punch_max_accuracy();
    if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($accuracy)) {
        return array('ok' => false, 'code' => 'coords', 'error' => 'location_invalid');
    }
    $lat = (float) $lat;
    $lng = (float) $lng;
    $accuracy = (float) $accuracy;
    if ($lat !== $lat || $lng !== $lng || $accuracy !== $accuracy) {
        return array('ok' => false, 'code' => 'coords', 'error' => 'location_invalid');
    }
    if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
        return array('ok' => false, 'code' => 'coords', 'error' => 'location_invalid');
    }
    if (abs($lat) < 0.000001 && abs($lng) < 0.000001) {
        return array('ok' => false, 'code' => 'coords', 'error' => 'location_invalid');
    }
    if ($accuracy < 0) {
        return array('ok' => false, 'code' => 'accuracy', 'error' => 'accuracy_poor');
    }
    $distance = punch_haversine($lat, $lng, $cfg['lat'], $cfg['lng']);
    $radius = (float) $cfg['radius_m'];
    $slack = punch_gps_slack($accuracy, $cfg);
    $inside = punch_is_inside($distance, $accuracy, $cfg);
    // On campus: never refuse for a noisy reading. Accuracy is only a
    // problem when the phone is clearly outside the school.
    if (!$inside && $accuracy > $maxAcc) {
        return array('ok' => false, 'code' => 'accuracy', 'error' => 'accuracy_poor', 'accuracy' => $accuracy);
    }
    return array(
        'ok' => true,
        'lat' => $lat,
        'lng' => $lng,
        'accuracy' => round($accuracy, 2),
        'distance' => $distance,
        'inside' => $inside,
        'radius' => $radius,
        'slack' => $slack,
    );
}

function punch_gps_slack($accuracy, $cfg = null)
{
    $cfg = $cfg ? $cfg : punch_config();
    $acc = max(0.0, (float) $accuracy);
    $cap = (float) $cfg['gps_slack_m'];
    return min($acc, $cap);
}

function punch_is_inside($distance, $accuracy, $cfg = null)
{
    $cfg = $cfg ? $cfg : punch_config();
    $radius = (float) $cfg['radius_m'];
    $distance = (float) $distance;
    if ($distance <= $radius) {
        return true;
    }
    $nearest = max(0.0, $distance - punch_gps_slack($accuracy, $cfg));
    return $nearest <= $radius;
}

function punch_db()
{
    if (!empty($GLOBALS['staffPreview'])) {
        return null;
    }
    if (empty($GLOBALS['database']) || !($GLOBALS['database'] instanceof mysqli)) {
        return null;
    }
    $db = $GLOBALS['database'];
    if (!empty($GLOBALS['database_database'])) {
        mysqli_select_db($db, $GLOBALS['database_database']);
    }
    return $db;
}

function punch_on_vacation($empId, $now)
{
    $db = punch_db();
    if (!$db || $empId < 1) {
        return false;
    }
    $day = punch_day_start($now);
    $empId = (int) $empId;
    $sql = "SELECT `id` FROM `emps_vacations` WHERE `emp_id` = {$empId} AND `status` = 1 AND `vacation_start` <= {$day} AND `vacation_end` >= {$day} LIMIT 1";
    $q = @mysqli_query($db, $sql);
    return $q && mysqli_num_rows($q) > 0;
}

function punch_today_row($empId, $now, $forUpdate = false)
{
    $db = punch_db();
    if (!$db || $empId < 1) {
        return null;
    }
    $start = punch_day_start($now);
    $end = punch_day_end($now);
    $empId = (int) $empId;
    $lock = $forUpdate ? ' FOR UPDATE' : '';
    $sql = "SELECT * FROM `attendance_log` WHERE `emp_id` = {$empId} AND `date` >= {$start} AND `date` <= {$end} ORDER BY `id` ASC LIMIT 1{$lock}";
    $q = mysqli_query($db, $sql);
    if ((!$q || mysqli_errno($db)) && $forUpdate) {
        $sql = "SELECT * FROM `attendance_log` WHERE `emp_id` = {$empId} AND `date` >= {$start} AND `date` <= {$end} ORDER BY `id` ASC LIMIT 1";
        $q = mysqli_query($db, $sql);
    }
    if (!$q || mysqli_num_rows($q) < 1) {
        return null;
    }
    return mysqli_fetch_assoc($q);
}

function punch_row_has_in($row)
{
    return is_array($row) && isset($row['sign_in']) && $row['sign_in'] !== null && $row['sign_in'] !== '' && (int) $row['sign_in'] > 0;
}

function punch_row_has_out($row)
{
    return is_array($row) && isset($row['sign_out']) && $row['sign_out'] !== null && $row['sign_out'] !== '' && (int) $row['sign_out'] > 0;
}

function punch_rate_ok($empId)
{
    $cfg = punch_config();
    $key = 'punch_rate_' . (int) $empId;
    $now = time();
    if (!empty($_SESSION[$key]) && ($now - (int) $_SESSION[$key]) < $cfg['rate_seconds']) {
        return false;
    }
    $_SESSION[$key] = $now;
    return true;
}

function punch_status($empId, $lang = 'eng')
{
    $now = punch_now();
    $cfg = punch_config();
    $official = punch_official_times($now);
    $row = punch_today_row($empId, $now, false);
    $hasIn = punch_row_has_in($row);
    $hasOut = punch_row_has_out($row);
    $signIn = $hasIn ? (int) $row['sign_in'] : 0;
    $signOut = $hasOut ? (int) $row['sign_out'] : 0;
    $lateIn = ($hasIn && isset($row['late_in'])) ? (int) $row['late_in'] : 0;
    $lateOut = ($hasOut && isset($row['late_out'])) ? (int) $row['late_out'] : 0;
    $worked = ($hasIn && $hasOut) ? max(0, $signOut - $signIn) : 0;
    $preview = !empty($GLOBALS['staffPreview']) || !empty($GLOBALS['staffLocalLive']);
    $csrf = isset($_SESSION['staff_csrf']) ? (string) $_SESSION['staff_csrf'] : '';

    return array(
        'ok' => true,
        'preview' => $preview,
        'csrf' => $csrf,
        'now' => $now,
        'day' => date('Y-m-d', $now),
        'fence' => array(
            'lat' => $cfg['lat'],
            'lng' => $cfg['lng'],
            'radius_m' => $cfg['radius_m'],
            'gps_slack_m' => $cfg['gps_slack_m'],
            'max_accuracy_m' => punch_max_accuracy(),
        ),
        'hours' => array(
            'in' => $official['in_label'],
            'out' => $official['out_label'],
            'checkout_until' => isset($cfg['checkout_until']) ? $cfg['checkout_until'] : '18:00',
        ),
        'checkout_until' => punch_checkout_deadline($now),
        'can_check_out' => $hasIn && !$hasOut && punch_checkout_open($now),
        'checkout_closed' => $hasIn && !$hasOut && !punch_checkout_open($now),
        'today' => array(
            'has_in' => $hasIn,
            'has_out' => $hasOut,
            'sign_in' => $hasIn ? punch_clock($signIn) : '',
            'sign_out' => $hasOut ? punch_clock($signOut) : '',
            'delay' => $hasIn ? punch_hm($lateIn) : '',
            'early' => $hasOut ? punch_hm($lateOut) : '',
            'worked' => ($hasIn && $hasOut) ? punch_hm($worked) : '',
            'on_vacation' => punch_on_vacation($empId, $now),
        ),
    );
}

function punch_error($code, $extra = array())
{
    $payload = array_merge(array('ok' => false, 'error' => $code), $extra);
    return $payload;
}

function punch_write_audit($db, $logId, $empId, $action, $geo, $now, $outKind, $late)
{
    if (!$db) {
        return;
    }
    $check = @mysqli_query($db, "SHOW TABLES LIKE 'attendance_app_punch'");
    if (!$check || mysqli_num_rows($check) < 1) {
        return;
    }
    $stmt = mysqli_prepare(
        $db,
        'INSERT INTO `attendance_app_punch` (`log_id`,`emp_id`,`day_start`,`action`,`source`,`punched_at`,`lat`,`lng`,`accuracy_m`,`distance_m`,`out_kind`,`late_seconds`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    if (!$stmt) {
        return;
    }
    $day = punch_day_start($now);
    $source = 'app';
    $logId = $logId ? (int) $logId : 0;
    $empId = (int) $empId;
    $lat = $geo['lat'];
    $lng = $geo['lng'];
    $acc = $geo['accuracy'];
    $dist = $geo['distance'];
    $outKind = $outKind ? $outKind : '';
    $late = (int) $late;
    mysqli_stmt_bind_param(
        $stmt,
        'iiissiddddsi',
        $logId,
        $empId,
        $day,
        $action,
        $source,
        $now,
        $lat,
        $lng,
        $acc,
        $dist,
        $outKind,
        $late
    );
    @mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function punch_perform($empId, $action, $lat, $lng, $accuracy)
{
    $now = punch_now();
    $cfg = punch_config();
    $action = ($action === 'out') ? 'out' : 'in';

    if (!empty($GLOBALS['staffPreview']) || !empty($GLOBALS['staffLocalLive']) || $empId < 1) {
        $geo = punch_validate_coords($lat, $lng, $accuracy);
        if (!$geo['ok']) {
            return punch_error($geo['error'], $geo);
        }
        if ($action === 'in' && empty($geo['inside'])) {
            return punch_error('outside', array('distance' => $geo['distance'], 'radius' => $cfg['radius_m'], 'inside' => false));
        }
        if ($action === 'out' && empty($geo['inside'])) {
            return punch_error('outside', array('distance' => $geo['distance'], 'radius' => $cfg['radius_m'], 'inside' => false));
        }
        if ($action === 'out' && !punch_checkout_open($now)) {
            return punch_error('checkout_closed');
        }
        return punch_error('preview_only', array(
            'distance' => $geo['distance'],
            'inside' => $geo['inside'],
            'accuracy' => $geo['accuracy'],
        ));
    }

    if (!punch_rate_ok($empId)) {
        return punch_error('rate_limited');
    }

    $geo = punch_validate_coords($lat, $lng, $accuracy);
    if (!$geo['ok']) {
        return punch_error($geo['error'], $geo);
    }

    $db = punch_db();
    if (!$db) {
        return punch_error('preview_only');
    }

    $official = punch_official_times($now);
    mysqli_query($db, 'START TRANSACTION');
    $row = punch_today_row($empId, $now, true);
    $hasIn = punch_row_has_in($row);
    $hasOut = punch_row_has_out($row);

    if ($action === 'in') {
        if (punch_on_vacation($empId, $now)) {
            mysqli_rollback($db);
            return punch_error('on_vacation');
        }
        if ($hasIn) {
            mysqli_rollback($db);
            return punch_error('already_in', array('sign_in' => punch_clock((int) $row['sign_in'])));
        }
        if (!$geo['inside']) {
            mysqli_rollback($db);
            return punch_error('outside', array('distance' => $geo['distance'], 'radius' => $cfg['radius_m']));
        }
        $late = punch_late_in($now, $official);
        $day = punch_day_start($now);
        $absent = 0;
        $empIdI = (int) $empId;
        if ($row) {
            $id = (int) $row['id'];
            $ok = mysqli_query(
                $db,
                "UPDATE `attendance_log` SET `sign_in` = {$now}, `late_in` = {$late}, `absent` = 0 WHERE `id` = {$id} LIMIT 1"
            );
            $logId = $id;
        } else {
            $ok = mysqli_query(
                $db,
                "INSERT INTO `attendance_log` (`emp_id`,`date`,`sign_in`,`late_in`,`absent`) VALUES ({$empIdI}, {$day}, {$now}, {$late}, {$absent})"
            );
            $logId = $ok ? mysqli_insert_id($db) : 0;
        }
        if (!$ok) {
            mysqli_rollback($db);
            return punch_error('write_failed');
        }
        punch_write_audit($db, $logId, $empId, 'in', $geo, $now, null, $late);
        mysqli_commit($db);
        $status = punch_status($empId);
        $status['punched'] = 'in';
        $status['distance'] = $geo['distance'];
        return $status;
    }

    if (!$hasIn) {
        mysqli_rollback($db);
        return punch_error('need_in');
    }
    if ($hasOut) {
        mysqli_rollback($db);
        return punch_error('already_out', array('sign_out' => punch_clock((int) $row['sign_out'])));
    }
    if (!punch_checkout_open($now)) {
        mysqli_rollback($db);
        $closed = punch_status($empId);
        $closed['ok'] = false;
        $closed['error'] = 'checkout_closed';
        return $closed;
    }
    if ($now < ((int) $row['sign_in'] + $cfg['min_gap_seconds'])) {
        mysqli_rollback($db);
        return punch_error('too_soon');
    }
    if (!$geo['inside']) {
        mysqli_rollback($db);
        return punch_error('outside', array('distance' => $geo['distance'], 'radius' => $cfg['radius_m']));
    }
    $outKind = 'fence';
    $late = punch_late_out($now, $official);
    $id = (int) $row['id'];
    $ok = mysqli_query(
        $db,
        "UPDATE `attendance_log` SET `sign_out` = {$now}, `late_out` = {$late} WHERE `id` = {$id} LIMIT 1"
    );
    if (!$ok) {
        mysqli_rollback($db);
        return punch_error('write_failed');
    }
    punch_write_audit($db, $id, $empId, 'out', $geo, $now, $outKind, $late);
    mysqli_commit($db);
    $status = punch_status($empId);
    $status['punched'] = 'out';
    $status['out_kind'] = $outKind;
    $status['distance'] = $geo['distance'];
    return $status;
}
