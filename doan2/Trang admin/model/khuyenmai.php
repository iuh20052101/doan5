
<?php
function load_khuyenmai(){
    $sql = "select * from khuyen_mai where 1";
    $re = pdo_query($sql);
    return $re;

}



function xoa_khuyenmai($id)
{
    $sql = "delete from khuyen_mai where id=" . $id;
    pdo_execute($sql);
}

function loadone_khuyenmai($id) {
    $sql = "SELECT * FROM khuyen_mai WHERE id=?";
    return pdo_query_one($sql, $id);
}

function update_khuyenmai($id,$ten_km, $gia_tri, $ngay_ket_thuc, $mota) {
    $sql = "update khuyen_mai set `ten_km`='{$ten_km}',`gia_tri`='{$gia_tri}',`ngay_ket_thuc`='{$ngay_ket_thuc}',`mota`='{$mota}' where `id`=". $id;
    pdo_execute($sql);
}
function them_khuyenmai($ten_km, $gia_tri, $ngay_ket_thuc, $mota) {
    $sql = "INSERT INTO khuyen_mai(ten_km, gia_tri, ngay_ket_thuc, mota) 
            VALUES (?, ?, ?, ?)";
    pdo_execute($sql, $ten_km, $gia_tri, $ngay_ket_thuc, $mota);
}
function loadall_khuyenmai(){
    $sql = "SELECT khuyen_mai.id, khuyen_mai.ten_km,khuyen_mai.gia_tri,khuyen_mai.ngay_ket_thuc,khuyen_mai.mota
    FROM khuyen_mai;
    ";
    $re = pdo_query($sql);
    return $re;
}

function createPromotionEvent() {
    try {
        $conn = pdo_get_connection();
        
        // Bật event scheduler
        $conn->exec("SET GLOBAL event_scheduler = ON");
        
        // Xóa event cũ nếu tồn tại
        $conn->exec("DROP EVENT IF EXISTS auto_delete_expired_promotions");
        
        // Tạo event mới
        $sql = "
        CREATE EVENT auto_delete_expired_promotions
        ON SCHEDULE EVERY 1 DAY
        STARTS CURRENT_TIMESTAMP
        DO
        BEGIN
            -- Xóa trong bảng nguoidung_khuyenmai trước
            DELETE FROM nguoidung_khuyenmai 
            WHERE id_km IN (SELECT id FROM khuyen_mai WHERE ngay_ket_thuc < CURDATE());
            
            -- Sau đó xóa trong bảng khuyen_mai
            DELETE FROM khuyen_mai 
            WHERE ngay_ket_thuc < CURDATE();
        END;
        ";
        
        $conn->exec($sql);
        
        // Kiểm tra event đã được tạo
        $check = $conn->query("SHOW EVENTS LIKE 'auto_delete_expired_promotions'");
        if($check->rowCount() > 0) {
            echo "Event đã được tạo thành công!";
        }
        
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

// Gọi hàm tạo event
createPromotionEvent();
