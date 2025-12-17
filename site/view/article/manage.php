<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --card:#ffffff;
    --bg:#f6f7fb;
    --brand:#b91c1c;
  }

  .admin-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    margin:6px 0 14px;
  }
  .admin-head h2{
    margin:0;
    font-size:24px;
    font-weight:950;
    color:var(--ink);
  }
  .admin-sub{
    margin-top:4px;
    color:var(--muted);
    font-size:13px;
  }

  .btn-pill{
    border-radius:999px;
    font-weight:800;
    font-size:13px;
    padding:9px 14px;
  }

  .panel{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 28px rgba(15,23,42,.05);
  }

  .table-wrap{ overflow:auto; }

  table.table{
    margin:0;
    border-color:var(--line)!important;
  }

  .table thead th{
    background:#0b1220!important;
    color:#fff!important;
    font-weight:850;
    white-space:nowrap;
  }

  .table tbody td{
    vertical-align:middle;
    border-color:var(--line)!important;
  }

  .table tbody tr:hover{
    background:#fafafa;
  }

  .col-title{
    font-weight:850;
    color:var(--ink);
    line-height:1.25;
  }

  .meta{
    color:var(--muted);
    font-size:12.5px;
    margin-top:3px;
  }

  .badge-soft{
    display:inline-flex;
    align-items:center;
    gap:6px;
    border-radius:999px;
    padding:6px 10px;
    font-size:12px;
    font-weight:850;
    border:1px solid var(--line);
    background:#f8fafc;
  }

  .badge-on{
    background:rgba(16,185,129,.08);
    border-color:rgba(16,185,129,.3);
    color:#065f46;
  }

  .badge-off{
    background:rgba(239,68,68,.08);
    border-color:rgba(239,68,68,.3);
    color:#991b1b;
  }

  .actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
  }

  .btn-mini{
    border-radius:10px;
    font-weight:800;
    font-size:12px;
    padding:7px 12px;
  }

  /* ===== PAGINATION FIX ===== */
  .pagination{
    gap:8px;
    margin-top:16px;
  }

  .pagination .page-link{
    border:1px solid var(--line);
    color:var(--ink);
    padding:8px 14px;
    border-radius:999px;
    font-weight:850;
    background:#fff;
    line-height:1;
  }

  .pagination .page-item.active .page-link{
    background:var(--ink);
    border-color:var(--ink);
    color:#fff !important;
  }

  .pagination .page-link:hover{
    background:#f1f5f9;
  }
</style>

<div class="admin-head">
  <div>
    <h2>Quản lý bài viết</h2>
    <div class="admin-sub">Quản trị nội dung, trạng thái hiển thị và thao tác nhanh.</div>
  </div>

  <div class="d-flex gap-2 flex-wrap">
    <a href="index.php?c=article&a=create" class="btn btn-dark btn-pill">+ Thêm bài viết</a>
    <a href="index.php?c=admin&a=dashboard" class="btn btn-outline-dark btn-pill">← Dashboard</a>
  </div>
</div>

<div class="panel">
  <div class="table-wrap">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th width="80">ID</th>
          <th>Tiêu đề</th>
          <th width="180">Chuyên mục</th>
          <th width="130">Hiển thị</th>
          <th width="190">Ngày tạo</th>
          <th width="170">Hành động</th>
        </tr>
      </thead>

      <tbody>
        <?php if (empty($articles)): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">Chưa có bài viết nào.</td>
          </tr>
        <?php else: foreach ($articles as $art):
          $cateName = $categoryMap[$art->category_id] ?? 'Không rõ';
          $isOn = (int)($art->status ?? 0) === 1;
        ?>
          <tr>
            <td><?= (int)$art->id ?></td>
            <td>
              <div class="col-title"><?= htmlspecialchars($art->title) ?></div>
              <?php if (!empty($art->short_description)): ?>
                <div class="meta">
                  <?= htmlspecialchars(mb_strimwidth(strip_tags($art->short_description),0,90,'...','UTF-8')) ?>
                </div>
              <?php endif; ?>
            </td>
            <td><span class="badge-soft"><?= htmlspecialchars($cateName) ?></span></td>
            <td>
              <span class="badge-soft <?= $isOn?'badge-on':'badge-off' ?>">
                <?= $isOn?'● Đang hiển thị':'● Đang ẩn' ?>
              </span>
            </td>
            <td class="text-muted"><?= $art->created_at ?></td>
            <td>
              <div class="actions">
                <a href="index.php?c=article&a=edit&id=<?= $art->id ?>" class="btn btn-warning btn-mini">Sửa</a>
                <a onclick="return confirm('Xóa bài này?')" 
                   href="index.php?c=article&a=delete&id=<?= $art->id ?>" 
                   class="btn btn-danger btn-mini">Xóa</a>
              </div>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (!empty($totalPages) && $totalPages > 1): ?>
<nav>
  <ul class="pagination justify-content-center flex-wrap">
    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?c=article&a=manage&page=<?= $page-1 ?>">&laquo;</a>
      </li>
    <?php endif; ?>

    <?php for ($i=1;$i<=$totalPages;$i++): ?>
      <li class="page-item <?= $i==$page?'active':'' ?>">
        <a class="page-link" href="?c=article&a=manage&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <li class="page-item">
        <a class="page-link" href="?c=article&a=manage&page=<?= $page+1 ?>">&raquo;</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>
<?php endif; ?>
