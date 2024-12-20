<?php
require('../../config/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['CategoryName'];
    $description = $_POST['Description'] ?? null;

    // Kiểm tra nếu tên danh mục rỗng
    if (empty($categoryName)) {
        echo "Tên danh mục không được để trống.";
        exit;
    }

    try {
        $conn = Database::getConnect();
        if ($conn) {
            $sql_str = "INSERT INTO categories (CategoryName, Description) VALUES (:CategoryName, :Description)";
            $stmt = $conn->prepare($sql_str);
            $stmt->bindParam(':CategoryName', $categoryName);
            $stmt->bindParam(':Description', $description);

            if ($stmt->execute()) {
                header("Location: ../listcats.php"); // Chuyển hướng về danh sách danh mục
                exit;
            } else {
                echo "Lỗi khi thực thi truy vấn.";
            }
        } else {
            echo "Không thể kết nối với cơ sở dữ liệu.";
        }
    } catch (PDOException $e) {
        echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
    }
}
