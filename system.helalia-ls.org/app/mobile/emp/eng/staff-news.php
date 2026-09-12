<?php
$staffLang = 'eng';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-timeline.php';
staff_inner($L['nav_news'], staff_nav_path('emp-view.php'), 'home');
staff_timeline_render_list();
staff_inner_end('home');
