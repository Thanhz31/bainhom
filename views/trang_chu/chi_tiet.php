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
            
            <!-- BẮT ĐẦU PHẦN ĐÁNH GIÁ & LƯỢT BÁN (BẢN TO) -->
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning fs-6 me-1">
                    <?php 
                    $rating_detail = isset($product['avg_rating']) ? round($product['avg_rating']) : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating_detail) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    ?>
                </div>
                <span class="fw-bold text-danger me-3" style="font-size: 1.1rem;">
                    <?php echo isset($product['avg_rating']) && $product['avg_rating'] > 0 ? number_format($product['avg_rating'], 1) : "0.0"; ?>
                </span>
                <a href="#reviews" class="text-decoration-none text-primary me-3">
                    (<?php echo isset($product['review_count']) ? $product['review_count'] : 0; ?> đánh giá)
                </a>
                <span class="text-muted border-start ps-3">
                    Đã bán <?php echo isset($product['sold_count']) ? $product['sold_count'] : 0; ?>
                </span>
            </div>
            <!-- KẾT THÚC PHẦN ĐÁNH GIÁ & LƯỢT BÁN -->

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

    <!-- BẮT ĐẦU KHU VỰC BÌNH LUẬN -->
    <div class="row mt-4 mb-5" id="reviews">
        <div class="col-12">
            <div class="bg-white p-4 shadow-sm rounded">
                <h4 class="text-uppercase border-bottom pb-2 border-danger text-danger mb-4">
                    <i class="fas fa-comments me-2"></i> Đánh giá từ khách hàng
                </h4>
                
                <?php if (isset($reviews) && count($reviews) > 0): ?>
                    <div class="review-list">
                        <?php foreach($reviews as $rv): ?>
                            <div class="d-flex mb-4 border-bottom pb-3">
                                <!-- Avatar mặc định -->
                                <div class="me-3">
                                    <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                
                                <!-- Nội dung đánh giá -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($rv['full_name']); ?></h6>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($rv['created_at'])); ?></small>
                                    </div>
                                    
                                    <!-- Số sao -->
                                    <div class="text-warning mb-2" style="font-size: 0.85rem;">
                                        <?php 
                                        $rv_rating = (int)$rv['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo ($i <= $rv_rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Text nhận xét -->
                                    <p class="mb-0 text-dark" style="line-height: 1.5;">
                                        <?php echo nl2br(htmlspecialchars($rv['comment'])); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Giao diện khi chưa có đánh giá -->
                    <div class="alert alert-light text-center border p-4">
                        <i class="fas fa-box-open fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">Chưa có đánh giá nào cho sản phẩm này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- KẾT THÚC KHU VỰC BÌNH LUẬN -->

<?php else: ?>
    <div class="alert alert-warning">Sản phẩm không tồn tại hoặc đã bị xóa</div>
<?php endif; ?>