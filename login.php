<?php
include 'db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $user_id;
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit;
    } else {
      $message = "Невірний пароль.";
    }
  } else {
    $message = "Користувача з таким ім’ям не знайдено.";
  }

  $stmt->close();
}
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="style.css">

<div class="auth-wrapper">
  <h2>Вхід</h2>
  <?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>
  <form method="POST">
    <label>Ім’я користувача:</label>
    <input type="text" name="username" required>

    <label>Пароль:</label>
    <input type="password" name="password" required>

    <input type="submit" value="Увійти">
  </form>
</div>


<?php include 'footer.php'; ?>
