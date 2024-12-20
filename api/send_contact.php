<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

$response = '';

try {
    if (isset($_POST['name']) && isset($_POST['email']) && !empty($_POST['name']) && !empty($_POST['email']) && isset($_POST['message']) && !empty($_POST['message'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $message = $_POST['message'];

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vanlongdh2@gmail.com';
        $mail->Password = 'bvvl whqe iqfm odjz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Gửi email cho admin
        $mail->setFrom($email, $name);
        $mail->addAddress('dong.yobo1@gmail.com', 'YOBO');
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = 'Liên hệ từ ' . $name;
        $mail->Body = 'Thông tin người gửi: <br>' .
            'Tên: ' . $name . '<br>' .
            'Email: ' . $email . '<br>' .
            'Số điện thoại: ' . $phone . '<br>' .
            'Nội dung: <br>' . nl2br($message);
        $mail->send();

        // Gửi email cảm ơn cho người gửi
        $mail->clearAddresses();
        $mail->addAddress($email, $name);
        $mail->Subject = 'Cảm ơn quý khách đã liên hệ với chúng tôi';
        $mail->Body = 'Kính gửi quý khách' . $name . ', <br>Chúng tôi chân thành cảm ơn quý khách đã liên hệ. Chúng tôi sẽ phản hồi lại trong thời gian sớm nhất. <br>
Trân trọng,<br>[Đội ngũ hỗ trợ khách hàng]';
        $mail->send();

        // Trả về thông báo thành công
        $response = ['status' => 'success', 'message' => 'Cảm ơn bạn! Email đã được gửi thành công và chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.'];
    } else {
        // Trả về thông báo lỗi nếu thiếu thông tin
        $response = ['status' => 'error', 'message' => 'Thiếu thông tin người gửi. Vui lòng nhập tên, email và nội dung.'];
    }
} catch (Exception $e) {
    // Trả về lỗi nếu có exception
    $response = ['status' => 'error', 'message' => 'Lỗi khi gửi email: ' . $e->getMessage()];
}

// Gửi phản hồi dưới dạng JSON
echo json_encode($response);
