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
        
        // Danh sách các action mà khách hàng (user thường) được phép truy cập
        $allowed_for_customers = ['chi_tiet_don_hang', 'huy_don'];

        if (in_array($action, $allowed_for_customers)) {
            // Kiểm tra khách hàng đã đăng nhập chưa
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?controller=tai_khoan&action=dang_nhap");
                exit();
            }
        } else {
            // Các action khác (index, chi_tiet, tim_kiem) bắt buộc phải là Admin
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
            if ($status == 3) {
                $this->model->hoanLaiKho($order_id);
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
    public function huy_don() {
    $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // 1. Lấy thông tin đơn hàng để kiểm tra
    $order = $this->model->layTheoId($order_id);

    // 2. BẢO MẬT: Chỉ hủy được nếu:
    // - Đơn hàng tồn tại
    // - Đơn hàng của chính người đang đăng nhập (user_id khớp)
    // - Đơn hàng đang ở trạng thái chờ duyệt (status == 0)
    if ($order && $order['user_id'] == $_SESSION['user']['id'] && $order['status'] == 0) {
        
        // 3. Thực hiện hủy: Chuyển status về 3 (Đã hủy)
        $this->model->capNhatTrangThai($order_id, 3);
        
        // 4. Hoàn lại kho
        $this->model->hoanLaiKho($order_id);
        
        // 5. Nếu đã thanh toán online (payment_status == 1) -> Đánh dấu hoàn tiền
        if ($order['payment_status'] == 1) {
            $this->model->capNhatThanhToan($order_id, 2); // 2: Đã hoàn tiền
        }

        echo "<script>alert('Đơn hàng đã được hủy thành công!'); window.location.href='index.php?controller=don_hang&action=chi_tiet_don_hang&id=$order_id';</script>";
    } else {
        echo "<script>alert('Không thể hủy đơn hàng này!'); window.location.href='index.php?controller=tai_khoan&action=don_hang';</script>";
    }
}
}
?>