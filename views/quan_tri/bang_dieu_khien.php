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
                <h3 class="fw-bold m-0"><?php echo number_format(isset($revenue) ? $revenue : 0); ?> ₫</h3>
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
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-secondary mb-0"><i class="fas fa-chart-bar text-success"></i> Doanh thu năm <?php echo isset($selected_year) ? $selected_year : date('Y'); ?></h5>
                
                <form action="index.php" method="GET" class="d-inline-flex align-items-center">
                    <input type="hidden" name="controller" value="quan_tri"> 
                    <label for="yearSelect" class="me-2 fw-semibold text-muted small mb-0 text-nowrap">Chọn năm:</label>
                    <select name="year" id="yearSelect" class="form-select form-select-sm" style="width: 100px; cursor: pointer;" onchange="this.form.submit()">
                        <?php 
                        $safe_list_years = isset($list_years) ? $list_years : [date('Y')];
                        $safe_selected = isset($selected_year) ? $selected_year : date('Y');
                        foreach($safe_list_years as $y): ?>
                            <option value="<?php echo $y; ?>" <?php echo ($y == $safe_selected) ? 'selected' : ''; ?>>
                                <?php echo $y; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
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
    const doanhThuData = <?php echo isset($doanhThuJson) ? $doanhThuJson : '[]'; ?>;
    const trangThaiData = <?php echo isset($trangThaiJson) ? $trangThaiJson : '[]'; ?>;

    // 1. VẼ BIỂU ĐỒ DOANH THU (Dạng Miền - Area Chart)
    const ctxDoanhThu = document.getElementById('doanhThuChart').getContext('2d');
    new Chart(ctxDoanhThu, {
        type: 'line', // Đổi thành dạng đường
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: doanhThuData, 
                backgroundColor: 'rgba(25, 135, 84, 0.2)', // Màu nền nhạt đi một chút để phần miền bên dưới trông đẹp hơn
                borderColor: 'rgba(25, 135, 84, 1)', // Viền đường kẻ màu xanh đậm
                borderWidth: 2,
                fill: true, // [QUAN TRỌNG] Bật thuộc tính này để đổ màu xuống trục X tạo thành Biểu đồ Miền
                tension: 0.4, // Tạo độ cong mượt mà cho các đỉnh
                pointBackgroundColor: '#ffffff', // Màu trong của các chấm dữ liệu
                pointBorderColor: 'rgba(25, 135, 84, 1)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: { 
                y: { beginAtZero: true } 
            },
            plugins: {
                legend: { display: true }
            }
        }
    });

    // 2. VẼ BIỂU ĐỒ TRẠNG THÁI ĐƠN HÀNG (Dạng Pie)
    const ctxTrangThai = document.getElementById('trangThaiChart').getContext('2d');
    new Chart(ctxTrangThai, {
        type: 'pie', 
        data: {
            labels: ['Chờ duyệt', 'Đang giao', 'Thành công', 'Đã hủy'],
            datasets: [{
                data: trangThaiData, 
                backgroundColor: [
                    '#ffc107', 
                    '#0d6efd', 
                    '#198754', 
                    '#dc3545'  
                ],
                borderWidth: 2, 
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: { padding: 20 }
                }
            }
        }
    });
</script>