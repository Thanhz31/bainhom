<?php
// Gọi model vào để sử dụng
require_once '../models/DonHangModel.php';
require_once '../models/SanPhamModel.php'; // Bổ sung Model Sản Phẩm

class QuanTriController {
    private $db;
    private $donHangModel;
    private $sanPhamModel; // Thêm biến

    public function __construct() {
        $this->db = (new Database())->getConnection();
        
        // Kiểm tra quyền truy cập Admin
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
        
        // Khởi tạo Model
        $this->donHangModel = new DonHangModel($this->db);
        $this->sanPhamModel = new SanPhamModel($this->db); // Khởi tạo
    }

    public function index() {
        // 1. Tổng doanh thu 
        $revenue = $this->donHangModel->tinhTongDoanhThu();

        // 2. Đếm số đơn chờ duyệt 
        $pending = $this->donHangModel->demDonChoDuyet();

        // 3. Đếm tổng số sản phẩm (MỚI THÊM)
        $total_products = $this->sanPhamModel->demTongSanPham();

        // 4. Danh sách đơn hàng mới nhất 
        $orders = $this->donHangModel->layTatCa();

        // Gọi View để hiển thị
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/bang_dieu_khien.php';
        require_once '../views/dung_chung/admin_footer.php';
    }
}
?>