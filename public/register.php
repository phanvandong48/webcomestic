<?php
// Biến lưu lỗi
$errors = [
    'username' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => ''
];

// Kiểm tra khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kiểm tra tên đăng nhập
    if (empty($username)) {
        $errors['username'] = 'Tên đăng nhập không được để trống.';
    }

    // Kiểm tra email
    if (empty($email)) {
        $errors['email'] = 'Email không được để trống.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }

    // Kiểm tra mật khẩu
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (empty($password)) {
        $errors['password'] = 'Mật khẩu không được để trống.';
    } elseif (!preg_match($passwordRegex, $password)) {
        $errors['password'] = 'Mật khẩu phải từ 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.';
    }

    // Kiểm tra nhập lại mật khẩu
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Mật khẩu không khớp.';
    }

    // Nếu không có lỗi, xử lý logic đăng ký
    if (!array_filter($errors)) {
        include "../api/User.php";
        $ketQua = themNguoiDung($username, $password, $email, 1);
        if (strpos($ketQua, "Thêm người dùng thành công!") !== false) {
            echo '<script>alert("Đăng ký thành công!");</script>';
        } else {
            echo '<script>alert("' . htmlspecialchars($ketQua) . '");</script>';
        }
    } else {
        echo '<script>alert("Đăng ký thất bại. Vui lòng kiểm tra lại thông tin!");</script>';
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
    <title>Form Đăng Ký</title>
    <link rel="stylesheet" href="../assets/css/logout.css">

</head>

<body>
    <div class="containerr">
        <form class="register-form" method="POST" action="">
            <h2>Đăng Ký</h2>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <div class="error"><?= $errors['username'] ?></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div class="error"><?= $errors['email'] ?></div>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password">
                <div class="error"><?= $errors['password'] ?></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Nhập lại mật khẩu</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <div class="error"><?= $errors['confirmPassword'] ?></div>
            </div>
            <div class="form-group">
                <button type="submit">Đăng Ký</button>
            </div>
            <div>
                Nếu bạn đã có tài khoản <a href="./login.php">Đăng nhập</a>

            </div>
        </form>
    </div>
</body>
<?php include "../include/footer.php" ?>

</html>