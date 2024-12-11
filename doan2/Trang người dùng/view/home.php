<?php include "banner.php"?>

<section class="container1">
    <h2 id='target' class="page-heading heading--outcontainer">Phim hot nhất</h2><br>
    <div class="movie-best">
        <div class="">
            <?php foreach ($loadphimhot as $hot){
                extract($hot);
                $linkp = "index.php?act=ctphim&id=".$id;
                $hinh = "imgavt/".$img;
                echo '<div class="movie-beta__item">
                        <div class="movie__image-container">
                            <img alt="lỗi" src="'.$hinh.'" width="250" height="300">
                        </div>
                        <span class="best-rate">5.0</span>
                        <ul class="movie-beta__info">
                            <li><span class="best-voted">Đã có '.$tong_so_ve.' vé đã đặt</span></li>
                            <li>
                                <p class="movie__time">'.$thoi_luong_phim.' phút</p>
                                <p>'.$name.'</p>
                            </li>
                            <li class="last-block">
                                <a href="'.$linkp. '" class="slide__link">Chi tiết</a>
                            </li>
                        </ul>
                    </div>';
            } ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <h2 id='target' class="page-heading heading--outcontainer1">Phim mới nhất</h2>
    
    <div class="col-sm-12">
        <div class="row">
            <section class="container movie-container">
                <?php foreach ($loadphimhome as $phim) {
                    extract($phim);
                    $hinh = "imgavt/".$img;
                    $linkp = "index.php?act=ctphim&id=".$id;
                    echo '<div class="movie movie--test movie--test--dark movie--test--left">
                            <div class="movie__images">
                                <a href="'.$linkp.'" class="movie-beta__link">
                                    <img alt="lỗi" src="'.$hinh.'" width="250" height="350">
                                </a>
                            </div>
                            <div class="movie__info">
                                <p class="movie__title"><a href="'.$linkp.'">'.$tieu_de.'</a></p>
                                <p class="movie__time">Thời Lượng Phim: '.$thoi_luong_phim.' phút</p>
                                <p class="movie__option">Thể Loại: '.$name.'</p>
                                <div class="movie__rate">
                                    <span class="movie__rating">4.9</span>
                                </div>
                            </div>
                        </div>';
                } ?>
            </section>

            <div class="row">
                <div class="social-group">
                    <div class="col-sm-6 col-md-4 col-sm-push-6 col-md-push-4">
                        <div class="social-group__head">Rapper đập phá <br><p style="padding: 5px;font-size: 2vw;"></p></div>
                        <div class="social-group__content">Wreck-It Ralph 2: Phá đảo thế giới ảo (tên gốc tiếng Anh: Wreck-It Ralph 2: Breaks the Internet) là phim điện ảnh hoạt hình hài hước 3D của Mỹ năm 2024 do Walt Disney Animation Studios sản xuất và Walt Disney Studios Motion Pictures chịu trách nhiệm phân phối. Tác phẩm là phim điện ảnh hoạt hình thứ 57 do hãng sản xuất, đồng thời cũng là phần tiếp theo của Ráp-phờ đập phá (2012). <br class="hidden-xs"><br></div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-sm-pull-6 col-md-pull-4">
                        <div class="facebook-group">
                            <img src="imgavt/rapperdappha.jpg" alt="" height="400px" width="340px;">
                        </div>
                    </div>
                    <div class="clearfix visible-sm"></div>
                </div>
            </div>
        </div>
    </div>
    <div><h2 class="meet-team-title">
               </h2></div><br>
    <div><h2 class="meet-team-title">
           ***   </h2></div><br>
        <div class="aboutus-back" style="background-image: url('imgavt/gioithieu1.jpg');">
    <div class="aboutus-content">
        
        <h1 class="aboutus-title">GIỚI THIỆU VỀ TIAMS</h1>
        <div class="aboutus-para">
            Sứ mệnh: Biến ý tưởng thành hiện thực, tạo ra những trải nghiệm phim độc đáo và không thể quên cho mọi khách hàng.
        </div>
    </div>
</div>
<div class="aboutus-back2" style="background-image: url('imgavt/gioithieu2.jpeg');">
    <div class="position-content">
        <div class="aboutus-para2">
            Chất lượng & Chuyên nghiệp: Đội ngũ chuyên viên giàu kinh nghiệm, cam kết dịch vụ chất lượng và chuyên nghiệp cho từng suất chiếu.
        </div>
    </div>
</div>
<div class="aboutus-back3" style="background-image: url('imgavt/gioithieu3.jpg');">
    <div class="position-content1">
        <div class="aboutus-para3">
            Đa dạng & Linh hoạt: Cung cấp các gói dịch vụ đa dạng, linh hoạt, đáp ứng mọi nhu cầu và mong muốn của khách hàng.
        </div>
    </div>
</div>

<div class="terms-conditions">
            <h2 class="terms-title">Quy định</h2>
            <div class="terms">
                <ol class="list">
                    
                    <li class="each-term">Trẻ em phải đi cùng người lớn hoặc có sự giám hộ từ phụ huynh hoặc người giám hộ phù hợp.</li>
                    <li class="each-term">Các vật dụng nguy hiểm như dao, vũ khí, hoặc bất kỳ vật phẩm nào có thể gây nguy hiểm đều bị cấm.</li>
                    <li class="each-term">Cấm mang thức ăn và nước uống từ bên ngoài vào rạp. Có các quầy bán đồ ăn và nước uống trong nhà hát để phục vụ khách hàng.</li>
                    <li class="each-term">Cấm hành vi gây rối trong suốt sự kiện.</li>
                    <li class="each-term">Không thể hủy vé sau khi đã thanh toán vé.</li>
                </ol>
            </div>
        </div>
    
    <?php include "view/tintuc.php"?>
    
</section>

<div class="clearfix"></div>
<style>.aboutus-back{
    background-image: url('../imgavt/đi\ tìm\ nemo.jpeg');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center;
    background-size:1400px 600px;
    padding-bottom:400px;
    padding-top:150px;
    padding-left:50px;
}
.aboutus-back2{
    background-image: url('../img/aboutus/aboutus2.jpg');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center;
    background-size:1400px 600px;
    padding-bottom:400px;
}
.aboutus-back3{
    background-image: url('../img/aboutus/aboutus4.jpg');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center;
    background-size:1400px 600px;
    padding-bottom:400px;
    padding-left:30px;
}
.aboutus-content{
    color:white;
    font-size:10px;
}
.aboutus-title{
    font-family: 'oswald';
    font-size:60px;
    font-weight: bolder;
    text-shadow:
      0 0 12px black,
      0 0 30px black,
      0 0 11px black,
      0 0 22px black,
      0 0 3px black;
}
.aboutus-para{
    margin-top:500px;
    font-family: 'oswald';
    background-color: rgba(31, 29, 29, 0.336);
    font-size: 30px;
    width:500px;
    text-align: center;
}
.aboutus-para2{   
    font-family: 'oswald';
    background-color: rgba(5, 5, 5, 0.545);
    font-size: 30px;
    width:500px;
    text-align: center;
    color:white;
    text-align: center;
}
.aboutus-para3{
    font-family: 'oswald';
    background-color: rgba(5, 5, 5, 0.545);
    font-size: 30px;
    width:500px;
    text-align: center;
    color:white;
    text-align: center;
}
.position-content{
    padding-top:500px;
    padding-left:550px;
}
.terms-conditions{
    background-color: black;
    margin-top:20px;
    padding-top:2px;
    padding-bottom:30px;
}
.terms-title{
 
    margin-top:40px;
    color:white;
    margin-left:10px;
    font: 20px 'aleobold', sans-serif;
}
.each-term{
    color:white;
    margin-left:60px;
    margin-top:20px;
    font: 20px 'aleobold', sans-serif;
    
}</style>

<!-- Phần tiêu đề -->
<div class="reward-title-section">
    <h2>Đổi điểm thưởng</h2>
    <?php if(isset($_SESSION['user'])): 
        // Lấy điểm trực tiếp từ database để kiểm tra
        $diem = get_diem_tich_luy($_SESSION['user']['id']);
    ?>
        <div class="user-points">
            <i class="fas fa-coins"></i>
            <span>Điểm của bạn: <?= number_format($diem) ?> điểm</span>
        </div>
        <!-- Debug -->
        <div style="display:none;">
            <?php
            echo "Điểm từ DB: " . $diem . "<br>";
            echo "Điểm từ Session: " . $_SESSION['user']['diem_tich_luy'];
            ?>
        </div>
    <?php endif; ?>
</div>

<!-- Phần khuyến mãi -->
<section class="promotion-section">
    <div class="promotion-container">
        <?php
        $khuyenmai_list = loadall_khuyenmai_available();
        if(isset($khuyenmai_list) && is_array($khuyenmai_list)) {
            foreach ($khuyenmai_list as $km) {
                extract($km);
                $disabled = '';
                $btn_text = 'Đổi ngay';
                $btn_class = 'primary';
                
                if(isset($_SESSION['user'])) {
                    if(check_user_promotion($_SESSION['user']['id'], $id)) {
                        $disabled = 'disabled';
                        $btn_text = 'Đã đổi';
                        $btn_class = 'disabled';
                    }
                }
                
                echo '<div class="promotion-card">
                        <div class="promotion-ribbon">
                            <span>'.number_format($gia_tri).' điểm</span>
                        </div>
                        <div class="promotion-content">
                            <div class="promotion-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h3 class="promotion-title">'.$ten_km.'</h3>
                            <div class="promotion-details">
                                <p class="promotion-desc">'.$mota.'</p>
                                <div class="promotion-meta">
                                    <span class="expiry-date">
                                        <i class="far fa-calendar-alt"></i>
                                        Hết hạn: '.date('d/m/Y', strtotime($ngay_ket_thuc)).'
                                    </span>
                                </div>
                            </div>
                            <button class="promotion-btn '.$btn_class.'" 
                                    onclick="doiDiem('.$id.', '.$gia_tri.')"
                                    '.($disabled ? 'disabled' : '').'>
                                <i class="fas fa-exchange-alt"></i>
                                '.$btn_text.'
                            </button>
                        </div>
                    </div>';
            }
        }
        ?>
    </div>
</section>

<style>
/* Reset một số style mặc định */
.reward-title-section {
    text-align: center;
    padding: 40px 0 20px;
    background: #8080;
}

.reward-title-section h2 {
    color: #1a1a1a;
    font-size: 2em;
    font-weight: 600;
    margin-bottom: 15px;
    letter-spacing: 1px;
}

.user-points {
    display: inline-flex;
   
    padding: 12px 30px;
    border-radius: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    align-items: center;
    gap: 12px;
    margin: 15px 0;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.4;
    font-family: 'Montserrat', sans-serif !important;
}

.user-points i {
    color: #ffd700;
    font-size: 1.5em;
    
}

.user-points span {
    color: #333;
    font-weight: 600;
    font-size: 1.2em;
}

.promotion-section {
    padding: 40px 0;
    background: #8080;
}

.promotion-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.promotion-card {
    background: #4a3228;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.1);
}

.promotion-content {
    position: relative;
    padding: 25px;
    background-color: rgba(139, 69, 19, 0.15);
    background-image: 
        linear-gradient(45deg, rgba(160, 82, 45, 0.1) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(160, 82, 45, 0.1) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, rgba(160, 82, 45, 0.1) 75%),
        linear-gradient(-45deg, transparent 75%, rgba(160, 82, 45, 0.1) 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
    border: 1px solid rgba(139, 69, 19, 0.2);
}

.promotion-ribbon {
    position: absolute;
    top: -10px;
    right: 10px;
    padding: 8px 15px;
    background: #D2691E;
    color: white;
    font-size: 0.9em;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 0 0 5px 5px;
}

.promotion-ribbon::before,
.promotion-ribbon::after {
    content: '';
    position: absolute;
    top: 0;
    border-style: solid;
}

.promotion-ribbon::before {
    left: -10px;
    border-width: 0 10px 10px 0;
    border-color: transparent #8B4513 transparent transparent;
}

.promotion-ribbon::after {
    right: -10px;
    border-width: 0 0 10px 10px;
    border-color: transparent transparent transparent #8B4513;
}

.promotion-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;
    background: #8B4513;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255,255,255,0.2);
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.promotion-icon:hover {
    transform: scale(1.05);
    background: #A0522D;
}

.promotion-icon i {
    font-size: 30px;
    color: #FFE4B5;
}

.promotion-title {
    color: #fff;
    background: rgba(74, 50, 40, 0.9);
    border-bottom: 2px dashed rgba(255,255,255,0.2);
    font-size: 1.3em;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding: 10px;
    border-radius: 8px;
}

.promotion-desc {
    color: #fff;
    background: rgba(74, 50, 40, 0.9);
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95em;
    padding: 10px;
    border-radius: 8px;
}

.promotion-meta {
    background: rgba(74, 50, 40, 0.9);
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.expiry-date {
    color: #fff;
    font-size: 0.9em;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.promotion-btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #8B4513;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 1px solid rgba(255,255,255,0.2);
}

.promotion-btn:hover {
    background: #A0522D;
}

.promotion-btn.disabled {
    background: #ccc;
    cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .promotion-container {
        grid-template-columns: 1fr;
        padding: 15px;
    }
}

/* Hiệu ứng 3D cho phim hot */
.movie-beta__item {
    transform-style: preserve-3d;
    perspective: 1000px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: pointer;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Hiệu ứng hover chính */
.movie-beta__item:hover {
    transform: scale(1.15) rotateY(10deg);
    box-shadow: -20px 20px 30px rgba(0,0,0,0.4);
    z-index: 100;
}

/* Hiệu ứng ánh sáng chạy qua */
.movie__image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: -150%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to right,
        transparent,
        rgba(255,255,255,0.8),
        transparent
    );
    transform: skewX(-25deg);
    animation: shine 3s infinite;
    z-index: 1;
}

@keyframes shine {
    100% {
        left: 150%;
    }
}

/* Hiệu ứng viền sáng */
.movie-beta__item::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #ff4e50, #f9d423, #00ff00, #00ffff);
    z-index: -1;
    animation: borderGlow 3s linear infinite;
    border-radius: 15px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.movie-beta__item:hover::after {
    opacity: 1;
}

@keyframes borderGlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Hiệu ứng cho rating */
.best-rate {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, #ff4e50, #f9d423);
    padding: 10px;
    border-radius: 50%;
    animation: pulseRating 2s infinite;
    z-index: 2;
    box-shadow: 0 0 10px rgba(255,78,80,0.5);
}

@keyframes pulseRating {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255,78,80,0.7);
    }
    70% {
        transform: scale(1.1);
        box-shadow: 0 0 0 15px rgba(255,78,80,0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255,78,80,0);
    }
}

/* Hiệu ứng cho thông tin phim */
.movie-beta__info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.8);
    padding: 15px;
    transform: translateY(100%);
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(5px);
}




/* Hiệu ứng cho nút chi tiết */
.slide__link {
    display: inline-block;
    padding: 8px 20px;
    background: linear-gradient(45deg, #ff4e50, #f9d423);
    border-radius: 25px;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    z-index: 1;
}

.slide__link:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255,78,80,0.4);
}





@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}



.movie__images {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.movie__title a {
    color: #333;
    font-size: 1.1em;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.movie__title a:hover {
    color: #e53637;
}

.movie__info {
    padding: 15px;
}

.movie__time,
.movie__option {
    color: #666;
    font-size: 0.9em;
    margin: 5px 0;
}

.movie__rating {
    color: #e53637;
    font-weight: bold;
}



/* Styling cho section giới thiệu phim */
.social-group {
   
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 30px;
    margin: 30px 0;
    transition: all 0.4s ease;
    position: relative;
    z-index: 1;
}

.social-group:hover {
    transform: translateY(-5px);
}

.social-group__head {
    font-size: 32px !important;
    font-weight: 800 !important;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin-bottom: 20px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.4;
    font-family: 'Montserrat', sans-serif !important;
}

.social-group__content {
    color: rgba(255, 255, 255, 0.9) !important;
    font-size: 16px !important;
    line-height: 1.8 !important;
    text-align: justify !important;
    padding: 15px 0 !important;
    font-family: 'Quicksand', sans-serif !important;
}

.facebook-group {
    position: relative !important;
    border-radius: 15px !important;
    overflow: hidden !important;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
}

.facebook-group img {
    width: 100% !important;
    height: 400px !important;
    object-fit: cover !important;
    border-radius: 15px !important;
    transition: transform 0.5s ease !important;
}

.facebook-group:hover img {
    transform: scale(1.05) !important;
}
/* 
/* Thêm overlay khi hover ảnh */
.facebook-group::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.3) 100%
    );
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 15px;
    z-index: 2;
} */

.facebook-group:hover::before {
    opacity: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .social-group__head {
        font-size: 24px !important;
        text-align: center !important;
    }
    
    .social-group__content {
        font-size: 14px !important;
        padding: 10px !important;
    }
    
    .facebook-group img {
        height: 300px !important;
    }
}

/* Styling cho phần quy định */
.terms-conditions {
    background: black;
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 30px 40px;
    margin: 40px 0;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.terms-title {
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin-bottom: 25px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
}

.terms {
    padding: 20px;
}

.list {
    counter-reset: terms-counter;
    list-style: none;
    padding: 0;
}

.each-term {
    color: #ffffff;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 20px;
    padding: 15px 20px 15px 50px;
    position: relative;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.each-term:hover {
    transform: translateX(10px);
    background: rgba(255, 255, 255, 0.1);
}

.each-term::before {
    counter-increment: terms-counter;
    content: counter(terms-counter);
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    width: 25px;
    height: 25px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .terms-conditions {
        padding: 20px;
        margin: 20px 0;
    }

    .terms-title {
        font-size: 24px;
    }

    .each-term {
        font-size: 14px;
        padding: 12px 15px 12px 40px;
    }

    .each-term::before {
        width: 20px;
        height: 20px;
        font-size: 12px;
    }
}

</style>

<script>
function doiDiem(id, giaTri) {
    if(!confirm('Bạn có chắc muốn đổi ' + giaTri + ' điểm cho khuyến mãi này?')) {
        return;
    }
    
    fetch('index.php?act=doi_diem', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_km: id
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            alert('Đổi điểm thành công!');
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xử lý yêu cầu');
    });
}

function updateUserPoints() {
    fetch('index.php?act=get_points')
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById('diem_tich_luy').textContent = data.points;
            location.reload();
        }
    })
    .catch(error => console.error('Error updating points:', error));
}
</script>

<!-- Đảm bảo biểu tượng hiển thị bằng cách thêm font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Thêm vào phần head của trang -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
      duration: 800,
      once: true,
      offset: 100
    });
  });
</script>

<script>
document.querySelectorAll('.movie--test').forEach(card => {
    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width/2;
        const y = e.clientY - rect.top - rect.height/2;
        
        const multiplier = 20;
        const rotateX = y / multiplier;
        const rotateY = -x / multiplier;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05,1.05,1.05)`;
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1,1,1)';
    });
});
</script>
