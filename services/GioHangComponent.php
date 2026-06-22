<?php
require_once '../core/interfaces/GioHangInterface.php';

class GioHangComponent implements GioHangInterface {
    
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function themMoi($id, $ten, $gia, $anh, $so_luong) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $so_luong;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $ten,
                'price' => $gia,
                'image' => $anh,
                'qty' => $so_luong
            ];
        }
    }

    public function xoaSanPham($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function capNhatSoLuong($id, $so_luong) {
        if ($so_luong <= 0) {
            $this->xoaSanPham($id);
        } elseif (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] = $so_luong;
        }
    }

    public function layGioHang() {
        return $_SESSION['cart'];
    }

    public function tinhTongTien() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    public function lamTrongGio() {
        $_SESSION['cart'] = [];
    }
}
?>