<?php
session_start();
require_once '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🗑️ Delete user by ID
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  query("DELETE FROM users WHERE id = $id");
  header("Location: users.php?msg=User $id deleted.");
  exit;
}

// 🛠️ Role edit via GET (💣 no validation)
if (isset($_GET['edit']) && isset($_GET['role'])) {
  $id = intval($_GET['edit']);
  $role = $_GET['role'];
  query("UPDATE users SET role = '$role' WHERE id = $id");
  header("Location: users.php?msg=User $id role updated to $role.");
  exit;
}

$users = fetchAll("SELECT * FROM users");
$msg = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users - Admin Panel</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/layout.css">
  <link rel="stylesheet" href="../assets/css/components/buttons.css">
  <link rel="stylesheet" href="../assets/css/components/alerts.css">
  <style>
    .user-box {
      background: #fff;
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .user-box h3 {
      margin: 0;
    }
    .actions a {
      margin-right: 1rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="logo">👥 Admin Users</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="orders.php">Orders</a>
  </div>
</div>

<section class="container">
  <h2>All Registered Users</h2>

  <?php if ($msg): ?>
    <div class="alert"><?= $msg ?></div>
  <?php endif; ?>

  <?php foreach ($users as $u): ?>
    <div class="user-box">
      <h3>#<?= $u['id'] ?> - <?= $u['username'] ?> (<?= $u['role'] ?>)</h3>
      <p>Email: <?= $u['email'] ?></p>

      <div class="actions">
        <a href="?delete=<?= $u['id'] ?>" style="color: red;">🗑️ Delete</a>
        <a href="?edit=<?= $u['id'] ?>&role=admin" style="color: green;">⬆️ Make Admin</a>
        <a href="?edit=<?= $u['id'] ?>&role=user" style="color: orange;">⬇️ Make User</a>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once '../includes/footer.php'; ?>
</body>
</html>
