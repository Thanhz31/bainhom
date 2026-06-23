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
        <a href="index.php?controller=don_hang" class="btn btn-warning text-dark fw-bold shadow-sm">
            <i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng
        </a>
        
        <a href="index.php?controller=danh_muc" class="btn btn-info text-white"><i class="fas fa-tags"></i> Quản lý Danh mục</a>
        <a href="index.php?controller=san_pham" class="btn btn-primary"><i class="fas fa-boxes"></i> Quản lý sản phẩm</a> 
        <a href="index.php?controller=nguoi_dung" class="btn btn-secondary"><i class="fas fa-users"></i> Người Dùng</a>  
        <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 1): ?>
            <a href="index.php?controller=nhan_vien" class="btn btn-dark"><i class="fas fa-user-tie"></i> Nhân sự</a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold text-secondary"><i class="fas fa-chart-line text-success"></i> Biểu đồ Doanh thu (7 ngày qua)</h5>
            </div>
            <div class="card-body">
                <canvas id="doanhThuChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold text-secondary"><i class="fas fa-chart-pie text-warning"></i> Tỷ lệ Đơn hàng</h5>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <canvas id="trangThaiChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. VẼ BIỂU ĐỒ CỘT (DOANH THU)
    const ctxDoanhThu = document.getElementById('doanhThuChart').getContext('2d');
    new Chart(ctxDoanhThu, {
        type: 'bar',
        data: {
            labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'], // Nhãn trục X
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [1500000, 2300000, 800000, 5000000, 3200000, 7800000, 4500000], // Dữ liệu ảo
                backgroundColor: 'rgba(25, 135, 84, 0.7)', // Màu xanh lá Bootstrap
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // 2. VẼ BIỂU ĐỒ TRÒN (TRẠNG THÁI ĐƠN HÀNG)
    const ctxTrangThai = document.getElementById('trangThaiChart').getContext('2d');
    new Chart(ctxTrangThai, {
        type: 'doughnut', // Biểu đồ bánh donut
        data: {
            labels: ['Chờ duyệt', 'Đang giao', 'Thành công', 'Đã hủy'],
            datasets: [{
                data: [4, 2, 10, 1], // Dữ liệu ảo
                backgroundColor: [
                    '#ffc107', // Vàng (Chờ duyệt)
                    '#0d6efd', // Xanh dương (Đang giao)
                    '#198754', // Xanh lá (Thành công)
                    '#dc3545'  // Đỏ (Đã hủy)
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>