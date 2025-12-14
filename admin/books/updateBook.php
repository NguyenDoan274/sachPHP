<?php
require_once '../../config/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? ($_POST['id'] ?? null);
if (!$id) die("Thiếu ID sách.");

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) die("Không tìm thấy sách.");

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $imageName = $book['image'];

    if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../images/';
        $fileName = trim($title) . '_' . basename($_FILES['images']['name']);
        if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadDir . $fileName)) {
            $imageName = $fileName;
        }
    }

    $sql = "UPDATE books SET title = ?, author = ?, price = ?, description = ?, image = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$title, $author, $price, $description, $imageName, $id]);
    header("Location: ../books.php");
    exit;
}
include_once __DIR__ . '/../header.php';
?>
<div class="container mt-4">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Cập nhật sách</h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Tên sách</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" value="<?= $book['price'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($book['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại</label>
                    <div>
                        <?php if($book['image']): ?>
                            <img src="../../images/<?= htmlspecialchars($book['image']) ?>" width="80" class="img-thumbnail">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thay đổi hình (nếu cần)</label>
                    <input type="file" name="images" class="form-control">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="../books.php" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-warning">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>