<?php
$staffLang = 'arb';
require dirname(__DIR__) . '/includes/staff.php';
staff_head($L['settings'], 'rtl', $css, $icon);
$meta = trim((string) ($row_get_user['phone'] ?? '') . ($jobLabel !== '' ? ' · ' . $jobLabel : ''));
staff_hero($L['settings'], false, $meta, false);
?>
<main class="page page--staff">
  <div class="settings">
    <a class="settings__item" href="<?php echo staff_h(staff_home_href()); ?>"><span><?php echo staff_h(dual_is_parent_mode() ? $L['parent_home'] : $L['home_title']); ?></span><span class="settings__go">‹</span></a>
    <?php if (dual_has_dual()) { ?>
    <a class="settings__item" href="choose-role.php?fresh=1"><span><?php echo staff_h($L['role_switch']); ?></span><span class="settings__go">‹</span></a>
    <?php } ?>
    <a class="settings__item" href="profile.php"><span><?php echo staff_h($L['profile']); ?></span><span class="settings__go">‹</span></a>
    <a class="settings__item" href="my-absence.php"><span><?php echo staff_h($L['my_absence']); ?></span><span class="settings__go">‹</span></a>
    <a class="settings__item" href="my-excuse.php"><span><?php echo staff_h($L['my_excuse']); ?></span><span class="settings__go">‹</span></a>
    <a class="settings__item" href="my-attendance.php"><span><?php echo staff_h($L['my_attendance']); ?></span><span class="settings__go">‹</span></a>
    <a class="settings__item" href="password.php"><span><?php echo staff_h($L['password']); ?></span><span class="settings__go">‹</span></a>
    <a class="settings__item" href="emp-view.php?exit=1"><span><?php echo staff_h($L['exit']); ?></span><span class="settings__go">‹</span></a>
  </div>
</main>
<?php staff_nav('settings', $L, $old, $showQuestions, $showNotify); ?>
