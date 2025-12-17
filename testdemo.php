<?php
require_once "connectDB.php";
require_once "model/category/CategoryRepository.php";
require_once "model/article/ArticleRepository.php";

// Khởi tạo repo
$categoryRepo = new CategoryRepository($pdo);
$articleRepo  = new ArticleRepository($pdo);

// Lấy dữ liệu
$categories = $categoryRepo->findAll();
$latest     = $articleRepo->getLatest(5);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Test Model</title>
</head>
<body>
<h2>Chuyên mục</h2>
<ul>
    <?php foreach ($categories as $c): ?>
        <li><?= $c->id ?> - <?= $c->name ?> (<?= $c->slug ?>)</li>
    <?php endforeach; ?>
</ul>

<h2>Tin mới nhất</h2>
<ul>
    <?php foreach ($latest as $a): ?>
        <li><?= $a->id ?> - <?= $a->title ?> (<?= $a->created_at ?>)</li>
    <?php endforeach; ?>
</ul>
</body>
</html>
