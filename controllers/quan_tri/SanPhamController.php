<?php
// Gọi các Model vào để sử dụng
require_once '../models/SanPhamModel.php';
require_once '../models/DanhMucModel.php';

class SanPhamController {
    private $db;
    private $sanPhamModel;
    private $danhMucModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        if (!isset($_SESSION['admin_user'])) { 
            header("Location: index.php?controller=tai_khoan&action=dang_nhap"); 
            exit(); 
        }
        // Khởi tạo các Model
        $this->sanPhamModel = new SanPhamModel($this->db);
        $this->danhMucModel = new DanhMucModel($this->db);
    }

    public function index() {
        // Lấy danh sách sản phẩm bằng Model
        $products = $this->sanPhamModel->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/san_pham/index.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    public function them() {
        if (isset($_POST['submit'])) {
            $img = basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $img);
            
            // Thêm sản phẩm bằng Model
            $this->sanPhamModel->themSanPham($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['category_id'], $_POST['description'], $_POST['detail_desc'], $img);
            
            header("Location: index.php?controller=san_pham"); 
            exit();
        }
        
        // Lấy danh mục bằng DanhMucModel để đổ vào thẻ <select>
        $categories = $this->danhMucModel->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php'; 
        require_once '../views/quan_tri/san_pham/them.php'; 
        require_once '../views/dung_chung/admin_footer.php';
    }

    public function sua() {
        $id = intval($_GET['id']);
        
        // Lấy thông tin sản phẩm bằng Model
        $product = $this->sanPhamModel->layTheoId($id);
        
        if (isset($_POST['update'])) {
            $img = !empty($_FILES['image']['name']) ? basename($_FILES["image"]["name"]) : $product['image'];
            if(!empty($_FILES['image']['name'])) {
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $img);
            }
            
            // Cập nhật sản phẩm bằng Model
            $this->sanPhamModel->suaSanPham($id, $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['category_id'], $_POST['description'], $_POST['detail_desc'], $img);
            
            header("Location: index.php?controller=san_pham"); 
            exit();
        }
        
        // Lấy danh mục bằng DanhMucModel để đổ vào thẻ <select>
        $categories = $this->danhMucModel->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php'; 
        require_once '../views/quan_tri/san_pham/sua.php'; 
        require_once '../views/dung_chung/admin_footer.php';
    }

    public function xoa() {
        $id = intval($_GET['id']);
        
        // Xóa sản phẩm bằng Model
        $this->sanPhamModel->xoaSanPham($id);
        
        header("Location: index.php?controller=san_pham");
    }

    public function tim_kiem() {
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $tu_khoa = trim($_GET['keyword']);
            
            // Tìm kiếm bằng Model
            $products = $this->sanPhamModel->timKiemAdmin($tu_khoa);
            
            require_once '../views/dung_chung/admin_header.php';
            echo "<div class='container mt-3 mb-0'><h5 class='fw-bold text-secondary'><i class='fas fa-search'></i> Kết quả tìm kiếm cho: <span class='text-danger'>'$tu_khoa'</span></h5></div>";
            require_once '../views/quan_tri/san_pham/index.php'; 
            require_once '../views/dung_chung/admin_footer.php';
        } else {
            header("Location: index.php?controller=san_pham");
            exit();
        }
    }
}
?>