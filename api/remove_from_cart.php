<?php
session_start();

// Kiểm tra nếu có ID sản phẩm cần xóa
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
    if (isset($_SESSION['cart'][$product_id])) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$product_id]);
    }

    // Chuyển hướng lại về trang giỏ hàng để cập nhật giỏ hàng
    header('Location: ../public/cart.php');
    exit();
} else {
    // Nếu không có ID, chuyển hướng về trang sản phẩm
    header('Location: ../public/product.php');
    exit();
}
