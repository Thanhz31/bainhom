<div class="container mt-4 mb-5">
    <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
        <a href="index.php?controller=don_hang" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Trở về danh sách
        </a>
        <h4 class="text-uppercase m-0 fw-bold"><i class="fas fa-info-circle text-info"></i> Chi tiết đơn hàng #<?php echo $order_info['id']; ?></h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-dark text-white fw-bold">Danh sách sản phẩm</div>
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

        <div class="col-md-4">
            <!-- THÔNG TIN GIAO HÀNG -->
            <div class="card shadow-sm mb-3 border-0">
                <div class="card-header bg-info text-white fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p class="mb-2"><strong>Người nhận:</strong> <span class="fw-bold text-dark"><?php echo $order_info['customer_name']; ?></span></p>
                    <p class="mb-2"><strong>SĐT:</strong> <span class="text-primary fw-bold"><?php echo $order_info['customer_phone']; ?></span></p>
                    <p class="mb-2"><strong>Địa chỉ:</strong> <small class="text-muted"><?php echo $order_info['customer_address']; ?></small></p>
                    <p class="mb-2"><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order_info['created_at'])); ?></p>
                    
                    <p class="mb-2"><strong>Hình thức TT:</strong> 
                        <?php 
                        echo (isset($order_info['payment_method']) && (int)$order_info['payment_method'] === 2) 
                             ? '<span class="badge bg-primary">Thanh toán Online</span>' 
                             : '<span class="badge bg-secondary">Khi nhận hàng (COD)</span>'; 
                        ?>
                    </p>

                    <!-- PHẦN TRẠNG THÁI TT ĐÃ SỬA: Đưa vào div d-flex để nằm ngang -->
                    <div class="d-flex align-items-center gap-2">
                        <strong>Trạng thái TT:</strong> 
                        <?php 
                        $pay_status = $order_info['payment_status'] ?? 0;
                        if ($pay_status == 1) {
                            echo '<span class="badge bg-success">Đã thanh toán</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Chưa thanh toán</span>';
                            echo ' <form action="index.php?controller=don_hang&action=chi_tiet&id='.$order_info['id'].'" method="POST" class="m-0">
                                    <input type="hidden" name="xac_nhan_thanh_toan" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" onclick="return confirm(\'Xác nhận đã nhận tiền?\')">
                                        <i class="fas fa-check"></i> Xác nhận TT
                                    </button>
                                </form>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- CẬP NHẬT TRẠNG THÁI -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">Cập nhật trạng thái</div>
                <div class="card-body">
                    <?php if ($order_info['status'] == 2 || $order_info['status'] == 3): ?>
                        <div class="alert <?php echo ($order_info['status'] == 2) ? 'alert-success' : 'alert-danger'; ?> text-center fw-bold mb-3">
                            <i class="fas <?php echo ($order_info['status'] == 2) ? 'fa-check-circle' : 'fa-times-circle'; ?> fs-4 mb-1"></i><br>
                            <?php echo ($order_info['status'] == 2) ? 'ĐƠN HÀNG ĐÃ HOÀN TẤT' : 'ĐƠN HÀNG ĐÃ BỊ HỦY'; ?>
                        </div>
                        <a href="index.php?controller=don_hang" class="btn btn-outline-secondary w-100">Quay lại</a>
                    <?php else: ?>
                        <form action="index.php?controller=don_hang&action=chi_tiet&id=<?php echo $order_info['id']; ?>" method="POST">
                            <select name="status" class="form-select mb-3 border-primary shadow-sm">
                                <?php if ($order_info['status'] == 0): ?>
                                    <option value="0" selected>Chờ duyệt (Mới)</option>
                                    <option value="1">Đang giao hàng</option>
                                    <option value="2">Đã giao (Hoàn tất)</option>
                                    <option value="3">Hủy đơn</option>
                                <?php elseif ($order_info['status'] == 1): ?>
                                    <option value="1" selected>Đang giao hàng</option>
                                    <option value="2">Đã giao (Hoàn tất)</option>
                                    <option value="3">Hủy đơn</option>
                                <?php endif; ?>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-success w-100 fw-bold shadow-sm">CẬP NHẬT</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>