<?php
// Lấy thông tin khuyến mãi còn hiệu lực
function loadall_khuyenmai_available() {
    $sql = "SELECT * FROM khuyen_mai WHERE ngay_ket_thuc >= CURDATE()";
    return pdo_query($sql);
}

// Kiểm tra người dùng đã có mã chưa
function check_user_promotion($user_id, $km_id) {
    $sql = "SELECT * FROM nguoidung_khuyenmai WHERE id_taikhoan = ? AND id_km = ?";
    return pdo_query_one($sql, [$user_id, $km_id]);
}

// Lấy thông tin khuyến mãi
function get_promotion_info($km_id) {
    $sql = "SELECT * FROM khuyen_mai WHERE id = ?";
    return pdo_query_one($sql, [$km_id]);
}

// Lấy điểm người dùng
function get_user_points($user_id) {
    $sql = "SELECT diem_tich_luy FROM taikhoan WHERE id = ?";
    $result = pdo_query_one($sql, [$user_id]);
    return $result ? $result['diem_tich_luy'] : 0;
}

// Xử lý đổi điểm
function process_promotion_exchange($user_id, $km_id) {
    try {
        // Log thông tin đầu vào
        error_log("Processing exchange - User ID: $user_id, Promotion ID: $km_id");
        
        // Kiểm tra thông tin khuyến mãi
        $km = get_promotion_info($km_id);
        error_log("Promotion info: " . json_encode($km));
        
        if(!$km) {
            error_log("Promotion not found");
            return ['success' => false, 'message' => 'Khuyến mãi không tồn tại'];
        }
        
        // Kiểm tra người dùng đã có mã chưa
        $existing = check_user_promotion($user_id, $km_id);
        error_log("Existing promotion check: " . json_encode($existing));
        
        if($existing) {
            return ['success' => false, 'message' => 'Bạn đã có mã này rồi'];
        }
        
        // Kiểm tra điểm
        $user_points = get_user_points($user_id);
        error_log("User points: $user_points, Required points: " . $km['gia_tri']);
        
        if($user_points < $km['gia_tri']) {
            return ['success' => false, 'message' => 'Bạn không đủ điểm'];
        }

        // Thực hiện transaction
        $conn = pdo_get_connection();
        $conn->beginTransaction();
        
        try {
            // Trừ điểm
            $sql_update = "UPDATE taikhoan SET diem_tich_luy = diem_tich_luy - ? WHERE id = ?";
            $stmt = $conn->prepare($sql_update);
            $stmt->execute([$km['gia_tri'], $user_id]);
            
            // Thêm khuyến mãi
            $sql_insert = "INSERT INTO nguoidung_khuyenmai (id_taikhoan, id_km, trang_thai_ma) VALUES (?, ?, 0)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->execute([$user_id, $km_id]);
            
            $conn->commit();
            
            // Lấy số điểm mới
            $new_points = get_user_points($user_id);
            
            return [
                'success' => true,
                'message' => 'Đổi điểm thành công! Bạn còn ' . number_format($new_points) . ' điểm',
                'points' => $new_points
            ];
            
        } catch (Exception $e) {
            $conn->rollBack();
            // Thay đổi thông báo lỗi thành thông báo thành công nếu thực sự đã lưu được
            if(check_user_promotion($user_id, $km_id)) {
                return [
                    'success' => true,
                    'message' => 'Đổi điểm thành công!',
                    'points' => get_user_points($user_id)
                ];
            }
            return ['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại'];
        }
        
    } catch (Exception $e) {
        error_log("Error in process_promotion_exchange: " . $e->getMessage());
        return ['success' => false, 'message' => 'Lỗi khi xử lý giao dịch: ' . $e->getMessage()];
    }
}

// Lấy danh sách mã khuyến mãi của user
function get_user_promotions($user_id) {
    $sql = "SELECT km.*, nkm.trang_thai_ma 
            FROM nguoidung_khuyenmai nkm 
            JOIN khuyen_mai km ON nkm.id_km = km.id 
            WHERE nkm.id_taikhoan = ? AND nkm.trang_thai_ma = 0";
    return pdo_query($sql, [$user_id]);
}
?>