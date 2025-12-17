<?php

class HomeController
{
    public function index()
    {
        // Lấy PDO từ bootstrap
        global $pdo;

        // Nhờ autoload, chỉ cần new là được
        $categoryRepo = new CategoryRepository($pdo);
        $articleRepo  = new ArticleRepository($pdo);

        $categories = $categoryRepo->findAll();
        $articles   = $articleRepo->getLatest(10);

        // Gọi view
        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/home/index.php";
        include __DIR__ . "/../layout/footer.php";
    }
}
