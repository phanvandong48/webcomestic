<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Xử lý yêu cầu OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/Database.php';

class Product
{
    private $db;

    public function __construct()
    {
        // Lấy kết nối từ Database::getConnect()
        $this->db = Database::getConnect();
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts($limit = 10, $offset = 0)
    {
        $query = "SELECT * FROM products LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($productId)
    {
        $query = "SELECT * FROM Products WHERE ProductID = :productId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm sản phẩm với các bộ lọc
    public function searchProducts($keyword, $categories, $brands, $minPrice, $maxPrice, $offset = 0, $perPage = 12)
    {
        $query = "SELECT * FROM products WHERE 1 ";

        if (!empty($keyword)) {
            $query .= "AND TenSanPham LIKE :keyword ";
        }
        if (!empty($categories)) {
            $categoryList = implode(',', array_map('intval', $categories));
            $query .= "AND CategoryId IN ($categoryList) ";
        }
        if (!empty($brands)) {
            $brandList = implode(',', array_map('intval', $brands));
            $query .= "AND BrandId IN ($brandList) ";
        }
        if ($minPrice >= 0 && $maxPrice > 0) {
            $query .= "AND Gia BETWEEN :minPrice AND :maxPrice ";
        }

        // Thêm LIMIT để phân trang
        $query .= "LIMIT :offset, :perPage";

        // Chuẩn bị câu lệnh
        $stmt = $this->db->prepare($query);

        // Gán giá trị tham số
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        }
        if ($minPrice >= 0 && $maxPrice > 0) {
            $stmt->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
            $stmt->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);

        // Thực thi câu lệnh
        $stmt->execute();

        // Lấy kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm lấy danh sách categories
    public function getCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->prepare($sql);  // Sử dụng $this->db thay vì $this->conn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm lấy danh sách brands
    public function getBrands()
    {
        $sql = "SELECT * FROM brands";
        $stmt = $this->db->prepare($sql);  // Sử dụng $this->db thay vì $this->conn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countProducts($keyword, $categories, $brands, $minPrice, $maxPrice)
    {
        $query = "SELECT COUNT(*) AS total FROM products WHERE 1 ";

        if (!empty($keyword)) {
            $query .= "AND TenSanPham LIKE :keyword ";
        }
        if (!empty($categories)) {
            $categoryList = implode(',', array_map('intval', $categories));
            $query .= "AND CategoryId IN ($categoryList) ";
        }
        if (!empty($brands)) {
            $brandList = implode(',', array_map('intval', $brands));
            $query .= "AND BrandId IN ($brandList) ";
        }
        if ($minPrice >= 0 && $maxPrice > 0) {
            $query .= "AND Gia BETWEEN :minPrice AND :maxPrice ";
        }

        // Chuẩn bị câu lệnh
        $stmt = $this->db->prepare($query);

        // Gán giá trị tham số nếu có
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        }
        if ($minPrice >= 0 && $maxPrice > 0) {
            $stmt->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
            $stmt->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
        }

        // Thực thi truy vấn
        $stmt->execute();

        // Lấy kết quả
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}

// Khởi tạo đối tượng Product
$product = new Product();

// Lấy tất cả sản phẩm
$allProducts = $product->getAllProducts();
