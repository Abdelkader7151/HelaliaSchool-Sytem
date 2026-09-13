<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('ok' => false, 'error' => 'method'));
    exit;
}

$staffLang = 'eng';
if (isset($_GET['lang']) && $_GET['lang'] === 'arb') {
    $staffLang = 'arb';
}

require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/attendance-punch.php';

if (isset($row_get_user['account_type']) && (int) $row_get_user['account_type'] !== 2 && empty($staffPreview)) {
    http_response_code(403);
    echo json_encode(array('ok' => false, 'error' => 'forbidden'));
    exit;
}

$empId = isset($empId) ? (int) $empId : 0;
$body = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents('php://input');
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $body = $decoded;
    } else {
        $body = $_POST;
    }
    if (isset($body['lang']) && $body['lang'] === 'arb') {
        $staffLang = 'arb';
    }
}

$action = isset($body['action']) ? (string) $body['action'] : (isset($_GET['action']) ? (string) $_GET['action'] : 'status');

if ($action === 'status' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(punch_status($empId, $staffLang));
    exit;
}

$token = isset($body['csrf']) ? (string) $body['csrf'] : '';
$expect = isset($_SESSION['staff_csrf']) ? (string) $_SESSION['staff_csrf'] : '';
if ($expect === '' || !hash_equals($expect, $token)) {
    http_response_code(403);
    echo json_encode(array('ok' => false, 'error' => 'csrf'));
    exit;
}

if ($action !== 'in' && $action !== 'out') {
    http_response_code(400);
    echo json_encode(array('ok' => false, 'error' => 'bad_action'));
    exit;
}

$lat = isset($body['lat']) ? $body['lat'] : null;
$lng = isset($body['lng']) ? $body['lng'] : null;
$accuracy = isset($body['accuracy']) ? $body['accuracy'] : null;

$result = punch_perform($empId, $action, $lat, $lng, $accuracy);
if (empty($result['ok'])) {
    http_response_code(400);
}
echo json_encode($result);
