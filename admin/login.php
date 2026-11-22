<?php
require_once __DIR__.'/../config.php';
if (admin_logged_in()) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $now = time();
    $windowStart = (int)($_SESSION['admin_attempt_window'] ?? $now);
    $attempts = (int)($_SESSION['admin_attempts'] ?? 0);
    if ($now - $windowStart > 900) { $windowStart = $now; $attempts = 0; }
    if ($attempts >= 5) {
        $error = 'Too many login attempts. Please wait 15 minutes and try again.';
    } else {
        try {
            $stmt = db()->prepare('SELECT id,username,password_hash FROM admins WHERE username=? LIMIT 1');
            $stmt->execute([trim($_POST['username'] ?? '')]);
            $admin = $stmt->fetch();
            if ($admin && password_verify((string)($_POST['password'] ?? ''), $admin['password_hash'])) {
                if (password_needs_rehash($admin['password_hash'], PASSWORD_DEFAULT)) {
                    $rehash = db()->prepare('UPDATE admins SET password_hash=? WHERE id=?');
                    $rehash->execute([password_hash((string)$_POST['password'], PASSWORD_DEFAULT), $admin['id']]);
                }
                session_regenerate_id(true);
                $_SESSION['admin_id'] = (int)$admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                unset($_SESSION['admin_attempts'], $_SESSION['admin_attempt_window']);
                header('Location: index.php'); exit;
            }
            $_SESSION['admin_attempt_window'] = $windowStart;
            $_SESSION['admin_attempts'] = $attempts + 1;
            $error = 'Incorrect username or password.';
        } catch (Throwable $e) {
            $error = 'Unable to verify the account. Check the database connection and admins table.';
        }
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login | BIAM CMS</title><link rel="stylesheet" href="admin.css"></head><body><button id="languageToggle" class="admin-language-toggle" type="button" style="position:fixed;right:18px;top:18px">বাংলা</button><main class="login"><p class="eyebrow">BIAM LABORATORY SCHOOL</p><h1>Admin Portal</h1><p>Sign in to manage the school website content and publication settings.</p><?php if($error):?><div class="alert"><?=e($error)?></div><?php endif;?><form method="post" autocomplete="on"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label for="username">Username</label><input id="username" name="username" autocomplete="username" required><label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required><button type="submit">Sign in to CMS →</button></form><a href="../index.php">← View public website</a></main><script src="../assets/js/script.js" defer></script></body></html>
