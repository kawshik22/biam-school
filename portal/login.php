<?php
require_once __DIR__ . '/../config.php';

$error = '';
$sessionNotice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'switch_account') {
    verify_csrf();
    unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_type']);
    session_regenerate_id(true);
    header('Location: login.php');
    exit;
}
if (admin_logged_in()) {
    $sessionNotice = 'An administrator session is already active in this browser. You can open the CMS or switch accounts below.';
} elseif (user_logged_in()) {
    $sessionNotice = 'A user session is already active in this browser. You can open your portal or switch accounts below.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') !== 'switch_account') {
    verify_csrf();

    $now = time();
    $windowStart = (int)($_SESSION['portal_attempt_window'] ?? $now);
    $attempts = (int)($_SESSION['portal_attempts'] ?? 0);
    if ($now - $windowStart > 900) {
        $windowStart = $now;
        $attempts = 0;
    }

    if ($attempts >= 5) {
        $error = 'Too many sign-in attempts. Please wait 15 minutes and try again.';
    } else {
        $identity = trim((string)($_POST['identity'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        try {
            // One public login form: admin username or student/teacher email.
            $adminQuery = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1');
            $adminQuery->execute([$identity]);
            $admin = $adminQuery->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                if (password_needs_rehash($admin['password_hash'], PASSWORD_DEFAULT)) {
                    $update = db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
                    $update->execute([password_hash($password, PASSWORD_DEFAULT), $admin['id']]);
                }
                session_regenerate_id(true);
                $_SESSION['admin_id'] = (int)$admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_type']);
                unset($_SESSION['portal_attempts'], $_SESSION['portal_attempt_window']);
                header('Location: ../admin/index.php');
                exit;
            }

            $userQuery = db()->prepare('SELECT id, full_name, email, account_type, password_hash, status FROM users WHERE email = ? LIMIT 1');
            $userQuery->execute([strtolower($identity)]);
            $user = $userQuery->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                if ($user['status'] !== 'approved') {
                    $error = $user['status'] === 'pending'
                        ? 'Your account is awaiting administrator approval.'
                        : 'This account is not active. Please contact the school office.';
                } else {
                    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                        $update = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                        $update->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
                    }
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_type'] = $user['account_type'];
                    unset($_SESSION['admin_id'], $_SESSION['admin_name']);
                    unset($_SESSION['portal_attempts'], $_SESSION['portal_attempt_window']);
                    header('Location: dashboard.php');
                    exit;
                }
            } else {
                $error = 'Incorrect username/email or password.';
            }

            $_SESSION['portal_attempt_window'] = $windowStart;
            $_SESSION['portal_attempts'] = $attempts + 1;
        } catch (Throwable $e) {
            $error = 'Unable to sign in right now. Please check the database connection.';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | BIAM Laboratory School</title>
    <link rel="stylesheet" href="portal.css">
</head>

<body>
    <button id="languageToggle" class="portal-language" type="button">বাংলা</button>
    <main class="auth-card">
        <a class="back" href="../index.php" data-en="← Back to website" data-bn="← ওয়েবসাইটে ফিরে যান">← Back to website</a>
        <div class="brand-mark">B</div>
        <p class="eyebrow">BIAM LABORATORY SCHOOL</p>
        <h1 data-en="Sign in" data-bn="লগইন করুন">Sign in</h1>
        <p class="muted" data-en="Use your administrator username or your approved student/teacher email address." data-bn="অ্যাডমিন ইউজারনেম অথবা অনুমোদিত শিক্ষার্থী/শিক্ষক ইমেইল ব্যবহার করুন।">Use your administrator username or your approved student/teacher email address.</p>
        <?php if ($sessionNotice): ?>
            <div class="session-note">
                <p data-en="<?= e($sessionNotice) ?>" data-bn="<?= admin_logged_in() ? 'এই ব্রাউজারে অ্যাডমিন সেশন চালু আছে। নিচে সাইন-ইন করতে পারেন অথবা অ্যাডমিন ড্যাশবোর্ডে যেতে পারেন।' : 'এই ব্রাউজারে একটি ইউজার সেশন চালু আছে। নিচে সাইন-ইন করতে পারেন অথবা ইউজার পোর্টালে যেতে পারেন।' ?>"><?= e($sessionNotice) ?></p>
                <?php if (admin_logged_in()): ?><a href="../admin/index.php" data-en="Open Admin Dashboard" data-bn="অ্যাডমিন ড্যাশবোর্ড খুলুন">Open Admin Dashboard</a><?php elseif (user_logged_in()): ?><a href="dashboard.php" data-en="Open User Portal" data-bn="ইউজার পোর্টাল খুলুন">Open User Portal</a><?php endif; ?>
                <form method="post" class="switch-account-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><button type="submit" name="action" value="switch_account" data-en="Sign out and switch account" data-bn="লগআউট করে অন্য অ্যাকাউন্টে প্রবেশ করুন">Sign out and switch account</button></form>
            </div>
        <?php endif; ?>
        <?php if ($error): ?><div class="error" data-en="<?= e($error) ?>" data-bn="<?= e($error) ?>"><?= e($error) ?></div><?php endif; ?>
        <form method="post" autocomplete="on">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label for="identity" data-en="Username or email" data-bn="ইউজারনেম অথবা ইমেইল">Username or email</label>
            <input id="identity" name="identity" autocomplete="username" placeholder="Enter username or email" required>
            <label for="password" data-en="Password" data-bn="পাসওয়ার্ড">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
            <button class="primary" data-en="Sign in →" data-bn="লগইন করুন →">Sign in →</button>
        </form>
        <p class="foot"><span data-en="New student or teacher?" data-bn="নতুন শিক্ষার্থী বা শিক্ষক?">New student or teacher?</span> <a href="register.php" data-en="Create an account" data-bn="অ্যাকাউন্ট তৈরি করুন">Create an account</a></p>
        <p class="foot"><a href="../index.php" data-en="Return to public website" data-bn="মূল ওয়েবসাইটে ফিরুন">Return to public website</a></p>
    </main>
    <script src="../assets/js/script.js" defer></script>
</body>

</html>