<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';

    $checkStmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
    $checkStmt->execute([$user]);
    if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
        header("Location: register.php?error=Email đã tồn tại");
        exit;
    } else {
        $sql = "INSERT INTO customers (email, password, full_name) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user, $pass, $name]);

        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng ký tài khoản</title>
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
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center text-primary mb-4">Đăng Ký</h3>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center p-2 small">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                </form>

                <div class="text-center mt-3 small">
                    <a href="index.php" class="text-decoration-none text-secondary">Về trang chủ</a>
                    <span class="mx-2">|</span>
                    <a href="login.php" class="text-decoration-none">Đã có tài khoản? Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>