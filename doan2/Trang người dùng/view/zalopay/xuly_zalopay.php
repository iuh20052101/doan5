<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

try {
    // Debug - Kiểm tra session
    error_log("Session data: " . print_r($_SESSION, true));

    // Đọc config
    $configFile = __DIR__ . "/config_zalopay.json";
    if (!file_exists($configFile)) {
        throw new Exception("Config file not found at: " . $configFile);
    }
    
    $config = json_decode(file_get_contents($configFile), true);
    if (!$config) {
        throw new Exception("Invalid config file: " . json_last_error_msg());
    }

    // Debug - Kiểm tra config
    error_log("Config loaded: " . json_encode($config));

    // Lấy thông tin thanh toán

    // Tính tổng tiền thanh toán
    $tong_tien = 0;

    // 1. Lấy giá vé (đã bao gồm khuyến mãi nếu có)
    if(isset($_SESSION['tong']['final_price'])) {
        $tong_tien = $_SESSION['tong']['final_price'];
    } else if(isset($_SESSION['tong']['gia_ghe'])) {
        $tong_tien = $_SESSION['tong']['gia_ghe'];
    }

    // 2. Cộng thêm tiền đồ ăn nếu có
    if(isset($_SESSION['tong']['tien_do_an']) && $_SESSION['tong']['tien_do_an'] > 0) {
        $tong_tien += $_SESSION['tong']['tien_do_an'];
    }

    // Kiểm tra xem đã có tổng tiền thanh toán chưa
    if(isset($_SESSION['tong']['tong_tien_thanh_toan'])) {
        $tong_tien = $_SESSION['tong']['tong_tien_thanh_toan'];
    }

    error_log("Tổng tiền thanh toán ZaloPay: " . $tong_tien);
    error_log("Session data ZaloPay: " . print_r($_SESSION['tong'], true));

    // Kiểm tra số tiền
    if ($tong_tien <= 0) {
        throw new Exception("Số tiền thanh toán không hợp lệ: " . $tong_tien);
    }

    // Tạo đơn hàng
    $transID = date("ymd") . "_" . uniqid();
    $embedData = [
        "redirecturl" => $config['redirecturl'],
        "promotioninfo" => "",
        "merchantinfo" => "Cinema Ticket Payment",
        "bankgroup" => "ATM",
        "paymentmethod" => "CC",
        "callback_url" => $config['redirecturl']
    ];

    // Debug - Kiểm tra embed_data trước khi encode
    error_log("Embed data before encode: " . print_r($embedData, true));
    $embedData = json_encode($embedData);

    $items = [[
        "itemid" => "movie_ticket",
        "itemname" => "Vé xem phim",
        "itemprice" => $tong_tien,
        "itemquantity" => 1
    ]];
    
    // Debug - Kiểm tra items trước khi encode
    error_log("Items before encode: " . print_r($items, true));
    $items = json_encode($items);

    $order = [
        "app_id" => $config['appid'],
        "app_trans_id" => $transID,
        "app_time" => round(microtime(true) * 1000),
        "app_user" => "demo",
        "amount" => $tong_tien,
        "description" => "Thanh toan ve xem phim - " . $transID,
        "bank_code" => "CC",
        "embed_data" => $embedData,
        "item" => $items,
        "callback_url" => $config['redirecturl']
    ];

    // Tạo chữ ký
    $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . 
            $order["amount"] . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
    
    // Debug - Kiểm tra chuỗi tạo chữ ký
    error_log("Mac string: " . $data);
    
    $order["mac"] = hash_hmac("sha256", $data, $config['key1']);

    // Debug - Kiểm tra request đầy đủ
    error_log("Full request: " . json_encode($order, JSON_PRETTY_PRINT));

    // Gọi API với timeout dài hơn
    $ch = curl_init($config['endpoint']);
    curl_setopt_array($ch, [
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($order),
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_VERBOSE => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ]
    ]);

    $response = curl_exec($ch);
    
    // Debug - Kiểm tra thông tin curl
    $curl_info = curl_getinfo($ch);
    error_log("Curl info: " . print_r($curl_info, true));
    
    if ($response === false) {
        throw new Exception('Curl error: ' . curl_error($ch) . ' (Code: ' . curl_errno($ch) . ')');
    }
    curl_close($ch);

    // Debug - Kiểm tra response gốc
    error_log("Raw response: " . $response);

    $result = json_decode($response, true);
    if (!is_array($result)) {
        throw new Exception('Invalid response format: ' . $response . ' (JSON error: ' . json_last_error_msg() . ')');
    }

    // Debug - Kiểm tra response đã decode
    error_log("Decoded response: " . json_encode($result, JSON_PRETTY_PRINT));

    if (!isset($result['return_code'])) {
        throw new Exception('Missing return code in response: ' . json_encode($result));
    }

    if ($result['return_code'] !== 1) {
        throw new Exception('ZaloPay error: ' . ($result['return_message'] ?? 'Unknown error') . ' (Code: ' . $result['return_code'] . ')');
    }

    $_SESSION['zalopay_payment'] = [
        'trans_id' => $transID,
        'amount' => $tong_tien,
        'token' => $result['zp_trans_token']
    ];

    // Debug - Kiểm tra URL chuyển hướng
    error_log("Redirecting to: " . $result['order_url']);

    header('Location: ' . $result['order_url']);
    exit;

} catch (Exception $e) {
    error_log("ZaloPay Error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo '<script>
        alert("Có lỗi xảy ra: ' . addslashes($e->getMessage()) . '");
        window.location.href = "../../index.php?act=thanhtoan";
    </script>';
    exit;
}
?> 