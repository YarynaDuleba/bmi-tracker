<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Здоров'я та ІМТ</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
<header>
  <nav>
    <a href="index.php">Головна</a>
    <a href="calc.php">Розрахунок ІМТ</a>
    <a href="advice.php">Поради</a>

    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="chart.php">Мій графік</a>
      <a href="logout.php">Вийти (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
    <?php else: ?>
      <a href="login.php">Увійти</a>
      <a href="register.php">Реєстрація</a>
    <?php endif; ?>
  </nav>
</header>

