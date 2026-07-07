<?php
require_once '../core/interfaces/DonHangInterface.php';
require_once '../models/DonHangModel.php';
require_once '../models/SanPhamModel.php';

class DonHangComponent implements DonHangInterface {
    private $donHangModel;
    private $sanPhamModel;

    public function __construct($db) {
        $this->donHangModel = new DonHangModel($db);
        $this->sanPhamModel = new SanPhamModel($db);
    }

    public function thanhToan($khach, $gio_hang) {
        // Lấy phương thức thanh toán, mặc định là 1 (COD) nếu không có
        $payment_method = isset($khach['payment_method']) ? $khach['payment_method'] : 1;

        // 1. Tạo đơn hàng chính - ĐÃ BỔ SUNG $payment_method
        $order_id = $this->donHangModel->taoDonHang(
            $khach['user_id'], 
            $khach['name'], 
            $khach['phone'], 
            $khach['address'], 
            $khach['total'],
            $payment_method // TRUYỀN THÊM BIẾN NÀY XUỐNG MODEL
        );

        if ($order_id) {
            // 2. Lưu chi tiết từng sản phẩm và cập nhật kho
            foreach ($gio_hang as $p_id => $item) {
                $this->donHangModel->luuChiTiet($order_id, $p_id, $item['price'], $item['qty']);
                $this->sanPhamModel->capNhatKho($p_id, $item['qty']);
            }
            return $order_id;
        }
        return false;
    }

    public function layLichSu($user_id) {
        return $this->donHangModel->layDonHangCuaKhach($user_id);
    }
    public function layChiTietDonHang($order_id) {
        return $this->donHangModel->layTheoId($order_id);
    }

    public function layChiTietSanPhamDonHang($order_id) {
        return $this->donHangModel->layChiTietDonHang($order_id);
    }
}
?>