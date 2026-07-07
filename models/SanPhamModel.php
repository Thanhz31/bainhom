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
    // CÁC HÀM THÊM/SỬA/XÓA (MỚI BỔ SUNG CHO CONTROLLER)
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
    // CÁC HÀM DÙNG CHO TRANG CHỦ
    // ==========================================
    public function laySanPhamGiaRe() {
        return $this->db->query("SELECT * FROM products ORDER BY price ASC LIMIT 4");
    }

    public function locSanPhamTrangChu($cat_id, $keyword) {
        $where_clause = "1=1";
        if ($cat_id !== null) {
            $cat_id = intval($cat_id);
            $where_clause .= " AND category_id = $cat_id";
        }
        if ($keyword !== null && $keyword !== '') {
            $safe_keyword = $this->db->real_escape_string($keyword);
            $where_clause .= " AND name LIKE '%$safe_keyword%'";
        }
        return $this->db->query("SELECT * FROM products WHERE $where_clause ORDER BY id DESC");
    }
    
    public function demTongSanPham() {
        $res = $this->db->query("SELECT COUNT(id) as count FROM products");
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['count'] : 0;
    }

    // ==========================================
    // HÀM MỚI BỔ SUNG: LẤY BÌNH LUẬN ĐÁNH GIÁ SẢN PHẨM
    // ==========================================
    public function layBinhLuanTheoSanPham($product_id) {
        $product_id = intval($product_id); // Chống SQL Injection
        
        // Câu lệnh SQL kéo dữ liệu từ bảng reviews và bảng users
        $sql = "SELECT r.*, u.full_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = $product_id 
                ORDER BY r.created_at DESC";
                
        $result = $this->db->query($sql);
        $reviews = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }
// HÀM ĐÃ SỬA: Tự động cập nhật avg_rating và review_count
    public function themDanhGia($product_id, $user_id, $order_id, $rating, $comment) {
        $product_id = intval($product_id);
        $user_id = intval($user_id);
        $order_id = intval($order_id);
        $rating = intval($rating);
        $comment = $this->db->real_escape_string($comment);

        // 1. Kiểm tra xem người dùng đã đánh giá đơn hàng này chưa
        $check = $this->db->query("SELECT id FROM reviews WHERE product_id = $product_id AND order_id = $order_id AND user_id = $user_id");
        if ($check && $check->num_rows > 0) {
            return false;
        }

        // 2. Thêm đánh giá vào bảng reviews
        $sql = "INSERT INTO reviews (product_id, user_id, order_id, rating, comment, created_at) 
                VALUES ($product_id, $user_id, $order_id, $rating, '$comment', NOW())";
        
        if ($this->db->query($sql)) {
            // 3. CẬP NHẬT ĐIỂM TRUNG BÌNH VÀ SỐ LƯỢT ĐÁNH GIÁ VÀO BẢNG products
            $update_sql = "UPDATE products SET 
                           avg_rating = (SELECT AVG(rating) FROM reviews WHERE product_id = $product_id),
                           review_count = (SELECT COUNT(id) FROM reviews WHERE product_id = $product_id)
                           WHERE id = $product_id";
            $this->db->query($update_sql);
            return true;
        }
        return false;
    }
}
?>