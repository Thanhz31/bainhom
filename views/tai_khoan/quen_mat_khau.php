<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khôi phục mật khẩu qua Email</title>
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
                            <i class="fa-solid fa-envelope-open-text" style="font-size: 3rem; color: #dc3545;"></i>
                            <h2 class="fw-bold text-uppercase mt-2">QUÊN MẬT KHẨU</h2>
                            <p class="text-muted">Hệ thống sẽ gửi mật khẩu mới trực tiếp vào Gmail của bạn</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger text-center py-2 small"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <?php if(!empty($success)): ?>
                            <div class="alert alert-success text-center py-3 small"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <form action="index.php?controller=tai_khoan&action=quen_mat_khau" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" name="forgo_username" class="form-control" placeholder="Nhập tên đăng nhập của bạn" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Địa chỉ Email đăng ký</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="forgo_email" class="form-control" placeholder="Nhập chính xác email để nhận mật khẩu" required>
                                </div>
                            </div>
                            
                            <button type="submit" name="btn_submit_email" class="btn btn-danger btn-lg w-100 py-2">
                                <i class="fa-solid fa-paper-plane"></i> &nbsp; GỬI MẬT KHẨU QUA EMAIL
                            </button>
                            
                            <div class="text-center mt-4 pt-3 border-top">
                                <a href="index.php?controller=tai_khoan&action=dang_nhap" class="text-decoration-none text-danger fw-bold">
                                    <i class="fa-solid fa-arrow-left"></i> Quay lại trang Đăng nhập
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