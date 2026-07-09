<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .register-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('uploads/anh_dangky.jpg') no-repeat center center/cover;
            padding: 40px 20px;
        }
        .register-card {
            width: 100%;
            max-width: 550px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,.15);
        }
    </style>
</head>
<body>
    <div class="register-page">
        <div class="register-card">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase text-danger">ĐĂNG KÝ TÀI KHOẢN</h2>
                <p class="text-muted">Vui lòng điền đầy đủ thông tin bên dưới</p>
            </div>

            <?php if(!empty($error)): ?>
                <div class="alert alert-danger text-center py-2 small"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="index.php?controller=tai_khoan&action=dang_ky" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Tên đăng nhập (Username)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Họ và tên</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                        <input type="text" name="full_name" class="form-control" placeholder="Nhập đầy đủ họ và tên" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Ví dụ: nguyenvana@gmail.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Địa chỉ cư trú</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ của bạn" required>
                    </div>
                </div>

                <button type="submit" name="register" class="btn btn-danger btn-lg w-100 py-2 fw-bold">
                    <i class="fa-solid fa-user-plus"></i> &nbsp;ĐĂNG KÝ NGAY
                </button>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted mb-0">Đã có tài khoản? 
                        <a href="index.php?controller=tai_khoan&action=dang_nhap" class="text-decoration-none text-danger fw-bold">Đăng nhập</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
