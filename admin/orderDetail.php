<?php
require_once '../config/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newStatus = $_POST['status'];
    $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$newStatus, $id]);
    $message = "Đã cập nhật trạng thái!";
}

$sql = "SELECT o.*, c.full_name FROM orders o LEFT JOIN customers c ON o.customer_id = c.id WHERE o.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$order = $stmt->fetch();

if (!$order) die("Không tìm thấy đơn hàng");

$sqlDetail = "SELECT od.*, b.title, b.image FROM order_details od JOIN books b ON od.book_id = b.id WHERE od.order_id = ?";
$stmtDetail = $pdo->prepare($sqlDetail);
$stmtDetail->execute([$id]);
$details = $stmtDetail->fetchAll();

include_once "header.php";
?>
<div class="container mt-4 pb-5">
    <a href="orders.php" class="btn btn-secondary mb-3">&larr; Quay lại</a>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Chi tiết sản phẩm đơn #<?= $id ?></h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Sách</th>
                                <th>Đơn giá</th>
                                <th>SL</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($item['image']): ?>
                                            <img src="../../images/<?= htmlspecialchars($item['image']) ?>" width="40" class="me-2 rounded">
                                        <?php endif; ?>
                                        <?= htmlspecialchars($item['title']) ?>
                                    </div>
                                </td>
                                <td><?= number_format($item['price']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td class="text-end fw-bold"><?= number_format($item['price'] * $item['quantity']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php if($message): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>
                    
                    <p><strong>Khách hàng:</strong><br> <?= htmlspecialchars($order['full_name']) ?></p>
                    <p><strong>Ngày đặt:</strong><br> <?= $order['order_date'] ?></p>
                    <p><strong>Tổng tiền:</strong><br> <span class="text-danger fs-4 fw-bold"><?= number_format($order['total_amount']) ?> đ</span></p>
                    
                    <hr>
                    <form method="POST">
                        <label class="form-label fw-bold">Trạng thái xử lý:</label>
                        <select name="status" class="form-select mb-3">
                            <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Chờ xử lý</option>
                            <option value="processing" <?= $order['status']=='processing'?'selected':'' ?>>Đang giao hàng</option>
                            <option value="completed" <?= $order['status']=='completed'?'selected':'' ?>>Hoàn thành</option>
                            <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Đã hủy</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>