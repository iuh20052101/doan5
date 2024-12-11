
<style>
    /* Nền gradient động */
 

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Container với glass effect */


    /* Box đồ ăn với hover effect */
    .prodo {
        width: 23%;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 10px;
        text-align: center;
        background: #000000;
        border-radius: 10px;
        color: #fff;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .prodo:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        border-color: #ffd564;
    }

    .prodo:hover img {
        transform: scale(1.1);
    }

    .prodo img {
        transition: transform 0.3s ease;
    }

    /* Nút với gradient và hover effect */
    .check_do_an {
        background: linear-gradient(45deg, #dc3545, #ff5c6c);
        color: white;
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .check_do_an:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    .check_do_an::before {
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

    .check_do_an:hover::before {
        left: 100%;
    }

    /* Thông tin đặt vé với animation */
    .tong {
        background: #000000;
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Tiêu đề với text glow */
    .phim {
        color: #00ffff;
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        animation: glowing 2s ease-in-out infinite;
    }

    @keyframes glowing {
        0% { text-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
        50% { text-shadow: 0 0 20px rgba(0, 255, 255, 0.8); }
        100% { text-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
    }

    /* Thông tin chi tiết với hover effect */
    .win span {
        display: block;
        /* margin: 10px 0; */
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .win span:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(10px);
    }

    /* Tổng tiền với gradient text */
    /* .checked-result {
        background: linear-gradient(45deg, #ffd564, #ff9f1a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
    } */

    /* Thông tin giảm giá với animation */
    .discount-info {
        color: #ffd564;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .container {
        width: 80%;
        margin: 0 auto;
        
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .prodoan {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap; /* Cho phép các phần tử xuống dòng khi không đủ không gian */
        margin-top: 20px;
    }

    .prodo {
        width: 23%;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 10px;
        text-align: center;
        background: #000000;
        border-radius: 10px;
        color: #fff;
    }

    .check_do_an {
        background-color: #dc3545;
        color: white;
        padding: 8px 15px;
        border: none;
        cursor: pointer;
    }

    /* Phần thông tin đặt vé */
    .tong {
        background: #000000;
        color: #fff;
     
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Tiêu đề phim */
    .phim {
        color: #00ffff; /* Màu cyan cho tiêu đề */
        margin-bottom: 20px;
    }

    /* Thông tin chi tiết */
    .win span {
        display: block;
      
        color: #fff;
    }

    /* Combo đã chọn */
    .check-doan {
        color: #fff;
    }

    /* Tổng tiền */
    .checked-result {
        color: #fff;
    }

    /* Input tổng tiền */
    #gia_ghe {
        background: #000000;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Thông tin giảm giá */
    .discount-info {
        color: #ffd564; /* Màu vàng cho thông tin giảm giá */
    }

    /* Style cho phần pagination */
    .booking-pagination {
        display: flex;
        justify-content: center;
        gap: 500px;
      
        align-items: center;
    }

    /* Style chung cho cả 2 nút */
    .quaylai,
    .booking-pagination__button {
        padding: 12px 25px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-weight: bold;
        text-decoration: none;
        border: none;
        min-width: 150px;
        text-align: center;
    }

    /* Nút quay lại */
    .quaylai {
        background: linear-gradient(45deg, #333, #666);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .quaylai:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* Hiệu ứng shine cho nút quay lại */
    .quaylai::before {
        content: '';
        position: absolute;
        top: 0;
        left: -70%;
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

 

    /* Nút tiếp tục */
    .booking-pagination__button {
        background: linear-gradient(45deg, #dc3545, #ff5c6c);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .booking-pagination__button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }
    .place-form-area {
    padding: 100px;
 
    margin: 0 auto;
}
</style>
<!-- Main content -->
<div class="place-form-area">
    <section class="container">
        <h1>Combo</h1>
        <div class="prodoan">
            <div class="prodo">
                <img src="imgavt/combo1.png" alt="Prodo 1" >
                <h3>Combo Minhon</h3>
                <p>GIẢM!!! Gồm: 1 Bắp vị bất kì + 1 Nước có gaz</p>

                <p>Giá: 59.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an btn btn-md btn--danger" check-price='3' check-place = 'Combo-Coca '>CHỌN NGAY</span>
                </div>


            </div>
            <div class="prodo">
                <img src="imgavt/combo2.png" alt="Prodo 1" >
                <h3>Combo Mini</h3>
                <p>5 Hộp bắp vị bất kì + free nước có gaz</p>

                <p>Giá: 259.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an , btn btn-md btn--danger" check-price='4' check-place = 'Combo-Halo '>CHỌN NGAY</span>
                </div>


            </div>
            <div class="prodo">
                <img src="imgavt/combo4.png" alt="Prodo 1" >
                <h3>Combo Max</h3>
                <p>5 ly nước có gazzzzzz mát lạnh</p>

                <p>Giá: 125.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an , btn btn-md btn--danger" check-price='1' check-place = 'Combo-Wish-C1 '>CHỌN NGAY</span>
                </div>


            </div>

            <div class="prodo" >
                <img src="imgavt/combo5.png" alt="Prodo 2" >
                <h3>Combo MaxMax</h3>
                <p>5 ly nước có gaz + 3 Hộp bắp vị bất kì</p>
                <p>Giá: 185.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an , btn btn-md btn--danger" check-price='2' check-place = 'Combo-Wish-B3 '>CHỌN NGAY </span>
                </div>

            </div>
            <div class="prodo" >
                <img src="imgavt/combo1.png" alt="Prodo 2" >
                <h3>Combo Định Mệnh</h3>
                <p>7 ly nước có gaz + 1 Hộp bắp vị bất kì</p>
                <p>Giá: 199.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an , btn btn-md btn--danger" check-price='6' check-place = 'Combo-Hủy-Diệt '>CHỌN NGAY </span>
                </div>

            </div>
            <div class="prodo" >
                <img src="imgavt/combo3.png" alt="Prodo 2" >
                <h3>Combo Hãi Hùng</h3>
                <p>10 ly nước có gaz + 1 Hộp bắp </p>
                <p>Giá: 219.000đ</p>
                <div class="combo-doan-right">
                    <span class="check_do_an btn btn-md btn--danger" check-price='5' check-place = 'Combo-Halo-2 '>CHỌN NGAY </span>
                </div>

            </div>

        </div>

</div>
<form action="index.php?act=dv4" method="post">
    <div class="col-lg-offset-1">
        <div class="tong">
            <h2 class="phim">Phim bạn chọn: <?= $_SESSION['tong']['tieu_de'] ?></h2>
            <div class="win">
                <span>📅Ngày chiếu: <?= isset($_SESSION['tong']['ngay_chieu']) ? $_SESSION['tong']['ngay_chieu'] : '' ?></span> <br>          
                <span>⏱Giờ chiếu: <?= isset($_SESSION['tong']['thoi_gian_chieu']) ? $_SESSION['tong']['thoi_gian_chieu'] : '' ?></span> <br>
                <span>🪑Ghế đã chọn:
                    <div class="checked-place">
                        <?php
                        if(isset($_SESSION['tong']['ten_ghe']) && is_array($_SESSION['tong']['ten_ghe'])) {
                            echo implode(', ', $_SESSION['tong']['ten_ghe']);
                            
                            foreach ($_SESSION['tong']['ten_ghe'] as $ghe) {
                                echo '<input type="hidden" name="ten_ghe[]" value="' . $ghe . '">';
                            }
                        }
                        ?>
                    </div>
                </span>
                <span>🏢Rạp: <?= isset($_SESSION['tong']['tenrap']) ? htmlspecialchars($_SESSION['tong']['tenrap']) : 'Chưa có thông tin' ?></span> <br>
                <!-- <span>📍Địa chỉ: <?= isset($_SESSION['tong']['diachi']) ? htmlspecialchars($_SESSION['tong']['diachi']) : 'Chưa có thông tin' ?></span> -->
            </div>
            
            <div style="display: flex">
                <span>Combo đã chọn: </span>
                <div class="check-doan">
                    <?php
                    if (isset($ten_doan['doan'])) {
                        foreach ($ten_doan['doan'] as $doan) {
                            echo  '<span class="check-doan">' . $doan . '</span>';
                            echo  '<input type="text" name="ten_do_an[]" value="' . $doan . '">';
                        }
                    } else {
                    } ?>
                </div>
            </div>

            <div class="tongtien">
                <div class="checked-result">
                    <span>Tổng cộng:</span>
                    <input name="giaghe" 
                           style="width: 80px; font-size: 20px; border: none;" 
                           type="text" 
                           id="gia_ghe"
                           value="<?php 
                               echo isset($_SESSION['tong']['final_price']) ? $_SESSION['tong']['final_price'] : 
                                    (isset($_SESSION['tong'][0]) ? $_SESSION['tong'][0] : 0); 
                           ?>" readonly>
                    <?php if(isset($_SESSION['tong']['discount_amount']) && $_SESSION['tong']['discount_amount'] > 0): ?>
                        <div class="discount-info">
                            <small>(Đã áp dụng giảm giá: <?= number_format($_SESSION['tong']['discount_amount']) ?>đ)</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-pagination ">
        <a href="index.php?act=datve2&id=<?php echo $_SESSION['tong']['id_phim'] ?>" >
            <span class="quaylai">QUAY LẠI</span>

        </a>
        <a href="" >
            <input type="submit" name="tiep_tuc" class="booking-pagination__button" value="TIẾP TỤC">
        </a>
    </div>
</form>

<div class="clearfix"></div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    // Lấy giá ghế ban đ���u
    var giaGheBanDau = parseInt(document.querySelector("#gia_ghe").value) || 0;
    var tong_tien = giaGheBanDau;

    // Xử lý click đồ ăn
    $(".check_do_an").click(function(e) {
        e.preventDefault();
        var tenCombo = $(this).attr("check-place");
        var doanPrice = $(this).attr("check-price");

        if (!$(this).hasClass("trangThai")) {
            // Thêm trạng thái đã chọn
            $(this).addClass("trangThai");
            $(this).removeClass("btn--danger").addClass("btn--success").text("BỎ CHỌN");

            // Thêm combo vào danh sách
            $(".check-doan").prepend(`
                <span class="choosen-place ${tenCombo}">${tenCombo}</span>
                <input class="${tenCombo}" type="hidden" name="ten_do_an[]" value="${tenCombo}">
            `);

            // Cộng tiền theo loại combo
            switch (doanPrice) {
                case "1": tong_tien += 125000; break;
                case "2": tong_tien += 185000; break;
                case "3": tong_tien += 59000; break;
                case "4": tong_tien += 259000; break;
                case "5": tong_tien += 219000; break;
                case "6": tong_tien += 199000; break;
            }
        } else {
            // Bỏ chọn
            $(this).removeClass("trangThai");
            $(this).removeClass("btn--success").addClass("btn--danger").text("CHỌN NGAY");

            // Xóa combo khỏi danh sách
            $("." + tenCombo).remove();

            // Trừ tiền theo loại combo
            switch (doanPrice) {
                case "1": tong_tien -= 125000; break;
                case "2": tong_tien -= 185000; break;
                case "3": tong_tien -= 59000; break;
                case "4": tong_tien -= 259000; break;
                case "5": tong_tien -= 219000; break;
                case "6": tong_tien -= 199000; break;
            }
        }

        // Cập nhật giá và hiển thị
        document.getElementById("gia_ghe").value = tong_tien;
        $('.checked-result').html(`
            <span>Tổng cộng:</span>
            <input name="giaghe" 
                   type="text" 
                   id="gia_ghe" 
                   value="${tong_tien}" 
                   style="width: 80px; font-size: 20px; border: none;"
                   readonly>
            <span>VND</span>
            <input name="tong_tien_do_an" type="hidden" value="${tong_tien - giaGheBanDau}">
            ${tong_tien > giaGheBanDau ? `
                <div class="discount-info">
                    <small>(Tiền đồ ăn: ${(tong_tien - giaGheBanDau).toLocaleString('vi-VN')}đ)</small>
                </div>
            ` : ''}
        `);

        // Lưu vào session
        $.ajax({
            url: 'index.php?act=save_total',
            method: 'POST',
            data: {
                gia_ghe: giaGheBanDau,
                tien_do_an: tong_tien - giaGheBanDau,
                tong_cong: tong_tien
            }
        });
    });
});
</script>