<?php require_once 'config/db.php'; include 'header.php'; ?>

<div class="container mt-4 pb-5">
    <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>

    <?php 
    if (empty($_SESSION['cart'])) {
        echo "<div class='text-center py-5'>
                <div class='alert alert-info d-inline-block'>Giỏ hàng đang trống.</div>
                <br>
                <a href='index.php' class='btn btn-primary mt-3'>&larr; Tiếp tục mua sắm</a>
              </div>";
    } else {
        $cartIds = array_keys($_SESSION['cart']);
        $ids = implode(',', $cartIds);
        
        $sql = "SELECT * FROM books WHERE id IN ($ids)";
        $stmt = $pdo->query($sql);
        $books = $stmt->fetchAll();
        $grandTotal = 0;
    ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="actions/cart.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sách</th>
                                    <th>Giá</th>
                                    <th style="width: 100px;">Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $book): 
                                    $id = $book['id'];
                                    $qty = $_SESSION['cart'][$id];
                                    $total = $book['price'] * $qty;
                                    $grandTotal += $total;
                                ?>
                                <tr>
                                    <td>
                                        <?php if($book['image']): ?>
                                            <img src="images/<?= htmlspecialchars($book['image']) ?>" class="img-thumbnail" style="width: 60px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($book['title']) ?></td>
                                    <td><?= number_format($book['price']) ?> đ</td>
                                    <td>
                                        <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="1" class="form-control form-control-sm text-center">
                                    </td>
                                    <td class="fw-bold"><?= number_format($total) ?> đ</td>
                                    <td>
                                        <button type="button" onclick="deleteItem(<?= $id ?>)" class="btn btn-danger btn-sm">Xóa</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="table-light">
                                    <td colspan="4" class="text-end fw-bold fs-5">Tổng cộng:</td>
                                    <td class="text-danger fw-bold fs-5"><?= number_format($grandTotal) ?> VNĐ</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="index.php" class="btn btn-secondary">&larr; Mua thêm</a>
                        <button type="submit" class="btn btn-info text-white">Cập nhật giỏ hàng</button>
                    </div>
                </form> 

                <div class="text-end mt-4 pt-3 border-top">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="actions/order.php" method="POST">
                            <button type="submit" name="order" class="btn btn-success btn-lg" onclick="return confirm('Xác nhận đặt hàng?')">
                                Đặt hàng ngay
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-warning btn-lg text-white">
                            Đăng nhập để đặt hàng
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <form id="delete-form" action="actions/cart.php" method="POST" style="display:none;">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" id="delete-id">
        </form>

        <script>
            function deleteItem(id) {
                if(confirm('Bạn có chắc muốn xóa sách này khỏi giỏ hàng?')) {
                    document.getElementById('delete-id').value = id;
                    document.getElementById('delete-form').submit();
                }
            }
        </script>
    <?php } ?>
</div>
</body>
</html>