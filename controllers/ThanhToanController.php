<?php
require_once '../services/GioHangComponent.php';
require_once '../services/DonHangComponent.php';

class ThanhToanController {
    private $gioHangService;
    private $donHangService;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->gioHangService = new GioHangComponent();
        $this->donHangService = new DonHangComponent($this->db);
    }

    // Xử lý khi nhấn nút Đặt hàng
    public function dat_hang() {
        if (isset($_POST['order'])) {
            $cart = $this->gioHangService->layGioHang();
            
            // ĐÃ THÊM: Bắt dữ liệu payment_method từ Form giỏ hàng gửi sang
            $payment_method = isset($_POST['payment_method']) ? (int)$_POST['payment_method'] : 1;

            $khach = [
                'user_id' => isset($_SESSION['user']) ? $_SESSION['user']['id'] : null,
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'total' => $_POST['total'],
                'payment_method' => $payment_method // ĐÃ THÊM: Truyền dữ liệu này vào mảng $khach
            ];

            $order_id = $this->donHangService->thanhToan($khach, $cart);

            if ($order_id) {
                $this->gioHangService->lamTrongGio();
                echo "<script>alert('Đặt hàng thành công! Mã đơn: #$order_id'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi đặt hàng!'); window.history.back();</script>";
            }
        }
    }
}
?>