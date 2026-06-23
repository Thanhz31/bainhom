<?php
require_once '../models/DonHangModel.php';

class DonHangController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        // Kiểm tra quyền truy cập
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
        $this->model = new DonHangModel($this->db);
    }

    // 1. Danh sách đơn hàng
    public function index() {
        $orders = $this->model->layTatCa();
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/index.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    // 2. Xem chi tiết và xử lý trạng thái
    public function chi_tiet() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=don_hang");
            exit();
        }
        
        $order_id = intval($_GET['id']);
        
        // Cập nhật trạng thái
        if (isset($_POST['update_status'])) {
            $status = intval($_POST['status']);
            $this->model->capNhatTrangThai($order_id, $status);
            // Hoàn kho nếu hủy đơn
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

    // 3. Xử lý hoàn tiền
    public function xuLyHoanTien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $order_id = intval($_POST['order_id']);
            $amount = floatval($_POST['amount']);
            $reason = trim($_POST['reason']);

            if ($this->model->xuLyHoanTien($order_id, $amount, $reason)) {
                header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id&msg=success");
            } else {
                header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id&msg=error");
            }
            exit();
        }
    }

    // 4. Dashboard & Tìm kiếm
    public function tim_kiem() {
        // Lấy dữ liệu cho Dashboard
        $revenue = $this->model->tinhTongDoanhThu();
        $pending = $this->model->demDonChoDuyet();
        $years = $this->model->layCacNamCoDoanhThu();

        $orders = [];
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $orders = $this->model->timKiemDonHangAdmin(trim($_GET['keyword']));
        }

        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/bang_dieu_khien.php'; 
        require_once '../views/dung_chung/admin_footer.php';
    }
}
?>