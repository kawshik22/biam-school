<?php require_once 'config.php';
$c = page_content('admission', ['title_en' => 'Start Your Journey With Us', 'title_bn' => 'আমাদের সঙ্গে আপনার যাত্রা শুরু করুন', 'body_en' => 'Apply for admission to BIAM Laboratory School.', 'body_bn' => 'বিয়াম ল্যাবরেটরি স্কুলে ভর্তির জন্য আবেদন করুন।']);
$sent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $q = db()->prepare('INSERT INTO admissions(student_name,class_name,guardian_name,mobile,email) VALUES(?,?,?,?,?)');
        $q->execute([trim($_POST['student_name'] ?? ''), trim($_POST['class_name'] ?? ''), trim($_POST['guardian_name'] ?? ''), trim($_POST['mobile'] ?? ''), trim($_POST['email'] ?? '')]);
        $sent = true;
    } catch (Throwable $e) {
        $error = 'Unable to submit right now. Please contact the school office.';
    }
}
include 'includes/header.php'; ?><main class="container admission-page">
    <section class="page-banner"><span data-en="ADMISSIONS" data-bn="ভর্তি">ADMISSIONS</span>
        <h1 data-en="<?= e($c['title_en']) ?>" data-bn="<?= e($c['title_bn'] ?: $c['title_en']) ?>"><?= e($c['title_en']) ?></h1>
        <p data-en="<?= e($c['body_en']) ?>" data-bn="<?= e($c['body_bn'] ?: $c['body_en']) ?>"><?= e($c['body_en']) ?></p>
    </section>
    <section class="admission-content">
        <div class="admission-intro">
            <h2 data-en="Online Admission Information" data-bn="অনলাইন ভর্তি সংক্রান্ত তথ্য">Online Admission Information</h2>
            <p data-en="Welcome to BIAM Laboratory School. We welcome students who are eager to learn, grow and build a bright future." data-bn="বিয়াম ল্যাবরেটরি স্কুলে স্বাগতম। আমরা আগ্রহী শিক্ষার্থীদের স্বাগত জানাই, যারা শিখতে, বেড়ে উঠতে এবং উজ্জ্বল ভবিষ্যৎ গড়তে চায়।">Welcome to BIAM Laboratory School. We welcome students who are eager to learn, grow and build a bright future.</p>
            <h3 data-en="Admission Requirements" data-bn="ভর্তির প্রয়োজনীয় কাগজপত্র">Admission Requirements</h3>
            <ul>
                <li data-en="Recent passport-size photograph" data-bn="সাম্প্রতিক পাসপোর্ট সাইজের ছবি">Recent passport-size photograph</li>
                <li data-en="Birth registration certificate" data-bn="জন্ম নিবন্ধন সনদ">Birth registration certificate</li>
                <li data-en="Previous academic records, if applicable" data-bn="প্রযোজ্য ক্ষেত্রে পূর্ববর্তী শিক্ষাগত তথ্য">Previous academic records, if applicable</li>
                <li data-en="Parent or guardian contact information" data-bn="অভিভাবকের যোগাযোগের তথ্য">Parent or guardian contact information</li>
            </ul>
        </div>
        <div class="admission-form-box">
            <h2 data-en="Admission Enquiry Form" data-bn="ভর্তি অনুসন্ধান ফরম">Admission Enquiry Form</h2><?php if ($sent): ?><p class="success-message" data-en="Thank you. Your admission enquiry has been received." data-bn="ধন্যবাদ। আপনার ভর্তি সংক্রান্ত অনুসন্ধান গ্রহণ করা হয়েছে।">Thank you. Your admission enquiry has been received.</p><?php elseif ($error): ?><p class="error-message"><?= e($error) ?></p><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label data-en="Student Name" data-bn="শিক্ষার্থীর নাম">Student Name</label><input name="student_name" placeholder="Enter student name" required><label data-en="Class Applying For" data-bn="যে শ্রেণিতে ভর্তি হতে ইচ্ছুক">Class Applying For</label><select name="class_name" required>
                    <option value="" data-en="Select Class" data-bn="শ্রেণি নির্বাচন করুন">Select Class</option><?php foreach (['Play Group', 'Nursery', 'Class One', 'Class Two', 'Class Three', 'Class Four', 'Class Five', 'Class Six', 'Class Seven', 'Class Eight', 'Class Nine', 'Class Ten'] as $cl): ?><option value="<?= e($cl) ?>"><?= e($cl) ?></option><?php endforeach; ?>
                </select><label data-en="Parent/Guardian Name" data-bn="অভিভাবকের নাম">Parent/Guardian Name</label><input name="guardian_name" placeholder="Enter guardian name" required><label data-en="Mobile Number" data-bn="মোবাইল নম্বর">Mobile Number</label><input name="mobile" required><label data-en="Email Address" data-bn="ইমেইল ঠিকানা">Email Address</label><input type="email" name="email"><button class="admission-submit" data-en="Submit Enquiry →" data-bn="অনুসন্ধান জমা দিন →">Submit Enquiry →</button></form>
        </div>
    </section>
</main><?php include 'includes/footer.php'; ?>