<?php


function loadall_phong(){
    $sql = "select * from phongchieu order by id desc";
    $listphong = pdo_query($sql);
    return $listphong;
}

function loadone_phong($id_phong) {
    $sql = "SELECT * FROM phongchieu WHERE id = ?";
    return pdo_query_one($sql, $id_phong);
}

// Các hàm khác liên quan đến phòng chiếu...
function lay_thong_tin_phong($id_phong) {
    if(!$id_phong) return null;
    $sql = "SELECT * FROM phongchieu WHERE id = ?";
    return pdo_query_one($sql, [$id_phong]);
}

