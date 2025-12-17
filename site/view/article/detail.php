<style>
  :root{
    --ink:#111827;
    --muted:#6b7280;
    --line:#e5e7eb;
    --brand:#b91c1c;
    --bg:#f3f4f6;
  }

  /* Card + layout */
  .detail-card{
    background:#fff;
    border:1px solid var(--line);
    border-radius: 14px;
    overflow:hidden;
    box-shadow: 0 10px 30px rgba(15,23,42,.06);
  }
  .detail-body{ padding: 20px 20px 22px; }

  /* Title + meta */
  .detail-title{
    font-size: 32px;
    line-height: 1.16;
    font-weight: 900;
    letter-spacing: .01em;
    margin: 0 0 10px;
    color: var(--ink);
  }
  .detail-meta{
    color: var(--muted);
    font-size: 13px;
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    align-items:center;
    margin-bottom: 14px;
  }
  .meta-dot{ width:4px; height:4px; border-radius:999px; background:#d1d5db; display:inline-block; }

  /* Sapo (lead) */
  .detail-sapo{
    font-size: 17px;
    color:#374151;
    font-weight: 700;
    line-height: 1.6;
    margin: 0 0 14px;
    padding-left: 12px;
    border-left: 3px solid var(--brand);
  }

  /* Thumbnail */
  .detail-thumb{
    width:100%;
    max-height: 440px;
    object-fit: cover;
    display:block;
    background: var(--bg);
    border-top:1px solid #f3f4f6;
    border-bottom:1px solid #f3f4f6;
  }

  /**
   * “Newspaper feel”:
   * - giới hạn bề rộng dòng
   * - font serif cho nội dung
   * - khoảng cách đoạn thoáng
   */
  .detail-content{
    max-width: 740px;        /* giống báo: dòng không quá dài */
    margin: 0 auto;          /* canh giữa khối nội dung */
    color: var(--ink);
    font-family: Georgia, "Times New Roman", Times, serif;
    font-size: 18px;
    line-height: 1.85;
  }

  .detail-content p{ margin: 0 0 16px; }

  /* Nếu bài có heading trong content */
  .detail-content h1,.detail-content h2,.detail-content h3{
    font-family: "Times New Roman", Times, serif;
    font-weight: 900;
    line-height: 1.25;
    margin: 18px 0 10px;
  }
  .detail-content h2{ font-size: 22px; }
  .detail-content h3{ font-size: 18px; }

  /* Quote style */
  .detail-content blockquote{
    margin: 16px 0;
    padding: 12px 14px;
    border-left: 3px solid var(--brand);
    background: #fafafa;
    border-radius: 12px;
    color:#374151;
    font-style: italic;
  }

  /* Links */
  .detail-content a{
    color: #2563eb;
    text-decoration: none;
    border-bottom: 1px solid rgba(37,99,235,.25);
  }
  .detail-content a:hover{
    text-decoration: underline;
  }

  /* Images inside content */
  .detail-content img{
    max-width: 100%;
    height: auto;
    border-radius: 14px;
    margin: 8px 0 12px;
    display:block;
  }

  /* Rating */
  .rate-box{
    background:#fafafa;
    border:1px solid var(--line);
    border-radius: 14px;
    padding: 14px;
  }
  .block-title{
    font-size: 13px;
    font-weight: 900;
    letter-spacing: .06em;
    text-transform: uppercase;
    margin:0 0 10px;
    color: var(--ink);
  }
  .stars{ color:#f59e0b; font-size: 14px; letter-spacing: 1px; }

  /* Comment form */
  .form-card{
    background:#fff;
    border:1px solid var(--line);
    border-radius: 14px;
    padding: 14px;
  }

  /* Comment item */
  .cmt{
    border:1px solid var(--line);
    border-radius: 14px;
    padding: 12px;
    background:#fff;
  }
  .cmt-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom: 6px;
  }
  .cmt-name{ font-weight: 900; }
  .cmt-time{ color: var(--muted); font-size: 12px; }
  .cmt-content{
    margin:0;
    color: var(--ink);
    font-size: 14px;
    line-height: 1.65;
    font-family: "Times New Roman", Times, serif;
  }

  @media (max-width: 992px){
    .detail-title{ font-size: 24px; }
    .detail-content{ font-size: 16px; max-width: 100%; }
  }
</style>

<div class="row g-3">
  <div class="col-12 col-lg-9 mx-auto">
    <!-- Nội dung bài viết -->
    <article class="detail-card">
      <div class="detail-body">
        <h1 class="detail-title"><?= htmlspecialchars($article->title ?? '') ?></h1>

        <div class="detail-meta">
          <span><?= !empty($article->created_at) ? htmlspecialchars($article->created_at) : '' ?></span>
          <span class="meta-dot"></span>
          <span>Tin thể thao</span>
        </div>

        <?php if (!empty($article->short_description)): ?>
          <div class="detail-sapo">
            <?= htmlspecialchars($article->short_description) ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($article->thumbnail)): ?>
        <img class="detail-thumb"
             src="<?= BASE_URL ?>site/upload/<?= htmlspecialchars($article->thumbnail) ?>"
             alt="Thumbnail">
      <?php endif; ?>

      <div class="detail-body">
        <div class="detail-content" style="white-space: pre-line;">
          <?= nl2br($article->content ?? '') ?>
        </div>
      </div>
    </article>

    <!-- ĐÁNH GIÁ -->
    <div class="mt-3 rate-box">
      <div class="block-title">Đánh giá bài viết</div>

      <?php if (!empty($totalRatings) && $totalRatings > 0): ?>
        <div>
          Điểm trung bình: <strong><?= htmlspecialchars($avgRating) ?>/5</strong>
          <span class="text-muted"> (<?= (int)$totalRatings ?> lượt)</span>
        </div>
        <?php
          $rounded = (int) round((float)$avgRating);
          $rounded = max(0, min(5, $rounded));
        ?>
        <div class="stars mt-1">
          <?= str_repeat('★', $rounded) ?><?= str_repeat('☆', 5 - $rounded) ?>
        </div>
      <?php else: ?>
        <div class="text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên!</div>
      <?php endif; ?>
    </div>

    <!-- THÔNG BÁO -->
    <?php if (!empty($_SESSION['comment_error'])): ?>
      <div class="alert alert-danger mt-3 mb-0">
        <?= htmlspecialchars($_SESSION['comment_error']) ?>
      </div>
      <?php unset($_SESSION['comment_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['comment_success'])): ?>
      <div class="alert alert-success mt-3 mb-0">
        <?= htmlspecialchars($_SESSION['comment_success']) ?>
      </div>
      <?php unset($_SESSION['comment_success']); ?>
    <?php endif; ?>

    <!-- FORM BÌNH LUẬN VÀ ĐÁNH GIÁ -->
    <div class="mt-3 form-card">
      <div class="block-title mb-2">Gửi bình luận</div>

      <form action="<?= BASE_URL ?>site/index.php?c=comment&a=store" method="post">
        <input type="hidden" name="article_id" value="<?= (int)($article->id ?? 0) ?>">

        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Tên của bạn</label>
            <input type="text" name="author_name" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Số sao</label>
            <select name="rating" class="form-select" required>
              <option value="">-- Chọn --</option>
              <option value="5">5 sao - Tuyệt vời</option>
              <option value="4">4 sao - Rất tốt</option>
              <option value="3">3 sao - Bình thường</option>
              <option value="2">2 sao - Chưa hay</option>
              <option value="1">1 sao - Tệ</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Nội dung bình luận</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
          </div>

          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-dark">Gửi bình luận</button>
          </div>
        </div>
      </form>
    </div>

    <!-- DANH SÁCH BÌNH LUẬN -->
    <div class="mt-3">
      <div class="block-title mb-2">Bình luận</div>

      <?php if (empty($comments)): ?>
        <div class="text-muted">Chưa có bình luận nào.</div>
      <?php else: ?>
        <div class="d-flex flex-column gap-2">
          <?php foreach ($comments as $cmt): ?>
            <?php
              $r = (int)($cmt->rating ?? 0);
              $r = max(0, min(5, $r));
            ?>
            <div class="cmt">
              <div class="cmt-head">
                <div>
                  <span class="cmt-name"><?= htmlspecialchars($cmt->author_name ?? '') ?></span>
                  <span class="stars ms-2"><?= str_repeat('★', $r) ?><?= str_repeat('☆', 5 - $r) ?></span>
                </div>
                <div class="cmt-time"><?= htmlspecialchars($cmt->created_at ?? '') ?></div>
              </div>
              <p class="cmt-content"><?= nl2br(htmlspecialchars($cmt->content ?? '')) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>
