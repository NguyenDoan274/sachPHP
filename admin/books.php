<?php
require_once '../config/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header("Location: books.php");
    exit;
}
$books = [];
if (isset($_POST['find']) && !empty($_POST['title'])) {
    $title = $_POST['title'];
    $sql = "SELECT * FROM books WHERE title LIKE :ten";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(":ten", "%$title%");
    $stm->execute();
    $books = $stm->fetchAll();
} else {
    $stmt = $pdo->query("SELECT * FROM books");
    $books = $stmt->fetchAll();
}
include_once "header.php"; 
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý kho sách</h2>
        <a href="books/createBook.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Thêm sách mới</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-auto flex-grow-1">
                    <input type="text" name="title" class="form-control" placeholder="Nhập tên sách cần tìm...">
                </div>
                <div class="col-auto">
                    <button type="submit" name="find" class="btn btn-primary">Tìm kiếm</button>
                    <a href="books.php" class="btn btn-outline-secondary">Đặt lại</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Tác giả</th>
                    <th style="width: 200px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['id'] ?></td>
                    <td>
                        <?php if (!empty($book['image'])): ?>
                            <img src="../images/<?= htmlspecialchars($book['image']) ?>" class="img-thumbnail" style="height: 60px;">
                        <?php else: ?>
                            <span class="text-muted small">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td class="fw-bold"><?= htmlspecialchars($book['title']) ?></td>
                    <td class="text-danger"><?= number_format($book['price']) ?> đ</td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td>
                        <a href="books/updateBook.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-warning text-dark">Sửa</a>
                        <form method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>