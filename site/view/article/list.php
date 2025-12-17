<?php
$articlesArr = is_array($articles) ? $articles : iterator_to_array($articles);
$sidebarLatest = array_slice($articlesArr, 0, 6);
?>

<style>
  .page-title{
    font-size: 20px;
    font-weight: 850;
    margin: 6px 0 16px;
    letter-spacing: .01em;
  }

  .panel{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 14px;
    overflow:hidden;
  }

  /* LIST ITEM */
  .news-item{
    padding: 14px 14px;
    border-top:1px solid #f3f4f6;
    display:flex;
    gap: 12px;
    text-decoration:none;
    color:#111827;
  }
  .news-item:first-child{ border-top:0; }
  .news-item:hover{ background:#fafafa; }

  .thumb{
    width: 132px;
    height: 84px;
    border-radius: 10px;
    object-fit: cover;
    background:#f3f4f6;
    flex: 0 0 auto;
    border: 1px solid #eef2f7;
  }

  .ni-title{
    font-size: 16px;
    font-weight: 850;
    line-height: 1.25;
    margin: 0 0 6px;
  }
  .news-item:hover .ni-title{ color:#b91c1c; text-decoration: underline; }

  .ni-meta{
    color:#6b7280;
    font-size: 12.5px;
    display:flex;
    flex-wrap:wrap;
    gap: 8px;
    align-items:center;
  }
  .badge-soft{
    background:#f3f4f6;
    border:1px solid #e5e7eb;
    color:#0f172a;
    font-weight:700;
    font-size: 11px;
    border-radius: 999px;
    padding: 3px 8px;
  }
  .ni-desc{
    color:#4b5563;
    font-size: 13px;
    margin: 8px 0 0;
  }

  /* SIDEBAR */
  .side-box{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 14px;
    overflow:hidden;
  }
  .side-head{
    padding: 12px 14px;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .side-head h3{
    font-size: 14px;
    font-weight: 850;
    margin:0;
    letter-spacing:.02em;
    text-transform: uppercase;
  }
  .side-list{ list-style:none; margin:0; padding: 6px 0; }
  .side-item{
    padding: 10px 14px;
    border-top:1px solid #f3f4f6;
  }
  .side-item:first-child{ border-top:0; }
  .side-item a{
    color:#111827;
    text-decoration:none;
    font-weight: 650;
    font-size: 14px;
    line-height: 1.3;
    display:block;
  }
  .side-item a:hover{ color:#b91c1c; text-decoration: underline; }
  .side-time{ color:#6b7280; font-size: 12px; margin-top: 4px; }

  /* Pagination */
  .pagination .page-link{
    border:1px solid #e5e7eb;
    color:#111827;
  }
  .pagination .page-item.active .page-link{
    background:#111827;
    border-color:#111827;
  }

  @media (max-width: 576px){
    .thumb{ width: 110px; height: 74px; }
  }
</style>

<h1 class="page-title">Tất cả bài viết</h1>

<?php if (empty($articlesArr)): ?>
  <div class="text-muted">Chưa có bài viết nào.</div>
<?php else: ?>

  <div class="row g-3">
    <!-- LEFT: LIST -->
    <div class="col-lg-8">
      <div class="panel">
        <?php foreach ($articlesArr as $article): ?>
          <?php
            $categoryLabel = '';
            if (is_object($article) && property_exists($article, 'category_name') && !empty($article->category_name)) {
              $categoryLabel = $article->category_name;
            }

            $thumb = '';
            if (is_object($article) && property_exists($article, 'thumbnail') && !empty($article->thumbnail)) {
              $thumb = BASE_URL . 'site/upload/' . rawurlencode($article->thumbnail);
            }

            $created = $article->created_at ?? '';
            $content = $article->content ?? '';
          ?>

          <a class="news-item" href="<?= BASE_URL ?>article/<?= $article->id ?>">
            <?php if (!empty($thumb)): ?>
              <img class="thumb" src="<?= $thumb ?>" alt="Thumbnail">
            <?php else: ?>
              <img class="thumb" src="https://via.placeholder.com/600x360?text=Tin+the+thao" alt="No image">
            <?php endif; ?>

            <div class="flex-grow-1">
              <h2 class="ni-title"><?= htmlspecialchars($article->title ?? '') ?></h2>

              <div class="ni-meta">
                <?php if (!empty($categoryLabel)): ?>
                  <span class="badge-soft"><?= htmlspecialchars($categoryLabel) ?></span>
                <?php endif; ?>
                <?php if (!empty($created)): ?>
                  <span><?= htmlspecialchars($created) ?></span>
                <?php endif; ?>
              </div>

              <?php if (!empty($content)): ?>
                <p class="ni-desc">
                  <?= htmlspecialchars(mb_strimwidth(strip_tags($content), 0, 140, '...', 'UTF-8')) ?>
                </p>
              <?php endif; ?>
            </div>
          </a>

        <?php endforeach; ?>
      </div>

      <?php if (!empty($totalPages) && $totalPages > 1): ?>
        <nav class="mt-3">
          <ul class="pagination mb-0 flex-wrap">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>articles?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>

    <!-- RIGHT: SIDEBAR -->
    <div class="col-lg-4">
      <aside class="side-box">
        <div class="side-head">
          <h3>Tin mới</h3>
          <span class="text-muted small">Cập nhật</span>
        </div>

        <ul class="side-list">
          <?php foreach ($sidebarLatest as $s): ?>
            <li class="side-item">
              <a href="<?= BASE_URL ?>article/<?= $s->id ?>">
                <?= htmlspecialchars($s->title ?? '') ?>
              </a>
              <div class="side-time">
                <?= !empty($s->created_at) ? htmlspecialchars($s->created_at) : '' ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </aside>

      <div class="mt-3 side-box">
        <div class="side-head">
          <h3>Gợi ý</h3>
          <span class="text-muted small">Theo dõi</span>
        </div>
        <div class="p-3">
          <div class="text-muted small">
            Bạn có thể thêm box “Bài nổi bật”, “Tin theo chuyên mục”, hoặc “Top view” khi có dữ liệu.
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>
