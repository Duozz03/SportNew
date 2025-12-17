<?php

class ArticleController
{
    private function requireLogin()
    {
        if (empty($_SESSION['admin_id'])) {
            // Chưa đăng nhập admin -> chuyển về trang login
            header("Location: " . BASE_URL . "site/index.php?c=auth&a=loginForm");
            exit;
        }
    }
    // Hiển thị danh sách tất cả bài viết
    public function list()
    {
        global $pdo;

        $articleRepo = new ArticleRepository($pdo);
        $categoryRepo = new CategoryRepository($pdo);

        $categories = $categoryRepo->findAll();

        // THIẾT LẬP PHÂN TRANG
        $limit = 5; // mỗi trang hiển thị 5 bài (tùy em)
        $page  = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        $totalArticles = $articleRepo->countAll();
        $totalPages = ceil($totalArticles / $limit);

        $articles = $articleRepo->getPage($offset, $limit);

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/list.php";
        include __DIR__ . "/../layout/footer.php";
    }

    // Hiển thị chi tiết 1 bài viết
    public function detail()
    {
        global $pdo;

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            die("ID bài viết không hợp lệ");
        }

        $articleRepo  = new ArticleRepository($pdo);
        $categoryRepo = new CategoryRepository($pdo);
        $commentRepo   = new CommentRepository($pdo);

        $article = $articleRepo->findById($id);
        if (!$article) {
            die("Không tìm thấy bài viết");
        }
        $comments      = $commentRepo->findByArticle($id);
        $ratingSummary = $commentRepo->getRatingSummary($id);
        $totalRatings  = $ratingSummary['total'];
        $avgRating     = $ratingSummary['avg_rating'];
        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/detail.php";
        include __DIR__ . "/../layout/footer.php";
    }
    // Trang quản lý bài viết (admin)
    public function manage()
    {
        $this->requireLogin();
        global $pdo;

        $articleRepo  = new ArticleRepository($pdo);
        $categoryRepo = new CategoryRepository($pdo);

        $categories = $categoryRepo->findAll();

        // PHÂN TRANG ADMIN
        $limit = 10;  // mỗi trang quản lý 10 bài
        $page  = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        $totalArticles = $articleRepo->countAllAdmin();
        $totalPages    = ceil($totalArticles / $limit);

        $articles = $articleRepo->getPageAdmin($offset, $limit);

        // Map category_id => name
        $categoryMap = [];
        foreach ($categories as $c) {
            $categoryMap[$c->id] = $c->name;
        }

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/manage.php";
        include __DIR__ . "/../layout/footer.php";
    }

    // Hiển thị form thêm
    public function create()
    {
        $this->requireLogin();
        global $pdo;

        $categoryRepo = new CategoryRepository($pdo);
        $categories   = $categoryRepo->findAll();

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/create.php";
        include __DIR__ . "/../layout/footer.php";
    }

    // Xử lý lưu bài mới
    public function store()
    {
        $this->requireLogin();
        global $pdo;

        $category_id       = (int)($_POST['category_id'] ?? 0);
        $title             = trim($_POST['title'] ?? '');
        $short_description = trim($_POST['short_description'] ?? '');
        $content           = trim($_POST['content'] ?? '');
        $status            = isset($_POST['status']) ? 1 : 0;

        if ($category_id <= 0 || $title === '') {
            die("Thiếu chuyên mục hoặc tiêu đề");
        }

        // Xử lý upload ảnh
        $thumbnail = null;

        if (!empty($_FILES['thumbnail_file']['name'])) {
            $file     = $_FILES['thumbnail_file'];
            $allowed  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize  = 2 * 1024 * 1024; // 2MB

            $finfoType = @mime_content_type($file['tmp_name']);
            if (!in_array($finfoType, $allowed)) {
                die("Chỉ cho phép upload ảnh (jpg, png, gif, webp)");
            }

            if ($file['size'] > $maxSize) {
                die("Ảnh quá lớn, tối đa 2MB");
            }

            $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName  = uniqid('thumb_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../upload/';
            $target    = $uploadDir . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $target)) {
                die("Upload ảnh thất bại");
            }

            $thumbnail = $fileName;
        }

        $articleRepo = new ArticleRepository($pdo);
        $articleRepo->insert(
            $category_id,
            $title,
            $thumbnail,
            $short_description ?: null,
            $content ?: null,
            $status
        );

        header("Location: index.php?c=article&a=manage");
        exit;
    }


    // Hiển thị form sửa
    public function edit()
    {
        $this->requireLogin();
        global $pdo;

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            die("ID không hợp lệ");
        }

        $articleRepo  = new ArticleRepository($pdo);
        $categoryRepo = new CategoryRepository($pdo);

        $article    = $articleRepo->findByIdAdmin($id);
        if (!$article) {
            die("Không tìm thấy bài viết");
        }

        $categories = $categoryRepo->findAll();

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/edit.php";
        include __DIR__ . "/../layout/footer.php";
    }

    // Xử lý update
    public function update()
    {
        $this->requireLogin();
        global $pdo;

        $id                = (int)($_POST['id'] ?? 0);
        $category_id       = (int)($_POST['category_id'] ?? 0);
        $title             = trim($_POST['title'] ?? '');
        $short_description = trim($_POST['short_description'] ?? '');
        $content           = trim($_POST['content'] ?? '');
        $status            = isset($_POST['status']) ? 1 : 0;
        $old_thumbnail     = $_POST['old_thumbnail'] ?? null;

        if ($id <= 0 || $category_id <= 0 || $title === '') {
            die("Thiếu dữ liệu");
        }

        $thumbnail = $old_thumbnail;

        // Nếu user upload ảnh mới
        if (!empty($_FILES['thumbnail_file']['name'])) {
            $file     = $_FILES['thumbnail_file'];
            $allowed  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize  = 2 * 1024 * 1024; // 2MB

            $finfoType = @mime_content_type($file['tmp_name']);
            if (!in_array($finfoType, $allowed)) {
                    die("Chỉ cho phép upload ảnh (jpg, png, gif, webp)");
            }

            if ($file['size'] > $maxSize) {
                die("Ảnh quá lớn, tối đa 2MB");
            }

            $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName  = uniqid('thumb_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../upload/';
            $target    = $uploadDir . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $target)) {
                die("Upload ảnh thất bại");
            }

            // Xóa ảnh cũ nếu có
            if (!empty($old_thumbnail)) {
                $oldPath = $uploadDir . $old_thumbnail;
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $thumbnail = $fileName;
        }

        $articleRepo = new ArticleRepository($pdo);
        $articleRepo->update(
            $id,
            $category_id,
            $title,
            $thumbnail,
            $short_description ?: null,
            $content ?: null,
            $status
        );

        header("Location: index.php?c=article&a=manage");
        exit;
    }


    // Xóa bài
    public function delete()
    {
        $this->requireLogin();
        global $pdo;

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            die("ID không hợp lệ");
        }

        $articleRepo = new ArticleRepository($pdo);
        $articleRepo->delete($id);

        header("Location: index.php?c=article&a=manage");
        exit;
    }
    public function search()
    {
        global $pdo;

        $keyword = trim($_GET['keyword'] ?? '');
        if ($keyword === '') {
            die("Vui lòng nhập từ khóa");
        }

        $articleRepo  = new ArticleRepository($pdo);
        $categoryRepo = new CategoryRepository($pdo);

        // Phân trang
        $limit  = 5;
        $page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        $totalArticles = $articleRepo->countSearch($keyword);
        $totalPages    = ceil($totalArticles / $limit);

        $articles = $articleRepo->search($keyword, $offset, $limit);

        $categories = $categoryRepo->findAll();

        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/article/search.php";
        include __DIR__ . "/../layout/footer.php";
    }
}
