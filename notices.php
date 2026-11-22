<?php
require_once __DIR__ . '/config.php';
$page = max(1, (int)($_GET['page'] ?? 1));
$per = 12;
$total = 0;
$rows = [];
$noticeDbReady = true;
try {
    $q = db()->prepare('SELECT COUNT(*) FROM notices WHERE is_published=1 AND publish_date<=CURDATE()');
    $q->execute();
    $total = (int)$q->fetchColumn();
    $st = db()->prepare('SELECT * FROM notices WHERE is_published=1 AND publish_date<=CURDATE() ORDER BY publish_date DESC,id DESC LIMIT ? OFFSET ?');
    $st->bindValue(1, $per, PDO::PARAM_INT);
    $st->bindValue(2, ($page - 1) * $per, PDO::PARAM_INT);
    $st->execute();
    $rows = $st->fetchAll();
} catch (Throwable $e) {
    $noticeDbReady = false;
}
include __DIR__ . '/includes/header.php';
?>
<main class="container section-pad">
    <div class="page-banner">
        <span data-en="NOTICE BOARD" data-bn="নোটিশ বোর্ড">NOTICE BOARD</span>
        <h1 data-en="School Notices & Announcements" data-bn="বিদ্যালয়ের নোটিশ ও ঘোষণা">School Notices &amp; Announcements</h1>
        <p data-en="Stay informed about important school updates." data-bn="বিদ্যালয়ের গুরুত্বপূর্ণ আপডেট সম্পর্কে অবগত থাকুন।">Stay informed about important school updates.</p>
    </div>
    <?php if (!$noticeDbReady): ?>
        <div class="faculty-empty-state"><strong data-en="Notice records are temporarily unavailable." data-bn="নোটিশের তথ্য আপাতত পাওয়া যাচ্ছে না।">Notice records are temporarily unavailable.</strong>
            <p data-en="Check that Apache and MySQL are running and that config.php points to the biam_school database." data-bn="Apache ও MySQL চালু আছে কি না এবং config.php সঠিক biam_school ডেটাবেসে সংযুক্ত কি না যাচাই করুন।">Check that Apache and MySQL are running and that config.php points to the biam_school database.</p>
        </div>
    <?php else: ?>
        <div class="notice-cards all-notices">
            <?php foreach ($rows as $n): ?>
                <article class="notice-card">
                    <div class="notice-date"><strong><?= e(date('d', strtotime($n['publish_date']))) ?></strong><span><?= e(date('M Y', strtotime($n['publish_date']))) ?></span></div>
                    <div>
                        <h3 data-en="<?= e($n['title_en']) ?>" data-bn="<?= e($n['title_bn'] ?: $n['title_en']) ?>"><?= e($n['title_en']) ?></h3>
                        <p data-en="<?= e($n['body_en'] ?? '') ?>" data-bn="<?= e($n['body_bn'] ?: ($n['body_en'] ?? '')) ?>"><?= e($n['body_en'] ?? '') ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if (!$rows): ?><p data-en="No published notices at this time." data-bn="এ মুহূর্তে কোনো প্রকাশিত নোটিশ নেই।">No published notices at this time.</p><?php endif; ?>
        <?php if ($total > $per): ?><nav class="pagination" aria-label="Notice pages"><?php for ($p = 1; $p <= ceil($total / $per); $p++): ?><a class="<?= $p === $page ? 'current' : '' ?>" href="?page=<?= $p ?>"><?= $p ?></a><?php endfor; ?></nav><?php endif; ?>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>