<?php
require 'config/db.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$user]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($account && $pass === $account['password']) {
        $_SESSION['user_id']   = $account['id'];
        $_SESSION['user_name'] = $account['full_name']; 
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?error=Sai tài khoản hoặc mật khẩu");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
         body {
        background: url('images/library.jpg') no-repeat center center;
        background-size: cover;
        min-height: calc(100vh - 70px); 
    }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center text-primary mb-4">Đăng Nhập</h3>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center p-2 small">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Nhập email..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>

                <div class="text-center mt-3 small">
                    <a href="index.php" class="text-decoration-none text-secondary">Về trang chủ</a>
                    <span class="mx-2">|</span>
                    <a href="register.php" class="text-decoration-none">Đăng ký tài khoản</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>