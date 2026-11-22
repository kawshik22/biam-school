<?php
require_once __DIR__ . '/../config.php';
$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$lang = (($_COOKIE['biam-language'] ?? 'en') === 'bn') ? 'bn' : 'en';
$phone = setting('phone', '');
$email = setting('email', '');
if (stripos($email, 'please update') !== false) $email = '';
if (stripos($phone, 'please update') !== false) $phone = '';
try {
  $tickerRows = db()->query("SELECT id,title_en,title_bn FROM notices WHERE is_published=1 ORDER BY publish_date DESC,id DESC LIMIT 6")->fetchAll();
} catch (Throwable $ex) {
  $tickerRows = [];
}
function nav_active(string $file, string $currentPage): string
{
  return $file === $currentPage ? ' is-active' : '';
}
?>
<!doctype html>
<html lang="<?= e($lang) ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#102b4e">
  <meta name="description" content="BIAM Laboratory School — learning, discovery, creativity and student development.">
  <title><?= e(setting('school_name', 'BIAM Laboratory School')) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="utility-bar">
    <div class="container utility-inner">
      <div class="utility-contact">
        <?php if ($email): ?><a href="mailto:<?= e($email) ?>">✉ <?= e($email) ?></a><?php endif; ?>
        <?php if ($phone): ?><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>">☎ <?= e($phone) ?></a><?php endif; ?>
        <?php if (!$email && !$phone): ?><span data-en="Official school website" data-bn="বিদ্যালয়ের অফিসিয়াল ওয়েবসাইট">Official school website</span><?php endif; ?>
      </div>
      <div class="utility-actions">
        <a href="notices.php" data-en="Notices" data-bn="নোটিশ">Notices</a>
        <a href="results.php" data-en="Results" data-bn="ফলাফল">Results</a>
        <a href="admission.php" data-en="Admission" data-bn="ভর্তি">Admission</a>
        <button id="languageToggle" class="language-toggle" type="button" aria-label="Change language">বাংলা</button>
      </div>
    </div>
  </div>
  <header class="compact-header">
    <div class="container compact-header-inner">
      <a href="index.php" class="brand-compact" aria-label="BIAM Laboratory School home">
        <span class="brand-symbol" aria-hidden="true">B</span>
        <span class="brand-wordmark"><strong data-en="BIAM" data-bn="বিয়াম">BIAM</strong><small data-en="Laboratory School" data-bn="ল্যাবরেটরি স্কুল">Laboratory School</small></span>
      </a>
      <div class="header-quick-actions">
        <a class="quick-admission" href="admission.php" data-en="Apply for Admission" data-bn="ভর্তির আবেদন">Apply for Admission <span aria-hidden="true">↗</span></a>
        <a class="header-login" href="portal/login.php" aria-label="Login" title="Login"><span aria-hidden="true">♙</span><small data-en="Login" data-bn="লগইন">Login</small></a>
      </div>
    </div>
  </header>
  <nav class="institution-nav" aria-label="Main navigation">
    <div class="container nav-shell">
      <button class="mobile-menu-toggle" type="button" aria-expanded="false" aria-controls="primaryNav"><span aria-hidden="true">☰</span><span data-en="Menu" data-bn="মেনু">Menu</span></button>
      <ul id="primaryNav" class="primary-nav">
        <li><a class="nav-link<?= nav_active('index.php', $currentPage) ?>" href="index.php" data-en="Home" data-bn="হোম">Home</a></li>
        <li class="nav-dropdown">
          <details>
            <summary data-en="About Us" data-bn="আমাদের সম্পর্কে">About Us</summary>
            <div class="dropdown-menu"><a href="index.php#about" data-en="School Overview" data-bn="বিদ্যালয় পরিচিতি">School Overview</a><a href="administration.php" data-en="Administration" data-bn="প্রশাসন">Administration</a><a href="teachers.php" data-en="Faculty & Teachers" data-bn="শিক্ষক ও শিক্ষকমণ্ডলী">Faculty &amp; Teachers</a></div>
          </details>
        </li>
        <li><a class="nav-link<?= nav_active('academics.php', $currentPage) ?>" href="academics.php" data-en="Academics" data-bn="একাডেমিক">Academics</a></li>
        <li><a class="nav-link<?= nav_active('admission.php', $currentPage) ?>" href="admission.php" data-en="Admission" data-bn="ভর্তি">Admission</a></li>
        <li class="nav-dropdown">
          <details>
            <summary data-en="Students" data-bn="শিক্ষার্থী">Students</summary>
            <div class="dropdown-menu"><a href="students.php" data-en="Student Information" data-bn="শিক্ষার্থী তথ্য">Student Information</a><a href="results.php" data-en="Examination Results" data-bn="পরীক্ষার ফলাফল">Examination Results</a><a href="portal/login.php" data-en="Student Portal" data-bn="শিক্ষার্থী পোর্টাল">Student Portal</a></div>
          </details>
        </li>
        <li><a class="nav-link<?= nav_active('gallery.php', $currentPage) ?>" href="gallery.php" data-en="Facilities & Gallery" data-bn="সুযোগ-সুবিধা ও গ্যালারি">Facilities &amp; Gallery</a></li>
        <li><a class="nav-link<?= nav_active('notices.php', $currentPage) ?>" href="notices.php" data-en="News & Notices" data-bn="খবর ও নোটিশ">News &amp; Notices</a></li>
        <li><a class="nav-link<?= nav_active('contact.php', $currentPage) ?>" href="contact.php" data-en="Contact" data-bn="যোগাযোগ">Contact</a></li>
      </ul>
    </div>
  </nav>
  <div class="notice-ticker" aria-label="Latest school notices">
    <div class="ticker-label"><span aria-hidden="true">▣</span><span data-en="LATEST UPDATES" data-bn="সর্বশেষ আপডেট">LATEST UPDATES</span></div>
    <div class="ticker-window">
      <?php if ($tickerRows): ?>
        <div class="ticker-track">
          <?php foreach ([0, 1] as $copy): ?><div class="ticker-group" <?= $copy ? 'aria-hidden="true"' : '' ?>>
              <?php foreach ($tickerRows as $item): ?><span class="ticker-item"><i aria-hidden="true"></i><span data-en="<?= e($item['title_en']) ?>" data-bn="<?= e($item['title_bn'] ?: $item['title_en']) ?>"><?= e($item['title_en']) ?></span></span><?php endforeach; ?>
            </div><?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="ticker-static" data-en="School notices and important announcements will appear here." data-bn="বিদ্যালয়ের নোটিশ ও গুরুত্বপূর্ণ ঘোষণা এখানে প্রকাশিত হবে।">School notices and important announcements will appear here.</div>
      <?php endif; ?>
    </div>
    <a class="ticker-more" href="notices.php" data-en="All notices →" data-bn="সব নোটিশ →">All notices →</a>
  </div>