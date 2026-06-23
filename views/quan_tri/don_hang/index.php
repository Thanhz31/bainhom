<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
        <h4 class="m-0 text-uppercase fw-bold text-secondary">
            <i class="fas fa-list-alt text-primary"></i> Danh sách Đơn hàng
        </h4>
    </div>
    
    <form action="index.php" method="GET" class="m-0" style="min-width: 350px;">
        <input type="hidden" name="controller" value="don_hang">
        <input type="hidden" name="action" value="tim_kiem">
        <div class="input-group shadow-sm">
            <input type="text" name="keyword" class="form-control border-primary" placeholder="Tìm tên, SĐT hoặc mã đơn..." 
                   value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" required>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            <?php if(isset($_GET['keyword'])): ?>
                <a href="index.php?controller=don_hang" class="btn btn-outline-danger"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders) && is_array($orders)): foreach($orders as $row): 
                    // Xử lý trạng thái đơn hàng
                    $stt = $row['status'] ?? 0;
                    $badge = match((int)$stt) {
                        0 => '<span class="badge bg-secondary">Chờ duyệt</span>',
                        1 => '<span class="badge bg-primary">Đang giao</span>',
                        2 => '<span class="badge bg-success">Đã giao</span>',
                        3 => '<span class="badge bg-danger">Đã hủy</span>',
                        default => '<span class="badge bg-dark">Khác</span>'
                    };
                    
                    // Xử lý trạng thái thanh toán
                    $pay = (isset($row['payment_status']) && $row['payment_status'] == 2) 
                        ? '<span class="badge bg-danger"><i class="fas fa-undo"></i> Hoàn tiền</span>' 
                        : '<span class="badge bg-info text-dark">Đã TT / COD</span>';
                ?>
                <tr>
                    <td class="text-center fw-bold">#<?php echo $row['id']; ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($row['customer_name'] ?? 'Khách hàng'); ?></strong><br>
                        <small class="text-muted"><i class="fas fa-phone-alt"></i> <?php echo $row['customer_phone'] ?? ''; ?></small>
                    </td>
                    <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></td>
                    <td class="text-end fw-bold text-danger"><?php echo number_format($row['total_money'] ?? 0); ?> ₫</td>
                    <td class="text-center"><?php echo $badge; ?></td>
                    <td class="text-center"><?php echo $pay; ?></td>
                    <td class="text-center">
                        <a href="index.php?controller=don_hang&action=chi_tiet&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Không tìm thấy đơn hàng nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>