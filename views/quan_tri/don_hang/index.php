<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary btn-sm shadow-sm" title="Trở về Bảng điều khiển">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
        <div>
            <h4 class="m-0 text-uppercase fw-bold text-secondary"><i class="fas fa-list-alt text-primary"></i> Danh sách Đơn hàng</h4>
            <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
                <small class="text-danger fw-bold">Hiển thị kết quả cho: '<?php echo htmlspecialchars($_GET['keyword']); ?>'</small>
            <?php endif; ?>
        </div>
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
                <a href="index.php?controller=don_hang" class="btn btn-outline-danger px-3" title="Hủy tìm kiếm">
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