<?php

class CategoryController
{
    private function requireLogin()
    {
        if (empty($_SESSION['admin_id'])) {
            header("Location: " . BASE_URL . "site/index.php?c=auth&a=loginForm");
            exit;
        }
    }

    private function redirectIndex(): void
    {
        header("Location: " . BASE_URL . "site/index.php?c=category&a=index");
        exit;
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION["flash_" . $type] = $message;
    }

    public function index()
    {
        $this->requireLogin();
        global $pdo;

        $repo = new CategoryRepository($pdo);
        $categories = $repo->findAll();

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/category/index.php";
        include __DIR__ . "/../layout/footer.php";
    }

    public function create()
    {
        $this->requireLogin();
        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/category/create.php";
        include __DIR__ . "/../layout/footer.php";
    }

    public function store()
    {
        $this->requireLogin();
        global $pdo;

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');

        if ($name === '') {
            $this->flash('error', "Tên chuyên mục không được để trống.");
            $this->redirectIndex();
        }

        // Cho phép bỏ trống slug -> tự generate
        if ($slug === '') {
            $slug = $this->generateSlug($name);
        }

        // Chặn trùng slug
        if ($this->slugExists($slug)) {
            $this->flash('error', "Slug đã tồn tại. Vui lòng chọn slug khác.");
            $this->redirectIndex();
        }

        $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (:name, :slug)");
        $stmt->execute(['name' => $name, 'slug' => $slug]);

        $this->flash('success', "Đã thêm chuyên mục thành công.");
        $this->redirectIndex();
    }

    public function delete()
    {
        $this->requireLogin();
        global $pdo;

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            $this->flash('error', "ID chuyên mục không hợp lệ.");
            $this->redirectIndex();
        }

        // 1) Kiểm tra còn bài viết trong chuyên mục không
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        $count = (int)$stmt->fetchColumn();

        if ($count > 0) {
            $this->flash('error', "Không thể xóa chuyên mục vì còn {$count} bài viết thuộc chuyên mục này.");
            $this->redirectIndex();
        }

        // 2) Xóa chuyên mục
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $this->flash('success', "Đã xóa chuyên mục thành công.");
        $this->redirectIndex();
    }

    public function articles()
    {
        global $pdo;

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            // frontend -> đơn giản die cũng được, nhưng có thể làm page 404 sau
            die("Chuyên mục không hợp lệ");
        }

        $categoryRepo = new CategoryRepository($pdo);
        $articleRepo  = new ArticleRepository($pdo);

        $category = $categoryRepo->findById($id);
        if (!$category) {
            die("Không tìm thấy chuyên mục");
        }

        // Phân trang
        $limit  = 5;
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $totalArticles = $articleRepo->countByCategory($id);
        $totalPages    = (int)ceil($totalArticles / $limit);

        $articles = $articleRepo->getPageByCategory($id, $offset, $limit);

        // nếu layout cần categories
        $categories = $categoryRepo->findAll();

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/category/articles.php";
        include __DIR__ . "/../layout/footer.php";
    }

    public function edit()
    {
        $this->requireLogin();
        global $pdo;

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            $this->flash('error', "ID chuyên mục không hợp lệ.");
            $this->redirectIndex();
        }

        $repo = new CategoryRepository($pdo);
        $category = $repo->findById($id);
        if (!$category) {
            $this->flash('error', "Không tìm thấy chuyên mục.");
            $this->redirectIndex();
        }

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/category/edit.php";
        include __DIR__ . "/../layout/footer.php";
    }

    public function update()
    {
        $this->requireLogin();
        global $pdo;

        $id   = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');

        if ($id <= 0) {
            $this->flash('error', "ID chuyên mục không hợp lệ.");
            $this->redirectIndex();
        }
        if ($name === '') {
            $this->flash('error', "Tên chuyên mục không được để trống.");
            $this->redirectIndex();
        }

        if ($slug === '') {
            $slug = $this->generateSlug($name);
        }

        // Chặn trùng slug (nhưng bỏ qua chính nó)
        if ($this->slugExists($slug, $id)) {
            $this->flash('error', "Slug đã tồn tại. Vui lòng chọn slug khác.");
            $this->redirectIndex();
        }

        $repo = new CategoryRepository($pdo);
        $repo->update($id, $name, $slug);

        $this->flash('success', "Đã cập nhật chuyên mục thành công.");
        $this->redirectIndex();
    }

    private function slugExists(string $slug, int $excludeId = 0): bool
    {
        global $pdo;

        $sql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
        if ($excludeId > 0) {
            $sql .= " AND id <> :excludeId";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        if ($excludeId > 0) {
            $stmt->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return (int)$stmt->fetchColumn() > 0;
    }

    private function generateSlug(string $str): string
    {
        $str = mb_strtolower($str, 'UTF-8');

        $patterns = [
            '/[áàạảãăắằặẳẵâấầậẩẫ]/u',
            '/[éèẹẻẽêếềệểễ]/u',
            '/[íìịỉĩ]/u',
            '/[óòọỏõôốồộổỗơớờợởỡ]/u',
            '/[úùụủũưứừựửữ]/u',
            '/[ýỳỵỷỹ]/u',
            '/[đ]/u',
        ];
        $replacements = ['a', 'e', 'i', 'o', 'u', 'y', 'd'];
        $str = preg_replace($patterns, $replacements, $str);

        $str = preg_replace('/[^a-z0-9]+/', '-', $str);
        $str = trim($str, '-');

        // fallback nếu name toàn ký tự đặc biệt
        if ($str === '') {
            $str = 'category-' . time();
        }

        return $str;
    }
}
