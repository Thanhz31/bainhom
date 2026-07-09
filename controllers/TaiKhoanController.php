<?php
require_once '../services/TaiKhoanComponent.php';
require_once '../services/DonHangComponent.php';
require_once '../models/NguoiDungModel.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class TaiKhoanController {
    private $taiKhoanService;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->taiKhoanService = new TaiKhoanComponent($this->db);
    }
    

    // Giữ nguyên hàm đăng nhập của bạn
    public function dang_nhap() {
        if (isset($_POST['login'])) {
            $res = $this->taiKhoanService->dangNhap($_POST['username'], $_POST['password']);
            if ($res) {
                $target = ($res['role'] == 'admin') ? 'index.php?controller=quan_tri' : 'index.php';
                header("Location: $target");
                exit();
            }
            $error = "Sai tài khoản hoặc mật khẩu!";
        }
        require_once '../views/tai_khoan/dang_nhap.php';
    }

    // Giữ nguyên hàm đăng xuất của bạn
    public function dang_xuat() {
        $this->taiKhoanService->dangXuat();
        header("Location: index.php");
    }

    // Giữ nguyên hàm xem đơn hàng của bạn
    public function don_hang() {
        if (!isset($_SESSION['user'])) header("Location: index.php?controller=tai_khoan&action=dang_nhap");
        
        $dhService = new DonHangComponent($this->db);
        $orders = $dhService->layLichSu($_SESSION['user']['id']);
        
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/don_hang_cua_toi.php';
        require_once '../views/dung_chung/footer.php';
    }

    // Hàm đăng ký đã được làm sạch SQL
// Hàm đăng ký đã cập nhật nhận Email
    public function dang_ky() {
        $error = ''; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']); // <-- Bắt email từ form gửi lên
            $password = $_POST['password']; 
            $full_name = trim($_POST['full_name']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            $nguoiDungModel = new NguoiDungModel($this->db);

            if ($nguoiDungModel->kiemTraTenDangNhapTonTai($username)) {
                $error = "Tên đăng nhập này đã có người sử dụng. Vui lòng chọn tên khác!";
            } else {
                // <-- Truyền thêm biến $email vào model
                if ($nguoiDungModel->dangKy($username, $email, $password, $full_name, $phone, $address)) {
                    echo "<script>
                            alert('Chúc mừng bạn đã đăng ký tài khoản thành công!'); 
                            window.location.href='index.php?controller=tai_khoan&action=dang_nhap';
                          </script>";
                    exit();
                } else {
                    $error = "Có lỗi hệ thống xảy ra, vui lòng thử lại sau!";
                }
            }
        }
        require_once '../views/tai_khoan/dang_ky.php';
        // (Chú ý: Mình đã xóa dòng require_once footer ở đây để form đăng ký không bị chèn phần chân trang gây vỡ giao diện)
    }
     // <<< CHỨC NĂNG QUÊN MẬT KHẨU MỚI THÊM VÀO >>>

    // Hàm xử lý hiển thị form và xác minh Quên mật khẩu
    public function quen_mat_khau() {
        $error = null;
        $success = null;

        if (isset($_POST['btn_submit_email'])) {
            $username = $_POST['forgo_username'];
            $email = $_POST['forgo_email'];

            // 1. Kiểm tra tài khoản và email trùng khớp trong bảng `users` bằng MySQLi
            $sql = "SELECT * FROM users WHERE username = ? AND email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                
                // 2. Nhúng thư viện PHPMailer từ thư mục libs
                require_once '../libs/PHPMailer/Exception.php';
                require_once '../libs/PHPMailer/PHPMailer.php';
                require_once '../libs/PHPMailer/SMTP.php';

                $mail = new PHPMailer(true);

                try {
                    // --- CẤU HÌNH MÁY CHỦ SMTP CỦA GOOGLE ---
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    
                    // XỬ LÝ: Hãy điền thông tin Gmail và mã 16 ký tự mật khẩu ứng dụng của bạn vào đây
                    $mail->Username   = 'sonenalymbph@gmail.com'; // <--- Thay bằng Gmail thật của bạn
                    $mail->Password   = 'zpli pqwb bhcl ohos';    // <--- Thay bằng 16 ký tự mật khẩu ứng dụng bạn lấy được từ link trực tiếp
                    
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->CharSet    = 'UTF-8'; // Giúp tiếng Việt hiển thị không bị lỗi font

                    // Cấu hình người gửi và người nhận
                    $mail->setFrom('sonenalymbph@gmail.com', 'Hệ Thống MYShop'); // Thay email gửi bằng gmail của bạn luôn
                    $mail->addAddress($email); // Email người nhận (Lấy từ ô nhập của khách)

                    // Tạo mật khẩu mới ngẫu nhiên gồm 6 chữ số
                    $matKhauMoi = rand(100000, 999999);

                    // Nội dung email định dạng HTML gửi cho khách
                    $mail->isHTML(true);
                    $mail->Subject = 'Khôi phục lại mật khẩu mới hệ thống MYShop';
                    $mail->Body    = "
                        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; max-width: 500px; border-radius: 8px;'>
                            <h3 style='color: #dc3545; text-align: center;'>YÊU CẦU CẤP LẠI MẬT KHẨU</h3>
                            <p>Chào bạn <b>$username</b>,</p>
                            <p>Hệ thống đã xác nhận thông tin của bạn thành công. Mật khẩu đăng nhập mới của bạn là:</p>
                            <div style='background: #f8f9fa; padding: 15px; font-size: 24px; font-weight: bold; color: #dc3545; text-align: center; border: 1px dashed #dc3545; margin: 15px 0;'>
                                $matKhauMoi
                            </div>
                            <p style='color: #6c757d; font-size: 13px;'><i>Vui lòng đăng nhập lại hệ thống bằng mật khẩu này và thực hiện đổi mật khẩu cá nhân mới ngay để bảo mật thông tin.</i></p>
                        </div>
                    ";

                    // Thực hiện lệnh gửi thư đi
                    $mail->send();

                    // 3. Tiến hành cập nhật mật khẩu mới này vào bảng `users` trong database
                    $sql_update = "UPDATE users SET password = ? WHERE username = ?";
                    $stmt_update = $this->db->prepare($sql_update);
                    $stmt_update->bind_param("ss", $matKhauMoi, $username);
                    $stmt_update->execute();

                    $success = "Hệ thống đã gửi mật khẩu mới vào hòm thư <b>$email</b>. Bạn hãy mở Gmail lên kiểm tra nhé!";
                } catch (Exception $e) {
                    $error = "Gửi thư thất bại. Lỗi kỹ thuật hệ thống: {$mail->ErrorInfo}";
                }

            } else {
                $error = "Thông tin không chính xác! Tên đăng nhập hoặc Email không tồn tại trên hệ thống.";
            }
        }

        // Gọi file giao diện hiển thị form lên màn hình
        require_once '../views/tai_khoan/quen_mat_khau.php';
    }
        // BẠN DÁN ĐOẠN NÀY VÀO TRONG CLASS TaiKhoanController
    public function chi_tiet_don_hang() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=tai_khoan&action=dang_nhap");
            exit();
        }

        // 2. Lấy ID đơn hàng từ URL
        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // 3. Khởi tạo Service để lấy dữ liệu
        $dhService = new DonHangComponent($this->db);
        
        // 4. Lấy thông tin đơn hàng và chi tiết đơn hàng
        $order_info = $dhService->layChiTietDonHang($order_id);
        $details = $dhService->layChiTietSanPhamDonHang($order_id);

        // 5. Kiểm tra xem đơn hàng có thuộc về user này không (bảo mật)
        if (!$order_info || $order_info['user_id'] != $_SESSION['user']['id']) {
            die("Đơn hàng không tồn tại hoặc bạn không có quyền truy cập!");
        }

        // 6. Hiển thị view
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/chi_tiet_don_hang.php';
        require_once '../views/dung_chung/footer.php';
    }
    
}
?>