<?php
include "../include/header.php";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form liên hệ</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>

<body>

    <h2 style="text-align: center;">Liên hệ với chúng tôi</h2>

    <form action="../api/send_contact.php" method="POST" id="contact-form">
        <label for="name">Tên:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone">

        <label for="message">Nội dung:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Gửi</button>
    </form>

    <!-- Khu vực hiển thị thông báo trạng thái -->
    <div id="response-message" style="display: none; margin-top: 20px; text-align: center;"></div>


    <script>
        // Xử lý form gửi mà không tải lại trang
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngừng tải lại trang

            var formData = new FormData(this);

            // Gửi dữ liệu bằng fetch
            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Chuyển đổi phản hồi thành JSON
                .then(data => {
                    var responseMessage = document.getElementById('response-message');
                    responseMessage.style.display = 'block'; // Hiển thị thông báo

                    if (data.status === 'success') {
                        responseMessage.innerHTML = '<p style="color: green; font-size: 18px;">' + data.message + '</p>';
                    } else {
                        responseMessage.innerHTML = '<p style="color: red; font-size: 18px;">' + data.message + '</p>';
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        });
    </script>


</body>

<?php
include "../include/footer.php";
?>

</html>