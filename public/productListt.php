<?php

include_once '../api/Product.php';
include_once '../config/Database.php';

$p = new Product();
$conn = Database::getConnect();
if ($conn === null) {
    die("Không thể kết nối tới cơ sở dữ liệu.");
}

// Lấy danh sách categories
$sqlCategories = "SELECT * FROM categories";
$stmtCategories = $conn->prepare($sqlCategories);
$stmtCategories->execute();

// Lấy danh sách brands
$sqlBrands = "SELECT * FROM brands";
$stmtBrands = $conn->prepare($sqlBrands);
$stmtBrands->execute();

// Lấy thông tin trang hiện tại
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;

// Lấy dữ liệu từ GET
$keyword = isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : '';
$categories = isset($_GET['categories']) ? array_map('intval', $_GET['categories']) : [];
$brands = isset($_GET['brands']) ? array_map('intval', $_GET['brands']) : [];
$minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 9999999;

// Tính OFFSET
$offset = ($page - 1) * $perPage;

// Lấy tổng số sản phẩm sau khi lọc
$totalProducts = $p->countProducts($keyword, $categories, $brands, $minPrice, $maxPrice);

// Tính tổng số trang
$totalPages = ceil($totalProducts / $perPage);

// Lấy danh sách sản phẩm từ cơ sở dữ liệu có phân trang
$allProducts = $p->searchProducts($keyword, $categories, $brands, $minPrice, $maxPrice, $offset, $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm - Sản phẩm làm đẹp</title>
    <link rel="stylesheet" href="../assets/css/demo.css">
</head>

<body>
    <div class="container-fluid mt-5 mb-5">
        <div class="row g-2">
            <!-- Sidebar bộ lọc -->
            <div class="col-md-3">
                <div class="t-products p-2">
                    <h6 class="text-uppercase">Product Categories</h6>
                    <form method="GET" action="./product.php">
                        <div class="p-lists">
                            <?php
                            if ($stmtCategories->rowCount() > 0) {
                                while ($row = $stmtCategories->fetch(PDO::FETCH_ASSOC)) {
                                    $categoryId = $row['CategoryId'];
                                    $categoryName = $row['CategoryName'];
                            ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $categoryId; ?>" id="category<?php echo $categoryId; ?>"
                                            <?php echo in_array($categoryId, $categories) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="category<?php echo $categoryId; ?>"><?php echo $categoryName; ?></label>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "No categories found";
                            }
                            ?>
                        </div>

                        <h6 class="text-uppercase mt-3">Brand</h6>
                        <div class="p-lists">
                            <?php
                            if ($stmtBrands->rowCount() > 0) {
                                while ($row = $stmtBrands->fetch(PDO::FETCH_ASSOC)) {
                                    $brandId = $row['BrandId'];
                                    $brandName = $row['BrandName'];
                            ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brands[]" value="<?php echo $brandId; ?>" id="brand<?php echo $brandId; ?>"
                                            <?php echo in_array($brandId, $brands) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="brand<?php echo $brandId; ?>"><?php echo $brandName; ?></label>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "No brands found";
                            }
                            ?>
                        </div>

                        <h6 class="text-uppercase mt-3">Price Range</h6>
                        <div class="form-group">
                            <label for="min_price">Min Price</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Min Price" value="<?php echo $minPrice; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label for="max_price">Max Price</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Max Price" value="<?php echo $maxPrice; ?>" min="0">
                        </div>

                        <button type="submit" class="btn btn-primary text-uppercase mt-3">Search</button>
                    </form>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">
                <h3 class="mb-4">Cosmetic products</h3>
                <div class="row g-2">
                    <?php if (isset($allProducts) && count($allProducts) > 0): ?>
                        <?php foreach ($allProducts as $product): ?>
                            <div class="col-md-4">
                                <div class="product py-4" onclick="window.location.href='./productDetail.php?id=<?php echo htmlspecialchars($product['ProductId']); ?>'">
                                    <?php if ($product['SalePercent'] > 0): ?>
                                        <span class="off bg-success">-<?php echo htmlspecialchars($product['SalePercent']); ?>% OFF</span>
                                    <?php endif; ?>
                                    <div class="text-center">
                                        <?php
                                        $imagePath = !empty($product['hinh']) ? '../admin/img/' . $product['hinh'] : '../admin/img/default.png';
                                        ?>
                                        <img src="<?php echo htmlspecialchars($imagePath); ?>" width="150" alt="Product Image">
                                    </div>
                                    <div class="about text-center">
                                        <h5><?php echo htmlspecialchars($product['TenSanPham']); ?></h5>
                                        <span><?php echo number_format($product['Gia'], 0, ',', ','); ?> VND</span>
                                    </div>
                                    <div class="cart-button mt-3 px-2">
                                        <form action="../api/add_to_cart.php" method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductId']); ?>">
                                            <button type="submit" class="btn btn-primary text-uppercase w-100">ADD TO CART</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không tìm thấy sản phẩm nào. Vui lòng thử lại!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Phân trang -->
    <div class="pagination d-flex justify-content-center ">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&keyword=<?php echo urlencode($keyword); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>

</html>