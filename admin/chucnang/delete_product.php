<?php
require('../../config/Database.php');

// Kiểm tra xem ID có được truyền vào không
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    $conn = Database::getConnect();
    if ($conn) {
        try {
            // Thực hiện xóa sản phẩm
            $sql_str = "DELETE FROM products WHERE ProductId = :id";
            $stmt = $conn->prepare($sql_str);
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            // Kiểm tra số dòng bị ảnh hưởng
            if ($stmt->rowCount() > 0) {
                echo "Sản phẩm đã được xóa thành công.";
            } else {
                echo "Không tìm thấy sản phẩm để xóa.";
            }
        } catch (PDOException $e) {
            echo "Lỗi khi xóa sản phẩm: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Kết nối cơ sở dữ liệu thất bại.";
    }
} else {
    echo "Không có ID sản phẩm được truyền vào.";
}
header("Location: ../listsanpham.php");
exit();
