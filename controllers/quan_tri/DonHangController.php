<?php
require_once '../models/DonHangModel.php';

class DonHangController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
<<<<<<< HEAD
        
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
=======
        // Kiểm tra quyền truy cập
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
>>>>>>> 29f501d389f1b6015ad7f032558dbb031ba77d98
        $this->model = new DonHangModel($this->db);
    }

    // 1. Danh sách đơn hàng
    public function index() {
        $orders = $this->model->layTatCa();
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/index.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

<<<<<<< HEAD
    // Xem chi tiết & Cập nhật trạng thái (Dành cho Admin)
=======
    // 2. Xem chi tiết và xử lý trạng thái
>>>>>>> 29f501d389f1b6015ad7f032558dbb031ba77d98
    public function chi_tiet() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=don_hang");
            exit();
        }
        
        $order_id = intval($_GET['id']);
        
<<<<<<< HEAD
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
=======
        // Cập nhật trạng thái
        if (isset($_POST['update_status'])) {
            $status = intval($_POST['status']);
            $this->model->capNhatTrangThai($order_id, $status);
            // Hoàn kho nếu hủy đơn
            if ($status == 3) {
                $this->model->hoanLaiKho($order_id);
            }
>>>>>>> 29f501d389f1b6015ad7f032558dbb031ba77d98
            header("Location: index.php?controller=don_hang&action=chi_tiet&id=$order_id");
            exit();
        }

        $order_info = $this->model->layTheoId($order_id);
        $details = $this->model->layChiTietDonHang($order_id);
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/don_hang/chi_tiet.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

<<<<<<< HEAD
    // TÌM KIẾM ĐƠN HÀNG NGAY TRÊN DASHBOARD (Dành cho Admin)
    public function tim_kiem() {
=======
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
>>>>>>> 29f501d389f1b6015ad7f032558dbb031ba77d98
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