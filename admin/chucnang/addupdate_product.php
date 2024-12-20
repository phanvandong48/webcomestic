<?php
require('../../config/Database.php');
$conn = Database::getConnect();

// Kiểm tra dữ liệu từ form
var_dump($_POST);

if ($conn && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $productId = isset($_POST['ProductId']) ? intval($_POST['ProductId']) : 0;
    $tenSanPham = isset($_POST['TenSanPham']) ? $_POST['TenSanPham'] : '';
    $gia = isset($_POST['Gia']) ? floatval($_POST['Gia']) : 0;
    $soLuongTonKho = isset($_POST['SoLuongTonKho']) ? intval($_POST['SoLuongTonKho']) : 0;
    $salePercent = isset($_POST['SalePercent']) ? intval($_POST['SalePercent']) : 0;
    $categoryId = isset($_POST['CategoryId']) ? intval($_POST['CategoryId']) : 0;
    $brandId = isset($_POST['BrandId']) ? intval($_POST['BrandId']) : 0;
    $hinh = '';  // Khởi tạo giá trị hình ảnh rỗng

    // Xử lý upload hình ảnh nếu có
    if (!empty($_FILES['hinh']['name'])) {
        $uploadDir = '../img/';
        $fileName = time() . '_' . basename($_FILES['hinh']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Kiểm tra thư mục upload có quyền ghi
        if (!is_writable($uploadDir)) {
            echo "Không có quyền ghi vào thư mục uploads!";
            exit;
        }

        // Di chuyển file từ tạm thời tới thư mục uploads
        if (move_uploaded_file($_FILES['hinh']['tmp_name'], $uploadFile)) {
            $hinh = $fileName;  // Lưu tên file hình ảnh
        } else {
            echo "Lỗi khi upload file: " . $_FILES['hinh']['error'];
            exit;
        }
    }

    // Chuẩn bị câu lệnh SQL
    if ($productId > 0) {
        // Cập nhật sản phẩm
        $sql = "UPDATE products SET TenSanPham = :TenSanPham, Gia = :Gia, SoLuongTonKho = :SoLuongTonKho, SalePercent = :SalePercent, CategoryId = :CategoryId, BrandId = :BrandId, hinh = :hinh WHERE ProductId = :ProductId";
    } else {
        // Thêm sản phẩm mới
        $sql = "INSERT INTO products (TenSanPham, Gia, SoLuongTonKho, SalePercent, CategoryId, BrandId, hinh) VALUES (:TenSanPham, :Gia, :SoLuongTonKho, :SalePercent, :CategoryId, :BrandId, :hinh)";
    }

    try {
        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':TenSanPham', $tenSanPham);
        $stmt->bindParam(':Gia', $gia);
        $stmt->bindParam(':SoLuongTonKho', $soLuongTonKho);
        $stmt->bindParam(':SalePercent', $salePercent);
        $stmt->bindParam(':CategoryId', $categoryId);
        $stmt->bindParam(':BrandId', $brandId);

        // Chỉ gán giá trị hình ảnh nếu có
        if (!empty($hinh)) {
            $stmt->bindParam(':hinh', $hinh);
        } else {
            $stmt->bindValue(':hinh', null, PDO::PARAM_NULL); // Nếu không có hình ảnh, gán giá trị null
        }

        // Nếu đang cập nhật (sửa sản phẩm), truyền thêm ProductId vào câu lệnh
        if ($productId > 0) {
            $stmt->bindParam(':ProductId', $productId, PDO::PARAM_INT);
        }

        // Thực thi câu lệnh SQL
        $stmt->execute();

        // Chuyển hướng sau khi hoàn thành (thành công)
        header("Location: ../listsanpham.php?message=success");
        exit; // Thêm exit để ngừng thực thi sau khi chuyển hướng

    } catch (PDOException $e) {
        // Bắt lỗi và hiển thị thông báo lỗi
        echo "Lỗi: " . $e->getMessage();
        exit;
    }
} else {
    // Nếu không phải POST hoặc không kết nối được CSDL, chuyển hướng về danh sách sản phẩm
    header("Location: ../listsanpham.php?message=invalid");
    exit;
}
