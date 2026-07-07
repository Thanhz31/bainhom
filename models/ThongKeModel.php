<?php
class ThongKeModel {
    private $db;

    // Bắt buộc phải có hàm khởi tạo để nhận kết nối Database
    public function __construct($db) {
        $this->db = $db;
    }

    // ĐÃ SỬA: Bổ sung câu lệnh SQL lấy doanh thu theo từng tháng của năm hiện tại
    public function getDoanhThuTheoThang() {
        $sql = "SELECT MONTH(created_at) as month, SUM(total_money) as revenue 
                FROM orders 
                WHERE status = 2 AND YEAR(created_at) = YEAR(CURRENT_DATE()) 
                GROUP BY MONTH(created_at)";
        $result = $this->db->query($sql);
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getTopSanPhamBanChay() {
        $sql = "SELECT name, sold_count, (price * sold_count) AS revenue
                FROM products ORDER BY sold_count DESC LIMIT 5";
        $result = $this->db->query($sql);
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getSanPhamTonKhoThap() {
        $sql = "SELECT name, quantity FROM products WHERE quantity < 10 ORDER BY quantity ASC LIMIT 5";
        $result = $this->db->query($sql);
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function demDonThanhCong() {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status = 2";
        $result = $this->db->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        }
        return 0;
    }

    public function getAllSanPhamBanChay() {
        $sql = "SELECT name, sold_count, (price * sold_count) AS revenue
                FROM products
                ORDER BY sold_count DESC";
        $result = $this->db->query($sql);
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>