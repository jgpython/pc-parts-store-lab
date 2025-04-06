<?php
session_start();
require_once '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 💣 Delete order via GET
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  query("DELETE FROM orders WHERE id = $id");
  header("Location: orders.php?msg=Order $id deleted.");
  exit;
}

// 📥 CSV export
if (isset($_GET['export'])) {
  $orders = fetchAll("SELECT * FROM orders");

  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="orders.csv"');

  $out = fopen('php://output', 'w');
  fputcsv($out, array_keys($orders[0]));
  foreach ($orders as $o) fputcsv($out, $o);
  fclose($out);
  exit;
}

$orders = fetchAll("SELECT * FROM orders");
$msg = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders - Admin Panel</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/layout.css">
  <link rel="stylesheet" href="../assets/css/components/buttons.css">
  <link rel="stylesheet" href="../assets/css/components/alerts.css">
  <style>
    .order-box {
      background: #fff;
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .order-box h3 {
      margin: 0 0 0.5rem 0;
    }
    .actions a {
      margin-right: 1rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="logo">📦 Admin Orders</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="?export=1" class="btn-primary" style="background:#28a745;">Export CSV</a>
  </div>
</div>

<section class="container">
  <h2>Recent Orders</h2>

  <?php if ($msg): ?>
    <div class="alert"><?= $msg ?></div>
  <?php endif; ?>

  <?php foreach ($orders as $o): ?>
    <div class="order-box">
      <h3>Order #<?= $o['id'] ?> - User <?= $o['user_id'] ?></h3>
      <p>Product ID: <?= $o['product_id'] ?></p>
      <p>Qty: <?= $o['quantity'] ?> — Total: $<?= $o['total'] ?> — Status: <?= $o['status'] ?></p>
      <p>Card Info: <?= $o['payment_data'] ?></p>
      <div class="actions">
        <a href="?delete=<?= $o['id'] ?>" style="color: red;">🗑️ Delete</a>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once '../includes/footer.php'; ?>
</body>
</html>
