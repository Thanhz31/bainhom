<div class="container mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h3>Sản phẩm thuộc danh mục</h3>
        <a href="index.php?controller=danh_muc" class="btn btn-secondary">Quay lại</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($products)): foreach($products as $p): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo $p['name']; ?></td>
                <td><?php echo number_format($p['price']); ?> ₫</td>
                <td><?php echo $p['quantity']; ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="4" class="text-center">Chưa có sản phẩm nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>