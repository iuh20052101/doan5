<?php

// Thêm vào đầu file để debug
error_log("Session trong thanhtoan.php trước khi xử lý: " . print_r($_SESSION, true));

// Kiểm tra và lấy thông tin từ session một cách an toàn
$id_phim = isset($_SESSION['tong']['id_phim']) ? $_SESSION['tong']['id_phim'] : '';
$id_lichchieu = isset($_SESSION['tong']['id_lichchieu']) ? $_SESSION['tong']['id_lichchieu'] : '';
$id_g = isset($_SESSION['tong']['id_g']) ? $_SESSION['tong']['id_g'] : '';
$id_phongchieu = isset($_SESSION['tong']['id_phongchieu']) ? $_SESSION['tong']['id_phongchieu'] : '';
$gia_ve = isset($_SESSION['tong']['gia_ve']) ? $_SESSION['tong']['gia_ve'] : '';
$ngay_chieu = isset($_SESSION['tong']['ngay_chieu']) ? $_SESSION['tong']['ngay_chieu'] : '';
$thoi_gian_chieu = isset($_SESSION['tong']['thoi_gian_chieu']) ? $_SESSION['tong']['thoi_gian_chieu'] : '';
$tieu_de = isset($_SESSION['tong']['tieu_de']) ? $_SESSION['tong']['tieu_de'] : '';
$rap_id = isset($_SESSION['tong']['rap_id']) ? $_SESSION['tong']['rap_id'] : '';
$tenrap = isset($_SESSION['tong']['tenrap']) ? $_SESSION['tong']['tenrap'] : 'Chưa có thông tin';

// Debug thông tin ghế trong thanhtoan.php
error_log("Thông tin ghế trong thanhtoan.php:");
error_log("ten_ghe: " . print_r(isset($_SESSION['tong']['ten_ghe']) ? $_SESSION['tong']['ten_ghe'] : 'không có', true));
error_log("ghe: " . print_r(isset($_SESSION['tong']['ghe']) ? $_SESSION['tong']['ghe'] : 'không có', true));
error_log("danh_sach_ghe: " . print_r(isset($_SESSION['tong']['danh_sach_ghe']) ? $_SESSION['tong']['danh_sach_ghe'] : 'không có', true));

// Lấy thông tin ghế 
if(isset($_SESSION['tong']['ten_ghe'])) {
    if(is_array($_SESSION['tong']['ten_ghe'])) {
        $ghe = implode(', ', $_SESSION['tong']['ten_ghe']);
    } else {
        $ghe = $_SESSION['tong']['ten_ghe'];
    }
} elseif(isset($_SESSION['tong']['danh_sach_ghe'])) {
    if(is_array($_SESSION['tong']['danh_sach_ghe'])) {
        $ghe = implode(', ', $_SESSION['tong']['danh_sach_ghe']);
    } else {
        $ghe = $_SESSION['tong']['danh_sach_ghe'];
    }
} else {
    $ghe = '';
}

// Lấy giá ghế từ dv2 (giá đã áp dụng khuyến mãi nếu có)
$gia_ghe = isset($_SESSION['tong']['gia_ghe']) ? $_SESSION['tong']['gia_ghe'] : 0;

// Lấy giá đồ ăn từ dv3
$tien_do_an = isset($_SESSION['tong']['tien_do_an']) ? $_SESSION['tong']['tien_do_an'] : 0;

// Đảm bảo tổng tiền được set chính xác
$tong_tien = 0;
if(isset($_SESSION['tong']['gia_ghe'])) {
    $tong_tien += $_SESSION['tong']['gia_ghe'];
}
if(isset($_SESSION['tong']['tien_do_an'])) {
    $tong_tien += $_SESSION['tong']['tien_do_an'];
}

// Set tổng tiền vào session
$_SESSION['tong']['tong_tien_thanh_toan'] = $tong_tien;

// Debug
error_log("Tổng tiền đã set: " . $tong_tien);

?>
<!-- Main content -->

<section class="container">
    <div class="order-container">
        <div class="order">
            <img class="order__images" alt='' src="images/tickets.png">
            <p class="order__title">Đặt vé <br><span class="order__descript">Tận Hưởng Thời Gian Xem Phim Vui Vẻ</span></p>
        </div>
    </div>
    <div class="order-step-area">
        <div class="order-step first--step order-step--disable ">1. Lịch Chiếu &amp; Thời gian</div>
        <div class="order-step second--step order-step--disable">2. Chọn ghế</div>
        <div class="order-step third--step">3. Thanh Toán </div>
    </div>
    <form action="" method="post">
  
    <div class="col-sm-12">
        <div class="checkout-wrapper">
            <h2 class="page-heading">Thông tin</h2>
          
            <ul class="book-result">
                <li class="book-result__item">Phim: <span class="book-result__count booking-cost"><?php echo $tieu_de ?></span></li>
                <li class="book-result__item">Rạp: <span class="book-result__count booking-cost"><?php echo $tenrap ?></span></li>
                <li class="book-result__item">Ngày chiếu: <span class="book-result__count booking-cost"><?php echo $ngay_chieu ?></span></li>
                <li class="book-result__item">Lịch chiếu: <span class="book-result__count booking-cost"><?php echo $thoi_gian_chieu ?></span></li>
                <br>
                <hr>
                <li class="book-result__item">Số ghế: <span class="book-result__count booking-cost"><?php echo $ghe ?></span></li>
                <?php if (isset($ten_doan['doan']) && !empty($ten_doan['doan'])): ?>
                <li class="book-result__item">Combo: <span class="book-result__count booking-cost">
                    <span class="check-doan">
                        <?php
                        foreach ($ten_doan['doan'] as $doan) {
                            echo '<span class="check-doan">' . $doan . '</span>';
                        }
                        ?>
                    </span>
                </span></li>
                <?php endif; ?>
                <br>
                <hr>
                <li class="book-result__item">Tổng tiền: <span class="book-result__count booking-cost"><?php echo number_format($tong_tien, 0, ',', '.') ?> VND</span></li>
            </ul>
           
            <h2 class="page-heading">Chọn hình thức thanh toán :</h2>
            <div class="payment">
                <ul>
                    <li>
                        <a href="view/momo/xuly_momo_atm.php" class="payment__item">
                            <img alt='' src="images/payment/momo.jpg" style="width: 70px; border-radius: 8px;">
                            <label class="tt">MOMO ATM</label>
                        </a>
                    </li>
                    
                    <!-- <li>
                        <a href="view/vnpay/xuly_vnpay.php" class="payment__item">
                            <img alt='' src="images/payment/vnpay.png" style="width: 70px; border-radius: 8px;">
                            <label class="tt">VNPAY</label>
                        </a>
                    </li> -->
                    <li>
                        <a href="view/zalopay/xuly_zalopay.php" class="payment__item">
                            <img alt='' src="images/payment/zalopay.png" style="width: 70px; border-radius: 8px;">
                            <label class="tt">ZaloPay</label>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="booking-pagination">
        <a href="index.php?act=dv3" class="quaylai">← Quay lại chọn đồ ăn</a>
   
    </div>
    </div>
 

</section>

</form>
<div class="clearfix"></div>


<div class="clearfix"></div>

<style>
 
  

  



    .checkout-wrapper {
        background: #000000;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        animation: fadeIn 0.5s ease;
    }

    .page-heading {
        color: #00ffff;
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
    }

    .book-result {
        list-style: none;
        padding: 0;
    }

    .book-result__item {
        padding: 10px;
        margin: 5px 0;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .book-result__item:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(10px);
    }

    .booking-cost {
        color: #ffd564;
        font-weight: bold;
    }

    .payment {
        margin-top: 20px;
    }

 

    .payment__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        border-color: #ffd564;
    }

    .tt {
        color: #fff;
        font-size: 1.2em;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes glowing {
        0% { text-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
        50% { text-shadow: 0 0 20px rgba(0, 255, 255, 0.8); }
        100% { text-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }

    /* Style cho nút quay lại */
    .booking-pagination {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding: 20px 0;
    }

    .quaylai, 
    .booking-pagination__button {
        padding: 12px 25px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-weight: bold;
        border: none;
    }

    .quaylai {
        background: linear-gradient(45deg, #333, #666);
        color: white;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .quaylai:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .quaylai::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        transition: 0.5s;
    }

    .quaylai:hover::before {
        left: 100%;
    }

    /* Style cho nút tiếp tục */
    .booking-pagination__button {
        background: linear-gradient(45deg, #dc3545, #ff5c6c);
        color: white;
    }

    .booking-pagination__button:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    .payment ul {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .payment__item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        padding: 10px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .payment__item:hover {
        transform: translateY(-5px);
        background: rgba(255,255,255,0.1);
    }

    .payment__item img {
        margin-bottom: 10px;
    }

    .tt {
        color: #fff;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php 
            switch($_GET['error']) {
                case '1':
                    echo 'Có lỗi xảy ra trong quá trình xử lý thanh toán';
                    break;
                case '2':
                    echo 'Thanh toán không thành công!';
                    break;
                default:
                    echo 'Có lỗi xảy ra, vui lòng thử lại';
            }
        ?>
    </div>
<?php endif; ?>