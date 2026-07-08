<?php
require_once dirname(__DIR__, 2) . '/models/ThongKeModel.php'; 

class BaoCaoController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->model = new ThongKeModel($this->db);
        
        if (!isset($_SESSION['admin_user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
    }

    public function index() {
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');

        $doanh_thu_tong = $this->model->getDoanhThuTong($tu_ngay, $den_ngay);
        $tong_don_thanh_cong = $this->model->demDonThanhCong($tu_ngay, $den_ngay);
        $top_sp = $this->model->getTopSanPhamBanChay($tu_ngay, $den_ngay);

        require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_header.php';
        require_once dirname(__DIR__, 2) . '/views/quan_tri/bao_cao/index.php';
        require_once dirname(__DIR__, 2) . '/views/dung_chung/admin_footer.php';
    }

    public function export() {
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');

        // Lấy dữ liệu
        $list_sp = $this->model->getTopSanPhamBanChay($tu_ngay, $den_ngay);

        // Thiết lập header ép trình duyệt tải file định dạng Excel
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Bao_Cao_Doanh_Thu_{$tu_ngay}_den_{$den_ngay}.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Sử dụng HTML để cấu trúc file Excel
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="utf-8"></head>';
        echo '<body>';
        
        // Tiêu đề báo cáo trong Excel căn trái để khớp với bảng
        echo '<h2 style="text-align: left; color: #333; margin-bottom: 5px;">BÁO CÁO DOANH THU SẢN PHẨM</h2>';
        echo '<p style="text-align: left; margin-top: 0;">Từ ngày: <b>' . date('d/m/Y', strtotime($tu_ngay)) . '</b> - Đến ngày: <b>' . date('d/m/Y', strtotime($den_ngay)) . '</b></p>';
        
        // Bảng dữ liệu: Bỏ width 100% để bảng tự co lại và nằm bên trái
        echo '<table border="1" style="border-collapse: collapse; font-family: Arial, sans-serif;">';
        echo '<thead>';
        echo '<tr style="background-color: #4CAF50; color: white; height: 40px;">';
        // Căn lề rõ ràng cho từng cột tiêu đề
        echo '<th style="padding: 10px 15px; text-align: center;">STT</th>';
        echo '<th style="padding: 10px 20px; text-align: left;">Tên sản phẩm</th>';
        echo '<th style="padding: 10px 20px; text-align: center;">Đã bán</th>';
        echo '<th style="padding: 10px 20px; text-align: right;">Doanh thu (VNĐ)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $stt = 1;
        $tong_tien = 0;
        
        foreach ($list_sp as $sp) {
            echo '<tr>';
            echo '<td style="text-align: center; padding: 8px 15px;">' . $stt++ . '</td>';
            echo '<td style="text-align: left; padding: 8px 20px;">' . htmlspecialchars($sp['name']) . '</td>';
            echo '<td style="text-align: center; padding: 8px 20px;">' . $sp['sold_count'] . '</td>';
            echo '<td style="text-align: right; padding: 8px 20px;">' . number_format($sp['revenue'], 0, ',', '.') . ' ₫</td>';
            echo '</tr>';
            
            $tong_tien += $sp['revenue'];
        }
        
        // Dòng tổng cộng cuối bảng
        echo '<tr style="font-weight: bold; background-color: #f2f2f2; height: 35px;">';
        echo '<td colspan="3" style="text-align: right; padding: 10px 20px;">TỔNG CỘNG DOANH THU:</td>';
        echo '<td style="text-align: right; color: #d32f2f; padding: 10px 20px;">' . number_format($tong_tien, 0, ',', '.') . ' ₫</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>