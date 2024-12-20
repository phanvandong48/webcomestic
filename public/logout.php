<?php
// Bắt đầu session (nếu bạn sử dụng session để lưu trữ thông tin)
session_start();

// Xóa cookie (ví dụ: xóa cookie 'username')
setcookie('username', '', time() - 3600, '/'); // Đặt thời gian hết hạn về 1 giờ trước

// Nếu bạn sử dụng session, có thể xóa session
session_destroy(); // Xóa tất cả dữ liệu session

// Sau khi xóa cookie và session, bạn có thể chuyển hướng người dùng đến trang đăng nhập hoặc trang khác
header("Location: login.php"); // Chuyển hướng người dùng về trang đăng nhập
exit();
