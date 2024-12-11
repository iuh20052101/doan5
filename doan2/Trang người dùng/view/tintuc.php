<div class="col-sm-12 ">
    <h2 class="page-heading">Tin mới Nhất </h2>

    <div class="col-sm-4 similar-wrap col--remove" >
        <div class="post post--preview post--preview--wide">
            <div class="post__image">
                <img alt='' src="imgavt/nguoilangnghe.jpg">
              
            </div>
            <p class="post__date">6 tháng 10 năm 2024</p>
            <a href="single-page-left.html" class="post__title">"Người lắng nghe "</a><br>
            <a href="single-page-left.html" class="btn read-more post--btn">ĐỌC THÊM</a>
        </div>
    </div>
    <div class="col-sm-4 similar-wrap col--remove">
        <div class="post post--preview post--preview--wide">
            <div class="post__image">
                <img alt='' src="imgavt/nuhoangbanggia.jpg">
             
            </div>
            <p class="post__date">7 tháng 10 năm 2024 </p>
            <a href="single-page-left.html" class="post__title">Nữ hoàng băng giá</a><br>
            <a href="single-page-left.html" class="btn read-more post--btn">ĐỌC THÊM</a>
        </div>
    </div>
    <div class="col-sm-4 similar-wrap col--remove">
        <div class="post post--preview post--preview--wide">
            <div class="post__image">
                <img alt='' src="imgavt/vodiensatnhan.jpg">
             
            </div>
            <p class="post__date">8 tháng 10 năm 2024 </p>
            <a href="single-page-left.html" class="post__title">Vô diện sát nhân</a><br>
            <a href="single-page-left.html" class="btn read-more post--btn">ĐỌC THÊM</a>
        </div>
    </div>
</div>
<style>
/* Styling cho phần tin tức */
.page-heading {
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    margin-bottom: 30px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.post {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.post:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.post__image {
    width: 100%;
    height: 250px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 15px;
    position: relative;
}

.post__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.post:hover .post__image img {
    transform: scale(1.1);
}

.post__date {
    color: #00dbde;
    font-size: 14px;
    margin: 10px 0;
}

.post__title {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
    display: block;
    margin-bottom: 15px;
    transition: color 0.3s ease;
}

.post__title:hover {
    color: #fc00ff;
}

.read-more {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
    display: inline-block;
}

.read-more:hover {
    background: linear-gradient(45deg, #fc00ff, #00dbde);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
}

.social--position {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    padding: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.post:hover .social--position {
    opacity: 1;
}

.social__variant {
    color: white;
    text-decoration: none;
    font-size: 16px;
    transition: transform 0.3s ease;
}

.social__variant:hover {
    transform: scale(1.2);
}

/* Responsive */
@media (max-width: 768px) {
    .post__image {
        height: 200px;
    }
    
    .page-heading {
        font-size: 24px;
        text-align: center;
    }
}
</style>