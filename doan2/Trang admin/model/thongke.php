<?php
// Thống kê doanh thu theo rạp có phân trang
function load_thongke_doanhthu($rap_id = null) {
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 4) THEN hd.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    LEFT JOIN hoa_don hd ON v.id_hd = hd.id";

    if($rap_id) {
        $sql .= " WHERE r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name
              ORDER BY sum_thanhtien DESC";

    return pdo_query($sql);
}

function load_thongke_doanhthu1($rap_id = null) {   
    if(isset($_GET['trang'])) {
        $trang = $_GET['trang'];
    } else {
        $trang = 1;
    }   
    $bghi = 5;
    $vitri = ($trang - 1) * $bghi;
    
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 4) THEN hd.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    LEFT JOIN hoa_don hd ON v.id_hd = hd.id";

    if($rap_id) {
        $sql .= " WHERE r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name
              ORDER BY sum_thanhtien DESC 
              LIMIT $vitri, $bghi";

    return pdo_query($sql);
}

// Thống kê doanh thu ngày không phân trang
function load_doanhthu_ngay($rap_id = null, $from_date = null, $to_date = null) {
    $sql = "SELECT 
        DATE(hoa_don.ngay_tt) as ngay,";
    
    // Nếu chọn rạp cụ thể thì hiện thông tin rạp
    if($rap_id) {
        $sql .= "
            rap.id as rap_id,
            rap.tenrap as ten_rap,
            rap.diachi,";
    }

    $sql .= "
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd
    WHERE 1=1";

    if($rap_id) {
        $sql .= " AND rap.id = $rap_id";
    }
    
    if($from_date) {
        $sql .= " AND DATE(hoa_don.ngay_tt) >= '$from_date'";
    }
    
    if($to_date) {
        $sql .= " AND DATE(hoa_don.ngay_tt) <= '$to_date'";
    }

    // Group by thay đổi tùy theo có lọc rạp hay không
    if($rap_id) {
        $sql .= " GROUP BY rap.id, DATE(hoa_don.ngay_tt)";
    } else {
        $sql .= " GROUP BY DATE(hoa_don.ngay_tt)";
    }

    $sql .= " ORDER BY ngay DESC, sum_thanhtien DESC";

    return pdo_query($sql);
}

// Thống kê doanh thu tuần không phân trang
function load_doanhthu_tuan($rap_id = null) {
    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        YEARWEEK(hoa_don.ngay_tt) as tuan,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, YEARWEEK(hoa_don.ngay_tt)
              ORDER BY tuan DESC, sum_thanhtien DESC";

    return pdo_query($sql);
}

// Thống kê doanh thu tháng không phân trang
function load_doanhthu_thang($rap_id = null) {
    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        MONTH(hoa_don.ngay_tt) as thang,
        YEAR(hoa_don.ngay_tt) as nam,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, YEAR(hoa_don.ngay_tt), MONTH(hoa_don.ngay_tt)
              ORDER BY nam DESC, thang DESC, sum_thanhtien DESC";

    return pdo_query($sql);
}


// Thống kê doanh thu theo ngày
function load_doanhthu_ngay1($rap_id = null) {
    if(isset($_GET['trang'])) {
        $trang = $_GET['trang'];
    } else {
        $trang = 1;
    }   
    $bghi = 5;
    $vitri = ($trang - 1) * $bghi;

    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        DATE(hoa_don.ngay_tt) as ngay,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, DATE(hoa_don.ngay_tt)
              ORDER BY ngay DESC, sum_thanhtien DESC 
              LIMIT $vitri, $bghi";

    return pdo_query($sql);
}

// Thống kê doanh thu theo tuần
function load_doanhthu_tuan1($rap_id = null) {
    if(isset($_GET['trang'])) {
        $trang = $_GET['trang'];
    } else {
        $trang = 1;
    }   
    $bghi = 5;
    $vitri = ($trang - 1) * $bghi;

    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        YEARWEEK(hoa_don.ngay_tt) as tuan,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, YEARWEEK(hoa_don.ngay_tt)
              ORDER BY tuan DESC, sum_thanhtien DESC 
              LIMIT $vitri, $bghi";

    return pdo_query($sql);
}

// Thống kê doanh thu theo tháng
function load_doanhthu_thang1($rap_id = null) {
    if(isset($_GET['trang'])) {
        $trang = $_GET['trang'];
    } else {
        $trang = 1;
    }   
    $bghi = 5;
    $vitri = ($trang - 1) * $bghi;

    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        MONTH(hoa_don.ngay_tt) as thang,
        YEAR(hoa_don.ngay_tt) as nam,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, YEAR(hoa_don.ngay_tt), MONTH(hoa_don.ngay_tt)
              ORDER BY nam DESC, thang DESC, sum_thanhtien DESC 
              LIMIT $vitri, $bghi";

    return pdo_query($sql);
}

// Các hàm thống kê tổng
function best_combo() {
    $sql = "SELECT 
        v.combo,
        COUNT(v.combo) AS so_luong_dat
    FROM ve v
    WHERE v.trang_thai IN (1, 2, 4)
    AND v.combo IS NOT NULL
    GROUP BY v.combo
    ORDER BY so_luong_dat DESC
    LIMIT 1";
    return pdo_query($sql);
}

function tong_week() {
    $sql = "SELECT 
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as tong_ve,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as tong_doanhthu
    FROM hoa_don
    LEFT JOIN ve ON hoa_don.id = ve.id_hd
    WHERE YEARWEEK(hoa_don.ngay_tt) = YEARWEEK(CURDATE())";
    return pdo_query($sql);
}

function tong_thang() {
    $sql = "SELECT 
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as tong_ve,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as tong_doanhthu
    FROM hoa_don
    LEFT JOIN ve ON hoa_don.id = ve.id_hd
    WHERE MONTH(hoa_don.ngay_tt) = MONTH(CURDATE())
    AND YEAR(hoa_don.ngay_tt) = YEAR(CURDATE())";
    return pdo_query($sql);
}

function tong_day() {
    $sql = "SELECT 
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as tong_ve,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as tong_doanhthu
    FROM hoa_don
    LEFT JOIN ve ON hoa_don.id = ve.id_hd
    WHERE DATE(hoa_don.ngay_tt) = CURDATE()";
    return pdo_query($sql);
}

function thongke_phim_dangchieu() {
    $sql = "SELECT COUNT(*) as tong_phimdc FROM phim";
    return pdo_query_one($sql);
}

function thongke_tong_doanhthu() {
    $sql = "SELECT 
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as tong_ve,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as tong_doanhthu
    FROM hoa_don
    LEFT JOIN ve ON hoa_don.id = ve.id_hd";
    return pdo_query($sql);
}
function tong(){
    $sql = "SELECT 
    SUM(so_luong_ve_dat) AS tong_so_luong_ve_dat,
    SUM(sum_thanhtien) AS tong_doanh_thu
FROM (
    SELECT 
        phim.id as id, 
        phim.tieu_de as tieu_de, 
        loaiphim.name as ten_loaiphim, 
        COUNT(CASE WHEN ve.trang_thai IN (1, 2,4) THEN ve.id END) as so_luong_ve_dat, 
        SUM(CASE WHEN ve.trang_thai IN (1, 2,4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM 
        phim
    LEFT JOIN 
        loaiphim ON loaiphim.id = phim.id_loai
    LEFT JOIN 
        lichchieu ON phim.id = lichchieu.id_phim
    LEFT JOIN 
        khung_gio_chieu ON lichchieu.id = khung_gio_chieu.id_lich_chieu
    LEFT JOIN 
        ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN 
        hoa_don ON hoa_don.id = ve.id_hd
    GROUP BY 
        phim.id
) AS phim_stats";

    $all = pdo_query($sql);
    return $all;
}
function load_doanhthu_rap($rap_id = null) {
    $sql = "SELECT 
        rap.id as rap_id,
        rap.tenrap as ten_rap,
        rap.diachi,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM rap
    LEFT JOIN phongchieu ON rap.id = phongchieu.rap_id
    LEFT JOIN khung_gio_chieu ON phongchieu.id = khung_gio_chieu.id_phong
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " WHERE rap.id = $rap_id";
    }

    $sql .= " GROUP BY rap.id, rap.tenrap, rap.diachi
              ORDER BY sum_thanhtien DESC";

    return pdo_query($sql);
}
function load_doanhthu_phim($rap_id = null) {
    $sql = "SELECT 
        phim.id,
        phim.tieu_de,
        loaiphim.ten_loaiphim,
        COUNT(DISTINCT CASE WHEN ve.trang_thai IN (1, 2, 4) THEN ve.id END) as so_luong_ve_dat,
        SUM(CASE WHEN ve.trang_thai IN (1, 2, 4) THEN hoa_don.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim
    LEFT JOIN loaiphim ON phim.id_loaiphim = loaiphim.id
    LEFT JOIN khung_gio_chieu ON phim.id = khung_gio_chieu.id_phim
    LEFT JOIN ve ON ve.id_thoi_gian_chieu = khung_gio_chieu.id
    LEFT JOIN hoa_don ON hoa_don.id = ve.id_hd";

    if($rap_id) {
        $sql .= " LEFT JOIN phongchieu ON khung_gio_chieu.id_phong = phongchieu.id
                  WHERE phongchieu.rap_id = $rap_id";
    }

    $sql .= " GROUP BY phim.id, phim.tieu_de, loaiphim.ten_loaiphim
              ORDER BY sum_thanhtien DESC";

    return pdo_query($sql);
}

// Thống kê phim bán chạy/ế nhất
function thongke_phim_theo_rap($rap_id = null) {
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        r.tenrap,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 4) THEN hd.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    LEFT JOIN hoa_don hd ON v.id_hd = hd.id";

    if($rap_id) {
        $sql .= " WHERE r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name, r.tenrap
              ORDER BY so_luong_ve_dat DESC";

    return pdo_query($sql);
}
// Thống kê phim theo ngày
function thongke_phim_theo_ngay($ngay, $rap_id = null) {
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        r.tenrap,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 4) THEN hd.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    LEFT JOIN hoa_don hd ON v.id_hd = hd.id
    WHERE DATE(hd.ngay_tt) = '$ngay'";

    if($rap_id) {
        $sql .= " AND r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name, r.tenrap
              ORDER BY so_luong_ve_dat DESC";

    return pdo_query($sql);
}

// Thống kê phim theo tuần
function thongke_phim_theo_tuan($tuan, $rap_id = null) {
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        r.tenrap,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 4) THEN hd.thanh_tien ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    LEFT JOIN hoa_don hd ON v.id_hd = hd.id
    WHERE YEARWEEK(hd.ngay_tt, 1) = '$tuan'";

    if($rap_id) {
        $sql .= " AND r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name, r.tenrap
              ORDER BY so_luong_ve_dat DESC";

    return pdo_query($sql);
}

// Thống kê phim theo tháng
function thongke_phim_theo_thang($month, $year, $rap_id = null) {
    // Tạo ngày đầu và cuối tháng
    $start_date = date("$year-$month-01 00:00:00");
    $end_date = date("$year-$month-t 23:59:59", strtotime($start_date));
    
    $sql = "SELECT 
        p.id,
        p.tieu_de,
        l.name as ten_loaiphim,
        r.tenrap,
        COUNT(DISTINCT CASE WHEN v.trang_thai IN (1, 2, 3, 4) THEN v.id END) as so_luong_ve_dat,
        SUM(CASE WHEN v.trang_thai IN (1, 2, 3, 4) THEN v.price ELSE 0 END) as sum_thanhtien
    FROM phim p
    LEFT JOIN loaiphim l ON p.id_loai = l.id
    LEFT JOIN khung_gio_chieu kgc ON kgc.id_lich_chieu IN (
        SELECT id FROM lichchieu WHERE id_phim = p.id
    )
    LEFT JOIN phongchieu pc ON kgc.id_phong = pc.id
    LEFT JOIN rap r ON pc.rap_id = r.id
    LEFT JOIN ve v ON v.id_thoi_gian_chieu = kgc.id
    WHERE v.ngay_dat IS NOT NULL 
    AND v.trang_thai IN (1, 2, 3, 4)
    AND v.ngay_dat BETWEEN '$start_date' AND '$end_date'";

    if($rap_id) {
        $sql .= " AND r.id = $rap_id";
    }

    $sql .= " GROUP BY p.id, p.tieu_de, l.name, r.tenrap
              HAVING so_luong_ve_dat > 0
              ORDER BY so_luong_ve_dat DESC";

    return pdo_query($sql);
}
?>