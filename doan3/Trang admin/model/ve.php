<?php
function loadall_vephim($ten = "", $tieude = "", $id_ve = "") {
    auto_update_ticket_status();
    
    $sql = "SELECT v.id, phim.tieu_de, v.price, v.ngay_dat, v.ghe, v.combo, 
            taikhoan.name, khung_gio_chieu.thoi_gian_chieu, lichchieu.ngay_chieu,
            v.id_hd, v.trang_thai, phongchieu.name as tenphong, rap.tenrap as tenrap
            FROM ve v 
            LEFT JOIN taikhoan ON taikhoan.id = v.id_tk 
            LEFT JOIN khung_gio_chieu ON khung_gio_chieu.id = v.id_thoi_gian_chieu 
            LEFT JOIN phim ON phim.id = v.id_phim       
            LEFT JOIN lichchieu ON lichchieu.id = khung_gio_chieu.id_lich_chieu
            LEFT JOIN phongchieu ON phongchieu.id = khung_gio_chieu.id_phong
            LEFT JOIN rap ON rap.id = phongchieu.rap_id
            WHERE v.trang_thai IN (1,2,3)";
    
    if($ten != "") {
        $sql .= " AND taikhoan.name LIKE '%".$ten."%'";
    }
    if($tieude != "") {
        $sql .= " AND phim.tieu_de LIKE '%".$tieude."%'";
    }
    if($id_ve != "") {
        $sql .= " AND v.id = '".$id_ve."'";
    }
    
    $sql .= " ORDER BY v.id DESC";
    
    return pdo_query($sql);
}

function loadone_vephim($id){
    auto_update_ticket_status();
    
    $sql = "SELECT v.id, phim.tieu_de, lichchieu.ngay_chieu, v.price, 
            v.ngay_dat, v.ghe, v.combo, taikhoan.name, 
            khung_gio_chieu.thoi_gian_chieu, v.id_hd, v.trang_thai, 
            phongchieu.name as tenphong, rap.tenrap as tenrap,
            CASE 
              
                WHEN v.trang_thai = 1 THEN 'Đã thanh toán'
                WHEN v.trang_thai = 2 THEN 'Đã sử dụng'
                WHEN v.trang_thai = 3 THEN 'Hết hạn'
                ELSE 'Không xác định'
            END as trang_thai_text
            FROM ve v
            LEFT JOIN taikhoan ON taikhoan.id = v.id_tk
            LEFT JOIN khung_gio_chieu ON khung_gio_chieu.id = v.id_thoi_gian_chieu
            LEFT JOIN phim ON phim.id = v.id_phim
            LEFT JOIN lichchieu ON lichchieu.id = khung_gio_chieu.id_lich_chieu
            LEFT JOIN phongchieu ON phongchieu.id = khung_gio_chieu.id_phong
            LEFT JOIN rap ON rap.id = phongchieu.rap_id
            WHERE v.id = ".$id;

    return pdo_query_one($sql);
}

function update_vephim($id, $trang_thai){
    if (!in_array($trang_thai, [1, 2, 3])) {
        return false;
    }

    try {
        $sql = "UPDATE ve SET trang_thai = '".$trang_thai."' WHERE id = '".$id."'";
        pdo_execute($sql);
        return true;
    } catch(Exception $e) {
        error_log("Lỗi cập nhật trạng thái vé: " . $e->getMessage());
        return false;
    }
}

function loadall_vephim1($searchName, $searchTieuDe, $searchid){
    $sql = "SELECT v.id, phim.tieu_de, lichchieu.ngay_chieu, v.price, 
            v.ngay_dat, v.ghe, v.combo, taikhoan.name, 
            khung_gio_chieu.thoi_gian_chieu, v.id_hd, v.trang_thai,
            phongchieu.name as tenphong,
            CASE 
                WHEN v.trang_thai = 1 THEN 'Đã thanh toán'
                WHEN v.trang_thai = 2 THEN 'Đã sử dụng'
                WHEN v.trang_thai = 3 THEN 'Hết hạn'
                ELSE 'Không xác định'
            END as trang_thai_text
            FROM ve v 
            LEFT JOIN taikhoan ON taikhoan.id = v.id_tk 
            LEFT JOIN khung_gio_chieu ON khung_gio_chieu.id = v.id_thoi_gian_chieu 
            LEFT JOIN phim ON phim.id = v.id_phim
            LEFT JOIN lichchieu ON lichchieu.id = khung_gio_chieu.id_lich_chieu
            LEFT JOIN phongchieu ON phongchieu.id = khung_gio_chieu.id_phong
            WHERE v.trang_thai IN (1,2,3)";

    // Tạo mảng params rỗng
    $params = array();

    if($searchName != "") {
        $sql .= " AND taikhoan.name LIKE '%".$searchName."%'";
    }
    if($searchTieuDe != "") {
        $sql .= " AND phim.tieu_de LIKE '%".$searchTieuDe."%'";
    }
    if($searchid != "") {
        $sql .= " AND v.id = '".$searchid."'";
    }

    $sql .= " ORDER BY v.id DESC";
    
    return pdo_query($sql);
}


function capnhat_tt_ve(){
    try {
        // Debug
        error_log("Bắt đầu cập nhật trạng thái vé");
        
        $sql = "UPDATE ve v
                INNER JOIN khung_gio_chieu kgc ON v.id_thoi_gian_chieu = kgc.id
                INNER JOIN lichchieu l ON l.id = kgc.id_lich_chieu
                SET v.trang_thai = 3
                WHERE CONCAT(l.ngay_chieu, ' ', kgc.thoi_gian_chieu) < NOW() 
                AND v.trang_thai = 1";
        
        pdo_execute($sql);
        
        // Debug
        error_log("Cập nhật trạng thái vé thành công");
        return true;
        
    } catch(Exception $e) {
        error_log("Lỗi cập nhật trạng thái vé hết hạn: " . $e->getMessage());
    }
}

function auto_update_ticket_status() {
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $sql = "UPDATE ve v
                INNER JOIN khung_gio_chieu kgc ON v.id_thoi_gian_chieu = kgc.id
                INNER JOIN lichchieu l ON l.id = kgc.id_lich_chieu
                SET v.trang_thai = 3
                WHERE CONCAT(l.ngay_chieu, ' ', kgc.thoi_gian_chieu) < DATE_SUB(NOW(), INTERVAL 1 HOUR)
                AND v.trang_thai = 1";
        
        error_log("Auto update query: " . $sql);
        pdo_execute($sql);
        return true;
        
    } catch(Exception $e) {
        error_log("Lỗi cập nhật tự động trạng thái vé: " . $e->getMessage());
        return false;
    }
}
