<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../db.php';
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
            $id = $pdo->lastInsertId();
            login(['id' => $id, 'username' => $username]);
            header('Location: index.php');
            exit;
        }
    }
}
?>
<h2>Register</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form">
  <?php csrf_field(); ?>
  <label>Username
    <input name="username" required>
  </label>
  <label>Password
    <input name="password" type="password" required minlength="6">
  </label>
  <button type="submit">Create account</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
