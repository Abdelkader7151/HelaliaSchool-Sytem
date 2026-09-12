<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
require_once dirname(__DIR__) . '/includes/staff-choices.php';
staff_inner($L['nav_choices'], 'emp-view.php', 'choices');
staff_render_choices();
staff_inner_end('choices');
