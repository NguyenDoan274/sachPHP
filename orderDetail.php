<?php
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE id = ? AND customer_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("<div class='container mt-5 alert alert-danger'>Đơn hàng không tồn tại hoặc bạn không có quyền xem. <a href='index.php'>Về trang chủ</a></div>");
}

$sqlDetail = "SELECT od.*, b.title, b.image 
              FROM order_details od
              JOIN books b ON od.book_id = b.id
              WHERE od.order_id = ?";
$stmtDetail = $pdo->prepare($sqlDetail);
$stmtDetail->execute([$order_id]);
$items = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

$isEditable = ($order['status'] === 'pending');
include 'header.php';
?>

<div class="container mt-4 pb-5">
    <a href="order.php" class="btn btn-outline-secondary mb-3">&larr; Quay lại danh sách</a>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>
        <?php if ($isEditable): ?>
            <form action="actions/order.php" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?');">
                <input type="hidden" name="action" value="cancel">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
            </form>
        <?php endif; ?>
    </div>
    
    <div class="card mb-4 shadow-sm">
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-4"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></div>
                <div class="col-md-4">
                    <strong>Trạng thái:</strong> 
                    <?php 
                        $st = $order['status'];
                        $cls = 'secondary';
                        if($st=='pending') $cls='warning text-dark';
                        if($st=='processing') $cls='primary';
                        if($st=='completed') $cls='success';
                        if($st=='cancelled') $cls='danger';
                    ?>
                    <span class="badge bg-<?= $cls ?>"><?= htmlspecialchars($st) ?></span>
                </div>
                <div class="col-md-4 text-md-end">
                    <strong>Tổng tiền:</strong> <span class="text-danger fs-5 fw-bold"><?= number_format($order['total_amount']) ?> đ</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Danh sách sản phẩm</h5>
        </div>
        <div class="card-body p-0">
            <?php if ($isEditable): ?><form action="actions/order.php" method="POST"><?php endif; ?>
                <input type="hidden" name="action" value="update_qty">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th style="width: 150px;">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="images/<?= htmlspecialchars($item['image']) ?>" class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded me-3" style="width: 50px; height: 70px;">N/A</div>
                                            <?php endif; ?>
                                            <div><?= htmlspecialchars($item['title']) ?></div>
                                        </div>
                                    </td>
                                    <td><?= number_format($item['price']) ?> đ</td>
                                    <td>
                                        <?php if ($isEditable): ?>
                                            <input type="number" name="qty[<?= $item['book_id'] ?>]" value="<?= $item['quantity'] ?>" min="0" class="form-control text-center">
                                        <?php else: ?>
                                            <span class="fw-bold d-block text-center"><?= $item['quantity'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end fw-bold text-danger">
                                        <?= number_format($item['price'] * $item['quantity']) ?> đ
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($isEditable): ?>
                    <div class="p-3 text-end bg-light border-top">
                        <button type="submit" class="btn btn-primary">Cập nhật thay đổi</button>
                    </div>
                </form> 
                <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>