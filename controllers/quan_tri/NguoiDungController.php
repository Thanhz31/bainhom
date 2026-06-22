<?php
require_once '../models/NguoiDungModel.php';

class NguoiDungController {
    private $model;

    public function __construct() {
        // Cả Admin và Nhân viên đều vào được module này
        if (!isset($_SESSION['admin_login'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }
        $db = (new Database())->getConnection();
        $this->model = new NguoiDungModel($db);
    }

    // Danh sách khách hàng
    public function index() {
        $danhSach = $this->model->layDanhSachKhachHang();
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nguoi_dung/danh_sach.php';
    }

    // Xóa khách hàng (Ai cũng có thể xóa)
    public function xoa() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->model->xoaKhachHang($id)) {
                echo "<script>alert('Đã xóa khách hàng thành công!'); window.location.href='index.php?controller=nguoi_dung';</script>";
            } else {
                echo "<script>alert('Lỗi hệ thống, không thể xóa!'); window.location.href='index.php?controller=nguoi_dung';</script>";
            }
            exit();
        }
    }

    // Thêm khách hàng mới
    public function them() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_them'])) {
            $u = $_POST['username']; $p = $_POST['password'];
            $f = $_POST['full_name']; $ph = $_POST['phone']; $ad = $_POST['address'];
            
            if ($this->model->themKhachHang($u, $p, $f, $ph, $ad)) {
                echo "<script>alert('Đã tạo tài khoản khách hàng thành công!'); window.location.href='index.php?controller=nguoi_dung';</script>";
                exit();
            } else {
                $error = "Tên đăng nhập này đã tồn tại!";
            }
        }
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nguoi_dung/them.php';
    }

    // Sửa thông tin khách hàng
    public function sua() {
        if (!isset($_GET['id'])) { header("Location: index.php?controller=nguoi_dung"); exit(); }
        $id = $_GET['id'];
        $khachHang = $this->model->layKhachHangTheoId($id);
        
        if (!$khachHang) { echo "<script>alert('Không tìm thấy khách hàng!'); window.location.href='index.php?controller=nguoi_dung';</script>"; exit(); }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_sua'])) {
            $p = $_POST['password']; $f = $_POST['full_name']; 
            $ph = $_POST['phone']; $ad = $_POST['address'];
            
            if ($this->model->suaThongTinKhachHang($id, $p, $f, $ph, $ad)) {
                echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='index.php?controller=nguoi_dung';</script>";
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật!";
            }
        }
        require_once '../views/dung_chung/admin_header.php';
        require_once '../views/quan_tri/nguoi_dung/sua.php';
    }

    // ==========================================
    // HÀM TÌM KIẾM NGƯỜI DÙNG
    // ==========================================
    public function tim_kiem() {
        if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {
            $tu_khoa = $_GET['keyword'];
            
            // Gọi Model để tìm kiếm
            $danhSach = $this->model->timKiemKhachHang($tu_khoa);
            
            // Gọi View danh sách ra để hiển thị
            require_once '../views/dung_chung/admin_header.php';
            require_once '../views/quan_tri/nguoi_dung/danh_sach.php'; 
        } else {
            header("Location: index.php?controller=nguoi_dung");
            exit();
        }
    }
}
?>