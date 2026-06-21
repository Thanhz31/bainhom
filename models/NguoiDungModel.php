<?php
class NguoiDungModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function dangNhapKhach($u, $p) {
        $u = $this->conn->real_escape_string($u);
        $p = $this->conn->real_escape_string($p);
        $sql = "SELECT * FROM users WHERE username = '$u' AND password = '$p'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function dangNhapAdmin($u, $p) {
        $u = $this->conn->real_escape_string($u);
        $p = $this->conn->real_escape_string($p);
        $sql = "SELECT * FROM admins WHERE username = '$u' AND password = '$p'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    // Hàm kiểm tra trùng lặp
    public function kiemTraTenDangNhapTonTai($username) {
        $u = $this->conn->real_escape_string($username);
        $sql = "SELECT id FROM users WHERE username = '$u'";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }

    // Hàm đăng ký
    public function dangKy($username, $password, $fullname, $phone, $address) {
        $u = $this->conn->real_escape_string($username);
        $p = $this->conn->real_escape_string($password);
        $f = $this->conn->real_escape_string($fullname);
        $ph = $this->conn->real_escape_string($phone);
        $ad = $this->conn->real_escape_string($address);
        
        $sql = "INSERT INTO users (username, password, full_name, phone, address) 
                VALUES ('$u', '$p', '$f', '$ph', '$ad')";
        return $this->conn->query($sql);
    }

    // ---------------- PHẦN DÀNH CHO ADMIN & NHÂN VIÊN ----------------

    public function layDanhSachKhachHang() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function xoaKhachHang($id) {
        $id = intval($id);
        $sql = "DELETE FROM users WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function layKhachHangTheoId($id) {
        $id = intval($id);
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function themKhachHang($u, $p, $f, $ph, $ad) {
        $u = $this->conn->real_escape_string($u);
        $p = $this->conn->real_escape_string($p);
        $f = $this->conn->real_escape_string($f);
        $ph = $this->conn->real_escape_string($ph);
        $ad = $this->conn->real_escape_string($ad);
        
        $check = $this->conn->query("SELECT id FROM users WHERE username = '$u'");
        if ($check->num_rows > 0) return false;

        $sql = "INSERT INTO users (username, password, full_name, phone, address) VALUES ('$u', '$p', '$f', '$ph', '$ad')";
        return $this->conn->query($sql);
    }

    public function suaThongTinKhachHang($id, $p, $f, $ph, $ad) {
        $id = intval($id);
        $p = $this->conn->real_escape_string($p);
        $f = $this->conn->real_escape_string($f);
        $ph = $this->conn->real_escape_string($ph);
        $ad = $this->conn->real_escape_string($ad);
        
        $sql = "UPDATE users SET password = '$p', full_name = '$f', phone = '$ph', address = '$ad' WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function timKiemKhachHang($tu_khoa) {
        $tu_khoa = $this->conn->real_escape_string($tu_khoa);
        
        $sql = "SELECT * FROM users WHERE username LIKE '%$tu_khoa%' OR full_name LIKE '%$tu_khoa%' OR phone LIKE '%$tu_khoa%' ORDER BY id DESC";
        $result = $this->conn->query($sql);
        
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