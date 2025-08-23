<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../db.php';
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        login($user);
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<h2>Login</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form">
  <?php csrf_field(); ?>
  <label>Username
    <input name="username" required>
  </label>
  <label>Password
    <input name="password" type="password" required>
  </label>
  <button type="submit">Login</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
