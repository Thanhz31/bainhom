<?php
session_start();
require_once '../config/database.php';

$controller = $_GET['controller'] ?? 'trang_chu';
$action = $_GET['action'] ?? 'index';

// Chuyển đổi tên sang Class (ví dụ: san_pham -> SanPhamController)
$class = str_replace(' ', '', ucwords(str_replace('_', ' ', $controller))) . 'Controller';

// Tìm file ở thư mục controllers hoặc controllers/quan_tri
$path = "../controllers/$class.php";
$admin_path = "../controllers/quan_tri/$class.php";

if (file_exists($path)) require_once $path;
elseif (file_exists($admin_path)) require_once $admin_path;
else die("Lỗi: Không tìm thấy Controller $class");

if (class_exists($class)) {
    $obj = new $class();
    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        die("Lỗi: Chức năng '$action' không tồn tại trong $class");
    }
}