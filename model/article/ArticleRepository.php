<?php

require_once __DIR__ . '/Article.php';

class ArticleRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy N bài mới nhất
    public function getLatest(int $limit = 10): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                       content, created_at, updated_at, status
                FROM articles
                WHERE status = 1
                ORDER BY created_at DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }

        return $articles;
    }

    // Lấy chi tiết 1 bài viết
    public function findById(int $id): ?Article
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                       content, created_at, updated_at, status
                FROM articles
                WHERE id = :id AND status = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new Article(
            (int)$row['id'],
            (int)$row['category_id'],
            $row['title'],
            $row['thumbnail'],
            $row['short_description'],
            $row['content'],
            $row['created_at'],
            $row['updated_at'],
            (int)$row['status']
        );
    }
    public function findByIdAdmin(int $id): ?Article
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            WHERE id = :id
            LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Article(
            (int)$row['id'],
            (int)$row['category_id'],
            $row['title'],
            $row['thumbnail'],
            $row['short_description'],
            $row['content'],
            $row['created_at'],
            $row['updated_at'],
            (int)$row['status']
        );
    }

    // Lấy tất cả bài (hoặc giới hạn)
    public function findAll(int $limit = 100): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            WHERE status = 1
            ORDER BY created_at DESC
            LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }
        return $data;
    }
    // Thêm bài viết mới
    public function insert(
        int $category_id,
        string $title,
        ?string $thumbnail,
        ?string $short_description,
        ?string $content,
        int $status = 1
    ): void {
        $sql = "INSERT INTO articles
                (category_id, title, thumbnail, short_description, content, status)
                VALUES (:category_id, :title, :thumbnail, :short_description, :content, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'category_id'       => $category_id,
            'title'             => $title,
            'thumbnail'         => $thumbnail,
            'short_description' => $short_description,
            'content'           => $content,
            'status'            => $status,
        ]);
    }

    // Cập nhật bài viết
    public function update(
        int $id,
        int $category_id,
        string $title,
        ?string $thumbnail,
        ?string $short_description,
        ?string $content,
        int $status = 1
    ): void {
        $sql = "UPDATE articles
                SET category_id = :category_id,
                    title = :title,
                    thumbnail = :thumbnail,
                    short_description = :short_description,
                    content = :content,
                    status = :status
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id'                => $id,
            'category_id'       => $category_id,
            'title'             => $title,
            'thumbnail'         => $thumbnail,
            'short_description' => $short_description,
            'content'           => $content,
            'status'            => $status,
        ]);
    }

    // Xóa bài viết
    public function delete(int $id): void
    {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM articles WHERE status = 1";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }

    public function getPage(int $offset, int $limit): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            WHERE status = 1
            ORDER BY created_at DESC
            LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }

        return $data;
    }
    // Đếm tất cả bài viết (kể cả ẩn) cho admin
    public function countAllAdmin(): int
    {
        $sql = "SELECT COUNT(*) FROM articles";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }

    // Lấy 1 trang bài viết cho admin (không lọc status)
    public function getPageAdmin(int $offset, int $limit): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            ORDER BY created_at DESC
            LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }

        return $data;
    }
    // Đếm số bài trong một chuyên mục (frontend)
    public function countByCategory(int $categoryId): int
    {
        $sql = "SELECT COUNT(*) FROM articles WHERE status = 1 AND category_id = :cid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cid' => $categoryId]);
        return (int)$stmt->fetchColumn();
    }

    // Lấy 1 trang bài viết trong một chuyên mục (frontend)
    public function getPageByCategory(int $categoryId, int $offset, int $limit): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            WHERE status = 1 AND category_id = :cid
            ORDER BY created_at DESC
            LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cid', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }

        return $data;
    }
    // Đếm kết quả tìm kiếm
    public function countSearch(string $keyword): int
    {
        $sql = "SELECT COUNT(*) FROM articles
            WHERE status = 1 AND title LIKE :kw";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['kw' => "%$keyword%"]);
        return (int)$stmt->fetchColumn();
    }

    // Lấy bài tìm kiếm theo trang
    public function search(string $keyword, int $offset, int $limit): array
    {
        $sql = "SELECT id, category_id, title, thumbnail, short_description,
                   content, created_at, updated_at, status
            FROM articles
            WHERE status = 1 AND title LIKE :kw
            ORDER BY created_at DESC
            LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Article(
                (int)$row['id'],
                (int)$row['category_id'],
                $row['title'],
                $row['thumbnail'],
                $row['short_description'],
                $row['content'],
                $row['created_at'],
                $row['updated_at'],
                (int)$row['status']
            );
        }

        return $data;
    }
}
