<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $_POST['product_id'] ?? 0;
  $user_id = $_POST['user_id'] ?? 1; // 💣 IDOR
  $comment = $_POST['comment'] ?? '';
  $rating = $_POST['rating'] ?? 5;

  // 💀 Stored XSS
  query("INSERT INTO reviews (product_id, user_id, comment, rating) VALUES ($product_id, $user_id, '$comment', $rating)");

  echo json_encode(["status" => "success"]);
  exit;
}

// Optional: return last reviews
echo json_encode(fetchAll("SELECT * FROM reviews ORDER BY id DESC LIMIT 10"));
