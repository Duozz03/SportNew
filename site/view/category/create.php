<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --card:#ffffff;
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
    box-shadow: 0 10px 28px rgba(15,23,42,.05);
    max-width: 720px;
  }
  .panel-head{
    padding: 12px 14px;
    border-bottom: 1px solid var(--line);
    font-weight: 850;
    color: var(--ink);
  }
  .panel-body{
    padding: 16px;
  }

  .label{
    font-weight: 850;
    font-size: 13px;
    color: var(--ink);
    margin-bottom: 6px;
  }
  .help{
    font-size: 12.5px;
    color: var(--muted);
    margin-top: 6px;
  }
</style>

<div class="page-head">
  <div>
    <h2>Thêm chuyên mục</h2>
    <div class="page-sub">Tạo chuyên mục để phân loại bài viết trên website.</div>
  </div>

  <div class="d-flex gap-2">
    <a href="index.php?c=category&a=index" class="btn btn-outline-dark btn-pill">
      ← Quản lý chuyên mục
    </a>
  </div>
</div>

<form action="index.php?c=category&a=store" method="post" class="panel">
  <div class="panel-head">
    Thông tin chuyên mục
  </div>

  <div class="panel-body">
    <div class="mb-3">
      <div class="label">Tên chuyên mục <span class="text-danger">*</span></div>
      <input type="text"
             name="name"
             id="name"
             class="form-control form-control-lg"
             required
             placeholder="Ví dụ: Bóng đá nam, Esports, Tennis...">
      <div class="help">Tên hiển thị trên menu và trang bài viết.</div>
    </div>

    <div class="mb-3">
      <div class="label">Slug</div>
      <input type="text"
             name="slug"
             id="slug"
             class="form-control"
             placeholder="Tự động tạo từ tên chuyên mục">
      <div class="help">
        Slug dùng cho URL. Nếu để trống, hệ thống sẽ tự tạo.
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
      <div class="text-muted" style="font-size: 13px;">
        Mẹo: Slug nên ngắn, không dấu, dùng dấu gạch ngang (-).
      </div>

      <div class="d-flex gap-2">
        <a href="index.php?c=category&a=index"
           class="btn btn-outline-secondary btn-pill">
          Hủy
        </a>
        <button type="submit"
                class="btn btn-dark btn-pill">
          Lưu chuyên mục
        </button>
      </div>
    </div>
  </div>
</form>

<script>
  // Tự động gợi ý slug từ tên chuyên mục
  const nameInput = document.getElementById('name');
  const slugInput = document.getElementById('slug');

  function generateSlug(text) {
    return text.toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // bỏ dấu
      .replace(/đ/g, 'd')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
  }

  nameInput.addEventListener('input', () => {
    if (slugInput.value.trim() === '') {
      slugInput.value = generateSlug(nameInput.value);
    }
  });
</script>
