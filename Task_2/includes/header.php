<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/csrf.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Basic CRUD Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="site-header">
    <h1><a href="index.php">Basic CRUD Blog</a></h1>
    <nav>
      <?php if (current_user()): ?>
        <span>Hello, <?= htmlspecialchars(current_user()['username']) ?></span>
        <a href="create.php">New Post</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>
  <main class="container">
