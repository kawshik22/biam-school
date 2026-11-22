<?php
require_once 'config.php';
$message = '';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sql = file_get_contents(__DIR__ . '/database.sql');
    // database.sql can be imported directly via phpMyAdmin; install page only creates admin after DB exists.
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(80) NOT NULL UNIQUE, password_hash VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (setting_key VARCHAR(100) PRIMARY KEY, setting_value TEXT NOT NULL)");
    $exists = $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
    if (!$exists && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $u = trim($_POST['username'] ?? '');
        $pw = $_POST['password'] ?? '';
        if (strlen($u) < 4 || strlen($pw) < 10) throw new Exception('Username must be at least 4 characters and password at least 10 characters.');
        $st = $pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)');
        $st->execute([$u, password_hash($pw, PASSWORD_DEFAULT)]);
        $message = 'Admin created. Delete install.php now, then log in at admin/login.php.';
    } elseif ($exists) $message = 'An admin account already exists. Remove install.php for security and log in.';
} catch (Throwable $e) {
    $message = 'Setup issue: ' . $e->getMessage() . '. First import database.sql in phpMyAdmin and check config.php.';
}
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>BIAM Setup</title>
<style>
    body {
        font: 16px Arial;
        background: #f2f5f9;
        padding: 40px
    }

    .box {
        max-width: 500px;
        margin: auto;
        background: white;
        padding: 28px;
        border-radius: 12px
    }

    input,
    button {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        box-sizing: border-box
    }

    button {
        background: #d9aa48;
        border: 0;
        font-weight: bold
    }
</style>
<div class="box">
    <h1>BIAM Admin Setup</h1>
    <p><?= e($message) ?></p><?php if (!$message || str_starts_with($message, 'Setup issue')): ?><form method="post"><label>Admin username</label><input name="username" required minlength="4"><label>Password (minimum 10 characters)</label><input name="password" type="password" required minlength="10"><button>Create Admin Account</button></form><?php endif; ?>
</div>

</html>