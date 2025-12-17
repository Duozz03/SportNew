<?php

class AdminController
{
    private function requireLogin()
    {
        if (empty($_SESSION['admin_id'])) {
            header("Location: " . BASE_URL . "site/index.php?c=auth&a=loginForm");
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireLogin();
        global $pdo;

        // Thống kê cơ bản
        $totalArticles   = (int)$pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
        $totalCategories = (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

        $totalComments = 0;
        try {
            $totalComments = (int)$pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
        } catch (Throwable $e) {
        }

        // Bài viết mới nhất
        $sqlLatest = "SELECT a.id, a.title, a.created_at, c.name AS category_name
                      FROM articles a
                      LEFT JOIN categories c ON a.category_id = c.id
                      ORDER BY a.created_at DESC
                      LIMIT 5";
        $latestArticles = $pdo->query($sqlLatest)->fetchAll(PDO::FETCH_ASSOC);

        // Bài viết được đánh giá cao nhất
        $topRatedArticles = [];
        try {
            $sqlTopRated = "SELECT a.id, a.title,
                                   AVG(c.rating) AS avg_rating,
                                   COUNT(c.id) AS total_ratings
                            FROM articles a
                            JOIN comments c ON a.id = c.article_id
                            GROUP BY a.id, a.title
                            HAVING COUNT(c.id) >= 1
                            ORDER BY avg_rating DESC, total_ratings DESC
                            LIMIT 5";
            $topRatedArticles = $pdo->query($sqlTopRated)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
        }

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/admin/dashboard.php";
        include __DIR__ . "/../layout/footer.php";
    }
}
