<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 🔓 Insecure query
$res = fetchAll("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
$user = $res[0] ?? null;

if ($user) {
  $token = base64_encode(json_encode([
    "id" => $user['id'],
    "user" => $user['username'],
    "role" => $user['role']
  ]));

  echo json_encode(["token" => $token]);
} else {
  echo json_encode(["error" => "Login failed"]);
}
