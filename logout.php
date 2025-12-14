<?php
session_start();
// Chỉ xóa session user, giữ admin nếu có
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
// Hoặc session_destroy() nếu muốn xóa sạch
header("Location: index.php"); 
?>