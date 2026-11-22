<?php require_once 'config.php';
$rows = [];
$searched = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $q = db()->prepare('SELECT * FROM results WHERE student_id=? AND exam_name=? AND academic_year=?');
        $q->execute([trim($_POST['student_id'] ?? ''), trim($_POST['exam_name'] ?? ''), trim($_POST['academic_year'] ?? '')]);
        $rows = $q->fetchAll();
        $searched = true;
    } catch (Throwable $e) {
        $searched = true;
        $error = 'Results are temporarily unavailable.';
    }
}
include 'includes/header.php'; ?><main class="container inner-page">
    <section class="page-banner"><span data-en="ACADEMIC RESULTS" data-bn="একাডেমিক ফলাফল">ACADEMIC RESULTS</span>
        <h1 data-en="Examination Results" data-bn="পরীক্ষার ফলাফল">Examination Results</h1>
        <p data-en="Check published student examination results." data-bn="প্রকাশিত পরীক্ষার ফলাফল দেখুন।">Check published student examination results.</p>
    </section>
    <section class="form-panel">
        <h2 data-en="Student Result Search" data-bn="শিক্ষার্থীর ফলাফল অনুসন্ধান">Student Result Search</h2>
        <form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label data-en="Student ID" data-bn="শিক্ষার্থী আইডি">Student ID</label><input name="student_id" placeholder="Enter Student ID" required><label data-en="Examination" data-bn="পরীক্ষা">Examination</label><select name="exam_name" required>
                <option value="" data-en="Select Examination" data-bn="পরীক্ষা নির্বাচন করুন">Select Examination</option>
                <option value="Annual Examination">Annual Examination</option>
                <option value="Half Yearly Examination">Half Yearly Examination</option>
                <option value="Model Test">Model Test</option>
            </select><label data-en="Academic Year" data-bn="শিক্ষাবর্ষ">Academic Year</label><select name="academic_year" required>
                <option value="" data-en="Select Year" data-bn="বছর নির্বাচন করুন">Select Year</option><?php foreach (['2026', '2025', '2024'] as $y): ?><option><?= e($y) ?></option><?php endforeach; ?>
            </select><button class="admission-submit" data-en="Check Result" data-bn="ফলাফল দেখুন">Check Result</button></form><?php if ($error): ?><p class="error-message"><?= e($error) ?></p><?php elseif ($searched && $rows): foreach ($rows as $r): ?><div class="service-panel result-panel">
                    <h3><?= e($r['student_name']) ?></h3>
                    <p data-en="Student ID: <?= e($r['student_id']) ?> · Class: <?= e($r['class_name']) ?>" data-bn="শিক্ষার্থী আইডি: <?= e($r['student_id']) ?> · শ্রেণি: <?= e($r['class_name']) ?>">Student ID: <?= e($r['student_id']) ?> · Class: <?= e($r['class_name']) ?></p>
                    <p data-en="Examination: <?= e($r['exam_name']) ?> · Year: <?= e($r['academic_year']) ?>" data-bn="পরীক্ষা: <?= e($r['exam_name']) ?> · বছর: <?= e($r['academic_year']) ?>">Examination: <?= e($r['exam_name']) ?> · Year: <?= e($r['academic_year']) ?></p>
                    <p data-en="Marks: <?= e($r['marks']) ?> · Grade: <?= e($r['grade']) ?>" data-bn="নম্বর: <?= e($r['marks']) ?> · গ্রেড: <?= e($r['grade']) ?>">Marks: <?= e($r['marks']) ?> · Grade: <?= e($r['grade']) ?></p>
                    <p><?= e($r['remarks']) ?></p>
                </div><?php endforeach;
                                                                                                                                                                                            elseif ($searched): ?><p data-en="No matching result found. Please check the details or contact the school." data-bn="কোনো ফলাফল পাওয়া যায়নি। তথ্য যাচাই করুন অথবা বিদ্যালয়ে যোগাযোগ করুন।">No matching result found. Please check the details or contact the school.</p><?php endif; ?>
    </section>
</main><?php include 'includes/footer.php'; ?>