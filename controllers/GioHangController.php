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
}
?>