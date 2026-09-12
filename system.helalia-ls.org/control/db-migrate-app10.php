<?php
define('MIGRATE_KEY', 'helalia-ch15-app10');

$key = isset($_GET['k']) ? (string) $_GET['k'] : '';
if ($key !== MIGRATE_KEY) {
    http_response_code(403);
    exit('Forbidden');
}

require_once('../Connections/database.php');
require_once('includes/app10-students-sync.php');

header('Content-Type: text/plain; charset=utf-8');

$added = helalia_student_search_ensure_columns();
$rows = helalia_student_search_backfill_from_teachers();

echo "Columns added: {$added}\n";
echo "Teacher rows synced: {$rows}\n";
echo "Done.\n";
