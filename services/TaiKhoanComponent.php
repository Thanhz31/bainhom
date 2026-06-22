<?php
require_once '../models/NguoiDungModel.php';

class TaiKhoanComponent {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new NguoiDungModel($db);
    }

    public function dangNhap($u, $p) {
        // 1. Kiểm tra Admin / Nhân viên trước
        $admin = $this->userModel->dangNhapAdmin($u, $p);
        if ($admin) {
            // LƯU CÁC SESSION PHÂN QUYỀN (ĐÃ BỔ SUNG)
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_user'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role']; // Lấy role (1 hoặc 2) từ CSDL
            
            return ['role' => 'admin', 'data' => $admin];
        }

        // 2. Kiểm tra Khách hàng
        $user = $this->userModel->dangNhapKhach($u, $p);
        if ($user) {
            $_SESSION['user'] = $user;
            return ['role' => 'user', 'data' => $user];
        }

        return false;
    }

    public function dangKy($u, $p, $f, $ph, $ad) {
        return $this->userModel->dangKy($u, $p, $f, $ph, $ad);
    }

    public function dangXuat() {
        // Xóa session của Khách hàng
        unset($_SESSION['user']);
        
        // Xóa toàn bộ session của Admin / Nhân viên (Đã bổ sung)
        unset($_SESSION['admin_login']);
        unset($_SESSION['admin_user']);
        unset($_SESSION['admin_role']);
    }
}
?>