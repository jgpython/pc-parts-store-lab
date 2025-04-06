<?php
session_start();
require_once '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔓 No role enforcement
$totalUsers = fetchAll("SELECT COUNT(*) AS total FROM users")[0]['total'];
$totalOrders = fetchAll("SELECT COUNT(*) AS total FROM orders")[0]['total'];
$totalRevenue = fetchAll("SELECT SUM(total) AS revenue FROM orders")[0]['revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/layout.css">
  <link rel="stylesheet" href="../assets/css/components/buttons.css">
  <link rel="stylesheet" href="../assets/css/components/alerts.css">
  <style>
    .dashboard {
      max-width: 800px;
      margin: 3rem auto;
      padding: 2rem;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-box {
      display: flex;
      justify-content: space-between;
      padding: 1rem;
      margin-bottom: 1rem;
      background: #f8f8f8;
      border-radius: 8px;
    }
    .stat-box h3 {
      margin: 0;
      font-size: 1.2rem;
    }
    .stat-box span {
      font-weight: bold;
      font-size: 1.4rem;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="logo">📊 Admin Dashboard</div>
  <div class="nav-links">
    <a href="../index.php">Home</a>
    <a href="orders.php">Orders</a>
    <a href="users.php">Users</a>
  </div>
</div>

<section class="dashboard">
  <h2>Overview</h2>

  <div class="stat-box">
    <h3>Total Users</h3>
    <span><?= $totalUsers ?></span>
  </div>

  <div class="stat-box">
    <h3>Total Orders</h3>
    <span><?= $totalOrders ?></span>
  </div>

  <div class="stat-box">
    <h3>Total Revenue</h3>
    <span>$<?= number_format($totalRevenue, 2) ?></span>
  </div>

  <div class="alert">
    🔓 No access control — anyone can view this page. Try logging in as a regular user and visiting <code>/admin/dashboard.php</code>.
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>
</body>
</html>
