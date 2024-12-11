<?php
function load_lichlamviec(){
    $sql = "SELECT l.*, r.tenrap,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN tk.name
                ELSE l.ten_nhanvien 
            END as ten_nguoi_lam
            FROM lichlamviec l
            LEFT JOIN taikhoan tk ON l.id_taikhoan = tk.id
            INNER JOIN rap r ON l.id_rap = r.id";
    return pdo_query($sql);
}

function loadone_lichlamviec($id) {
    $sql = "SELECT l.*, r.tenrap,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN tk.name
                ELSE l.ten_nhanvien 
            END as ten_nguoi_lam
            FROM lichlamviec l
            LEFT JOIN taikhoan tk ON l.id_taikhoan = tk.id
            INNER JOIN rap r ON l.id_rap = r.id
            WHERE l.id = ?";
    return pdo_query_one($sql, $id);
}
function xoa_lichlamviec($id) {
    try {
        // Xóa một ca làm việc cụ thể
        $sql = "DELETE FROM lichlamviec WHERE id = ?";
        pdo_execute($sql, $id);
    } catch(Exception $e) {
        throw $e;
    }
}

// Update cho quản lý (không có ngày và ca làm việc)
function update_lich_quanly($id, $id_taikhoan, $id_rap, $ten_cong_viec) {
    $sql = "UPDATE lichlamviec SET 
            id_taikhoan = ?, 
            id_rap = ?, 
            ten_cong_viec = ?,
            ngay_lam_viec = NULL,
            ca_lam_viec = NULL,
            ten_nhanvien = NULL 
            WHERE id = ?";
    pdo_execute($sql, $id_taikhoan, $id_rap, $ten_cong_viec, $id);
}
// Update cho nhân viên (có đầy đủ thông tin)
function update_lich_nhanvien($id, $id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec, $ten_nhanvien) {
    try {
        $sql = "UPDATE lichlamviec SET 
                id_rap = ?, 
                ngay_lam_viec = ?, 
                ca_lam_viec = ?, 
                ten_cong_viec = ?,
                ten_nhanvien = ? 
                WHERE id = ?";
        // Thêm debug
        error_log("SQL: " . $sql);
        error_log("Params: " . print_r([$id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec, $ten_nhanvien, $id], true));
        
        return pdo_execute($sql, $id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec, $ten_nhanvien, $id);
    } catch (Exception $e) {
        error_log("Error updating lichlamviec: " . $e->getMessage());
        throw $e;
    }
}
// Thêm lịch cho quản lý (không có ngày và ca làm việc)
function them_lich_quanly($id_taikhoan, $id_rap, $thang_lam, $ten_cong_viec) {
    try {
        // Lấy ngày đầu và cuối của tháng
        $first_day = date('Y-m-01', strtotime($thang_lam));
        $last_day = date('Y-m-t', strtotime($thang_lam));
        
        // Tạo lịch cho từng ngày trong tháng
        $current_date = $first_day;
        while (strtotime($current_date) <= strtotime($last_day)) {
            $sql = "INSERT INTO lichlamviec (
                id_taikhoan, 
                id_rap, 
                ngay_lam_viec, 
                ten_cong_viec,
                ca_lam_viec
            ) VALUES (?, ?, ?, ?, 'Full time')";
            
            pdo_execute($sql, $id_taikhoan, $id_rap, $current_date, $ten_cong_viec);
            
            // Tăng lên 1 ngày
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }
        
        return true;
    } catch(Exception $e) {
        throw $e;
    }
}
// Thêm lịch cho nhân viên (có đầy đủ thông tin)
function them_lich_nhanvien($ten_nhanvien, $id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec) {
    $sql = "INSERT INTO lichlamviec(id_taikhoan, id_rap, ngay_lam_viec, ca_lam_viec, ten_cong_viec, ten_nhanvien) 
            VALUES (NULL, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec, $ten_nhanvien);
}

function loadall_lichlamviec(){
    $sql = "SELECT l.*, r.tenrap,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN tk.name
                ELSE l.ten_nhanvien 
            END as ten_nguoi_lam,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN 'Quản lý'
                ELSE 'Nhân viên'
            END as vai_tro,
            DATE_FORMAT(l.ngay_lam_viec, '%d-%m-%Y') as ngay_lam_formatted,
            DATE_FORMAT(CURRENT_TIMESTAMP, '%d-%m-%Y %H:%i') as ngay_tao
            FROM lichlamviec l
            LEFT JOIN taikhoan tk ON l.id_taikhoan = tk.id
            INNER JOIN rap r ON l.id_rap = r.id
            ORDER BY l.ngay_lam_viec DESC, l.ca_lam_viec ASC";
    return pdo_query($sql);
}
function get_ten_from_id_taikhoan($id_taikhoan) {
    $sql = "SELECT name FROM taikhoan WHERE id=?";
    return pdo_query_one($sql, $id_taikhoan);
}
function getAllRap() {
    $sql = "SELECT * FROM rap ORDER BY tenrap ASC";
    return pdo_query($sql);
}

function them_lich_nhanvien_theo_tuan($ten_nhanvien, $id_rap, $ngay_bat_dau, $so_tuan, $ten_cong_viec, $lich_lam) {
    try {
        global $conn;
        $conn->beginTransaction();
        
        $ngay = strtotime($ngay_bat_dau);
        
        // Debug
        error_log("Thông tin đầu vào:");
        error_log("Tên NV: " . $ten_nhanvien);
        error_log("Ngày bắt đầu: " . $ngay_bat_dau);
        error_log("Lịch làm: " . print_r($lich_lam, true));
        
        for($tuan = 0; $tuan < $so_tuan; $tuan++) {
            foreach($lich_lam as $thu => $ca_lam) {
                $ngay_lam = strtotime("+$thu day", $ngay);
                $ngay_lam_sql = date('Y-m-d', $ngay_lam);
                
                foreach($ca_lam as $ca => $value) {
                    if($value) {
                        $ca_lam_viec = "Ca " . $ca . " (" . get_ca_lam_text($ca) . ")";
                        
                        // Debug
                        error_log("Thêm lịch: Ngày $ngay_lam_sql, $ca_lam_viec");
                        
                        $sql = "INSERT INTO lichlamviec(
                                    ten_nhanvien, 
                                    id_rap, 
                                    ngay_lam_viec, 
                                    ca_lam_viec, 
                                    ten_cong_viec, 
                                    id_taikhoan,
                                    trang_thai_cham_cong
                                ) VALUES (?, ?, ?, ?, ?, NULL, 'chưa chấm công')";
                                
                        pdo_execute($sql, 
                            $ten_nhanvien, 
                            $id_rap, 
                            $ngay_lam_sql,
                            $ca_lam_viec,
                            $ten_cong_viec
                        );
                    }
                }
            }
            $ngay = strtotime("+1 week", $ngay);
        }
        
        $conn->commit();
        return true;
        
    } catch(Exception $e) {
        $conn->rollBack();
        error_log("Lỗi thêm lịch: " . $e->getMessage());
        throw $e;
    }
}

// Hàm hỗ trợ lấy text ca làm
function get_ca_lam_text($ca) {
    switch($ca) {
        case 1: return "8:00-12:00";
        case 2: return "12:00-16:00";
        case 3: return "16:00-20:00";
        case 4: return "20:00-24:00";
        default: return "";
    }
}

// Đổi tên từ check_trung_lich thành check_trung_lich_lamviec
function check_trung_lich_lamviec($id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_nhanvien, $id = null) {
    $sql = "SELECT COUNT(*) as count 
            FROM lichlamviec 
            WHERE id_rap = ? 
            AND ngay_lam_viec = ? 
            AND ca_lam_viec = ? 
            AND ten_nhanvien = ?";
    
    $params = [$id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_nhanvien];
    
    if($id) {
        $sql .= " AND id != ?";
        $params[] = $id;
    }
    
    return pdo_query_value($sql, ...$params) > 0;
}

// Thêm hàm cập nhật trạng thái chấm công
function update_trang_thai_cham_cong($id, $trang_thai) {
    $sql = "UPDATE lichlamviec 
            SET trang_thai_cham_cong = ? 
            WHERE id = ?";
    pdo_execute($sql, $trang_thai, $id);
}

// Thêm hàm lấy thống kê chấm công
function get_thong_ke_cham_cong($tu_ngay, $den_ngay, $id_rap = null) {
    $sql = "SELECT 
                ten_nhanvien,
                COUNT(*) as tong_ca,
                SUM(CASE WHEN trang_thai_cham_cong = 'đúng giờ' THEN 1 ELSE 0 END) as dung_gio,
                SUM(CASE WHEN trang_thai_cham_cong = 'đi trễ' THEN 1 ELSE 0 END) as di_tre,
                SUM(CASE WHEN trang_thai_cham_cong = 'vắng' THEN 1 ELSE 0 END) as vang
            FROM lichlamviec
            WHERE ngay_lam_viec BETWEEN ? AND ?";
    
    $params = [$tu_ngay, $den_ngay];
    
    if($id_rap) {
        $sql .= " AND id_rap = ?";
        $params[] = $id_rap;
    }
    
    $sql .= " GROUP BY ten_nhanvien";
    
    return pdo_query($sql, ...$params);
}

// Hàm kiểm tra dữ liệu đầu vào
function validate_lich_input($ten_nhanvien, $id_rap, $ngay_bat_dau, $so_tuan, $ten_cong_viec, $lich_lam) {
    if(empty($ten_nhanvien)) {
        throw new Exception("Tên nhân viên không được để trống");
    }
    if(empty($id_rap)) {
        throw new Exception("Chưa chọn rạp");
    }
    if(empty($ngay_bat_dau)) {
        throw new Exception("Chưa chọn ngày bắt đầu");
    }
    
    // Kiểm tra ngày bắt đầu phải từ ngày mai trở đi
    $tomorrow = strtotime('tomorrow');
    $selected_date = strtotime($ngay_bat_dau);
    if ($selected_date < $tomorrow) {
        throw new Exception("Ngày bắt đầu phải từ ngày mai trở đi");
    }
    
    if($so_tuan < 1) {
        throw new Exception("Số tuần phải lớn hơn 0");
    }
    if(empty($ten_cong_viec)) {
        throw new Exception("Tên công việc không được để trống");
    }
    
    // Sửa lại phần kiểm tra lịch làm
    if(!is_array($lich_lam) || count(array_filter($lich_lam)) == 0) {
        throw new Exception("Chưa chọn ca làm việc nào");
    }
    
    return true;
}

// Trong controller, thêm xử lý như sau:
if(isset($_POST['them_lich'])) {
    try {
        $ten_nhanvien = $_POST['ten_nhanvien'];
        $id_rap = $_POST['id_rap'];
        $ngay_bat_dau = $_POST['ngay_bat_dau'];
        $so_tuan = $_POST['so_tuan'];
        $ten_cong_viec = $_POST['ten_cong_viec'];
        $lich_lam = isset($_POST['lich']) ? $_POST['lich'] : array();
        
        // Validate đầu vào
        validate_lich_input($ten_nhanvien, $id_rap, $ngay_bat_dau, $so_tuan, $ten_cong_viec, $lich_lam);
        
        // Thêm lịch
        them_lich_nhanvien_theo_tuan($ten_nhanvien, $id_rap, $ngay_bat_dau, $so_tuan, $ten_cong_viec, $lich_lam);
        
        // Thông báo thành công
        $thongbao = "Thêm lịch làm việc thành công";
        
    } catch(Exception $e) {
        // Thông báo lỗi
        $error = $e->getMessage();
    }
}

function get_lich_quanly_theo_ngay($lich_quanly, $ngay) {
    // Thêm debug
    error_log("Debug get_lich_quanly_theo_ngay:");
    error_log("Thông tin lịch: " . print_r($lich_quanly, true));
    error_log("Ngày kiểm tra: " . $ngay);
    error_log("Tháng của ngày: " . date('Y-m', strtotime($ngay)));
    error_log("Tháng trong lịch: " . $lich_quanly['ngay_lam_viec']);
    
    // Chỉ xử lý cho quản lý
    if($lich_quanly['vai_tro'] != 'Quản lý') {
        error_log("Không phải quản lý");
        return null;
    }
    
    // So sánh tháng
    $thang_hien_tai = date('Y-m', strtotime($ngay));
    if($thang_hien_tai == $lich_quanly['ngay_lam_viec']) {
        error_log("Khớp tháng - trả về lịch");
        return [
            'ca_lam_viec' => 'Full time',
            'ten_cong_viec' => $lich_quanly['ten_cong_viec']
        ];
    }
    error_log("Không khớp tháng");
    return null;
}

function loadLichNhanVien($ten_nhanvien, $id_rap) {
    $sql = "SELECT l.*, r.tenrap,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN tk.name
                ELSE l.ten_nhanvien 
            END as ten_nguoi_lam,
            CASE 
                WHEN l.id_taikhoan IS NOT NULL THEN 'Quản lý'
                ELSE 'Nhân viên'
            END as vai_tro,
            DATE_FORMAT(l.ngay_lam_viec, '%d-%m-%Y') as ngay_lam_formatted
            FROM lichlamviec l
            LEFT JOIN taikhoan tk ON l.id_taikhoan = tk.id
            INNER JOIN rap r ON l.id_rap = r.id
            WHERE l.ten_nhanvien = ? 
            AND l.id_rap = ?
            AND l.id_taikhoan IS NULL
            ORDER BY l.ngay_lam_viec ASC, l.ca_lam_viec ASC";
            
    return pdo_query($sql, $ten_nhanvien, $id_rap);
}
function loadLichQuanLy($id_taikhoan, $id_rap) {
    $sql = "SELECT l.*, r.tenrap, tk.name as ten_nguoi_lam 
            FROM lichlamviec l
            INNER JOIN rap r ON l.id_rap = r.id 
            INNER JOIN taikhoan tk ON l.id_taikhoan = tk.id
            WHERE l.id_taikhoan = ? AND l.id_rap = ?
            ORDER BY l.ngay_lam_viec ASC";
    return pdo_query($sql, $id_taikhoan, $id_rap);
}
function delete_future_schedule($id_taikhoan, $id_rap) {
    $today = date('Y-m-d');
    $sql = "DELETE FROM lichlamviec 
            WHERE id_taikhoan = ? 
            AND id_rap = ? 
            AND ngay_lam_viec >= ?";
    pdo_execute($sql, $id_taikhoan, $id_rap, $today);
}

function insert_lichlamviec_quanly($id_taikhoan, $id_rap, $ngay, $ten_cong_viec) {
    $sql = "INSERT INTO lichlamviec(id_taikhoan, id_rap, ngay_lam_viec, ten_cong_viec) 
            VALUES (?, ?, ?, ?)";
    pdo_execute($sql, $id_taikhoan, $id_rap, $ngay, $ten_cong_viec);
}

function loadLichQuanLyByTenRap($ten, $rap_id) {
    $sql = "SELECT l.*, t.name as ten_nguoi_lam 
            FROM lichlamviec l 
            JOIN taikhoan t ON l.id_taikhoan = t.id 
            WHERE t.name = ? AND l.id_rap = ?
            ORDER BY l.ngay_lam_viec ASC";
    return pdo_query($sql, $ten, $rap_id);
}