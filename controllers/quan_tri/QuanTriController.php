<?php
// Gọi model vào để sử dụng
require_once '../models/DonHangModel.php';
require_once '../models/SanPhamModel.php'; 

class QuanTriController {
    private $db;
    private $donHangModel;
    private $sanPhamModel; 

    public function __construct() {
        $this->db = (new Database())->getConnection();
        
        // Kiểm tra quyền truy cập Admin
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
        
        // Khởi tạo Model
        $this->donHangModel = new DonHangModel($this->db);
        $this->sanPhamModel = new SanPhamModel($this->db); 
    }

    public function index() {
        // 1. Tổng doanh thu và thống kê 
        $revenue = $this->donHangModel->tinhTongDoanhThu();
        $pending = $this->donHangModel->demDonChoDuyet();
        $total_products = $this->sanPhamModel->demTongSanPham();

        // 2. Bắt năm được chọn từ Form (nếu không có thì lấy năm hiện tại)
        $selected_year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        
        // Lấy danh sách các năm có doanh thu để hiển thị ra thẻ select
        $list_years = $this->donHangModel->layCacNamCoDoanhThu();

        // 3. Lấy dữ liệu Doanh thu truyền tham số năm
        $doanhThuRaw = $this->donHangModel->thongKeDoanhThuTheoThang($selected_year);
        $doanhThu12Thang = [];
        for ($i = 1; $i <= 12; $i++) {
            $doanhThu12Thang[] = isset($doanhThuRaw[$i]) ? (int)$doanhThuRaw[$i] : 0;
        }
        $doanhThuJson = json_encode($doanhThu12Thang);

        // 4. Lấy dữ liệu Trạng thái đơn hàng
        $trangThaiRaw = $this->donHangModel->thongKeTrangThaiDonHang();
        $trangThaiArr = [
            isset($trangThaiRaw[0]) ? $trangThaiRaw[0] : 0, 
            isset($trangThaiRaw[1]) ? $trangThaiRaw[1] : 0, 
            isset($trangThaiRaw[2]) ? $trangThaiRaw[2] : 0, 
            isset($trangThaiRaw[3]) ? $trangThaiRaw[3] : 0
        ];
        $trangThaiJson = json_encode($trangThaiArr);

        // Gọi View để hiển thị
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/bang_dieu_khien.php';
        require_once '../views/dung_chung/admin_footer.php';
    }
}
?>