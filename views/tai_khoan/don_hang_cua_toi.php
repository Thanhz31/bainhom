<h3 class="mb-4 text-uppercase border-bottom pb-2">Lịch sử đơn hàng của bạn</h3>

<?php if (!empty($orders)): ?>
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Tổng tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <!-- BỔ SUNG CỘT HÀNH ĐỘNG -->
                        <th class="text-center">Hoá đơn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="text-center fw-bold">#<?php echo $order['id']; ?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($order['created_at'])); ?></td>
                        <td><small><?php echo $order['customer_address']; ?></small></td>
                        <td class="text-danger fw-bold"><?php echo number_format($order['total_money']); ?> ₫</td>
                        <td class="text-center">
                            <?php 
                                switch($order['status']) {
                                    case 0:
                                        echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge bg-info text-white">Đang giao</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge bg-success">Đã giao</span>';
                                        break;
                                    case 3:
                                        echo '<span class="badge bg-danger">Đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">Không xác định</span>';
                                }
                            ?>
                        </td>
                        <!-- BỔ SUNG NÚT XEM CHI TIẾT -->
                        <td class="text-center">
                            <!-- Lưu ý: Chữ 'tai_khoan' ở controller có thể sếp phải đổi lại theo đúng tên Controller của sếp nhé -->
                            <a href="index.php?controller=don_hang&action=chi_tiet_don_hang&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-info shadow-sm rounded-pill">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info py-5 text-center shadow-sm">
        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
        <h5>Bạn chưa có đơn hàng nào!</h5>
        <p class="mb-0">Hãy quay lại trang chủ để chọn món đồ ưng ý nhé.</p>
        <a href="index.php" class="btn btn-primary mt-3 px-4 rounded-pill">Tiếp tục mua sắm</a>
    </div>
    public function capNhatThanhToan($order_id, $payment_status) {
    $sql = "UPDATE orders SET payment_status = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$payment_status, $order_id]);
}
<?php endif; ?>