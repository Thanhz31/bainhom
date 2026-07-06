<?php
// controllers/BotController.php
require_once '../models/SanPhamModel.php'; 

class BotController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->model = new SanPhamModel($this->db); 
    }

    public function tu_van() {
        $cau_hoi = isset($_GET['q']) ? mb_strtolower(trim($_GET['q']), 'UTF-8') : '';
        $html_response = "";

        // KỊCH BẢN 1: CHÀO HỎI BÌNH THƯỜNG
        if (strpos($cau_hoi, 'chào') !== false || strpos($cau_hoi, 'hi') !== false || strpos($cau_hoi, 'hello') !== false) {
            $html_response = "Dạ em chào Anh/Chị! Anh/Chị đang cần tìm sản phẩm loại nào ạ (áo sơ mi, áo khoác, quần jean...)?";
        }
        
        // KỊCH BẢN 2: TÌM HÀNG GIÁ RẺ / KHUYẾN MÃI
        elseif (strpos($cau_hoi, 'giá rẻ') !== false || strpos($cau_hoi, 'rẻ nhất') !== false || strpos($cau_hoi, 'khuyến mãi') !== false) {
            // SỬA: Gọi đúng hàm laySanPhamGiaRe() có sẵn trong Model của bạn
            $products_result = $this->model->laySanPhamGiaRe(); 
            
            $html_response = "Dạ đây là một số sản phẩm đang có mức giá rất tốt bên em ạ:<br><br>";
            // Hàm render bên dưới đã được sửa để xử lý cả đối tượng mysqli_result
            $html_response .= $this->renderProductCards($products_result, 3);
        }

        // KỊCH BẢN 3: TÌM HÀNG BÁN CHẠY (HOT)
        elseif (strpos($cau_hoi, 'bán chạy') !== false || strpos($cau_hoi, 'hot') !== false) {
            // SỬA: Gọi đúng hàm layTatCa() có sẵn trong Model của bạn
            $products_result = $this->model->layTatCa(); 
            
            $html_response = "Dạ các mẫu này đang được khách bên em mua cực kỳ nhiều luôn ạ:<br><br>";
            $html_response .= $this->renderProductCards($products_result, 3);
        }

        // KỊCH BẢN 4: TÌM KIẾM THEO TÊN
        else {
            // Hàm timKiemSanPham() của bạn trả về một mảng (Array)
            $products_array = $this->model->timKiemSanPham($cau_hoi);
            
            // SỬA: Kiểm tra mảng thay vì dùng num_rows
            if (!empty($products_array)) {
                $html_response = "Dạ em tìm thấy các mẫu <strong>" . htmlspecialchars($cau_hoi) . "</strong> này, Anh/Chị xem thử nhé:<br><br>";
                $html_response .= $this->renderProductCardsFromArray($products_array, 5); 
            } else {
                $html_response = "Dạ rất tiếc em không tìm thấy sản phẩm nào tên là '<strong>" . htmlspecialchars($cau_hoi) . "</strong>'. Anh/Chị thử nhập từ khóa ngắn gọn hơn giúp em nhé (VD: áo thun, quần âu...)!";
            }
        }

        echo $html_response;
        exit();
    }

    // --- HÀM PHỤ TRỢ 1: Dành cho kết quả từ query (mysqli_result) ---
    private function renderProductCards($result_set, $limit = 3) {
        $html = "<div style='display: flex; flex-direction: column; gap: 10px;'>";
        $count = 0;

        if ($result_set) {
            while ($row = $result_set->fetch_assoc()) {
                if ($count >= $limit) break;
                $html .= $this->buildCardHTML($row);
                $count++;
            }
        }
        $html .= "</div>";
        return $html;
    }

    // --- HÀM PHỤ TRỢ 2: Dành cho kết quả từ mảng (Array) ---
    private function renderProductCardsFromArray($data_array, $limit = 3) {
        $html = "<div style='display: flex; flex-direction: column; gap: 10px;'>";
        $count = 0;

        foreach ($data_array as $row) {
            if ($count >= $limit) break;
            $html .= $this->buildCardHTML($row);
            $count++;
        }
        $html .= "</div>";
        return $html;
    }

    // --- HTML THẺ SẢN PHẨM ---
    private function buildCardHTML($row) {
        return "
        <div style='border: 1px solid #ddd; border-radius: 8px; padding: 8px; display: flex; gap: 10px; align-items: center;'>
            <img src='uploads/" . htmlspecialchars($row['image']) . "' style='width: 60px; height: 60px; object-fit: cover; border-radius: 5px;'>
            <div style='flex: 1;'>
                <div style='font-weight: bold; font-size: 13px; line-height: 1.2; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;'>" . htmlspecialchars($row['name']) . "</div>
                <div style='color: #e60000; font-weight: bold; font-size: 13px;'>" . number_format($row['price']) . " ₫</div>
            </div>
            <form action='index.php?controller=gio_hang&action=them' method='POST' style='margin: 0;'>
                <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                <input type='hidden' name='product_name' value='" . htmlspecialchars($row['name']) . "'>
                <input type='hidden' name='product_price' value='" . $row['price'] . "'>
                <input type='hidden' name='product_image' value='" . htmlspecialchars($row['image']) . "'>
                <input type='hidden' name='qty' value='1'>
                <button type='submit' name='add_to_cart' style='background: #e60000; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; display: flex; align-items: center; justify-content: center;' title='Thêm vào giỏ'>
                    <i class='fas fa-cart-plus'></i>
                </button>
            </form>
        </div>";
    }
}
?>