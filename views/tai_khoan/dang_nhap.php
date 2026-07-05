<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">

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
    <div class="login-page-custom" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('uploads/anh_dangky.jpg') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="login-card-custom">
                        
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #dc3545;"></i>
                            <h2 class="fw-bold text-uppercase mt-2">ĐĂNG NHẬP</h2>
                            <p class="text-muted">Welcome back! Please login to your account</p>
                        </div>

                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger text-center py-2 small"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="index.php?controller=tai_khoan&action=dang_nhap" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 small">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label text-muted" for="rememberMe">Ghi nhớ đăng nhập</label>
                                </div>
                                <a href="index.php?controller=tai_khoan&action=quen_mat_khau" class="text-danger text-decoration-none fw-bold">
                                    Quên mật khẩu?
                                </a>
                            </div>
                            
                            <button type="submit" name="login" class="btn btn-danger btn-lg w-100 py-2">
                                <i class="fa-solid fa-right-to-bracket"></i> &nbsp; ĐĂNG NHẬP
                            </button>
                            
                            <div class="text-center mt-4 pt-3 border-top">
                                <small class="text-muted">Chưa có tài khoản?</small><br>
                                <a href="index.php?controller=tai_khoan&action=dang_ky" class="text-decoration-none text-danger fw-bold">
                                    Đăng ký thành viên mới
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