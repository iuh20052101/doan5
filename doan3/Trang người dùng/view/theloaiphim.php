<?php include "view/search.php"?>

<!-- Main content -->
<section class="container">
    <div class="col-sm-12">
        <h2 class="page-heading">Danh sách phim /
            <span><?=$ten_loai?></span>
        </h2>

        <!-- Movie preview item -->
        <?php foreach($dsp as $phim): ?>
            <?php
                $hinhpath = "imgavt/" . $phim['img'];
                $linkp = "index.php?act=ctphim&id=".$phim['id'];
                $book1 = "index.php?act=datve&id=".$phim['id'];
            ?>
            <div class="movie movie--preview movie--full comments">
                <div class="col-sm-3 col-md-2 col-lg-2">
                    <div class="movie__images">
                        <img src="<?=$hinhpath?>" alt="<?=$phim['tieu_de']?>">
                    </div>
                </div>

                <div class="col-sm-9 col-md-10 col-lg-10 movie__about">
                    <a href="<?=$linkp?>" class="movie__title link--huge"><?=$phim['tieu_de']?></a>

                    <p class="movie__time"><?=$phim['thoi_luong_phim']?> phút</p>
                    <p class="movie__option"><strong>Quốc gia: </strong><?=$phim['quoc_gia']?></p>
                    <p class="movie__option"><strong>Thể loại: </strong><?=$phim['name']?></p>
                    <p class="movie__option"><strong>Ngày phát hành: </strong><?=$phim['date_phat_hanh']?></p>
                    <p class="movie__option"><strong>Đạo diễn: </strong><?=$phim['daodien']?></p>
                    <p class="movie__option"><strong>Diễn viên: </strong><?=$phim['dienvien']?></p>
                    <p class="movie__option"><strong>Giới hạn độ tuổi: </strong><?=$phim['gia_han_tuoi']?></p>
                    
                    <div class="movie__btns">
                        <a href="<?=$book1?>" class="btn btn-md btn--warning">Đặt Vé <span class="hidden-sm">Xem phim</span></a>
                    </div>

                    <div class="preview-footer">
                        <div class="movie__rate">
                            <div class="rating">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <i class="fa-solid fa-star" style="color: #fbff00;"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="movie__rating">5.0</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!-- Time table -->
                <?php if(isset($phim['lich_chieu']) && !empty($phim['lich_chieu'])): ?>
                <div class="time-select">
                    <?php foreach($phim['lich_chieu'] as $rap): ?>
                        <div class="time-select__group">
                            <div class="col-sm-4">
                                <p class="time-select__place"><?=$rap['ten_rap']?></p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <?php foreach($rap['gio_chieu'] as $gio): ?>
                                    <li class="time-select__item" data-time="<?=$gio?>"><?=$gio?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <!-- end time table-->
            </div>
        <?php endforeach; ?>
        <!-- end movie preview item -->

        <?php if(count($dsp) > 0): ?>
        <div class="coloum-wrapper">
            <div class="pagination paginatioon--full">
                <a href='#' class="pagination__prev">prev</a>
                <a href='#' class="pagination__next">next</a>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            Không có phim nào thuộc thể loại này!
        </div>
        <?php endif; ?>

    </div>
</section>

<div class="clearfix"></div>
<style>
 /* Styling cho trang thể loại phim */
.page-heading {
    font-size: 38px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin-bottom: 45px;
    letter-spacing: 1.2px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
    position: relative;
    position: relative;
    text-shadow: 0 0 10px rgba(0, 219, 222, 0.5),
                 0 0 20px rgba(0, 219, 222, 0.3),
                 0 0 30px rgba(0, 219, 222, 0.1);
}

.page-heading span {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
    font-weight: 900;
}

.page-heading::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100px;
    height: 2px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
}

/* Card phim với màu sắc mới */
.movie--preview {
    background: rgba(0, 0, 0, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    border-radius: 20px;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 35px;
    padding: 25px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
}

.movie--preview:hover {
    background: rgba(0, 0, 0, 0.95);
    box-shadow: 
        0 0 20px rgba(0, 219, 222, 0.3),
        0 0 40px rgba(252, 0, 255, 0.3);
}

.movie--preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: -75%;
    z-index: 2;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        to right,
        rgba(255,255,255,0) 0%,
        rgba(255,255,255,.3) 100%
    );
    transform: skewX(-25deg);
    transition: 0.7s;
}

.movie--preview:hover::before {
    animation: shine 1s;
}

@keyframes shine {
    100% {
        left: 125%;
    }
}

/* Ảnh phim */
.movie__images {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    position: relative;
    transform-style: preserve-3d;
    perspective: 1000px;
}

.movie__images img {
    width: 100%;
    height: auto;
    transition: transform 0.5s ease;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.movie__images:hover img {
    transform: scale(1.08);
    transform: rotateY(10deg) scale(1.05);
}

.movie__images::before {
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
}

.movie__images:hover::before {
    opacity: 1;
}

/* Thông tin phim */
.movie__about {
    padding-left: 25px;
}

.movie__title {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin: 15px 0;
    letter-spacing: 0.8px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    text-decoration: none;
    display: block;
    background: linear-gradient(
        to right,
        #00dbde,
        #fc00ff,
        #00dbde
    );
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient 3s linear infinite;
    position: relative;
    display: inline-block;
}

.movie__title:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
}

.movie__time {
    font-size: 18px;
    color: #ff6b81;
    font-weight: 500;
    margin-bottom: 15px;
}

.movie__option {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 12px;
    transition: all 0.3s ease;
    padding-left: 20px;
    position: relative;
}

.movie__option::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #00dbde;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.movie__option:hover::before {
    opacity: 1;
    transform: translateX(0);
}

.movie__option strong {
    color: #fff;
    font-weight: 600;
    margin-right: 8px;
}
.movie {
    animation: fadeInUp 0.8s ease-out;
    background: rgba(18, 18, 18, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
/* Nút đặt vé */
.btn--warning {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border: none;
    padding: 14px 35px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
    transition: all 0.3s ease;
    color: #fff;
    animation: floating 3s ease-in-out infinite;
}

.btn--warning:hover {
    background: linear-gradient(45deg, #fc00ff, #00dbde);
    box-shadow: 0 8px 25px rgba(252, 0, 255, 0.5);
}

/* Rating */
.movie__rate {
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 15px;
    display: inline-flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
    position: relative;
}

.fa-star {
    font-size: 18px;
    color: #00dbde;
    filter: drop-shadow(0 0 5px rgba(0, 219, 222, 0.5));
    animation: starPulse 2s infinite;
}

@keyframes starPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.movie__rate::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 15px;
    padding: 2px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    animation: borderPulse 2s infinite;
}

@keyframes borderPulse {
    0% { opacity: 0.5; }
    50% { opacity: 1; }
    100% { opacity: 0.5; }
}

/* Lịch chiếu */
.time-select {
    background: rgba(0, 0, 0, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-top: 25px;
}

.time-select__place {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
}

.time-select__item {
    background: rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.time-select__item:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
}

.time-select__item::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease-out, height 0.6s ease-out;
}

.time-select__item:hover::after {
    width: 200%;
    height: 200%;
}

/* Phân trang */
.pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.pagination__prev,
.pagination__next {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    color: #fff;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 500;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.pagination__prev::before,
.pagination__next::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.3),
        transparent
    );
    transition: 0.5s;
}

.pagination__prev:hover::before,
.pagination__next:hover::before {
    left: 100%;
}

.pagination__prev:hover,
.pagination__next:hover {
    background: linear-gradient(45deg, #fc00ff, #00dbde);
    box-shadow: 0 8px 25px rgba(252, 0, 255, 0.5);
}

/* Alert */
.alert {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    font-size: 16px;
    margin: 30px 0;
}
.movie {
    animation: fadeInUp 0.8s ease-out;
    background: rgba(18, 18, 18, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .movie__about {
        padding-left: 0;
        margin-top: 20px;
    }
    
    .movie__title {
        font-size: 20px;
    }
    
    .time-select__item {
        padding: 6px 12px;
        font-size: 14px;
    }
}

/* Hiệu ứng glow cho movie options khi hover */
.movie__option:hover strong {
    text-shadow: 0 0 10px rgba(0, 219, 222, 0.8),
                 0 0 20px rgba(0, 219, 222, 0.4);
}

/* Hiệu ứng loading skeleton */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.movie--preview.loading {
    background: linear-gradient(
        90deg,
        rgba(255,255,255,0.05) 25%,
        rgba(255,255,255,0.1) 50%,
        rgba(255,255,255,0.05) 75%
    );
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}

/* Hiệu ứng glass morphism nâng cao */
.movie--preview {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 
        0 8px 32px 0 rgba(31,38,135,0.37),
        inset 0 0 80px rgba(255,255,255,0.05);
}

/* Hiệu ứng gradient border */
.movie--preview::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 2px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}

/* Hiệu ứng mới cho tiêu đề */
.movie__title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    transition: width 0.3s ease;
}

.movie__title:hover::after {
    width: 100%;
}
</style>