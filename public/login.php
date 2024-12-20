<?php
session_start(); // Thêm dòng này ở đầu file PHP

// Biến lưu lỗi
$errors = [
    'username' => '',
    'password' => ''
];

// Kiểm tra khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xóa cookie 'username'

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Kiểm tra username
    if (empty($username)) {
        $errors['username'] = 'Tên đăng nhập không được để trống.';
    }

    // Kiểm tra password
    if (empty($password)) {
        $errors['password'] = 'Mật khẩu không được để trống.';
    }

    // Nếu không có lỗi, tiến hành kiểm tra đăng nhập
    if (!array_filter($errors)) {
        try {
            // Kết nối cơ sở dữ liệu
            $dsn = 'mysql:host=127.0.0.1;dbname=doancn;charset=utf8mb4';
            $dbUsername = 'root'; // Tên tài khoản MySQL
            $dbPassword = ''; // Mật khẩu MySQL
            $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Truy vấn lấy thông tin người dùng
            // $sql = "SELECT MatKhau FROM users WHERE TenNguoiDung = :username";
            $sql = "SELECT MatKhau, quyen, TenNguoiDung FROM users WHERE TenNguoiDung = :username";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $username]);

            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['MatKhau'])) {
                // $_SESSION['username'] = $user["TenNguoiDung"];  // Lưu tên đăng nhập vào session
                // Lưu thông tin người dùng vào cookie
                setcookie('username', $username, time() + 3600, '/', '', true, true); // Thời gian sống 1 giờ

                echo '<script>alert("Đăng nhập thành công!");</script>';
                if ($user["quyen"] == 1)
                    header("Location: index.php");
                if ($user["quyen"] == 0) {
                    header("Location: ../admin/");
                } // Chuyển hướng đến trang khác

                exit;
            } else {
                $errors['password'] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
            }
        } catch (PDOException $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }
}
?>
<?php
include '../include/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Nhập</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <div class="containerr">
        <form class="login-form" method="POST" action="">
            <h2>Đăng Nhập</h2>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <div class="error"><?= $errors['username'] ?></div>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password">
                <div class="error"><?= $errors['password'] ?></div>
            </div>
            <div class="form-group">
                <button type="submit">Đăng Nhập</button>
            </div>
            <div>
                Nếu bạn chưa có tài khoản <a href="./register.php">Đăng ký</a>
            </div>
        </form>
    </div>
</body>
<?php include "../include/footer.php" ?>

</html>