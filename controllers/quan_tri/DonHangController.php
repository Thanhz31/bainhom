<?php
// Gọi model vào
require_once '../models/DonHangModel.php';

class DonHangController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        
        // Lấy action hiện tại
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        // =====================================
        // PHÂN LUỒNG KIỂM TRA QUYỀN TRUY CẬP
        // =====================================
        $allowed_for_customers = ['chi_tiet_don_hang', 'huy_don'];

        if (in_array($action, $allowed_for_customers)) {
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?controller=tai_khoan&action=dang_nhap");
                exit();
            }
        } else {
            if (!isset($_SESSION['admin_user'])) {
                header("Location: index.php?controller=tai_khoan&action=dang_nhap");
                exit();
            }
        }

        $this->model = new DonHangModel($this->db);
    }

    public function index() {
        $orders = $this->model->layTatCa();
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/index.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    // Xem chi tiết & Cập nhật trạng thái/Thanh toán (Dành cho Admin)
    public function chi_tiet() {
        $order_id = intval($_GET['id']);
        
        // 1. XỬ LÝ XÁC NHẬN THANH TOÁN THỦ CÔNG
        if (isset($_POST['xac_nhan_thanh_toan'])) {
            // 1: Đã thanh toán
            $this->model->capNhatTrangThaiThanhToan($order_id, 1);
            header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id&msg=success");
            exit();
        }

        // 2. XỬ LÝ CẬP NHẬT TRẠNG THÁI GIAO HÀNG
        if (isset($_POST['update_status'])) {
            $status = $_POST['status'];
            $this->model->capNhatTrangThai($order_id, $status);

            if ($status == 3) {
                $this->model->hoanLaiKho($order_id);
            }

            header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id");
            exit();
        }

        $order_info = $this->model->layTheoId($order_id);
        $details = $this->model->layChiTietDonHang($order_id);
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/chi_tiet.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    public function tim_kiem() {
        $revenue = $this->model->tinhTongDoanhThu();
        $pending = $this->model->demDonChoDuyet();

        $orders = [];
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $tu_khoa = trim($_GET['keyword']);
            $orders = $this->model->timKiemDonHangAdmin($tu_khoa);
        }

        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/bang_dieu_khien.php'; 
        require_once '../views/dung_chung/admin_footer.php';
    }

    public function chi_tiet_don_hang() {
        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $order_info = $this->model->layTheoId($order_id);

        if (!$order_info || $order_info['user_id'] != $_SESSION['user']['id']) {
            echo "<script>alert('Bạn không có quyền xem hóa đơn này!'); window.location.href='index.php?controller=tai_khoan&action=don_hang';</script>";
            exit();
        }

        $details = $this->model->layChiTietDonHang($order_id);
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/chi_tiet_don_hang.php'; 
        require_once '../views/dung_chung/footer.php';
    }

    public function huy_don() {
        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $order = $this->model->layTheoId($order_id);

        if ($order && $order['user_id'] == $_SESSION['user']['id'] && $order['status'] == 0) {
            $this->model->capNhatTrangThai($order_id, 3);
            $this->model->hoanLaiKho($order_id);
            
            if ($order['payment_status'] == 1) {
                $this->model->capNhatTrangThaiThanhToan($order_id, 2); // 2: Đã hoàn tiền
            }

            echo "<script>alert('Đơn hàng đã được hủy thành công!'); window.location.href='index.php?controller=don_hang&action=chi_tiet_don_hang&id=$order_id';</script>";
        } else {
            echo "<script>alert('Không thể hủy đơn hàng này!'); window.location.href='index.php?controller=tai_khoan&action=don_hang';</script>";
        }
    }
}
?>