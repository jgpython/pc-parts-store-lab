<?php
session_start();
require_once 'includes/db.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// INSECURE SQL (intentionally vulnerable)
if ($search) {
  $products = fetchAll("SELECT * FROM products WHERE name LIKE '%$search%'");
} elseif ($category) {
  $products = fetchAll("SELECT * FROM products WHERE category = '$category'");
} else {
  $products = fetchAll("SELECT * FROM products");
}

// Get distinct categories for filters (no validation here either)
$categories = fetchAll("SELECT DISTINCT category FROM products");

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Products</title>

  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/hero.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/cards.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
</head>
<body>

<!-- Top Navigation -->
<div class="topbar">
  <div class="logo">🖥️ PC Parts Store</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
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
  header("Location: products.php?msg=Logged out successfully");
  exit;
}
?>

<!-- Page Title + Search -->
<section class="container">
 <div class="section-header">
  <h1>🛍️ All Products</h1>
 </div>

  <!-- Search Form (SQLi + Reflected XSS vulnerable) -->
  <form method="get" action="products.php" class="hero-search" style="margin-top: 1rem;">
    <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>" placeholder="Search by name..." />
    <button type="submit" class="btn-primary">Search</button>
  </form>

  <!-- Category Filters (with broken logic) -->
   <div class="category-bar">
    <a href="products.php" class="btn-primary">All</a>
    <?php foreach ($categories as $c): ?>
      <a href="products.php?category=<?= urlencode($c['category']) ?>" class="btn-primary">
        <?= htmlspecialchars($c['category']) ?>
      </a>
    <?php endforeach; ?>

    <!-- SQLi Training Button -->
    <a href="products.php?category=' OR 1=1 --" class="btn-primary">🔥 SQLi</a>
  </div>

  <!-- Message (XSS) -->
  <?php if (isset($_GET['msg'])): ?>
    <div class="alert"><?= $_GET['msg'] ?></div>
  <?php endif; ?>

  <!-- Product Grid -->
  <div class="grid" style="margin-top: 2rem;">
    <?php foreach ($products as $p): ?>
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

