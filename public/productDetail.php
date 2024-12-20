<?php
include_once '../api/Product.php';
include_once '../config/Database.php';
include_once '../include/header.php';

$p = new Product();
$conn = Database::getConnect();
if ($conn === null) {
    die("Không thể kết nối tới cơ sở dữ liệu.");
}

// Lấy thông tin sản phẩm theo ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($productId === 0) {
    die("Sản phẩm không tồn tại.");
}

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$sqlProduct = "SELECT * FROM products WHERE ProductId = :productId";
$stmtProduct = $conn->prepare($sqlProduct);
$stmtProduct->bindParam(':productId', $productId, PDO::PARAM_INT);
$stmtProduct->execute();
$product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Lấy thông tin danh mục và thương hiệu
$sqlCategories = "SELECT * FROM categories";
$stmtCategories = $conn->prepare($sqlCategories);
$stmtCategories->execute();

$sqlBrands = "SELECT * FROM brands";
$stmtBrands = $conn->prepare($sqlBrands);
$stmtBrands->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?php echo htmlspecialchars($product['TenSanPham']); ?></title>
    <link rel="stylesheet" href="../assets/css/productDetail.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="../admin/img/<?php echo htmlspecialchars($product['hinh']); ?>" alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h3><?php echo htmlspecialchars($product['TenSanPham']); ?></h3>
                <p><strong>Giá: </strong><?php echo number_format($product['Gia'], 0, ',', ','); ?> VND</p>
                <p><strong>Danh mục: </strong>
                    <?php
                    $categoryId = $product['CategoryId'];
                    $stmtCategories->execute();
                    while ($row = $stmtCategories->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['CategoryId'] == $categoryId) {
                            echo htmlspecialchars($row['CategoryName']);
                            break;
                        }
                    }
                    ?>
                </p>
                <p><strong>Thương hiệu: </strong>
                    <?php
                    $brandId = $product['BrandId'];
                    $stmtBrands->execute();
                    while ($row = $stmtBrands->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['BrandId'] == $brandId) {
                            echo htmlspecialchars($row['BrandName']);
                            break;
                        }
                    }
                    ?>
                </p>
                <p><strong>Mô tả: </strong><?php echo nl2br(htmlspecialchars($product['MoTa'])); ?></p>
                <p><strong>Sale: </strong>
                    <?php if ($product['SalePercent'] > 0): ?>
                        <?php echo $product['SalePercent']; ?>% OFF
                    <?php else: ?>
                        Không có giảm giá
                    <?php endif; ?>
                </p>
                <form action="../api/add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductId']); ?>">
                    <button type="submit" class="btn btn-primary abc">Add to cart</button>
                </form>
            </div>
        </div>
    </div>

    <?php include_once '../include/footer.php'; ?>
</body>

</html>