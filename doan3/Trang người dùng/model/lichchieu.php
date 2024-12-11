<?php
function lichchieu_select_by_id_phim($id)
{
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_date = date('Y-m-d');

        $sql = "SELECT l.id, l.ngay_chieu, phim.tieu_de
                FROM lichchieu l
                LEFT JOIN phim ON phim.id = l.id_phim
                WHERE l.id_phim = '$id'
                AND l.ngay_chieu >= '$current_date'
                ORDER BY l.ngay_chieu ASC";
        $re = pdo_query($sql);
        return $re;
    } catch(Exception $e) {
        error_log("Lỗi select lịch chiếu: " . $e->getMessage());
        return array();
    }
}

function khunggiochieu_select_by_idxc($id_lc)
{
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_datetime = date('Y-m-d H:i:s');

        $sql = "SELECT g.id, g.id_lich_chieu, g.thoi_gian_chieu, lichchieu.ngay_chieu, g.id_phong 
                FROM khung_gio_chieu g 
                INNER JOIN lichchieu ON lichchieu.id = g.id_lich_chieu 
                INNER JOIN phongchieu ON phongchieu.id = g.id_phong 
                WHERE lichchieu.id = '$id_lc'
                AND CONCAT(lichchieu.ngay_chieu, ' ', g.thoi_gian_chieu) > '$current_datetime'
                ORDER BY g.thoi_gian_chieu ASC";
        $re = pdo_query($sql);
        return $re;
    } catch(Exception $e) {
        error_log("Lỗi select khung giờ chiếu: " . $e->getMessage());
        return array();
    }
}



function loadall_lichchieu_by_rap($id_phim, $rap_id) {
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_date = date('Y-m-d');

        $sql = "SELECT DISTINCT lc.* 
                FROM lichchieu lc
                JOIN khung_gio_chieu kgc ON lc.id = kgc.id_lich_chieu
                JOIN phongchieu pc ON kgc.id_phong = pc.id
                WHERE lc.id_phim = ? 
                AND pc.rap_id = ?
                AND lc.ngay_chieu >= ?
                ORDER BY lc.ngay_chieu ASC";

        return pdo_query($sql, $id_phim, $rap_id, $current_date);
    } catch(PDOException $e) {
        error_log("Lỗi truy vấn lịch chiếu: " . $e->getMessage());
        return array();
    }
}

function loadall_lichchieu_user($id_phim) {
    $sql = "SELECT lc.*, p.tieu_de 
            FROM lichchieu lc
            INNER JOIN phim p ON lc.id_phim = p.id
            WHERE lc.id_phim = ?
            AND DATE(lc.ngay_chieu) >= DATE(NOW())
            ORDER BY lc.ngay_chieu ASC";
            
    return pdo_query($sql, array($id_phim));
}

function get_khung_gio_by_lichchieu($id_lc) {
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_timestamp = time();

        $sql = "SELECT kg.*, l.ngay_chieu 
                FROM khung_gio_chieu kg
                JOIN lichchieu l ON l.id = kg.id_lich_chieu
                WHERE kg.id_lich_chieu = ? 
                AND UNIX_TIMESTAMP(CONCAT(l.ngay_chieu, ' ', kg.thoi_gian_chieu)) > ?
                ORDER BY kg.thoi_gian_chieu ASC";

        return pdo_query($sql, $id_lc, $current_timestamp);
    } catch(PDOException $e) {
        error_log("Lỗi truy vấn khung giờ chiếu: " . $e->getMessage());
        return array();
    }
}
function lay_thong_tin_suat_chieu($id_suat) {
    $sql = "SELECT lc.*, p.id_phong 
            FROM lichchieu lc
            JOIN phongchieu p ON lc.id_phong = p.id
            WHERE lc.id = ?";
    return pdo_query_one($sql, $id_suat);
}