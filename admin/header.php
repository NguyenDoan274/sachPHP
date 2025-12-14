<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="../admin/index.php">ADMIN PANEL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="../admin/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/books.php">Quản lý sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/orders.php">Quản lý đơn hàng</a></li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="me-3">Xin chào, <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong></span>
                    <a href="../admin/logout.php" class="btn btn-sm btn-light text-primary fw-bold">Đăng xuất</a>
                </div>
            </div>
        </div>
    </nav>