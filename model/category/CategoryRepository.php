<?php

require_once __DIR__ . '/Category.php';

class CategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT id, name, slug, created_at FROM categories ORDER BY name ASC";
        $stmt = $this->pdo->query($sql);

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                (int)$row['id'],
                $row['name'],
                $row['slug'],
                $row['created_at']
            );
        }

        return $categories;
    }

    public function findById(int $id): ?Category
    {
        $sql = "SELECT id, name, slug, created_at FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Category(
            (int)$row['id'],
            $row['name'],
            $row['slug'],
            $row['created_at']
        );
    }

    public function insert(string $name, string $slug): void
    {
        $sql = "INSERT INTO categories (name, slug) VALUES (:name, :slug)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'slug' => $slug
        ]);
    }

    public function update(int $id, string $name, string $slug): void
    {
        $sql = "UPDATE categories SET name = :name, slug = :slug WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id'   => $id,
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    // Kiểm tra slug đã tồn tại chưa (dùng cho create/update)
    public function existsSlug(string $slug, int $excludeId = 0): bool
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
        if ($excludeId > 0) {
            $sql .= " AND id <> :excludeId";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        if ($excludeId > 0) {
            $stmt->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return (int)$stmt->fetchColumn() > 0;
    }
}
