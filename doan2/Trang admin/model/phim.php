<?php

function loadall_phim($searchName1 = "", $searchLoai = "", $rap_id = 0) {
    $sql = "SELECT DISTINCT p.id, p.tieu_de, p.gia_ve, p.daodien, p.dienvien, 
                   p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, 
                   lp.name, p.quoc_gia, p.gia_han_tuoi
            FROM phim p
            LEFT JOIN loaiphim lp ON lp.id = p.id_loai";
    
    if ($rap_id != 0) {
        $sql .= " LEFT JOIN lichchieu lc ON p.id = lc.id_phim
                  LEFT JOIN rap r ON lc.rap_id = r.id";
    }
    
    $sql .= " WHERE 1=1";
    $params = array();
    
    if (!empty($searchName1)) {
        $sql .= " AND p.tieu_de LIKE ?";
        $params[] = "%$searchName1%";
    }
    
    if (!empty($searchLoai)) {
        $sql .= " AND lp.name LIKE ?";
        $params[] = "%$searchLoai%";
    }
    
    if ($rap_id != 0) {
        $sql .= " AND (r.id = ? OR r.id IS NULL)";
        $params[] = $rap_id;
    }
    
    $sql .= " ORDER BY p.id DESC";
    
    try {
        if (empty($params)) {
            $result = pdo_query($sql);
        } else {
            $result = pdo_query($sql, ...$params);
        }
        return $result;
    } catch (Exception $e) {
        error_log("Error in loadall_phim: " . $e->getMessage());
        return array();
    }
}

function get_phim_theo_rap($rap_id) {
    $sql = "SELECT DISTINCT p.*
            FROM phim p
            INNER JOIN lich_chieu lc ON p.id = lc.phim_id
            INNER JOIN rap r ON lc.rap_id = r.id
            WHERE r.id = ?";
    return pdo_query($sql, $rap_id);
}


function them_phim($tieu_de,$gia_ve, $daodien, $dienvien, $img, $mo_ta, $thoiluong, $quoc_gia, $gia_han_tuoi, $date, $id_loai,$link)
{
    $sql = "insert into `phim` (`tieu_de`,`gia_ve`,`daodien`,`dienvien`,`img`,`mo_ta`,`thoi_luong_phim`,`quoc_gia`,`gia_han_tuoi`,`date_phat_hanh`,`id_loai`,`link_trailer`) values ('$tieu_de','$gia_ve','$daodien','$dienvien','$img','$mo_ta','$thoiluong','$quoc_gia','$gia_han_tuoi','$date','$id_loai','$link')";
    pdo_execute($sql);
}

function loadone_phim($id)
{
    $sql = "select * from phim where id =" . $id;
    $re = pdo_query_one($sql);
    return $re;
}

function xoa_phim($id)
{
    $sql = "delete from phim where id=" . $id;
    pdo_execute($sql);
}
function sua_phim($id, $tieu_de,$gia_ve, $img, $mo_ta, $thoiluong, $date, $id_loai)
{
    if ($img != "") {
        $sql = "update phim set `tieu_de`='{$tieu_de}',`gia_ve`='{$gia_ve}',`img`='{$img}',`mo_ta`='{$mo_ta}',`thoi_luong_phim`='{$thoiluong}',`date_phat_hanh`='{$date}',`id_loai`='{$id_loai}'where id=" . $id;
    } else {
        $sql = "update phim set `tieu_de`='{$tieu_de}',`gia_ve`='{$gia_ve}','mo_ta`='{$mo_ta}',`thoi_luong_phim`='{$thoiluong}',`date_phat_hanh`='{$date}',`id_loai`='{$id_loai}'where id=" . $id;
    }
    pdo_execute($sql);
}


function tong_phimdc(){
    $sql = "SELECT COUNT(*) AS total_phim
FROM phim
WHERE date_phat_hanh < CURDATE();";
    $re=pdo_query($sql);
    return  $re;
}

function tong_phimsc(){
    $sql = "SELECT COUNT(*) AS total_phim
FROM phim
WHERE date_phat_hanh > CURDATE();";
    $re=pdo_query($sql);
    return  $re;
}