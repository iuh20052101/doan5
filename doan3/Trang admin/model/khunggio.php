<?php
function loadall_khunggiochieu($rap_id = 0) {
    $sql = "SELECT kgc.*, p.tieu_de, pc.name, lc.ngay_chieu, r.tenrap 
            FROM khung_gio_chieu kgc
            INNER JOIN lichchieu lc ON kgc.id_lich_chieu = lc.id
            INNER JOIN phim p ON lc.id_phim = p.id
            INNER JOIN phongchieu pc ON kgc.id_phong = pc.id
            INNER JOIN rap r ON lc.rap_id = r.id";
    
    if($rap_id > 0) {
        $sql .= " WHERE lc.rap_id = $rap_id";
    }
    
    $sql .= " ORDER BY  kgc.id DESC, kgc.thoi_gian_chieu  DESC";
    
    return pdo_query($sql);
}

function loadall_khunggiochieu_by_phong($id_phong) {
    $sql = "SELECT kgc.*, p.tieu_de, pc.name, lc.ngay_chieu, r.tenrap 
            FROM khung_gio_chieu kgc
            INNER JOIN lichchieu lc ON kgc.id_lich_chieu = lc.id
            INNER JOIN phim p ON lc.id_phim = p.id
            INNER JOIN phongchieu pc ON kgc.id_phong = pc.id
            INNER JOIN rap r ON lc.rap_id = r.id
            WHERE kgc.id_phong = ?
            ORDER BY kgc.id DESC, lc.ngay_chieu DESC, kgc.thoi_gian_chieu DESC";
            
    return pdo_query($sql, $id_phong);
}
    function loadone_khung_gio_chieu($id)
    {
        $sql = "select * from khung_gio_chieu where id =" . $id . " ORDER BY id DESC";
        $re = pdo_query_one($sql);
        return $re;
    }

function sua_kgc($id,$id_lc,$id_phong,$thoi_gian_chieu)
{
    $sql = "UPDATE khung_gio_chieu SET `id_lich_chieu`='{$id_lc}',`id_phong`='{$id_phong}',`thoi_gian_chieu`='{$thoi_gian_chieu}'WHERE `khung_gio_chieu`.`id`=" . $id;

    pdo_execute($sql);
}
function xoa_kgc($id)
{
    $sql = "DELETE FROM khung_gio_chieu WHERE id=" . $id;
    pdo_execute($sql);
}
// Sửa lại hàm them_kgc để xử lý nhiều giờ một lúc
// function them_kgc($id_lc, $id_phong, $tgc_array) {
//     foreach($tgc_array as $tgc) {
//         // Kiểm tra khoảng cách thời gian
//         $sql_check = "SELECT thoi_gian_chieu FROM khung_gio_chieu 
//                       WHERE id_lich_chieu = ? AND id_phong = ?";
//         $existing_times = pdo_query($sql_check, $id_lc, $id_phong);
        
//         foreach ($existing_times as $time) {
//             $existing_time = strtotime($time['thoi_gian_chieu']);
//             $new_time = strtotime($tgc);
//             if (abs($new_time - $existing_time) < 3 * 3600) { // 3 tiếng
//                 continue 2; // Bỏ qua nếu không đủ khoảng cách
//             }
//         }
        
//         $sql = "INSERT INTO khung_gio_chieu (id_lich_chieu, id_phong, thoi_gian_chieu) 
//                 VALUES (?, ?, ?)";
//         pdo_execute($sql, $id_lc, $id_phong, $tgc);
//     }
// }

// Thêm hàm kiểm tra trùng lịch
function check_trung_lich($id_phong, $ngay_chieu, $tgc) {
    $sql = "SELECT kgc.* 
            FROM khung_gio_chieu kgc
            INNER JOIN lichchieu lc ON kgc.id_lich_chieu = lc.id
            WHERE kgc.id_phong = ? 
            AND lc.ngay_chieu = ?
            AND kgc.thoi_gian_chieu = ?";
    
    return pdo_query_one($sql, $id_phong, $ngay_chieu, $tgc);
}
function get_suatchieu_trong_ngay($id_phong, $ngay_chieu) {
    $sql = "SELECT kgc.thoi_gian_chieu 
            FROM khung_gio_chieu kgc
            INNER JOIN lichchieu lc ON kgc.id_lich_chieu = lc.id
            WHERE kgc.id_phong = ? 
            AND DATE(lc.ngay_chieu) = DATE(?)
            ORDER BY kgc.thoi_gian_chieu";
    return pdo_query($sql, $id_phong, $ngay_chieu);
}
function them_kgc($id_lc, $id_phong, $tgc_array) {
    try {
        $conn = pdo_get_connection();
        $conn->beginTransaction();

        // Debug
        error_log("Bắt đầu thêm khung giờ chiếu");
        error_log("ID lịch chiếu: $id_lc");
        error_log("ID phòng: $id_phong");
        error_log("Giờ chiếu: " . print_r($tgc_array, true));

        foreach($tgc_array as $tgc) {
            if(empty($tgc)) continue;

            // 1. Thêm khung giờ chiếu
            $sql = "INSERT INTO khung_gio_chieu(id_lich_chieu, id_phong, thoi_gian_chieu) 
                    VALUES(?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt->execute([$id_lc, $id_phong, $tgc])) {
                throw new Exception("Không thể thêm khung giờ chiếu");
            }
            
            // 2. Lấy ID vừa insert
            $kgc_id = $conn->lastInsertId();
            error_log("Đã thêm khung giờ chiếu ID: $kgc_id");
            
            if(!$kgc_id) {
                throw new Exception("Không lấy được ID khung giờ chiếu");
            }

            // 3. Lấy thông tin phòng
            $sql = "SELECT so_hang, so_cot FROM phongchieu WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id_phong]);
            $phong = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$phong) {
                throw new Exception("Không tìm thấy thông tin phòng");
            }

            error_log("Thông tin phòng: " . print_r($phong, true));

            // 4. Tạo ghế
            $chu_cai = range('A', 'Z');
            
            for($i = 0; $i < $phong['so_hang']; $i++) {
                for($j = 1; $j <= $phong['so_cot']; $j++) {
                    $loai_ghe = 'thuong';
                    if($i < 2) $loai_ghe = 'vip';
                    elseif($i >= $phong['so_hang'] - 2) $loai_ghe = 'doi';
                    
                    $sql = "INSERT INTO ghe(id_khung_gio_chieu, hang, so_ghe, loai_ghe, trang_thai) 
                           VALUES(?, ?, ?, ?, 'chưa đặt')";
                    $stmt = $conn->prepare($sql);
                    if (!$stmt->execute([$kgc_id, $chu_cai[$i], $j, $loai_ghe])) {
                        throw new Exception("Không thể thêm ghế hàng {$chu_cai[$i]} số $j");
                    }
                }
            }
            error_log("Đã tạo xong ghế cho khung giờ chiếu $kgc_id");
        }

        $conn->commit();
        error_log("Đã commit thành công");
        return true;

    } catch(Exception $e) {
        $conn->rollBack();
        error_log("Lỗi: " . $e->getMessage());
        error_log($e->getTraceAsString());
        return false;
    }
}