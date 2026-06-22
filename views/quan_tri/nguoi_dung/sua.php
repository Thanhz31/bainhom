<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h2><i class="fas fa-edit"></i> Sửa Thông Tin Người Dùng</h2>
    <a href="index.php?controller=nguoi_dung" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow border-0" style="max-width: 600px; margin: auto;">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <form action="index.php?controller=nguoi_dung&action=sua&id=<?php echo $khachHang['id']; ?>" method="POST">
            <div class="mb-3"><label class="fw-bold">Tên đăng nhập (Không thể sửa)</label><input type="text" class="form-control" value="<?php echo $khachHang['username']; ?>" disabled></div>
            <div class="mb-3"><label class="fw-bold">Mật khẩu *</label><input type="text" name="password" class="form-control" value="<?php echo $khachHang['password']; ?>" required></div>
            <div class="mb-3"><label class="fw-bold">Họ và tên *</label><input type="text" name="full_name" class="form-control" value="<?php echo $khachHang['full_name']; ?>" required></div>
            <div class="mb-3"><label class="fw-bold">Số điện thoại *</label><input type="text" name="phone" class="form-control" value="<?php echo $khachHang['phone']; ?>" required></div>
            <div class="mb-3"><label class="fw-bold">Địa chỉ *</label><textarea name="address" class="form-control" required><?php echo $khachHang['address']; ?></textarea></div>
            <button type="submit" name="btn_sua" class="btn btn-primary w-100 fw-bold">Lưu Thay Đổi</button>
        </form>
    </div>
</div>