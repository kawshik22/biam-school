<?php require_once 'config.php';
$c = page_content('students', ['title_en' => 'Student Information', 'title_bn' => 'শিক্ষার্থী তথ্য', 'body_en' => 'Access academic resources and student services.', 'body_bn' => 'একাডেমিক তথ্য ও শিক্ষার্থী সেবা দেখুন।']);
include 'includes/header.php'; ?><main class="container inner-page">
    <section class="page-banner"><span data-en="STUDENT CORNER" data-bn="শিক্ষার্থী কর্নার">STUDENT CORNER</span>
        <h1 data-en="<?= e($c['title_en']) ?>" data-bn="<?= e($c['title_bn'] ?: $c['title_en']) ?>"><?= e($c['title_en']) ?></h1>
        <p data-en="<?= e($c['body_en']) ?>" data-bn="<?= e($c['body_bn'] ?: $c['body_en']) ?>"><?= e($c['body_en']) ?></p>
    </section>
    <div class="student-service-grid">
        <article class="service-panel">
            <h2 data-en="Academic Information" data-bn="একাডেমিক তথ্য">Academic Information</h2>
            <p data-en="Class schedules, academic calendar and syllabus." data-bn="ক্লাসের সময়সূচি, একাডেমিক ক্যালেন্ডার ও পাঠ্যসূচি।">Class schedules, academic calendar and syllabus.</p><a href="academics.php">View Academic Information →</a>
        </article>
        <article class="service-panel">
            <h2 data-en="Examination Results" data-bn="পরীক্ষার ফলাফল">Examination Results</h2>
            <p data-en="Search published examination results using your student ID." data-bn="শিক্ষার্থী আইডি দিয়ে প্রকাশিত পরীক্ষার ফলাফল খুঁজুন।">Search published examination results using your student ID.</p><a href="results.php">Check Results →</a>
        </article>
        <article class="service-panel">
            <h2 data-en="Student Portal" data-bn="শিক্ষার্থী পোর্টাল">Student Portal</h2>
            <p data-en="Sign in with an approved student account to access available services." data-bn="অনুমোদিত শিক্ষার্থী অ্যাকাউন্ট দিয়ে লগইন করে সেবা ব্যবহার করুন।">Sign in with an approved student account to access available services.</p><a href="portal/login.php">Login →</a>
        </article>
        <article class="service-panel">
            <h2 data-en="Student Guidelines" data-bn="শিক্ষার্থীদের নির্দেশিকা">Student Guidelines</h2>
            <p data-en="School rules, discipline and student guidelines." data-bn="বিদ্যালয়ের নিয়ম, শৃঙ্খলা ও শিক্ষার্থীদের নির্দেশিকা।">School rules, discipline and student guidelines.</p><a href="contact.php">Contact School →</a>
        </article>
    </div>
</main><?php include 'includes/footer.php'; ?>