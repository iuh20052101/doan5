<?php



function them_ve($gia_ghe, $ngay_tt, $ghe, $id_user, $id_kgc, $id_hd, $id_lc, $id_phim, $combo = null) {
    try {
        // Nếu không có combo, gán giá trị mặc định là chuỗi rỗng thay vì null
        $combo = $combo ?: '';
        
        $sql = 'INSERT INTO `ve` (`price`, `ngay_dat`, `ghe`, `id_tk`, `id_thoi_gian_chieu`, `id_hd`, `id_ngay_chieu`, `id_phim`, `combo`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
                
        // Log để debug
        error_log("Thêm vé - Data: " . json_encode([
            'gia_ghe' => $gia_ghe,
            'ngay_tt' => $ngay_tt,
            'ghe' => $ghe,
            'combo' => $combo
        ]));
        
        return pdo_execute_return_interlastid($sql, $gia_ghe, $ngay_tt, $ghe, $id_user, $id_kgc, $id_hd, $id_lc, $id_phim, $combo);
        
    } catch (Exception $e) {
        error_log("Lỗi thêm vé: " . $e->getMessage());
        return false;
    }
}
function load_ve($id){
    $sql = "SELECT v.id, v.price, v.ngay_dat, v.ghe, v.combo, v.trang_thai,
            p.tieu_de, lc.ngay_chieu, kgc.thoi_gian_chieu, 
            tk.name, pc.name as tenphong, r.tenrap
            FROM ve v
            LEFT JOIN khung_gio_chieu kgc ON kgc.id = v.id_thoi_gian_chieu
            LEFT JOIN phongchieu pc ON pc.id = kgc.id_phong
            LEFT JOIN rap r ON r.id = pc.rap_id
            LEFT JOIN taikhoan tk ON tk.id = v.id_tk
            LEFT JOIN phim p ON p.id = v.id_phim
            LEFT JOIN lichchieu lc ON lc.id = v.id_ngay_chieu
            WHERE v.trang_thai IN (1, 2, 3, 4)
            AND v.id_tk = ?
            ORDER BY v.id DESC";
            
    try {
        // Debug
        error_log("Loading tickets for user ID: " . $id);
        error_log("SQL Query: " . $sql);
        
        $result = pdo_query($sql, $id);
        
        error_log("Found " . count($result) . " tickets");
        return $result;
        
    } catch (Exception $e) {
        error_log("Error loading tickets: " . $e->getMessage());
        return array();
    }
}

function update_ve_after_payment($id_ve, $id_hd) {
    try {
        $conn = pdo_get_connection();
        $conn->beginTransaction();
        
        try {
            // 1. Cập nhật trạng thái vé và hóa đơn
            $sql_ve = "UPDATE ve SET trang_thai = 1, ngay_dat = NOW() 
                       WHERE id = ? AND trang_thai = 0";
            $sql_hd = "UPDATE hoa_don SET trang_thai = 1 
                       WHERE id = ? AND trang_thai = 0";
                       
            pdo_execute($sql_ve, $id_ve);
            pdo_execute($sql_hd, $id_hd);

            // 2. Cập nhật điểm tích lũy
            if (isset($_SESSION['user']['id'])) {
                // Lấy thông tin vé
                $sql_ve = "SELECT tong_tien FROM ve WHERE id = ?";
                $ve = pdo_query_one($sql_ve, $id_ve);
                
                if ($ve) {
                    // Tính điểm tích lũy (1 điểm = 10,000đ)
                    $diem_tich_luy = floor($ve['tong_tien'] / 10000);
                    
                    // Cập nhật điểm cho user
                    $sql_update = "UPDATE taikhoan 
                                 SET diem_tich_luy = diem_tich_luy + ? 
                                 WHERE id = ?";
                    pdo_execute($sql_update, $diem_tich_luy, $_SESSION['user']['id']);
                }

                // 3. Cập nhật trạng thái mã khuyến mãi nếu có sử dụng
                if (isset($_SESSION['id_khuyenmai'])) {
                    $sql_km = "UPDATE nguoidung_khuyenmai 
                              SET trang_thai_ma = 1 
                              WHERE id_taikhoan = ? AND id_km = ?";
                    pdo_execute($sql_km, $_SESSION['user']['id'], $_SESSION['id_khuyenmai']);
                }
            }
            
            $conn->commit();

            // 4. Gửi mail xác nhận
            $load_ve_tt = load_ve_tt($id_ve);
            if ($load_ve_tt) {
                gui_mail_ve($load_ve_tt);
            }
            
            return true;

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    } catch (Exception $e) {
        error_log("Lỗi cập nhật vé: " . $e->getMessage());
        return false;
    }
}


function load_ve_tt($id)
{
    $sql = "SELECT h.thanh_tien, ve.id,h.ngay_tt, taikhoan.name, khung_gio_chieu.thoi_gian_chieu, lichchieu.ngay_chieu, phim.tieu_de, ve.ghe, ve.combo, phongchieu.name as tenphong
FROM hoa_don h
JOIN ve ON ve.id_hd = h.id 
JOIN taikhoan ON ve.id_tk = taikhoan.id 
JOIN khung_gio_chieu ON khung_gio_chieu.id = ve.id_thoi_gian_chieu
JOIN lichchieu ON lichchieu.id = khung_gio_chieu.id_lich_chieu 
JOIN phongchieu ON phongchieu.id = khung_gio_chieu.id_phong
JOIN phim ON phim.id = lichchieu.id_phim
WHERE h.id = ".$id;


    return pdo_query_one($sql);
}

function update_khuyenmai_status($id_user, $id_km) {
    try {
        // Bắt đầu transaction
        $conn = pdo_get_connection();
        $conn->beginTransaction();

        try {
            // 1. Kiểm tra mã khuyến mãi có hợp lệ không
            $check_sql = "SELECT * FROM nguoidung_khuyenmai 
                         WHERE id_taikhoan = ? 
                         AND id_km = ? 
                         AND trang_thai_ma = 0
                         FOR UPDATE"; // Khóa hàng để tránh race condition
            
            $km = pdo_query_one($check_sql, $id_user, $id_km);
            
            if (!$km) {
                error_log("Mã khuyến mãi không hợp lệ hoặc đã được sử dụng: User $id_user, KM $id_km");
                $conn->rollBack();
                return false;
            }

            // 2. Cập nhật trạng thái mã
            $update_sql = "UPDATE nguoidung_khuyenmai 
                          SET trang_thai_ma = 1 
                          WHERE id_taikhoan = ? 
                          AND id_km = ? 
                          AND trang_thai_ma = 0";
            
            $result = pdo_execute($update_sql, $id_user, $id_km);
            
            if (!$result) {
                error_log("Không thể cập nhật trạng thái mã khuyến mãi");
                $conn->rollBack();
                return false;
            }

            // 3. Commit transaction nếu mọi thứ OK
            $conn->commit();
            
            // 4. Log kết quả và xóa session
            error_log("Cập nhật mã khuyến mãi thành công: User $id_user, KM $id_km");
            if (isset($_SESSION['id_khuyenmai'])) {
                unset($_SESSION['id_khuyenmai']);
            }
            
            return true;

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    } catch (Exception $e) {
        error_log("Lỗi cập nhật mã khuyến mãi: " . $e->getMessage());
        return false;
    }
}

function gui_mail_ve($load_ve_tt) {
    $_SESSION['mail_debug'] = []; // Khởi tạo mảng debug

    // Ghi log để kiểm tra
    $_SESSION['mail_debug']['function_called'] = "Hàm gui_mail_ve được gọi";
    $_SESSION['mail_debug']['session_user'] = isset($_SESSION['user']) ? $_SESSION['user'] : 'No user';
    $_SESSION['mail_debug']['ticket_info'] = $load_ve_tt;

    try {
        // Kiểm tra session user
        if (!isset($_SESSION['user'])) {
            $_SESSION['mail_debug']['error'] = "Không có thông tin người dùng trong session";
            return false;
        }

        // Kiểm tra email
        if (!isset($_SESSION['user']['email'])) {
            $_SESSION['mail_debug']['error'] = "Không có email trong session user";
            return false;
        }

        // Kiểm tra user từ database
        $sql = "SELECT * FROM taikhoan WHERE id = ?";
        $user_db = pdo_query_one($sql, $_SESSION['user']['id']);
        $_SESSION['mail_debug']['user_db'] = $user_db;

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'haibang741@gmail.com';
        $mail->Password = 'wiud ljdp mkkh zzuz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('haibang741@gmail.com', 'TIAMS');
        $mail->addAddress($_SESSION['user']['email'], $_SESSION['user']['name'] ?? '');

        // Nội dung mail
        $mail->isHTML(true);
        $mail->Subject = 'Xác nhận đặt vé xem phim thành công';

        // Format nội dung
        $thanh_tien = number_format($load_ve_tt['thanh_tien'], 0, ',', '.');
        $combo = $load_ve_tt['combo'] ?: 'Không có';
        $ngay_chieu = date('d/m/Y', strtotime($load_ve_tt['ngay_chieu']));
        $gio_chieu = date('H:i', strtotime($load_ve_tt['thoi_gian_chieu']));

        $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #e53637; text-align: center;">Xác nhận Đặt Vé Xem Phim Thành Công</h2>
                <p>Xin chào <strong>'.$_SESSION['user']['name'].'</strong>,</p>
                <p>Cảm ơn bạn đã đặt vé tại TIAMS. Dưới đây là thông tin vé của bạn:</p>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                    <p><strong>Mã vé:</strong> '.$load_ve_tt['id'].'</p>
                    <p><strong>Phim:</strong> '.$load_ve_tt['tieu_de'].'</p>
                    <p><strong>Rạp:</strong> '.$load_ve_tt['tenrap'].'</p>
                    <p><strong>Phòng:</strong> '.$load_ve_tt['tenphong'].'</p>
                    <p><strong>Suất chiếu:</strong> '.$gio_chieu.' - '.$ngay_chieu.'</p>
                    <p><strong>Ghế:</strong> '.$load_ve_tt['ghe'].'</p>
                    <p><strong>Combo:</strong> '.$combo.'</p>
                    <p><strong>Thành tiền:</strong> '.$thanh_tien.' VNĐ</p>
                </div>
                <p style="color: #666; font-size: 14px; margin-top: 20px;">
                    * Vui lòng đến rạp trước giờ chiếu 15-20 phút và xuất trình mã vé này.
                </p>
                <p style="text-align: center; margin-top: 30px;">
                    <strong>Chúc bạn xem phim vui vẻ!</strong>
                </p>
            </div>';

        $mail->SMTPDebug = 2; // Đặt mức độ debug cho SMTP
        $mail->Debugoutput = function($str, $level) {
            $_SESSION['mail_debug']['smtp_debug'][] = $str; // Lưu log SMTP vào session
        };

        $result = $mail->send();
        error_log("Gửi mail " . ($result ? "thành công" : "thất bại") . " đến " . $_SESSION['user']['email']);
        return $result;
    } catch (Exception $e) {
        error_log("Lỗi gửi mail: " . $e->getMessage());
        return false;
    }
}

function update_trang_thai_ghe($ghe, $id_kgc, $id_lc) {
    try {
        // Log để debug
        error_log("Cập nhật ghế: " . json_encode([
            'ghe' => $ghe,
            'id_khung_gio_chieu' => $id_kgc,
            'ghe_array' => explode(', ', $ghe)
        ]));

        // Tách chuỗi ghế thành mảng (VD: "A1, A2" -> ["A1", "A2"])
        $ghe_array = explode(', ', $ghe);
        
        foreach ($ghe_array as $ma_ghe) {
            // Tách mã ghế thành hàng và số (VD: "A1" -> hang = "A", so_ghe = 1)
            preg_match('/([A-Z])(\d+)/', $ma_ghe, $matches);
            if (count($matches) === 3) {
                $hang = $matches[1];
                $so_ghe = (int)$matches[2];

                // Cập nhật trạng thái ghế dựa trên hàng, số ghế và id_khung_gio_chieu
                $sql = "UPDATE ghe 
                       SET trang_thai = 'đã đặt' 
                       WHERE hang = ? 
                       AND so_ghe = ? 
                       AND id_khung_gio_chieu = ?";
                
                $result = pdo_execute($sql, $hang, $so_ghe, $id_kgc);
                
                // Log kết quả cập nhật
                error_log("Cập nhật ghế $ma_ghe: " . ($result ? "thành công" : "thất bại"));
            } else {
                error_log("Mã ghế không hợp lệ: $ma_ghe");
            }
        }

        return true;

    } catch (Exception $e) {
        error_log("Lỗi cập nhật ghế: " . $e->getMessage());
        return false;
    }
}

// Thêm các hàm cập nhật trạng thái
function trangthai_hd($id_hd) {
    try {
        $sql = "UPDATE hoa_don SET trang_thai = 1 WHERE id = ?";
        return pdo_execute($sql, $id_hd);
    } catch (Exception $e) {
        error_log("Lỗi cập nhật trạng thái hóa đơn: " . $e->getMessage());
        return false;
    }
}

function trangthai_ve($id_hd) {
    try {
        $sql = "UPDATE ve SET trang_thai = 1 WHERE id_hd = ?";
        return pdo_execute($sql, $id_hd);
    } catch (Exception $e) {
        error_log("Lỗi cập nhật trạng thái vé: " . $e->getMessage());
        return false;
    }
}

function process_payment_success($tong_tien, $ghe, $id_user, $id_kgc, $id_lc, $id_phim, $combo = null) {
    $success = true;
    $errors = [];
    $id_ve = null;
    $id_hd = null;

    try {
        // 1. Tạo hóa đơn
        $ngay_tt = date('Y-m-d H:i:s');
        $id_hd = them_hoa_don($ngay_tt, $tong_tien);
        
        if (!$id_hd) {
            $success = false;
            $errors[] = "Không thể tạo hóa đơn";
        }

        // 2. Tạo vé (nếu tạo được hóa đơn)
        if ($id_hd) {
            $id_ve = them_ve($tong_tien, $ngay_tt, $ghe, $id_user, $id_kgc, $id_hd, $id_lc, $id_phim, $combo);
            
            if (!$id_ve) {
                $success = false;
                $errors[] = "Không thể tạo vé";
            }
        }

        // 3. Cập nhật trạng thái ghế (thực hiện bất kể kết quả các bước trước)
        try {
            if (!update_trang_thai_ghe($ghe, $id_kgc, $id_lc)) {
                error_log("Lỗi cập nhật trạng thái ghế");
                $errors[] = "Không thể cập nhật trạng thái ghế";
            }
        } catch (Exception $e) {
            error_log("Exception khi cập nhật ghế: " . $e->getMessage());
        }
            
        // 4. Cập nhật trạng thái hóa đơn và vé (nếu có id_hd)
        if ($id_hd) {
            try {
                if (!trangthai_hd($id_hd)) {
                    error_log("Lỗi cập nhật trạng thái hóa đơn");
                    $errors[] = "Không thể cập nhật trạng thái hóa đơn";
                }
            } catch (Exception $e) {
                error_log("Exception khi cập nhật hóa đơn: " . $e->getMessage());
            }

            try {
                if (!trangthai_ve($id_hd)) {
                    error_log("Lỗi cập nhật trạng thái vé");
                    $errors[] = "Không thể cập nhật trạng thái vé";
                }
            } catch (Exception $e) {
                error_log("Exception khi cập nhật vé: " . $e->getMessage());
            }
        }
                
        // 5. Cập nhật điểm tích lũy (thực hiện độc lập)
        try {
            $diem_tich_luy = floor($tong_tien / 10000);
            $sql_update_diem = "UPDATE taikhoan 
                              SET diem_tich_luy = diem_tich_luy + ? 
                              WHERE id = ?";
            if (!pdo_execute($sql_update_diem, $diem_tich_luy, $id_user)) {
                error_log("Lỗi cập nhật điểm tích lũy");
                $errors[] = "Không thể cập nhật điểm tích lũy";
            }
        } catch (Exception $e) {
            error_log("Exception khi cập nhật điểm: " . $e->getMessage());
        }
                
        // 6. Cập nhật trạng thái mã khuyến mãi nếu có
        if (isset($_SESSION['tong']['promotion_id']) && !empty($_SESSION['tong']['promotion_id'])) {
            try {
                $id_km = $_SESSION['tong']['promotion_id'];
                if (!update_khuyenmai_status($id_user, $id_km)) {
                    error_log("Lỗi cập nhật trạng thái mã khuyến mãi");
                    $errors[] = "Không thể cập nhật trạng thái mã khuyến mãi";
                }
            } catch (Exception $e) {
                error_log("Exception khi cập nhật mã khuyến mãi: " . $e->getMessage());
                $errors[] = "Lỗi xử lý mã khuyến mãi";
            }
        }

        // 7. Gửi mail xác nhận (thực hiện độc lập)
        if ($id_ve) {
            try {
                $load_ve_tt = load_ve_tt($id_ve);
                if ($load_ve_tt) {
                    if (!gui_mail_ve($load_ve_tt)) {
                        error_log("Không thể gửi mail xác nhận");
                        $errors[] = "Không thể gửi mail xác nhận";
                    }
                }
            } catch (Exception $e) {
                error_log("Exception khi gửi mail: " . $e->getMessage());
            }
        }

        // Trả về kết quả
        return [
            'success' => $success && $id_ve !== null, // Thành công nếu ít nhất tạo được vé
            'id_ve' => $id_ve,
            'message' => $errors ? implode("; ", $errors) : 'Thanh toán thành công',
            'warnings' => $errors // Danh sách các lỗi không nghiêm trọng
        ];

    } catch (Exception $e) {
        error_log("Lỗi xử lý thanh toán chính: " . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage(),
            'warnings' => $errors
        ];
    }
}

function load_ve_thanhtoan($id_ve) {
    $sql = "SELECT v.id, v.price as thanh_tien, v.ngay_dat, v.ghe, v.combo, v.trang_thai,
            p.tieu_de, lc.ngay_chieu, kgc.thoi_gian_chieu, 
            tk.name, pc.name as tenphong, r.tenrap
            FROM ve v
            LEFT JOIN khung_gio_chieu kgc ON kgc.id = v.id_thoi_gian_chieu
            LEFT JOIN phongchieu pc ON pc.id = kgc.id_phong
            LEFT JOIN rap r ON r.id = pc.rap_id
            LEFT JOIN taikhoan tk ON tk.id = v.id_tk
            LEFT JOIN phim p ON p.id = v.id_phim
            LEFT JOIN lichchieu lc ON lc.id = v.id_ngay_chieu
            WHERE v.id = ?";
            
    try {
        $result = pdo_query_one($sql, $id_ve);
        if($result) {
            return $result;
        }
        return false;
    } catch (Exception $e) {
        error_log("Error loading ticket detail: " . $e->getMessage());
        return false;
    }
}

