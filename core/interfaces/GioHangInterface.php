<?php
interface GioHangInterface {
    /**
     * Đầu vào: ID, Tên, Giá, Ảnh, Số lượng
     * Đầu ra: void (không trả về) hoặc bool
     */
    public function themMoi($id, $ten, $gia, $anh, $so_luong);

    /**
     * Đầu vào: ID sản phẩm cần xóa
     */
    public function xoaSanPham($id);

    /**
     * Đầu vào: ID và Số lượng mới
     */
    public function capNhatSoLuong($id, $so_luong);

    /**
     * Đầu ra: Mảng chứa toàn bộ sản phẩm trong giỏ
     */
    public function layGioHang();

    /**
     * Đầu ra: Số tiền tổng cộng (float/int)
     */
    public function tinhTongTien();

    /**
     * Xóa sạch giỏ hàng sau khi đặt hàng thành công
     */
    public function lamTrongGio();
}
?>