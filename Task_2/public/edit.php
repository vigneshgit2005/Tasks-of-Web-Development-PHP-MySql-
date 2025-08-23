<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../db.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) { http_response_code(404); exit('Post not found'); }
if (!is_owner($post['user_id'])) { http_response_code(403); exit('Forbidden'); }

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    } else {
        $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ? WHERE id = ?');
        $stmt->execute([$title, $content, $id]);
        header('Location: index.php');
        exit;
    }
}
?>
<h2>Edit Post</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form">
  <?php csrf_field(); ?>
  <label>Title
    <input name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
  </label>
  <label>Content
    <textarea name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
  </label>
  <button type="submit">Save</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
