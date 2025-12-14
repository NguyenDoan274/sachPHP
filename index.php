<?php require_once 'config/db.php'; ?>
<?php include 'header.php'; ?>
<style>
    body {
        background: url('images/library.jpg') no-repeat center center;
        background-size: cover;
        min-height: calc(100vh - 70px); 
    }
</style>
<div class="container pb-5">
    <div class="text-center mb-5 text-white">
        <h1 class="display-6">Chào mừng bạn đến với Tủ Sách Nhỏ</h1>
        <p >Nơi lưu giữ tri thức nhân loại</p>
    </div>
    <a href="hi.php">Trang hi</a>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if(isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
            while ($book = $stmt->fetch()):
        ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <a href="bookDetail.php?id=<?= $book['id'] ?>" class="text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-center p-3" style="height: 250px; background: #fff;">
                            <?php if (!empty($book['image'])): ?>
                                <img src="images/<?= htmlspecialchars($book['image']) ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="<?= htmlspecialchars($book['title']) ?>">
                            <?php else: ?>
                                <span class="text-muted">Chưa có hình</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center border-top">
                            <h6 class="card-title text-truncate" title="<?= htmlspecialchars($book['title']) ?>"><?= htmlspecialchars($book['title']) ?></h6>
                            <p class="card-text text-danger fw-bold mb-2"><?= number_format($book['price'], 0, ',', '.') ?> VNĐ</p>
                        </div>
                    </a>
                    <div class="card-footer bg-white border-0 pb-3">
                        <form action="actions/cart.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <button type="submit" class="btn btn-primary w-100 btn-sm">Chọn mua</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
            endwhile; 
        } else {
            echo "<div class='alert alert-danger w-100'>Lỗi kết nối cơ sở dữ liệu.</div>";
        }
        ?>
    </div>
</div>
</body>
</html>