<?php
session_start();
require_once 'includes/db.php';
// require_once 'includes/header.php'; // Removed to clean up header

$msg = $_GET['msg'] ?? 'Welcome to <strong>PC Parts Store</strong>!';
$featured = fetchAll("SELECT * FROM products ORDER BY RAND() LIMIT 4");

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PC Parts Store</title>

  <!-- Modular CSS Imports -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/hero.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/cards.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
</head>
<body>

<!-- NAVIGATION -->
<div class="topbar">
  <div class="logo">🖥️ PC Parts Store</div>
  <div class="nav-links">
    <a href="cart.php">Cart</a>
    <?php if (!isset($_SESSION['user'])): ?>
      <a href="login.php">Login</a>
    <?php else: ?>
      <a href="?logout=1">Logout (<?= htmlspecialchars($_SESSION['user']) ?>)</a>
    <?php endif; ?>
  </div>
</div>

<?php
if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  header("Location: index.php?msg=You have been logged out");
  exit;
}
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>Build Your <span>Dream</span> PC</h1>
    <p>High-performance components for gamers and creators</p>
<a href="products.php" class="btn-primary hero-btn">Shop Now</a>
<form method="get" action="products.php" class="hero-search">
  <input type="text" name="search" placeholder="Search RTX 4090..." />
  <button type="submit" class="btn-primary">Search</button>
</form>


  </div>
</section>

<!-- XSS Welcome Banner -->
<div class="container">
  <div class="alert">
    <?= $msg ?>
  </div>
</div>

<!-- Featured Products Section -->
<section class="container">
  <div class="section-header">
    <h2>🔥 Featured Products</h2>
    <a href="<?= $_GET['url'] ?? '#' ?>" class="alert">
      🚚 Free Shipping Today Only!
    </a>
  </div>

  <div class="grid">
    <?php foreach ($featured as $p): ?>
      <div class="product-card">
        <div class="product-placeholder"></div>
        <h3><?= $p['name'] ?></h3>
        <p>$<?= $p['price'] ?></p>
        <a href="product.php?id=<?= $p['id'] ?>" class="btn-primary">View Product</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

</body>
</html>
