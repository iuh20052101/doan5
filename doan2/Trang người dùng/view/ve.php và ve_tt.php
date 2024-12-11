<?php
require_once 'model/qrcode.php';

// Khi cần tạo QR code
$ticket_data = [
    'id' => $id,
    'tieu_de' => $tieu_de,
    'ngay_chieu' => $ngay_chieu,
    'thoi_gian_chieu' => $thoi_gian_chieu,
    'tenrap' => $tenrap,
    'tenphong' => $tenphong,
    'name' => $name,
    'ngay_dat' => $ngay_dat,
    'price' => number_format($price, 0, ',', '.') . ' vnđ',
    'ghe' => $ghe,
    'combo' => $combo
];

$qrimage = generateTicketQR($ticket_data); 