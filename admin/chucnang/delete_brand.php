<?php
require('../../config/Database.php');

if (isset($_GET['delete'])) {
    $brandId = $_GET['delete'];

    // Kết nối đến cơ sở dữ liệu
    $conn = Database::getConnect();

    if ($conn) {
        try {
            // Câu lệnh SQL để xóa thương hiệu
            $sql_delete = "DELETE FROM brands WHERE BrandId = :brandId";
            $stmt = $conn->prepare($sql_delete);
            $stmt->bindParam(':brandId', $brandId, PDO::PARAM_INT);
            $stmt->execute();

            // Chuyển hướng trở lại danh sách sau khi xóa
            header('Location: ../listbrands.php');
            exit;
        } catch (PDOException $e) {
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Kết nối cơ sở dữ liệu thất bại!";
    }
} else {
    echo "Không có thương hiệu nào để xóa!";
}
