<?php
// Sửa thành đường dẫn tuyệt đối bằng __DIR__
require_once dirname(__DIR__, 2) . '/models/ThongKeModel.php'; 

class BaoCaoController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->model = new ThongKeModel($this->db);
        
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
    }

    public function index() {
        // 1. Lấy giá trị từ URL, nếu không có thì mặc định từ đầu tháng tới nay
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');

        // 2. Gọi Model để lấy số liệu dựa trên khoảng thời gian
        $doanh_thu_tong = $this->model->getDoanhThuTong($tu_ngay, $den_ngay);
        $tong_don_thanh_cong = $this->model->demDonThanhCong($tu_ngay, $den_ngay);
        $top_sp = $this->model->getTopSanPhamBanChay($tu_ngay, $den_ngay);

        // 3. Đổ dữ liệu vào view
        require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_header.php';
        require_once dirname(__DIR__, 2) . '/views/quan_tri/bao_cao/index.php';
        require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_footer.php';
    }

    public function export() {
        // 1. Lấy ngày từ URL
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');

        // 2. Lấy dữ liệu bán chạy theo khoảng thời gian
        $list_sp = $this->model->getTopSanPhamBanChay($tu_ngay, $den_ngay);

        // 3. Thiết lập header cho file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=bao_cao_{$tu_ngay}_den_{$den_ngay}.csv");

        $output = fopen('php://output', 'w');
        // Thêm BOM để Excel hiển thị đúng tiếng Việt
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); 

        // 4. Tạo dòng tiêu đề, sử dụng dấu ; cho Excel tiếng Việt
        fputcsv($output, ['Tên sản phẩm', 'Đã bán', 'Doanh thu (VNĐ)'], ';');

        // 5. Đổ dữ liệu
        foreach ($list_sp as $sp) {
            fputcsv($output, [$sp['name'], $sp['sold_count'], $sp['revenue']], ';');
        }
        
        fclose($output);
        exit;
    }
}
