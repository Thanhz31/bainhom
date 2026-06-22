<?php
class NhanVienModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // 1. Lấy toàn bộ tài khoản là nhân viên
    public function layDanhSach() {
        $sql = "SELECT * FROM admins WHERE role = 2 ORDER BY id DESC";
        $result = $this->db->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // 2. Lấy thông tin 1 nhân viên dựa vào ID
    public function layNhanVienTheoId($id) {
        $id = intval($id);
        $sql = "SELECT * FROM admins WHERE id = $id AND role = 2";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    // 3. Cập nhật mật khẩu cho nhân viên
// Hàm xử lý SQL: Cập nhật thông tin nhân viên (Tên đăng nhập & Mật khẩu)
    public function suaThongTinNhanVien($id, $username, $password) {
        $id = intval($id);
        
        // Làm sạch dữ liệu trước khi đưa vào SQL để chống hack
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        
        // Câu lệnh SQL chuẩn xác (chỉ cập nhật người có role = 2)
        $sql = "UPDATE admins SET username = '$username', password = '$password' WHERE id = $id AND role = 2";
        
        return $this->db->query($sql);
    }

    // 4. Thêm nhân viên mới (Mặc định role = 2)
    public function themNhanVien($username, $password) {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        
        // Kiểm tra xem username đã tồn tại chưa
        $check = $this->db->query("SELECT id FROM admins WHERE username = '$username'");
        if ($check && $check->num_rows > 0) {
            return false; // Trùng tên đăng nhập
        }

        $sql = "INSERT INTO admins (username, password, role) VALUES ('$username', '$password', 2)";
        return $this->db->query($sql);
    }

    // 5. Xóa nhân viên
    public function xoaNhanVien($id) {
        $id = intval($id);
        // Chỉ cho phép xóa nếu role = 2 (Bảo vệ không cho tự xóa Admin)
        $sql = "DELETE FROM admins WHERE id = $id AND role = 2";
        return $this->db->query($sql);
    }

    // ==========================================
    // ĐÃ SỬA LẠI THÀNH $this->db CHO ĐÚNG
    // ==========================================
    public function timKiemNhanVien($tu_khoa) {
        $tu_khoa = $this->db->real_escape_string($tu_khoa);
        
        // Tìm kiếm nhân viên có tên đăng nhập khớp với từ khóa (Chỉ lấy nhân viên, role=2)
        $sql = "SELECT * FROM admins WHERE role = 2 AND username LIKE '%$tu_khoa%' ORDER BY id DESC";
        $result = $this->db->query($sql);
        
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>