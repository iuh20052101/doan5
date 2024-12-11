<?php
session_start();
require_once("config_zalopay.json");

if (!isset($_GET['status'])) {
    header("Location: ../../index.php?act=thanhtoan");
    exit;
}

$status = $_GET['status'];
$trans_id = $_GET['apptransid'] ?? '';

if ($status == 1) { // Thanh toán thành công
    header("Location: ../../index.php?act=bill&resultCode=0");
} else { // Thanh toán thất bại
    header("Location: ../../index.php?act=bill&resultCode=1");
}
exit;
?> 