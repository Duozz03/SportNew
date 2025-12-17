<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --card:#ffffff;
    --brand:#b91c1c;
  }

  .login-wrap{
    min-height: calc(100vh - 140px); /* trừ header/footer */
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 28px 12px;
    position: relative;
  }

  /* Background */
  .login-bg{
    position:absolute;
    inset: 0;
    background:
      radial-gradient(800px 400px at 15% 20%, rgba(185,28,28,.14), transparent 60%),
      radial-gradient(700px 360px at 85% 30%, rgba(37,99,235,.12), transparent 60%),
      linear-gradient(180deg, #ffffff, #f6f7fb);
    pointer-events:none;
  }

  .login-card{
    width: 100%;
    max-width: 520px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(10px);
    border: 1px solid var(--line);
    border-radius: 18px;
    box-shadow: 0 18px 45px rgba(15,23,42,.10);
    position: relative;
    overflow: hidden;
  }

  .login-topbar{
    height: 6px;
    background: linear-gradient(90deg, var(--brand), #2563eb);
  }

  .login-body{
    padding: 18px;
  }

  .brand-row{
    display:flex;
    align-items:center;
    gap: 12px;
    margin-bottom: 10px;
  }
  .brand-badge{
    width: 42px; height: 42px;
    border-radius: 14px;
    background: rgba(185,28,28,.10);
    border: 1px solid rgba(185,28,28,.18);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight: 950;
    color: var(--brand);
    letter-spacing: .02em;
  }
  .brand-title{
    margin:0;
    font-size: 20px;
    font-weight: 950;
    color: var(--ink);
  }
  .brand-sub{
    margin: 2px 0 0;
    color: var(--muted);
    font-size: 13px;
  }

  .form-label{
    font-weight: 850;
    color: var(--ink);
  }

  .input-group-text{
    background:#f8fafc;
    border-color: var(--line);
  }

  .form-control{
    border-color: var(--line);
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .form-control:focus{
    border-color: rgba(37,99,235,.35);
    box-shadow: 0 0 0 .2rem rgba(37,99,235,.10);
  }

  .btn-login{
    border-radius: 14px;
    font-weight: 900;
    padding: 11px 14px;
  }

  .login-foot{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
    color: var(--muted);
    font-size: 13px;
  }
</style>

<div class="login-wrap">
  <div class="login-bg"></div>

  <div class="login-card">
    <div class="login-topbar"></div>

    <div class="login-body">
      <div class="brand-row">
        <div class="brand-badge">AD</div>
        <div>
          <h1 class="brand-title">Đăng nhập quản trị</h1>
          <div class="brand-sub">Khu vực dành cho Admin — quản lý bài viết và chuyên mục.</div>
        </div>
      </div>

      <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger mb-3">
          <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
      <?php endif; ?>

      <form action="index.php?c=auth&a=login" method="post" autocomplete="off">
        <div class="mb-3">
          <label class="form-label">Tài khoản</label>
          <div class="input-group">
            <span class="input-group-text">👤</span>
            <input type="text" name="username" class="form-control" required
                   placeholder="Nhập tài khoản admin">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text">🔒</span>
            <input type="password" name="password" class="form-control" required
                   placeholder="Nhập mật khẩu">
            <button class="btn btn-outline-secondary" type="button" id="togglePw">Hiện</button>
          </div>
        </div>

        <button type="submit" class="btn btn-dark w-100 btn-login">Đăng nhập</button>

        <div class="login-foot">
          <a class="text-decoration-none" href="<?= BASE_URL ?>">← Về trang chủ</a>
          <span>© <?= date('Y') ?> Tin tức thể thao</span>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  (function(){
    const btn = document.getElementById('togglePw');
    if (!btn) return;
    const input = btn.parentElement.querySelector('input[type="password"], input[type="text"]');

    btn.addEventListener('click', function(){
      if (!input) return;
      const isPw = input.getAttribute('type') === 'password';
      input.setAttribute('type', isPw ? 'text' : 'password');
      btn.textContent = isPw ? 'Ẩn' : 'Hiện';
    });
  })();
</script>
