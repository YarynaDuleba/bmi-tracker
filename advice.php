<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Поради для здорової ваги</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "header.php";
include "db.php"; ?>

<section class="hero-tips" style="background-image: url('images/hero3.png');">
  <h1 style="font-size: 36px; font-weight: bold; text-shadow: 10px 10px 15px rgba(0,0,0,0.4); margin: 0;">
    Поради для зниження або підтримки здорової ваги
  </h1>
</section>

<div class="tips-grid">
  <?php
  $result = $conn->query("SELECT * FROM tips ORDER BY id ASC");

  while ($tip = $result->fetch_assoc()) {
    echo "<div class='tip-card'>";
    echo "<h3>" . htmlspecialchars($tip['title']) . "</h3>";
    echo "<p>" . htmlspecialchars($tip['text']) . "</p>";
    echo "</div>";
  }
  ?>
</div>

<?php include "footer.php"; ?>
</body>
</html>
