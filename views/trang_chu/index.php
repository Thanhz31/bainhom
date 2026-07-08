<!-- NHÚNG TRỰC TIẾP CSS GIAO DIỆN SHOPEE -->
<style>
    .banner-container {
        height: 320px; /* Sếp có thể chỉnh số này nếu muốn cao/thấp hơn */
    }
    /* Đảm bảo ảnh banner phụ luôn chia đều không gian */
    .sub-banner {
        height: calc(50% - 5px);
    }
    /* KHUNG DANH MỤC */
    .shopee-cat-container {
    background: #fff;
    border-radius: 2px;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.05);
    margin: 0 20px 25px 20px; 
    position: relative;
    overflow: visible;
    }
    .shopee-cat-header {
        padding: 15px 20px;
        font-size: 1rem;
        color: rgba(0,0,0,.54);
        font-weight: 500;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
    /* LƯỚI DANH MỤC KÉO NGANG */
    .shopee-cat-scroll {
        display: grid;
        grid-template-rows: repeat(2, 1fr);
        grid-auto-flow: column;
        grid-auto-columns: 120px; /* Đặt độ rộng cố định cho cột để đảm bảo thẳng hàng */
        overflow-x: auto;
        overflow-y: hidden;
        border-top: 1px solid rgba(0,0,0,.05);
        border-left: 1px solid rgba(0,0,0,.05); /* Thêm viền trái cho container */
        background-color: #fff;
    }
    /* Thanh cuộn ngang thanh mảnh */
    .shopee-cat-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .shopee-cat-scroll::-webkit-scrollbar-thumb {
        background-color: #e5e5e5;
        border-radius: 10px;
    }
    .shopee-cat-scroll:hover::-webkit-scrollbar-thumb {
        background-color: #bfbfbf;
    }
    /* TỪNG ITEM DANH MỤC */
    .shopee-cat-item {
        width: 100%; /* Để item tự lấp đầy cột 120px */
        height: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-decoration: none;
        color: rgba(0,0,0,.8);
        border-right: 1px solid rgba(0,0,0,.05); /* Viền phải */
        border-bottom: 1px solid rgba(0,0,0,.05); /* Viền dưới */
        transition: transform 0.1s, box-shadow 0.1s;
        padding: 10px;
    }
      .shopee-cat-item:hover {
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05); 
        z-index: 1;
        background-color: #fafafa;
    }
    /* ẢNH/ICON DANH MỤC */
    .shopee-cat-img {
        width: 70px;
        height: 70px;
        margin-bottom: 10px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }
    .shopee-cat-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shopee-cat-text {
        font-size: 0.85rem;
        line-height: 1.2;
        padding: 0 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
   
</style>
<div class="row">
    <div class="col-12">
        
        <!-- ====================================
             1. KHUNG BANNER TỶ LỆ 8:4 GỌN GÀNG
        ==================================== -->
        <div class="row g-2 banner-container mb-4">
    <div class="col-md-8 h-100">
        <div id="bannerKhuyenMai" class="carousel slide h-100 shadow-sm" data-bs-ride="carousel">
            <div class="carousel-inner rounded h-100">
                <div class="carousel-item active h-100">
                    <img src="uploads/banner1.jpg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Banner chính 1">
                </div>
                <div class="carousel-item h-100">
                    <img src="uploads/banner2.jpg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Banner chính 2">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 h-100 d-flex flex-column justify-content-between">
        <div class="sub-banner rounded overflow-hidden shadow-sm">
            <a href="#">
                <img src="uploads/anhphu1.png" class="w-100 h-100" style="object-fit: cover;" alt="Banner Phụ 1">
            </a>
        </div>
        <div class="sub-banner rounded overflow-hidden shadow-sm">
            <a href="#">
                <img src="uploads/anhphu2.png" class="w-100 h-100" style="object-fit: cover;" alt="Banner Phụ 2">
            </a>
        </div>
    </div>
</div>

        <!-- ====================================
             2. LƯỚI DANH MỤC 2 HÀNG KIỂU SHOPEE
        ==================================== -->
        <div class="shopee-cat-container position-relative">
            <div class="shopee-cat-header">DANH MỤC</div>
           
          

            <div class="shopee-cat-scroll">
                
                <!-- Nút Mặc định: Tất cả sản phẩm -->
                <a href="index.php" class="shopee-cat-item">
                    <div class="shopee-cat-img" style="<?php echo (!isset($_GET['cat_id'])) ? 'border-color: #ee4d2d;' : ''; ?>">
                        <img src="https://cdn-icons-png.flaticon.com/512/2544/2544087.png" alt="All" class="p-2">
                    </div>
                    <div class="shopee-cat-text">Tất cả<br>sản phẩm</div>
                </a>
                <?php 
               $icon_map = [
                 'thời trang nam' => 'uploads/icon-T.jpg',
                 'thời trang nữ'  => 'uploads/icon-T-W.jpg',
                 'Giày dép'       => 'uploads/icon-Shoe.jpg',
                 'giày nữ'       => 'uploads/icon-Shoe-W.jpg',
                 'Mũ'       => 'uploads/icon-hat.jpg',
                 'quần áo cho bé'       => 'uploads/icon-baby.jpg',
                 'Phụ kiện'       => 'uploads/icon-watch1.webp',
                 'điện thoại'       => 'uploads/icon-phone1.jpg',
                 'nhà sách online'       => 'uploads/icon-book.avif',
                 'sắc đẹp'       => 'uploads/icon-son.jpg',
                 'túi ví nữ'       => 'uploads/icon-P-W.webp',
                 'đồ chơi'       => 'uploads/icon-toy1.jpg',
                 'Mẹ và bé'       => 'uploads/icon-MB1.jpg',
                 'balo & túi ví nam'       => 'uploads/icon-balo1.jpg',
                 'dụng cụ và thiết bị tiện ích'       => 'uploads/icon-tool.jpg',
                 'đồ điện gia dụng'       => 'uploads/icon-elec.jpg',
                 'máy tính & laptop'       => 'uploads/icon-lap.webp',
                 'máy ảnh & máy quay phim'       => 'uploads/icon-cam.webp',
                 ];
               ?>
                <!-- Loop các danh mục từ Database -->
                <?php if (!empty($categories)): foreach($categories as $cat): 
                    $border_color = (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat['id']) ? 'border-color: #ee4d2d;' : '';
                    $icon_src = isset($icon_map[$cat['name']]) ? $icon_map[$cat['name']] : 'uploads/icons/default.png';
                ?>
                    <a href="index.php?controller=trang_chu&cat_id=<?php echo $cat['id']; ?>" class="shopee-cat-item">
                        <div class="shopee-cat-img" style="<?php echo $border_color; ?>">
                            <!-- Avatar tự tạo từ tên danh mục -->
                            <img src="<?php echo $icon_src; ?>" alt="<?php echo $cat['name']; ?>" style="object-fit: contain;">
                        </div>
                        <div class="shopee-cat-text"><?php echo $cat['name']; ?></div>
                    </a>
                <?php endforeach; endif; ?>
                
            </div>
        </div>      

        <!-- ====================================
             3. SẢN PHẨM GIÁ RẺ (FLASH SALE)
        ==================================== -->
        <?php if(!isset($_GET['q']) && !isset($_GET['cat_id']) && isset($res_top) && $res_top): ?>
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

        <!-- ====================================
             4. DANH SÁCH SẢN PHẨM CHÍNH (GỢI Ý)
        ==================================== -->
        <h4 class="text-uppercase border-bottom pb-2 border-secondary mb-3 mt-4">
            <?php echo isset($section_title) ? $section_title : 'Sản phẩm gợi ý'; ?>
        </h4>

        <div class="row">
            <?php if (isset($products) && $products && $products->num_rows > 0): ?>
                <?php while($row = $products->fetch_assoc()): 
                    $is_out_of_stock = ($row['quantity'] <= 0);
                    $opacity = $is_out_of_stock ? "opacity: 0.6; filter: grayscale(100%);" : "";
                    $badge = $is_out_of_stock ? "<span class='badge bg-secondary position-absolute top-0 start-0 m-2 shadow-sm'>HẾT HÀNG</span>" : "";
                ?>
                <!-- Sử dụng col-md-3 để hiện 4 sản phẩm / 1 hàng giống Shopee -->
                <div class="col-md-3 col-sm-6 mb-4">
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