<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Xử lý yêu cầu OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/Database.php';


class Cart
{
    // Lấy tất cả sản phẩm trong giỏ hàng từ session
    public function getCartItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    // Tính tổng giá trị giỏ hàng
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->getCartItems() as $item) {
            $total += $item['total'];
        }
        return $total;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($productId, $productName, $price, $quantity)
    {
        if (isset($_SESSION['cart'][$productId])) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
            $_SESSION['cart'][$productId]['total'] = $_SESSION['cart'][$productId]['quantity'] * $price;
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'name' => $productName,
                'price' => $price,
                'quantity' => $quantity,
                'total' => $price * $quantity
            ];
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart($productId, $quantity)
    {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            $_SESSION['cart'][$productId]['total'] = $quantity * $_SESSION['cart'][$productId]['price'];
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}


// Hiển thị giỏ hàng
