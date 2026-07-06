<?php
require_once '../models/DanhMucModel.php';
require_once '../models/SanPhamModel.php';

class TrangChuController {
    private $db;
    private $danhMucModel;
    private $sanPhamModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->danhMucModel = new DanhMucModel($this->db);
        $this->sanPhamModel = new SanPhamModel($this->db);
    }

    public function index() {
        // 1. Giỏ hàng
        $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;

        // 2. Danh mục
        $cat_res = $this->danhMucModel->layTatCa();
        $categories = [];
        if ($cat_res) {
            while($cat = $cat_res->fetch_assoc()) { $categories[] = $cat; }
        }

        // 3. Xử lý thuật toán Phân trang
        $limit = 9; // Hiển thị tối đa 9 sản phẩm trên 1 trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // 4. Lấy các tham số lọc (nếu có)
        $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : null;
        $keyword = (isset($_GET['q']) && !empty($_GET['q'])) ? $_GET['q'] : null;

        // Sản phẩm giá rẻ (Chỉ hiển thị khi ở Trang 1 và không tìm kiếm)
        $res_top = null;
        if ($keyword === null && $cat_id === null && $page == 1) {
            $res_top = $this->sanPhamModel->laySanPhamGiaRe();
        }

        // 5. Lọc sản phẩm chính (có kết hợp Phân trang)
        $section_title = "Tất Cả Sản Phẩm";
        if ($cat_id !== null) {
            $cat_name = $this->danhMucModel->layTheoId($cat_id);
            if ($cat_name) $section_title = "Danh mục: " . $cat_name['name'];
        }
        if ($keyword !== null) {
            $section_title = "Kết quả tìm kiếm cho: <span class='text-danger'>'$keyword'</span>";
        }

        // Chạy truy vấn lấy dữ liệu ĐÃ BỊ GIỚI HẠN theo trang
        $products = $this->sanPhamModel->locSanPhamTrangChu($cat_id, $keyword, $offset, $limit);
        
        // Tính tổng số lượng trang để vẽ nút bấm ra giao diện
        $total_products = $this->sanPhamModel->demSanPhamTrangChu($cat_id, $keyword);
        $total_pages = ceil($total_products / $limit);

        require_once '../views/dung_chung/header.php';
        require_once '../views/trang_chu/index.php';
        require_once '../views/dung_chung/footer.php';
    }

    public function chi_tiet() {
        $id = intval($_GET['id']);
        
        $product = $this->sanPhamModel->layTheoId($id); 
        
        $cat_res = $this->danhMucModel->layTatCa();
        $categories = [];
        if ($cat_res) {
            while($c = $cat_res->fetch_assoc()) $categories[] = $c;
        }
        
        require_once '../views/dung_chung/header.php';
        require_once '../views/trang_chu/chi_tiet.php';
        require_once '../views/dung_chung/footer.php';
    }
}
?>