<?php

class CommentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy tất cả comment (đang hiển thị) của 1 bài
    public function findByArticle(int $articleId): array
    {
        $sql = "SELECT id, article_id, author_name, content, rating, created_at, status
                FROM comments
                WHERE article_id = :article_id AND status = 1
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Comment(
                (int)$row['id'],
                (int)$row['article_id'],
                $row['author_name'],
                $row['content'],
                (int)$row['rating'],
                $row['created_at'],
                (int)$row['status']
            );
        }

        return $data;
    }

    // Thêm comment mới
    public function insert(int $articleId, string $authorName, string $content, int $rating): void
    {
        $sql = "INSERT INTO comments (article_id, author_name, content, rating)
                VALUES (:article_id, :author_name, :content, :rating)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'article_id'  => $articleId,
            'author_name' => $authorName,
            'content'     => $content,
            'rating'      => $rating,
        ]);
    }

    // Tính điểm trung bình + số lượt đánh giá 1 bài
    public function getRatingSummary(int $articleId): array
    {
        $sql = "SELECT COUNT(*) AS total, AVG(rating) AS avg_rating
                FROM comments
                WHERE article_id = :article_id AND status = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total'      => (int)($row['total'] ?? 0),
            'avg_rating' => $row['avg_rating'] ? round($row['avg_rating'], 1) : 0,
        ];
    }
}
