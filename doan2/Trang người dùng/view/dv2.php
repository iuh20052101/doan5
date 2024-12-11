<?php if(isset($thongbaoghe) && ($thongbaoghe) != "") {
    echo '<p style="color: red; text-align: center;">' . $thongbaoghe . '</p>';
}

// Lấy thông tin từ session và URL
$id_khunggio = isset($_SESSION['tong']['id_g']) ? $_SESSION['tong']['id_g'] : 
              (isset($_GET['id_g']) ? $_GET['id_g'] : 0);
$id_lichchieu = isset($_SESSION['tong']['id_lichchieu']) ? $_SESSION['tong']['id_lichchieu'] : 
                (isset($_GET['id_lc']) ? $_GET['id_lc'] : 0);
$id_phong = isset($_SESSION['tong']['id_phongchieu']) ? $_SESSION['tong']['id_phongchieu'] : 
           (isset($_GET['id_phong']) ? $_GET['id_phong'] : 0);

// Debug
error_log("ID khung giờ: $id_khunggio");
error_log("ID lịch chiếu: $id_lichchieu");
error_log("ID phòng: $id_phong");
?>

<div class="content-body">
    <section class="container seat-section">
        <div class="box">
            <div class="box-head">
                <h3 class="title">Phim: <?= isset($_SESSION['tong']['tieu_de']) ? $_SESSION['tong']['tieu_de'] : '' ?></h3>
            </div>

            <!-- Phần chú thích -->
            <div class="chu-thich-container">
                <div class="chu-thich">
                    <div class="col-auto">
                        <button class="ghe thuong"></button>
                        <span>Ghế thường</span>
                    </div>
                    <div class="col-auto">
                        <button class="ghe vip"></button>
                        <span>Ghế VIP</span>
                    </div>
                    <div class="col-auto">
                        <button class="ghe-doi"></button>
                        <span>Ghế đôi</span>
                    </div>
                    <div class="col-auto">
                        <button class="ghe đã-đặt"></button>
                        <span>Đã đặt</span>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="so-do-ghe">
                    <div class="man-hinh">Màn hình</div>
                    <?php
                    if($id_khunggio) {
                        try {
                            // 1. Lấy thông tin phòng và giá vé
                            $sql = "SELECT pc.*, r.id as rap_id, r.tenrap, p.gia_ve,
                                   l.ngay_chieu, kgc.thoi_gian_chieu
                                   FROM khung_gio_chieu kgc
                                   JOIN phongchieu pc ON kgc.id_phong = pc.id
                                   JOIN rap r ON pc.rap_id = r.id 
                                   JOIN lichchieu l ON kgc.id_lich_chieu = l.id
                                   JOIN phim p ON l.id_phim = p.id
                                   WHERE kgc.id = ?";
                            $info = pdo_query_one($sql, $id_khunggio);

                            if($info) {
                                // 2. Lấy danh sách ghế
                                $sql_ghe = "SELECT * FROM ghe 
                                          WHERE id_khung_gio_chieu = ?
                                          ORDER BY hang, so_ghe";
                                $list_ghe = pdo_query($sql_ghe, $id_khunggio);

                                // Lưu thông tin vào session
                                $_SESSION['tong']['rap_id'] = $info['rap_id'];
                                $_SESSION['tong']['tenrap'] = $info['tenrap'];
                                $_SESSION['tong']['ten_phong'] = $info['name'];
                                $_SESSION['tong']['ngay_chieu'] = $info['ngay_chieu'];
                                $_SESSION['tong']['thoi_gian_chieu'] = $info['thoi_gian_chieu'];
                                $_SESSION['tong']['gia_ve'] = $info['gia_ve'];

                                // 3. Tạo mảng ghế theo hàng
                                $ghe_theo_hang = [];
                                foreach($list_ghe as $ghe) {
                                    $ghe_theo_hang[$ghe['hang']][] = $ghe;
                                }

                                // 4. Hiển thị ghế
                                foreach($ghe_theo_hang as $hang => $ghe_hang) {
                                    echo '<div class="hang-ghe">';
                                    echo '<div class="label-hang">'.$hang.'</div>';
                                    
                                    // Kiểm tra ghế đôi
                                    $is_hang_doi = array_search($hang, array_keys($ghe_theo_hang)) >= count($ghe_theo_hang) - 2;
                                    
                                    if($is_hang_doi) {
                                        // Xử lý ghế đôi
                                        for($i = 0; $i < count($ghe_hang); $i += 2) {
                                            if(isset($ghe_hang[$i])) {
                                                if(isset($ghe_hang[$i + 1])) {
                                                    // Xử lý cặp ghế đôi
                                                    $ghe1 = $ghe_hang[$i];
                                                    $ghe2 = $ghe_hang[$i + 1];
                                                    
                                                    $class = 'ghe-doi';
                                                    if($ghe1['trang_thai'] == 'đã đặt' || $ghe2['trang_thai'] == 'đã đặt') {
                                                        $class .= ' đã-đặt';
                                                    }

                                                    $gia_ghe = $info['gia_ve'] * 2; // Ghế đôi có hệ số 2
                                                    $ma_ghe = $hang . $ghe1['so_ghe'] . '-' . $ghe2['so_ghe'];

                                                    echo '<button class="'.$class.'" 
                                                          data-id="'.$ghe1['id'].','.$ghe2['id'].'" 
                                                          data-gia="'.$gia_ghe.'">'.$ma_ghe.'</button>';
                                                } else {
                                                    // Xử lý ghế lẻ cuối hàng
                                                    $ghe = $ghe_hang[$i];
                                                    $class = 'ghe ' . $ghe['loai_ghe'];
                                                    if($ghe['trang_thai'] == 'đã đặt') {
                                                        $class .= ' đã-đặt';
                                                    }

                                                    $he_so = ($ghe['loai_ghe'] == 'vip') ? 1.5 : 1;
                                                    $gia_ghe = $info['gia_ve'] * $he_so;
                                                    $ma_ghe = $hang . $ghe['so_ghe'];

                                                    echo '<button class="'.$class.'" 
                                                          data-id="'.$ghe['id'].'" 
                                                          data-gia="'.$gia_ghe.'">'.$ma_ghe.'</button>';
                                                }
                                            }
                                        }
                                    } else {
                                        // Xử lý ghế thường và VIP
                                        foreach($ghe_hang as $ghe) {
                                            $class = 'ghe ' . $ghe['loai_ghe'];
                                            if($ghe['trang_thai'] == 'đã đặt') {
                                                $class .= ' đã-đặt';
                                            }

                                            $he_so = ($ghe['loai_ghe'] == 'vip') ? 1.5 : 1;
                                            $gia_ghe = $info['gia_ve'] * $he_so;
                                            $ma_ghe = $hang . $ghe['so_ghe'];

                                            echo '<button class="'.$class.'" 
                                                  data-id="'.$ghe['id'].'" 
                                                  data-gia="'.$gia_ghe.'">'.$ma_ghe.'</button>';
                                        }
                                    }
                                    echo '</div>';
                                }
                            }
                        } catch(Exception $e) {
                            error_log("Lỗi: " . $e->getMessage());
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Phần thông tin -->
    <section class="container info-section">
        <div class="box">
            <div class="box-head">
                <h3 class="title">Thông tin đặt vé</h3>
            </div>
            <div class="box-body">
                <form action="index.php?act=dv3" method="post" id="bookingForm" onsubmit="return validateForm()">
                    <!-- Thêm các input hidden cần thiết -->
                    <input type="hidden" name="id_khunggio" value="<?= $id_khunggio ?>">
                    <input type="hidden" name="id_lichchieu" value="<?= $id_lichchieu ?>">
                    <input type="hidden" name="id_phim" value="<?= isset($_SESSION['tong']['id_phim']) ? $_SESSION['tong']['id_phim'] : '' ?>">
                    <input type="hidden" name="id_rap" value="<?= isset($_SESSION['tong']['rap_id']) ? $_SESSION['tong']['rap_id'] : '' ?>">
                    <input type="hidden" name="ten_rap" value="<?= isset($_SESSION['tong']['tenrap']) ? $_SESSION['tong']['tenrap'] : '' ?>">
                    <input type="hidden" name="dia_chi_rap" value="<?= isset($_SESSION['tong']['dia_chi_rap']) ? $_SESSION['tong']['dia_chi_rap'] : '' ?>">
                    
                    <!-- Input cho ghế và giá -->
                    <input type="hidden" name="ten_ghe" id="danh_sach_ghe" value="">
                    <input type="hidden" name="giaghe" id="gia_ghe" value="0">
                    <input type="hidden" name="tong_tien_ghe" id="tong_tien_ghe" value="0">
                    
                    <!-- Input cho khuyến mãi -->
                    <input type="hidden" name="promotion_id" id="promotion_id" value="">
                    <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                    <input type="hidden" name="final_price_input" id="final_price_input" value="0">

                    <div class="win">
                        <span>Rạp: <?= isset($_SESSION['tong']['tenrap']) ? $_SESSION['tong']['tenrap'] : 'Chưa xác định' ?></span>
                        <span>🎦Phòng: <?= isset($_SESSION['tong']['ten_phong']) ? $_SESSION['tong']['ten_phong'] : 'Chưa xác định' ?></span>
                        <span>📅Ngày chiếu: <?= isset($_SESSION['tong']['ngay_chieu']) ? date('d/m/Y', strtotime($_SESSION['tong']['ngay_chieu'])) : '' ?></span>
                        <span>⏱Giờ chiếu: <?= isset($_SESSION['tong']['thoi_gian_chieu']) ? date('H:i', strtotime($_SESSION['tong']['thoi_gian_chieu'])) : 'Chưa xác định' ?></span>
                    </div>

                    <div class="checked-place">
                     
                        <!-- Ghế sẽ được thêm vào đây bằng JavaScript -->
                    </div>

                    <div class="tongtien">
                        <div class="checked-result">
                            <span>Tổng cộng:</span>
                            <input name="giaghe" type="text" id="gia_ghe" value="0" readonly> VND
                        </div>
                        
                        <!-- Phần khuyến mãi -->
                        <div class="promotion-section">
                            <div class="promotion-select">
                                <label for="promotion">Chọn mã khuyến mãi:</label>
                                <select name="promotion" id="promotion" onchange="applyPromotion()">
                                    <option value="">Không sử dụng</option>
                                    <?php 
                                    if(isset($_SESSION['user'])) {
                                        $promotions = get_user_promotions($_SESSION['user']['id']);
                                        foreach($promotions as $promo) {
                                            echo '<option value="'.$promo['id'].'" data-value="'.($promo['gia_tri'] * 1000).'">'
                                                 .$promo['ten_km'].' - Giảm '.number_format($promo['gia_tri'] * 1000).'đ</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="price-summary">
                                <div class="discount">
                                    Giảm giá: <span id="discount-amount">0đ</span>
                                </div>
                                <div class="final-price">
                                    Thành tiền: <span id="final-price">0đ</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thêm input hidden để lưu thông tin -->
                        <input type="hidden" name="original_price" id="original_price">
                        <input type="hidden" name="discount_amount" id="discount_amount">
                        <input type="hidden" name="final_price_input" id="final_price_input">
                        <input type="hidden" name="promotion_id" id="promotion_id">
                    </div>

                    <!-- Thêm các input hidden để lưu thông tin -->
                    <input type="hidden" name="final_price" id="final_price" value="0">
                    <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                    <input type="hidden" name="promotion_id" id="promotion_id" value="">
                    
                    <!-- Thêm input hidden để lưu thông tin -->
                    <input type="hidden" name="tong_tien_ghe" id="tong_tien_ghe" value="0">
                    <input type="hidden" name="danh_sach_ghe" id="danh_sach_ghe" value="">
                    
                    <!-- Thêm nút submit -->
                    <div class="booking-pagination">
                        <a href="index.php?act=datve&id=<?= isset($_SESSION['tong']['id_phim']) ? $_SESSION['tong']['id_phim'] : '' ?>" 
                           class="booking-pagination__prev">
                            <span class="arrow">←</span> Quay lại
                        </a>
                        <button type="submit" name="tiep_tuc" class="booking-pagination__next">
                            Tiếp tục <span class="arrow">→</span>
                        </button>
                    </div>

                    <!-- Thêm div hiển thị thông báo lỗi -->
                    <div id="error-message" class="error-message"></div>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    .container1 {
    margin-top: 50px;
}
.content-body {
    padding: 100px;
    max-width: 1400px;
    margin: 0 auto;
}

.box {
    background: #8080;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    width: 100%;
}

.box-head {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

.box-head .title {
    margin: 0;
    font-size: 18px;
    font-weight: 500;
}

.box-body {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.so-do-ghe {
    padding: 20px;
    text-align: center;
}

.hang-ghe {
    margin: 15px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.label-hang {
    width: 40px;
    margin-right: 20px;
    font-weight: bold;
    font-size: 16px;
}

.ghe {
    width: 45px;
    height: 45px;
    border: 2px solid #ddd;
    background: #fff;
    cursor: pointer;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.ghe:hover:not(.đã-đặt) {
    transform: scale(1.1);
}

.ghe.vip {
    background: #ffd700;
    color: #000;
    border-color: #ffd700;
}

.ghe-doi {
    width: 100px;
    height: 45px;
    background: #ff69b4;
    color: #fff;
    border: 2px solid #ff69b4;
    cursor: pointer;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.ghe.đã-đặt, .ghe-doi.đã-đặt {
    background: #808080;
    color: #fff;
    border-color: #808080;
    cursor: not-allowed;
}

.man-hinh {
    width: 90%;
    height: 40px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin: 0 auto 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    font-weight: bold;
}

.chu-thich-container {
    max-width: 1400px;
    margin: 0 auto 30px;
    background: #000000;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 5px;
}

.chu-thich {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    width: 100%;
}

.chu-thich .col-auto {
    display: flex;
    align-items: center;
    padding: 0 30px;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.chu-thich .col-auto:last-child {
    border-right: none;
}

.chu-thich button {
    margin-right: 10px;
}

.chu-thich span {
    color: #fff;
}

/* Phần thông tin */
.win {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.win span {
    padding: 12px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    font-size: 15px;
}

.ghe-da-chon {
    margin: 30px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
}

.checked-place {
    margin-top: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.choosen-place {
    padding: 8px 15px;
    font-size: 15px;
}

.tongtien {
    margin: 30px 0;
    padding: 20px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 5px;
}

.checked-result {
    font-size: 18px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #ddd;
}

#gia_ghe {
    width: 100px;
    font-size: 20px;
    text-align: right;
    padding-right: 10px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.booking-pagination {
    margin-top: 30px;
    padding-top: 20px;
}

.quaylai, .booking-pagination__button {
    padding: 10px 30px;
    font-size: 16px;
}

/* Responsive */
@media (max-width: 1200px) {
    .content-body {
        padding: 15px;
        margin: 0 10px;
    }
}

@media (max-width: 768px) {
    .win {
        grid-template-columns: 1fr;
    }
    
    .chu-thich {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .chu-thich .col-auto {
        border-right: none;
        padding: 10px 20px;
    }
}

/* Style cho ghế được chọn - đặt ở vị trí cao hơn để override các style khác */
.ghe.selected, .ghe.thuong.selected {
    background-color: #4CAF50 !important;
    color: white !important;
    border-color: #4CAF50 !important;
}

.ghe.vip.selected {
    background-color: #4CAF50 !important;
    color: white !important;
    border-color: #4CAF50 !important;
}

.ghe-doi.selected {
    background-color: #4CAF50 !important;
    color: white !important;
    border-color: #4CAF50 !important;
}

.promotion-section {
    margin-top: 20px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.promotion-select {
    margin-bottom: 20px;
}

.promotion-select label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.promotion-select select {
    width: 100%;
    padding: 10px;
    background: #000000;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    font-size: 16px;
}

.price-summary > div {
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    font-size: 16px;
}

.final-price {
    font-weight: bold;
    font-size: 18px;
    color: #e53637;
}

.booking-pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    padding: 20px 0;
}

.booking-pagination__prev,
.booking-pagination__next {
    padding: 15px 40px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-weight: bold;
    text-decoration: none;
    border: none;
    min-width: 200px;
    text-align: center;
    font-size: 16px;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.booking-pagination__prev {
    background: linear-gradient(45deg, #2c2c2c, #3d3d3d);
    color: white;
    border: 1px solid rgba(255,255,255,0.1);
}

.booking-pagination__prev:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255,255,255,0.1);
    background: linear-gradient(45deg, #3d3d3d, #4d4d4d);
}

.booking-pagination__next {
    background: linear-gradient(45deg, #ffd564, #ff9f1a);
    color: #000;
    font-weight: 700;
    box-shadow: 0 5px 15px rgba(255,213,100,0.2);
}

.booking-pagination__next:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255,213,100,0.4);
    background: linear-gradient(45deg, #ff9f1a, #ffd564);
}

.booking-pagination__prev::before,
.booking-pagination__next::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
    );
    transition: 0.5s;
}

.booking-pagination__prev:hover::before,
.booking-pagination__next:hover::before {
    left: 100%;
}

.arrow {
    margin-right: 8px;
    font-size: 18px;
}

.ghe.đã-đặt, 
.ghe-doi.đã-đặt,
.ghe.thuong.đã-đặt,
.ghe.vip.đã-đặt {
    background-color: #808080 !important; /* Màu xám */
    color: #ffffff !important;
    border-color: #808080 !important;
    cursor: not-allowed;
    opacity: 0.7;
    pointer-events: none; /* Ngăn không cho click */
}

/* Thêm hiệu ứng hover */
.ghe:not(.đã-đặt):hover,
.ghe-doi:not(.đã-đặt):hover {
    transform: scale(1.1);
    transition: all 0.3s ease;
}

/* Đảm bảo ghế đã đặt không có hiệu ứng hover */
.ghe.đã-đặt:hover,
.ghe-doi.đã-đặt:hover {
    transform: none;
}

/* Thêm style cho thông báo lỗi */
.error-message {
    color: #ff0000;
    text-align: center;
    margin: 10px 0;
    padding: 10px;
    background-color: rgba(255, 0, 0, 0.1);
    border-radius: 4px;
    display: none;
}
</style>

<script>
let currentUrl = window.location.href;

setInterval(() => {
    if (currentUrl !== window.location.href) {
        window.location.reload();
        currentUrl = window.location.href;
    }
}, 500);

document.addEventListener('DOMContentLoaded', function() {
    // Thêm sự kiện click cho tất cả các ghế
    const gheElements = document.querySelectorAll('.ghe:not(.đã-đặt), .ghe-doi:not(.đã-đặt)');
    gheElements.forEach(ghe => {
        ghe.addEventListener('click', function() {
            this.classList.toggle('selected');
            capNhatGheDaChon();
            tinhTongTien();
        });
    });
});

function capNhatGheDaChon() {
    const gheSelected = document.querySelectorAll('.ghe.selected, .ghe-doi.selected');
    const checkedPlace = document.querySelector('.checked-place');
    checkedPlace.innerHTML = '';
    
    let danhSachGhe = [];
    let danhSachId = [];
    
    gheSelected.forEach(ghe => {
        const span = document.createElement('span');
        span.className = 'choosen-place';
        span.textContent = `Ghế ${ghe.textContent}`;
        checkedPlace.appendChild(span);
        
        danhSachGhe.push(ghe.textContent);
        danhSachId.push(ghe.dataset.id);
    });

    // Cập nhật input hidden
    document.getElementById('danh_sach_ghe').value = danhSachGhe.join(',');
    
    // Thêm input hidden mới cho ID ghế
    const gheIdInput = document.createElement('input');
    gheIdInput.type = 'hidden';
    gheIdInput.name = 'ghe_id[]';
    gheIdInput.value = danhSachId.join(',');
    checkedPlace.appendChild(gheIdInput);
}

function tinhTongTien() {
    const gheSelected = document.querySelectorAll('.ghe.selected, .ghe-doi.selected');
    let tongTien = 0;
    
    gheSelected.forEach(ghe => {
        const giaGhe = parseInt(ghe.dataset.gia) || 0;
        tongTien += giaGhe;
    });
    
    // Cập nhật hiển thị và input
    const giaGheInput = document.getElementById('gia_ghe');
    const tongTienGheInput = document.getElementById('tong_tien_ghe');
    
    if(giaGheInput) giaGheInput.value = tongTien;
    if(tongTienGheInput) tongTienGheInput.value = tongTien;

    const tongTienDisplay = document.querySelector('.checked-result');
    if(tongTienDisplay) {
        tongTienDisplay.innerHTML = `<span>Tổng tiền: ${formatCurrency(tongTien)}</span>`;
    }

    if(typeof applyPromotion === 'function') {
        applyPromotion();
    }
}

function applyPromotion() {
    const select = document.getElementById('promotion');
    const selectedOption = select.options[select.selectedIndex];
    const originalPrice = parseInt(document.getElementById('gia_ghe').value) || 0;
    
    // Lấy giá trị giảm giá
    const discountAmount = selectedOption.value ? parseInt(selectedOption.dataset.value) : 0;
    
    // Tính giá cuối
    const finalPrice = Math.max(0, originalPrice - discountAmount);
    
    // Cập nhật hiển thị
    document.getElementById('discount-amount').textContent = formatCurrency(discountAmount);
    document.getElementById('final-price').textContent = formatCurrency(finalPrice);
    
    // Cập nhật input hidden
    document.getElementById('original_price').value = originalPrice;
    document.getElementById('discount_amount').value = discountAmount;
    document.getElementById('final_price_input').value = finalPrice;
    document.getElementById('promotion_id').value = selectedOption.value;
    
    // Lưu vào session thông qua AJAX
    saveToSession(originalPrice, discountAmount, finalPrice, selectedOption.value);
}

function saveToSession(originalPrice, discountAmount, finalPrice, promotionId) {
    fetch('index.php?act=save_price', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            original_price: originalPrice,
            discount_amount: discountAmount,
            final_price: finalPrice,
            promotion_id: promotionId
        })
    }).then(response => response.json())
      .then(data => {
          console.log('Session updated', data);
      })
      .catch(error => console.error('Error updating session', error));
}

// Thêm event listener cho gia_ghe
document.getElementById('gia_ghe').addEventListener('change', applyPromotion);

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount).replace('₫', 'VNĐ');
}

// Thêm input hidden vào form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if(form) {
        form.innerHTML += `
            <input type="hidden" name="final_price" id="final_price" value="0">
            <input type="hidden" name="discount_amount" id="discount_amount" value="0">
            <input type="hidden" name="promotion_id" id="promotion_id" value="">
        `;
    }
    // Gọi applyPromotion lần đầu để khởi tạo giá trị
    applyPromotion();
});

function validateForm() {
    const selectedSeats = document.querySelectorAll('.ghe.selected, .ghe-doi.selected');
    const errorDiv = document.getElementById('error-message');
    
    if (selectedSeats.length === 0) {
        errorDiv.textContent = 'Vui lòng chọn ít nhất một ghế trước khi tiếp tục';
        errorDiv.style.display = 'block';
        return false;
    }

    // Lưu thông tin vào session storage trước khi submit
    const formData = {
        danh_sach_ghe: document.getElementById('danh_sach_ghe').value,
        tong_tien_ghe: document.getElementById('tong_tien_ghe').value,
        promotion_id: document.getElementById('promotion_id').value,
        final_price: document.getElementById('final_price_input').value
    };
    
    sessionStorage.setItem('booking_data', JSON.stringify(formData));
    return true;
}
</script>

