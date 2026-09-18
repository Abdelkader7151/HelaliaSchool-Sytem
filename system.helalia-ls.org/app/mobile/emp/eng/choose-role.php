<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/dual-ui.php';
if (empty($dualKids) && !(function_exists('dual_is_manual_dual') && dual_is_manual_dual())) {
    header('Location: emp-view.php');
    exit;
}
// Clear pick only on ?fresh=1 / exit — accidental GET keeps mid-session role
if (function_exists('dual_choose_role_prepare')) {
    dual_choose_role_prepare();
}
dual_role_handle_post();
dual_render_choose();
