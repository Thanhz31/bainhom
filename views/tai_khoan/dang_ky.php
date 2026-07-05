<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="/public/css/style.css"> 

<link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="register-page">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="register-card">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-cart-shopping register-logo"></i>
                            <h2>ĐĂNG KÝ</h2>
                            <p class="text-muted">Create your account and start shopping</p>
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" name="full_name" placeholder="Nhập họ và tên" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ (để giao hàng)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                    <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ giao hàng" required></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                                </div>
                            </div>

                           <button type="submit" name="register" class="btn btn-danger btn-lg w-100 mt-2">
                             <i class="fa-solid fa-user-plus"></i> &nbsp; ĐĂNG KÝ
                            </button>

                            <div class="text-center mt-3">
                                Đã có tài khoản? <a href="index.php?controller=tai_khoan&action=dang_nhap">Đăng nhập</a>
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