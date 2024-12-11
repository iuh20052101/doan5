





<!-- Main content -->
<section class="container1">
    <div class="col-sm-12">
        <div class="movie">


            <?php
            extract($phim);
            $hinh = "imgavt/".$img;
            $book1 = "index.php?act=datve&id=".$id;
            ?>
            <h2 class="page-heading">Chi tiết phim</h2>
            <div class="movie__i">
                <div class="col-sm-4 col-md-3 movie-mobile">
                    <div class="movie__images">
                        <span class="movie__rating">5.0</span>
                        <img alt='' src="<?php echo $hinh?>"  style="width: 260.3px;height: 350px">

                    </div>
                </div>
                <div class="col-sm-8 col-md-9">
                    <p class="movie__option"> <a href="#"class="heading" style="font-size: 1.5vw ;"><?php echo $tieu_de?></a></p>
                    <p class="movie__option"> <?php echo $gia_ve?></a> VND</p>
                    <p class="movie__time"><?php echo $thoi_luong_phim?> Phút</p>
                    <p class="movie__option"><strong>Quốc Gia: </strong><a href="#"></a> <a href="#"><?php echo $quoc_gia?></a></p>
                    <p class="movie__option"><strong>Năm: </strong><a href="#">2023</a></p>
                    <p class="movie__option"><strong>Thể Loại: </strong><a href="#"><?php echo $name?></a></p>
                    <p class="movie__option"><strong>Ngày Phát Hành: </strong><?php echo $date_phat_hanh ?></</p>
                    <p class="movie__option"><strong>Đạo Diễn: </strong><a href="#"><?php echo $daodien ?></</a></p>
                    <p class="movie__option"><strong>Diễn Viên: </strong><a href="#"><?php echo $dienvien ?></</a>, <a href="#">...</a></p>
                    <p class="movie__option"><strong>Thời Lượng Phim: </strong><a href="#"><?php echo $thoi_luong_phim?> phút</a></p>
                    <p class="movie__option"><strong>Giới Hạn độ tuổi: </strong><a href="#"><?php echo $gia_han_tuoi?>+</a></p>

                    <div class="movie__btns movie__btns--full">
                        <a href="<?=$book1?>" class="btn btn-md btn--warning">Đặt ngay</a>
                    </div>

                </div>
            </div>

            <div class="clearfix"></div>

            <h2 class="page-heading">Mô Tả Phim</h2>

            <p class="movie__describe"><?=$mo_ta?></p>

            <h2 class="page-heading">Trailer</h2>

            <div class="movie__media">
                <div class="-switcmovie__mediah">
                    <a href="#"><?=$link_trailer?></a>
                </div>

            </div>


            <div class="binhluannew" id="binhluannew" > </div>
            </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#binhluannew").load("view/binhluan.php", {
                    id_phim: <?= $phim['id'] ?>

                });
            });
        </script>

        </div>
    </div>

</section>

<div class="clearfix"></div>





<style>
    .container1 {
    margin-top: 50px;
  
    padding: 0 15px;
}
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
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 35px;
    padding: 25px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.movie--preview:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 45px 0 rgba(31, 38, 135, 0.3);
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
}

.movie__title:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
}

.movie__option {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.movie__option:hover {
    padding-left: 5px;
    color: #00dbde;
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
}

.btn--warning:hover {
    background: linear-gradient(45deg, #fc00ff, #00dbde);
    box-shadow: 0 8px 25px rgba(252, 0, 255, 0.5);
    transform: translateY(-3px);
}

.movie__rate {
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 15px;
    display: inline-flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}

.fa-star {
    color: #00dbde;
    filter: drop-shadow(0 0 5px rgba(0, 219, 222, 0.5));
    font-size: 18px;
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

/* Hiệu ứng loading cho trang */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.movie {
    animation: fadeInUp 0.8s ease-out;
    background: rgba(18, 18, 18, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Hiệu ứng cho tiêu đề */
.page-heading {
    position: relative;
    overflow: hidden;
}

.page-heading::before {
    content: '';
    position: absolute;
    left: -100%;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #00dbde, #fc00ff, transparent);
    animation: slidingGlow 3s linear infinite;
}

@keyframes slidingGlow {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Hiệu ứng cho hình ảnh */
.movie__images {
    position: relative;
    overflow: hidden;
}

.movie__images::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transform: skewX(-25deg);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { left: -100%; }
    20% { left: 100%; }
    100% { left: 100%; }
}

/* Hiệu ứng cho nút đặt vé */
.btn--warning {
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.5s ease;
}

.btn--warning::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, #fc00ff, #00dbde);
    transition: all 0.5s ease;
    z-index: -1;
}

.btn--warning:hover::before {
    width: 100%;
}

/* Hiệu ứng cho thông tin phim */
.movie__option {
    position: relative;
    padding-left: 0;
    transition: all 0.3s ease;
}

.movie__option:hover {
    padding-left: 15px;
    background: linear-gradient(90deg, rgba(0,219,222,0.1), transparent);
    border-radius: 5px;
}

/* Hiệu ứng cho mô tả phim */
.movie__describe {
    position: relative;
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    padding: 20px;
    transition: all 0.3s ease;
}

.movie__describe:hover {
    background: rgba(255,255,255,0.08);
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

/* Hiệu ứng cho rating */
.movie__rating {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Hiệu ứng cho trailer */
.movie__media {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.movie__media:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.movie__media a {
    position: relative;
    display: inline-block;
    padding: 10px 20px;
    color: #fff;
    overflow: hidden;
    transition: all 0.3s ease;
}

.movie__media a:hover {
    color: #00dbde;
    text-shadow: 0 0 10px rgba(0,219,222,0.5);
}

/* Hiệu ứng hover cho links */
a {
    transition: all 0.3s ease;
}

a:hover {
    text-shadow: 0 0 10px rgba(252,0,255,0.5);
}
</style>