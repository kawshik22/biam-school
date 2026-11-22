<?php
require_once __DIR__ . '/config.php';

$defaults = [
  'hero' => ['title_en' => 'Learning today. Leading tomorrow.', 'title_bn' => 'আজকের শিক্ষা, আগামীর নেতৃত্ব', 'body_en' => 'A welcoming place where curiosity, creativity and confidence grow together.', 'body_bn' => 'কৌতূহল, সৃজনশীলতা ও আত্মবিশ্বাস একসঙ্গে বিকশিত হওয়ার একটি শিক্ষাবান্ধব পরিবেশ।', 'image_path' => 'assets/images/school/01-homepage-banner.jpg', 'button_text_en' => 'Discover our school', 'button_text_bn' => 'আমাদের বিদ্যালয় সম্পর্কে জানুন', 'button_url' => 'index.php#about'],
];
try {
  $slides = db()->query("SELECT * FROM site_sections WHERE section_key LIKE 'hero%' AND is_published=1 ORDER BY sort_order,id LIMIT 5")->fetchAll();
  $about = site_section('about') ?: ['title_en' => 'A place to learn, grow and achieve', 'title_bn' => 'শেখা, বেড়ে ওঠা ও সাফল্যের ঠিকানা', 'body_en' => 'BIAM Laboratory School aims to nurture curious minds through supportive teaching, meaningful experiences and a positive learning environment.', 'body_bn' => 'সহায়ক পাঠদান, অর্থবহ অভিজ্ঞতা ও ইতিবাচক শিক্ষার পরিবেশের মাধ্যমে শিক্ষার্থীদের বিকাশে বিয়াম ল্যাবরেটরি স্কুল কাজ করে।', 'image_path' => 'assets/images/school/04-modern-classroom.jpg'];
  $principalMessage = site_section('principal-message') ?: ['title_en' => 'A message from our school leadership', 'title_bn' => 'বিদ্যালয় নেতৃত্বের পক্ষ থেকে বার্তা', 'body_en' => 'We believe every learner deserves encouragement, opportunity and a safe place to discover their strengths. Together, we work to make learning purposeful and inspiring.', 'body_bn' => 'আমরা বিশ্বাস করি, প্রত্যেক শিক্ষার্থীর উৎসাহ, সুযোগ এবং নিজের সক্ষমতা আবিষ্কারের নিরাপদ পরিবেশ প্রাপ্য। অর্থবহ ও অনুপ্রেরণামূলক শিক্ষা নিশ্চিত করতে আমরা একসঙ্গে কাজ করি।', 'image_path' => 'assets/images/school/16-principals-message.jpg'];
  $highlights = db()->query("SELECT * FROM site_sections WHERE section_key LIKE 'highlight-%' AND is_published=1 ORDER BY sort_order,id LIMIT 6")->fetchAll();
  $notices = db()->query('SELECT id,title_en,title_bn,body_en,body_bn,publish_date FROM notices WHERE is_published=1 AND publish_date<=CURDATE() ORDER BY publish_date DESC,id DESC LIMIT 5')->fetchAll();
  $leaders = db()->query("SELECT * FROM staff WHERE is_published=1 AND category='leadership' ORDER BY sort_order,id LIMIT 3")->fetchAll();
  $teachers = db()->query("SELECT * FROM staff WHERE is_published=1 AND category='teacher' ORDER BY sort_order,id LIMIT 5")->fetchAll();
  $achievements = db()->query('SELECT * FROM achievements WHERE is_published=1 ORDER BY achievement_date DESC,id DESC LIMIT 3')->fetchAll();
  $gallery = db()->query('SELECT * FROM gallery WHERE is_published=1 ORDER BY id DESC LIMIT 8')->fetchAll();
  $counts = [
    'teachers' => (int)db()->query("SELECT COUNT(*) FROM staff WHERE is_published=1 AND category='teacher'")->fetchColumn(),
    'notices' => (int)db()->query('SELECT COUNT(*) FROM notices WHERE is_published=1 AND publish_date<=CURDATE()')->fetchColumn(),
    'gallery' => (int)db()->query('SELECT COUNT(*) FROM gallery WHERE is_published=1')->fetchColumn(),
    'achievements' => (int)db()->query('SELECT COUNT(*) FROM achievements WHERE is_published=1')->fetchColumn(),
  ];
} catch (Throwable $ex) {
  $slides = $highlights = $notices = $leaders = $teachers = $achievements = $gallery = [];
  $about = ['title_en' => 'A place to learn, grow and achieve', 'title_bn' => 'শেখা, বেড়ে ওঠা ও সাফল্যের ঠিকানা', 'body_en' => 'BIAM Laboratory School aims to nurture curious minds through supportive teaching, meaningful experiences and a positive learning environment.', 'body_bn' => 'সহায়ক পাঠদান, অর্থবহ অভিজ্ঞতা ও ইতিবাচক শিক্ষার পরিবেশের মাধ্যমে শিক্ষার্থীদের বিকাশে বিয়াম ল্যাবরেটরি স্কুল কাজ করে।', 'image_path' => 'assets/images/school/04-modern-classroom.jpg'];
  $principalMessage = ['title_en' => 'A message from our school leadership', 'title_bn' => 'বিদ্যালয় নেতৃত্বের পক্ষ থেকে বার্তা', 'body_en' => 'We believe every learner deserves encouragement, opportunity and a safe place to discover their strengths.', 'body_bn' => 'আমরা বিশ্বাস করি, প্রত্যেক শিক্ষার্থীর উৎসাহ, সুযোগ এবং নিজের সক্ষমতা আবিষ্কারের নিরাপদ পরিবেশ প্রাপ্য।', 'image_path' => 'assets/images/school/16-principals-message.jpg'];
  $counts = ['teachers' => 0, 'notices' => 0, 'gallery' => 0, 'achievements' => 0];
}
if (!$slides) $slides = [
  $defaults['hero'],
  ['title_en' => 'Curiosity opens new possibilities', 'title_bn' => 'কৌতূহল খুলে দেয় নতুন সম্ভাবনার দুয়ার', 'body_en' => 'Explore ideas, ask questions and learn by doing in an engaging environment.', 'body_bn' => 'আকর্ষণীয় পরিবেশে ধারণা অন্বেষণ, প্রশ্ন করা এবং হাতে-কলমে শেখার সুযোগ।', 'image_path' => 'assets/images/school/04-modern-classroom.jpg', 'button_text_en' => 'Explore learning', 'button_text_bn' => 'শেখার পরিবেশ দেখুন', 'button_url' => 'gallery.php'],
  ['title_en' => 'Learning through discovery', 'title_bn' => 'আবিষ্কারের মাধ্যমে শিক্ষা', 'body_en' => 'Build knowledge and practical skills through exploration and active learning.', 'body_bn' => 'অন্বেষণ ও সক্রিয় শিক্ষার মাধ্যমে জ্ঞান ও ব্যবহারিক দক্ষতা গড়ে তুলুন।', 'image_path' => 'assets/images/school/05-science-laboratory.jpg', 'button_text_en' => 'See our facilities', 'button_text_bn' => 'সুযোগ-সুবিধা দেখুন', 'button_url' => 'gallery.php'],
  ['title_en' => 'Every learner has a place to shine', 'title_bn' => 'প্রতিটি শিক্ষার্থীর বিকশিত হওয়ার সুযোগ আছে', 'body_en' => 'A supportive school community encourages participation, creativity and confidence.', 'body_bn' => 'সহায়ক বিদ্যালয় পরিবার অংশগ্রহণ, সৃজনশীলতা ও আত্মবিশ্বাসে উৎসাহ দেয়।', 'image_path' => 'assets/images/school/11-teachers-and-students.jpg', 'button_text_en' => 'Explore student life', 'button_text_bn' => 'শিক্ষার্থী জীবন দেখুন', 'button_url' => 'gallery.php']
];
$slides = array_slice($slides, 0, 4);
include __DIR__ . '/includes/header.php';
?>
<main>
  <section class="visual-hero" aria-label="School highlights">
    <div class="hero-slides" id="heroSlides">
      <?php foreach ($slides as $i => $slide): $image = $slide['image_path'] ?? 'assets/images/school/01-homepage-banner.jpg'; ?>
        <article class="hero-slide<?= $i === 0 ? ' is-current' : '' ?>" data-slide="<?= (int)$i ?>" aria-hidden="<?= $i === 0 ? 'false' : 'true' ?>">
          <img class="hero-image" src="<?= e($image) ?>" alt="<?= e($slide['title_en'] ?? 'School campus and learning') ?>" <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
          <div class="hero-film"></div>
          <div class="container hero-content-wrap">
            <div class="hero-copy-block">
              <span class="hero-eyebrow" data-en="LEARN · DISCOVER · ACHIEVE" data-bn="শিখি · আবিষ্কার করি · এগিয়ে যাই">LEARN · DISCOVER · ACHIEVE</span>
              <h1 data-en="<?= e($slide['title_en'] ?? '') ?>" data-bn="<?= e(($slide['title_bn'] ?? '') ?: ($slide['title_en'] ?? '')) ?>"><?= e($slide['title_en'] ?? '') ?></h1>
              <p data-en="<?= e($slide['body_en'] ?? '') ?>" data-bn="<?= e(($slide['body_bn'] ?? '') ?: ($slide['body_en'] ?? '')) ?>"><?= e($slide['body_en'] ?? '') ?></p>
              <div class="hero-actions">
                <a class="button button-gold" href="<?= e($slide['button_url'] ?? 'index.php#about') ?>" data-en="<?= e(($slide['button_text_en'] ?? '') ?: 'Discover our school') ?>" data-bn="<?= e(($slide['button_text_bn'] ?? '') ?: 'আমাদের বিদ্যালয় সম্পর্কে জানুন') ?>"><?= e(($slide['button_text_en'] ?? '') ?: 'Discover our school') ?> <span aria-hidden="true">↗</span></a>
                <a class="button button-glass" href="admission.php" data-en="Admission information" data-bn="ভর্তি সংক্রান্ত তথ্য">Admission information</a>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="container hero-bottom-bar">
      <div class="hero-caption"><span data-en="A COMMUNITY OF LEARNING" data-bn="শেখার এক সম্মিলিত পরিবার">A COMMUNITY OF LEARNING</span><small data-en="Every day is an opportunity to grow." data-bn="প্রতিটি দিনই এগিয়ে যাওয়ার নতুন সুযোগ।">Every day is an opportunity to grow.</small></div>
      <div class="hero-controls"><button class="hero-arrow" type="button" data-hero-prev aria-label="Previous slide">‹</button>
        <div class="hero-dots" id="heroDots" aria-label="Choose hero slide"><?php foreach ($slides as $i => $slide): ?><button type="button" class="hero-dot<?= $i === 0 ? ' is-active' : '' ?>" data-hero-dot="<?= (int)$i ?>" aria-label="Slide <?= (int)$i + 1 ?>"></button><?php endforeach; ?></div><button class="hero-arrow" type="button" data-hero-next aria-label="Next slide">›</button>
      </div>
    </div>
  </section>

  <section class="quick-access-wrap" aria-label="Quick access">
    <div class="container quick-access">
      <a href="admission.php"><span class="quick-icon">✦</span><span><strong data-en="Admissions" data-bn="ভর্তি">Admissions</strong><small data-en="Application information" data-bn="আবেদনের তথ্য">Application information</small></span><b>↗</b></a>
      <a href="results.php"><span class="quick-icon">▤</span><span><strong data-en="Results" data-bn="ফলাফল">Results</strong><small data-en="Examination results" data-bn="পরীক্ষার ফলাফল">Examination results</small></span><b>↗</b></a>
      <a href="notices.php"><span class="quick-icon">▣</span><span><strong data-en="Notices" data-bn="নোটিশ">Notices</strong><small data-en="Updates and announcements" data-bn="আপডেট ও ঘোষণা">Updates and announcements</small></span><b>↗</b></a>
      <a href="portal/login.php"><span class="quick-icon">♙</span><span><strong data-en="User Portal" data-bn="ইউজার পোর্টাল">User Portal</strong><small data-en="Student and teacher access" data-bn="শিক্ষার্থী ও শিক্ষকের প্রবেশ">Student and teacher access</small></span><b>↗</b></a>
    </div>
  </section>

  <section class="intro-section section-space" id="about">
    <div class="container intro-layout">
      <div class="intro-visual reveal"><img src="<?= e($about['image_path'] ?: 'assets/images/school/04-modern-classroom.jpg') ?>" alt="Students learning in a classroom" loading="lazy" decoding="async">
        <div class="intro-image-caption"><span>✦</span><strong data-en="Learning with purpose" data-bn="উদ্দেশ্যপূর্ণ শিক্ষা">Learning with purpose</strong></div>
      </div>
      <div class="intro-copy reveal"><span class="section-label" data-en="WELCOME TO OUR SCHOOL" data-bn="আমাদের বিদ্যালয়ে স্বাগতম">WELCOME TO OUR SCHOOL</span>
        <h2 data-en="<?= e($about['title_en']) ?>" data-bn="<?= e($about['title_bn'] ?: $about['title_en']) ?>"><?= e($about['title_en']) ?></h2>
        <p data-en="<?= e($about['body_en']) ?>" data-bn="<?= e($about['body_bn'] ?: $about['body_en']) ?>"><?= e($about['body_en']) ?></p><a class="underlined-link" href="administration.php" data-en="Discover our school →" data-bn="আমাদের বিদ্যালয় সম্পর্কে জানুন →">Discover our school →</a>
      </div>
    </div>
  </section>

  <section class="school-facts">
    <div class="container facts-grid">
      <div class="fact-item"><strong><?= number_format($counts['teachers']) ?></strong><span data-en="Published teacher profiles" data-bn="প্রকাশিত শিক্ষক প্রোফাইল">Published teacher profiles</span></div>
      <div class="fact-item"><strong><?= number_format($counts['notices']) ?></strong><span data-en="Published notices" data-bn="প্রকাশিত নোটিশ">Published notices</span></div>
      <div class="fact-item"><strong><?= number_format($counts['achievements']) ?></strong><span data-en="Achievement stories" data-bn="অর্জনের গল্প">Achievement stories</span></div>
      <div class="fact-item"><strong><?= number_format($counts['gallery']) ?></strong><span data-en="Gallery moments" data-bn="গ্যালারির ছবি">Gallery moments</span></div>
    </div>
  </section>

  <section class="why-section section-space">
    <div class="container">
      <div class="section-heading reveal"><span class="section-label" data-en="THE LEARNING EXPERIENCE" data-bn="শিক্ষার অভিজ্ঞতা">THE LEARNING EXPERIENCE</span>
        <h2 data-en="An environment where potential can flourish" data-bn="যে পরিবেশে বিকশিত হয় সম্ভাবনা">An environment where potential can flourish</h2>
        <p data-en="Learning is more than lessons. It is curiosity, participation, friendship and discovering what you can do." data-bn="শিক্ষা শুধু পাঠ্যবই নয়। শিক্ষা হলো কৌতূহল, অংশগ্রহণ, বন্ধুত্ব এবং নিজের সক্ষমতা আবিষ্কার।">Learning is more than lessons. It is curiosity, participation, friendship and discovering what you can do.</p>
      </div>
      <div class="learning-grid"><?php if ($highlights): foreach ($highlights as $i => $item): ?><article class="learning-card reveal"><span class="learning-number"><?= sprintf('%02d', $i + 1) ?></span>
              <h3 data-en="<?= e($item['title_en']) ?>" data-bn="<?= e($item['title_bn'] ?: $item['title_en']) ?>"><?= e($item['title_en']) ?></h3>
              <p data-en="<?= e($item['body_en'] ?? '') ?>" data-bn="<?= e(($item['body_bn'] ?? '') ?: ($item['body_en'] ?? '')) ?>"><?= e($item['body_en'] ?? '') ?></p>
            </article><?php endforeach;
                                  else: ?>
          <article class="learning-card reveal"><span class="learning-number">01</span>
            <h3 data-en="Supportive learning" data-bn="সহায়ক শিক্ষার পরিবেশ">Supportive learning</h3>
            <p data-en="A positive environment that encourages questions, confidence and growth." data-bn="প্রশ্ন, আত্মবিশ্বাস ও বিকাশে উৎসাহ জোগানো ইতিবাচক পরিবেশ।">A positive environment that encourages questions, confidence and growth.</p>
          </article>
          <article class="learning-card reveal"><span class="learning-number">02</span>
            <h3 data-en="Learning by doing" data-bn="কাজের মাধ্যমে শেখা">Learning by doing</h3>
            <p data-en="Meaningful classroom and practical activities help connect ideas with experience." data-bn="অর্থবহ শ্রেণিকক্ষ ও ব্যবহারিক কার্যক্রম ধারণার সঙ্গে অভিজ্ঞতার যোগসূত্র তৈরি করে।">Meaningful classroom and practical activities help connect ideas with experience.</p>
          </article>
          <article class="learning-card reveal"><span class="learning-number">03</span>
            <h3 data-en="A wider school life" data-bn="বিস্তৃত বিদ্যালয় জীবন">A wider school life</h3>
            <p data-en="Creative, cultural and sporting activities make school life richer." data-bn="সৃজনশীল, সাংস্কৃতিক ও ক্রীড়া কার্যক্রম বিদ্যালয় জীবনকে সমৃদ্ধ করে।">Creative, cultural and sporting activities make school life richer.</p>
          </article><?php endif; ?>
      </div>
    </div>
  </section>

  <section class="facilities-section section-space">
    <div class="container">
      <div class="section-heading-row reveal">
        <div><span class="section-label" data-en="CAMPUS & FACILITIES" data-bn="ক্যাম্পাস ও সুযোগ-সুবিধা">CAMPUS &amp; FACILITIES</span>
          <h2 data-en="Spaces that inspire learning" data-bn="শেখার অনুপ্রেরণায় সাজানো পরিসর">Spaces that inspire learning</h2>
          <p data-en="Take a look at the spaces and activities that support everyday learning." data-bn="দৈনন্দিন শিক্ষাকে সহায়তা করে এমন স্থান ও কার্যক্রমগুলো দেখে নিন।">Take a look at the spaces and activities that support everyday learning.</p>
        </div><a class="underlined-link" href="gallery.php" data-en="View all facilities →" data-bn="সব ছবি দেখুন →">View all facilities →</a>
      </div>
      <div class="facilities-grid">
        <a class="facility-card facility-large reveal" href="gallery.php"><img src="assets/images/school/03-school-library.jpg" alt="School library" loading="lazy" decoding="async"><span class="facility-overlay"><small data-en="READ · EXPLORE · DISCOVER" data-bn="পড়ি · অন্বেষণ করি · আবিষ্কার করি">READ · EXPLORE · DISCOVER</small><strong data-en="School Library" data-bn="বিদ্যালয় পাঠাগার">School Library</strong></span></a>
        <a class="facility-card reveal" href="gallery.php"><img src="assets/images/school/04-modern-classroom.jpg" alt="Modern classroom" loading="lazy" decoding="async"><span class="facility-overlay"><small data-en="ACTIVE LEARNING" data-bn="সক্রিয় শিক্ষা">ACTIVE LEARNING</small><strong data-en="Classrooms" data-bn="শ্রেণিকক্ষ">Classrooms</strong></span></a>
        <a class="facility-card reveal" href="gallery.php"><img src="assets/images/school/05-science-laboratory.jpg" alt="Science laboratory" loading="lazy" decoding="async"><span class="facility-overlay"><small data-en="LEARN BY DISCOVERY" data-bn="আবিষ্কারের মাধ্যমে শিক্ষা">LEARN BY DISCOVERY</small><strong data-en="Science Laboratory" data-bn="বিজ্ঞানাগার">Science Laboratory</strong></span></a>
        <a class="facility-card reveal" href="gallery.php"><img src="assets/images/school/06-computer-laboratory.jpg" alt="Computer laboratory" loading="lazy" decoding="async"><span class="facility-overlay"><small data-en="DIGITAL SKILLS" data-bn="ডিজিটাল দক্ষতা">DIGITAL SKILLS</small><strong data-en="Computer Laboratory" data-bn="কম্পিউটার ল্যাব">Computer Laboratory</strong></span></a>
        <a class="facility-card reveal" href="gallery.php"><img src="assets/images/school/08-school-sports-field.jpg" alt="School sports field" loading="lazy" decoding="async"><span class="facility-overlay"><small data-en="PLAY · TEAMWORK · GROW" data-bn="খেলি · দলবদ্ধ হই · বেড়ে উঠি">PLAY · TEAMWORK · GROW</small><strong data-en="Sports & Playground" data-bn="খেলাধুলা ও মাঠ">Sports &amp; Playground</strong></span></a>
      </div>
    </div>
  </section>

  <section class="notice-section section-space" id="notice-board">
    <div class="container notice-layout">
      <div class="notice-intro reveal"><span class="section-label" data-en="SCHOOL UPDATES" data-bn="বিদ্যালয়ের আপডেট">SCHOOL UPDATES</span>
        <h2 data-en="Latest news & notices" data-bn="সর্বশেষ খবর ও নোটিশ">Latest news &amp; notices</h2>
        <p data-en="Stay connected with school announcements, academic updates and important information." data-bn="বিদ্যালয়ের ঘোষণা, একাডেমিক আপডেট ও গুরুত্বপূর্ণ তথ্যের সঙ্গে যুক্ত থাকুন।">Stay connected with school announcements, academic updates and important information.</p><a class="button button-navy" href="notices.php" data-en="Browse all notices →" data-bn="সব নোটিশ দেখুন →">Browse all notices →</a>
      </div>
      <div class="notice-list reveal"><?php if ($notices): foreach ($notices as $n): ?><a class="notice-row" href="notices.php"><span class="notice-calendar"><strong><?= date('d', strtotime($n['publish_date'])) ?></strong><small><?= e(date('M Y', strtotime($n['publish_date']))) ?></small></span><span class="notice-text"><strong data-en="<?= e($n['title_en']) ?>" data-bn="<?= e($n['title_bn'] ?: $n['title_en']) ?>"><?= e($n['title_en']) ?></strong><small data-en="<?= e(short_text($n['body_en'] ?? '', 105)) ?>" data-bn="<?= e(short_text(($n['body_bn'] ?: ($n['body_en'] ?? '')), 105)) ?>"><?= e(short_text($n['body_en'] ?? '', 105)) ?></small></span><span class="notice-arrow" aria-hidden="true">↗</span></a><?php endforeach;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              else: ?><div class="empty-state" data-en="New school notices will appear here." data-bn="বিদ্যালয়ের নতুন নোটিশ এখানে প্রকাশিত হবে।">New school notices will appear here.</div><?php endif; ?></div>
    </div>
  </section>

  <?php if ($achievements): ?><section class="achievement-section section-space">
      <div class="container">
        <div class="section-heading-row reveal">
          <div><span class="section-label" data-en="MILESTONES & MOMENTS" data-bn="অর্জন ও স্মরণীয় মুহূর্ত">MILESTONES &amp; MOMENTS</span>
            <h2 data-en="Celebrating achievements" data-bn="অর্জনকে উদযাপন">Celebrating achievements</h2>
            <p data-en="Stories of effort, participation and progress from our school community." data-bn="বিদ্যালয় পরিবারের প্রচেষ্টা, অংশগ্রহণ ও অগ্রগতির গল্প।">Stories of effort, participation and progress from our school community.</p>
          </div>
        </div>
        <div class="achievement-cards"><?php foreach ($achievements as $a): ?><article class="achievement-tile reveal"><?php if ($a['image_path']): ?><img src="<?= e($a['image_path']) ?>" alt="<?= e($a['title_en']) ?>" loading="lazy" decoding="async"><?php endif; ?><div><small><?= e($a['achievement_date'] ?? '') ?></small>
                <h3 data-en="<?= e($a['title_en']) ?>" data-bn="<?= e($a['title_bn'] ?: $a['title_en']) ?>"><?= e($a['title_en']) ?></h3>
                <p data-en="<?= e($a['description_en'] ?? '') ?>" data-bn="<?= e(($a['description_bn'] ?? '') ?: ($a['description_en'] ?? '')) ?>"><?= e($a['description_en'] ?? '') ?></p>
              </div>
            </article><?php endforeach; ?></div>
      </div>
    </section><?php endif; ?>

  <section class="message-section section-space">
    <div class="container message-layout">
      <div class="message-photo reveal"><img src="<?= e($principalMessage['image_path'] ?: 'assets/images/school/16-principals-message.jpg') ?>" alt="School leadership message" loading="lazy" decoding="async"><span class="message-photo-tag" data-en="LEADERSHIP MESSAGE" data-bn="নেতৃত্বের বার্তা">LEADERSHIP MESSAGE</span></div>
      <div class="message-copy reveal"><span class="section-label" data-en="A NOTE TO OUR COMMUNITY" data-bn="আমাদের বিদ্যালয় পরিবারের প্রতি">A NOTE TO OUR COMMUNITY</span>
        <h2 data-en="<?= e($principalMessage['title_en']) ?>" data-bn="<?= e($principalMessage['title_bn'] ?: $principalMessage['title_en']) ?>"><?= e($principalMessage['title_en']) ?></h2>
        <p data-en="<?= e($principalMessage['body_en']) ?>" data-bn="<?= e($principalMessage['body_bn'] ?: $principalMessage['body_en']) ?>"><?= e($principalMessage['body_en']) ?></p><a class="underlined-link" href="administration.php" data-en="Meet the leadership team →" data-bn="নেতৃত্বের সঙ্গে পরিচিত হোন →">Meet the leadership team →</a>
      </div>
    </div>
  </section>

  <?php if ($leaders || $teachers): ?><section class="people-section section-space">
      <div class="container">
        <div class="section-heading-row reveal">
          <div><span class="section-label" data-en="OUR PEOPLE" data-bn="আমাদের মানুষ">OUR PEOPLE</span>
            <h2 data-en="Guiding and supporting every learner" data-bn="প্রতিটি শিক্ষার্থীর পাশে আমাদের শিক্ষকবৃন্দ">Guiding and supporting every learner</h2>
          </div><a href="teachers.php" class="underlined-link" data-en="Meet all teachers →" data-bn="সব শিক্ষকের পরিচিতি →">Meet all teachers →</a>
        </div>
        <p class="demo-home-note" data-en="Sample faculty and leadership profiles are shown for demonstration. Replace with approved BIAM information before publishing." data-bn="প্রদর্শনের জন্য নমুনা শিক্ষক ও নেতৃত্বের প্রোফাইল দেখানো হয়েছে। প্রকাশের আগে অনুমোদিত বিয়াম তথ্য দিয়ে প্রতিস্থাপন করুন।">Sample faculty and leadership profiles are shown for demonstration. Replace with approved BIAM information before publishing.</p>
        <div class="people-cards"><?php foreach (array_slice(array_merge($teachers, $leaders), 0, 4) as $person): $personName = trim((string)$person['name_en']);
                                    $personInitials = '';
                                    foreach (preg_split('/\s+/', $personName) as $part) {
                                      if ($part !== '') $personInitials .= strtoupper(substr($part, 0, 1));
                                      if (strlen($personInitials) >= 2) break;
                                    } ?><article class="people-card reveal"><?php if (!empty($person['photo']) && is_file(__DIR__ . '/' . $person['photo'])): ?><img src="<?= e($person['photo']) ?>" alt="Demo portrait of <?= e($personName) ?>" loading="lazy" decoding="async"><?php else: ?><div class="people-avatar" aria-hidden="true"><?= e($personInitials ?: 'BI') ?></div><?php endif; ?><div><small data-en="<?= e($person['designation_en'] ?? '') ?>" data-bn="<?= e(($person['designation_bn'] ?? '') ?: ($person['designation_en'] ?? '')) ?>"><?= e($person['designation_en'] ?? '') ?></small>
                <h3 data-en="<?= e($person['name_en']) ?>" data-bn="<?= e($person['name_bn'] ?: $person['name_en']) ?>"><?= e($person['name_en']) ?></h3>
                <p data-en="<?= e(short_text($person['bio_en'] ?? '', 105)) ?>" data-bn="<?= e(short_text(($person['bio_bn'] ?: ($person['bio_en'] ?? '')), 105)) ?>"><?= e(short_text($person['bio_en'] ?? '', 105)) ?></p>
              </div>
            </article><?php endforeach; ?></div>
      </div>
    </section><?php endif; ?>

  <section class="school-life-section section-space">
    <div class="container">
      <div class="section-heading-row reveal">
        <div><span class="section-label" data-en="SCHOOL LIFE" data-bn="বিদ্যালয় জীবন">SCHOOL LIFE</span>
          <h2 data-en="More than a classroom" data-bn="শ্রেণিকক্ষের বাইরেও অনেক কিছু">More than a classroom</h2>
          <p data-en="Shared experiences, activities and moments make every school day memorable." data-bn="অভিজ্ঞতা, কার্যক্রম ও আনন্দঘন মুহূর্ত প্রতিটি স্কুলের দিনকে স্মরণীয় করে তোলে।">Shared experiences, activities and moments make every school day memorable.</p>
        </div><a href="gallery.php" class="underlined-link" data-en="Explore the gallery →" data-bn="গ্যালারি দেখুন →">Explore the gallery →</a>
      </div>
      <div class="life-gallery">
        <?php $lifeImages = [['assets/images/school/11-teachers-and-students.jpg', 'Teachers & Students', 'শিক্ষক ও শিক্ষার্থী'], ['assets/images/school/12-cultural-activities.jpg', 'Cultural Activities', 'সাংস্কৃতিক কার্যক্রম'], ['assets/images/school/13-school-events.jpg', 'School Events', 'বিদ্যালয়ের অনুষ্ঠান'], ['assets/images/school/17-student-activities.jpg', 'Student Activities', 'শিক্ষার্থীদের কার্যক্রম']];
        foreach ($lifeImages as $i => $pic): ?><a class="life-image life-image-<?= $i + 1 ?> reveal" href="gallery.php"><img src="<?= e($pic[0]) ?>" alt="<?= e($pic[1]) ?>" loading="lazy" decoding="async"><span data-en="<?= e($pic[1]) ?>" data-bn="<?= e($pic[2]) ?>"><?= e($pic[1]) ?></span></a><?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="portal-banner">
    <div class="container portal-banner-inner reveal">
      <div><span class="section-label" data-en="STUDENT & TEACHER SERVICES" data-bn="শিক্ষার্থী ও শিক্ষক সেবা">STUDENT &amp; TEACHER SERVICES</span>
        <h2 data-en="Your school services, in one place" data-bn="বিদ্যালয়ের প্রয়োজনীয় সেবা এক জায়গায়">Your school services, in one place</h2>
        <p data-en="Sign in with an approved account to access the services available to you." data-bn="অনুমোদিত অ্যাকাউন্ট দিয়ে লগইন করে আপনার জন্য নির্ধারিত সেবা ব্যবহার করুন।">Sign in with an approved account to access the services available to you.</p>
      </div><a class="button button-gold" href="portal/login.php" data-en="Open user portal →" data-bn="ইউজার পোর্টাল খুলুন →">Open user portal →</a>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>