<?php 

extract($phim);
?>

<div class="container1" style="height: auto; width: 100%; margin-bottom: 20px;">
    <section class="container1">
        <!-- Phần header -->
        <div class="order-container">
            <div class="order">
                <img class="order__images" alt='' src="images/tickets.png">
                <p class="order__title1">Đặt vé <br><span class="order__descript">Tận Hưởng Thời Gian Xem Phim Vui Vẻ</span></p>
            </div>
        </div>
        <br>
        <div class="order-step-area">
            <div class="order-step first--step">1 Chọn Lịch Chiếu &amp; Thời Gian</div>
        </div>
        <h2 class="page-heading heading--outcontainer">Phim Bạn Chọn</h2>

        <!-- Phần chọn phim -->
        <div class="movie-selected">
            <div class="movie-selected__info">
                <div class="movie-selected__title">
                    <strong>Phim Đã Chọn:</strong>
                    <span class="movie-name"><?=$tieu_de?></span>
                </div>
                <?php if(isset($phim['hinh']) && $phim['hinh'] != ""): ?>
                    <div class="movie-selected__poster">
                        <img src="<?=$phim['hinh']?>" alt="<?=$tieu_de?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-sm-12">
            <!-- <div class="choose-indector choose-indector--film">
                <strong>Phim Đã Chọn </strong><span class="choosen-area"><?=$tieu_de?></span>
            </div> -->

            <!-- Phần chọn rạp và bản đồ -->
            <h2 class="page-heading">Chọn Rạp Gần Bạn</h2>
            <div class="row" style="display: flex; flex-wrap: wrap;">
                <div class="col-md-8" style="flex: 2;">
                    <div id="map" style="height: 600px; width: 100%; margin-bottom: 20px;"></div>
                </div>
                <div class="col-md-4" style="flex: 1;">
                    <div class="theater-list" style="height: 600px; overflow-y: auto;">
                        <?php foreach($loadrap as $rap): ?>
                            <a href="index.php?act=datve&id=<?=$id?>&rap_id=<?=$rap['id']?>" 
                               class="theater-item <?= isset($_GET['rap_id']) && $_GET['rap_id'] == $rap['id'] ? 'active' : '' ?>"
                               data-theater-id="<?=$rap['id']?>"
                               onclick="selectTheater(event, <?=$rap['id']?>)">
                                <h4><?=$rap['tenrap']?></h4>
                                <p><?=$rap['dia_chi']?></p>
                                <span class="distance"></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <h2 class="page-heading">Chọn lịch chiếu</h2>
            <div class="choose-container choose-container--short">
                <?php
                if (empty($lc)) {
                    echo '<div class="alert alert-info">Không có lịch chiếu cho phim này.</div>';
                } else {
                    $current_date = '';
                    $current_datetime = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại đầy đủ
                    
                    foreach ($lc as $l) {
                        $ngay_chieu = strtotime($l['ngay_chieu']);
                        $date = date('Y-m-d', $ngay_chieu);
                        
                        // Kiểm tra ngày chiếu
                        if ($date < date('Y-m-d')) {
                            continue; // Bỏ qua các ngày đã qua
                        }
                        
                        // Nhóm các lịch chiếu theo ngày
                        if ($date != $current_date) {
                            if ($current_date != '') echo '</div>';
                            $current_date = $date;
                            echo '<div class="date-group">';
                        }
                        ?>
                        <a href="index.php?act=datve&id=<?=$id?>&rap_id=<?=$l['rap_id']?>&id_lc=<?=$l['id']?>" 
                           class="time-slot <?= isset($_GET['id_lc']) && $_GET['id_lc'] == $l['id'] ? 'active' : '' ?>">
                            <div class="time-block">
                                <?= date('d/m/Y', $ngay_chieu) ?>
                            </div>
                        </a>
                        <?php
                    }
                    if (!empty($lc)) {
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <?php if (!empty($khunggio)): ?>
            <h2 class="page-heading">Chọn Thời gian chiếu</h2>
            <div class="time-select time-select--wide">
                <div class="time-s">
                    <?php 
                    $current_time = time();
                    $available_shows = false;

                    foreach ($khunggio as $g): 
                        // Lấy thông tin phòng chiếu
                        $phong_info = lay_thong_tin_phong($g['id_phong']);
                        
                        // Lấy ngày chiếu và tạo datetime đầy đủ
                        $ngay_chieu = date('Y-m-d', strtotime($g['ngay_chieu']));
                        $show_datetime = strtotime($ngay_chieu . ' ' . $g['thoi_gian_chieu']);
                        
                        // Chỉ hiển thị suất chiếu trong tương lai
                        if ($show_datetime > $current_time):
                            $available_shows = true;
                    ?>
                        <a href="index.php?act=datve2&id=<?=$id?>&id_lc=<?=$g['id_lich_chieu']?>&id_g=<?=$g['id']?>&id_phong=<?=$g['id_phong']?>" 
                           class="time-select__item <?= isset($_GET['id_g']) && $_GET['id_g'] == $g['id'] ? 'active' : '' ?>">
                            <?=$g['thoi_gian_chieu']?><br>
                            <small>Phòng: <?=$phong_info['name']?></small>
                        </a>
                    <?php 
                        endif;
                    endforeach;
                    
                    if (!$available_shows) {
                        echo '<div class="alert alert-info">Không có suất chiếu nào kh dụng cho ngày hôm nay.</div>';
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="clearfix"></div>
</div>

<script>
let map, userMarker, infoWindow;
const theaters = <?php echo json_encode($loadrap); ?>;

function initMap() {
    // Khởi tạo bản đồ
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: { lat: 10.7757, lng: 106.7004 },
        mapTypeControl: true,
        fullscreenControl: true,
        streetViewControl: true,
        zoomControl: true
    });

    infoWindow = new google.maps.InfoWindow();

    // Thêm markers cho các rạp
    theaters.forEach(theater => {
        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(theater.lat),
                lng: parseFloat(theater.lng)
            },
            map: map,
            title: theater.tenrap,
            label: {
                text: theater.tenrap,
                color: '#FFFFFF',
                fontSize: '12px',
                fontWeight: 'bold',
                className: 'marker-label'
            },
            icon: {
                url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                scaledSize: new google.maps.Size(40, 40),
                labelOrigin: new google.maps.Point(20, -10)
            },
            animation: google.maps.Animation.DROP
        });

        // Tạo nội dung cho InfoWindow
        const content = `
            <div style="padding: 15px; max-width: 300px;">
                <h4 style="margin: 0 0 10px; color: #333;">${theater.tenrap}</h4>
                <p style="margin: 0 0 10px; color: #666;">
                    ${theater.dia_chi}
                </p>
                <a href="index.php?act=datve&id=<?=$id?>&rap_id=${theater.id}" 
                   class="btn btn-primary btn-sm">
                    Chọn rạp này
                </a>
                <button onclick="getDirections(${theater.lat}, ${theater.lng})" 
                        class="btn btn-info btn-sm ml-2">
                    Chỉ đường
                </button>
            </div>
        `;

        // Thêm sự kiện click cho marker
        marker.addListener('click', () => {
            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        });
    });

    // Lấy vị trí người dùng
    if (navigator.geolocation) {
        // Thêm thông báo để debug
        console.log('Đang yêu cầu vị trí...');
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                try {
                    console.log('Đã nhận được vị trí:', position.coords);
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Kiểm tra và hiển thị tọa độ nhận được
                    console.log('Tọa độ:', pos);

                    if (isNaN(pos.lat) || isNaN(pos.lng)) {
                        throw new Error('Tọa độ không hợp lệ');
                    }

                    // Hiển thị marker vị trí người dùng
                    if (userMarker) userMarker.setMap(null); // Xóa marker cũ nếu có
                    
                    userMarker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: {
                            url: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            scaledSize: new google.maps.Size(40, 40)
                        },
                        title: 'Vị trí của bạn',
                        animation: google.maps.Animation.DROP
                    });

                    // Di chuyển map đến vị trí người dùng với animation
                    map.panTo(pos);
                    map.setZoom(15);
                    
                    calculateDistances(pos);
                    
                    // Thông báo thành công
                    console.log('Đã đặt marker vị trí thành công');
                    
                } catch (err) {
                    console.error('Lỗi xử lý vị trí:', err);
                    alert('Có lỗi khi xử lý vị trí của bạn: ' + err.message);
                }
            },
            (error) => {
                console.error('Mã lỗi:', error.code);
                console.error('Thông báo lỗi:', error.message);
                
                let errorMessage = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Bạn đã từ chối cho phép truy cập vị trí. Vui lòng vào cài đặt trình duyệt để cấp quyền và thử lại.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Không thể lấy được thông tin vị trí. Vui lòng kiểm tra kết nối mạng và GPS.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Quá thời gian chờ lấy vị trí. Vui lòng thử lại.';
                        break;
                    default:
                        errorMessage = 'Đã xảy ra lỗi không xác định: ' + error.message;
                }
                alert(errorMessage);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        alert('Trình duyệt của bạn không hỗ trợ định vị. Vui lòng sử dụng trình duyệt khác.');
    }
}

function calculateDistances(userPos) {
    theaters.forEach(theater => {
        const theaterPos = new google.maps.LatLng(
            parseFloat(theater.lat), 
            parseFloat(theater.lng)
        );
        const distance = google.maps.geometry.spherical.computeDistanceBetween(
            new google.maps.LatLng(userPos.lat, userPos.lng),
            theaterPos
        );
        const distanceKm = (distance / 1000).toFixed(1);
        
        // Cập nhật khoảng cách vào DOM
        const theaterElement = document.querySelector(`[data-theater-id="${theater.id}"]`);
        if (theaterElement) {
            theaterElement.querySelector('.distance').textContent = `${distanceKm} km`;
        }
    });
}

function getDirections(lat, lng) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const origin = `${position.coords.latitude},${position.coords.longitude}`;
                const destination = `${lat},${lng}`;
                window.open(
                    `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}`,
                    '_blank'
                );
            }
        );
    }
}

function selectTheater(event, theaterId) {
    // Ngăn chặn hành vi mặc định của thẻ a
    event.preventDefault();
    
    // Chuyển hướng đến URL mới
    window.location.href = `index.php?act=datve&id=<?=$id?>&rap_id=${theaterId}`;
}

// Thêm hàm xử lý lỗi chi tiết
function handleLocationError(error) {
    let errorMessage = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            errorMessage = 'Người dùng từ chối cấp quyền truy cập vị trí.';
            break;
        case error.POSITION_UNAVAILABLE:
            errorMessage = 'Không thể lấy được thông tin vị trí.';
            break;
        case error.TIMEOUT:
            errorMessage = 'Yêu cầu vị trí đã hết thời gian chờ.';
            break;
        default:
            errorMessage = 'Đã xảy ra lỗi không xác định.';
            break;
    }
    console.error('Lỗi định vị:', errorMessage);
    // Có thể hiển thị thông báo cho người dùng
    alert('Không thể lấy vị trí của bạn: ' + errorMessage);
}

// Khởi tạo bản đồ
google.maps.event.addDomListener(window, 'load', initMap);
</script>

<style>
.theater-list {
    padding: 10px;
    background: rgba(0, 0, 0, 0.8);
    border-radius: 10px;
}

.theater-item {
    display: block;
    padding: 15px;
    margin-bottom: 10px;
    background: linear-gradient(45deg, #2c2c2c, #3d3d3d);
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.theater-item:hover,
.theater-item.active {
    background: linear-gradient(45deg, #ffd564, #ff9f1a);
    color: #000;
    transform: translateY(-2px);
}

.theater-item h4 {
    margin: 0 0 5px;
    font-size: 18px;
}

.theater-item p {
    margin: 0;
    font-size: 16px;
    opacity: 0.8;
}

.distance {
    display: inline-block;
    margin-top: 5px;
    font-size: 14px;
    background: rgba(0,0,0,0.2);
    padding: 2px 8px;
    border-radius: 12px;
}

.btn {
    padding: 8px 15px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4285f4;
    color: white;
}

.btn-info {
    background: #34a853;
    color: white;
}

.ml-2 {
    margin-left: 8px;
}

/* Phần chọn lịch chiếu */
.choose-container {
    background: rgba(0, 0, 0, 0.8);
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.date-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.time-slot {
    background: linear-gradient(45deg, #2c2c2c, #3d3d3d);
    padding: 15px 25px;
    border-radius: 10px;
  
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.time-slot:hover,
.time-slot.active {
    background: linear-gradient(45deg, #ffd564, #ff9f1a);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 213, 100, 0.3);
}

.time-block {
    font-size: 16px;
    font-weight: 500;
    text-align: center;
}

/* Phần chọn thời gian chiếu */
.time-select {
    background: rgba(0, 0, 0, 0.8);
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.time-select__group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.time-select__item {
    background: linear-gradient(45deg, #2c2c2c, #3d3d3d);
    padding: 15px 25px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
    text-align: center;
    min-width: 120px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.time-select__item:hover,
.time-select__item.active {
    background: linear-gradient(45deg, #ffd564, #ff9f1a);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 213, 100, 0.3);
}

.time-select__item small {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    opacity: 0.8;
}

/* Tiêu đề */
.page-heading {
    color: #ffd564;
    font-size: 24px;
    font-weight: 600;
    margin: 30px 0 20px;
    text-transform: uppercase;
    position: relative;
    padding-left: 15px;
}

.page-heading:before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 24px;
    background: linear-gradient(to bottom, #ffd564, #ff9f1a);
    border-radius: 2px;
}

/* Alert messages */
.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin: 20px 0;
    font-size: 16px;
}

.alert-info {
    background: rgba(66, 133, 244, 0.1);
    border: 1px solid rgba(66, 133, 244, 0.3);
    color: #4285f4;
}

/* Responsive */
@media (max-width: 768px) {
    .time-select__group {
        justify-content: center;
    }
    
    .time-select__item {
        min-width: calc(50% - 15px);
    }
    
    .date-group {
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.time-slot,
.time-select__item {
    animation: fadeIn 0.3s ease-out;
}

/* Hover effects */
.time-slot:hover,
.time-select__item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 213, 100, 0.3);
}

/* Active state */
.time-slot.active,
.time-select__item.active {
    background: linear-gradient(45deg, #ff9f1a, #ffd564);
    color: #000;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(255, 213, 100, 0.3);
}

/* Phần phim đã chọn */
.movie-selected {
    background: rgba(0, 0, 0, 0.8);
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.movie-selected__info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.movie-selected__title {
    flex: 1;
}

.movie-selected__title strong {
    display: block;
    color: #ffd564;
    font-size: 24px;
    margin-bottom: 10px;
    text-transform: uppercase;
    font-weight: 600;
}

.movie-name {
    font-size: px;
    color: #fff;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    background: linear-gradient(45deg, #ffd564, #ff9f1a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.movie-selected__poster {
    flex-shrink: 0;
    width: 120px;
    height: 180px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    border: 2px solid #ffd564;
}

.movie-selected__poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.movie-selected__poster:hover img {
    transform: scale(1.05);
}

/* Animation */
.movie-selected {
    animation: fadeInUp 0.5s ease-out;
}

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

/* Responsive */
@media (max-width: 768px) {
    .movie-selected__info {
        flex-direction: column;
        text-align: center;
    }
    
    .movie-name {
        font-size: 24px;
    }
    
    .movie-selected__poster {
        margin: 20px auto;
    }
}

/* Style cho label của marker */
.marker-label {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 4px 8px;
    border-radius: 4px;
    white-space: nowrap;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

/* Thêm vào phần style hiện có */
#map {
    height: 600px;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}
</style>