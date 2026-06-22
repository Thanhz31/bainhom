<?php
class DonHangModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ==========================================
    // CÁC HÀM CŨ (Dùng cho khách đặt hàng)
    // ==========================================
    public function taoDonHang($user_id, $name, $phone, $address, $total) {
        $uid = $user_id ? intval($user_id) : "NULL";
        $name = $this->conn->real_escape_string($name);
        $phone = $this->conn->real_escape_string($phone);
        $address = $this->conn->real_escape_string($address);

        $sql = "INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_money) 
                VALUES ($uid, '$name', '$phone', '$address', '$total')";
        
        if ($this->conn->query($sql)) {
            return $this->conn->insert_id; // Trả về mã đơn hàng vừa tạo
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
        while($row = $result->fetch_assoc()) { $data[] = $row; }
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

    // ==========================================
    // CÁC HÀM MỚI (Dọn từ Controller sang)
    // ==========================================
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
        return $this->conn->query("UPDATE orders SET status = $status WHERE id = $id");
    }

    public function tinhTongDoanhThu() {
        $res = $this->conn->query("SELECT SUM(total_money) as total FROM orders WHERE status = 2");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['total'] : 0;
    }

    public function demDonChoDuyet() {
        $res = $this->conn->query("SELECT COUNT(id) as count FROM orders WHERE status = 0");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }
}
?>