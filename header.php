<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tủ sách nhỏ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* body { background-color: #f8f9fa; } */
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
          body { background-color: #f0f2f5; } 
        .lab-card { transition: transform 0.2s; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .lab-card:hover { transform: translateY(-5px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .card-header { background-color: #0d6efd; color: white; font-weight: bold; }
        .list-group-item a { text-decoration: none; color: #333; display: block; }
        .list-group-item a:hover { color: #0d6efd; font-weight: 500; }
        .badge-folder { background-color: #ffc107; color: #000; margin-left: 5px; font-size: 0.7rem;}
    </style>
</head>
<body>
    <?php
    $count_cart = 0;
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $qty){
            $count_cart += $qty;
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">📚 Tủ Sách Nhỏ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="../index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/BT/index.php">Bài tập tuần</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link position-relative" href="/admin/index.php">Admin Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="../cart.php">
                            Giỏ hàng
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $count_cart ?>
                            </span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../order.php">Đơn mua</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Xin chào, <?= htmlspecialchars($_SESSION['user_name']) ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../logout.php">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../login.php">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="../register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>