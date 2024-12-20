<?php
require_once '../models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        // Khởi tạo model Product để truy xuất dữ liệu
        $this->productModel = new Product();
    }

    // Hiển thị tất cả sản phẩm
    public function showProducts()
    {
        $allProducts = $this->productModel->getAllProducts();
        include '../views/productList.php';  // Truyền dữ liệu vào view
    }

    // Hiển thị chi tiết sản phẩm
    public function showProduct($productId)
    {
        $product = $this->productModel->getProductById($productId);
        if ($product) {
            echo json_encode($product, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["message" => "Product not found"]);
        }
    }

    // Thêm sản phẩm mới
    public function createProduct($data)
    {
        $tenSanPham = $data['tenSanPham'];
        $moTa = $data['moTa'];
        $gia = $data['gia'];
        $soLuongTonKho = $data['soLuongTonKho'];

        $result = $this->productModel->createProduct($tenSanPham, $moTa, $gia, $soLuongTonKho);

        if ($result) {
            echo json_encode(["message" => "Product created successfully"]);
        } else {
            echo json_encode(["message" => "Product creation failed"]);
        }
    }

    // Cập nhật sản phẩm
    public function updateProduct($productId, $data)
    {
        $tenSanPham = $data['tenSanPham'];
        $moTa = $data['moTa'];
        $gia = $data['gia'];
        $soLuongTonKho = $data['soLuongTonKho'];

        $result = $this->productModel->updateProduct($productId, $tenSanPham, $moTa, $gia, $soLuongTonKho);

        if ($result) {
            echo json_encode(["message" => "Product updated successfully"]);
        } else {
            echo json_encode(["message" => "Product update failed"]);
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($productId)
    {
        $result = $this->productModel->deleteProduct($productId);

        if ($result) {
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["message" => "Product deletion failed"]);
        }
    }
}
