<?php
require_once __DIR__ . '/config.php';
$content = page_content('teachers', [
    'title_en' => 'Our Faculty & Teachers',
    'title_bn' => 'আমাদের শিক্ষক ও শিক্ষকমণ্ডলী',
    'body_en' => 'Meet the educators who guide, encourage and support every learner.',
    'body_bn' => 'যাঁরা প্রতিটি শিক্ষার্থীকে শেখার পথে দিকনির্দেশনা ও উৎসাহ দেন, তাঁদের সঙ্গে পরিচিত হোন।'
]);
$teachers = [];
try {
    $stmt = db()->prepare("SELECT id,name_en,name_bn,designation_en,designation_bn,bio_en,bio_bn,photo,sort_order FROM staff WHERE is_published=1 AND category='teacher' ORDER BY sort_order ASC, name_en ASC");
    $stmt->execute();
    $teachers = $stmt->fetchAll();
} catch (Throwable $e) {
    // The page remains usable and displays a setup notice if the database is not ready.
}
include __DIR__ . '/includes/header.php';
?>
<main class="container inner-page faculty-page">
    <section class="faculty-banner reveal">
        <div class="faculty-banner-copy">
            <span class="section-label" data-en="ACADEMIC TEAM" data-bn="একাডেমিক টিম">ACADEMIC TEAM</span>
            <h1 data-en="<?= e($content['title_en']) ?>" data-bn="<?= e($content['title_bn'] ?: $content['title_en']) ?>"><?= e($content['title_en']) ?></h1>
            <p data-en="<?= e($content['body_en']) ?>" data-bn="<?= e($content['body_bn'] ?: $content['body_en']) ?>"><?= e($content['body_en']) ?></p>
        </div>
        <div class="faculty-banner-stat"><strong><?= count($teachers) ?></strong><span data-en="Published profiles" data-bn="প্রকাশিত প্রোফাইল">Published profiles</span></div>
    </section>

    <section class="faculty-directory-section">
        <div class="faculty-section-heading">
            <div>
                <span class="section-label" data-en="MEET THE PEOPLE WHO TEACH" data-bn="আমাদের শিক্ষকমণ্ডলী">MEET THE PEOPLE WHO TEACH</span>
                <h2 data-en="Faculty directory" data-bn="শিক্ষক পরিচিতি">Faculty directory</h2>
                <p data-en="Explore the teaching team and their academic responsibilities." data-bn="শিক্ষকবৃন্দ ও তাঁদের একাডেমিক দায়িত্ব সম্পর্কে জানুন।">Explore the teaching team and their academic responsibilities.</p>
            </div>
            <div class="faculty-search-wrap">
                <label class="sr-only" for="facultySearch" data-en="Search teachers" data-bn="শিক্ষক খুঁজুন">Search teachers</label>
                <input id="facultySearch" type="search" placeholder="Search by name or designation" data-en-placeholder="Search by name or designation" data-bn-placeholder="নাম বা পদবি দিয়ে খুঁজুন">
                <span aria-hidden="true">⌕</span>
            </div>
        </div>

        <div class="demo-content-note" role="note">
            <strong data-en="Demo faculty profiles" data-bn="নমুনা শিক্ষক প্রোফাইল">Demo faculty profiles</strong>
            <span data-en="These sample names, designations and portraits are for layout demonstration. Replace them with verified BIAM staff details before publishing." data-bn="লেআউট প্রদর্শনের জন্য নমুনা নাম, পদবি ও ছবি ব্যবহার করা হয়েছে। প্রকাশের আগে যাচাইকৃত বিয়াম শিক্ষক তথ্য দিয়ে প্রতিস্থাপন করুন।">These sample names, designations and portraits are for layout demonstration. Replace them with verified BIAM staff details before publishing.</span>
        </div>

        <?php if ($teachers): ?>
            <div class="faculty-grid" id="facultyGrid">
                <?php foreach ($teachers as $teacher):
                    $name = trim((string)$teacher['name_en']);
                    $initials = '';
                    foreach (preg_split('/\s+/', $name) as $part) {
                        if ($part !== '') $initials .= strtoupper(substr($part, 0, 1));
                        if (strlen($initials) >= 2) break;
                    }
                    $searchValue = strtolower($name . ' ' . ($teacher['designation_en'] ?? '') . ' ' . ($teacher['bio_en'] ?? ''));
                ?>
                    <article class="faculty-card" data-faculty-search="<?= e($searchValue) ?>">
                        <div class="faculty-photo-wrap">
                            <?php if (!empty($teacher['photo']) && is_file(__DIR__ . '/' . $teacher['photo'])): ?>
                                <img src="<?= e($teacher['photo']) ?>" alt="Demo portrait of <?= e($name) ?>" loading="lazy" decoding="async">
                            <?php else: ?>
                                <div class="faculty-avatar" aria-hidden="true"><?= e($initials ?: 'BS') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="faculty-info">
                            <span class="faculty-role" data-en="FACULTY MEMBER" data-bn="শিক্ষক">FACULTY MEMBER</span>
                            <h3 data-en="<?= e($teacher['name_en']) ?>" data-bn="<?= e($teacher['name_bn'] ?: $teacher['name_en']) ?>"><?= e($teacher['name_en']) ?></h3>
                            <p class="faculty-designation" data-en="<?= e($teacher['designation_en']) ?>" data-bn="<?= e($teacher['designation_bn'] ?: $teacher['designation_en']) ?>"><?= e($teacher['designation_en']) ?></p>
                            <p class="faculty-bio" data-en="<?= e($teacher['bio_en']) ?>" data-bn="<?= e($teacher['bio_bn'] ?: $teacher['bio_en']) ?>"><?= e($teacher['bio_en']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <p class="faculty-no-results" id="facultyNoResults" hidden data-en="No faculty profiles match your search." data-bn="আপনার অনুসন্ধানের সঙ্গে মেলে এমন কোনো শিক্ষক প্রোফাইল পাওয়া যায়নি।">No faculty profiles match your search.</p>
        <?php else: ?>
            <div class="faculty-empty-state">
                <strong data-en="Faculty records are not available yet." data-bn="শিক্ষক প্রোফাইল এখনো যুক্ত করা হয়নি।">Faculty records are not available yet.</strong>
                <p data-en="Import database-update.sql from the project package. The sample teacher profiles will then appear here and become editable from Admin → Leadership & Teachers." data-bn="প্রজেক্ট প্যাকেজের database-update.sql ইমপোর্ট করুন। এরপর নমুনা শিক্ষক প্রোফাইল এখানে দেখা যাবে এবং Admin → Leadership & Teachers থেকে সম্পাদনা করা যাবে।">Import database-update.sql from the project package. The sample teacher profiles will then appear here and become editable from Admin → Leadership & Teachers.</p>
            </div>
        <?php endif; ?>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('facultySearch');
        const cards = Array.from(document.querySelectorAll('[data-faculty-search]'));
        const empty = document.getElementById('facultyNoResults');
        if (!input) return;
        input.addEventListener('input', function() {
            const query = input.value.trim().toLocaleLowerCase();
            let visible = 0;
            cards.forEach(card => {
                const match = card.dataset.facultySearch.includes(query);
                card.hidden = !match;
                if (match) visible++;
            });
            if (empty) empty.hidden = visible !== 0;
        });
    });
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>