<?php
require_once '../services/GioHangComponent.php';
require_once '../models/SanPhamModel.php';

class GioHangController {
    private $gioHangService;

    public function __construct() {
        $this->gioHangService = new GioHangComponent();
    }

    // Hiển thị trang giỏ hàng
    public function index() {
        $cart = $this->gioHangService->layGioHang();
        $total = $this->gioHangService->tinhTongTien();

        require_once '../views/dung_chung/header.php';
        require_once '../views/gio_hang/index.php';
        require_once '../views/dung_chung/footer.php';
    }

    // Thêm sản phẩm vào giỏ
    public function them() {
        if (isset($_POST['product_id'])) {
            $db = (new Database())->getConnection();
            $spModel = new SanPhamModel($db);
            $sp = $spModel->layTheoId($_POST['product_id']);
            
            if ($sp) {
                $qty = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
                $this->gioHangService->themMoi($sp['id'], $sp['name'], $sp['price'], $sp['image'], $qty);
            }
        }
        header("Location: index.php?controller=gio_hang");
    }

    // Xóa sản phẩm
    public function xoa() {
        $id = $_GET['id'];
        $this->gioHangService->xoaSanPham($id);
        header("Location: index.php?controller=gio_hang");
    }
    // ==========================================
    // [THÊM MỚI] Hàm cập nhật số lượng giỏ hàng
    // ==========================================
    public function cap_nhat() {
        if (isset($_POST['qty']) && is_array($_POST['qty'])) {
            // Duyệt qua mảng số lượng người dùng gửi lên
            foreach ($_POST['qty'] as $id => $quantity) {
                // Đảm bảo số lượng là số nguyên và lớn hơn 0
                $qty = intval($quantity);
                if ($qty > 0) {
                     // Nếu bạn đã viết sẵn hàm capNhat trong GioHangComponent thì dùng nó
                     // Ví dụ: $this->gioHangService->capNhat($id, $qty);
                     
                     // Hoặc cách phổ thông nếu không có hàm cập nhật riêng:
                     $_SESSION['cart'][$id]['qty'] = $qty;
                }
            }
        }
        // Quay lại trang giỏ hàng sau khi tính toán xong
        header("Location: index.php?controller=gio_hang");
        exit();
    }
}
?>