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

        // 2. Danh mục (Gọi qua Model)
        $cat_res = $this->danhMucModel->layTatCa();
        $categories = [];
        if ($cat_res) {
            while($cat = $cat_res->fetch_assoc()) { $categories[] = $cat; }
        }

        // 3. Sản phẩm giá rẻ (Gọi qua Model)
        $res_top = null;
        $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : null;
        $keyword = (isset($_GET['q']) && !empty($_GET['q'])) ? $_GET['q'] : null;

        if ($keyword === null && $cat_id === null) {
            $res_top = $this->sanPhamModel->laySanPhamGiaRe();
        }

        // 4. Lọc sản phẩm chính
        $section_title = "Sản Phẩm Mới";

        // Lọc theo Danh mục
        if ($cat_id !== null) {
            $cat_name = $this->danhMucModel->layTheoId($cat_id);
            if ($cat_name) $section_title = "Danh mục: " . $cat_name['name'];
        }

        // Lọc theo Từ khóa
        if ($keyword !== null) {
            $section_title = "Kết quả tìm kiếm cho: <span class='text-danger'>'$keyword'</span>";
        }

        // Chạy truy vấn cuối cùng thông qua Model
        $products = $this->sanPhamModel->locSanPhamTrangChu($cat_id, $keyword);

        require_once '../views/dung_chung/header.php';
        require_once '../views/trang_chu/index.php';
        require_once '../views/dung_chung/footer.php';
    }

    public function chi_tiet() {
        $id = intval($_GET['id']);
        
        // 1. Gọi hàm lấy thông tin chi tiết sản phẩm
        $product = $this->sanPhamModel->layTheoId($id); 
        
        // 2. GỌI HÀM LẤY BÌNH LUẬN TỪ MODEL
        $reviews = $this->sanPhamModel->layBinhLuanTheoSanPham($id);
        
        // 3. Lấy danh mục để hiển thị thanh menu
        $cat_res = $this->danhMucModel->layTatCa();
        $categories = [];
        if ($cat_res) {
            while($c = $cat_res->fetch_assoc()) $categories[] = $c;
        }
        
        // Đưa dữ liệu sang View
        require_once '../views/dung_chung/header.php';
        require_once '../views/trang_chu/chi_tiet.php';
        require_once '../views/dung_chung/footer.php';
    }
}
?>