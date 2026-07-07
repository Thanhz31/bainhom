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
public function export() {
    // 1. Lấy dữ liệu bán chạy
    $list_sp = $this->model->getAllSanPhamBanChay();

    // 2. Thiết lập header để trình duyệt hiểu đây là file Excel (CSV)
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=bao_cao_kinh_doanh.csv');

    // 3. Mở file đầu ra
    $output = fopen('php://output', 'w');

    // Thêm BOM để Excel đọc được tiếng Việt có dấu
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // 4. Tạo dòng tiêu đề cho file Excel
    fputcsv($output, ['Tên sản phẩm', 'Đã bán', 'Doanh thu (VNĐ)']);

    // 5. Đổ dữ liệu vào file
    foreach ($list_sp as $sp) {
        fputcsv($output, [
            $sp['name'], 
            $sp['sold_count'], 
            $sp['revenue'] // Để định dạng số không dấu phẩy để Excel dễ tính toán
        ]);
    }
    // 6. Đóng file
    fclose($output);
    exit; // Dừng lại ở đây, không load thêm giao diện gì nữa
}
 public function index() {
    // 1. Lấy dữ liệu từ Model
    $data_thang = $this->model->getDoanhThuTheoThang(); 
    $top_sp = $this->model->getTopSanPhamBanChay();
    $ton_kho = $this->model->getSanPhamTonKhoThap();
    
    // Sếp thêm dòng này vào để lấy số liệu thực tế
    $tong_don_thanh_cong = $this->model->demDonThanhCong(); 

    // 2. Tính toán doanh thu tổng (cũ)
    $doanh_thu_tong = 0;
    foreach ($data_thang as $item) {
        $doanh_thu_tong += $item['doanh_thu'];
    }

    // 3. Gọi View
    require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_header.php';
    require_once dirname(__DIR__, 2) . '/views/quan_tri/bao_cao/index.php';
    require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_footer.php';
}
}