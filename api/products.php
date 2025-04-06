<?php
require_once '../includes/db.php';

header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

// 💣 SQLi vulnerable endpoint
$sql = "SELECT * FROM products WHERE name LIKE '%$q%' OR description LIKE '%$q%' LIMIT 10";
$results = fetchAll($sql);

// 🔥 No escaping = JSON-based XSS
echo json_encode([
  "results" => $results,
  "query" => $q
]);
