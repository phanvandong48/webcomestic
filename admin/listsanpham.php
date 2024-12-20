<?php
require('includes/header.php');
?>

<div>
    <h3>Danh sách sản phẩm</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Giảm giá (%)</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Giảm giá (%)</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        require('../config/Database.php');
                        $conn = Database::getConnect();

                        if ($conn) {
                            try {
                                $sql_str = "SELECT ProductId, TenSanPham, Gia, SoLuongTonKho, SalePercent, hinh, CreatedAt FROM products ORDER BY TenSanPham";
                                $stmt = $conn->prepare($sql_str);
                                $stmt->execute();
                                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($products as $product) {
                                    echo "<tr>";
                                    echo "<td><img src='../admin/img/" . htmlspecialchars($product['hinh']) . "' alt='" . htmlspecialchars($product['TenSanPham']) . "' style='width: 100px; height: auto;'></td>";
                                    echo "<td>" . htmlspecialchars($product['TenSanPham']) . "</td>";
                                    echo "<td>" . number_format($product['Gia'], 0, ',', '.') . " VND</td>";
                                    echo "<td>" . htmlspecialchars($product['SoLuongTonKho']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['SalePercent']) . "%</td>";
                                    echo "<td>" . htmlspecialchars($product['CreatedAt']) . "</td>";
                                    echo "<td>
                                        <a href='./addupdate.php' class='btn btn-success btn-sm'>Thêm</a>
                                        <a href='./chucnang/delete_product.php?id=" . htmlspecialchars($product['ProductId']) . "' class='btn btn-danger btn-sm'>Xóa</a>
                                        <a href='./addupdate.php?id=" . htmlspecialchars($product['ProductId']) . "' class='btn btn-warning btn-sm'>Sửa</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='7'>Lỗi truy vấn: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Kết nối cơ sở dữ liệu thất bại</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require('includes/footer.php');
?>