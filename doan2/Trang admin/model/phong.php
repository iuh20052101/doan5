<?php
function load_phong() {
    $sql = "SELECT pc.*, r.tenrap 
            FROM phongchieu pc 
            LEFT JOIN rap r ON pc.rap_id = r.id 
            ORDER BY r.tenrap, pc.name";
    return pdo_query($sql);
}

function load_phong_by_rap($rap_id) {
    $sql = "SELECT pc.*, r.tenrap 
            FROM phongchieu pc 
            LEFT JOIN rap r ON pc.rap_id = r.id 
            WHERE pc.rap_id = ? 
            ORDER BY pc.name";
    return pdo_query($sql, $rap_id);
}

function xoa_phong($id)
{
    $sql = "delete from phongchieu where id=" . $id;
    pdo_execute($sql);
}
function load_phong_by_id($id_phong) {
    try {
        $conn = pdo_get_connection(); // Lấy kết nối PDO
        $sql = "SELECT * FROM phongchieu WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_phong]);
        
        // Lấy thông tin phòng chiếu
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Lỗi truy vấn phòng chiếu: " . $e->getMessage());
        return null; // Trả về null nếu có lỗi
    } finally {
        unset($conn); // Giải phóng kết nối
    }
}


function loadall_phongchieu(){
    $sql = "SELECT p.*, r.tenrap 
            FROM phongchieu p 
            INNER JOIN rap r ON p.rap_id = r.id";
    return pdo_query($sql);
}
function loadone_phong($id){
    $sql = "SELECT p.*, r.tenrap 
            FROM phongchieu p 
            LEFT JOIN rap r ON p.rap_id = r.id 
            WHERE p.id = ?";
    return pdo_query_one($sql, $id);
}
function update_phong($id, $name, $rap_id, $so_hang, $so_cot) {
    $sql = "UPDATE phongchieu SET name = ?, rap_id = ?, so_hang = ?, so_cot = ? WHERE id = ?";
    pdo_execute($sql, $name, $rap_id, $so_hang, $so_cot, $id);
}

// function lay_ghe_theo_phong($phong_id) {
//     try {
//         $sql = "SELECT g.*, p.name as ten_phong 
//                 FROM ghe g
//                 JOIN phongchieu p ON g.id_phongchieu = p.id
//                 WHERE g.id_phongchieu = ?
//                 ORDER BY g.hang, g.so_ghe";
//         return pdo_query($sql, $phong_id);
//     } catch(PDOException $e) {
//         error_log("Lỗi truy vấn ghế: " . $e->getMessage());
//         return [];
//     }
// }

// function tao_ghe_cho_phong($phong_id, $so_hang, $so_cot) {
//     $chu_cai = range('A', 'Z');
    
//     for($i = 0; $i < $so_hang; $i++) {
//         $hang = $chu_cai[$i];
        
//         for($j = 1; $j <= $so_cot; $j++) {
//             $loai_ghe = 'thuong';
//             if($i < 2) {
//                 $loai_ghe = 'vip';
//             } elseif($i >= $so_hang - 2) {
//                 $loai_ghe = 'doi';
//             }
            
//             $sql = "INSERT INTO ghe(id_phongchieu, hang, so_ghe, loai_ghe) 
//                     VALUES(?, ?, ?, ?)";
//             pdo_execute($sql, $phong_id, $hang, $j, $loai_ghe);
//         }
//     }
// }



function cap_nhat_trang_thai_ghe($ghe_id, $trang_thai) {
    $sql = "UPDATE ghe 
            SET trang_thai = ? 
            WHERE id = ?";
    return pdo_execute($sql, $trang_thai, $ghe_id);
}

function them_phong($name, $rap_id, $so_hang, $so_cot) {
    try {
        $conn = pdo_get_connection();
        $conn->beginTransaction();
        
        // 1. Thêm phòng
        $sql = "INSERT INTO phongchieu(name, rap_id, so_hang, so_cot) VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute([$name, $rap_id, $so_hang, $so_cot])) {
            throw new Exception("Không thể thêm phòng");
        }
        
       
        
        $conn->commit();
        return true;
        
    } catch(Exception $e) {
        if(isset($conn)) {
            $conn->rollBack();
        }
        error_log("Lỗi: " . $e->getMessage());
        throw $e;
    }
}