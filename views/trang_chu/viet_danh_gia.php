<div class="container mt-5 mb-5" style="max-width: 600px;">
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-dark fw-bold text-center py-3">
            <h4 class="mb-0 text-uppercase"><i class="fas fa-star text-white"></i> Đánh giá sản phẩm</h4>
        </div>
        <div class="card-body p-4 bg-light">
            <form action="index.php?controller=danh_gia&action=luu_danh_gia" method="POST">
                
                <input type="hidden" name="product_id" value="<?php echo isset($_GET['product_id']) ? intval($_GET['product_id']) : 0; ?>">
                <input type="hidden" name="order_id" value="<?php echo isset($_GET['order_id']) ? intval($_GET['order_id']) : 0; ?>">
                
                <div class="mb-4 text-center">
                    <label class="fw-bold d-block mb-3 fs-5 text-dark">Chất lượng sản phẩm</label>
                    <select name="rating" class="form-select w-75 mx-auto fw-bold text-center border-warning text-warning shadow-sm" style="font-size: 1.1rem;" required>
                        <option value="5">⭐⭐⭐⭐⭐ - Tuyệt vời</option>
                        <option value="4">⭐⭐⭐⭐ - Rất tốt</option>
                        <option value="3">⭐⭐⭐ - Bình thường</option>
                        <option value="2">⭐⭐ - Tạm được</option>
                        <option value="1">⭐ - Rất tệ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2 text-dark">Hãy chia sẻ nhận xét của bạn</label>
                    <textarea name="comment" class="form-control shadow-sm border-warning" rows="5" placeholder="Chất liệu thế nào? Đóng gói ra sao? Bạn có hài lòng với sản phẩm không?..." required></textarea>
                </div>

                <button type="submit" class="btn btn-danger w-100 fw-bold py-2 fs-5 shadow">
                    <i class="fas fa-paper-plane me-2"></i> GỬI ĐÁNH GIÁ
                </button>
            </form>
        </div>
    </div>
</div>