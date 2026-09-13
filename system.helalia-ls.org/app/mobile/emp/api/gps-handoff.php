<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once dirname(__DIR__) . '/includes/gps-handoff-lib.php';

$action = isset($_GET['action']) ? (string) $_GET['action'] : '';
$raw = file_get_contents('php://input');
$body = json_decode((string) $raw, true);
if (!is_array($body)) {
    $body = $_POST;
}
if ($action === '' && isset($body['action'])) {
    $action = (string) $body['action'];
}

if ($action === 'save') {
    $token = isset($body['token']) ? (string) $body['token'] : (isset($_GET['t']) ? (string) $_GET['t'] : '');
    $row = gps_pending_read($token);
    if (!$row) {
        http_response_code(404);
        echo json_encode(array('ok' => false, 'error' => 'expired'));
        exit;
    }
    $lat = isset($body['lat']) ? (float) $body['lat'] : null;
    $lng = isset($body['lng']) ? (float) $body['lng'] : null;
    $acc = isset($body['accuracy']) ? (float) $body['accuracy'] : null;
    if ($lat === null || $lng === null || $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
        http_response_code(400);
        echo json_encode(array('ok' => false, 'error' => 'location_invalid'));
        exit;
    }
    $row['lat'] = $lat;
    $row['lng'] = $lng;
    $row['accuracy'] = $acc;
    gps_pending_write($token, $row);
    echo json_encode(array('ok' => true));
    exit;
}

$staffLang = (isset($_GET['lang']) && $_GET['lang'] === 'arb') ? 'arb' : 'eng';
require dirname(__DIR__) . '/includes/staff.php';

if (isset($row_get_user['account_type']) && (int) $row_get_user['account_type'] !== 2 && empty($staffPreview)) {
    http_response_code(403);
    echo json_encode(array('ok' => false, 'error' => 'forbidden'));
    exit;
}

$empId = isset($empId) ? (int) $empId : 0;
$csrf = isset($body['csrf']) ? (string) $body['csrf'] : (isset($_GET['csrf']) ? (string) $_GET['csrf'] : '');
$expect = isset($_SESSION['staff_csrf']) ? (string) $_SESSION['staff_csrf'] : '';

if ($action === 'start') {
    if ($expect === '' || !hash_equals($expect, $csrf)) {
        http_response_code(403);
        echo json_encode(array('ok' => false, 'error' => 'csrf'));
        exit;
    }
    $token = gps_pending_create($empId);
    if ($token === '') {
        http_response_code(500);
        echo json_encode(array('ok' => false, 'error' => 'write_failed'));
        exit;
    }
    $url = '../gps-ask.php?t=' . $token . '&lang=' . $staffLang;
    echo json_encode(array('ok' => true, 'token' => $token, 'url' => $url));
    exit;
}

if ($action === 'poll') {
    $token = isset($_GET['t']) ? (string) $_GET['t'] : (isset($body['token']) ? (string) $body['token'] : '');
    $row = gps_pending_read($token);
    if (!$row || (int) $row['emp_id'] !== $empId) {
        echo json_encode(array('ok' => false, 'ready' => false));
        exit;
    }
    if ($row['lat'] === null || $row['lng'] === null) {
        echo json_encode(array('ok' => true, 'ready' => false));
        exit;
    }
    echo json_encode(array(
        'ok' => true,
        'ready' => true,
        'lat' => (float) $row['lat'],
        'lng' => (float) $row['lng'],
        'accuracy' => $row['accuracy'],
    ));
    exit;
}

http_response_code(400);
echo json_encode(array('ok' => false, 'error' => 'bad_action'));
