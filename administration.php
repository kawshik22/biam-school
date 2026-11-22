<?php
require_once __DIR__ . '/config.php';
$content = page_content('administration', [
    'title_en' => 'School Leadership & Administration',
    'title_bn' => 'বিদ্যালয় নেতৃত্ব ও প্রশাসন',
    'body_en' => 'The leadership team works to support an organised, welcoming and purposeful learning community.',
    'body_bn' => 'একটি সুশৃঙ্খল, আন্তরিক ও উদ্দেশ্যপূর্ণ শিক্ষার পরিবেশ গড়তে নেতৃত্বের দল কাজ করে।'
]);
$leaders = [];
try {
    $stmt = db()->prepare("SELECT id,name_en,name_bn,designation_en,designation_bn,bio_en,bio_bn,photo,sort_order FROM staff WHERE is_published=1 AND category='leadership' ORDER BY sort_order ASC, id ASC");
    $stmt->execute();
    $leaders = $stmt->fetchAll();
} catch (Throwable $e) {}
include __DIR__ . '/includes/header.php';
?>
<main class="container inner-page faculty-page">
    <section class="faculty-banner administration-banner reveal">
        <div class="faculty-banner-copy">
            <span class="section-label" data-en="SCHOOL LEADERSHIP" data-bn="বিদ্যালয় নেতৃত্ব">SCHOOL LEADERSHIP</span>
            <h1 data-en="<?= e($content['title_en']) ?>" data-bn="<?= e($content['title_bn'] ?: $content['title_en']) ?>"><?= e($content['title_en']) ?></h1>
            <p data-en="<?= e($content['body_en']) ?>" data-bn="<?= e($content['body_bn'] ?: $content['body_en']) ?>"><?= e($content['body_en']) ?></p>
        </div>
        <div class="faculty-banner-stat"><strong><?= count($leaders) ?></strong><span data-en="Leadership profiles" data-bn="নেতৃত্বের প্রোফাইল">Leadership profiles</span></div>
    </section>

    <section class="faculty-directory-section">
        <div class="faculty-section-heading">
            <div>
                <span class="section-label" data-en="MEET OUR LEADERS" data-bn="নেতৃত্বের সঙ্গে পরিচিত হোন">MEET OUR LEADERS</span>
                <h2 data-en="School leadership team" data-bn="বিদ্যালয় নেতৃত্ব দল">School leadership team</h2>
                <p data-en="The people responsible for guiding the school's academic and institutional direction." data-bn="বিদ্যালয়ের একাডেমিক ও প্রাতিষ্ঠানিক কার্যক্রম পরিচালনায় দায়িত্বপ্রাপ্ত ব্যক্তিবৃন্দ।">The people responsible for guiding the school's academic and institutional direction.</p>
            </div>
        </div>
        <div class="demo-content-note" role="note">
            <strong data-en="Demo leadership profiles" data-bn="নমুনা নেতৃত্ব প্রোফাইল">Demo leadership profiles</strong>
            <span data-en="Names, designations and portraits are illustrative placeholders. Replace them with approved BIAM information before publishing." data-bn="নাম, পদবি ও ছবি নমুনা হিসেবে যুক্ত করা হয়েছে। প্রকাশের আগে অনুমোদিত বিয়াম তথ্য দিয়ে প্রতিস্থাপন করুন।">Names, designations and portraits are illustrative placeholders. Replace them with approved BIAM information before publishing.</span>
        </div>
        <?php if ($leaders): ?>
            <div class="leadership-grid">
                <?php foreach ($leaders as $leader):
                    $name = trim((string)$leader['name_en']);
                    $initials = '';
                    foreach (preg_split('/\s+/', $name) as $part) { if ($part !== '') $initials .= strtoupper(substr($part, 0, 1)); if (strlen($initials) >= 2) break; }
                ?>
                    <article class="leadership-card reveal">
                        <div class="leadership-photo">
                            <?php if (!empty($leader['photo']) && is_file(__DIR__ . '/' . $leader['photo'])): ?>
                                <img src="<?= e($leader['photo']) ?>" alt="Demo portrait of <?= e($name) ?>" loading="lazy" decoding="async">
                            <?php else: ?><div class="faculty-avatar large" aria-hidden="true"><?= e($initials ?: 'BI') ?></div><?php endif; ?>
                            <span data-en="LEADERSHIP" data-bn="নেতৃত্ব">LEADERSHIP</span>
                        </div>
                        <div class="leadership-info">
                            <p class="faculty-designation" data-en="<?= e($leader['designation_en']) ?>" data-bn="<?= e($leader['designation_bn'] ?: $leader['designation_en']) ?>"><?= e($leader['designation_en']) ?></p>
                            <h3 data-en="<?= e($leader['name_en']) ?>" data-bn="<?= e($leader['name_bn'] ?: $leader['name_en']) ?>"><?= e($leader['name_en']) ?></h3>
                            <p class="faculty-bio" data-en="<?= e($leader['bio_en']) ?>" data-bn="<?= e($leader['bio_bn'] ?: $leader['bio_en']) ?>"><?= e($leader['bio_en']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="faculty-empty-state"><strong data-en="Leadership profiles are not available yet." data-bn="নেতৃত্বের প্রোফাইল এখনো যুক্ত করা হয়নি।">Leadership profiles are not available yet.</strong><p data-en="Import database-update.sql to add editable sample profiles." data-bn="সম্পাদনাযোগ্য নমুনা প্রোফাইল যোগ করতে database-update.sql ইমপোর্ট করুন।">Import database-update.sql to add editable sample profiles.</p></div>
        <?php endif; ?>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
