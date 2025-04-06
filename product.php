<?php
session_start();
require_once 'includes/db.php';

$id = $_GET['id'] ?? 1;
$product = fetchAll("SELECT * FROM products WHERE id = $id");
$product = $product[0] ?? null;

// Handle review submission (stored XSS, IDOR)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $review = $_POST['review'] ?? '';
  $userId = $_POST['user_id'] ?? 1;
  query("INSERT INTO reviews (product_id, user_id, comment) VALUES ($id, $userId, '$review')");
}

$reviews = fetchAll("
  SELECT r.comment, r.rating, r.created_at, u.username AS reviewer_name
  FROM reviews r
  LEFT JOIN users u ON r.user_id = u.id
  WHERE r.product_id = $id
  ORDER BY r.id DESC
");

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $product['name'] ?? 'Product Not Found' ?></title>

  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/cards.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
</head>
<body>

<div class="topbar">
  <div class="logo">🖥 PC Parts Store</div>
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
  header("Location: product.php?id=$id&msg=Logged out");
  exit;
}
?>

<section class="container">
  <?php if (!$product): ?>
    <div class="alert">Product not found.</div>
  <?php else: ?>
    <!-- Product Info -->
    <div class="product-detail-box" style="max-width: 700px; margin: auto; padding: 2rem; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
      <div class="product-placeholder" style="margin-bottom: 1rem;"></div>
      <h2><?= $product['name'] ?></h2>
      <p style="font-size: 1.2rem; font-weight: bold;">$<?= $product['price'] ?></p>
      <button onclick="addToCart(<?= $product['id'] ?>)" class="btn-primary">Add to Cart</button>
    </div>

    <!-- Reviews -->
    <div class="section-header" style="margin-top: 3rem;">
      <h3>Reviews</h3>
    </div>
    <div style="max-width: 700px; margin: auto;">
      <?php foreach ($reviews as $r): ?>
        <div class="alert">
          <strong><?= htmlspecialchars($r['reviewer_name'] ?? 'Anonymous') ?></strong>
          <em style="float: right; font-size: 0.85rem; color: #666;"><?= $r['created_at'] ?></em><br>
          ⭐ Rating: <?= $r['rating'] ?>/5<br>
          <?= $r['comment'] ?> <!-- Stored XSS -->
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Review Form -->
    <div class="section-header" style="margin-top: 3rem;">
      <h3>Leave a Review</h3>
    </div>
    <form method="POST" style="max-width: 500px; margin: auto;">
      <input type="number" name="user_id" placeholder="User ID (optional)" style="width: 100%; padding: 0.5rem; margin-bottom: 0.5rem;" />
      <textarea name="review" placeholder="Write your review..." rows="4" style="width: 100%; padding: 0.5rem;"></textarea>
      <button type="submit" class="btn-primary" style="margin-top: 0.5rem;">Submit Review</button>
    </form>
  <?php endif; ?>
</section>

<!-- ✅ Add to Cart Script -->
<script>
function addToCart(id) {
  let cart = [];

  try {
    const stored = JSON.parse(localStorage.getItem('cart'));
    if (Array.isArray(stored)) {
      cart = stored.filter(item =>
        typeof item === 'object' && item !== null && 'id' in item && 'quantity' in item
      );
    }
  } catch (e) {
    cart = [];
  }

  id = parseInt(id);
  const existing = cart.find(item => item.id === id);

  if (existing) {
    existing.quantity += 1;
    alert("🔁 Increased quantity in cart.");
  } else {
    cart.push({ id: id, quantity: 1 });
    alert("✅ Product added to cart!");
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  console.log("🛒 Cart:", cart);
}
</script>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
