<?php
require('../../config/Database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['brandName'];
    $description = $_POST['description'];

    try {
        $conn = Database::getConnect();

        if ($conn) {
            $sql = "INSERT INTO brands (BrandName, Description) VALUES (:brandName, :description)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':brandName', $brandName);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
                header('Location: ../listbrands.php?success=true');
            } else {
                throw new Exception("Không thể thực hiện thao tác thêm thương hiệu.");
            }
        } else {
            throw new Exception("Kết nối cơ sở dữ liệu thất bại.");
        }
    } catch (PDOException $e) {
        echo "Lỗi PDO: " . $e->getMessage();
        header('Location: addBrand.php?error=true&message=' . urlencode($e->getMessage()));
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
        header('Location: addBrand.php?error=true&message=' . urlencode($e->getMessage()));
    }
}
