<!-- Slider -->
<div class="bannercontainer">
    <div class="banner">
        <ul>
            <li data-transition="fade" data-slotamount="8" class="slide">
                
            </li>
        </ul>
    </div>
</div> 
<div class="banner-slide">
        <div class="banner-slide__images">
            <div class="banner-slide__image">
            <img src="imgavt/banner1.jpg" alt="Ảnh 1">
            </div>
            <div class="banner-slide__image">
                <img src="imgavt/banner2.jpg" alt="Ảnh 2">
            </div>
            <div class="banner-slide__image">
                <img src="imgavt/banner3.jpg" alt="Ảnh 3">
            </div>
            <div class="banner-slide__image">
                <img src="imgavt/banner4.jpg" alt="Ảnh 4">
            </div>
            <div class="banner-slide__image">
                <img src="imgavt/banner5.jpg" alt="Ảnh 5">
            </div>
            <div class="banner-slide__image">
                <img src="imgavt/banner7.jpg" alt="Ảnh 6">
            </div>
       
        
        </div>

        <div class="banner-slide__nav">
            <button class="banner-slide__nav-btn prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="banner-slide__nav-btn next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="banner-slide__controls">
            <div class="banner-slide__control active" data-index="0"></div>
            <div class="banner-slide__control" data-index="1"></div>
            <div class="banner-slide__control" data-index="2"></div>
            <div class="banner-slide__control" data-index="3"></div>
            <div class="banner-slide__control" data-index="4"></div>
            <div class="banner-slide__control" data-index="5"></div>
        
            
         
        </div>
    </div>
    <script>
        const bannerSlide = document.querySelector('.banner-slide');
const images = document.querySelectorAll('.banner-slide__image');
const controls = document.querySelectorAll('.banner-slide__control');
const prevBtn = document.querySelector('.banner-slide__nav-btn.prev');
const nextBtn = document.querySelector('.banner-slide__nav-btn.next');

let activeIndex = 0;
let intervalId;

function updateImage() {
    images.forEach(image => {
        image.classList.remove('active');
    });
    images[activeIndex].classList.add('active');

    controls.forEach(control => {
        control.classList.remove('active');
    });
    controls[activeIndex].classList.add('active');
}

function nextImage() {
    activeIndex = (activeIndex + 1) % images.length;
    updateImage();
}

function prevImage() {
    activeIndex = (activeIndex - 1 + images.length) % images.length;
    updateImage();
}

function startAutoSlide() {
    intervalId = setInterval(nextImage, 5000);
}

function stopAutoSlide() {
    clearInterval(intervalId);
}

// Event listeners
controls.forEach((control, index) => {
    control.addEventListener('click', () => {
        activeIndex = index;
        updateImage();
        stopAutoSlide();
        startAutoSlide();
    });
});

prevBtn.addEventListener('click', () => {
    prevImage();
    stopAutoSlide();
    startAutoSlide();
});

nextBtn.addEventListener('click', () => {
    nextImage();
    stopAutoSlide();
    startAutoSlide();
});

bannerSlide.addEventListener('mouseover', stopAutoSlide);
bannerSlide.addEventListener('mouseout', startAutoSlide);

// Initialize
updateImage();
startAutoSlide();

    </script>


<style>
    /*banner*/
.banner-slide {
    width: 100%;
    height: 600px;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* Styling cho phần chứa ảnh */
.banner-slide__images {
    width: 100%;
    height: 100%;
    position: relative;
}

/* Styling cho từng ảnh */
.banner-slide__image {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.8s ease;
}

.banner-slide__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.1);
    transition: transform 8s ease;
}

/* Hiệu ứng zoom khi ảnh active */
.banner-slide__image.active {
    opacity: 1;
}

.banner-slide__image.active img {
    transform: scale(1);
}

/* Overlay gradient cho banner */
.banner-slide__image::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        0deg,
        rgba(0,0,0,0.7) 0%,
        rgba(0,0,0,0.4) 50%,
        rgba(0,0,0,0.2) 100%
    );
}

/* Styling cho nút điều khiển */
.banner-slide__controls {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    z-index: 10;
}

.banner-slide__control {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.banner-slide__control:hover {
    background: rgba(255,255,255,0.8);
    transform: scale(1.2);
}

.banner-slide__control.active {
    background: #fff;
    width: 30px;
    border-radius: 10px;
    border-color: rgba(255,255,255,0.3);
}

/* Thêm nút prev/next */
.banner-slide__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    z-index: 10;
}

.banner-slide__nav-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(5px);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.banner-slide__nav-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}

/* Animation cho chuyển đổi slide */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(1.1); }
    to { opacity: 1; transform: scale(1); }
}

.banner-slide__image.active {
    animation: fadeIn 0.8s ease forwards;
}

</style>
