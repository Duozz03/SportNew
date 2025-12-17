<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/connectDB.php";  // tạo biến $pdo (PDO)

//Start session (nếu chưa)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Require các model mà dự án tin tức thể thao đang dùng

require_once __DIR__ . "/model/category/Category.php";
require_once __DIR__ . "/model/category/CategoryRepository.php";

require_once __DIR__ . "/model/article/Article.php";
require_once __DIR__ . "/model/article/ArticleRepository.php";

require_once __DIR__ . "/model/comment/Comment.php";
require_once __DIR__ . "/model/comment/CommentRepository.php";

require_once __DIR__ . "/model/user/Admin.php";
require_once __DIR__ . "/model/user/AdminRepository.php";

