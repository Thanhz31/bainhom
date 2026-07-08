<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../style.css"> 

    <style>
        .login-page-custom {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .login-card-custom {
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,.15);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="login-page-custom" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('../uploads/anh_dangky.jpg') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="login-card-custom">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-user-plus" style="font-size: 3rem; color: #dc3545;"></i>
                            <h2 class="fw-bold text-uppercase mt-2">ĐĂNG KÝ</h2>
                            <p class="text-muted">Tạo tài khoản để bắt đầu mua sắm</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger text-center py-2 small"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="index.php?controller=tai_khoan&action=dang_ky" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" name="full_name" placeholder="Nhập họ và tên" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="Nhập email để nhận lại mật khẩu khi quên" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Địa chỉ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                    <textarea class="form-control" name="address" rows="2" placeholder="Nhập địa chỉ giao hàng" required></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                           <button type="submit" name="register" class="btn btn-danger btn-lg w-100 mt-3 py-2">
                             <i class="fa-solid fa-user-check"></i> &nbsp; HOÀN TẤT ĐĂNG KÝ
                            </button>

                            <div class="text-center mt-4 pt-3 border-top">
                                <small class="text-muted">Đã có tài khoản?</small><br>
                                <a href="index.php?controller=tai_khoan&action=dang_nhap" class="text-decoration-none text-danger fw-bold">
                                    Quay lại trang Đăng nhập
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(){
            const password = document.getElementById("password");
            if(password.type === "password"){
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
    </script>
</body>
</html>