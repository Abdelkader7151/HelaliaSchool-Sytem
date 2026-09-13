<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

$user = current_user();
if ($user && is_portal_user($user)) {
    redirect(portal_home_url($user));
}

$err = $_GET['err'] ?? '';
$msg = '';
if ($err === '1') {
    $msg = t('err_login');
} elseif ($err === '2' || $err === 'inactive') {
    $msg = t('err_inactive');
} elseif ($err === 'staff') {
    $msg = t('err_staff');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $plain = (string) ($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);
    if (isset($_POST['lang']) && in_array($_POST['lang'], ['eng', 'arb'], true)) {
        $_SESSION['lang'] = $_POST['lang'];
    }
    if ($phone === '' || $plain === '') {
        redirect('login.php?err=1');
    }
    $hash = password_hash_app($plain);
    $row = db_one(
        'SELECT `id`, `phone`, `name`, `email`, `picture`, `account_type`, `active` FROM `app_login` WHERE `phone` = ? AND `password` = ? LIMIT 1',
        'ss',
        [$phone, $hash]
    );
    if (!$row) {
        redirect('login.php?err=1');
    }
    if ((int) $row['active'] !== 1) {
        redirect('login.php?err=2');
    }
    if (!is_portal_user($row)) {
        redirect('login.php?err=staff');
    }
    start_parent_session($row);
    set_remember_cookies($phone, $hash, $remember);
    redirect(portal_home_url($row));
}

$bg = '/assets/media/sliders/1724071808i1lGMKhW6z.jpg';
$logo = '/assets/media/logo.png';

portal_head(t('login_title'), ' login-page');
?>
<div class="auth">
  <div class="auth__hero">
    <img class="auth__hero-img" src="<?php echo h($bg); ?>" alt="<?php echo h(t('school_name')); ?>">
  </div>
  <div class="auth__bar">
    <a class="auth__back" href="https://helalia-ls.org/" aria-label="<?php echo h(t('back_site')); ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19 8 12l7-7"/></svg>
    </a>
    <a class="auth__lang" href="<?php echo h(switch_lang_url()); ?>"><?php echo h(t('language')); ?></a>
  </div>
  <div class="auth__stage">
    <div class="auth__brand">
      <img class="auth__logo" src="<?php echo h($logo); ?>" alt="">
      <h1 class="auth__name"><?php echo h(t('school_name')); ?></h1>
      <p class="auth__tag"><?php echo h(t('login_title')); ?></p>
    </div>
    <form class="auth__form" method="post" action="login.php" autocomplete="on">
      <input type="hidden" name="lang" value="<?php echo h(lang()); ?>">
      <p class="auth__err<?php echo $msg !== '' ? ' is-on' : ''; ?>" role="alert"><?php echo h($msg); ?></p>
      <label class="field"><span><?php echo h(t('phone')); ?></span>
        <input class="auth-input" type="text" name="phone" autocomplete="username" placeholder="test or 01xxxxxxxxx" required>
      </label>
      <label class="field"><span><?php echo h(t('password')); ?></span>
        <input class="auth-input" type="password" name="password" autocomplete="current-password" placeholder="••••••••" required>
      </label>
      <label class="check auth-check"><input type="checkbox" name="remember" value="1" checked> <?php echo h(t('remember')); ?></label>
      <button class="btn btn-sun btn-block auth-go" type="submit"><?php echo h(t('sign_in')); ?></button>
    </form>
  </div>
</div>
</body>
</html>
<?php
exit;
