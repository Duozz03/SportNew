<?php

class AuthController
{
    public function loginForm()
    {
        include __DIR__ . "/../layout/header.php";
        include __DIR__ . "/../view/auth/login.php";
        include __DIR__ . "/../layout/footer.php";
    }

    public function login()
    {
        global $pdo;

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['flash_error'] = "Vui lòng nhập đầy đủ tài khoản và mật khẩu.";
            header("Location: " . BASE_URL . "site/index.php?c=auth&a=loginForm");
            exit;
        }

        $repo  = new AdminRepository($pdo);
        $admin = $repo->findByUsername($username);

        // So sánh plain text (theo DB hiện tại của bạn)
        if (!$admin || $password !== $admin->password) {
            $_SESSION['flash_error'] = "Sai tài khoản hoặc mật khẩu.";
            header("Location: " . BASE_URL . "site/index.php?c=auth&a=loginForm");
            exit;
        }

        // Đăng nhập thành công
        $_SESSION['admin_id']       = $admin->id;
        $_SESSION['admin_username'] = $admin->username;

        header("Location: " . BASE_URL . "site/index.php?c=admin&a=dashboard");
        exit;
    }

    public function logout()
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_username']);

        header("Location: " . BASE_URL);
        exit;
    }
}
