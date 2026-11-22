<?php
$footerAddress = setting('address', '');
$footerEmail = setting('email', '');
$footerPhone = setting('phone', '');
foreach (['footerAddress', 'footerEmail', 'footerPhone'] as $field) {
    if (stripos($$field, 'please update') !== false) $$field = '';
}
?>
<footer class="site-footer">
  <div class="footer-main">
    <div class="container footer-grid">
      <div class="footer-intro">
        <a href="index.php" class="footer-brand"><span class="brand-symbol">B</span><span><strong>BIAM</strong><small data-en="Laboratory School" data-bn="ল্যাবরেটরি স্কুল">Laboratory School</small></span></a>
        <p data-en="A place to discover potential, build confidence and prepare for a brighter future." data-bn="মেধা আবিষ্কার, আত্মবিশ্বাস গঠন এবং উজ্জ্বল ভবিষ্যতের প্রস্তুতির শিক্ষাঙ্গন।">A place to discover potential, build confidence and prepare for a brighter future.</p>
      </div>
      <div class="footer-column"><h3 data-en="Explore" data-bn="এক নজরে">Explore</h3><a href="academics.php" data-en="Academics" data-bn="একাডেমিক">Academics</a><a href="admission.php" data-en="Admission" data-bn="ভর্তি">Admission</a><a href="teachers.php" data-en="Teachers" data-bn="শিক্ষকমণ্ডলী">Teachers</a><a href="notices.php" data-en="News & Notices" data-bn="খবর ও নোটিশ">News &amp; Notices</a><a href="gallery.php" data-en="Photo Gallery" data-bn="ফটো গ্যালারি">Photo Gallery</a></div>
      <div class="footer-column"><h3 data-en="Student Services" data-bn="শিক্ষার্থী সেবা">Student Services</h3><a href="results.php" data-en="Examination Results" data-bn="পরীক্ষার ফলাফল">Examination Results</a><a href="students.php" data-en="Student Information" data-bn="শিক্ষার্থী তথ্য">Student Information</a><a href="portal/login.php" data-en="User Login" data-bn="ইউজার লগইন">User Login</a><a href="portal/register.php" data-en="Create Account" data-bn="অ্যাকাউন্ট তৈরি">Create Account</a></div>
      <div class="footer-column footer-contact"><h3 data-en="Contact" data-bn="যোগাযোগ">Contact</h3><?php if ($footerAddress): ?><p>⌖ <?= e($footerAddress) ?></p><?php endif; ?>
        <?php if ($footerEmail): ?><p>✉ <?= e($footerEmail) ?></p><?php endif; ?>
        <?php if ($footerPhone): ?><p>☎ <?= e($footerPhone) ?></p><?php endif; ?>
        <?php if (!$footerAddress && !$footerEmail && !$footerPhone): ?><p data-en="Official contact details will be published by the school." data-bn="বিদ্যালয় কর্তৃপক্ষের পক্ষ থেকে অফিসিয়াল যোগাযোগের তথ্য প্রকাশ করা হবে।">Official contact details will be published by the school.</p><?php endif; ?><a href="contact.php" data-en="Contact the school →" data-bn="বিদ্যালয়ে যোগাযোগ করুন →">Contact the school →</a></div>
    </div>
  </div>
  <div class="footer-bottom"><div class="container footer-bottom-inner"><p>© <?= date('Y') ?> <?= e(setting('school_name', 'BIAM Laboratory School')) ?>. <span data-en="All Rights Reserved." data-bn="সর্বস্বত্ব সংরক্ষিত।">All Rights Reserved.</span></p><p><span data-en="Designed & Developed by" data-bn="ওয়েবসাইট তৈরি করেছেন">Designed &amp; Developed by</span> <strong>Kawshik</strong></p></div></div>
</footer>
<script src="assets/js/script.js" defer></script>
</body>
</html>
