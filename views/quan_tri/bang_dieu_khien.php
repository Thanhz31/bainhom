<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
    <h2 class="text-uppercase m-0"><i class="fas fa-tachometer-alt text-primary"></i> Dashboard</h2>
    <div class="d-flex align-items-center gap-3">
        <span>Xin chào, 
            <strong><?php echo $_SESSION['admin_user']; ?></strong> 
            <?php if(isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 1): ?>
                <span class="badge bg-danger">Admin</span>
            <?php else: ?>
                <span class="badge bg-secondary">Nhân viên</span>
            <?php endif; ?>
        </span>
        <a href="index.php?controller=tai_khoan&action=dang_xuat" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>
</div>

<div class="row mb-4">
    <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 1): ?>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success shadow h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title text-uppercase fw-bold">Tổng Doanh Thu</h5>
                    <p class="card-text small">(Đơn thành công)</p>
                </div>
                <h3 class="fw-bold m-0"><?php echo number_format($revenue ? $revenue : 0); ?> ₫</h3>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-4 mb-3">
        <div class="card text-dark bg-warning shadow h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title text-uppercase fw-bold">Đơn Chờ Duyệt</h5>
                    <p class="card-text small">(Cần xử lý ngay)</p>
                </div>
                <h3 class="fw-bold m-0"><?php echo isset($pending) ? $pending : 0; ?> Đơn</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info shadow h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title text-uppercase fw-bold">Tổng Sản Phẩm</h5>
                    <p class="card-text small">(Đang bán trên web)</p>
                </div>
                <h3 class="fw-bold m-0"><?php echo isset($total_products) ? $total_products : 0; ?> Mẫu</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4 bg-light">
    <div class="card-body d-flex justify-content-center gap-3">
        <a href="index.php?controller=danh_muc" class="btn btn-info text-white"><i class="fas fa-tags"></i> Quản lý Danh mục</a>
        <a href="index.php?controller=san_pham" class="btn btn-primary"><i class="fas fa-boxes"></i> Quản lý sản phẩm</a> 
        <a href="index.php?controller=nguoi_dung" class="btn btn-secondary"><i class="fas fa-users"></i> Người Dùng</a>  
        <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 1): ?>
            <a href="index.php?controller=nhan_vien" class="btn btn-dark"><i class="fas fa-user-tie"></i> Nhân sự</a>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="m-0 text-uppercase fw-bold text-secondary"><i class="fas fa-list-alt text-primary"></i> Danh sách Đơn hàng</h4>
        <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
            <small class="text-danger fw-bold">Hiển thị kết quả cho: '<?php echo htmlspecialchars($_GET['keyword']); ?>'</small>
        <?php endif; ?>
    </div>
    
    <form action="index.php" method="GET" class="m-0" style="min-width: 350px;">
        <input type="hidden" name="controller" value="don_hang">
        <input type="hidden" name="action" value="tim_kiem">
        
        <div class="input-group shadow-sm">
            <input type="text" name="keyword" class="form-control border-primary" placeholder="Tên, SĐT hoặc Mã đơn..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" required>
            
            <button type="submit" class="btn btn-primary px-3" title="Tìm kiếm">
                <i class="fas fa-search"></i>
            </button>
            
            <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
                <a href="index.php?controller=quan_tri" class="btn btn-outline-danger px-3" title="Hủy tìm kiếm">
                    <i class="fas fa-times"></i>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0 align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Mã đơn</th>
                    <th>Thông tin Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): foreach($orders as $row): 
                    $stt = $row['status'];
                    $badge = "";
                    if ($stt == 0) $badge = '<span class="badge bg-secondary">Chờ duyệt</span>';
                    elseif ($stt == 1) $badge = '<span class="badge bg-primary">Đang giao</span>';
                    elseif ($stt == 2) $badge = '<span class="badge bg-success">Đã giao (Thành công)</span>';
                    elseif ($stt == 3) $badge = '<span class="badge bg-danger">Đã hủy</span>';
                ?>
                <tr>
                    <td class="text-center fw-bold">#<?php echo $row['id']; ?></td>
                    <td>
                        <strong><?php echo $row['customer_name']; ?></strong><br>
                        <small class="text-muted"><i class="fas fa-phone-alt"></i> <?php echo $row['customer_phone']; ?></small>
                    </td>
                    <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></td>
                    <td class="text-end text-danger fw-bold"><?php echo number_format($row['total_money']); ?> ₫</td>
                    <td class="text-center"><?php echo $badge; ?></td>
                    <td class="text-center">
                        <a href="index.php?controller=don_hang&action=chi_tiet&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Xem & Xử lý
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Không tìm thấy đơn hàng nào khớp với từ khóa!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>