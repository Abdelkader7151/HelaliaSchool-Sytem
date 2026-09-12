<?php
/**
 * Read-only staff permission inspector (admin diagnostic).
 * Search by name, phone, or employee id. No writes.
 */
define('PERM_AUDIT_KEY', 'helalia-ch13-audit');

$empHome = __DIR__;
$mobileRoot = dirname($empHome);
require_once $empHome . '/includes/local-request.php';

$key = isset($_GET['k']) ? (string) $_GET['k'] : '';
if ($key !== PERM_AUDIT_KEY) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Forbidden';
    exit;
}

$connPath = staff_resolve_connections($empHome, $mobileRoot);
if (!is_file($connPath)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Database connection file not found.';
    exit;
}
require_once $connPath;
if (!isset($database) || !($database instanceof mysqli)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Database connection failed.';
    exit;
}
if (!empty($database_database)) {
    mysqli_select_db($database, $database_database);
}
mysqli_set_charset($database, 'utf8');

function perm_audit_h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function perm_audit_years()
{
    return array(
        0 => 'Preschool',
        1 => 'KG1',
        2 => 'KG2',
        3 => 'Junior One',
        4 => 'Junior Two',
        5 => 'Junior Three',
        6 => 'Junior Four',
        7 => 'Junior Five',
        8 => 'Junior Six',
        9 => 'Middle One',
        10 => 'Middle Two',
        11 => 'Middle Three',
        12 => 'Senior One',
        13 => 'Senior Two',
        14 => 'Senior Three',
    );
}

function perm_audit_year_name($year)
{
    $years = perm_audit_years();
    $year = (int) $year;
    return isset($years[$year]) ? $years[$year] : ('Year ' . $year);
}

function perm_audit_stage_groups($prefix)
{
    return array(
        0 => array('flag' => $prefix . '_0', 'label' => 'Preschool', 'years' => array(0)),
        1 => array('flag' => $prefix . '_1', 'label' => 'KG1 + KG2', 'years' => array(1, 2)),
        2 => array('flag' => $prefix . '_2', 'label' => 'Junior One–Three', 'years' => array(3, 4, 5)),
        3 => array('flag' => $prefix . '_3', 'label' => 'Junior Four–Six', 'years' => array(6, 7, 8)),
        4 => array('flag' => $prefix . '_4', 'label' => 'Middle One–Three', 'years' => array(9, 10, 11)),
        5 => array('flag' => $prefix . '_5', 'label' => 'Senior One–Three', 'years' => array(12, 13, 14)),
    );
}

function perm_audit_memo_groups()
{
    return perm_audit_stage_groups('app18');
}

function perm_audit_student_groups()
{
    return perm_audit_stage_groups('app10');
}

function perm_audit_flag_years($empRow, $groups)
{
    $years = array();
    foreach ($groups as $group) {
        if (perm_audit_on($empRow, $group['flag'])) {
            foreach ($group['years'] as $year) {
                $years[] = (int) $year;
            }
        }
    }
    sort($years, SORT_NUMERIC);
    return $years;
}

function perm_audit_fetch($sql)
{
    global $database;
    $rows = array();
    $q = mysqli_query($database, $sql);
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function perm_audit_one($sql)
{
    $rows = perm_audit_fetch($sql);
    return isset($rows[0]) ? $rows[0] : null;
}

function perm_audit_on($row, $col)
{
    return $row && isset($row[$col]) && (int) $row[$col] === 1;
}

function perm_audit_class_name($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return '—';
    }
    $row = perm_audit_one("SELECT `name` FROM `class` WHERE `id` = '{$id}' LIMIT 1");
    return ($row && !empty($row['name'])) ? (string) $row['name'] : ('Class #' . $id);
}

function perm_audit_subject_name($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return '—';
    }
    $row = perm_audit_one("SELECT `name_eng`, `name`, `name_arb` FROM `subjects` WHERE `id` = '{$id}' LIMIT 1");
    if (!$row) {
        return 'Subject #' . $id;
    }
    if (!empty($row['name_eng'])) {
        return (string) $row['name_eng'];
    }
    if (!empty($row['name'])) {
        return (string) $row['name'];
    }
    if (!empty($row['name_arb'])) {
        return (string) $row['name_arb'];
    }
    return 'Subject #' . $id;
}

function perm_audit_job_name($id)
{
    $id = (int) $id;
    if ($id < 1) {
        return '—';
    }
    $row = perm_audit_one("SELECT `name` FROM `jobs` WHERE `id` = '{$id}' LIMIT 1");
    return ($row && !empty($row['name'])) ? (string) $row['name'] : ('Job #' . $id);
}

function perm_audit_teacher_years($empId)
{
    $empId = (int) $empId;
    $rows = perm_audit_fetch("SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '{$empId}' ORDER BY `study_year` ASC");
    $years = array();
    foreach ($rows as $row) {
        $years[] = (int) $row['study_year'];
    }
    return $years;
}

function perm_audit_memo_years($empRow)
{
    $years = array();
    foreach (perm_audit_memo_groups() as $group) {
        if (perm_audit_on($empRow, $group['flag'])) {
            foreach ($group['years'] as $year) {
                $years[] = (int) $year;
            }
        }
    }
    sort($years, SORT_NUMERIC);
    return $years;
}

function perm_audit_year_list($years)
{
    if (!$years) {
        return 'None';
    }
    $parts = array();
    foreach ($years as $year) {
        $parts[] = perm_audit_year_name($year) . ' (' . (int) $year . ')';
    }
    return implode(', ', $parts);
}

function perm_audit_search($q)
{
    global $database;
    $q = trim((string) $q);
    if ($q === '') {
        return array();
    }
    if (ctype_digit($q)) {
        $id = (int) $q;
        $rows = perm_audit_fetch("SELECT `id`, `name`, `job` FROM `emps` WHERE `id` = '{$id}' LIMIT 1");
        if ($rows) {
            return $rows;
        }
        $rows = perm_audit_fetch(
            "SELECT e.`id`, e.`name`, e.`job` FROM `emps` e
             INNER JOIN `app_login` al ON al.`emp_id` = e.`id`
             WHERE al.`id` = '{$id}' OR al.`phone` LIKE '%" . mysqli_real_escape_string($database, $q) . "%'
             LIMIT 20"
        );
        return $rows;
    }
    $esc = mysqli_real_escape_string($database, $q);
    $like = "'%" . $esc . "%'";
    return perm_audit_fetch(
        "SELECT DISTINCT e.`id`, e.`name`, e.`job`
         FROM `emps` e
         LEFT JOIN `app_login` al ON al.`emp_id` = e.`id`
         WHERE e.`name` LIKE {$like} OR al.`name` LIKE {$like} OR al.`phone` LIKE {$like}
         ORDER BY e.`name` ASC
         LIMIT 25"
    );
}

function perm_audit_assignments($empId)
{
    $empId = (int) $empId;
    return perm_audit_fetch(
        "SELECT `study_year`, `class`, `subject`
         FROM `teachers`
         WHERE `emp_id` = '{$empId}'
         ORDER BY `study_year` ASC, `class` ASC, `subject` ASC"
    );
}

function perm_audit_logins($empId)
{
    $empId = (int) $empId;
    return perm_audit_fetch(
        "SELECT `id`, `name`, `phone`, `active`, `account_type`
         FROM `app_login`
         WHERE `emp_id` = '{$empId}'
         ORDER BY `id` ASC"
    );
}

function perm_audit_roles($empId)
{
    $empId = (int) $empId;
    $out = array('coordinator' => array(), 'head' => array());
    $rows = perm_audit_fetch("SELECT `id`, `name_eng`, `name`, `cor`, `head` FROM `subjects` WHERE `cor` = '{$empId}' OR `head` = '{$empId}'");
    foreach ($rows as $row) {
        $label = !empty($row['name_eng']) ? $row['name_eng'] : (!empty($row['name']) ? $row['name'] : ('Subject #' . $row['id']));
        if ((int) $row['cor'] === $empId) {
            $out['coordinator'][] = $label;
        }
        if ((int) $row['head'] === $empId) {
            $out['head'][] = $label;
        }
    }
    return $out;
}

function perm_audit_classes_for_year($empId, $year)
{
    $empId = (int) $empId;
    $year = (int) $year;
    $rows = perm_audit_fetch("SELECT DISTINCT `class` FROM `teachers` WHERE `emp_id` = '{$empId}' AND `study_year` = '{$year}' ORDER BY `class` ASC");
    $names = array();
    foreach ($rows as $row) {
        $names[] = perm_audit_class_name($row['class']);
    }
    return $names ? implode(', ', $names) : 'None';
}

$q = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
$empId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$matches = array();
$emp = null;

if ($empId > 0) {
    $emp = perm_audit_one("SELECT * FROM `emps` WHERE `id` = '{$empId}' LIMIT 1");
} elseif ($q !== '') {
    $matches = perm_audit_search($q);
    if (count($matches) === 1) {
        $empId = (int) $matches[0]['id'];
        $emp = perm_audit_one("SELECT * FROM `emps` WHERE `id` = '{$empId}' LIMIT 1");
        $matches = array();
    }
}

header('Content-Type: text/html; charset=utf-8');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Staff permission audit</title>
<style>
  :root { --navy:#112c5a; --gold:#eed484; --muted:#5c6b82; }
  body { margin:0; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; background:#f4f6fa; color:#1b2433; }
  .wrap { max-width:920px; margin:0 auto; padding:24px 16px 48px; }
  h1 { margin:0 0 8px; color:var(--navy); font-size:24px; }
  .sub { color:var(--muted); margin:0 0 20px; line-height:1.45; }
  form { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
  input[type=text], input[type=number] { flex:1 1 220px; padding:12px 14px; border:1px solid #cfd8e6; border-radius:10px; font-size:16px; }
  button, .btn { display:inline-block; padding:12px 16px; border:0; border-radius:10px; background:var(--gold); color:var(--navy); font-weight:700; text-decoration:none; cursor:pointer; }
  .card { background:#fff; border-radius:14px; padding:18px 18px 8px; margin-bottom:16px; box-shadow:0 8px 24px rgba(17,44,90,.08); }
  .card h2 { margin:0 0 12px; font-size:18px; color:var(--navy); }
  table { width:100%; border-collapse:collapse; font-size:14px; }
  th, td { text-align:left; padding:10px 8px; border-bottom:1px solid #e8edf5; vertical-align:top; }
  th { color:var(--muted); font-weight:600; width:34%; }
  .on { color:#0b7a3b; font-weight:700; }
  .off { color:#9aa7b8; }
  .warn { background:#fff8e6; border:1px solid #f0dfa0; border-radius:10px; padding:12px 14px; margin:12px 0 0; color:#6a4d00; }
  .match { display:block; padding:12px 14px; border-radius:10px; background:#fff; margin-bottom:8px; text-decoration:none; color:inherit; box-shadow:0 4px 14px rgba(17,44,90,.06); }
  .match b { color:var(--navy); }
  .pill { display:inline-block; padding:2px 8px; border-radius:999px; background:#eef3fb; color:var(--navy); font-size:12px; margin:0 6px 6px 0; }
  ul { margin:0 0 12px 18px; padding:0; }
  li { margin-bottom:6px; }
</style>
</head>
<body>
<div class="wrap">
  <h1>Staff permission audit</h1>
  <p class="sub">Read-only check for why a teacher sees certain grades in student search, homework, and memo. Search by name, phone, or employee id.</p>

  <form method="get" action="">
    <input type="hidden" name="k" value="<?php echo perm_audit_h(PERM_AUDIT_KEY); ?>">
    <input type="text" name="q" value="<?php echo perm_audit_h($q); ?>" placeholder="Name, phone, or employee id" autofocus>
    <button type="submit">Search</button>
  </form>

<?php if ($matches) { ?>
  <div class="card">
    <h2>Matches (<?php echo count($matches); ?>)</h2>
    <?php foreach ($matches as $m) { ?>
      <a class="match" href="?k=<?php echo urlencode(PERM_AUDIT_KEY); ?>&amp;id=<?php echo (int) $m['id']; ?>">
        <b><?php echo perm_audit_h($m['name']); ?></b>
        · Employee #<?php echo (int) $m['id']; ?>
        · <?php echo perm_audit_h(perm_audit_job_name($m['job'])); ?>
      </a>
    <?php } ?>
  </div>
<?php } elseif ($q !== '' && !$emp) { ?>
  <div class="card"><p>No employee found for <b><?php echo perm_audit_h($q); ?></b>.</p></div>
<?php } ?>

<?php if ($emp) {
    $empId = (int) $emp['id'];
    $teacherYears = perm_audit_teacher_years($empId);
    $studentYears = perm_audit_flag_years($emp, perm_audit_student_groups());
    $memoYears = perm_audit_memo_years($emp);
    $assignments = perm_audit_assignments($empId);
    $logins = perm_audit_logins($empId);
    $roles = perm_audit_roles($empId);
    $memoOnly = array_values(array_diff($memoYears, $teacherYears));
    $teacherOnly = array_values(array_diff($teacherYears, $memoYears));
    $studentOnly = array_values(array_diff($studentYears, $teacherYears));
    $teacherNotStudent = array_values(array_diff($teacherYears, $studentYears));
?>
  <div class="card">
    <h2><?php echo perm_audit_h($emp['name']); ?></h2>
    <table>
      <tr><th>Employee id</th><td><?php echo $empId; ?></td></tr>
      <tr><th>Job</th><td><?php echo perm_audit_h(perm_audit_job_name($emp['job'])); ?></td></tr>
      <tr><th>Mobile logins</th><td>
        <?php if (!$logins) { echo 'None'; } else {
            foreach ($logins as $login) {
                $active = (int) $login['active'] === 1 ? 'active' : 'inactive';
                echo '<div>' . perm_audit_h($login['name']) . ' · ' . perm_audit_h($login['phone']) . ' · login #' . (int) $login['id'] . ' · ' . $active . '</div>';
            }
        } ?>
      </td></tr>
    </table>
  </div>

  <div class="card">
    <h2>App modules</h2>
    <table>
      <tr><th>Student search</th><td class="<?php echo perm_audit_on($emp, 'app10') ? 'on' : 'off'; ?>"><?php echo perm_audit_on($emp, 'app10') ? 'ON (app10)' : 'OFF'; ?></td></tr>
      <tr><th>Homework module</th><td class="<?php echo (perm_audit_on($emp, 'app11') || perm_audit_on($emp, 'app11_2')) ? 'on' : 'off'; ?>"><?php echo (perm_audit_on($emp, 'app11') || perm_audit_on($emp, 'app11_2')) ? 'ON' : 'OFF'; ?></td></tr>
      <tr><th>Homework assign</th><td class="<?php echo perm_audit_on($emp, 'app11_1') ? 'on' : 'off'; ?>"><?php echo perm_audit_on($emp, 'app11_1') ? 'ON (app11_1)' : 'OFF'; ?></td></tr>
      <tr><th>Memo module</th><td class="<?php echo (perm_audit_on($emp, 'app17') || perm_audit_on($emp, 'app18')) ? 'on' : 'off'; ?>"><?php echo (perm_audit_on($emp, 'app17') || perm_audit_on($emp, 'app18')) ? 'ON' : 'OFF'; ?></td></tr>
      <tr><th>Memo upload</th><td class="<?php echo (perm_audit_on($emp, 'app17_1') || perm_audit_on($emp, 'app17')) ? 'on' : 'off'; ?>"><?php echo (perm_audit_on($emp, 'app17_1') || perm_audit_on($emp, 'app17')) ? 'ON' : 'OFF'; ?></td></tr>
      <tr><th>Memo view uploaded</th><td class="<?php echo perm_audit_on($emp, 'app18') ? 'on' : 'off'; ?>"><?php echo perm_audit_on($emp, 'app18') ? 'ON (app18)' : 'OFF'; ?></td></tr>
    </table>
  </div>

  <div class="card">
    <h2>What they see in each feature</h2>
    <table>
      <tr><th>Student search years</th><td><?php echo perm_audit_h(perm_audit_year_list($studentYears)); ?><br><span class="sub">From <code>emps.app10_*</code> stage flags (grouped)</span></td></tr>
      <tr><th>Homework years</th><td><?php echo perm_audit_h(perm_audit_year_list($teacherYears)); ?><br><span class="sub">From <code>teachers</code> table; classes filtered per assignment</span></td></tr>
      <tr><th>Memo years</th><td><?php echo perm_audit_h(perm_audit_year_list($memoYears)); ?><br><span class="sub">From <code>emps.app18_*</code> stage flags (grouped)</span></td></tr>
    </table>
    <?php if ($memoOnly || $teacherOnly || $studentOnly || $teacherNotStudent) { ?>
      <div class="warn">
        <?php if ($studentOnly) { ?>
          <div><b>Student search only:</b> <?php echo perm_audit_h(perm_audit_year_list($studentOnly)); ?> — search flag is on but no matching <code>teachers</code> row.</div>
        <?php } ?>
        <?php if ($teacherNotStudent) { ?>
          <div><b>Teaching only:</b> <?php echo perm_audit_h(perm_audit_year_list($teacherNotStudent)); ?> — assigned in <code>teachers</code> but student-search stage flag is off.</div>
        <?php } ?>
        <?php if ($memoOnly) { ?>
          <div><b>Memo only:</b> <?php echo perm_audit_h(perm_audit_year_list($memoOnly)); ?> — memo flag is on but no matching <code>teachers</code> row (class list may be empty).</div>
        <?php } ?>
        <?php if ($teacherOnly) { ?>
          <div><b>Teachers only:</b> <?php echo perm_audit_h(perm_audit_year_list($teacherOnly)); ?> — assigned in <code>teachers</code> but memo stage flag is off.</div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>

  <div class="card">
    <h2>Student search stage flags</h2>
    <table>
      <?php foreach (perm_audit_student_groups() as $group) {
          $on = perm_audit_on($emp, $group['flag']);
          $yearLabels = array();
          foreach ($group['years'] as $year) {
              $yearLabels[] = perm_audit_year_name($year);
          }
      ?>
      <tr>
        <th><?php echo perm_audit_h($group['label']); ?></th>
        <td class="<?php echo $on ? 'on' : 'off'; ?>">
          <?php echo $on ? 'ON' : 'OFF'; ?> · <code><?php echo perm_audit_h($group['flag']); ?></code>
          <?php if ($on) { ?> · unlocks <?php echo perm_audit_h(implode(', ', $yearLabels)); ?><?php } ?>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div class="card">
    <h2>Memo stage flags</h2>
    <table>
      <?php foreach (perm_audit_memo_groups() as $group) {
          $on = perm_audit_on($emp, $group['flag']);
          $yearLabels = array();
          foreach ($group['years'] as $year) {
              $yearLabels[] = perm_audit_year_name($year);
          }
      ?>
      <tr>
        <th><?php echo perm_audit_h($group['label']); ?></th>
        <td class="<?php echo $on ? 'on' : 'off'; ?>">
          <?php echo $on ? 'ON' : 'OFF'; ?> · <code><?php echo perm_audit_h($group['flag']); ?></code>
          <?php if ($on) { ?> · unlocks <?php echo perm_audit_h(implode(', ', $yearLabels)); ?><?php } ?>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <?php if ($roles['coordinator'] || $roles['head']) { ?>
  <div class="card">
    <h2>Special roles</h2>
    <?php if ($roles['coordinator']) { ?><p><b>Subject coordinator:</b> <?php echo perm_audit_h(implode(', ', $roles['coordinator'])); ?></p><?php } ?>
    <?php if ($roles['head']) { ?><p><b>Department head:</b> <?php echo perm_audit_h(implode(', ', $roles['head'])); ?></p><?php } ?>
  </div>
  <?php } ?>

  <div class="card">
    <h2>Teaching assignments (<code>teachers</code> table)</h2>
    <?php if (!$assignments) { ?>
      <p>No rows in <code>teachers</code> for this employee.</p>
    <?php } else { ?>
      <table>
        <thead>
          <tr><th>Year</th><th>Class</th><th>Subject</th></tr>
        </thead>
        <tbody>
        <?php foreach ($assignments as $row) { ?>
          <tr>
            <td><?php echo perm_audit_h(perm_audit_year_name($row['study_year'])); ?> (<?php echo (int) $row['study_year']; ?>)</td>
            <td><?php echo perm_audit_h(perm_audit_class_name($row['class'])); ?></td>
            <td><?php echo perm_audit_h(perm_audit_subject_name($row['subject'])); ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div>

  <div class="card">
    <h2>Classes per year (effective for homework / memo class pickers)</h2>
    <?php if (!$teacherYears) { ?>
      <p>None — no <code>teachers</code> rows.</p>
    <?php } else { ?>
      <ul>
      <?php foreach ($teacherYears as $year) { ?>
        <li><b><?php echo perm_audit_h(perm_audit_year_name($year)); ?>:</b> <?php echo perm_audit_h(perm_audit_classes_for_year($empId, $year)); ?></li>
      <?php } ?>
      </ul>
    <?php } ?>
  </div>

  <p class="sub">To change access: Helalia control panel → employee permissions (<code>app18_*</code>, <code>app10</code>, etc.) and teacher assignments (<code>teachers</code> table / All Teachers).</p>
<?php } ?>
</div>
</body>
</html>
