<?php
require_once __DIR__ . '/../config.php';
require_admin();
$type = $_GET['type'] ?? 'notices';
$allowed = ['sections', 'notices', 'staff', 'achievements', 'gallery', 'pages', 'settings', 'admissions', 'messages', 'users'];
if (!in_array($type, $allowed, true)) $type = 'notices';
$labels = ['sections' => 'Homepage Sections', 'notices' => 'Notices & News', 'staff' => 'Leadership & Teachers', 'achievements' => 'Awards & Achievements', 'gallery' => 'Photo Gallery', 'pages' => 'Page Content', 'settings' => 'School Settings', 'admissions' => 'Admission Enquiries', 'messages' => 'Contact Messages', 'users' => 'User Account Approvals'];
$flash = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        if ($type === 'users' && isset($_POST['user_action'])) {
            $id = (int)$_POST['id'];
            $action = $_POST['user_action'];
            $status = ['approve' => 'approved', 'reject' => 'rejected', 'suspend' => 'suspended', 'pending' => 'pending'][$action] ?? 'pending';
            $q = db()->prepare('UPDATE users SET status=?,approved_at=? WHERE id=?');
            $q->execute([$status, $status === 'approved' ? date('Y-m-d H:i:s') : null, $id]);
            $flash = 'Account status updated.';
        } elseif (isset($_POST['delete_id'])) {
            $id = (int)$_POST['delete_id'];
            $tables = ['notices' => 'notices', 'staff' => 'staff', 'achievements' => 'achievements', 'gallery' => 'gallery'];
            if (isset($tables[$type])) {
                $q = db()->prepare('DELETE FROM ' . $tables[$type] . ' WHERE id=?');
                $q->execute([$id]);
                $flash = 'Record deleted.';
            }
        } elseif ($type === 'settings') {
            foreach (['school_name', 'address', 'phone', 'email', 'office_hours'] as $k) {
                $q = db()->prepare('INSERT INTO settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
                $q->execute([$k, trim($_POST[$k] ?? '')]);
            }
            $flash = 'School settings saved.';
        } elseif ($type === 'sections') {
            $id = (int)($_POST['id'] ?? 0);
            $img = upload_image('image');
            $vals = [trim($_POST['title_en'] ?? ''), trim($_POST['title_bn'] ?? ''), trim($_POST['body_en'] ?? ''), trim($_POST['body_bn'] ?? ''), $img ?: trim($_POST['image_path'] ?? ''), trim($_POST['button_text_en'] ?? ''), trim($_POST['button_text_bn'] ?? ''), trim($_POST['button_url'] ?? ''), isset($_POST['is_published']) ? 1 : 0, (int)($_POST['sort_order'] ?? 0)];
            $q = db()->prepare('UPDATE site_sections SET title_en=?,title_bn=?,body_en=?,body_bn=?,image_path=?,button_text_en=?,button_text_bn=?,button_url=?,is_published=?,sort_order=? WHERE id=?');
            $q->execute([...$vals, $id]);
            $flash = 'Homepage section updated.';
        } elseif ($type === 'notices') {
            $vals = [trim($_POST['title_en']), trim($_POST['title_bn'] ?? ''), trim($_POST['body_en'] ?? ''), trim($_POST['body_bn'] ?? ''), $_POST['publish_date'] ?? date('Y-m-d'), isset($_POST['is_published']) ? 1 : 0];
            $id = (int)($_POST['id'] ?? 0);
            if ($id) {
                $q = db()->prepare('UPDATE notices SET title_en=?,title_bn=?,body_en=?,body_bn=?,publish_date=?,is_published=? WHERE id=?');
                $q->execute([...$vals, $id]);
            } else {
                $q = db()->prepare('INSERT INTO notices(title_en,title_bn,body_en,body_bn,publish_date,is_published) VALUES(?,?,?,?,?,?)');
                $q->execute($vals);
            }
            $flash = 'Notice saved.';
        } elseif ($type === 'staff') {
            $img = upload_image('image', 'assets/uploads/staff');
            $vals = [trim($_POST['name_en']), trim($_POST['name_bn'] ?? ''), trim($_POST['designation_en'] ?? ''), trim($_POST['designation_bn'] ?? ''), trim($_POST['bio_en'] ?? ''), trim($_POST['bio_bn'] ?? ''), $img ?: trim($_POST['photo'] ?? ''), $_POST['category'] === 'leadership' ? 'leadership' : 'teacher', isset($_POST['is_published']) ? 1 : 0, (int)($_POST['sort_order'] ?? 0)];
            $id = (int)($_POST['id'] ?? 0);
            if ($id) {
                $q = db()->prepare('UPDATE staff SET name_en=?,name_bn=?,designation_en=?,designation_bn=?,bio_en=?,bio_bn=?,photo=?,category=?,is_published=?,sort_order=? WHERE id=?');
                $q->execute([...$vals, $id]);
            } else {
                $q = db()->prepare('INSERT INTO staff(name_en,name_bn,designation_en,designation_bn,bio_en,bio_bn,photo,category,is_published,sort_order) VALUES(?,?,?,?,?,?,?,?,?,?)');
                $q->execute($vals);
            }
            $flash = 'Staff profile saved.';
        } elseif ($type === 'achievements') {
            $img = upload_image('image', 'assets/uploads/achievements');
            $vals = [trim($_POST['title_en']), trim($_POST['title_bn'] ?? ''), trim($_POST['description_en'] ?? ''), trim($_POST['description_bn'] ?? ''), $_POST['achievement_date'] ?: null, $img ?: trim($_POST['image_path'] ?? ''), isset($_POST['is_published']) ? 1 : 0];
            $id = (int)($_POST['id'] ?? 0);
            if ($id) {
                $q = db()->prepare('UPDATE achievements SET title_en=?,title_bn=?,description_en=?,description_bn=?,achievement_date=?,image_path=?,is_published=? WHERE id=?');
                $q->execute([...$vals, $id]);
            } else {
                $q = db()->prepare('INSERT INTO achievements(title_en,title_bn,description_en,description_bn,achievement_date,image_path,is_published) VALUES(?,?,?,?,?,?,?)');
                $q->execute($vals);
            }
            $flash = 'Achievement saved.';
        } elseif ($type === 'gallery') {
            $img = upload_image('image', 'assets/uploads/gallery');
            $path = $img ?: trim($_POST['image_path'] ?? '');
            if (!$path) throw new RuntimeException('Please upload an image.');
            $vals = [trim($_POST['title_en']), trim($_POST['title_bn'] ?? ''), $path, trim($_POST['category'] ?? 'Campus'), isset($_POST['is_published']) ? 1 : 0];
            $id = (int)($_POST['id'] ?? 0);
            if ($id) {
                $q = db()->prepare('UPDATE gallery SET title_en=?,title_bn=?,image_path=?,category=?,is_published=? WHERE id=?');
                $q->execute([...$vals, $id]);
            } else {
                $q = db()->prepare('INSERT INTO gallery(title_en,title_bn,image_path,category,is_published) VALUES(?,?,?,?,?)');
                $q->execute($vals);
            }
            $flash = 'Gallery image saved.';
        } elseif ($type === 'pages') {
            $q = db()->prepare('INSERT INTO page_content(page_key,title_en,title_bn,body_en,body_bn) VALUES(?,?,?,?,?) ON DUPLICATE KEY UPDATE title_en=VALUES(title_en),title_bn=VALUES(title_bn),body_en=VALUES(body_en),body_bn=VALUES(body_bn)');
            $q->execute([trim($_POST['page_key']), trim($_POST['title_en']), trim($_POST['title_bn'] ?? ''), trim($_POST['body_en'] ?? ''), trim($_POST['body_bn'] ?? '')]);
            $flash = 'Page content saved.';
        }
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }
}
$edit = null;
if (isset($_GET['edit'])) {
    $table = ['notices' => 'notices', 'staff' => 'staff', 'achievements' => 'achievements', 'gallery' => 'gallery', 'sections' => 'site_sections'][$type] ?? null;
    if ($table) {
        $q = db()->prepare("SELECT * FROM `$table` WHERE id=?");
        $q->execute([(int)$_GET['edit']]);
        $edit = $q->fetch();
    }
}
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 15;
$search = trim($_GET['q'] ?? '');
$records = [];
$total = 0;
if (in_array($type, ['notices', 'staff', 'achievements', 'gallery', 'pages', 'admissions', 'messages', 'users'])) {
    try {
        $table = $type === 'pages' ? 'page_content' : $type;
        $where = '';
        $args = [];
        if ($search) {
            $cols = ['notices' => 'title_en LIKE ? OR title_bn LIKE ?', 'staff' => 'name_en LIKE ? OR name_bn LIKE ?', 'achievements' => 'title_en LIKE ? OR title_bn LIKE ?', 'gallery' => 'title_en LIKE ? OR title_bn LIKE ?', 'pages' => 'page_key LIKE ? OR title_en LIKE ?', 'admissions' => 'student_name LIKE ? OR mobile LIKE ?', 'messages' => 'name LIKE ? OR subject LIKE ?', 'users' => 'full_name LIKE ? OR email LIKE ?'];
            $where = ' WHERE (' . $cols[$type] . ')';
            $args = ["%$search%", "%$search%"];
        }
        $q = db()->prepare("SELECT COUNT(*) FROM `$table`$where");
        $q->execute($args);
        $total = (int)$q->fetchColumn();
        $offset = ($page - 1) * $perPage;
        $q = db()->prepare("SELECT * FROM `$table`$where ORDER BY id DESC LIMIT $perPage OFFSET $offset");
        $q->execute($args);
        $records = $q->fetchAll();
    } catch (Throwable $ex) {
        $error = $error ?: $ex->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= e($labels[$type]) ?> | BIAM CMS</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="layout">
        <aside class="side">
            <h2>BIAM <span>CMS</span></h2>
            <nav><a href="index.php">Dashboard</a><?php foreach ($labels as $k => $v): ?><a class="<?= $k === $type ? 'selected' : '' ?>" href="manage.php?type=<?= e($k) ?>"><?= e($v) ?></a><?php endforeach; ?><a href="../index.php" target="_blank">↗ View Website</a><a href="logout.php">Log Out</a></nav>
        </aside>
        <main class="main">
            <div class="top">
                <div>
                    <p class="eyebrow">CONTENT MANAGEMENT</p>
                    <h1><?= e($labels[$type]) ?></h1>
                </div>
                <div style="display:flex;gap:9px;align-items:center"><button id="languageToggle" class="admin-language-toggle" type="button">বাংলা</button><a class="btn" href="index.php">Dashboard</a></div>
            </div><?php if ($flash): ?><div class="notice"><?= e($flash) ?></div><?php endif; ?><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
            <?php if ($type === 'settings'): ?><form class="panel" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><?php foreach (['school_name' => 'School name', 'address' => 'Address', 'phone' => 'Phone', 'email' => 'Email', 'office_hours' => 'Office hours'] as $k => $v): ?><label><?= e($v) ?></label><input name="<?= e($k) ?>" value="<?= e(setting($k)) ?>"><?php endforeach; ?><button>Save Settings</button></form>
            <?php elseif ($type === 'sections'): ?><div class="panel">
                    <p>Edit the hero and introduction content. The image can be uploaded or set using an existing relative path.</p>
                    <div class="table-wrap">
                        <table>
                            <tr>
                                <th>Section</th>
                                <th>English title</th>
                                <th>Published</th>
                                <th>Action</th>
                            </tr><?php foreach (db()->query('SELECT * FROM site_sections ORDER BY sort_order,id') as $r): ?><tr>
                                    <td><?= e($r['section_key']) ?></td>
                                    <td><?= e($r['title_en']) ?></td>
                                    <td><?= !empty($r['is_published']) ? 'Yes' : 'No' ?></td>
                                    <td><a class="btn" href="?type=sections&edit=<?= $r['id'] ?>">Edit</a></td>
                                </tr><?php endforeach; ?>
                        </table>
                    </div>
                </div><?php if ($edit): ?><form class="panel" method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= $edit['id'] ?>">
                        <h2>Edit <?= e($edit['section_key']) ?></h2><?php foreach (['title_en' => 'Title (English)', 'title_bn' => 'Title (Bangla)', 'body_en' => 'Description (English)', 'body_bn' => 'Description (Bangla)', 'button_text_en' => 'Button (English)', 'button_text_bn' => 'Button (Bangla)', 'button_url' => 'Button URL', 'image_path' => 'Current image path', 'sort_order' => 'Display order'] as $k => $label): ?><label><?= e($label) ?></label><?php if (str_starts_with($k, 'body_')): ?><textarea name="<?= $k ?>"><?= e($edit[$k]) ?></textarea><?php else: ?><input name="<?= $k ?>" value="<?= e($edit[$k] ?? '') ?>"><?php endif; ?><?php endforeach; ?><label>Upload replacement image</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp"><label><input type="checkbox" name="is_published" <?= !empty($edit['is_published']) ? 'checked' : '' ?>> Published</label><button>Save Section</button>
                    </form><?php endif; ?>
            <?php elseif ($type === 'notices' || $type === 'staff' || $type === 'achievements' || $type === 'gallery'): ?><form class="panel" method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
                    <h2><?= $edit ? 'Edit record' : 'Add new record' ?></h2><?php $fields = match ($type) {
                                                                                'notices' => ['title_en' => 'Title (English)', 'title_bn' => 'Title (Bangla)', 'body_en' => 'Notice body (English)', 'body_bn' => 'Notice body (Bangla)', 'publish_date' => 'Publish date'],
                                                                                'staff' => ['name_en' => 'Name (English)', 'name_bn' => 'Name (Bangla)', 'designation_en' => 'Designation (English)', 'designation_bn' => 'Designation (Bangla)', 'bio_en' => 'Biography (English)', 'bio_bn' => 'Biography (Bangla)', 'category' => 'Profile category', 'photo' => 'Current photo path', 'sort_order' => 'Display order'],
                                                                                'achievements' => ['title_en' => 'Achievement title (English)', 'title_bn' => 'Achievement title (Bangla)', 'description_en' => 'Description (English)', 'description_bn' => 'Description (Bangla)', 'achievement_date' => 'Date', 'image_path' => 'Current image path'],
                                                                                'gallery' => ['title_en' => 'Image title (English)', 'title_bn' => 'Image title (Bangla)', 'category' => 'Category', 'image_path' => 'Current image path']
                                                                            };
                                                                            foreach ($fields as $k => $label): ?><label><?= e($label) ?></label><?php if (in_array($k, ['body_en', 'body_bn', 'bio_en', 'bio_bn', 'description_en', 'description_bn'])): ?><textarea name="<?= $k ?>"><?= e($edit[$k] ?? '') ?></textarea><?php elseif ($k === 'category' && $type === 'staff'): ?><select name="category">
                                <option value="teacher" <?= ($edit['category'] ?? 'teacher') === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                <option value="leadership" <?= ($edit['category'] ?? '') === 'leadership' ? 'selected' : '' ?>>Leadership</option>
                            </select><?php elseif ($k === 'publish_date' || $k === 'achievement_date'): ?><input type="date" name="<?= $k ?>" value="<?= e($edit[$k] ?? date('Y-m-d')) ?>"><?php else: ?><input name="<?= $k ?>" value="<?= e($edit[$k] ?? '') ?>" <?= in_array($k, ['title_en', 'name_en']) ? 'required' : '' ?>><?php endif; ?><?php endforeach; ?><?php if ($type !== 'notices'): ?><label>Upload image (JPG, PNG or WEBP, max 5 MB)</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp"><?php endif; ?><label><input type="checkbox" name="is_published" <?= (!isset($edit) || !empty($edit['is_published'])) ? 'checked' : '' ?>> Published</label><button>Save</button><?php if ($edit): ?> <a href="manage.php?type=<?= e($type) ?>">Cancel</a><?php endif; ?>
                </form>
                <div class="panel">
                    <form class="filter-row" method="get"><input type="hidden" name="type" value="<?= e($type) ?>">
                        <div><label>Search records</label><input name="q" value="<?= e($search) ?>" placeholder="Search title or name"></div><button>Search</button>
                    </form>
                    <div class="table-wrap">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Title / Name</th>
                                <th>Date / Category</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr><?php foreach ($records as $r): ?><tr>
                                    <td><?= e($r['id']) ?></td>
                                    <td><?php if ($type === 'staff' && !empty($r['photo'])): ?><img src="../<?= e($r['photo']) ?>" alt="" loading="lazy"><?php endif; ?><?php if ($type === 'staff'): ?><strong><?= e($r['name_en']) ?></strong><br><small><?= e($r['designation_en']) ?></small><?php else: ?><?= e($r['title_en'] ?? $r['name_en'] ?? '') ?><?php endif; ?></td>
                                    <td><?= e($r['publish_date'] ?? $r['achievement_date'] ?? $r['category'] ?? '') ?></td>
                                    <td><?= !empty($r['is_published']) ? 'Yes' : 'No' ?></td>
                                    <td class="actions"><a class="btn" href="?type=<?= e($type) ?>&edit=<?= e($r['id']) ?>">Edit</a>
                                        <form method="post" class="inline" onsubmit="return confirm('Delete this record?')"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="delete_id" value="<?= e($r['id']) ?>"><button class="btn danger">Delete</button></form>
                                    </td>
                                </tr><?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php elseif ($type === 'users'): ?><div class="panel">
                    <p>New registrations remain pending until an administrator approves them. Approval does not grant admin privileges.</p>
                    <form class="filter-row" method="get"><input type="hidden" name="type" value="users">
                        <div><label>Search name or email</label><input name="q" value="<?= e($search) ?>"></div><button>Search</button>
                    </form>
                    <div class="table-wrap">
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Account type</th>
                                <th>Contact</th>
                                <th>Reference ID</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr><?php foreach ($records as $r): ?><tr>
                                    <td><?= e($r['full_name']) ?></td>
                                    <td><?= e(ucfirst($r['account_type'])) ?></td>
                                    <td><?= e($r['email']) ?><br><?= e($r['mobile']) ?></td>
                                    <td><?= e($r['reference_id']) ?></td>
                                    <td><span class="status <?= e($r['status']) ?>"><?= e(ucfirst($r['status'])) ?></span></td>
                                    <td><?= e($r['created_at']) ?></td>
                                    <td><?php foreach (['approve' => 'Approve', 'reject' => 'Reject', 'suspend' => 'Suspend', 'pending' => 'Set Pending'] as $act => $label): ?><form method="post" class="inline"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="btn <?= in_array($act, ['reject', 'suspend']) ? 'danger' : '' ?>" name="user_action" value="<?= $act ?>"><?= $label ?></button></form><?php endforeach; ?></td>
                                </tr><?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php elseif (in_array($type, ['admissions', 'messages'])): ?><div class="panel">
                    <p>Website submissions. These are read-only in this dashboard.</p>
                    <form class="filter-row" method="get"><input type="hidden" name="type" value="<?= e($type) ?>">
                        <div><label>Search records</label><input name="q" value="<?= e($search) ?>"></div><button>Search</button>
                    </form>
                    <div class="table-wrap">
                        <table>
                            <tr><?php $cols = $type === 'admissions' ? ['id', 'student_name', 'class_name', 'guardian_name', 'mobile', 'email', 'created_at'] : ['id', 'name', 'email', 'subject', 'message', 'created_at'];
                                foreach ($cols as $c): ?><th><?= e(ucwords(str_replace('_', ' ', $c))) ?></th><?php endforeach; ?></tr><?php foreach ($records as $r): ?><tr><?php foreach ($cols as $c): ?><td><?= e($r[$c] ?? '') ?></td><?php endforeach; ?></tr><?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php elseif ($type === 'pages'): ?><form class="panel" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Page key</label><input name="page_key" required placeholder="about_school"><label>Title English</label><input name="title_en" required><label>Title Bangla</label><input name="title_bn"><label>Body English</label><textarea name="body_en"></textarea><label>Body Bangla</label><textarea name="body_bn"></textarea><button>Save page content</button></form>
                <div class="panel table-wrap">
                    <table>
                        <tr>
                            <th>Key</th>
                            <th>Title</th>
                            <th>Updated</th>
                        </tr><?php foreach ($records as $r): ?><tr>
                                <td><?= e($r['page_key']) ?></td>
                                <td><?= e($r['title_en']) ?></td>
                                <td><?= e($r['updated_at']) ?></td>
                            </tr><?php endforeach; ?>
                    </table>
                </div><?php endif; ?>
            <?php if ($total > $perPage): ?><div class="panel">
                    <p>Page <?= $page ?> of <?= ceil($total / $perPage) ?> · <?= $total ?> records</p><?php for ($p = 1; $p <= ceil($total / $perPage); $p++): ?><a class="btn" href="?type=<?= e($type) ?>&page=<?= $p ?>&q=<?= urlencode($search) ?>"><?= $p ?></a> <?php endfor; ?>
                </div><?php endif; ?>
        </main>
    </div>
    <script src="../assets/js/script.js" defer></script>
</body>

</html>