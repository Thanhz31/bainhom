<?php if ($product): ?>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active"><?php echo $product['name']; ?></li>
        </ol>
    </nav>

    <div class="row bg-white p-4 shadow-sm rounded">
        <div class="col-md-5">
            <img src="uploads/<?php echo $product['image']; ?>" class="img-fluid rounded border">
        </div>

        <div class="col-md-7">
            <h2 class="fw-bold"><?php echo $product['name']; ?></h2>
            <div class="mb-3">
                <?php 
                echo ($product['quantity'] > 0) 
                    ? "<span class='badge bg-success'>Còn hàng (SL: {$product['quantity']})</span>" 
                    : "<span class='badge bg-secondary'>Hết hàng</span>"; 
                ?>
            </div>
            <h3 class="text-danger my-3"><?php echo number_format($product['price']); ?> ₫</h3>
            
            <p class="text-muted" style="line-height: 1.6;">
                <strong>Mô tả ngắn:</strong> <?php echo $product['description']; ?><br><br>
                <strong>Chi tiết:</strong><br>
                <?php echo nl2br($product['detail_desc'] ? $product['detail_desc'] : "Chưa có mô tả chi tiết."); ?>
            </p>

            <hr>
            <form action="index.php?controller=gio_hang&action=them" method="POST" class="d-flex align-items-center">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <div class="me-3">
                    <label class="fw-bold d-block mb-1">Số lượng:</label>
                    <input type="number" name="quantity" value="1" min="1" 
                           max="<?php echo $product['quantity']; ?>" 
                           class="form-control" style="width: 80px;">
                </div>

                <button type="submit" class="btn btn-danger btn-lg mt-4" 
                        <?php if($product['quantity'] <= 0) echo 'disabled'; ?>>
                    <i class="fas fa-cart-plus"></i> THÊM VÀO GIỎ
                </button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
    <div class="col-12 bg-white p-4 shadow-sm rounded">
        <h4 class="mb-4 text-uppercase border-bottom pb-2">Đánh giá sản phẩm (<?php echo $product['review_count']; ?>)</h4>

        <!-- 1. FORM GỬI ĐÁNH GIÁ (Chỉ hiển thị khi đã đăng nhập và đã mua hàng) -->
        <?php if(isset($_SESSION['user'])): ?>
            <!-- Sếp cần thêm logic check $has_purchased ở Controller để ẩn hiện form này -->
            <?php if($has_purchased): ?>
                <div class="mb-4">
                    <h5>Gửi đánh giá của bạn:</h5>
                    <form action="index.php?controller=review&action=them" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <div class="mb-2">
                            <select name="rating" class="form-select w-25" required>
                                <option value="5">5 Sao - Rất tốt</option>
                                <option value="4">4 Sao - Tốt</option>
                                <option value="3">3 Sao - Trung bình</option>
                                <option value="2">2 Sao - Kém</option>
                                <option value="1">1 Sao - Tệ</option>
                            </select>
                        </div>
                        <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Nhập bình luận của bạn..." required></textarea>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Bạn cần mua sản phẩm này và nhận hàng thành công mới được phép đánh giá.</div>
            <?php endif; ?>
        <?php else: ?>
            <p class="alert alert-warning">Vui lòng <a href="index.php?controller=tai_khoan&action=dang_nhap">đăng nhập</a> để bình luận.</p>
        <?php endif; ?>

        <hr>

        <!-- 2. HIỂN THỊ DANH SÁCH BÌNH LUẬN -->
        <div class="reviews-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3 border-0 bg-light p-3">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo $review['user_name']; ?></strong>
                            <small class="text-muted"><?php echo date("d/m/Y", strtotime($review['created_at'])); ?></small>
                        </div>
                        <div class="text-warning mb-1">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="fas fa-star <?php echo ($i <= $review['rating']) ? '' : 'text-secondary'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="mb-0 mt-1"><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php endif; ?>
        </div>
    </div>
 </div>
<?php else: ?>
    <div class="alert alert-warning">Sản phẩm không tồn tại hoặc đã bị xóa</div>
<?php endif; ?>