<?php
class DanhMucModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function layTatCa() {
        return $this->db->query("SELECT * FROM categories ORDER BY id ASC");
    }

    public function kiemTraTen($name) {
        return $this->db->query("SELECT * FROM categories WHERE name = '$name'");
    }

    public function them($name) {
        return $this->db->query("INSERT INTO categories (name) VALUES ('$name')");
    }

    public function coSanPham($id) {
        $check = $this->db->query("SELECT * FROM products WHERE category_id = $id");
        return $check->num_rows > 0;
    }

    public function xoa($id) {
        return $this->db->query("DELETE FROM categories WHERE id = $id");
    }

    // Bổ sung hàm lấy tên Danh mục cho Trang chủ
    public function layTheoId($id) {
        $id = intval($id);
        $res = $this->db->query("SELECT * FROM categories WHERE id = $id");
        return $res ? $res->fetch_assoc() : null;
    }
}
?>