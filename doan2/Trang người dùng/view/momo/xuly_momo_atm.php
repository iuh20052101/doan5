<?php
session_start();
header('Content-type: text/html; charset=utf-8');

// Debug session ban đầu
error_log("Session data before payment: " . print_r($_SESSION['tong'], true));

// Tính tổng tiền thanh toán
$tong_tien = 0;

// Kiểm tra và lấy giá tiền theo thứ tự ưu tiên
if (isset($_SESSION['tong']['tong_tien_thanh_toan'])) {
    // Ưu tiên lấy tổng tiền cuối cùng đã tính
    $tong_tien = $_SESSION['tong']['tong_tien_thanh_toan'];
} else if (isset($_SESSION['tong']['final_price'])) {
    // Nếu có giá sau khuyến mãi
    $tong_tien = $_SESSION['tong']['final_price'];
} else {
    // Tính tổng từ giá ghế và đồ ăn
    if (isset($_SESSION['tong']['gia_ghe'])) {
        $tong_tien = $_SESSION['tong']['gia_ghe'];
    }
    
    // Cộng thêm tiền đồ ăn nếu có
    if (isset($_SESSION['tong']['tien_do_an'])) {
        $tong_tien += $_SESSION['tong']['tien_do_an'];
    }
}

// Đảm bảo giá tiền là số nguyên và không có phần thập phân
$tong_tien = (int)$tong_tien;

// Debug giá tiền
error_log("Chi tiết giá tiền:");
error_log("Giá ghế: " . ($_SESSION['tong']['gia_ghe'] ?? 0));
error_log("Tiền đồ ăn: " . ($_SESSION['tong']['tien_do_an'] ?? 0));
error_log("Giá sau khuyến mãi: " . ($_SESSION['tong']['final_price'] ?? 0));
error_log("Tổng tiền cuối: " . $tong_tien);

// Kiểm tra số tiền
if ($tong_tien <= 0) {
    echo '<script>
        alert("Số tiền thanh toán không hợp lệ");
        window.location.href = "../../index.php?act=thanhtoan";
    </script>';
    exit;
}

// Lưu lại tổng tiền vào session để sử dụng sau này
$_SESSION['tong']['tong_tien_thanh_toan'] = $tong_tien;

// Thông tin thanh toán MOMO
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = "MOMOBKUN20180529";
$accessKey = "klm05TvNBzhg7h7j";
$secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
$orderInfo = "Thanh toán vé xem phim";
$redirectUrl = "http://localhost/doan4/Trang%20người%20dùng/index.php?act=bill";
$ipnUrl = "http://localhost/doan4/Trang%20người%20dùng/index.php?act=bill";
$extraData = "";

$requestId = time() . "";
$requestType = "payWithATM";
$orderId = time() . "";

// Tạo chữ ký
$rawHash = "accessKey=" . $accessKey . "&amount=" . $tong_tien . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    'storeId' => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $tong_tien,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

// Gọi API MoMo
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

// Kiểm tra kết quả và chuyển hướng
if(isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit;
} else {
    echo "Có lỗi xảy ra trong quá trình thanh toán: ";
    print_r($jsonResult);
}

// Sau khi xử lý thanh toán MOMO thành công
if ($result['resultCode'] == 0) {
    require_once('../save_ticket.php');
    $ticket_id = saveTicket('momo', 'completed');
    
    if ($ticket_id) {
        // Xóa session không cần thiết
        unset($_SESSION['tong']);
        
        // Chuyển hướng đến trang xem vé
        header("Location: ../view_ticket.php?id=" . $ticket_id);
        exit();
    }
}

// Hàm gọi API
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    
    // Thêm option này để bỏ qua SSL verification trong môi trường test
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    
    curl_close($ch);
    return $result;
}

// Debug
error_log("MoMo Request Data: " . print_r($data, true));
error_log("MoMo Response: " . print_r($jsonResult, true));
?>
