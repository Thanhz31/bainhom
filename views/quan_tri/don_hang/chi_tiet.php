<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-dark text-white"><h5>Thông tin sản phẩm (Đơn hàng #<?php echo $order_info['id']; ?>)</h5></div>
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
                                <td class="text-end fw-bold"><?php echo number_format($item['price'] * $item['quantity']); ?> ₫</td>
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
            
            <div class="card shadow-sm mb-3 border-0">
                <div class="card-header bg-info text-white fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> <?php echo $order_info['customer_name']; ?></p>
                    <p><strong>SĐT:</strong> <?php echo $order_info['customer_phone']; ?></p>
                    <p><strong>Địa chỉ:</strong> <small class="text-muted"><?php echo $order_info['customer_address']; ?></small></p>
                    <p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order_info['created_at'])); ?></p>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">Cập nhật trạng thái</div>
                <div class="card-body">
                    <?php 
                    // NGUYÊN TẮC 3: Nếu đơn hàng đã giao (2) hoặc đã hủy (3) thì khóa giao diện
                    if ($order_info['status'] == 2 || $order_info['status'] == 3): 
                    ?>
                        <div class="alert <?php echo ($order_info['status'] == 2) ? 'alert-success' : 'alert-danger'; ?> text-center fw-bold mb-3">
                            <?php echo ($order_info['status'] == 2) ? 'ĐƠN HÀNG ĐÃ HOÀN TẤT' : 'ĐƠN HÀNG ĐÃ BỊ HỦY'; ?>
                            <br><small class="fw-normal">Không thể thay đổi trạng thái</small>
                        </div>
                        <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary w-100">Quay lại danh sách</a>
                    
                    <?php 
                    // Nếu đơn hàng đang ở mức Chờ duyệt (0) hoặc Đang giao (1) thì mở Form
                    else: 
                    ?>
                        <form action="index.php?controller=don_hang&action=chi_tiet&id=<?php echo $order_info['id']; ?>" method="POST">
                            <select name="status" class="form-select mb-3">
                                
                                <?php if ($order_info['status'] == 0): ?>
                                    <option value="0" selected>Chờ duyệt (Mới)</option>
                                    <option value="1">Đang giao hàng</option>
                                    <option value="2">Đã giao (Hoàn tất)</option>
                                    <option value="3">Hủy đơn</option>
                                
                                <?php elseif ($order_info['status'] == 1): ?>
                                    <option value="1" selected>Đang giao hàng</option>
                                    <option value="2">Đã giao (Hoàn tất)</option>
                                    <option value="3">Hủy đơn (Khách bom hàng)</option>
                                <?php endif; ?>

                            </select>
                            <button type="submit" name="update_status" class="btn btn-success w-100 fw-bold">CẬP NHẬT</button>
                        </form>
                        <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary w-100 mt-2">Quay lại danh sách</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>