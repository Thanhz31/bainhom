<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uppercase fw-bold"><i class="fas fa-tags"></i> QUẢN LÝ DANH MỤC</h2>
        <a href="index.php?controller=quan_tri" class="btn btn-secondary">Về Dashboard</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thêm danh mục mới</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=danh_muc&action=index" method="POST">
                        <div class="mb-3">
                            <label class="fw-bold">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" placeholder="Ví dụ: Áo khoác..." required>
                        </div>
                        <button type="submit" name="add_cat" class="btn btn-primary w-100"><i class="fas fa-plus"></i> Thêm ngay</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Danh sách hiện có</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Tên danh mục</th>
                                <th style="width: 100px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $row): ?>
                            <tr>
                                <td class="text-center fw-bold"><?php echo $row['id']; ?></td>
                                <td class="fw-bold"><?php echo $row['name']; ?></td>
                                <td class="text-center">
                                    <a href="index.php?controller=danh_muc&action=xem_san_pham&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i> Xem SP
                                    </a>
                                    <a href="index.php?controller=danh_muc&action=xoa&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>