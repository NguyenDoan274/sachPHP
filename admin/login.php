<?php
require '../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['action'] ?? '') === 'admin_login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM employees WHERE username = ?");
    $stmt->execute([$user]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($account && $pass === $account['password']) {
        $_SESSION['admin_id']   = $account['id'];
        $_SESSION['admin_name'] = $account['full_name'];
        $_SESSION['admin_role'] = 'admin';

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
    <title>Đăng nhập Quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center text-danger mb-4">ADMIN LOGIN</h3>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center p-2 small">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <input type="hidden" name="action" value="admin_login">
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Đăng nhập</button>
                </form>

                <div class="text-center mt-3">
                    <a href="../index.php" class="text-secondary small">&larr; Về trang khách hàng</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>