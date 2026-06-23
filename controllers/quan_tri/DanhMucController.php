<?php
// Gọi file Model vào để sử dụng
require_once '../models/DanhMucModel.php';

class DanhMucController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        // Kiểm tra quyền truy cập Admin
        if (!isset($_SESSION['admin_user'])) { 
            header("Location: index.php?controller=tai_khoan&action=dang_nhap"); 
            exit(); 
        }
        // Khởi tạo Model
        $this->model = new DanhMucModel($this->db);
    }

    // Hiển thị danh sách và Thêm danh mục mới
    public function index() {
        // Xử lý thêm danh mục (Đã thay lệnh INSERT bằng gọi Model)
        if (isset($_POST['add_cat'])) {
            $name = trim($_POST['name']);
            $this->model->them($name);
            header("Location: index.php?controller=danh_muc");
            exit();
        }
        
        // Lấy danh sách danh mục (Đã thay lệnh SELECT bằng gọi Model)
        $categories = $this->model->layTatCa();
        
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/danh_muc/index.php';
        require_once '../views/dung_chung/admin_footer.php';
    }

    // Xóa danh mục
    public function xoa() {
        $id = intval($_GET['id']);
        
        // Kiểm tra xem danh mục có sản phẩm không (Đã thay lệnh SELECT bằng gọi Model)
        if ($this->model->coSanPham($id)) {
            echo "<script>alert('KHÔNG THỂ XÓA! Danh mục này đang chứa sản phẩm.'); window.location='index.php?controller=danh_muc';</script>";
        } else {
            // Xóa danh mục (Đã thay lệnh DELETE bằng gọi Model)
            $this->model->xoa($id);
            header("Location: index.php?controller=danh_muc");
        }
    }
    // Thêm vào DanhMucController.php
    public function xem_san_pham() {
    $category_id = intval($_GET['id']);
    
    // Gọi model để lấy danh sách sản phẩm
    $danhMucModel = new DanhMucModel($this->db);
    $products = $danhMucModel->laySanPhamTheoDanhMuc($category_id);
    
    // Gọi view hiển thị danh sách sản phẩm (bạn cần tạo file này ở Bước 3)
    require_once '../views/dung_chung/admin_header.php';
    require_once '../views/quan_tri/danh_muc/danh_sach_san_pham.php';
    require_once '../views/dung_chung/admin_footer.php';
    }
}
?>