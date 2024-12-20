<?php
class Database
{
    private static $host = "localhost";
    private static $db_name = "doancn";
    private static $username = "root";
    private static $password = "";

    private static $conn;

    public static function getConnect()
    {
        try {
            // Kiểm tra xem kết nối đã tồn tại chưa
            if (self::$conn === NULL) {
                // Thiết lập kết nối
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$conn->exec("set names utf8"); // Đảm bảo sử dụng đúng bộ mã hóa
            }
            return self::$conn;
        } catch (PDOException $exception) {
            // Xử lý khi kết nối thất bại
            echo "Kết nối thất bại: " . $exception->getMessage();
            return null;
        }
    }
}
