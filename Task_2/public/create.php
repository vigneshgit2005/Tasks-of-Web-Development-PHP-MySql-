<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../db.php';
require_login();
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)');
        $stmt->execute([$title, $content, current_user()['id']]);
        header('Location: index.php');
        exit;
    }
}
?>
<h2>New Post</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form">
  <?php csrf_field(); ?>
  <label>Title
    <input name="title" required>
  </label>
  <label>Content
    <textarea name="content" rows="6" required></textarea>
  </label>
  <button type="submit">Create</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
