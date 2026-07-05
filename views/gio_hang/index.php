<h2 class="mb-4 text-uppercase border-bottom pb-2">Giỏ hàng của bạn</h2>

<?php if (!empty($cart)): ?>
    <div class="row">
        <div class="col-md-8">
            <!-- Form bao bọc toàn bộ bảng giỏ hàng -->
            <form action="index.php?controller=gio_hang&action=cap_nhat" method="POST">
                <div class="card shadow-sm border-0 mb-3">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th style="width: 120px;">Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): 
                                $subtotal = $item['price'] * $item['qty'];
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="uploads/<?php echo $item['image']; ?>" width="60" class="me-2 rounded border"> 
                                        <span class="fw-bold"><?php echo $item['name']; ?></span>
                                    </div>
                                </td>
                                <td><?php echo number_format($item['price']); ?> ₫</td>
                                <td>
                                    <!-- ĐÃ THÊM: onchange="this.form.submit()" để tự động cập nhật khi đổi số -->
                                    <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['qty']; ?>" class="form-control text-center" min="1" onchange="this.form.submit()" style="cursor: pointer;">
                                </td>
                                <td class="fw-bold text-danger"><?php echo number_format($subtotal); ?> ₫</td>
                                <td>
                                    <a href="index.php?controller=gio_hang&action=xoa&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white text-center">
                    <h5 class="mb-0">THÔNG TIN THANH TOÁN</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="fs-4 text-danger fw-bold"><?php echo number_format($total); ?> ₫</span>
                    </div>
                    <hr>
                    
                    <form action="index.php?controller=thanh_toan&action=dat_hang" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Họ tên người nhận</label>
                            <input type="text" name="name" class="form-control" value="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['full_name'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['phone'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Địa chỉ giao hàng</label>
                            <textarea name="address" class="form-control" rows="3" required><?php echo isset($_SESSION['user']) ? $_SESSION['user']['address'] : ''; ?></textarea>
                        </div>
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <button type="submit" name="order" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">
                            TIẾN HÀNH ĐẶT HÀNG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <h4>Giỏ hàng đang trống!</h4>
        <a href="index.php" class="btn btn-primary mt-2">Quay lại cửa hàng</a>
    </div>
<?php endif; ?>