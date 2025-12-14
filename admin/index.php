<?php
require '../config/db.php'; 
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include_once "header.php"; 
?>
<style>
    .bg-admin-home {
        background: url('../images/library.jpg') no-repeat center center;
        background-size: cover;
        min-height: calc(100vh - 70px); 
    }
</style>
<div class="container-fluid bg-admin-home d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-5" style="background: rgba(255, 255, 255, 0.95); max-width: 600px;">
        <div class="card-body text-center">
            <h1 class="card-title text-primary mb-3">Hệ thống Quản lý</h1>
            <h4 class="text-secondary mb-4">Tủ Sách Nhỏ</h4>
            <p class="lead mb-4">Xin chào, <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong>!</p>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-center">
                <a href="books.php" class="btn btn-primary btn-lg px-4">Quản lý Sách</a>
                <a href="orders.php" class="btn btn-success btn-lg px-4">Quản lý Đơn hàng</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>