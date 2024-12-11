<?php
session_start();
require_once('model/pdo.php');

if (isset($_GET['resultCode']) && isset($_GET['orderId'])) {
    // Log toàn bộ dữ liệu callback để debug
    error_log("MOMO Callback Data: " . print_r($_GET, true));
    
    try {
        if ($_GET['resultCode'] == '0') { // Thanh toán thành công
            // Kiểm tra chữ ký để đảm bảo dữ liệu hợp lệ
            $partnerCode = $_GET['partnerCode'];
            $orderId = $_GET['orderId'];
            $requestId = $_GET['requestId'];
            $amount = $_GET['amount'];
            $orderInfo = $_GET['orderInfo'];
            $orderType = $_GET['orderType'];
            $transId = $_GET['transId'];
            $resultCode = $_GET['resultCode'];
            $message = $_GET['message'];
            $payType = $_GET['payType'];
            $responseTime = $_GET['responseTime'];
            $extraData = $_GET['extraData'];
            $signature = $_GET['signature'];

            // Tạo vé mới
            $sql = "INSERT INTO ve (
                ma_ve,
                id_tk,
                id_lichchieu,
                ghe_ngoi,
                tong_tien,
                trang_thai,
                ngay_dat,
                ma_giao_dich,
                phuong_thuc_thanh_toan
            ) VALUES (?, ?, ?, ?, ?, 1, NOW(), ?, 'momo')";

            pdo_execute($sql,
                $orderId,
                $_SESSION['user']['id'],
                $_SESSION['tong']['id_lichchieu'],
                $_SESSION['tong']['ghe_ngoi'],
                $amount,
                $transId
            );

            // Cập nhật trạng thái ghế
            $ghe_array = explode(',', $_SESSION['tong']['ghe_ngoi']);
            foreach ($ghe_array as $ghe) {
                $sql_ghe = "UPDATE ghe SET trang_thai = 1 
                           WHERE id_lichchieu = ? AND so_ghe = ?";
                pdo_execute($sql_ghe, 
                    $_SESSION['tong']['id_lichchieu'],
                    trim($ghe)
                );
            }

            // Xóa session không cần thiết
            unset($_SESSION['tong']);
            
            // Thông báo thành công
            echo "<script>
                alert('Thanh toán thành công! Vé của bạn đã được tạo.');
                window.location.href='index.php?act=lichsuve';
            </script>";

        } else {
            // Thanh toán thất bại
            throw new Exception("Thanh toán thất bại: " . $_GET['message']);
        }
        
    } catch (Exception $e) {
        error_log("Error processing MOMO payment: " . $e->getMessage());
        echo "<script>
            alert('Có lỗi xảy ra: " . $e->getMessage() . "');
            window.location.href='index.php';
        </script>";
    }
} else {
    // Không có dữ liệu callback
    header("Location: index.php");
}
?> 