<?php
require_once __DIR__ . '/config.php';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 24;
try {
  $total = (int)db()->query('SELECT COUNT(*) FROM gallery WHERE is_published=1')->fetchColumn();
  $q = db()->prepare('SELECT * FROM gallery WHERE is_published=1 ORDER BY id DESC LIMIT ? OFFSET ?');
  $q->bindValue(1, $perPage, PDO::PARAM_INT);
  $q->bindValue(2, ($page - 1) * $perPage, PDO::PARAM_INT);
  $q->execute();
  $rows = $q->fetchAll();
} catch (Throwable $e) {
  $total = 0;
  $rows = [];
}
include __DIR__ . '/includes/header.php';
?>
<main class="container section-pad">
  <div class="page-banner"><span data-en="CAMPUS MOMENTS" data-bn="ক্যাম্পাসের মুহূর্ত">CAMPUS MOMENTS</span>
    <h1 data-en="School Photo Gallery" data-bn="বিদ্যালয়ের ফটো গ্যালারি">School Photo Gallery</h1>
    <p data-en="A glimpse of learning, activities and school life." data-bn="শিক্ষা, কার্যক্রম ও বিদ্যালয় জীবনের কিছু মুহূর্ত।">A glimpse of learning, activities and school life.</p>
  </div>
  <div class="gallery-grid">
    <?php foreach ($rows as $r): ?><figure><img src="<?= e($r['image_path']) ?>" alt="<?= e($r['title_en']) ?>" loading="lazy" decoding="async">
        <figcaption data-en="<?= e($r['title_en']) ?>" data-bn="<?= e($r['title_bn'] ?: $r['title_en']) ?>"><?= e($r['title_en']) ?></figcaption>
      </figure><?php endforeach; ?>
  </div>
  <?php if (!$rows): ?><p data-en="Gallery photographs will be published here by the school administrator." data-bn="বিদ্যালয় প্রশাসক এখানে গ্যালারির ছবি প্রকাশ করবেন।">Gallery photographs will be published here by the school administrator.</p><?php endif; ?>
  <?php if ($total > $perPage): ?><nav class="pagination" aria-label="Gallery pages"><?php for ($p = 1; $p <= ceil($total / $perPage); $p++): ?><a class="<?= $p === $page ? 'current' : '' ?>" href="?page=<?= $p ?>" aria-current="<?= $p === $page ? 'page' : 'false' ?>"><?= $p ?></a><?php endfor; ?></nav><?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>