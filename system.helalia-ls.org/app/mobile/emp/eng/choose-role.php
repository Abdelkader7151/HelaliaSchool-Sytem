<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/dual-ui.php';
if (empty($dualKids) && !(function_exists('dual_is_manual_dual') && dual_is_manual_dual())) {
    header('Location: emp-view.php');
    exit;
}
// Always re-open chooser cleanly (app reopen / Switch role).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (function_exists('dual_clear_role_pick')) {
        dual_clear_role_pick();
    } else {
        unset($_SESSION['helalia_role']);
    }
    if (function_exists('dual_restore_emp_session_for_staff_boot')) {
        dual_restore_emp_session_for_staff_boot();
    }
}
dual_role_handle_post();
dual_render_choose();
