<?php
define("SERVERNAME", "sql312.infinityfree.com");
define("USERNAME", "if0_40654558");
define("PASSWORD", "GC35mhbbFIdr");
define("DBNAME", "if0_40654558_bookstore");
define('ROOT', dirname(dirname(__FILE__)));
//Thu muc tuyet doi truoc cua config; c:/wamp/www/lab/
define("BASE_URL", "http://" . $_SERVER['SERVER_NAME'] . "/lab/"); //dia chi website
try {
    // Tạo kết nối PDO
    $dsn = "mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, USERNAME, PASSWORD);

    // Thiết lập chế độ lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
