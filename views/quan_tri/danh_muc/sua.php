<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uppercase fw-bold"><i class="fas fa-edit"></i> CHỈNH SỬA DANH MỤC</h2>
        <a href="index.php?controller=danh_muc" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0 fw-bold">Cập nhật thông tin</h5>
        </div>
        <div class="card-body">
            <form action="index.php?controller=danh_muc&action=sua&id=<?php echo $category['id']; ?>" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="fw-bold">Tên danh mục</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $category['name']; ?>" required>
                </div>

                <div class="mb-4">
                    <label class="fw-bold">Icon danh mục mới (Tùy chọn)</label>
                    
                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">Ảnh hiện tại:</small>
                        <?php 
                        $icon_path = !empty($category['icon']) ? 'uploads/icons/' . $category['icon'] : 'uploads/icons/default.png';
                        ?>
                        <img src="<?php echo $icon_path; ?>" alt="icon" style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #ccc; padding: 2px; border-radius: 5px;">
                    </div>

                    <input type="file" name="icon" class="form-control" accept="image/png, image/jpeg, image/webp">
                    <small class="text-muted fst-italic">Để trống nếu muốn giữ nguyên ảnh cũ.</small>
                </div>

                <button type="submit" name="edit_cat" class="btn btn-warning w-100 fw-bold"><i class="fas fa-save"></i> Lưu Thay Đổi</button>
            </form>
        </div>
    </div>
</div>