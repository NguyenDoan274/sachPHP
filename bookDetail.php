<?php
require_once 'config/db.php';
include 'header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    echo "<div class='container mt-5 text-center'><div class='alert alert-warning'>ID không hợp lệ! <a href='index.php'>Quay lại</a></div></div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo "<div class='container mt-5 text-center'><div class='alert alert-danger'>Sách không tồn tại! <a href='index.php'>Quay lại</a></div></div>";
    exit;
}
?>

<div class="container py-4">
    <a href="index.php" class="btn btn-outline-secondary mb-4">&larr; Quay lại danh sách</a>

    <div class="card shadow-sm border-0">
        <div class="row g-0">
            <div class="col-md-5 d-flex align-items-center justify-content-center bg-white p-3">
                <?php if (!empty($book['image'])): ?>
                    <img src="images/<?= htmlspecialchars($book['image']) ?>" class="img-fluid rounded" style="max-height: 400px;" alt="<?= htmlspecialchars($book['title']) ?>">
                <?php else: ?>
                    <span class="text-muted">Không có ảnh</span>
                <?php endif; ?>
            </div>
            <div class="col-md-7">
                <div class="card-body p-4">
                    <h2 class="card-title text-primary"><?= htmlspecialchars($book['title']) ?></h2>
                    <p class="text-muted mb-3">Tác giả: <strong><?= htmlspecialchars($book['author']) ?></strong></p>
                    <h3 class="text-danger fw-bold mb-4"><?= number_format($book['price']) ?> đ</h3>
                    
                    <form action="actions/cart.php" method="POST" class="d-flex align-items-center gap-3 mb-4">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= (int)$book['id'] ?>">
                        
                        <div class="input-group" style="width: 150px;">
                            <span class="input-group-text">SL</span>
                            <input type="number" name="quantity" value="1" min="1" max="99" class="form-control text-center">
                        </div>
                        
                        <button type="submit" class="btn btn-success flex-grow-1">
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    </form>

                    <div class="border-top pt-3">
                        <h5 class="mb-3">Mô tả sản phẩm</h5>
                        <p class="card-text text-secondary" style="line-height: 1.6;">
                            <?= !empty($book['description']) ? nl2br(htmlspecialchars($book['description'])) : "Chưa có mô tả." ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>