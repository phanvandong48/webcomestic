<?php
require('../../config/Database.php');

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    try {
        $conn = Database::getConnect();
        if ($conn) {
            $sql_str = "DELETE FROM categories WHERE CategoryId = :CategoryId";
            $stmt = $conn->prepare($sql_str);
            $stmt->bindParam(':CategoryId', $categoryId);
            $stmt->execute();
            header("Location: ../listcats.php"); // Redirect back to the category list
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
