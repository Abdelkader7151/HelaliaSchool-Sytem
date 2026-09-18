<?php

if (!empty($_SESSION['staff_preview_user']) && (!empty($staffPreview) || !empty($staffSnapshot))) {
    $p = $_SESSION['staff_preview_user'];
    if (!empty($p['name'])) {
        $row_get_user['name'] = $p['name'];
        $displayName = $p['name'];
    }
    if (isset($p['email'])) {
        $row_get_user['email'] = $p['email'];
    }
}

if (!function_exists('staff_sql')) {
    function staff_sql($value, $type)
    {
        global $database;
        if (function_exists('GetSQLValueString') && !empty($database)) {
            return GetSQLValueString($database, $value, $type);
        }
        if ($type === 'int') {
            return ($value === '' || $value === null) ? 'NULL' : (string) intval($value);
        }
        if ($value === '' || $value === null) {
            return 'NULL';
        }
        $escaped = isset($database) ? mysqli_real_escape_string($database, (string) $value) : addslashes((string) $value);
        return "'" . $escaped . "'";
    }
}

/**
 * staff_site_dir
 * Live folders 3ala site root (uploads / homework / attachments)
 * Zay el app el adeem: ../../../uploads men emp/eng — mesh app/mobile/uploads
 */
function staff_site_dir($folder)
{
    global $mobileRoot;
    $folder = preg_replace('/[^a-z0-9_-]/i', '', (string) $folder);
    $empHome = dirname(__DIR__);
    $mobile = (!empty($mobileRoot) && is_string($mobileRoot)) ? $mobileRoot : dirname($empHome);
    // .../app/mobile -> .../app -> .../system.helalia-ls.org
    $siteRoot = dirname($mobile, 2);
    $dir = $siteRoot . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    $real = realpath($dir);
    return $real ? $real : $dir;
}

function staff_uploads_dir()
{
    return staff_site_dir('uploads');
}

function staff_attachments_dir()
{
    return staff_site_dir('attachments');
}

function staff_vac_type($id)
{
    global $L;
    $key = 'vac_' . (int) $id;
    return isset($L[$key]) ? $L[$key] : '';
}

function staff_vac_status($id)
{
    global $L;
    $map = array(0 => 'st_pending', 1 => 'st_accepted', 2 => 'st_rejected', 3 => 'st_canceled');
    $key = isset($map[(int) $id]) ? $map[(int) $id] : 'st_pending';
    return $L[$key];
}

function staff_vac_tone($id)
{
    $map = array(0 => 't-blue', 1 => 't-green', 2 => 't-coral', 3 => 't-gold');
    return isset($map[(int) $id]) ? $map[(int) $id] : 't-navy';
}

function staff_vac_days($start, $end)
{
    global $L;
    $days = (int) round(((int) $end - (int) $start) / 86400);
    if ($days == 1) {
        return $days . ' ' . $L['day_one'];
    }
    return $days . ' ' . $L['day_many'];
}

function staff_exc_time($start, $end)
{
    $step = (int) $end - (int) $start;
    if ($step <= 0) {
        return '00:00';
    }
    return gmdate('H:i', $step);
}

function staff_fetch($sql)
{
    global $database, $database_database;
    if (!isset($database) || !($database instanceof mysqli)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $q = mysqli_query($database, $sql);
    $rows = array();
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) {
            $rows[] = $r;
        }
    }
    return $rows;
}

function staff_banner($done)
{
    global $staffPreview;
    if ($done && $staffPreview) {
        echo '<p class="note note--navy">' . staff_h($GLOBALS['L']['preview_note']) . '</p>';
    }
}

function staff_go()
{
    global $staffLang;
    return ($staffLang === 'arb') ? '‹' : '›';
}

function staff_notify_emps($appCol, $message)
{
    global $database, $database_database;
    if (!function_exists('sendMessage') || !function_exists('app_msg_id2')) {
        return;
    }
    $col = preg_replace('/[^a-z0-9_]/i', '', $appCol);
    $rows = staff_fetch("SELECT `id` FROM `emps` WHERE `{$col}`=1");
    foreach ($rows as $row) {
        sendMessage(app_msg_id2($row['id']), 'HLS', $message);
    }
}

/**
 * staff_upload_picture
 * Save profile photo fe site uploads/ (same URL staff_photo_url)
 * jpg/png/gif bas — zay el system el adeem
 */
function staff_upload_picture($userId, $oldName)
{
    $keep = basename(str_replace('\\', '/', (string) $oldName));
    if (empty($_FILES['picture']['name']) || empty($_FILES['picture']['tmp_name'])) {
        return $keep;
    }
    if (!empty($_FILES['picture']['error']) && (int) $_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
        return $keep;
    }
    $filename = stripslashes((string) $_FILES['picture']['name']);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if ($ext === 'jpeg') {
        $ext = 'jpg';
    }
    if (!in_array($ext, array('jpg', 'png', 'gif'), true)) {
        return $keep;
    }
    $tmp = $_FILES['picture']['tmp_name'];
    if (!is_uploaded_file($tmp)) {
        return $keep;
    }
    if (filesize($tmp) / 1000 > 80000) {
        return $keep;
    }
    $dir = staff_uploads_dir();
    if ($dir === '' || !is_dir($dir)) {
        return $keep;
    }
    // Recompress to jpg law momken (asghar 3ala el phone)
    $outExt = $ext;
    $img = null;
    if (function_exists('getimagesize')) {
        $info = @getimagesize($tmp);
        if ($info && !empty($info['mime'])) {
            if ($info['mime'] === 'image/jpeg' && function_exists('imagecreatefromjpeg')) {
                $img = @imagecreatefromjpeg($tmp);
            } elseif ($info['mime'] === 'image/png' && function_exists('imagecreatefrompng')) {
                $img = @imagecreatefrompng($tmp);
            } elseif ($info['mime'] === 'image/gif' && function_exists('imagecreatefromgif')) {
                $img = @imagecreatefromgif($tmp);
            }
        }
    }
    if ($img && function_exists('imagejpeg')) {
        $outExt = 'jpg';
    }
    $imageName = (int) $userId . '-' . time() . '.' . $outExt;
    $dest = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $imageName;
    $wrote = false;
    if ($img && function_exists('imagejpeg')) {
        $wrote = @imagejpeg($img, $dest, 70);
        imagedestroy($img);
    }
    if (!$wrote) {
        $wrote = @move_uploaded_file($tmp, $dest);
    }
    if (!$wrote) {
        $wrote = @copy($tmp, $dest);
    }
    if (!$wrote || !is_file($dest)) {
        return $keep;
    }
    if ($keep !== '' && stripos($keep, 'no-picture-') !== 0 && $keep !== $imageName) {
        $oldPath = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $keep;
        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }
    return $imageName;
}

function staff_upload_sick_note()
{
    if (empty($_FILES['sick_note']['name']) || empty($_FILES['sick_note']['tmp_name'])) {
        return null;
    }
    $filename = stripslashes((string) $_FILES['sick_note']['name']);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'), true)) {
        return null;
    }
    if (filesize($_FILES['sick_note']['tmp_name']) / 1000 > 15000) {
        return null;
    }
    $dir = staff_attachments_dir();
    if (!is_dir($dir)) {
        return null;
    }
    $imageName = time() . '.' . $ext;
    $dest = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $imageName;
    if (!@copy($_FILES['sick_note']['tmp_name'], $dest)) {
        return null;
    }
    return $imageName;
}

function staff_vac_store_mode()
{
    global $staffPreview, $staffSnapshot;
    return !empty($staffPreview) || !empty($staffSnapshot);
}

function staff_absence_back_href()
{
    if (isset($_GET['new']) || isset($_GET['id'])) {
        return staff_absence_list_href();
    }
    if (isset($_GET['from']) && $_GET['from'] === 'checkin') {
        return 'emp-checkin.php';
    }
    if (isset($_GET['from']) && $_GET['from'] === 'attendance') {
        return isset($_GET['ret']) && $_GET['ret'] === 'checkin'
            ? 'my-attendance.php?from=checkin'
            : 'my-attendance.php';
    }
    return staff_profile_href();
}

function staff_absence_list_href()
{
    $href = 'my-absence.php';
    $parts = array();
    if (isset($_GET['from']) && $_GET['from'] !== '') {
        $parts[] = 'from=' . rawurlencode((string) $_GET['from']);
    }
    if (isset($_GET['ret']) && $_GET['ret'] !== '') {
        $parts[] = 'ret=' . rawurlencode((string) $_GET['ret']);
    }
    return $parts ? ($href . '?' . implode('&', $parts)) : $href;
}

function staff_render_my_absence_link($from = '', $ret = '')
{
    global $L;
    $parts = array();
    if ($from !== '') {
        $parts[] = 'from=' . rawurlencode($from);
    }
    if ($ret !== '') {
        $parts[] = 'ret=' . rawurlencode($ret);
    }
    $qs = $parts ? ('?' . implode('&', $parts)) : '';
    echo '<div class="staff-quick">';
    echo '<a class="staff-quick__link staff-quick__link--abs" href="my-absence.php' . staff_h($qs) . '">';
    echo staff_ico('thermo') . '<span>' . staff_h($L['my_absence']) . '</span></a>';
    echo '</div>';
}

function staff_vac_push_approval_queue($row)
{
    global $row_get_user;
    if (!function_exists('staff_demo')) {
        require_once __DIR__ . '/services.php';
    }
    $d = staff_demo();
    $max = 80;
    foreach ($d['vacs'] as $v) {
        $max = max($max, (int) $v['id']);
    }
    $d['vacs'][] = array(
        'id' => $max + 1,
        'emp_id' => (int) ($row_get_user['emp_id'] ?? 0),
        'status' => 0,
        'type' => (int) $row['type'],
        'vacation_start' => (int) $row['vacation_start'],
        'vacation_end' => (int) $row['vacation_end'],
        'text' => (string) $row['text'],
        'sick_note' => isset($row['sick_note']) ? $row['sick_note'] : null,
    );
    staff_demo_save($d);
}

function staff_preview_vacs()
{
    global $staffSnapshot, $staffPreview;
    if (!empty($staffSnapshot) && empty($staffPreview)) {
        if (empty($_SESSION['staff_preview_vacs'])) {
            $_SESSION['staff_preview_vacs'] = array();
        }
        return $_SESSION['staff_preview_vacs'];
    }
    if (empty($_SESSION['staff_preview_vacs'])) {
        $now = time();
        $_SESSION['staff_preview_vacs'] = array(
            array(
                'id' => 1,
                'type' => 1,
                'vacation_start' => $now - (3 * 86400),
                'vacation_end' => $now,
                'text' => 'Family matter',
                'sick_note' => null,
                'status' => 0,
                'date' => $now - (4 * 86400),
            ),
            array(
                'id' => 2,
                'type' => 3,
                'vacation_start' => $now - (20 * 86400),
                'vacation_end' => $now - (18 * 86400),
                'text' => 'Medical rest',
                'sick_note' => 'note.jpg',
                'status' => 1,
                'date' => $now - (21 * 86400),
            ),
        );
    }
    return $_SESSION['staff_preview_vacs'];
}

function staff_preview_excuses()
{
    if (empty($_SESSION['staff_preview_excuses'])) {
        $now = time();
        $_SESSION['staff_preview_excuses'] = array(
            array(
                'id' => 1,
                'start' => strtotime('1/1/2000 09:00'),
                'end' => strtotime('1/1/2000 11:30'),
                'hours' => '02:30',
                'text' => 'Clinic visit',
                'status' => 0,
                'date' => $now,
            ),
            array(
                'id' => 2,
                'start' => strtotime('1/1/2000 13:00'),
                'end' => strtotime('1/1/2000 14:00'),
                'hours' => '01:00',
                'text' => 'Paperwork',
                'status' => 1,
                'date' => $now - (9 * 86400),
            ),
        );
    }
    return $_SESSION['staff_preview_excuses'];
}

function staff_profile_year_name($id)
{
    if (function_exists('staff_year_label')) {
        $label = trim((string) staff_year_label($id));
        if ($label !== '') {
            return $label;
        }
    }
    if (function_exists('year_of_study')) {
        $label = trim((string) year_of_study($id));
        if ($label !== '') {
            return $label;
        }
    }
    global $staffLang;
    $eng = array(
        0 => 'Preschool', 1 => 'KG1', 2 => 'KG2', 3 => 'Junior One', 4 => 'Junior Two',
        5 => 'Junior Three', 6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
        12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
    );
    $arb = array(
        0 => 'بري سكول', 1 => 'رياض أطفال 1', 2 => 'رياض أطفال 2', 3 => 'الابتدائي 1', 4 => 'الابتدائي 2',
        5 => 'الابتدائي 3', 6 => 'الابتدائي 4', 7 => 'الابتدائي 5', 8 => 'الابتدائي 6',
        9 => 'الاعدادي 1', 10 => 'الاعدادي 2', 11 => 'الاعدادي 3',
        12 => 'الثانوي 1', 13 => 'الثانوي 2', 14 => 'الثانوي 3',
    );
    $map = ($staffLang === 'arb') ? $arb : $eng;
    $id = (int) $id;
    return isset($map[$id]) ? $map[$id] : (string) $id;
}

function staff_profile_dash($value)
{
    global $L;
    $v = trim((string) $value);
    if ($v === '' || strcasecmp($v, 'null') === 0) {
        return isset($L['profile_dash']) ? $L['profile_dash'] : '—';
    }
    return $v;
}

function staff_profile_emp_row()
{
    global $empId, $database, $row_get_user;
    if (function_exists('staff_local_emp_row') && isset($database) && $database instanceof mysqli && (int) $empId > 0) {
        $row = staff_local_emp_row($empId);
        if ($row) {
            return $row;
        }
    }
    if (!empty($_SESSION['helalia_snapshot_emp'])) {
        $p = $_SESSION['helalia_snapshot_emp'];
        return array(
            'id' => (int) ($p['emp_id'] ?? 0),
            'name' => isset($p['name']) ? $p['name'] : '',
            'job' => $p['job'] ?? '',
            'phone' => isset($p['phone']) ? $p['phone'] : '',
        );
    }
    return array(
        'id' => (int) ($row_get_user['emp_id'] ?? 0),
        'name' => isset($row_get_user['name']) ? $row_get_user['name'] : '',
        'phone' => isset($row_get_user['phone']) ? $row_get_user['phone'] : '',
    );
}

function staff_profile_years()
{
    global $empId, $database, $database_database, $staffPreview, $staffSnapshot;
    if (isset($database) && $database instanceof mysqli && (int) $empId > 0) {
        mysqli_select_db($database, $database_database);
        $eid = (int) $empId;
        $rs = mysqli_query($database, "SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '{$eid}' ORDER BY `study_year` ASC");
        $years = array();
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $years[] = (int) $row['study_year'];
            }
        }
        return $years;
    }
    if (!empty($staffPreview) || !empty($staffSnapshot)) {
        return array(5);
    }
    return array();
}

function staff_profile_job_label($emp)
{
    global $jobLabel;
    if (trim((string) $jobLabel) !== '') {
        return (string) $jobLabel;
    }
    if (isset($emp['job']) && !is_numeric($emp['job']) && trim((string) $emp['job']) !== '') {
        return trim((string) $emp['job']);
    }
    if (function_exists('job_name') && function_exists('empjob') && !empty($emp['id'])) {
        $j = trim((string) job_name(empjob($emp['id'])));
        if ($j !== '') {
            return $j;
        }
    }
    return '';
}

function staff_profile_gender_label()
{
    global $L, $row_get_user;
    $g = (string) ($row_get_user['gender'] ?? '');
    if ($g === '1') {
        return $L['gender_m'];
    }
    if ($g === '2') {
        return $L['gender_f'];
    }
    return '';
}

function staff_profile_fact($label, $value)
{
    echo '<div class="prof-fact">';
    echo '<span>' . staff_h($label) . '</span>';
    echo '<b>' . staff_h(staff_profile_dash($value)) . '</b>';
    echo '</div>';
}

function staff_boot_profile()
{
    global $database, $database_database, $row_get_user;
    if (!isset($_POST['submit'])) {
        return;
    }
    $name = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
    $email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
    if (staff_vac_store_mode()) {
        $_SESSION['staff_preview_user'] = array('name' => $name, 'email' => $email);
        header('Location: profile.php?done=1');
        exit;
    }
    // Keep current DB picture law upload fashal — mesh NULL
    $oldImg = isset($_POST['old_img']) ? (string) $_POST['old_img'] : '';
    if ($oldImg === '' || strcasecmp($oldImg, 'null') === 0) {
        $oldImg = isset($row_get_user['picture']) ? (string) $row_get_user['picture'] : '';
    }
    $imageName = staff_upload_picture((int) $row_get_user['id'], $oldImg);
    if ($imageName === '' || strcasecmp($imageName, 'null') === 0) {
        $imageName = $oldImg;
    }
    mysqli_select_db($database, $database_database);
    if ($imageName !== '' && strcasecmp($imageName, 'null') !== 0) {
        $updateSQL1 = sprintf(
            "UPDATE `app_login` SET `name`=%s, `email`=%s, `picture`=%s WHERE `id`=%s",
            staff_sql($name, 'text'),
            staff_sql($email, 'text'),
            staff_sql($imageName, 'text'),
            staff_sql($row_get_user['id'], 'int')
        );
    } else {
        // Mesh temsa7 picture law mafish soora gdeeda
        $updateSQL1 = sprintf(
            "UPDATE `app_login` SET `name`=%s, `email`=%s WHERE `id`=%s",
            staff_sql($name, 'text'),
            staff_sql($email, 'text'),
            staff_sql($row_get_user['id'], 'int')
        );
    }
    mysqli_query($database, $updateSQL1);
    $uid = (int) $row_get_user['id'];
    $kids = staff_fetch("SELECT * FROM `kids_list` WHERE `parent_id` = '{$uid}'");
    foreach ($kids as $kid) {
        $updateSQL2 = sprintf(
            "UPDATE `kids` SET `email`=%s WHERE `id`=%s",
            staff_sql($email, 'text'),
            staff_sql($kid['kid_id'], 'int')
        );
        mysqli_query($database, $updateSQL2);
    }
    // Refresh session user picture for same request chain
    if ($imageName !== '' && strcasecmp($imageName, 'null') !== 0) {
        $row_get_user['picture'] = $imageName;
    }
    header('Location: profile.php?done=1');
    exit;
}

function staff_profile_option($href, $label, $meta, $danger = false)
{
    $go = function_exists('staff_go') ? staff_go() : '›';
    $cls = 'settings__item' . ($danger ? ' settings__item--danger' : '');
    echo '<a class="' . $cls . '" href="' . staff_h($href) . '">';
    echo '<span class="prof-opt">';
    echo '<strong>' . staff_h($label) . '</strong>';
    if ($meta !== '') {
        echo '<small>' . staff_h($meta) . '</small>';
    }
    echo '</span>';
    echo '<span class="settings__go">' . $go . '</span>';
    echo '</a>';
}

function staff_ascendra_credit_url()
{
    $up = (function_exists('dual_in_kid_folder') && dual_in_kid_folder()) ? '../../' : '../';
    return $up . 'assets/img/ascendra-logo-black.png';
}

function staff_render_ascendra_credit()
{
    echo '<div class="ascendra-credit">';
    echo '<img class="ascendra-credit__logo" src="' . staff_h(staff_ascendra_credit_url()) . '" width="100" alt="Ascendra">';
    echo '<p class="ascendra-credit__text">POWERED BY</p>';
    echo '</div>';
}

function staff_render_profile_edit($field)
{
    global $L, $row_get_user, $displayName;
    $isEmail = ($field === 'email');
    $title = $isEmail ? $L['edit_email'] : $L['edit_name'];
    $value = $isEmail
        ? (string) ($row_get_user['email'] ?? '')
        : (string) ($row_get_user['name'] ?? $displayName);
    $inputName = $isEmail ? 'email' : 'name';
    $type = $isEmail ? 'email' : 'text';
    echo '<form class="card stack" action="profile.php?edit=' . ($isEmail ? 'email' : 'name') . '" method="post">';
    echo '<label class="field"><span class="field__label">' . staff_h($isEmail ? $L['field_email'] : $L['field_name']) . '</span>';
    echo '<input class="input" id="' . $inputName . '" name="' . $inputName . '" type="' . $type . '" value="' . staff_h($value) . '" required></label>';
    if ($isEmail) {
        echo '<input type="hidden" name="name" value="' . staff_h((string) ($row_get_user['name'] ?? $displayName)) . '">';
    } else {
        echo '<input type="hidden" name="email" value="' . staff_h((string) ($row_get_user['email'] ?? '')) . '">';
    }
    echo '<button class="btn btn--primary" name="submit" type="submit">' . staff_h($L['save_profile']) . '</button>';
    echo '</form>';
}

function staff_render_profile()
{
    global $L, $row_get_user, $photoUrl, $displayName, $empId;
    $edit = isset($_GET['edit']) ? (string) $_GET['edit'] : '';
    if ($edit === 'name' || $edit === 'email') {
        staff_render_profile_edit($edit);
        return;
    }
    $done = isset($_GET['done']);
    $canPic = (int) ($row_get_user['id'] ?? 0) !== 1;
    $email = (string) ($row_get_user['email'] ?? '');
    $name = (string) ($row_get_user['name'] ?? $displayName);
    $phone = (string) ($row_get_user['phone'] ?? '');
    $oldPic = trim((string) ($row_get_user['picture'] ?? ''));
    if (strcasecmp($oldPic, 'null') === 0) {
        $oldPic = '';
    }
    $emp = staff_profile_emp_row();
    $job = staff_profile_job_label($emp);
    $official = isset($emp['name']) ? trim((string) $emp['name']) : '';
    if ($official === '') {
        $official = $displayName;
    }
    $empPhone = '';
    foreach (array('phone', 'mobile', 'tel') as $col) {
        if (!empty($emp[$col]) && trim((string) $emp[$col]) !== '') {
            $empPhone = trim((string) $emp[$col]);
            break;
        }
    }
    if ($empPhone === '') {
        $empPhone = $phone;
    }
    $years = staff_profile_years();
    $showId = (int) ($emp['id'] ?? $empId);

    staff_banner($done);
    echo '<section class="prof">';
    echo '<div class="prof__id">';
    if ($canPic) {
        echo '<button class="prof__photo" type="button" data-photo-trigger aria-label="' . staff_h($L['change_photo']) . '">';
        echo '<img data-photo-img src="' . staff_h($photoUrl) . '" alt="">';
        echo '<span class="prof__edit">' . staff_ico('pencil') . '</span>';
        echo '</button>';
    } else {
        echo '<div class="prof__photo prof__photo--static">';
        echo '<img src="' . staff_h($photoUrl) . '" alt="">';
        echo '</div>';
    }
    echo '<h2 class="prof__name">' . staff_h($official) . '</h2>';
    if ($job !== '') {
        echo '<p class="prof__job">' . staff_h($job) . '</p>';
    }
    echo '</div>';

    echo '<div class="card prof-card">';
    echo '<p class="prof-card__kicker">' . staff_h($L['profile_school']) . '</p>';
    echo '<div class="prof-facts">';
    staff_profile_fact($L['profile_job'], $job);
    staff_profile_fact($L['field_phone'], $empPhone);
    staff_profile_fact($L['field_email'], $email);
    staff_profile_fact($L['profile_emp_id'], $showId > 0 ? (string) $showId : '');
    echo '</div>';
    if ($years) {
        echo '<p class="prof-card__label">' . staff_h($L['profile_years']) . '</p>';
        echo '<div class="prof-chips">';
        foreach ($years as $y) {
            echo '<span class="prof-chip">' . staff_h(staff_profile_year_name($y)) . '</span>';
        }
        echo '</div>';
    }
    echo '</div>';

    echo '<p class="prof-card__kicker prof-card__kicker--out">' . staff_h($L['profile_edit']) . '</p>';
    echo '<div class="settings">';
    staff_profile_option('profile.php?edit=name', $L['field_name'], staff_profile_dash($name));
    staff_profile_option('profile.php?edit=email', $L['field_email'], staff_profile_dash($email));
    if ($canPic) {
        echo '<button class="settings__item" type="button" data-photo-trigger>';
        echo '<span class="prof-opt"><strong>' . staff_h($L['change_photo']) . '</strong></span>';
        echo '<span class="settings__go">' . (function_exists('staff_go') ? staff_go() : '›') . '</span>';
        echo '</button>';
    }
    staff_profile_option('password.php?from=profile', $L['password'], '');
    echo '</div>';
    echo '<a class="btn btn--signout" href="emp-view.php?exit=1">' . staff_ico('logout') . '<span>' . staff_h($L['exit']) . '</span></a>';
    staff_render_ascendra_credit();

    if ($canPic) {
        echo '<form action="profile.php" method="post" enctype="multipart/form-data" hidden data-photo-save>';
        echo '<input type="file" id="picture" name="picture" accept="image/jpeg,image/png,image/gif,.jpg,.jpeg,.png,.gif" hidden data-photo-input>';
        echo '<input type="hidden" name="old_img" value="' . staff_h($oldPic) . '">';
        echo '<input type="hidden" name="name" value="' . staff_h($name) . '">';
        echo '<input type="hidden" name="email" value="' . staff_h($email) . '">';
        echo '<button type="submit" name="submit" value="1"></button>';
        echo '</form>';
    }
    echo '</section>';
}

function staff_boot_password()
{
    global $staffPreview, $database, $row_get_user;
    if (!isset($_POST['submit'])) {
        return;
    }
    if ($staffPreview) {
        header('Location: password.php?done=1');
        exit;
    }
    $pass = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $updateSQL = sprintf(
        "UPDATE `app_login` SET `password`=%s WHERE `id`=%s",
        staff_sql(strtolower(md5($pass)), 'text'),
        staff_sql($row_get_user['id'], 'int')
    );
    mysqli_query($database, $updateSQL);
    header('Location: password.php?done=1');
    exit;
}

function staff_render_password()
{
    global $L;
    staff_banner(isset($_GET['done']));
    echo '<form class="card stack" action="password.php" method="post">';
    echo '<label class="field"><span class="field__label">' . staff_h($L['password_label']) . '</span>';
    echo '<input class="input" id="password" name="password" type="text" required></label>';
    echo '<button class="btn btn--primary" name="submit" type="submit">' . staff_h($L['save_password']) . '</button>';
    echo '</form>';
}

function staff_boot_absence()
{
    global $database, $database_database, $row_get_user, $empId;
    if (!isset($_POST['start'])) {
        return;
    }
    $type = isset($_POST['type']) ? (int) $_POST['type'] : 1;
    $start = isset($_POST['start']) ? strtotime($_POST['start']) : 0;
    $end = isset($_POST['end']) ? strtotime($_POST['end']) : 0;
    $text = isset($_POST['text']) ? (string) $_POST['text'] : '';
    $from = isset($_POST['from']) ? (string) $_POST['from'] : '';
    $ret = isset($_POST['ret']) ? (string) $_POST['ret'] : '';
    $doneParts = array('done=1');
    if ($from !== '') {
        $doneParts[] = 'from=' . rawurlencode($from);
    }
    if ($ret !== '') {
        $doneParts[] = 'ret=' . rawurlencode($ret);
    }
    $doneQs = implode('&', $doneParts);
    if (staff_vac_store_mode()) {
        $rows = staff_preview_vacs();
        $max = 0;
        foreach ($rows as $r) {
            $max = max($max, (int) $r['id']);
        }
        $newRow = array(
            'id' => $max + 1,
            'emp_id' => (int) ($row_get_user['emp_id'] ?? 0),
            'type' => $type,
            'vacation_start' => $start,
            'vacation_end' => $end,
            'text' => $text,
            'sick_note' => !empty($_FILES['sick_note']['name']) ? 'preview' : null,
            'status' => 0,
            'date' => time(),
        );
        $rows[] = $newRow;
        $_SESSION['staff_preview_vacs'] = $rows;
        staff_vac_push_approval_queue($newRow);
        header('Location: my-absence.php?' . $doneQs);
        exit;
    }
    $imageName = staff_upload_sick_note();
    $insertSQL = sprintf(
        "INSERT INTO `emps_vacations` (`emp_id`, `type`, `vacation_start`, `vacation_end`, `text`, `sick_note`, `date`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
        staff_sql($row_get_user['emp_id'], 'int'),
        staff_sql($type, 'int'),
        staff_sql($start, 'int'),
        staff_sql($end, 'int'),
        staff_sql($text, 'text'),
        staff_sql($imageName, 'text'),
        staff_sql(time(), 'int')
    );
    mysqli_select_db($database, $database_database);
    mysqli_query($database, $insertSQL);
    $who = function_exists('emp_name') ? emp_name($empId) : (string) ($row_get_user['name'] ?? '');
    staff_notify_emps('app4', date('d/m/Y') . ' طلب اجازة مقدم من  ' . $who);
    header('Location: my-absence.php');
    exit;
}

function staff_absence_rows($pending)
{
    global $row_get_user;
    if (staff_vac_store_mode()) {
        $out = array();
        foreach (staff_preview_vacs() as $row) {
            $isPend = ((int) $row['status'] === 0);
            if ($pending === $isPend) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $emp = (int) $row_get_user['emp_id'];
    $op = $pending ? '=' : '!=';
    return staff_fetch("SELECT * FROM `emps_vacations` WHERE `emp_id` = '{$emp}' AND `status` {$op} 0");
}

function staff_absence_one($id)
{
    global $row_get_user;
    $id = (int) $id;
    if (staff_vac_store_mode()) {
        foreach (staff_preview_vacs() as $row) {
            if ((int) $row['id'] === $id) {
                return $row;
            }
        }
        return null;
    }
    $emp = (int) $row_get_user['emp_id'];
    $rows = staff_fetch("SELECT * FROM `emps_vacations` WHERE `emp_id` = '{$emp}' AND `id` = '{$id}'");
    return $rows ? $rows[0] : null;
}

function staff_render_absence_list()
{
    global $L;
    $pending = staff_absence_rows(true);
    $settled = staff_absence_rows(false);
    staff_banner(isset($_GET['done']));
    $newParts = array('new=1');
    if (isset($_GET['from']) && $_GET['from'] !== '') {
        $newParts[] = 'from=' . rawurlencode((string) $_GET['from']);
    }
    if (isset($_GET['ret']) && $_GET['ret'] !== '') {
        $newParts[] = 'ret=' . rawurlencode((string) $_GET['ret']);
    }
    $newHref = 'my-absence.php?' . implode('&', $newParts);
    echo '<a class="btn btn--primary" href="' . staff_h($newHref) . '">' . staff_h($L['submit_vacation']) . '</a>';
    if ($pending) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['vac_not_settled']) . '</h2></div>';
        echo '<div class="rows">';
        foreach ($pending as $row) {
            staff_absence_row($row);
        }
        echo '</div>';
    }
    if ($settled) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['vac_settled']) . '</h2></div>';
        echo '<div class="rows">';
        foreach ($settled as $row) {
            staff_absence_row($row);
        }
        echo '</div>';
    }
    if (!$pending && !$settled) {
        echo '<div class="empty"><p>' . staff_h($L['empty_list']) . '</p></div>';
    }
}

function staff_absence_row($row)
{
    global $L;
    $tone = staff_vac_tone($row['status']);
    echo '<a class="row ' . $tone . '" href="my-absence.php?id=' . (int) $row['id'] . '">';
    echo '<span class="row__ico">' . staff_ico('calendar') . '</span>';
    echo '<div class="row__body">';
    echo '<p class="row__title">' . staff_h(date('d/m/Y', (int) $row['vacation_start'])) . '</p>';
    echo '<p class="row__meta">' . staff_h(staff_vac_days($row['vacation_start'], $row['vacation_end'])) . ' · ' . staff_h($L['type_prefix'] . ' ' . staff_vac_type($row['type'])) . '</p>';
    echo '</div>';
    echo '<span class="row__go">' . staff_go() . '</span>';
    echo '</a>';
}

function staff_render_absence_form()
{
    global $L;
    $from = isset($_GET['from']) ? (string) $_GET['from'] : '';
    $ret = isset($_GET['ret']) ? (string) $_GET['ret'] : '';
    $formParts = array();
    if ($from !== '') {
        $formParts[] = 'from=' . rawurlencode($from);
    }
    if ($ret !== '') {
        $formParts[] = 'ret=' . rawurlencode($ret);
    }
    $formAction = 'my-absence.php' . ($formParts ? ('?' . implode('&', $formParts)) : '');
    echo '<form class="card stack" action="' . staff_h($formAction) . '" method="post" enctype="multipart/form-data" id="form1">';
    if ($from !== '') {
        echo '<input type="hidden" name="from" value="' . staff_h($from) . '">';
    }
    if ($ret !== '') {
        echo '<input type="hidden" name="ret" value="' . staff_h($ret) . '">';
    }
    echo '<p class="muted">' . staff_h($L['submit_vacation']) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['vac_start']) . '</span>';
    echo '<input class="input" type="date" name="start" id="datepicker-input1" required data-vac-start></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['vac_end']) . '</span>';
    echo '<input class="input" type="date" name="end" id="datepicker-input2" required data-vac-end>';
    echo '<span class="tiny">' . staff_h($L['vac_return_hint']) . '</span></label>';
    echo '<p class="staff-count">' . staff_h($L['days_label']) . ' <strong data-vac-days>0</strong></p>';
    echo '<fieldset class="radios"><legend class="field__label">' . staff_h($L['type_label']) . '</legend>';
    for ($i = 1; $i <= 8; $i++) {
        $chk = ($i === 1) ? ' checked' : '';
        echo '<label class="radio"><input type="radio" name="type" value="' . $i . '"' . $chk . '><span>' . staff_h($L['vac_' . $i]) . '</span></label>';
    }
    echo '</fieldset>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['attach']) . '</span>';
    echo '<input class="input" id="sick_note" name="sick_note" type="file"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['brief']) . '</span>';
    echo '<textarea class="input" id="textarea-prefix" name="text" required></textarea></label>';
    echo '<button class="btn btn--primary" name="submit" id="submit" type="submit" disabled data-vac-submit>' . staff_h($L['submit_vac_btn']) . '</button>';
    echo '</form>';
}

function staff_render_absence_view($row)
{
    global $L;
    if (!$row) {
        echo '<div class="empty"><p>' . staff_h($L['not_found']) . '</p></div>';
        return;
    }
    $tone = staff_vac_tone($row['status']);
    echo '<div class="card stack">';
    echo '<p class="staff-status ' . $tone . '">' . staff_h(staff_vac_status($row['status'])) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['vac_start']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(date('d/m/Y', (int) $row['vacation_start'])) . '"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['vac_end']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(date('d/m/Y', (int) $row['vacation_end'])) . '">';
    echo '<span class="tiny">' . staff_h($L['vac_return_hint']) . '</span></label>';
    echo '<p class="staff-count">' . staff_h(staff_vac_days($row['vacation_start'], $row['vacation_end'])) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['type_label']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(staff_vac_type($row['type'])) . '"></label>';
    if (!empty($row['sick_note'])) {
        echo '<p class="muted">' . staff_h($L['attached']) . ': ' . staff_h($L['uploaded']) . '</p>';
    }
    echo '<label class="field"><span class="field__label">' . staff_h($L['brief']) . '</span>';
    echo '<textarea class="input" readonly>' . staff_h($row['text']) . '</textarea></label>';
    echo '</div>';
}

function staff_render_absence()
{
    if (isset($_GET['new'])) {
        staff_render_absence_form();
        return;
    }
    if (isset($_GET['id'])) {
        staff_render_absence_view(staff_absence_one($_GET['id']));
        return;
    }
    staff_render_absence_list();
}

function staff_boot_excuse()
{
    global $staffPreview, $database, $database_database, $row_get_user, $empId;
    if (!isset($_POST['start'])) {
        return;
    }
    $startRaw = (string) $_POST['start'];
    $endRaw = isset($_POST['end']) ? (string) $_POST['end'] : '';
    $dateTs = isset($_POST['date']) ? strtotime($_POST['date']) : 0;
    $text = isset($_POST['text']) ? (string) $_POST['text'] : '';
    $startClock = strtotime($startRaw);
    $endClock = strtotime($endRaw);
    $hours = 0;
    if ($startClock > 0 && $endClock > 0) {
        $hours = gmdate('H:i', $endClock - $startClock);
    }
    $startStore = strtotime('1/1/2000 ' . $startRaw);
    $endStore = ($endRaw !== '') ? strtotime('1/1/2000 ' . $endRaw) : '';
    if (staff_vac_store_mode()) {
        if (!($hours > 0)) {
            header('Location: my-excuse.php?new=1');
            exit;
        }
        $rows = staff_preview_excuses();
        $max = 0;
        foreach ($rows as $r) {
            $max = max($max, (int) $r['id']);
        }
        $rows[] = array(
            'id' => $max + 1,
            'start' => $startStore,
            'end' => $endStore,
            'hours' => $hours,
            'text' => $text,
            'status' => 0,
            'date' => $dateTs,
        );
        $_SESSION['staff_preview_excuses'] = $rows;
        header('Location: my-excuse.php?done=1');
        exit;
    }
    if (!($hours > 0)) {
        return;
    }
    $insertSQL = sprintf(
        "INSERT INTO `emps_excuse` (`emp_id`, `start`, `end`, `hours`, `text`, `date`) VALUES (%s, %s, %s, %s, %s, %s)",
        staff_sql($row_get_user['emp_id'], 'int'),
        staff_sql($startStore, 'int'),
        staff_sql($endStore, 'int'),
        staff_sql($hours, 'text'),
        staff_sql($text, 'text'),
        staff_sql($dateTs, 'int')
    );
    mysqli_select_db($database, $database_database);
    mysqli_query($database, $insertSQL);
    $who = function_exists('emp_name') ? emp_name($empId) : (string) ($row_get_user['name'] ?? '');
    staff_notify_emps('app5', date('d/m/Y') . ' طلب اذن مقدم من  ' . $who);
    header('Location: my-excuse.php');
    exit;
}

function staff_excuse_rows($pending)
{
    global $row_get_user;
    if (staff_vac_store_mode()) {
        $out = array();
        foreach (staff_preview_excuses() as $row) {
            $isPend = ((int) $row['status'] === 0);
            if ($pending === $isPend) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $emp = (int) $row_get_user['emp_id'];
    $op = $pending ? '=' : '!=';
    return staff_fetch("SELECT * FROM `emps_excuse` WHERE `emp_id` = '{$emp}' AND `status` {$op} 0");
}

function staff_excuse_one($id)
{
    global $row_get_user;
    $id = (int) $id;
    if (staff_vac_store_mode()) {
        foreach (staff_preview_excuses() as $row) {
            if ((int) $row['id'] === $id) {
                return $row;
            }
        }
        return null;
    }
    $emp = (int) $row_get_user['emp_id'];
    $rows = staff_fetch("SELECT * FROM `emps_excuse` WHERE `emp_id` = '{$emp}' AND `id` = '{$id}'");
    return $rows ? $rows[0] : null;
}

function staff_excuse_row($row)
{
    echo '<a class="row ' . staff_vac_tone($row['status']) . '" href="my-excuse.php?id=' . (int) $row['id'] . '">';
    echo '<span class="row__ico">' . staff_ico('hourglass') . '</span>';
    echo '<div class="row__body">';
    echo '<p class="row__title">' . staff_h(date('d/m/Y', (int) $row['date'])) . '</p>';
    echo '<p class="row__meta">' . staff_h(staff_exc_time($row['start'], $row['end'])) . '</p>';
    echo '</div>';
    echo '<span class="row__go">' . staff_go() . '</span>';
    echo '</a>';
}

function staff_render_excuse_list()
{
    global $L;
    $pending = staff_excuse_rows(true);
    $settled = staff_excuse_rows(false);
    staff_banner(isset($_GET['done']));
    echo '<a class="btn btn--primary" href="my-excuse.php?new=1">' . staff_h($L['submit_excuse']) . '</a>';
    if ($pending) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['pending_excuses']) . '</h2></div>';
        echo '<div class="rows">';
        foreach ($pending as $row) {
            staff_excuse_row($row);
        }
        echo '</div>';
    }
    if ($settled) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($L['excuses_settled']) . '</h2></div>';
        echo '<div class="rows">';
        foreach ($settled as $row) {
            staff_excuse_row($row);
        }
        echo '</div>';
    }
    if (!$pending && !$settled) {
        echo '<div class="empty"><p>' . staff_h($L['empty_list']) . '</p></div>';
    }
}

function staff_render_excuse_form()
{
    global $L;
    echo '<form class="card stack" action="my-excuse.php" method="post" id="form1">';
    echo '<p class="muted">' . staff_h($L['submit_excuse']) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_date']) . '</span>';
    echo '<input class="input" type="date" name="date" id="datepicker-input1" required></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_start']) . '</span>';
    echo '<input class="input" type="time" name="start" id="timepicker-input1" required data-exc-start></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_return']) . '</span>';
    echo '<input class="input" type="time" name="end" id="timepicker-input2" data-exc-end></label>';
    echo '<p class="staff-count">' . staff_h($L['hours_label']) . ' <strong data-exc-hours>0</strong></p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['brief']) . '</span>';
    echo '<textarea class="input" name="text" required></textarea></label>';
    echo '<button class="btn btn--primary" name="submit" type="submit">' . staff_h($L['submit_exc_btn']) . '</button>';
    echo '</form>';
}

function staff_render_excuse_view($row)
{
    global $L;
    if (!$row) {
        echo '<div class="empty"><p>' . staff_h($L['not_found']) . '</p></div>';
        return;
    }
    echo '<div class="card stack">';
    echo '<p class="staff-status ' . staff_vac_tone($row['status']) . '">' . staff_h(staff_vac_status($row['status'])) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_date']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(date('d/m/Y', (int) $row['date'])) . '"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_start']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(date('h:i a', (int) $row['start'])) . '"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['excuse_return']) . '</span>';
    echo '<input class="input" type="text" readonly value="' . staff_h(date('h:i a', (int) $row['end'])) . '"></label>';
    echo '<p class="staff-count">' . staff_h($L['hours_word']) . ': ' . staff_h($row['hours']) . '</p>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['brief']) . '</span>';
    echo '<textarea class="input" readonly>' . staff_h($row['text']) . '</textarea></label>';
    echo '</div>';
}

function staff_render_excuse()
{
    if (isset($_GET['new'])) {
        staff_render_excuse_form();
        return;
    }
    if (isset($_GET['id'])) {
        staff_render_excuse_view(staff_excuse_one($_GET['id']));
        return;
    }
    staff_render_excuse_list();
}

function staff_attendance_back_href()
{
    if (isset($_GET['from']) && $_GET['from'] === 'checkin') {
        return 'emp-checkin.php';
    }
    return staff_profile_href();
}

function staff_att_store_mode()
{
    global $staffPreview, $staffSnapshot;
    return !empty($staffPreview) || !empty($staffSnapshot);
}

function staff_att_range()
{
    if (isset($_POST['submit'])) {
        $start = strtotime((string) $_POST['from']);
        $end = strtotime((string) $_POST['to']);
        if ($start > 0 && $end > 0 && $end < $start) {
            $tmp = $start;
            $start = $end;
            $end = $tmp;
        }
        return array($start, $end);
    }
    $start = strtotime(date('Y-m-01'));
    $end = strtotime(date('Y-m-t'));
    return array($start, $end);
}

function staff_att_sample_rows()
{
    $base = strtotime(date('Y-m-d'));
    return array(
        array('date' => $base, 'sign_in' => $base + (7 * 3600) + (45 * 60), 'sign_out' => $base + (15 * 3600) + (30 * 60), 'late_in' => 0, 'late_out' => 0, 'absent' => 0, 'exception' => 0),
        array('date' => $base - 86400, 'sign_in' => $base - 86400 + (8 * 3600) + (10 * 60), 'sign_out' => $base - 86400 + (15 * 3600), 'late_in' => 600, 'late_out' => 0, 'absent' => 0, 'exception' => 0),
        array('date' => $base - (2 * 86400), 'sign_in' => null, 'sign_out' => null, 'late_in' => 0, 'late_out' => 0, 'absent' => 1, 'exception' => 0),
        array('date' => $base - (3 * 86400), 'sign_in' => $base - (3 * 86400) + (7 * 3600) + (50 * 60), 'sign_out' => $base - (3 * 86400) + (14 * 3600) + (40 * 60), 'late_in' => 0, 'late_out' => 1200, 'absent' => 0, 'exception' => 0),
    );
}

function staff_att_rows($start, $end)
{
    global $row_get_user;
    if (staff_att_store_mode()) {
        $out = array();
        foreach (staff_att_sample_rows() as $row) {
            if ((int) $row['date'] >= $start && (int) $row['date'] <= $end) {
                $out[] = $row;
            }
        }
        usort($out, function ($a, $b) {
            return (int) $b['date'] - (int) $a['date'];
        });
        return $out;
    }
    $emp = (int) $row_get_user['emp_id'];
    $s = (int) $start;
    $e = (int) $end;
    $rows = staff_fetch("SELECT * FROM `attendance_log` WHERE `emp_id` = '{$emp}' AND `date`>='{$s}' AND `date`<='{$e}' ORDER BY `date` DESC");
    return $rows;
}

function staff_att_is_absent($row)
{
    return ((int) $row['absent'] === 1 && (int) $row['exception'] === 0);
}

function staff_att_clock_in($row)
{
    if (staff_att_is_absent($row) || $row['sign_in'] === null || $row['sign_in'] === '') {
        return '-';
    }
    return date('H:i', (int) $row['sign_in']);
}

function staff_att_clock_out($row)
{
    if (staff_att_is_absent($row) || $row['sign_out'] === null || $row['sign_out'] === '') {
        return '-';
    }
    return date('H:i', (int) $row['sign_out']);
}

function staff_att_duration($seconds)
{
    if ((int) $seconds <= 0) {
        return '00:00';
    }
    return gmdate('H:i', (int) $seconds);
}

function staff_render_attendance()
{
    global $L;
    $fromCheckin = (isset($_GET['from']) && $_GET['from'] === 'checkin');
    list($start, $end) = staff_att_range();
    $rows = staff_att_rows($start, $end);
    $formAction = 'my-attendance.php' . ($fromCheckin ? '?from=checkin' : '');
    echo '<p class="lede staff-lede">' . staff_h($L['att_lede']) . '</p>';
    echo '<form class="card stack" method="post" action="' . staff_h($formAction) . '">';
    if ($fromCheckin) {
        echo '<input type="hidden" name="from" value="checkin">';
    }
    echo '<div class="staff-dates">';
    echo '<label class="field"><span class="field__label">' . staff_h($L['att_from']) . '</span>';
    echo '<input class="input" type="date" name="from" value="' . staff_h(date('Y-m-d', $start)) . '" required></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($L['att_to']) . '</span>';
    echo '<input class="input" type="date" name="to" value="' . staff_h(date('Y-m-d', $end)) . '" required></label>';
    echo '</div>';
    echo '<button class="btn btn--primary" type="submit" name="submit">' . staff_h($L['att_submit']) . '</button>';
    echo '</form>';
    if (!$rows) {
        echo '<div class="empty"><p>' . staff_h($L['empty_list']) . '</p></div>';
    } else {
    echo '<div class="att-list">';
    foreach ($rows as $row) {
        $absent = staff_att_is_absent($row);
        $in = staff_att_clock_in($row);
        $out = staff_att_clock_out($row);
        $delay = $absent ? '' : staff_att_duration($row['late_in']);
        $early = $absent ? '' : staff_att_duration($row['late_out']);
        $tone = $absent ? ' att-card--absent' : '';
        if (!$absent && ((int) $row['late_in'] > 0 || (int) $row['late_out'] > 0)) {
            $tone = ' att-card--warn';
        }
        echo '<article class="att-card' . $tone . '">';
        echo '<header class="att-card__head">';
        echo '<p class="att-card__date">' . staff_h(date('d/m/Y', (int) $row['date'])) . '</p>';
        if ($absent) {
            echo '<span class="att-card__badge">' . staff_h($L['att_absent']) . '</span>';
        }
        echo '</header>';
        echo '<div class="att-card__facts">';
        echo '<div' . ($absent ? ' class="is-bad"' : '') . '><span>' . staff_h($L['att_in']) . '</span><b>' . staff_h($in) . '</b></div>';
        echo '<div' . ($absent ? ' class="is-bad"' : '') . '><span>' . staff_h($L['att_out']) . '</span><b>' . staff_h($out) . '</b></div>';
        echo '<div' . (!$absent && (int) $row['late_in'] > 0 ? ' class="is-bad"' : '') . '><span>' . staff_h($L['att_delay']) . '</span><b>' . staff_h($delay) . '</b></div>';
        echo '<div' . (!$absent && (int) $row['late_out'] > 0 ? ' class="is-bad"' : '') . '><span>' . staff_h($L['att_early']) . '</span><b>' . staff_h($early) . '</b></div>';
        echo '</div></article>';
    }
    echo '</div>';
    }
    staff_render_my_absence_link('attendance', $fromCheckin ? 'checkin' : '');
}
