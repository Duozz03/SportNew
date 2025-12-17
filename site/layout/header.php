<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$isAdmin = !empty($_SESSION['admin_id']);
$c = $_GET['c'] ?? '';
$a = $_GET['a'] ?? '';
$categories = [];
try {
  if (isset($pdo)) {
    require_once __DIR__ . '/../../model/category/CategoryRepository.php';
    require_once __DIR__ . '/../../model/category/Category.php';
    $cateRepo = new CategoryRepository($pdo);
    $categories = $cateRepo->findAll();
  }
} catch (Throwable $e) {
  $categories = [];
}

$maxTabs = 6;
$tabs = !empty($categories) ? array_slice($categories, 0, $maxTabs) : [];
$more = !empty($categories) ? array_slice($categories, $maxTabs) : [];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tin tức thể thao</title>
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>site/layout/favicon.ico">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --ink: #0f172a;
      --muted: #64748b;
      --line: #e5e7eb;
      --brand: #b91c1c;
      --bg: #f3f4f6;
      --tab: #0f172a;
      --ring: rgba(37, 99, 235, .18);
    }

    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: var(--bg);
      color: var(--ink);
    }

    /* Topbar */
    .topbar {
      background: #fff;
      border-bottom: 1px solid var(--line);
      font-size: 13px;
      color: var(--muted);
    }

    .topbar a {
      color: var(--muted);
      text-decoration: none;
      font-weight: 600;
    }

    .topbar a:hover {
      color: var(--ink);
    }

    .live-dot {
      width: 7px;
      height: 7px;
      border-radius: 999px;
      background: var(--brand);
      display: inline-block;
      box-shadow: 0 0 0 3px rgba(185, 28, 28, .10);
    }

    /* Header main */
    .header {
      background: #fff;
      border-bottom: 1px solid var(--line);
      position: sticky;
      top: 0;
      z-index: 1030;
      transition: box-shadow .2s ease, border-color .2s ease;
    }

    .header.is-scrolled {
      box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
      border-bottom-color: rgba(229, 231, 235, .85);
    }

    /* Brand */
    .brand {
      font-weight: 900;
      text-decoration: none;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: .65rem;
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--brand), #ef4444);
      color: #fff;
      font-weight: 950;
      font-size: 14px;
      letter-spacing: .02em;
      box-shadow: 0 10px 18px rgba(185, 28, 28, .18);
    }

    .brand-name {
      font-size: 18px;
      line-height: 1.05;
      letter-spacing: .01em;
    }

    .brand-sub {
      font-size: 12.5px;
      color: var(--muted);
      font-weight: 650;
      margin-top: 2px;
    }

    /* Search */
    .searchbar {
      background: #f8fafc;
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: 6px 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      min-width: 320px;
    }

    .searchbar .icon {
      color: var(--muted);
      font-size: 14px;
      line-height: 1;
    }

    .searchbar input {
      border: 0;
      outline: 0;
      background: transparent;
      width: 100%;
      font-size: 14px;
    }

    .searchbar:focus-within {
      border-color: rgba(37, 99, 235, .35);
      box-shadow: 0 0 0 4px var(--ring);
      background: #fff;
    }

    .searchbar button {
      border: 0;
      background: var(--ink);
      color: #fff;
      padding: 7px 14px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 800;
    }

    .searchbar button:hover {
      opacity: .94;
    }

    /* Category nav (tabs) */
    .catnav {
      background: #fff;
      border-top: 1px solid #f1f5f9;
      border-bottom: 1px solid var(--line);
    }

    /* IMPORTANT: only the tab list scrolls horizontally, dropdown stays outside and can open downward */
    .catnav-scroll {
      overflow-x: auto;
      overflow-y: visible;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
    }

    .catnav .nav {
      gap: 6px;
    }

    .catnav .nav-link {
      color: var(--tab);
      font-weight: 800;
      font-size: 14px;
      padding: 10px 12px;
      border-radius: 999px;
      border: 1px solid transparent;
      white-space: nowrap;
    }

    .catnav .nav-link:hover {
      background: #f8fafc;
      border-color: #eef2f7;
      color: var(--brand);
    }

    .catnav .nav-link.active {
      color: #fff;
      background: linear-gradient(90deg, var(--brand), #ef4444);
      border-color: rgba(185, 28, 28, .25);
      box-shadow: 0 10px 18px rgba(185, 28, 28, .12);
    }

    /* Dropdown must appear above everything */
    .catnav .dropdown-menu {
      z-index: 2000;
    }

    /* Admin dropdown button */
    .admin-btn {
      border: 1px solid var(--line);
      background: #fff;
      border-radius: 999px;
      padding: 8px 12px;
      font-weight: 800;
      font-size: 13px;
      color: var(--ink);
    }

    .admin-btn:hover {
      background: #f9fafb;
    }

    /* Utility */
    .divider-v {
      width: 1px;
      height: 22px;
      background: var(--line);
    }

    .small-muted {
      color: var(--muted);
      font-size: 13px;
    }

    main {
      padding: 18px 0 40px;
    }

    .page-wrap .content {
      background: transparent;
    }

    @media (max-width: 992px) {
      .searchbar {
        min-width: 220px;
      }

      .brand-name {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>

  <!-- TOPBAR -->
  <div class="topbar py-1">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <span class="small-muted d-flex align-items-center gap-2">
          <span class="live-dot"></span>
          Tin nhanh • Thể thao • 24/24
        </span>
        <span class="divider-v d-none d-md-inline-block"></span>
        <a class="d-none d-md-inline-block" href="<?= BASE_URL ?>articles">Mới nhất</a>
      </div>

      <div class="d-flex align-items-center gap-2">
        <?php if ($isAdmin): ?>
          <span class="small-muted d-none d-md-inline-block">
            Xin chào, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>
          </span>
        <?php else: ?>
          <span class="small-muted d-none d-md-inline-block">Đọc nhanh, rõ ràng, cập nhật liên tục</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- HEADER -->
  <header class="header">
    <div class="container py-2 d-flex align-items-center justify-content-between gap-3">
      <a class="brand" href="<?= BASE_URL ?>">
        <span class="brand-badge">24h</span>
        <span>
          <div class="brand-name">Tin Thể Thao</div>
          <div class="brand-sub">24/7 Sports News</div>
        </span>
      </a>

      <div class="d-flex align-items-center gap-2">
        <!-- Search (desktop) -->
        <form class="searchbar d-none d-md-flex" action="<?= BASE_URL ?>site/index.php" method="get">
          <span class="icon">🔎</span>
          <input type="hidden" name="c" value="article">
          <input type="hidden" name="a" value="search">
          <input type="search" name="keyword" placeholder="Tìm kiếm bài viết..." aria-label="Tìm kiếm">
          <button type="submit">Tìm</button>
        </form>

        <?php if ($isAdmin): ?>
          <div class="dropdown">
            <button class="admin-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Quản trị
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= BASE_URL ?>site/index.php?c=admin&a=dashboard">Dashboard</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>site/index.php?c=article&a=manage">Quản lý bài viết</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>site/index.php?c=category&a=index">Quản lý chuyên mục</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>site/index.php?c=auth&a=logout">Đăng xuất</a></li>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Mobile search toggle -->
        <button class="btn btn-outline-dark btn-sm d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch">
          Tìm kiếm
        </button>
      </div>
    </div>

    <!-- Search (mobile) -->
    <div class="container pb-2 d-md-none">
      <div class="collapse" id="mobileSearch">
        <form class="searchbar w-100" action="<?= BASE_URL ?>site/index.php" method="get">
          <span class="icon">🔎</span>
          <input type="hidden" name="c" value="article">
          <input type="hidden" name="a" value="search">
          <input type="search" name="keyword" placeholder="Tìm kiếm bài viết..." aria-label="Tìm kiếm">
          <button type="submit">Tìm</button>
        </form>
      </div>
    </div>

    <!-- CATEGORY NAV (FIXED DROPDOWN) -->
    <nav class="catnav">
      <div class="container">
        <div class="d-flex align-items-center gap-2">

          <!-- LEFT: tabs (scrollable) -->
          <div class="catnav-scroll flex-grow-1">
            <ul class="nav nav-pills flex-nowrap">
              <li class="nav-item">
                <a class="nav-link <?= ($c === '' || $c === 'home') ? 'active' : '' ?>" href="<?= BASE_URL ?>">Trang chủ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($c === 'article' && $a === 'list') ? 'active' : '' ?>" href="<?= BASE_URL ?>articles">Mới nhất</a>
              </li>

              <?php foreach ($tabs as $cate): ?>
                <li class="nav-item">
                  <a class="nav-link <?= ($c === 'category' && (string)($_GET['id'] ?? '') === (string)$cate->id) ? 'active' : '' ?>"
                    href="<?= BASE_URL ?>category/<?= $cate->id ?>">
                    <?= htmlspecialchars($cate->name) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- RIGHT: dropdown "Xem thêm" (NOT inside scroll, so it opens downward normally) -->
          <?php if (!empty($more)): ?>
            <div class="dropdown flex-shrink-0">
              <button class="nav-link dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="font-weight:800; border-radius:999px; padding:10px 12px;">
                Xem thêm
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php foreach ($more as $cate): ?>
                  <li>
                    <a class="dropdown-item"
                      href="<?= BASE_URL ?>category/<?= $cate->id ?>">
                      <?= htmlspecialchars($cate->name) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </nav>
  </header>

  <script>
    (function() {
      const header = document.querySelector('.header');
      if (!header) return;

      function onScroll() {
        if (window.scrollY > 6) header.classList.add('is-scrolled');
        else header.classList.remove('is-scrolled');
      }

      onScroll();
      window.addEventListener('scroll', onScroll, {
        passive: true
      });
    })();
  </script>

  <main>
    <div class="container page-wrap">
      <div class="content">