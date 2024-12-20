<?php
session_start(); // Khởi tạo session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>

<body>
    <?php include '../include/header.php'; ?>
    <div class="container-cart">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td>
                                <?php
                                // Tạo đường dẫn đầy đủ
                                $imagePath = !empty($product['product_image']) ? '../admin/img/' . $product['product_image'] : '../admin/img/default.png';
                                ?>
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Product Image" width="100">
                            </td>

                            <td><?php echo number_format($product['product_price'], 0, ',', ','); ?> VND</td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td><?php echo number_format($product['product_price'] * $product['quantity'], 0, ',', ','); ?> VND</td>
                            <td class="remove">
                                <a href="../api/remove_from_cart.php?id=<?php echo urlencode($product_id); ?>" class="btn-remove">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:right; font-weight:bold;">Total Price:</td>
                        <td><?php
                            $total_price = array_reduce($_SESSION['cart'], function ($sum, $product) {
                                return $sum + ($product['product_price'] * $product['quantity']);
                            }, 0);
                            echo number_format($total_price, 0, ',', ','); ?> VND
                        </td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Your cart is empty. <a href="./product.php">Continue shopping</a></p>
        <?php endif; ?>
    </div>
    <?php include '../include/footer.php'; ?>
</body>

</html>