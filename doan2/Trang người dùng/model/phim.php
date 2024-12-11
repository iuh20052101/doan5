<?php

function loadall_phim()
{if(isset($_GET['sotrang'])){
    $sotrang=$_GET['sotrang'];
   }else{
       $sotrang=1;
   }
   $bghi=5;
   $vitri=($sotrang-1)*$bghi;
    $sql = "SELECT p.id, p.tieu_de,p.gia_ve, p.daodien, p.dienvien, p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, loaiphim.name, p.quoc_gia, p.gia_han_tuoi, p.link_trailer
    FROM phim p
    INNER JOIN loaiphim ON loaiphim.id = p.id_loai where 1 order by id asc limit $vitri,$bghi";
    $re = pdo_query($sql);
    return $re;
}
function loadall_phim_hot()
{
    $sql = "SELECT
    p.id,
    p.tieu_de,
    p.gia_ve,
    p.daodien,
    p.dienvien,
    p.img,
    p.mo_ta,
    p.date_phat_hanh,
    p.thoi_luong_phim,
    loaiphim.name,
    p.quoc_gia,
    p.gia_han_tuoi,
    COUNT(v.id) AS tong_so_ve
FROM
    phim p
INNER JOIN
    loaiphim ON loaiphim.id = p.id_loai
LEFT JOIN
    ve v ON v.id_phim = p.id
WHERE
    v.trang_thai IN (1, 2, 4)
GROUP BY
    p.id
ORDER BY
    tong_so_ve DESC
LIMIT
    0, 6;
";
    $listsanpham = pdo_query($sql);
    return $listsanpham;
}


function loadall_phim_home()
{
    $sql = "SELECT p.id, p.tieu_de,p.gia_ve, p.daodien, p.dienvien, p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, loaiphim.name, p.quoc_gia, p.gia_han_tuoi
FROM phim p
INNER JOIN loaiphim ON loaiphim.id = p.id_loai
WHERE 1
ORDER BY p.id DESC
LIMIT 0,8;";
    $listsanpham = pdo_query($sql);
    return $listsanpham;
}

function loadone_phim($id) {
    $sql = "SELECT p.id, p.tieu_de, p.gia_ve, p.daodien, p.dienvien, 
                   p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, 
                   loaiphim.name, p.quoc_gia, p.gia_han_tuoi, p.link_trailer
            FROM phim p
            INNER JOIN loaiphim ON loaiphim.id = p.id_loai 
            WHERE p.id = ?";
    return pdo_query_one($sql, $id);
}


//function loadall_phim1($kys="",$id_loai=0){
//    $sql="SELECT phim.id, phim.tieu_de, phim.img, phim.mo_ta, phim.thoi_luong_phim, phim.date_phat_hanh, loaiphim.name FROM phim left JOIN loaiphim ON phim.id_loai = loaiphim.id";
//    if($kys!=""){
//        $sql.=" and tieu_de like '%".$kys."%'";
//    }
//    if($id_loai>0){
//        $sql.=" and id_loai ='".$id_loai."'";
//    }
//    $sql.=" order by id desc";
//    $re=pdo_query($sql);
//    return  $re;
//}
function phim_select_all()
{
    $sql = "SELECT phim.id, phim.tieu_de,phim.gia_ve, phim.img, phim.mo_ta, phim.thoi_luong_phim, phim.date_phat_hanh, loaiphim.name FROM phim left JOIN loaiphim ON phim.id_loai = loaiphim.id
            where 1 order by id asc";
    return pdo_query($sql);
}

function loadall_phim1($kys="",$id_loai=0){
    
    $sql="SELECT p.id, p.tieu_de,p.gia_ve ,p.daodien, p.dienvien, p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, loaiphim.name, p.quoc_gia, p.gia_han_tuoi, p.link_trailer
FROM phim p
INNER JOIN loaiphim ON loaiphim.id = p.id_loai";
    if($kys!=""){
        $sql.=" and tieu_de like '%".$kys."%'";
    }
    if($id_loai>0){
        $sql.=" and id_loai ='".$id_loai."'";
    }
    $sql.=" order by id desc  ";
    $re=pdo_query($sql);
    return  $re;
}

function load_phimdc(){
    $sql = "SELECT p.id,p.tieu_de,p.gia_ve, p.daodien, p.dienvien, p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, loaiphim.name, p.quoc_gia, p.gia_han_tuoi
FROM phim p
INNER JOIN loaiphim ON loaiphim.id = p.id_loai
WHERE p.date_phat_hanh < CURDATE();
";
    $re=pdo_query($sql);
    return  $re;
}

function load_phimsc(){
    $sql = "SELECT p.id,p.tieu_de,p.gia_ve, p.daodien, p.dienvien, p.img, p.mo_ta, p.date_phat_hanh, p.thoi_luong_phim, loaiphim.name, p.quoc_gia, p.gia_han_tuoi
FROM phim p
INNER JOIN loaiphim ON loaiphim.id = p.id_loai
WHERE p.date_phat_hanh > CURDATE()
";
    $re=pdo_query($sql);
    return  $re;
}

function load_lc_p($id_phim, $id_lichchieu, $id_gio) {
    try {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_time = time(); // Lấy timestamp hiện tại

        $sql = "SELECT lc.*, p.gia_ve, p.tieu_de, pc.id as id_phongchieu, 
                       pc.name as ten_phong, pc.rap_id,
                       kgc.thoi_gian_chieu, kgc.id_phong,
                       r.tenrap, r.id as rap_id
                FROM lichchieu lc
                JOIN phim p ON lc.id_phim = p.id 
                JOIN khung_gio_chieu kgc ON lc.id = kgc.id_lich_chieu
                JOIN phongchieu pc ON kgc.id_phong = pc.id
                JOIN rap r ON pc.rap_id = r.id
                WHERE lc.id_phim = ? 
                AND lc.id = ? 
                AND kgc.id = ?";
                
        $result = pdo_query_one($sql, [$id_phim, $id_lichchieu, $id_gio]);
        
        if ($result) {
            // Tạo timestamp đầy đủ từ ngày chiếu và giờ chiếu
            $show_datetime = strtotime($result['ngay_chieu'] . ' ' . $result['thoi_gian_chieu']);
            
            // Kiểm tra nếu thời gian chiếu đã qua
            if ($show_datetime <= $current_time) {
                error_log("Suất chiếu đã qua: " . date('Y-m-d H:i:s', $show_datetime));
                return null;
            }

            $result['id_phim'] = $id_phim;
            $result['id_lichchieu'] = $id_lichchieu;
            $result['id_g'] = $id_gio;
            $result['gio_chieu'] = date('H:i', strtotime($result['thoi_gian_chieu']));
            
            // Debug
            error_log("Current time: " . date('Y-m-d H:i:s', $current_time));
            error_log("Show time: " . date('Y-m-d H:i:s', $show_datetime));
        }
        
        return $result;
    } catch(PDOException $e) {
        error_log("Lỗi truy vấn lịch chiếu: " . $e->getMessage());
        return null;
    }
}
function dat_phim($ten, $ngay, $gio, $gia_ve,$tk)
{
    $sql = "insert into `ve` (`id_thoi_gian_chieu`,`id_ngay_chieu`,`id_phim`,`id_tk`,`ghe`,`price`) values ('$gio','$ngay','$ten','$gia_ve','$tk','0','$gia_ve')";
    pdo_execute($sql);
}function lay_gia_ve($id_phim) {
    $sql = "SELECT gia_ve FROM phim WHERE id = ?";
    $result = pdo_query_one($sql, $id_phim);
    return isset($result['gia_ve']) ? $result['gia_ve'] : 0;
}

function lay_thong_tin_rap($rap_id) {
    if(!$rap_id) return null;
    $sql = "SELECT * FROM rap WHERE id = ?";
    return pdo_query_one($sql, [$rap_id]);
}
function lay_thong_tin_gio($id_g) {
    if(!$id_g) return null;
    $sql = "SELECT kgc.*, lc.ngay_chieu, p.name as ten_phong 
            FROM khung_gio_chieu kgc
            JOIN lichchieu lc ON kgc.id_lich_chieu = lc.id
            JOIN phongchieu p ON kgc.id_phong = p.id
            WHERE kgc.id = ?";
    return pdo_query_one($sql, [$id_g]);
    
}
function get_phim_by_loai($id_loai) {
    $sql = "SELECT p.*, l.name 
            FROM phim p 
            INNER JOIN loaiphim l ON p.id_loai = l.id 
            WHERE p.id_loai = ?";
    return pdo_query($sql, $id_loai);
}



