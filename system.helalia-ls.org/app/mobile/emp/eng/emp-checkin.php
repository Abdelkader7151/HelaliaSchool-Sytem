<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/attendance-ui.php';
staff_inner($L['checkin'], 'emp-view.php', 'checkin');
staff_render_checkin();
staff_inner_end('checkin');
