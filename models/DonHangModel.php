<?php
class DonHangModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function taoDonHang($user_id, $name, $phone, $address, $total) {
        $uid = $user_id ? intval($user_id) : "NULL";
        $name = $this->conn->real_escape_string($name);
        $phone = $this->conn->real_escape_string($phone);
        $address = $this->conn->real_escape_string($address);

        $sql = "INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_money) 
                VALUES ($uid, '$name', '$phone', '$address', '$total')";
        
        if ($this->conn->query($sql)) {
            return $this->conn->insert_id; 
        }
        return false;
    }

    public function luuChiTiet($order_id, $product_id, $price, $quantity) {
        $sql = "INSERT INTO order_details (order_id, product_id, price, quantity) 
                VALUES ($order_id, $product_id, $price, $quantity)";
        return $this->conn->query($sql);
    }

    public function layDonHangCuaKhach($user_id) {
        $user_id = intval($user_id);
        $sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()) { $data[] = $row; }
        }
        return $data;
    }

    public function timKiemDonHangAdmin($tu_khoa) {
        $tu_khoa = $this->conn->real_escape_string($tu_khoa);
        $sql = "SELECT * FROM orders 
                WHERE id LIKE '%$tu_khoa%' 
                   OR customer_name LIKE '%$tu_khoa%' 
                   OR customer_phone LIKE '%$tu_khoa%' 
                ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { $data[] = $row; }
        }
        return $data;
    }

    public function layTatCa() {
        $result = $this->conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()) { $data[] = $row; }
        }
        return $data;
    }

    public function layTheoId($id) {
        $id = intval($id);
        $result = $this->conn->query("SELECT * FROM orders WHERE id = $id");
        return $result ? $result->fetch_assoc() : null;
    }

    public function layChiTietDonHang($id) {
        $id = intval($id);
        $result = $this->conn->query("SELECT d.*, p.name, p.image FROM order_details d JOIN products p ON d.product_id = p.id WHERE d.order_id = $id");
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()) { $data[] = $row; }
        }
        return $data;
    }

    public function capNhatTrangThai($id, $status) {
        $id = intval($id); 
        $status = intval($status);

        $don_hang = $this->layTheoId($id);
        if (!$don_hang) return false;
        
        $trang_thai_hien_tai = intval($don_hang['status']);

        if ($trang_thai_hien_tai == 2 || $trang_thai_hien_tai == 3) {
            return false;
        }

        if ($status < $trang_thai_hien_tai && $status != 3) {
            return false;
        }

        return $this->conn->query("UPDATE orders SET status = $status WHERE id = $id");
    }

    public function hoanLaiKho($id_don_hang) {
        $id_don_hang = intval($id_don_hang);
        $sql_get = "SELECT product_id, quantity FROM order_details WHERE order_id = $id_don_hang";
        $result = $this->conn->query($sql_get);

        if ($result && $result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $pid = intval($item['product_id']);
                $qty = intval($item['quantity']);
                $sql_update = "UPDATE products SET quantity = quantity + $qty WHERE id = $pid";
                $this->conn->query($sql_update);
            }
        }
    }

    public function tinhTongDoanhThu() {
        $res = $this->conn->query("SELECT SUM(total_money) as total FROM orders WHERE status = 2");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['total'] : 0;
    }

    public function demDonChoDuyet() {
        $res = $this->conn->query("SELECT COUNT(id) as count FROM orders WHERE status = 0");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }

    // ==========================================
    // CÁC HÀM XỬ LÝ DỮ LIỆU BIỂU ĐỒ
    // ==========================================
    
    // Lấy danh sách các năm có giao dịch để làm bộ lọc
    public function layCacNamCoDoanhThu() {
        $sql = "SELECT DISTINCT YEAR(created_at) as nam FROM orders WHERE status = 2 ORDER BY nam DESC";
        $result = $this->conn->query($sql);
        $years = [];
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $years[] = $row['nam'];
            }
        }
        // Nếu database chưa có đơn nào, mặc định trả về năm hiện tại
        if (empty($years)) {
            $years[] = date('Y');
        }
        return $years;
    }

    // Lấy tổng doanh thu của từng tháng theo năm
    public function thongKeDoanhThuTheoThang($year = null) {
        if ($year == null) {
            $year = date('Y');
        }
        $year = intval($year); 

        $sql = "SELECT MONTH(created_at) as thang, SUM(total_money) as doanh_thu 
                FROM orders 
                WHERE status = 2 AND YEAR(created_at) = $year 
                GROUP BY MONTH(created_at)";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()) { 
                $data[$row['thang']] = $row['doanh_thu']; 
            }
        }
        return $data;
    }

    // Đếm số lượng đơn hàng theo từng trạng thái
    public function thongKeTrangThaiDonHang() {
        $sql = "SELECT status, COUNT(id) as so_luong FROM orders GROUP BY status";
        $result = $this->conn->query($sql);
        $data = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; 
        if ($result) {
            while($row = $result->fetch_assoc()) { 
                $data[$row['status']] = $row['so_luong']; 
            }
        }
        return $data;
    }
}
?>