<?php
require('includes/header.php');
?>

<div class="container">
    <h3><?php echo isset($_GET['id']) ? "Sửa sản phẩm" : "Thêm sản phẩm"; ?></h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?php echo isset($_GET['id']) ? "Sửa sản phẩm" : "Thêm sản phẩm"; ?>
            </h6>
        </div>
        <div class="card-body">
            <?php
            require('../config/Database.php');
            $conn = Database::getConnect();

            // Khởi tạo dữ liệu sản phẩm mặc định
            $product = [
                'ProductId' => '',
                'TenSanPham' => '',
                'Gia' => '',
                'SoLuongTonKho' => '',
                'SalePercent' => '',
                'hinh' => '',
                'CategoryId' => '',
                'BrandId' => '',
            ];

            // Nếu có ID, lấy thông tin sản phẩm từ database
            if (isset($_GET['id']) && $conn) {
                $productId = intval($_GET['id']);
                $sql = "SELECT * FROM products WHERE ProductId = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            // Lấy danh sách các danh mục và thương hiệu
            $categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
            $brands = $conn->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <form action="./chucnang/addupdate_product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ProductId" value="<?php echo htmlspecialchars($product['ProductId']); ?>">

                <!-- Tên sản phẩm -->
                <div class="form-group">
                    <label for="TenSanPham">Tên sản phẩm</label>
                    <input type="text" name="TenSanPham" class="form-control" value="<?php echo htmlspecialchars($product['TenSanPham']); ?>" required>
                </div>

                <!-- Giá -->
                <div class="form-group">
                    <label for="Gia">Giá</label>
                    <input type="number" name="Gia" class="form-control" value="<?php echo htmlspecialchars($product['Gia']); ?>" required>
                </div>

                <!-- Số lượng tồn kho -->
                <div class="form-group">
                    <label for="SoLuongTonKho">Số lượng tồn kho</label>
                    <input type="number" name="SoLuongTonKho" class="form-control" value="<?php echo htmlspecialchars($product['SoLuongTonKho']); ?>" required>
                </div>

                <!-- Giảm giá -->
                <div class="form-group">
                    <label for="SalePercent">Giảm giá (%)</label>
                    <input type="number" name="SalePercent" class="form-control" value="<?php echo htmlspecialchars($product['SalePercent']); ?>">
                </div>

                <!-- Hình ảnh -->
                <div class="form-group">
                    <label for="hinh">Hình ảnh</label>
                    <input type="file" name="hinh" class="form-control">
                    <?php if (!empty($product['hinh'])): ?>
                        <img src="../admin/img/<?php echo htmlspecialchars($product['hinh']); ?>" alt="Hình ảnh sản phẩm" style="width: 100px; height: auto;">
                    <?php endif; ?>
                </div>

                <!-- Danh mục -->
                <div class="form-group">
                    <label for="CategoryId">Danh mục</label>
                    <select name="CategoryId" class="form-control" required>
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['CategoryId']; ?>" <?php echo $category['CategoryId'] == $product['CategoryId'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['CategoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Thương hiệu -->
                <div class="form-group">
                    <label for="BrandId">Thương hiệu</label>
                    <select name="BrandId" class="form-control" required>
                        <option value="">Chọn thương hiệu</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo $brand['BrandId']; ?>" <?php echo $brand['BrandId'] == $product['BrandId'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($brand['BrandName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="./listsanpham.php" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php
require('includes/footer.php');
?>