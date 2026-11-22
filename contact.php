<?php
require_once __DIR__ . '/config.php';
$c = page_content('contact', [
    'title_en' => 'Contact BIAM Laboratory School',
    'title_bn' => 'বিয়াম ল্যাবরেটরি স্কুলে যোগাযোগ',
    'body_en' => 'We are here to assist students, parents and visitors.',
    'body_bn' => 'শিক্ষার্থী, অভিভাবক ও দর্শনার্থীদের সহায়তায় আমরা প্রস্তুত।'
]);
$sent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string)($_POST['name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $subject = trim((string)($_POST['subject'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));
    if (mb_strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($subject) < 2 || mb_strlen($message) < 5) {
        $error = 'Please complete all fields with valid information.';
    } else {
        try {
            $q = db()->prepare('INSERT INTO messages(name,email,subject,message) VALUES(?,?,?,?)');
            $q->execute([$name, $email, $subject, $message]);
            $sent = true;
        } catch (Throwable $e) {
            $error = 'Unable to send your message right now. Please try later.';
        }
    }
}
$contact = [
    'address' => setting('address', ''),
    'phone' => setting('phone', ''),
    'email' => setting('email', ''),
    'office_hours' => setting('office_hours', '')
];
foreach ($contact as $key => $value) {
    if (stripos($value, 'please update') !== false || stripos($value, 'update official') !== false) $contact[$key] = '';
}
include __DIR__ . '/includes/header.php';
?>
<main class="container inner-page">
    <section class="page-banner">
        <span data-en="GET IN TOUCH" data-bn="যোগাযোগ করুন">GET IN TOUCH</span>
        <h1 data-en="<?= e($c['title_en']) ?>" data-bn="<?= e($c['title_bn'] ?: $c['title_en']) ?>"><?= e($c['title_en']) ?></h1>
        <p data-en="<?= e($c['body_en']) ?>" data-bn="<?= e($c['body_bn'] ?: $c['body_en']) ?>"><?= e($c['body_en']) ?></p>
    </section>
    <div class="student-service-grid">
        <div class="service-panel">
            <h2 data-en="School Address" data-bn="বিদ্যালয়ের ঠিকানা">School Address</h2>
            <p data-en="<?= e($contact['address'] ?: 'Contact the school office for the official address.') ?>" data-bn="<?= e($contact['address'] ?: 'অফিসিয়াল ঠিকানার জন্য বিদ্যালয় অফিসে যোগাযোগ করুন।') ?>"><?= e($contact['address'] ?: 'Contact the school office for the official address.') ?></p>
        </div>
        <div class="service-panel">
            <h2 data-en="Phone Number" data-bn="ফোন নম্বর">Phone Number</h2>
            <p data-en="<?= e($contact['phone'] ?: 'Official phone information will be published here.') ?>" data-bn="<?= e($contact['phone'] ?: 'অফিসিয়াল ফোন নম্বর এখানে প্রকাশ করা হবে।') ?>"><?= e($contact['phone'] ?: 'Official phone information will be published here.') ?></p>
        </div>
        <div class="service-panel">
            <h2 data-en="Email Address" data-bn="ইমেইল ঠিকানা">Email Address</h2>
            <p data-en="<?= e($contact['email'] ?: 'Official email information will be published here.') ?>" data-bn="<?= e($contact['email'] ?: 'অফিসিয়াল ইমেইল ঠিকানা এখানে প্রকাশ করা হবে।') ?>"><?= e($contact['email'] ?: 'Official email information will be published here.') ?></p>
        </div>
        <div class="service-panel">
            <h2 data-en="Office Hours" data-bn="অফিস সময়সূচি">Office Hours</h2>
            <p data-en="<?= e($contact['office_hours'] ?: 'Please contact the school office for visiting hours.') ?>" data-bn="<?= e($contact['office_hours'] ?: 'বিদ্যালয়ে আসার সময় জানতে অফিসে যোগাযোগ করুন।') ?>"><?= e($contact['office_hours'] ?: 'Please contact the school office for visiting hours.') ?></p>
        </div>
    </div>
    <section class="form-panel">
        <h2 data-en="Send Us a Message" data-bn="আমাদের বার্তা পাঠান">Send Us a Message</h2>
        <?php if ($sent): ?><p class="success-message" data-en="Thank you! Your message has been received." data-bn="ধন্যবাদ! আপনার বার্তা গ্রহণ করা হয়েছে।">Thank you! Your message has been received.</p>
        <?php elseif ($error): ?><p class="error-message" data-en="<?= e($error) ?>" data-bn="<?= e($error === 'Please complete all fields with valid information.' ? 'সঠিক তথ্য দিয়ে সব ঘর পূরণ করুন।' : 'এই মুহূর্তে বার্তা পাঠানো যাচ্ছে না। পরে আবার চেষ্টা করুন।') ?>"><?= e($error) ?></p><?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label for="contact-name" data-en="Your Name" data-bn="আপনার নাম">Your Name</label><input id="contact-name" name="name" maxlength="160" placeholder="Enter your name" required>
            <label for="contact-email" data-en="Email Address" data-bn="ইমেইল ঠিকানা">Email Address</label><input id="contact-email" type="email" name="email" maxlength="160" placeholder="Enter your email" required>
            <label for="contact-subject" data-en="Subject" data-bn="বিষয়">Subject</label><input id="contact-subject" name="subject" maxlength="255" placeholder="Enter subject" required>
            <label for="contact-message" data-en="Message" data-bn="বার্তা">Message</label><textarea id="contact-message" name="message" rows="5" maxlength="5000" placeholder="Write your message" required></textarea>
            <button class="admission-submit" data-en="Send Message →" data-bn="বার্তা পাঠান →">Send Message →</button>
        </form>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>