<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../db.php';
$stmt = $pdo->query('SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC');
$posts = $stmt->fetchAll();
?>
<h2>All Posts</h2>
<?php if (!$posts): ?>
  <p>No posts yet. <?php if (current_user()): ?><a href="create.php">Create the first post</a>.<?php endif; ?></p>
<?php endif; ?>
<?php foreach ($posts as $post): ?>
  <article class="post">
    <h3><?= htmlspecialchars($post['title']) ?></h3>
    <p class="meta">by <?= htmlspecialchars($post['username']) ?> on <?= htmlspecialchars($post['created_at']) ?></p>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <?php if (is_owner($post['user_id'])): ?>
      <p>
        <a href="edit.php?id=<?= (int)$post['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= (int)$post['id'] ?>" onclick="return confirm('Delete this post?');">Delete</a>
      </p>
    <?php endif; ?>
  </article>
<?php endforeach; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
