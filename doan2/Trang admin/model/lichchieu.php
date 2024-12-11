<?php
function loadall_lichchieu($rap_id = 0) {
    $sql = "SELECT lc.*, p.tieu_de, r.tenrap 
            FROM lichchieu lc
            INNER JOIN phim p ON lc.id_phim = p.id 
            INNER JOIN rap r ON lc.rap_id = r.id";
    
    // Thêm điều kiện lọc theo rạp nếu có
    if($rap_id > 0) {
        $sql .= " WHERE lc.rap_id = ?";
        $sql .= " ORDER BY lc.id DESC";
        return pdo_query($sql, $rap_id);
    }
    
    $sql .= " ORDER BY lc.id DESC";
    return pdo_query($sql);
}

function loadone_lichchieu($id)
{
    $sql = "select * from lichchieu where id =" . $id;
    $re = pdo_query_one($sql);
    return $re;
}

function check_lichchieu_trung($id_phim, $rap_id, $ngay_chieu) {
    $sql = "SELECT COUNT(*) as count 
            FROM lichchieu 
            WHERE id_phim = ? 
            AND rap_id = ? 
            AND ngay_chieu = ?";
    $result = pdo_query_one($sql, $id_phim, $rap_id, $ngay_chieu);
    return $result['count'] > 0;
}

function them_lichchieu($id_phim, $rap_id, $ngay_chieu) {
    // Kiểm tra lịch chiếu trùng
    if(check_lichchieu_trung($id_phim, $rap_id, $ngay_chieu)) {
        return array(
            'status' => false,
            'message' => 'Phim này đã có lịch chiếu vào ngày ' . date('d/m/Y', strtotime($ngay_chieu)) . ' tại rạp này!'
        );
    }
    
    // Nếu không trùng thì thêm mới
    $sql = "INSERT INTO lichchieu(id_phim, rap_id, ngay_chieu) 
            VALUES (?, ?, ?)";
    try {
        pdo_execute($sql, $id_phim, $rap_id, $ngay_chieu);
        return array(
            'status' => true,
            'message' => 'Thêm lịch chiếu thành công!'
        );
    } catch(Exception $e) {
        return array(
            'status' => false,
            'message' => 'Lỗi: ' . $e->getMessage()
        );
    }
}

function sua_lichchieu($id, $id_phim, $rap_id, $ngay_chieu) {
    $sql = "UPDATE lichchieu 
            SET id_phim = ?, rap_id = ?, ngay_chieu = ? 
            WHERE id = ?";
    return pdo_execute($sql, $id_phim, $rap_id, $ngay_chieu, $id);
}

function xoa_lc($id)
{
    $sql = "DELETE FROM lichchieu WHERE id=" . $id;
    pdo_execute($sql);
}
function get_lich_chieu($id) {
    $sql = "SELECT * FROM lichchieu WHERE id = ?";
    return pdo_query_one($sql, $id);
}