<style>
    :root {
        --ink: #0f172a;
        --muted: #64748b;
        --line: #e2e8f0;
        --card: #ffffff;
    }

    .admin-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin: 6px 0 14px;
    }

    .admin-head h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 950;
        color: var(--ink);
        letter-spacing: .01em;
    }

    .admin-sub {
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
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
    }

    .table-wrap {
        overflow: auto;
    }

    table.table {
        margin: 0;
        border-color: var(--line) !important;
    }

    .table thead th {
        background: #0b1220 !important;
        color: #fff !important;
        font-weight: 850;
        letter-spacing: .02em;
        white-space: nowrap;
        border-color: rgba(255, 255, 255, .08) !important;
    }

    .table tbody td {
        vertical-align: middle;
        border-color: var(--line) !important;
    }

    .table tbody tr:hover {
        background: #fafafa;
    }

    .col-name {
        font-weight: 900;
        color: var(--ink);
        line-height: 1.25;
    }

    .slug {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size: 12px;
        color: #0f172a;
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 6px 8px;
        display: inline-block;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-mini {
        border-radius: 10px;
        font-weight: 800;
        font-size: 12px;
        padding: 7px 10px;
    }
</style>

<div class="admin-head">
    <div>
        <h2>Quản lý chuyên mục</h2>
        <div class="admin-sub">Tạo/sửa/xóa chuyên mục để phân loại bài viết.</div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="index.php?c=category&a=create" class="btn btn-dark btn-pill">+ Thêm chuyên mục</a>
        <a href="index.php?c=admin&a=dashboard" class="btn btn-outline-dark btn-pill">← Dashboard</a>
    </div>
</div>

<div class="panel">
    <div class="table-wrap">
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['flash_error']) ?>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['flash_success']) ?>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">ID</th>
                    <th>Tên chuyên mục</th>
                    <th style="min-width:220px;">Slug</th>
                    <th style="width:180px;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Chưa có chuyên mục nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $cate): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= (int)$cate->id ?></td>

                            <td>
                                <div class="col-name"><?= htmlspecialchars($cate->name ?? '') ?></div>
                            </td>

                            <td>
                                <span class="slug"><?= htmlspecialchars($cate->slug ?? '') ?></span>
                            </td>

                            <td>
                                <div class="actions">
                                    <a class="btn btn-warning btn-mini"
                                        href="<?= BASE_URL ?>site/index.php?c=category&a=edit&id=<?= (int)$cate->id ?>">
                                        Sửa
                                    </a>

                                    <a class="btn btn-danger btn-mini"
                                        onclick="return confirm('Xóa chuyên mục này? (Nếu còn bài viết thuộc chuyên mục này có thể bị lỗi)')"
                                        href="<?= BASE_URL ?>site/index.php?c=category&a=delete&id=<?= (int)$cate->id ?>">
                                        Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>