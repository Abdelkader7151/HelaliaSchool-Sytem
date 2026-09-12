<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");

$since = function_exists('helalia_alert_new_since') ? (int) helalia_alert_new_since() : (time() - 14 * 86400);
$pageSize = 10;
$offset = isset($_GET['more']) ? max(0, (int) $_GET['more']) : 0;

if (isset($_GET['mark_all']) && (string) $_GET['mark_all'] === '1') {
    $kidsQ = mysqli_query($database, "SELECT `kid_id` FROM `kids_list` WHERE `parent_id` = '{$row_get_user['id']}'");
    while ($kidsQ && ($kr = mysqli_fetch_assoc($kidsQ))) {
        $kid = (int) $kr['kid_id'];
        mysqli_query($database, "UPDATE `notifications` SET `view` = 1 WHERE `kid_id` = '{$kid}' AND `view` = 0 AND `del` = 0");
    }
    $redir = 'parent-alerts.php';
    if (isset($_GET['kid']) && (int) $_GET['kid'] > 0) {
        $redir .= '?kid=' . (int) $_GET['kid'];
    }
    header('Location: ' . $redir);
    exit();
}

if (isset($_GET['del']) && escape($_GET['del']) > 0) {
    $del = escape($_GET['del']);
    $kid_id = escape($_GET['kid']);
    $updateSQL1 = sprintf(
        "UPDATE `notifications` SET `del`=%s WHERE `id`=%s AND `kid_id`=%s",
        GetSQLValueString($database, 1, "int"),
        GetSQLValueString($database, $del, "int"),
        GetSQLValueString($database, $kid_id, "int")
    );
    mysqli_query($database, $updateSQL1) or die(mysqli_error($database));
}

$kid_id = 0;
if (isset($_GET['kid']) && escape($_GET['kid']) > 0) {
    $kid_id = (int) escape($_GET['kid']);
    $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}' and `kid_id` = '{$kid_id}'";
    $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
    $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
    $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);
    if ($totalRows_get_kids_list == 0) {
        header("Location: parent-view.php");
        exit();
    }
    $query_get_kid_data = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
    $get_kid_data = mysqli_query($database, $query_get_kid_data) or die(mysqli_error($database));
    $row_get_kid_data = mysqli_fetch_assoc($get_kid_data);
    $totalRows_get_kid_data = mysqli_num_rows($get_kid_data);
    if ($totalRows_get_kid_data == 0) {
        header("Location: parent-view.php");
        exit();
    }
}

$parentId = (int) $row_get_user['id'];
$kidIds = array();
$kq = mysqli_query($database, "SELECT `kid_id` FROM `kids_list` WHERE `parent_id` = '{$parentId}'");
while ($kq && ($kr = mysqli_fetch_assoc($kq))) {
    $kidIds[] = (int) $kr['kid_id'];
}
if ($kid_id > 0) {
    $kidIds = array($kid_id);
}
$kidIds = array_values(array_filter($kidIds));
$inKids = $kidIds ? implode(',', $kidIds) : '0';

$listSql = "SELECT * FROM `notifications`
  WHERE `del` = 0 AND `kid_id` IN ({$inKids}) AND `date` >= '{$since}'
  ORDER BY (`view` = 0) DESC, `id` DESC
  LIMIT " . (int) ($pageSize + 1) . " OFFSET " . (int) $offset;
$get_notifications = mysqli_query($database, $listSql) or die(mysqli_error($database));
$rows = array();
while ($get_notifications && ($r = mysqli_fetch_assoc($get_notifications))) {
    $rows[] = $r;
}
$hasMore = count($rows) > $pageSize;
if ($hasMore) {
    array_pop($rows);
}

$unreadNew = 0;
$uq = mysqli_query($database, "SELECT COUNT(*) AS c FROM `notifications` WHERE `del` = 0 AND `view` = 0 AND `kid_id` IN ({$inKids}) AND `date` >= '{$since}'");
if ($uq && ($ur = mysqli_fetch_assoc($uq))) {
    $unreadNew = (int) $ur['c'];
}

$typeLabel = function ($t) {
    $t = (int) $t;
    if ($t === 1) return 'غياب';
    if ($t === 6) return 'إعلان';
    if ($t === 65) return 'رسالة';
    return 'تنبيه';
};

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title>التنبيهات · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=35">
</head>
<body>
<div class="app">
  <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-view.php" aria-label="رجوع">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg>
      </a>
      <h1 class="hero__title">التنبيهات</h1>
      <div class="bells"></div>
    </div>
  </header>

  <main class="page">
<?php
$tabQ = mysqli_query($database, "SELECT * FROM `kids_list` WHERE `parent_id` = '{$parentId}'");
$tabRows = array();
while ($tabQ && ($tr = mysqli_fetch_assoc($tabQ))) {
    $tabRows[] = $tr;
}
if (count($tabRows) > 1) { ?>
    <div class="tabs tabs--scroll">
      <a class="tab<?php echo $kid_id < 1 ? ' is-active' : ''; ?>" href="parent-alerts.php">الكل</a>
<?php foreach ($tabRows as $tr) {
    $kd = mysqli_query($database, "SELECT `id`,`name`,`fn_name` FROM `kids` WHERE `id` = '{$tr['kid_id']}' LIMIT 1");
    $kidRow = $kd ? mysqli_fetch_assoc($kd) : null;
    if (!$kidRow) continue;
    $label = !empty($kidRow['name']) ? $kidRow['name'] : $kidRow['fn_name'];
?>
      <a class="tab<?php echo ($kid_id === (int) $kidRow['id']) ? ' is-active' : ''; ?>" href="parent-alerts.php?kid=<?php echo (int) $kidRow['id']; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></a>
<?php } ?>
    </div>
<?php } ?>

    <p class="auth__fine" style="margin:0 0 10px">عرض آخر <?php echo (int) helalia_alert_new_days(); ?> يوماً<?php if ($unreadNew > 0) { echo ' · ' . $unreadNew . ' جديدة'; } ?>.</p>
<?php if ($unreadNew > 0) {
    $markUrl = 'parent-alerts.php?mark_all=1' . ($kid_id > 0 ? '&kid=' . $kid_id : '');
?>
    <p style="margin:0 0 12px"><a class="btn btn--quiet" href="<?php echo htmlspecialchars($markUrl, ENT_QUOTES, 'UTF-8'); ?>">تعيين الكل كمقروء</a></p>
<?php } ?>

    <div class="rows" id="alerts-list">
<?php if (!$rows) { ?>
      <p class="auth__fine">لا توجد تنبيهات جديدة في هذه الفترة.</p>
<?php } else {
    foreach ($rows as $n) {
        $isUnread = ((int) $n['view'] === 0);
        $rowClass = $isUnread ? 'row is-unread' : 'row is-read';
        $href = 'parent-alert.php?id=' . (int) $n['id'] . '&kid=' . (int) $n['kid_id'];
?>
      <a class="<?php echo $rowClass; ?>" href="<?php echo $href; ?>">
        <span class="row__ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 4h8a2 2 0 0 1 2 2v14l-6-3-6 3V6a2 2 0 0 1 2-2z"/></svg>
        </span>
        <div class="row__body">
          <p class="row__title"><?php echo htmlspecialchars((string) $n['title'], ENT_QUOTES, 'UTF-8'); ?></p>
          <p class="row__meta"><?php
            if ($kid_id < 1) {
                echo htmlspecialchars(kid_name($n['kid_id']), ENT_QUOTES, 'UTF-8') . ' · ';
            }
            echo $typeLabel($n['type']);
          ?></p>
          <p class="row__time"><?php echo date('d M, Y', (int) $n['date']); ?></p>
        </div>
        <span class="row__go">›</span>
      </a>
<?php }
} ?>
    </div>

<?php if ($hasMore) {
    $moreUrl = 'parent-alerts.php?more=' . (int) ($offset + $pageSize) . ($kid_id > 0 ? '&kid=' . $kid_id : '');
?>
    <a class="btn btn--quiet alerts-more" style="display:block;width:100%;text-align:center;margin:14px 0" href="<?php echo htmlspecialchars($moreUrl, ENT_QUOTES, 'UTF-8'); ?>">تحميل المزيد</a>
<?php } ?>
  </main>

<?php if ($kid_id > 0) { ?>
  <nav class="nav" aria-label="Home" style="height:90px">
    <a class="nav__item" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.2"/><path d="M3 19a6 6 0 0 1 12 0"/><path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/><path d="M18 13.5a6 6 0 0 1 3 5.5"/></svg>
      <span>الطلاب</span><span class="nav__dot"></span>
    </a>
    <a class="nav__item" href="parent-calendar.php?kid=<?php echo $kid_id; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <span>التقويم</span><span class="nav__dot"></span>
    </a>
    <a class="nav__fab" href="parent-kid.php?id=<?php echo (int) $row_get_kid_data['id']; ?>" aria-label="">
      <img src="../../../../kids/<?php echo ($row_get_kid_data['picture'] != NULL && file_exists('../../../../kids/' . $row_get_kid_data['picture'])) ? htmlspecialchars($row_get_kid_data['picture'], ENT_QUOTES, 'UTF-8') : 'no-picture.png'; ?>" alt="">
    </a>
    <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/><path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/><path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/></svg>
      <span>آخر الأخبار</span><span class="nav__dot"></span>
    </a>
    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
      <span>الإعدادات</span><span class="nav__dot"></span>
    </a>
  </nav>
<?php } else { ?>
  <nav class="nav nav--trio" aria-label="Home" style="height:90px">
    <a class="nav__item" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.2"/><path d="M3 19a6 6 0 0 1 12 0"/><path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/><path d="M18 13.5a6 6 0 0 1 3 5.5"/></svg>
      <span>الطلاب</span><span class="nav__dot"></span>
    </a>
    <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/><path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/><path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/></svg>
      <span>آخر الأخبار</span><span class="nav__dot"></span>
    </a>
    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
      <span>الإعدادات</span><span class="nav__dot"></span>
    </a>
  </nav>
<?php } ?>
</div>
<script src="../assets/js/app.js?v=35" defer></script>
</body>
</html>
