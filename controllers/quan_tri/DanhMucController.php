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
    // Hiển thị danh sách và Thêm danh mục mới
public function index() {
    if (isset($_POST['add_cat'])) {
        $name = trim($_POST['name']);
        
        // --- XỬ LÝ UPLOAD ICON ---
        $icon_filename = ''; // Mặc định là rỗng
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
            $target_dir = "uploads/icons/";
            // Tạo tên file ngẫu nhiên để không bị trùng (vd: 1698765432_icon.png)
            $icon_filename = basename($_FILES["icon"]["name"]);
            $target_file = $target_dir . $icon_filename;
            
            // Di chuyển file từ bộ nhớ tạm vào thư mục
            move_uploaded_file($_FILES["icon"]["tmp_name"], $target_file);
        }
        // -------------------------

        // Cập nhật: Truyền thêm biến $icon_filename vào Model
        $this->model->them($name, $icon_filename);
        header("Location: index.php?controller=danh_muc");
        exit();
    }
    
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
    // Chỉnh sửa danh mục
    public function sua() {
        $id = intval($_GET['id']);
        // Lấy thông tin danh mục hiện tại để hiển thị ra form
        $category = $this->model->layTheoId($id);

        if (isset($_POST['edit_cat'])) {
            $name = trim($_POST['name']);
            $icon_filename = '';
            
            // Xử lý upload ảnh nếu người dùng có chọn file mới
            if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
                $target_dir = "uploads/icons/"; // Trỏ thẳng vào gốc dự án như đã thống nhất
                $icon_filename = basename($_FILES["icon"]["name"]);
                $target_file = $target_dir . $icon_filename;
                
                move_uploaded_file($_FILES["icon"]["tmp_name"], $target_file);
            }

            // Gọi model để lưu vào DB
            $this->model->capNhat($id, $name, $icon_filename);
            
            // Sửa xong thì quay về trang danh sách
            header("Location: index.php?controller=danh_muc");
            exit();
        }

        // Gọi View hiển thị form sửa
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/danh_muc/sua.php'; // File này sẽ tạo ở Bước 4
        require_once '../views/dung_chung/admin_footer.php';
    }
}
?>