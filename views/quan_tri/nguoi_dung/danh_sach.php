<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2 mt-4">
    <h2 class="text-uppercase m-0"><i class="fas fa-users text-primary"></i> Quản Lý Người Dùng</h2>
    
    <div class="d-flex align-items-center gap-2">
        <form action="index.php" method="GET" class="m-0" style="min-width: 320px;">
            <input type="hidden" name="controller" value="nguoi_dung">
            <input type="hidden" name="action" value="tim_kiem">
            
            <div class="input-group shadow-sm">
                <input type="text" name="keyword" class="form-control border-primary" placeholder="Tên, Username hoặc SĐT..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" required>
                
                <button type="submit" class="btn btn-primary px-3" title="Tìm kiếm">
                    <i class="fas fa-search"></i>
                </button>

                <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
                    <a href="index.php?controller=nguoi_dung" class="btn btn-outline-danger px-3" title="Hủy tìm kiếm">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary fw-bold text-nowrap shadow-sm">
            <i class="fas fa-arrow-left"></i> Về Dashboard
        </a>
        <a href="index.php?controller=nguoi_dung&action=them" class="btn btn-success fw-bold text-nowrap shadow-sm">
            <i class="fas fa-plus"></i> Thêm Người dùng
        </a>
    </div>
</div>

<?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
    <div class="mb-3">
        <span class="text-danger fw-bold"><i class="fas fa-filter"></i> Kết quả tìm kiếm cho: '<?php echo htmlspecialchars($_GET['keyword']); ?>'</span>
    </div>
<?php endif; ?>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0 align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Liên hệ</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($danhSach)): foreach($danhSach as $kh): ?>
                <tr>
                    <td class="text-center fw-bold"><?php echo $kh['id']; ?></td>
                    <td><?php echo $kh['username']; ?></td>
                    <td><strong class="text-primary"><?php echo $kh['full_name']; ?></strong></td>
                    <td class="text-center"><?php echo $kh['phone']; ?></td>
                    <td><?php echo $kh['address']; ?></td>
                   <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="index.php?controller=nguoi_dung&action=sua&id=<?php echo $kh['id']; ?>" class="btn btn-sm btn-warning text-dark shadow-sm px-2 py-1">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <a href="index.php?controller=nguoi_dung&action=xoa&id=<?php echo $kh['id']; ?>" class="btn btn-sm btn-danger shadow-sm px-2 py-1" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
            <i class="fas fa-trash-alt"></i> Xóa
        </a>
    </div>
</td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Không tìm thấy người dùng nào khớp với từ khóa!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>