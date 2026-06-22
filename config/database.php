<?php
class Database {
    // Thông tin cấu hình (Lấy từ file db.php cũ của bạn)
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $dbname = "myshop";
    public $conn;

    // Hàm thực hiện kết nối
    public function getConnection() {
        $this->conn = null;

        try {
            // Khởi tạo kết nối MySQLi
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            
            // Kiểm tra lỗi kết nối
            if ($this->conn->connect_error) {
                throw new Exception("Kết nối thất bại: " . $this->conn->connect_error);
            }

            // Thiết lập font chữ tiếng Việt chuẩn utf8
            $this->conn->set_charset("utf8");

        } catch (Exception $e) {
            echo "Lỗi hệ thống: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>