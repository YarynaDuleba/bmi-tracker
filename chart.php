<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT bmi, created_at FROM bmi_data WHERE user_id = ? ORDER BY created_at";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bmi_data = [];
while ($row = $result->fetch_assoc()) {
  $bmi_data[] = [
    'date' => date("d.m.Y", strtotime($row['created_at'])),
    'bmi' => $row['bmi']
  ];
}

$stmt->close();
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="style.css">

<div style="max-width: 800px; margin: 60px auto; background: #fff0e0; padding: 30px; border-radius: 16px;">
  <h2 style="text-align: center;">Ваш графік ІМТ</h2>

  <?php if (count($bmi_data) === 0): ?>
    <p style="text-align: center;">Немає даних для відображення.</p>
  <?php else: ?>
    <div style="max-width: 800px; height: 300px; margin: 0 auto;">
  <canvas id="bmiChart" style="height: 100% !important; width:100%;"></canvas>
</div>

  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('bmiChart').getContext('2d');
  const bmiChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode(array_column($bmi_data, 'date')) ?>,
      datasets: [{
        label: 'ІМТ',
        data: <?= json_encode(array_column($bmi_data, 'bmi')) ?>,
        backgroundColor: 'rgba(224, 176, 132, 0.2)',
        borderColor: '#e0b084',
        borderWidth: 3,
        fill: true,
        tension: 0.3,
        pointRadius: 5
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: false,
          title: {
            display: true,
            text: 'ІМТ'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Дата'
          }
        }
      }
    }
  });
</script>

<?php include 'footer.php'; ?>
