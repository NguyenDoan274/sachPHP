<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

if ($action === 'cancel') {
    $orderId = (int)($_POST['order_id'] ?? 0);

    $stmt = $pdo->prepare("SELECT status FROM orders WHERE id = ? AND customer_id = ?");
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "<script>alert('Đơn hàng không tồn tại hoặc bạn không có quyền.'); window.location.href='../order.php';</script>";
        exit;
    }

    if ($order['status'] !== 'pending') {
        echo "<script>alert('Chỉ được xóa đơn khi đang pending.'); window.location.href='../order.php';</script>";
        exit;
    }

    try {
        $pdo->prepare("DELETE FROM order_details WHERE order_id = ?")->execute([$orderId]);
        $delOrder = $pdo->prepare("DELETE FROM orders WHERE id = ? AND customer_id = ?");
        $delOrder->execute([$orderId, $userId]);

        if ($delOrder->rowCount() > 0) {
            header("Location: ../order.php");
            exit;
        } else {
            echo "<script>alert('Không thể xóa đơn.'); window.location.href='../order.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>alert('Lỗi hệ thống khi xóa đơn.'); window.location.href='../order.php';</script>";
        exit;
    }
}

if ($action === 'update_qty') {
    $orderId = (int)($_POST['order_id'] ?? 0);
    $quantities = $_POST['qty'] ?? [];

    $stmt = $pdo->prepare("SELECT status FROM orders WHERE id = ? AND customer_id = ?");
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order && $order['status'] === 'pending') {
        $newTotalMoney = 0;

        foreach ($quantities as $bookId => $qty) {
            $bookId = (int)$bookId;
            $qty = (int)$qty;

            if ($qty > 0) {
                $stmtDetail = $pdo->prepare("UPDATE order_details SET quantity = ? WHERE order_id = ? AND book_id = ?");
                $stmtDetail->execute([$qty, $orderId, $bookId]);

                $stmtPrice = $pdo->prepare("SELECT price FROM order_details WHERE order_id = ? AND book_id = ?");
                $stmtPrice->execute([$orderId, $bookId]);
                $price = $stmtPrice->fetchColumn();

                if ($price === false) continue;
                $newTotalMoney += ((float)$price) * $qty;
            } else {
                $pdo->prepare("DELETE FROM order_details WHERE order_id = ? AND book_id = ?")->execute([$orderId, $bookId]);
            }
        }

        $pdo->prepare("UPDATE orders SET total_amount = ? WHERE id = ? AND customer_id = ?")
            ->execute([$newTotalMoney, $orderId, $userId]);
    }

    header("Location: ../orderDetail.php?id=" . $orderId);
    exit;
}

if (isset($_POST['order']) || empty($action)) {
    if (empty($_SESSION['cart'])) {
        header("Location: ../index.php");
        exit;
    }

    $cart = $_SESSION['cart'];
    $bookIds = array_map('intval', array_keys($cart));

    if (empty($bookIds)) {
        header("Location: ../index.php");
        exit;
    }

    $ids = implode(',', $bookIds);

    try {
        $stmt = $pdo->query("SELECT id, price FROM books WHERE id IN ($ids)");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Lỗi truy vấn sách");
    }

    if (empty($books)) {
        die("Không tìm thấy sản phẩm.");
    }

    $total_amount = 0;
    foreach ($books as $book) {
        $bid = (int)$book['id'];
        $qty = (int)($cart[$bid] ?? 0);
        $total_amount += ((float)$book['price']) * $qty;
    }

    $stmtOrder = $pdo->prepare("INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'pending')");
    $stmtOrder->execute([$userId, $total_amount]);

    $order_id = $pdo->lastInsertId();

    $stmtDetail = $pdo->prepare("INSERT INTO order_details (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($books as $book) {
        $bid = (int)$book['id'];
        $qty = (int)($cart[$bid] ?? 0);
        $price = (float)$book['price'];
        if ($qty <= 0) continue;

        if (!$stmtDetail->execute([$order_id, $bid, $qty, $price])) {
            $pdo->prepare("DELETE FROM order_details WHERE order_id = ?")->execute([$order_id]);
            $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$order_id]);
            die("Lỗi khi lưu chi tiết đơn hàng.");
        }
    }

    unset($_SESSION['cart']);
    header("Location: ../order.php");
    exit;
}

header("Location: ../order.php");
exit;
