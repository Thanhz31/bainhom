<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2 mt-4">
    <h2 class="text-uppercase"><i class="fas fa-edit"></i> Sửa Thông Tin Nhân Viên</h2>
    <a href="index.php?controller=nhan_vien" class="btn btn-secondary fw-bold">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card shadow border-0" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Cập nhật tài khoản</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger fw-bold"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=nhan_vien&action=sua&id=<?php echo $nhanVien['id']; ?>" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập (Username) <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" value="<?php echo $nhanVien['username']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control" value="<?php echo $nhanVien['password']; ?>" required>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" name="btn_sua" class="btn btn-primary fw-bold px-4 py-2">
                    <i class="fas fa-save"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>