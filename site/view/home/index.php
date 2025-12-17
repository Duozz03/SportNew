<?php
// chuẩn hóa mảng để dễ dùng
$articlesArr = is_array($articles) ? $articles : iterator_to_array($articles);
$hero = $articlesArr[0] ?? null;
$side = array_slice($articlesArr, 1, 5);
$list = array_slice($articlesArr, 1); // phần dưới
?>

<style>
  .home-title{
    font-size: 22px;
    font-weight: 800;
    margin: 6px 0 18px;
    letter-spacing: .01em;
  }

  .news-shell{
    background: transparent;
  }

  /* HERO */
  .hero-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 22px rgba(15,23,42,.06);
  }
  .hero-img{
    width:100%;
    height: 320px;
    object-fit: cover;
    display:block;
    background:#f3f4f6;
  }
  .hero-body{ padding: 16px 16px 18px; }
  .hero-title{
    font-size: 22px;
    line-height: 1.25;
    font-weight: 850;
    margin: 0 0 10px;
  }
  .hero-title a{ color:#111827; text-decoration:none; }
  .hero-title a:hover{ color:#b91c1c; text-decoration: underline; }
  .meta{
    color:#6b7280;
    font-size: 13px;
    display:flex;
    gap:10px;
    align-items:center;
    margin-bottom: 10px;
  }
  .hero-desc{
    color:#4b5563;
    font-size: 14px;
    margin:0;
  }

  /* SIDEBAR "TIN MỚI" */
  .side-box{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
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
  .side-head a{ font-size: 13px; text-decoration:none; color:#2563eb; }
  .side-head a:hover{ text-decoration: underline; }

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

  /* CATEGORY CHIPS */
  .chip-row{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top: 18px;
  }
  .chip{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 999px;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 650;
    text-decoration:none;
    color:#0f172a;
  }
  .chip:hover{
    border-color:#b91c1c;
    color:#b91c1c;
  }

  /* GRID LIST */
  .block-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin: 24px 0 10px;
  }
  .block-head h2{
    font-size: 16px;
    font-weight: 850;
    margin:0;
    letter-spacing:.02em;
    text-transform: uppercase;
  }
  .block-head a{ font-size: 13px; text-decoration:none; color:#2563eb; }
  .block-head a:hover{ text-decoration: underline; }

  .news-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 14px;
    overflow:hidden;
    height:100%;
    transition: transform .12s ease, box-shadow .12s ease;
  }
  .news-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(15,23,42,.08);
  }
  .news-img{
    width:100%;
    height: 170px;
    object-fit: cover;
    display:block;
    background:#f3f4f6;
  }
  .news-body{ padding: 12px 14px 14px; }
  .news-title{
    font-size: 16px;
    font-weight: 800;
    line-height: 1.28;
    margin: 0 0 8px;
  }
  .news-title a{ color:#111827; text-decoration:none; }
  .news-title a:hover{ color:#b91c1c; text-decoration: underline; }
  .news-desc{
    color:#4b5563;
    font-size: 13px;
    margin: 8px 0 0;
  }
</style>

<div class="news-shell">

  <h1 class="home-title">Tin thể thao hôm nay</h1>

  <!-- HERO + SIDEBAR -->
  <section class="row g-3 align-items-stretch">
    <div class="col-lg-8">
      <?php if ($hero): ?>
        <article class="hero-card h-100">
          <?php if (!empty($hero->thumbnail)): ?>
            <img class="hero-img" src="<?= BASE_URL ?>site/upload/<?= htmlspecialchars($hero->thumbnail) ?>" alt="Thumbnail">
          <?php else: ?>
            <img class="hero-img" src="https://via.placeholder.com/1200x600?text=Tin+the+thao" alt="No image">
          <?php endif; ?>

          <div class="hero-body">
            <h2 class="hero-title">
              <a href="<?= BASE_URL ?>article/<?= $hero->id ?>">
                <?= htmlspecialchars($hero->title) ?>
              </a>
            </h2>

            <div class="meta">
              <span><?= date('d/m/Y H:i', strtotime($hero->created_at)) ?></span>
              <span>•</span>
              <span>Tin mới</span>
            </div>

            <?php if (!empty($hero->content)): ?>
              <p class="hero-desc">
                <?= htmlspecialchars(mb_strimwidth(strip_tags($hero->content), 0, 220, '...', 'UTF-8')) ?>
              </p>
            <?php endif; ?>
          </div>
        </article>
      <?php endif; ?>
    </div>

    <div class="col-lg-4">
      <aside class="side-box h-100">
        <div class="side-head">
          <h3>Tin mới</h3>
          <a href="<?= BASE_URL ?>articles">Xem tất cả</a>
        </div>
        <ul class="side-list">
          <?php foreach ($side as $s): ?>
            <li class="side-item">
              <a href="<?= BASE_URL ?>article/<?= $s->id ?>">
                <?= htmlspecialchars($s->title) ?>
              </a>
              <div class="side-time"><?= date('d/m/Y H:i', strtotime($s->created_at)) ?></div>
            </li>
          <?php endforeach; ?>

          <?php if (empty($side)): ?>
            <li class="side-item">
              <div class="text-muted small">Chưa có bài viết.</div>
            </li>
          <?php endif; ?>
        </ul>
      </aside>
    </div>
  </section>

  <!-- CHUYÊN MỤC (chips) -->
  <section class="mt-2">
    <div class="block-head">
      <h2>Chuyên mục</h2>
      <span class="text-muted small">Chọn chuyên mục để lọc tin</span>
    </div>

    <div class="chip-row">
      <?php foreach ($categories as $cate): ?>
        <a class="chip" href="<?= BASE_URL ?>category/<?= $cate->id ?>">
          <?= htmlspecialchars($cate->name) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- DANH SÁCH TIN -->
  <section>
    <div class="block-head">
      <h2>Tin mới nhất</h2>
      <a href="<?= BASE_URL ?>articles">Xem tất cả →</a>
    </div>

    <div class="row g-3">
      <?php foreach ($list as $art): ?>
        <div class="col-12 col-md-6">
          <article class="news-card">
            <?php if (!empty($art->thumbnail)): ?>
              <img class="news-img" src="<?= BASE_URL ?>site/upload/<?= htmlspecialchars($art->thumbnail) ?>" alt="Thumbnail">
            <?php else: ?>
              <img class="news-img" src="https://via.placeholder.com/900x450?text=Tin+the+thao" alt="No image">
            <?php endif; ?>

            <div class="news-body">
              <h3 class="news-title">
                <a href="<?= BASE_URL ?>article/<?= $art->id ?>">
                  <?= htmlspecialchars($art->title) ?>
                </a>
              </h3>

              <div class="meta mb-0">
                <span><?= date('d/m/Y H:i', strtotime($art->created_at)) ?></span>
              </div>

              <?php if (!empty($art->content)): ?>
                <p class="news-desc">
                  <?= htmlspecialchars(mb_strimwidth(strip_tags($art->content), 0, 140, '...', 'UTF-8')) ?>
                </p>
              <?php endif; ?>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

</div>
