<?php
function loadall_rap() {
    $sql = "SELECT * FROM rap ORDER BY id DESC";
    $listrap = pdo_query($sql);
    return $listrap;
}

function loadone_rap($id) {
    $sql = "SELECT * FROM rap WHERE id=".$id;
    $rap = pdo_query_one($sql);
    return $rap;
}

function insert_rap($tenrap, $dia_chi, $sdt, $email, $lat, $lng) {
    $sql = "INSERT INTO rap(tenrap, dia_chi, sdt, email, lat, lng) 
            VALUES ('$tenrap', '$dia_chi', '$sdt', '$email', $lat, $lng)";
    pdo_execute($sql);
}

function update_rap($id, $tenrap, $dia_chi, $sdt, $email, $lat, $lng) {
    $sql = "UPDATE rap SET 
            tenrap='".$tenrap."',
            dia_chi='".$dia_chi."',
            sdt='".$sdt."',
            email='".$email."',
            lat=".$lat.",
            lng=".$lng."
            WHERE id=".$id;
    pdo_execute($sql);
}
function loadall_rap_by_phim($id_phim) {
    $sql = "SELECT DISTINCT r.* 
            FROM rap r
            JOIN phongchieu p ON p.rap_id = r.id
            JOIN khung_gio_chieu k ON k.id_phong = p.id
            JOIN lichchieu l ON l.id = k.id_lich_chieu
            WHERE l.id_phim = ?
            AND l.ngay_chieu >= CURDATE()
            AND CONCAT(l.ngay_chieu, ' ', k.thoi_gian_chieu) > NOW()";
            
    return pdo_query($sql, $id_phim);
}
?>