<?php
interface DonHangInterface {
    /**
     * Đầu vào: 
     * - $thong_tin_khach: Mảng chứa (tên, sđt, địa chỉ, user_id)
     * - $danh_sach_sp: Mảng các sản phẩm lấy từ Giỏ hàng
     * Đầu ra: ID đơn hàng vừa tạo hoặc false nếu lỗi
     */
    public function thanhToan($thong_tin_khach, $danh_sach_sp);

    /**
     * Đầu vào: ID của người dùng
     * Đầu ra: Mảng danh sách các đơn hàng đã đặt
     */
    public function layLichSu($user_id);
}
?>