<div class="container mt-2 mb-5">
    <div class="card shadow border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-warning p-2">
            <h4 class="mb-0 mt-0 fw-bold" style="font-size: 1.25rem;">Sửa sản phẩm: <?php echo $product['name']; ?></h4>
        </div>
        <div class="card-body p-3">
            <form action="index.php?controller=san_pham&action=sua&id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold small">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="<?php echo $product['name']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold small">Danh mục</label>
                        <select name="category_id" class="form-select form-select-sm">
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold small">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control form-control-sm" value="<?php echo $product['price']; ?>" required min="0">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold small">Số lượng kho</label>
                        <input type="number" name="quantity" class="form-control form-control-sm" value="<?php echo $product['quantity']; ?>" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="fw-bold small">Mô tả ngắn</label>
                    <textarea name="description" class="form-control form-control-sm" rows="2"><?php echo $product['description']; ?></textarea>
                </div>
                <div class="mb-2">
                    <label class="fw-bold small">Mô tả chi tiết</label>
                    <textarea name="detail_desc" class="form-control form-control-sm" rows="4"><?php echo $product['detail_desc']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">Hình ảnh hiện tại</label><br>
                    <img src="uploads/<?php echo $product['image']; ?>" width="90" class="mb-2 rounded border shadow-sm">
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <button type="submit" name="update" class="btn btn-primary w-100 fw-bold py-2">Cập nhật thay đổi</button>
                <a href="index.php?controller=san_pham" class="btn btn-light w-100 mt-2 border btn-sm text-center">Hủy bỏ</a>
            </form>
        </div>
    </div>
</div>