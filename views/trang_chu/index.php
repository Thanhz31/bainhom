<div class="row">
    <!-- CỘT BÊN TRÁI: DANH MỤC SẢN PHẨM -->
    <div class="col-md-3 mb-4">
        <div class="list-group shadow-sm sticky-top" style="top: 80px; z-index: 1;">
            <a href="#" class="list-group-item list-group-item-action active fw-bold text-uppercase">
                <i class="fas fa-bars me-2"></i> Danh mục
            </a>
            <a href="index.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                Tất cả sản phẩm <i class="fas fa-chevron-right text-muted small"></i>
            </a>
            <?php foreach($categories as $cat): 
                $active = (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat['id']) ? 'bg-light fw-bold text-danger' : '';
            ?>
                <a href="index.php?controller=trang_chu&cat_id=<?php echo $cat['id']; ?>" class="list-group-item list-group-item-action <?php echo $active; ?> d-flex justify-content-between align-items-center">
                    <?php echo $cat['name']; ?> <i class="fas fa-chevron-right text-muted small"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CỘT BÊN PHẢI: NỘI DUNG CHÍNH -->
    <div class="col-md-9">
<<<<<<< HEAD
        
        <!-- KHUNG BANNER KIỂU SHOPEE ĐÃ ĐƯỢC CẬP NHẬT -->
        <div class="row g-2 mb-4">
            <!-- Banner Carousel Chính (Chiếm 2/3 không gian) -->
            <div class="col-md-8">
                <div id="bannerKhuyenMai" class="carousel slide h-100 shadow-sm" data-bs-ride="carousel">
                    <div class="carousel-inner rounded h-100">
                        <div class="carousel-item active h-100">
                            <img src="uploads/banner1.jpg" class="d-block w-100 h-100" style="object-fit: cover; min-height: 250px;" alt="Lễ hội bóng đá giảm 50%">
                        </div>  
                        <div class="carousel-item h-100">
                            <img src="uploads/banner2.jpg" class="d-block w-100 h-100" style="object-fit: cover; min-height: 250px;" alt="Siêu sale giữa tháng">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <!-- 2 Banner Nhỏ Bên Phải (Chiếm 1/3 không gian) -->
            <div class="col-md-4 d-flex flex-column gap-2">
                <div class="rounded overflow-hidden shadow-sm flex-fill">
                    <a href="#">
                        <img src="uploads/anhphu1.png" class="w-100 h-100" style="object-fit: cover; min-height: 120px;" alt="Banner Phụ 1">
                    </a>
                </div>
                <div class="rounded overflow-hidden shadow-sm flex-fill">
                    <a href="#">
                        <img src="uploads/anhphu2.png" class="w-100 h-100" style="object-fit: cover; min-height: 120px;" alt="Banner Phụ 2">
                    </a>
                </div>
            </div>
        </div> 
        <!-- HẾT KHUNG BANNER -->

        <!-- KHU VỰC SẢN PHẨM GIÁ RẺ -->
=======
        <div id="bannerKhuyenMai" class="carousel slide mb-4 shadow-sm" data-bs-ride="carousel">
  <div class="carousel-inner rounded">
    <div class="carousel-item active">
      <img src="uploads/banner1.jpg" class="d-block w-100" alt="Lễ hội bóng đá giảm 50%">
    </div>  
    <div class="carousel-item">
      <img src="uploads/banner2.jpg" class="d-block w-100" alt="Siêu sale giữa tháng">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>
>>>>>>> 29f501d389f1b6015ad7f032558dbb031ba77d98
        <?php if(!isset($_GET['q']) && !isset($_GET['cat_id']) && $res_top): ?>
        <div class="mb-5">
            <h4 class="text-uppercase border-bottom pb-2 border-danger text-danger">
                <i class="fas fa-fire"></i> Sản Phẩm Giá rẻ
            </h4>
            <div class="row">
                <?php while($row = $res_top->fetch_assoc()): ?>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <a href="index.php?controller=trang_chu&action=chi_tiet&id=<?php echo $row['id']; ?>" target="_blank">
                            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top p-2" style="height: 150px; object-fit: contain;">
                        </a>
                        <div class="card-body p-2 text-center">
<h6 class="card-title text-truncate"><a href="index.php?controller=trang_chu&action=chi_tiet&id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark"><?php echo $row['name']; ?></a></h6>
                            <p class="text-danger fw-bold mb-0"><?php echo number_format($row['price']); ?> ₫</p>
                            <small class="text-muted" style="font-size: 0.8rem;">Đã bán: <?php echo isset($row['sold_count']) ? $row['sold_count'] : 0; ?></small>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- KHU VỰC DANH SÁCH SẢN PHẨM CHÍNH -->
        <h4 class="text-uppercase border-bottom pb-2 border-secondary mb-3">
            <?php echo $section_title; ?>
        </h4>

        <div class="row">
            <?php if ($products && $products->num_rows > 0): ?>
                <?php while($row = $products->fetch_assoc()): 
                    $is_out_of_stock = ($row['quantity'] <= 0);
                    $opacity = $is_out_of_stock ? "opacity: 0.6; filter: grayscale(100%);" : "";
                    $badge = $is_out_of_stock ? "<span class='badge bg-secondary position-absolute top-0 start-0 m-2 shadow-sm'>HẾT HÀNG</span>" : "";
                ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card position-relative border-0">
                        <?php echo $badge; ?>
                        
                        <a href="index.php?controller=trang_chu&action=chi_tiet&id=<?php echo $row['id']; ?>" target="_blank">
                            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height: 220px; object-fit: cover; <?php echo $opacity; ?>">
                        </a>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-danger fw-bold fs-5"><?php echo number_format($row['price']); ?> ₫</span>
                                <small class="text-muted" style="font-size: 0.85rem;">
                                    <?php echo $is_out_of_stock ? "Tạm hết" : "Kho: " . $row['quantity']; ?>
                                </small>
                            </div>
                            
                            <form action="index.php?controller=gio_hang&action=them" method="POST" class="mt-auto">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
<input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                                <input type="hidden" name="qty" value="1">
                                
                                <button type="submit" name="add_to_cart" class="btn btn-outline-danger w-100 rounded-pill" <?php if($is_out_of_stock) echo 'disabled'; ?>>
                                    <i class="fas fa-cart-plus me-1"></i> 
                                    <?php echo $is_out_of_stock ? 'Hết hàng' : 'Thêm vào giỏ'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class='col-12 text-center py-5'>
                    <h5 class='text-muted'>Không tìm thấy sản phẩm nào! 😞</h5>
                    <a href='index.php' class='btn btn-primary mt-3'>Xem tất cả</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
