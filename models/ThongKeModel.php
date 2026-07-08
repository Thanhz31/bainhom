<?php
class ThongKeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ==========================================
    // CÁC HÀM CÓ LỌC THỜI GIAN (DÙNG CHO BÁO CÁO)
    // ==========================================

    // Lấy tổng doanh thu trong khoảng thời gian (chỉ đơn thành công)
    public function getDoanhThuTong($tu, $den) {
        $sql = "SELECT SUM(total_money) as total FROM orders 
                WHERE status = 2 AND DATE(created_at) BETWEEN '$tu' AND '$den'";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_assoc()['total'] : 0;
    }

    // Đếm đơn thành công trong khoảng thời gian
    public function demDonThanhCong($tu, $den) {
        $sql = "SELECT COUNT(id) as total FROM orders 
                WHERE status = 2 AND DATE(created_at) BETWEEN '$tu' AND '$den'";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_assoc()['total'] : 0;
    }

    public function getTopSanPhamBanChay($tu, $den) {
    $sql = "SELECT p.name, SUM(od.quantity) AS sold_count, 
                   SUM(od.price * od.quantity) AS revenue
            FROM products p
            JOIN order_details od ON p.id = od.product_id
            JOIN orders o ON od.order_id = o.id
            WHERE DATE(o.created_at) BETWEEN '$tu' AND '$den'
            GROUP BY p.id ORDER BY sold_count DESC"; // Đã bỏ status = 2
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

    // ==========================================
    // CÁC HÀM TỔNG QUAN (DÙNG CHO DASHBOARD)
    // ==========================================

    // Doanh thu theo tháng của năm hiện tại (dùng cho biểu đồ Dashboard)
    public function getDoanhThuTheoThang() {
        $sql = "SELECT MONTH(created_at) as month, SUM(total_money) as revenue 
                FROM orders 
                WHERE status = 2 AND YEAR(created_at) = YEAR(CURRENT_DATE()) 
                GROUP BY MONTH(created_at)";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Lấy sản phẩm tồn kho thấp (dùng để cảnh báo)
    public function getSanPhamTonKhoThap() {
        $sql = "SELECT name, quantity FROM products WHERE quantity < 10 ORDER BY quantity ASC LIMIT 5";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Lấy tất cả sản phẩm bán chạy (không lọc thời gian, dùng cho xuất Excel)
    public function getAllSanPhamBanChay() {
        $sql = "SELECT name, sold_count, (price * sold_count) AS revenue
                FROM products ORDER BY sold_count DESC";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getSanPhamBanChayTheoKhoang($tu, $den) {
    $sql = "SELECT p.name, SUM(od.quantity) AS sold_count, 
                   SUM(od.price * od.quantity) AS revenue
            FROM products p
            JOIN order_details od ON p.id = od.product_id
            JOIN orders o ON od.order_id = o.id
            WHERE o.status = 2 AND DATE(o.created_at) BETWEEN '$tu' AND '$den'
            GROUP BY p.id ORDER BY sold_count DESC";
    $result = $this->db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
}
?>
