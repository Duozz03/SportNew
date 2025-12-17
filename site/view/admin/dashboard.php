<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --bg:#f6f7fb;
    --card:#ffffff;
    --brand:#b91c1c; /* đỏ tin tức */
  }

  /* Page */
  .admin-wrap{ padding: 6px 0 22px; }
  .admin-title{
    font-size: 28px;
    font-weight: 900;
    letter-spacing: .01em;
    color: var(--ink);
    margin: 6px 0 6px;
  }
  .admin-sub{
    color: var(--muted);
    font-size: 13px;
    margin-bottom: 14px;
  }

  /* Section card */
  .panel{
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 16px;
    overflow: hidden;
  }
  .panel-head{
    padding: 12px 14px;
    border-bottom: 1px solid var(--line);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    background: #fff;
  }
  .panel-head h3{
    margin:0;
    font-size: 14px;
    font-weight: 900;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--ink);
  }

  /* Stat cards */
  .stat{
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 14px;
    box-shadow: 0 10px 28px rgba(15,23,42,.05);
    height: 100%;
  }
  .stat-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap: 12px;
  }
  .stat-label{
    color: var(--muted);
    font-size: 13px;
    font-weight: 700;
  }
  .stat-value{
    font-size: 34px;
    line-height: 1;
    font-weight: 950;
    color: var(--ink);
    margin-top: 8px;
  }
  .stat-pill{
    font-size: 12px;
    font-weight: 800;
    border-radius: 999px;
    padding: 6px 10px;
    border: 1px solid var(--line);
    color: var(--ink);
    background: #f8fafc;
    white-space: nowrap;
  }
  .pill-red{ border-color: rgba(185,28,28,.25); background: rgba(185,28,28,.06); color: #991b1b; }
  .pill-blue{ border-color: rgba(37,99,235,.25); background: rgba(37,99,235,.06); color: #1d4ed8; }
  .pill-amber{ border-color: rgba(245,158,11,.25); background: rgba(245,158,11,.10); color: #92400e; }

  /* Lists look like newsroom */
  .news-list{ margin: 0; padding: 0; list-style: none; }
  .news-item{
    padding: 12px 14px;
    border-top: 1px solid #f1f5f9;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap: 14px;
  }
  .news-item:first-child{ border-top: 0; }
  .news-title{
    font-weight: 850;
    color: var(--ink);
    margin: 0 0 4px;
    line-height: 1.3;
  }
  .news-meta{
    color: var(--muted);
    font-size: 12.5px;
    display:flex;
    flex-wrap:wrap;
    gap: 8px;
    align-items:center;
  }
  .badge-soft{
    font-size: 11px;
    font-weight: 850;
    border-radius: 999px;
    padding: 4px 8px;
    border: 1px solid var(--line);
    background: #f8fafc;
    color: var(--ink);
  }
  .dot{ width:4px; height:4px; border-radius:999px; background:#cbd5e1; display:inline-block; }

  /* Right aligned score */
  .score{
    min-width: 86px;
    text-align: right;
  }
  .score strong{
    font-size: 16px;
    font-weight: 950;
    color: var(--ink);
  }
  .score small{
    display:block;
    color: var(--muted);
    font-size: 12px;
    margin-top: 2px;
  }

  /* Quick actions */
  .actions{
    display:flex;
    flex-wrap: wrap;
    gap: 8px;
  }
  .btn-news{
    border-radius: 999px;
    font-weight: 750;
    font-size: 13px;
    padding: 8px 12px;
  }

  @media (max-width: 768px){
    .admin-title{ font-size: 22px; }
    .stat-value{ font-size: 28px; }
    .score{ min-width: 70px; }
  }
</style>

<div class="admin-wrap">

  <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
    <div>
      <div class="admin-title">Dashboard Admin</div>
      <div class="admin-sub">Tổng quan hoạt động nội dung và tương tác trên website tin tức.</div>
    </div>

    <div class="actions">
      <a href="<?= BASE_URL ?>site/index.php?c=article&a=manage" class="btn btn-dark btn-news">Quản lý bài viết</a>
      <a href="<?= BASE_URL ?>site/index.php?c=category&a=index" class="btn btn-outline-dark btn-news">Chuyên mục</a>
      <a href="<?= BASE_URL ?>site/index.php?c=article&a=create" class="btn btn-outline-danger btn-news" style="border-color: var(--brand); color: var(--brand);">+ Thêm bài</a>
    </div>
  </div>

  <!-- Stats -->
  <div class="row g-3 mt-1">
    <div class="col-12 col-md-4">
      <div class="stat">
        <div class="stat-row">
          <div>
            <div class="stat-label">Tổng số bài viết</div>
            <div class="stat-value"><?= (int)$totalArticles ?></div>
          </div>
          <div class="stat-pill pill-blue">Nội dung</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="stat">
        <div class="stat-row">
          <div>
            <div class="stat-label">Tổng số chuyên mục</div>
            <div class="stat-value"><?= (int)$totalCategories ?></div>
          </div>
          <div class="stat-pill pill-red">Phân loại</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="stat">
        <div class="stat-row">
          <div>
            <div class="stat-label">Tổng số bình luận</div>
            <div class="stat-value"><?= (int)$totalComments ?></div>
          </div>
          <div class="stat-pill pill-amber">Tương tác</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Panels -->
  <div class="row g-3 mt-1">
    <!-- Latest -->
    <div class="col-12 col-lg-7">
      <div class="panel">
        <div class="panel-head">
          <h3>Bài viết mới nhất</h3>
          <a class="small text-decoration-none" href="<?= BASE_URL ?>site/index.php?c=article&a=manage">Xem quản lý</a>
        </div>

        <?php if (empty($latestArticles)): ?>
          <div class="p-3 text-muted">Chưa có bài viết nào.</div>
        <?php else: ?>
          <ul class="news-list">
            <?php foreach ($latestArticles as $a): ?>
              <li class="news-item">
                <div class="flex-grow-1">
                  <div class="news-title"><?= htmlspecialchars($a['title']) ?></div>
                  <div class="news-meta">
                    <span class="badge-soft"><?= htmlspecialchars($a['category_name'] ?? 'Không rõ') ?></span>
                    <span class="dot"></span>
                    <span><?= htmlspecialchars($a['created_at']) ?></span>
                  </div>
                </div>

                <div class="score">
                  <strong>NEW</strong>
                  <small>Đăng gần đây</small>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

    <!-- Top rated -->
    <div class="col-12 col-lg-5">
      <div class="panel">
        <div class="panel-head">
          <h3>Đánh giá cao</h3>
          <span class="small text-muted">Top rating</span>
        </div>

        <?php if (empty($topRatedArticles)): ?>
          <div class="p-3 text-muted">Chưa có dữ liệu đánh giá.</div>
        <?php else: ?>
          <ul class="news-list">
            <?php foreach ($topRatedArticles as $a): ?>
              <li class="news-item">
                <div class="flex-grow-1">
                  <div class="news-title"><?= htmlspecialchars($a['title']) ?></div>
                  <div class="news-meta">
                    <span class="badge-soft">★ <?= round((float)$a['avg_rating'], 1) ?>/5</span>
                    <span class="dot"></span>
                    <span><?= (int)$a['total_ratings'] ?> lượt</span>
                  </div>
                </div>

                <div class="score">
                  <strong><?= round((float)$a['avg_rating'], 1) ?></strong>
                  <small>/ 5.0</small>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>
