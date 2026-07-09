<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../services/TaiKhoanComponent.php';
require_once '../services/DonHangComponent.php';
require_once '../models/NguoiDungModel.php'; 

class TaiKhoanController {
    private $taiKhoanService;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->taiKhoanService = new TaiKhoanComponent($this->db);
    }
    
    // Hàm đăng nhập
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

    // Hàm đăng xuất
    public function dang_xuat() {
        $this->taiKhoanService->dangXuat();
        header("Location: index.php");
    }

    // Hàm xem đơn hàng
    public function don_hang() {
        if (!isset($_SESSION['user'])) header("Location: index.php?controller=tai_khoan&action=dang_nhap");
        
        $dhService = new DonHangComponent($this->db);
        $orders = $dhService->layLichSu($_SESSION['user']['id']);
        
        require_once '../views/dung_chung/header.php';
        require_once '../views/tai_khoan/don_hang_cua_toi.php';
        require_once '../views/dung_chung/footer.php';
    }

    // Hàm đăng ký tài khoản mới có nhận thêm Email
    public function dang_ky() {
        $error = ''; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password']; 
            $full_name = $_POST['full_name'];
            $email     = $_POST['email']; 
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $nguoiDungModel = new NguoiDungModel($this->db);

            if ($nguoiDungModel->kiemTraTenDangNhapTonTai($username)) {
                $error = "Tên đăng nhập này đã có người sử dụng. Vui lòng chọn tên khác!";
            } else {
                if ($nguoiDungModel->dangKy($username, $password, $full_name, $email, $phone, $address)) {
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
        require_once '../views/dung_chung/footer.php';
    }

    // Hàm quên mật khẩu chuẩn (Chỉ xuất hiện đúng 1 lần duy nhất)
    public function quen_mat_khau() {
        $error = null;
        $success = null;

        if (isset($_POST['btn_submit_email'])) {
            $username = $_POST['forgo_username'];
            $email = $_POST['forgo_email'];

            $sql = "SELECT * FROM users WHERE username = ? AND email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                
                require_once '../libs/PHPMailer/Exception.php';
                require_once '../libs/PHPMailer/PHPMailer.php';
                require_once '../libs/PHPMailer/SMTP.php';

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    
                    // Bạn điền lại thông tin tài khoản Gmail hệ thống của bạn ở đây:
                    $mail->Username   = 'sonenalymbph@gmail.com'; 
                    $mail->Password   = 'zpli pqwb bhcl ohos';    
                    
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('sonenalymbph@gmail.com', 'Hệ Thống MYShop'); 
                    $mail->addAddress($email); 

                    $matKhauMoi = rand(100000, 999999);

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

                    $mail->send();

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

        require_once '../views/tai_khoan/quen_mat_khau.php';
    }
}
?>