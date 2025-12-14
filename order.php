<?php
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$sql = "SELECT * FROM orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();
include 'header.php';
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Lịch sử đơn hàng</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-secondary">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($orders)): ?>
                            <tr><td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                                <td class="text-danger fw-bold">
                                    <?= number_format($order['total_amount']) ?> đ
                                </td>
                                <td>
                                    <?php 
                                        $s = $order['status'];
                                        $badgeClass = 'bg-secondary';
                                        if($s=='pending') $badgeClass = 'bg-warning text-dark';
                                        if($s=='processing') $badgeClass = 'bg-primary';
                                        if($s=='completed') $badgeClass = 'bg-success';
                                        if($s=='cancelled') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($s) ?></span>
                                </td>
                                <td>
                                    <a href="orderDetail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info text-white">Chi tiết</a>
                                    
                                    <?php if ($order['status'] == 'pending'): ?>
                                        <form action="actions/order.php" method="POST" class="d-inline-block" onsubmit="return confirm('Hủy đơn #<?= $order['id'] ?>?');">
                                            <input type="hidden" name="action" value="cancel">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1">Hủy</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>