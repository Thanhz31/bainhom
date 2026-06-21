<div class="container mt-4 mb-5">
    <div class="card shadow border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0 text-uppercase">Thêm Sản Phẩm Mới</h4>
        </div>
        <div class="card-body">
            <form action="index.php?controller=san_pham&action=them" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo mb_convert_case($cat['name'], MB_CASE_TITLE, "UTF-8"); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" required min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Số lượng kho</label>
                        <input type="number" name="quantity" class="form-control" value="100" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Mô tả chi tiết</label>
                    <textarea name="detail_desc" class="form-control" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Hình ảnh</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-success w-100 fw-bold py-2">LƯU SẢN PHẨM</button>
                <a href="index.php?controller=san_pham" class="btn btn-light w-100 mt-2">Thành đẹp trai<</a>
            </form>
        </div>
    </div>
</div>