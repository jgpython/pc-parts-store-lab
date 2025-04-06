<?php
session_start();
require_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? 'Anonymous';
  $address = $_POST['address'] ?? '';
  $card = $_POST['card'] ?? '';
  $exp = $_POST['exp'] ?? '';
  $cvv = $_POST['cvv'] ?? '';
  $userId = $_POST['user_id'] ?? 1; // 💣 IDOR – no validation
  $cart = json_decode($_POST['cart'] ?? '[]', true);

  foreach ($cart as $item) {
    $productId = $item['id'];
    $quantity = $item['quantity'];

    // 💥 Use hardcoded pricing for insecure flow
    $prices = [1=>1599.99,2=>699.99,3=>249.99,4=>89.99,5=>129.99,6=>149.99,7=>159.99,8=>399.99,9=>179.99,10=>129.99,12=>129.99];
    $total = $prices[$productId] * $quantity;

    $paymentData = "CC: $card, EXP: $exp, CVV: $cvv";

    // 💣 Raw insert
    query("INSERT INTO orders (user_id, product_id, quantity, total, status, payment_data)
           VALUES ($userId, $productId, $quantity, $total, 'pending', '$paymentData')");
  }

  header("Location: confirmation.php?id=$userId");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
  <style>
    .checkout-box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      max-width: 600px;
      margin: auto;
    }
    input[type="text"], input[type="number"] {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="logo">💳 Checkout</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="cart.php">Cart</a>
  </div>
</div>

<section class="container">
  <div class="checkout-box">
    <h2>Billing Information</h2>
    <form method="POST">
      <input type="hidden" name="user_id" value="1" /> <!-- 🔥 IDOR -->
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="text" name="address" placeholder="Shipping Address" required />
      <input type="text" name="card" placeholder="Card Number (16 digits)" required />
      <input type="text" name="exp" placeholder="Expiration (MM/YY)" required />
      <input type="number" name="cvv" placeholder="CVV" required />

      <!-- Cart -->
      <input type="hidden" name="cart" id="cart-data" />
      <p><strong>Total (Estimated):</strong> $<span id="display-total">0.00</span></p>

      <button type="submit" class="btn-primary">Place Order</button>
    </form>
  </div>
</section>

<script>
// 💣 Insecure client-only cart values
const cart = JSON.parse(localStorage.getItem('cart') || '[]');
document.getElementById('cart-data').value = JSON.stringify(cart);

const prices = {1:1599.99,2:699.99,3:249.99,4:89.99,5:129.99,6:149.99,7:159.99,8:399.99,9:179.99,10:129.99,12:129.99};
let total = 0;
cart.forEach(item => {
  const price = prices[item.id] || 0;
  total += price * item.quantity;
});

document.getElementById('display-total').textContent = total.toFixed(2);
</script>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
