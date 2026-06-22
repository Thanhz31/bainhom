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
<?php else: ?>
    <div class="alert alert-warning">Sản phẩm không tồn tại hoặc đã bị xóa.</div>
<?php endif; ?>