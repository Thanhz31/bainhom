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
    // CÁC HÀM QUẢN TRỊ (Đã áp dụng 3 Nguyên Tắc)
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

    // [ĐÃ SỬA] Hàm cập nhật trạng thái tích hợp rào chắn Backend
    public function capNhatTrangThai($id, $status) {
        $id = intval($id); 
        $status = intval($status);

        // Lấy thông tin trạng thái hiện tại của đơn hàng
        $don_hang = $this->layTheoId($id);
        if (!$don_hang) return false;
        
        $trang_thai_hien_tai = intval($don_hang['status']);

        // NGUYÊN TẮC 3 (ĐÓNG BĂNG): Nếu đơn đã giao (2) hoặc hủy (3) thì từ chối mọi lệnh Update
        if ($trang_thai_hien_tai == 2 || $trang_thai_hien_tai == 3) {
            return false;
        }

        // NGUYÊN TẮC 1 (TIẾN BƯỚC): Trạng thái mới phải lớn hơn trạng thái cũ (Ví dụ: Không được lùi từ 1 về 0)
        // (Ngoại trừ trường hợp hủy đơn bằng 3)
        if ($status < $trang_thai_hien_tai && $status != 3) {
            return false;
        }

        // Nếu vượt qua được các vòng kiểm tra trên thì mới cho phép Update
        return $this->conn->query("UPDATE orders SET status = $status WHERE id = $id");
    }

    // [THÊM MỚI] NGUYÊN TẮC 2 (HOÀN KHO): Hàm cộng lại số lượng giày vào kho khi Hủy đơn
    public function hoanLaiKho($id_don_hang) {
        $id_don_hang = intval($id_don_hang);
        
        // Bước 1: Lấy danh sách sản phẩm và số lượng từ bảng chi tiết đơn hàng
        $sql_get = "SELECT product_id, quantity FROM order_details WHERE order_id = $id_don_hang";
        $result = $this->conn->query($sql_get);

        if ($result && $result->num_rows > 0) {
            // Bước 2: Duyệt qua từng sản phẩm để cộng trả lại kho
            while ($item = $result->fetch_assoc()) {
                $pid = intval($item['product_id']);
                $qty = intval($item['quantity']);
                
                // Cập nhật lại cột quantity trong bảng products
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
}
?>