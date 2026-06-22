<?php
// Tự động đếm TỔNG SỐ LƯỢNG tất cả sản phẩm trong giỏ hàng 1
$cart_count = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        // Cộng dồn cột 'qty' (số lượng) của từng sản phẩm lại với nhau
        $cart_count += intval($item['qty']); 
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-icon { position: relative; }
        .cart-badge { position: absolute; top: -5px; right: -10px; font-size: 0.7rem; }
        .product-card { transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .list-group-item.active { background-color: #dc3545; border-color: #dc3545; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100"> 

<nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="fas fa-shopping-bag"></i> MY SHOP</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex mx-auto w-50 my-2 my-lg-0" action="index.php" method="GET">
                <input type="hidden" name="controller" value="trang_chu">
                <input class="form-control me-2 rounded-pill" type="search" name="q" placeholder="Bạn muốn tìm gì..." 
                       value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                <button class="btn btn-light rounded-circle" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="d-flex align-items-center mt-2 mt-lg-0">
                <a href="index.php?controller=gio_hang" class="text-white text-decoration-none me-4 cart-icon">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="badge bg-warning text-dark rounded-circle cart-badge"><?php echo $cart_count; ?></span>
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="dropdown">
                        <a class="text-white text-decoration-none dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo $_SESSION['user']['full_name']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="index.php?controller=tai_khoan&action=don_hang">Đơn hàng của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?controller=tai_khoan&action=dang_xuat">Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div>
                        <a href="index.php?controller=tai_khoan&action=dang_nhap" class="text-white text-decoration-none fw-bold">Đăng nhập</a>
                        <span class="text-white mx-2">|</span>
                        <a href="index.php?controller=tai_khoan&action=dang_ky" class="text-white text-decoration-none">Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5 flex-grow-1">