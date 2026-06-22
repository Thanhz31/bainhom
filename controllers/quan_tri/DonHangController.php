<?php
// Gọi model vào
require_once '../models/DonHangModel.php';

class DonHangController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
        // Khởi tạo Model
        $this->model = new DonHangModel($this->db);
    }

    public function index() {
        // Lấy danh sách qua Model
        $orders = $this->model->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/index.php'; // Giao diện danh sách đơn
        require_once '../views/dung_chung/admin_footer.php';
    }

    // Xem chi tiết & Cập nhật trạng thái
    public function chi_tiet() {
        $order_id = intval($_GET['id']);
        
        if (isset($_POST['update_status'])) {
            $status = $_POST['status'];
            // Cập nhật qua Model
            $this->model->capNhatTrangThai($order_id, $status);
            header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id");
            exit();
        }

        // Lấy thông tin qua Model
        $order_info = $this->model->layTheoId($order_id);
        $details = $this->model->layChiTietDonHang($order_id);
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/chi_tiet.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    // ==========================================
    // TÌM KIẾM ĐƠN HÀNG NGAY TRÊN DASHBOARD
    // ==========================================
    public function tim_kiem() {
        // 1. Lấy dữ liệu Thống kê qua Model
        $revenue = $this->model->tinhTongDoanhThu();
        $pending = $this->model->demDonChoDuyet();

        // 2. Lọc đơn hàng theo từ khóa qua Model
        $orders = [];
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $tu_khoa = trim($_GET['keyword']);
            $orders = $this->model->timKiemDonHangAdmin($tu_khoa);
        }

        // 3. Gọi thẳng giao diện Dashboard (bang_dieu_khien.php) ra để hiển thị
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/bang_dieu_khien.php'; 
        require_once '../views/dung_chung/admin_footer.php';
    }
}
?>