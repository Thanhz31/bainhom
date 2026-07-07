<?php
class ThongKeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDoanhThuTheoThang() {
        $sql = "SELECT MONTH(created_at) as thang, SUM(total_money) as doanh_thu 
                FROM orders WHERE status = 2 GROUP BY MONTH(created_at)";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTopSanPhamBanChay() {
        $sql = "SELECT name, sold_count, (price * sold_count) AS revenue 
                FROM products ORDER BY sold_count DESC LIMIT 5";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSanPhamTonKhoThap() {
        $sql = "SELECT name, quantity FROM products WHERE quantity < 10 ORDER BY quantity ASC LIMIT 5";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function demDonThanhCong() {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status = 2";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    public function getAllSanPhamBanChay() {
        $sql = "SELECT name, sold_count, (price * sold_count) AS revenue 
                FROM products 
                ORDER BY sold_count DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>