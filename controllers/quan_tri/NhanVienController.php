<?php
require_once '../models/NhanVienModel.php';

class NhanVienController {
    private $model;

    public function __construct() {
        // KIỂM TRA BẢO MẬT: Không phải Admin thì đuổi thẳng cổ!
        if (!isset($_SESSION['admin_login']) || $_SESSION['admin_role'] != 1) {
            echo "<script>
                    alert('Lỗi bảo mật! Chỉ Quản trị viên cấp cao mới được vào khu vực này.'); 
                    window.location.href='index.php?controller=quan_tri';
                  </script>";
            exit();
        }
        
        $db = (new Database())->getConnection();
        $this->model = new NhanVienModel($db);
    }

    // Mặc định load trang danh sách
    public function index() {
        // Gọi Model lấy danh sách nhân viên
        $danhSach = $this->model->layDanhSach();
        
        // Gọi các file Giao diện
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nhan_vien/danh_sach.php'; // Bạn sẽ tạo file này ở bước sau
    }
    
    // Hàm xử lý việc sửa thông tin/phân quyền nhân viên
    public function phan_quyen() {
        // Kiểm tra xem có truyền ID lên không
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=nhan_vien");
            exit();
        }
        
        $id = $_GET['id'];
        $nhanVien = $this->model->layNhanVienTheoId($id); // Lấy thông tin nhân viên cũ

        if (!$nhanVien) {
            echo "<script>alert('Không tìm thấy nhân viên này!'); window.location.href='index.php?controller=nhan_vien';</script>";
            exit();
        }

        // Nếu người dùng bấm nút "Cập nhật"
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_cap_nhat'])) {
            $password = $_POST['password']; // Lấy mật khẩu mới
            
            if ($this->model->suaNhanVien($id, $password)) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?controller=nhan_vien';</script>";
                exit();
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }

        // Gọi giao diện Form phan_quyen.php
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nhan_vien/phan_quyen.php';
    }
    
    // Hàm xử lý hiển thị Form và Lưu nhân viên mới
    public function them() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_them'])) {
            $username = $_POST['username'];
            $password = $_POST['password']; 
            
            // Gọi Model để lưu vào CSDL
            if ($this->model->themNhanVien($username, $password)) {
                echo "<script>alert('Tuyệt vời! Đã tạo tài khoản nhân viên thành công.'); window.location.href='index.php?controller=nhan_vien';</script>";
                exit();
            } else {
                $error = "Lỗi: Tên đăng nhập này đã tồn tại. Vui lòng chọn tên khác!";
            }
        }
        
        // Gọi giao diện Form thêm nhân viên
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nhan_vien/them.php';
    }

    // Hàm xử lý Xóa nhân viên khi bấm nút thùng rác
    public function xoa() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->model->xoaNhanVien($id)) {
                echo "<script>alert('Đã xóa nhân viên khỏi hệ thống!'); window.location.href='index.php?controller=nhan_vien';</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể xóa!'); window.location.href='index.php?controller=nhan_vien';</script>";
            }
            exit();
        }
    }
    
    // Hàm xử lý logic Sửa thông tin nhân viên (Giao tiếp qua Model)
    public function sua() {
        // 1. Kiểm tra ID truyền lên
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=nhan_vien");
            exit();
        }
        
        $id = $_GET['id'];
        
        // 2. Lấy dữ liệu nhân viên cũ từ Model để hiển thị ra form
        $nhanVien = $this->model->layNhanVienTheoId($id); 

        if (!$nhanVien) {
            echo "<script>alert('Lỗi: Không tìm thấy nhân viên này!'); window.location.href='index.php?controller=nhan_vien';</script>";
            exit();
        }

        // 3. Nếu Admin điền form và bấm "Cập nhật"
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_sua'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Gọi Model để thực thi SQL
            if ($this->model->suaThongTinNhanVien($id, $username, $password)) {
                echo "<script>alert('Đã cập nhật thông tin nhân viên thành công!'); window.location.href='index.php?controller=nhan_vien';</script>";
                exit();
            } else {
                $error = "Cập nhật thất bại! Tên đăng nhập này có thể đã bị trùng.";
            }
        }

        // 4. Gọi giao diện Form sửa (View)
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nhan_vien/sua.php';
    }

    // ==========================================
    // HÀM TÌM KIẾM NHÂN VIÊN MỚI THÊM
    // ==========================================
    public function tim_kiem() {
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $tu_khoa = $_GET['keyword'];
            
            // Gọi Model để tìm kiếm
            $danhSach = $this->model->timKiemNhanVien($tu_khoa);
            
            // Gọi View danh sách ra để hiển thị lại
            require_once '../views/dung_chung/admin_header.php';
            require_once '../views/quan_tri/nhan_vien/danh_sach.php'; 
        } else {
            // Nếu không nhập gì thì về lại danh sách gốc
            header("Location: index.php?controller=nhan_vien");
            exit();
        }
    }
}
?>