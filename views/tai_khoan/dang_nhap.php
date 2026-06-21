<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow" style="max-width: 400px; margin: auto;">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">ĐĂNG NHẬP</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="index.php?controller=tai_khoan&action=dang_nhap" method="POST">
                    <div class="mb-3">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Đăng Nhập</button>
                    
                    <div class="text-center mt-3 pt-2 border-top">
                        <small class="text-muted">Chưa có tài khoản?</small><br>
                        <a href="index.php?controller=tai_khoan&action=dang_ky" class="text-decoration-none text-danger">Đăng ký thành viên mới</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>