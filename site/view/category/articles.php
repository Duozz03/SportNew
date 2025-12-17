<style>
  :root {
    --ink: #0f172a;
    --muted: #64748b;
    --line: #e2e8f0;
    --card: #ffffff;
    --brand: #b91c1c;
  }

  .cat-head {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 14px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
    margin: 6px 0 14px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }

  .cat-title {
    margin: 0;
    font-size: 22px;
    font-weight: 950;
    color: var(--ink);
    letter-spacing: .01em;
  }

  .cat-sub {
    margin-top: 6px;
    color: var(--muted);
    font-size: 13px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }

  .chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 999px;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 850;
    border: 1px solid var(--line);
    background: #f8fafc;
    color: var(--ink);
    white-space: nowrap;
  }

  .chip-cat {
    border-color: rgba(185, 28, 28, .25);
    background: rgba(185, 28, 28, .06);
    color: #991b1b;
  }

  .panel {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    overflow: hidden;
  }

  .news-item {
    padding: 14px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 12px;
    text-decoration: none;
    color: var(--ink);
  }

  .news-item:first-child {
    border-top: 0;
  }

  .news-item:hover {
    background: #fafafa;
  }

  .thumb {
    width: 132px;
    height: 84px;
    border-radius: 12px;
    object-fit: cover;
    background: #f3f4f6;
    border: 1px solid #eef2f7;
    flex: 0 0 auto;
  }

  .ni-title {
    font-size: 16px;
    font-weight: 950;
    line-height: 1.25;
    margin: 0 0 6px;
    color: var(--ink);
  }

  .news-item:hover .ni-title {
    color: var(--brand);
    text-decoration: underline;
  }

  .ni-meta {
    color: var(--muted);
    font-size: 12.5px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }

  .dot {
    width: 4px;
    height: 4px;
    border-radius: 999px;
    background: #cbd5e1;
    display: inline-block;
  }

  .ni-desc {
    margin: 8px 0 0;
    color: #475569;
    font-size: 13px;
  }

  .empty-box {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 18px;
  }

  /* ===== PAGINATION FIX + BEAUTIFY ===== */
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin: 0;
    padding-left: 0;
    list-style: none;
  }

  /* Không dựa vào gap để tránh browser/Bootstrap override */
  .pagination .page-item {
    margin: 0 4px;
  }

  .pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    /* mọi nút đều đều */
    height: 38px;
    /* chiều cao cố định */
    padding: 0 14px;
    border-radius: 999px;
    border: 1px solid var(--line);
    background: #fff;
    color: var(--ink);
    font-weight: 850;
    line-height: 1;
    text-decoration: none;
  }

  .pagination .page-link:hover {
    background: #f1f5f9;
  }

  .pagination .page-item.active .page-link {
    background: var(--ink) !important;
    border-color: var(--ink) !important;
    color: #fff !important;
  }

  .pagination .page-item.disabled .page-link {
    opacity: .5;
    pointer-events: none;
  }
</style>

<div class="cat-head">
  <div>
    <h2 class="cat-title">Chuyên mục: <?= htmlspecialchars($category->name ?? '') ?></h2>
    <div class="cat-sub">
      <span class="chip chip-cat"><?= htmlspecialchars($category->name ?? '') ?></span>
      <?php if (!empty($articles)): ?>
        <span class="dot"></span>
        <span class="text-muted">Trang <?= (int)($page ?? 1) ?> / <?= (int)($totalPages ?? 1) ?></span>
      <?php endif; ?>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap">
    <a class="btn btn-outline-dark" href="<?= BASE_URL ?>articles">Tất cả bài viết</a>
    <a class="btn btn-dark" href="<?= BASE_URL ?>">Trang chủ</a>
  </div>
</div>

<?php if (empty($articles)): ?>
  <div class="empty-box">
    <div class="fw-semibold" style="color:#0f172a;">Chưa có bài viết nào trong chuyên mục này.</div>
    <div class="text-muted mt-1">Bạn có thể quay lại trang chủ hoặc xem tất cả bài viết.</div>
  </div>
<?php else: ?>

  <div class="panel">
    <?php foreach ($articles as $art): ?>
      <?php
      $thumb = '';
      if (is_object($art) && property_exists($art, 'thumbnail') && !empty($art->thumbnail)) {
        $thumb = BASE_URL . 'site/upload/' . htmlspecialchars($art->thumbnail);
      }
      $desc = '';
      if (is_object($art) && property_exists($art, 'short_description') && !empty($art->short_description)) {
        $desc = $art->short_description;
      } elseif (is_object($art) && property_exists($art, 'content') && !empty($art->content)) {
        $desc = $art->content;
      }
      ?>

      <a class="news-item" href="<?= BASE_URL ?>article/<?= (int)$art->id ?>">
        <?php if (!empty($thumb)): ?>
          <img class="thumb" src="<?= $thumb ?>" alt="Thumbnail">
        <?php else: ?>
          <img class="thumb" src="https://via.placeholder.com/600x360?text=Tin+the+thao" alt="No image">
        <?php endif; ?>

        <div class="flex-grow-1">
          <div class="ni-title"><?= htmlspecialchars($art->title ?? '') ?></div>

          <div class="ni-meta">
            <span><?= htmlspecialchars($art->created_at ?? '') ?></span>
          </div>

          <?php if (!empty($desc)): ?>
            <div class="ni-desc">
              <?= htmlspecialchars(mb_strimwidth(strip_tags($desc), 0, 140, '...', 'UTF-8')) ?>
            </div>
          <?php endif; ?>
        </div>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- PHÂN TRANG -->
  <?php if (!empty($totalPages) && $totalPages > 1): ?>
    <nav class="mt-3">
      <ul class="pagination justify-content-center mb-0 flex-wrap">
        <?php if (($page ?? 1) > 1): ?>
          <li class="page-item">
            <a class="page-link" href="<?= BASE_URL ?>category/<?= (int)$category->id ?>?page=<?= (int)$page - 1 ?>">&laquo;</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>">
            <a class="page-link" href="<?= BASE_URL ?>category/<?= (int)$category->id ?>?page=<?= (int)$i ?>">
              <?= (int)$i ?>
            </a>
          </li>
        <?php endfor; ?>

        <?php if (($page ?? 1) < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="<?= BASE_URL ?>category/<?= (int)$category->id ?>?page=<?= (int)$page + 1 ?>">&raquo;</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>

<?php endif; ?>