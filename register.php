<?php
session_start();
require_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $role = $_POST['role'] ?? 'user'; // 🔥 hidden field, can be edited client-side

  // Check for email reuse
  $check = fetchAll("SELECT * FROM users WHERE email = '$email'");
  if (count($check) > 0) {
    $msg = "⚠️ Email already registered!";
  } else {
    query("INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')");
    header("Location: login.php?msg=Account created! Please log in.");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - PC Parts Store</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
  <style>
    .register-box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      max-width: 450px;
      margin: 3rem auto;
      box-sizing: border-box;
      text-align: center;
    }
    .register-box h2 {
      margin-bottom: 1rem;
    }
    .register-box input {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      box-sizing: border-box;
    }
    .note {
      font-size: 0.9rem;
      color: #666;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="logo">🖥 PC Parts Store</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
  </div>
</div>

<section class="container">
  <div class="register-box">
    <?php if ($msg): ?>
      <div class="alert"><?= $msg ?></div>
    <?php endif; ?>

    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="hidden" name="role" value="user" /> <!-- 🔥 Mass assignment if tampered -->

      <button type="submit" class="btn-primary" style="width: 100%;">Register</button>
    </form>
    <p class="note">Passwords are stored in plaintext. Role can be modified via dev tools.</p>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
