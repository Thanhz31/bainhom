<?php
class DonHangModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- 1. HÀM QUẢN LÝ ĐƠN HÀNG CƠ BẢN ---
    public function taoDonHang($user_id, $name, $phone, $address, $total) {
        $uid = $user_id ? intval($user_id) : "NULL";
        $name = $this->conn->real_escape_string($name);
        $phone = $this->conn->real_escape_string($phone);
        $address = $this->conn->real_escape_string($address);
        $sql = "INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_money) 
                VALUES ($uid, '$name', '$phone', '$address', '$total')";
        return $this->conn->query($sql) ? $this->conn->insert_id : false;
    }

    public function luuChiTiet($order_id, $product_id, $price, $quantity) {
        $sql = "INSERT INTO order_details (order_id, product_id, price, quantity) 
                VALUES (".intval($order_id).", ".intval($product_id).", ".floatval($price).", ".intval($quantity).")";
        return $this->conn->query($sql);
    }

    public function layTatCa() {
        $result = $this->conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        $data = [];
        if ($result) { while($row = $result->fetch_assoc()) { $data[] = $row; } }
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
        if ($result) { while($row = $result->fetch_assoc()) { $data[] = $row; } }
        return $data;
    }

    public function capNhatTrangThai($id, $status) {
        return $this->conn->query("UPDATE orders SET status = ".intval($status)." WHERE id = ".intval($id));
    }

    public function hoanLaiKho($id_don_hang) {
        $id_don_hang = intval($id_don_hang);
        $sql_get = "SELECT product_id, quantity FROM order_details WHERE order_id = $id_don_hang";
        $result = $this->conn->query($sql_get);
        if ($result && $result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $this->conn->query("UPDATE products SET quantity = quantity + " . intval($item['quantity']) . " WHERE id = " . intval($item['product_id']));
            }
        }
    }

    // --- 2. HÀM THỐNG KÊ (DASHBOARD) ---
    public function tinhTongDoanhThu() {
        $res = $this->conn->query("SELECT SUM(total_money) as total FROM orders WHERE status = 2");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['total'] : 0;
    }

    public function demDonChoDuyet() {
        $res = $this->conn->query("SELECT COUNT(id) as count FROM orders WHERE status = 0");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }

    public function timKiemDonHangAdmin($tu_khoa) {
        $tk = $this->conn->real_escape_string($tu_khoa);
        $sql = "SELECT * FROM orders WHERE id LIKE '%$tk%' OR customer_name LIKE '%$tk%' OR customer_phone LIKE '%$tk%' ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) { while($row = $result->fetch_assoc()) { $data[] = $row; } }
        return $data;
    }

    public function layCacNamCoDoanhThu() {
        $sql = "SELECT DISTINCT YEAR(created_at) as nam FROM orders WHERE status = 2 ORDER BY nam DESC";
        $result = $this->conn->query($sql);
        $years = [];
        if ($result) { while($row = $result->fetch_assoc()) { $years[] = $row['nam']; } }
        return empty($years) ? [date('Y')] : $years;
    }

    public function thongKeDoanhThuTheoThang($year = null) {
        $year = $year ?: date('Y');
        $sql = "SELECT MONTH(created_at) as thang, SUM(total_money) as doanh_thu FROM orders 
                WHERE status = 2 AND YEAR(created_at) = " . intval($year) . " GROUP BY MONTH(created_at)";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) { while($row = $result->fetch_assoc()) { $data[$row['thang']] = $row['doanh_thu']; } }
        return $data;
    }

    public function thongKeTrangThaiDonHang() {
        $sql = "SELECT status, COUNT(id) as so_luong FROM orders GROUP BY status";
        $result = $this->conn->query($sql);
        $data = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; 
        if ($result) { while($row = $result->fetch_assoc()) { $data[$row['status']] = $row['so_luong']; } }
        return $data;
    }

    // --- 3. HÀM CHỨC NĂNG HOÀN TIỀN (MỚI) ---
    public function luuThongTinHoanTien($order_id, $amount, $reason) {
        $sql = "INSERT INTO order_refunds (order_id, refund_amount, reason) VALUES (".intval($order_id).", ".floatval($amount).", '".$this->conn->real_escape_string($reason)."')";
        return $this->conn->query($sql);
    }

    public function capNhatTrangThaiThanhToan($order_id, $payment_status) {
        return $this->conn->query("UPDATE orders SET payment_status = ".intval($payment_status)." WHERE id = ".intval($order_id));
    }

    public function xuLyHoanTien($order_id, $amount, $reason) {
        $order = $this->layTheoId($order_id);
        if (!$order || $order['payment_status'] == 2) return false;

        $saved = $this->luuThongTinHoanTien($order_id, $amount, $reason);
        $updated = $this->capNhatTrangThaiThanhToan($order_id, 2);
        $this->hoanLaiKho($order_id);

        return $saved && $updated;
    }
}
?>