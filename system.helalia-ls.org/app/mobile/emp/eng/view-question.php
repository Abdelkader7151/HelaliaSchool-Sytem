<?php

$staffLang = 'eng';

require dirname(__DIR__) . '/includes/staff.php';

require dirname(__DIR__) . '/includes/staff-questions.php';

staff_q_boot();

staff_q_handle_post();

staff_inner($L['q_title'], 'questions.php', 'questions');

staff_q_render_view();

staff_inner_end('questions');

