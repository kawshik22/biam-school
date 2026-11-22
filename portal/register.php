<?php
require_once __DIR__ . '/../config.php';
$ok = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $name = trim($_POST['full_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $mobile = trim($_POST['mobile'] ?? '');
        $type = $_POST['account_type'] ?? '';
        $ref = trim($_POST['reference_id'] ?? '');
        $pass = (string)($_POST['password'] ?? '');
        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($type, ['student', 'teacher'], true) || strlen($pass) < 10) throw new RuntimeException('Please check your details. Password must be at least 10 characters.');
        $q = db()->prepare("INSERT INTO users(full_name,email,mobile,account_type,reference_id,password_hash,status) VALUES(?,?,?,?,?,?,'pending')");
        $q->execute([$name, $email, $mobile, $type, $ref, password_hash($pass, PASSWORD_DEFAULT)]);
        $ok = true;
    } catch (Throwable $e) {
        $error = $e instanceof PDOException ? 'This email may already be registered. Please try logging in.' : $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Create Account | BIAM</title>
    <link rel="stylesheet" href="portal.css">
</head>

<body><button id="languageToggle" class="portal-language" type="button">বাংলা</button>
    <main class="auth-card"><a class="back" href="../index.php" data-en="← Back to website" data-bn="← ওয়েবসাইটে ফিরে যান">← Back to website</a>
        <div class="brand-mark">B</div>
        <p class="eyebrow">BIAM LABORATORY SCHOOL</p>
        <h1 data-en="Create an account" data-bn="অ্যাকাউন্ট তৈরি করুন">Create an account</h1>
        <p class="muted" data-en="Your account will be reviewed by the school administrator before access is activated." data-bn="অ্যাকাউন্ট সক্রিয় হওয়ার আগে বিদ্যালয়ের প্রশাসক আপনার আবেদন পর্যালোচনা করবেন।">Your account will be reviewed by the school administrator before access is activated.</p><?php if ($ok): ?><div class="success" data-en="Registration received. Your account is pending admin approval. You can sign in after it has been approved." data-bn="নিবন্ধন গ্রহণ করা হয়েছে। আপনার অ্যাকাউন্ট প্রশাসকের অনুমোদনের অপেক্ষায় রয়েছে। অনুমোদনের পর লগইন করতে পারবেন।">Registration received. Your account is pending admin approval. You can sign in after it has been approved.</div><a class="primary" href="login.php" data-en="Go to login" data-bn="লগইন পেজে যান">Go to login</a><?php else: ?><?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label for="full_name" data-en="Full name" data-bn="পূর্ণ নাম">Full name</label><input id="full_name" name="full_name" placeholder="Enter your full name" required><label for="register_email" data-en="Email address" data-bn="ইমেইল ঠিকানা">Email address</label><input id="register_email" type="email" name="email" placeholder="Enter your email" required><label for="mobile" data-en="Mobile number" data-bn="মোবাইল নম্বর">Mobile number</label><input id="mobile" name="mobile" placeholder="Enter mobile number"><label for="account_type" data-en="Account type" data-bn="অ্যাকাউন্টের ধরন">Account type</label><select id="account_type" name="account_type" required>
                <option value="" data-en="Choose account type" data-bn="অ্যাকাউন্টের ধরন নির্বাচন করুন">Choose account type</option>
                <option value="student" data-en="Student" data-bn="শিক্ষার্থী">Student</option>
                <option value="teacher" data-en="Teacher" data-bn="শিক্ষক">Teacher</option>
            </select><label for="reference_id" data-en="Student / Teacher ID (if available)" data-bn="শিক্ষার্থী / শিক্ষক আইডি (যদি থাকে)">Student / Teacher ID (if available)</label><input id="reference_id" name="reference_id"><label for="register_password" data-en="Password (minimum 10 characters)" data-bn="পাসওয়ার্ড (কমপক্ষে ১০ অক্ষর)">Password (minimum 10 characters)</label><input id="register_password" type="password" name="password" minlength="10" autocomplete="new-password" required><button class="primary" data-en="Submit registration" data-bn="নিবন্ধন জমা দিন">Submit registration</button></form><?php endif; ?><p class="foot"><span data-en="Already registered?" data-bn="ইতোমধ্যে নিবন্ধিত?">Already registered?</span> <a href="login.php" data-en="Sign in" data-bn="লগইন করুন">Sign in</a></p>
    </main>
    <script src="../assets/js/script.js" defer></script>
</body>

</html>