<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary m-0"><i class="fas fa-chart-line"></i> Báo cáo kinh doanh</h2>
        <div>
            <a href="index.php?controller=quan_tri&action=index" class="btn btn-outline-secondary shadow-sm me-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="index.php?controller=bao_cao&action=export" class="btn btn-success shadow-sm">
                <i class="fas fa-file-excel"></i> Xuất Excel
            </a>
        </div>
    </div>

    <form method="GET" action="index.php" class="row g-3 mb-4 align-items-end bg-white p-3 shadow-sm rounded">
        <input type="hidden" name="controller" value="baocao">
        <input type="hidden" name="action" value="index">
        
        <div class="col-md-4">
            <label class="fw-bold">Từ ngày:</label>
            <input type="date" name="tu_ngay" class="form-control" 
                   value="<?php echo isset($tu_ngay) ? htmlspecialchars($tu_ngay) : date('Y-m-01'); ?>">
        </div>
        <div class="col-md-4">
            <label class="fw-bold">Đến ngày:</label>
            <input type="date" name="den_ngay" class="form-control" 
                   value="<?php echo isset($den_ngay) ? htmlspecialchars($den_ngay) : date('Y-m-d'); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Lọc
            </button>
        </div>
    </form>

    <div class="row mb-4">
        <div class="col-md-6"> 
            <div class="card bg-primary text-white shadow p-4">
                <h5 class="opacity-75">Tổng doanh thu</h5>
                <h2 class="fw-bold"><?php echo number_format($doanh_thu_tong); ?> đ</h2>
                <small class="opacity-75">
                    <?php echo (isset($tu_ngay) ? $tu_ngay : 'Đầu tháng') . ' đến ' . (isset($den_ngay) ? $den_ngay : 'Hôm nay'); ?>
                </small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white shadow p-4">
                <h5 class="opacity-75">Đơn hàng thành công</h5>
                <h2 class="fw-bold"><?php echo isset($tong_don_thanh_cong) ? $tong_don_thanh_cong : 0; ?> đơn</h2>
                <small class="opacity-75">Trong khoảng thời gian đã chọn</small>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold"><i class="fas fa-trophy text-warning"></i> Chi tiết sản phẩm bán chạy</h5>
        </div>
        <div class="card-body p-0"> 
            <table class="table table-hover table-striped m-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tên sản phẩm</th>
                        <th>Đã bán</th>
                        <th class="pe-4 text-end">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($top_sp)): ?>
                        <?php foreach ($top_sp as $sp): ?>
                        <tr>
                            <td class="ps-4"><?php echo htmlspecialchars($sp['name']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo $sp['sold_count']; ?></span></td>
                            <td class="pe-4 fw-bold text-primary text-end">
                                <?php echo number_format($sp['revenue']); ?> đ
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center p-3">Chưa có dữ liệu trong khoảng thời gian này</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>