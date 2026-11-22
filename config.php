<?php
// Local XAMPP defaults. Change credentials before public deployment.
define('DB_HOST', 'localhost');
define('DB_NAME', 'biam_school');
define('DB_USER', 'root');
define('DB_PASS', '');
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    $isHttps = (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off');
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => $isHttps, 'path' => '/']);
    session_start();
}
function db(): PDO
{
    static $pdo = null;
    if (!$pdo) $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
    return $pdo;
}
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function setting(string $key, string $fallback = ''): string
{
    try {
        $q = db()->prepare('SELECT setting_value FROM settings WHERE setting_key=?');
        $q->execute([$key]);
        $v = $q->fetchColumn();
        return $v !== false ? (string)$v : $fallback;
    } catch (Throwable $ex) {
        return $fallback;
    }
}
function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}
function user_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}
function require_admin(): void
{
    if (!admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        exit('Invalid request token. Please go back and try again.');
    }
}
function upload_image(string $field, string $folder = 'assets/uploads'): string
{
    if (!isset($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return '';
    if (($_FILES[$field]['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES[$field]['tmp_name'])) throw new RuntimeException('The image could not be uploaded. Please try again.');
    $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) throw new RuntimeException('Upload a matching JPG, PNG or WEBP image.');
    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) throw new RuntimeException('Image must be smaller than 5 MB.');
    $dir = __DIR__ . '/' . $folder;
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $name = bin2hex(random_bytes(12)) . '.' . $ext;
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Image upload failed.');
    return $folder . '/' . $name;
}
function site_section(string $key): ?array
{
    try {
        $q = db()->prepare('SELECT * FROM site_sections WHERE section_key=? AND is_published=1');
        $q->execute([$key]);
        $r = $q->fetch();
        return $r ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function page_content(string $key, array $fallback = []): array
{
    try {
        $q = db()->prepare('SELECT title_en,title_bn,body_en,body_bn FROM page_content WHERE page_key=?');
        $q->execute([$key]);
        $r = $q->fetch();
        return $r ?: $fallback;
    } catch (Throwable $e) {
        return $fallback;
    }
}
function short_text(string $text, int $width = 130): string
{
    $text = trim(strip_tags($text));
    return function_exists('mb_strimwidth') ? mb_strimwidth($text, 0, $width, '…') : substr($text, 0, $width);
}
