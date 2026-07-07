<div class="container mt-4 mb-5">
    <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
        <a href="index.php?controller=don_hang" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Trở về danh sách
        </a>
        <h4 class="text-uppercase m-0 fw-bold">
            <i class="fas fa-info-circle text-info"></i> 
            Chi tiết đơn hàng #<?php echo $order_info['id'] ?? 'N/A'; ?>
        </h4>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-<?php echo $_GET['msg'] == 'success' ? 'success' : 'danger'; ?> shadow-sm mb-4">
            <?php echo $_GET['msg'] == 'success' ? 'Hoàn tiền thành công!' : 'Có lỗi xảy ra hoặc đơn hàng không hợp lệ!'; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-dark text-white fw-bold">Danh sách sản phẩm</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($details)): foreach($details as $item): ?>
                            <tr>
                                <td class="text-center"><img src="uploads/<?php echo $item['image']; ?>" width="50" class="rounded border"></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($item['name'] ?? 'Sản phẩm'); ?></td>
                                <td class="text-center"><?php echo $item['quantity'] ?? 0; ?></td>
                                <td class="text-end"><?php echo number_format($item['price'] ?? 0); ?> ₫</td>
                                <td class="text-end fw-bold text-danger"><?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0)); ?> ₫</td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="text-center">Không có sản phẩm nào.</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold text-uppercase">TỔNG CỘNG:</td>
                                <td class="text-end text-danger fw-bold fs-5">
                                    <?php echo number_format($order_info['total_money'] ?? 0); ?> ₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3 border-0">
                <div class="card-header bg-info text-white fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p class="mb-2"><strong>Người nhận:</strong> <?php echo htmlspecialchars($order_info['customer_name'] ?? 'N/A'); ?></p>
                    <p class="mb-2"><strong>SĐT:</strong> <?php echo $order_info['customer_phone'] ?? 'N/A'; ?></p>
                    <p class="mb-2"><strong>Địa chỉ:</strong> <small><?php echo htmlspecialchars($order_info['customer_address'] ?? 'N/A'); ?></small></p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-warning text-dark fw-bold">Cập nhật trạng thái</div>
                <div class="card-body">
                    <?php if (isset($order_info['status']) && ($order_info['status'] == 2 || $order_info['status'] == 3)): ?>
                        <div class="alert alert-secondary text-center fw-bold mb-0">Đơn hàng đã hoàn tất/hủy</div>
                    <?php else: ?>
                        <form action="index.php?controller=don_hang&action=chi_tiet&id=<?php echo $order_info['id']; ?>" method="POST">
                            <select name="status" class="form-select mb-2">
                                <option value="0" <?php echo ($order_info['status'] == 0) ? 'selected' : ''; ?>>Chờ duyệt</option>
                                <option value="1" <?php echo ($order_info['status'] == 1) ? 'selected' : ''; ?>>Đang giao</option>
                                <option value="2" <?php echo ($order_info['status'] == 2) ? 'selected' : ''; ?>>Đã giao</option>
                                <option value="3" <?php echo ($order_info['status'] == 3) ? 'selected' : ''; ?>>Hủy đơn</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-success w-100">CẬP NHẬT</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white fw-bold">Xử lý hoàn tiền</div>
                <div class="card-body">
                    <?php if (isset($order_info['payment_status']) && $order_info['payment_status'] == 1): ?>
                        <form action="index.php?controller=don_hang&action=xuLyHoanTien" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order_info['id']; ?>">
                            <div class="mb-2">
                                <label class="small">Số tiền hoàn:</label>
                                <input type="number" name="amount" class="form-control" value="<?php echo $order_info['total_money'] ?? 0; ?>" required>
                            </div>
                            <div class="mb-2">
                                <label class="small">Lý do:</label>
                                <input type="text" name="reason" class="form-control" placeholder="Ví dụ: Khách trả hàng" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 fw-bold">XÁC NHẬN HOÀN TIỀN</button>
                        </form>
                    <?php elseif (isset($order_info['payment_status']) && $order_info['payment_status'] == 2): ?>
                        <div class="alert alert-danger text-center mb-0 fw-bold">ĐÃ HOÀN TIỀN</div>
                    <?php else: ?>
                        <p class="text-muted small text-center mb-0">Chưa thanh toán, không thể hoàn tiền.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>