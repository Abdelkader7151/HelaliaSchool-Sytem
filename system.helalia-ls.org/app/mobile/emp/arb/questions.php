<?php

$staffLang = 'arb';

require dirname(__DIR__) . '/includes/staff.php';

require dirname(__DIR__) . '/includes/staff-questions.php';

staff_q_boot();

staff_inner($L['q_title'], 'emp-view.php');

staff_q_render_dock();

staff_q_render_list();

staff_inner_end();

