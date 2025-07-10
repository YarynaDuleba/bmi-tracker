<?php include 'header.php'; ?>
<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
};
?>

<link rel="stylesheet" href="style.css">

<div class="bmi-wrapper" style=" background-image: url('images/hero2.png'); ">

  
  <div class="form-box" style="background-color: rgba(255, 255, 255, 0.74); max-width: 500px; width: 100%;">
    <h2 style="margin-top: 0;">Розрахунок ІМТ</h2>
    <form method="POST" action="">
      <label for="age">Вік:</label>
      <input type="number" name="age" required>

      <label for="height">Ріст (в см):</label>
      <input type="number" name="height" required>

      <label for="weight">Вага (в кг):</label>
      <input type="number" name="weight" required>

      <input type="submit" value="Розрахувати ІМТ">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $age = (int) $_POST['age'];
  $height = (float) $_POST['height'] / 100;
  $weight = (float) $_POST['weight'];

  if ($height > 0) {
    $bmi = round($weight / ($height * $height), 2);

    echo "<div class='result'>Ваш ІМТ: <strong>$bmi</strong><br>";

    if ($bmi < 18.5) {
      echo "У вас недостатня вага.";
    } elseif ($bmi >= 18.5 && $bmi < 25) {
      echo "Ваша вага в нормі.";
    } elseif ($bmi >= 25 && $bmi < 30) {
      echo "У вас надмірна вага.";
    } else {
      echo "У вас ожиріння.";
    }

    echo "</div>";

    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];

      $stmt = $conn->prepare("INSERT INTO bmi_data (user_id, age, height, weight, bmi) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("idddd", $user_id, $age, $height, $weight, $bmi);
      $stmt->execute();
      $stmt->close();
    }
  }
}

    ?>
  </div>

</div>

<?php include 'footer.php'; ?>
