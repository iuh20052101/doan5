<?php include "view/search.php"; ?>

<!-- Main content -->
<section class="container">
    <div class="col-sm-12">
        <h2 class="page-heading">Danh sách phim
            <span>Mới nhất</span>
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

                    <p class="movie__time"><?=$phim['thoi_luong_phim']?> Phút</p>
                    <p class="movie__option"><strong>Quốc gia: </strong><?=$phim['quoc_gia']?></p>
                    <p class="movie__option"><strong>Thể loại: </strong><?=$phim['name']?></p>
                    <p class="movie__option"><strong>Ngày phát hành: </strong><?=$phim['date_phat_hanh']?></p>
                    <p class="movie__option"><strong>Đạo diễn: </strong><?=$phim['daodien']?></p>
                    <p class="movie__option"><strong>Diễn viên: </strong><?=$phim['dienvien']?></p>
                    <p class="movie__option"><strong>Giới hạn độ tuổi: </strong><?=$phim['gia_han_tuoi']?></p>
                    
                    <div class="movie__btns">
                        <a href="<?=$book1?>" class="btn btn-md btn--warning">Đặt vé <span class="hidden-sm">ngay</span></a>
                    </div>

                    <div class="preview-footer">
                        <div class="movie__rate">
                            <div class="rating">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="movie__rating">5.0</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        <?php endforeach; ?>

        <?php if(count($dsp) > 0): ?>
        <div class="coloum-wrapper">
            <div class="pagination paginatioon--full">
                <a href='#' class="pagination__prev">prev</a>
                <a href='#' class="pagination__next">next</a>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            Không có phim nào!
        </div>
        <?php endif; ?>

    </div>
</section>

<div class="clearfix"></div>

<style>
/* Sử dụng lại style từ trang thể loại phim */
.page-heading {
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin-bottom: 45px;
    letter-spacing: 1.2px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
    position: relative;
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

.movie--preview {
    /* background: rgba(0, 0, 0, 0.9); */
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    position: relative;
    border-radius: 20px;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    margin-bottom: 35px;
    padding: 25px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

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

.movie--preview:hover {
    background: rgba(0, 0, 0, 0.95);
    box-shadow: 
        0 0 20px rgba(0, 219, 222, 0.3),
        0 0 40px rgba(252, 0, 255, 0.3);
    transform: translateY(-10px);
}

.movie__images {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.movie__images img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.movie__images:hover img {
    transform: scale(1.08);
}

.movie__title {
    font-size: 26px;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin: 15px 0;
    letter-spacing: 0.8px;
    line-height: 1.4;
    position: relative;
    display: inline-block;
}

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

.movie__option {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 12px;
    transition: all 0.3s ease;
    position: relative;
    padding-left: 20px;
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

.movie__option a {
    color: inherit;
    text-decoration: none;
}

.btn--warning {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border: none;
    padding: 14px 35px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
    color: #fff;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn--warning::before {
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

.btn--warning:hover::before {
    left: 100%;
}

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

.fa-star {
    color: #00dbde;
    filter: drop-shadow(0 0 5px rgba(0, 219, 222, 0.5));
    font-size: 18px;
    animation: starPulse 2s infinite;
}

@keyframes starPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.movie__rating {
    color: #fff;
    font-weight: 600;
}

.pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
    gap: 15px;
}
.movie {
    animation: fadeInUp 0.8s ease-out;
    /* background: rgba(18, 18, 18, 0.95); */
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
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
}

.pagination__prev:hover,
.pagination__next:hover {
    background: linear-gradient(45deg, #fc00ff, #00dbde);
    box-shadow: 0 8px 25px rgba(252, 0, 255, 0.5);
    transform: translateY(-3px);
}
</style>