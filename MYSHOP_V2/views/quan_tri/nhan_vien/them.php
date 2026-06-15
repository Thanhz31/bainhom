<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2 mt-4">
    <h2 class="text-uppercase"><i class="fas fa-user-plus"></i> Thêm Nhân Viên Mới</h2>
    <a href="index.php?controller=nhan_vien" class="btn btn-secondary fw-bold">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="card shadow border-0" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Cấp tài khoản mới</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger fw-bold"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=nhan_vien&action=them" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập (Username) <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản..." required>
                <small class="text-muted">Nhân viên sẽ dùng tên này để đăng nhập vào hệ thống.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu khởi tạo <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control" value="123456" required>
                <small class="text-muted">Mặc định là 123456, bạn có thể đổi thành mật khẩu khác.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Quyền hạn hệ thống</label>
                <input type="text" class="form-control" value="Nhân viên (Chỉ xem đơn hàng, kho)" disabled>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" name="btn_them" class="btn btn-success fw-bold px-4 py-2">
                    <i class="fas fa-check-circle"></i> Tạo Tài Khoản
                </button>
            </div>
        </form>
    </div>
</div>