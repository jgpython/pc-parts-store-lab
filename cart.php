<?php
// cart.php (pure client-side version with fixed styles)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db.php';
$allProducts = fetchAll("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components/buttons.css">
  <link rel="stylesheet" href="assets/css/components/cards.css">
  <link rel="stylesheet" href="assets/css/components/alerts.css">
  <style>
    .cart-container {
      max-width: 800px;
      margin: 3rem auto;
      padding: 2rem;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }
    .cart-item h3 {
      margin: 0;
    }
    .cart-total {
      font-size: 1.3rem;
      font-weight: bold;
      text-align: right;
      margin-top: 1.5rem;
    }
    .cart-actions {
      text-align: right;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <div class="logo">🛒 Your Cart</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="checkout.php">Checkout</a>
  </div>
</div>

<!-- CONTAINER -->
<section class="container">
  <h2>🧾 Items in Your Cart</h2>

  <div class="cart-container">
    <div id="cart-items"></div>
    <div class="cart-total">Total: $<span id="cart-total">0.00</span></div>
    <div class="cart-actions">
      <button onclick="checkout()" class="btn-primary">Proceed to Checkout</button>
    </div>
  </div>
</section>

<script>
const ALL_PRODUCTS = <?= json_encode($allProducts) ?> || [];
let cart = JSON.parse(localStorage.getItem('cart') || '[]');

const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');

function renderCart() {
  cartItemsEl.innerHTML = '';
  let total = 0;

  if (!cart.length) {
    cartItemsEl.innerHTML = `<div class="alert">Your cart is empty.</div>`;
    cartTotalEl.textContent = "0.00";
    return;
  }

  cart.forEach(item => {
    const prod = ALL_PRODUCTS.find(p => p.id == item.id);
    if (!prod) return;

    const subTotal = parseFloat(prod.price) * item.quantity;
    total += subTotal;

    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <div>
        <h3>${prod.name}</h3>
        <p>$${prod.price} × ${item.quantity} = <strong>$${subTotal.toFixed(2)}</strong></p>
      </div>
      <button class="btn-primary" style="background:#dc3545;" onclick="removeFromCart(${prod.id})">Remove</button>
    `;
    cartItemsEl.appendChild(div);
  });

  cartTotalEl.textContent = total.toFixed(2);
}

function removeFromCart(id) {
  cart = cart.filter(i => i.id !== id);
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}
function checkout() {
  const cart = localStorage.getItem('cart');
  if (cart) {
    // Pass cart JSON directly via query param (💣 insecure, for testing)
    window.location.href = 'checkout.php?cart=' + encodeURIComponent(cart);
  } else {
    alert("Your cart is empty.");
  }
}

renderCart();
</script>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
