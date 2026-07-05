<div class="container mt-4 mb-5">
    <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
        <!-- Nút Trở về lịch sử -->
        <a href="index.php?controller=tai_khoan&action=don_hang" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Trở về lịch sử
        </a>
        <h3 class="text-uppercase m-0 fw-bold"><i class="fas fa-file-invoice-dollar text-primary"></i> Chi tiết hóa đơn #<?php echo $order_info['id']; ?></h3>
    </div>

    <div class="row">
        <!-- Cột trái: Danh sách sản phẩm -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-dark text-white fw-bold">Sản phẩm đã mua</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $item): ?>
                            <tr>
                                <td class="text-center"><img src="uploads/<?php echo $item['image']; ?>" width="50" class="rounded border"></td>
                                <td class="fw-bold"><?php echo $item['name']; ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end"><?php echo number_format($item['price']); ?> ₫</td>
                                <td class="text-end fw-bold text-danger"><?php echo number_format($item['price'] * $item['quantity']); ?> ₫</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold text-uppercase">TỔNG CỘNG:</td>
                                <td class="text-end text-danger fw-bold fs-5"><?php echo number_format($order_info['total_money']); ?> ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin giao hàng và Trạng thái -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-info text-white fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p class="mb-2"><strong>Người nhận:</strong> <span class="fw-bold"><?php echo $order_info['customer_name']; ?></span></p>
                    <p class="mb-2"><strong>SĐT:</strong> <span class="text-primary fw-bold"><?php echo $order_info['customer_phone']; ?></span></p>
                    <p class="mb-2"><strong>Địa chỉ:</strong> <small class="text-muted"><?php echo $order_info['customer_address']; ?></small></p>
                    <p class="mb-0"><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order_info['created_at'])); ?></p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">Trạng thái đơn hàng</div>
                <div class="card-body text-center">
                    <?php 
                        $stt = $order_info['status'];
                        if ($stt == 0) {
                            echo '<h5 class="text-warning fw-bold mb-0"><i class="fas fa-clock fs-3 mb-2 d-block"></i> Chờ duyệt</h5><p class="small text-muted mt-2 mb-0">Đơn hàng đang chờ shop xác nhận.</p>';
                        } elseif ($stt == 1) {
                            echo '<h5 class="text-info fw-bold mb-0"><i class="fas fa-truck fs-3 mb-2 d-block"></i> Đang giao hàng</h5><p class="small text-muted mt-2 mb-0">Đơn hàng đang trên đường đến với bạn.</p>';
                        } elseif ($stt == 2) {
                            echo '<h5 class="text-success fw-bold mb-0"><i class="fas fa-check-circle fs-3 mb-2 d-block"></i> Đã giao thành công</h5><p class="small text-muted mt-2 mb-0">Cảm ơn bạn đã mua sắm tại MyShop!</p>';
                        } elseif ($stt == 3) {
                            echo '<h5 class="text-danger fw-bold mb-0"><i class="fas fa-times-circle fs-3 mb-2 d-block"></i> Đã hủy</h5><p class="small text-muted mt-2 mb-0">Đơn hàng này đã bị hủy.</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>