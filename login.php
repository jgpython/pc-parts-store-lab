<?php
session_start();
require_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$msg = $_GET['msg'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['user'] ?? '';
  $password = $_POST['pass'] ?? '';

  // 💣 SQL Injection vulnerable
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

  try {
    $res = @fetchAll($sql); // suppress SQL errors for red team testing
    $user = $res[0] ?? null;
  } catch (Exception $e) {
    $msg = "⚠️ SQL Error: Injection failed.";
    $user = null;
  }

  if ($user) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    setcookie("token", base64_encode($user['username']), time() + 3600); // 💣 insecure remember-me

    header("Location: index.php?msg=Welcome back, $username!");
    exit;
  } else {
    $msg = "❌ Login failed. Try <code>admin' --</code> or any user.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - PC Parts Store</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
  <style>
    .login-box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      max-width: 420px;
      margin: 3rem auto;
      text-align: center;
      box-sizing: border-box;
    }
    .login-box h2 {
      margin-bottom: 1rem;
    }
    .login-box input {
      width: calc(100% - 2px);
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      box-sizing: border-box;
    }
    .login-links {
      margin-top: 1rem;
      display: flex;
      justify-content: space-between;
      font-size: 0.9rem;
    }
    .login-links a {
      color: #007bff;
      text-decoration: none;
    }
  </style>
</head>
<body>

<!-- Top Bar -->
<div class="topbar">
  <div class="logo">🖥 PC Parts Store</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
  </div>
</div>

<section class="container">
  <div class="login-box">
    <?php if ($msg): ?>
      <div class="alert"><?= $msg ?></div>
    <?php endif; ?>

    <h2>Login</h2>
    <form method="POST">
      <input type="text" name="user" placeholder="Username" required />
      <input type="password" name="pass" placeholder="Password" required />
      <button type="submit" class="btn-primary" style="width: 100%;">Login</button>
    </form>

    <div class="login-links">
      <a href="register.php">Create Account</a>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
