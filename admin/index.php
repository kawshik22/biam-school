<?php
require_once __DIR__ . '/../config.php';
require_admin();
$counts = [];
foreach (['notices', 'staff', 'achievements', 'gallery', 'admissions', 'messages', 'users'] as $table) {
  try {
    $counts[$table] = (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
  } catch (Throwable $e) {
    $counts[$table] = 0;
  }
}
try {
  $pending = (int)db()->query("SELECT COUNT(*) FROM users WHERE status='pending'")->fetchColumn();
} catch (Throwable $e) {
  $pending = 0;
}
try {
  $recentNotices = db()->query('SELECT title_en,publish_date,is_published FROM notices ORDER BY publish_date DESC,id DESC LIMIT 5')->fetchAll();
} catch (Throwable $e) {
  $recentNotices = [];
}
try {
  $pendingUsers = db()->query("SELECT full_name,email,account_type,created_at FROM users WHERE status='pending' ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch (Throwable $e) {
  $pendingUsers = [];
}
try {
  $galleryPreview = db()->query("SELECT title_en,image_path FROM gallery WHERE is_published=1 ORDER BY id DESC LIMIT 4")->fetchAll();
} catch (Throwable $e) {
  $galleryPreview = [];
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>BIAM CMS Dashboard</title>
  <link rel="stylesheet" href="admin.css">
</head>

<body>
  <div class="layout">
    <aside class="side">
      <h2>BIAM <span>CMS</span></h2>
      <p class="muted">Welcome, <?= e($_SESSION['admin_name'] ?? 'Administrator') ?></p>
      <nav>
        <a class="selected" href="index.php">▦ Dashboard</a><a href="manage.php?type=sections">Homepage & Hero</a><a href="manage.php?type=notices">News & Notices</a><a href="manage.php?type=achievements">Awards & Achievements</a><a href="manage.php?type=gallery">Photo Gallery</a><a href="manage.php?type=staff">Leadership & Teachers</a><a href="manage.php?type=pages">Page Content</a><a href="manage.php?type=settings">School Settings</a><a href="manage.php?type=users">User Approvals <b class="count-badge"><?= $pending ?></b></a><a href="manage.php?type=admissions">Admission Enquiries</a><a href="manage.php?type=messages">Contact Messages</a><a href="../index.php" target="_blank" rel="noopener">↗ View Website</a><a href="logout.php">Log Out</a>
      </nav>
      <div class="side-footer">Content management system<br>Student master records are maintained in MySQL/phpMyAdmin, not from this dashboard.</div>
    </aside>
    <main class="main">
      <div class="top">
        <div>
          <p class="eyebrow">CONTENT MANAGEMENT SYSTEM</p>
          <h1>Dashboard</h1>
          <p class="muted">Manage the public website, school updates and account requests.</p>
        </div>
        <div style="display:flex;gap:9px;align-items:center"><button id="languageToggle" class="admin-language-toggle" type="button">বাংলা</button><a class="btn" href="../index.php" target="_blank" rel="noopener">Preview Website ↗</a></div>
      </div>
      <div class="cards">
        <?php foreach (['notices' => 'News & notices', 'staff' => 'Leadership & teacher profiles', 'achievements' => 'Awards & achievements', 'gallery' => 'Published gallery images', 'admissions' => 'Admission enquiries', 'messages' => 'Contact messages', 'users' => 'Registered accounts'] as $key => $label): ?><div class="stat"><strong><?= number_format($counts[$key] ?? 0) ?></strong><span><?= e($label) ?></span></div><?php endforeach; ?>
      </div>
      <section class="media-preview-panel">
        <div class="media-preview-heading">
          <div>
            <p class="eyebrow">VISUAL CONTENT</p>
            <h2>Recently published photographs</h2>
            <p>Preview the images currently available on the public school website.</p>
          </div><a class="btn secondary" href="manage.php?type=gallery">Manage gallery</a>
        </div>
        <?php if ($galleryPreview): ?><div class="admin-media-grid"><?php foreach ($galleryPreview as $photo): ?><a href="manage.php?type=gallery" class="admin-media-card"><img src="../<?= e($photo['image_path']) ?>" alt="<?= e($photo['title_en']) ?>" loading="lazy"><span><?= e($photo['title_en']) ?></span></a><?php endforeach; ?></div><?php else: ?><p class="muted">No published photographs yet.</p><?php endif; ?>
      </section>
      <section class="panel">
        <div class="panel-head">
          <div>
            <h2>Manage website content</h2>
            <p>Update text, photographs and notices without editing website code.</p>
          </div>
        </div>
        <div class="module-grid">
          <a href="manage.php?type=sections"><b>Homepage & hero slides</b><span>Manage the main banner, introduction, messages and homepage content.</span></a>
          <a href="manage.php?type=notices"><b>News & notices</b><span>Publish, unpublish, search and paginate announcements.</span></a>
          <a href="manage.php?type=achievements"><b>Awards & achievements</b><span>Add student milestones and recognitions with photographs.</span></a>
          <a href="manage.php?type=gallery"><b>Photo gallery</b><span>Upload campus, facilities, events and school-life photographs.</span></a>
          <a href="manage.php?type=staff"><b>Leadership & teachers</b><span>Update designations, biographies and profile photographs.</span></a>
          <a href="manage.php?type=users"><b>User account approvals</b><span><?= $pending ?> registration request(s) waiting for administrator review.</span></a>
          <a href="manage.php?type=settings"><b>School settings</b><span>Update official address, phone, email and office hours.</span></a>
          <a href="manage.php?type=admissions"><b>Admission enquiries</b><span>Review submitted admission enquiries.</span></a>
          <a href="manage.php?type=messages"><b>Contact messages</b><span>Read messages submitted through the public website.</span></a>
        </div>
        <p class="note">Student records are intentionally not exposed as a dashboard CRUD module. As requested by the supervisor, maintain student master data using SQL queries in phpMyAdmin. Public result lookup uses the results table.</p>
      </section>
      <div class="dashboard-columns">
        <section class="panel">
          <div class="panel-head">
            <div>
              <h2>Recent notices</h2>
              <p>Latest records in the notice manager.</p>
            </div><a class="btn secondary" href="manage.php?type=notices">Manage</a>
          </div>
          <div class="recent-list"><?php if ($recentNotices): foreach ($recentNotices as $notice): ?><div class="recent-item"><span class="recent-date"><strong><?= e(date('d', strtotime($notice['publish_date']))) ?></strong><small><?= e(date('M', strtotime($notice['publish_date']))) ?></small></span>
                  <div><b><?= e($notice['title_en']) ?></b><small><?= !empty($notice['is_published']) ? 'Published' : 'Draft' ?></small></div>
                </div><?php endforeach;
                                    else: ?><div class="empty-note">No notice records yet.</div><?php endif; ?></div>
        </section>
        <section class="panel">
          <div class="panel-head">
            <div>
              <h2>Pending registrations</h2>
              <p>Accounts require approval before portal access.</p>
            </div><a class="btn secondary" href="manage.php?type=users">Review</a>
          </div>
          <div class="recent-list"><?php if ($pendingUsers): foreach ($pendingUsers as $user): ?><div class="recent-item"><span class="recent-date">♙</span>
                  <div><b><?= e($user['full_name']) ?></b><small><?= e(ucfirst($user['account_type'])) ?> · <?= e($user['email']) ?></small></div>
                </div><?php endforeach;
                                    else: ?><div class="empty-note">There are no pending account requests.</div><?php endif; ?></div>
        </section>
      </div>
    </main>
  </div>
  <script src="../assets/js/script.js" defer></script>
</body>

</html>