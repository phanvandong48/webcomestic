<?php
session_start();  // Bắt đầu session

// Bao gồm file kết nối cơ sở dữ liệu
include '../config/Database.php';

// Lấy kết nối CSDL
$pdo = Database::getConnect();

// Lấy ID sản phẩm từ POST
$product_id = $_POST['product_id'];

// Truy vấn để lấy thông tin sản phẩm từ CSDL
$sql = "SELECT * FROM products WHERE ProductId = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Kiểm tra xem sản phẩm có tồn tại trong cơ sở dữ liệu hay không
if ($product) {
    // Kiểm tra nếu giỏ hàng chưa được khởi tạo
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];  // Tạo mảng giỏ hàng nếu chưa có
    }

    // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Nếu sản phẩm chưa có trong giỏ, thêm mới vào giỏ hàng
        $_SESSION['cart'][$product_id] = [
            'product_name' => $product['TenSanPham'],
            'product_image' => $product['hinh'],
            'product_price' => $product['Gia'],
            'quantity' => 1
        ];
    }

    // Quay lại trang giỏ hàng sau khi thêm sản phẩm
    header('Location: ../public/cart.php');
    exit();
} else {
    // Nếu không tìm thấy sản phẩm, có thể báo lỗi
    echo "Product not found.";
}
