<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
staff_head($L['home_title'], 'rtl', $css, $icon);
staff_hero($L['home_title'], true, '', true);
?>
<main class="page page--staff page--fab">
<?php staff_home_dashboard(); ?>
</main>
<?php staff_nav('home', $L, $old, $showQuestions, $showNotify); ?>
