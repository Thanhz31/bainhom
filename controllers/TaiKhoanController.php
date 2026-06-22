<?php
require_once '../services/TaiKhoanComponent.php';
require_once '../services/DonHangComponent.php';
require_once '../models/NguoiDungModel.php'; 

class TaiKhoanController {
    private $taiKhoanService;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->taiKhoanService = new TaiKhoanComponent($this->db);
    }

    // Giữ nguyên hàm đăng nhập của bạn
    public function dang_nhap() {
        if (isset($_POST['login'])) {
            $res = $this->taiKhoanService->dangNhap($_POST['username'], $_POST['password']);
            if ($res) {
                $target = ($res['role'] == 'admin') ? 'index.php?controller=quan_tri' : 'index.php';
                header("Location: $target");
                exit();
            }
            $error = "Sai tài khoản hoặc mật khẩu!";
        }
        require_once '../views/tai_khoan/dang_nhap.php';
    }

    // Giữ nguyên hàm đăng xuất của bạn
    public function dang_xuat() {
        $this->taiKhoanService->dangXuat();
        header("Location: index.php");
    }

    // Giữ nguyên hàm xem đơn hàng của bạn
    public function don_hang() {
        if (!isset($_SESSION['user'])) header("Location: index.php?controller=tai_khoan&action=dang_nhap");
        
        $dhService = new DonHangComponent($this->db);
        $orders = $dhService->layLichSu($_SESSION['user']['id']);
        
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/don_hang_cua_toi.php';
        require_once '../views/dung_chung/footer.php';
    }

    // Hàm đăng ký đã được làm sạch SQL
    public function dang_ky() {
        $error = ''; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password']; 
            $full_name = $_POST['full_name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $nguoiDungModel = new NguoiDungModel($this->db);

            if ($nguoiDungModel->kiemTraTenDangNhapTonTai($username)) {
                $error = "Tên đăng nhập này đã có người sử dụng. Vui lòng chọn tên khác!";
            } else {
                if ($nguoiDungModel->dangKy($username, $password, $full_name, $phone, $address)) {
                    echo "<script>
                            alert('Chúc mừng bạn đã đăng ký tài khoản thành công!'); 
                            window.location.href='index.php?controller=tai_khoan&action=dang_nhap';
                          </script>";
                    exit();
                } else {
                    $error = "Có lỗi hệ thống xảy ra, vui lòng thử lại sau!";
                }
            }
        }
        require_once '../views/tai_khoan/dang_ky.php';
        require_once '../views/dung_chung/footer.php';
    }
}
?>