<?php
include 'db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $password = $_POST["password"];

  if (strlen($username) < 3) {
    $message = "Ім’я користувача має бути щонайменше 3 символи.";
  } elseif (strlen($password) < 5) {
    $message = "Пароль має бути щонайменше 5 символів.";
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $message = "Це ім’я вже зайняте.";
    } else {
      $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $hashed_password);

      if ($stmt->execute()) {
        $message = "Реєстрація успішна! Тепер увійдіть.";
      } else {
        $message = "Сталася помилка при реєстрації.";
      }
    }
    $stmt->close();
  }
}
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="style.css">

<div class="auth-wrapper">
  <h2>Реєстрація</h2>
  <?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>
  <form method="POST">
    <label>Ім’я користувача:</label>
    <input type="text" name="username" required>

    <label>Пароль:</label>
    <input type="password" name="password" required>

    <input type="submit" value="Зареєструватися">
  </form>
</div>


<?php include 'footer.php'; ?>
