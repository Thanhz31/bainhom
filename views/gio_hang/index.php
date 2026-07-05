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

                        <!-- PHẦN CHỌN PHƯƠNG THỨC THANH TOÁN -->
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Phương thức thanh toán</label>
                            <div class="form-check border rounded p-2 mb-2 bg-light">
                                <!-- Value 1: COD -->
                                <input class="form-check-input ms-1" type="radio" name="payment_method" id="payCOD" value="1" checked onchange="toggleQR(false)">
                                <label class="form-check-label ms-2" for="payCOD" style="cursor:pointer; display:block;">
                                    <i class="fas fa-truck text-primary"></i> Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check border rounded p-2 bg-light">
                                <!-- Value 2: Online -->
                                <input class="form-check-input ms-1" type="radio" name="payment_method" id="payOnline" value="2" onchange="toggleQR(true)">
                                <label class="form-check-label ms-2" for="payOnline" style="cursor:pointer; display:block;">
                                    <i class="fas fa-qrcode text-success"></i> Thanh toán Online (Chuyển khoản)
                                </label>
                            </div>
                        </div>

                        <!-- KHU VỰC HIỂN THỊ MÃ QR (Mặc định ẩn) -->
                        <div id="qrSection" class="mb-3 border border-success rounded p-3 text-center" style="display: none; background-color: #f8fff9;">
                            <h6 class="text-success fw-bold mb-2">QUÉT MÃ ĐỂ THANH TOÁN</h6>
                            
                            <!-- Hiển thị ảnh QR -->
                            <img src="uploads/qrthanhtoan.png" alt="Mã QR Thanh Toán" class="img-fluid rounded border mb-2" style="max-width: 200px;">
                            
                            <p class="small text-muted mb-1">Nội dung chuyển khoản (Tự động copy):</p>
                            <div class="input-group mb-2">
                                <!-- Tạo mã chuyển khoản ngẫu nhiên hoặc theo quy tắc -->
                                <?php 
                                    $user_phone = isset($_SESSION['user']) ? $_SESSION['user']['phone'] : 'KHACH_LE';
                                    $transfer_code = "THANHTOAN " . $user_phone . " " . date("His"); 
                                ?>
                                <input type="text" id="transferCode" class="form-control text-center fw-bold text-primary" value="<?php echo $transfer_code; ?>" readonly>
                                <button class="btn btn-outline-success" type="button" onclick="copyCode()" title="Copy mã">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <small class="text-danger">Vui lòng nhập đúng <b>Nội dung chuyển khoản</b> để hệ thống xác nhận tự động.</small>
                        </div>

                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <button type="submit" name="order" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">
                            TIẾN HÀNH ĐẶT HÀNG
                        </button>
                    </form>
                </div>
            </div>

            <!-- SCRIPTS ĐIỀU KHIỂN GIAO DIỆN -->
            <script>
                // Hàm ẩn/hiện khu vực QR
                function toggleQR(show) {
                    var qrSection = document.getElementById('qrSection');
                    if(show) {
                        qrSection.style.display = 'block';
                    } else {
                        qrSection.style.display = 'none';
                    }
                }

                // Hàm copy mã chuyển khoản
                function copyCode() {
                    var copyText = document.getElementById("transferCode");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); /* Dành cho mobile */
                    navigator.clipboard.writeText(copyText.value);
                    alert("Đã copy nội dung: " + copyText.value);
                }
            </script>
        </div>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <h4>Giỏ hàng đang trống!</h4>
        <a href="index.php" class="btn btn-primary mt-2">Quay lại cửa hàng</a>
    </div>
<?php endif; ?>