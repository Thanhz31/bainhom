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

    <div class="row mb-4">
        <div class="col-md-6"> <div class="card bg-primary text-white shadow p-4">
                <h5 class="opacity-75">Tổng doanh thu</h5>
                <h2 class="fw-bold"><?php echo number_format($doanh_thu_tong); ?> đ</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white shadow p-4">
                <h5 class="opacity-75">Đơn hàng thành công</h5>
                <h2 class="fw-bold"><?php echo $tong_don_thanh_cong; ?> đơn</h2>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold">Chi tiết bán chạy</h5>
        </div>
        <div class="card-body p-0"> <table class="table table-hover table-striped m-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tên sản phẩm</th>
                        <th>Đã bán</th>
                        <th class="pe-4">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($top_sp)): ?>
                        <?php foreach ($top_sp as $sp): ?>
                        <tr>
                            <td class="ps-4"><?php echo $sp['name']; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $sp['sold_count']; ?></span></td>
                            <td class="pe-4 fw-bold text-primary"><?php echo number_format($sp['revenue']); ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center p-3">Chưa có dữ liệu</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>