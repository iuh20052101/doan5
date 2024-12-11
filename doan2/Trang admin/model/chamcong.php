<?php
if (!function_exists('checkQuanLy')) {
    function checkQuanLy($id_admin) {
        $sql = "SELECT vai_tro FROM taikhoan WHERE id = ?";
        $result = pdo_query_one($sql, $id_admin);
        return ($result && $result['vai_tro'] == 2);
    }
}

if (!function_exists('getLichLamViecAll')) {
    function getLichLamViecAll() {
        $sql = "SELECT *
                FROM lichlamviec 
                WHERE ngay_lam_viec = CURRENT_DATE
                ORDER BY ca_lam_viec ASC";
        return pdo_query($sql);
    }
}

if (!function_exists('getBangChamCong')) {
    function getBangChamCong($thang, $nam) {
        $sql = "SELECT *
                FROM lichlamviec 
                WHERE MONTH(ngay_lam_viec) = ? 
                AND YEAR(ngay_lam_viec) = ?
                ORDER BY ngay_lam_viec DESC, ca_lam_viec ASC";
        return pdo_query($sql, $thang, $nam);
    }
}

if (!function_exists('chamCongChoNhanVien')) {
    function chamCongChoNhanVien($id_lichlamviec, $trang_thai) {
        // Debug
        echo "Updating: ID=$id_lichlamviec, Status=$trang_thai<br>";
        
        try {
            $sql = "UPDATE lichlamviec 
                    SET trang_thai_cham_cong = ?
                    WHERE id = ?";
            return pdo_execute($sql, $trang_thai, $id_lichlamviec);
        } catch (Exception $e) {
            // Debug
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}



// Lấy lịch làm việc theo tháng cho quản lý
function getLichLamViecQuanLy($thang, $nam, $id_taikhoan = null) {
    $sql = "SELECT l.*, r.tenrap, tk.name as ten_quanly
            FROM lichlamviec l
            INNER JOIN rap r ON l.id_rap = r.id
            INNER JOIN taikhoan tk ON l.id_taikhoan = tk.id
            WHERE MONTH(l.ngay_lam_viec) = ? 
            AND YEAR(l.ngay_lam_viec) = ?";
            
    if($id_taikhoan) {
        $sql .= " AND l.id_taikhoan = ?";
        return pdo_query($sql, $thang, $nam, $id_taikhoan);
    }
    
    return pdo_query($sql, $thang, $nam);
}

// Cập nhật trạng thái chấm công
function chamCong($id_lichlamviec, $trang_thai) {
    try {
        $sql = "UPDATE lichlamviec 
                SET trang_thai_cham_cong = ?
                WHERE id = ?";
        return pdo_execute($sql, $trang_thai, $id_lichlamviec);
    } catch (Exception $e) {
        error_log("Lỗi chấm công: " . $e->getMessage());
        return false;
    }
}

// Lấy thống kê chấm công theo tháng
function getThongKeChamCong($thang, $nam, $is_quanly = false) {
    $sql = "SELECT 
                CASE 
                    WHEN id_taikhoan IS NOT NULL THEN tk.name
                    ELSE ten_nhanvien 
                END as ten_nguoi_lam,
                COUNT(*) as tong_ca,
                SUM(CASE WHEN trang_thai_cham_cong = 'đúng giờ' THEN 1 ELSE 0 END) as dung_gio,
                SUM(CASE WHEN trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as di_tre,
                SUM(CASE WHEN trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as vang
            FROM lichlamviec l
            LEFT JOIN taikhoan tk ON l.id_taikhoan = tk.id
            WHERE MONTH(ngay_lam_viec) = ? 
            AND YEAR(ngay_lam_viec) = ?";
    
    if($is_quanly) {
        $sql .= " AND id_taikhoan IS NOT NULL";
    } else {
        $sql .= " AND id_taikhoan IS NULL";
    }
    
    $sql .= " GROUP BY CASE WHEN id_taikhoan IS NOT NULL THEN tk.name ELSE ten_nhanvien END";
    
    return pdo_query($sql, $thang, $nam);
}
if (!function_exists('getTrangThaiBadgeClass')) {
    function getTrangThaiBadgeClass($trang_thai) {
        switch($trang_thai) {
            case 'đúng giờ': return 'success';
            case 'đi trễ': return 'warning';
            case 'vắng': return 'danger';
            default: return 'secondary';
        }
    }
}

// Lấy danh sách quản lý theo rạp
function getQuanLyTheoRap($thang, $nam, $rap_id = null) {
    $params = [$thang, $nam];
    
    $sql = "SELECT r.id as rap_id, r.tenrap,
            tk.id as id_taikhoan, tk.name as ten_quanly,
            COUNT(DISTINCT l.ngay_lam_viec) as tong_ngay,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đúng giờ' THEN 1 ELSE 0 END) as dung_gio,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as di_tre,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as vang
            FROM rap r
            INNER JOIN lichlamviec l ON r.id = l.id_rap
            INNER JOIN taikhoan tk ON l.id_taikhoan = tk.id
            WHERE MONTH(l.ngay_lam_viec) = ? 
            AND YEAR(l.ngay_lam_viec) = ?";
            
    if($rap_id) {
        $sql .= " AND r.id = ?";
        $params[] = $rap_id;
    }
    
    $sql .= " GROUP BY r.id, tk.id
              ORDER BY r.tenrap, tk.name";
              
    $result = pdo_query($sql, ...$params);
    
    // Chuyển đổi kết quả thành mảng theo rạp
    $dsQuanLyTheoRap = [];
    foreach($result as $row) {
        if(!isset($dsQuanLyTheoRap[$row['rap_id']])) {
            $dsQuanLyTheoRap[$row['rap_id']] = [
                'ten_rap' => $row['tenrap'],
                'quanly' => []
            ];
        }
        
        // Thêm chi tiết chấm công theo ngày
        $row['chi_tiet'] = getChiTietChamCong($row['id_taikhoan'], $row['rap_id'], $thang, $nam);
        
        $dsQuanLyTheoRap[$row['rap_id']]['quanly'][] = $row;
    }
    
    return $dsQuanLyTheoRap;
}

// Lấy chi tiết chấm công theo ngày
function getChiTietChamCong($id_taikhoan, $id_rap, $thang, $nam) {
    $sql = "SELECT id, ngay_lam_viec, trang_thai_cham_cong
            FROM lichlamviec
            WHERE id_taikhoan = ?
            AND id_rap = ?
            AND MONTH(ngay_lam_viec) = ?
            AND YEAR(ngay_lam_viec) = ?
            ORDER BY ngay_lam_viec";
            
    return pdo_query($sql, $id_taikhoan, $id_rap, $thang, $nam);
}
function getThongKeNhanVien($thang, $nam) {
    $sql = "SELECT 
            tk.id as id_nhanvien,
            tk.name as ten_nguoi_lam,
            COUNT(DISTINCT l.ngay_lam_viec) as tong_ca,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đúng giờ' THEN 1 ELSE 0 END) as dung_gio,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as di_tre,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as vang
            FROM taikhoan tk
            LEFT JOIN lichlamviec l ON tk.id = l.id_taikhoan
            WHERE MONTH(l.ngay_lam_viec) = ? 
            AND YEAR(l.ngay_lam_viec) = ?
            GROUP BY tk.id";
            
    $thongke = pdo_query($sql, $thang, $nam);
    
    // Lấy thêm chi tiết theo ngày cho mỗi nhân viên
    foreach($thongke as &$tk) {
        $sql_chitiet = "SELECT l.*, r.tenrap
                       FROM lichlamviec l
                       LEFT JOIN rap r ON l.id_rap = r.id
                       WHERE l.id_taikhoan = ?
                       AND MONTH(l.ngay_lam_viec) = ?
                       AND YEAR(l.ngay_lam_viec) = ?
                       ORDER BY l.ngay_lam_viec, l.ca_lam_viec";
        $tk['chi_tiet'] = pdo_query($sql_chitiet, $tk['id_nhanvien'], $thang, $nam);
    }
    
    return $thongke;
}
function getLichLamViecNhanVien($ngay, $rap_id = null) {
    $sql = "SELECT l.*, r.tenrap 
            FROM lichlamviec l
            LEFT JOIN rap r ON l.id_rap = r.id
            WHERE l.ngay_lam_viec = ?
            AND l.ten_nhanvien IS NOT NULL
            AND l.id_taikhoan IS NULL";  // Thêm điều kiện lọc nhân viên
    $params = [$ngay];
    
    if ($rap_id) {
        $sql .= " AND l.id_rap = ?";
        $params[] = $rap_id;
    }
    
    $sql .= " ORDER BY l.ca_lam_viec";
    return pdo_query($sql, ...$params);
}

function getThongKeNhanVienChiTiet($thang, $nam, $rap_id = null) {
    $sql = "SELECT 
            l.ten_nhanvien,
            COUNT(DISTINCT l.ngay_lam_viec) as tong_ca,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đúng giờ' THEN 1 ELSE 0 END) as dung_gio,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as di_tre,
            SUM(CASE WHEN l.trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as vang
            FROM lichlamviec l
            WHERE MONTH(l.ngay_lam_viec) = ? 
            AND YEAR(l.ngay_lam_viec) = ?
            AND l.ten_nhanvien IS NOT NULL  -- Thêm điều kiện này
            AND l.id_taikhoan IS NULL";    
    
    $params = [$thang, $nam];
    
    if ($rap_id) {
        $sql .= " AND l.id_rap = ?";
        $params[] = $rap_id;
    }
    
    $sql .= " GROUP BY l.ten_nhanvien";
    
    $thongke = pdo_query($sql, ...$params);
    
    // Lấy chi tiết cho từng nhân viên
    foreach($thongke as &$tk) {
        $sql_chitiet = "SELECT l.*, r.tenrap
                       FROM lichlamviec l
                       LEFT JOIN rap r ON l.id_rap = r.id
                       WHERE l.ten_nhanvien = ?
                       AND l.id_taikhoan IS NULL
                       AND MONTH(l.ngay_lam_viec) = ?
                       AND YEAR(l.ngay_lam_viec) = ?";
        
        $chitiet_params = [$tk['ten_nhanvien'], $thang, $nam];
        
        if ($rap_id) {
            $sql_chitiet .= " AND l.id_rap = ?";
            $chitiet_params[] = $rap_id;
        }
        
        $sql_chitiet .= " ORDER BY l.ngay_lam_viec, l.ca_lam_viec";
        
        $tk['chi_tiet'] = pdo_query($sql_chitiet, ...$chitiet_params);
    }
    
    return $thongke;
}


// Thêm các hằng số cấu hình lương
define('LUONG_NGAY_QUANLY', 300000);  // Lương quản lý: 300k/ngày
define('THUONG_CHUYEN_CAN_QUANLY', 1000000); // Thưởng chuyên cần quản lý: 1 triệu/tháng
define('PHAT_VANG_QUANLY', 500000);   // Phạt vắng quản lý: 500k/ngày
define('PHAT_TRE_QUANLY', 100000);    // Phạt đi trễ quản lý: 100k/lần

// Định nghĩa mức lương theo công việc
define('LUONG_THEO_CONGVIEC', [
    'Nhân viên bán vé' => 120000,                         // 120k/ca
    'Nhân viên phòng chiếu' => 130000,                   // 130k/ca
    'Nhân viên vệ sinh' => 100000,                       // 100k/ca
    'Nhân viên bảo vệ' => 150000,                        // 150k/ca
    'Nhân viên phục vụ đồ ăn và thức uống' => 110000,    // 110k/ca
    'Kỹ thuật viên' => 180000                            // 180k/ca
]);

define('THUONG_CHUYEN_CAN_NHANVIEN', 800000); // Thưởng chuyên cần nhân viên: 800k/tháng
define('PHAT_VANG_NHANVIEN', 200000);  // Phạt vắng nhân viên: 200k/ca
define('PHAT_TRE_NHANVIEN', 50000);    // Phạt đi trễ nhân viên: 50k/lần

// Hàm tính lương quản lý
function tinhLuongQuanLy($id_taikhoan, $thang, $nam) {
    // Lấy thông tin chấm công từ bảng lichlamviec
    $sql = "SELECT 
            COUNT(DISTINCT ngay_lam_viec) as so_ngay_lam,
            SUM(CASE WHEN trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as so_lan_vang,
            SUM(CASE WHEN trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as so_lan_tre
            FROM lichlamviec 
            WHERE id_taikhoan = ? 
            AND MONTH(ngay_lam_viec) = ?
            AND YEAR(ngay_lam_viec) = ?";
            
    $chamcong = pdo_query_one($sql, $id_taikhoan, $thang, $nam);
    
    // Tính lương cơ bản
    $luong_co_ban = $chamcong['so_ngay_lam'] * LUONG_NGAY_QUANLY;
    
    // Tính thưởng chuyên cần (nếu làm >= 20 ngày)
    $thuong_chuyen_can = ($chamcong['so_ngay_lam'] >= 20) ? THUONG_CHUYEN_CAN_QUANLY : 0;
    
    // Tính tiền phạt
    $tien_phat = ($chamcong['so_lan_vang'] * PHAT_VANG_QUANLY) 
                + ($chamcong['so_lan_tre'] * PHAT_TRE_QUANLY);
    
    // Tính tổng lương
    $tong_luong = $luong_co_ban + $thuong_chuyen_can - $tien_phat;
    
    return [
        'luong_co_ban' => $luong_co_ban,
        'thuong_chuyen_can' => $thuong_chuyen_can,
        'tien_phat' => $tien_phat,
        'tong_luong' => $tong_luong,
        'chi_tiet' => $chamcong
    ];
}

// Hàm tính lương nhân viên
function tinhLuongNhanVien($ten_nhanvien, $thang, $nam) {
    // Lấy thông tin chấm công và công việc
    $sql = "SELECT 
            COUNT(*) as so_ca_lam,
            SUM(CASE WHEN trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as so_lan_vang,
            SUM(CASE WHEN trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as so_lan_tre,
            ten_cong_viec  -- Thêm cột này
            FROM lichlamviec 
            WHERE ten_nhanvien = ?
            AND MONTH(ngay_lam_viec) = ?
            AND YEAR(ngay_lam_viec) = ?
            GROUP BY ten_nhanvien, ten_cong_viec
            LIMIT 1";  // Thêm LIMIT 1 để đảm bảo chỉ lấy 1 bản ghi
            
    $chamcong = pdo_query_one($sql, $ten_nhanvien, $thang, $nam);
    
    if(!$chamcong) {
        return [
            'luong_co_ban' => 0,
            'thuong_chuyen_can' => 0,
            'tien_phat' => 0,
            'tong_luong' => 0,
            'chi_tiet' => [
                'so_ca_lam' => 0,
                'so_lan_vang' => 0,
                'so_lan_tre' => 0,
                'cong_viec' => 'Chưa phân công'
            ]
        ];
    }

    // Lấy công việc của nhân viên
    $sql_congviec = "SELECT DISTINCT ten_cong_viec 
                     FROM lichlamviec 
                     WHERE ten_nhanvien = ? 
                     AND MONTH(ngay_lam_viec) = ? 
                     AND YEAR(ngay_lam_viec) = ?
                     LIMIT 1";
    $congviec = pdo_query_one($sql_congviec, $ten_nhanvien, $thang, $nam);
    
    // Tính lương cơ bản theo công việc
    $ten_cong_viec = $congviec['ten_cong_viec'] ?? 'Chưa phân công';
    $muc_luong = LUONG_THEO_CONGVIEC[$ten_cong_viec] ?? 100000; // Mặc định 100k
    $luong_co_ban = $chamcong['so_ca_lam'] * $muc_luong;
    
    // Tính thưởng chuyên cần
    $thuong_chuyen_can = ($chamcong['so_ca_lam'] >= 80) ? THUONG_CHUYEN_CAN_NHANVIEN : 0;
    
    // Tính tiền phạt
    $tien_phat = ($chamcong['so_lan_vang'] * PHAT_VANG_NHANVIEN) 
                + ($chamcong['so_lan_tre'] * PHAT_TRE_NHANVIEN);
    
    // Tính tổng lương
    $tong_luong = $luong_co_ban + $thuong_chuyen_can - $tien_phat;
    
    return [
        'luong_co_ban' => $luong_co_ban,
        'thuong_chuyen_can' => $thuong_chuyen_can,
        'tien_phat' => $tien_phat,
        'tong_luong' => $tong_luong,
        'chi_tiet' => [
            'so_ca_lam' => $chamcong['so_ca_lam'],
            'so_lan_vang' => $chamcong['so_lan_vang'],
            'so_lan_tre' => $chamcong['so_lan_tre'],
            'cong_viec' => $ten_cong_viec
        ]
    ];
}

function getAllQuanLy($rap_id = 0) {
    $sql = "SELECT id, name
            FROM taikhoan 
            WHERE vai_tro = 3";
    
    if ($rap_id != 0) {
        $sql .= " AND rap_id = ?";
        return pdo_query($sql, $rap_id);
    }

    return pdo_query($sql);
}


function getAllNhanVien($rap_id = null) {
    $sql = "SELECT DISTINCT ten_nhanvien 
            FROM lichlamviec 
            WHERE ten_nhanvien IS NOT NULL 
            AND id_taikhoan IS NULL";
    
    if($rap_id) {
        $sql .= " AND id_rap = ?";
        return pdo_query($sql, $rap_id);
    }
    
    return pdo_query($sql);
}
// Thêm các hàm xử lý cho quản lý
function getQuanLyLamViecHomNay($rap_id = null) {
    $today = date('Y-m-d');
    $sql = "SELECT llv.*, tk.name as ten_quanly, r.tenrap 
            FROM lichlamviec llv
            JOIN taikhoan tk ON llv.id_taikhoan = tk.id 
            JOIN rap r ON llv.id_rap = r.id
            WHERE llv.ngay_lam_viec = '$today' 
            AND tk.vai_tro = 1";  // Giả sử 2 là mã vai trò của quản lý
    
    if($rap_id) {
        $sql .= " AND llv.id_rap = $rap_id";
    }
    
    return pdo_query($sql);
}

function getThongKeQuanLyTheoThang($thang, $nam, $rap_id = null) {
    $sql = "SELECT DISTINCT llv.id_taikhoan, tk.name as ten_quanly
            FROM lichlamviec llv
            JOIN taikhoan tk ON llv.id_taikhoan = tk.id
            WHERE tk.vai_tro = 1
            AND MONTH(llv.ngay_lam_viec) = $thang 
            AND YEAR(llv.ngay_lam_viec) = $nam";
    
    if($rap_id) {
        $sql .= " AND llv.id_rap = $rap_id";
    }
    
    $dsQuanLy = pdo_query($sql);
    
    foreach($dsQuanLy as &$quanly) {
        $sql = "SELECT llv.*, r.tenrap, llv.trang_thai_cham_cong
                FROM lichlamviec llv
                JOIN rap r ON llv.id_rap = r.id
                WHERE llv.id_taikhoan = {$quanly['id_taikhoan']}
                AND MONTH(llv.ngay_lam_viec) = $thang 
                AND YEAR(llv.ngay_lam_viec) = $nam
                ORDER BY llv.ngay_lam_viec ASC";
        
        $chi_tiet = pdo_query($sql);
        
        $quanly['tong_ngay'] = count($chi_tiet);
        $quanly['dung_gio'] = 0;
        $quanly['di_tre'] = 0;
        $quanly['vang'] = 0;
        $quanly['chi_tiet'] = $chi_tiet;
        
        foreach($chi_tiet as $ct) {
            switch($ct['trang_thai_cham_cong']) {
                case 'đúng giờ':
                    $quanly['dung_gio']++;
                    break;
                case 'đi trễ':
                    $quanly['di_tre']++;
                    break;
                case 'vắng':
                    $quanly['vang']++;
                    break;
            }
        }
    }
    
    return $dsQuanLy;
}

?>