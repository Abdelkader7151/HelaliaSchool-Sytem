<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}
require_once dirname(__DIR__) . '/staff.php';
require_once dirname(__DIR__) . '/services.php';

$page = basename($_SERVER['PHP_SELF']);
$from = isset($_GET['from']) ? $_GET['from'] : (($page === 'questions-reply.php') ? 'reply' : 'direct');

if ($page === 'questions-direct.php' && !svc_can('app2_access') && empty($showDirectQ)) {
    svc_go('emp-view.php');
}
if ($page === 'questions-reply.php' && !svc_can('app7_access') && !svc_can('app14access') && empty($showReplyQ)) {
    svc_go('emp-view.php');
}

if ($page === 'questions-view.php') {
    $id = svc_int('id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit2'])) {
        svc_save_reply($id, isset($_POST['reply']) ? $_POST['reply'] : '');
        $back = ($from === 'reply') ? 'questions-reply.php' : 'questions-direct.php';
        svc_go($back);
    }
    $q = svc_question($id);
    $back = ($from === 'reply') ? 'questions-reply.php' : 'questions-direct.php';
    svc_boot($S['ask_title'], $back);
    if (!$q) {
        svc_empty();
        staff_inner_end();
        return;
    }
    $kid = svc_kid_row($q['kid_id']);
    $classId = $kid ? (int) $kid['class'] : 0;
    $status = ((int) $q['status'] === 1) ? $S['replied'] : $S['pending'];
    $facts = array(
        $S['status'] => $status,
        $S['date'] => date('d/m/Y h:i A', (int) $q['date']),
        $S['parent'] => svc_parent_name($q['user_id']),
        $S['student'] => svc_kid_name($q['kid_id']),
        $S['grade'] => svc_year($q['study_year']),
        $S['class'] => $classId ? svc_class_name($classId) : '',
        $S['subject'] => svc_subject($q['subject']),
        $S['question'] => $q['text'],
    );
    if (!empty($q['teacher_id']) || (isset($q['teacher_id']) && $q['teacher_id'] === 0 && $q['reply'])) {
        $facts[$S['teacher']] = svc_emp_name($q['teacher_id']);
    }
    if (!empty($q['respond'])) {
        $facts[$S['respond']] = date('d/m/Y h:i A', (int) $q['respond']);
    }
    if (!empty($q['director_id'])) {
        $facts[$S['director']] = svc_emp_name($q['director_id']);
    }
    echo '<div class="svc-facts">';
    foreach ($facts as $k => $v) {
        echo '<div class="svc-fact"><b>' . staff_h($k) . '</b><span>' . staff_h($v) . '</span></div>';
    }
    echo '</div>';
    $canEdit = empty($q['reply']) || svc_can('app20access_edit');
    if (!$canEdit) {
        echo '<div class="svc-sub svc-fact"><b>' . staff_h($S['reply']) . '</b><span>' . staff_h($q['reply']) . '</span></div>';
    } else {
        echo '<form class="stack svc-sub" method="post" action="questions-view.php?id=' . $id . '&from=' . staff_h($from) . '">';
        echo '<label class="field"><span class="field__label">' . staff_h($S['reply']) . '</span>';
        echo '<textarea class="input" name="reply" required>' . staff_h($q['reply']) . '</textarea></label>';
        echo '<input type="hidden" name="q_id" value="' . $id . '">';
        echo '<button class="btn btn--primary" name="submit2" type="submit">' . staff_h($S['save']) . '</button>';
        echo '</form>';
    }
    staff_inner_end();
    return;
}

if ($page === 'questions-reply.php') {
    svc_boot($S['reply_title']);
    $open = svc_questions_unreplied();
    echo '<div class="sec"><h2 class="sec__title">' . staff_h($S['unreplied']) . '</h2></div>';
    if (!$open) {
        svc_empty();
    } else {
        echo '<div class="rows">';
        foreach ($open as $q) {
            $meta = svc_subject($q['subject']) . ' · ' . svc_year($q['study_year']);
            svc_row('questions-view.php?id=' . (int) $q['id'] . '&from=reply', svc_parent_name($q['user_id']), $meta . ' · ' . date('d/m/Y', (int) $q['date']), null, 't-coral', 'chat');
        }
        echo '</div>';
    }
    $done = svc_questions_replied();
    echo '<div class="sec svc-sub"><h2 class="sec__title">' . staff_h($S['replied_list']) . '</h2></div>';
    if (!$done) {
        svc_empty();
    } else {
        echo '<div class="rows">';
        foreach ($done as $q) {
            $meta = svc_subject($q['subject']) . ' · ' . svc_year($q['study_year']);
            svc_row('questions-view.php?id=' . (int) $q['id'] . '&from=reply', svc_parent_name($q['user_id']), $meta . ' · ' . date('d/m/Y', (int) $q['date']), null, 't-navy', 'check');
        }
        echo '</div>';
    }
    staff_inner_end();
    return;
}

svc_boot($S['direct_title']);
$rows = svc_questions_direct();
if (!$rows) {
    svc_empty();
} else {
    echo '<div class="rows">';
    foreach ($rows as $q) {
        $meta = svc_subject($q['subject']) . ' · ' . svc_year($q['study_year']) . ' · ' . date('d/m/Y h:i A', (int) $q['date']);
        svc_row('questions-view.php?id=' . (int) $q['id'] . '&from=direct', svc_parent_name($q['user_id']), $meta, null, 't-coral', 'chat');
    }
    echo '</div>';
}
staff_inner_end();
