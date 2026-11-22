<?php
require_once __DIR__ . '/../config.php';
if (!user_logged_in()) {
    header('Location: login.php');
    exit;
}
$q = db()->prepare("SELECT full_name,email,account_type,reference_id FROM users WHERE id=? AND status='approved'");
$q->execute([$_SESSION['user_id']]);
$u = $q->fetch();
if (!$u) {
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>User Dashboard | BIAM</title>
    <link rel="stylesheet" href="portal.css">
</head>

<body><button id="languageToggle" class="portal-language" type="button">বাংলা</button>
    <main class="dashboard-card"><a class="back" href="../index.php" data-en="← Website" data-bn="← ওয়েবসাইট">← Website</a>
        <div class="brand-mark">B</div>
        <p class="eyebrow">BIAM USER PORTAL</p>
        <h1><span data-en="Welcome," data-bn="স্বাগতম,">Welcome,</span> <?= e($u['full_name']) ?></h1>
        <p class="muted" data-en="Your account is approved and active." data-bn="আপনার অ্যাকাউন্ট অনুমোদিত ও সক্রিয়।">Your account is approved and active.</p>
        <div class="profile-grid">
            <div><small data-en="Account type" data-bn="অ্যাকাউন্টের ধরন">Account type</small><strong><?= e(ucfirst($u['account_type'])) ?></strong></div>
            <div><small data-en="Email" data-bn="ইমেইল">Email</small><strong><?= e($u['email']) ?></strong></div>
            <div><small data-en="Reference ID" data-bn="রেফারেন্স আইডি">Reference ID</small><strong><?= e($u['reference_id'] ?: 'Not provided') ?></strong></div>
        </div>
        <p class="muted" data-en="Portal services will be added according to the school's requirements." data-bn="বিদ্যালয়ের প্রয়োজন অনুযায়ী এখানে পোর্টাল সেবা যুক্ত করা হবে।">Portal services will be added according to the school's requirements.</p><a class="primary" href="logout.php" data-en="Sign out" data-bn="লগআউট">Sign out</a>
    </main>
    <script src="../assets/js/script.js" defer></script>
</body>

</html>