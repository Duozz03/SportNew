<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --card:#ffffff;
    --bg:#f6f7fb;
    --brand:#b91c1c;
  }

  .page-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin: 6px 0 14px;
  }
  .page-head h2{
    margin:0;
    font-size: 24px;
    font-weight: 950;
    color: var(--ink);
    letter-spacing: .01em;
  }
  .page-sub{
    margin-top: 4px;
    color: var(--muted);
    font-size: 13px;
  }
  .btn-pill{
    border-radius: 999px;
    font-weight: 800;
    font-size: 13px;
    padding: 9px 12px;
  }

  .panel{
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(15,23,42,.05);
  }
  .panel-head{
    padding: 12px 14px;
    border-bottom: 1px solid var(--line);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
  }
  .panel-head .hint{
    color: var(--muted);
    font-size: 13px;
  }
  .panel-body{ padding: 14px; }

  .label{
    font-weight: 850;
    color: var(--ink);
    font-size: 13px;
    margin-bottom: 6px;
  }
  .help{
    color: var(--muted);
    font-size: 12.5px;
    margin-top: 6px;
  }

  .thumb-preview{
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: 14px;
    border: 1px dashed var(--line);
    background: #f8fafc;
    display:none;
  }

  .sticky-actions{
    position: sticky;
    bottom: 12px;
    margin-top: 14px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(8px);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 10px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
  }
</style>

<div class="page-head">
  <div>
    <h2>Thêm bài viết</h2>
    <div class="page-sub">Tạo bài viết mới theo chuẩn trang tin tức: tiêu đề rõ, sapo ngắn, nội dung đầy đủ.</div>
  </div>

  <div class="d-flex gap-2 flex-wrap">
    <a href="index.php?c=article&a=manage" class="btn btn-outline-dark btn-pill">← Quay lại danh sách</a>
  </div>
</div>

<form action="index.php?c=article&a=store" method="post" enctype="multipart/form-data" class="panel">
  <div class="panel-head">
    <div class="fw-bold" style="color: var(--ink);">Thông tin bài viết</div>
    <div class="hint">Các trường có dấu * là bắt buộc</div>
  </div>

  <div class="panel-body">
    <div class="row g-3">
      <!-- LEFT: meta -->
      <div class="col-12 col-lg-4">
        <div class="mb-3">
          <div class="label">Chuyên mục <span class="text-danger">*</span></div>
          <select name="category_id" class="form-select" required>
            <option value="">-- Chọn chuyên mục --</option>
            <?php foreach ($categories as $cate): ?>
              <option value="<?= (int)$cate->id ?>"><?= htmlspecialchars($cate->name) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="help">Chọn đúng chuyên mục để bài hiển thị đúng menu.</div>
        </div>

        <div class="mb-3">
          <div class="label">Ảnh thumbnail</div>
          <input id="thumbInput" type="file" name="thumbnail_file" accept="image/*" class="form-control">
          <div class="help">Khuyến nghị ảnh ngang (16:9), dung lượng vừa phải.</div>

          <div class="mt-2">
            <img id="thumbPreview" class="thumb-preview" alt="Preview thumbnail">
          </div>
        </div>

        <div class="mb-3">
          <div class="label">Trạng thái hiển thị</div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
            <label class="form-check-label" for="status">Hiển thị bài viết</label>
          </div>
          <div class="help">Bỏ tick nếu muốn lưu nháp/ẩn bài.</div>
        </div>
      </div>

      <!-- RIGHT: content -->
      <div class="col-12 col-lg-8">
        <div class="mb-3">
          <div class="label">Tiêu đề <span class="text-danger">*</span></div>
          <input type="text" name="title" class="form-control form-control-lg" required
                 placeholder="Ví dụ: MU thắng Liverpool 2-1...">
          <div class="help">Tiêu đề ngắn gọn, có thông tin chính, tránh viết hoa toàn bộ.</div>
        </div>

        <div class="mb-3">
          <div class="label">Mô tả ngắn (Sapo)</div>
          <textarea name="short_description" class="form-control" rows="3"
                    placeholder="1–2 câu tóm tắt nội dung, giống sapo báo điện tử..."></textarea>
          <div class="help">Sapo hiển thị đẹp ở trang chi tiết và list bài.</div>
        </div>

        <div class="mb-3">
          <div class="label">Nội dung</div>
          <textarea name="content" class="form-control" rows="12"
                    placeholder="Nội dung bài viết... (có thể xuống dòng, chia đoạn rõ ràng)"></textarea>
          <div class="help">Khuyến nghị chia đoạn, mỗi đoạn 2–4 câu để dễ đọc.</div>
        </div>
      </div>
    </div>

    <!-- ACTIONS -->
    <div class="sticky-actions">
      <div class="text-muted" style="font-size: 13px;">
        Mẹo: Thêm thumbnail + sapo sẽ giúp bài trông giống báo điện tử hơn.
      </div>

      <div class="d-flex gap-2">
        <a href="index.php?c=article&a=manage" class="btn btn-outline-secondary btn-pill">Hủy</a>
        <button type="submit" class="btn btn-dark btn-pill">Lưu bài viết</button>
      </div>
    </div>
  </div>
</form>

<script>
  (function(){
    const input = document.getElementById('thumbInput');
    const preview = document.getElementById('thumbPreview');

    if (!input || !preview) return;

    input.addEventListener('change', function(){
      const file = this.files && this.files[0];
      if (!file) {
        preview.style.display = 'none';
        preview.src = '';
        return;
      }
      const ok = file.type && file.type.startsWith('image/');
      if (!ok) {
        preview.style.display = 'none';
        preview.src = '';
        return;
      }
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    });
  })();
</script>
