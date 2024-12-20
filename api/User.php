<?php 
function themNguoiDung($tenNguoiDung, $matKhau, $email, $quyen) {
    try {
        // Kết nối cơ sở dữ liệu
        $dsn = 'mysql:host=127.0.0.1;dbname=doancn;charset=utf8mb4';
        $username = 'root'; // Thay bằng tài khoản MySQL của bạn
        $password = ''; // Thay bằng mật khẩu MySQL của bạn
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // Hash mật khẩu
        $hashedPassword = password_hash($matKhau, PASSWORD_BCRYPT);

        // Câu lệnh SQL thêm người dùng
        $sql = "INSERT INTO users (TenNguoiDung, MatKhau, Email, quyen) 
                VALUES (:tenNguoiDung, :matKhau, :email,  :quyen)";
        $stmt = $pdo->prepare($sql);

        // Thực thi câu lệnh
        $stmt->execute([
            ':tenNguoiDung' => $tenNguoiDung,
            ':matKhau' => $hashedPassword,
            ':email' => $email,
           
            ':quyen' => $quyen,
        ]);

        return "Thêm người dùng thành công!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            return "Tên người dùng hoặc email đã tồn tại.";
        }
        return "Lỗi: " . $e->getMessage();
    }
}

?>