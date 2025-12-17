<style>
    :root {
        --ink: #0f172a;
        --muted: #64748b;
        --line: #e2e8f0;
        --card: #ffffff;
    }

    .page-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin: 6px 0 14px;
    }

    .page-head h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 950;
        color: var(--ink);
    }

    .page-sub {
        margin-top: 4px;
        color: var(--muted);
        font-size: 13px;
    }

    .btn-pill {
        border-radius: 999px;
        font-weight: 800;
        font-size: 13px;
        padding: 9px 12px;
    }

    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
        max-width: 720px;
    }

    .panel-head {
        padding: 12px 14px;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .panel-head .title {
        font-weight: 850;
        color: var(--ink);
    }

    .panel-head .hint {
        color: var(--muted);
        font-size: 13px;
    }

    .panel-body {
        padding: 16px;
    }

    .label {
        font-weight: 850;
        font-size: 13px;
        color: var(--ink);
        margin-bottom: 6px;
    }

    .help {
        font-size: 12.5px;
        color: var(--muted);
        margin-top: 6px;
    }
</style>

<div class="page-head">
    <div>
        <h1 class="mb-0">Sửa chuyên mục</h1>
        <div class="page-sub">Cập nhật tên và slug cho chuyên mục. ID: <strong>#<?= (int)$category->id ?></strong></div>
    </div>

    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>site/index.php?c=category&a=index" class="btn btn-outline-dark btn-pill">
            ← Quản lý chuyên mục
        </a>
    </div>
</div>

<form action="<?= BASE_URL ?>site/index.php?c=category&a=update" method="post" class="panel">
    <div class="panel-head">
        <div class="title">Thông tin chuyên mục</div>
        <div class="hint">Chỉnh sửa và lưu thay đổi</div>
    </div>

    <div class="panel-body">
        <input type="hidden" name="id" value="<?= (int)$category->id ?>">

        <div class="mb-3">
            <div class="label">Tên chuyên mục <span class="text-danger">*</span></div>
            <input type="text"
                name="name"
                id="name"
                class="form-control form-control-lg"
                value="<?= htmlspecialchars($category->name ?? '') ?>"
                required>
            <div class="help">Tên hiển thị ở menu và trang bài viết theo chuyên mục.</div>
        </div>

        <div class="mb-3">
            <div class="label">Slug</div>
            <input type="text"
                name="slug"
                id="slug"
                class="form-control"
                value="<?= htmlspecialchars($category->slug ?? '') ?>"
                placeholder="Để trống nếu muốn hệ thống tự tạo">
            <div class="help">Slug dùng cho URL. Nên không dấu, ngắn gọn, dùng dấu gạch ngang (-).</div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted" style="font-size: 13px;">
                Mẹo: Nếu bạn đổi tên, có thể để trống slug để hệ thống tự tạo slug mới.
            </div>

            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>site/index.php?c=category&a=index"
                    class="btn btn-outline-secondary btn-pill">
                    Hủy
                </a>
                <button type="submit"
                    class="btn btn-dark btn-pill">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    // Gợi ý slug từ tên nếu người dùng xóa slug (để trống)
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    function generateSlug(text) {
        return text.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
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