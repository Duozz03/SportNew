<?php
define("SERVERNAME", "sql312.infinityfree.com");
define("USERNAME", "if0_40654558");
define("PASSWORD", "GC35mhbbFIdr");
define("DBNAME", "if0_40654558_bookstore");
try {
    // Tạo kết nối PDO
    $dsn = "mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, USERNAME, PASSWORD);

    // Thiết lập chế độ lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
