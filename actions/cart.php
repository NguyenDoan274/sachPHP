<?php
require_once '../config/db.php';

$action = $_POST['action'] ?? '';

if ($action == 'add') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($id > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $qty;
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    header("Location: ../cart.php");
    exit;
}

if ($action == 'update') {
    $quantities = $_POST['qty'] ?? [];
    foreach ($quantities as $id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$id] = (int)$qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: ../cart.php");
    exit;
}

if ($action == 'delete') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: ../cart.php");
    exit;
}

header("Location: ../index.php");
?>