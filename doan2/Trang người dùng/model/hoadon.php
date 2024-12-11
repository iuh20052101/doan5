<?php

function them_hoa_don($ngay_tt, $tong_tien)
{
    try {
        // Debug
        error_log("Thêm hóa đơn - Ngày: $ngay_tt, Tổng tiền: $tong_tien");
        
        // Kiểm tra giá trị đầu vào
        if (empty($ngay_tt) || !is_numeric($tong_tien)) {
            throw new Exception("Dữ liệu đầu vào không hợp lệ");
        }
        
        $sql = "INSERT INTO hoa_don (ngay_tt, thanh_tien, trang_thai) 
                VALUES (?, ?, 0)";
        
        $id_hd = pdo_execute_return_interlastid($sql, $ngay_tt, $tong_tien);
        error_log("Đã tạo hóa đơn ID: " . $id_hd);
        return $id_hd;
        
    } catch(Exception $e) {
        error_log("Lỗi thêm hóa đơn: " . $e->getMessage());
        return false;
    }
}