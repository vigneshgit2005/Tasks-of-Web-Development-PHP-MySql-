<?php
require 'db.php';

// --- Handle search ---
$search = isset($_GET['search']) ? $_GET['search'] : '';

// --- Pagination setup ---
$limit = 5; // posts per page
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $limit;

// --- Count total posts ---
$countQuery = "SELECT COUNT(*) FROM posts 
               WHERE title LIKE :title OR content LIKE :content";
$stmt = $pdo->prepare($countQuery);
$stmt->execute([
    ':title'   => "%$search%",
    ':content' => "%$search%"
]);
$total = $stmt->fetchColumn();
$totalPages = ceil($total / $limit);

// --- Fetch posts ---
$query = "SELECT * FROM posts 
          WHERE title LIKE :title OR content LIKE :content
          ORDER BY created_at DESC
          LIMIT :start, :limit";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':title', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':content', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h2 class="mb-4">Posts</h2>

  <!-- Search Form -->
  <form class="mb-3" method="get" action="">
    <div class="input-group">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search posts...">
      <button class="btn btn-primary">Search</button>
    </div>
  </form>

  <!-- Posts List -->
  <?php if ($posts): ?>
    <?php foreach ($posts as $post): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
          <p class="card-text"><?= htmlspecialchars(substr($post['content'], 0, 150)) ?>...</p>
          <small class="text-muted"><?= $post['created_at'] ?></small>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-warning">No posts found.</div>
  <?php endif; ?>

  <!-- Pagination -->
  <nav>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>

</body>
</html>
