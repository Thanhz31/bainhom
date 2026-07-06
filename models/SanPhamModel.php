<?php
class SanPhamModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ==========================================
    // CÁC HÀM CŨ (DÙNG CHO ADMIN & ĐẶT HÀNG)
    // ==========================================
    public function layTatCa() {
        return $this->db->query("SELECT * FROM products ORDER BY id DESC");
    }

    public function layTheoId($id) {
        $id = intval($id);
        $res = $this->db->query("SELECT * FROM products WHERE id = $id");
        return $res ? $res->fetch_assoc() : null;
    }

    public function capNhatKho($id, $qty) {
        $id = intval($id);
        $qty = intval($qty);
        $sql = "UPDATE products SET quantity = quantity - $qty, sold_count = sold_count + $qty WHERE id = $id";
        return $this->db->query($sql);
    }

    public function timKiemSanPham($tu_khoa) {
        $tu_khoa = addslashes($tu_khoa); 
        $sql = "SELECT * FROM products WHERE name LIKE '%$tu_khoa%' ORDER BY id DESC";
        $result = $this->db->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { $data[] = $row; }
        }
        return $data;
    }

    // ==========================================
    // CÁC HÀM THÊM/SỬA/XÓA 
    // ==========================================
    public function themSanPham($name, $price, $qty, $cat_id, $desc, $detail, $img) {
        $name = $this->db->real_escape_string($name);
        $desc = $this->db->real_escape_string($desc);
        $detail = $this->db->real_escape_string($detail);
        
        $sql = "INSERT INTO products (name, price, quantity, category_id, description, detail_desc, image) 
                VALUES ('$name', '$price', '$qty', '$cat_id', '$desc', '$detail', '$img')";
        return $this->db->query($sql);
    }

    public function suaSanPham($id, $name, $price, $qty, $cat_id, $desc, $detail, $img) {
        $id = intval($id);
        $name = $this->db->real_escape_string($name);
        $desc = $this->db->real_escape_string($desc);
        $detail = $this->db->real_escape_string($detail);
        
        $sql = "UPDATE products SET name='$name', price='$price', quantity='$qty', category_id='$cat_id', description='$desc', detail_desc='$detail', image='$img' WHERE id=$id";
        return $this->db->query($sql);
    }

    public function xoaSanPham($id) {
        $id = intval($id);
        return $this->db->query("DELETE FROM products WHERE id = $id");
    }

    public function timKiemAdmin($tu_khoa) {
        $tu_khoa = $this->db->real_escape_string(trim($tu_khoa));
        return $this->db->query("SELECT * FROM products WHERE name LIKE '%$tu_khoa%' ORDER BY id DESC");
    }

    // ==========================================
    // CÁC HÀM DÙNG CHO TRANG CHỦ (ĐÃ THÊM PHÂN TRANG)
    // ==========================================
    public function laySanPhamGiaRe() {
        return $this->db->query("SELECT * FROM products ORDER BY price ASC LIMIT 4");
    }

    // Đã cập nhật tham số offset và limit
    public function locSanPhamTrangChu($cat_id, $keyword, $offset = 0, $limit = 9) {
        $where_clause = "1=1";
        if ($cat_id !== null) {
            $cat_id = intval($cat_id);
            $where_clause .= " AND category_id = $cat_id";
        }
        if ($keyword !== null && $keyword !== '') {
            $safe_keyword = $this->db->real_escape_string($keyword);
            $where_clause .= " AND name LIKE '%$safe_keyword%'";
        }
        return $this->db->query("SELECT * FROM products WHERE $where_clause ORDER BY id DESC LIMIT $offset, $limit");
    }

    // Hàm đếm số lượng để xử lý thuật toán chia trang
    public function demSanPhamTrangChu($cat_id, $keyword) {
        $where_clause = "1=1";
        if ($cat_id !== null) {
            $cat_id = intval($cat_id);
            $where_clause .= " AND category_id = $cat_id";
        }
        if ($keyword !== null && $keyword !== '') {
            $safe_keyword = $this->db->real_escape_string($keyword);
            $where_clause .= " AND name LIKE '%$safe_keyword%'";
        }
        $res = $this->db->query("SELECT COUNT(id) as count FROM products WHERE $where_clause");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }

    // ==========================================
    // HÀM DÙNG CHO DASHBOARD ADMIN (ĐÃ KHÔI PHỤC)
    // ==========================================
    public function demTongSanPham() {
        $res = $this->db->query("SELECT COUNT(id) as count FROM products");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }
}
?>