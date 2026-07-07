<?php
require_once '../config/database.php'; 
require_once '../models/SanPhamModel.php';

class DanhGiaController {
    private $db;
    private $sanPhamModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->sanPhamModel = new SanPhamModel($this->db);
    }

    public function viet_danh_gia() {
        // SỬA LẠI: Kiểm tra theo biến $_SESSION['user'] khớp với TaiKhoanController
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit;
        }
        
        require_once '../views/dung_chung/header.php';
        require_once '../views/danh_gia/viet_danh_gia.php'; 
        require_once '../views/dung_chung/footer.php';
    }
    
    public function luu_danh_gia() {
        // SỬA LẠI: Kiểm tra theo biến $_SESSION['user']
        if (!isset($_SESSION['user'])) {
            exit("Vui lòng đăng nhập!");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = intval($_POST['product_id']);
            $order_id = intval($_POST['order_id']);
            $rating = intval($_POST['rating']);
            $comment = $_POST['comment'];
            // SỬA LẠI: Lấy ID từ mảng $_SESSION['user']['id']
            $user_id = $_SESSION['user']['id'];

            $result = $this->sanPhamModel->themDanhGia($product_id, $user_id, $order_id, $rating, $comment);

            if ($result) {
                echo "<script>
                    alert('Cảm ơn bạn đã đánh giá sản phẩm!'); 
                    window.location.href='index.php?controller=tai_khoan&action=chi_tiet_don_hang&id=$order_id';
                </script>";
            } else {
                echo "<script>
                    alert('Bạn đã đánh giá sản phẩm này rồi!'); 
                    window.location.href='index.php?controller=tai_khoan&action=chi_tiet_don_hang&id=$order_id';
                </script>";
            }
        }
    }
}
?>