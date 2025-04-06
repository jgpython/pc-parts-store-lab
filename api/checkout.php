<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uid = $_POST['user_id'] ?? 0;
  $pid = $_POST['product_id'] ?? 0;
  $qty = $_POST['quantity'] ?? 1;
  $total = $_POST['total'] ?? 0.00;
  $cc = $_POST['card'] ?? 'raw';

  // 💀 Insecure storage
  $data = "CC: $cc, EXP: {$_POST['exp']}, CVV: {$_POST['cvv']}";
  query("INSERT INTO orders (user_id, product_id, quantity, total, status, payment_data) 
         VALUES ($uid, $pid, $qty, $total, 'pending', '$data')");

  echo json_encode(["status" => "order placed"]);
  exit;
}
