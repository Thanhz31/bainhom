<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow" style="max-width: 500px; margin: auto;">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Đăng ký thành viên</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=tai_khoan&action=dang_ky" method="POST">
                    <div class="mb-3">
                        <label>Họ và tên</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Địa chỉ (Để giao hàng)</label>
                        <textarea name="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Đăng Ký</button>
                    <div class="text-center mt-3">
                        <a href="index.php?controller=tai_khoan&action=dang_nhap">Đã có tài khoản? Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>