<?php
// Gọi model vào
require_once '../models/DonHangModel.php';

class DonHangController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        
        // Lấy action hiện tại (nếu không truyền mặc định là index)
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        // =====================================
        // PHÂN LUỒNG KIỂM TRA QUYỀN TRUY CẬP
        // =====================================
        if ($action == 'chi_tiet_don_hang') {
            // Dành cho khách hàng xem hóa đơn: Chỉ cần đăng nhập tài khoản thường
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?controller=tai_khoan&action=dang_nhap");
                exit();
            }
        } else {
            // Dành cho Admin (index, chi_tiet, tim_kiem): Bắt buộc phải là Admin
            if (!isset($_SESSION['admin_user'])) {
                header("Location: index.php?controller=tai_khoan&action=dang_nhap");
                exit();
            }
        }

        // Khởi tạo Model dùng chung
        $this->model = new DonHangModel($this->db);
    }

    public function index() {
        // Lấy danh sách qua Model
        $orders = $this->model->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/index.php'; // Giao diện danh sách đơn
        require_once '../views/dung_chung/admin_footer.php';
    }

    // Xem chi tiết & Cập nhật trạng thái (Dành cho Admin)
    public function chi_tiet() {
        $order_id = intval($_GET['id']);
        
       if (isset($_POST['update_status'])) {
            $status = $_POST['status'];
            
            // 1. Cập nhật trạng thái qua Model
            $this->model->capNhatTrangThai($order_id, $status);

            // 2. LOGIC HOÀN KHO: Nếu trạng thái là 3 (Hủy đơn) thì gọi hàm hoàn kho
            // 2. XỬ LÝ LOGIC KHI HỦY ĐƠN (STATUS = 3)
if ($status == 3) 
    {
    // A. Hoàn lại kho
    $this->model->hoanLaiKho($order_id);

    // B. Kiểm tra và Hoàn tiền (Nếu đã thanh toán online)
    $order_info = $this->model->layTheoId($order_id);
    
    // Nếu đơn hàng đã thanh toán (payment_status == 1), chuyển sang hoàn tiền (2)
    if ($order_info['payment_status'] == 1) {
        $this->model->capNhatThanhToan($order_id, 2); 
    }
}
            // 3. Load lại trang
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

    // TÌM KIẾM ĐƠN HÀNG NGAY TRÊN DASHBOARD (Dành cho Admin)
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

    // ==========================================
    // KHÁCH HÀNG: Xem chi tiết hóa đơn của mình
    // ==========================================
    public function chi_tiet_don_hang() {
        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Gọi dữ liệu thông qua $this->model đã khởi tạo ở __construct
        $order_info = $this->model->layTheoId($order_id);

        // BẢO MẬT: Kiểm tra đơn hàng có tồn tại và PHẢI CỦA KHÁCH HÀNG ĐANG ĐĂNG NHẬP KHÔNG
        if (!$order_info || $order_info['user_id'] != $_SESSION['user']['id']) {
            echo "<script>alert('Bạn không có quyền xem hóa đơn này!'); window.location.href='index.php?controller=tai_khoan&action=don_hang';</script>";
            exit();
        }

        // Lấy danh sách sản phẩm trong hóa đơn
        $details = $this->model->layChiTietDonHang($order_id);

        // Gọi View hiển thị
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/chi_tiet_don_hang.php'; 
        require_once '../views/dung_chung/footer.php';
    }
}
?>