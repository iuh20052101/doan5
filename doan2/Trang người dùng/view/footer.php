<footer class="footer-wrapper">
    <section class="container">
        <div class="col-xs-4 col-md-2">
            <ul class="nav-link">
                <li><a href="#" class="nav-link__item">Thành phố</a></li>
                <li><a href="movie-list-left.html" class="nav-link__item">Phim</a></li>
                <li><a href="trailer.html" class="nav-link__item">Trailers</a></li>
            </ul>
        </div>
        <div class="col-xs-4 col-md-2 ">
            <ul class="nav-link">
                <li><a href="coming-soon.html" class="nav-link__item">Sắp ra mắt</a></li>
                <li><a href="cinema-list.html" class="nav-link__item">Rạp</a></li>
                <li><a href="news-left.html" class="nav-link__item">Tin tức</a></li>
            </ul>
        </div>
        <div class="col-xs-4 col-md-2 ">
            <ul class="nav-link">
                <li><a href="#" class="nav-link__item">Điều khoản</a></li>
                <li><a href="gallery-four.html" class="nav-link__item">Đang chiếu</a></li>
                <li><a href="contact.html" class="nav-link__item">Liên hệ</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="footer-info">
                <p class="heading-special--small">TIAMS<br><span class="title-edition">trên mạng xã hội</span></p>

                <div class="social">
                    <a href='https://www.facebook.com/tien.vominh.98871/' class="social__variant">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href='#' class="social__variant">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href='https://www.instagram.com/tio_1009/' class="social__variant">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>

                <div class="clearfix"></div>
                <p class="copy">&copy; TIAMS, 2024. Đã đăng ký bản quyền. Hoàn thành bởi Minh Tiến & Ngọc Vân</p>
            </div>
        </div>
        <!-- <div class="header-map">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <h3 class="map-title">Vị trí rạp chiếu phim</h3>
                    <div id="map" style="height: 200px; width: 100%; border-radius: 10px;"></div>
                </div>
            </div>
        </div> -->
    </section>
    
</div>
</footer>





<style>
.footer-wrapper {
    background: linear-gradient(45deg, rgba(0,0,0,0.95), rgba(0,0,0,0.98));
   
    border-top: 1px solid rgba(255,255,255,0.1);
    position: relative;
}

 

    .nav-link {
        list-style: none;
        padding: 0;
    }

    .nav-link__item {
        color: #fff !important;
        font-size: 14px;
        line-height: 30px;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 15px;
    }

    .nav-link__item:before {
        content: '→';
        position: absolute;
        left: 0;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .nav-link__item:hover {
        color: #00dbde !important;
        transform: translateX(10px);
        text-decoration: none;
    }

    .nav-link__item:hover:before {
        opacity: 1;
    }

    .footer-info {
        text-align: center;
    }

    .heading-special--small {
        background: linear-gradient(45deg, #00dbde, #fc00ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .title-edition {
        font-size: 16px;
        opacity: 0.8;
    }

    .social {
        margin: 20px 0;
    }

    .social__variant {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, #00dbde, #fc00ff);
        color: white !important;
        text-align: center;
        line-height: 40px;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .social__variant:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,219,222,0.4);
    }

    .copy {
        color: rgba(255,255,255,0.6);
        font-size: 12px;
        margin-top: 20px;
    }

    /* Animation cho social icons */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    .social__variant {
        animation: float 3s ease-in-out infinite;
    }

    .header-map{
      
        width:1500px;
        padding-bottom:40px;
    }

.map-section {
    padding: 40px 0;
    background: rgba(255,255,255,0.05);
    margin-top: 40px;
}

.map-title {
    color: #fff;
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.map-info-window {
    padding: 10px;
    max-width: 250px;
}

.map-info-window h4 {
    margin: 0 0 10px;
    color: #333;
    font-size: 16px;
}

.map-info-window p {
    margin: 0 0 10px;
    color: #666;
    font-size: 14px;
}

.direction-btn {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.3s ease;
}

.direction-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,219,222,0.4);
}

.custom-map-control-button {
    background-color: #fff;
    border: 0;
    border-radius: 2px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.3);
    margin: 10px;
    padding: 8px;
    font-size: 14px;
    cursor: pointer;
}

.custom-map-control-button:hover {
    background-color: #f4f4f4;
}

.footer-title {
    color: #fff;
    font-size: 18px;
    margin-bottom: 20px;

    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

@media (max-width: 768px) {
    .footer-title {
        text-align: center;
        margin-top: 30px;
    }
    
    .footer-info {
        margin-bottom: 30px;
    }
}
</style>

<!-- Font Awesome -->
<script>
// Danh sách các rạp chiếu phim
const theaters = [
    {
        name: "TIAM Quang Trung",
        position: { lat: 10.8431, lng: 106.6425 }, // Tọa độ Gò Vấp
        address: "45 Quang Trung, Phường 10, Gò Vấp, Hồ Chí Minh",
        icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    },
    {
        name: "TIAM Tân Bình",
        position: { lat: 10.7927, lng: 106.6544 }, // Tọa độ Tân Bình
        address: "667, Lý Thường Kiệt, Phường 11, Tân Bình, Hồ Chí Minh",
        icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    },
    {
        name: "TIAM Bình Thạnh",
        position: { lat: 10.8016, lng: 106.7198 }, // Tọa độ Bình Thạnh
        address: "44 Bình Quới, Phường 27, Quận Bình Thạnh, Hồ Chí Minh",
        icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    },
    {
        name: "TIAM Bình Tân",
        position: { lat: 10.7652, lng: 106.6077 }, // Tọa độ Bình Tân
        address: "89 Đường Số 7, Phường Bình Hưng Hòa A, Quận Bình Tân, Hồ Chí Minh",
        icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    },
    {
        name: "TIAM Quận 1",
        position: { lat: 10.7757, lng: 106.7004 }, // Tọa độ Quận 1
        address: "103 Đồng Khởi, Phường Bến Nghé, Quận 1, Hồ Chí Minh",
        icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    }
];

function initMap() {
    // Tạo bản đồ với tâm ở TPHCM
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12, // Điều chỉnh zoom để nhìn thấy tất cả các rạp
        center: { lat: 10.7757, lng: 106.7004 }, // Đặt tâm ở khu vực trung tâm TPHCM
        styles: [
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [{ "visibility": "on" }]
            }
        ]
    });

    // Tạo InfoWindow để hiển thị thông tin rạp
    const infoWindow = new google.maps.InfoWindow();

    // Thêm marker cho từng rạp
    theaters.forEach(theater => {
        const marker = new google.maps.Marker({
            position: theater.position,
            map: map,
            title: theater.name,
            animation: google.maps.Animation.DROP,
            icon: {
                url: theater.icon,
                scaledSize: new google.maps.Size(35, 35)
            }
        });

        // Tạo nội dung cho InfoWindow với style
        const content = `
            <div class="map-info-window" style="padding: 15px; max-width: 300px;">
                <h4 style="margin: 0 0 10px; color: #333; font-size: 16px; font-weight: bold;">
                    ${theater.name}
                </h4>
                <p style="margin: 0 0 10px; color: #666; font-size: 14px; line-height: 1.4;">
                    <i class="fas fa-map-marker-alt" style="color: #ff4444; margin-right: 5px;"></i>
                    ${theater.address}
                </p>
                <button onclick="getDirections(${theater.position.lat}, ${theater.position.lng})" 
                        style="background: linear-gradient(45deg, #00dbde, #fc00ff);
                               color: white;
                               border: none;
                               padding: 8px 15px;
                               border-radius: 5px;
                               cursor: pointer;
                               font-size: 13px;
                               width: 100%;
                               transition: all 0.3s ease;">
                    <i class="fas fa-directions" style="margin-right: 5px;"></i>
                    Chỉ đường đến đây
                </button>
            </div>
        `;

        // Thêm sự kiện click cho marker
        marker.addListener('click', () => {
            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        });

        // Thêm animation khi hover
        marker.addListener('mouseover', () => {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        });

        marker.addListener('mouseout', () => {
            marker.setAnimation(null);
        });
    });

    // Thêm nút định vị với style mới
    const locationButton = document.createElement("button");
    locationButton.innerHTML = '<i class="fas fa-location-arrow"></i> Vị trí của tôi';
    locationButton.className = "custom-map-control-button";
    locationButton.style.cssText = `
        background: white;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        margin: 10px;
        padding: 10px 15px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    `;
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

    locationButton.addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                    new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                        },
                        title: 'Vị trí của bạn'
                    });
                },
                () => {
                    alert("Không thể xác định vị trí của bạn.");
                }
            );
        }
    });
}

// Hàm chỉ đường
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
            },
            () => {
                alert("Không thể xác định vị trí của bạn.");
            }
        );
    }
}
</script>