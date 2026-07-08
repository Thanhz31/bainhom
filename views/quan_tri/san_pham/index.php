<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-uppercase fw-bold m-0">Quản lý sản phẩm</h2>
        
        <div class="d-flex align-items-center gap-2">
            <form action="index.php" method="GET" class="m-0" style="min-width: 350px;">
                <input type="hidden" name="controller" value="san_pham">
                <input type="hidden" name="action" value="tim_kiem">
                
                <div class="input-group shadow-sm">
                    <input type="text" name="keyword" class="form-control border-primary" placeholder="Nhập tên sản phẩm..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" required>
                    
                    <button type="submit" class="btn btn-primary px-3" title="Tìm kiếm">
                        <i class="fas fa-search"></i>
                    </button>

                    <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
                        <a href="index.php?controller=san_pham" class="btn btn-outline-danger px-3" title="Hủy tìm kiếm">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
            
            <a href="index.php?controller=quan_tri" class="btn btn-outline-secondary text-nowrap">Về Dashboard</a>
            <a href="index.php?controller=san_pham&action=them" class="btn btn-success text-nowrap"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
        </div>
    </div>

    <?php if(isset($_GET['keyword']) && trim($_GET['keyword']) != ''): ?>
        <div class="mb-3">
            <span class="text-danger fw-bold"><i class="fas fa-filter"></i> Kết quả tìm kiếm cho: '<?php echo htmlspecialchars($_GET['keyword']); ?>'</span>
        </div>
    <?php endif; ?>

    <table class="table table-bordered bg-white shadow-sm align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): foreach($products as $row): ?>
            <tr>
                <td class="text-center fw-bold"><?php echo $row['id']; ?></td>
                <td class="text-center"><img src="uploads/<?php echo $row['image']; ?>" width="50" class="rounded border"></td>
                <td class="fw-bold"><?php echo $row['name']; ?></td>
                <td class="text-danger fw-bold text-center"><?php echo number_format($row['price']); ?> ₫</td>
                <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="index.php?controller=san_pham&action=sua&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning text-dark shadow-sm px-2 py-1">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <a href="index.php?controller=san_pham&action=xoa&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger shadow-sm px-2 py-1" onclick="return confirm('Bạn có chắc muốn xóa?');">
            <i class="fas fa-trash-alt"></i> Xóa
        </a>
    </div>
</td>
            </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Không tìm thấy sản phẩm nào khớp với từ khóa!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>