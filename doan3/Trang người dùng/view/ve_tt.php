<?php
require_once 'qr/vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

// Tạo thư mục QR nếu chưa có
$qrDir = 'qrcode/';
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0777, true);
}

// include "view/search.php";
?>

<section class="container">
    <div class="order-container">
        <?php
        if($load_ve_tt) {
            extract($load_ve_tt);
            ?>
            <div class="order">
                <img class="order__images" alt='' src="images/tickets.png">
                <p class="order__title">Cảm ơn <br><span class="order__descript">bạn đã mua vé thành công</span></p>
            </div>

            <?php
            // Tạo nội dung QR code
            $qrtext = "Mã vé: $id\nTên phim: $tieu_de\nNgày chiếu: $ngay_chieu\nGiờ chiếu: $thoi_gian_chieu\nRạp: $tenrap\nPhòng: $tenphong\nNgười đặt: $name\nThời gian đặt: $ngay_dat\nGiá: " . number_format($thanh_tien, 0, ',', '.') . " vnđ\nGhế: $ghe\nCombo: $combo";
            $timestamp = time();
            $qrimage = $qrDir . 'ticket-' . $id . '-' . $timestamp . '.png';

            try {
                if (!extension_loaded('gd')) {
                    $qrimage = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrtext);
                } else {
                    $result = Builder::create()
                        ->writer(new PngWriter())
                        ->encoding(new Encoding('UTF-8'))
                        ->size(300)
                        ->margin(10)
                        ->data($qrtext)
                        ->build();

                    $result->saveToFile($qrimage);
                }
            } catch (Exception $e) {
                error_log("Error creating QR code: " . $e->getMessage());
                $qrimage = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrtext);
            }
            ?>

            <div class="ticket">
                <div class="ticket-position">
                    <div class="ticket__indecator indecator--pre">
                        <div class="indecator-text pre--text"><?=htmlspecialchars($tenrap)?></div>
                    </div>
                    <div class="ticket__inner">
                        <div class="ticket-secondary">
                            <span class="ticket__item">Mã vé <strong class="ticket__number"><?=htmlspecialchars($id)?></strong></span>
                            <span class="ticket__item ticket__date">Ngày: <?=htmlspecialchars($ngay_chieu)?></span>
                            <span class="ticket__item ticket__time">Giờ: <?=htmlspecialchars($thoi_gian_chieu)?></span>
                            <span class="ticket__item">Rạp : <span class="ticket__cinema"><?=htmlspecialchars($tenrap)?></span></span>
                            <span class="ticket__item">Phòng : <strong class="ticket__number"><?=htmlspecialchars($tenphong)?></strong></span>
                            <span class="ticket__item">Người đặt: <span class="ticket__cinema"><?=htmlspecialchars($name)?></span></span>
                            <span class="ticket__item">Thời gian đặt: <span class="ticket__hall"><?=htmlspecialchars($ngay_dat)?></span></span>
                            <span class="ticket__item ticket__price" style="margin-top: 5px">Giá: <strong class="ticket__cost"><?=number_format($thanh_tien)?> vnđ</strong></span>
                        </div>
                        <div class="i0">
                            <div class="ticket-primery">
                                <span class="ticket__item ticket__item--primery ticket__film" style="display:flex;"> <strong class="ticket__movie" >PHIM : <?=htmlspecialchars($tieu_de)?></strong></span>
                                <span class="ticket__item ticket__item--primery">Ghế: <span class="ticket__place"><?=htmlspecialchars($ghe)?></span></span>
                                <span class="ticket__item ticket__item--primery">Combo: <span class="ticket__place"><?=htmlspecialchars($combo)?></span></span>
                            </div>
                            <div class="qr-code">
                                <img src="<?=htmlspecialchars($qrimage)?>" alt="QR Code" class="qr-code-img">
                            </div>
                        </div>
                    </div>
                    <div class="ticket__indecator indecator--post">
                        <div class="indecator-text post--text"><?=htmlspecialchars($tenrap)?></div>
                    </div>
                </div>
            </div>
            
            <!-- Nút in vé -->
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn-print">
                    <i class="fa fa-print"></i> In vé
                </button>
                <a href="index.php?act=ve" class="btn-back">
                    Xem tất cả vé
                </a>
            </div>
            <?php
        } else {
            echo "<div class='alert alert-danger'>Không tìm thấy thông tin vé!</div>";
        }
        ?>
    </div>
</section>

<style>
    .qr-code-img {
        width: 200px;
        height: 200px;
    }
    .i0{
        display: flex;
    }
    .order{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn-print,
    .btn-back {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-print {
        background: #28a745;
        color: white;
        border: none;
    }
    .btn-back {
        background: #007bff;
        color: white;
    }
    @media print {
        .btn-print,
        .btn-back {
            display: none;
        }
    }

    /* Thêm CSS để điều chỉnh kích thước chữ */
    .ticket__item {
        font-size: 14px;  /* Giảm kích thước chữ mặc định */
    }

    .ticket__number,
    .ticket__cinema,
    .ticket__cost,
    .ticket__place {
        font-size: 14px;  /* Giảm kích thước chữ cho các phần in đậm */
    }

    .ticket__movie {
        font-size: 16px;  /* Giảm kích thước chữ tên phim nhưng vẫn lớn hơn chút */
    }

    .indecator-text {
        font-size: 13px;  /* Giảm kích thước chữ tên rạp ở header và footer */
    }

    .order__title {
        font-size: 20px;  /* Giảm kích thước chữ tiêu đề */
    }

    .order__descript {
        font-size: 16px;  /* Giảm kích thước chữ mô tả */
    }

    /* Điều chỉnh khoảng cách giữa các dòng */
    .ticket-secondary,
    .ticket-primery {
        line-height: 1.4;  /* Giảm khoảng cách giữa các dòng */
    }
  
</style>
