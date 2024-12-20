<?php
require('includes/header.php');
?>

<div>
    <h3>Danh sách thương hiệu</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách thương hiệu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Cột Actions cho nút xóa -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Brand</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Cột Actions cho nút xóa -->
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        require('../config/Database.php');
                        $conn = Database::getConnect();

                        if ($conn) {
                            try {
                                $sql_str = "SELECT BrandId, BrandName, Description, CreatedAt FROM brands ORDER BY BrandName";
                                $stmt = $conn->prepare($sql_str);
                                $stmt->execute();
                                $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($brands as $brand) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($brand['BrandName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($brand['Description'] ?? 'Không có mô tả') . "</td>";
                                    echo "<td>" . htmlspecialchars($brand['CreatedAt']) . "</td>";
                                    echo "<td><a href='../admin/chucnang/delete_brand.php?delete=" . $brand['BrandId'] . "' class='btn btn-danger btn-sm'>Xóa</a></td>"; // Nút xóa
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='4'>Lỗi truy vấn: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Kết nối cơ sở dữ liệu thất bại</td></tr>";
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