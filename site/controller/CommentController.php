<?php

class CommentController
{
    // Xử lý form gửi bình luận
    public function store()
    {
        global $pdo;

        $articleId   = (int)($_POST['article_id'] ?? 0);
        $authorName  = trim($_POST['author_name'] ?? '');
        $content     = trim($_POST['content'] ?? '');
        $rating      = (int)($_POST['rating'] ?? 0);

        if ($articleId <= 0 || $authorName === '' || $content === '' || $rating < 1 || $rating > 5) {
            $_SESSION['comment_error'] = "Vui lòng nhập đầy đủ thông tin và chọn số sao (1-5).";
            header("Location: " . BASE_URL . "article/" . $articleId);
            exit;
        }

        $repo = new CommentRepository($pdo);
        $repo->insert($articleId, $authorName, $content, $rating);

        $_SESSION['comment_success'] = "Cảm ơn bạn đã bình luận!";
        header("Location: " . BASE_URL . "article/" . $articleId);
        exit;
    }
}
