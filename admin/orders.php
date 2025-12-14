<?php
require_once '../config/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $orderId = $_POST['id'];
  
 
        $pdo->prepare("DELETE FROM order_details WHERE order_id = ?")->execute([$orderId]);
        $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$orderId]);
       
        echo "<script>alert('Đã xóa đơn hàng thành công');</script>";

}

$sql = "SELECT o.*, c.full_name FROM orders o LEFT JOIN customers c ON o.customer_id = c.id ORDER BY o.order_date DESC";
$orders = $pdo->query($sql)->fetchAll();
include_once "header.php";
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản lý Đơn hàng</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['full_name'] ?? 'Khách vãng lai') ?></td>
                            <td class="text-danger fw-bold"><?= number_format($order['total_amount']) ?> đ</td>
                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                            <td>
                                <?php 
                                    $s = $order['status'];
                                    $cls = 'secondary';
                                    if($s=='pending') $cls='warning text-dark';
                                    if($s=='processing') $cls='primary';
                                    if($s=='completed') $cls='success';
                                    if($s=='cancelled') $cls='danger';
                                ?>
                                <span class="badge bg-<?= $cls ?>"><?= htmlspecialchars($s) ?></span>
                            </td>
                            <td>
                                <a href="orderDetail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info text-white">Xem</a>
                                <form method="POST" class="d-inline-block" onsubmit="return confirm('Xóa đơn này?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>