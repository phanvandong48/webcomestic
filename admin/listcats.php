<?php
require('includes/header.php');
?>

<div>
    <h3>Danh sách danh mục</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Thêm cột Actions để chứa nút Xóa -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Thêm cột Actions để chứa nút Xóa -->
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        require('../config/Database.php');
                        $conn = Database::getConnect();

                        if ($conn) {
                            try {
                                $sql_str = "SELECT CategoryId, CategoryName, Description, CreatedAt FROM categories ORDER BY CategoryName";
                                $stmt = $conn->prepare($sql_str);
                                $stmt->execute();
                                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($categories as $category) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($category['CategoryName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($category['Description'] ?? 'Không có mô tả') . "</td>";
                                    echo "<td>" . htmlspecialchars($category['CreatedAt']) . "</td>";
                                    // Thêm cột Xóa
                                    echo "<td><a href='../../demo/admin/chucnang/delete_category.php?id=" . $category['CategoryId'] . "' class='btn btn-danger btn-sm'>Xóa</a></td>";
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