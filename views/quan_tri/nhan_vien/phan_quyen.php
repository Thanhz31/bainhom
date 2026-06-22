<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2 mt-4">
    <h2 class="text-uppercase"><i class="fas fa-user-shield"></i> Cập Nhật Phân Quyền</h2>
    <a href="index.php?controller=nhan_vien" class="btn btn-secondary fw-bold">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="card shadow border-0" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Thông tin tài khoản</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=nhan_vien&action=phan_quyen&id=<?php echo $nhanVien['id']; ?>" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập (Username)</label>
                <input type="text" class="form-control" value="<?php echo $nhanVien['username']; ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control" value="<?php echo $nhanVien['password']; ?>" required>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" name="btn_cap_nhat" class="btn btn-primary fw-bold px-4">
                    <i class="fas fa-save"></i> Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>
</div>