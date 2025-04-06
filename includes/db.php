<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // blank password
define('DB_NAME', 'pc_part_store');

// Create a global connection once
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) die("DB Error: " . mysqli_connect_error());

function query($sql) {
    global $conn;
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        echo "<div class='alert'>SQL Error: " . htmlspecialchars(mysqli_error($conn)) . "</div>";
        return false;
    }

    return $res;
}

function fetchAll($sql) {
    $data = [];
    $res = query($sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
    }
    return $data;
}
