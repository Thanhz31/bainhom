<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <div class="login-page">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    
                    <div class="login-card">
                        
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-key login-logo"></i>
                            <h2 class="fw-bold text-uppercase">QUÊN MẬT KHẨU</h2>
                            <p class="text-muted">Nhập thông tin để khôi phục mật khẩu tài khoản</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger text-center py-2 small"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if(!empty($success)): ?>
                            <div class="alert alert-success text-center py-2 small"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <form action="index.php?controller=tai_khoan&action=quen_mat_khau" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại đã đăng ký" required>
                                </div>
                            </div>
                            
                            <button type="submit" name="forgot_password" class="btn btn-danger btn-lg w-100 py-2">
                                <i class="fa-solid fa-paper-plane"></i> &nbsp; XÁC MINH TÀI KHOẢN
                            </button>
                            
                            <div class="text-center mt-4 pt-3 border-top">
                                <a href="index.php?controller=tai_khoan&action=dang_nhap" class="text-decoration-none text-danger fw-bold">
                                    <i class="fa-solid fa-arrow-left"></i> Quay lại Đăng nhập
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>