<?php
require_once '../../config/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    
    $imageName = null;
    if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../images/';
        $fileName = trim($_POST['title']) . '_' . basename($_FILES['images']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['images']['tmp_name'], $targetPath)) {
            $imageName = $fileName;
        } else {
            $message = "Lỗi upload ảnh.";
        }
    }

    if (empty($message)) {
        $sql = "INSERT INTO books (title, author, price, description, image) VALUES (?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$title, $author, $price, $description, $imageName]);
        header("Location: ../books.php");
        exit;
    }
}
include_once __DIR__ . '/../header.php';
?>
<div class="container mt-4">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Thêm sách mới</h4>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Tên sách</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" name="images" class="form-control">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="../books.php" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-success">Lưu sách</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>